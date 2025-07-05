<?php
class Auth_model extends CI_Model {
    public function login($username, $password, $role) {
        $table = '';
        if ($role == 'admin') $table = 'admin';
        elseif ($role == 'guru') $table = 'guru';
        elseif ($role == 'siswa') $table = 'siswa';
        else return false;

        $this->db->where('username', $username);
        $query = $this->db->get($table);
        $user = $query->row();

        // Menggunakan MD5 untuk verifikasi password
        if ($user && md5($password) == $user->password) {
            if ($role == 'admin') {
                $user->nama = $user->nama_lengkap;
            }
            return $user;
        }
        return false;
    }
}