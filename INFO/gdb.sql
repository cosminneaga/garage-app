-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2020 at 09:17 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `auth_level` enum('manager','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `name`, `email`, `auth_level`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'Cosmin Neaga', 'kosmyn.neaga@gmail.com', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `admin_survey_data`
--

CREATE TABLE `admin_survey_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `owned_by` varchar(100) NOT NULL,
  `question_no` int(5) NOT NULL,
  `answer` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_survey_data`
--

INSERT INTO `admin_survey_data` (`id`, `username`, `owned_by`, `question_no`, `answer`) VALUES
(40, 'test', 'test', 1, 5),
(41, 'test', 'test', 2, 5),
(42, 'test', 'test', 6, 5),
(43, 'test', 'test', 7, 5),
(44, 'test', 'test', 9, 5),
(45, 'test', 'test', 11, 5),
(46, 'test', 'test', 12, 5),
(47, 'test', 'test', 13, 5),
(48, 'test_manager1', 'test', 1, 5),
(49, 'test_manager1', 'test', 2, 5),
(50, 'test_manager1', 'test', 6, 5),
(51, 'test_manager1', 'test', 7, 5),
(52, 'test_manager1', 'test', 9, 5),
(53, 'test_manager1', 'test', 11, 4),
(54, 'test_manager1', 'test', 12, 4),
(55, 'test_manager1', 'test', 13, 4),
(56, 'test_w', 'test', 1, 5),
(57, 'test_w', 'test', 2, 5),
(58, 'test_w', 'test', 6, 5),
(59, 'test_w', 'test', 7, 4),
(60, 'test_w', 'test', 9, 5),
(61, 'test_w', 'test', 11, 4),
(62, 'test_w', 'test', 12, 4),
(63, 'test_w', 'test', 13, 4),
(64, 'test_w1', 'test', 1, 5),
(65, 'test_w1', 'test', 2, 4),
(66, 'test_w1', 'test', 6, 5),
(67, 'test_w1', 'test', 7, 5),
(68, 'test_w1', 'test', 9, 5),
(69, 'test_w1', 'test', 11, 4),
(70, 'test_w1', 'test', 12, 4),
(71, 'test_w1', 'test', 13, 4),
(72, 'test_w2', 'test', 1, 5),
(73, 'test_w2', 'test', 2, 5),
(74, 'test_w2', 'test', 6, 5),
(75, 'test_w2', 'test', 7, 5),
(76, 'test_w2', 'test', 9, 5),
(77, 'test_w2', 'test', 11, 4),
(78, 'test_w2', 'test', 12, 5),
(79, 'test_w2', 'test', 13, 4),
(80, 'test_w10', 'test', 1, 5),
(81, 'test_w10', 'test', 2, 5),
(82, 'test_w10', 'test', 6, 5),
(83, 'test_w10', 'test', 7, 5),
(84, 'test_w10', 'test', 9, 5),
(85, 'test_w10', 'test', 11, 5),
(86, 'test_w10', 'test', 12, 5),
(87, 'test_w10', 'test', 13, 5),
(88, 'test_w3', 'test', 1, 5),
(89, 'test_w3', 'test', 2, 5),
(90, 'test_w3', 'test', 6, 5),
(91, 'test_w3', 'test', 7, 5),
(92, 'test_w3', 'test', 9, 5),
(93, 'test_w3', 'test', 11, 5),
(94, 'test_w3', 'test', 12, 5),
(95, 'test_w3', 'test', 13, 5),
(96, 'test_w4', 'test', 1, 5),
(97, 'test_w4', 'test', 2, 5),
(98, 'test_w4', 'test', 6, 5),
(99, 'test_w4', 'test', 7, 5),
(100, 'test_w4', 'test', 9, 5),
(101, 'test_w4', 'test', 11, 5),
(102, 'test_w4', 'test', 12, 5),
(103, 'test_w4', 'test', 13, 5),
(104, 'test_w5', 'test', 1, 5),
(105, 'test_w5', 'test', 2, 5),
(106, 'test_w5', 'test', 6, 5),
(107, 'test_w5', 'test', 7, 5),
(108, 'test_w5', 'test', 9, 5),
(109, 'test_w5', 'test', 11, 5),
(110, 'test_w5', 'test', 12, 5),
(111, 'test_w5', 'test', 13, 5),
(112, 'test_w6', 'test', 1, 5),
(113, 'test_w6', 'test', 2, 5),
(114, 'test_w6', 'test', 6, 5),
(115, 'test_w6', 'test', 7, 5),
(116, 'test_w6', 'test', 9, 5),
(117, 'test_w6', 'test', 11, 5),
(118, 'test_w6', 'test', 12, 5),
(119, 'test_w6', 'test', 13, 5),
(120, 'test_w7', 'test', 1, 5),
(121, 'test_w7', 'test', 2, 5),
(122, 'test_w7', 'test', 6, 5),
(123, 'test_w7', 'test', 7, 5),
(124, 'test_w7', 'test', 9, 5),
(125, 'test_w7', 'test', 11, 5),
(126, 'test_w7', 'test', 12, 5),
(127, 'test_w7', 'test', 13, 5),
(128, 'test_w8', 'test', 1, 5),
(129, 'test_w8', 'test', 2, 5),
(130, 'test_w8', 'test', 6, 5),
(131, 'test_w8', 'test', 7, 5),
(132, 'test_w8', 'test', 9, 5),
(133, 'test_w8', 'test', 11, 5),
(134, 'test_w8', 'test', 12, 5),
(135, 'test_w8', 'test', 13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `admin_survey_data_comments`
--

CREATE TABLE `admin_survey_data_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `owned_by` varchar(100) NOT NULL,
  `question_no` int(5) NOT NULL,
  `comment` longtext NOT NULL,
  `status` enum('not read','read') NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_survey_data_comments`
--

INSERT INTO `admin_survey_data_comments` (`id`, `username`, `owned_by`, `question_no`, `comment`, `status`, `created_on`) VALUES
(19, 'test', 'test', 3, 'very positive', 'read', '2020-05-08 15:38:06'),
(20, 'test', 'test', 4, 'everything', 'read', '2020-05-08 15:38:06'),
(21, 'test', 'test', 5, 'i don\'t have any thoughts about improvement at the moment', 'read', '2020-05-08 15:38:06'),
(22, 'test', 'test', 8, 'definitely need it', 'read', '2020-05-08 15:38:06'),
(23, 'test', 'test', 10, 'absolutely', 'read', '2020-05-08 15:38:06'),
(24, 'test', 'test', 14, 'no problems at all, in fact this software helped me in major problems\r\nno problems at all, in fact this software helped me in major problems\r\nno problems at all, in fact this software helped me in major problems\r\nno problems at all, in fact this software helped me in major problems', 'read', '2020-05-08 15:38:06'),
(25, 'test_manager1', 'test', 3, 'positive', 'read', '2020-05-08 15:56:12'),
(26, 'test_manager1', 'test', 4, 'the design is ok', 'read', '2020-05-08 15:56:12'),
(27, 'test_manager1', 'test', 5, 'everything is ok', 'read', '2020-05-08 15:56:12'),
(28, 'test_manager1', 'test', 8, 'definitely need it', 'read', '2020-05-08 15:56:12'),
(29, 'test_manager1', 'test', 10, 'absolutely', 'read', '2020-05-08 15:56:12'),
(30, 'test_manager1', 'test', 14, 'no problem', 'read', '2020-05-08 15:56:13'),
(31, 'test_w', 'test', 3, 'very positive', 'read', '2020-05-08 15:58:51'),
(32, 'test_w', 'test', 4, 'design', 'read', '2020-05-08 15:58:51'),
(33, 'test_w', 'test', 5, 'nothing to improve', 'read', '2020-05-08 15:58:51'),
(34, 'test_w', 'test', 8, 'definitely need it', 'read', '2020-05-08 15:58:51'),
(35, 'test_w', 'test', 10, 'absolutely', 'read', '2020-05-08 15:58:51'),
(36, 'test_w', 'test', 14, 'no problem', 'read', '2020-05-08 15:58:51'),
(37, 'test_w1', 'test', 3, 'very positive', 'read', '2020-05-08 16:00:59'),
(38, 'test_w1', 'test', 4, 'design', 'read', '2020-05-08 16:00:59'),
(39, 'test_w1', 'test', 5, 'nothing to improve', 'read', '2020-05-08 16:00:59'),
(40, 'test_w1', 'test', 8, 'kind of need it', 'read', '2020-05-08 16:00:59'),
(41, 'test_w1', 'test', 10, 'absolutely', 'read', '2020-05-08 16:00:59'),
(42, 'test_w1', 'test', 14, 'no problem', 'read', '2020-05-08 16:00:59'),
(43, 'test_w2', 'test', 3, 'very positive', 'read', '2020-05-08 16:05:56'),
(44, 'test_w2', 'test', 4, 'design \nhow easy you can navigate \ni like it', 'read', '2020-05-08 16:05:56'),
(45, 'test_w2', 'test', 5, 'for moment nothing to improve', 'read', '2020-05-08 16:05:56'),
(46, 'test_w2', 'test', 8, 'definitely need it', 'read', '2020-05-08 16:05:56'),
(47, 'test_w2', 'test', 10, 'absolutely', 'read', '2020-05-08 16:05:56'),
(48, 'test_w2', 'test', 14, 'the design is very nice\n i didn\'t have any problems \ni like it', 'read', '2020-05-08 16:05:56'),
(49, 'test_w10', 'test', 3, 'very positive', 'not read', '2020-05-10 15:20:26'),
(50, 'test_w10', 'test', 4, 'number of functionalities, and its user-friendly', 'not read', '2020-05-10 15:20:26'),
(51, 'test_w10', 'test', 5, 'i don\'t have any thoughts at the moment', 'not read', '2020-05-10 15:20:26'),
(52, 'test_w10', 'test', 8, 'definitely need it', 'not read', '2020-05-10 15:20:26'),
(53, 'test_w10', 'test', 10, 'absolutely', 'not read', '2020-05-10 15:20:26'),
(54, 'test_w10', 'test', 14, '', 'not read', '2020-05-10 15:20:26'),
(55, 'test_w3', 'test', 3, 'positive', 'not read', '2020-05-10 15:33:56'),
(56, 'test_w3', 'test', 4, 'the fact that i am able to create invoices fast and easy', 'not read', '2020-05-10 15:33:56'),
(57, 'test_w3', 'test', 5, '', 'not read', '2020-05-10 15:33:56'),
(58, 'test_w3', 'test', 8, 'definitely need it', 'not read', '2020-05-10 15:33:56'),
(59, 'test_w3', 'test', 10, 'absolutely', 'not read', '2020-05-10 15:33:56'),
(60, 'test_w3', 'test', 14, '', 'not read', '2020-05-10 15:33:56'),
(61, 'test_w4', 'test', 3, 'very positive', 'read', '2020-05-10 15:40:49'),
(62, 'test_w4', 'test', 4, '', 'read', '2020-05-10 15:40:49'),
(63, 'test_w4', 'test', 5, '', 'read', '2020-05-10 15:40:49'),
(64, 'test_w4', 'test', 8, 'definitely need it', 'read', '2020-05-10 15:40:49'),
(65, 'test_w4', 'test', 10, 'absolutely', 'read', '2020-05-10 15:40:49'),
(66, 'test_w4', 'test', 14, '', 'read', '2020-05-10 15:40:50'),
(67, 'test_w5', 'test', 3, 'very positive', 'read', '2020-05-10 15:42:45'),
(68, 'test_w5', 'test', 4, '', 'read', '2020-05-10 15:42:45'),
(69, 'test_w5', 'test', 5, '', 'read', '2020-05-10 15:42:45'),
(70, 'test_w5', 'test', 8, 'definitely need it', 'read', '2020-05-10 15:42:45'),
(71, 'test_w5', 'test', 10, 'absolutely', 'read', '2020-05-10 15:42:45'),
(72, 'test_w5', 'test', 14, '', 'read', '2020-05-10 15:42:45'),
(73, 'test_w6', 'test', 3, 'very positive', 'read', '2020-05-10 15:43:36'),
(74, 'test_w6', 'test', 4, '', 'read', '2020-05-10 15:43:36'),
(75, 'test_w6', 'test', 5, '', 'read', '2020-05-10 15:43:36'),
(76, 'test_w6', 'test', 8, 'definitely need it', 'read', '2020-05-10 15:43:36'),
(77, 'test_w6', 'test', 10, 'absolutely', 'read', '2020-05-10 15:43:36'),
(78, 'test_w6', 'test', 14, '', 'read', '2020-05-10 15:43:36'),
(79, 'test_w7', 'test', 3, 'very positive', 'read', '2020-05-10 15:44:21'),
(80, 'test_w7', 'test', 4, '', 'read', '2020-05-10 15:44:21'),
(81, 'test_w7', 'test', 5, '', 'read', '2020-05-10 15:44:21'),
(82, 'test_w7', 'test', 8, 'definitely need it', 'read', '2020-05-10 15:44:21'),
(83, 'test_w7', 'test', 10, 'absolutely', 'read', '2020-05-10 15:44:21'),
(84, 'test_w7', 'test', 14, '', 'read', '2020-05-10 15:44:21'),
(85, 'test_w8', 'test', 3, 'very positive', 'not read', '2020-05-14 14:38:29'),
(86, 'test_w8', 'test', 4, '', 'not read', '2020-05-14 14:38:29'),
(87, 'test_w8', 'test', 5, '', 'not read', '2020-05-14 14:38:29'),
(88, 'test_w8', 'test', 8, 'definitely need it', 'not read', '2020-05-14 14:38:29'),
(89, 'test_w8', 'test', 10, 'absolutely', 'not read', '2020-05-14 14:38:29'),
(90, 'test_w8', 'test', 14, '', 'not read', '2020-05-14 14:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_type`
--

CREATE TABLE `fuel_type` (
  `id` int(11) NOT NULL,
  `fuel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fuel_type`
--

INSERT INTO `fuel_type` (`id`, `fuel`) VALUES
(1, 'Petrol'),
(2, 'Diesel'),
(3, 'Electric'),
(4, 'Hybrid'),
(5, 'LPG'),
(6, 'CNG'),
(7, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `test_bookings`
--

CREATE TABLE `test_bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_mob_one` varchar(50) NOT NULL,
  `vehicle_reg` varchar(50) NOT NULL,
  `notes` longtext NOT NULL,
  `booked_on` datetime NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_data` longblob DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `owned_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_bookings`
--

INSERT INTO `test_bookings` (`id`, `client_name`, `client_mob_one`, `vehicle_reg`, `notes`, `booked_on`, `date_created`, `image_data`, `created_by`, `owned_by`) VALUES
(8, 'Name Of Client', 'MOBILE', 'REG', 'THIS IS BOOKING FOR TOMORROW', '2020-05-15 08:05:00', '2020-05-14 08:56:41', '', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `test_clients`
--

CREATE TABLE `test_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(150) NOT NULL,
  `postcode` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `mob_one` varchar(50) NOT NULL,
  `mob_two` varchar(50) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(50) NOT NULL,
  `owned_by` varchar(50) NOT NULL,
  `survey_status` varchar(100) NOT NULL,
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_clients`
--

INSERT INTO `test_clients` (`id`, `name`, `email`, `address`, `city`, `postcode`, `country`, `mob_one`, `mob_two`, `creation_date`, `created_by`, `owned_by`, `survey_status`, `session_id`) VALUES
(1, 'James Thomas', 'james@gmail.com', '222 High Road', 'London', 'E1 6AF', 'United Kingdom', '07441344561', '', '2020-05-03 11:17:37', 'test', 'test', 'completed', '25bb28974f4b7a4aa2754a7b455a66aa'),
(2, 'Peter Duffield', 'peterduff11@gmail.com', '222 Studley Road', 'Evesham', 'B983RD', 'United Kingdom', '07666454422', '', '2020-05-03 11:25:47', 'test', 'test', 'completed', '52fc370cbc74982ef35e6ec97b58121e'),
(3, 'John Doe', 'doe@gmail.com', '230 Norman St', 'Nottingham', 'NG1 1EF', 'United Kingdom', '07452659557', '01125566547', '2020-05-03 11:26:30', 'test', 'test', 'completed', '3c5c8e2121bf11ecdf9bc03bba7422fa'),
(4, 'Amanda Cook', 'amandasweet8@gmail.com', 'Abbey Road', 'Leicester', 'LE41SJ', 'United Kingdom', '07665511451', '', '2020-05-03 11:26:59', 'test', 'test', 'completed', '0f4c1a66c3f4e35ffe08a4da89caab73'),
(5, 'William Johnson', 'will@gmail.com', '45 Lula Road', 'Nottingham', 'NG9 8ZF', 'United Kingdom', '07856552654', '', '2020-05-03 11:27:58', 'test', 'test', 'completed', '5e642d8ad5bccabee7090141b73baf10'),
(6, 'Paul Cooper', 'paulkp@gmail.com', '74 Agnes Street', 'Malvern', 'E1 7AE', 'United Kingdom', '07424827653', '', '2020-05-03 11:28:49', 'test', 'test', 'not completed', '2d08bdba856231a0ca295336dc039e88'),
(7, 'Claire Dougat', 'claire_dougat@gmail.com', '345 High Road', 'Leicester', 'LE67 8DF', 'United Kingdom', '07952636546', '01126599945', '2020-05-03 11:29:01', 'test', 'test', 'completed', 'ffffa55b5cf2dbb7076ab88db85b761a'),
(8, 'George Thomas', 'george@gmail.com', '203 Templar Street', 'Leicester', 'LE2 3FF', 'United Kingdom', '07556266586', '', '2020-05-03 11:29:57', 'test', 'test', 'completed', 'bd506f57c982a324e3d553fb65b69e26'),
(9, 'Oliver Jake', 'oly@gmail.com', '7 New Road', 'Leicester', 'LE44 3FG', 'United Kingdom', '07885623256', '', '2020-05-03 11:30:56', 'test', 'test', 'completed', 'a50958e33fc2d3b2cd167e9914fb740a'),
(10, 'Jennifer Brooks', 'jennybr14@gmail.com', 'Adams Row', 'Aldgate', 'E1 7BH', 'United Kingdom', '07881414221', '', '2020-05-03 11:31:24', 'test', 'test', 'completed', 'ca8005e341fbfc3c926a4b08ad34ca33'),
(11, 'Harry Callum', 'harry@gmail.com', '44 Oliver Street', 'Walsall', 'B74 2DR', 'United Kingdom', '07895626546', '', '2020-05-03 11:32:05', 'test', 'test', 'not completed', 'd606f4c797bb548598a702005f25b14c'),
(12, 'Adam Bentley', 'adamben112@gmail.com', '112 Birmingham Road', 'London', 'E1 7DD', 'United Kingdom', '07995513242', '', '2020-05-03 11:32:41', 'test', 'test', 'completed', 'd6c11d5729b7c66e808c5fc8a47c1f74'),
(13, 'Alexander Joseph', 'alex@gmail.com', '44 New Road', 'Walsall', 'B74 3TS', 'United Kingdom', '07562312365', '', '2020-05-03 11:32:57', 'test', 'test', 'completed', '3f28f0fb3d112bb80ba8e15c45f47469'),
(14, 'Marius Popescu', 'popmarius99@gmail.com', '17 Jonshon Close ', 'Rugeley', 'WS152PP', 'United Kingdom', '07896766776', '', '2020-05-03 11:33:55', 'test', 'test', 'send', ''),
(15, 'Mason Robert', 'mason_r@gmail.com', '55 Peak Road', 'Walsall', 'WS1 1EJ', 'United Kingdom', '07462654658', '', '2020-05-03 11:34:03', 'test', 'test', 'not completed', 'cb580b57387d82ba37fb5327d96bee07'),
(16, 'Oscar Rhys', 'rhys@gmail.com', '80 Pass St', 'Wolverhampton', 'DY3 4AG', 'United Kingdom', '07889562314', '', '2020-05-03 11:35:08', 'test', 'test', 'send', ''),
(17, 'Sorin Creanga', 'sorincr77@gmail.com', '37 Evington Road', 'Leicester', 'LE2 0SA', 'United Kingdom', '07877415234', '', '2020-05-03 11:35:19', 'test', 'test', 'completed', 'e4d9ec338802e1dd2ca924f8b87cadae'),
(18, 'George Reece', 'reece_george@gmail.com', '503 London Road', 'Wolverhampton', 'WV1 1PD', 'United Kingdom', '07456465266', '', '2020-05-03 11:36:10', 'test', 'test', 'send', ''),
(19, 'Darren Dunn', 'darrend56@gmail.com', '14 Holyoake Place', 'Rugeley', 'WS152RP', 'United Kingdom', '0774556455', '', '2020-05-03 11:37:02', 'test', 'test', 'not completed', 'dd7f9f239a28ee6044206e5021321107'),
(20, 'Razvan Ciobanu', 'ciobrazvan91@gmail.com', '67 Main Street', 'Bristol', 'B1 9 PR', 'United Kingdom', '07567565756', '', '2020-05-03 11:38:46', 'test', 'test', 'completed', '958101d75e4a119d3926546a4d86e0c9'),
(21, 'Ian Brooks', 'ian66@gmail.com', '77 High Road', 'Hinkley', 'LE174EX', 'United Kingdom', '07666757575', '', '2020-03-03 16:31:19', 'test', 'test', 'not completed', '25701b704dd6013d7aa43172d9fd368c'),
(22, 'Mark Twain', 'twain@gmail.com', '345 High Road', 'Masachutes', '874373', 'Usa', '07424928497', '', '2020-05-15 12:20:13', 'test', 'test', 'send', '');

-- --------------------------------------------------------

--
-- Table structure for table `test_company`
--

CREATE TABLE `test_company` (
  `id` int(11) NOT NULL,
  `image_type` varchar(255) DEFAULT NULL,
  `image_data` longblob DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(150) NOT NULL,
  `postcode` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `registration_no` varchar(100) NOT NULL,
  `mob_one` varchar(50) NOT NULL,
  `mob_two` varchar(50) NOT NULL,
  `landline` varchar(50) NOT NULL,
  `tax_value` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `owned_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_company`
--

INSERT INTO `test_company` (`id`, `image_type`, `image_data`, `name`, `email`, `address`, `city`, `postcode`, `country`, `registration_no`, `mob_one`, `mob_two`, `landline`, `tax_value`, `creation_date`, `owned_by`) VALUES
(1, NULL, NULL, 'TEST MOTORS LTD', 'kosmyn.neaga96@gmail.com', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 20, '2020-05-03 11:50:00', 'test');

-- --------------------------------------------------------

--
-- Stand-in structure for view `test_graphs_data`
-- (See below for the actual view)
--
CREATE TABLE `test_graphs_data` (
`id` int(10) unsigned
,`invoice_date` timestamp
,`job_time` double(8,2)
,`hourly_charge` double(8,2)
,`discount` double(8,2)
,`status` enum('paid','unpaid')
,`remaining_balance` double(10,2)
,`item_price` double(8,2)
,`labour_price` double(8,2)
,`total_price` double(8,2)
,`sub_total` double(10,2)
,`grand_total` double(12,2)
,`created_by` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `test_invoice`
--

CREATE TABLE `test_invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `company_name` longtext NOT NULL,
  `company_address` varchar(200) NOT NULL,
  `company_city` varchar(150) NOT NULL,
  `company_postcode` varchar(100) NOT NULL,
  `company_country` varchar(100) NOT NULL,
  `company_vat` varchar(100) NOT NULL,
  `company_mob_one` varchar(50) NOT NULL,
  `company_mob_two` varchar(50) NOT NULL,
  `company_landline` varchar(50) NOT NULL,
  `job_time` double(8,2) DEFAULT 0.00,
  `hourly_charge` double(8,2) DEFAULT 0.00,
  `client_name` varchar(100) NOT NULL,
  `client_address` varchar(200) NOT NULL,
  `client_city` varchar(150) NOT NULL,
  `client_postcode` varchar(100) NOT NULL,
  `client_country` varchar(100) NOT NULL,
  `client_mob_one` varchar(50) NOT NULL,
  `client_mob_two` varchar(50) NOT NULL,
  `vehicle_reg` varchar(50) NOT NULL,
  `vehicle_make` varchar(50) NOT NULL,
  `vehicle_model` varchar(150) NOT NULL,
  `vehicle_vin` varchar(250) NOT NULL,
  `vehicle_odometer` varchar(100) NOT NULL,
  `vehicle_fuel` varchar(100) NOT NULL,
  `sub_total` double(10,2) DEFAULT 0.00,
  `tax` double(10,2) DEFAULT 0.00,
  `discount` double(8,2) DEFAULT 0.00,
  `grand_total` double(12,2) DEFAULT 0.00,
  `status` enum('paid','unpaid') NOT NULL,
  `remaining_balance` double(10,2) DEFAULT 0.00,
  `created_by` varchar(50) NOT NULL,
  `owned_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_invoice`
--

INSERT INTO `test_invoice` (`id`, `invoice_date`, `company_name`, `company_address`, `company_city`, `company_postcode`, `company_country`, `company_vat`, `company_mob_one`, `company_mob_two`, `company_landline`, `job_time`, `hourly_charge`, `client_name`, `client_address`, `client_city`, `client_postcode`, `client_country`, `client_mob_one`, `client_mob_two`, `vehicle_reg`, `vehicle_make`, `vehicle_model`, `vehicle_vin`, `vehicle_odometer`, `vehicle_fuel`, `sub_total`, `tax`, `discount`, `grand_total`, `status`, `remaining_balance`, `created_by`, `owned_by`) VALUES
(1, '2020-05-03 12:22:51', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 1.08, 37.00, 'James Thomas', '222 High Road', 'London', 'E1 6AR', 'United Kingdom', '07441344561', '', 'FJ17SKK', 'Citroen', 'Relay', '', '5600', 'diesel', 153.46, 20.00, 0.00, 184.15, 'paid', 0.00, 'test', 'test'),
(2, '2020-05-03 12:46:55', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 4.50, 45.00, 'John Doe', '230 Norman St', 'Nottingham', 'NG1 1EF', 'United Kingdom', '07452659557', '01125566547', 'DA10FKL', 'Ford', 'Ka', '', '25000', 'petrol', 462.50, 20.00, 0.00, 555.00, 'paid', 0.00, 'test', 'test'),
(3, '2020-05-03 12:48:41', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 1.00, 45.00, 'Claire Dougat', '345 High Road', 'Leicester', 'LE67 8DF', 'United Kingdom', '07952636546', '01126599945', 'BN54TXH', 'Bmw', '5-series', '', '65900', 'diesel', 110.00, 20.00, 0.00, 132.00, 'paid', 0.00, 'test', 'test'),
(4, '2020-05-03 12:51:18', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 1.00, 0.00, 'Jennifer Brooks', 'Adams Row', 'Aldgate', 'E1 7BH', 'United Kingdom', '07881414221', '', 'DA10FKL', 'Ford', 'Ka', '', '25000', 'petrol', 242.95, 20.00, 0.00, 291.54, 'paid', 0.00, 'test', 'test'),
(5, '2020-05-03 12:53:04', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 11.00, 30.00, 'George Reece', '503 London Road', 'Wolverhampton', 'WV1 1PD', 'United Kingdom', '07456465266', '', 'VR14AAC', 'Bmw', 'X5', '', '56000', 'diesel', 580.00, 20.00, 0.00, 696.00, 'paid', 0.00, 'test', 'test'),
(6, '2020-05-03 12:55:15', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.00, 0.00, 'Harry Callum', '44 Oliver Street', 'Walsall', 'B74 2DR', 'United Kingdom', '07895626546', '', 'V322AAN', 'Ford', 'Mondeo', '', '75000', 'diesel', 304.35, 20.00, 0.00, 365.22, 'paid', 0.00, 'test', 'test'),
(7, '2020-05-03 12:58:31', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.38, 34.00, 'Peter Duffield', '222 Studley Road', 'Evesham', 'B983RD', 'United Kingdom', '07666454422', '', 'FJ17SKK', 'Citroen', 'Relay', '', '5600', 'diesel', 335.92, 20.00, 0.00, 403.10, 'paid', 0.00, 'test', 'test'),
(8, '2020-05-03 13:02:19', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.23, 33.00, 'Amanda Cook', 'Abbey Road', 'Leicester', 'LE41SJ', 'United Kingdom', '07665511451', '', 'RJ16SKK', 'Vauxhall', 'Insignia', '', '77000', 'diesel', 412.59, 20.00, 0.00, 495.11, 'paid', 0.00, 'test', 'test'),
(9, '2020-05-03 13:05:18', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 1.17, 38.00, 'Adam Bentley', '112 Birmingham Road', 'London', 'E1 7DD', 'United Kingdom', '07995513242', '', 'FR17MOD', 'Mazda', 'Cx-3', '', '10340', 'diesel', 211.46, 20.00, 0.00, 253.75, 'paid', 0.00, 'test', 'test'),
(10, '2020-05-03 13:19:26', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.17, 40.00, 'Peter Duffield', '222 Studley Road', 'Evesham', 'B983RD', 'United Kingdom', '07666454422', '', 'FJ17SKK', 'Citroen', 'Relay', '', '5600', 'diesel', 86.80, 20.00, 0.00, 104.16, 'paid', 0.00, 'test', 'test'),
(11, '2020-05-03 13:21:01', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 3.00, 30.00, 'Oliver Jake', '7 New Road', 'Leicester', 'LE44 3FG', 'United Kingdom', '07885623256', '', 'CR04AUA', 'Vauxhall', 'Corsa', '', '103000', 'petrol', 90.00, 20.00, 0.00, 108.00, 'paid', 0.00, 'test', 'test'),
(17, '2020-05-03 14:07:41', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 0.50, 60.00, 'John Doe', '230 Norman St', 'Nottingham', 'NG1 1EF', 'United Kingdom', '07452659557', '01125566547', 'FM05KLU', 'Mercedes', 'Vito', '', '165200', 'diesel', 70.00, 20.00, 0.00, 84.00, 'paid', 0.00, 'test', 'test'),
(18, '2020-05-03 14:08:34', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.00, 0.00, 'Mason Robert', '55 Peak Road', 'Walsall', 'WS1 1EJ', 'United Kingdom', '07462654658', '', 'LR09DDE', 'Mercedes', 'Cd200', '', '250000', 'diesel', 450.00, 20.00, 0.00, 540.00, 'paid', 0.00, 'test', 'test'),
(19, '2020-03-03 16:16:16', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.50, 0.00, 'Sorin Creanga', '37 Evington Road', 'Leicester', 'LE2 0SA', 'United Kingdom', '07877415234', '', 'RJ16SKK', 'Vauxhall', 'Insignia', '', '77000', 'diesel', 230.00, 20.00, 0.00, 276.00, 'paid', 0.00, 'test', 'test'),
(20, '2020-03-03 16:17:19', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 28.00, 0.00, 'William Johnson', '45 Lula Road', 'Nottingham', 'NG9 8ZF', 'United Kingdom', '07856552654', '', 'FJ17SKO', 'Citroen', 'Relay', '', '19750', 'diesel', 975.68, 20.00, 0.00, 1170.82, 'paid', 0.00, 'test', 'test'),
(21, '2020-03-03 16:19:39', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 5.00, 40.00, 'Darren Dunn', '14 Holyoake Place', 'Rugeley', 'WS152RP', 'United Kingdom', '0774556455', '', 'DA10FKL', 'Ford', 'Ka', '', '25000', 'petrol', 380.00, 20.00, 0.00, 456.00, 'paid', 0.00, 'test', 'test'),
(22, '2020-03-03 16:20:53', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.72, 34.00, 'Marius Popescu', '17 Jonshon Close ', 'Rugeley', 'WS152PP', 'United Kingdom', '07896766776', '', 'V322AAN', 'Ford', 'Mondeo', '', '75000', 'diesel', 532.48, 20.00, 0.00, 638.98, 'paid', 0.00, 'test', 'test'),
(23, '2020-03-03 16:21:06', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 6.00, 40.00, 'Adam Bentley', '112 Birmingham Road', 'London', 'E1 7DD', 'United Kingdom', '07995513242', '', 'KY13VTV', 'Vauxhall', 'Movano', '', '55000', 'diesel', 526.78, 20.00, 0.00, 632.14, 'paid', 0.00, 'test', 'test'),
(24, '2020-03-03 16:23:29', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 1.00, 33.00, 'Sorin Creanga', '37 Evington Road', 'Leicester', 'LE2 0SA', 'United Kingdom', '07877415234', '', 'CJ19RYX', 'Vauxhall', 'Zafira', '', '156000', 'petrol', 75.00, 20.00, 0.00, 90.00, 'paid', 0.00, 'test', 'test'),
(25, '2020-03-03 16:24:08', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 8.00, 34.67, 'Razvan Ciobanu', '67 Main Street', 'Bristol', 'B1 9 PR', 'United Kingdom', '07567565756', '', 'AR20ITK', 'Tesla', 'Model-s', '', '23000', 'electric', 572.36, 20.00, 0.00, 686.83, 'paid', 0.00, 'test', 'test'),
(26, '2020-03-03 16:25:09', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.00, 0.00, 'Amanda Cook', 'Abbey Road', 'Leicester', 'LE41SJ', 'United Kingdom', '07665511451', '', 'SK19RIO', 'Toyota', 'Corolla', '', '12300', 'diesel', 100.00, 20.00, 0.00, 120.00, 'paid', 0.00, 'test', 'test'),
(27, '2020-03-03 16:25:50', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.75, 35.00, 'Darren Dunn', '14 Holyoake Place', 'Rugeley', 'WS152RP', 'United Kingdom', '0774556455', '', 'PR18MUT', 'Seat', 'Toledo', '', '123000', 'diesel', 501.25, 20.00, 0.00, 601.50, 'paid', 0.00, 'test', 'test'),
(28, '2020-03-03 16:26:51', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 15.00, 30.00, 'Alexander Joseph', '44 New Road', 'Walsall', 'B74 3TS', 'United Kingdom', '07562312365', '', 'VV19VWV', 'Ford', 'Titanium', '', '2500', 'hybrid', 1030.00, 20.00, 0.00, 1236.00, 'paid', 0.00, 'test', 'test'),
(29, '2020-03-03 16:27:27', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 0.92, 33.00, 'Razvan Ciobanu', '67 Main Street', 'Bristol', 'B1 9 PR', 'United Kingdom', '07567565756', '', 'FJ17SKO', 'Citroen', 'Relay', '', '19750', 'diesel', 62.36, 20.00, 0.00, 74.83, 'paid', 0.00, 'test', 'test'),
(30, '2020-03-03 16:28:02', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 12.00, 25.67, 'Harry Callum', '44 Oliver Street', 'Walsall', 'B74 2DR', 'United Kingdom', '07895626546', '', 'LR09DDE', 'Mercedes', 'Cd200', '', '250000', 'diesel', 608.04, 20.00, 0.00, 729.65, 'paid', 0.00, 'test', 'test'),
(31, '2020-03-03 16:29:40', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 8.00, 0.00, 'Oliver Jake', '7 New Road', 'Leicester', 'LE44 3FG', 'United Kingdom', '07885623256', '', 'CR04AUA', 'Vauxhall', 'Corsa', '', '103000', 'petrol', 124.73, 20.00, 0.00, 149.68, 'paid', 0.00, 'test', 'test'),
(32, '2020-03-03 16:35:10', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.20, 35.00, 'George Thomas', '203 Templar Street', 'Leicester', 'LE2 3FF', 'United Kingdom', '07556266586', '', 'FJ17SKO', 'Citroen', 'Relay', '', '19750', 'diesel', 281.00, 20.00, 0.00, 337.20, 'paid', 0.00, 'test', 'test'),
(33, '2020-03-03 16:36:36', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.00, 35.00, 'Sorin Creanga', '37 Evington Road', 'Leicester', 'LE2 0SA', 'United Kingdom', '07877415234', '', 'RJ16SKK', 'Vauxhall', 'Insignia', '', '77000', 'diesel', 257.00, 20.00, 0.00, 308.40, 'paid', 0.00, 'test', 'test'),
(34, '2020-03-03 16:38:16', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 1.75, 35.00, 'Ian Brooks', '77 High Road', 'Hinkley', 'LE174EX', 'United Kingdom', '07666757575', '', 'FR17MOD', 'Mazda', 'Cx-3', '', '10340', 'diesel', 182.25, 20.00, 0.00, 218.70, 'paid', 0.00, 'test', 'test'),
(35, '2020-03-03 16:39:50', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.68, 35.00, 'William Johnson', '45 Lula Road', 'Nottingham', 'NG9 8ZF', 'United Kingdom', '07856552654', '', 'FR17MOD', 'Mazda', 'Cx-3', '', '10340', 'diesel', 269.80, 20.00, 0.00, 323.76, 'paid', 0.00, 'test', 'test'),
(36, '2020-04-03 14:41:59', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 1.00, 45.00, 'Marius Popescu', '17 Jonshon Close ', 'Rugeley', 'WS152PP', 'United Kingdom', '07896766776', '', 'SK19RIO', 'Toyota', 'Corolla', '', '12300', 'diesel', 124.86, 20.00, 0.00, 149.83, 'paid', 0.00, 'test', 'test'),
(37, '2020-04-05 14:42:15', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.42, 35.00, 'Mason Robert', '55 Peak Road', 'Walsall', 'WS1 1EJ', 'United Kingdom', '07462654658', '', 'CJ19RYX', 'Vauxhall', 'Zafira', '', '156000', 'petrol', 182.70, 20.00, 0.00, 219.24, 'paid', 0.00, 'test', 'test'),
(38, '2020-04-05 14:43:28', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 3.25, 35.00, 'George Reece', '503 London Road', 'Wolverhampton', 'WV1 1PD', 'United Kingdom', '07456465266', '', 'AR20ITK', 'Tesla', 'Model-s', '', '23000', 'electric', 355.75, 20.00, 0.00, 426.90, 'paid', 0.00, 'test', 'test'),
(39, '2020-04-05 14:43:47', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 4.00, 0.00, 'Paul Cooper', '74 Agnes Street', 'Malvern', 'E1 7AE', 'United Kingdom', '07424827653', '', 'LY02DCU', 'Renault', 'Traffic', '', '120000', 'diesel', 870.69, 20.00, 0.00, 1044.83, 'paid', 0.00, 'test', 'test'),
(40, '2020-04-14 14:44:43', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.82, 35.00, 'Marius Popescu', '17 Jonshon Close ', 'Rugeley', 'WS152PP', 'United Kingdom', '07896766776', '', 'FR17MOD', 'Mazda', 'Cx-3', '', '10340', 'diesel', 411.70, 20.00, 0.00, 494.04, 'paid', 0.00, 'test', 'test'),
(41, '2020-04-14 14:44:57', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 4.00, 0.00, 'Ian Brooks', '77 High Road', 'Hinkley', 'LE174EX', 'United Kingdom', '07666757575', '', 'PR18MUT', 'Seat', 'Toledo', '', '123000', 'diesel', 400.00, 20.00, 0.00, 480.00, 'paid', 0.00, 'test', 'test'),
(42, '2020-04-23 14:45:54', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 1.50, 35.00, 'Jennifer Brooks', 'Adams Row', 'Aldgate', 'E1 7BH', 'United Kingdom', '07881414221', '', 'DA10FKL', 'Ford', 'Ka', '', '25000', 'petrol', 230.50, 20.00, 0.00, 276.60, 'paid', 0.00, 'test', 'test'),
(43, '2020-04-23 14:45:56', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.00, 0.00, 'George Thomas', '203 Templar Street', 'Leicester', 'LE2 3FF', 'United Kingdom', '07556266586', '', 'DA10FKL', 'Ford', 'Ka', '', '25000', 'petrol', 100.00, 20.00, 0.00, 120.00, 'paid', 0.00, 'test', 'test'),
(44, '2020-04-23 14:47:27', 'TEST MOTORS LTD', 'Unit 7 Industrial Park', 'Leicester', 'LE334FG', 'United Kingdom', '5424567888', '07424928497', '07305955497', '01125634521', 2.75, 35.00, 'Paul Cooper', '74 Agnes Street', 'Malvern', 'E1 7AE', 'United Kingdom', '07424827653', '', 'CJ19RYX', 'Vauxhall', 'Zafira', '', '156000', 'petrol', 197.25, 20.00, 0.00, 236.70, 'paid', 0.00, 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `test_invoice_items`
--

CREATE TABLE `test_invoice_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(300) NOT NULL,
  `item_quantity` int(11) DEFAULT 0,
  `item_price` double(8,2) DEFAULT 0.00,
  `labour_price` double(8,2) DEFAULT 0.00,
  `total_price` double(8,2) DEFAULT 0.00,
  `invoice_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_invoice_items`
--

INSERT INTO `test_invoice_items` (`id`, `item_name`, `item_quantity`, `item_price`, `labour_price`, `total_price`, `invoice_id`) VALUES
(1, 'Break Pads', 4, 22.00, 0.00, 88.00, 1),
(2, 'Fuel Filter', 1, 13.00, 0.00, 13.00, 1),
(3, 'Oil Filter', 1, 12.50, 0.00, 12.50, 1),
(4, 'Full Service', 1, 200.00, 0.00, 200.00, 2),
(5, 'Brake Pads', 4, 15.00, 0.00, 60.00, 2),
(6, 'Front Headlight Bulb', 2, 5.00, 0.00, 10.00, 3),
(7, 'Bonnet Hatch', 1, 45.00, 0.00, 45.00, 3),
(8, 'Windscreen Crack', 1, 10.00, 0.00, 10.00, 3),
(9, 'Front Headlight Bulb', 2, 5.00, 10.00, 20.00, 4),
(10, 'Brake Pads', 2, 20.00, 35.00, 75.00, 4),
(11, 'Engine Oil', 1, 55.00, 30.00, 85.00, 4),
(12, 'Fuel Filter', 1, 12.80, 10.00, 22.80, 4),
(13, 'Oil Filter', 1, 10.30, 10.00, 20.30, 4),
(14, 'Air Filter', 1, 9.85, 10.00, 19.85, 4),
(15, 'Timing Chain Replacement', 1, 250.00, 0.00, 250.00, 5),
(16, 'Brake Pads', 4, 16.00, 0.00, 64.00, 3),
(17, 'Oil Filter', 1, 11.00, 0.00, 11.00, 3),
(18, 'Discs', 2, 67.00, 0.00, 134.00, 3),
(19, 'Air Conditioning', 1, 55.00, 0.00, 55.00, 3),
(20, 'Brake Pads', 2, 14.35, 40.00, 68.70, 6),
(21, 'Full Service', 1, 175.65, 60.00, 235.65, 6),
(22, 'Brake Pads', 4, 16.00, 0.00, 64.00, 6),
(23, 'Brake Discs', 2, 90.00, 0.00, 180.00, 6),
(24, 'Brake Pads', 4, 16.00, 0.00, 64.00, 6),
(25, 'Brake Discs', 2, 90.00, 0.00, 180.00, 6),
(26, 'Brake Discs', 2, 90.00, 0.00, 180.00, 7),
(27, 'Air Conditioning', 1, 75.00, 0.00, 75.00, 7),
(28, 'Brake Discs', 2, 120.00, 0.00, 240.00, 8),
(29, 'Oil Filter', 1, 10.00, 0.00, 10.00, 8),
(30, 'Fuel Filter', 1, 12.00, 0.00, 12.00, 8),
(31, 'Air Conditioning', 1, 77.00, 0.00, 77.00, 8),
(32, 'Brake Discs', 1, 55.00, 0.00, 55.00, 9),
(33, 'Brake Pads', 4, 22.00, 0.00, 88.00, 9),
(34, 'Oil Filter', 1, 11.00, 0.00, 11.00, 9),
(35, 'Fuel Filter', 1, 13.00, 0.00, 13.00, 9),
(36, 'Brake Pads', 4, 15.00, 0.00, 60.00, 10),
(37, 'Clutch Kit', 1, 250.00, 0.00, 250.00, 11),
(46, 'Brake Pads', 4, 10.00, 0.00, 40.00, 17),
(47, 'Clutch Kit', 1, 250.00, 200.00, 450.00, 18),
(48, 'Clucth Kit', 1, 230.00, 0.00, 230.00, 19),
(49, 'Headgasket', 1, 375.68, 600.00, 975.68, 20),
(50, 'Brake Discs', 4, 30.00, 0.00, 120.00, 21),
(51, 'Brake Pads', 4, 15.00, 0.00, 60.00, 21),
(52, 'Fuel Filter', 1, 9.00, 0.00, 9.00, 22),
(53, 'Brake Discs', 2, 78.00, 0.00, 156.00, 22),
(54, 'Air Conditioning', 1, 65.00, 0.00, 65.00, 22),
(55, 'Brake Pads', 2, 99.00, 0.00, 198.00, 22),
(56, 'Oil Filter', 1, 12.00, 0.00, 12.00, 22),
(57, 'Engine Coolant', 1, 30.00, 0.00, 30.00, 23),
(58, 'Full Service Kit', 1, 256.78, 0.00, 256.78, 23),
(59, 'Oil Filter', 1, 10.00, 0.00, 10.00, 24),
(60, 'Fuel Filter', 1, 10.00, 0.00, 10.00, 24),
(61, 'Brake Discs', 1, 22.00, 0.00, 22.00, 24),
(62, 'Light Bulbs Front', 4, 5.00, 0.00, 20.00, 25),
(63, 'Passanger Seatbelt Replacement', 1, 65.00, 0.00, 65.00, 25),
(64, 'Central Locking', 1, 200.00, 0.00, 200.00, 25),
(65, 'Tyre Puncture', 2, 5.00, 0.00, 10.00, 25),
(66, 'Engine Coolant Top-up', 1, 10.00, 10.00, 20.00, 26),
(67, 'Front Brake Pads', 2, 15.00, 50.00, 80.00, 26),
(68, 'Air Conditioning', 1, 77.00, 0.00, 77.00, 27),
(69, 'Brake Discs', 1, 44.00, 0.00, 44.00, 27),
(70, 'Fuel Filter', 1, 9.00, 0.00, 9.00, 27),
(71, 'Oil Filter', 1, 11.00, 0.00, 11.00, 27),
(72, 'Brake Pads', 3, 88.00, 0.00, 264.00, 27),
(73, 'Full Service', 1, 200.00, 0.00, 200.00, 28),
(74, 'Tyre Replacement', 2, 175.00, 0.00, 350.00, 28),
(75, 'Windscreen Crack Repair', 1, 30.00, 0.00, 30.00, 28),
(76, 'Fuel Filter', 1, 10.00, 0.00, 10.00, 29),
(77, 'Oil Filter', 1, 11.00, 0.00, 11.00, 29),
(78, 'Brake Pads', 1, 11.00, 0.00, 11.00, 29),
(79, 'Brake Pads', 4, 15.00, 0.00, 60.00, 30),
(80, 'Brake Discs', 4, 60.00, 0.00, 240.00, 30),
(81, 'Air Filter', 1, 10.00, 10.00, 20.00, 31),
(82, 'Fuel Filter', 1, 10.00, 10.00, 20.00, 31),
(83, 'Oil Filter', 1, 8.95, 10.00, 18.95, 31),
(84, 'Engine Oil 5w30', 1, 45.78, 20.00, 65.78, 31),
(85, 'Fuel Filter', 1, 11.00, 0.00, 11.00, 32),
(86, 'Brake Pads', 2, 14.00, 0.00, 28.00, 32),
(87, 'Brake Discs', 2, 44.00, 0.00, 88.00, 32),
(88, 'Air Conditioning', 1, 77.00, 0.00, 77.00, 32),
(89, 'Air Conditioning', 1, 77.00, 0.00, 77.00, 33),
(90, 'Oil Filter', 1, 11.00, 0.00, 11.00, 33),
(91, 'Fuel Filter', 1, 11.00, 0.00, 11.00, 33),
(92, 'Brake Pads', 2, 22.00, 0.00, 44.00, 33),
(93, 'Brake Discs', 1, 44.00, 0.00, 44.00, 33),
(94, 'Air Conditioning', 1, 77.00, 0.00, 77.00, 34),
(95, 'Brake Discs', 1, 22.00, 0.00, 22.00, 34),
(96, 'Fuel Filter', 1, 11.00, 0.00, 11.00, 34),
(97, 'Oil Filter', 1, 11.00, 0.00, 11.00, 34),
(98, 'Air Conditioning', 1, 77.00, 0.00, 77.00, 35),
(99, 'Oil Filter', 1, 11.00, 0.00, 11.00, 35),
(100, 'Brake Pads', 2, 22.00, 0.00, 44.00, 35),
(101, 'Fuel Filter', 1, 11.00, 0.00, 11.00, 35),
(102, 'Brake Discs', 1, 33.00, 0.00, 33.00, 35),
(103, 'Engine Oil 10w40', 1, 70.00, 0.00, 70.00, 36),
(104, 'Oil Filter', 1, 9.86, 0.00, 9.86, 36),
(105, 'Fuel Filter', 1, 11.00, 0.00, 11.00, 37),
(106, 'Brake Pads', 1, 8.00, 0.00, 8.00, 37),
(107, 'Brake Discs', 2, 34.00, 0.00, 68.00, 37),
(108, 'Oil Filter', 1, 11.00, 0.00, 11.00, 37),
(109, 'Brake Pads', 2, 55.00, 0.00, 110.00, 38),
(110, 'Brake Discs', 2, 66.00, 0.00, 132.00, 38),
(111, 'Clutch Kit', 1, 175.69, 200.00, 375.69, 39),
(112, 'Timing Belt', 1, 120.00, 150.00, 270.00, 39),
(113, 'Full Service Kit', 1, 175.00, 50.00, 225.00, 39),
(114, 'Fuel Filter', 1, 15.00, 0.00, 15.00, 40),
(115, 'Air Conditioning', 1, 100.00, 0.00, 100.00, 40),
(116, 'Brake Discs', 2, 77.00, 0.00, 154.00, 40),
(117, 'Brake Pads', 1, 44.00, 0.00, 44.00, 40),
(118, 'Brake Discs', 4, 50.00, 100.00, 300.00, 41),
(119, 'Brake Pads', 4, 10.00, 60.00, 100.00, 41),
(120, 'Brake Discs', 2, 34.00, 0.00, 68.00, 42),
(121, 'Brake Pads', 2, 33.00, 0.00, 66.00, 42),
(122, 'Fuel Filter', 1, 22.00, 0.00, 22.00, 42),
(123, 'Oil Filter', 1, 22.00, 0.00, 22.00, 42),
(124, 'Central Locking Repair', 1, 40.00, 60.00, 100.00, 43),
(125, 'Oil Filter', 1, 11.00, 0.00, 11.00, 44),
(126, 'Brake Discs', 1, 11.00, 0.00, 11.00, 44),
(127, 'Brake Pads', 2, 22.00, 0.00, 44.00, 44),
(128, 'Air Conditioning', 1, 35.00, 0.00, 35.00, 44);

-- --------------------------------------------------------

--
-- Table structure for table `test_survey_data`
--

CREATE TABLE `test_survey_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `question_no` int(10) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_survey_data`
--

INSERT INTO `test_survey_data` (`id`, `client_id`, `question_no`, `answer`) VALUES
(1, 1, 1, '10'),
(2, 1, 2, '10'),
(3, 1, 3, '10'),
(4, 1, 4, '10'),
(5, 1, 5, '10'),
(6, 2, 1, '10'),
(7, 2, 2, '10'),
(8, 2, 3, '10'),
(9, 2, 4, '10'),
(10, 2, 5, '10'),
(11, 4, 1, '10'),
(12, 4, 2, '10'),
(13, 4, 3, '10'),
(14, 4, 4, '10'),
(15, 4, 5, '8'),
(16, 8, 1, '3'),
(17, 8, 2, '3'),
(18, 8, 3, '3'),
(19, 8, 4, '3'),
(20, 8, 5, '3'),
(21, 3, 1, '4'),
(22, 3, 2, '6'),
(23, 3, 3, '9'),
(24, 3, 4, '10'),
(25, 3, 5, '1'),
(26, 12, 1, '8'),
(27, 12, 2, '8'),
(28, 12, 3, '9'),
(29, 12, 4, '8'),
(30, 12, 5, '9'),
(31, 13, 1, '8'),
(32, 13, 2, '10'),
(33, 13, 3, '10'),
(34, 13, 4, '10'),
(35, 13, 5, '10'),
(36, 20, 1, '8'),
(37, 20, 2, '10'),
(38, 20, 3, '9'),
(39, 20, 4, '10'),
(40, 20, 5, '8'),
(41, 17, 1, '10'),
(42, 17, 2, '10'),
(43, 17, 3, '10'),
(44, 17, 4, '10'),
(45, 17, 5, '10'),
(46, 9, 1, '10'),
(47, 9, 2, '10'),
(48, 9, 3, '10'),
(49, 9, 4, '10'),
(50, 9, 5, '10'),
(51, 7, 1, '10'),
(52, 7, 2, '10'),
(53, 7, 3, '10'),
(54, 7, 4, '10'),
(55, 7, 5, '10'),
(56, 10, 1, '10'),
(57, 10, 2, '10'),
(58, 10, 3, '10'),
(59, 10, 4, '10'),
(60, 10, 5, '10'),
(61, 5, 1, '10'),
(62, 5, 2, '10'),
(63, 5, 3, '10'),
(64, 5, 4, '10'),
(65, 5, 5, '10');

-- --------------------------------------------------------

--
-- Table structure for table `test_vehicle`
--

CREATE TABLE `test_vehicle` (
  `id` int(10) UNSIGNED NOT NULL,
  `reg` varchar(50) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(150) NOT NULL,
  `vin` varchar(250) NOT NULL,
  `odometer` varchar(100) NOT NULL,
  `fuel` varchar(100) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `owned_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_vehicle`
--

INSERT INTO `test_vehicle` (`id`, `reg`, `make`, `model`, `vin`, `odometer`, `fuel`, `created_by`, `owned_by`) VALUES
(1, 'AO06GCZ', 'Nissan', 'Primastar', '', '15000', 'diesel', 'test', 'test'),
(2, 'FJ17SKK', 'Citroen', 'Relay', '', '5600', 'diesel', 'test', 'test'),
(3, 'BN54TXH', 'Bmw', '5-series', '', '65900', 'diesel', 'test', 'test'),
(4, 'FM05KLU', 'Mercedes', 'Vito', '', '165200', 'diesel', 'test', 'test'),
(5, 'LY02DCU', 'Renault', 'Traffic', '', '120000', 'diesel', 'test', 'test'),
(6, 'DA10FKL', 'Ford', 'Ka', '', '25000', 'petrol', 'test', 'test'),
(7, 'KY13VTV', 'Vauxhall', 'Movano', '', '55000', 'diesel', 'test', 'test'),
(8, 'LR09DDE', 'Mercedes', 'Cd200', '', '250000', 'diesel', 'test', 'test'),
(9, 'CR04AUA', 'Vauxhall', 'Corsa', '', '103000', 'petrol', 'test', 'test'),
(10, 'VV19VWV', 'Ford', 'Titanium', '', '2500', 'hybrid', 'test', 'test'),
(11, 'RJ16SKK', 'Vauxhall', 'Insignia', '', '77000', 'diesel', 'test', 'test'),
(12, 'AR20ITK', 'Tesla', 'Model-s', '', '23000', 'electric', 'test', 'test'),
(13, 'CJ19RYX', 'Vauxhall', 'Zafira', '', '156000', 'petrol', 'test', 'test'),
(14, 'DT12DOD', 'Mercedes', 'Compressor 180', '', '46700', 'petrol', 'test', 'test'),
(15, 'SK19RIO', 'Toyota', 'Corolla', '', '12300', 'diesel', 'test', 'test'),
(16, 'V322AAN', 'Ford', 'Mondeo', '', '75000', 'diesel', 'test', 'test'),
(17, 'VR14AAC', 'Bmw', 'X5', '', '56000', 'diesel', 'test', 'test'),
(18, 'FR17MOD', 'Mazda', 'Cx-3', '', '10340', 'diesel', 'test', 'test'),
(19, 'FJ17SKO', 'Citroen', 'Relay', '', '19750', 'diesel', 'test', 'test'),
(20, 'PR18MUT', 'Seat', 'Toledo', '', '123000', 'diesel', 'test', 'test'),
(21, 'BN55TTH', 'Volvo', 'S90', '', '123500', 'diesel', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `test_workers`
--

CREATE TABLE `test_workers` (
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mob_one` varchar(50) NOT NULL,
  `mob_two` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(150) NOT NULL,
  `postcode` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `auth_level` enum('manager','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `test_workers`
--

INSERT INTO `test_workers` (`username`, `name`, `email`, `mob_one`, `mob_two`, `address`, `city`, `postcode`, `country`, `auth_level`) VALUES
('test_manager1', 'Name', 'man@gmail.com', 'MOBILE', '', 'Address', 'City', 'POSTCODE', 'Country', 'manager'),
('test_w', 'Name', 'email@gmail.com', 'MOBILE', '', 'Address', 'City', 'POSTCODE', 'Country', 'user'),
('test_w1', 'Name', 'email@gmail.com', '07424928497', '', 'Address', 'City', 'POSTCODE', 'Country', 'user'),
('test_w10', 'Michael', 'mike@gmail.com', '878787', '', 'Hhghghh', 'Hb', 'HHHG', 'United Kingdom', 'user'),
('test_w2', 'Name', 'email@gmail.com', '07424928497', '', 'Address', 'City', 'POSTCODE', 'Country', 'user'),
('test_w3', 'Name', 'email@gmail.com', '07424928497', '', 'Address', 'City', 'POSTCODE', 'Country', 'user'),
('test_w4', 'Name', 'email@gmail.com', 'MOBILE', '', 'Address', 'City', 'POSTCODE', 'Country', 'user'),
('test_w5', 'Michael', 'mike@gmail.com', '878787', '', 'Hhghghh', 'Hb', 'HHHG', 'United Kingdom', 'user'),
('test_w6', 'Michael', 'mike@gmail.com', '878787', '', 'Hhghghh', 'Hb', 'HHHG', 'United Kingdom', 'user'),
('test_w7', 'Michael', 'mike@gmail.com', '878787', '', 'Hhghghh', 'Hb', 'HHHG', 'United Kingdom', 'user'),
('test_w8', 'Michael', 'mike@gmail.com', '878787', '', 'Hhghghh', 'Hb', 'HHHG', 'United Kingdom', 'user'),
('test_w9', 'Michael', 'mike@gmail.com', '878787', '', 'Hhghghh', 'Hb', 'HHHG', 'United Kingdom', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `owned_by` varchar(50) NOT NULL,
  `auth_level` enum('manager','user') NOT NULL,
  `status` enum('unblocked','blocked') NOT NULL,
  `survey_status` enum('send','not completed','completed') NOT NULL,
  `survey_session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `name`, `email`, `creation_date`, `owned_by`, `auth_level`, `status`, `survey_status`, `survey_session_id`) VALUES
('test', '098f6bcd4621d373cade4e832627b4f6', 'Test Test', 'test@gmail.com', '2020-05-06 09:34:41', 'test', 'manager', 'unblocked', 'completed', ''),
('test_manager1', '098f6bcd4621d373cade4e832627b4f6', 'Name', 'man@gmail.com', '2020-05-08 15:35:31', 'test', 'manager', 'blocked', 'completed', ''),
('test_w', '098f6bcd4621d373cade4e832627b4f6', 'Name', 'email@gmail.com', '2020-05-08 14:57:13', 'test', 'user', 'unblocked', 'completed', ''),
('test_w1', '098f6bcd4621d373cade4e832627b4f6', 'Name', 'email@gmail.com', '2020-05-08 15:34:19', 'test', 'user', 'unblocked', 'completed', ''),
('test_w10', '098f6bcd4621d373cade4e832627b4f6', 'Michael', 'mike@gmail.com', '2020-05-10 15:12:44', 'test', 'user', 'unblocked', 'completed', ''),
('test_w2', '098f6bcd4621d373cade4e832627b4f6', 'Name', 'email@gmail.com', '2020-05-08 15:34:54', 'test', 'user', 'unblocked', 'completed', ''),
('test_w3', '098f6bcd4621d373cade4e832627b4f6', 'Name', 'email@gmail.com', '2020-05-10 15:10:06', 'test', 'user', 'unblocked', 'completed', ''),
('test_w4', '098f6bcd4621d373cade4e832627b4f6', 'Name', 'email@gmail.com', '2020-05-10 15:11:16', 'test', 'user', 'unblocked', 'completed', ''),
('test_w5', '098f6bcd4621d373cade4e832627b4f6', 'Michael', 'mike@gmail.com', '2020-05-10 15:11:37', 'test', 'user', 'unblocked', 'completed', ''),
('test_w6', '098f6bcd4621d373cade4e832627b4f6', 'Michael', 'mike@gmail.com', '2020-05-10 15:11:50', 'test', 'user', 'unblocked', 'completed', ''),
('test_w7', '098f6bcd4621d373cade4e832627b4f6', 'Michael', 'mike@gmail.com', '2020-05-10 15:12:07', 'test', 'user', 'unblocked', 'completed', ''),
('test_w8', '098f6bcd4621d373cade4e832627b4f6', 'Michael', 'mike@gmail.com', '2020-05-10 15:12:19', 'test', 'user', 'unblocked', 'completed', '');

-- --------------------------------------------------------

--
-- Structure for view `test_graphs_data`
--
DROP TABLE IF EXISTS `test_graphs_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cosmin`@`localhost` SQL SECURITY DEFINER VIEW `test_graphs_data`  AS  select `test_invoice`.`id` AS `id`,`test_invoice`.`invoice_date` AS `invoice_date`,`test_invoice`.`job_time` AS `job_time`,`test_invoice`.`hourly_charge` AS `hourly_charge`,`test_invoice`.`discount` AS `discount`,`test_invoice`.`status` AS `status`,`test_invoice`.`remaining_balance` AS `remaining_balance`,`test_invoice_items`.`item_price` AS `item_price`,`test_invoice_items`.`labour_price` AS `labour_price`,`test_invoice_items`.`total_price` AS `total_price`,`test_invoice`.`sub_total` AS `sub_total`,`test_invoice`.`grand_total` AS `grand_total`,`test_invoice`.`created_by` AS `created_by` from (`test_invoice` join `test_invoice_items`) where `test_invoice`.`id` = `test_invoice_items`.`invoice_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `uniqueusername` (`username`);

--
-- Indexes for table `admin_survey_data`
--
ALTER TABLE `admin_survey_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_survey_data_comments`
--
ALTER TABLE `admin_survey_data_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuel_type`
--
ALTER TABLE `fuel_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_bookings`
--
ALTER TABLE `test_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_clients`
--
ALTER TABLE `test_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_company`
--
ALTER TABLE `test_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_invoice`
--
ALTER TABLE `test_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_invoice_items`
--
ALTER TABLE `test_invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_survey_data`
--
ALTER TABLE `test_survey_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_vehicle`
--
ALTER TABLE `test_vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_workers`
--
ALTER TABLE `test_workers`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `uniqueusername` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_survey_data`
--
ALTER TABLE `admin_survey_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `admin_survey_data_comments`
--
ALTER TABLE `admin_survey_data_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `fuel_type`
--
ALTER TABLE `fuel_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `test_bookings`
--
ALTER TABLE `test_bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `test_clients`
--
ALTER TABLE `test_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `test_company`
--
ALTER TABLE `test_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `test_invoice`
--
ALTER TABLE `test_invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `test_invoice_items`
--
ALTER TABLE `test_invoice_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `test_survey_data`
--
ALTER TABLE `test_survey_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `test_vehicle`
--
ALTER TABLE `test_vehicle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
