-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 10, 2023 at 06:49 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `username`, `sector`) VALUES
(1, 'ternos', 'Parts'),
(2, 'ternos', 'Machine Shop'),
(3, 'ternos', 'New Product Development'),
(4, 'ternos', 'Fabrication');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `name`, `phone_number`, `designation`, `code`) VALUES
(1, 'ternos', '$2y$10$LvhZ5PeI1PHdZGFJdfxUBeManXBPbcXWWKuCrt5YgqhkPCalNPdzm', '2023-03-10 12:17:51', 'Whale Enterprises', '9566555628', 'SuperAdmin', '0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
