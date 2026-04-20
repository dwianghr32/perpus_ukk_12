<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {

    private $table = 'buku';

    public function get_all() {
        $this->db->order_by('judul', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function get_available() {
        $this->db->where('stok >', 0);
        $this->db->order_by('judul', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_filtered($filters = array()) {
        $this->db->where('stok >', 0);
        
        if (!empty($filters['search'])) {
            $this->db->like('judul', $filters['search']);
            $this->db->or_like('pengarang', $filters['search']);
            $this->db->or_like('kode_buku', $filters['search']);
        }
        
        if (!empty($filters['kategori'])) {
            $this->db->where('kategori', $filters['kategori']);
        }
        
        if (!empty($filters['tahun'])) {
            $this->db->where('tahun_terbit', $filters['tahun']);
        }
        
        $this->db->order_by('judul', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_filtered_admin($filters = array()) {
        if (!empty($filters['search'])) {
            $this->db->like('judul', $filters['search']);
            $this->db->or_like('pengarang', $filters['search']);
            $this->db->or_like('kode_buku', $filters['search']);
        }
        
        if (!empty($filters['kategori'])) {
            $this->db->where('kategori', $filters['kategori']);
        }
        
        if (!empty($filters['tahun'])) {
            $this->db->where('tahun_terbit', $filters['tahun']);
        }
        
        if (!empty($filters['stok'])) {
            if ($filters['stok'] === 'available') {
                $this->db->where('stok >', 0);
            } elseif ($filters['stok'] === 'empty') {
                $this->db->where('stok', 0);
            }
        }
        
        $this->db->order_by('judul', 'ASC');
        return $this->db->get($this->table)->result_array();
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

    public function get_categories() {
        $this->db->select('kategori');
        $this->db->distinct();
        $this->db->where('kategori IS NOT NULL');
        $this->db->where('kategori !=', '');
        $this->db->order_by('kategori', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
}
