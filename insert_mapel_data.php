<?php
// Script untuk insert data mata pelajaran langsung
// Jalankan: http://localhost/SIA/insert_mapel_data.php

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sia';

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Insert Data Mata Pelajaran</h2>";
    
    // Data mata pelajaran sesuai struktur database (hanya id dan nama_mapel)
    $mapel_data = [
        [1, 'Matematika'],
        [2, 'Bahasa Indonesia'],
        [3, 'Fisika'],
        [4, 'Kimia'],
        [5, 'Biologi'],
        [6, 'Bahasa Inggris'],
        [7, 'Sejarah'],
        [8, 'Geografi'],
        [9, 'Ekonomi'],
        [10, 'Sosiologi']
    ];
    
    // Insert data mata pelajaran
    $stmt = $pdo->prepare("INSERT IGNORE INTO mapel (id, nama_mapel) VALUES (?, ?)");
    
    $success_count = 0;
    foreach ($mapel_data as $mapel) {
        try {
            $stmt->execute($mapel);
            if ($stmt->rowCount() > 0) {
                $success_count++;
                echo "<p style='color: green;'>✅ Berhasil insert: {$mapel[1]}</p>";
            } else {
                echo "<p style='color: orange;'>⚠️ Data sudah ada: {$mapel[1]}</p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color: red;'>❌ Error insert {$mapel[1]}: " . $e->getMessage() . "</p>";
        }
    }
    
    // Cek total data
    $stmt = $pdo->query("SELECT COUNT(*) FROM mapel");
    $total = $stmt->fetchColumn();
    
    echo "<hr>";
    echo "<h3>Hasil:</h3>";
    echo "<p><strong>Data baru diinsert:</strong> $success_count</p>";
    echo "<p><strong>Total data mata pelajaran:</strong> $total</p>";
    
    // Tampilkan semua data
    echo "<h3>Daftar Mata Pelajaran:</h3>";
    $stmt = $pdo->query("SELECT * FROM mapel ORDER BY id");
    $mapels = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%; background: white;'>";
    echo "<tr style='background: #007bff; color: white;'><th>ID</th><th>Nama Mata Pelajaran</th></tr>";
    
    foreach ($mapels as $mapel) {
        echo "<tr>";
        echo "<td style='padding: 8px; text-align: center;'>{$mapel['id']}</td>";
        echo "<td style='padding: 8px;'>{$mapel['nama_mapel']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<hr>";
    echo "<p style='color: green; font-weight: bold;'>✅ Insert data mata pelajaran selesai!</p>";
    echo "<p><a href='admin/mata_pelajaran' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Lihat Data Mata Pelajaran</a></p>";
    echo "<p><a href='index.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Kembali ke Aplikasi</a></p>";
    
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

table {
    margin: 10px 0;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

th, td {
    border: 1px solid #ddd;
}
</style>
