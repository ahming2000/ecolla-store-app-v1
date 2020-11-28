-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 28, 2020 at 08:48 AM
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
  `i_id` int(11) NOT NULL,
  `cat_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `catogories_FK_i_id` (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `catogories`
--

INSERT INTO `catogories` (`cat_id`, `i_id`, `cat_name`) VALUES
(1, 1, '饮料'),
(2, 2, '零食'),
(3, 3, '零食');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `c_phone_mcc` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '+60',
  `c_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `c_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `c_postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `c_city` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `c_state` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(15, '6941025702019', '2021-01-01', 10);

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
  `i_isListed` tinyint(1) NOT NULL,
  `i_imgCount` int(11) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`i_id`, `i_name`, `i_brand`, `i_country`, `i_isListed`, `i_imgCount`) VALUES
(1, '维生素功能饮料', '脉动', '中国', 1, 4),
(2, '手撕素肉排', '好味屋', '中国', 1, 5),
(3, '鹌鹑蛋', '湖湘贡', '中国', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `o_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `o_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `o_item_count` int(11) NOT NULL DEFAULT '0',
  `o_subtotal` float NOT NULL DEFAULT '0',
  `c_id` int(11) NOT NULL,
  `o_delivery_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`o_id`) USING BTREE,
  KEY `orders_FK_c_id` (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `oi_id` int(11) NOT NULL AUTO_INCREMENT,
  `o_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `s_id` int(11) NOT NULL,
  `oi_quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`oi_id`),
  KEY `order_items_FK_s_id` (`s_id`),
  KEY `order_items_FK_o_id` (`o_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specifications`
--

DROP TABLE IF EXISTS `specifications`;
CREATE TABLE IF NOT EXISTS `specifications` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `v_barcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `i_id` int(11) NOT NULL,
  PRIMARY KEY (`s_id`),
  KEY `specifications_FK_i_id` (`i_id`),
  KEY `specifications_FK_v_barcode` (`v_barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specifications`
--

INSERT INTO `specifications` (`s_id`, `v_barcode`, `i_id`) VALUES
(1, '6902538005141', 1),
(2, '6902538004045', 1),
(3, '6902538007381', 1),
(4, '6902538007367', 1),
(5, '6902538007886', 1),
(6, '6902538007862', 1),
(7, '6931754804900', 2),
(8, '6931754804917', 2),
(9, '6931754804931', 2),
(10, '6931754805655', 2),
(11, '6931754804924', 2),
(12, '6941025700138', 3),
(13, '6941025701074', 3),
(14, '6941025700084', 3),
(15, '6941025702019', 3);

-- --------------------------------------------------------

--
-- Table structure for table `varieties`
--

DROP TABLE IF EXISTS `varieties`;
CREATE TABLE IF NOT EXISTS `varieties` (
  `v_barcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `v_property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `v_propertyName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `v_price` float NOT NULL,
  `v_weight` float NOT NULL,
  `v_weightUnit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `v_discountRate` float NOT NULL DEFAULT '1',
  PRIMARY KEY (`v_barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `varieties`
--

INSERT INTO `varieties` (`v_barcode`, `v_property`, `v_propertyName`, `v_price`, `v_weight`, `v_weightUnit`, `v_discountRate`) VALUES
('1234567890', '阿铭味', '口味', 1007, 65, 'kg', 1.5),
('6902538004045', '青柠', '口味', 4.8, 600, 'ml', 0.9),
('6902538005141', '水蜜桃', '口味', 4.8, 600, 'ml', 0.9),
('6902538007367', '芒果', '口味', 4.8, 600, 'ml', 0.9),
('6902538007381', '仙人掌青橘', '口味', 4.8, 600, 'ml', 0.9),
('6902538007862', '竹子青提', '口味', 4.8, 500, 'ml', 0.9),
('6902538007886', '卡曼橘', '口味', 4.8, 500, 'ml', 0.9),
('6931754804900', '香辣味', '口味', 1.5, 26, 'g', 1),
('6931754804917', '黑椒味', '口味', 1.5, 26, 'g', 1),
('6931754804924', '山椒味', '口味', 1.5, 26, 'g', 1),
('6931754804931', '烧烤味', '口味', 1.5, 26, 'g', 1),
('6931754805655', '黑鸭味', '口味', 1.5, 26, 'g', 1),
('6941025700084', '香辣', '口味', 1.2, 20, 'g', 1),
('6941025700138', '盐焗', '口味', 1.2, 20, 'g', 1),
('6941025701074', '卤蛋', '口味', 1.2, 20, 'g', 1),
('6941025702019', '泡辣', '口味', 1.2, 20, 'g', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catogories`
--
ALTER TABLE `catogories`
  ADD CONSTRAINT `catogories_FK_i_id` FOREIGN KEY (`i_id`) REFERENCES `items` (`i_id`) ON DELETE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `shelf_life_list_FK_v_barcode` FOREIGN KEY (`v_barcode`) REFERENCES `varieties` (`v_barcode`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_FK_c_id` FOREIGN KEY (`c_id`) REFERENCES `customers` (`c_id`) ON DELETE NO ACTION;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_FK_o_id` FOREIGN KEY (`o_id`) REFERENCES `orders` (`o_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_FK_s_id` FOREIGN KEY (`s_id`) REFERENCES `specifications` (`s_id`) ON DELETE NO ACTION;

--
-- Constraints for table `specifications`
--
ALTER TABLE `specifications`
  ADD CONSTRAINT `specifications_FK_i_id` FOREIGN KEY (`i_id`) REFERENCES `items` (`i_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `specifications_FK_v_barcode` FOREIGN KEY (`v_barcode`) REFERENCES `varieties` (`v_barcode`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
