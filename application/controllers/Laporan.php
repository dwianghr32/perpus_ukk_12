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
        
        // FILTER
        $filters = [];
        if ($this->input->get('kategori')) {
            $filters['kategori'] = $this->input->get('kategori');
        }
        if ($this->input->get('tahun')) {
            $filters['tahun'] = $this->input->get('tahun');
        }
        if ($this->input->get('bulan')) {
            $filters['bulan'] = $this->input->get('bulan');
        }
        if ($this->input->get('search')) {
            $filters['search'] = $this->input->get('search');
        }

        $data['buku'] = $this->Laporan_model->get_laporan_buku($filters);

        // STATISTIK
        $data['statistik_buku'] = $this->Laporan_model->get_statistik_buku($filters);

        // FILTER OPTION
        $data['filters'] = $filters;
        $data['kategori_list'] = $this->Laporan_model->get_kategori_buku();
        $data['tahun_list'] = $this->Laporan_model->get_tahun_peminjaman();

        // LOAD VIEW
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('templates/footer');
    }
}