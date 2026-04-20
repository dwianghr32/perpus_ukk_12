<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_check_login();
        $this->load->model('Buku_model');
    }

    private function _check_login() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Kelola Data Buku';
        
        // Handle filters
        $filters = array();
        if ($this->input->get('search')) {
            $filters['search'] = $this->input->get('search');
        }
        if ($this->input->get('kategori')) {
            $filters['kategori'] = $this->input->get('kategori');
        }
        if ($this->input->get('tahun')) {
            $filters['tahun'] = $this->input->get('tahun');
        }
        if ($this->input->get('stok')) {
            $filters['stok'] = $this->input->get('stok');
        }
        
        $data['buku'] = $this->Buku_model->get_filtered_admin($filters);
        $data['filters'] = $filters;
        
        // Get categories for filter dropdown
        $data['kategori_options'] = $this->Buku_model->get_categories();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/buku/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $this->form_validation->set_rules('kode_buku', 'Kode Buku', 'required|trim|is_unique[buku.kode_buku]');
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('pengarang', 'Pengarang', 'required|trim');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Buku';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/buku/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'kode_buku' => $this->input->post('kode_buku'),
                'judul' => $this->input->post('judul'),
                'pengarang' => $this->input->post('pengarang'),
                'penerbit' => $this->input->post('penerbit'),
                'tahun_terbit' => $this->input->post('tahun_terbit'),
                'kategori' => $this->input->post('kategori'),
                'stok' => $this->input->post('stok'),
                'deskripsi' => $this->input->post('deskripsi')
            );

            $this->Buku_model->insert($data);
            $this->session->set_flashdata('success', 'Buku berhasil ditambahkan!');
            redirect('buku');
        }
    }

    public function edit($id) {
        $data['buku'] = $this->Buku_model->get_by_id($id);
        
        if (!$data['buku']) {
            show_404();
        }

        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('pengarang', 'Pengarang', 'required|trim');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Buku';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/buku/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $update_data = array(
                'judul' => $this->input->post('judul'),
                'pengarang' => $this->input->post('pengarang'),
                'penerbit' => $this->input->post('penerbit'),
                'tahun_terbit' => $this->input->post('tahun_terbit'),
                'kategori' => $this->input->post('kategori'),
                'stok' => $this->input->post('stok'),
                'deskripsi' => $this->input->post('deskripsi')
            );

            $this->Buku_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Buku berhasil diupdate!');
            redirect('buku');
        }
    }

    public function hapus($id) {
        $buku = $this->Buku_model->get_by_id($id);
        
        if (!$buku) {
            show_404();
        }

        $this->Buku_model->delete($id);
        $this->session->set_flashdata('success', 'Buku berhasil dihapus!');
        redirect('buku');
    }
}
