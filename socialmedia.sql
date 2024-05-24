-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 01:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialmedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `conntent` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `post_id`, `user_id`, `conntent`, `created_at`) VALUES
(26, 650, 1, 'prvi komentar', '2024-05-01'),
(28, 651, 9, 'komentar', '2024-05-02'),
(29, 1, 1, 'cvknvc', '2024-05-04'),
(30, 1, 1, 'cvn cvk n', '2024-05-04'),
(31, 1, 1, 'lvk nv', '2024-05-04'),
(32, 1, 1, 'kndfjvkdf', '2024-05-04'),
(33, 1, 1, 'fklvn', '2024-05-04'),
(34, 1, 1, 'vkjlkjnvkl', '2024-05-04'),
(40, 651, 1, 'c,.m n', '2024-05-07');

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `following_id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`following_id`, `user1_id`, `user2_id`) VALUES
(23, 9, 1),
(24, 9, 3),
(25, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `content`, `photo_path`, `user_id`, `created_at`) VALUES
(650, 'prva objava', NULL, 1, '2024-05-01 11:32:23'),
(651, 'sdlfksd;lk', NULL, 3, '2024-05-01 16:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `last_name`, `email`, `username`, `password`, `photo_path`, `description`, `admin`) VALUES
(1, 'Mirko', 'Popovic', 'mirkopopovic21@gmail.com', 'Mirko', '$2y$10$z2GwQ7GhiDODTfxAmwS9h.SrB12SZNLDmNJyY0sTXyj55Mrbw740q', 'images/Mirko/29-04-2024-1714345604-keisuke-takahashi-rx7-fd-initial-d-rx7.jpg', NULL, 0),
(3, 'Filip', 'Filipovic', 'filip@gmail.com', 'cofi', '$2y$10$eeySV8kmB4ZsyYW8WqTOsOeyFJHq/nrsrywfPqnjeHXAgfFueUmLu', 'images/cofi/imageForEntry5-ODq.webp', NULL, 0),
(6, 'Mirko', 'Popovic', 'mirko@gmail.com', 'admin', '$2y$10$64xUqSHbAwPIWD51lbxGKOg4xaH80g1wt6JSkr1pYZ2uzGMekCkSa', NULL, NULL, 1),
(9, 'Marko', 'Markovic', 'markomarkovic@gmail.com', 'marko123', '$2y$10$cSiTSzHUnkjkGHC7CygJ3OCLHsEA8u2hh7r7Nfv.0mpVuIcRrXzTu', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`following_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `following_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=670;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
