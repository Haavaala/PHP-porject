-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2022 at 01:39 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `country` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `firstname`, `lastname`, `address`, `country`) VALUES
(142, 'Ingrid', 'Grid', 'Brasilia', 'Brazil'),
(143, 'Ronald', 'dinho', 'barcelona', 'Spain'),
(144, 'anosh', 'anoshen', 'anosh', 'Andorra'),
(145, 'Chris', 'Chrisson', 'London', 'East Timor');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` varchar(32) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `time` int(64) DEFAULT NULL,
  `quantity` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `product_id`, `time`, `quantity`) VALUES
(24, '141', 49, 1668065348, 1),
(25, '143', 50, 1668065800, 2),
(26, '144', 50, 1668079190, 1),
(27, '144', 52, 1668079190, 1),
(28, '145', 49, 1668168313, 2),
(29, '145', 51, 1668168313, 1),
(30, '145', 50, 1668168313, 3);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(32) DEFAULT NULL,
  `image_name` varchar(64) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `image_name`, `description`, `price`) VALUES
(49, 'Jabulani', 'Jabulani.jpg', 'Iconic football for the world cup in South Africa 2010', 3000),
(50, 'Ronaldinho shirt', 'Ronaldinho.jpg', 'Barcelona shirt with Ronaldinho on the back', 2000),
(51, 'Adidas f50 football shoes', 'Sko.jpg', 'Retro football boots from adidas', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(32) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `role` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `password`, `customer_id`, `role`) VALUES
('admin', 'admin@ecommerce.com', '0admin0', NULL, 0),
('Anosh', 'Anosh@anosh.no', '$2y$10$uEbALj.6Pxcu1B/FdoU1f.DfE8.cKMM8zQC5RLIFKGwRXr5a/D5ua', NULL, 1),
('Ingrid', 'flex@ingrid.com', '$2y$10$i7TqGDiIt3DubKEiOLTD2ej/vi519prBSUTDO.fsMCkt.NnsqulQ.', NULL, 1),
('thor', 'thor@thor.no', '$2y$10$ackopm1/.u2ClPUfLZ58heSXl/jfhvd2G5a3UWoRia1Ng8xISsoq2', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
