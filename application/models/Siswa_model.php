<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

    public function get_jadwal_by_kelas($kelas_id) {
        $this->db->select('j.*, mp.nama_mapel, g.nama as nama_guru, j.hari, j.jam_mulai, j.jam_selesai');
        $this->db->from('jadwal j');
        $this->db->join('mapel mp', 'j.mapel_id = mp.id');
        $this->db->join('guru g', 'j.guru_id = g.id');
        $this->db->where('j.kelas_id', $kelas_id);
        $this->db->order_by('j.hari, j.jam_mulai');
        return $this->db->get()->result();
    }

    public function get_absensi_siswa($siswa_id) {
        $this->db->select('p.*, j.hari, j.jam_mulai, j.jam_selesai, mp.nama_mapel, g.nama as nama_guru');
        $this->db->from('presensi p');
        $this->db->join('jadwal j', 'p.jadwal_id = j.id');
        $this->db->join('mapel mp', 'j.mapel_id = mp.id');
        $this->db->join('guru g', 'j.guru_id = g.id');
        $this->db->where('p.siswa_id', $siswa_id);
        $this->db->order_by('p.tanggal DESC');
        return $this->db->get()->result();
    }

    // Gunakan fungsi yang sama dari Guru_model atau duplikat di sini
    public function get_laporan_nilai($siswa_id) {
        $siswa = $this->db->get_where('siswa', ['id' => $siswa_id])->row();
        if (!$siswa) return [];

        $this->db->select('j.id as jadwal_id, j.mapel_id, mp.nama_mapel');
        $this->db->from('jadwal j');
        $this->db->join('mapel mp', 'j.mapel_id = mp.id');
        $this->db->where('j.kelas_id', $siswa->kelas_id);
        $jadwal_siswa = $this->db->get()->result();

        $laporan_lengkap = [];


        foreach ($jadwal_siswa as $jadwal) {
            $this->load->model('Guru_model'); 
            $detail_nilai = $this->Guru_model->get_laporan_nilai_per_mapel($siswa_id, $jadwal->jadwal_id);

            $laporan_lengkap[] = [
                'nama_mapel' => $jadwal->nama_mapel,
                'detail_nilai' => $detail_nilai
            ];
        }

        return $laporan_lengkap;
    }
}