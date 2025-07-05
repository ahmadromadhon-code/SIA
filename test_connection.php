<?php
/**
 * Script untuk testing koneksi database dan struktur tabel
 * Jalankan file ini untuk memastikan database sudah setup dengan benar
 */

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sia';

echo "<h2>Testing Koneksi Database SIA</h2>";

try {
    // Test koneksi
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
    
    // Cek tabel yang ada
    echo "<h3>Daftar Tabel:</h3>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $expected_tables = ['admin', 'guru', 'jadwal', 'kelas', 'mapel', 'nilai', 'presensi', 'siswa', 'tahun_ajaran'];
    
    echo "<ul>";
    foreach ($expected_tables as $table) {
        if (in_array($table, $tables)) {
            echo "<li style='color: green;'>✅ $table</li>";
        } else {
            echo "<li style='color: red;'>❌ $table (tidak ditemukan)</li>";
        }
    }
    echo "</ul>";
    
    // Cek data sample
    echo "<h3>Data Sample:</h3>";
    
    // Cek admin
    $stmt = $pdo->query("SELECT COUNT(*) FROM admin");
    $admin_count = $stmt->fetchColumn();
    echo "<p>Admin: $admin_count record(s)</p>";
    
    // Cek guru
    $stmt = $pdo->query("SELECT COUNT(*) FROM guru");
    $guru_count = $stmt->fetchColumn();
    echo "<p>Guru: $guru_count record(s)</p>";
    
    // Cek siswa
    $stmt = $pdo->query("SELECT COUNT(*) FROM siswa");
    $siswa_count = $stmt->fetchColumn();
    echo "<p>Siswa: $siswa_count record(s)</p>";
    
    // Cek kelas
    $stmt = $pdo->query("SELECT COUNT(*) FROM kelas");
    $kelas_count = $stmt->fetchColumn();
    echo "<p>Kelas: $kelas_count record(s)</p>";
    
    // Cek mapel
    $stmt = $pdo->query("SELECT COUNT(*) FROM mapel");
    $mapel_count = $stmt->fetchColumn();
    echo "<p>Mata Pelajaran: $mapel_count record(s)</p>";
    
    // Cek jadwal
    $stmt = $pdo->query("SELECT COUNT(*) FROM jadwal");
    $jadwal_count = $stmt->fetchColumn();
    echo "<p>Jadwal: $jadwal_count record(s)</p>";
    
    // Test login credentials
    echo "<h3>Test Login Credentials:</h3>";
    
    // Test admin
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = MD5(?)");
    $stmt->execute(['admin', 'admin123']);
    if ($stmt->fetch()) {
        echo "<p style='color: green;'>✅ Admin login: admin/admin123</p>";
    } else {
        echo "<p style='color: red;'>❌ Admin login gagal</p>";
    }
    
    // Test guru
    $stmt = $pdo->prepare("SELECT * FROM guru WHERE username = ? AND password = MD5(?)");
    $stmt->execute(['budi', 'guru123']);
    if ($stmt->fetch()) {
        echo "<p style='color: green;'>✅ Guru login: budi/guru123</p>";
    } else {
        echo "<p style='color: red;'>❌ Guru login gagal</p>";
    }
    
    // Test siswa
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE username = ? AND password = MD5(?)");
    $stmt->execute(['andi', 'siswa123']);
    if ($stmt->fetch()) {
        echo "<p style='color: green;'>✅ Siswa login: andi/siswa123</p>";
    } else {
        echo "<p style='color: red;'>❌ Siswa login gagal</p>";
    }
    
    // Test relasi tabel
    echo "<h3>Test Relasi Tabel:</h3>";
    
    // Test jadwal dengan join
    $stmt = $pdo->query("
        SELECT j.id, k.nama_kelas, m.nama_mapel, g.nama as nama_guru 
        FROM jadwal j 
        JOIN kelas k ON j.kelas_id = k.id 
        JOIN mapel m ON j.mapel_id = m.id 
        JOIN guru g ON j.guru_id = g.id 
        LIMIT 1
    ");
    
    if ($stmt->fetch()) {
        echo "<p style='color: green;'>✅ Relasi tabel jadwal berfungsi</p>";
    } else {
        echo "<p style='color: red;'>❌ Relasi tabel jadwal bermasalah</p>";
    }
    
    echo "<h3>Kesimpulan:</h3>";
    
    if (count(array_intersect($expected_tables, $tables)) == count($expected_tables)) {
        echo "<p style='color: green; font-weight: bold;'>✅ Database setup berhasil! Aplikasi siap digunakan.</p>";
        echo "<p><a href='index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Akses Aplikasi</a></p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>❌ Database setup belum lengkap. Silakan import file SQL yang diperlukan.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Error koneksi database: " . $e->getMessage() . "</p>";
    echo "<p>Pastikan:</p>";
    echo "<ul>";
    echo "<li>MySQL service sudah running</li>";
    echo "<li>Database 'sia' sudah dibuat</li>";
    echo "<li>Username/password database benar</li>";
    echo "</ul>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f5f5f5;
}

h2, h3 {
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
}

ul {
    background: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

p {
    background: white;
    padding: 10px;
    border-radius: 5px;
    margin: 5px 0;
}
</style>
