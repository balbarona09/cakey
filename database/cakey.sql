-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2023 at 10:33 PM
-- Server version: 8.0.29
-- PHP Version: 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cakey`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int NOT NULL,
  `product_category_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(256) NOT NULL,
  `extension_file` varchar(10) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT 'active=0, archived=0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_category_id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `extension_file` varchar(10) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT 'active=0, archived=1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction1`
--

CREATE TABLE `transaction1` (
  `transaction_id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `quantity` smallint NOT NULL,
  `ordered_product` varchar(100) DEFAULT NULL,
  `ordered_amount` decimal(10,2) DEFAULT NULL,
  `fullname` varchar(256) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=cart, 1=ordered, 2=delivery, 3=completed, 4=user_cancelled, 5=admin_cancelled',
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `role` tinyint NOT NULL DEFAULT '0' COMMENT '0=customer, 1=admin',
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=Activated, 1=Deactivated, 2=Blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role`, `name`, `email`, `password`, `phone`, `region`, `province`, `city`, `barangay`, `postal_code`, `street`, `creation_date`, `updation_date`, `status`) VALUES
(1, 1, 'Aegon Targaryen', 'admin@gmail.com', '$2y$10$SNThOGEPvUPlYw0nKPrw5.AiWJ20avRlUX4USWUXy3W9g5uhyLIM.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-19 09:58:53', '2023-07-19 09:58:53', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `transaction1`
--
ALTER TABLE `transaction1`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction1`
--
ALTER TABLE `transaction1`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
