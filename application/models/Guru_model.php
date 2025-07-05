<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model {

    public function get_kelas_by_guru($guru_id) {
        $this->db->select('k.*, mp.nama_mapel, j.id as jadwal_id');
        $this->db->from('kelas k');
        $this->db->join('jadwal j', 'k.id = j.kelas_id');
        $this->db->join('mapel mp', 'j.mapel_id = mp.id');
        $this->db->where('j.guru_id', $guru_id);
        $this->db->group_by('k.id, j.id');
        return $this->db->get()->result();
    }
    public function get_jadwal_by_guru($guru_id) {
        $this->db->select('j.*, k.nama_kelas, m.nama_mapel, ta.nama as tahun_ajaran');
        $this->db->from('jadwal j');
        $this->db->join('kelas k', 'j.kelas_id = k.id');
        $this->db->join('mapel m', 'j.mapel_id = m.id');
        $this->db->join('tahun_ajaran ta', 'j.tahun_ajaran_id = ta.id');
        $this->db->where('j.guru_id', $guru_id);
        return $this->db->get()->result();
    }
    
    public function get_siswa_by_kelas($kelas_id) {
        return $this->db->get_where('siswa', ['kelas_id' => $kelas_id])->result();
    }

    public function get_jadwal_detail($jadwal_id) {
        return $this->db->get_where('jadwal', ['id' => $jadwal_id])->row();
    }
    
    public function get_next_pertemuan($jadwal_id) {
        $this->db->select_max('pertemuan');
        $this->db->where('jadwal_id', $jadwal_id);
        $result = $this->db->get('presensi')->row();
        return $result->pertemuan ? $result->pertemuan + 1 : 1;
    }

    // Fungsi untuk input presensi dengan nomor pertemuan otomatis
    public function input_presensi($jadwal_id, $data_presensi) {
       
        $pertemuan = $this->get_next_pertemuan($jadwal_id);

        $batch_data = [];
        foreach ($data_presensi as $siswa_id => $keterangan) {
            $batch_data[] = [
                'siswa_id' => $siswa_id,
                'jadwal_id' => $jadwal_id,
                'tanggal' => date('Y-m-d'),
                'semester' => 'Ganjil', 
                'pertemuan' => $pertemuan,
                'keterangan' => $keterangan
            ];
        }

        return $this->db->insert_batch('presensi', $batch_data);
    }

    // Fungsi untuk mendapatkan daftar siswa berdasarkan kelas
    public function get_siswa_by_kelas_with_nilai($kelas_id, $jadwal_id = null) {
        $this->db->select('s.*, k.nama_kelas');
        $this->db->from('siswa s');
        $this->db->join('kelas k', 's.kelas_id = k.id');
        $this->db->where('s.kelas_id', $kelas_id);
        $siswa = $this->db->get()->result();

        if ($jadwal_id) {
            foreach ($siswa as &$s) {
                $s->nilai = $this->get_laporan_nilai_per_mapel($s->id, $jadwal_id);
            }
        }

        return $siswa;
    }

    // Fungsi untuk menghitung nilai akhir per mata pelajaran
    public function get_laporan_nilai_per_mapel($siswa_id, $jadwal_id) {
        $nilai = ['uts' => 0, 'uas' => 0, 'sikap' => 0, 'tugas' => 0];

        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('jadwal_id', $jadwal_id);
        $this->db->where_in('jenis', ['uts', 'uas', 'sikap']);
        $result = $this->db->get('nilai')->result();
        foreach ($result as $row) {
            $nilai[$row->jenis] = $row->nilai;
        }

        // Ambil rata-rata tugas (bisa multiple input)
        $this->db->select_avg('nilai', 'rata_tugas');
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('jadwal_id', $jadwal_id);
        $this->db->where('jenis', 'tugas');
        $rata_tugas = $this->db->get('nilai')->row();
        $nilai['tugas'] = $rata_tugas->rata_tugas ? $rata_tugas->rata_tugas : 0;

        // Hitung nilai presensi berdasarkan kehadiran
        $this->db->where('jadwal_id', $jadwal_id);
        $this->db->where('siswa_id', $siswa_id);
        $total_pertemuan = $this->db->count_all_results('presensi');

        $this->db->where('jadwal_id', $jadwal_id);
        $this->db->where('siswa_id', $siswa_id);
        $this->db->where('keterangan', 'hadir');
        $kehadiran = $this->db->count_all_results('presensi');

        $nilai_presensi = $total_pertemuan > 0 ? ($kehadiran / $total_pertemuan) * 100 : 0;

        // Hitung Nilai Akhir sesuai komposisi
        $nilai_akhir = ($nilai['uts'] * 0.25) + ($nilai['uas'] * 0.25) +
                      ($nilai['tugas'] * 0.25) + ($nilai_presensi * 0.15) +
                      ($nilai['sikap'] * 0.10);

        return [
            'uts' => number_format($nilai['uts'], 2),
            'uas' => number_format($nilai['uas'], 2),
            'tugas' => number_format($nilai['tugas'], 2),
            'sikap' => number_format($nilai['sikap'], 2),
            'presensi' => number_format($nilai_presensi, 2),
            'nilai_akhir' => number_format($nilai_akhir, 2),
            'total_pertemuan' => $total_pertemuan,
            'total_hadir' => $kehadiran
        ];
    }

    // Fungsi untuk cek apakah nilai sudah pernah diinput
    public function cek_nilai_exists($siswa_id, $jadwal_id, $jenis) {
        $this->db->where([
            'siswa_id' => $siswa_id,
            'jadwal_id' => $jadwal_id,
            'jenis' => $jenis
        ]);
        return $this->db->count_all_results('nilai') > 0;
    }

    // Fungsi untuk input nilai dengan validasi
    public function input_nilai($data) {
        if (in_array($data['jenis'], ['uts', 'uas', 'sikap'])) {
            if ($this->cek_nilai_exists($data['siswa_id'], $data['jadwal_id'], $data['jenis'])) {
                return ['status' => false, 'message' => 'Nilai ' . strtoupper($data['jenis']) . ' sudah pernah diinput!'];
            }
        }

        // Insert nilai
        if ($this->db->insert('nilai', $data)) {
            return ['status' => true, 'message' => 'Nilai berhasil disimpan'];
        } else {
            return ['status' => false, 'message' => 'Gagal menyimpan nilai'];
        }
    }
}