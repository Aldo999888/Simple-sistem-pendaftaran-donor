-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2025 at 04:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_donor`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendonor`
--

CREATE TABLE `tbl_pendonor` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `ttl` date NOT NULL,
  `goldar` enum('A','B','AB','O') NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pendonor`
--

INSERT INTO `tbl_pendonor` (`id`, `nama`, `alamat`, `ttl`, `goldar`, `no_hp`) VALUES
(1, 'aldo', 'pati', '2000-10-18', 'A', '082227177638'),
(2, 'fani', 'kudus', '2000-12-24', 'B', '081973986133'),
(3, 'abdul', 'pati', '2000-07-11', 'AB', '089127372464');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_pendonor`
--
ALTER TABLE `tbl_pendonor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_pendonor`
--
ALTER TABLE `tbl_pendonor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
