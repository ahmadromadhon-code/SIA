-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2025 at 03:23 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sia`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator Sistem');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `username`, `password`, `no_hp`, `alamat`) VALUES
(1, '198501012010011001', 'Budi Santoso, S.Pd', 'budi', '9310f83135f238b04af729fec041cca8', '081234567890', 'Jl. Pendidikan No. 1'),
(2, '198702152011012002', 'Sari Dewi, S.Pd', 'sari', '9310f83135f238b04af729fec041cca8', '081234567891', 'Jl. Guru No. 2'),
(3, '198903202012013003', 'Ahmad Fauzi, S.Pd', 'ahmad', '9310f83135f238b04af729fec041cca8', '081234567892', 'Jl. Ilmu No. 3');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `kelas_id`, `mapel_id`, `guru_id`, `tahun_ajaran_id`, `semester`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 1, 1, 1, 1, 'Ganjil', 'Senin', '07:30:00', '09:00:00'),
(2, 1, 2, 2, 1, 'Ganjil', 'Senin', '09:15:00', '10:45:00'),
(3, 1, 3, 3, 1, 'Ganjil', 'Selasa', '07:30:00', '09:00:00'),
(4, 2, 1, 1, 1, 'Ganjil', 'Selasa', '09:15:00', '10:45:00'),
(5, 2, 2, 2, 1, 'Ganjil', 'Rabu', '07:30:00', '09:00:00'),
(6, 1, 4, 1, 1, 'Ganjil', 'Rabu', '09:15:00', '10:45:00'),
(7, 1, 5, 3, 1, 'Ganjil', 'Kamis', '07:30:00', '09:00:00'),
(8, 2, 3, 3, 1, 'Ganjil', 'Kamis', '09:15:00', '10:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `wali_kelas_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `wali_kelas_id`) VALUES
(1, 'X IPA 1', 1),
(2, 'X IPA 2', 2),
(3, 'XI IPA 1', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id`, `nama_mapel`) VALUES
(1, 'Matematika'),
(2, 'Bahasa Indonesia'),
(3, 'Fisika'),
(4, 'Kimia'),
(5, 'Biologi'),
(6, 'Bahasa Inggris'),
(7, 'Sejarah'),
(8, 'Geografi'),
(9, 'Ekonomi'),
(10, 'Sosiologi');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `jenis` enum('uts','uas','tugas','sikap') NOT NULL,
  `nilai` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `siswa_id`, `jadwal_id`, `tahun_ajaran_id`, `semester`, `jenis`, `nilai`) VALUES
(1, 1, 1, 1, 'Ganjil', 'uts', '85.00'),
(2, 1, 1, 1, 'Ganjil', 'uas', '88.00'),
(3, 1, 1, 1, 'Ganjil', 'tugas', '90.00'),
(4, 1, 1, 1, 'Ganjil', 'sikap', '85.00'),
(5, 2, 1, 1, 'Ganjil', 'uts', '78.00'),
(6, 2, 1, 1, 'Ganjil', 'uas', '82.00'),
(7, 2, 1, 1, 'Ganjil', 'tugas', '85.00'),
(8, 2, 1, 1, 'Ganjil', 'sikap', '88.00');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `jadwal_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `semester` enum('Ganjil','Genap') DEFAULT NULL,
  `pertemuan` int(11) NOT NULL,
  `keterangan` enum('hadir','izin','sakit','alfa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `siswa_id`, `jadwal_id`, `tanggal`, `semester`, `pertemuan`, `keterangan`) VALUES
(1, 1, 1, '2025-01-15', 'Ganjil', 1, 'hadir'),
(2, 1, 1, '2025-01-22', 'Ganjil', 2, 'hadir'),
(3, 1, 1, '2025-01-29', 'Ganjil', 3, 'sakit'),
(4, 2, 1, '2025-01-15', 'Ganjil', 1, 'hadir'),
(5, 2, 1, '2025-01-22', 'Ganjil', 2, 'hadir'),
(6, 2, 1, '2025-01-29', 'Ganjil', 3, 'hadir');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `username`, `password`, `kelas_id`, `jenis_kelamin`, `tanggal_lahir`, `alamat`) VALUES
(1, '2025001', 'Andi Pratama', 'andi', '3afa0d81296a4f17d477ec823261b1ec', 1, 'L', '2008-01-15', 'Jl. Siswa No. 1'),
(2, '2025002', 'Siti Nurhaliza', 'siti', '3afa0d81296a4f17d477ec823261b1ec', 1, 'P', '2008-02-20', 'Jl. Siswa No. 2'),
(3, '2025003', 'Rudi Hermawan', 'rudi', '3afa0d81296a4f17d477ec823261b1ec', 2, 'L', '2008-03-10', 'Jl. Siswa No. 3'),
(4, '2025004', 'Maya Sari', 'maya', '3afa0d81296a4f17d477ec823261b1ec', 2, 'P', '2008-04-05', 'Jl. Siswa No. 4');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `nama`) VALUES
(1, '2025/2026');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `mapel_id` (`mapel_id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wali_kelas_id` (`wali_kelas_id`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `jadwal_id` (`jadwal_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_id` (`siswa_id`,`jadwal_id`,`pertemuan`),
  ADD KEY `jadwal_id` (`jadwal_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_4` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`),
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`);

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presensi_ibfk_2` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
