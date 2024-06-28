-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 09:27 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `potlot_galeri`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`, `updated_at`) VALUES
('admin@gmail.com', '$2y$10$kjIc8WbWCd6JEHzs3iG8vusitvJ.YUKtzw1ohOFjUPtn2xVAWX7F2', '2022-09-27 06:09:52', '2022-09-27 13:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cart`
--

CREATE TABLE `tb_cart` (
  `id` int(11) NOT NULL,
  `id_gambar` int(11) DEFAULT NULL,
  `id_cust` int(11) DEFAULT NULL,
  `id_pemasar` int(11) DEFAULT NULL,
  `harga` float DEFAULT 0,
  `promo` int(11) DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pesan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_cart`
--

INSERT INTO `tb_cart` (`id`, `id_gambar`, `id_cust`, `id_pemasar`, `harga`, `promo`, `status`, `created_at`, `updated_at`) VALUES
(14, 26, 9, 12, 200, 0, 'dibayar', '2023-05-23 15:24:41', '2023-05-23 15:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `tb_custom`
--

CREATE TABLE `tb_custom` (
  `id` int(11) NOT NULL,
  `id_pemasar` int(11) DEFAULT NULL,
  `id_cust` int(11) DEFAULT NULL,
  `sampel` text DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `canvas` int(11) DEFAULT NULL,
  `harga` float DEFAULT 0,
  `gambar1` varchar(255) DEFAULT NULL,
  `gambar2` varchar(255) DEFAULT NULL,
  `gambar3` varchar(255) DEFAULT NULL,
  `gambar4` varchar(255) DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `rate` int(1) DEFAULT 0,
  `koment` text DEFAULT NULL,
  `status` varchar(55) DEFAULT 'pesan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_custom`
--

INSERT INTO `tb_custom` (`id`, `id_pemasar`, `id_cust`, `sampel`, `nama`, `canvas`, `harga`, `gambar1`, `gambar2`, `gambar3`, `gambar4`, `media`, `rate`, `koment`, `status`, `created_at`, `updated_at`) VALUES
(10, 12, 9, '1684848554.jpg', 'derby', 46, 100, NULL, NULL, NULL, NULL, 'kayu', 0, NULL, 'dibayar', '2023-05-23 13:29:14', '2023-05-23 13:29:14'),
(11, 12, 9, '1684855084.jpg', 'Wisuda', 79, 100, '1684855244.jpg', '1684855303.jpg', '1684855329.jpg', NULL, 'canvas', 5, 'bagus', 'dibayar', '2023-05-23 15:18:04', '2023-05-23 15:18:04');

-- --------------------------------------------------------

--
-- Table structure for table `tb_custom_chat`
--

CREATE TABLE `tb_custom_chat` (
  `id_custom` int(11) DEFAULT NULL,
  `id_pengirim` int(11) DEFAULT NULL,
  `id_penerima` int(11) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_custom_chat`
--

INSERT INTO `tb_custom_chat` (`id_custom`, `id_pengirim`, `id_penerima`, `isi`, `created_at`) VALUES
(3, 6, 7, 'rego 11000', '2022-12-11 12:59:56'),
(10, 9, 12, 'berapa mas', '2023-05-23 14:10:56'),
(10, 12, 9, '100', '2023-05-23 14:11:20'),
(10, 9, 12, 'ok', '2023-05-23 14:11:32'),
(11, 9, 12, 'berapa mas', '2023-05-23 15:18:27'),
(11, 12, 9, '100k', '2023-05-23 15:19:03'),
(11, 9, 12, 'Mas ada revisi, warna hijabny hitam', '2023-05-23 15:20:12'),
(11, 9, 12, 'kurang hitam mas', '2023-05-23 15:21:20'),
(11, 9, 12, 'ok', '2023-05-23 15:22:51');

-- --------------------------------------------------------

--
-- Table structure for table `tb_gaji`
--

CREATE TABLE `tb_gaji` (
  `id_user` int(11) DEFAULT NULL,
  `gaji` int(11) DEFAULT NULL,
  `tgl_gaji` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_gaji`
--

INSERT INTO `tb_gaji` (`id_user`, `gaji`, `tgl_gaji`) VALUES
(1, 1, '2022-12-20 21:00:12'),
(1, 1, '2022-12-20 21:45:50'),
(1, 200, '2022-12-20 21:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_gambar`
--

CREATE TABLE `tb_gambar` (
  `id` int(11) NOT NULL,
  `gambar` text DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `promo` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_gambar`
--

INSERT INTO `tb_gambar` (`id`, `gambar`, `nama`, `keterangan`, `harga`, `kategori`, `promo`, `created_at`, `updated_at`) VALUES
(27, '1685969165.jpg', 'Hutan Amazon', 'Keindahan Hutan', 2000, NULL, 0, '2023-06-05 12:46:05', '2023-06-05 12:46:05'),
(28, '1685969412.jpg', 'Hutan Cempaka', 'Hutan Indonesia', 500, NULL, 0, '2023-06-05 12:50:12', '2023-06-05 12:50:12'),
(29, '1685969469.jpg', 'Hutan Mangrove', 'Hutan di surabaya', 500, NULL, 0, '2023-06-05 12:51:09', '2023-06-05 12:51:09'),
(30, '1685969562.jpg', 'Hutan Tropis', 'Keindahan Alam Mempesona', 500, NULL, 0, '2023-06-05 12:52:42', '2023-06-05 12:52:42'),
(31, '1685969723.jpg', 'Leopard', 'Hewan Liar', 1000, NULL, 0, '2023-06-05 12:55:23', '2023-06-05 12:55:23'),
(32, '1685969780.jpg', 'Kucing Anggora', 'Kucing Rumahan', 500, NULL, 0, '2023-06-05 12:56:20', '2023-06-05 12:56:20'),
(33, '1685969830.jpg', 'Kucing Persia', 'Kucing Mahal', 500, NULL, 0, '2023-06-05 12:57:10', '2023-06-05 12:57:10'),
(34, '1685969889.jpg', 'Kucing Liar', 'Kucing Galak', 500, NULL, 0, '2023-06-05 12:58:09', '2023-06-05 12:58:09'),
(35, '1685969940.jpg', 'Bapak Sholeh dan Ibu Murti', 'Kisah Cinta', 1000, NULL, 0, '2023-06-05 12:59:00', '2023-06-05 12:59:00'),
(36, '1685969986.jpg', 'Ibu Tuminah', 'Penjual di Pasar', 500, NULL, 0, '2023-06-05 12:59:46', '2023-06-05 12:59:46'),
(37, '1685970028.jpg', 'Nelayan Paruh Baya', 'Nelayan Ikan', 500, NULL, 0, '2023-06-05 13:00:28', '2023-06-05 13:00:28'),
(39, '1685970091.jpg', 'Mengayak Padi', 'Nenek Mengayak Padi', 500, NULL, 0, '2023-06-05 13:01:31', '2023-06-05 13:01:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT 'customer',
  `alamat` text DEFAULT NULL,
  `no_hp` text DEFAULT NULL,
  `verif` enum('login','tidak') DEFAULT 'tidak',
  `ktp` varchar(256) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `alamat`, `no_hp`, `verif`, `ktp`, `created_at`, `updated_at`) VALUES
(0, 'pemilik', 'pemilik@gmail.com', '$2y$10$NEdidpjIjsSGaQ20bxakJuC.t0YSP5spxw7YFb9U34RtSEwuGejRm', 'pemilik', NULL, NULL, 'login', NULL, '2022-12-20 16:06:48', '2022-12-20 16:06:52'),
(1, 'admin', 'admin@gmail.com', '$2y$10$WEZwhGml9T8ir5he3hdWVuqBGviCgwm9rpAHUeBSu.DYNlwX0lMrS', 'admin', NULL, NULL, 'login', NULL, '2022-09-04 08:51:51', '2022-09-04 08:51:51'),
(9, 'customer1', 'customer1@gmail.com', '$2y$10$QLoRNagR8GxqlWdhGSjMbeZMAo6OVJtb4mFnWjt0UgfieHgVQHh82', 'customer', NULL, NULL, 'login', NULL, '2023-05-23 06:25:20', '2023-05-23 06:25:20'),
(10, 'customer2', 'customer2@gmail.com', '$2y$10$fC/3LyJIzMvlGIJwt2d08.pdRWmusj4x7oNjkhAxyDiOfPjGMAPku', 'customer', NULL, NULL, 'login', NULL, '2023-05-23 06:25:43', '2023-05-23 06:25:43'),
(11, 'customer3', 'customer3@gmail.com', '$2y$10$E7oAj/8gR73Up82Ajm2M3uA1QNM/1Szvjx757cqDxbDDZ6n495Gge', 'customer', NULL, NULL, 'login', NULL, '2023-05-23 06:26:07', '2023-05-23 06:26:07'),
(12, 'marketing1', 'marketing1@gmail.com', '$2y$10$xtnoRmvpWbu3Tb5IdBm.aeL67myqSREjJXDPt4VxErSPX/Qhm0Er6', 'anggota', NULL, NULL, 'login', NULL, '2023-05-23 06:26:25', '2023-05-23 06:26:25'),
(13, 'marketing2', 'marketing2@gmail.com', '$2y$10$rLhplHFmaGrNwUYtmds3q.qym6N.JnehWc7ZYgeAyEZseHXA7GsDS', 'anggota', NULL, '081244444444', 'login', '1710318329.png', '2023-05-23 06:26:40', '2023-05-23 06:26:40'),
(15, 'Jajang', 'jajang@gmail.com', '$2y$10$htoqDQMaTCG1ODxISTcHJubUUu5l2nTFaXllwqF3Fvsi4ekG21jqu', 'customer', NULL, NULL, 'login', NULL, '2024-02-20 01:28:23', '2024-02-20 01:28:23'),
(16, 'Mia', 'Mia@gmail.com', '$2y$10$DvR8i6blxGXUaHdN9DW4supoUNXzWEcXAHbRx0ke1f0PMeCCFsEq2', 'customer', NULL, NULL, 'tidak', NULL, '2024-03-04 02:19:09', '2024-03-04 02:19:09'),
(17, 'Dia', 'dia@gmail.com', '$2y$10$0tVZkdTbr7klDME3/vdHbOZUsF99SC.YDWGDBTriZsjSF92KMe6ri', 'customer', NULL, NULL, 'tidak', NULL, '2024-03-04 02:23:51', '2024-03-04 02:23:51'),
(18, 'sasa', 'sasa@gmail.com', '$2y$10$mqmeuNtP4/TuBP4xZ2d3UOIsNDVEcqENTKobW55eaKQF6YUjnoUru', 'customer', NULL, NULL, 'login', NULL, '2024-03-04 02:44:58', '2024-03-04 02:44:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_custom`
--
ALTER TABLE `tb_custom`
  ADD PRIMARY KEY (`id`,`nama`);

--
-- Indexes for table `tb_gambar`
--
ALTER TABLE `tb_gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cart`
--
ALTER TABLE `tb_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_custom`
--
ALTER TABLE `tb_custom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_gambar`
--
ALTER TABLE `tb_gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
