-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Mar 2024 pada 21.54
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test-sesasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `logauth`
--

CREATE TABLE `logauth` (
  `id` int(3) NOT NULL,
  `id_user` int(3) NOT NULL,
  `authorization` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `logauth`
--

INSERT INTO `logauth` (`id`, `id_user`, `authorization`, `status`) VALUES
(2, 1, '0276efe170c1d0974fb65afea155da1f', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `timeoff`
--

CREATE TABLE `timeoff` (
  `id` int(3) NOT NULL,
  `id_user` int(3) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `id_verifikator` int(3) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('ADMIN','VERIFIKATOR','USER') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `role`) VALUES
(1, 'Dennis', 'admin', '25d55ad283aa400af464c76d713c07ad', 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `logauth`
--
ALTER TABLE `logauth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `authorization` (`authorization`);

--
-- Indeks untuk tabel `timeoff`
--
ALTER TABLE `timeoff`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `logauth`
--
ALTER TABLE `logauth`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `timeoff`
--
ALTER TABLE `timeoff`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
