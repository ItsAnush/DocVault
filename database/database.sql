
--
-- Database: `whale_enterprises`
--
CREATE DATABASE  `whale_enterprises`;
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
);

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
) ;

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
);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `name`, `phone_number`, `designation`, `code`) VALUES
(1, 'ternos', '$2y$10$LvhZ5PeI1PHdZGFJdfxUBeManXBPbcXWWKuCrt5YgqhkPCalNPdzm', '2023-03-10 12:17:51', 'Whale Enterprises', '9566555628', 'SuperAdmin', '0');
COMMIT;


ALTER TABLE `whale_enterprises`.`software_model` 
CHANGE COLUMN `drawing_number` `drawing_number` VARCHAR(45) NOT NULL ,
CHANGE COLUMN `revision_number` `revision_number` VARCHAR(45) NOT NULL ,
CHANGE COLUMN `description` `description` LONGTEXT NOT NULL ,
CHANGE COLUMN `sector` `sector` VARCHAR(45) NULL DEFAULT NULL ;
ALTER TABLE `whale_enterprises`.`software_model` 
CHANGE COLUMN `sector` `sector` VARCHAR(45) NULL DEFAULT NULL ;
ALTER TABLE `whale_enterprises`.`software_model` 
CHANGE COLUMN `sector` `sector` VARCHAR(45) NULL DEFAULT NULL ;

