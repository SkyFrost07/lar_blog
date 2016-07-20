-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2016 at 07:05 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lar_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `plar_caps`
--

CREATE TABLE IF NOT EXISTS `plar_caps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `higher` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `plar_caps`
--

INSERT INTO `plar_caps` (`id`, `name`, `label`, `higher`, `created_at`, `updated_at`) VALUES
(1, 'publish_posts', 'Publish posts', '', '2016-07-12 14:45:21', '2016-07-12 14:45:21'),
(2, 'edit_my_post', 'Edit my post', 'edit_other_posts', '2016-07-12 14:48:44', '2016-07-12 15:00:08'),
(3, 'edit_other_posts', 'Edit posts of other members', '', '2016-07-12 14:49:35', '2016-07-12 14:49:35'),
(4, 'remove_my_post', 'Remove my post', 'remove_other_posts', '2016-07-12 14:49:57', '2016-07-12 15:01:33'),
(5, 'remove_other_posts', 'Remove other post', '', '2016-07-12 14:50:24', '2016-07-12 14:50:24'),
(6, 'manage_roles', 'Manage roles', '', '2016-07-12 14:51:02', '2016-07-12 14:51:02'),
(7, 'manage_caps', 'Manage Caps', '', '2016-07-12 14:51:23', '2016-07-12 14:51:23'),
(8, 'edit_my_user', 'Edit my account', 'edit_other_users', '2016-07-12 14:51:51', '2016-07-12 15:01:17'),
(9, 'remove_my_user', 'Remove my account', 'remove_other_users', '2016-07-12 14:52:13', '2016-07-12 15:01:57'),
(10, 'publish_users', 'Create users', '', '2016-07-12 14:53:17', '2016-07-12 14:53:17'),
(11, 'edit_other_users', 'Edit other accounts', '', '2016-07-12 14:54:33', '2016-07-12 14:54:33'),
(12, 'remove_other_users', 'Remove other account', '', '2016-07-12 14:54:46', '2016-07-12 14:54:46'),
(13, 'accept_manage', 'Access manage area', '', '2016-07-12 15:02:35', '2016-07-12 15:02:35'),
(18, 'manage_users', 'Crud users', '', '2016-07-16 06:50:23', '2016-07-16 06:50:23'),
(19, 'manage_posts', 'Crud posts', '', '2016-07-16 06:51:08', '2016-07-16 06:51:08'),
(20, 'read_users', 'List users', 'manage_users', '2016-07-16 06:52:23', '2016-07-16 06:52:23'),
(21, 'read_posts', 'List posts', 'manage_posts', '2016-07-16 07:26:49', '2016-07-16 07:26:49'),
(22, 'manage_langs', 'Crud Langs', '', '2016-07-16 07:54:36', '2016-07-16 07:54:36'),
(23, 'manage_cats', 'Crud Categories', '', '2016-07-16 13:22:11', '2016-07-16 13:22:11'),
(24, 'manage_tags', 'Crud Tags', '', '2016-07-16 13:22:22', '2016-07-16 13:22:22'),
(25, 'edit_my_comment', 'Edit my comment', '', '2016-07-16 14:55:03', '2016-07-16 14:55:03'),
(26, 'edit_other_comments', 'Edit other comments', '', '2016-07-16 14:55:29', '2016-07-16 14:55:29'),
(27, 'remove_my_comment', 'Remove my comment', 'remove_other_comments', '2016-07-16 14:55:48', '2016-07-16 15:04:58'),
(28, 'remove_other_comments', 'Remove other comments', '', '2016-07-16 14:56:29', '2016-07-16 14:56:29'),
(29, 'publish_comments', 'Publish comments', '', '2016-07-16 14:56:49', '2016-07-16 14:56:49'),
(30, 'manage_menus', 'Manage menu', '', '2016-07-18 15:25:44', '2016-07-18 15:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `plar_files`
--

CREATE TABLE IF NOT EXISTS `plar_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'image',
  `mimetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `plar_langs`
--

CREATE TABLE IF NOT EXISTS `plar_langs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `folder` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `ratio_currency` double(8,2) NOT NULL DEFAULT '1.00',
  `order` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `default` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `plar_langs`
--

INSERT INTO `plar_langs` (`id`, `name`, `code`, `icon`, `folder`, `unit`, `ratio_currency`, `order`, `status`, `default`, `created_at`, `updated_at`) VALUES
(1, 'Tiếng Việt', 'vi', 'vi.png', 'vi', 'VNĐ', 1.00, 1, 1, 0, '2016-07-16 08:18:41', '2016-07-16 09:18:40'),
(2, 'English', 'en', 'en.png', 'en', '$', 23230.00, 2, 1, 0, '2016-07-16 08:21:34', '2016-07-16 09:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `plar_menus`
--

CREATE TABLE IF NOT EXISTS `plar_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `menu_type` tinyint(4) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `icon` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `open_type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `order` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `plar_menus`
--

INSERT INTO `plar_menus` (`id`, `group_id`, `parent_id`, `menu_type`, `type_id`, `icon`, `open_type`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 33, 0, 3, 22, 'fa-ball', '', 1, 1, '2016-07-18 16:50:24', '2016-07-18 16:50:24');

-- --------------------------------------------------------

--
-- Table structure for table `plar_menu_desc`
--

CREATE TABLE IF NOT EXISTS `plar_menu_desc` (
  `menu_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`menu_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plar_menu_desc`
--

INSERT INTO `plar_menu_desc` (`menu_id`, `lang_id`, `title`, `slug`, `link`) VALUES
(1, 1, 'Tin thể thao', '', ''),
(1, 2, 'Sport news', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `plar_migrations`
--

CREATE TABLE IF NOT EXISTS `plar_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plar_migrations`
--

INSERT INTO `plar_migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2016_07_10_085445_create_files_tbl', 1),
('2016_07_10_141427_create_cats_tbl', 1),
('2016_07_10_142757_create_langs_tbl', 1),
('2016_07_10_223458_create_role_cap_tbl', 2),
('2016_07_17_102149_create_tax_relations_table', 3),
('2016_07_18_224450_create_menus_table', 4),
('2016_07_19_195412_create_post_table', 5),
('2016_07_19_203944_create_files_tbl', 5);

-- --------------------------------------------------------

--
-- Table structure for table `plar_posts`
--

CREATE TABLE IF NOT EXISTS `plar_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thumb_id` int(11) NOT NULL,
  `thumb_ids` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `comment_status` tinyint(4) NOT NULL DEFAULT '1',
  `comment_count` int(11) NOT NULL,
  `post_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'post',
  `views` int(11) NOT NULL,
  `template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `trashed_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_id_post_type_index` (`id`,`post_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `plar_posts`
--

INSERT INTO `plar_posts` (`id`, `thumb_id`, `thumb_ids`, `author_id`, `status`, `comment_status`, `comment_count`, `post_type`, `views`, `template`, `created_at`, `updated_at`, `trashed_at`) VALUES
(8, 0, '', 0, 1, 1, 0, 'post', 0, '', '2016-07-19 14:51:34', '2016-07-19 14:51:34', '0000-00-00 00:00:00'),
(9, 0, '', 1, 1, 1, 0, 'post', 3, '', '2016-07-19 14:52:41', '2016-07-19 17:22:12', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `plar_post_desc`
--

CREATE TABLE IF NOT EXISTS `plar_post_desc` (
  `post_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `custom` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_desc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`post_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plar_post_desc`
--

INSERT INTO `plar_post_desc` (`post_id`, `lang_id`, `title`, `slug`, `excerpt`, `content`, `custom`, `meta_keyword`, `meta_desc`) VALUES
(9, 1, 'Bai viet so 2', 'bai-viet-so-2', 'Tom tat bai viet so 2', 'Noi dung bai viet so 2', '', '', ''),
(9, 2, 'The post number 2', 'the-post-number-2', 'The excerpt of post number 2', 'The content of post number 2', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `plar_post_tax`
--

CREATE TABLE IF NOT EXISTS `plar_post_tax` (
  `post_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plar_post_tax`
--

INSERT INTO `plar_post_tax` (`post_id`, `tax_id`) VALUES
(9, 23),
(9, 24),
(9, 28),
(9, 31),
(9, 38);

-- --------------------------------------------------------

--
-- Table structure for table `plar_roles`
--

CREATE TABLE IF NOT EXISTS `plar_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `plar_roles`
--

INSERT INTO `plar_roles` (`id`, `label`, `name`, `default`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', 0, '2016-07-10 18:23:33', '2016-07-11 14:54:58'),
(2, 'Editor', 'editor', 0, '2016-07-10 18:23:51', '2016-07-11 14:57:22'),
(3, 'Member', 'member', 1, '2016-07-10 18:24:15', '2016-07-12 15:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `plar_role_cap`
--

CREATE TABLE IF NOT EXISTS `plar_role_cap` (
  `role_id` int(11) NOT NULL,
  `cap_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`cap_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plar_role_cap`
--

INSERT INTO `plar_role_cap` (`role_id`, `cap_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(6, 1),
(7, 1),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(13, 2),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `plar_taxs`
--

CREATE TABLE IF NOT EXISTS `plar_taxs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'cat',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39 ;

--
-- Dumping data for table `plar_taxs`
--

INSERT INTO `plar_taxs` (`id`, `image_id`, `type`, `parent_id`, `order`, `count`, `status`, `created_at`, `updated_at`) VALUES
(20, 0, 'cat', 22, 0, 0, 1, '2016-07-16 20:40:45', '2016-07-16 20:52:56'),
(22, 0, 'cat', 0, 0, 0, 1, '2016-07-16 20:52:09', '2016-07-16 20:52:09'),
(23, 0, 'cat', 22, 0, 0, 1, '2016-07-16 20:53:30', '2016-07-18 14:16:00'),
(24, 0, 'cat', 0, 0, 0, 1, '2016-07-16 20:53:52', '2016-07-16 20:53:52'),
(25, 0, 'cat', 24, 0, 0, 1, '2016-07-16 20:54:08', '2016-07-16 20:54:55'),
(27, 0, 'cat', 0, 0, 0, 1, '2016-07-16 21:00:12', '2016-07-16 21:00:12'),
(28, 0, 'cat', 23, 0, 0, 1, '2016-07-17 03:17:14', '2016-07-17 03:17:14'),
(29, 0, 'cat', 27, 0, 0, 1, '2016-07-17 03:35:04', '2016-07-17 03:35:04'),
(31, 0, 'tag', 0, 0, 0, 1, '2016-07-17 04:47:49', '2016-07-17 04:47:49'),
(33, 0, 'menucat', 0, 0, 0, 1, '2016-07-18 15:29:52', '2016-07-18 15:36:08'),
(34, 0, 'menucat', 0, 0, 0, 1, '2016-07-18 15:31:08', '2016-07-18 15:31:08'),
(38, 0, 'tag', 0, 0, 0, 1, '2016-07-19 16:58:17', '2016-07-19 16:58:17');

-- --------------------------------------------------------

--
-- Table structure for table `plar_tax_desc`
--

CREATE TABLE IF NOT EXISTS `plar_tax_desc` (
  `tax_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tax_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plar_tax_desc`
--

INSERT INTO `plar_tax_desc` (`tax_id`, `lang_id`, `name`, `slug`, `description`, `meta_keyword`, `meta_desc`, `created_at`, `updated_at`) VALUES
(20, 1, 'Tennis', 'tennis', '', '', '', NULL, NULL),
(20, 2, 'Tennis', 'tennis', '', '', '', NULL, NULL),
(22, 1, 'Thể thao', 'the-thao', '', '', '', NULL, NULL),
(22, 2, 'Sport', 'sport', '', '', '', NULL, NULL),
(23, 1, 'Bóng đá', 'bong-da', '', '', '', NULL, NULL),
(23, 2, 'Football', 'football', '', '', '', NULL, NULL),
(24, 1, 'Xã Hội', 'xa-hoi', '', '', '', NULL, NULL),
(24, 2, 'Socials', 'socials', '', '', '', NULL, NULL),
(25, 1, 'Giáo dục', 'giao-duc', '', '', '', NULL, NULL),
(25, 2, 'Education', 'education', '', '', '', NULL, NULL),
(27, 1, 'Pháp luật', 'phap-luat', 'Bản tin pháp luật', 'phap luat', 'Tin pháp luật', NULL, NULL),
(27, 2, 'Law', 'law', 'Law news', 'law keyword', 'law description', NULL, NULL),
(28, 1, 'Bóng đá anh', 'bong-da-anh', '', '', '', NULL, NULL),
(28, 2, 'Premier Leguage', 'premier-leguage', '', '', '', NULL, NULL),
(29, 1, 'Văn bản luật', 'van-ban-luat', '', '', '', NULL, NULL),
(29, 2, 'Legal texts', 'legal-texts', '', '', '', NULL, NULL),
(31, 1, 'vui nhộn', 'vui-nhon', '', '', '', NULL, NULL),
(31, 2, 'funny', 'funny', '', '', '', NULL, NULL),
(33, 1, 'Menu chính', 'menu-chinh', '', '', '', NULL, NULL),
(33, 2, 'Primary menu', 'primary-menu', '', '', '', NULL, NULL),
(34, 1, 'Footer menu', 'footer-menu', '', '', '', NULL, NULL),
(34, 2, 'Footer menu', 'footer-menu', '', '', '', NULL, NULL),
(38, 1, 'cung hong', 'cung-hong', '', '', '', NULL, NULL),
(38, 2, 'inter ivew', 'inter-ivew', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plar_tax_relations`
--

CREATE TABLE IF NOT EXISTS `plar_tax_relations` (
  `tax_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`tax_id`,`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plar_tax_relations`
--

INSERT INTO `plar_tax_relations` (`tax_id`, `parent_id`) VALUES
(20, 22),
(23, 22),
(25, 24),
(28, 23),
(29, 27);

-- --------------------------------------------------------

--
-- Table structure for table `plar_users`
--

CREATE TABLE IF NOT EXISTS `plar_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL,
  `birth` timestamp NOT NULL,
  `image_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2',
  `resetPasswdToken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `resetPasswdExpires` bigint(20) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `plar_users`
--

INSERT INTO `plar_users` (`id`, `name`, `email`, `password`, `role_id`, `gender`, `birth`, `image_id`, `status`, `resetPasswdToken`, `resetPasswdExpires`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'frostsky07', 'skyfrost.07@gmail.com', '$2y$10$DxhMb42U4QKJeMrBNjZKAeCJgNPSLB4vcs2RD0zAQI7N29w5xkGs.', 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, 'bv11I6lIGdgcxzuFlr7090ZtFw1ZKggqTXoogGmxchWQYV81fzIFLE9Nckw6', '2016-07-10 08:35:23', '2016-07-16 06:59:54'),
(2, 'test1', 'tes1@gmail.com', '$2y$10$4tC3z.mlDyi7bvyuS7lwJuunfVrD4u3WiXQfaxA1vK.axUclJ9Cn6', 3, 0, '0000-00-00 00:00:00', 0, -1, '', 0, NULL, '2016-07-10 08:36:38', '2016-07-16 09:33:04'),
(3, 'Văn Lam', 'vanlam0705@gmail.com', '$2y$10$GtXMyZtG6LQ/oRg.v5VmGO4a4Qoix5osl2M0m/ocP0DMdMfaZABl6', 1, 0, '0000-00-00 00:00:00', 0, 1, '', 0, 'GGuN0roS6U3lcmkXgpOImr955UFhUQrIVoNOUHxuwcPdyN8We102vfuQWlwI', '2016-07-10 08:37:45', '2016-07-16 06:59:54'),
(4, 'test2', 'test2@gmail.com', '$2y$10$L9ADkN6lIfqNNew8XSKx5eC6t/OmwsfodmIS.mCjg3QCf8P2Rj786', 3, 0, '0000-00-00 00:00:00', 0, 0, '', NULL, NULL, '2016-07-12 15:38:54', '2016-07-16 09:31:35'),
(5, 'member3', 'member3@gmail.com', '$2y$10$QS8zOy4Yk6WRvV0YAsIoQ./xYN/EH8zClGFYQGHvgtCjKRAtGXuxS', 2, 0, '0000-00-00 00:00:00', 0, 1, '', NULL, '287BUDJ5RObocczn4QTTfeHMkIbuwsPV1A3OvjMOaZYurYOiLtWoKzzXI5Tm', '2016-07-12 15:39:27', '2016-07-16 06:59:54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
