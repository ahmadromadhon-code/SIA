<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('is_logged_in') || $this->session->userdata('role') != 'siswa') {
            redirect('auth');
        }
        $this->load->model('Siswa_model');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Siswa';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('siswa/dashboard');
        $this->load->view('templates/footer');
    }

    public function jadwal() {
        $siswa_id = $this->session->userdata('id_user');
        $kelas_id = $this->session->userdata('kelas_id');
        $data['title'] = 'Jadwal Pelajaran';
        $data['jadwal'] = $this->Siswa_model->get_jadwal_by_kelas($kelas_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('siswa/jadwal', $data);
        $this->load->view('templates/footer');
    }

    public function nilai() {
        $siswa_id = $this->session->userdata('id_user');
        $data['title'] = 'Laporan Nilai';
        $data['laporan_nilai'] = $this->Siswa_model->get_laporan_nilai($siswa_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('siswa/nilai', $data);
        $this->load->view('templates/footer');
    }

    public function absensi() {
        $siswa_id = $this->session->userdata('id_user');
        $data['title'] = 'Absensi Saya';
        $data['absensi'] = $this->Siswa_model->get_absensi_siswa($siswa_id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('siswa/absensi', $data);
        $this->load->view('templates/footer');
    }
}