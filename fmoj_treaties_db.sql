-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2023 at 08:43 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fmoj_treaties_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `admin_phone` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_pword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_passwordreset`
--

CREATE TABLE `tbl_passwordreset` (
  `pr_id` int(11) NOT NULL DEFAULT current_timestamp(),
  `pr_status` varchar(50) NOT NULL,
  `pr_useremail` varchar(50) NOT NULL,
  `pr_usertype` varchar(50) NOT NULL,
  `pr_dummypword` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pr_token` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `lib_id` int(11) NOT NULL DEFAULT current_timestamp(),
  `lib_fname` varchar(50) NOT NULL,
  `lib_sname` varchar(50) NOT NULL,
  `lib_phone` varchar(50) NOT NULL,
  `lib_email` varchar(50) NOT NULL,
  `lib_dpic` blob NOT NULL,
  `lib_pword` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_treaties`
--

CREATE TABLE `tbl_treaties` (
  `treaties_id` int(11) NOT NULL DEFAULT current_timestamp(),
  `treaties_name` varchar(100) NOT NULL,
  `treaties_authour` varchar(100) NOT NULL,
  `treaties_title` varchar(100) NOT NULL,
  `treaties_date` datetime NOT NULL,
  `treaties_numb` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_treatiescategory`
--

CREATE TABLE `tbl_treatiescategory` (
  `treaties_code` varchar(50) NOT NULL,
  `treaties_desc` longtext NOT NULL,
  `treaties_id` int(11) NOT NULL DEFAULT current_timestamp(),
  `treaties_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `u_id` int(11) NOT NULL DEFAULT current_timestamp(),
  `u_fname` varchar(50) NOT NULL,
  `u_sname` varchar(50) NOT NULL,
  `u_phone` varchar(50) NOT NULL,
  `u_email` varchar(50) NOT NULL,
  `u_pword` varchar(50) NOT NULL,
  `u_sex` varchar(50) NOT NULL,
  `u_pic` blob NOT NULL,
  `u_country` varchar(50) NOT NULL,
  `u_organization` varchar(50) NOT NULL,
  `u_position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_passwordreset`
--
ALTER TABLE `tbl_passwordreset`
  ADD PRIMARY KEY (`pr_id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`lib_id`);

--
-- Indexes for table `tbl_treaties`
--
ALTER TABLE `tbl_treaties`
  ADD PRIMARY KEY (`treaties_id`);

--
-- Indexes for table `tbl_treatiescategory`
--
ALTER TABLE `tbl_treatiescategory`
  ADD PRIMARY KEY (`treaties_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
