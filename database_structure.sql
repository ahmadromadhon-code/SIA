-- Struktur Database SIA yang sesuai dengan requirement
-- Tabel: admin, guru, jadwal, kelas, mapel, nilai, presensi, siswa, tahun_ajaran

-- Tabel admin
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel guru
CREATE TABLE `guru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel kelas
CREATE TABLE `kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` varchar(10) DEFAULT NULL,
  `wali_kelas_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wali_kelas_id` (`wali_kelas_id`),
  FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel mapel
CREATE TABLE `mapel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel tahun_ajaran
CREATE TABLE `tahun_ajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(20) NOT NULL,
  `tahun_mulai` year DEFAULT NULL,
  `tahun_selesai` year DEFAULT NULL,
  `status` enum('aktif','tidak_aktif') DEFAULT 'tidak_aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel siswa
CREATE TABLE `siswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `nis` (`nis`),
  KEY `kelas_id` (`kelas_id`),
  FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel jadwal
CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kelas_id` int(11) DEFAULT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_id` (`kelas_id`),
  KEY `mapel_id` (`mapel_id`),
  KEY `guru_id` (`guru_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`),
  FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`),
  FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`),
  FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel nilai
CREATE TABLE `nilai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siswa_id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `jenis` enum('uts','uas','tugas','sikap') NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `jadwal_id` (`jadwal_id`),
  KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`),
  FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`),
  FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel presensi
CREATE TABLE `presensi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siswa_id` int(11) DEFAULT NULL,
  `jadwal_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `semester` enum('Ganjil','Genap') DEFAULT NULL,
  `pertemuan` int(11) NOT NULL,
  `keterangan` enum('hadir','izin','sakit','alfa') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `jadwal_id` (`jadwal_id`),
  FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`),
  FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
