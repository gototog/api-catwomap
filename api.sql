-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2016 at 10:57 AM
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

--
-- Dumping data for table `alert`
--

INSERT INTO `alert` (`id`, `createdAt`, `finishedAt`, `user_creator_id`, `position_long`, `position_lat`, `position_city`, `position_dep`, `position_country`, `category`) VALUES
(1, '2016-01-16 00:00:00', NULL, 2, '45.187277', '5.778652', 'Grenoble', '38', 'France', 'helpme'),
(2, '2016-01-20 00:00:00', '2016-02-17 00:00:00', 2, '45.188413', '5.778655', 'Grenoble', '38', 'France', 'helphim');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `lastname`, `firstname`, `position_long`, `password`, `position_lat`, `photo`) VALUES
(1, 'jeanbaptiste-fuss@epsi.fr', 'Fuss', 'Jean-Baptiste', '45.187637', 'pass', '5.773306', 'http://ressources.blogdumoderateur.com/2016/01/google-logo-4-couleurs.jpg'),
(2, 'renaud.bredy@epsi.fr', 'Bredy', 'Renaud', '45.187856', 'pass', '5.778520', 'http://ressources.blogdumoderateur.com/2016/01/google-logo-4-couleurs.jpg');

--
-- Dumping data for table `user_help_alert`
--

INSERT INTO `user_help_alert` (`id`, `user_id`, `alert_id`, `is_deprecated`, `has_called_police`) VALUES
(1, 1, 2, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;