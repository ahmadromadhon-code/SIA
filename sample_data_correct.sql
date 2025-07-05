-- Sample data untuk testing Sistem Informasi Akademik
-- SESUAI STRUKTUR DATABASE YANG ADA - TIDAK MENGUBAH FIELD APAPUN

-- Insert data admin
INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', MD5('admin123'), 'Administrator Sistem');

-- Insert data guru
INSERT INTO `guru` (`id`, `nip`, `nama`, `username`, `password`, `no_hp`, `alamat`) VALUES
(1, '198501012010011001', 'Budi Santoso, S.Pd', 'budi', MD5('guru123'), '081234567890', 'Jl. Pendidikan No. 1'),
(2, '198702152011012002', 'Sari Dewi, S.Pd', 'sari', MD5('guru123'), '081234567891', 'Jl. Guru No. 2'),
(3, '198903202012013003', 'Ahmad Fauzi, S.Pd', 'ahmad', MD5('guru123'), '081234567892', 'Jl. Ilmu No. 3');

-- Insert data kelas (hanya: id, nama_kelas, wali_kelas_id)
INSERT INTO `kelas` (`id`, `nama_kelas`, `wali_kelas_id`) VALUES
(1, 'X IPA 1', 1),
(2, 'X IPA 2', 2),
(3, 'XI IPA 1', 3);

-- Insert data mata pelajaran (hanya: id, nama_mapel)
INSERT INTO `mapel` (`id`, `nama_mapel`) VALUES
(1, 'Matematika'),
(2, 'Bahasa Indonesia'),
(3, 'Fisika'),
(4, 'Kimia'),
(5, 'Biologi');

-- Insert data siswa
INSERT INTO `siswa` (`id`, `nis`, `nama`, `username`, `password`, `kelas_id`, `jenis_kelamin`, `tanggal_lahir`, `alamat`) VALUES
(1, '2025001', 'Andi Pratama', 'andi', MD5('siswa123'), 1, 'L', '2008-01-15', 'Jl. Siswa No. 1'),
(2, '2025002', 'Siti Nurhaliza', 'siti', MD5('siswa123'), 1, 'P', '2008-02-20', 'Jl. Siswa No. 2'),
(3, '2025003', 'Rudi Hermawan', 'rudi', MD5('siswa123'), 2, 'L', '2008-03-10', 'Jl. Siswa No. 3'),
(4, '2025004', 'Maya Sari', 'maya', MD5('siswa123'), 2, 'P', '2008-04-05', 'Jl. Siswa No. 4');

-- Insert data tahun ajaran (hanya: id, nama)
INSERT INTO `tahun_ajaran` (`id`, `nama`) VALUES
(1, '2025/2026');

-- Insert data jadwal
INSERT INTO `jadwal` (`id`, `kelas_id`, `mapel_id`, `guru_id`, `tahun_ajaran_id`, `semester`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 1, 1, 1, 1, 'Ganjil', 'Senin', '07:30:00', '09:00:00'),
(2, 1, 2, 2, 1, 'Ganjil', 'Senin', '09:15:00', '10:45:00'),
(3, 1, 3, 3, 1, 'Ganjil', 'Selasa', '07:30:00', '09:00:00'),
(4, 2, 1, 1, 1, 'Ganjil', 'Selasa', '09:15:00', '10:45:00'),
(5, 2, 2, 2, 1, 'Ganjil', 'Rabu', '07:30:00', '09:00:00'),
(6, 1, 4, 1, 1, 'Ganjil', 'Rabu', '09:15:00', '10:45:00'),
(7, 1, 5, 3, 1, 'Ganjil', 'Kamis', '07:30:00', '09:00:00'),
(8, 2, 3, 3, 1, 'Ganjil', 'Kamis', '09:15:00', '10:45:00');

-- Insert sample nilai
INSERT INTO `nilai` (`id`, `siswa_id`, `jadwal_id`, `tahun_ajaran_id`, `semester`, `jenis`, `nilai`) VALUES
(1, 1, 1, 1, 'Ganjil', 'uts', 85.00),
(2, 1, 1, 1, 'Ganjil', 'uas', 88.00),
(3, 1, 1, 1, 'Ganjil', 'tugas', 90.00),
(4, 1, 1, 1, 'Ganjil', 'sikap', 85.00),
(5, 2, 1, 1, 'Ganjil', 'uts', 78.00),
(6, 2, 1, 1, 'Ganjil', 'uas', 82.00),
(7, 2, 1, 1, 'Ganjil', 'tugas', 85.00),
(8, 2, 1, 1, 'Ganjil', 'sikap', 88.00);

-- Insert sample presensi
INSERT INTO `presensi` (`id`, `siswa_id`, `jadwal_id`, `tanggal`, `semester`, `pertemuan`, `keterangan`) VALUES
(1, 1, 1, '2025-01-15', 'Ganjil', 1, 'hadir'),
(2, 1, 1, '2025-01-22', 'Ganjil', 2, 'hadir'),
(3, 1, 1, '2025-01-29', 'Ganjil', 3, 'sakit'),
(4, 2, 1, '2025-01-15', 'Ganjil', 1, 'hadir'),
(5, 2, 1, '2025-01-22', 'Ganjil', 2, 'hadir'),
(6, 2, 1, '2025-01-29', 'Ganjil', 3, 'hadir');
