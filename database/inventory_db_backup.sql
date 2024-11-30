-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 10:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(150) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL,
  `img_dir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`id`, `date_time`, `name`, `username`, `password`, `address`, `phone`, `email`, `role`, `status`, `img_dir`) VALUES
(1, '2024-09-22 14:11:13', ' ADMIN', 'Administrator', '$2y$10$wYrKBih/ucHlCpEtkwyJpehhMiM9Dn2ij3eLAkqoXKnmpBIYzwKEC', 'Brgy. Pusok, Cebu City, Cebu', '09123456789', 'admin@gmail.comm', 'ADMIN', 'ACTIVE', '3.png'),
(14, '2024-09-22 13:14:05', 'Andrei-shop', 'Andrei-shop', '$2y$10$rnvNTKn8UHjTWs4mp0z41efNlSAcjRX0qXY6qOc91IF9aRf0RZNd2', '', '09357951246', '', 'ADMIN', 'ACTIVE', 'default.png'),
(15, '2024-09-22 14:22:38', 'Sample', 'Sample', '$2y$10$.akqNjI9KbepitTWRpfu5OO1v3H.BB3OBt5Onc3CSOu2q3O2cvrx.', '', '09321456987', '', 'CASHIER', 'ACTIVE', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brands`
--

CREATE TABLE `tbl_brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `brand` varchar(50) NOT NULL,
  `img_dir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_brands`
--

INSERT INTO `tbl_brands` (`id`, `brand`, `img_dir`) VALUES
(26, 'Happy Noz Onion Stickers', '2024090512285232.jpg'),
(27, 'Brilliant Skin', '2024090513255662.jpg'),
(28, 'NRB', '2024090512303380.jpg'),
(29, 'Beauche Skin Care', '2024090512323801.jpg'),
(30, 'Rosmar Kagayaku', '2024090512334049.jpg'),
(31, 'Sevendays', '2024090512372278.jpg'),
(33, 'Sereese Beauty', '2024090512410891.jpg'),
(34, 'Goree', '2024090512433551.jpg'),
(37, 'COCOBERRY', '2024090512471846.jpg'),
(38, 'Glowrie', '2024090512495658.jpg'),
(39, 'A Bonne', '2024090512521718.jpg'),
(40, 'Beauty Wise', '2024090512544117.jpg'),
(41, 'Skin Reborn', '2024090512560018.jpg'),
(42, 'Dr. Alvin', '2024090512582743.jpg'),
(43, 'BS Essentials', '2024090513372373.jpg'),
(44, 'DW Staying Beautiful', '2024090513423831.jpg'),
(46, 'Sace Lady', '2024090513522721.jpg'),
(48, 'Skin Sensation', '2024090514151057.jpg'),
(49, 'Honest Glow', '2024090514175554.jpg'),
(50, 'So Beauty Soriko', '2024090514380279.jpg'),
(51, 'Luxe Skin', '2024090514391278.jpg'),
(52, 'SkeenCare', '2024090514401647.jpg'),
(53, 'Aishi Tokyo', '2024090514420827.jpg'),
(54, 'Gluta Frozen', '2024090514424517.jpg'),
(55, 'Kat Melendez', '2024090514432736.jpg'),
(56, 'ISHIN', '2024090514440229.jpg'),
(57, 'FDA', '2024090514484779.jpg'),
(58, 'LI-SHOU', '2024090514504457.jpg'),
(59, 'Gluta Lipo', '2024090514512381.jpg'),
(60, 'Ashley Shine', '2024090515093643.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_brand` varchar(50) NOT NULL,
  `product_price` float NOT NULL,
  `subtotal` float NOT NULL,
  `product_qty` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int(10) UNSIGNED NOT NULL,
  `notif_name` varchar(50) NOT NULL,
  `notif_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_id` varchar(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_brand` varchar(30) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `product_qty` int(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `qr_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `date_posted`, `product_id`, `product_img`, `product_brand`, `product_name`, `product_desc`, `product_price`, `product_qty`, `status`, `qr_code`) VALUES
(133, '2024-09-24 07:56:43', 'PRODUCT_I4Nj92X3gAUM', 'default.png', 'Happy Noz Onion Stickers', 'Organic Onion Sticker', 'free nose freshener                ', 350, 1, 'IN STOCK', 'Organic Onion Sticker.png'),
(134, '2024-09-24 07:55:51', 'PRODUCT_waA8yrs64jFo', 'default.png', 'NRB', 'Whitening Deo Cream', 'Effectiveness of an antiperspirant                ', 190, 1, 'IN STOCK', 'Whitening Deo Cream.png'),
(135, '2024-09-24 07:55:26', 'PRODUCT_65eqoSNQy2KB', 'default.png', 'Beauche Skin Care', 'Beauty Soap', 'Cleanse your skin and eliminate pimple                ', 299, 1, 'IN STOCK', 'Beauty Soap.png'),
(136, '2024-09-25 17:28:49', 'PRODUCT_oe9VqsIX72T4', 'default.png', 'Rosmar Kagayaku', 'Bleaching whipped soap', 'Scars remover                ', 32, 5, 'IN STOCK', 'Bleaching whipped soap.png'),
(137, '2024-09-22 17:14:46', 'PRODUCT_JZWx6lUYEuBm', '2024090515144343.jpg', 'Ashley Shine', 'Hair Serum', 'Breakage for a strong and shiny hair', 150, 1, 'IN STOCK', 'Hair Serum.png'),
(138, '2024-09-22 17:17:19', 'PRODUCT_8E2XTPg9nl0s', '2024090515093643.jpg', 'Ashley Shine', 'Niacinamide Pure Serum', 'Quickly penetrate the skin', 350, 1, 'IN STOCK', 'Niacinamide Pure Serum.png'),
(139, '2024-09-25 17:28:27', 'PRODUCT_kw0KWjVSUnRO', 'default.png', 'Gluta Lipo', 'lemon juice drink', 'Remove body toxins                 ', 280, 5, 'IN STOCK', 'lemon juice drink.png'),
(140, '2024-09-25 17:23:07', 'PRODUCT_5dWrQG0EtNxU', 'default.png', 'LI-SHOU', 'Slimming Coffee', 'Reducing inflammation                 ', 349.96, 1, 'IN STOCK', 'Slimming Coffee.png'),
(141, '2024-09-22 17:25:21', 'PRODUCT_pPaQ1l3q4zxv', '2024090514484779.jpg', 'FDA', 'Feminine Wash', 'Reduce visible wrinkles', 150, 1, 'IN STOCK', 'Feminine Wash.png'),
(142, '2024-09-24 07:56:28', 'PRODUCT_WDSphiNwJj6a', 'default.png', 'Glowrie', 'Whitening Body Lotion', 'Enriched with snail extract                ', 280, 1, 'IN STOCK', 'Whitening Body Lotion.png'),
(143, '2024-09-25 17:15:18', 'PRODUCT_diHvQgxB0e1N', 'default.png', 'Glowrie', 'Serum Lotion', 'Protects and whitens without hurting your pocket                ', 185, 4, 'IN STOCK', 'Serum Lotion.png'),
(144, '2024-09-22 17:31:34', 'PRODUCT_isp0ktPTWRnD', '2024090514463292.jpg', 'COCOBERRY', 'Serum Gel Lotion', 'Moisturizes and Smoothens skin', 298, 1, 'IN STOCK', 'Serum Gel Lotion.png'),
(145, '2024-09-22 17:33:26', 'PRODUCT_OuCNRElHfTpA', '2024090514455517.jpg', 'Kat Melendez', 'Nikocee', 'Anti-aging', 250, 1, 'IN STOCK', 'Nikocee.png'),
(146, '2024-09-22 17:37:21', 'PRODUCT_t4wy5dnmvaKD', '2024090514451255.jpg', 'Beauty Wise', ' Capsule Glutathione ', 'Promote a youthful appearance', 349, 1, 'IN STOCK', ' Capsule Glutathione .png'),
(147, '2024-09-22 17:38:59', 'PRODUCT_ByGguVlAjWtP', '2024090514440229.jpg', 'ISHIN', 'Food Supplement', 'Help protect skin cells', 350, 1, 'IN STOCK', 'Food Supplement.png'),
(148, '2024-09-22 17:40:30', 'PRODUCT_dtQ2gUoLDNBi', '2024090514432736.jpg', 'Kat Melendez', 'Nekothione', 'Moisture boost in every pill', 599, 1, 'IN STOCK', 'Nekothione.png'),
(149, '2024-09-23 15:39:23', 'PRODUCT_q7HXyB4jULM6', '2024090514424517.jpg', 'Freshies Collagen', 'Frozen Collagen Capsule', 'Gives nutrients to the skin', 349, 1, 'IN STOCK', 'Frozen Collagen Capsule.png'),
(150, '2024-09-23 15:42:50', 'PRODUCT_XG0qczi3DbO5', '2024090514420827.jpg', 'Aishi Tokyo', 'Glutathione', 'Promote intense lightening without harming the skin', 570, 1, 'IN STOCK', 'Glutathione.png'),
(151, '2024-09-25 17:14:35', 'PRODUCT_Q3b0MOeV8Iqs', 'default.png', 'Sevendays', 'Power soap', 'Improve dark spot                ', 40, 6, 'IN STOCK', 'Power soap.png'),
(152, '2024-09-25 17:14:10', 'PRODUCT_ERmcXBVNlaeH', 'default.png', 'COCOBERRY', 'Body soap', 'A Premium soap                ', 50, 5, 'IN STOCK', 'Body soap.png'),
(153, '2024-09-25 17:27:40', 'PRODUCT_gnVjI9e3C4TM', 'default.png', 'Rosmar Kagayaku', 'Body soap', 'Lighten your skin                                ', 50, 5, 'IN STOCK', 'Body soap.png'),
(154, '2024-09-25 17:13:45', 'PRODUCT_C634UqJsEHgK', 'default.png', 'A Bonne', 'A Bonne Spa MILK Salt', 'Provide Nourishment                ', 130, 2, 'IN STOCK', 'A Bonne Spa MILK Salt.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role`) VALUES
(1, 'ADMIN'),
(2, 'CASHIER');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales`
--

CREATE TABLE `tbl_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `date_purchased` varchar(20) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `customer` varchar(50) NOT NULL,
  `total` float NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_sales`
--

INSERT INTO `tbl_sales` (`id`, `date_purchased`, `transaction_id`, `customer`, `total`, `status`) VALUES
(2, '2024/09/24 03:31:13', 'RZ5rqF8zmCQUkBA', 'novemae', 839, 'COMPLETED'),
(3, '2024/09/24 03:33:40', 'dMelg83ByuzsAvj', 'mikha', 280, 'COMPLETED'),
(4, '2024/09/24 03:51:53', 'WqbaOiD7mfM3y9Y', 'joana', 560, 'COMPLETED'),
(5, '2024/09/26 01:22:45', 'R6GoMvVCBJXx9dQ', 'colet', 749.92, 'COMPLETED');


-- --------------------------------------------------------

--
-- Table structure for table `tbl_system_info`
--

CREATE TABLE `tbl_system_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `system_title` varchar(50) NOT NULL,
  `system_description` varchar(1000) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `open_hours` varchar(100) NOT NULL,
  `system_icon` varchar(255) NOT NULL,
  `system_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_system_info`
--

INSERT INTO `tbl_system_info` (`id`, `system_title`, `system_description`, `address`, `phone`, `email`, `open_hours`, `system_icon`, `system_logo`) VALUES
(1, 'Andrei’s Beauty and Wellness Products', 'We sell .Beauty and Wellness Products. Come to our shop to explore more products.', 'Avancena St. Pob 1 Beside Tambunting and NIG Marketing,  Sagay City, Negros Occidental', '09123456789', 'admin@gmail.com', 'Monday to Friday 8:00 AM ~ 5:00 PM ', 'log-2.png', 'log-2.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction_ref`
--

CREATE TABLE `tbl_transaction_ref` (
  `id` int(10) UNSIGNED NOT NULL,
  `date_purchased` varchar(20) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `product_brand` varchar(50) NOT NULL,
  `product_price` float NOT NULL,
  `subtotal` float NOT NULL,
  `product_qty` int(255) NOT NULL,
  `customer` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_transaction_ref`
--

INSERT INTO `tbl_transaction_ref` (`id`, `date_purchased`, `transaction_id`, `qr_code`, `product_img`, `product_id`, `product_name`, `product_brand`, `product_price`, `subtotal`, `product_qty`, `customer`, `status`) VALUES
(35, '2024/09/24 03:31:13', 'RZ5rqF8zmCQUkBA', 'Beauty Soap.png', '2024090512323801.jpg', 'PRODUCT_65eqoSNQy2KB', 'Beauty Soap', 'Beauche Skin Care', 299, 299, 1, 'novemae', 'COMPLETED'),
(36, '2024/09/24 03:31:13', 'RZ5rqF8zmCQUkBA', 'Whitening Deo Cream.png', '2024090512303380.jpg', 'PRODUCT_waA8yrs64jFo', 'Whitening Deo Cream', 'NRB', 190, 190, 1, 'novemae', 'COMPLETED'),
(37, '2024/09/24 03:31:13', 'RZ5rqF8zmCQUkBA', 'Organic Onion Sticker.png', '2024090512285232.jpg', 'PRODUCT_I4Nj92X3gAUM', 'Organic Onion Sticker', 'Happy Noz Onion Stickers', 350, 350, 1, 'novemae', 'COMPLETED'),
(38, '2024/09/24 03:33:40', 'dMelg83ByuzsAvj', 'Whitening Body Lotion.png', '2024090514481133.jpg', 'PRODUCT_WDSphiNwJj6a', 'Whitening Body Lotion', 'Glowrie', 280, 280, 1, 'mikha', 'COMPLETED'),
(39, '2024/09/24 03:51:53', 'WqbaOiD7mfM3y9Y', 'lemon juice drink.png', '2024090514512381.jpg', 'PRODUCT_kw0KWjVSUnRO', 'lemon juice drink', 'Gluta Lipo', 280, 280, 1, 'joana', 'COMPLETED'),
(40, '2024/09/24 03:51:53', 'WqbaOiD7mfM3y9Y', 'lemon juice drink.png', '2024090514512381.jpg', 'PRODUCT_kw0KWjVSUnRO', 'lemon juice drink', 'Gluta Lipo', 280, 280, 1, 'joana', 'COMPLETED'),
(41, '2024/09/24 03:51:53', 'WqbaOiD7mfM3y9Y', '', '', '', '', '', 0, 0, 1, 'joana', 'COMPLETED'),
(42, '2024/09/24 03:51:53', 'WqbaOiD7mfM3y9Y', '', '', '', '', '', 0, 0, 1, 'joana', 'COMPLETED'),
(43, '2024/09/24 03:51:53', 'WqbaOiD7mfM3y9Y', '', '', '', '', '', 0, 0, 1, 'joana', 'COMPLETED'),
(44, '2024/09/26 01:22:45', 'R6GoMvVCBJXx9dQ', 'Body soap.png', 'default.png', 'PRODUCT_gnVjI9e3C4TM', 'Body soap', 'Rosmar Kagayaku', 50, 50, 1, 'colet', 'COMPLETED'),
(45, '2024/09/26 01:22:45', 'R6GoMvVCBJXx9dQ', 'Slimming Coffee.png', 'default.png', 'PRODUCT_5dWrQG0EtNxU', 'Slimming Coffee', 'LI-SHOU', 349.96, 349.96, 1, 'colet', 'COMPLETED'),
(46, '2024/09/26 01:22:45', 'R6GoMvVCBJXx9dQ', 'Slimming Coffee.png', 'default.png', 'PRODUCT_5dWrQG0EtNxU', 'Slimming Coffee', 'LI-SHOU', 349.96, 349.96, 1, 'colet', 'COMPLETED');


--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_system_info`
--
ALTER TABLE `tbl_system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction_ref`
--
ALTER TABLE `tbl_transaction_ref`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_system_info`
--
ALTER TABLE `tbl_system_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_transaction_ref`
--
ALTER TABLE `tbl_transaction_ref`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
