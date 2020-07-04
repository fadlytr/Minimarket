-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2020 at 01:09 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minimarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(6) NOT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `harga_barang` bigint(20) DEFAULT NULL,
  `stok_barang` int(11) DEFAULT NULL,
  `img` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga_barang`, `stok_barang`, `img`) VALUES
('M001', 'Manjun Yaki Nori', 85000, 10, 'assets/img/majun-nori.jpg'),
('M002', 'Egg Drops Monde', 8000, 10, 'assets/img/eggdrops.jpg'),
('M003', 'Lays Rumput Laur', 12000, 0, 'assets/img/lays.jpg'),
('M004', 'Mama Suka Nori', 13000, 19, 'assets/img/mamasuka-nori.jpg'),
('M005', 'Susu Fullcream UHT', 6500, 19, 'assets/img/uht-fullcream.jpg'),
('M006', 'Samyang', 18500, 18, 'assets/img/samyang.jpg'),
('M007', 'Pop Mie Geledek', 5500, 20, 'assets/img/popmigeledek.jpg'),
('M008', 'Twister', 8000, 18, 'assets/img/twister.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_trx` int(11) NOT NULL,
  `id_barang` char(6) NOT NULL,
  `jml_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_trx`, `id_barang`, `jml_barang`) VALUES
(4, 'M002', 1),
(4, 'M002', 2),
(1, 'M002', 2),
(4, 'M003', 1),
(5, 'M003', 2),
(6, 'M002', 2),
(6, 'M003', 1),
(7, 'M005', 1),
(7, 'M006', 2),
(8, 'M004', 1),
(8, 'M008', 2);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id_request` char(6) NOT NULL,
  `jml_barang` int(11) DEFAULT NULL,
  `tgl_pengiriman` timestamp NULL DEFAULT NULL,
  `id_barang` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_trx` int(11) NOT NULL,
  `jenis_trx` char(1) DEFAULT NULL,
  `tgl_trx` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_trx`, `jenis_trx`, `tgl_trx`, `status`) VALUES
(1, '2', '2020-07-04 04:34:31', 'bayar'),
(2, '2', '2020-07-04 04:35:22', 'bayar'),
(3, '2', '2020-07-04 04:35:27', 'bayar'),
(4, '2', '2020-07-04 04:36:11', 'bayar'),
(5, '2', '2020-07-04 06:00:35', 'bayar'),
(6, '2', '2020-07-04 06:01:06', 'bayar'),
(7, '2', '2020-07-04 06:01:57', 'bayar'),
(8, '2', '2020-07-04 06:02:31', 'bayar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_trx` (`id_trx`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_trx`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_trx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_trx`) REFERENCES `transaksi` (`id_trx`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
