-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2016 at 02:53 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert`
--

CREATE TABLE IF NOT EXISTS `alert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gmapCreatedPosition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `finishedAt` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_17FD46C1A76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `alert`
--

INSERT INTO `alert` (`id`, `gmapCreatedPosition`, `createdAt`, `updatedAt`, `finishedAt`, `user_id`, `type`) VALUES
(1, '45.187277, 5.778652', '2016-01-16 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'vol'),
(2, '45.188413, 5.778655', '2016-01-20 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'danger');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gmapPosition` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `lastname`, `firstname`, `gmapPosition`, `password`) VALUES
(1, 'jeanbaptiste-fuss@epsi.fr', 'Fuss', 'Jean-Baptiste', '45.187637, 5.773306', 'pass'),
(2, 'renaud.bredy@epsi.Fr', 'Bredy', 'Renaud', '45.187856, 5.778520', 'pass');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alert`
--
ALTER TABLE `alert`
  ADD CONSTRAINT `FK_17FD46C1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
