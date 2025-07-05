<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_logged_in') || $this->session->userdata('role') != 'guru') {
            redirect('auth');
        }
        $this->load->model('Guru_model');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Guru';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('guru/dashboard');
        $this->load->view('templates/footer');
    }

    public function kelas_saya() {
        $guru_id = $this->session->userdata('id_user');
        $data['title'] = 'Kelas Saya';
        $data['kelas'] = $this->Guru_model->get_kelas_by_guru($guru_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('guru/kelas_saya', $data);
        $this->load->view('templates/footer');
    }

    public function nilai() {
        $guru_id = $this->session->userdata('id_user');
        $data['title'] = 'Input Nilai';
        $data['kelas'] = $this->Guru_model->get_kelas_by_guru($guru_id);

        // Jika ada filter jadwal, ambil data siswa
        if ($this->input->get('jadwal_id')) {
            $jadwal_id = $this->input->get('jadwal_id');

            // Ambil info jadwal untuk mendapatkan kelas_id
            $jadwal_info = $this->Guru_model->get_jadwal_detail($jadwal_id);
            if ($jadwal_info) {
                $kelas_id = $jadwal_info->kelas_id;
                $data['siswa'] = $this->Guru_model->get_siswa_by_kelas_with_nilai($kelas_id, $jadwal_id);
                $data['selected_kelas'] = $kelas_id;
                $data['selected_jadwal'] = $jadwal_id;
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('guru/nilai_index', $data);
        $this->load->view('templates/footer');
    }

    public function absensi() {
        $guru_id = $this->session->userdata('id_user');
        $data['title'] = 'Absensi';
        $data['kelas'] = $this->Guru_model->get_kelas_by_guru($guru_id);

        // Jika ada filter jadwal, ambil data siswa
        if ($this->input->get('jadwal_id')) {
            $jadwal_id = $this->input->get('jadwal_id');

            // Ambil info jadwal untuk mendapatkan kelas_id
            $jadwal_info = $this->Guru_model->get_jadwal_detail($jadwal_id);
            if ($jadwal_info) {
                $kelas_id = $jadwal_info->kelas_id;
                $data['siswa'] = $this->Guru_model->get_siswa_by_kelas($kelas_id);
                $data['selected_kelas'] = $kelas_id;
                $data['selected_jadwal'] = $jadwal_id;
                $data['next_pertemuan'] = $this->Guru_model->get_next_pertemuan($jadwal_id);
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('guru/absensi_index', $data);
        $this->load->view('templates/footer');
    }

    // Fungsi untuk menyimpan nilai
    public function simpan_nilai() {
        $siswa_id = $this->input->post('siswa_id');
        $jadwal_id = $this->input->post('jadwal_id');
        $jenis = $this->input->post('jenis');
        $nilai = $this->input->post('nilai');

        $data_nilai = [
            'siswa_id' => $siswa_id,
            'jadwal_id' => $jadwal_id,
            'tahun_ajaran_id' => 1, // Bisa disesuaikan dengan tahun ajaran aktif
            'semester' => 'Ganjil', // Bisa disesuaikan dengan semester aktif
            'jenis' => $jenis,
            'nilai' => $nilai
        ];

        $result = $this->Guru_model->input_nilai($data_nilai);

        if ($result['status']) {
            $this->session->set_flashdata('success', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }

        redirect('guru/nilai?kelas_id=' . $this->input->post('kelas_id') . '&jadwal_id=' . $jadwal_id);
    }

    // Fungsi untuk menyimpan presensi
    public function simpan_absensi() {
        $jadwal_id = $this->input->post('jadwal_id');
        $kelas_id = $this->input->post('kelas_id');
        $siswa_ids = $this->input->post('siswa_id');
        $keterangan = $this->input->post('keterangan');

        $data_presensi = [];
        foreach ($siswa_ids as $key => $siswa_id) {
            $data_presensi[$siswa_id] = $keterangan[$key];
        }

        if ($this->Guru_model->input_presensi($jadwal_id, $data_presensi)) {
            $this->session->set_flashdata('success', 'Data presensi berhasil disimpan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data presensi');
        }

        redirect('guru/absensi?kelas_id=' . $kelas_id . '&jadwal_id=' . $jadwal_id);
    }

    public function jadwal_mengajar() {
        $guru_id = $this->session->userdata('id_user');
        $data['title'] = 'Jadwal Mengajar';
        $data['jadwal'] = $this->Guru_model->get_jadwal_by_guru($guru_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('guru/jadwal', $data);
        $this->load->view('templates/footer');
    }

    public function input_presensi($jadwal_id) {
        $data['title'] = 'Input Presensi';
        $data['jadwal'] = $this->Guru_model->get_jadwal_detail($jadwal_id);
        $data['siswa'] = $this->Guru_model->get_siswa_by_kelas($data['jadwal']->kelas_id);
        // Sistem otomatis menentukan pertemuan berikutnya
        $data['pertemuan'] = $this->Guru_model->get_next_pertemuan($jadwal_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('guru/presensi_form', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_presensi() {
        $presensi_data = [];
        $siswa_ids = $this->input->post('siswa_id');
        $keterangan = $this->input->post('keterangan');
        
        foreach ($siswa_ids as $key => $siswa_id) {
            $presensi_data[] = [
                'siswa_id' => $siswa_id,
                'jadwal_id' => $this->input->post('jadwal_id'),
                'tanggal' => date('Y-m-d'),
                'semester' => $this->input->post('semester'),
                'pertemuan' => $this->input->post('pertemuan'),
                'keterangan' => $keterangan[$key]
            ];
        }
        
        $this->db->insert_batch('presensi', $presensi_data);
        $this->session->set_flashdata('success', 'Data presensi berhasil disimpan.');
        redirect('guru/jadwal_mengajar');
    }

    // ... Function untuk input nilai (UTS, UAS, Tugas, Sikap)
    // ... Function untuk melihat nilai akhir siswa
}