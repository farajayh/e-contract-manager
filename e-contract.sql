-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2020 at 12:38 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-contract`
--

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `contract_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `contractor` varchar(255) NOT NULL,
  `contractor_email` varchar(255) NOT NULL,
  `contractor_phone_number` varchar(20) NOT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  `user_id` varchar(255) NOT NULL,
  `last_modified_by` varchar(255) NOT NULL,
  `mail_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `contract_id`, `title`, `details`, `date_created`, `start_date`, `end_date`, `contractor`, `contractor_email`, `contractor_phone_number`, `last_modified`, `user_id`, `last_modified_by`, `mail_status`) VALUES
(10, '0z4ddnwdj', 'new contractor', 'contract details', '2018-04-08 03:04:35', '2018-05-01', '2021-03-02', 'name of the contractor', 'email@contractor.com', '123554', '2018-04-08 04:04:35', '12345', 'my surname my firstname', 0),
(11, '11zwh=nzqz', 'contract 2', 'details of the contract', '2018-04-06 12:49:14', '2018-07-02', '2019-02-02', 'contractor name', 'email@coontractor.com', '123456778', NULL, '12345', '', 0),
(12, '121nt1ommq', 'another contract', 'details', '2018-04-06 12:51:15', '2018-05-01', '2019-06-02', 'contractor', 'email@contractor.com', '123456778', NULL, '12345', '', 0),
(13, 'tjq13dxmnj', 'new contract2', 'contract details', '2018-04-06 12:59:23', '2018-09-02', '2019-06-01', 'contractor', 'email@contractor.com', '12435', NULL, '12345', '', 0),
(14, 'jvf14hzmwn', 'jlkjljlk', 'nhlhhlkh', '2018-04-08 01:58:49', '2020-03-02', '2020-07-02', 'nlknk.dn.', 'contractor@gmail.com', '134334', NULL, '12345', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pass_reset`
--

CREATE TABLE `pass_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verification_key` varchar(255) NOT NULL,
  `exp_date` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(15) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `phone_num` int(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `verification_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `first_name`, `middle_name`, `surname`, `department`, `phone_num`, `email`, `password`, `status`, `verification_code`) VALUES
(1, '12345', 'my firstname', 'my middlename', 'my surname', 'option 1', 80234354, 'farajayh@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'active', 'ozfnm0vm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pass_reset`
--
ALTER TABLE `pass_reset`
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
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `pass_reset`
--
ALTER TABLE `pass_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
