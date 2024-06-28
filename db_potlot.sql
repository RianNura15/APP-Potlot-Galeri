-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jun 2024 pada 04.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_potlot`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`, `updated_at`) VALUES
('admin@gmail.com', '$2y$10$kjIc8WbWCd6JEHzs3iG8vusitvJ.YUKtzw1ohOFjUPtn2xVAWX7F2', '2022-09-27 06:09:52', '2022-09-27 13:09:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_cart`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_cart`
--

INSERT INTO `tb_cart` (`id`, `id_gambar`, `id_cust`, `id_pemasar`, `harga`, `promo`, `status`, `created_at`, `updated_at`) VALUES
(19, 32, 9, 12, 500, 0, 'dibayar', '2024-06-11 15:12:03', '2024-06-11 15:12:03'),
(20, 27, 9, 12, 2000, 0, 'dibayar', '2024-06-21 07:56:59', '2024-06-21 07:56:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_custom`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_custom`
--

INSERT INTO `tb_custom` (`id`, `id_pemasar`, `id_cust`, `sampel`, `nama`, `canvas`, `harga`, `gambar1`, `gambar2`, `gambar3`, `gambar4`, `media`, `rate`, `koment`, `status`, `created_at`, `updated_at`) VALUES
(15, 12, 9, '1718957041.jpg', 'lukman', 67, 100, '1718957096.jpg', '1718957147.jpg', '1718957163.jpg', '1718957170.jpg', 'canvas', 0, 'bagus', 'dibayar', '2024-06-21 08:04:01', '2024-06-21 08:04:01'),
(18, 46, 47, '1719334903.jpg', 'KTP', 46, 0, NULL, NULL, NULL, NULL, 'canvas', 0, NULL, 'pesan', '2024-06-25 17:01:43', '2024-06-25 17:01:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_custom_chat`
--

CREATE TABLE `tb_custom_chat` (
  `id_custom` int(11) DEFAULT NULL,
  `id_pengirim` int(11) DEFAULT NULL,
  `id_penerima` int(11) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_custom_chat`
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
(11, 9, 12, 'ok', '2023-05-23 15:22:51'),
(12, 9, 12, 'diperkecil mas', '2024-06-06 15:08:59'),
(12, 12, 9, 'oke', '2024-06-06 15:09:09'),
(12, 9, 12, 'kurang kecil', '2024-06-06 15:09:41'),
(12, 9, 12, 'kekecilan', '2024-06-06 15:10:14'),
(12, 9, 12, 'oke', '2024-06-06 15:10:54'),
(13, 33, 12, 'diperkecil mas', '2024-06-07 06:30:15'),
(13, 12, 33, 'baik', '2024-06-07 06:30:22'),
(13, 33, 12, 'kurang', '2024-06-07 06:30:49'),
(13, 33, 12, 'berapa pak?', '2024-06-07 06:32:07'),
(13, 12, 33, '100', '2024-06-07 06:32:14'),
(14, 34, 12, 'Kurang kecil mas', '2024-06-11 15:01:48'),
(14, 12, 34, 'Baik mas', '2024-06-11 15:02:01'),
(15, 9, 12, 'berapa', '2024-06-21 08:04:37'),
(15, 12, 9, '100', '2024-06-21 08:04:45'),
(15, 9, 12, 'baik mas', '2024-06-21 08:06:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_gaji`
--

CREATE TABLE `tb_gaji` (
  `id_user` int(11) DEFAULT NULL,
  `gaji` int(11) DEFAULT NULL,
  `tgl_gaji` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_gaji`
--

INSERT INTO `tb_gaji` (`id_user`, `gaji`, `tgl_gaji`) VALUES
(1, 1, '2022-12-20 21:00:12'),
(1, 1, '2022-12-20 21:45:50'),
(1, 200, '2022-12-20 21:45:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_gambar`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_gambar`
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
-- Struktur dari tabel `users`
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
  `koderef_mark` varchar(255) DEFAULT NULL,
  `koderef_cust` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `alamat`, `no_hp`, `verif`, `ktp`, `koderef_mark`, `koderef_cust`, `created_at`, `updated_at`) VALUES
(0, 'pemilik', 'pemilik@gmail.com', '$2y$10$NEdidpjIjsSGaQ20bxakJuC.t0YSP5spxw7YFb9U34RtSEwuGejRm', 'pemilik', NULL, NULL, 'login', NULL, NULL, NULL, '2022-12-20 16:06:48', '2022-12-20 16:06:52'),
(1, 'admin', 'admin@gmail.com', '$2y$10$WEZwhGml9T8ir5he3hdWVuqBGviCgwm9rpAHUeBSu.DYNlwX0lMrS', 'admin', NULL, NULL, 'login', NULL, NULL, NULL, '2022-09-04 08:51:51', '2022-09-04 08:51:51'),
(9, 'customer1', 'customer1@gmail.com', '$2y$10$QLoRNagR8GxqlWdhGSjMbeZMAo6OVJtb4mFnWjt0UgfieHgVQHh82', 'customer', NULL, NULL, 'login', NULL, NULL, NULL, '2023-05-23 06:25:20', '2023-05-23 06:25:20'),
(10, 'customer2', 'customer2@gmail.com', '$2y$10$fC/3LyJIzMvlGIJwt2d08.pdRWmusj4x7oNjkhAxyDiOfPjGMAPku', 'customer', NULL, NULL, 'login', NULL, NULL, NULL, '2023-05-23 06:25:43', '2023-05-23 06:25:43'),
(11, 'customer3', 'customer3@gmail.com', '$2y$10$E7oAj/8gR73Up82Ajm2M3uA1QNM/1Szvjx757cqDxbDDZ6n495Gge', 'customer', NULL, NULL, 'login', NULL, NULL, NULL, '2023-05-23 06:26:07', '2023-05-23 06:26:07'),
(12, 'marketing1', 'marketing1@gmail.com', '$2y$10$xtnoRmvpWbu3Tb5IdBm.aeL67myqSREjJXDPt4VxErSPX/Qhm0Er6', 'anggota', NULL, NULL, 'login', NULL, NULL, NULL, '2023-05-23 06:26:25', '2023-05-23 06:26:25'),
(13, 'marketing2', 'marketing2@gmail.com', '$2y$10$rLhplHFmaGrNwUYtmds3q.qym6N.JnehWc7ZYgeAyEZseHXA7GsDS', 'anggota', NULL, '081244444444', 'login', '1710318329.png', NULL, NULL, '2023-05-23 06:26:40', '2023-05-23 06:26:40'),
(29, 'marketing3', 'marketing3@gmail.com', '$2y$10$jQUNTfMpRs5qbXPUVssbP.d4qU6Z8fpVn8aolTOOd4tXwm.wgzUXy', 'anggota', NULL, '081267895674', 'login', '1717684845.jpg', NULL, NULL, '2024-06-06 14:40:45', '2024-06-06 14:40:45'),
(38, 'customer5', 'customer5@gmail.com', '$2y$10$zSNCZ5DqYB3d8vOxbE8aSObEwLKo08wZPrWo7So3eigalYhAW7zye', 'customer', NULL, NULL, 'tidak', NULL, NULL, NULL, '2024-06-21 00:45:49', '2024-06-21 00:45:49'),
(39, 'customer10', 'customer10@gmail.com', '$2y$10$WblYalsD9F389FVEIaCUM.kCh879Fq2YosqZHp2GLLQpcGwlGLqNe', 'customer', NULL, NULL, 'tidak', NULL, NULL, NULL, '2024-06-21 00:46:16', '2024-06-21 00:46:16'),
(40, 'customerlukman', 'customerlukman@gmail.com', '$2y$10$BimKeVEfmpbBnZgMoilip.D8aDqNd7GitrNqy/BcwPX7ozr2224z2', 'customer', NULL, NULL, 'tidak', NULL, NULL, NULL, '2024-06-21 00:47:15', '2024-06-21 00:47:15'),
(41, 'marketing4', 'marketing4@gmail.com', '$2y$10$DovtcMda9d9TbU6HxqJ2PeQtLvFLtsRpy7oC7EF0cnvFOA82y1Kcq', 'anggota', NULL, '081267895674', 'login', '1718956152.jpg', NULL, NULL, '2024-06-21 07:49:12', '2024-06-21 07:49:12'),
(42, 'rian', 'rian@gmail.com', '$2y$10$2egiUVbMK7PPxvCE.3IuJ.UITgtfWibd4Wb6RIqG25l.hTqv6qeiO', 'customer', NULL, NULL, 'login', NULL, NULL, NULL, '2024-06-23 06:05:46', '2024-06-23 06:05:46'),
(43, 'Nura', 'Nura@gmail.com', '$2y$10$4gc43KjgTya45YBDkfwbau0uPyIbrfTuQQFp0Ick2mxpiygNcBeQi', 'customer', NULL, NULL, 'login', NULL, NULL, NULL, '2024-06-25 04:30:30', '2024-06-25 04:30:30'),
(44, 'marketing5', 'marketing5@gmail.com', '$2y$10$W9qTGTyYGXC4eKrFTpCckOiW5Aovka/eMWCOBpoA8KisGzzTWMsea', 'anggota', NULL, '08989871135', 'login', '1719321383.jpg', NULL, NULL, '2024-06-25 13:16:24', '2024-06-25 13:16:24'),
(45, 'marketing6', 'marketing6@gmail.com', '$2y$10$ffv0CW5f8PgB79dPXkeTBusWVb4Wmrn.KJdkU.ZTwXwOjXnrbROxG', 'anggota', NULL, '08989871135', 'login', '1719321541.jpg', '667ac3c589f40', NULL, '2024-06-25 13:19:01', '2024-06-25 13:19:01'),
(46, 'marketing7', 'marketing7@gmail.com', '$2y$10$yL7XOIza66fz1sGuJ5ZTrOsfmfMpyEN77VJW16NY5suNQ0vymzjxq', 'anggota', NULL, '08989871135', 'login', '1719321596.jpg', '667ac3fc904ec', NULL, '2024-06-25 13:19:56', '2024-06-25 13:19:56'),
(47, 'guslukman', 'guslukman@gmail.com', '$2y$10$cXvLK20dGghjWs/QN.GehO9JtOSkLv2X6fvwzQRb7k27NGZH8RIZK', 'customer', NULL, NULL, 'login', NULL, NULL, '667ac3fc904ec', '2024-06-25 07:28:08', '2024-06-25 07:28:08');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_cart`
--
ALTER TABLE `tb_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_custom`
--
ALTER TABLE `tb_custom`
  ADD PRIMARY KEY (`id`,`nama`);

--
-- Indeks untuk tabel `tb_gambar`
--
ALTER TABLE `tb_gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_cart`
--
ALTER TABLE `tb_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `tb_custom`
--
ALTER TABLE `tb_custom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tb_gambar`
--
ALTER TABLE `tb_gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
