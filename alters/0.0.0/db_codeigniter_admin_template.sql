-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2018 at 12:26 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_codeigniter_admin_template`
--

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

CREATE TABLE `system_users` (
  `su_id` int(11) NOT NULL,
  `sut_id` int(11) NOT NULL,
  `su_first_name` varchar(100) NOT NULL,
  `su_last_name` varchar(100) NOT NULL,
  `su_mobile` varchar(100) NOT NULL,
  `su_email` varchar(100) NOT NULL,
  `su_password` varchar(255) NOT NULL,
  `su_status` tinyint(1) NOT NULL DEFAULT '1',
  `su_inserted` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_users`
--

INSERT INTO `system_users` (`su_id`, `sut_id`, `su_first_name`, `su_last_name`, `su_mobile`, `su_email`, `su_password`, `su_status`, `su_inserted`) VALUES
(1, 1, 'Rahat Ahmed', 'Shawon', '01717509261', 'shawon.mu@gmail.com', '$1$/A/DHkhe$ndFfxZNnEBDuCMWSU57mD1', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `system_users_type`
--

CREATE TABLE `system_users_type` (
  `sut_id` int(11) NOT NULL,
  `sut_type` varchar(100) NOT NULL,
  `sut_type_key` varchar(255) NOT NULL,
  `sut_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_users_type`
--

INSERT INTO `system_users_type` (`sut_id`, `sut_type`, `sut_type_key`, `sut_description`) VALUES
(1, 'Super Admin', 'super-admin', 'Who have an access to do anything in the CMS');

-- --------------------------------------------------------

--
-- Table structure for table `system_user_login_info`
--

CREATE TABLE `system_user_login_info` (
  `suli_id` int(11) NOT NULL,
  `su_id` int(11) NOT NULL,
  `suli_ip_address` varchar(255) NOT NULL,
  `suli_login_time` varchar(50) NOT NULL,
  `suli_logout_time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_user_login_info`
--

INSERT INTO `system_user_login_info` (`suli_id`, `su_id`, `suli_ip_address`, `suli_login_time`, `suli_logout_time`) VALUES
(1, 1, '::1', '1533444627', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `system_users`
--
ALTER TABLE `system_users`
  ADD PRIMARY KEY (`su_id`);

--
-- Indexes for table `system_users_type`
--
ALTER TABLE `system_users_type`
  ADD PRIMARY KEY (`sut_id`);

--
-- Indexes for table `system_user_login_info`
--
ALTER TABLE `system_user_login_info`
  ADD PRIMARY KEY (`suli_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `system_users`
--
ALTER TABLE `system_users`
  MODIFY `su_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_users_type`
--
ALTER TABLE `system_users_type`
  MODIFY `sut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_user_login_info`
--
ALTER TABLE `system_user_login_info`
  MODIFY `suli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
