<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function get_laporan_buku($filters = array()) {
        $this->db->select('buku.*, COUNT(peminjaman.id) as jumlah_peminjaman');
        $this->db->from('buku');
        $this->db->join('peminjaman', 'peminjaman.id_buku = buku.id', 'left');
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('buku.judul', $filters['search']);
            $this->db->or_like('buku.pengarang', $filters['search']);
            $this->db->or_like('buku.kode_buku', $filters['search']);
            $this->db->group_end();
        }
        
        if (!empty($filters['kategori'])) {
            $this->db->where('buku.kategori', $filters['kategori']);
        }
        
        if (!empty($filters['tahun'])) {
            $this->db->where('buku.tahun_terbit', $filters['tahun']);
        }
        
        if (!empty($filters['stok'])) {
            if ($filters['stok'] == 'tersedia') {
                $this->db->where('buku.stok', 0, '>');
            } elseif ($filters['stok'] == 'habis') {
                $this->db->where('buku.stok', 0);
            }
        }
        
        $this->db->group_by('buku.id');
        $this->db->order_by('buku.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_laporan_anggota($filters = array()) {
        $this->db->select('anggota.*, COUNT(peminjaman.id) as jumlah_peminjaman, COUNT(CASE WHEN peminjaman.status = "dipinjam" THEN 1 END) as peminjaman_aktif');
        $this->db->from('anggota');
        $this->db->join('peminjaman', 'peminjaman.id_anggota = anggota.id', 'left');
        
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('anggota.nama', $filters['search']);
            $this->db->or_like('anggota.nis', $filters['search']);
            $this->db->group_end();
        }
        
        if (!empty($filters['kelas'])) {
            $this->db->where('anggota.kelas', $filters['kelas']);
        }
        
        $this->db->group_by('anggota.id');
        $this->db->order_by('anggota.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_laporan_peminjaman($filters = array()) {
        $this->db->select('peminjaman.*, buku.judul, buku.kode_buku, anggota.nama, anggota.nis, anggota.kelas');
        $this->db->from('peminjaman');
        $this->db->join('buku', 'buku.id = peminjaman.id_buku');
        $this->db->join('anggota', 'anggota.id = peminjaman.id_anggota');

        if (!empty($filters['tanggal_mulai']) && !empty($filters['tanggal_akhir'])) {
            $this->db->where('peminjaman.tanggal_pinjam >=', $filters['tanggal_mulai']);
            $this->db->where('peminjaman.tanggal_pinjam <=', $filters['tanggal_akhir']);
        }

        $this->db->order_by('peminjaman.tanggal_pinjam', 'DESC');
        
        if (!empty($filters['limit'])) {
            $this->db->limit($filters['limit']);
        }
        
        return $this->db->get()->result_array();
    }

    public function get_statistik_buku($filters = array()) {
        $this->db->select('COUNT(*) as total_buku, SUM(stok) as total_stok, COUNT(CASE WHEN stok > 0 THEN 1 END) as buku_tersedia, COUNT(CASE WHEN stok = 0 THEN 1 END) as buku_habis');
        $this->db->from('buku');
        
        if (!empty($filters['kategori'])) {
            $this->db->where('buku.kategori', $filters['kategori']);
        }
        if (!empty($filters['tahun'])) {
            $this->db->where('buku.tahun_terbit', $filters['tahun']);
        }
        
        return $this->db->get()->row_array();
    }

    public function get_statistik_peminjaman($filters = array()) {
        $query = $this->db->query("
            SELECT
                COUNT(*) as total_peminjaman,
                COUNT(CASE WHEN status = 'dipinjam' THEN 1 END) as peminjaman_aktif,
                COUNT(CASE WHEN status = 'dikembalikan' THEN 1 END) as peminjaman_selesai,
                COUNT(CASE WHEN status = 'terlambat' THEN 1 END) as peminjaman_terlambat,
                SUM(denda) as total_denda
            FROM peminjaman
            WHERE 1=1
        ");
        
        if (!empty($filters['tahun'])) {
            $query = $this->db->query("
                SELECT
                    COUNT(*) as total_peminjaman,
                    COUNT(CASE WHEN status = 'dipinjam' THEN 1 END) as peminjaman_aktif,
                    COUNT(CASE WHEN status = 'dikembalikan' THEN 1 END) as peminjaman_selesai,
                    COUNT(CASE WHEN status = 'terlambat' THEN 1 END) as peminjaman_terlambat,
                    SUM(denda) as total_denda
                FROM peminjaman
                WHERE YEAR(tanggal_pinjam) = " . intval($filters['tahun'])
            );
        }
        
        if (!empty($filters['bulan']) && !empty($filters['tahun'])) {
            $query = $this->db->query("
                SELECT
                    COUNT(*) as total_peminjaman,
                    COUNT(CASE WHEN status = 'dipinjam' THEN 1 END) as peminjaman_aktif,
                    COUNT(CASE WHEN status = 'dikembalikan' THEN 1 END) as peminjaman_selesai,
                    COUNT(CASE WHEN status = 'terlambat' THEN 1 END) as peminjaman_terlambat,
                    SUM(denda) as total_denda
                FROM peminjaman
                WHERE YEAR(tanggal_pinjam) = " . intval($filters['tahun']) . " AND MONTH(tanggal_pinjam) = " . intval($filters['bulan'])
            );
        }
        
        return $query->row_array();
    }

    public function get_buku_terpopuler($limit = 10, $filters = array()) {
        $this->db->select('buku.judul, buku.kode_buku, buku.pengarang, COUNT(peminjaman.id) as jumlah_peminjaman');
        $this->db->from('buku');
        $this->db->join('peminjaman', 'peminjaman.id_buku = buku.id');
        
        if (!empty($filters['tahun'])) {
            $this->db->where("YEAR(peminjaman.tanggal_pinjam) = {$filters['tahun']}", NULL, FALSE);
        }
        if (!empty($filters['bulan'])) {
            $this->db->where("MONTH(peminjaman.tanggal_pinjam) = {$filters['bulan']}", NULL, FALSE);
        }
        
        $this->db->group_by('buku.id');
        $this->db->order_by('jumlah_peminjaman', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_anggota_teraktif($limit = 10, $filters = array()) {
        $this->db->select('anggota.nama, anggota.nis, anggota.kelas, COUNT(peminjaman.id) as jumlah_peminjaman');
        $this->db->from('anggota');
        $this->db->join('peminjaman', 'peminjaman.id_anggota = anggota.id');
        
        if (!empty($filters['kelas'])) {
            $this->db->where('anggota.kelas', $filters['kelas']);
        }
        if (!empty($filters['tahun'])) {
            $this->db->where("YEAR(peminjaman.tanggal_pinjam) = {$filters['tahun']}", NULL, FALSE);
        }
        
        $this->db->group_by('anggota.id');
        $this->db->order_by('jumlah_peminjaman', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_peminjaman_per_bulan($tahun = null) {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $query = $this->db->query("
            SELECT
                MONTH(tanggal_pinjam) as bulan,
                COUNT(*) as jumlah_peminjaman
            FROM peminjaman
            WHERE YEAR(tanggal_pinjam) = ?
            GROUP BY MONTH(tanggal_pinjam)
            ORDER BY bulan
        ", array($tahun));

        return $query->result_array();
    }
    
    public function get_kategori_buku() {
        $this->db->select('kategori');
        $this->db->from('buku');
        $this->db->where('kategori IS NOT NULL');
        $this->db->distinct();
        $this->db->order_by('kategori', 'ASC');
        return $this->db->get()->result_array();
    }
    
    public function get_tahun_terbit() {
        $this->db->select('tahun_terbit');
        $this->db->from('buku');
        $this->db->where('tahun_terbit IS NOT NULL');
        $this->db->distinct();
        $this->db->order_by('tahun_terbit', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_kelas() {
        $this->db->select('kelas');
        $this->db->from('anggota');
        $this->db->distinct();
        $this->db->order_by('kelas', 'ASC');
        return $this->db->get()->result_array();
    }
    
    public function get_tahun_peminjaman() {
        $query = $this->db->query("
            SELECT DISTINCT YEAR(tanggal_pinjam) as tahun
            FROM peminjaman
            ORDER BY tahun DESC
        ");
        return $query->result_array();
    }

    public function get_peminjaman_per_kategori() {
        $this->db->select('buku.kategori, COUNT(peminjaman.id) as jumlah_peminjaman');
        $this->db->from('peminjaman');
        $this->db->join('buku', 'buku.id = peminjaman.id_buku');
        $this->db->where('buku.kategori IS NOT NULL');
        $this->db->group_by('buku.kategori');
        $this->db->order_by('jumlah_peminjaman', 'DESC');
        return $this->db->get()->result_array();
    }
}