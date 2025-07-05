# Sistem Informasi Akademik (SIA)

Sistem Informasi Akademik berbasis web menggunakan CodeIgniter 3 dengan fitur lengkap untuk mengelola data akademik sekolah.

## Fitur Utama

### Admin
- Dashboard dengan statistik
- Manajemen data guru
- Manajemen data siswa  
- Manajemen data kelas
- Manajemen mata pelajaran
- Pengaturan sistem

### Guru
- Dashboard guru
- Melihat kelas yang diampu
- Input dan kelola nilai siswa
- Input absensi siswa
- Laporan nilai dan absensi

### Siswa
- Dashboard siswa
- Melihat jadwal pelajaran
- Melihat nilai dan rapor
- Melihat riwayat absensi
- Profil siswa

## Teknologi yang Digunakan

- **Backend**: CodeIgniter 3
- **Frontend**: Bootstrap 5, Font Awesome 6
- **Database**: MySQL/MariaDB
- **Server**: Apache (XAMPP)

## Instalasi

### 1. Persiapan Environment
- Install XAMPP atau server web lainnya
- Pastikan PHP 7.4+ dan MySQL aktif

### 2. Setup Database
1. Buat database baru dengan nama `sia`
2. Import file `application/sia.sql` ke database
3. Import file `sample_data.sql` untuk data contoh

### 3. Konfigurasi
1. Sesuaikan konfigurasi database di `application/config/database.php`
2. Sesuaikan base URL di `application/config/config.php`

### 4. Akses Aplikasi
Buka browser dan akses: `http://localhost/SIA`

## Login Default

### Admin
- Username: `admin`
- Password: `admin123`

### Guru
- Username: `budi` / `sari` / `ahmad`
- Password: `guru123`

### Siswa
- Username: `andi` / `siti` / `rudi` / `maya`
- Password: `siswa123`

## Struktur Database

### Tabel Utama (Sesuai Database)
- `admin` - Data administrator
- `guru` - Data guru
- `siswa` - Data siswa
- `kelas` - Data kelas
- `mapel` - Data mata pelajaran (bukan mata_pelajaran)
- `jadwal` - Jadwal pelajaran
- `nilai` - Data nilai siswa
- `presensi` - Data absensi
- `tahun_ajaran` - Data tahun ajaran

### Relasi Antar Tabel
- `siswa.kelas_id` → `kelas.id`
- `kelas.wali_kelas_id` → `guru.id`
- `jadwal.kelas_id` → `kelas.id`
- `jadwal.mapel_id` → `mapel.id`
- `jadwal.guru_id` → `guru.id`
- `jadwal.tahun_ajaran_id` → `tahun_ajaran.id`
- `nilai.siswa_id` → `siswa.id`
- `nilai.jadwal_id` → `jadwal.id`
- `presensi.siswa_id` → `siswa.id`
- `presensi.jadwal_id` → `jadwal.id`

## Fitur Keamanan

- Password terenkripsi MD5
- Session management
- Role-based access control
- Input validation
- SQL injection protection (CodeIgniter Active Record)

## Pengembangan Lebih Lanjut

### Fitur yang Bisa Ditambahkan
- Upload foto profil
- Sistem notifikasi
- Export laporan ke PDF/Excel
- Sistem pembayaran SPP
- E-learning module
- Parent portal
- Mobile responsive optimization

### Peningkatan Keamanan
- Upgrade ke password hashing yang lebih aman (bcrypt)
- Implementasi CSRF protection
- Rate limiting untuk login
- Two-factor authentication

## Troubleshooting

### Error Database Connection
- Pastikan MySQL service aktif
- Cek konfigurasi di `application/config/database.php`
- Pastikan database `sia` sudah dibuat

### Error 404 Not Found
- Pastikan mod_rewrite Apache aktif
- Cek file `.htaccess` di root folder
- Sesuaikan base URL di config

### Error Permission Denied
- Pastikan folder `application/cache` dan `application/logs` writable
- Set permission 755 untuk folder aplikasi

## Kontribusi

Silakan fork repository ini dan buat pull request untuk kontribusi pengembangan.

## Lisensi

Project ini menggunakan lisensi MIT. Silakan gunakan dan modifikasi sesuai kebutuhan.

---

**Catatan**: Aplikasi ini dibuat untuk tujuan pembelajaran dan pengembangan. Untuk penggunaan production, disarankan untuk melakukan security audit dan optimisasi lebih lanjut.
