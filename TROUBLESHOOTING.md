# Troubleshooting Sistem Informasi Akademik

## Error: "Undefined property: stdClass::$tingkat"

### Penyebab
Error ini terjadi karena kolom `tingkat` tidak ada di tabel `kelas`. Berdasarkan struktur database yang ada, tabel `kelas` hanya memiliki field:
- `id`
- `nama_kelas`
- `wali_kelas_id`

### Solusi ✅ SUDAH DIPERBAIKI

**TIDAK BOLEH MENGUBAH STRUKTUR DATABASE**

Saya sudah memperbaiki view `admin/kelas_index.php` untuk menghilangkan kolom tingkat dari tampilan, sehingga error ini tidak akan muncul lagi.

**Perubahan yang dilakukan:**
- ❌ Menghilangkan kolom "Tingkat" dari header tabel
- ❌ Menghilangkan `$k->tingkat` dari data row
- ❌ Menghilangkan field tingkat dari form input
- ✅ Menggunakan hanya field yang ada di database

## Error Umum Lainnya

### 1. "Table doesn't exist"
**Penyebab:** Tabel belum dibuat atau nama tabel salah

**Solusi:**
```sql
-- Cek tabel yang ada
SHOW TABLES;

-- Import struktur database
SOURCE application/sia.sql;
```

### 2. "Access denied for user"
**Penyebab:** Username/password database salah

**Solusi:**
- Cek konfigurasi di `application/config/database.php`
- Pastikan MySQL service running
- Gunakan username/password yang benar (default: root/kosong)

### 3. "Call to undefined method"
**Penyebab:** Model atau method tidak ditemukan

**Solusi:**
- Pastikan model sudah di-load di controller
- Cek nama method di model
- Pastikan file model ada di folder `application/models/`

### 4. "404 Page Not Found"
**Penyebab:** URL routing bermasalah

**Solusi:**
- Pastikan file `.htaccess` ada di root folder
- Cek konfigurasi `base_url` di `application/config/config.php`
- Pastikan mod_rewrite Apache aktif

### 5. "Undefined index" atau "Undefined variable"
**Penyebab:** Variabel tidak didefinisikan atau tidak dikirim dari controller

**Solusi:**
- Gunakan `isset()` untuk cek variabel
- Pastikan data dikirim dari controller ke view
- Gunakan operator null coalescing `??` (PHP 7+)

## Langkah Debugging

### 1. Cek Error Log
```bash
# Lokasi error log (XAMPP)
tail -f C:\xampp\apache\logs\error.log
```

### 2. Enable Error Reporting
Tambahkan di `index.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### 3. Cek Database Connection
Jalankan `test_connection.php` untuk memastikan database terhubung dengan benar.

### 4. Debug Query
Tambahkan di controller untuk debug query:
```php
echo $this->db->last_query();
exit;
```

## Struktur Database yang Benar

Pastikan tabel-tabel berikut ada:
- ✅ admin
- ✅ guru  
- ✅ siswa
- ✅ kelas
- ✅ mapel
- ✅ jadwal
- ✅ nilai
- ✅ presensi
- ✅ tahun_ajaran

## File Penting untuk Troubleshooting

1. **`test_connection.php`** - Test koneksi database
2. **`fix_database.sql`** - Perbaikan struktur database
3. **`application/config/database.php`** - Konfigurasi database
4. **`application/config/config.php`** - Konfigurasi aplikasi
5. **`.htaccess`** - URL rewriting

## Kontak Support

Jika masih ada masalah:
1. Cek error message dengan teliti
2. Lihat di browser console untuk JavaScript error
3. Cek network tab untuk AJAX error
4. Pastikan semua file sudah di-upload dengan benar

## Tips Pencegahan

1. **Selalu backup database** sebelum melakukan perubahan
2. **Test di environment development** sebelum production
3. **Gunakan version control** (Git) untuk track perubahan
4. **Enable error logging** untuk monitoring
5. **Dokumentasikan perubahan** yang dilakukan

---

**Catatan:** Error "Undefined property: stdClass::$tingkat" sudah diperbaiki dengan menghilangkan kolom tingkat dari tampilan Data Kelas.
