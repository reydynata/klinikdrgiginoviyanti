-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Nov 2025 pada 22.21
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
-- Database: `klinik_gigi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `pasien_id` int(11) NOT NULL,
  `layanan_id` int(11) NOT NULL,
  `tanggal_janji` date NOT NULL,
  `waktu_janji` time NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `appointments`
--

INSERT INTO `appointments` (`id`, `pasien_id`, `layanan_id`, `tanggal_janji`, `waktu_janji`, `catatan`, `status`, `created_at`) VALUES
(2, 9, 4, '2222-12-12', '14:22:00', '22', 'Confirmed', '2025-11-26 16:26:20'),
(3, 10, 1, '2025-11-27', '20:00:00', 'konsultasi gigi', 'Confirmed', '2025-11-27 15:41:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `ikon` varchar(50) DEFAULT NULL,
  `gambar` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `layanan`
--

INSERT INTO `layanan` (`id`, `judul`, `deskripsi`, `ikon`, `gambar`) VALUES
(1, 'Pembersihan Karang Gigi', 'Perawatan scaling untuk menghilangkan plak dan karang yang menumpuk di gigi dan gusi.', 'fas fa-tooth', NULL),
(2, 'Pembuatan Gigi Palsu', 'Layanan pembuatan gigi palsu (Gigi Tiruan Lepasan atau Gigi Tiruan Cekat) yang presisi dan nyaman.', 'fas fa-teeth', NULL),
(3, 'Tambal Gigi Estetika', 'Mengisi gigi berlubang menggunakan bahan sewarna gigi (composite) agar tampilan tetap alami.', 'fas fa-fill-drip', NULL),
(4, 'Pemasangan Behel (Orthodonti)', 'Perawatan untuk merapikan susunan gigi dan memperbaiki gigitan.', 'fas fa-crown', NULL),
(5, 'Cabut Gigi', 'Prosedur pencabutan gigi yang sudah rusak parah atau tidak dapat dipertahankan.', 'fas fa-skull-crossbones', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pasien','dokter') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Dr. Novi Yanti, AMKG', 'admin@klinik.com', '$2y$10$Uc0ZiAcIiAm3QWs87AEgDe5XWUYum/78qpac.3FtiUhuT0HZARu42', 'dokter', '2025-11-25 07:56:14'),
(3, 'pandu', 'pandu@gmail.com', '$2y$10$yRtUdfbUBgp9zq/q0Uq5Xe31XA83KEfFUyf2TnOVn0Y4wxZrO3096', 'pasien', '2025-11-25 09:46:04'),
(4, 'maman', 'maman@d.com', '$2y$10$PiejJPwMHR9lqzZ83b.7G.LctrWdSVx7ikeB2RWDHrmOZ2lc8oAc2', 'pasien', '2025-11-25 10:37:12'),
(5, 'dasob123', 'dasob@d.com', '$2y$10$P4kc/SQ4ZL1s/fLT0MpQzeHf9K83nszbHf7MPNUi2BYaebEWgo706', 'pasien', '2025-11-26 07:13:16'),
(6, 'mamansiregar', 'maman1@gmail.com', '$2y$10$gekpb9nTJsw.yD7yL2wTcOgQTI7tP5Qn2rno78/wfC6xaHn1pzSha', 'pasien', '2025-11-26 08:26:27'),
(7, 'a', 'a@a.com', '$2y$10$QG9TI.20H7sm5hwBlmh9gOG2rb1/F4Eace23BowwaU3zNM6AGH15i', 'pasien', '2025-11-26 08:52:32'),
(8, '123', 'a@abc.com', '$2y$10$nBW2rGEbHGxZUvljOVgnLuPyjXo5RDjbE/zz.Co94NmQXHLCcKXOC', 'pasien', '2025-11-26 08:53:13'),
(9, 'df', 'fd@d.com', '$2y$10$WL7SXL.U9PLg1yNESfR.TOAdfnc/5yKalfr5RUKuzrpKbrbNqyXFy', 'pasien', '2025-11-26 09:11:03'),
(10, 'rehan', 'rehan@gmail.com', '$2y$10$Fz4mJXFeX7x5hCD2a9zrYe3bGcsJNtzUSjCy/XKl/MJvVNnCoFrIO', 'pasien', '2025-11-27 08:40:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
