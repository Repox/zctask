-- --------------------------------------------------------
-- Host:                         33.33.33.15
-- Server version:               5.6.20-1+deb.sury.org~trusty+1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for usersystem
CREATE DATABASE IF NOT EXISTS `usersystem` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `usersystem`;


-- Dumping structure for table usersystem.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table usersystem.groups: ~0 rows (approximately)
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`) VALUES
	(1, 'Hurtiggruppen');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


-- Dumping structure for table usersystem.group_user
CREATE TABLE IF NOT EXISTS `group_user` (
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table usersystem.group_user: ~0 rows (approximately)
/*!40000 ALTER TABLE `group_user` DISABLE KEYS */;
INSERT INTO `group_user` (`group_id`, `user_id`) VALUES
	(1, 3),
	(1, 7);
/*!40000 ALTER TABLE `group_user` ENABLE KEYS */;


-- Dumping structure for table usersystem.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table usersystem.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
	(1, 'storm@err0r.dk', '$2y$10$NxAHFfkfTlAsGW1E2OMZuOJq6.TMttFfuoU51HMFcy2KZI1NCjOZa', '2014-09-05 07:10:42', '2014-09-05 07:44:03'),
	(3, 'mh@example.org', '$2y$10$Y7VNImXEESlaSFzgxXm74OO757GlSdLvF0cfx4GJVfCT0w35jGvTu', '2014-09-05 07:49:47', NULL),
	(4, 'akm@example.org', '$2y$10$3fjL3.2c6Q3o/z/p18JIS.6yMNBtUl1lhdZJaJWt2qYIHxrFqDN4C', '2014-09-05 07:58:25', NULL),
	(5, 'akms@example.org', '$2y$10$xIZQJA.YDVclrt/muxNLtOH4t1kH4Q9oI2OEbcFJKaDUw8DfNZRGi', '2014-09-05 08:01:23', NULL),
	(6, 'akmss@example.org', '$2y$10$C2gDJLdh3EzFpze/GzRzbOEQgMSu.uKhfithbxd8DkTK..DFV2HoK', '2014-09-05 08:01:50', NULL),
	(7, 'akmsss@example.org', '$2y$10$fLvtvLCGXvy3xvCU25U2L.gy5dHpuPPBz1gyzsE9BQi86dCHhqjLG', '2014-09-05 08:01:59', '2014-09-05 08:02:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
