-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 06, 2020 at 05:07 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbneighbours`
--
CREATE DATABASE IF NOT EXISTS `dbneighbours` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dbneighbours`;

-- --------------------------------------------------------

--
-- Table structure for table `neighbours`
--

DROP TABLE IF EXISTS `neighbours`;
CREATE TABLE IF NOT EXISTS `neighbours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `about` text NOT NULL,
  `favorite` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `neighbours`
--

INSERT INTO `neighbours` (`id`, `name`, `address`, `phone`, `about`, `favorite`) VALUES
(1, 'Admin', 'moi', '+221774563215', 'Je suis quelque chose', 0),
(2, 'William', 'Washington', '+125674114567', 'I\'m trader', 1),
(3, 'Dupont', 'Belgique', '+334568723', 'Je suis investisseur', 0),
(4, 'Duk', 'Togo', '+22875201345', 'Je suis pentester', 1),
(5, 'Terrance', 'Niary', ' 221778546231', 'ingÃ©nieur', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
