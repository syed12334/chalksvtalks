-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 26, 2023 at 05:38 AM
-- Server version: 5.7.37
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sha`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `status`, `created_at`) VALUES
(1, 'admin', '$2y$10$SywMmu2nU3KYzIVSwRzSz.tSA0izvdk0RmSzVBc2xmE5UgPueqKPm', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `areaname` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `cid`, `areaname`, `status`, `created_at`, `modified_at`) VALUES
(3, 1, 'Bengaluru South', 0, '2022-08-12 10:41:16', '2022-08-12 12:52:15'),
(4, 1, 'Bengaluru North', 0, '2022-08-12 15:15:34', ''),
(5, 1, 'Basavanagudi', 0, '2022-08-17 15:50:27', ''),
(6, 1, 'Bengaluru East', 0, '2022-08-17 15:52:18', '2022-08-17 15:52:25'),
(7, 1, 'Bengaluru West', 0, '2022-08-17 15:52:43', ''),
(8, 1, 'Bengaluru Central', 0, '2022-08-17 15:52:56', ''),
(9, 1, 'Bengaluru All', 0, '2022-08-17 15:53:10', ''),
(10, 1, 'Indira Nagar, Bengaluru', 0, '2022-08-17 15:53:44', '2022-08-17 15:55:01'),
(11, 1, 'Jayanagar, Bengaluru', 0, '2022-08-17 15:54:34', '2022-08-17 15:55:12'),
(12, 1, 'Koramangala, Bengaluru', 0, '2022-08-17 15:56:13', '2022-08-17 15:56:24'),
(14, 11, 'Kolkata South', 0, '2022-09-12 13:20:23', '2022-10-17 20:00:59'),
(23, 51, 'Ahmednagar', 0, '2022-11-03 11:08:31', '');

-- --------------------------------------------------------

--
-- Table structure for table `arttype`
--

CREATE TABLE `arttype` (
  `art_id` int(11) NOT NULL,
  `art_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arttype`
--

INSERT INTO `arttype` (`art_id`, `art_name`, `status`, `created_at`, `modified_at`) VALUES
(1, 'demos', 0, '2023-01-11 12:30:52', '2023-01-11 12:31:20');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cname` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `page_url` varchar(180) NOT NULL,
  `icons` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive	',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cname`, `image`, `page_url`, `icons`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Sports', '', 'sports', '', 0, '2023-01-12 11:41:03', '2023-01-20 10:19:50'),
(2, 'Games', '', 'games', '', 0, '2023-01-20 10:19:57', ''),
(3, 'Education', '', 'education', '', 0, '2023-01-20 10:20:08', ''),
(4, 'Football', '', 'football', '', 0, '2023-01-20 10:20:17', ''),
(5, 'Cricket', '', 'cricket', '', 0, '2023-01-20 10:20:23', ''),
(6, 'Food and Beverages', '', 'food-and-beverages', '', 0, '2023-01-20 10:20:34', '2023-03-23 13:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `celebrities`
--

CREATE TABLE `celebrities` (
  `c_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `art_type` int(11) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `totalfans` varchar(20) NOT NULL,
  `city_id` int(11) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `celebrities`
--

INSERT INTO `celebrities` (`c_id`, `name`, `art_type`, `experience`, `totalfans`, `city_id`, `phone`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Demo', 1, '5 years', '5', 2, '9986571768', 0, '2023-01-11 16:33:17', '2023-01-11 17:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `sid`, `cname`, `status`, `created_at`, `modified_date`) VALUES
(1, 1, 'Bengaluru', 0, '2022-07-22 05:52:19', '0000-00-00 00:00:00'),
(2, 1, 'Mangalore', 0, '2022-07-22 05:52:19', '0000-00-00 00:00:00'),
(3, 2, 'Chennai', 0, '2022-07-22 05:52:19', '0000-00-00 00:00:00'),
(4, 2, 'Coimbatore', 0, '2022-07-22 05:52:19', '0000-00-00 00:00:00'),
(5, 2, 'Madurai', 0, '2022-07-22 05:52:19', '2022-07-25 20:11:12'),
(11, 9, 'Kolkata', 0, '2022-09-12 13:19:16', '0000-00-00 00:00:00'),
(12, 9, 'Durgapur', 0, '2022-09-12 15:41:58', '0000-00-00 00:00:00'),
(13, 9, 'Asansol', 0, '2022-09-12 15:42:13', '0000-00-00 00:00:00'),
(14, 9, 'Bankura', 0, '2022-09-12 15:42:42', '0000-00-00 00:00:00'),
(15, 1, 'Mysore', 0, '2022-09-12 15:43:17', '0000-00-00 00:00:00'),
(16, 22, 'Mumbai', 0, '2022-09-12 15:45:10', '0000-00-00 00:00:00'),
(17, 22, 'Pune', 0, '2022-09-12 15:45:23', '0000-00-00 00:00:00'),
(18, 10, 'Amaravati', 0, '2022-09-12 15:46:02', '0000-00-00 00:00:00'),
(19, 10, 'Visakhapatnam', 0, '2022-09-12 15:46:31', '0000-00-00 00:00:00'),
(20, 32, 'Hyderabad', 0, '2022-09-12 15:47:53', '0000-00-00 00:00:00'),
(21, 32, 'Secunderabad', 0, '2022-09-12 15:48:34', '0000-00-00 00:00:00'),
(22, 13, 'Patna', 0, '2022-09-12 15:49:07', '0000-00-00 00:00:00'),
(23, 13, 'Gaya', 0, '2022-09-12 15:49:44', '0000-00-00 00:00:00'),
(24, 34, 'Allahabad', 0, '2022-09-12 15:50:48', '0000-00-00 00:00:00'),
(25, 34, 'Agra', 0, '2022-09-12 15:51:02', '0000-00-00 00:00:00'),
(26, 34, 'Kanpur', 0, '2022-09-12 15:51:14', '0000-00-00 00:00:00'),
(27, 34, 'Varanasi', 0, '2022-09-12 15:51:35', '0000-00-00 00:00:00'),
(28, 34, 'Noida', 0, '2022-09-12 15:52:52', '0000-00-00 00:00:00'),
(29, 7, 'Delhi All', 0, '2022-09-12 15:53:38', '0000-00-00 00:00:00'),
(30, 7, 'NCR', 0, '2022-09-12 15:53:52', '0000-00-00 00:00:00'),
(31, 29, 'Jaipur', 0, '2022-09-12 15:54:27', '0000-00-00 00:00:00'),
(32, 29, 'Udaipur', 0, '2022-09-12 15:54:50', '0000-00-00 00:00:00'),
(33, 9, 'Darjeeling', 0, '2022-09-12 15:55:42', '0000-00-00 00:00:00'),
(34, 9, 'Siliguri', 0, '2022-09-12 15:55:57', '0000-00-00 00:00:00'),
(35, 9, 'New Jalpaiguri', 0, '2022-09-12 15:56:23', '0000-00-00 00:00:00'),
(36, 9, 'Berhampore', 0, '2022-09-12 15:57:53', '0000-00-00 00:00:00'),
(37, 9, 'Krishnanagar', 0, '2022-09-12 15:58:29', '0000-00-00 00:00:00'),
(38, 9, 'Katwa', 0, '2022-09-12 15:58:42', '0000-00-00 00:00:00'),
(39, 9, 'Burdwan (Bardhaman)', 0, '2022-09-12 15:59:44', '0000-00-00 00:00:00'),
(40, 9, 'Kalna', 0, '2022-09-12 16:00:04', '0000-00-00 00:00:00'),
(41, 14, 'Raipur', 0, '2022-09-12 16:01:27', '0000-00-00 00:00:00'),
(42, 15, 'Panjim', 0, '2022-09-12 16:02:33', '0000-00-00 00:00:00'),
(43, 15, 'Madgaon', 0, '2022-09-12 16:03:01', '0000-00-00 00:00:00'),
(44, 12, 'Guwahati', 0, '2022-09-12 16:03:44', '0000-00-00 00:00:00'),
(45, 24, 'Shillong', 0, '2022-09-12 16:04:07', '0000-00-00 00:00:00'),
(46, 2, 'Madurai', 0, '2022-09-12 16:05:28', '0000-00-00 00:00:00'),
(47, 2, 'Coimbatore', 0, '2022-09-12 16:06:11', '0000-00-00 00:00:00'),
(48, 19, 'Ranchi', 0, '2022-09-12 16:07:02', '0000-00-00 00:00:00'),
(49, 9, 'Howrah', 0, '2022-09-12 16:08:14', '0000-00-00 00:00:00'),
(50, 9, 'Chandannagar', 0, '2022-09-12 16:08:49', '0000-00-00 00:00:00'),
(51, 16, 'Ahmedabad', 0, '2022-09-12 16:10:03', '0000-00-00 00:00:00'),
(52, 16, 'Surat', 0, '2022-09-12 16:10:37', '0000-00-00 00:00:00'),
(53, 16, 'Vadodara', 0, '2022-09-12 16:10:55', '0000-00-00 00:00:00'),
(54, 16, 'Rajkot', 0, '2022-09-12 16:11:20', '0000-00-00 00:00:00'),
(55, 34, 'Lucknow', 0, '2022-09-12 16:11:47', '0000-00-00 00:00:00'),
(56, 20, 'Thiruvananthapuram', 0, '2022-09-12 16:12:52', '0000-00-00 00:00:00'),
(57, 20, 'Kochi', 0, '2022-09-12 16:13:16', '0000-00-00 00:00:00'),
(58, 20, 'Kannur', 0, '2022-09-12 16:13:43', '0000-00-00 00:00:00'),
(59, 17, 'Faridabad', 0, '2022-09-12 16:14:54', '0000-00-00 00:00:00'),
(60, 17, 'Gurugram', 0, '2022-09-12 16:15:23', '0000-00-00 00:00:00'),
(61, 17, 'Panipat', 0, '2022-09-12 16:15:45', '0000-00-00 00:00:00'),
(62, 17, 'Ambala', 0, '2022-09-12 16:16:13', '0000-00-00 00:00:00'),
(63, 28, 'Ludhiana', 0, '2022-09-12 16:17:48', '0000-00-00 00:00:00'),
(64, 28, 'Amritsar', 0, '2022-09-12 16:18:07', '0000-00-00 00:00:00'),
(65, 28, 'Jalandhar', 0, '2022-09-12 16:18:28', '0000-00-00 00:00:00'),
(66, 28, 'Patiala', 0, '2022-09-12 16:18:49', '0000-00-00 00:00:00'),
(67, 28, 'Mohali', 0, '2022-09-12 16:19:18', '0000-00-00 00:00:00'),
(68, 28, 'Pathankot', 0, '2022-09-12 16:19:52', '0000-00-00 00:00:00'),
(69, 9, 'Salt Lake City', 0, '2022-09-12 16:20:15', '0000-00-00 00:00:00'),
(70, 23, 'Imphal', 0, '2022-09-12 16:21:20', '0000-00-00 00:00:00'),
(71, 30, 'Gantok', 0, '2022-09-12 16:21:49', '0000-00-00 00:00:00'),
(72, 35, 'Haridwar', 0, '2022-09-12 16:24:09', '0000-00-00 00:00:00'),
(80, 1, 'Karnataka', 0, '2022-10-27 10:28:55', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `cname` varchar(90) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groupmsg`
--

CREATE TABLE `groupmsg` (
  `gid` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `comment` varchar(450) NOT NULL,
  `reply_to` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groupmsg`
--

INSERT INTO `groupmsg` (`gid`, `sender_id`, `group_id`, `comment`, `reply_to`, `created_at`) VALUES
(1, 1, 1, 'How are you', '', '2023-01-31 10:46:07'),
(2, 2, 1, 'Good', 'How are you', '2023-01-31 10:46:32'),
(3, 3, 1, 'Well', 'Good', '2023-01-31 10:48:34'),
(4, 2, 2, 'test comment', '', '2023-01-31 10:49:36'),
(5, 2, 2, 'test reply', 'test comment', '2023-01-31 10:49:44'),
(6, 3, 2, 'test comment reply 2', 'test comment', '2023-01-31 10:55:28'),
(7, 2, 2, 'test reply to reply', 'test comment reply 2', '2023-01-31 10:57:32'),
(8, 1, 1, 'hi', '', '2023-02-01 11:04:57'),
(9, 1, 1, 'syed share logo to uday', '', '2023-02-01 11:23:07'),
(10, 1, 1, 'ok sir i will share', '', '2023-02-01 11:23:26'),
(11, 2, 2, 'test comment', '', '2023-02-25 14:09:13'),
(12, 2, 2, 'test replyy', 'test comment', '2023-02-25 14:10:25'),
(13, 2, 2, 'Hello there testing', '', '2023-03-16 11:13:20'),
(14, 2, 2, 'testing reply', 'Hello there testing', '2023-03-16 11:14:35'),
(15, 2, 2, 'hiii', '', '2023-03-23 14:34:12'),
(16, 2, 2, 'ok', 'testing reply', '2023-03-23 14:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `groupmsglist`
--

CREATE TABLE `groupmsglist` (
  `id` int(11) NOT NULL,
  `gmsgid` int(11) NOT NULL,
  `comment` varchar(450) NOT NULL,
  `uid` int(11) NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_title` varchar(150) NOT NULL,
  `group_pic` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `user_id`, `group_title`, `group_pic`, `created_at`) VALUES
(1, 1, 'Savithru', 'assets/groupimg/MID56853.jpg', '2023-01-20 11:55:59'),
(2, 2, 'Savithru', 'assets/groupimg/MID56853.jpg', '2023-01-20 11:55:59'),
(3, 2, 'Test App Group', 'assets/groupimg/MID40247.jpg', '2023-02-27 11:25:37');

-- --------------------------------------------------------

--
-- Table structure for table `group_category`
--

CREATE TABLE `group_category` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_category`
--

INSERT INTO `group_category` (`id`, `group_id`, `cat_id`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 2, 1),
(4, 2, 2),
(5, 3, 1),
(6, 3, 2),
(7, 3, 3),
(8, 3, 4),
(9, 3, 5),
(10, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `group_list`
--

CREATE TABLE `group_list` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_list`
--

INSERT INTO `group_list` (`id`, `group_id`, `people_id`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 2, 3),
(4, 2, 2),
(5, 1, 3),
(6, 3, 1),
(7, 3, 2),
(8, 3, 3),
(9, 3, 4),
(10, 1, 2),
(11, 1, 3),
(12, 3, 1),
(13, 3, 3),
(14, 3, 3),
(15, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `interest_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`id`, `user_id`, `interest_id`, `created_at`) VALUES
(1, 1, 1, '2023-01-19 14:22:59'),
(2, 1, 2, '2023-01-19 14:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `login_report`
--

CREATE TABLE `login_report` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `last_login` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_report`
--

INSERT INTO `login_report` (`id`, `login_id`, `last_login`) VALUES
(1, 1, 20230120155451),
(2, 1, 1674210850),
(3, 2, 1674211668),
(4, 1, 1674212476),
(5, 3, 1674212514),
(6, 2, 1674212566),
(7, 2, 1674454941),
(8, 2, 1674468657),
(9, 2, 1674538529),
(10, 2, 1674889494),
(11, 1, 1675227187),
(12, 1, 1675227229),
(13, 1, 1675227772),
(14, 1, 1675227884),
(15, 1, 1675227997),
(16, 1, 1675229140),
(17, 1, 1675229190),
(18, 2, 1675229371),
(19, 1, 1675230562),
(20, 2, 1675230865),
(21, 2, 1675231263),
(22, 2, 1675231630),
(23, 2, 1675419930),
(24, 4, 1675426516),
(25, 2, 1676268301),
(26, 2, 1676352380),
(27, 2, 1677821772),
(28, 5, 1677822661),
(29, 5, 1677822741),
(30, 2, 1678352401),
(31, 2, 1678535654),
(32, 2, 1678536435),
(33, 2, 1678536966),
(34, 2, 1678536968),
(35, 6, 1679561915),
(36, 2, 1679561923),
(37, 2, 1679562195);

-- --------------------------------------------------------

--
-- Table structure for table `pincodes`
--

CREATE TABLE `pincodes` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pincode` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pincodes`
--

INSERT INTO `pincodes` (`id`, `cid`, `pincode`, `status`, `created_at`, `modified_at`) VALUES
(1, 1, '560064', 0, '2022-11-16 14:15:03', 2022),
(2, 1, '560013', 0, '2022-11-23 17:29:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `police`
--

CREATE TABLE `police` (
  `po_id` int(11) NOT NULL,
  `station_name` varchar(150) NOT NULL,
  `incharge_officer` varchar(120) NOT NULL,
  `phoneno` varchar(12) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `police`
--

INSERT INTO `police` (`po_id`, `station_name`, `incharge_officer`, `phoneno`, `status`, `created_at`, `modified_at`) VALUES
(2, 'Karnataka', 'Nanjunda', '9986571768', 0, '2023-01-11 15:25:16', '2023-01-11 15:37:09');

-- --------------------------------------------------------

--
-- Table structure for table `postcomment`
--

CREATE TABLE `postcomment` (
  `comment_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reciever_id` int(11) NOT NULL,
  `comment` varchar(450) NOT NULL,
  `reply_to` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postcomment`
--

INSERT INTO `postcomment` (`comment_id`, `sender_id`, `reciever_id`, `comment`, `reply_to`, `created_at`, `modified_at`) VALUES
(1, 1, 2, 'How are you', 'Good', '2023-01-30 11:10:04', ''),
(2, 1, 2, 'Good', 'Well', '2023-01-30 11:10:28', ''),
(3, 1, 2, 'Well', 'Good', '2023-01-30 11:18:25', ''),
(4, 2, 1, 'new comment', 'reply to new comment', '2023-01-30 11:19:37', ''),
(5, 2, 1, 'reply to new comment', 'new comment', '2023-01-30 11:19:58', ''),
(6, 2, 1, 'new comment 2', '', '2023-01-30 11:22:22', ''),
(7, 2, 1, 'reply to new comment 2', 'new comment 2', '2023-01-30 11:22:35', ''),
(10, 2, 3, 'Test comment', '', '2023-01-31 15:46:01', ''),
(11, 1, 1, 'how are you', '', '2023-02-01 10:57:59', ''),
(12, 2, 1, 'test comment', '', '2023-02-01 11:00:28', ''),
(13, 1, 2, 'new comment 10', '', '2023-02-01 11:01:49', ''),
(14, 2, 1, 'i am fine', 'how are you', '2023-02-01 11:03:07', ''),
(15, 1, 1, 'need help', '', '2023-02-01 11:21:10', ''),
(16, 1, 1, 'go ahead', '', '2023-02-01 11:21:30', ''),
(17, 2, 2, 'test comment', '', '2023-02-27 16:11:39', ''),
(18, 5, 1, 'hi', 'go ahead', '2023-03-03 11:23:06', ''),
(19, 5, 2, 'hi', '', '2023-03-03 11:23:27', ''),
(20, 5, 2, 'hi', 'hi', '2023-03-03 11:23:32', ''),
(21, 5, 1, 'hu', '', '2023-03-07 12:48:42', ''),
(22, 5, 1, 'hello', '', '2023-03-07 15:21:41', '');

-- --------------------------------------------------------

--
-- Table structure for table `psychiatrist`
--

CREATE TABLE `psychiatrist` (
  `p_id` int(11) NOT NULL,
  `dname` varchar(120) NOT NULL,
  `fstudy` varchar(120) NOT NULL,
  `experience` varchar(120) NOT NULL,
  `city_id` int(11) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` text NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `psychiatrist`
--

INSERT INTO `psychiatrist` (`p_id`, `dname`, `fstudy`, `experience`, `city_id`, `phone`, `address`, `profile_pic`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Syed', 'Cycology', '16 years', 2, '9986571768', '', '', 0, '2023-01-12 11:24:10', '2023-01-12 11:27:19');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - Active, -1 - Deactive',
  `created_at` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `status`, `created_at`, `modified_date`) VALUES
(1, 'Karnataka', 0, '2022-07-22 05:50:49', '2022-07-26 22:10:53'),
(2, 'Tamil Nadu', 0, '2022-07-22 05:50:49', '2022-07-26 22:10:50'),
(7, 'Delhi', 0, '2022-08-16 09:50:58', '0000-00-00 00:00:00'),
(9, 'West Bengal', 0, '2022-08-16 09:54:12', '2022-08-17 15:58:47'),
(10, 'Andhra Pradesh', 0, '2022-08-17 16:12:24', '0000-00-00 00:00:00'),
(11, 'Arunachal Pradesh', 0, '2022-08-17 16:12:43', '0000-00-00 00:00:00'),
(12, 'Assam', 0, '2022-08-17 16:12:58', '0000-00-00 00:00:00'),
(13, 'Bihar', 0, '2022-08-17 16:13:13', '0000-00-00 00:00:00'),
(14, 'Chhattisgarh', 0, '2022-08-17 16:13:25', '0000-00-00 00:00:00'),
(15, 'Goa', 0, '2022-08-17 16:14:11', '0000-00-00 00:00:00'),
(16, 'Gujarat', 0, '2022-08-17 16:14:30', '0000-00-00 00:00:00'),
(17, 'Haryana', 0, '2022-08-17 16:14:43', '0000-00-00 00:00:00'),
(18, 'Himachal Pradesh', 0, '2022-08-17 16:15:03', '0000-00-00 00:00:00'),
(19, 'Jharkhand', 0, '2022-08-17 16:15:17', '0000-00-00 00:00:00'),
(20, 'Kerala', 0, '2022-08-17 16:15:29', '0000-00-00 00:00:00'),
(21, 'Madhya Pradesh', 0, '2022-08-17 16:15:39', '0000-00-00 00:00:00'),
(22, 'Maharashtra', 0, '2022-08-17 16:15:51', '2022-09-12 15:44:36'),
(23, 'Manipur', 0, '2022-08-17 16:16:08', '0000-00-00 00:00:00'),
(24, 'Meghalaya', 0, '2022-08-17 16:16:21', '0000-00-00 00:00:00'),
(25, 'Mizoram', 0, '2022-08-17 16:16:32', '0000-00-00 00:00:00'),
(26, 'Nagaland', 0, '2022-08-17 16:16:42', '0000-00-00 00:00:00'),
(27, 'Odisha', 0, '2022-08-17 16:16:50', '0000-00-00 00:00:00'),
(28, 'Punjab', 0, '2022-08-17 16:17:02', '0000-00-00 00:00:00'),
(29, 'Rajasthan', 0, '2022-08-17 16:17:17', '0000-00-00 00:00:00'),
(30, 'Sikkim', 0, '2022-08-17 16:17:30', '0000-00-00 00:00:00'),
(32, 'Telangana', 0, '2022-08-17 16:17:49', '0000-00-00 00:00:00'),
(33, 'Tripura', 0, '2022-08-17 16:18:00', '0000-00-00 00:00:00'),
(34, 'Uttar Pradesh', 0, '2022-08-17 16:18:18', '0000-00-00 00:00:00'),
(35, 'Uttarakhand', 0, '2022-08-17 16:18:32', '0000-00-00 00:00:00'),
(36, 'Puducherry', 0, '2022-08-17 16:19:29', '0000-00-00 00:00:00'),
(37, 'Andaman and Nicobar Islands', 0, '2022-08-17 16:19:45', '0000-00-00 00:00:00'),
(38, 'Chandigarh', 0, '2022-08-17 16:20:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sname` varchar(200) NOT NULL,
  `sub_img` varchar(200) NOT NULL,
  `page_url` varchar(180) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 - Active, -1 - Deactive	',
  `created_at` datetime NOT NULL,
  `modified_at` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `cat_id`, `sname`, `sub_img`, `page_url`, `status`, `created_at`, `modified_at`) VALUES
(1, 13, 'Footwear', '', 'men-footwear', 0, '2022-11-04 10:36:51', '2022-11-04 12:21:36'),
(2, 13, 'Clothing', '', 'men-clothing', 0, '2022-11-04 10:36:51', '2022-11-04 12:20:37'),
(3, 11, 'Men', '', 'men-cosmetics', 0, '2022-11-04 05:17:34', '2022-11-04 11:08:41'),
(4, 11, 'Woman', '', 'woman-cosmetics', 0, '2022-11-04 05:17:34', ''),
(6, 6, 'Men', '', 'personal-tools-men', 0, '2022-11-04 05:28:09', ''),
(7, 6, 'Woman', '', 'personal-tools-woman', 0, '2022-11-04 05:28:09', ''),
(8, 7, 'Men', '', 'fragrance-men', 0, '2022-11-04 05:28:09', ''),
(9, 7, 'Woman', '', 'fragrance-woman', 0, '2022-11-04 05:28:09', ''),
(10, 8, 'Men', '', 'skin-care-men', 0, '2022-11-04 05:28:09', ''),
(11, 8, 'Woman', '', 'skin-care-woman', 0, '2022-11-04 05:28:09', ''),
(12, 9, 'Men', '', 'health-and-wellness-men', 0, '2022-11-04 05:28:09', ''),
(13, 9, 'Woman', '', 'health-and-wellness-woman', 0, '2022-11-04 05:28:09', '2022-11-04 11:17:06'),
(16, 10, 'Men', '', 'gadgets-men', 0, '2022-11-04 06:20:31', ''),
(17, 10, 'Woman', '', 'gadgets-woman', 0, '2022-11-04 06:20:31', ''),
(18, 1, 'Men', '', 'home-decor-men', 0, '2022-11-04 06:20:31', ''),
(19, 1, 'Woman', '', 'home-decor-woman', 0, '2022-11-04 06:20:31', ''),
(20, 2, 'Music Categories\n', '', 'music-and-books-music-categories', 0, '2022-11-04 06:20:31', ''),
(21, 2, 'Vinyle Records\n', '', 'music-and-books-vinyle-records\n', 0, '2022-11-04 06:20:31', ''),
(22, 3, 'Mother\n', '', 'mom-and-kids-mother', 0, '2022-11-04 06:20:31', ''),
(23, 3, 'Infants\n', '', 'music-and-books-infants', 0, '2022-11-04 06:20:31', ''),
(24, 4, 'Exclusive', '', 'exclusive', 0, '2022-11-04 06:20:31', ''),
(25, 5, 'Men', '', 'gift-set-men', 0, '2022-11-04 06:20:31', ''),
(26, 13, 'Accessories', '', 'men-accessories', 0, '2022-11-04 12:01:30', '2022-11-05 12:26:33'),
(27, 14, 'Clothing', '', 'woman-clothing', 0, '2022-11-04 06:52:55', ''),
(28, 14, 'Footwear', '', 'woman-footwear', 0, '2022-11-04 06:52:55', ''),
(29, 2, 'CDS', '', 'music-and-books-cds', 0, '2022-11-04 07:09:40', ''),
(30, 2, 'English', '', 'music-and-books-english', 0, '2022-11-04 07:09:40', ''),
(31, 2, 'Hindi', '', 'music-and-books-hindi', 0, '2022-11-04 07:09:40', ''),
(32, 5, 'Woman', '', 'gift-set-woman', 0, '2022-11-04 07:11:45', ''),
(33, 5, 'Boys', '', 'gift-set-boys', 0, '2022-11-04 07:11:45', ''),
(34, 5, 'Girls', '', 'gift-set-girls', 0, '2022-11-04 07:11:45', ''),
(35, 15, 'Men', '', 'hair-care-men', 0, '2022-11-04 07:14:57', ''),
(36, 15, 'Woman', '', 'hair-care-woman', 0, '2022-11-04 07:14:57', ''),
(37, 16, 'Men', '', 'personal-care-men', 0, '2022-11-04 07:17:03', ''),
(38, 16, 'Woman', '', 'personal-care-woman', 0, '2022-11-04 07:17:03', ''),
(39, 1, 'Bed Linen', '', 'bed-linen', 0, '2022-11-04 12:54:31', ''),
(40, 1, 'Bath', '', 'bath', 0, '2022-11-04 12:54:31', ''),
(41, 1, 'Flooring', '', 'flooring', 0, '2022-11-04 12:54:31', ''),
(42, 1, 'Lamps & Lighting', '', 'lamps-lighting', 0, '2022-11-04 12:54:31', ''),
(43, 1, 'Interior Décor', '', 'interior-décor', 0, '2022-11-04 12:54:31', ''),
(44, 1, 'Cushion & Covers', '', 'cushion-covers', 0, '2022-11-04 12:54:31', '');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `uid`, `token`, `cname`, `created_at`) VALUES
(1, 1, '00625d49efea7d940529324ad7ee265c632IABGCzfjG/sU41gdydY6maj4Hg948PmR0G+nFPiJDb5dDFk+DS6379yDIgDsRQAAU1PeYwQAAQBTU95jAwBTU95jAgBTU95jBABTU95j', 'ChatVtalks', '2023-01-23 17:41:07'),
(2, 2, '00625d49efea7d940529324ad7ee265c632IABdR7wlf6E/l5pQObGOKzbCGQYtWsDYGWiRUZmPVBBFBlk+DS4NvtUaIgAYLQAAdGgdZAQAAQB0aB1kAwB0aB1kAgB0aB1kBAB0aB1k', 'ChatVtalks', '2023-02-02 18:06:24'),
(3, 4, '00625d49efea7d940529324ad7ee265c632IACBTUdKF7yAC30fJ0YsFxEaJ4RUAzyw+0pm0y7/kRiqc1k+DS44G7bzIgDrggAA61PeYwQAAQDrU95jAwDrU95jAgDrU95jBADrU95j', 'ChatVtalks', '2023-02-03 17:45:44'),
(4, 5, '00625d49efea7d940529324ad7ee265c632IABcy+mQHIIm7AkWuYZBfIuUTy3bFsctDEWs2smgYNdBBFk+DS6uK7GEIgD6ygAAsU0IZAQAAQCxTQhkAwCxTQhkAgCxTQhkBACxTQhk', 'ChatVtalks', '2023-03-03 11:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `emailid` varchar(190) NOT NULL,
  `profileimg` varchar(255) NOT NULL,
  `mno` varchar(12) NOT NULL,
  `otp` int(11) NOT NULL,
  `fcm_id` varchar(255) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - Active , -1 - Deactive',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `name`, `uname`, `emailid`, `profileimg`, `mno`, `otp`, `fcm_id`, `device_id`, `status`, `created_at`) VALUES
(1, '', 'magical', 'ran@savithru.com', '', '9986571768', 6339, '2222', '', 0, '2023-01-19 14:20:36'),
(2, '', 'Test User', 'uday@savithru.com', 'assets/groupimg/MID13292.jpg', '8904458227', 6072, 'cqssXvTyQnqmlFlgEqpv3P:APA91bEWYVyPsUPyVTOAZOMB9-jAk6pV7LFGsv3uBMAm8nZW5UX8sGijsjI-xCEetZEUw-fGbMa7DSMCnAJfWivb3OntYwNBRKAPALVBOgLfdi0uRGm7CXR1ZX-YUbpZkDcG6G5E1NdE', '', 0, '2023-01-20 16:17:38'),
(3, '', 'New', '', '', '890445822', 2829, 'cqssXvTyQnqmlFlgEqpv3P:APA91bEWYVyPsUPyVTOAZOMB9-jAk6pV7LFGsv3uBMAm8nZW5UX8sGijsjI-xCEetZEUw-fGbMa7DSMCnAJfWivb3OntYwNBRKAPALVBOgLfdi0uRGm7CXR1ZX-YUbpZkDcG6G5E1NdE', '', 0, '2023-01-20 16:31:44'),
(4, '', 'pa1', 'pavan@savithru.com', '', '8147979973', 6340, 'fRt4MbUbSISz0MIP_uBgq6:APA91bEC-6SK_HzOiV-DYM9dxxXsb-W8mVTK2xV8SbShYGqK-SmzJjZQvrv_uk6gB7VDyGWKadyKqdc9fOoE0l7xLEiBdS8BBFtHzzoHEdsCBdnmmt-9HocwoabRBTUPlCumEtAy2SgD', '', 0, '2023-02-03 17:45:06'),
(5, '', 'suresh', 'suresh@abhinavinfo.com', '', '9845324064', 2221, 'cYU5QwoyQK6o0I6opYvfpz:APA91bE4pitkGyGh-DzmVWxzPEEFUa13ZVE24ENf3w8Krv99Q9sWJ4Lrs2oNjKYrPobU-L4varLVMf7S8_qYaI5x3-qtIDr43_N4Qy5mhT9cBbbsoumj9aIO4u0s7EdHt5YMEeOgED1k', '', 0, '2023-03-03 11:20:51'),
(6, '', 'kavya', 'www.harirockzz99@gmail.com', '', '9686682671', 9629, 'el1KJjaOSDyM-2SLZkUmYk:APA91bGv1zUgjS43F68oVh8gftlUZi27BtEYWtfuQ7XW3cD-IuAD1fKMaW-XhQfmp3n7V3_XJdMSgycVk7k47e_FYV1tSsyJR38nDwrMw599GMhUB7xu7rn0YykF6fh15rNshF2_AJ4q', '', 0, '2023-03-23 14:28:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cid` (`cid`);

--
-- Indexes for table `arttype`
--
ALTER TABLE `arttype`
  ADD PRIMARY KEY (`art_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cname` (`cname`);

--
-- Indexes for table `celebrities`
--
ALTER TABLE `celebrities`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sid` (`sid`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groupmsg`
--
ALTER TABLE `groupmsg`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `groupmsglist`
--
ALTER TABLE `groupmsglist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `group_category`
--
ALTER TABLE `group_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_list`
--
ALTER TABLE `group_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_report`
--
ALTER TABLE `login_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pincodes`
--
ALTER TABLE `pincodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pincdoe` (`cid`);

--
-- Indexes for table `police`
--
ALTER TABLE `police`
  ADD PRIMARY KEY (`po_id`);

--
-- Indexes for table `postcomment`
--
ALTER TABLE `postcomment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `psychiatrist`
--
ALTER TABLE `psychiatrist`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `sname` (`sname`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `arttype`
--
ALTER TABLE `arttype`
  MODIFY `art_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `celebrities`
--
ALTER TABLE `celebrities`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupmsg`
--
ALTER TABLE `groupmsg`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `groupmsglist`
--
ALTER TABLE `groupmsglist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group_category`
--
ALTER TABLE `group_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `group_list`
--
ALTER TABLE `group_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_report`
--
ALTER TABLE `login_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `pincodes`
--
ALTER TABLE `pincodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `police`
--
ALTER TABLE `police`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `postcomment`
--
ALTER TABLE `postcomment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `psychiatrist`
--
ALTER TABLE `psychiatrist`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `cities` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `fk_sid` FOREIGN KEY (`sid`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pincodes`
--
ALTER TABLE `pincodes`
  ADD CONSTRAINT `fk_pincdoe` FOREIGN KEY (`cid`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pincodes_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `cities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
