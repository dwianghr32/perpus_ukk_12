<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_check_login();
        $this->load->model('Buku_model');
        $this->load->model('Anggota_model');
        $this->load->model('Peminjaman_model');
    }

    private function _check_login() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Dashboard Admin';
        $data['total_buku'] = $this->Buku_model->count_all();
        $data['total_anggota'] = $this->Anggota_model->count_all();
        $data['total_peminjaman'] = $this->Peminjaman_model->count_active();
        $data['peminjaman_terbaru'] = $this->Peminjaman_model->get_recent(5);
        
        // Data untuk ringkasan bulan ini
        $bulan_ini = date('m');
        $tahun_ini = date('Y');
        
        $this->db->select('COUNT(*) as total');
        $this->db->from('peminjaman');
        $this->db->where('MONTH(tanggal_pinjam)', $bulan_ini);
        $this->db->where('YEAR(tanggal_pinjam)', $tahun_ini);
        $peminjaman_bulan = $this->db->get()->row_array();
        $data['bulan_ini'] = $peminjaman_bulan['total'];
        
        $this->db->select('COUNT(*) as total');
        $this->db->from('peminjaman');
        $this->db->where('status', 'dikembalikan');
        $this->db->where('MONTH(tanggal_dikembalikan)', $bulan_ini);
        $this->db->where('YEAR(tanggal_dikembalikan)', $tahun_ini);
        $pengembalian_bulan = $this->db->get()->row_array();
        $data['pengembalian_bulan_ini'] = $pengembalian_bulan['total'];
        
        $this->db->select('COUNT(*) as total');
        $this->db->from('peminjaman');
        $this->db->where('status', 'terlambat');
        $this->db->where('MONTH(tanggal_pinjam)', $bulan_ini);
        $this->db->where('YEAR(tanggal_pinjam)', $tahun_ini);
        $terlambat_bulan = $this->db->get()->row_array();
        $data['terlambat_bulan_ini'] = $terlambat_bulan['total'];
        
        $this->db->select('SUM(denda) as total_denda');
        $this->db->from('peminjaman');
        $this->db->where('MONTH(tanggal_dikembalikan)', $bulan_ini);
        $this->db->where('YEAR(tanggal_dikembalikan)', $tahun_ini);
        $denda_bulan = $this->db->get()->row_array();
        $data['denda_bulan_ini'] = $denda_bulan['total_denda'] ?? 0;

        // Data chart tren peminjaman 6 bulan terakhir
        $chartLabels = [];
        $chartValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = strtotime("-$i month");
            $monthNumber = date('m', $date);
            $yearNumber = date('Y', $date);
            $monthLabel = date('M', $date);

            $this->db->select('COUNT(*) as total');
            $this->db->from('peminjaman');
            $this->db->where('MONTH(tanggal_pinjam)', $monthNumber);
            $this->db->where('YEAR(tanggal_pinjam)', $yearNumber);
            $countRow = $this->db->get()->row_array();
            $chartLabels[] = $monthLabel;
            $chartValues[] = intval($countRow['total'] ?? 0);
        }

        $data['chart_labels'] = json_encode($chartLabels);
        $data['chart_data'] = json_encode($chartValues);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }
}
