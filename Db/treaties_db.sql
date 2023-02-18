-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 18, 2023 at 08:27 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `treaties_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `il_notifications`
--

CREATE TABLE `il_notifications` (
  `id` int(20) NOT NULL,
  `content` longtext NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `il_passwordresets`
--

CREATE TABLE `il_passwordresets` (
  `pr_id` int(20) NOT NULL,
  `pr_useremail` varchar(200) NOT NULL,
  `pr_usertype` varchar(200) NOT NULL,
  `pr_dummypwd` varchar(200) NOT NULL,
  `pr_token` varchar(200) NOT NULL,
  `pr_status` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `il_sudo`
--

CREATE TABLE `il_sudo` (
  `id` int(20) NOT NULL,
  `username` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `bio` longtext NOT NULL,
  `phone` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `il_sudo`
--

INSERT INTO `il_sudo` (`id`, `username`, `number`, `email`, `password`, `profile_pic`, `bio`, `phone`, `created_at`) VALUES
(1, 'FMOJ_Admin', 'FMOJ-001', 'admin@FMOJ.org', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '', 'The National Depository of Treaties under the Federal Ministry of Justice in Nigeria is responsible for the safekeeping and management of international agreements, conventions, and treaties entered into by the Nigerian government with other countries and international organizations. ', '+23490000000000', '2020-06-11 09:00:08.999494');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `id` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `bio` longtext NOT NULL,
  `phone` varchar(200) NOT NULL,
  `adr` varchar(200) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `acc_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`id`, `name`, `number`, `email`, `pwd`, `bio`, `phone`, `adr`, `pic`, `acc_status`, `created_at`) VALUES
(1, 'Ajala Morenikeji', 'FMOJ-002', 'staff001@FMOJ.org', 'fd71a7e85b8d962e34fba7dbac1aec8ce64f3e87', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', '+254740847563', '127001 Localhost', '', 'Active', '2023-02-18 06:54:38.167002'),
(2, 'Jacobs Charles', 'FMOJ-003', 'staff002@FMOJ.org', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '+254740847908', '127001 Localhost', '', 'Suspended', '2023-02-16 07:38:08.740921'),
(3, 'Debra Espinoza', 'FMOJ-136', 'judylydubo@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', 'Beatae repellendus ', '+1 (424) 327-6698', 'Vel iusto esse nulla', '', 'Active', '2023-02-17 09:09:49.263153');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`id`, `name`, `description`) VALUES
(1, 'Published', 'Instruments Signed by the President/Head of state of the Federal Republic of Nigeria'),
(2, 'Running', 'Instruments Signed by the President/Head of state of the Federal Republic of Nigeria'),
(3, 'Revised', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis, similique nulla. Possimus eligendi, deserunt hic adipisci amet magni unde pariatur soluta! Culpa delectus amet eaque inventore tenetur optio minima repellendus.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_treaties`
--

CREATE TABLE `tbl_treaties` (
  `id` int(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `signatory` varchar(200) NOT NULL,
  `b_publisher` varchar(200) NOT NULL,
  `b_file` varchar(255) NOT NULL,
  `tc_id` varchar(200) NOT NULL,
  `tc_name` varchar(200) NOT NULL,
  `s_id` int(20) NOT NULL,
  `s_status` varchar(50) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `b_summary` longtext NOT NULL,
  `treaty_year` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_treaties`
--

INSERT INTO `tbl_treaties` (`id`, `title`, `signatory`, `b_publisher`, `b_file`, `tc_id`, `tc_name`, `s_id`, `s_status`, `created_at`, `b_summary`, `treaty_year`) VALUES
(1, 'Practical Web 2.0 Applications With PHP (Edited)', 'Quentin Zervaas', 'FMOJ_Admin', 'Preview-1.pdf', '1', 'Instruments', 1, 'Published', '2023-02-17 09:12:36.295940', 'Many of today\'s web development books and articles cover single aspects of the development life cycle, delving only into specific features rather than looking at the whole picture. In this book, we will develop a complete web application. Although we will be using various third-party libraries and tools to aid in development, we will be developing the application from start to finish. The focus of this book is on Web 2. 0, a catchphrase that has been in use for a few years now and is typically used to refer to web sites or web applications that have particular char- teristics. Some of these characteristics include the following:  Correctly using HTML/XHTML, CSS, and other standards Using Ajax (Asynchronous JavaScript and XML) to provide a responsive application without requiring a full refresh of pages  Allowing syndication of web site content using RSS Adding wikis, blogs, or tags Although not everybody is an advocate of the Web 2. 0 phrase, the term does signify forward progress in web development. And although not everybody has the need to provide a wiki or a blog on their web site, the other characteristics listed (such as correct standards usage) provide a good basis for a web site and should be used by all developers, regardless of how they want their web site or application categorized. I wrote this book because I want to share with other users how I build web sites.', '1980'),
(2, 'Adobe Dreamweaver CS4 Complete (Edited)', 'Shelly Wells', 'FMOJ_Admin', 'Preview-2.pdf', '1', 'Instruments', 1, 'Published', '2023-02-17 09:12:36.295940', 'Adobe Dreamweaver CS4: Complete Concepts and Techniques gives students a complete introduction to Web design and Development using the Adobe Dreamweaver CS4 software.Visually-dynamic chapters and ongoing central project allow students to gain the skills necessary to build exciting, professional looking websites and more! Real-World, hands on training successful prepares students to use Dreamweaver CS4 in their professional and personal lives.', '1990'),
(3, 'Unix Fundermentals', 'Harley Hann', 'Ajala Morenikeji', 'Preview-3.jpeg', '1', 'Instruments', 2, 'Running', '2023-02-17 09:12:36.295940', 'This book will show you how to Use Unix operating system effectively.You will learn: What is UNIX, and why is so important, useful and satisfying. How UNIX world is connected, How to start using Unix and which UNIX programs and features you can use immediately.', '2000'),
(4, 'The Immortal Life of Henrietta Lacks', 'Rebecca Skloot', 'Jacobs Charles', 'Preview-4.jpg', '2', 'Agreements', 2, 'Running', '2023-02-17 09:12:45.265457', 'The book is about Henrietta Lacks and the immortal cell line, known as HeLa, that came from Lacks\'s cervical cancer cells in 1951. Skloot became interested in Lacks after a biology teacher referenced her, but didn\'t know much about her. Skloot began conducting extensive research on her and worked with Lacks\' family to create the book. The book is notable for its science writing and dealing with ethical issues of race and class in medical research. Skloot said that some of the information was taken from the journal of Deborah Lacks, Henrietta Lacks\'s daughter, as well as from \"archival photos and documents, scientific and historical research.\" It is Skloot\'s first book.', '1991'),
(5, 'Nineteen Eighty-Four', 'George Orwell', 'Ajala Morenikeji', 'Preview-5.png', '3', 'Memorandum of Understanding', 3, 'Revised', '2023-02-17 06:58:32.473622', 'Nineteen Eighty-Four: A Novel, often published as 1984, is a dystopian novel by English novelist George Orwell. It was published on 8 June 1949 by Secker & Warburg as Orwell\'s ninth and final book completed in his lifetime. The story was mostly written at Barnhill, a farmhouse on the Scottish island of Jura, at times while Orwell suffered from severe tuberculosis. Thematically, Nineteen Eighty-Four centres on the consequences of government over-reach, totalitarianism, mass surveillance, and repressive regimentation of all persons and behaviours within society.\r\n\r\nThe story takes place in an imagined future, the year 1984, when much of the world has fallen victim to perpetual war, omnipresent government surveillance, historical negationism, and propaganda. Great Britain, known as Airstrip One, has become a province of a superstate named Oceania that is ruled by the Party who employ the Thought Police to persecute individuality and independent thinking.[4] Big Brother, the leader of the Party, enjoys an intense cult of personality despite the fact that he may not exist. The protagonist, Winston Smith, is a diligent and skillful rank-and-file worker and Party member who secretly hates the Party and dreams of rebellion. He enters a forbidden relationship with a co-worker, Julia.\r\n\r\nNineteen Eighty-Four has become a classic literary example of political and dystopian fiction. Many terms used in the novel have entered common usage, including Big Brother, doublethink, thoughtcrime, Newspeak, Room 101, telescreen, 2 + 2 = 5, prole, and memory hole. Nineteen Eighty-Four also popularised the adjective \"Orwellian\", connoting things such as official deception, secret surveillance, brazenly misleading terminology, and manipulation of recorded history by a totalitarian or authoritarian state. Time included it on its 100 best English-language novels from 1923 to 2005.[5] It was placed on the Modern Library\'s 100 Best Novels, reaching No. 13 on the editors\' list and No. 6 on the readers\' list.[6] In 2003, the novel was listed at No. 8 on The Big Read survey by the BBC.[7] Parallels have been drawn between the novel\'s subject matter and real life instances of totalitarianism, communism, mass surveillance, and violations of freedom of expression among other themes.', '1992'),
(6, 'Testing Edit', 'Modi facere neque cu', 'Jacobs Charles', 'Preview-5.png', '3', 'Memorandum of Understanding', 1, 'Published', '2023-02-17 06:58:41.832134', 'Voluptas labore magn', '1990');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_treatiescategory`
--

CREATE TABLE `tbl_treatiescategory` (
  `id` int(20) NOT NULL,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_treatiescategory`
--

INSERT INTO `tbl_treatiescategory` (`id`, `code`, `name`, `description`) VALUES
(1, 'FMOJ-INT', 'Instruments', 'Instruments Signed by the President/Head of state of the Federal Republic of Nigeria'),
(2, 'FMOJ-AGR', 'Agreements', 'Agreements signed between the federal republic of Nigeria and other entities'),
(3, 'FMOJ-MOU', 'Memorandum of Understanding', 'Memorandum of Understanding signed between the Federal Republic of Nigeria and other entities');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `il_notifications`
--
ALTER TABLE `il_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `il_passwordresets`
--
ALTER TABLE `il_passwordresets`
  ADD PRIMARY KEY (`pr_id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_treaties`
--
ALTER TABLE `tbl_treaties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_treatiescategory`
--
ALTER TABLE `tbl_treatiescategory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `il_notifications`
--
ALTER TABLE `il_notifications`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `il_passwordresets`
--
ALTER TABLE `il_passwordresets`
  MODIFY `pr_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_treaties`
--
ALTER TABLE `tbl_treaties`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_treatiescategory`
--
ALTER TABLE `tbl_treatiescategory`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
