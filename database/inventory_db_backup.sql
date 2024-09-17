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
(1, '2024-09-14 13:11:41', 'ADMIN', 'admin', '$2y$10$SiixH0RkHfGao32m4VN8TePXYFIaiefnmNM7Pwds6z.AFpNVHw63e', 'Brgy. Pusok, Cebu City, Cebu', '09123456789', 'admin@gmail.comm', 'ADMIN', 'ACTIVE', '3.png'),
(12, '2024-09-02 19:06:37', 'Sample', 'Sample', '$2y$10$w/tBh7IHRpIgSfy9Q2jSfO8rKtDfCpz9GQM0B/yym0qErrWNMq9tW', '', '9326578124', '', 'CASHIER', 'ACTIVE', 'default.png');

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
(15, 'Wardiere Beauty', '1.png'),
(16, 'Radiance Glow', '2.png'),
(17, 'Beauty Cosmetics', '4.png'),
(18, 'Purely PH', '3.png'),
(19, 'Bella Skin', '5.png'),
(22, 'Borcel SKin Care', '7.png'),
(23, 'Luminous Beauty', '8.png');

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
(128, '2024-09-17 05:48:52', 'PRODUCT_9KbhTHA2Ovok', 'default.png', 'Wardiere Beauty', 'Mogo Bar', 'Just a Bar                                ', 50, 1000, 'IN STOCK', 'Mogo Bar.png'),
(129, '2024-09-17 06:31:26', 'PRODUCT_6y7Ozw3IZmtl', 'default.png', 'Bella Skin', 'Real Time Test', 'Real Time Time                                     ', 500, 500, 'IN STOCK', 'Test.png'),
(130, '2024-09-17 05:49:09', 'PRODUCT_dKVlaGD0mYso', 'default.png', 'Wardiere Beauty', 'Tablet', 'Tablet                                ', 550, 1000, 'IN STOCK', 'Tablet.png'),
(131, '2024-09-17 05:49:27', 'PRODUCT_L2s8NQBFS9wE', 'default.png', 'Wardiere Beauty', 'Cream', 'Cream                                 ', 210, 1000, 'IN STOCK', 'Cream.png'),
(132, '2024-09-17 05:41:49', 'PRODUCT_n9NtMqXiLyp4', 'default.png', 'Wardiere Beauty', 'Perfume', 'Oil based         ', 150, 1000, 'IN STOCK', 'p.png');

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
