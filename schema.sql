CREATE DATABASE IF NOT EXISTS `paytour_test`;

USE `paytour_test`;

CREATE TABLE `submissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `desired_position` varchar(255) NOT NULL,
  `education_level` varchar(100) NOT NULL,
  `observations` text,
  `file_path` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `submitted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
