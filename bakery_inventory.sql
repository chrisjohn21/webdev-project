-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2023 at 03:06 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakery_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `quantity` int NOT NULL DEFAULT '0',
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `quantity`, `last_updated`) VALUES
(1, 'vanilla cake', '70.00', 'yellow', 143, '2023-12-05 12:37:35'),
(2, 'a', '1.00', 'a', 11, '2023-12-05 09:30:52'),
(3, 'bread', '20.00', 'malunggay', 24, '2023-12-05 09:42:11'),
(4, 'costumized cake', '350.00', 'can be costumize', 20, '2023-12-05 14:40:56'),
(5, 'vanilla chiffon', '120.00', 'vanilla', 30, '2023-12-05 14:42:11'),
(6, 'banana cake', '80.00', 'banana', 30, '2023-12-05 14:44:05'),
(7, 'cheese cake', '120.00', 'cheese', 20, '2023-12-05 14:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `action` enum('in','out') DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `product_id`, `product_name`, `action`, `quantity`, `created_at`) VALUES
(1, 1, 'vanilla cake', 'in', 11, '2023-12-05 09:24:08'),
(2, 1, 'vanilla cake', 'in', 22, '2023-12-05 09:27:02'),
(3, 2, 'a', 'out', 11, '2023-12-05 09:27:08'),
(4, 2, 'a', 'in', 11, '2023-12-05 09:30:46'),
(5, 2, 'a', 'out', 11, '2023-12-05 09:30:49'),
(6, 2, 'a', 'in', 11, '2023-12-05 09:30:52'),
(7, 3, 'bread', 'in', 12, '2023-12-05 09:42:11'),
(8, 1, 'vanilla cake', 'in', 11, '2023-12-05 12:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'jack', '1234'),
(2, 'cj', 'securepass'),
(3, 'bakeryman', 'admin123');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
