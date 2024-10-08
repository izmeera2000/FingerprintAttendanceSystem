-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 04, 2024 at 04:10 PM
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
  `event_status` tinyint DEFAULT '1',
  `masa_mula` datetime DEFAULT NULL,
  `masa_tamat` datetime DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `time_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `event_status`, `masa_mula`, `masa_tamat`, `type`, `time_add`, `time_edit`) VALUES
(1, 6, 1, '2024-09-04 08:46:41', '2024-09-04 14:46:41', NULL, '2024-09-04 15:46:57', '2024-09-04 15:46:57'),
(2, 21, 1, '2024-09-04 15:46:41', '2024-09-04 17:46:41', NULL, '2024-09-04 15:46:57', '2024-09-04 15:46:57'),
(3, 21, 0, '2024-09-04 17:46:41', '2024-09-04 18:00:00', NULL, '2024-09-04 15:46:57', '2024-09-04 15:46:57'),
(9, 7, 1, '2024-09-04 23:34:10', '2024-09-04 23:34:23', NULL, '2024-09-04 23:34:10', '2024-09-04 23:34:10');

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
  `jantina` int DEFAULT NULL,
  `agama` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kahwin` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bangsa` varchar(99) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `time_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_edit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `ndp`, `nama`, `email`, `phone`, `kp`, `jantina`, `agama`, `status_kahwin`, `bangsa`, `image_url`, `password`, `time_add`, `time_edit`) VALUES
(6, 2, 12312321, 'Izmeer Aiman', 'izmeera2000@gmail.com', 123213213, 21321312, 0, 'Lain-lain', 'Tidak Berkahwin', 'asdasd', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(7, 1, NULL, 'Izmeer Aiman', 'aa@gmail.com', 51511, 21321321, 0, 'Lain-lain', 'Tidak Berkahwin', 'asdasd', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(18, 2, 12312322, 'Izmeer Aiman', 'asddasdsa2@gmail.com', 1232132132, 213213122, 0, 'Lain-lain', 'Tidak Berkahwin', 'asdasd', 'gambar.png', 'a8f5f167f44f4964e6c998dee827110c', '2024-08-28 14:58:58', '2024-08-28 14:58:58'),
(21, 2, 511, '5151', 'morax8000@gmail.com', 5151, 5151, 0, 'Islam', 'Tidak Berkahwin', 'asdasd', 'gambar.png', '717d8b3d60d9eea997b35b02b6a4e867', '2024-09-02 20:03:02', '2024-09-02 20:03:02');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
