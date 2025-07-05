<?php
// Script untuk insert SEMUA sample data yang benar ke database SIA
// Jalankan: http://localhost/SIA/insert_all_sample_data.php

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sia';

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Insert SEMUA Sample Data SIA 2025</h2>";
    echo "<p><strong>Sesuai struktur database yang ada - TIDAK mengubah field apapun</strong></p>";
    
    $total_inserted = 0;
    
    // 1. INSERT DATA ADMIN
    echo "<h3>1. Insert Data Admin</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO admin (id, username, password, nama_lengkap) VALUES (?, ?, ?, ?)");
    $admin_data = [
        [1, 'admin', md5('admin123'), 'Administrator Sistem']
    ];
    
    foreach ($admin_data as $admin) {
        if ($stmt->execute($admin) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Admin: {$admin[3]}</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Admin sudah ada: {$admin[3]}</p>";
        }
    }
    
    // 2. INSERT DATA GURU
    echo "<h3>2. Insert Data Guru</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO guru (id, nip, nama, username, password, no_hp, alamat) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $guru_data = [
        [1, '198501012010011001', 'Budi Santoso, S.Pd', 'budi', md5('guru123'), '081234567890', 'Jl. Pendidikan No. 1'],
        [2, '198702152011012002', 'Sari Dewi, S.Pd', 'sari', md5('guru123'), '081234567891', 'Jl. Guru No. 2'],
        [3, '198903202012013003', 'Ahmad Fauzi, S.Pd', 'ahmad', md5('guru123'), '081234567892', 'Jl. Ilmu No. 3']
    ];
    
    foreach ($guru_data as $guru) {
        if ($stmt->execute($guru) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Guru: {$guru[2]}</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Guru sudah ada: {$guru[2]}</p>";
        }
    }
    
    // 3. INSERT DATA KELAS (sesuai struktur: id, nama_kelas, wali_kelas_id)
    echo "<h3>3. Insert Data Kelas</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO kelas (id, nama_kelas, wali_kelas_id) VALUES (?, ?, ?)");
    $kelas_data = [
        [1, 'X IPA 1', 1],
        [2, 'X IPA 2', 2],
        [3, 'XI IPA 1', 3]
    ];
    
    foreach ($kelas_data as $kelas) {
        if ($stmt->execute($kelas) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Kelas: {$kelas[1]}</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Kelas sudah ada: {$kelas[1]}</p>";
        }
    }
    
    // 4. INSERT DATA MATA PELAJARAN (sesuai struktur: id, nama_mapel)
    echo "<h3>4. Insert Data Mata Pelajaran</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO mapel (id, nama_mapel) VALUES (?, ?)");
    $mapel_data = [
        [1, 'Matematika'],
        [2, 'Bahasa Indonesia'],
        [3, 'Fisika'],
        [4, 'Kimia'],
        [5, 'Biologi']
    ];
    
    foreach ($mapel_data as $mapel) {
        if ($stmt->execute($mapel) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Mata Pelajaran: {$mapel[1]}</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Mata Pelajaran sudah ada: {$mapel[1]}</p>";
        }
    }
    
    // 5. INSERT DATA SISWA
    echo "<h3>5. Insert Data Siswa</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO siswa (id, nis, nama, username, password, kelas_id, jenis_kelamin, tanggal_lahir, alamat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $siswa_data = [
        [1, '2025001', 'Andi Pratama', 'andi', md5('siswa123'), 1, 'L', '2008-01-15', 'Jl. Siswa No. 1'],
        [2, '2025002', 'Siti Nurhaliza', 'siti', md5('siswa123'), 1, 'P', '2008-02-20', 'Jl. Siswa No. 2'],
        [3, '2025003', 'Rudi Hermawan', 'rudi', md5('siswa123'), 2, 'L', '2008-03-10', 'Jl. Siswa No. 3'],
        [4, '2025004', 'Maya Sari', 'maya', md5('siswa123'), 2, 'P', '2008-04-05', 'Jl. Siswa No. 4']
    ];
    
    foreach ($siswa_data as $siswa) {
        if ($stmt->execute($siswa) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Siswa: {$siswa[2]} (NIS: {$siswa[1]})</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Siswa sudah ada: {$siswa[2]}</p>";
        }
    }
    
    // 6. INSERT DATA TAHUN AJARAN (sesuai struktur: id, nama)
    echo "<h3>6. Insert Data Tahun Ajaran</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO tahun_ajaran (id, nama) VALUES (?, ?)");
    $tahun_data = [
        [1, '2025/2026']
    ];
    
    foreach ($tahun_data as $tahun) {
        if ($stmt->execute($tahun) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Tahun Ajaran: {$tahun[1]}</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Tahun Ajaran sudah ada: {$tahun[1]}</p>";
        }
    }
    
    echo "<hr>";
    echo "<h3>📊 Ringkasan Data yang Berhasil Diinsert</h3>";
    echo "<p><strong>Total record baru:</strong> $total_inserted</p>";
    
    // Cek total data di setiap tabel
    $tables = ['admin', 'guru', 'siswa', 'kelas', 'mapel', 'tahun_ajaran'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetchColumn();
        echo "<p>📊 <strong>$table:</strong> $count record(s)</p>";
    }
    
    // 7. INSERT DATA JADWAL
    echo "<h3>7. Insert Data Jadwal</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO jadwal (id, kelas_id, mapel_id, guru_id, tahun_ajaran_id, semester, hari, jam_mulai, jam_selesai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $jadwal_data = [
        [1, 1, 1, 1, 1, 'Ganjil', 'Senin', '07:30:00', '09:00:00'],
        [2, 1, 2, 2, 1, 'Ganjil', 'Senin', '09:15:00', '10:45:00'],
        [3, 1, 3, 3, 1, 'Ganjil', 'Selasa', '07:30:00', '09:00:00'],
        [4, 2, 1, 1, 1, 'Ganjil', 'Selasa', '09:15:00', '10:45:00'],
        [5, 2, 2, 2, 1, 'Ganjil', 'Rabu', '07:30:00', '09:00:00'],
        [6, 1, 4, 1, 1, 'Ganjil', 'Rabu', '09:15:00', '10:45:00'],
        [7, 1, 5, 3, 1, 'Ganjil', 'Kamis', '07:30:00', '09:00:00'],
        [8, 2, 3, 3, 1, 'Ganjil', 'Kamis', '09:15:00', '10:45:00']
    ];

    foreach ($jadwal_data as $jadwal) {
        if ($stmt->execute($jadwal) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Jadwal: Kelas {$jadwal[1]} - {$jadwal[5]} {$jadwal[6]}</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Jadwal sudah ada: Kelas {$jadwal[1]} - {$jadwal[5]} {$jadwal[6]}</p>";
        }
    }

    // 8. INSERT DATA NILAI
    echo "<h3>8. Insert Data Nilai</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO nilai (id, siswa_id, jadwal_id, tahun_ajaran_id, semester, jenis, nilai) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $nilai_data = [
        [1, 1, 1, 1, 'Ganjil', 'uts', 85.00],
        [2, 1, 1, 1, 'Ganjil', 'uas', 88.00],
        [3, 1, 1, 1, 'Ganjil', 'tugas', 90.00],
        [4, 1, 1, 1, 'Ganjil', 'sikap', 85.00],
        [5, 2, 1, 1, 'Ganjil', 'uts', 78.00],
        [6, 2, 1, 1, 'Ganjil', 'uas', 82.00],
        [7, 2, 1, 1, 'Ganjil', 'tugas', 85.00],
        [8, 2, 1, 1, 'Ganjil', 'sikap', 88.00]
    ];

    foreach ($nilai_data as $nilai) {
        if ($stmt->execute($nilai) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Nilai: Siswa {$nilai[1]} - {$nilai[5]} = {$nilai[6]}</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Nilai sudah ada: Siswa {$nilai[1]} - {$nilai[5]}</p>";
        }
    }

    // 9. INSERT DATA PRESENSI
    echo "<h3>9. Insert Data Presensi</h3>";
    $stmt = $pdo->prepare("INSERT IGNORE INTO presensi (id, siswa_id, jadwal_id, tanggal, semester, pertemuan, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $presensi_data = [
        [1, 1, 1, '2025-01-15', 'Ganjil', 1, 'hadir'],
        [2, 1, 1, '2025-01-22', 'Ganjil', 2, 'hadir'],
        [3, 1, 1, '2025-01-29', 'Ganjil', 3, 'sakit'],
        [4, 2, 1, '2025-01-15', 'Ganjil', 1, 'hadir'],
        [5, 2, 1, '2025-01-22', 'Ganjil', 2, 'hadir'],
        [6, 2, 1, '2025-01-29', 'Ganjil', 3, 'hadir']
    ];

    foreach ($presensi_data as $presensi) {
        if ($stmt->execute($presensi) && $stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Presensi: Siswa {$presensi[1]} - {$presensi[3]} ({$presensi[6]})</p>";
            $total_inserted++;
        } else {
            echo "<p style='color: orange;'>⚠️ Presensi sudah ada: Siswa {$presensi[1]} - {$presensi[3]}</p>";
        }
    }

    echo "<hr>";
    echo "<h3>🎉 SEMUA SAMPLE DATA BERHASIL DIINSERT!</h3>";
    echo "<p><strong>Total record baru:</strong> $total_inserted</p>";

    // Cek total data di semua tabel
    $all_tables = ['admin', 'guru', 'siswa', 'kelas', 'mapel', 'tahun_ajaran', 'jadwal', 'nilai', 'presensi'];

    foreach ($all_tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetchColumn();
        echo "<p>📊 <strong>$table:</strong> $count record(s)</p>";
    }

    echo "<hr>";
    echo "<h3>🚀 Test Aplikasi</h3>";
    echo "<p><a href='index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login ke Aplikasi</a></p>";
    echo "<p><a href='test_connection.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Test Koneksi Database</a></p>";

    echo "<h3>📋 Kredensial Login</h3>";
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<p><strong>Admin:</strong> admin / admin123</p>";
    echo "<p><strong>Guru:</strong> budi / guru123 (atau sari, ahmad)</p>";
    echo "<p><strong>Siswa:</strong> andi / siswa123 (atau siti, rudi, maya)</p>";
    echo "</div>";

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f5f5f5;
}

h2, h3 {
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
}

p {
    background: white;
    padding: 8px 12px;
    border-radius: 5px;
    margin: 3px 0;
}

div {
    margin: 10px 0;
}
</style>
