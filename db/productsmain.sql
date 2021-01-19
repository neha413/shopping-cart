-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 19, 2021 at 04:29 PM
-- Server version: 5.7.31-0ubuntu0.18.04.1
-- PHP Version: 7.3.23-2+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `productsmain`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Games', '1', '2021-01-17 15:02:39', NULL),
(2, 'Movies', '1', '2021-01-17 15:02:54', NULL),
(3, 'Electronics', '1', '2021-01-17 15:03:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1610791751),
('m130524_201442_init', 1610791754),
('m190124_110200_add_verification_token_column_to_user_table', 1610791754);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(6,2) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `order_status` enum('1','0','2') NOT NULL DEFAULT '1' COMMENT '1=Active,0=Cancelled, 2= Completed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `order_date`, `modified_date`, `order_status`) VALUES
(1, 2, '160.00', '2021-01-19 10:04:17', NULL, '1'),
(2, 2, '980.00', '2021-01-19 10:10:16', NULL, '1'),
(3, 2, '560.00', '2021-01-19 10:36:18', NULL, '1'),
(4, 2, '500.00', '2021-01-19 10:52:44', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 3, 1),
(2, 2, 1, 1),
(3, 2, 3, 3),
(4, 3, 2, 1),
(5, 3, 3, 1),
(6, 4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `imagename` varchar(50) NOT NULL,
  `imagepath` varchar(250) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `category_id`, `description`, `imagename`, `imagepath`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Uncharted 4: A Thief\'s End', 1, 'Several years after his last adventure, retired fortune hunter, Nathan Drake, is forced back into the world of thieves.', '8059617105051_l600511adbaca3.jpg', 'http://localhost/productsmain/backend/web/uploads/8059617105051_l600511adbaca3.jpg', '500.00', '1', '2021-01-18 10:12:21', '2021-01-19 09:40:08'),
(2, 'Lego Movie Videogame, The', 2, 'Control over 90 characters from The LEGO Movie, including Batman, the Green Ninja and Gandalf.', '5051892159852_l60065bef27045.jpg', 'http://localhost/productsmain/backend/web/uploads/5051892159852_l60065bef27045.jpg', '400.00', '1', '2021-01-19 09:41:27', NULL),
(3, 'Secure Digital (SD) 8GB', 3, '8 GB Capacity\r\nSecure Digital eXtended Capacity format', 'SMEMSD22_l60065c36cca6e.jpg', 'http://localhost/productsmain/backend/web/uploads/SMEMSD22_l60065c36cca6e.jpg', '160.00', '1', '2021-01-19 09:42:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '2' COMMENT '1: admin 2: user',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `role`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', '1', '4R0PjYuE4EAUxvWLkV5kVIqgoBZyZkfK', '$2y$13$Tk/T5zEIUdOOLQW33oOVRuJ4y3Y4eO6CAsRtqTZOb/oag1PZVHLuG', NULL, 'admin@gmail.com', 10, 1610874886, 1610874886, 'dbELv-ev3eNeO-Ommabo2Q_grCuDUJcF_1610874886'),
(2, 'neha', '2', 'XKwt3hI0nzc7ykadacvzwRDbfhHWztox', '$2y$13$bluB8iKy6aUNs04JFXrSFemeFESVxDGXD9SDklx1er8ZS8yFfPI0u', NULL, 'neha@gmail.com', 10, 1610874906, 1610874906, 'lCrWochHg-KaFyQGjK3qrUGvWU8vZisp_1610874906'),
(3, 'demo', '2', 'q6czd_b_D-AelGIodqojnaUHSaEQpwHx', '$2y$13$9Kdx16/oY6jJJwwtsXL9yOrNNknQ0dcMsxe9O2Z4gN3caPhQVcsOG', NULL, 'demo@gmail.com', 10, 1610874964, 1610874964, '5s9I7u7og83nR9vkKKyecLPJmn3lFAuM_1610874964');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_id` (`order_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
