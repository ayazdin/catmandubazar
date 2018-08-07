-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2018 at 06:00 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dac_ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `autobrands`
--

CREATE TABLE IF NOT EXISTS `autobrands` (
  `id` int(10) unsigned NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cat_relations`
--

CREATE TABLE IF NOT EXISTS `cat_relations` (
  `id` int(10) unsigned NOT NULL,
  `postid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_resets_table', 1),
(10, '2018_05_21_044556_create_options_table', 1),
(11, '2018_05_21_044621_create_posts_table', 1),
(12, '2018_05_21_044642_create_postcats_table', 1),
(13, '2018_05_21_044720_create_cat_relations_table', 1),
(14, '2018_05_21_044757_create_postmetas_table', 1),
(15, '2018_06_20_054437_create_autobrands_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(10) unsigned NOT NULL,
  `var_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `var_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postcats`
--

CREATE TABLE IF NOT EXISTS `postcats` (
  `id` int(10) unsigned NOT NULL,
  `parent` int(11) DEFAULT '0',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catorder` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postcats`
--

INSERT INTO `postcats` (`id`, `parent`, `type`, `name`, `slug`, `image`, `catorder`, `created_at`, `updated_at`) VALUES
(1, 0, 'category', 'xx', 'xx', NULL, 0, '2018-08-02 11:41:21', '2018-08-02 11:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `postmetas`
--

CREATE TABLE IF NOT EXISTS `postmetas` (
  `id` int(10) unsigned NOT NULL,
  `postid` int(11) NOT NULL,
  `meta_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postmetas`
--

INSERT INTO `postmetas` (`id`, `postid`, `meta_key`, `meta_value`, `created_at`, `updated_at`) VALUES
(1, 1, 'priceOption', 'a:0:{}', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(2, 1, 'options', 'a:2:{i:0;a:2:{s:4:"name";s:5:"Color";s:7:"options";a:2:{i:0;s:3:"Red";i:1;s:5:"Green";}}i:1;a:2:{s:4:"name";s:4:"Size";s:7:"options";a:2:{i:0;s:5:"Large";i:1;s:5:"Small";}}}', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(3, 1, 'isFeatured', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(4, 1, 'hashtags', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(5, 1, 'price', '680', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(6, 1, 'keywords', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(7, 1, 'metadesc', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(8, 1, 'currency', 'NPR', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(9, 1, 'purchase', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(10, 1, 'quantity', '12', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(11, 1, 'stock', 'in', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(12, 1, 'showQty', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(13, 1, 'showPrice', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(14, 1, 'showStock', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(15, 1, 'showDesc', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(16, 1, 'buyurl', '', '2018-08-02 11:32:37', '2018-08-02 11:32:37'),
(17, 1, 'images', 'a:1:{i:0;N;}', '2018-08-02 11:32:37', '2018-08-02 11:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL,
  `userid` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `clean_url` text COLLATE utf8mb4_unicode_ci,
  `ctype` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_order` int(11) DEFAULT NULL,
  `cmt_count` int(11) DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userid`, `title`, `name`, `excerpt`, `content`, `clean_url`, `ctype`, `image`, `menu_order`, `cmt_count`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test is test', NULL, NULL, '<p>This is a test content</p>', 'test-is-test', 'product', '/photos/1/dunlop-tyre-700x439.jpg', NULL, NULL, 'publish', '2018-08-02 11:32:37', '2018-08-02 11:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ayaz Uddin', 'ayaz.din@gmail.com', '$2y$10$DhrhFkN8ngPsTZ7ved4/2OYRC2tB3P2w9.P3zNroWhX4ikG0YjucW', 'admin', '3hKQnyETyCAjtTDgRhA2sjnasA7mWO0ChUQkg58zCHG0wjXfXw4DCAX8yNUI', '2018-05-20 23:54:13', '2018-05-20 23:54:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autobrands`
--
ALTER TABLE `autobrands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cat_relations`
--
ALTER TABLE `cat_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `postcats`
--
ALTER TABLE `postcats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postmetas`
--
ALTER TABLE `postmetas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autobrands`
--
ALTER TABLE `autobrands`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cat_relations`
--
ALTER TABLE `cat_relations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `postcats`
--
ALTER TABLE `postcats`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `postmetas`
--
ALTER TABLE `postmetas`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
