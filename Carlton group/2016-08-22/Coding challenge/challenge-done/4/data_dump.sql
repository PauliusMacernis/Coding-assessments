-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.5111
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for acme
CREATE DATABASE IF NOT EXISTS `acme` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `acme`;

-- Dumping structure for table acme.department
CREATE TABLE IF NOT EXISTS `department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text,
  `url` varchar(2083) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `opening_hours` varchar(200) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Active - 1, not active - 0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COMMENT='Acme''s departments\r\nColumns could be extended with these if needed: https://schema.org/Organization';

-- Dumping data for table acme.department: ~17 rows (approximately)
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` (`id`, `title`, `description`, `url`, `logo`, `opening_hours`, `active`, `created`, `updated`) VALUES
	(1, 'A', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:23:28', '2016-08-22 02:23:28'),
	(2, 'IT', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:23:59', '2016-08-22 04:34:23'),
	(3, 'C', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:24:04', '2016-08-22 02:24:04'),
	(4, 'D', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:24:09', '2016-08-22 02:24:09'),
	(5, 'E', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:24:48', '2016-08-22 02:24:48'),
	(6, 'F', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:24:53', '2016-08-22 02:24:53'),
	(7, 'O', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:25:11', '2016-08-22 02:25:11'),
	(8, 'P', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:25:15', '2016-08-22 02:25:15'),
	(9, 'G', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:26:18', '2016-08-22 02:26:18'),
	(10, 'H', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:26:26', '2016-08-22 02:26:26'),
	(11, 'I', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:26:30', '2016-08-22 02:26:30'),
	(12, 'R', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:26:43', '2016-08-22 02:26:43'),
	(13, 'J', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:27:03', '2016-08-22 02:27:03'),
	(14, 'K', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:27:30', '2016-08-22 02:27:30'),
	(15, 'L', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:27:40', '2016-08-22 02:27:40'),
	(16, 'M', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:27:44', '2016-08-22 02:27:44'),
	(17, 'N', NULL, NULL, NULL, NULL, 0, '2016-08-22 02:27:50', '2016-08-22 02:27:50');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;

-- Dumping structure for table acme.department_department
CREATE TABLE IF NOT EXISTS `department_department` (
  `department_id_father` int(10) unsigned NOT NULL,
  `department_id_child` int(10) unsigned NOT NULL,
  `hierarchy_level` tinyint(3) unsigned NOT NULL COMMENT 'Starting from 0 (points to self) and adding by one each time the new hierarchy level is reached',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`department_id_father`,`department_id_child`),
  KEY `FK_department_department_dchild` (`department_id_child`),
  CONSTRAINT `FK_department_department_dchild` FOREIGN KEY (`department_id_child`) REFERENCES `department` (`id`),
  CONSTRAINT `FK_department_department_dfather` FOREIGN KEY (`department_id_father`) REFERENCES `department` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Relations between departments - the hierarchy.';

-- Dumping data for table acme.department_department: ~64 rows (approximately)
/*!40000 ALTER TABLE `department_department` DISABLE KEYS */;
INSERT INTO `department_department` (`department_id_father`, `department_id_child`, `hierarchy_level`, `created`, `updated`) VALUES
	(1, 1, 1, '2016-08-22 02:23:28', '2016-08-22 02:23:28'),
	(1, 2, 2, '2016-08-22 02:23:59', '2016-08-22 02:23:59'),
	(1, 3, 2, '2016-08-22 02:24:04', '2016-08-22 02:24:04'),
	(1, 4, 2, '2016-08-22 02:24:09', '2016-08-22 02:24:09'),
	(1, 5, 3, '2016-08-22 02:24:48', '2016-08-22 02:24:48'),
	(1, 6, 3, '2016-08-22 02:24:53', '2016-08-22 02:24:53'),
	(1, 7, 3, '2016-08-22 02:25:11', '2016-08-22 02:25:11'),
	(1, 8, 3, '2016-08-22 02:25:15', '2016-08-22 02:25:15'),
	(1, 9, 4, '2016-08-22 02:26:18', '2016-08-22 02:26:18'),
	(1, 10, 4, '2016-08-22 02:26:26', '2016-08-22 02:26:26'),
	(1, 11, 4, '2016-08-22 02:26:30', '2016-08-22 02:26:30'),
	(1, 12, 4, '2016-08-22 02:26:43', '2016-08-22 02:26:43'),
	(1, 13, 5, '2016-08-22 02:27:03', '2016-08-22 02:27:03'),
	(1, 14, 6, '2016-08-22 02:27:30', '2016-08-22 02:27:30'),
	(1, 15, 6, '2016-08-22 02:27:40', '2016-08-22 02:27:40'),
	(1, 16, 6, '2016-08-22 02:27:44', '2016-08-22 02:27:44'),
	(1, 17, 6, '2016-08-22 02:27:50', '2016-08-22 02:27:50'),
	(2, 2, 2, '2016-08-22 02:23:59', '2016-08-22 02:23:59'),
	(2, 5, 3, '2016-08-22 02:24:48', '2016-08-22 02:24:48'),
	(2, 6, 3, '2016-08-22 02:24:53', '2016-08-22 02:24:53'),
	(2, 9, 4, '2016-08-22 02:26:18', '2016-08-22 02:26:18'),
	(2, 10, 4, '2016-08-22 02:26:26', '2016-08-22 02:26:26'),
	(2, 11, 4, '2016-08-22 02:26:30', '2016-08-22 02:26:30'),
	(2, 13, 5, '2016-08-22 02:27:03', '2016-08-22 02:27:03'),
	(2, 14, 6, '2016-08-22 02:27:30', '2016-08-22 02:27:30'),
	(2, 15, 6, '2016-08-22 02:27:40', '2016-08-22 02:27:40'),
	(2, 16, 6, '2016-08-22 02:27:44', '2016-08-22 02:27:44'),
	(2, 17, 6, '2016-08-22 02:27:50', '2016-08-22 02:27:50'),
	(3, 3, 2, '2016-08-22 02:24:04', '2016-08-22 02:24:04'),
	(4, 4, 2, '2016-08-22 02:24:09', '2016-08-22 02:24:09'),
	(4, 7, 3, '2016-08-22 02:25:11', '2016-08-22 02:25:11'),
	(4, 8, 3, '2016-08-22 02:25:15', '2016-08-22 02:25:15'),
	(4, 12, 4, '2016-08-22 02:26:43', '2016-08-22 02:26:43'),
	(5, 5, 3, '2016-08-22 02:24:48', '2016-08-22 02:24:48'),
	(6, 6, 3, '2016-08-22 02:24:53', '2016-08-22 02:24:53'),
	(6, 9, 4, '2016-08-22 02:26:18', '2016-08-22 02:26:18'),
	(6, 10, 4, '2016-08-22 02:26:26', '2016-08-22 02:26:26'),
	(6, 11, 4, '2016-08-22 02:26:30', '2016-08-22 02:26:30'),
	(6, 13, 5, '2016-08-22 02:27:03', '2016-08-22 02:27:03'),
	(6, 14, 6, '2016-08-22 02:27:30', '2016-08-22 02:27:30'),
	(6, 15, 6, '2016-08-22 02:27:40', '2016-08-22 02:27:40'),
	(6, 16, 6, '2016-08-22 02:27:44', '2016-08-22 02:27:44'),
	(6, 17, 6, '2016-08-22 02:27:50', '2016-08-22 02:27:50'),
	(7, 7, 3, '2016-08-22 02:25:11', '2016-08-22 02:25:11'),
	(8, 8, 3, '2016-08-22 02:25:15', '2016-08-22 02:25:15'),
	(8, 12, 4, '2016-08-22 02:26:43', '2016-08-22 02:26:43'),
	(9, 9, 4, '2016-08-22 02:26:18', '2016-08-22 02:26:18'),
	(10, 10, 4, '2016-08-22 02:26:26', '2016-08-22 02:26:26'),
	(11, 11, 4, '2016-08-22 02:26:30', '2016-08-22 02:26:30'),
	(11, 13, 5, '2016-08-22 02:27:03', '2016-08-22 02:27:03'),
	(11, 14, 6, '2016-08-22 02:27:30', '2016-08-22 02:27:30'),
	(11, 15, 6, '2016-08-22 02:27:40', '2016-08-22 02:27:40'),
	(11, 16, 6, '2016-08-22 02:27:44', '2016-08-22 02:27:44'),
	(11, 17, 6, '2016-08-22 02:27:50', '2016-08-22 02:27:50'),
	(12, 12, 4, '2016-08-22 02:26:43', '2016-08-22 02:26:43'),
	(13, 13, 5, '2016-08-22 02:27:03', '2016-08-22 02:27:03'),
	(13, 14, 6, '2016-08-22 02:27:30', '2016-08-22 02:27:30'),
	(13, 15, 6, '2016-08-22 02:27:40', '2016-08-22 02:27:40'),
	(13, 16, 6, '2016-08-22 02:27:44', '2016-08-22 02:27:44'),
	(13, 17, 6, '2016-08-22 02:27:50', '2016-08-22 02:27:50'),
	(14, 14, 6, '2016-08-22 02:27:30', '2016-08-22 02:27:30'),
	(15, 15, 6, '2016-08-22 02:27:40', '2016-08-22 02:27:40'),
	(16, 16, 6, '2016-08-22 02:27:44', '2016-08-22 02:27:44'),
	(17, 17, 6, '2016-08-22 02:27:50', '2016-08-22 02:27:50');
/*!40000 ALTER TABLE `department_department` ENABLE KEYS */;

-- Dumping structure for table acme.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `job_title` varchar(200) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `working_start` date DEFAULT NULL,
  `working_end` date DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT '0' COMMENT 'Active - 1, not active - 0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_employee_department` (`department_id`),
  CONSTRAINT `FK_employee_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='Someone working for Acme.\r\nColumns could be extended with these if needed: https://schema.org/Person';

-- Dumping data for table acme.employee: ~5 rows (approximately)
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` (`id`, `department_id`, `name`, `surname`, `address`, `birth_date`, `email`, `job_title`, `image`, `working_start`, `working_end`, `active`, `created`, `updated`) VALUES
	(1, NULL, 'P', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-08-21 00:15:43', '2016-08-21 00:15:43'),
	(2, NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-08-21 00:15:53', '2016-08-21 00:15:53'),
	(3, NULL, 'K', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-08-21 00:16:01', '2016-08-21 00:16:01'),
	(4, NULL, 'H', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-08-21 00:16:11', '2016-08-21 00:16:11'),
	(5, NULL, 'T', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2016-08-21 00:16:18', '2016-08-21 00:16:18');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
