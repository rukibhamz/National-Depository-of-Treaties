-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2023 at 10:47 AM
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
-- Table structure for table `tbl_treaties`
--

CREATE TABLE `tbl_treaties` (
  `id` int(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `signatory` varchar(200) NOT NULL,
  `b_isbn_no` varchar(200) NOT NULL,
  `b_publisher` varchar(200) NOT NULL,
  `b_coverimage` varchar(200) NOT NULL,
  `b_file` varchar(255) NOT NULL,
  `tc_id` varchar(200) NOT NULL,
  `tc_name` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `b_summary` longtext NOT NULL,
  `b_copies` varchar(200) NOT NULL,
  `treaty_year` varchar(50) NOT NULL,
  `b_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_treaties`
--

INSERT INTO `tbl_treaties` (`id`, `title`, `signatory`, `b_isbn_no`, `b_publisher`, `b_coverimage`, `b_file`, `tc_id`, `tc_name`, `created_at`, `b_summary`, `b_copies`, `treaty_year`, `b_status`) VALUES
(1, 'Practical Web 2.0 Applications With PHP', 'Quentin Zervaas', '978-1-59059-906-8', 'Apress', '', 'Preview-1.pdf', '1', 'Instruments', '2023-02-16 07:29:46.347703', 'Many of today\'s web development books and articles cover single aspects of the development life cycle, delving only into specific features rather than looking at the whole picture. In this book, we will develop a complete web application. Although we will be using various third-party libraries and tools to aid in development, we will be developing the application from start to finish. The focus of this book is on Web 2. 0, a catchphrase that has been in use for a few years now and is typically used to refer to web sites or web applications that have particular char- teristics. Some of these characteristics include the following:  Correctly using HTML/XHTML, CSS, and other standards Using Ajax (Asynchronous JavaScript and XML) to provide a responsive application without requiring a full refresh of pages  Allowing syndication of web site content using RSS Adding wikis, blogs, or tags Although not everybody is an advocate of the Web 2. 0 phrase, the term does signify forward progress in web development. And although not everybody has the need to provide a wiki or a blog on their web site, the other characteristics listed (such as correct standards usage) provide a good basis for a web site and should be used by all developers, regardless of how they want their web site or application categorized. I wrote this book because I want to share with other users how I build web sites.', '40', '1980', 'Published'),
(2, 'Adobe Dreamweaver CS4 Complete', 'Shelly Wells', 'ISBN-13: 978-0-324-78832-7', 'Cengange Learning', 'IMG_20200413_112931_6.jpg', 'Preview-2.pdf', '1', 'Instruments', '2023-02-16 07:29:44.228344', 'Adobe Dreamweaver CS4: Complete Concepts and Techniques gives students a complete introduction to Web design and Development using the Adobe Dreamweaver CS4 software.Visually-dynamic chapters and ongoing central project allow students to gain the skills necessary to build exciting, professional looking websites and more! Real-World, hands on training successful prepares students to use Dreamweaver CS4 in their professional and personal lives.', '86', '1990', 'Published'),
(3, 'Unix Fundermentals', 'Harley Hann', 'ISBN 0-07-025511-3', 'Mc Graw Hill', 'IMG_20200413_111712_8.jpg', 'Preview-3.jpeg', '1', 'Instruments', '2023-02-16 07:29:40.902044', 'This book will show you how to Use Unix operating system effectively.You will learn: What is UNIX, and why is so important, useful and satisfying. How UNIX world is connected, How to start using Unix and which UNIX programs and features you can use immediately.', '46', '2000', 'Running'),
(4, 'The Immortal Life of Henrietta Lacks', 'Rebecca Skloot', 'ISBN 0-13-681095-1', 'Crown Publishing Group', 'Rebecca Skloot.jpeg', 'Preview-4.jpg', '2', 'Agreements', '2023-02-16 07:29:38.273625', 'The book is about Henrietta Lacks and the immortal cell line, known as HeLa, that came from Lacks\'s cervical cancer cells in 1951. Skloot became interested in Lacks after a biology teacher referenced her, but didn\'t know much about her. Skloot began conducting extensive research on her and worked with Lacks\' family to create the book. The book is notable for its science writing and dealing with ethical issues of race and class in medical research. Skloot said that some of the information was taken from the journal of Deborah Lacks, Henrietta Lacks\'s daughter, as well as from \"archival photos and documents, scientific and historical research.\" It is Skloot\'s first book.', '198', '1991', 'Running'),
(5, 'Nineteen Eighty-Four', 'George Orwell', 'ISBN 0-13-379061-1', 'Secker & Warburg Publishers', '1984.jpg', 'Preview-5.png', '3', 'Memorandum of Understanding', '2023-02-16 07:29:26.213896', 'Nineteen Eighty-Four: A Novel, often published as 1984, is a dystopian novel by English novelist George Orwell. It was published on 8 June 1949 by Secker & Warburg as Orwell\'s ninth and final book completed in his lifetime. The story was mostly written at Barnhill, a farmhouse on the Scottish island of Jura, at times while Orwell suffered from severe tuberculosis. Thematically, Nineteen Eighty-Four centres on the consequences of government over-reach, totalitarianism, mass surveillance, and repressive regimentation of all persons and behaviours within society.\r\n\r\nThe story takes place in an imagined future, the year 1984, when much of the world has fallen victim to perpetual war, omnipresent government surveillance, historical negationism, and propaganda. Great Britain, known as Airstrip One, has become a province of a superstate named Oceania that is ruled by the Party who employ the Thought Police to persecute individuality and independent thinking.[4] Big Brother, the leader of the Party, enjoys an intense cult of personality despite the fact that he may not exist. The protagonist, Winston Smith, is a diligent and skillful rank-and-file worker and Party member who secretly hates the Party and dreams of rebellion. He enters a forbidden relationship with a co-worker, Julia.\r\n\r\nNineteen Eighty-Four has become a classic literary example of political and dystopian fiction. Many terms used in the novel have entered common usage, including Big Brother, doublethink, thoughtcrime, Newspeak, Room 101, telescreen, 2 + 2 = 5, prole, and memory hole. Nineteen Eighty-Four also popularised the adjective \"Orwellian\", connoting things such as official deception, secret surveillance, brazenly misleading terminology, and manipulation of recorded history by a totalitarian or authoritarian state. Time included it on its 100 best English-language novels from 1923 to 2005.[5] It was placed on the Modern Library\'s 100 Best Novels, reaching No. 13 on the editors\' list and No. 6 on the readers\' list.[6] In 2003, the novel was listed at No. 8 on The Big Read survey by the BBC.[7] Parallels have been drawn between the novel\'s subject matter and real life instances of totalitarianism, communism, mass surveillance, and violations of freedom of expression among other themes.', '56', '1992', 'Running'),
(7, 'Obcaecati provident', 'Aut maxime accusamus', 'Aliquid eos veritati', 'Autem animi sed sun', 'sololearn.pdf', 'Preview-7.jpeg', '3', 'Memorandum of Understanding', '2023-02-16 07:29:22.331009', 'Voluptas ducimus mo', 'Aspernatur est fugia', '2000', 'Revised');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_treaties`
--
ALTER TABLE `tbl_treaties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_treaties`
--
ALTER TABLE `tbl_treaties`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
