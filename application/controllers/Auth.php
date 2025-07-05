<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function index() {
        // Jika sudah login, redirect sesuai peran
        if ($this->session->userdata('is_logged_in')) {
            redirect($this->session->userdata('role'));
        }
        $this->load->view('auth/login');
    }

    public function proses_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role = $this->input->post('role');

        $user = $this->Auth_model->login($username, $password, $role);

        if ($user) {
            $session_data = [
                'id_user' => $user->id,
                'username' => $user->username,
                'nama_lengkap' => $user->nama, // atau nama_lengkap untuk admin
                'role' => $role,
                'is_logged_in' => TRUE
            ];
            
            // untuk siswa, simpan juga kelas_id
            if($role == 'siswa'){
                $session_data['kelas_id'] = $user->kelas_id;
            }

            $this->session->set_userdata($session_data);
            redirect($role . '/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username, Password, atau Peran salah!');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}