-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2017 at 12:42 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gistout`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `likes` bigint(20) NOT NULL,
  `shares` bigint(20) NOT NULL,
  `quotes` bigint(20) NOT NULL,
  `created` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `followed_posts`
--

CREATE TABLE `followed_posts` (
  `id` int(11) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE `hashtag` (
  `id` bigint(20) NOT NULL,
  `hashtag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hashtag_post`
--

CREATE TABLE `hashtag_post` (
  `id` int(11) NOT NULL,
  `hashtag_id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `hashtag_spec` enum('post','comment','debate') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mentions`
--

CREATE TABLE `mentions` (
  `id` bigint(20) NOT NULL,
  `mention_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `mention_specs` enum('post','comment','debate') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `receiver_id` bigint(20) NOT NULL,
  `sender_id` bigint(20) NOT NULL,
  `time` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `notification_spec` enum('post','comment','debate') NOT NULL,
  `notification_type` enum('mention','following','share','like','trophy','badge') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(255) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `category_id` varchar(30) NOT NULL,
  `user_id` bigint(255) NOT NULL,
  `content` varchar(15000) NOT NULL,
  `likes` bigint(255) NOT NULL,
  `shares` bigint(255) NOT NULL,
  `created` text NOT NULL,
  `last_updated` text NOT NULL,
  `views` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trending_hashtag`
--

CREATE TABLE `trending_hashtag` (
  `id` int(11) NOT NULL,
  `hashtag_id` bigint(20) NOT NULL,
  `last_count` bigint(20) NOT NULL,
  `recent_count` bigint(20) NOT NULL,
  `last_update` text NOT NULL,
  `recent_update` text NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `dob` text NOT NULL,
  `user_points` varchar(255) NOT NULL,
  `user_avatar` longtext NOT NULL,
  `joined` text NOT NULL,
  `last_seen` text NOT NULL,
  `online` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followed_posts`
--
ALTER TABLE `followed_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hashtag`
--
ALTER TABLE `hashtag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hashtag_post`
--
ALTER TABLE `hashtag_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentions`
--
ALTER TABLE `mentions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trending_hashtag`
--
ALTER TABLE `trending_hashtag`
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
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `followed_posts`
--
ALTER TABLE `followed_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hashtag_post`
--
ALTER TABLE `hashtag_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentions`
--
ALTER TABLE `mentions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trending_hashtag`
--
ALTER TABLE `trending_hashtag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
