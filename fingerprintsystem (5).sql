-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 16, 2024 at 02:36 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(78, 6, NULL, NULL, 1, '2024-12-01 14:42:16', '2024-12-01 15:42:16', NULL, '2024-11-26 12:42:16', '2024-12-01 03:49:10'),
(79, 6, NULL, NULL, 1, '2024-12-08 14:42:16', '2024-12-08 15:42:16', NULL, '2024-11-26 12:42:16', '2024-12-01 03:49:10');

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
  `verify_att` int DEFAULT NULL,
  `lect_id` int DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`slot`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_slot`
--

INSERT INTO `attendance_slot` (`id`, `user_id`, `slot`, `slot_status`, `tarikh`, `reason`, `file_path`, `tarikh2`, `verify`, `verify_att`, `lect_id`, `time_add`, `time_edit`) VALUES
(71, 6, 'slot1', 1, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:31:35'),
(72, 6, 'rehat1', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:05'),
(73, 6, 'slot2', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-14 16:04:55'),
(74, 6, 'slot3', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, 7, '2024-12-11 20:46:48', '2024-12-11 22:06:21'),
(75, 6, 'rehat2', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(76, 6, 'slot4', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(77, 6, 'slot5', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(78, 18, 'slot1', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(79, 18, 'rehat1', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(80, 18, 'slot2', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-14 16:04:57'),
(81, 18, 'slot3', 0, '2024-12-11', NULL, NULL, NULL, 0, 0, 7, '2024-12-11 20:46:48', '2024-12-11 22:06:23'),
(82, 18, 'rehat2', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(83, 18, 'slot4', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(84, 18, 'slot5', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(85, 21, 'slot1', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(86, 21, 'rehat1', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(87, 21, 'slot2', 0, '2024-12-11', NULL, NULL, NULL, 1, 7, NULL, '2024-12-11 20:46:48', '2024-12-14 16:07:00'),
(88, 21, 'slot3', 0, '2024-12-11', NULL, NULL, NULL, 1, 7, 7, '2024-12-11 20:46:48', '2024-12-15 19:40:01'),
(89, 21, 'rehat2', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(90, 21, 'slot4', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-14 15:50:05'),
(91, 21, 'slot5', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(92, 22, 'slot1', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(93, 22, 'rehat1', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(94, 22, 'slot2', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-14 16:04:58'),
(95, 22, 'slot3', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, 7, '2024-12-11 20:46:48', '2024-12-11 22:06:26'),
(96, 22, 'rehat2', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(97, 22, 'slot4', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(98, 22, 'slot5', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(99, 23, 'slot1', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(100, 23, 'rehat1', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(101, 23, 'slot2', 0, '2024-12-11', NULL, NULL, NULL, 1, 7, NULL, '2024-12-11 20:46:48', '2024-12-14 16:07:00'),
(102, 23, 'slot3', 0, '2024-12-11', NULL, NULL, NULL, 1, 7, 7, '2024-12-11 20:46:48', '2024-12-15 19:40:01'),
(103, 23, 'rehat2', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(104, 23, 'slot4', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-14 15:50:07'),
(105, 23, 'slot5', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(106, 25, 'slot1', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(107, 25, 'rehat1', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(108, 25, 'slot2', 0, '2024-12-11', NULL, NULL, NULL, 1, 7, NULL, '2024-12-11 20:46:48', '2024-12-14 16:07:00'),
(109, 25, 'slot3', 0, '2024-12-11', NULL, NULL, NULL, 1, 7, 7, '2024-12-11 20:46:48', '2024-12-15 19:40:01'),
(110, 25, 'rehat2', 6, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16'),
(111, 25, 'slot4', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-14 15:50:10'),
(112, 25, 'slot5', 0, '2024-12-11', NULL, NULL, NULL, 1, 0, NULL, '2024-12-11 20:46:48', '2024-12-11 21:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `bengkel`
--

DROP TABLE IF EXISTS `bengkel`;
CREATE TABLE IF NOT EXISTS `bengkel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` text COLLATE utf8mb4_unicode_ci,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bengkel`
--

INSERT INTO `bengkel` (`id`, `nama`, `time_add`, `time_edit`) VALUES
(1, 'Komputer\r\n', '2024-12-01 02:36:57', '2024-12-01 02:36:57'),
(2, 'MEKA', '2024-12-01 02:37:16', '2024-12-01 02:37:16'),
(3, 'MICROE', '2024-12-01 02:37:21', '2024-12-01 02:37:21'),
(4, 'JK', '2024-12-01 02:37:24', '2024-12-01 02:37:24'),
(5, 'POLIMER', '2024-12-01 02:37:27', '2024-12-01 02:37:27'),
(6, 'KOMPOSIT', '2024-12-01 02:37:53', '2024-12-01 02:37:53'),
(7, 'SERAMIK', '2024-12-01 02:37:56', '2024-12-01 02:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bengkel_id` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `masa_mula` datetime DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `nama`, `bengkel_id`, `created_by`, `masa_mula`, `time_add`, `time_edit`) VALUES
(1, 'DTK Komputer', 1, NULL, NULL, '2024-11-21 12:45:35', '2024-12-16 04:03:20'),
(2, 'DT KOMPUTER', 1, NULL, NULL, '2024-12-08 11:32:44', '2024-12-08 14:39:14');

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
(1, 1, 2, '2024-11-18 23:05:43', '2024-12-16 05:29:04');

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
  `bengkel_id` int DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `location`, `fp_entrance`, `fp_exit`, `bengkel_id`, `time_add`, `time_edit`) VALUES
(1, 'Makmal Komputer', 'Makmal Test', 1, 2, 1, '2024-11-02 17:52:09', '2024-12-08 16:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

DROP TABLE IF EXISTS `program`;
CREATE TABLE IF NOT EXISTS `program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_by` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `sem_id` int DEFAULT NULL,
  `bengkel_id` int DEFAULT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `uniq_id` varchar(33) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarikh_mula` datetime DEFAULT NULL,
  `tarikh_tamat` datetime DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `created_by`, `course_id`, `sem_id`, `bengkel_id`, `nama`, `uniq_id`, `tarikh_mula`, `tarikh_tamat`, `time_add`, `time_edit`) VALUES
(113, 7, 1, 2, NULL, 'test', '1', '2024-12-15 08:00:00', '2024-12-17 13:00:00', '2024-12-16 16:15:24', '2024-12-16 16:15:24'),
(114, 7, 2, 2, NULL, 'test', '1', '2024-12-15 08:00:00', '2024-12-17 13:00:00', '2024-12-16 16:15:24', '2024-12-16 16:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `program_attendance`
--

DROP TABLE IF EXISTS `program_attendance`;
CREATE TABLE IF NOT EXISTS `program_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `scan_by` int DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_attendance`
--

INSERT INTO `program_attendance` (`id`, `program_id`, `student_id`, `scan_by`, `time_add`, `time_edit`) VALUES
(6, 1, 21, 7, '2024-12-16 19:46:32', '2024-12-16 19:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `sem`
--

DROP TABLE IF EXISTS `sem`;
CREATE TABLE IF NOT EXISTS `sem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` text COLLATE utf8mb4_unicode_ci,
  `created_by` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sem`
--

INSERT INTO `sem` (`id`, `nama`, `created_by`, `start_date`, `end_date`, `time_add`, `time_edit`) VALUES
(1, '1/2024', NULL, '2024-01-01', '2024-06-06', '2024-11-02 17:57:50', '2024-11-02 17:57:50'),
(2, '2/2024', NULL, '2024-07-01', '2024-12-06', '2024-11-21 12:17:11', '2024-11-27 07:58:38'),
(3, '1/2025', NULL, '2025-01-01', '2025-06-06', '2024-11-21 12:18:10', '2024-12-07 15:45:08'),
(4, '2/2025', NULL, '2025-07-01', '2025-12-06', '2024-11-21 12:18:24', '2024-12-07 15:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `subjek`
--

DROP TABLE IF EXISTS `subjek`;
CREATE TABLE IF NOT EXISTS `subjek` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subjek_nama` text COLLATE utf8mb4_unicode_ci,
  `subjek_kod` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjek`
--

INSERT INTO `subjek` (`id`, `subjek_nama`, `subjek_kod`, `created_by`, `time_add`, `time_edit`) VALUES
(1, 'test', 'test', 7, '2024-11-30 11:51:36', '2024-12-02 03:14:13'),
(2, 'test2', 'test2', 7, '2024-11-30 11:51:36', '2024-12-02 03:14:13'),
(3, 'test3', 'test3', NULL, '2024-12-16 04:12:43', '2024-12-16 04:12:43');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

DROP TABLE IF EXISTS `time_slot`;
CREATE TABLE IF NOT EXISTS `time_slot` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slot` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nama` int DEFAULT NULL,
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

INSERT INTO `time_slot` (`id`, `slot`, `nama`, `masa_mula`, `masa_tamat`, `masa_mula2`, `masa_tamat2`, `time_add`, `time_edit`) VALUES
(1, 'slot1', 1, '08:00:00', '09:30:00', NULL, NULL, '2024-10-29 15:45:48', '2024-12-16 15:07:00'),
(2, 'rehat1', NULL, '09:30:00', '10:00:00', NULL, NULL, '2024-10-29 15:45:48', '2024-11-02 17:26:21'),
(3, 'slot2', 2, '10:00:00', '11:30:00', NULL, NULL, '2024-10-29 15:45:48', '2024-12-16 15:07:02'),
(4, 'slot3', 3, '11:30:00', '13:00:00', '11:30:00', '12:15:00', '2024-10-29 15:45:48', '2024-12-16 15:07:03'),
(5, 'rehat2', NULL, '13:00:00', '14:00:00', '12:15:00', '14:45:00', '2024-10-29 15:45:48', '2024-11-29 04:13:01'),
(6, 'slot4', 4, '14:00:00', '15:30:00', '14:45:00', '15:30:00', '2024-10-29 15:45:48', '2024-12-16 15:07:05'),
(7, 'slot5', 5, '15:30:00', '17:00:00', NULL, NULL, '2024-10-29 15:45:48', '2024-12-16 15:07:07');

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
  `bengkel_id` int DEFAULT NULL,
  `waris_nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `waris_phone` text COLLATE utf8mb4_unicode_ci,
  `time_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `ndp`, `nama`, `email`, `phone`, `kp`, `jantina`, `agama`, `status_kahwin`, `bangsa`, `image_url`, `password`, `bengkel_id`, `waris_nama`, `waris_phone`, `time_add`, `time_edit`) VALUES
(6, 4, '29124075', 'DIN', 'morax8000@gmail.com', '1123606009', '21321312', '0', 'Lain-lain', 'Tidak Berkahwin', 'Melayu', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', 1, NULL, NULL, '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(7, 1, NULL, 'JAZ', 'aa@gmail.com', '51511', '21321321', '0', 'Lain-lain', 'Tidak Berkahwin', 'Melayu', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', 1, NULL, NULL, '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(18, 4, '29124021', 'SITI', '29124021@adtectaiping.edu.my', '143915786', '213213122', '0', 'Lain-lain', 'Tidak Berkahwin', 'Melayu', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', 1, NULL, NULL, '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(21, 4, '29124074', 'HIJAZI', '29124074@adtectaiping.edu.my', '1112456300', '5151', '0', 'Islam', 'Tidak Berkahwin', 'Melayu', 'gambar.png', '717d8b3d60d9eea997b35b02b6a4e867', 1, NULL, NULL, '2024-09-02 20:03:02', '2024-09-02 20:03:02'),
(22, 4, '29224158', 'nurin', 'nurin7@gmail.com', '713028758', '2147483647', 'Perempuan', 'Hindu', 'Tidak Berkahwin', 'India', 'gambar.jpg', 'a8f5f167f44f4964e6c998dee827110c', 1, NULL, NULL, '2024-11-26 01:32:21', '2024-11-26 01:32:21'),
(23, 4, '29224159', 'test', 'saerahhassan603@gmail.com\n', '13082', '2147483647', 'Lelaki', 'Kristian', 'Tidak Berkahwin', 'India', 'gambar.jpg', 'a8f5f167f44f4964e6c998dee827110c', 1, NULL, NULL, '2024-11-26 03:47:22', '2024-11-26 03:47:22'),
(24, 1, NULL, 'JAZA', 'aa5@gmail.com', '51512', '21321325', '0', 'Lain-lain', 'Tidak Berkahwin', 'Melayu', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', 1, NULL, NULL, '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(25, 4, '12312321', '12312312', '312312@gmail.com', '0112321', '1322131231', 'Lelaki', 'Hindu', 'Tidak Berkahwin', 'asdasd', 'gambar.jpg', 'a8f5f167f44f4964e6c998dee827110c', 1, NULL, NULL, '2024-12-06 06:05:12', '2024-12-06 06:05:12');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_enroll`
--

INSERT INTO `user_enroll` (`id`, `user_id`, `course_id`, `sem_start`, `sem_end`, `sem_now`, `user_status`, `verified`, `time_add`, `time_edit`) VALUES
(1, 21, 1, 1, 2, 2, 1, NULL, '2024-11-25 18:33:29', '2024-12-06 13:52:52'),
(2, 18, 2, 1, 2, 2, 0, NULL, '2024-11-25 18:33:29', '2024-12-08 22:34:15'),
(3, 6, 2, 2, 3, 2, 1, NULL, '2024-11-25 18:33:29', '2024-12-08 12:02:48'),
(5, 22, 1, 2, 2, 2, 1, NULL, '2024-11-25 18:33:29', '2024-12-08 22:34:06'),
(6, 23, 1, 1, 2, 2, 1, NULL, '2024-11-25 18:33:29', '2024-12-06 13:52:58'),
(7, 25, 1, 1, 2, 2, 1, NULL, '2024-12-06 14:05:12', '2024-12-06 14:12:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_fp`
--

DROP TABLE IF EXISTS `user_fp`;
CREATE TABLE IF NOT EXISTS `user_fp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `kelas_id` int NOT NULL,
  `fp_num` int DEFAULT NULL,
  `fp_status` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_add` datetime DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_fp`
--

INSERT INTO `user_fp` (`id`, `user_id`, `kelas_id`, `fp_num`, `fp_status`, `time_add`, `time_edit`) VALUES
(4, 18, 1, 2, NULL, '2024-12-08 19:12:54', '2024-12-15 18:43:32'),
(5, 6, 1, 1, NULL, '2024-12-08 19:18:09', '2024-12-14 17:01:05'),
(6, 23, 1, 3, NULL, '2024-12-15 18:42:22', '2024-12-15 18:43:34');

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
  `sign_path` text COLLATE utf8mb4_unicode_ci,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_staff`
--

INSERT INTO `user_staff` (`id`, `user_id`, `course_id`, `sign_path`, `time_add`, `time_edit`) VALUES
(1, 7, 1, '7.png', '2024-11-30 17:00:27', '2024-12-02 16:01:17'),
(2, 24, 1, NULL, '2024-11-30 17:00:27', '2024-11-30 17:00:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_staff_absence`
--

DROP TABLE IF EXISTS `user_staff_absence`;
CREATE TABLE IF NOT EXISTS `user_staff_absence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `tarikh_mula` date NOT NULL,
  `tarikh_tamat` date NOT NULL,
  `assign_to` int NOT NULL,
  `verify` int DEFAULT '0',
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_staff_absence`
--

INSERT INTO `user_staff_absence` (`id`, `user_id`, `tarikh_mula`, `tarikh_tamat`, `assign_to`, `verify`, `time_add`, `time_edit`) VALUES
(1, 7, '2024-12-01', '2024-12-05', 24, 1, '2024-12-02 16:18:33', '2024-12-02 16:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_subjek`
--

DROP TABLE IF EXISTS `user_subjek`;
CREATE TABLE IF NOT EXISTS `user_subjek` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int DEFAULT NULL,
  `subjek_id` int DEFAULT NULL,
  `assign_to` int DEFAULT NULL,
  `day` int DEFAULT NULL,
  `slot_id` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `sem_id` int DEFAULT NULL,
  `tarikh_mula` date DEFAULT NULL,
  `tarikh_tamat` date DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_subjek`
--

INSERT INTO `user_subjek` (`id`, `course_id`, `subjek_id`, `assign_to`, `day`, `slot_id`, `status`, `sem_id`, `tarikh_mula`, `tarikh_tamat`, `time_add`, `time_edit`) VALUES
(2, 1, 1, 7, 4, 3, 1, 2, '2024-11-01', '2024-12-31', '2024-12-01 19:23:24', '2024-12-01 19:23:24'),
(3, 1, 2, 7, 4, 4, 1, 2, '2024-11-01', '2024-12-31', '2024-12-01 19:23:24', '2024-12-01 19:23:24');

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
