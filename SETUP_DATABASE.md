# Setup Database Sistem Informasi Akademik

## ⚠️ PENTING: Menggunakan Struktur Database yang Ada

**TIDAK BOLEH MENGUBAH STRUKTUR DATABASE YANG SUDAH ADA**

Berdasarkan gambar struktur database yang Anda berikan, tabel yang harus ada adalah:

1. **admin** - Data administrator sistem
2. **guru** - Data guru/pengajar
3. **jadwal** - Jadwal pelajaran
4. **kelas** - Data kelas
5. **mapel** - Data mata pelajaran
6. **nilai** - Data nilai siswa
7. **presensi** - Data absensi siswa
8. **siswa** - Data siswa
9. **tahun_ajaran** - Data tahun ajaran

## Langkah Setup Database

### 1. Buat Database
```sql
CREATE DATABASE sia;
USE sia;
```

### 2. Import Struktur Tabel
Gunakan file `application/sia.sql` yang sudah ada, atau jalankan script berikut:

```sql
-- Import dari file
SOURCE application/sia.sql;
```

### 3. Import Data Sample
```sql
-- Import data sample yang sesuai struktur database
SOURCE sample_data_correct.sql;
```

**CATATAN:** Gunakan `sample_data_correct.sql` yang sudah disesuaikan dengan struktur database yang ada tanpa mengubah field apapun.

## Verifikasi Struktur Database

Setelah import, pastikan tabel-tabel berikut ada:

```sql
SHOW TABLES;
```

Hasil yang diharapkan:
```
+------------------+
| Tables_in_sia    |
+------------------+
| admin            |
| guru             |
| jadwal           |
| kelas            |
| mapel            |
| nilai            |
| presensi         |
| siswa            |
| tahun_ajaran     |
+------------------+
```

## Data Sample untuk Testing

### Login Credentials

**Admin:**
- Username: `admin`
- Password: `admin123`
- Role: Admin

**Guru:**
- Username: `budi`
- Password: `guru123`
- Role: Guru

**Siswa:**
- Username: `andi`
- Password: `siswa123`
- Role: Siswa

### Data yang Tersedia

1. **3 Guru** dengan mata pelajaran berbeda
2. **3 Kelas** (X IPA 1, X IPA 2, XI IPA 1)
3. **5 Mata Pelajaran** (Matematika, Bahasa Indonesia, Fisika, Kimia, Biologi)
4. **4 Siswa** tersebar di kelas yang berbeda
5. **8 Jadwal** pelajaran untuk testing
6. **Sample nilai** untuk beberapa siswa
7. **Sample presensi** untuk testing perhitungan

## Konfigurasi Aplikasi

### 1. Database Config
Edit file `application/config/database.php`:

```php
$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'sia',
    'dbdriver' => 'mysqli',
    // ... konfigurasi lainnya
);
```

### 2. Base URL
Edit file `application/config/config.php`:

```php
$config['base_url'] = 'http://localhost/SIA/';
```

## Testing Aplikasi

### 1. Akses Aplikasi
Buka browser dan akses: `http://localhost/SIA`

### 2. Test Login
- Login sebagai admin untuk kelola data master
- Login sebagai guru untuk input nilai dan absensi
- Login sebagai siswa untuk lihat jadwal dan nilai

### 3. Test Fitur Utama

**Admin:**
- ✅ Kelola data guru
- ✅ Kelola data siswa
- ✅ Kelola data kelas
- ✅ Kelola mata pelajaran

**Guru:**
- ✅ Input nilai (UTS, UAS, Tugas, Sikap)
- ✅ Input absensi dengan nomor pertemuan otomatis
- ✅ Lihat kelas yang diampu

**Siswa:**
- ✅ Lihat jadwal pelajaran
- ✅ Lihat nilai dengan perhitungan otomatis
- ✅ Lihat riwayat absensi

## Troubleshooting

### Error "Table doesn't exist"
- Pastikan semua tabel sudah diimport dengan benar
- Cek nama tabel menggunakan `SHOW TABLES;`
- Pastikan menggunakan nama tabel yang benar: `mapel` bukan `mata_pelajaran`

### Error Database Connection
- Pastikan MySQL service aktif
- Cek username/password database
- Pastikan database `sia` sudah dibuat

### Error 404 Not Found
- Pastikan mod_rewrite Apache aktif
- Cek file `.htaccess` di root folder
- Sesuaikan base URL di config

## Fitur Sistem

### Perhitungan Nilai Otomatis
Sistem menghitung nilai akhir dengan komposisi:
- **UTS: 25%** (input sekali)
- **UAS: 25%** (input sekali)
- **Tugas: 25%** (multiple input, dihitung rata-rata)
- **Presensi: 15%** (otomatis dari absensi)
- **Sikap: 10%** (input sekali)

### Validasi Input
- UTS, UAS, Sikap hanya bisa diinput sekali per siswa per mata pelajaran
- Tugas bisa diinput berkali-kali, sistem otomatis menghitung rata-rata
- Nomor pertemuan presensi ditentukan otomatis oleh sistem

### Keamanan
- Role-based access control
- Session management
- Input validation
- Password encryption (MD5)

## Catatan Penting

1. **Nama Tabel:** Gunakan `mapel` bukan `mata_pelajaran`
2. **Relasi:** Pastikan foreign key constraints aktif
3. **Data Sample:** Gunakan data sample untuk testing fitur
4. **Backup:** Selalu backup database sebelum modifikasi

---

Jika ada masalah dalam setup, pastikan struktur database sesuai dengan yang ditunjukkan dalam gambar dan ikuti langkah-langkah di atas secara berurutan.
