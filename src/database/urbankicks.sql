-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2025 at 05:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urbankicks`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(1, 'admin', 'CAC29D7A34687EB14B37068EE4708E7B', 'admin@mail.com', '', '2022-05-27 13:21:52'),
(2, 'kush', 'kush@admin', 'admin@gmail.com', '', '2024-02-14 11:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`rs_id`, `title`, `image`, `date`) VALUES
(1, 'Adidas', 'brand-1.jpg', '2024-02-12 21:50:14'),
(2, 'Nike', 'brand-2.jpg', '2024-02-12 21:50:14'),
(3, 'Puma', 'Brand-5.jpg', '2024-02-12 21:50:56'),
(4, 'Reebok', '65cc9df40c642.png', '2024-02-14 11:03:16'),
(5, 'GUCCI', 'brand-3.jpg', '2024-03-03 08:33:26'),
(6, 'Asian', 'brand-6.jpg', '2024-03-04 10:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `rs_id`, `title`, `slogan`, `price`, `img`) VALUES
(1, 1, 'Adidas', 'Adidas green & white colored shoes', 5099.00, '65ca9feacf5c7.jpg'),
(2, 1, 'Adidas', 'Adidas shoes', 4599.00, '65ca9fb40cf72.jpg'),
(3, 1, 'Adidas', 'Adidas blue & white colored shoes', 9999.00, '65ca9f7851ae2.jpg'),
(4, 1, 'Adidas', 'Adidas off-white colored shoes', 5599.00, '65ca9f4629646.jpg'),
(9, 2, 'Nike', 'Nike pink colored shoes', 7999.00, '65ca9ec491b29.jpg'),
(10, 2, 'Nike', 'Nike yellow, black & white colored shoes', 6059.00, '65ca9e87aafd3.jpg'),
(11, 2, 'NIke', 'Nike black/grey colored shoes', 8050.00, '65ca9e2e51bd0.jpg'),
(12, 2, 'Nike', 'Nike red, white and black colored shoes', 7095.00, '65ca9df0562b7.jpg'),
(13, 3, 'Puma', 'Puma black colored shoes', 8000.00, '65caa2a16cb52.png'),
(14, 3, 'Puma', 'Puma light colored shoes', 6099.00, '65caa252427d8.png'),
(15, 3, 'Puma', 'Puma blue colored shoes', 5000.00, '65caa1ea19a51.png'),
(16, 3, 'Puma', 'Puma White shoes', 2500.00, '65caa1267ee19.png'),
(17, 4, 'Reebok', 'Reebok orange & black colored shoes', 8050.00, '65d1158342e16.png'),
(18, 4, 'Reebok', 'Reebook unisex shoes', 8999.00, '65d115bb43297.png'),
(19, 4, 'Reebok', 'Reebook blue colored shoes', 9999.00, '65d115f03be50.png'),
(20, 4, 'Reebok', 'Reebook white colored shoes', 10900.00, '65d11611d7d3d.png'),
(27, 5, 'Gucci', 'Gucci white and Brown Colored Shoes', 9999.00, '65e598260e707.png'),
(28, 5, 'GUCCI', 'Gucci Black colored shoes', 11000.00, '65e598b7f0ccb.png'),
(29, 5, 'GUCCI', 'GUCCI Screener Sneaker in black and gray color', 50000.00, '65e59950af48f.png'),
(30, 5, 'GUCCI', 'Black Loafer', 44900.00, '65e59a65db9b7.png'),
(31, 6, 'Asian', 'Asian blue colored Shoe', 1699.00, '65e5b9bdda082.png'),
(32, 6, 'Asian', 'Asian wings sports shoes', 1980.00, '65e5ba703ec78.png'),
(33, 6, 'Asian', 'Asian Twinspring Running Shoes.', 1499.00, '65e5bb21d2c70.png'),
(34, 6, 'Asian', 'Asian Disco Sneaker', 2499.00, '65e5bb9788d7a.png'),
(35, 6, 'Asian', 'Asian Urban Sneaker', 1899.00, '65e5bc261981c.png'),
(36, 3, 'Puma', 'Puma Voyage NITROâ„¢ 2 shoes', 10999.00, '65e5bcf484824.png'),
(37, 1, 'Adidas', 'Ultraboost light shoes', 18999.00, '65e5bdb718673.png'),
(38, 2, 'Nike', 'NIke Go FlyEase', 11850.00, '65e5be9347aef.png'),
(39, 4, 'Reebok', 'Rebook Unisex Running shoes', 10619.00, '65e5bf63c5391.png'),
(40, 5, 'GUCCI', 'GUCCI GG Rython Sneaker', 75000.00, '65e5c14090a86.png');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(1, 2, 'in process', 'none', '2022-05-01 05:17:49'),
(2, 3, 'in process', 'none', '2022-05-27 11:01:30'),
(3, 2, 'closed', 'thank you for your order!', '2022-05-27 11:11:41'),
(4, 3, 'closed', 'none', '2022-05-27 11:42:35'),
(5, 4, 'in process', 'none', '2022-05-27 11:42:55'),
(6, 1, 'rejected', 'none', '2022-05-27 11:43:26'),
(7, 7, 'in process', 'none', '2022-05-27 13:03:24'),
(8, 8, 'in process', 'none', '2022-05-27 13:03:38'),
(9, 9, 'rejected', 'thank you', '2022-05-27 13:03:53'),
(10, 7, 'closed', 'thank you for your ordering with us', '2022-05-27 13:04:33'),
(11, 8, 'closed', 'thanks ', '2022-05-27 13:05:24'),
(12, 5, 'closed', 'none', '2022-05-27 13:18:03'),
(13, 10, 'closed', 'done', '2024-02-12 20:41:36'),
(14, 10, 'in process', 'on the way', '2024-02-12 20:42:25'),
(15, 2, 'closed', 'null', '2024-02-13 07:05:54'),
(16, 5, 'rejected', 'out of stock', '2024-02-17 12:35:31'),
(17, 7, 'closed', 'doone', '2024-02-17 17:56:09'),
(18, 8, 'closed', 'done', '2024-02-18 08:40:28'),
(19, 6, 'closed', 'Done', '2024-02-18 09:21:20'),
(20, 4, 'closed', 'done\r\n', '2024-03-01 09:09:18'),
(21, 5, 'closed', 'done', '2024-03-01 09:09:46'),
(22, 8, 'closed', 'Delivered\r\n', '2024-03-01 10:02:02'),
(23, 9, 'in process', 'Wait for the order', '2024-03-01 10:02:25'),
(24, 14, 'rejected', 'Out Of Stock', '2024-03-03 07:49:08'),
(25, 13, 'closed', 'done', '2024-03-07 17:33:23'),
(26, 55, 'closed', 'done', '2024-04-05 09:06:31'),
(27, 57, 'closed', 'thank you for order\r\n', '2024-04-05 10:46:13'),
(28, 77, 'closed', 'thank you for order', '2024-04-05 15:59:37'),
(29, 79, 'closed', 'thank you', '2024-04-06 03:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `shoe_size`
--

CREATE TABLE `shoe_size` (
  `size_id` int(255) NOT NULL,
  `size` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `shoe_size`
--

INSERT INTO `shoe_size` (`size_id`, `size`) VALUES
(1, '7'),
(2, '8'),
(3, '9'),
(4, '10'),
(5, '11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`, `status`, `date`, `otp`, `otp_expiry`) VALUES
(30, 'Rajan', 'Rajan', 'Vaishnav', 'rajan1278@gmail.com', '9725888640', '$2y$10$vMkd864zIEMAUqnegKvI0.DNGM1rZUY98E6ht0dTN/GALOnAqiUby', 'raysan', 1, '2024-04-05 14:25:56', NULL, NULL),
(32, 'kush', 'kush', 'vaishnav', 'vaiskush@gmail.com', '8511060234', '$2y$10$eLOWjujlU5HJGwGHSPR.5OnyK2Q.afPKP.780FhypalVdSWKAGHJO', 'B-501 Shubh Pioneer, Koba, Gandhonagar', 1, '2024-07-21 14:17:58', NULL, NULL),
(34, 'Nish', 'Nish', 'Vaishnav', 'kushv946@gmail.com', '9725888640', '$2y$10$XLT34OTE/K/mC1Fiw7zzOO1v1pL6axaHArPhCydviycOjOz.vEBiK', 'koba', 1, '2024-04-05 10:44:35', NULL, NULL),
(35, 'Nilam', 'Nilam', 'Vaishnav', 'nilraj0980@gmail.com', '8264814980', '$2y$10$netoZb822W0ZRTwsCEaUMuNBAAoDQLdZJg5XBbQXUgIe4POvPqmca', 'Koba', 1, '2024-03-26 17:34:36', NULL, NULL),
(36, 'Nirav', 'Nirav', 'Nayi', 'niravllimbachia031@gmail.com', '8511060234', '$2y$10$8mf3FqZeaeXXBchPXPhS9.xKZAsjEewFaYRrwM.0QA8DqP98qtK9C', 'kadi gandhinagar', 1, '2024-07-10 10:10:05', NULL, NULL),
(37, 'Umang', 'Umang', 'Suthar', 'skpimcakush@gmail.com', '8511060234', '$2y$10$4ahtYNR2KQ1JMWANmksBPumN5dPTd4JvPKQVeJ2sC/.uQsJw.uCbm', 'Patel Vas Nr. Verai Mata Madir', 1, '2025-01-28 16:57:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `shoe_size` int(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `shoe_size`, `price`, `payment_method`, `status`, `date`) VALUES
(55, 34, 'Puma', 1, 7, 5000.00, 'COD', 'closed', '2024-04-05 09:06:31'),
(56, 34, 'Adidas', 1, 7, 4599.00, 'COD', NULL, '2024-03-19 13:38:53'),
(57, 34, 'Reebok', 1, 7, 9999.00, 'Online(RazorPay)', 'closed', '2024-04-05 10:46:13'),
(58, 34, 'Adidas', 1, 7, 4599.00, 'COD', NULL, '2024-03-22 09:32:16'),
(59, 34, 'Adidas', 1, 7, 18999.00, 'COD', NULL, '2024-03-22 09:33:53'),
(60, 35, 'Reebok', 1, 7, 9999.00, 'COD', NULL, '2024-03-26 17:35:44'),
(61, 32, 'Puma', 1, 11, 5000.00, 'COD', NULL, '2024-04-04 14:36:13'),
(62, 32, 'Reebok', 1, 7, 8050.00, 'COD', NULL, '2024-04-04 14:38:19'),
(63, 32, 'Adidas', 1, 7, 4599.00, 'COD', NULL, '2024-04-05 07:09:25'),
(64, 32, 'Adidas', 1, 7, 18999.00, 'COD', NULL, '2024-04-05 07:10:49'),
(65, 32, 'Nike', 1, 7, 7999.00, 'COD', NULL, '2024-04-05 07:15:19'),
(67, 32, 'Reebok', 1, 7, 9999.00, 'COD', NULL, '2024-04-05 07:20:01'),
(68, 32, 'Puma', 1, 7, 8000.00, 'COD', NULL, '2024-04-05 07:20:44'),
(69, 32, 'Adidas', 1, 7, 18999.00, 'COD', NULL, '2024-04-05 07:23:18'),
(70, 32, 'Adidas', 1, 7, 9999.00, 'COD', NULL, '2024-04-05 07:23:18'),
(71, 32, 'Adidas', 1, 7, 9999.00, 'COD', NULL, '2024-04-05 08:21:50'),
(72, 32, 'Adidas', 2, 11, 5099.00, 'COD', NULL, '2024-04-05 08:23:56'),
(73, 32, 'Gucci', 1, 7, 9999.00, 'COD', NULL, '2024-04-05 08:24:52'),
(74, 32, 'Adidas', 1, 7, 18999.00, 'COD', NULL, '2024-04-05 08:26:27'),
(75, 34, 'Adidas', 1, 7, 5099.00, 'COD', NULL, '2024-04-05 08:35:47'),
(76, 34, 'Adidas', 1, 7, 9999.00, 'COD', NULL, '2024-04-05 08:42:39'),
(77, 36, 'Nike', 1, 7, 7095.00, 'COD', 'closed', '2024-04-05 15:59:37'),
(78, 36, 'Puma', 1, 7, 8000.00, 'Online(RazorPay)', NULL, '2024-04-05 16:13:26'),
(79, 32, 'Reebok', 1, 10, 8050.00, 'COD', 'closed', '2024-04-06 03:34:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoe_size`
--
ALTER TABLE `shoe_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `shoe_size`
--
ALTER TABLE `shoe_size`
  MODIFY `size_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
