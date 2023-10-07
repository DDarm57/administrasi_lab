-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2022 at 03:40 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `aslab`
--

CREATE TABLE `aslab` (
  `id_aslab` int(11) NOT NULL,
  `nama_aslab` varchar(100) NOT NULL,
  `email_aslab` varchar(100) NOT NULL,
  `password_aslab` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aslab`
--

INSERT INTO `aslab` (`id_aslab`, `nama_aslab`, `email_aslab`, `password_aslab`, `role`) VALUES
(1, 'aslab2', 'aslab2@gmail.com', '12345', 'aslab'),
(5, 'Walid', 'walid@gmail.com', '123', 'aslab');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `nip` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `nip`) VALUES
(7, 'Rahman Hadi, S.Pd', '192209399212283'),
(10, 'Didik Purwo S.Pd', '192083488398238'),
(12, 'Guru Siskom', ''),
(13, 'Guru Jaringan', '');

-- --------------------------------------------------------

--
-- Table structure for table `guru_mengajar`
--

CREATE TABLE `guru_mengajar` (
  `id_guruM` int(11) NOT NULL,
  `id_jam` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru_mengajar`
--

INSERT INTO `guru_mengajar` (`id_guruM`, `id_jam`, `id_guru`, `id_kelas`, `id_mapel`, `id_tahun`) VALUES
(27, 18, 7, 7, 8, 1),
(28, 19, 7, 8, 8, 1),
(30, 18, 10, 7, 12, 1),
(31, 19, 10, 8, 12, 1),
(32, 20, 7, 9, 8, 1),
(33, 21, 10, 9, 12, 1),
(34, 20, 12, 7, 5, 1),
(35, 21, 12, 8, 5, 1),
(38, 18, 7, 7, 8, 2),
(39, 19, 7, 8, 8, 2),
(40, 18, 10, 7, 12, 2),
(41, 19, 10, 8, 12, 2),
(48, 20, 7, 8, 3, 2),
(51, 20, 12, 8, 5, 2),
(52, 18, 12, 8, 5, 2),
(53, 19, 10, 7, 6, 2),
(54, 18, 10, 8, 7, 2),
(57, 18, 12, 7, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id_inventaris` int(11) NOT NULL,
  `id_aslab` int(11) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `nama_inventaris` varchar(100) NOT NULL,
  `jumlah` varchar(20) NOT NULL,
  `kondisi` varchar(100) NOT NULL,
  `tahun_pengadaan` varchar(20) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id_inventaris`, `id_aslab`, `kode`, `nama_inventaris`, `jumlah`, `kondisi`, `tahun_pengadaan`, `created_at`) VALUES
(1, 1, 'INV0020392022', 'laptop', '2', 'normal', '2022', '2022-08-17'),
(2, 1, 'InvTGQ1hm0xAY2022', 'Komputer', '5', 'Baik', '2022', '2022-08-17'),
(4, 1, 'InvQtx5IzkTXH2022', 'monitor', '20', 'Baik', '2022', '2022-08-17'),
(5, 5, 'InvOtrsBIsEjQ2022', 'kursi', '20', 'Baik', '2022', '2022-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL,
  `id_guruM` int(11) NOT NULL,
  `hari` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_ruangan`, `id_guruM`, `hari`) VALUES
(39, 8, 27, 'Senin'),
(40, 8, 28, 'Senin'),
(42, 9, 30, 'Senin'),
(43, 9, 31, 'Senin'),
(44, 8, 32, 'Senin'),
(45, 8, 33, 'Senin'),
(46, 9, 34, 'Senin'),
(47, 9, 35, 'Senin'),
(50, 8, 38, 'Senin'),
(51, 8, 39, 'Senin'),
(52, 9, 40, 'Senin'),
(53, 9, 41, 'Senin'),
(60, 8, 48, 'Senin'),
(63, 9, 51, 'Senin'),
(64, 8, 52, 'Selasa'),
(65, 8, 53, 'Selasa'),
(66, 9, 54, 'Selasa');

-- --------------------------------------------------------

--
-- Table structure for table `jam`
--

CREATE TABLE `jam` (
  `id_jam` int(11) NOT NULL,
  `jam_mulai` varchar(100) NOT NULL,
  `jam_selesai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jam`
--

INSERT INTO `jam` (`id_jam`, `jam_mulai`, `jam_selesai`) VALUES
(18, '07:30', '08:30'),
(19, '08:30', '09:30'),
(20, '10:00', '11:00'),
(21, '11:00', '12:00');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`) VALUES
(7, 'X'),
(8, 'XI'),
(9, 'XII');

-- --------------------------------------------------------

--
-- Table structure for table `ketua_jurusan`
--

CREATE TABLE `ketua_jurusan` (
  `id_kajur` int(11) NOT NULL,
  `nama_kajur` varchar(100) NOT NULL,
  `email_kajur` varchar(100) NOT NULL,
  `password_kajur` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ketua_jurusan`
--

INSERT INTO `ketua_jurusan` (`id_kajur`, `nama_kajur`, `email_kajur`, `password_kajur`, `role`) VALUES
(1, 'Contoh Name Kajur', 'kajur@gmail.com', '12345', 'kajur');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`) VALUES
(2, 'setting mikrotik'),
(3, 'Rekayasa Perangkat Lunak'),
(4, 'Simulasi digital'),
(5, 'Siskom'),
(6, 'Komputer Dan Jaringan Dasar'),
(7, 'Pemrograman Dasar'),
(8, 'Desain Grafis'),
(9, 'Teknologi Jaringan Wan'),
(10, 'Infrastrutur Jaringan'),
(11, 'Sistem Jaringan'),
(12, 'Web');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`) VALUES
(8, 'lab 1'),
(9, 'lab 2');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `id_tahun` int(11) NOT NULL,
  `tahun` varchar(100) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`id_tahun`, `tahun`, `semester`, `status`) VALUES
(1, '2022', 'Genap', 'tidak aktif'),
(2, '2023', 'Gasal', 'aktif'),
(3, '2023', 'Genap', 'tidak aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aslab`
--
ALTER TABLE `aslab`
  ADD PRIMARY KEY (`id_aslab`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `guru_mengajar`
--
ALTER TABLE `guru_mengajar`
  ADD PRIMARY KEY (`id_guruM`),
  ADD KEY `id_jam` (`id_jam`,`id_guru`,`id_kelas`,`id_mapel`),
  ADD KEY `guru_mengajar_ibfk_1` (`id_guru`),
  ADD KEY `guru_mengajar_ibfk_3` (`id_kelas`),
  ADD KEY `guru_mengajar_ibfk_4` (`id_mapel`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id_inventaris`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_ruangan` (`id_ruangan`),
  ADD KEY `id_guruM` (`id_guruM`);

--
-- Indexes for table `jam`
--
ALTER TABLE `jam`
  ADD PRIMARY KEY (`id_jam`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `ketua_jurusan`
--
ALTER TABLE `ketua_jurusan`
  ADD PRIMARY KEY (`id_kajur`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  ADD PRIMARY KEY (`id_tahun`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aslab`
--
ALTER TABLE `aslab`
  MODIFY `id_aslab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `guru_mengajar`
--
ALTER TABLE `guru_mengajar`
  MODIFY `id_guruM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id_inventaris` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `jam`
--
ALTER TABLE `jam`
  MODIFY `id_jam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ketua_jurusan`
--
ALTER TABLE `ketua_jurusan`
  MODIFY `id_kajur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `id_tahun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru_mengajar`
--
ALTER TABLE `guru_mengajar`
  ADD CONSTRAINT `guru_mengajar_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`),
  ADD CONSTRAINT `guru_mengajar_ibfk_2` FOREIGN KEY (`id_jam`) REFERENCES `jam` (`id_jam`),
  ADD CONSTRAINT `guru_mengajar_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `guru_mengajar_ibfk_4` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`);

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_guruM`) REFERENCES `guru_mengajar` (`id_guruM`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
