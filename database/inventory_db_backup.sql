-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 09:38 AM
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
-- Table structure for table `in_stock`
--

CREATE TABLE `in_stock` (
  `id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `in_stock`
--

INSERT INTO `in_stock` (`id`, `date_added`, `product_id`, `batch_number`, `product_name`, `quantity`) VALUES
(57, '2024-12-18 16:21:36', '', 'BATCH_2GY31ofs', 'Vitruvi ', 100),
(58, '2024-12-18 16:22:01', '', 'BATCH_EfLVNuei', 'Radiant Glow Serum', 100),
(59, '2024-12-18 16:22:17', 'PRODUCT_zFOhGWtorlPS', 'BATCH_kJI0xGgi', 'Vitruvi ', 100),
(60, '2024-12-18 16:24:30', 'PRODUCT_MdgxcW0uNU8v', 'BATCH_oHZNyekx', 'Power soap', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `out_stock`
--

CREATE TABLE `out_stock` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_sold` datetime NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `reason` enum('sold','expired','damage','return') DEFAULT 'sold'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `out_stock`
--

INSERT INTO `out_stock` (`id`, `product_name`, `quantity`, `date_sold`, `product_id`, `reason`) VALUES
(25, 'Power soap', 200, '2024-12-18 16:25:20', '0', 'expired'),
(26, 'Power soap', 500, '2024-12-18 16:26:01', 'PRODUCT_MdgxcW0uNU8v', 'expired'),
(27, 'Vitruvi ', 10, '2024-12-18 16:26:12', 'PRODUCT_zFOhGWtorlPS', 'damage'),
(28, 'Radiant Glow Serum', 50, '2024-12-18 16:26:21', 'PRODUCT_Bynw3OGCd0pi', 'return');

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

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`id`, `qr_code`, `product_img`, `product_id`, `product_name`, `product_brand`, `product_price`, `subtotal`, `product_qty`) VALUES
(78, 'Vitruvi .png', 'default.png', 'PRODUCT_bzrtGEOs2nXR', 'Vitruvi ', 'Wardiere Beauty', 35, 35, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int(10) UNSIGNED NOT NULL,
  `notif_name` varchar(50) NOT NULL,
  `notif_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`id`, `notif_name`, `notif_desc`) VALUES
(59, 'PRODUCT LOW ON STOCKS!', 'The product Radiant Glow Serum has only 9 pcs remaining. Please restock soon.');

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
  `exp_date` date NOT NULL,
  `product_price` float NOT NULL,
  `in_sale` decimal(10,2) DEFAULT NULL,
  `product_qty` int(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `qr_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `date_posted`, `product_id`, `product_img`, `product_brand`, `product_name`, `exp_date`, `product_price`, `in_sale`, `product_qty`, `status`, `qr_code`) VALUES
(147, '2024-12-18 08:26:12', 'PRODUCT_zFOhGWtorlPS', 'default.png', 'Wardiere Beauty', 'Vitruvi ', '2025-01-11', 200, NULL, 190, 'IN STOCK', 'Vitruvi .png'),
(149, '2024-12-18 08:26:21', 'PRODUCT_Bynw3OGCd0pi', 'default.png', 'Radiance Glow', 'Radiant Glow Serum', '2024-12-28', 50, NULL, 50, 'IN STOCK', 'Radiant Glow Serum.png'),
(150, '2024-12-18 08:26:01', 'PRODUCT_MdgxcW0uNU8v', 'default.png', 'Purely PH', 'Power soap', '2024-12-03', 200, NULL, 300, 'IN STOCK', 'Power soap.png');

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
(7, '2024/11/29 05:46:26', 'KS2lE5XwxJ7p1D9', 'Vi', 2500, 'COMPLETED'),
(8, '2024/11/30 12:40:04', 'KJFdqkiNQphrnf1', 'test', 560, 'COMPLETED'),
(9, '2024/11/30 01:44:42', 'oFA3mEGX9Nxuk2f', 'Gian', 840, 'COMPLETED'),
(10, '2024/12/02 12:07:48', 'Nce394HoyFdLBws', 'm', 277200, 'COMPLETED'),
(11, '2024/12/02 12:22:21', 'P7ATn4pYUbr1Cq3', 'cv', 17185, 'COMPLETED'),
(12, '2024/12/02 12:35:05', 'uaAdytBOXiHVTPC', 'v', 2835, 'IN STOCK'),
(13, '2024/12/02 12:35:33', 'bGpgA19tdcMRF2L', 'nm', 350, 'LOW STOCK');

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
(43, '2024/11/29 05:46:26', 'KS2lE5XwxJ7p1D9', 'Vitruvi .png', 'default.png', 'PRODUCT_bzrtGEOs2nXR', 'Vitruvi ', 'Wardiere Beauty', 50, 500, 10, 'Vi', 'COMPLETED'),
(44, '2024/11/29 05:46:26', 'KS2lE5XwxJ7p1D9', 'Radiant Glow Serum.png', 'default.png', 'PRODUCT_PGDL5oRK0zyr', 'Radiant Glow Serum', 'Purely PH', 200, 2000, 10, 'Vi', 'COMPLETED'),
(45, '2024/11/30 12:40:04', 'KJFdqkiNQphrnf1', 'Radiant Glow Serum.png', 'default.png', 'PRODUCT_PGDL5oRK0zyr', ' Glow Serum', 'Bella Skin', 280, 560, 2, 'test', 'COMPLETED'),
(46, '2024/11/30 01:44:42', 'oFA3mEGX9Nxuk2f', 'Radiant Glow Serum.png', 'default.png', 'PRODUCT_PGDL5oRK0zyr', ' Glow Serum', 'Bella Skin', 280, 840, 3, 'Gian', 'COMPLETED'),
(47, '2024/12/02 12:07:48', 'Nce394HoyFdLBws', 'Radiant Glow Serum.png', 'default.png', 'PRODUCT_PGDL5oRK0zyr', ' Glow Serum', 'Bella Skin', 280, 277200, 990, 'm', 'COMPLETED'),
(48, '2024/12/02 12:22:21', 'P7ATn4pYUbr1Cq3', 'Vitruvi .png', 'default.png', 'PRODUCT_bzrtGEOs2nXR', 'Vitruvi ', 'Wardiere Beauty', 35, 17185, 491, 'cv', 'COMPLETED'),
(49, '2024/12/02 12:35:05', 'uaAdytBOXiHVTPC', 'Vitruvi .png', 'default.png', 'PRODUCT_bzrtGEOs2nXR', 'Vitruvi ', 'Wardiere Beauty', 35, 2835, 81, 'v', 'COMPLETED'),
(50, '2024/12/02 12:35:33', 'bGpgA19tdcMRF2L', 'Vitruvi .png', 'default.png', 'PRODUCT_bzrtGEOs2nXR', 'Vitruvi ', 'Wardiere Beauty', 35, 350, 10, 'nm', 'COMPLETED');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `in_stock`
--
ALTER TABLE `in_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `out_stock`
--
ALTER TABLE `out_stock`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `in_stock`
--
ALTER TABLE `in_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `out_stock`
--
ALTER TABLE `out_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_system_info`
--
ALTER TABLE `tbl_system_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_transaction_ref`
--
ALTER TABLE `tbl_transaction_ref`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
