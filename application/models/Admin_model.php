<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    // Fungsi untuk mengambil semua data dari sebuah tabel
    public function get_all($table) {
        return $this->db->get($table)->result();
    }

    // Fungsi untuk mengambil data siswa dengan informasi kelas
    public function get_siswa_with_kelas() {
        $this->db->select('siswa.*, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kelas_id = kelas.id', 'left');
        return $this->db->get()->result();
    }

    // Fungsi untuk mengambil data kelas dengan wali kelas
    public function get_kelas_with_wali() {
        $this->db->select('kelas.*, guru.nama as nama_wali, COUNT(siswa.id) as jumlah_siswa');
        $this->db->from('kelas');
        $this->db->join('guru', 'kelas.wali_kelas_id = guru.id', 'left');
        $this->db->join('siswa', 'kelas.id = siswa.kelas_id', 'left');
        $this->db->group_by('kelas.id');
        return $this->db->get()->result();
    }

    // Fungsi untuk insert data
    public function insert($table, $data) {
        return $this->db->insert($table, $data);
    }

    // Fungsi untuk update data
    public function update($table, $data, $where) {
        return $this->db->update($table, $data, $where);
    }

    // Fungsi untuk delete data
    public function delete($table, $where) {
        return $this->db->delete($table, $where);
    }

    // Fungsi untuk mengambil data berdasarkan ID
    public function get_by_id($table, $id) {
        return $this->db->get_where($table, ['id' => $id])->row();
    }

    // Fungsi untuk mengambil detail siswa dengan informasi kelas
    public function get_siswa_detail($id) {
        $this->db->select('siswa.*, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('kelas', 'siswa.kelas_id = kelas.id', 'left');
        $this->db->where('siswa.id', $id);
        return $this->db->get()->row();
    }

    // Fungsi untuk mengambil detail kelas dengan informasi wali kelas
    public function get_kelas_detail($id) {
        $this->db->select('kelas.*, guru.nama as nama_wali, COUNT(siswa.id) as jumlah_siswa');
        $this->db->from('kelas');
        $this->db->join('guru', 'kelas.wali_kelas_id = guru.id', 'left');
        $this->db->join('siswa', 'kelas.id = siswa.kelas_id', 'left');
        $this->db->where('kelas.id', $id);
        $this->db->group_by('kelas.id');
        return $this->db->get()->row();
    }

    // Fungsi untuk menghitung jumlah siswa dalam kelas
    public function count_siswa_in_kelas($kelas_id) {
        return $this->db->where('kelas_id', $kelas_id)->count_all_results('siswa');
    }

    // Fungsi untuk menghitung jumlah jadwal yang menggunakan mata pelajaran
    public function count_jadwal_by_mapel($mapel_id) {
        return $this->db->where('mapel_id', $mapel_id)->count_all_results('jadwal');
    }



}