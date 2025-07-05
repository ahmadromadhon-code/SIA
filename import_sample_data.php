<?php
// Script untuk import sample data ke database SIA
// Jalankan: http://localhost/SIA/import_sample_data.php

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sia';

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Import Sample Data SIA</h2>";
    
    // Baca file sample data
    $sql_file = 'sample_data_correct.sql';
    if (!file_exists($sql_file)) {
        throw new Exception("File $sql_file tidak ditemukan!");
    }
    
    $sql_content = file_get_contents($sql_file);
    
    // Pisahkan query berdasarkan semicolon
    $queries = explode(';', $sql_content);
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($queries as $query) {
        $query = trim($query);
        
        // Skip query kosong atau komentar
        if (empty($query) || strpos($query, '--') === 0) {
            continue;
        }
        
        try {
            $pdo->exec($query);
            $success_count++;
            echo "<p style='color: green;'>✅ Query berhasil: " . substr($query, 0, 50) . "...</p>";
        } catch (PDOException $e) {
            $error_count++;
            echo "<p style='color: orange;'>⚠️ Query skip (mungkin data sudah ada): " . substr($query, 0, 50) . "...</p>";
            echo "<small style='color: gray;'>Error: " . $e->getMessage() . "</small><br>";
        }
    }
    
    echo "<hr>";
    echo "<h3>Hasil Import:</h3>";
    echo "<p><strong>Query berhasil:</strong> $success_count</p>";
    echo "<p><strong>Query skip:</strong> $error_count</p>";
    
    // Cek data yang berhasil diimport
    echo "<h3>Data yang berhasil diimport:</h3>";
    
    $tables = ['admin', 'guru', 'siswa', 'kelas', 'mapel', 'tahun_ajaran', 'jadwal', 'nilai', 'presensi'];
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "<p>📊 <strong>$table:</strong> $count record(s)</p>";
        } catch (PDOException $e) {
            echo "<p style='color: red;'>❌ Error pada tabel $table: " . $e->getMessage() . "</p>";
        }
    }
    
    echo "<hr>";
    echo "<p style='color: green; font-weight: bold;'>✅ Import selesai!</p>";
    echo "<p><a href='index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Akses Aplikasi</a></p>";
    echo "<p><a href='test_connection.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Test Koneksi</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
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

p {
    background: white;
    padding: 10px;
    border-radius: 5px;
    margin: 5px 0;
}

small {
    display: block;
    margin-left: 20px;
}
</style>
