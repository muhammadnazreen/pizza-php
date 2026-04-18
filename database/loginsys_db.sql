-- phpMyAdmin SQL Dump
-- Pizza Paradizo — Database Schema
-- Updated with indexes for performance

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `loginsys_db`
CREATE DATABASE IF NOT EXISTS `loginsys_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `loginsys_db`;

-- --------------------------------------------------------
-- Table: cart
-- --------------------------------------------------------

CREATE TABLE `cart` (
  `order_id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `product_1` int(11) NOT NULL,
  `product_2` int(11) NOT NULL,
  `product_3` int(11) DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `line_address1` varchar(255) DEFAULT NULL,
  `line_address2` varchar(255) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_time` time DEFAULT NULL,
  `card_num` text DEFAULT NULL,
  `card_expired` text DEFAULT NULL,
  `cvv` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `idx_cart_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: product_list
-- --------------------------------------------------------

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `category_id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `img_path` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=unavailable, 1=available',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product_list` (`id`, `category_id`, `name`, `description`, `price`, `img_path`, `status`) VALUES
(1, 3, 'Sicilian Pizza (Traditional Toppings)', 'Sicilian pizza with bits of tomato, onion, anchovies, and herbs toppings.', 350, '1676512620_Sicilian.jpg', 1),
(2, 1, 'Pepperoni Thin', 'Pepperoni thin-crust', 380, '1676512800_thin-pepperoni.png', 1),
(3, 2, 'Detroit Style', 'Detroit-style thick crust pizza with rich toppings.', 360, '1676512980_detroit-style-thick.jpg', 1);

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `secret_question` varchar(255) NOT NULL,
  `secret_answer` text NOT NULL,
  `encryption_key` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_users_username` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
