<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends CI_Model {

    private $table = 'peminjaman';

    public function get_all() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_all_with_detail() {
        $this->db->select('peminjaman.*, buku.judul, buku.kode_buku, anggota.nama, anggota.nis');
        $this->db->from($this->table);
        $this->db->join('buku', 'buku.id = peminjaman.id_buku');
        $this->db->join('anggota', 'anggota.id = peminjaman.id_anggota');
        $this->db->order_by('peminjaman.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function get_by_id_with_detail($id) {
        $this->db->select('peminjaman.*, buku.judul, buku.kode_buku, buku.pengarang, anggota.nama, anggota.nis, anggota.kelas');
        $this->db->from($this->table);
        $this->db->join('buku', 'buku.id = peminjaman.id_buku');
        $this->db->join('anggota', 'anggota.id = peminjaman.id_anggota');
        $this->db->where('peminjaman.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_by_anggota($id_anggota, $limit = null) {
        $this->db->where('id_anggota', $id_anggota);
        $this->db->order_by('created_at', 'DESC');
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_anggota_with_detail($id_anggota) {
        $this->db->select('peminjaman.*, buku.judul, buku.kode_buku, buku.pengarang');
        $this->db->from($this->table);
        $this->db->join('buku', 'buku.id = peminjaman.id_buku');
        $this->db->where('peminjaman.id_anggota', $id_anggota);
        $this->db->order_by('peminjaman.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_filtered_riwayat($id_anggota, $filters = array()) {
        $this->db->select('peminjaman.*, buku.judul, buku.kode_buku, buku.pengarang');
        $this->db->from($this->table);
        $this->db->join('buku', 'buku.id = peminjaman.id_buku');
        $this->db->where('peminjaman.id_anggota', $id_anggota);
        
        if (!empty($filters['status'])) {
            $this->db->where('peminjaman.status', $filters['status']);
        }
        
        if (!empty($filters['search'])) {
            $this->db->like('buku.judul', $filters['search']);
            $this->db->or_like('buku.pengarang', $filters['search']);
            $this->db->or_like('buku.kode_buku', $filters['search']);
        }
        
        if (!empty($filters['tanggal_mulai']) && !empty($filters['tanggal_akhir'])) {
            $this->db->where('peminjaman.tanggal_pinjam >=', $filters['tanggal_mulai']);
            $this->db->where('peminjaman.tanggal_pinjam <=', $filters['tanggal_akhir']);
        }
        
        $this->db->order_by('peminjaman.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_filtered_admin($filters = array()) {
        $this->db->select('peminjaman.*, buku.judul, buku.kode_buku, anggota.nama, anggota.nis');
        $this->db->from($this->table);
        $this->db->join('buku', 'buku.id = peminjaman.id_buku');
        $this->db->join('anggota', 'anggota.id = peminjaman.id_anggota');
        
        if (!empty($filters['status'])) {
            $this->db->where('peminjaman.status', $filters['status']);
        }
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('anggota.nama', $filters['search']);
            $this->db->or_like('anggota.nis', $filters['search']);
            $this->db->or_like('buku.judul', $filters['search']);
            $this->db->or_like('buku.kode_buku', $filters['search']);
            $this->db->group_end();
        }
        
        if (!empty($filters['tanggal_mulai']) && !empty($filters['tanggal_akhir'])) {
            $this->db->where('peminjaman.tanggal_pinjam >=', $filters['tanggal_mulai']);
            $this->db->where('peminjaman.tanggal_pinjam <=', $filters['tanggal_akhir']);
        }
        
        $this->db->order_by('peminjaman.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_recent($limit = 5) {
        $this->db->select('peminjaman.*, buku.judul, anggota.nama');
        $this->db->from($this->table);
        $this->db->join('buku', 'buku.id = peminjaman.id_buku');
        $this->db->join('anggota', 'anggota.id = peminjaman.id_anggota');
        $this->db->order_by('peminjaman.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function check_existing($id_anggota, $id_buku) {
        $this->db->where('id_anggota', $id_anggota);
        $this->db->where('id_buku', $id_buku);
        $this->db->where('status', 'dipinjam');
        return $this->db->get($this->table)->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function count_all() {
        return $this->db->count_all($this->table);
    }

    public function count_active() {
        $this->db->where('status', 'dipinjam');
        return $this->db->count_all_results($this->table);
    }

    public function count_by_anggota($id_anggota) {
        $this->db->where('id_anggota', $id_anggota);
        return $this->db->count_all_results($this->table);
    }

    public function count_active_by_anggota($id_anggota) {
        $this->db->where('id_anggota', $id_anggota);
        $this->db->where('status', 'dipinjam');
        return $this->db->count_all_results($this->table);
    }
}
