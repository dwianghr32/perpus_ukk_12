<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_check_login();
        $this->load->model('Laporan_model');
    }

    private function _check_login() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Laporan Perpustakaan';
        
        $filters = [];
        if ($this->input->get('search'))    $filters['search']   = $this->input->get('search');
        if ($this->input->get('kategori'))  $filters['kategori'] = $this->input->get('kategori');
        if ($this->input->get('tahun'))     $filters['tahun']    = $this->input->get('tahun');
        if ($this->input->get('bulan'))     $filters['bulan']    = $this->input->get('bulan');

        $data['buku']           = $this->Laporan_model->get_laporan_buku($filters);
        $data['statistik_buku'] = $this->Laporan_model->get_statistik_buku($filters);

        $data['filters']       = $filters;
        $data['kategori_list'] = $this->Laporan_model->get_kategori_buku();
        $data['tahun_list']    = $this->Laporan_model->get_tahun_peminjaman();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('templates/footer');
    }

    // === METHOD CETAK ===
    public function cetak() {
        $periode = $this->input->get('periode');

        $filters = [];
        $judul_periode = 'Laporan Perpustakaan';

        switch ($periode) {
            case 'hari':
                $filters['tanggal_hari'] = date('Y-m-d');
                $judul_periode = 'Laporan Hari Ini - ' . date('d F Y');
                break;
            case 'minggu':
                $filters['tanggal_mulai'] = date('Y-m-d', strtotime('-7 days'));
                $filters['tanggal_akhir'] = date('Y-m-d');
                $judul_periode = 'Laporan Minggu Ini';
                break;
            case 'bulan':
                $filters['bulan'] = date('m');
                $filters['tahun'] = date('Y');
                $judul_periode = 'Laporan Bulan ' . date('F Y');
                break;
            case 'tahun':
                $filters['tahun'] = date('Y');
                $judul_periode = 'Laporan Tahun ' . date('Y');
                break;
            default:
                $judul_periode = 'Laporan Semua Data';
                break;
        }

        $data['buku']          = $this->Laporan_model->get_laporan_buku($filters);
        $data['judul_periode'] = $judul_periode;

        $this->load->view('admin/laporan/cetak_laporan', $data);
    }
}