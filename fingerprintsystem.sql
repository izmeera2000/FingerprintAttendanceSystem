-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 30, 2024 at 09:35 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `fp_id_in`, `fp_id_out`, `event_status`, `masa_mula`, `masa_tamat`, `type`, `time_add`, `time_edit`) VALUES
(69, 21, NULL, NULL, 1, '2024-11-26 01:24:12', '2024-11-26 01:24:56', NULL, '2024-11-26 01:24:12', '2024-11-26 01:24:56'),
(70, 21, NULL, NULL, 1, '2024-11-26 01:27:16', '2024-11-26 01:28:16', NULL, '2024-11-26 01:27:16', '2024-11-29 04:05:17'),
(71, 18, NULL, NULL, 1, '2024-11-26 09:25:35', '2024-11-26 09:27:05', NULL, '2024-11-26 09:25:35', '2024-11-26 09:27:05'),
(73, 6, NULL, NULL, 1, '2024-11-26 10:00:31', '2024-11-26 12:11:40', NULL, '2024-11-26 10:00:31', '2024-11-26 12:11:40'),
(74, 22, NULL, NULL, 1, '2024-11-26 10:14:49', '2024-11-26 10:15:49', NULL, '2024-11-26 10:14:49', '2024-11-29 04:05:13'),
(76, 6, NULL, NULL, 1, '2024-11-26 12:42:16', '2024-11-26 12:46:16', NULL, '2024-11-26 12:42:16', '2024-11-29 04:05:07'),
(77, 6, NULL, NULL, 1, '2024-11-29 09:42:16', '2024-11-29 11:42:16', NULL, '2024-11-26 12:42:16', '2024-11-29 20:13:44'),
(78, 6, NULL, NULL, 1, '2024-11-29 14:42:16', '2024-11-29 15:42:16', NULL, '2024-11-26 12:42:16', '2024-11-29 20:13:44');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`slot`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_slot`
--

INSERT INTO `attendance_slot` (`id`, `user_id`, `slot`, `slot_status`, `tarikh`, `reason`, `file_path`, `tarikh2`, `verify`, `lect_id`, `time_add`, `time_edit`) VALUES
(1, 6, 'slot1', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(2, 6, 'rehat1', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(3, 6, 'slot2', 1, '2024-11-29', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-29 20:27:38'),
(4, 6, 'slot3', 5, '2024-11-29', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-29 20:27:38'),
(5, 6, 'rehat2', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(6, 6, 'slot4', 5, '2024-11-29', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-29 20:27:38'),
(7, 6, 'slot5', 5, '2024-11-29', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-29 20:27:38'),
(15, 18, 'slot1', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(16, 18, 'rehat1', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(17, 18, 'slot2', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(18, 18, 'slot3', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(19, 18, 'rehat2', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(20, 18, 'slot4', 7, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(21, 18, 'slot5', 7, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(22, 21, 'slot1', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(23, 21, 'rehat1', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(24, 21, 'slot2', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(25, 21, 'slot3', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(26, 21, 'rehat2', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(27, 21, 'slot4', 7, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(28, 21, 'slot5', 7, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(29, 22, 'slot1', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(30, 22, 'rehat1', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(31, 22, 'slot2', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(32, 22, 'slot3', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(33, 22, 'rehat2', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(34, 22, 'slot4', 7, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(35, 22, 'slot5', 7, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(36, 23, 'slot1', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(37, 23, 'rehat1', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(38, 23, 'slot2', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(39, 23, 'slot3', 0, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(40, 23, 'rehat2', 6, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(41, 23, 'slot4', 7, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00'),
(42, 23, 'slot5', 7, '2024-11-30', NULL, NULL, NULL, NULL, NULL, '2024-11-29 20:27:38', '2024-11-30 11:45:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `nama`, `masa_mula`, `time_add`, `time_edit`) VALUES
(1, 'DTK Komputer', NULL, '2024-11-21 12:45:35', '2024-11-21 12:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `rate1` float DEFAULT NULL,
  `rate2` float DEFAULT NULL,
  `rate3` float DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `nama`, `content`, `rate1`, `rate2`, `rate3`, `time_add`, `time_edit`) VALUES
(1, 'Test', 'test', 3.5, NULL, NULL, '2024-11-21 15:07:33', '2024-11-21 15:28:43'),
(11, 'Jaz', 'Nice', 5, 5, 5, '2024-11-22 02:34:15', '2024-11-22 02:34:15'),
(12, 'Din', '', 5, 5, 5, '2024-11-22 02:39:18', '2024-11-22 02:39:18'),
(13, 'Morax', '', 5, 5, 5, '2024-11-22 02:39:26', '2024-11-22 02:39:26'),
(14, 'admin', '', 5, 5, 5, '2024-11-22 02:39:34', '2024-11-22 02:39:34'),
(15, 'haris', '', 5, 5, 5, '2024-11-22 02:39:43', '2024-11-22 02:39:43'),
(16, 'ahmad', '', 5, 5, 5, '2024-11-22 02:39:49', '2024-11-22 02:39:49'),
(17, 'syazili', '', 5, 5, 5, '2024-11-22 02:39:58', '2024-11-22 02:39:58'),
(18, 'Siti Rosnadia', '', 5, 5, 5, '2024-11-26 10:32:59', '2024-11-26 10:32:59'),
(19, 'Fariez', '', 5, 5, 5, '2024-11-26 10:33:25', '2024-11-26 10:33:25'),
(20, 'MUHAMMAD HAZIQ BIN MOHD AZMAN ', '', 5, 5, 5, '2024-11-26 10:53:52', '2024-11-26 10:53:52'),
(21, 'Din', 'Xde', 2, 3.5, 2.5, '2024-11-26 12:47:06', '2024-11-26 12:47:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fp_device`
--

INSERT INTO `fp_device` (`id`, `nama`, `entrance`, `time_add`, `time_edit`) VALUES
(1, 'testin', 1, '2024-11-02 17:52:45', '2024-11-02 17:57:10'),
(2, 'testout', 0, '2024-11-02 17:53:39', '2024-11-02 17:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `fp_settings`
--

DROP TABLE IF EXISTS `fp_settings`;
CREATE TABLE IF NOT EXISTS `fp_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kelas_id` int DEFAULT NULL,
  `mode` int NOT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fp_settings`
--

INSERT INTO `fp_settings` (`id`, `kelas_id`, `mode`, `time_add`, `time_edit`) VALUES
(1, 1, 1, '2024-11-18 23:05:43', '2024-11-29 04:22:45');

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Makmal Komputer', 'Makmal Test', 1, 2, '2024-11-02 17:52:09', '2024-11-29 03:44:19');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sem`
--

INSERT INTO `sem` (`id`, `nama`, `start_date`, `end_date`, `time_add`, `time_edit`) VALUES
(1, '1/2024', '2024-01-01', '2024-06-06', '2024-11-02 17:57:50', '2024-11-02 17:57:50'),
(2, '2/2024', '2024-07-01', '2024-12-06', '2024-11-21 12:17:11', '2024-11-27 07:58:38'),
(3, 'asdasdasda', '0000-00-00', '0000-00-00', '2024-11-21 12:18:10', '2024-11-21 12:18:10'),
(4, 'sadasdas', '0000-00-00', '0000-00-00', '2024-11-21 12:18:24', '2024-11-21 12:18:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjek`
--

INSERT INTO `subjek` (`id`, `subjek_nama`, `subjek_kod`, `time_add`, `time_edit`) VALUES
(1, 'test', 'test', '2024-11-30 11:51:36', '2024-11-30 11:51:36');

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
  `masa_mula2` time DEFAULT NULL,
  `masa_tamat2` time DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`id`, `slot`, `masa_mula`, `masa_tamat`, `masa_mula2`, `masa_tamat2`, `time_add`, `time_edit`) VALUES
(1, 'slot1', '08:00:00', '09:30:00', NULL, NULL, '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(2, 'rehat1', '09:30:00', '10:00:00', NULL, NULL, '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(3, 'slot2', '10:00:00', '11:30:00', NULL, NULL, '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(4, 'slot3', '11:30:00', '13:00:00', NULL, NULL, '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(5, 'rehat2', '13:00:00', '14:00:00', '12:15:00', '14:45:00', '2024-10-29 15:45:48', '2024-11-29 04:13:01'),
(6, 'slot4', '14:00:00', '15:30:00', NULL, NULL, '2024-10-29 15:45:48', '2024-11-02 17:28:04'),
(7, 'slot5', '15:30:00', '17:00:00', NULL, NULL, '2024-10-29 15:45:48', '2024-11-02 17:26:21');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` int DEFAULT NULL,
  `ndp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `ndp`, `nama`, `email`, `phone`, `kp`, `jantina`, `agama`, `status_kahwin`, `bangsa`, `image_url`, `password`, `fp`, `time_add`, `time_edit`) VALUES
(6, 4, '29124075', 'DIN', 'morax8000@gmail.com', '1123606009', '21321312', '0', 'Lain-lain', 'Tidak Berkahwin', 'Melayu', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', 'D', '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(7, 1, NULL, 'JAZ', 'aa@gmail.com', '51511', '21321321', '0', 'Lain-lain', 'Tidak Berkahwin', 'Melayu', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', NULL, '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(18, 4, '29124021', 'SITI', '29124021@adtectaiping.edu.my', '143915786', '213213122', '0', 'Lain-lain', 'Tidak Berkahwin', 'Melayu', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', 'D', '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(21, 4, '29124074', 'HIJAZI', '29124074@adtectaiping.edu.my', '1112456300', '5151', '0', 'Islam', 'Tidak Berkahwin', 'Melayu', 'gambar.png', '717d8b3d60d9eea997b35b02b6a4e867', 'D', '2024-09-02 20:03:02', '2024-09-02 20:03:02'),
(22, 4, '29224158', 'nurin', 'nurin7@gmail.com', '713028758', '2147483647', 'Perempuan', 'Hindu', 'Tidak Berkahwin', 'India', 'gambar.jpg', 'a8f5f167f44f4964e6c998dee827110c', NULL, '2024-11-26 01:32:21', '2024-11-26 01:32:21'),
(23, 4, '29224159', 'test', 'saerahhassan603@gmail.com\n', '13082', '2147483647', 'Lelaki', 'Kristian', 'Tidak Berkahwin', 'India', 'gambar.jpg', 'a8f5f167f44f4964e6c998dee827110c', NULL, '2024-11-26 03:47:22', '2024-11-26 03:47:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_enroll`
--

DROP TABLE IF EXISTS `user_enroll`;
CREATE TABLE IF NOT EXISTS `user_enroll` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `sem_start` int DEFAULT NULL,
  `sem_end` int DEFAULT NULL,
  `sem_now` int DEFAULT NULL,
  `user_status` int DEFAULT NULL,
  `verified` int DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_enroll`
--

INSERT INTO `user_enroll` (`id`, `user_id`, `course_id`, `sem_start`, `sem_end`, `sem_now`, `user_status`, `verified`, `time_add`, `time_edit`) VALUES
(1, 21, 1, 1, 2, 2, 1, NULL, '2024-11-25 18:33:29', '2024-11-25 21:39:18'),
(2, 18, 1, 1, 2, 2, 1, NULL, '2024-11-25 18:33:29', '2024-11-25 21:39:18'),
(3, 6, 1, 1, 2, 2, 1, NULL, '2024-11-25 18:33:29', '2024-11-25 21:39:18'),
(5, 22, 1, 1, 2, 2, 1, NULL, '2024-11-25 18:33:29', '2024-11-25 21:39:18'),
(6, 23, 1, 1, 2, 2, 1, NULL, '2024-11-25 18:33:29', '2024-11-25 21:39:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_fp`
--

DROP TABLE IF EXISTS `user_fp`;
CREATE TABLE IF NOT EXISTS `user_fp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `kelas_id` int NOT NULL,
  `fp_status` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_add` datetime DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_holiday`
--

DROP TABLE IF EXISTS `user_holiday`;
CREATE TABLE IF NOT EXISTS `user_holiday` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `tarikh_mula` datetime DEFAULT NULL,
  `tarikh_tamat` datetime DEFAULT NULL,
  `status` int DEFAULT NULL,
  `bukti` text COLLATE utf8mb4_unicode_ci,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_holiday`
--

INSERT INTO `user_holiday` (`id`, `user_id`, `tarikh_mula`, `tarikh_tamat`, `status`, `bukti`, `time_add`, `time_edit`) VALUES
(1, 6, '2024-11-30 09:42:16', '2024-11-30 19:42:16', NULL, NULL, '2024-11-29 20:13:22', '2024-11-29 20:20:16');

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
-- Table structure for table `user_staff`
--

DROP TABLE IF EXISTS `user_staff`;
CREATE TABLE IF NOT EXISTS `user_staff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `course_id` int NOT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_staff`
--

INSERT INTO `user_staff` (`id`, `user_id`, `course_id`, `time_add`, `time_edit`) VALUES
(1, 6, 1, '2024-11-30 17:00:27', '2024-11-30 17:00:27');

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
-- Constraints for table `user_enroll`
--
ALTER TABLE `user_enroll`
  ADD CONSTRAINT `user_enroll_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_enroll_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
