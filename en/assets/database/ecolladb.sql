-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 26, 2021 at 04:40 PM
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, '饮料'),
(2, '零食'),
(3, '素食'),
(4, '小零食'),
(5, '能量饮品'),
(6, '中国出产'),
(7, '酒精饮品'),
(8, '热卖'),
(9, '新品');

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
(5, 1),
(2, 2),
(3, 2),
(2, 3),
(3, 3),
(2, 4),
(3, 4),
(1, 5),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(5, 6),
(4, 7),
(5, 7),
(1, 8),
(2, 8),
(3, 8),
(4, 8),
(5, 8),
(1, 9),
(2, 9),
(3, 9),
(4, 9),
(5, 9);

-- --------------------------------------------------------

--
-- Table structure for table `ecolla_website_config`
--

DROP TABLE IF EXISTS `ecolla_website_config`;
CREATE TABLE IF NOT EXISTS `ecolla_website_config` (
  `config_name` varchar(50) NOT NULL,
  `config_value_text` varchar(200) DEFAULT NULL,
  `config_value_float` float DEFAULT NULL,
  `config_info` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`config_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ecolla_website_config`
--

INSERT INTO `ecolla_website_config` (`config_name`, `config_value_text`, `config_value_float`, `config_info`) VALUES
('max_items_per_page', NULL, 8, 'The maximum number of items to show in each page of item-list.php'),
('max_management_content', NULL, 5, 'Maximum content viewing at order-management.php and item-management.php page.'),
('order_id_prefix', 'ECOLLA', NULL, 'Order ID prefix which used for the order to have special id.'),
('shipping_fee_east_my', NULL, 5.66, 'Shipping Fee in RM (Malaysia Ringgit) per kilogram for east Malaysia'),
('shipping_fee_west_my', NULL, 4.77, 'Shipping Fee in RM (Malaysia Ringgit) per kilogram for west Malaysia');

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`inv_id`, `v_barcode`, `inv_expire_date`, `inv_quantity`) VALUES
(1, '6902538004045', '2021-01-01', 0),
(2, '6902538005141', '2021-01-01', 18),
(3, '6902538007367', '2021-01-01', 20),
(4, '6902538007381', '2021-01-01', 22),
(5, '6902538007862', '2021-01-01', 0),
(6, '6902538007886', '2021-01-01', 0),
(7, '6931754804900', '2021-01-01', 0),
(8, '6931754804917', '2021-01-01', 27),
(9, '6931754804924', '2021-01-01', 23),
(10, '6931754804931', '2021-01-01', 23),
(11, '6931754805655', '2021-01-01', 14),
(12, '6941025700084', '2021-01-01', 22),
(13, '6941025700138', '2021-01-01', 12),
(14, '6941025701074', '2021-01-01', 14),
(15, '6941025702019', '2021-01-01', 19),
(16, '6902538004045', '2021-03-05', 0),
(17, '6935145301016', '2021-05-20', 10),
(18, '6935145301030', '2021-05-20', 20),
(19, '6935145301047', '2021-05-20', 9),
(20, '6935145301061', '2021-05-20', 20),
(21, '6935145301078', '2021-05-20', 39),
(22, '6935145343030', '2021-07-27', 15),
(23, '6935145343047', '2021-07-27', 20),
(24, '6935145343061', '2021-07-27', 16),
(25, '6935145343092', '2021-07-27', 20),
(56, '6902538007862', '2021-01-25', 20),
(58, '6935145301016', '2021-01-07', 5),
(59, '6931754804900', '2021-06-14', 300),
(60, '6902538004045', '2021-04-21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `i_desc` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `i_brand` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `i_origin` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `i_property_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `i_is_listed` tinyint(1) NOT NULL DEFAULT '0',
  `i_image_count` int(11) NOT NULL,
  `i_view_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`i_id`, `i_name`, `i_desc`, `i_brand`, `i_origin`, `i_property_name`, `i_is_listed`, `i_image_count`, `i_view_count`) VALUES
(1, '脉动维生素功能饮料', '好喝的饮料', '脉动', '中国', '口味', 1, 4, 40),
(2, '好味屋手撕素肉排', '面筋制品', '好味屋', '中国', '口味', 1, 5, 478),
(3, '湖湘贡鹌鹑蛋', '风味鸳鸯蛋', '湖湘贡', '中国', '口味', 1, 5, 107),
(4, 'RIO鸡尾酒', '精美玻璃，漂亮的颜色的鸡尾酒', 'RIO', '中国', '口味', 1, 3, 28),
(5, 'RIO微醺鸡尾酒', '来一杯，享受好时光', 'RIO', '中国', '口味', 1, 1, 19);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `o_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `o_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `o_payment_method` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `o_note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `o_delivery_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'This attribute will remain NULL before the order is being processed by admin.',
  `o_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '待处理' COMMENT 'There is only four Enums available for this column, which is 待处理, 已出货, 已退货, 已取消',
  `c_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Since the website does not have customer registration, customer information will combine with this table.',
  `c_phone_mcc` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '+60',
  `c_phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `c_address` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `c_state` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `c_area` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `c_postal_code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`o_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `o_date_time`, `o_payment_method`, `o_note`, `o_delivery_id`, `o_status`, `c_name`, `c_phone_mcc`, `c_phone`, `c_address`, `c_state`, `c_area`, `c_postal_code`) VALUES
('ECOLLA20210105110145', '2021-01-05 11:01:45', 'TnG', '', '', '已取消', 'Kee', '+60', '143892199', '10, Jalan Suasa 1', 'Perak', 'Kampar', '31900'),
('ECOLLA20210109083102', '2021-01-09 08:31:02', 'TnG', '', '', '待处理', '123', '+60', '1232131', 'KJL', 'Johor', 'Ayer Baloi', '82100'),
('ECOLLA20210111081323', '2021-01-11 08:13:23', 'TnG', '', 'ABCSDSDSD', '已出货', 'Alex Lee', '+60', '1232131', '122342', 'Kuala Lumpur', 'Ampang', '68000'),
('ECOLLA20210112103353', '2021-01-12 10:33:53', 'TnG', '', NULL, '已退款', '123', '+60', '123123', 'dsfsf', 'Kuala Lumpur', 'Setapak', '53300'),
('ECOLLA20210115120546', '2021-01-15 12:05:46', 'TnG', '', NULL, '待处理', 'Name is me', '+60', '123765', 'jgshdkfjhksf', 'Johor', 'Ayer Baloi', '82100'),
('ECOLLA20210117154008', '2021-01-17 15:40:08', 'TnG', '', 'J&TABCD1234', '已出货', 'Test Discount', '+60', '21345', 'kjlsdka', 'Perak', 'Ayer Tawar', '32400'),
('SUNDAY20210125185038', '2021-01-25 18:50:38', 'TnG', '', NULL, '待处理', 'Alex Lee', '+60', '1232131', 'klshbdjc', 'Johor', 'Ayer Baloi', '82100');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `o_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `v_barcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `oi_quantity` int(11) NOT NULL DEFAULT '0',
  `oi_expire_date` date NOT NULL,
  PRIMARY KEY (`o_id`,`v_barcode`,`oi_expire_date`) USING BTREE,
  KEY `order_items_FK_v_barcode` (`v_barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`o_id`, `v_barcode`, `oi_quantity`, `oi_expire_date`) VALUES
('ECOLLA20210105110145', '6935145301016', 6, '2021-01-07'),
('ECOLLA20210109083102', '6935145301016', 4, '2021-01-21'),
('ECOLLA20210111081323', '6902538004045', 3, '2021-01-22'),
('ECOLLA20210112103353', '6935145301047', 3, '2021-05-20'),
('ECOLLA20210115120546', '6902538004045', 1, '2021-01-01'),
('ECOLLA20210117154008', '6902538005141', 2, '2021-01-01'),
('ECOLLA20210117154008', '6902538007862', 3, '2021-01-01'),
('ECOLLA20210117154008', '6931754804900', 35, '2021-01-01'),
('ECOLLA20210117154008', '6931754804917', 3, '2021-01-01'),
('SUNDAY20210125185038', '6935145301016', 1, '2021-01-07');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES
(4, 'ahming', '$2y$10$jzQhJUHEwCmhnuPY1Gp0bOjLf3vW3SWTNmt/H/ieBBu8lr59vl56i'),
(5, 'txe1', '$2y$10$XOC8AkdEmDSQ5.K7qJjvYO6OszzdpvSZfgZwCIobIagyqHqyKu2Bu');

-- --------------------------------------------------------

--
-- Table structure for table `varieties`
--

DROP TABLE IF EXISTS `varieties`;
CREATE TABLE IF NOT EXISTS `varieties` (
  `v_barcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `v_property` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `v_price` float NOT NULL COMMENT 'Default currency unit is Ringgit Malaysia',
  `v_weight` float NOT NULL COMMENT 'Format in kilogram',
  `v_discount_rate` float NOT NULL DEFAULT '1',
  `i_id` int(11) NOT NULL,
  PRIMARY KEY (`v_barcode`),
  KEY `varieties_FK_i_id` (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `varieties`
--

INSERT INTO `varieties` (`v_barcode`, `v_property`, `v_price`, `v_weight`, `v_discount_rate`, `i_id`) VALUES
('6902538004045', '青柠味600ml', 4.8, 0.6, 1, 1),
('6902538005141', '水蜜桃味600ml', 4.8, 0.6, 0.520833, 1),
('6902538007367', '芒果味600ml', 4.8, 0.6, 1, 1),
('6902538007381', '仙人掌青橘味600ml', 4.8, 0.6, 1, 1),
('6902538007862', '竹子青提味500ml', 4.8, 0.5, 1, 1),
('6902538007886', '卡曼橘味500ml', 4.8, 0.5, 1, 1),
('6931754804900', '香辣味26g', 1.5, 0.026, 1, 2),
('6931754804917', '黑椒味26g', 1.5, 0.026, 0.8, 2),
('6931754804924', '山椒味26g', 1.5, 0.026, 1, 2),
('6931754804931', '烧烤味26g', 1.5, 0.026, 1, 2),
('6931754805655', '黑鸭味26g', 1.5, 0.026, 1, 2),
('6935145301016', '青柠275ml', 11.5, 0.275, 1, 4),
('6935145301030', '水蜜桃275ml', 11.5, 0.275, 1, 4),
('6935145301047', '蓝玫瑰275ml', 11.5, 0.275, 1, 4),
('6935145301061', '混合水果275ml', 11.5, 0.275, 1, 4),
('6935145301078', '紫葡萄275ml', 11.5, 0.275, 1, 4),
('6935145343030', '白桃+白兰地330ml', 8.8, 0.33, 0.58, 5),
('6935145343047', '葡萄+白兰地330ml', 8.8, 0.33, 1, 5),
('6935145343061', '玫瑰+荔枝330ml', 8.8, 0.33, 1, 5),
('6935145343092', '果茶乐橘乌龙330ml', 8.8, 0.33, 1, 5),
('6941025700084', '香辣味20g', 1.2, 0.02, 1, 3),
('6941025700138', '盐焗味20g', 1.2, 0.02, 1, 3),
('6941025701074', '卤蛋味20g', 1.2, 0.02, 1, 3),
('6941025702019', '泡辣味20g', 1.2, 0.02, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `wholesales`
--

DROP TABLE IF EXISTS `wholesales`;
CREATE TABLE IF NOT EXISTS `wholesales` (
  `w_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_id` int(11) NOT NULL,
  `w_min` int(11) NOT NULL,
  `w_max` int(11) DEFAULT NULL,
  `w_discount_rate` float NOT NULL,
  PRIMARY KEY (`w_id`),
  KEY `wholesales_FK_i_id` (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wholesales`
--

INSERT INTO `wholesales` (`w_id`, `i_id`, `w_min`, `w_max`, `w_discount_rate`) VALUES
(28, 2, 30, 39, 0.866667),
(29, 2, 40, 49, 0.8),
(30, 2, 50, NULL, 0.733333),
(31, 2, 20, 29, 0.933333);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classifications`
--
ALTER TABLE `classifications`
  ADD CONSTRAINT `classifications_FK_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`),
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
  ADD CONSTRAINT `order_items_FK_v_barcode` FOREIGN KEY (`v_barcode`) REFERENCES `varieties` (`v_barcode`) ON DELETE NO ACTION;

--
-- Constraints for table `varieties`
--
ALTER TABLE `varieties`
  ADD CONSTRAINT `varieties_FK_i_id` FOREIGN KEY (`i_id`) REFERENCES `items` (`i_id`) ON DELETE CASCADE;

--
-- Constraints for table `wholesales`
--
ALTER TABLE `wholesales`
  ADD CONSTRAINT `wholesales_FK_i_id` FOREIGN KEY (`i_id`) REFERENCES `items` (`i_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
