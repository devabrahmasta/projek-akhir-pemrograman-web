-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 03:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_powergym`
--

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `instruktur` varchar(100) DEFAULT NULL,
  `image_instruktur` varchar(255) DEFAULT NULL,
  `image_kelas` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `rating` float DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `judul`, `kategori`, `deskripsi`, `instruktur`, `image_instruktur`, `image_kelas`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `rating`) VALUES
(1, 'Morning Flow Yoga', 'Yoga', 'Awali hari dengan ketenangan dan fleksibilitas.', 'Sarah W.', 'https://randomuser.me/api/portraits/women/44.jpg', 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?q=80&w=600&auto=format&fit=crop', '2025-11-26', '07:00:00', '08:00:00', 4.8),
(2, 'Zumba Party Blast', 'Zumba', 'Bakar kalori dengan tarian latin yang energik.', 'Rina S.', 'https://randomuser.me/api/portraits/women/65.jpg', 'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=600&auto=format&fit=crop', '2025-11-26', '18:30:00', '19:30:00', 5),
(3, 'Core Pilates', 'Pilates', 'Fokus pada kekuatan otot inti dan postur tubuh.', 'Jessica L.', 'https://randomuser.me/api/portraits/women/32.jpg', 'https://images.unsplash.com/photo-1518310383802-640c2de311b2?q=80&w=600&auto=format&fit=crop', '2025-11-27', '09:00:00', '10:00:00', 4.9),
(4, 'Body Combat Warrior', 'Body Combat', 'Latihan kardio intensif terinspirasi bela diri.', 'Budi Hartono', 'https://randomuser.me/api/portraits/men/45.jpg', 'https://images.unsplash.com/photo-1599058945522-28d584b6f0ff?q=80&w=600&auto=format&fit=crop', '2025-11-27', '19:00:00', '20:00:00', 4.7);

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `id_membership` int(3) NOT NULL,
  `id_trainer` int(3) DEFAULT NULL,
  `id_pelanggan` int(3) NOT NULL,
  `id_paket` int(3) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `harga` decimal(50,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id_membership`, `id_trainer`, `id_pelanggan`, `id_paket`, `tgl_mulai`, `harga`) VALUES
(5, 2, 32, 2, '2025-11-23', 175000),
(6, 3, 32, 2, '2025-11-23', 175000),
(7, 4, 32, 1, '2025-11-23', 80000),
(8, 1, 33, 1, '2025-11-23', 80000),
(11, NULL, 34, 1, '2025-11-24', 80000),
(12, NULL, 35, 5, '2025-11-24', 1400000),
(13, NULL, 35, 5, '2025-11-24', 1400000),
(14, NULL, 35, 4, '2025-11-24', 760000),
(15, 5, 34, 1, '2025-11-25', 80000);

-- --------------------------------------------------------

--
-- Table structure for table `paket_member`
--

CREATE TABLE `paket_member` (
  `id_paket` int(3) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `durasi` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_member`
--

INSERT INTO `paket_member` (`id_paket`, `deskripsi`, `harga`, `durasi`) VALUES
(1, 'Paket 1 Minggu', 80000, 7),
(2, 'Paket 1 Bulan', 175000, 30),
(3, 'Paket 3 Bulan', 400000, 90),
(4, 'Paket 6 Bulan', 760000, 180),
(5, 'Paket 1 Tahun', 1400000, 365);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(3) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `testimoni` varchar(300) DEFAULT NULL,
  `tanggal_testimoni` date DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `no_hp`, `gender`, `testimoni`, `tanggal_testimoni`, `username`, `password`) VALUES
(32, 'lintang', '08880888808', 'Laki-laki', NULL, NULL, 'lintang', '$2y$10$NE20N6O9GZk/7WvLxG12ZeXVf8SqPv7dnMDo/mpuhGTQcaD1VPATu'),
(33, 'a', 'a', 'Laki-laki', 'Bagus banget waw, aku terkesima, alatnya lenlgkap bagus, perawatannya keren. juga disediakan handuk dan kamar mandinya bersih', '2025-11-24', 'a', '$2y$10$kQaJ5eTHFVg5P7PR0BQd8u/buQOMLEW2UT1Z/iMOmkSP7fuCnr91O'),
(34, 'b', 'b', 'Laki-laki', NULL, NULL, 'b', '$2y$10$FpKlG59w0Hf85gidi/2BVeH5KCcchA9a7pULn0ZBa.Pj6aFNIx0kG'),
(35, 'Yusfi Akizen', '08123123812', 'Laki-laki', 'Buat saya yang penting itu kebersihan, dan gym ini juara sih. Area latihan bersih, alat-alat terawat nggak berkarat, jadi enak, nggak was-was soal higienitas.', '2025-11-24', 'zenbuw', '$2y$10$R9wYoWZ1oj94Zelkfr.OhuB1uOYp6gup8RJPQQcqeYxtb2XcXsRHq'),
(36, 'Kirito Chan', '082123417293', 'Laki-laki', 'Bagus banget waw, aku terkesima, alatnya lenlgkap bagus, perawatannya keren. juga disediakan handuk dan kamar mandinya bersih.', '2025-11-24', 'kiritochan', '$2y$10$d1.TR/Hu3XRK0QatBxOf8OtlrClTslm./9.lFIuAVIF0y9wdRD0Au'),
(37, 'Aditya Pratama', '081234567890', 'Laki-laki', 'Alat-alatnya lengkap banget! Terutama bagian free weight, dumbell-nya solid. Suasana juga asik buat fokus latihan.', '2025-11-24', 'adityasixpack', '$2y$10$l1Z.ykEQpKTHILcp8NjH3e2.DTURU0c5mGw7mcu0KzpTyPY1Y2ZDa'),
(38, 'Sinta Nurhaliza', '081298765432', 'Perempuan', 'Seneng banget ada area khusus cardio yang bersih dan AC-nya dingin. Coach-nya juga ramah-ramah kalau ditanyain.', '2025-11-24', 'sintafit', '$2y$10$HWAx88ChUwp8ES8aDc39pOBnQag5WM3rFh6spF.MclIM5YGZmKno2'),
(39, 'Fitri Handayani', '081398765412', 'Perempuan', 'Awalnya ragu mau nge-gym malu, tapi di sini vibes-nya positif banget. Nggak ada yang judging, semua saling support!', '2025-11-24', 'fitripower', '$2y$10$Rrks0VEuNuCbi6A0J3O.7ODM3WVaPbwT2LQKYf4DeUtRfLuwtLdoC'),
(40, 'Putri Sartini', '08182436172', 'Perempuan', 'Gym-nya keren, estetik dan bersih', '2025-11-24', 'baru', '$2y$10$u40sBsGNOOBLlgtMXxp2m.qMc4QeRmiloxZdQLqUxMfvWq0Mf0eUi');

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

CREATE TABLE `trainer` (
  `nama` varchar(200) NOT NULL,
  `id_trainer` int(3) NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `status` enum('DISEWA','TIDAK DISEWA') NOT NULL DEFAULT 'TIDAK DISEWA',
  `image` varchar(225) NOT NULL,
  `spesialisasi` enum('Body Building','Fat Loss Expert','Yoga Specialist','Functional Coach') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`nama`, `id_trainer`, `gender`, `no_hp`, `status`, `image`, `spesialisasi`) VALUES
('Rizky Pratama', 1, 'Laki-laki', '081234567890', 'TIDAK DISEWA', 'https://images.unsplash.com/photo-1579758629938-03607ccdbaba?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Body Building'),
('Andi Saputra', 2, 'Laki-laki', '081298765432', 'TIDAK DISEWA', 'https://images.unsplash.com/photo-1628935291759-bbaf33a66dc6?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Body Building'),
('Dewi Lestari', 3, 'Perempuan', '082134567890', 'TIDAK DISEWA', 'https://images.unsplash.com/photo-1606902965551-dce093cda6e7?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Yoga Specialist'),
('Siti Rahmawati', 4, 'Perempuan', '085612345678', 'TIDAK DISEWA', 'https://images.unsplash.com/photo-1697060657705-be2e85f7bff2?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Fat Loss Expert'),
('Yoga Prabowo', 5, 'Laki-laki', '087812345679', 'TIDAK DISEWA', 'https://images.unsplash.com/photo-1619361728853-2542f3864532?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Functional Coach');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_membership` int(11) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `nominal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_membership`, `tanggal_transaksi`, `nominal`) VALUES
(1, 5, '2025-11-23', 775000.00),
(2, 6, '2025-11-23', 775000.00),
(3, 7, '2025-11-23', 220000.00),
(4, 8, '2025-11-23', 220000.00),
(7, 11, '2025-11-24', 80000.00),
(8, 12, '2025-11-24', 1400000.00),
(9, 13, '2025-11-24', 1400000.00),
(10, 14, '2025-11-24', 760000.00),
(11, 15, '2025-11-25', 220000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id_membership`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_trainer` (`id_trainer`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indexes for table `paket_member`
--
ALTER TABLE `paket_member`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `trainer`
--
ALTER TABLE `trainer`
  ADD PRIMARY KEY (`id_trainer`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_membership` (`id_membership`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id_membership` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `paket_member`
--
ALTER TABLE `paket_member`
  MODIFY `id_paket` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `trainer`
--
ALTER TABLE `trainer`
  MODIFY `id_trainer` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `id_paket` FOREIGN KEY (`id_paket`) REFERENCES `paket_member` (`id_paket`),
  ADD CONSTRAINT `id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `id_trainer` FOREIGN KEY (`id_trainer`) REFERENCES `trainer` (`id_trainer`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `id_membership` FOREIGN KEY (`id_membership`) REFERENCES `membership` (`id_membership`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
