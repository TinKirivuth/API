-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2019 at 03:26 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kc_restful_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Business Loan', 'SME Loan product is diversified to provide to existing small and medium enterprises funds (commercial, manufacturing, services, agriculture) to expand their existing business by financing working capital and/or investment, or to diversify their activities by creating a new business.', '2019-09-15 20:08:42'),
(2, 'Personal Loan', 'Personal Loan provides individuals Salary Earner, micro and small entrepreneurs and farmer who have regular income between USD500 to USD1,000 per month borrow for personal financial need. Any salary earning individual can get loan amount up to 5 times of monthly salary (net salary after tax) for 24 months term.', '2019-09-15 20:11:02'),
(3, 'Comercial Loan', 'SME Loan product is diversified to provide to existing small and medium enterprises funds (commercial, manufacturing, services, agriculture) to expand their existing business by financing working capital and/or investment, or to diversify their activities by creating a new business.', '2019-09-15 20:19:34'),
(4, 'Condo Loan', 'Condo Loan is another product to provide individuals Salary Earner, micro and small entrepreneurs as well as foreigner/investor who have regular income between USD2,000 to USD5,000 per month to purchase condo unit(s).', '2019-09-15 20:23:58'),
(5, 'Housing Loan', 'Housing Loan provides individuals Salary Earner, micro and small entrepreneurs and farmer who have regular income between USD500 to USD2,000 per month at rural, semi-urban and suburb to buy or build new house on their ownership land.', '2019-09-15 20:28:26'),
(6, 'Consumer Loan', 'Consumption Loan is for individuals intending to purchase household equipment or personal items, such as a vehicle, a computer, some furniture, a refrigerator, a television, a generator, etc. They can also use this loan to pay for tuition fees, university and post-graduate studies to enhance family''s member capacity.', '2019-09-15 20:37:35'),
(7, 'Testing Category', 'For testing to post data into api with first app using completionhadler', '2019-10-19 16:12:05'),
(8, 'Testing Category More', 'For testing to post data into api with first app using completionhadler', '2019-10-19 16:12:58'),
(9, 'test', 'Testing', '2019-10-19 16:18:46'),
(10, 'SMALL LOAN', 'TESTING REFRESHING PAGE', '2019-10-26 19:36:48'),
(11, 'API V3', 'TEST ING API V3', '2019-10-26 19:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_about`
--

CREATE TABLE IF NOT EXISTS `tbl_about` (
  `id` bigint(20) NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_about`
--

INSERT INTO `tbl_about` (`id`, `name`, `description`, `created_at`, `status`) VALUES
(1, 'Company Profile', 'Khmer Capital Microfinance Institution PLC,', '2019-10-03 10:43:27', 1),
(2, 'Mission', 'Cambodia with the Ministry', '2019-10-03 10:43:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_about_items`
--

CREATE TABLE IF NOT EXISTS `tbl_about_items` (
  `id` bigint(20) NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `img` text COLLATE utf8_unicode_ci,
  `about_id` bigint(20) NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE IF NOT EXISTS `tbl_products` (
  `id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `icon` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_public` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `name`, `title`, `description`, `icon`, `category_id`, `created_at`, `is_public`) VALUES
(5, 'SDFSFSDF', 'SDFSDFSFDSFSFSF', 'SDFSFSDFS SFD SFSS SFDSDFSDF', 'EERR', 1, '2019-09-16 00:00:00', 1),
(6, 'HHG', 'GHF', '<p> </p><p>\nSME Loan product is diversified to provide to existing small and medium enterprises funds (commercial, manufacturing, services,\nagriculture) to expand their existing business by financing working capital and/or investment, or to diversify their activities by creating a new business. \n</p>\n<h3 style="margin-top:0cm;margin-right:0cm;margin-bottom:6.0pt;margin-left:0cm;text-indent:0cm;line-height:150%;mso-pagination:none;mso-layout-grid-align:none;text-autospace:none">\n	Benefit \n</h3><p>\nSME Loan product is diversified to provide to existing small and medium enterprises funds (commercial, manufacturing, services,\nagriculture) to expand their existing business by financing working capital and/or investment, or to diversify their activities by creating a new business. \n</p>\n<h3 style="margin-top:0cm;margin-right:0cm;margin-bottom:6.0pt;margin-left:0cm;text-indent:0cm;line-height:150%;mso-pagination:none;mso-layout-grid-align:none;text-autospace:none">\n	Benefit \n</h3>', '1CVCV', 2, '2019-09-16 00:00:00', 1),
(9, 'Testing', 'Testing post', 'For testing Post data', 'Testing.png', 1, '2019-09-17 22:05:18', 1),
(10, 'Testing', 'Testing post', 'For testing Post data', 'Testing.png', 1, '2019-09-17 22:05:35', 1),
(11, 'Testing', 'Testing post', 'For testing Post data', 'Testing.png', 1, '2019-09-17 22:08:27', 1),
(18, 'TIN KIRIVUTH', 'Testing with tin kirivut', '<table class="MsoNormalTable" width="949" cellspacing="0" cellpadding="0" border="0">\n<tbody>\n	<tr>\n		<td style="border:none;border-bottom:solid #000000 1.0pt;\n			  mso-border-bottom-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-bottom-alt:solid #000000 .5pt;\n			  mso-border-bottom-themecolor:accent6;padding:0in 2.4pt 0in 2.4pt" width="3">\n				<p class="MsoNormal" style="margin-top:4.0pt;margin-right:0in;\n					  margin-bottom:4.0pt;margin-left:0in;text-align:center;text-indent:0in;\n					  line-height:120%;mso-pagination:none;mso-layout-grid-align:none;text-autospace:\n					  none" align="center">\n						<span style="font-size:13.0pt;line-height:150%;font-family:" arial","sans-serif";="" mso-fareast-font-family:"times="" new="" roman""="">\n							1\n					    </span>\n				</p>	  \n			</td>\n		  \n		<td style="width:166.5pt;border:none;border-bottom:solid #000000 1.0pt;\n			  mso-border-bottom-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-bottom-alt:solid #000000 .5pt;\n			  mso-border-bottom-themecolor:accent6;padding:0in 5.4pt 0in 5.4pt" width="606">\n					<p class="MsoNormal" style="margin: 4pt 0in; text-indent: 0in; line-height: 180%;" align="left">\n						<span style="font-size:13.0pt;line-height:180%;font-family:" arial","sans-serif";="" mso-fareast-font-family:"times="" new="" roman""="">\n							Copy of ID card(s), family book, collateral property title deed\n							<o:p></o:p>\n						</span>\n					</p>\n		</td>\n	</tr>\n	<tr>\n		<td style="border:none;border-bottom:solid #000000 1.0pt;\n			  mso-border-bottom-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-bottom-alt:solid #000000 .5pt;\n			  mso-border-bottom-themecolor:accent6;padding:0in 2.4pt 0in 2.4pt" width="3">\n					<p class="MsoNormal" style="margin-top:4.0pt;margin-right:0in;\n						  margin-bottom:4.0pt;margin-left:0in;text-align:center;text-indent:0in;\n						  line-height:120%;mso-pagination:none;mso-layout-grid-align:none;text-autospace:\n						  none" align="center">\n						<span style="font-size:13.0pt;line-height:150%;font-family:" arial","sans-serif";="" mso-fareast-font-family:"times="" new="" roman""="">\n							2\n					    </span>\n					</p>\n		</td>\n		<td style="width:166.5pt;border:none;border-bottom:solid #000000 1.0pt;\n			  mso-border-bottom-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-bottom-alt:solid #000000 .5pt;\n			  mso-border-bottom-themecolor:accent6;padding:0in 5.4pt 0in 5.4pt" width="606">\n			<p class="MsoNormal" style="margin: 4pt 0in; text-indent: 0in; line-height: 180%;" align="left">\n				<span style="font-size:13.0pt;line-height:180%;font-family:" arial","sans-serif";="" mso-fareast-font-family:"times="" new="" roman""="">\n					Proof of business: patent, certificate, permission letter, other related documents\n					<o:p></o:p>\n				</span>\n			</p>\n		</td>\n	</tr>\n	<tr>\n		<td style="border:none;border-bottom:solid #000000 1.0pt;\n			  mso-border-bottom-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-bottom-alt:solid #000000 .5pt;\n			  mso-border-bottom-themecolor:accent6;padding:0in 2.4pt 0in 2.4pt" width="3">\n					<p class="MsoNormal" style="margin-top:4.0pt;margin-right:0in;\n						  margin-bottom:4.0pt;margin-left:0in;text-align:center;text-indent:0in;\n						  line-height:120%;mso-pagination:none;mso-layout-grid-align:none;text-autospace:\n						  none" align="center">\n						<span style="font-size:13.0pt;line-height:150%;font-family:" arial","sans-serif";="" mso-fareast-font-family:"times="" new="" roman""="">\n							3\n					    </span>\n					</p>\n		</td>\n		<td style="width:166.5pt;border:none;border-bottom:solid #000000 1.0pt;\n			  mso-border-bottom-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-top-alt:solid #000000 .5pt;\n			  mso-border-top-themecolor:accent6;mso-border-bottom-alt:solid #000000 .5pt;\n			  mso-border-bottom-themecolor:accent6;padding:0in 5.4pt 0in 5.4pt" width="606">\n			<p class="MsoNormal" style="margin: 4pt 0in; text-indent: 0in; line-height: 180%;" align="left">\n				<span style="font-size:13.0pt;line-height:180%;font-family:" arial","sans-serif";="" mso-fareast-font-family:"times="" new="" roman""="">\n					Financial report(One year).\n					<o:p></o:p>\n				</span>\n			</p>\n		</td>\n	</tr>\n   </tbody>\n</table> \n <br>\n <p class="MsoNormal" style="margin: 4pt 0in; text-indent: 0in;">\n *** Terms and conditions are subject to change at the KC MFI sole discretion without prior notice to customer\n </p>', 'logo.png', 2, '2019-09-22 19:16:29', 1),
(19, 'TIN KIRIVUTH1', 'Testing with tin kirivut1', 'For testing Post data tin kirivuth1', 'logo.png1', 3, '2019-09-22 19:18:54', 1),
(20, 'TIN KIRIVUTH2', 'Testing with tin kirivut3', 'For testing Post data tin kirivuth4', 'logo1.png', 5, '2019-09-22 19:20:29', 1),
(21, 'TIN KIRIVUTH2', 'Testing with tin kirivut3', 'For testing Post data tin kirivuth4', 'logo1.png', 5, '2019-09-22 19:27:57', 1),
(22, 'TIN KIRIVUTH2', 'Testing with tin kirivut3', 'For testing Post data tin kirivuth4', 'logo1.png', 5, '2019-09-22 19:33:43', 1),
(23, 'TIN KIRIVUTH2', 'Testing with tin kirivut3', 'For testing Post data tin kirivuth4', 'logo1.png', 5, '2019-09-22 19:35:34', 1),
(24, 'TIN KIRIVUTH2', 'Testing with tin kirivut3', 'For testing Post data tin kirivuth4', 'logo1.png', 5, '2019-09-22 19:36:06', 1),
(25, 'TIN KIRIVUTH2', 'Testing with tin kirivut3', 'For testing Post data tin kirivuth4', 'logo1.png', 5, '2019-09-22 19:37:26', 1),
(26, 'TIN KIRIVUTH2', 'Testing with tin kirivut3', 'For testing Post data tin kirivuth4', 'logo1.png', 5, '2019-09-22 19:38:35', 1),
(27, 'TIN KIRIVUTH2', 'Testing with tin kirivut3', 'For testing Post data tin kirivuth4', 'logo1.png', 5, '2019-09-22 19:40:17', 1),
(28, 'BBU', 'BUILD BRIGHT UNIVERSITY', '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">', 'BBU.png', 2, '2019-09-22 19:41:37', 1),
(32, 'BBU1', 'BUILD BRIGHT UNIVERSITY1', 'test', 'BBU1.png', 1, '2019-09-22 20:32:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `password`, `type`, `status`) VALUES
(1, 'vuth', '$2y$10$7QwMhXRTEpUfqeZLI0XY/ONOqHf2o39Ezc6mIXVHHAwLaDJBczPNu', 1, 1),
(2, 'kirivuth@khmercapital.com.kh', '$2y$10$L/9nHG43WyEqXPx0qYOZ5eEZfvIGh1NVaekLN.eTEUYokraBRfp8e', 1, 1),
(3, 'admin', '$2y$10$e/XAdivcQ86l/Ek2KeHoGepoPyiRnX1Mzf.4NqDbE.tiUTDb0zPym', 1, 1),
(4, 'test', '$2y$10$eiFViloXbp.EE6nrlTLSReX.mTcMexjdFze8SvmUIYKJxWBMce1OG', 1, 1),
(5, 'demo', '$2y$10$qrXldva1.nt7Kzn94.CWg.0FSfQcLmQl3X2pR8C3lI2Mfdy5uavLO', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_about`
--
ALTER TABLE `tbl_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_about_items`
--
ALTER TABLE `tbl_about_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_about`
--
ALTER TABLE `tbl_about`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_about_items`
--
ALTER TABLE `tbl_about_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
