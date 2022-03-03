-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2021 at 03:43 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dogelab`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unique_id` varchar(11) DEFAULT NULL,
  `ref_by` int(10) UNSIGNED DEFAULT NULL,
  `wallet` varchar(191) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `access`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '5ff1c3531ed3f1609679699.jpg', NULL, '$2y$10$881.RJENbcp.ILchkOe6H.g/HedUprvxdyv8xN/WGa6TMlmhNi9WG', NULL, '2021-06-08 05:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `wallet` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_templates`
--

CREATE TABLE `email_sms_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `act` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subj` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcodes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_status` tinyint(4) NOT NULL DEFAULT 1,
  `sms_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_sms_templates`
--

INSERT INTO `email_sms_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(1, 'PASS_RESET_CODE', 'Password Reset', 'Password Reset', '<div>We have received a request to reset the password for your account on <b>{{time}} .<br></b></div><div>Requested From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div><div><br></div><br><div><div><div>Your account recovery code is:&nbsp;&nbsp; <font size=\"6\"><b>{{code}}</b></font></div><div><br></div></div></div><div><br></div><div><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><br>', 'Your account recovery code is: {{code}}', ' {\"code\":\"Password Reset Code\",\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2021-01-06 00:49:06'),
(2, 'PASS_RESET_DONE', 'Password Reset Confirmation', 'You have Reset your password', '<div><p>\r\n    You have successfully reset your password.</p><p>You changed from&nbsp; IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}}&nbsp;</b> on <b>{{time}}</b></p><p><b><br></b></p><p><font color=\"#FF0000\"><b>If you did not changed that, Please contact with us as soon as possible.</b></font><br></p></div>', 'Your password has been changed successfully', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-07 10:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` int(10) UNSIGNED NOT NULL,
  `act` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"58dd135ef7bbaa72709c3470\\/default\"}}', 'twak.png', 1, NULL, '2019-10-18 23:16:05', '2021-01-03 23:39:18'),
(2, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{app_key}}\"></script>\r\n                <script>\r\n                  window.dataLayer = window.dataLayer || [];\r\n                  function gtag(){dataLayer.push(arguments);}\r\n                  gtag(\"js\", new Date());\r\n                \r\n                  gtag(\"config\", \"{{app_key}}\");\r\n                </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"Demo\"}}', 'ganalytics.png', 1, NULL, NULL, '2020-07-20 19:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_keys` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"crypto\",\"cryptocurrency\",\"doge\",\"dogecoin\",\"coin\"],\"description\":\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit\",\"social_title\":\"Viserlab Limited\",\"social_description\":\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit ff\",\"image\":\"60bf4d03b5b861623149827.png\"}', '2020-07-04 23:42:52', '2021-06-08 04:57:45'),
(39, 'banner.content', '{\"has_image\":\"1\",\"title\":\"Welcome To\",\"subtitle\":\"Dogecoin Mining Platform\",\"description\":\"Dignissimos modi magnam quidem, eos ducimus recusandae voluptatum, ex enim soluta neque officia iste eius commodi qui ea ratione! Nam, quis iure commodi qui ea ratione! Nam, quis iure\",\"background_image\":\"6077e90f004691618471183.jpg\",\"icon\":\"60bf47b64e73a1623148470.png\",\"image\":\"60bf47b6514fa1623148470.png\"}', '2021-04-15 01:19:42', '2021-06-08 04:34:30'),
(40, 'how_work.content', '{\"title\":\"Working Process\",\"subtitle\":\"Ho To Start\",\"description\":\"Laborum impedit commodi numquam blanditiis sed obcaecati, eum dicta pariatur laudantium modi corrupti voluptate\"}', '2021-04-15 02:08:05', '2021-04-15 02:08:05'),
(41, 'how_work.element', '{\"title\":\"Enter Wallet Address\"}', '2021-04-15 02:09:37', '2021-04-15 02:09:37'),
(42, 'how_work.element', '{\"title\":\"Deposit Money\"}', '2021-04-15 02:09:54', '2021-04-15 02:09:54'),
(43, 'how_work.element', '{\"title\":\"Start Mining\"}', '2021-04-15 02:10:35', '2021-04-15 02:12:49'),
(44, 'how_work.element', '{\"title\":\"Withdraw\"}', '2021-04-15 02:12:20', '2021-04-15 02:12:31'),
(45, 'transaction.content', '{\"has_image\":\"1\",\"title\":\"Latest Transactions\",\"subtitle\":\"Our Latest Deposits and Withdraws\",\"description\":\"Nisi voluptates, neque animi velit inventore quidem omnis. Quo veritatis aliquam aspernatur nihil consequatur? delectus facilis!\",\"background_image\":\"6077f7b885b861618474936.jpg\"}', '2021-04-15 02:22:16', '2021-04-15 02:22:16'),
(46, 'about.content', '{\"has_image\":\"1\",\"quote\":\"Successfully Providing the Best Mining Service from 24 years\",\"title\":\"About Us\",\"subtitle\":\"Know What We Are\",\"short_description\":\"Nisi voluptates, neque animi velit inventore quidem omnis. Quo veritatis aliquam aspernatur nihil consequatur? delectus facilis!\",\"details\":\"Lure corrupti cumque nulla doloribus necessitatibus, vero, voluptas temporibus voluptatem voluptate dolorem quaerat? Vitae, saepe dolorem. Voluptas, nihil necessitatibus. Corrupti, facilis odit! Molestias nostrum harum omnis molestiae recusandae ad voluptatum eum sit, in ex, expedita iure corrupti illum quaerat mollitia cum doloribus totam consequatur!\",\"image\":\"6077f924e25b31618475300.jpg\"}', '2021-04-15 02:28:20', '2021-04-15 02:39:34'),
(47, 'about.element', '{\"about_list_item\":\"Accusantium labore est aperiam iste.\"}', '2021-04-15 02:39:04', '2021-04-15 02:39:04'),
(48, 'about.element', '{\"about_list_item\":\"Maxime accusantium obcaecati quam iusto porro!\"}', '2021-04-15 02:39:44', '2021-04-15 02:39:44'),
(49, 'about.element', '{\"about_list_item\":\"Cumque sequi deleniti, doloremque voluptatem\"}', '2021-04-15 02:39:53', '2021-04-15 02:39:53'),
(50, 'feature.content', '{\"has_image\":\"1\",\"title\":\"Feature\",\"subtitle\":\"Our Special Feature\",\"description\":\"Nisi voluptates, neque animi velit inventore quidem omnis. Quo veritatis aliquam aspernatur nihil consequatur? delectus facilis!\",\"background_image\":\"60bf61298ce671623154985.jpg\"}', '2021-04-15 02:48:28', '2021-06-08 06:23:05'),
(51, 'feature.element', '{\"icon\":\"<i class=\\\"las la-headset\\\"><\\/i>\",\"title\":\"24\\/7 Support\",\"description\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\"}', '2021-04-15 02:49:13', '2021-04-15 02:49:13'),
(52, 'feature.element', '{\"icon\":\"<i class=\\\"las la-globe-africa\\\"><\\/i>\",\"title\":\"Global\",\"description\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\"}', '2021-04-15 02:49:58', '2021-04-15 02:49:58'),
(53, 'feature.element', '{\"icon\":\"<i class=\\\"las la-lock\\\"><\\/i>\",\"title\":\"Secure\",\"description\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\"}', '2021-04-15 02:50:31', '2021-04-15 02:50:31'),
(54, 'feature.element', '{\"icon\":\"<i class=\\\"fas fa-language\\\"><\\/i>\",\"title\":\"Multilingual\",\"description\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\"}', '2021-04-15 02:55:24', '2021-04-15 02:55:24'),
(55, 'feature.element', '{\"icon\":\"<i class=\\\"las la-power-off\\\"><\\/i>\",\"title\":\"Offline Tracking\",\"description\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\"}', '2021-04-15 02:56:40', '2021-04-15 02:56:40'),
(56, 'feature.element', '{\"icon\":\"<i class=\\\"fas fa-money-check\\\"><\\/i>\",\"title\":\"Easy Payment System\",\"description\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\"}', '2021-04-15 02:57:03', '2021-04-15 02:57:03'),
(57, 'faq.content', '{\"title\":\"FAQ\'S\",\"subtitle\":\"Frequently Asked Questions\",\"description\":\"Nisi voluptates, neque animi velit inventore quidem omnis. Quo veritatis aliquam aspernatur nihil consequatur? delectus facilis!\"}', '2021-04-15 03:08:20', '2021-04-15 03:08:20'),
(58, 'faq.element', '{\"question\":\"What is Cryptocurrency?\",\"answer\":\"Cryptocurrency is decentralized digital money, based on blockchain technology. You may be familiar with the most popular versions, Bitcoin and Ethereum, but there are more than 5,000 different cryptocurrencies in circulation, according to CoinLore.\"}', '2021-04-15 03:09:38', '2021-04-15 03:09:38'),
(59, 'faq.element', '{\"question\":\"What is crypto currency mining?\",\"answer\":\"In a nutshell, cryptocurrency mining is a term that refers to the process of gathering cryptocurrency as a reward for work that you complete.\"}', '2021-04-15 03:09:58', '2021-04-15 03:09:58'),
(60, 'faq.element', '{\"question\":\"Why do people crypto mine?\",\"answer\":\"For some, they\\u2019re looking for another source of income. For others, it\\u2019s about gaining greater financial freedom without governments or banks butting in. But whatever the reason, cryptocurrencies are a growing area of interest for technophiles, investors, and cybercriminals alike.\"}', '2021-04-15 03:10:23', '2021-04-15 03:10:23'),
(61, 'faq.element', '{\"question\":\"Neque animi velit inventore quidem omnis?\",\"answer\":\"First Nam cupiditate impedit nobis quasi error iste quas nesciunt aut eius, repellat quos dolor, nihil, sunt soluta repudiandae ducimus eos voluptatibus alias.\\r\\n\\r\\nSecond Nam cupiditate impedit nobis quasi error iste quas nesciunt aut eius, repellat quos dolor, nihil, sunt soluta repudiandae ducimus eos voluptatibus alias.\"}', '2021-04-15 03:10:57', '2021-04-15 03:10:57'),
(62, 'faq.element', '{\"question\":\"Neque animi velit inventore quidem omnis?\",\"answer\":\"First Nam cupiditate impedit nobis quasi error iste quas nesciunt aut eius, repellat quos dolor, nihil, sunt soluta repudiandae ducimus eos voluptatibus alias.\\r\\n\\r\\nSecond Nam cupiditate impedit nobis quasi error iste quas nesciunt aut eius, repellat quos dolor, nihil, sunt soluta repudiandae ducimus eos voluptatibus alias.\"}', '2021-04-15 03:11:18', '2021-04-15 03:11:18'),
(63, 'faq.element', '{\"question\":\"What is Cryptocurrency?\",\"answer\":\"Cryptocurrency is decentralized digital money, based on blockchain technology. You may be familiar with the most popular versions, Bitcoin and Ethereum, but there are more than 5,000 different cryptocurrencies in circulation, according to CoinLore.\"}', '2021-04-15 03:11:39', '2021-04-15 03:11:39'),
(64, 'counter.content', '{\"has_image\":\"1\",\"background_image\":\"607804aaaa8f31618478250.jpg\"}', '2021-04-15 03:17:30', '2021-04-15 03:17:31'),
(67, 'counter.element', '{\"title\":\"Withdraw\",\"digit\":\"1000\",\"unit\":\"+\",\"icon\":\"<i class=\\\"las la-wallet\\\"><\\/i>\"}', '2021-04-15 03:20:34', '2021-04-15 03:20:34'),
(68, 'counter.element', '{\"title\":\"Happy Miners\",\"digit\":\"35\",\"unit\":\"K\",\"icon\":\"<i class=\\\"las la-user-alt\\\"><\\/i>\"}', '2021-04-15 03:21:01', '2021-04-15 03:21:01'),
(69, 'counter.element', '{\"title\":\"Deposit\",\"digit\":\"230\",\"unit\":\"K\",\"icon\":\"<i class=\\\"fas fa-money-check-alt\\\"><\\/i>\"}', '2021-04-15 03:22:58', '2021-04-15 03:22:58'),
(70, 'counter.element', '{\"title\":\"Supported Language\",\"digit\":\"15\",\"unit\":\"+\",\"icon\":\"<i class=\\\"las la-language\\\"><\\/i>\"}', '2021-04-15 03:24:05', '2021-04-15 03:24:05'),
(72, 'testimonial.content', '{\"has_image\":\"1\",\"background_image\":\"60780eee640e61618480878.jpg\"}', '2021-04-15 04:01:18', '2021-04-15 04:01:18'),
(73, 'testimonial.element', '{\"has_image\":[\"1\"],\"author\":\"John Doe\",\"designation\":\"CEO\",\"rating\":\"5\",\"quote\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\",\"image\":\"60780f7abed651618481018.jpg\"}', '2021-04-15 04:03:38', '2021-04-15 04:03:38'),
(74, 'testimonial.element', '{\"has_image\":[\"1\"],\"author\":\"Mark Jecno\",\"designation\":\"Managing Partner\",\"rating\":\"4\",\"quote\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\",\"image\":\"607810c1711e41618481345.jpg\"}', '2021-04-15 04:09:05', '2021-04-15 04:13:55'),
(75, 'testimonial.element', '{\"has_image\":[\"1\"],\"author\":\"Jane Smith\",\"designation\":\"CTO\",\"rating\":\"5\",\"quote\":\"Necessitatibus unde perspiciatis accusamus explicabo sapiente dolor! Incidunt numquam a, molestiae ex rem atque optio minima\",\"image\":\"607810e2c7c421618481378.jpg\"}', '2021-04-15 04:09:38', '2021-04-15 04:09:38'),
(76, 'partners.content', '{\"title\":\"Partners\",\"subtitle\":\"Our Partners\",\"description\":\"Nisi voluptates, neque animi velit inventore quidem omnis. Quo veritatis aliquam aspernatur nihil consequatur? delectus facilis!\"}', '2021-04-15 04:21:42', '2021-04-15 04:21:42'),
(77, 'partners.element', '{\"has_image\":\"1\",\"image\":\"60bf93037d35d1623167747.jpg\"}', '2021-04-15 04:23:17', '2021-06-08 09:55:47'),
(78, 'partners.element', '{\"has_image\":\"1\",\"image\":\"60bf94264c2421623168038.jpg\"}', '2021-04-15 04:23:22', '2021-06-08 10:00:38'),
(79, 'partners.element', '{\"has_image\":\"1\",\"image\":\"60781424af4761618482212.png\"}', '2021-04-15 04:23:32', '2021-04-15 04:23:32'),
(80, 'partners.element', '{\"has_image\":\"1\",\"image\":\"60bf944c0c01b1623168076.jpg\"}', '2021-04-15 04:23:38', '2021-06-08 10:01:16'),
(81, 'partners.element', '{\"has_image\":\"1\",\"image\":\"60bf943a4cbd21623168058.jpg\"}', '2021-04-15 04:23:46', '2021-06-08 10:00:58'),
(82, 'socials.element', '{\"icon\":\"<i class=\\\"lab la-facebook-f\\\"><\\/i>\",\"url\":\"www.facebook.com\"}', '2021-04-15 04:32:58', '2021-04-15 04:32:58'),
(83, 'socials.element', '{\"icon\":\"<i class=\\\"lab la-twitter\\\"><\\/i>\",\"url\":\"www.twitter.com\"}', '2021-04-15 04:33:19', '2021-04-15 04:33:19'),
(84, 'socials.element', '{\"icon\":\"<i class=\\\"lab la-linkedin-in\\\"><\\/i>\",\"url\":\"www.linkedin.com\"}', '2021-04-15 04:33:43', '2021-04-15 04:33:43'),
(85, 'footer.content', '{\"has_image\":\"1\",\"short_description\":\"Quos odio, dolores ea praesentium hic minima? Magnam perspiciatis nobis aliquid dicta, voluptatum sed rem dolor at quas ea labore dolorem voluptas.\",\"copyright_text\":\"\\u00a9 All Right Reserved by DogeLab\",\"image\":\"60bf664a610081623156298.jpg\"}', '2021-04-15 04:36:40', '2021-06-08 06:44:58'),
(86, 'top_investor.content', '{\"has_image\":\"1\",\"title\":\"Investor\",\"subtitle\":\"Our Top Investors\",\"description\":\"Nisi voluptates, neque animi velit inventore quidem omnis. Quo veritatis aliquam aspernatur nihil consequatur? delectus facilis!\",\"image\":\"6090e70d9cda21620109069.png\"}', '2021-04-21 22:29:51', '2021-05-04 00:17:49'),
(87, 'contact.content', '{\"has_image\":\"1\",\"address\":\"518 Dolphin Road C58D\",\"email_one\":\"demo@test.com\",\"email_two\":\"support@test.com\",\"phone_one\":\"+854 546457485644\",\"phone_two\":\"+854 465498654654\",\"form_title\":\"Send Us a Message\",\"header_background\":\"608148f1a433a1619085553.jpg\",\"image\":\"60813dcb1c5f81619082699.jpg\"}', '2021-04-22 01:50:03', '2021-04-22 03:59:13'),
(88, 'breadcrumb.content', '{\"has_image\":\"1\",\"image\":\"60c09df54de7b1623236085.jpg\"}', '2021-04-22 03:02:50', '2021-06-09 04:54:45'),
(89, 'user_dashboard.content', '{\"has_image\":\"1\",\"background_image\":\"608e4bf1a6db71619938289.jpg\"}', '2021-05-02 00:51:29', '2021-05-02 00:51:30'),
(90, 'policy_pages.element', '{\"page_title\":\"Privacy Policy\",\"description\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How do we protect your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">All provided delicate\\/credit data is sent through Stripe.<br \\/>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Do we disclose any information to outside parties?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Changes to our Privacy Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How long we retain your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What we don\\u2019t do with your data<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><\\/div><\\/div>\"}', '2021-06-08 06:12:41', '2021-06-08 06:12:41'),
(91, 'policy_pages.element', '{\"page_title\":\"Terms and Conditions\",\"description\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We claim all authority to dismiss, end, or handicap any help with or without cause per administrator discretion. This is a Complete independent facilitating, on the off chance that you misuse our ticket or Livechat or emotionally supportive network by submitting solicitations or protests we will impair your record. The solitary time you should reach us about the seaward facilitating is if there is an issue with the worker. We have not many substance limitations and everything is as per laws and guidelines. Try not to join on the off chance that you intend to do anything contrary to the guidelines, we do check these things and we will know, don\'t burn through our own and your time by joining on the off chance that you figure you will have the option to sneak by us and break the terms.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><ul class=\\\"font-18\\\" style=\\\"padding-left:15px;list-style-type:disc;font-size:18px;\\\"><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Configuration requests - If you have a fully managed dedicated server with us then we offer custom PHP\\/MySQL configurations, firewalls for dedicated IPs, DNS, and httpd configurations.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Software requests - Cpanel Extension Installation will be granted as long as it does not interfere with the security, stability, and performance of other users on the server.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Emergency Support - We do not provide emergency support \\/ Phone Support \\/ LiveChat Support. Support may take some hours sometimes.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Webmaster help - We do not offer any support for webmaster related issues and difficulty including coding, &amp; installs, Error solving. if there is an issue where a library or configuration of the server then we can help you if it\'s possible from our end.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Backups - We keep backups but we are not responsible for data loss, you are fully responsible for all backups.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">We Don\'t support any child porn or such material.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No spam-related sites or material, such as email lists, mass mail programs, and scripts, etc.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No harassing material that may cause people to retaliate against you.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No phishing pages.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">You may not run any exploitation script from the server. reason can be terminated immediately.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">If Anyone attempting to hack or exploit the server by using your script or hosting, we will terminate your account to keep safe other users.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Malicious Botnets are strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Spam, mass mailing, or email marketing in any way are strictly forbidden here.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Malicious hacking materials, trojans, viruses, &amp; malicious bots running or for download are forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Resource and cronjob abuse is forbidden and will result in suspension or termination.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Php\\/CGI proxies are strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">CGI-IRC is strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No fake or disposal mailers, mass mailing, mail bombers, SMS bombers, etc.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">NO CREDIT OR REFUND will be granted for interruptions of service, due to User Agreement violations.<\\/li><\\/ul><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Terms &amp; Conditions for Users<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">Before getting to this site, you are consenting to be limited by these site Terms and Conditions of Use, every single appropriate law, and guidelines, and concur that you are answerable for consistency with any material neighborhood laws. If you disagree with any of these terms, you are restricted from utilizing or getting to this site.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Support<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">Whenever you have downloaded our item, you may get in touch with us for help through email and we will give a valiant effort to determine your issue. We will attempt to answer using the Email for more modest bug fixes, after which we will refresh the center bundle. Content help is offered to confirmed clients by Tickets as it were. Backing demands made by email and Livechat.<\\/p><p class=\\\"my-3 font-18 font-weight-bold\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">On the off chance that your help requires extra adjustment of the System, at that point, you have two alternatives:<\\/p><ul class=\\\"font-18\\\" style=\\\"padding-left:15px;list-style-type:disc;font-size:18px;\\\"><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Hang tight for additional update discharge.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Or on the other hand, enlist a specialist (We offer customization for extra charges).<\\/li><\\/ul><\\/div>\"}', '2021-06-08 06:13:15', '2021-06-08 06:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `minimum_deposit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `minimum_withdraw` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `maximum_withdraw` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `key_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable_withdraw` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `minimum_deposit`, `minimum_withdraw`, `maximum_withdraw`, `key_1`, `key_2`, `enable_withdraw`, `created_at`, `updated_at`) VALUES
(1, '100.00000000', '10.00000000', '500.00000000', '***********', '*************', 0, '2018-09-12 18:00:00', '2021-06-08 02:02:37');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sitename` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `daily_earning` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `dhs_price` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `free_dhs` int(11) NOT NULL DEFAULT 0,
  `referral_system` tinyint(4) NOT NULL DEFAULT 1,
  `referral_bonus` decimal(18,8) NOT NULL DEFAULT 0.00000000 COMMENT '%',
  `email_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_api` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email configuration',
  `force_ssl` tinyint(4) NOT NULL DEFAULT 0,
  `active_template` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_version` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `sitename`, `cur_text`, `cur_sym`, `daily_earning`, `dhs_price`, `free_dhs`, `referral_system`, `referral_bonus`, `email_from`, `email_template`, `sms_api`, `base_color`, `secondary_color`, `mail_config`, `force_ssl`, `active_template`, `sys_version`, `last_cron`, `created_at`, `updated_at`) VALUES
(1, 'DogeLab', 'DOGE', 'DOGE', '0.00000000', '0.00000000', 0, 0, '0.00000000', 'test@site.com', '<table style=\"color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(0, 23, 54); text-decoration-style: initial; text-decoration-color: initial;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" bgcolor=\"#001736\"><tbody><tr><td valign=\"top\" align=\"center\"><table class=\"mobile-shell\" width=\"650\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"td container\" style=\"width: 650px; min-width: 650px; font-size: 0pt; line-height: 0pt; margin: 0px; font-weight: normal; padding: 55px 0px;\"><div style=\"text-align: center;\"><img src=\"https://i.imgur.com/m8ZYz6G.png\" style=\"height: 240 !important;width: 338px;margin-bottom: 20px;\"></div><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"padding-bottom: 10px;\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"tbrr p30-15\" style=\"padding: 60px 30px; border-radius: 26px 26px 0px 0px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"color: rgb(255, 255, 255); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 46px; padding-bottom: 25px; font-weight: bold;\">Hi {{name}} ,</td></tr><tr><td style=\"color: rgb(193, 205, 220); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 30px; padding-bottom: 25px;\">{{message}}</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"p30-15 bbrr\" style=\"padding: 50px 30px; border-radius: 0px 0px 26px 26px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"text-footer1 pb10\" style=\"color: rgb(0, 153, 255); font-family: Muli, Arial, sans-serif; font-size: 18px; line-height: 30px; text-align: center; padding-bottom: 10px;\">© 2020 DogeLab. All Rights Reserved.</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>', 'https://api.infobip.com/api/v3/sendsms/plain?user=viserlab&password=26289099&sender=ViserLab&SMSText={{message}}&GSM={{number}}&type=longSMS', '7202bb', '3264f5', '{\"name\":\"php\"}', 0, 'basic', NULL, '2021-06-08 14:31:39', NULL, '2021-06-08 10:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_align` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: left to right text align, 1: right to left text align',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `icon`, `text_align`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '5f15968db08911595250317.png', 0, 1, '2020-07-06 03:47:55', '2021-03-18 06:45:08'),
(5, 'Hindi', 'hn', NULL, 0, 0, '2020-12-29 02:20:07', '2020-12-29 02:20:16'),
(9, 'Bangla', 'bn', NULL, 0, 0, '2021-03-14 04:37:41', '2021-03-14 04:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', 'home', 'templates.basic.', '[\"how_work\",\"transaction\",\"about\",\"feature\",\"faq\",\"counter\",\"top_investor\",\"testimonial\",\"partners\"]', 1, '2020-07-11 06:23:58', '2021-04-21 23:43:49'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"about\"]', 1, '2020-10-22 01:14:53', '2021-06-08 04:24:18'),
(12, 'blog', 'blogs', 'templates.basic.', '[\"blog\"]', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `referral_logs`
--

CREATE TABLE `referral_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `ref_user_id` int(11) NOT NULL,
  `deposit_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `bonus_value` decimal(18,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `speed` int(11) NOT NULL DEFAULT 0,
  `balance` decimal(15,8) NOT NULL DEFAULT 0.00000000,
  `withdraw` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referral_logs`
--
ALTER TABLE `referral_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `referral_logs`
--
ALTER TABLE `referral_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
