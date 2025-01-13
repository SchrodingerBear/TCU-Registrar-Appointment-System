-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 13, 2025 at 02:24 PM
-- Server version: 10.4.33-MariaDB-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tcuregistrar`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(30) NOT NULL,
  `patient_id` int(30) NOT NULL,
  `date_sched` datetime NOT NULL,
  `ailment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `date_sched`, `ailment`, `status`, `date_created`) VALUES
(1, 22, '2025-01-30 09:37:00', 'seancvpugosa@gmail.comav', 0, '2025-01-09 09:37:36'),
(2, 23, '2025-02-04 09:40:00', 'seancvpugosa@gmail.com', 0, '2025-01-09 09:40:45'),
(3, 24, '2025-01-27 09:41:00', 'seancvpugosa@gmail.com', 0, '2025-01-09 09:41:43'),
(4, 25, '2025-02-06 09:45:00', 'seancvpugosa@gmail.com', 0, '2025-01-09 09:45:53'),
(5, 9, '2025-03-05 09:47:00', 'seancvpugosa@gmail.com', 0, '2025-01-09 09:48:08'),
(6, 9, '2025-01-28 09:53:00', 'seancvpugosa@gmail.com', 0, '2025-01-09 09:53:45'),
(7, 9, '2025-01-17 08:13:00', 'ntes', 0, '2025-01-09 12:13:19'),
(8, 9, '2025-01-20 13:02:00', '123', 0, '2025-01-09 13:02:45'),
(9, 9, '2025-01-29 13:03:00', 'asdasd', 0, '2025-01-09 13:03:07'),
(10, 9, '2025-02-07 13:03:00', 'asd', 0, '2025-01-09 13:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `booked`
--

CREATE TABLE `booked` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `class` varchar(10) NOT NULL DEFAULT 'second',
  `no` int(11) NOT NULL DEFAULT 1,
  `seat` varchar(30) NOT NULL,
  `date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booked`
--

INSERT INTO `booked` (`id`, `schedule_id`, `payment_id`, `user_id`, `code`, `class`, `no`, `seat`, `date`) VALUES
(15, 5, 12, 4, '2020/005/1324', 'first', 1, 'F01', 'Tue, 11-Aug-2020 11:52:19 AM'),
(17, 5, 15, 3, '2020/005/2645', 'first', 5, 'F02', 'Tue, 11-Aug-2020 12:48:38 PM'),
(18, 6, 16, 3, '2020/006/1655', 'first', 8, 'F001 -F008', 'Tue, 11-Aug-2020 01:08:20 PM'),
(19, 6, 1, 4, '2020/006/9146', 'second', 1, 'S0001', 'Tue, 11-Aug-2020 01:09:22 PM'),
(20, 8, 18, 4, '2020/008/1144', 'second', 8, 'S0001 -S0008', 'Tue, 11-Aug-2020 01:12:58 PM'),
(21, 18, 19, 1, '2020/018/1671', 'first', 8, 'F01 -F08', 'Tue, 11-Aug-2020 04:10:29 PM'),
(22, 20, 20, 5, '2020/020/126', 'first', 30, 'F01 - F30', 'Mon, 31-Aug-2020 11:36:57 PM'),
(23, 20, 21, 6, '2020/020/31816', 'first', 2, 'F31 - F32', 'Fri, 06-Nov-2020 10:10:44 PM'),
(24, 22, 22, 6, '2020/022/1176', 'second', 1, 'S001', 'Sun, 08-Nov-2020 02:08:07 PM'),
(25, 24, 23, 2, '2020/024/197', 'second', 2, 'S001 - S002', 'Sun, 15-Nov-2020 02:25:27 PM'),
(26, 26, 24, 8, '2021/026/1183', 'first', 4, 'F01 - F04', 'Fri, 17-Sep-2021 04:25:09 PM'),
(27, 98, 25, 7, '2021/098/198', 'first', 2, 'F001 - F002', 'Wed, 13-Oct-2021 05:17:54 AM'),
(28, 99, 26, 7, '2021/099/157', 'second', 1, 'S001', 'Wed, 13-Oct-2021 05:28:54 AM'),
(29, 100, 27, 7, '2021/0100/1134', 'second', 1, 'S001', 'Wed, 13-Oct-2021 05:39:18 AM'),
(30, 101, 39, 7, '2021/0101/1116', 'second', 1, 'S001', 'Wed, 13-Oct-2021 06:15:30 AM'),
(31, 102, 40, 7, '2021/0102/1502', 'first', 1, 'F001', 'Wed, 13-Oct-2021 06:18:10 AM'),
(32, 103, 43, 7, '2021/0103/1792', 'second', 2, 'S001 - S002', 'Wed, 13-Oct-2021 11:02:56 AM'),
(33, 103, 44, 8, '2021/0103/3809', 'second', 1, 'S003', 'Wed, 13-Oct-2021 02:21:40 PM'),
(34, 104, 45, 8, '2021/0104/1526', 'first', 2, 'F001 - F002', 'Wed, 13-Oct-2021 05:22:15 PM');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(400) NOT NULL,
  `response` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `message`, `response`) VALUES
(1, 3, 'This is a demo test.', NULL),
(3, 6, 'Demo Test - 2', 'Are you sure that this is another test? '),
(8, 4, 'This is a feedback text', NULL),
(9, 6, 'Test Test Test Test Test', NULL),
(11, 8, 'This is a demo test for feedback sections!!!', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(30) NOT NULL,
  `location` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `max_a_day` int(5) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `location`, `description`, `max_a_day`, `date_created`, `date_updated`) VALUES
(1, 'Vaccination Location 1, Sample City, Negros Occidental', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus accumsan ac justo consequat dignissim. Nam eget pretium nisl, at tempor velit. Sed vel nisl a metus porta placerat in in neque. Praesent aliquam nisi nisl, eget porta lacus iaculis ac. Fusce dignissim et nibh vel euismod. Vestibulum eget enim metus. Ut faucibus, lectus facilisis eleifend dignissim, ligula lorem porttitor elit, eu placerat odio urna quis augue. Proin rutrum, enim in auctor rhoncus, turpis ipsum rutrum sem, nec varius purus nisi at dolor. Donec porta turpis vel erat iaculis, eget consequat mauris dapibus. Nullam euismod quam sagittis nisl maximus auctor. Duis turpis nisi, condimentum eget interdum ut, ultricies non turpis. Donec auctor a mi at commodo. Vivamus ultrices venenatis orci, vel venenatis sem pharetra ac. Ut scelerisque lorem sed purus facilisis lacinia.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 500, '2021-06-28 09:52:13', '2021-06-28 09:52:39'),
(4, 'Sample location  2', '&lt;p&gt;Sample only&lt;/p&gt;', 100, '2021-06-28 16:19:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(40) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `loc` varchar(40) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`id`, `name`, `email`, `password`, `phone`, `address`, `loc`, `status`) VALUES
(1, 'Passenger One', 'pas1o@mail.com', '1f87051e29a6927b2e6651dfb9b66387', '0780100000', 'No. 20 Aiyeteju Street', 'f3fc8566140434f0a3f47303c62d5146.jpg', 1),
(2, 'Adelabu Simbiat', 'jobowonubi@otrs.com', '1526755d438e395e551f229a484f8a1d', '3000002000', 'No. 30 Tanke Ilorin', 'f3fc8566140434f0a3f47303c62d5146.jpg', 1),
(3, 'Passenger Two', 'pass2@mail.com', 'c3a19571f1271af5f27a9582377b7d4a', '1400000020', 'abrahamjasmine', 'f3fc8566140434f0a3f47303c62d5146.jpg', 0),
(4, 'Passenger Three', 'pass3@mail.com', '1dd76b458af8df200a097c5b061df9b1', '9000001000', 'No. 589 Ilorin', 'f3fc8566140434f0a3f47303c62d5146.jpg', 1),
(5, 'Passenger Four', 'pass4@mail.com', 'd780455a563c7c5dbfb74a51785ad949', '0000010020', 'Shagamu', 'f3fc8566140434f0a3f47303c62d5146.jpg', 1),
(6, 'Test Passenger', 'testpass@mail.com', 'abe1bcf64eb68c39847b962e8caadadf', '0000002000', 'Ilorin', 'f3fc8566140434f0a3f47303c62d5146.jpg', 1),
(7, 'Liam Moore', 'liamoore@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '7000000000', '7014 Allace Road', 'f3fc8566140434f0a3f47303c62d5146.jpg', 1),
(8, 'Demo Account', 'demoaccount@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '7800000000', '100 Demo Address', '404a6378027a553d980b99162a5b4ce8.png', 1),
(9, 'seancvpugosa@gmail.com', 'seancvpugosa@gmail.com', 'e4447e63d0a0dffead7007cdc5c8dd51', '63', 'seancvpugosa@gmail.com', 'seancvpugosa@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient_list`
--

CREATE TABLE `patient_list` (
  `id` int(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_list`
--

INSERT INTO `patient_list` (`id`, `name`, `date_created`) VALUES
(6, 'John Smith', '2021-09-02 21:58:59'),
(9, 'Claire Blake', '2021-09-02 23:14:50'),
(10, 'Mike Williams', '2021-09-02 23:23:05'),
(11, 'Samantha Lou', '2021-09-02 23:44:32'),
(12, 'Test', '2025-01-09 08:32:54'),
(13, 'Sean', '2025-01-09 08:33:40'),
(14, 'seancvpugosa@gmail.com', '2025-01-09 08:49:45'),
(15, 'seancvpugosa@gmail.com', '2025-01-09 09:04:39'),
(16, 'seancvpugosa@gmail.com', '2025-01-09 09:05:15'),
(17, 'seancvpugosa@gmail.com', '2025-01-09 09:06:14'),
(18, 'seancvpugosa@gmail.com', '2025-01-09 09:10:39'),
(19, 'seancvpugosa@gmail.com', '2025-01-09 09:11:43'),
(20, 'seancvpugosa@gmail.com', '2025-01-09 09:13:51'),
(21, 'seancvpugosa@gmail.com', '2025-01-09 09:14:46'),
(22, 'seancvpugosa@gmail.com', '2025-01-09 09:37:36'),
(23, 'seancvpugosa@gmail.com', '2025-01-09 09:40:45'),
(24, 'seancvpugosa@gmail.com', '2025-01-09 09:41:43'),
(25, 'seancvpugosa@gmail.com', '2025-01-09 09:45:53');

-- --------------------------------------------------------

--
-- Table structure for table `patient_meta`
--

CREATE TABLE `patient_meta` (
  `patient_id` int(30) NOT NULL,
  `meta_field` text DEFAULT NULL,
  `meta_value` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_meta`
--

INSERT INTO `patient_meta` (`patient_id`, `meta_field`, `meta_value`, `date_created`, `id`) VALUES
(10, 'id', '', '2021-09-02 23:23:05', 9),
(10, 'patient_id', '', '2021-09-02 23:23:05', 10),
(10, 'name', 'Mike Williams', '2021-09-02 23:23:05', 11),
(10, 'email', 'mwilliams@sample.com', '2021-09-02 23:23:05', 12),
(10, 'contact', '09789456321', '2021-09-02 23:23:05', 13),
(10, 'gender', 'Female', '2021-09-02 23:23:05', 14),
(10, 'dob', '1990-12-10', '2021-09-02 23:23:05', 15),
(10, 'address', 'Sample Address', '2021-09-02 23:23:05', 16),
(6, 'id', '6', '2025-01-09 08:31:12', 17),
(6, 'patient_id', '6', '2025-01-09 08:31:12', 18),
(6, 'name', 'John Smith', '2025-01-09 08:31:12', 19),
(6, 'email', 'jsmith@sample.com', '2025-01-09 08:31:12', 20),
(6, 'contact', '09123456789', '2025-01-09 08:31:12', 21),
(6, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 08:31:12', 22),
(6, 'dob', '1997-06-23', '2025-01-09 08:31:12', 23),
(6, 'subject', 'Array', '2025-01-09 08:31:12', 24),
(11, 'id', '12', '2025-01-09 08:32:10', 25),
(11, 'patient_id', '11', '2025-01-09 08:32:10', 26),
(11, 'name', 'Samantha Lou', '2025-01-09 08:32:10', 27),
(11, 'email', 'slou@sample.com', '2025-01-09 08:32:10', 28),
(11, 'contact', '09123654456', '2025-01-09 08:32:10', 29),
(11, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 08:32:10', 30),
(11, 'dob', '1990-12-07', '2025-01-09 08:32:10', 31),
(11, 'subject', '[\"Course Schedule\",\"Good Moral\"]', '2025-01-09 08:32:10', 32),
(12, 'id', '', '2025-01-09 08:32:54', 33),
(12, 'patient_id', '', '2025-01-09 08:32:54', 34),
(12, 'name', 'Test', '2025-01-09 08:32:54', 35),
(12, 'email', 'seancvpugosa@gmail.com', '2025-01-09 08:32:54', 36),
(12, 'contact', '123', '2025-01-09 08:32:54', 37),
(12, 'department', 'College of Business Management (CBM)', '2025-01-09 08:32:54', 38),
(12, 'dob', '2025-02-06', '2025-01-09 08:32:54', 39),
(12, 'subject', '[\"Diplomas and Certificate\",\"Good Moral\"]', '2025-01-09 08:32:54', 40),
(13, 'id', '1', '2025-01-09 08:47:10', 81),
(13, 'patient_id', '13', '2025-01-09 08:47:10', 82),
(13, 'name', 'Sean', '2025-01-09 08:47:10', 83),
(13, 'email', 'seancvpugosa@gmail.com', '2025-01-09 08:47:10', 84),
(13, 'contact', '1', '2025-01-09 08:47:10', 85),
(13, 'department', 'College of Business Management (CBM)', '2025-01-09 08:47:10', 86),
(13, 'dob', '2025-01-28', '2025-01-09 08:47:10', 87),
(13, 'documents', '[\"Course Schedule\",\"Good Moral\"]', '2025-01-09 08:47:10', 88),
(14, 'id', '', '2025-01-09 08:49:45', 89),
(14, 'patient_id', '', '2025-01-09 08:49:45', 90),
(14, 'name', 'seancvpugosa@gmail.com', '2025-01-09 08:49:45', 91),
(14, 'email', 'seancvpugosa@gmail.com', '2025-01-09 08:49:45', 92),
(14, 'contact', 'seancvpugosa@gmail.com', '2025-01-09 08:49:45', 93),
(14, 'department', 'College of Business Management (CBM)', '2025-01-09 08:49:45', 94),
(14, 'dob', '2025-01-29', '2025-01-09 08:49:45', 95),
(14, 'documents', '[\"Transcript of Record\",\"Course Schedule\"]', '2025-01-09 08:49:45', 96),
(15, 'id', '', '2025-01-09 09:04:39', 97),
(15, 'patient_id', '', '2025-01-09 09:04:39', 98),
(15, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:04:39', 99),
(15, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:04:39', 100),
(15, 'contact', 'seancvpugosa@gmail.com', '2025-01-09 09:04:39', 101),
(15, 'department', 'College of Business Management (CBM)', '2025-01-09 09:04:39', 102),
(15, 'dob', '2025-02-06', '2025-01-09 09:04:39', 103),
(15, 'documents', '[\"Diplomas and Certificate\",\"Course Schedule\"]', '2025-01-09 09:04:39', 104),
(16, 'id', '', '2025-01-09 09:05:15', 105),
(16, 'patient_id', '', '2025-01-09 09:05:15', 106),
(16, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:05:15', 107),
(16, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:05:15', 108),
(16, 'contact', 'seancvpugosa@gmail.com', '2025-01-09 09:05:15', 109),
(16, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:05:15', 110),
(16, 'dob', '2025-02-01', '2025-01-09 09:05:15', 111),
(16, 'documents', '[\"Course Schedule\",\"Good Moral\"]', '2025-01-09 09:05:15', 112),
(17, 'id', '', '2025-01-09 09:06:14', 113),
(17, 'patient_id', '', '2025-01-09 09:06:14', 114),
(17, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:06:14', 115),
(17, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:06:14', 116),
(17, 'contact', 'seancvpugosa@gmail.com', '2025-01-09 09:06:14', 117),
(17, 'department', 'College of Criminal Justice (CCJ)', '2025-01-09 09:06:14', 118),
(17, 'dob', '2025-01-21', '2025-01-09 09:06:14', 119),
(17, 'documents', '[\"Diplomas and Certificate\",\"Good Moral\"]', '2025-01-09 09:06:14', 120),
(18, 'id', '', '2025-01-09 09:10:39', 121),
(18, 'patient_id', '', '2025-01-09 09:10:39', 122),
(18, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:10:39', 123),
(18, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:10:39', 124),
(18, 'contact', 'seancvpugosa@gmail.com', '2025-01-09 09:10:39', 125),
(18, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:10:39', 126),
(18, 'dob', '2025-01-29', '2025-01-09 09:10:39', 127),
(18, 'documents', '[\"Diplomas and Certificate\",\"Good Moral\"]', '2025-01-09 09:10:39', 128),
(19, 'id', '2', '2025-01-09 09:13:24', 137),
(19, 'patient_id', '19', '2025-01-09 09:13:24', 138),
(19, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:13:24', 139),
(19, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:13:24', 140),
(19, 'contact', 'seancvpugosa@gmail.com', '2025-01-09 09:13:24', 141),
(19, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:13:24', 142),
(19, 'dob', '2025-01-29', '2025-01-09 09:13:24', 143),
(19, 'documents', '[\"Transcript of Record\",\"Course Schedule\"]', '2025-01-09 09:13:24', 144),
(20, 'id', '', '2025-01-09 09:13:51', 145),
(20, 'patient_id', '', '2025-01-09 09:13:51', 146),
(20, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:13:51', 147),
(20, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:13:51', 148),
(20, 'contact', 'seancvpugosa@gmail.com', '2025-01-09 09:13:51', 149),
(20, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:13:51', 150),
(20, 'dob', '2025-02-07', '2025-01-09 09:13:51', 151),
(20, 'documents', '[\"Diplomas and Certificate\",\"Good Moral\"]', '2025-01-09 09:13:51', 152),
(21, 'id', '', '2025-01-09 09:14:46', 153),
(21, 'patient_id', '', '2025-01-09 09:14:46', 154),
(21, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:14:46', 155),
(21, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:14:46', 156),
(21, 'contact', 'seancvpugosa@gmail.com', '2025-01-09 09:14:46', 157),
(21, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:14:46', 158),
(21, 'dob', '2025-01-30', '2025-01-09 09:14:46', 159),
(21, 'documents', '[\"Transcript of Record\",\"Diplomas and Certificate\"]', '2025-01-09 09:14:46', 160),
(22, 'id', '', '2025-01-09 09:37:36', 161),
(22, 'patient_id', '', '2025-01-09 09:37:36', 162),
(22, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:37:36', 163),
(22, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:37:36', 164),
(22, 'contact', '9', '2025-01-09 09:37:36', 165),
(22, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:37:36', 166),
(22, 'dob', '2025-01-18', '2025-01-09 09:37:36', 167),
(22, 'documents', '[\"Diplomas and Certificate\"]', '2025-01-09 09:37:36', 168),
(23, 'id', '', '2025-01-09 09:40:45', 169),
(23, 'patient_id', '', '2025-01-09 09:40:45', 170),
(23, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:40:45', 171),
(23, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:40:45', 172),
(23, 'contact', '9', '2025-01-09 09:40:45', 173),
(23, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:40:45', 174),
(23, 'dob', '2025-01-21', '2025-01-09 09:40:45', 175),
(23, 'documents', '[\"Course Schedule\"]', '2025-01-09 09:40:45', 176),
(24, 'id', '', '2025-01-09 09:41:43', 177),
(24, 'patient_id', '', '2025-01-09 09:41:43', 178),
(24, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:41:43', 179),
(24, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:41:43', 180),
(24, 'contact', '9', '2025-01-09 09:41:43', 181),
(24, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:41:43', 182),
(24, 'dob', '2025-01-14', '2025-01-09 09:41:43', 183),
(24, 'documents', '[\"Course Schedule\"]', '2025-01-09 09:41:43', 184),
(25, 'id', '', '2025-01-09 09:45:53', 185),
(25, 'patient_id', '', '2025-01-09 09:45:53', 186),
(25, 'name', 'seancvpugosa@gmail.com', '2025-01-09 09:45:53', 187),
(25, 'email', 'seancvpugosa@gmail.com', '2025-01-09 09:45:53', 188),
(25, 'contact', '9', '2025-01-09 09:45:53', 189),
(25, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 09:45:53', 190),
(25, 'dob', '2025-02-04', '2025-01-09 09:45:53', 191),
(25, 'documents', '[\"Diplomas and Certificate\"]', '2025-01-09 09:45:53', 192),
(9, 'id', '', '2025-01-09 13:03:43', 233),
(9, 'patient_id', '', '2025-01-09 13:03:43', 234),
(9, 'name', 'seancvpugosa@gmail.com', '2025-01-09 13:03:43', 235),
(9, 'email', 'seancvpugosa@gmail.com', '2025-01-09 13:03:43', 236),
(9, 'contact', '9', '2025-01-09 13:03:43', 237),
(9, 'department', 'College of Arts and Sciences (CAS)', '2025-01-09 13:03:43', 238),
(9, 'dob', '2025-01-14', '2025-01-09 13:03:43', 239),
(9, 'documents', '[\"Good Moral\"]', '2025-01-09 13:03:43', 240);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `ref` varchar(100) NOT NULL,
  `date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `passenger_id`, `schedule_id`, `amount`, `ref`, `date`) VALUES
(12, 4, 5, '520', 'oyki20masb', 'Tue, 11-Aug-2020 11:52:19 AM'),
(14, 4, 6, '23', 'oyki20masb', 'Tue, 11-Aug-2020 11:52:19 AM'),
(15, 3, 5, '1860', '5gtnjnzclw', 'Tue, 11-Aug-2020 12:48:38 PM'),
(16, 3, 6, '680', 'dzwl1488r0', 'Tue, 11-Aug-2020 01:08:20 PM'),
(18, 4, 8, '8080', 'hja9zvtmgk', 'Tue, 11-Aug-2020 01:12:58 PM'),
(19, 1, 18, '1080', '3TVSHVBQII', 'Tue, 11-Aug-2020 04:10:29 PM'),
(20, 5, 20, '120', '84JP4U5LKZ', 'Mon, 31-Aug-2020 11:36:57 PM'),
(21, 6, 20, '8080', 'VXIZSCHMOG', 'Fri, 06-Nov-2020 10:10:44 PM'),
(22, 6, 22, '1410', 'TDHRBZTZOH', 'Sun, 08-Nov-2020 02:08:07 PM'),
(23, 2, 24, '5050', '4TRM9FIFEV', 'Sun, 15-Nov-2020 02:25:27 PM'),
(24, 8, 26, '5260', '1QXPYSUTOI', 'Fri, 17-Sep-2021 04:25:09 PM'),
(25, 7, 98, '303', 'FIPJBLU5LC', 'Wed, 13-Oct-2021 05:17:54 AM'),
(26, 7, 99, '80', 'NKMGVH44QG', 'Wed, 13-Oct-2021 05:28:54 AM'),
(27, 7, 100, '51', 'NS5IEEK1HS', 'Wed, 13-Oct-2021 05:39:18 AM'),
(39, 7, 101, '56', 'OEPPIM6X9H', 'Wed, 13-Oct-2021 06:15:30 AM'),
(40, 7, 102, '107', 'M07FP4QTOV', 'Wed, 13-Oct-2021 06:18:10 AM'),
(43, 7, 103, '152', 'RITK5E5GDM', 'Wed, 13-Oct-2021 11:02:56 AM'),
(44, 8, 103, '76', 'H6CMTHBJUU', 'Wed, 13-Oct-2021 02:21:40 PM'),
(45, 8, 104, '324', 'KH70GOC8KO', 'Wed, 13-Oct-2021 05:22:15 PM');

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `start` varchar(100) NOT NULL,
  `stop` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`id`, `start`, `stop`) VALUES
(3, 'St Bawle', 'San Ghammea'),
(4, 'Hurstcracombe', 'Treeblooms'),
(5, 'Cape Onbac', 'Ringkya'),
(6, 'Treeblooms', 'Bridghamgascon'),
(7, 'Fort Hammits', 'Aux Cursbur'),
(8, 'Addersfield', 'Glenarm'),
(9, 'Peterbrugh', 'Ffestiniog'),
(10, 'Dawsbury', 'Blencathra'),
(11, 'Rutherglen', 'Tylwaerdreath'),
(12, 'Cirencester', 'Bournemouth'),
(13, 'Laencaster', 'Fournemouth'),
(14, 'Urmkirkey', 'Longdale'),
(15, 'Vlinginia', 'Onaginia'),
(16, 'Onaginia', 'Epleburgh'),
(17, 'Epleburgh', 'Kapwood'),
(18, 'Vlinginia', 'Oroville'),
(19, 'Vlinginia', 'Inaschester');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(10) NOT NULL,
  `first_fee` float NOT NULL,
  `second_fee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `train_id`, `route_id`, `date`, `time`, `first_fee`, `second_fee`) VALUES
(5, 7, 7, '11-08-2020', '18:30', 180, 80),
(6, 11, 6, '11-08-2020', '18:30', 200, 85),
(7, 11, 5, '12-08-2020', '18:30', 130, 45),
(8, 11, 4, '13-08-2020', '18:30', 130, 60),
(9, 11, 3, '14-08-2020', '18:30', 100, 40),
(10, 7, 5, '15-08-2020', '18:30', 160, 100),
(11, 9, 7, '16-08-2020', '18:30', 180, 100),
(12, 10, 5, '17-08-2020', '18:30', 310, 150),
(16, 2, 7, '16-08-2020', '11:00', 265, 180),
(17, 9, 3, '23-08-2020', '11:00', 180, 115),
(18, 10, 4, '30-08-2020', '11:00', 180, 100),
(20, 8, 4, '07-11-2020', '22:24', 165, 100),
(22, 8, 3, '08-11-2020', '15:13', 130, 70),
(23, 3, 3, '07-11-2020', '15:10', 100, 85),
(24, 2, 3, '15-11-2020', '15:22', 130, 95),
(25, 1, 3, '11-06-2021', '05:37', 65, 55),
(26, 2, 3, '18-09-2021', '09:00', 130, 90),
(97, 11, 8, '11-10-2021', '11:05', 185, 90),
(98, 10, 14, '12-10-2021', '09:00', 150, 85),
(99, 8, 11, '12-10-2021', '11:10', 166, 79),
(100, 9, 12, '12-10-2021', '12:20', 100, 50),
(101, 2, 10, '12-10-2021', '22:59', 105, 55),
(102, 7, 4, '12-10-2021', '11:02', 105, 65),
(103, 9, 11, '12-10-2021', '04:45', 120, 75),
(104, 12, 15, '14-10-2021', '10:00', 160, 72);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_settings`
--

CREATE TABLE `schedule_settings` (
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  `date_create` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_settings`
--

INSERT INTO `schedule_settings` (`meta_field`, `meta_value`, `date_create`, `id`) VALUES
('day_schedule', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday', '2025-01-09 12:33:05', 37),
('morning_schedule', '08:00,11:00', '2025-01-09 12:33:05', 38),
('afternoon_schedule', '13:00,16:00', '2025-01-09 12:33:05', 39),
('holiday_schedule', '2025-01-10,2025-01-22', '2025-01-09 12:33:05', 40);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'TCU Appointment Scheduler System - PHP'),
(6, 'short_name', 'TCU - ASS '),
(11, 'logo', 'uploads/1630631400_clinic-logo.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1630631400_clinic-cover.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `train`
--

CREATE TABLE `train` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `first_seat` int(11) NOT NULL,
  `second_seat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `train`
--

INSERT INTO `train` (`id`, `name`, `first_seat`, `second_seat`) VALUES
(1, 'Kano Rails', 30, 800),
(2, 'British Railways', 20, 900),
(3, 'Wester Railways', 10, 600),
(7, 'Lagos Rails', 400, 1000),
(8, 'Marble Railways', 395, 780),
(9, 'Renfee R', 400, 850),
(10, 'Venice Express', 500, 1200),
(11, 'Orient Express', 200, 500),
(12, 'Phantom Express', 250, 600),
(13, 'Marshland Express', 300, 500);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `loc` varchar(40) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `phone`, `address`, `loc`, `status`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', '', '', '', 1, 'uploads/1624240500_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-06-21 09:55:07'),
(6, 'George', 'Wilson', 'gwilson', 'd40242fb23c45206fadee4e2418f274f', '', '', '', 1, 'uploads/1630598640_male.png', NULL, 0, '2021-09-03 00:04:40', '2021-09-03 00:07:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_list`
--
ALTER TABLE `patient_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_meta`
--
ALTER TABLE `patient_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `schedule_settings`
--
ALTER TABLE `schedule_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient_list`
--
ALTER TABLE `patient_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `patient_meta`
--
ALTER TABLE `patient_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `schedule_settings`
--
ALTER TABLE `schedule_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient_meta`
--
ALTER TABLE `patient_meta`
  ADD CONSTRAINT `patient_meta_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
