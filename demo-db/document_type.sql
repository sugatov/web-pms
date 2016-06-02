-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.13-MariaDB-1~jessie - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- Dumping data for table pms.document_type: ~6 rows (approximately)
/*!40000 ALTER TABLE `document_type` DISABLE KEYS */;
INSERT INTO `document_type` (`id`, `created`, `updated`, `name`) VALUES
	(1, '2016-05-29 15:01:38', '2016-05-29 15:01:38', 'Паспорт гражданина РФ'),
	(2, '2016-05-29 15:01:51', '2016-05-29 15:01:51', 'Свидетельство о рождении (РФ)'),
	(3, '2016-05-29 15:25:57', '2016-05-29 15:30:09', 'Паспорт гражданина иного государства'),
	(4, '2016-05-29 15:26:31', '2016-05-29 15:26:31', 'Водительские права (РФ)'),
	(5, '2016-05-29 15:26:59', '2016-05-29 15:29:00', 'Военный билет (РФ)'),
	(6, '2016-05-29 15:29:30', '2016-05-29 15:29:30', 'Другой документ');
/*!40000 ALTER TABLE `document_type` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

