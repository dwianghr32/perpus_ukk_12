-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 20, 2026 at 06:48 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `alamat` text,
  `telepon` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nis`, `nama`, `kelas`, `alamat`, `telepon`, `created_at`, `updated_at`) VALUES
(9, '260430', 'Arief Fadilah', 'XII PPLG', 'Cikaret', '0888999777', '2026-03-31 13:49:06', '2026-03-31 13:49:06'),
(10, '123', 'dwi', '12', 'cilodong', '089602173040', '2026-04-14 12:21:46', '2026-04-14 12:21:46'),
(11, '12345', 'diwi', '12', 'cilodong', '089602173040', '2026-04-14 12:22:50', '2026-04-14 12:22:50'),
(12, '1234', 'ibot', '12', 'cilodong', '089602173045', '2026-04-14 12:24:35', '2026-04-14 12:24:35'),
(13, '12345678', 'dwi anugrah', '12', 'cikumpa', '089602173045', '2026-04-14 12:27:44', '2026-04-14 12:27:44'),
(15, '1234567890', 'ketel', '12', 'cilodong', '0897687876686', '2026-04-14 14:03:34', '2026-04-14 14:03:34'),
(17, '0987', 'Rizky Ha', '12', 'cikumpa', '089602173211', '2026-04-16 08:35:28', '2026-04-16 08:35:28'),
(18, '7022', 'udin', '12', 'serap', '089602174050', '2026-04-16 14:00:30', '2026-04-16 14:00:30'),
(19, '02321', 'HUMAN', 'XII AKL', 'CIKUMPA', '0892121313131', '2026-04-16 14:03:59', '2026-04-16 14:03:59'),
(20, 'rio', 'Rizky ling', 'XII AKL', 'cilodong', '085813433815', '2026-04-17 11:32:23', '2026-04-17 11:32:23'),
(21, '4321', 'Rizky Hanugrah', '12mplb', 'cilodong', '08960278090', '2026-04-17 13:23:33', '2026-04-17 13:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `kode_buku` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` year DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `stok` int NOT NULL DEFAULT '1',
  `deskripsi` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `kode_buku`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `kategori`, `stok`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'BK001', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 'Novel', 5, 'Novel inspiratif tentang pendidikan di Belitung', '2026-01-29 10:42:48', '2026-04-14 12:56:44'),
(3, 'BK003', 'Pemrograman PHP', 'Abdul Kadir', 'Andi Publisher', 2018, 'Teknologi', 10, 'Buku panduan pemrograman PHP untuk pemula', '2026-01-29 10:42:48', '2026-02-07 13:51:58'),
(4, 'BK004', 'Matematika Dasar', 'Sukino', 'Erlangga', 2020, 'Pendidikan', 8, 'Buku matematika untuk SMA', '2026-01-29 10:42:48', '2026-04-16 08:10:18'),
(5, 'BK005', 'Sejarah Indonesia', 'Marwati Poesponegoro', 'Balai Pustaka', 2008, 'Sejarah', 4, 'Sejarah Indonesia dari masa ke masa', '2026-01-29 10:42:48', '2026-04-17 14:26:18'),
(6, 'BK006', 'Ayah ini arahnya kemana', 'Drs. Arief Fadilah S.T', 'Drs. Arief Fadilah S.T', 2026, 'Lainnya', 5, 'novel menceritakan tentang kata kata kasih fahamm!!!!!!', '2026-01-29 14:18:18', '2026-04-17 14:26:25'),
(7, '008', 'serap di malam hari', 'budi', 'jajang', 2021, 'Novel', 10, 'duaudaa', '2026-04-16 14:02:55', '2026-04-17 08:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `id_anggota` int NOT NULL,
  `id_buku` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan','terlambat') NOT NULL DEFAULT 'dipinjam',
  `denda` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_anggota`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_dikembalikan`, `status`, `denda`, `created_at`, `updated_at`) VALUES
(23, 13, 4, '2026-04-15', '2026-04-22', '2026-04-16', 'dikembalikan', 0, '2026-04-15 10:40:46', '2026-04-16 08:10:18'),
(24, 17, 5, '2026-04-16', '2026-04-23', '2026-04-16', 'dikembalikan', 0, '2026-04-16 08:36:34', '2026-04-16 10:00:15'),
(25, 18, 5, '2026-04-16', '2026-04-23', '2026-04-16', 'dikembalikan', 0, '2026-04-16 14:01:28', '2026-04-16 14:04:50'),
(26, 17, 6, '2026-04-16', '2026-04-23', '2026-04-17', 'dikembalikan', 0, '2026-04-16 14:08:37', '2026-04-17 14:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL DEFAULT 'siswa',
  `id_anggota` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `id_anggota`, `created_at`, `updated_at`) VALUES
(7, 'admin', '$2y$10$eAnYIo1LSYKU9G890MXQaO2I0gKQ1aHatIr7vHrMVeeNa.wBie6aO', 'admin', NULL, '2026-01-29 10:52:39', '2026-01-29 10:56:00'),
(16, '12345678', '$2y$10$6E3ckeSez1qhUWvwAjlESuhTJdehISXf8HXtftJgfEA/2Tap8uIhi', 'siswa', 13, '2026-04-14 12:27:44', '2026-04-14 12:27:44'),
(18, '1234567890', '$2y$10$Yadhtw0rsgwYUi4s7p.2luvou6tuOdSSF9kKHQLUU1y7hImj/n07q', 'siswa', 15, '2026-04-14 14:03:34', '2026-04-14 14:03:34'),
(20, '0987', '$2y$10$.Owkg1NTaPFQR3245CdIP.xZP.r5lPJ.X7F2uF184ulIv8JuLc80a', 'siswa', 17, '2026-04-16 08:35:28', '2026-04-16 08:35:28'),
(21, '7022', '$2y$10$aZN0uF7IXCeBCgEtF1vRIOTyerbeTKkNd.LLIYQKX1T9GsoIYdKQW', 'siswa', 18, '2026-04-16 14:00:30', '2026-04-16 14:00:30'),
(22, '02321', '$2y$10$vOUCaQAWVI6j9FkZFUEqRO27yQy5IdeHRlct4DAcsnmCzB0xjU.Ea', 'siswa', 19, '2026-04-16 14:03:59', '2026-04-16 14:03:59'),
(23, 'rio', '$2y$10$kPoBR08rjgYdA/nqrtDFEehf0yfRbgG5OsFKsHp3oXcxNAM/ToASq', 'siswa', 20, '2026-04-17 11:32:23', '2026-04-17 11:32:23'),
(24, '4321', '$2y$10$MBJnMgp3FEWkvUXIBnkHVOd3olWP4/PuatTnrDoYiCKRU8on2uzae', 'siswa', 21, '2026-04-17 13:23:33', '2026-04-17 13:23:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_buku` (`kode_buku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
