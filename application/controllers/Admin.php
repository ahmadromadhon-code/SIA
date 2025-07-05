<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Middleware untuk cek login dan peran
        if (!$this->session->userdata('is_logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
        $this->load->model('Admin_model');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Admin';
        // Logika untuk menampilkan data di dashboard
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/dashboard');
        $this->load->view('templates/footer');
    }

    // Contoh: Mengelola Data Guru
    public function data_guru() {
        $data['title'] = 'Data Guru';
        $data['guru'] = $this->Admin_model->get_all('guru');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/guru_index', $data);
        $this->load->view('templates/footer');
    }
    
    public function data_siswa() {
        $data['title'] = 'Data Siswa';
        $data['siswa'] = $this->Admin_model->get_siswa_with_kelas();
        $data['kelas'] = $this->Admin_model->get_all('kelas');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/siswa_index', $data);
        $this->load->view('templates/footer');
    }

    public function data_kelas() {
        $data['title'] = 'Data Kelas';
        $data['kelas'] = $this->Admin_model->get_kelas_with_wali();
        $data['guru'] = $this->Admin_model->get_all('guru');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/kelas_index', $data);
        $this->load->view('templates/footer');
    }

    public function mata_pelajaran() {
        $data['title'] = 'Data Mata Pelajaran';
        $data['mapel'] = $this->Admin_model->get_all('mapel');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/mata_pelajaran_index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_guru() {
        $data['title'] = 'Tambah Guru';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/guru_form', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_guru() {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('nip', 'NIP', 'required|is_unique[guru.nip]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[guru.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/data_guru');
        } else {
            $data = array(
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password')), // Hash dengan MD5
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat')
            );

            if ($this->Admin_model->insert('guru', $data)) {
                $this->session->set_flashdata('success', 'Data guru berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data guru!');
            }
            redirect('admin/data_guru');
        }
    }

    public function detail_guru($id) {
        $data['title'] = 'Detail Guru';
        $data['guru'] = $this->Admin_model->get_by_id('guru', $id);

        if (!$data['guru']) {
            $this->session->set_flashdata('error', 'Data guru tidak ditemukan!');
            redirect('admin/data_guru');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/guru_detail', $data);
        $this->load->view('templates/footer');
    }

    public function edit_guru($id) {
        $data['title'] = 'Edit Guru';
        $data['guru'] = $this->Admin_model->get_by_id('guru', $id);

        if (!$data['guru']) {
            $this->session->set_flashdata('error', 'Data guru tidak ditemukan!');
            redirect('admin/data_guru');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/guru_edit', $data);
        $this->load->view('templates/footer');
    }

    public function update_guru() {
        $this->load->library('form_validation');
        $id = $this->input->post('id');

        // Set validation rules (NIP dan username harus unique kecuali untuk record yang sedang diedit)
        $this->form_validation->set_rules('nip', 'NIP', 'required|callback_check_unique_nip['.$id.']');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|callback_check_unique_username['.$id.']');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/edit_guru/'.$id);
        } else {
            $data = array(
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat')
            );

            // Update password jika diisi
            if (!empty($this->input->post('password'))) {
                $data['password'] = md5($this->input->post('password'));
            }

            if ($this->Admin_model->update('guru', $data, ['id' => $id])) {
                $this->session->set_flashdata('success', 'Data guru berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate data guru!');
            }
            redirect('admin/data_guru');
        }
    }

    public function hapus_guru($id) {
        $guru = $this->Admin_model->get_by_id('guru', $id);

        if (!$guru) {
            $this->session->set_flashdata('error', 'Data guru tidak ditemukan!');
            redirect('admin/data_guru');
        }

        if ($this->Admin_model->delete('guru', ['id' => $id])) {
            $this->session->set_flashdata('success', 'Data guru berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data guru!');
        }
        redirect('admin/data_guru');
    }

    // Custom validation untuk NIP unique saat edit
    public function check_unique_nip($nip, $id) {
        $this->db->where('nip', $nip);
        $this->db->where('id !=', $id);
        $query = $this->db->get('guru');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_nip', 'NIP sudah digunakan oleh guru lain.');
            return FALSE;
        }
        return TRUE;
    }

    // Custom validation untuk Username unique saat edit
    public function check_unique_username($username, $id) {
        $this->db->where('username', $username);
        $this->db->where('id !=', $id);
        $query = $this->db->get('guru');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_username', 'Username sudah digunakan oleh guru lain.');
            return FALSE;
        }
        return TRUE;
    }

    // Method untuk mengambil data guru via AJAX
    public function get_guru($id) {
        $guru = $this->Admin_model->get_by_id('guru', $id);

        if ($guru) {
            echo json_encode(['success' => true, 'guru' => $guru]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data guru tidak ditemukan']);
        }
    }

    // ========== CRUD SISWA ==========
    public function tambah_siswa() {
        $data['title'] = 'Tambah Siswa';
        $data['kelas'] = $this->Admin_model->get_all('kelas');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/siswa_form', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_siswa() {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('nis', 'NIS', 'required|is_unique[siswa.nis]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[siswa.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/data_siswa');
        } else {
            $data = array(
                'nis' => $this->input->post('nis'),
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password')),
                'kelas_id' => $this->input->post('kelas_id'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat' => $this->input->post('alamat')
            );

            if ($this->Admin_model->insert('siswa', $data)) {
                $this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data siswa!');
            }
            redirect('admin/data_siswa');
        }
    }

    public function detail_siswa($id) {
        $data['title'] = 'Detail Siswa';
        $data['siswa'] = $this->Admin_model->get_siswa_detail($id);

        if (!$data['siswa']) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan!');
            redirect('admin/data_siswa');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/siswa_detail', $data);
        $this->load->view('templates/footer');
    }

    public function update_siswa() {
        $this->load->library('form_validation');
        $id = $this->input->post('id');

        // Set validation rules
        $this->form_validation->set_rules('nis', 'NIS', 'required|callback_check_unique_nis_siswa['.$id.']');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|callback_check_unique_username_siswa['.$id.']');
        $this->form_validation->set_rules('kelas_id', 'Kelas', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/data_siswa');
        } else {
            $data = array(
                'nis' => $this->input->post('nis'),
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'kelas_id' => $this->input->post('kelas_id'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat' => $this->input->post('alamat')
            );

            // Update password jika diisi
            if (!empty($this->input->post('password'))) {
                $data['password'] = md5($this->input->post('password'));
            }

            if ($this->Admin_model->update('siswa', $data, ['id' => $id])) {
                $this->session->set_flashdata('success', 'Data siswa berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate data siswa!');
            }
            redirect('admin/data_siswa');
        }
    }

    public function hapus_siswa($id) {
        $siswa = $this->Admin_model->get_by_id('siswa', $id);

        if (!$siswa) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan!');
            redirect('admin/data_siswa');
        }

        if ($this->Admin_model->delete('siswa', ['id' => $id])) {
            $this->session->set_flashdata('success', 'Data siswa berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data siswa!');
        }
        redirect('admin/data_siswa');
    }

    public function get_siswa($id) {
        $siswa = $this->Admin_model->get_siswa_detail($id);

        if ($siswa) {
            echo json_encode(['success' => true, 'siswa' => $siswa]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data siswa tidak ditemukan']);
        }
    }

    // Custom validation untuk NIS unique saat edit siswa
    public function check_unique_nis_siswa($nis, $id) {
        $this->db->where('nis', $nis);
        $this->db->where('id !=', $id);
        $query = $this->db->get('siswa');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_nis_siswa', 'NIS sudah digunakan oleh siswa lain.');
            return FALSE;
        }
        return TRUE;
    }

    // Custom validation untuk Username unique saat edit siswa
    public function check_unique_username_siswa($username, $id) {
        $this->db->where('username', $username);
        $this->db->where('id !=', $id);
        $query = $this->db->get('siswa');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_username_siswa', 'Username sudah digunakan oleh siswa lain.');
            return FALSE;
        }
        return TRUE;
    }

    // ========== CRUD KELAS ==========
    public function tambah_kelas() {
        $data['title'] = 'Tambah Kelas';
        $data['guru'] = $this->Admin_model->get_all('guru');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/kelas_form', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_kelas() {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|is_unique[kelas.nama_kelas]');
        $this->form_validation->set_rules('wali_kelas_id', 'Wali Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/data_kelas');
        } else {
            $data = array(
                'nama_kelas' => $this->input->post('nama_kelas'),
                'wali_kelas_id' => $this->input->post('wali_kelas_id')
            );

            if ($this->Admin_model->insert('kelas', $data)) {
                $this->session->set_flashdata('success', 'Data kelas berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data kelas!');
            }
            redirect('admin/data_kelas');
        }
    }

    public function detail_kelas($id) {
        $data['title'] = 'Detail Kelas';
        $data['kelas'] = $this->Admin_model->get_kelas_detail($id);

        if (!$data['kelas']) {
            $this->session->set_flashdata('error', 'Data kelas tidak ditemukan!');
            redirect('admin/data_kelas');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/kelas_detail', $data);
        $this->load->view('templates/footer');
    }

    public function update_kelas() {
        $this->load->library('form_validation');
        $id = $this->input->post('id');

        // Set validation rules
        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|callback_check_unique_nama_kelas['.$id.']');
        $this->form_validation->set_rules('wali_kelas_id', 'Wali Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/data_kelas');
        } else {
            $data = array(
                'nama_kelas' => $this->input->post('nama_kelas'),
                'wali_kelas_id' => $this->input->post('wali_kelas_id')
            );

            if ($this->Admin_model->update('kelas', $data, ['id' => $id])) {
                $this->session->set_flashdata('success', 'Data kelas berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate data kelas!');
            }
            redirect('admin/data_kelas');
        }
    }

    public function hapus_kelas($id) {
        $kelas = $this->Admin_model->get_by_id('kelas', $id);

        if (!$kelas) {
            $this->session->set_flashdata('error', 'Data kelas tidak ditemukan!');
            redirect('admin/data_kelas');
        }

        // Check if there are students in this class
        $siswa_count = $this->Admin_model->count_siswa_in_kelas($id);
        if ($siswa_count > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa!');
            redirect('admin/data_kelas');
        }

        if ($this->Admin_model->delete('kelas', ['id' => $id])) {
            $this->session->set_flashdata('success', 'Data kelas berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data kelas!');
        }
        redirect('admin/data_kelas');
    }

    public function get_kelas($id) {
        $kelas = $this->Admin_model->get_kelas_detail($id);

        if ($kelas) {
            echo json_encode(['success' => true, 'kelas' => $kelas]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data kelas tidak ditemukan']);
        }
    }

    // Custom validation untuk Nama Kelas unique saat edit
    public function check_unique_nama_kelas($nama_kelas, $id) {
        $this->db->where('nama_kelas', $nama_kelas);
        $this->db->where('id !=', $id);
        $query = $this->db->get('kelas');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_nama_kelas', 'Nama kelas sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    // ========== CRUD MATA PELAJARAN ==========
    public function tambah_mata_pelajaran() {
        $data['title'] = 'Tambah Mata Pelajaran';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/mapel_form', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_mapel() {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required|is_unique[mapel.nama_mapel]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/mata_pelajaran');
        } else {
            $data = array(
                'nama_mapel' => $this->input->post('nama_mapel')
            );

            if ($this->Admin_model->insert('mapel', $data)) {
                $this->session->set_flashdata('success', 'Data mata pelajaran berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data mata pelajaran!');
            }
            redirect('admin/mata_pelajaran');
        }
    }

    public function detail_mapel($id) {
        $data['title'] = 'Detail Mata Pelajaran';
        $data['mapel'] = $this->Admin_model->get_by_id('mapel', $id);

        if (!$data['mapel']) {
            $this->session->set_flashdata('error', 'Data mata pelajaran tidak ditemukan!');
            redirect('admin/mata_pelajaran');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('admin/mapel_detail', $data);
        $this->load->view('templates/footer');
    }

    public function update_mapel() {
        $this->load->library('form_validation');
        $id = $this->input->post('id');

        // Set validation rules
        $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required|callback_check_unique_nama_mapel['.$id.']');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/mata_pelajaran');
        } else {
            $data = array(
                'nama_mapel' => $this->input->post('nama_mapel')
            );

            if ($this->Admin_model->update('mapel', $data, ['id' => $id])) {
                $this->session->set_flashdata('success', 'Data mata pelajaran berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate data mata pelajaran!');
            }
            redirect('admin/mata_pelajaran');
        }
    }

    public function hapus_mapel($id) {
        $mapel = $this->Admin_model->get_by_id('mapel', $id);

        if (!$mapel) {
            $this->session->set_flashdata('error', 'Data mata pelajaran tidak ditemukan!');
            redirect('admin/mata_pelajaran');
        }

        // Check if this mapel is used in jadwal
        $jadwal_count = $this->Admin_model->count_jadwal_by_mapel($id);
        if ($jadwal_count > 0) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus mata pelajaran yang masih digunakan dalam jadwal!');
            redirect('admin/mata_pelajaran');
        }

        if ($this->Admin_model->delete('mapel', ['id' => $id])) {
            $this->session->set_flashdata('success', 'Data mata pelajaran berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data mata pelajaran!');
        }
        redirect('admin/mata_pelajaran');
    }

    public function get_mapel($id) {
        $mapel = $this->Admin_model->get_by_id('mapel', $id);

        if ($mapel) {
            echo json_encode(['success' => true, 'mapel' => $mapel]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data mata pelajaran tidak ditemukan']);
        }
    }

    // Custom validation untuk Nama Mata Pelajaran unique saat edit
    public function check_unique_nama_mapel($nama_mapel, $id) {
        $this->db->where('nama_mapel', $nama_mapel);
        $this->db->where('id !=', $id);
        $query = $this->db->get('mapel');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_nama_mapel', 'Nama mata pelajaran sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

}