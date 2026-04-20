<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_check_login();
        $this->load->model('Anggota_model');
    }

    private function _check_login() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['title'] = 'Kelola Data Anggota';
        
        // Handle filters
        $filters = array();
        if ($this->input->get('search')) {
            $filters['search'] = $this->input->get('search');
        }
        if ($this->input->get('kelas')) {
            $filters['kelas'] = $this->input->get('kelas');
        }
        
        $data['anggota'] = $this->Anggota_model->get_filtered($filters);
        $data['filters'] = $filters;
        
        // Get classes for filter dropdown
        $data['kelas_options'] = $this->Anggota_model->get_classes();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar_admin', $data);
        $this->load->view('admin/anggota/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $this->form_validation->set_rules('nis', 'NIS', 'required|trim|is_unique[anggota.nis]');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Anggota';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/anggota/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data_anggota = array(
                'nis' => $this->input->post('nis'),
                'nama' => $this->input->post('nama'),
                'kelas' => $this->input->post('kelas'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon')
            );

            $id_anggota = $this->Anggota_model->insert($data_anggota);

            // Buat akun user untuk anggota
            $data_user = array(
                'username' => $this->input->post('nis'),
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'role' => 'siswa',
                'id_anggota' => $id_anggota
            );
            $this->db->insert('users', $data_user);

            $this->session->set_flashdata('success', 'Anggota berhasil ditambahkan! Password default: siswa123');
            redirect('anggota');
        }
    }

    public function edit($id) {
        $data['anggota'] = $this->Anggota_model->get_by_id($id);
        
        if (!$data['anggota']) {
            show_404();
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Anggota';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar_admin', $data);
            $this->load->view('admin/anggota/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $update_data = array(
                'nama' => $this->input->post('nama'),
                'kelas' => $this->input->post('kelas'),
                'alamat' => $this->input->post('alamat'),
                'telepon' => $this->input->post('telepon')
            );

            $this->Anggota_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Anggota berhasil diupdate!');
            redirect('anggota');
        }
    }

    public function hapus($id) {
        $anggota = $this->Anggota_model->get_by_id($id);
        
        if (!$anggota) {
            show_404();
        }

        // Hapus user terkait
        $this->db->where('id_anggota', $id);
        $this->db->delete('users');

        $this->Anggota_model->delete($id);
        $this->session->set_flashdata('success', 'Anggota berhasil dihapus!');
        redirect('anggota');
    }
}
