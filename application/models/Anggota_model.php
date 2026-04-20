<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_model extends CI_Model {

    private $table = 'anggota';

    public function get_all() {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function get_by_nis($nis) {
        $this->db->where('nis', $nis);
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

    public function get_filtered($filters = array()) {
        if (!empty($filters['search'])) {
            $this->db->like('nama', $filters['search']);
            $this->db->or_like('nis', $filters['search']);
        }
        
        if (!empty($filters['kelas'])) {
            $this->db->where('kelas', $filters['kelas']);
        }
        
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_classes() {
        $this->db->select('kelas');
        $this->db->distinct();
        $this->db->where('kelas IS NOT NULL');
        $this->db->where('kelas !=', '');
        $this->db->order_by('kelas', 'ASC');
        return $this->db->get($this->table)->result_array();
    }
}
