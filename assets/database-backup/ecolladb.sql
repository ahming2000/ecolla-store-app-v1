-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 01, 2020 at 01:50 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecolladb`
--

-- --------------------------------------------------------

--
-- Table structure for table `catogories`
--

DROP TABLE IF EXISTS `catogories`;
CREATE TABLE IF NOT EXISTS `catogories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `catogories`
--

INSERT INTO `catogories` (`cat_id`, `cat_name`) VALUES
(1, '饮料'),
(2, '零食'),
(25, '素食'),
(26, '小零食'),
(27, '能量饮品');

-- --------------------------------------------------------

--
-- Table structure for table `classifications`
--

DROP TABLE IF EXISTS `classifications`;
CREATE TABLE IF NOT EXISTS `classifications` (
  `i_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`i_id`,`cat_id`),
  KEY `classifications_FK_cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classifications`
--

INSERT INTO `classifications` (`i_id`, `cat_id`) VALUES
(1, 1),
(4, 1),
(2, 2),
(3, 2),
(2, 25),
(3, 25),
(2, 26),
(3, 26),
(1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `ecolla_website_config`
--

DROP TABLE IF EXISTS `ecolla_website_config`;
CREATE TABLE IF NOT EXISTS `ecolla_website_config` (
  `config_name` varchar(50) NOT NULL,
  `config_value` varchar(200) NOT NULL,
  `config_info` varchar(200) NOT NULL,
  PRIMARY KEY (`config_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

DROP TABLE IF EXISTS `inventories`;
CREATE TABLE IF NOT EXISTS `inventories` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `v_barcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `inv_expire_date` date NOT NULL,
  `inv_quantity` int(11) NOT NULL,
  PRIMARY KEY (`inv_id`),
  KEY `inventories_FK_v_barcode` (`v_barcode`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`inv_id`, `v_barcode`, `inv_expire_date`, `inv_quantity`) VALUES
(1, '6902538004045', '2021-01-01', 20),
(2, '6902538005141', '2021-01-01', 20),
(3, '6902538007367', '2021-01-01', 20),
(4, '6902538007381', '2021-01-01', 22),
(5, '6902538007862', '2021-01-01', 22),
(6, '6902538007886', '2021-01-01', 123),
(7, '6931754804900', '2021-01-01', 123),
(8, '6931754804917', '2021-01-01', 213),
(9, '6931754804924', '2021-01-01', 23),
(10, '6931754804931', '2021-01-01', 23),
(11, '6931754805655', '2021-01-01', 123),
(12, '6941025700084', '2021-01-01', 23),
(13, '6941025700138', '2021-01-01', 12),
(14, '6941025701074', '2021-01-01', 14),
(15, '6941025702019', '2021-01-01', 10),
(41, '6902538004045', '2021-03-05', 100),
(42, '6954645911153', '2020-11-20', 10);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `i_brand` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `i_country` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `i_is_listed` tinyint(1) NOT NULL,
  `i_image_count` int(11) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`i_id`, `i_name`, `i_brand`, `i_country`, `i_is_listed`, `i_image_count`) VALUES
(1, '维生素功能饮料', '脉动', '中国', 1, 4),
(2, '手撕素肉排', '好味屋', '中国', 1, 5),
(3, '鹌鹑蛋', '湖湘贡', '中国', 1, 5),
(4, '素食主义', '食为光', '中国', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `o_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `o_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `o_delivery_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'This attribute will remain NULL before the order is being processed by admin.',
  `c_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Since the website does not have customer registration, customer information will combine with this table.',
  `c_phone_mcc` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '+60',
  `c_phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `c_address` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`o_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `o_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `v_barcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `oi_quantity` int(11) NOT NULL DEFAULT '0',
  `oi_note` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`o_id`,`v_barcode`),
  KEY `order_items_FK_v_barcode` (`v_barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES
(4, 'ahming', '$2y$10$MRlh6g79a9c20u3zIwRdcONp9XhOoYJ.1ucT7AaMQazZ94y4u.ZtG');

-- --------------------------------------------------------

--
-- Table structure for table `varieties`
--

DROP TABLE IF EXISTS `varieties`;
CREATE TABLE IF NOT EXISTS `varieties` (
  `v_barcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `v_property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `v_property_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `v_price` float NOT NULL,
  `v_weight` float NOT NULL,
  `v_weight_unit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `v_discount_rate` float NOT NULL DEFAULT '1',
  `i_id` int(11) NOT NULL,
  PRIMARY KEY (`v_barcode`),
  KEY `varieties_FK_i_id` (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `varieties`
--

INSERT INTO `varieties` (`v_barcode`, `v_property`, `v_property_name`, `v_price`, `v_weight`, `v_weight_unit`, `v_discount_rate`, `i_id`) VALUES
('6902538004045', '青柠', '口味', 4.8, 600, 'ml', 0.9, 1),
('6902538005141', '水蜜桃', '口味', 4.8, 600, 'ml', 0.9, 1),
('6902538007367', '芒果', '口味', 4.8, 600, 'ml', 0.9, 1),
('6902538007381', '仙人掌青橘', '口味', 4.8, 600, 'ml', 0.9, 1),
('6902538007862', '竹子青提', '口味', 4.8, 500, 'ml', 0.9, 1),
('6902538007886', '卡曼橘', '口味', 4.8, 500, 'ml', 0.9, 1),
('6931754804900', '香辣味', '口味', 1.5, 26, 'g', 1, 2),
('6931754804917', '黑椒味', '口味', 1.5, 26, 'g', 1, 2),
('6931754804924', '山椒味', '口味', 1.5, 26, 'g', 1, 2),
('6931754804931', '烧烤味', '口味', 1.5, 26, 'g', 1, 2),
('6931754805655', '黑鸭味', '口味', 1.5, 26, 'g', 1, 2),
('6941025700084', '香辣', '口味', 1.2, 20, 'g', 1, 3),
('6941025700138', '盐焗', '口味', 1.2, 20, 'g', 1, 3),
('6941025701074', '卤蛋', '口味', 1.2, 20, 'g', 1, 3),
('6941025702019', '泡辣', '口味', 1.2, 20, 'g', 1, 3),
('6954645911153', '海带丝', '口味', 1.3, 36, 'g', 1, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classifications`
--
ALTER TABLE `classifications`
  ADD CONSTRAINT `classifications_FK_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `catogories` (`cat_id`),
  ADD CONSTRAINT `classifications_FK_i_id` FOREIGN KEY (`i_id`) REFERENCES `items` (`i_id`) ON DELETE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `shelf_life_list_FK_v_barcode` FOREIGN KEY (`v_barcode`) REFERENCES `varieties` (`v_barcode`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_FK_o_id` FOREIGN KEY (`o_id`) REFERENCES `orders` (`o_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_FK_v_barcode` FOREIGN KEY (`v_barcode`) REFERENCES `varieties` (`v_barcode`) ON DELETE CASCADE;

--
-- Constraints for table `varieties`
--
ALTER TABLE `varieties`
  ADD CONSTRAINT `varieties_FK_i_id` FOREIGN KEY (`i_id`) REFERENCES `items` (`i_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
