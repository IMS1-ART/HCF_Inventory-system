-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2024 at 04:13 PM
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
-- Database: `92donerkings`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `verification_code` int(255) NOT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `email`, `password`, `phone_no`, `address`, `verification_code`, `verified`) VALUES
(4, 'Rod', 'dozieiwuji@yahoo.com', '$2y$10$f/t4jTqWhe.Tosl//Gr8RupiPXyJQBaaqOWP/vALZlwY/kjFfub6a', 2147483647, '17 Gascoyne Street', 50446, 1),
(5, 'Babu', 'bobnadaf@gmail.com', '$2y$10$TffF3U517MqjBeTl8LjpCO6.MUvQRmmYFFya8Mh/zba/0.6OMSkQ.', 2147483647, 'Manchester', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_description`) VALUES
(1, 'Pizza', 'Freshly baked pizza of different sizes'),
(2, 'Chips', 'Crispy chips of different sizes'),
(4, 'Kebab', 'Chicken and Lamb kebab'),
(5, 'Burger', 'Burger with different topins and sizes'),
(6, 'Drinks', 'cold fizzy drinks');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(225) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` int(11) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `email`, `phone_no`, `address`) VALUES
(1, 'Jamie Kee', 'Jamiee@yahoo.com', 80776868, 'Manchester'),
(2, 'Ije Oma', 'ije@gmail.com', 2147483647, 'Old trafford'),
(3, 'Milan Chi', 'milan@yahoo.com', 237664886, 'Bury'),
(4, 'Emeka Jude', 'emeka@gmail.com', 214748368, 'Salford'),
(5, 'Joe Morin', 'moris@gmail.com', 2147483647, 'Chester');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `product_id`, `customer_id`, `quantity`, `total_price`, `order_date`, `order_time`) VALUES
(1, 1, 1, 1, 1, '2024-02-20', '00:00:00'),
(6, 1, 1, 10, 10, '2024-02-20', '00:00:00'),
(7, 1, 4, 8, 8, '2024-02-21', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'dozieiwuji@yahoo.com', '2851458063b00a408f903967f0a61ddb', '2024-02-20 11:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `category_id`, `product_price`, `product_quantity`, `product_description`) VALUES
(1, 'Cola', 6, 1, 189, 'Chilled coke'),
(2, 'Fanta', 1, 1, 200, 'Chilled and fizzy'),
(3, 'Diet Coke', 6, 1, 194, 'Reduced sugar'),
(5, 'Pepsi', 6, 1, 201, 'Refreshing');

-- --------------------------------------------------------

--
-- Table structure for table `served_order`
--

CREATE TABLE `served_order` (
  `served_order_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `served_order`
--

INSERT INTO `served_order` (`served_order_id`, `order_id`) VALUES
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pin` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `staff_name`, `email`, `phone_no`, `address`, `pin`) VALUES
(2, 'John Wick', 'jonny@gmail.com', 2147483647, 'Bury', 5656),
(3, 'Ali H.', 'ali@gmail.com', 97767878, 'Umuahia', 9090),
(5, 'Chidera', 'dera@yahoo.com', 2147483647, 'Aba', 7171),
(6, 'Obi Nne', 'obi@outlook.com', 706564567, 'London', 2021),
(7, 'Babu', 'bab@gmail.com', 988778776, 'Oldham', 67667);

-- --------------------------------------------------------

--
-- Table structure for table `void_order`
--

CREATE TABLE `void_order` (
  `void_order_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `void_order`
--

INSERT INTO `void_order` (`void_order_id`, `order_id`) VALUES
(1, 5),
(2, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `served_order`
--
ALTER TABLE `served_order`
  ADD PRIMARY KEY (`served_order_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `void_order`
--
ALTER TABLE `void_order`
  ADD PRIMARY KEY (`void_order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `served_order`
--
ALTER TABLE `served_order`
  MODIFY `served_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `void_order`
--
ALTER TABLE `void_order`
  MODIFY `void_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
