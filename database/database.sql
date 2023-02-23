-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 21, 2023 at 05:35 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `whale_enterprises`
--
CREATE DATABASE IF NOT EXISTS `whale_enterprises` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `whale_enterprises`;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

DROP TABLE IF EXISTS `sectors`;
CREATE TABLE IF NOT EXISTS `sectors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `username`, `sector`) VALUES
(1, 'ternos', 'Parts'),
(2, 'ternos', 'Machine Shop'),
(3, 'ternos', 'New Product Development'),
(4, 'ternos', 'Fabrication'),
(7, '', NULL),
(21, 'purusothamanp@gmail.com', 'Machine Shop'),
(20, 'purusothamanp@gmail.com', 'Fabrication'),
(14, 'purusothaman@bitsathy.ac.in', 'Parts'),
(24, 'kavinkumar.cs21@bitsathy.ac.in', 'Fabrication'),
(23, 'hola', 'New Product Development'),
(18, 'valo', 'Parts');

-- --------------------------------------------------------

--
-- Table structure for table `software_model`
--

DROP TABLE IF EXISTS `software_model`;
CREATE TABLE IF NOT EXISTS `software_model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `drawing_number` varchar(45) NOT NULL,
  `revision_number` varchar(45) NOT NULL,
  `description` longtext NOT NULL,
  `file` varbinary(255) NOT NULL,
  `sector` varchar(45) DEFAULT NULL,
  `last_rev_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `software_model`
--

INSERT INTO `software_model` (`id`, `drawing_number`, `revision_number`, `description`, `file`, `sector`, `last_rev_date`) VALUES
(20, 'n', 'hj', 'dfghj', 0x34303533322d412e504446, 'Fabrication', '2023-02-21 09:52:32'),
(15, 'kavin', 'kumar', 'nothing', 0x34373431342d412e504446, 'Fabrication', '2023-02-09 02:42:18'),
(2, 'kavin', 'kumar', 'cfghbjklm', 0x34373431322d30285a45524f292e504446, 'New Product Development', '2023-02-07 00:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `designation` varchar(255) DEFAULT 'User',
  `code` varchar(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `name`, `phone_number`, `designation`, `code`) VALUES (1, 'ternos', '$2y$10$LvhZ5PeI1PHdZGFJdfxUBeManXBPbcXWWKuCrt5YgqhkPCalNPdzm', '2022-10-18 14:21:51', 'Kavinkumar B', '8072677947', 'SuperAdmin', '0'),
(13, 'valo', '$2y$10$ia96zP8a1Sx5pf52FBYNR.3.OkKXVCJP1sEp8HvhrXt9IXEZbXJ9O', '2022-10-18 14:21:51', 'Muruga', '9786241601', 'Admin', '0'),
(15, 'hola', '$2y$10$ia96zP8a1Sx5pf52FBYNR.3.OkKXVCJP1sEp8HvhrXt9IXEZbXJ9O', '2022-10-18 14:21:51', 'Vinayaga', '9442792601', 'Admin', '0'),
(28, 'kavinkumar.cs21@bitsathy.ac.in', '$2y$10$K4intGG27NyWzhm3hfyiYuKUgwIKanHwd4KaQPQDmF9gmLyfpNjCm', '2023-02-09 18:51:48', 'Kavinkumar B', '8072677947', 'User', '0'),
(29, 'purusothaman@bitsathy.ac.in', '$2y$10$TkNnZljHfH2RQ7q5xSfw8u0Wbcm6Eo1aRZR4sGd68Etmf325VaYJS', '2023-02-13 11:59:30', 'Purusothaman P', '9952013214', ' User', '0'),
(30, 'purusothamanp@gmail.com', '$2y$10$j0PgC2UBYZ0weJFbXkXsZueIBUmrRmwbeK8MyV3O7geNHRvItZcHi', '2023-02-13 15:05:20', 'Purusothaman P', '9912341235', 'User', '0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
