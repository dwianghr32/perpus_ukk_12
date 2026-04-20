<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_check_login();
        $this->load->model('Peminjaman_model');
        $this->load->model('Buku_model');
        $this->load->model('Anggota_model');
    }

    private function _check_login() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Kelola Transaksi';
        
        // Handle filters
        $filters = array();
        if ($this->input->get('search')) {
            $filters['search'] = $this->input->get('search');
        }
        if ($this->input->get('status')) {
            $filters['status'] = $this->input->get('status');
        }
        if ($this->input->get('tanggal_mulai')) {
            $filters['tanggal_mulai'] = $this->input->get('tanggal_mulai');
        }
        if ($this->input->get('tanggal_akhir')) {
            $filters['tanggal_akhir'] = $this->input->get('tanggal_akhir');
        }
        
        if (!empty($filters)) {
            $data['transaksi'] = $this->Peminjaman_model->get_filtered_admin($filters);
        } else {
            $data['transaksi'] = $this->Peminjaman_model->get_all_with_detail();
        }
        
        // Pass filter values back to view
        $data['filters'] = $filters;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/transaksi/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $this->form_validation->set_rules('id_anggota', 'Anggota', 'required');
        $this->form_validation->set_rules('id_buku', 'Buku', 'required');
        $this->form_validation->set_rules('tanggal_pinjam', 'Tanggal Pinjam', 'required');
        $this->form_validation->set_rules('tanggal_kembali', 'Tanggal Kembali', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Transaksi';
            $data['anggota'] = $this->Anggota_model->get_all();
            $data['buku'] = $this->Buku_model->get_available();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/transaksi/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $id_buku = $this->input->post('id_buku');
            
            // Cek stok buku
            $buku = $this->Buku_model->get_by_id($id_buku);
            if ($buku['stok'] < 1) {
                $this->session->set_flashdata('error', 'Stok buku tidak tersedia!');
                redirect('transaksi/tambah');
            }

            $data = array(
                'id_anggota' => $this->input->post('id_anggota'),
                'id_buku' => $id_buku,
                'tanggal_pinjam' => $this->input->post('tanggal_pinjam'),
                'tanggal_kembali' => $this->input->post('tanggal_kembali'),
                'status' => 'dipinjam'
            );

            $this->Peminjaman_model->insert($data);
            
            // Kurangi stok buku
            $this->Buku_model->update($id_buku, array('stok' => $buku['stok'] - 1));

            $this->session->set_flashdata('success', 'Transaksi peminjaman berhasil ditambahkan!');
            redirect('transaksi');
        }
    }

    public function detail($id) {
        $data['title'] = 'Detail Transaksi';
        $data['transaksi'] = $this->Peminjaman_model->get_by_id_with_detail($id);
        
        if (!$data['transaksi']) {
            show_404();
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/transaksi/detail', $data);
        $this->load->view('templates/footer');
    }

    public function konfirmasi($id) {
        $transaksi = $this->Peminjaman_model->get_by_id($id);
        
        if (!$transaksi) {
            show_404();
        }

        // Update status menjadi dikembalikan
        $today = date('Y-m-d');
        $denda = 0;

        // Hitung denda jika terlambat (Rp 1000/hari)
        if (strtotime($today) > strtotime($transaksi['tanggal_kembali'])) {
            $diff = (strtotime($today) - strtotime($transaksi['tanggal_kembali'])) / (60 * 60 * 24);
            $denda = $diff * 1000;
        }

        $update_data = array(
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => $today,
            'denda' => $denda
        );

        $this->Peminjaman_model->update($id, $update_data);

        // Tambah stok buku
        $buku = $this->Buku_model->get_by_id($transaksi['id_buku']);
        $this->Buku_model->update($transaksi['id_buku'], array('stok' => $buku['stok'] + 1));

        $this->session->set_flashdata('success', 'Buku berhasil dikembalikan!' . ($denda > 0 ? ' Denda: Rp ' . number_format($denda, 0, ',', '.') : ''));
        redirect('transaksi');
    }

    public function hapus($id) {
        $transaksi = $this->Peminjaman_model->get_by_id($id);
        
        if (!$transaksi) {
            show_404();
        }

        // Jika masih dipinjam, kembalikan stok
        if ($transaksi['status'] == 'dipinjam') {
            $buku = $this->Buku_model->get_by_id($transaksi['id_buku']);
            $this->Buku_model->update($transaksi['id_buku'], array('stok' => $buku['stok'] + 1));
        }

        $this->Peminjaman_model->delete($id);
        $this->session->set_flashdata('success', 'Transaksi berhasil dihapus!');
        redirect('transaksi');
    }
}
