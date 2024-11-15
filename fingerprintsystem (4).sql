-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 15, 2024 at 06:45 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fingerprintsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `fp_id_in` int DEFAULT NULL,
  `fp_id_out` int DEFAULT NULL,
  `event_status` tinyint DEFAULT '1',
  `masa_mula` datetime DEFAULT CURRENT_TIMESTAMP,
  `masa_tamat` datetime DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `fp_id_in`, `fp_id_out`, `event_status`, `masa_mula`, `masa_tamat`, `type`, `time_add`, `time_edit`) VALUES
(1, 6, NULL, 0, 1, '2024-09-04 08:46:41', '2024-09-04 14:46:41', NULL, '2024-09-04 15:46:57', '2024-09-04 15:46:57'),
(2, 21, NULL, 0, 1, '2024-09-04 15:46:41', '2024-09-04 17:46:41', NULL, '2024-09-04 15:46:57', '2024-09-04 15:46:57'),
(3, 21, NULL, 0, 0, '2024-09-04 17:46:41', '2024-09-04 18:00:00', NULL, '2024-09-04 15:46:57', '2024-09-04 15:46:57'),
(9, 7, NULL, 0, 1, '2024-09-04 23:34:10', '2024-09-04 23:34:23', NULL, '2024-09-04 23:34:10', '2024-09-04 23:34:10'),
(10, 7, NULL, 0, 1, '2024-11-02 17:29:23', '2024-11-02 17:29:28', NULL, '2024-11-02 17:29:23', '2024-11-02 17:29:23'),
(12, 6, NULL, 0, 1, '2024-11-01 14:30:41', '2024-11-01 17:30:41', NULL, '2024-11-02 17:30:41', '2024-11-02 17:30:41'),
(13, 6, NULL, NULL, 1, '2024-11-12 02:13:16', '2024-11-12 02:20:13', NULL, '2024-11-12 02:13:32', '2024-11-12 02:20:13'),
(14, 6, NULL, NULL, 1, '2024-11-12 02:21:44', NULL, NULL, '2024-11-12 02:21:44', '2024-11-12 02:21:44'),
(15, 7, NULL, NULL, 1, '2024-11-13 11:19:13', NULL, NULL, '2024-11-13 11:19:13', '2024-11-13 11:19:13'),
(16, 7, NULL, NULL, 1, '2024-11-13 11:20:19', NULL, NULL, '2024-11-13 11:20:19', '2024-11-13 11:20:19'),
(17, 7, NULL, NULL, 1, '2024-11-13 13:38:51', NULL, NULL, '2024-11-13 13:38:51', '2024-11-13 13:38:51');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_slot`
--

DROP TABLE IF EXISTS `attendance_slot`;
CREATE TABLE IF NOT EXISTS `attendance_slot` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `slot` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slot_status` int DEFAULT NULL,
  `tarikh` date DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `file_path` text COLLATE utf8mb4_unicode_ci,
  `tarikh2` date DEFAULT NULL,
  `verify` int DEFAULT NULL,
  `lect_id` int DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_slot`
--

INSERT INTO `attendance_slot` (`id`, `user_id`, `slot`, `slot_status`, `tarikh`, `reason`, `file_path`, `tarikh2`, `verify`, `lect_id`, `time_add`, `time_edit`) VALUES
(1, 6, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(2, 6, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(3, 6, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(4, 6, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(5, 6, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(6, 6, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(7, 6, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(8, 18, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(9, 18, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(10, 18, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(11, 18, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(12, 18, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(13, 18, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(14, 18, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(15, 21, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(16, 21, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(17, 21, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(18, 21, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(19, 21, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(20, 21, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(21, 21, '', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:39:29', '2024-11-02 17:39:29'),
(22, 6, 'slot1', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(23, 6, 'rehat1', 6, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(24, 6, 'slot2', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(25, 6, 'slot3', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(26, 6, 'rehat2', 6, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(27, 6, 'slot4', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(28, 6, 'slot5', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(29, 18, 'slot1', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(30, 18, 'rehat1', 6, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(31, 18, 'slot2', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(32, 18, 'slot3', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(33, 18, 'rehat2', 6, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(34, 18, 'slot4', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(35, 18, 'slot5', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(36, 21, 'slot1', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(37, 21, 'rehat1', 6, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(38, 21, 'slot2', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(39, 21, 'slot3', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(40, 21, 'rehat2', 6, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(41, 21, 'slot4', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04'),
(42, 21, 'slot5', 0, '2024-11-02', NULL, NULL, NULL, NULL, NULL, '2024-11-02 17:40:04', '2024-11-02 17:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masa_mula` datetime DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fp_device`
--

DROP TABLE IF EXISTS `fp_device`;
CREATE TABLE IF NOT EXISTS `fp_device` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` text COLLATE utf8mb4_unicode_ci,
  `entrance` int NOT NULL DEFAULT '0',
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fp_device`
--

INSERT INTO `fp_device` (`id`, `nama`, `entrance`, `time_add`, `time_edit`) VALUES
(1, 'testin', 1, '2024-11-02 17:52:45', '2024-11-02 17:57:10'),
(2, 'testout', 0, '2024-11-02 17:53:39', '2024-11-02 17:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

DROP TABLE IF EXISTS `holiday`;
CREATE TABLE IF NOT EXISTS `holiday` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tarikh` date DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify` int NOT NULL DEFAULT '0',
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_holiday` (`nama`,`tarikh`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `tarikh`, `nama`, `verify`, `time_add`, `time_edit`) VALUES
(4, '2024-01-01', 'Tahun Baru 2024', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(5, '2024-01-25', 'Hari Thaipusam', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(6, '2024-03-28', 'Hari Nuzul Al-Quran', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(7, '2024-11-01', 'Hari Keputeraan DYMM Paduka Seri Sultan Perak Darul Ridzuan', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(8, '2024-02-10', 'Tahun Baru Cina', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(9, '2024-02-11', 'Tahun Baru Cina', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(10, '2024-04-10', 'Hari Raya Puasa', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(11, '2024-04-11', 'Hari Raya Puasa', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(12, '2024-05-01', 'Hari Pekerja', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(13, '2024-05-22', 'Hari Wesak', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(14, '2024-06-03', 'Hari Keputeraan Seri Paduka Baginda Yang di-Pertuan Agong', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(15, '2024-06-17', 'Hari Raya Qurban', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(16, '2024-07-07', 'Awal Muharram', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(17, '2024-08-31', 'Hari Kebangsaan', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(18, '2024-09-16', 'Hari Malaysia', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(19, '2024-09-16', 'Hari Keputeraan Nabi Muhammad S.A.W', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(20, '2024-10-31', 'Hari Deepavali', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11'),
(21, '2024-12-25', 'Hari Krismas', 0, '2024-11-03 12:02:11', '2024-11-03 12:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
CREATE TABLE IF NOT EXISTS `kelas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kelas` text COLLATE utf8mb4_unicode_ci,
  `location` text COLLATE utf8mb4_unicode_ci,
  `fp_entrance` int DEFAULT NULL,
  `fp_exit` int DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `location`, `fp_entrance`, `fp_exit`, `time_add`, `time_edit`) VALUES
(1, 'DTK KOMPUTER', 'Makmal Test', 0, 0, '2024-11-02 17:52:09', '2024-11-02 17:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `sem`
--

DROP TABLE IF EXISTS `sem`;
CREATE TABLE IF NOT EXISTS `sem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` text COLLATE utf8mb4_unicode_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sem`
--

INSERT INTO `sem` (`id`, `nama`, `start_date`, `end_date`, `time_add`, `time_edit`) VALUES
(1, '1/2024', '2024-01-01', '2024-06-06', '2024-11-02 17:57:50', '2024-11-02 17:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `subjek`
--

DROP TABLE IF EXISTS `subjek`;
CREATE TABLE IF NOT EXISTS `subjek` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subjek_nama` text COLLATE utf8mb4_unicode_ci,
  `subjek_kod` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

DROP TABLE IF EXISTS `time_slot`;
CREATE TABLE IF NOT EXISTS `time_slot` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slot` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `masa_mula` time DEFAULT NULL,
  `masa_tamat` time DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`id`, `slot`, `masa_mula`, `masa_tamat`, `time_add`, `time_edit`) VALUES
(1, 'slot1', '08:00:00', '09:30:00', '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(2, 'rehat1', '09:30:00', '10:00:00', '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(3, 'slot2', '10:00:00', '11:30:00', '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(4, 'slot3', '11:30:00', '13:00:00', '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(5, 'rehat2', '13:00:00', '14:00:00', '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(6, 'slot4', '14:00:00', '15:30:00', '2024-10-29 15:45:48', '2024-11-02 17:28:04'),
(7, 'slot5', '15:30:00', '17:00:00', '2024-10-29 15:45:48', '2024-11-02 17:26:21');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` int DEFAULT NULL,
  `ndp` int DEFAULT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `kp` int DEFAULT NULL,
  `jantina` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kahwin` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bangsa` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fp` text COLLATE utf8mb4_unicode_ci,
  `time_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `ndp`, `nama`, `email`, `phone`, `kp`, `jantina`, `agama`, `status_kahwin`, `bangsa`, `image_url`, `password`, `fp`, `time_add`, `time_edit`) VALUES
(6, 4, 12312321, 'Izmeer Aiman', 'izmeera2000@gmail.com', 123213213, 21321312, '0', 'Lain-lain', 'Tidak Berkahwin', 'asdasd', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', NULL, '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(7, 1, NULL, 'Izmeer Aiman', 'aa@gmail.com', 51511, 21321321, '0', 'Lain-lain', 'Tidak Berkahwin', 'asdasd', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', NULL, '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(18, 4, 12312322, 'Izmeer Aiman', 'asddasdsa2@gmail.com', 1232132132, 213213122, '0', 'Lain-lain', 'Tidak Berkahwin', 'asdasd', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', NULL, '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(21, 4, 511, '5151', 'morax8000@gmail.com', 5151, 5151, '0', 'Islam', 'Tidak Berkahwin', 'asdasd', 'gambar.png', '717d8b3d60d9eea997b35b02b6a4e867', NULL, '2024-09-02 20:03:02', '2024-09-02 20:03:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `nama`) VALUES
(1, 'ADMIN'),
(2, 'PENYELIA'),
(3, 'PENSYARAH'),
(4, 'STUDENT');

-- --------------------------------------------------------

--
-- Table structure for table `user_sem`
--

DROP TABLE IF EXISTS `user_sem`;
CREATE TABLE IF NOT EXISTS `user_sem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `sem_start` int DEFAULT NULL,
  `sem_end` int DEFAULT NULL,
  `sem_now` int DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sem_end` (`sem_end`),
  KEY `sem_now` (`sem_now`),
  KEY `sem_start` (`sem_start`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `user_role` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_sem`
--
ALTER TABLE `user_sem`
  ADD CONSTRAINT `user_sem_ibfk_1` FOREIGN KEY (`sem_end`) REFERENCES `sem` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_sem_ibfk_2` FOREIGN KEY (`sem_now`) REFERENCES `sem` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_sem_ibfk_3` FOREIGN KEY (`sem_start`) REFERENCES `sem` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
