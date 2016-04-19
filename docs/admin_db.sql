/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50617
Source Host           : 127.0.0.1:3366
Source Database       : admin_db

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-03-25 09:53:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_category`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_category`;
CREATE TABLE `tbl_category` (
  `cat_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(100) DEFAULT NULL,
  `cat_image` varchar(100) DEFAULT NULL,
  `cat_front` tinyint(1) DEFAULT '0',
  `cat_status` tinyint(1) DEFAULT NULL,
  `cat_sequense` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_category
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_category_detail`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_category_detail`;
CREATE TABLE `tbl_category_detail` (
  `ctd_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(3) DEFAULT NULL,
  `ctd_title` varchar(225) DEFAULT NULL,
  `ctd_image` varchar(100) DEFAULT NULL,
  `ctd_status` tinyint(1) DEFAULT NULL,
  `ctd_sequense` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ctd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_category_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_category_detail_translate`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_category_detail_translate`;
CREATE TABLE `tbl_category_detail_translate` (
  `ctdt_id` smallint(8) NOT NULL AUTO_INCREMENT,
  `ctd_id` smallint(5) DEFAULT NULL,
  `lang_id` smallint(2) DEFAULT NULL,
  `ctdt_title` varchar(250) DEFAULT NULL,
  `ctdt_des` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ctdt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_category_detail_translate
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_category_translate`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_category_translate`;
CREATE TABLE `tbl_category_translate` (
  `catt_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(3) DEFAULT NULL,
  `catt_title` varchar(225) DEFAULT NULL,
  `lang_id` smallint(2) DEFAULT NULL,
  `catt_des` text,
  PRIMARY KEY (`catt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_category_translate
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_content`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_content`;
CREATE TABLE `tbl_content` (
  `con_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `cnt_id` smallint(2) DEFAULT NULL,
  `con_title` varchar(100) DEFAULT NULL,
  `con_remark` varchar(500) DEFAULT NULL,
  `con_front` smallint(1) DEFAULT '0',
  `meta_key` varchar(500) DEFAULT NULL,
  `meta_des` varchar(750) DEFAULT NULL,
  `con_sequense` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`con_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_content
-- ----------------------------
INSERT INTO `tbl_content` VALUES ('1', '1', 'Home', null, '1', 'Young Shopping Mall, Cambodia, Khmer, Supper markert, Phnom Penh Shopping Mall', 'Musashi Advertising Provice services Mobile Truck Advertising, Indoor IDP Advertising, Graphic Design, Web Design, TV Commercials and Documentaries, Event Management: Press Conference, Post Production, Products Launching, Products Trade Show, Concerts, Grand Opening etc.', null, '2016-03-09 15:03:25', '2016-03-09 08:03:25');
INSERT INTO `tbl_content` VALUES ('2', '5', 'Contact Us', '<iframe width=\"730\" height=\"350\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?f=d&amp;source=s_d&amp;saddr=&amp;daddr=Young+Shopping+Mall%4011.593891366058939,104.93033409118652&amp;hl=en&amp;geocode=FaPosAAdHhxBBg&amp;sll=11.593891,104.930334&amp;sspn=0.006401,0.010568&amp;mra=ls&amp;ie=UTF8&amp;t=m&amp;ll=11.593891,104.930334&amp;spn=0.006401,0.010568&amp;output=embed\"></iframe>', '0', 'Advertising, Cambodia, Khmer, Video Sport', 'Musashi Advertising Provice services Mobile Truck Advertising, Indoor IDP Advertising, Graphic Design, Web Design, TV Commercials and Documentaries, Event Management: Press Conference, Post Production, Products Launching, Products Trade Show, Concerts, Grand Opening etc.', null, '2016-03-03 08:58:33', '2016-03-03 08:58:33');
INSERT INTO `tbl_content` VALUES ('3', '1', 'Link for out site', null, '0', null, null, null, '2016-03-09 10:25:52', '2016-03-09 10:25:52');

-- ----------------------------
-- Table structure for `tbl_content_translate`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_content_translate`;
CREATE TABLE `tbl_content_translate` (
  `ctt_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `con_id` smallint(3) DEFAULT NULL,
  `ctt_title` varchar(225) DEFAULT NULL,
  `lang_id` smallint(2) DEFAULT NULL,
  `ctt_des` text,
  PRIMARY KEY (`ctt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_content_translate
-- ----------------------------
INSERT INTO `tbl_content_translate` VALUES ('1', '1', 'Home', '1', 'Here is my Home description...');
INSERT INTO `tbl_content_translate` VALUES ('2', '2', 'Contact Us', '1', '<p>Contact Us description</p>\r\n\r\n<p><img alt=\"\" src=\"/images/1/no-logo.jpg\" style=\"height:152px; width:300px\" /></p>\r\n');
INSERT INTO `tbl_content_translate` VALUES ('3', '3', 'Link for out site', '1', null);

-- ----------------------------
-- Table structure for `tbl_content_type`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_content_type`;
CREATE TABLE `tbl_content_type` (
  `cnt_id` smallint(2) NOT NULL AUTO_INCREMENT,
  `cnt_title` varchar(50) DEFAULT NULL,
  `cnt_des` varchar(150) DEFAULT NULL,
  `cnt_status` smallint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`cnt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_content_type
-- ----------------------------
INSERT INTO `tbl_content_type` VALUES ('1', 'Home', null, '0', '2016-03-07 17:07:37', '2016-03-07 17:07:37');
INSERT INTO `tbl_content_type` VALUES ('2', 'Category', null, '1', '2016-03-03 08:38:50', '2016-03-03 08:38:38');
INSERT INTO `tbl_content_type` VALUES ('3', 'Gallery', null, '1', '2016-03-08 10:58:14', '2016-03-08 10:58:14');
INSERT INTO `tbl_content_type` VALUES ('4', 'Article', null, '1', '2016-03-08 10:58:27', '2016-03-08 10:58:27');
INSERT INTO `tbl_content_type` VALUES ('5', 'Contact', null, '1', '2016-03-03 08:38:53', '2016-03-03 08:38:38');
INSERT INTO `tbl_content_type` VALUES ('6', 'Slideshow', null, '1', '2016-03-03 08:38:53', '2016-03-16 11:26:48');

-- ----------------------------
-- Table structure for `tbl_gallery`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_gallery`;
CREATE TABLE `tbl_gallery` (
  `gal_id` smallint(10) NOT NULL AUTO_INCREMENT,
  `gal_title` varchar(450) DEFAULT NULL,
  `gal_status` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`gal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_gallery
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_image`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_image`;
CREATE TABLE `tbl_image` (
  `img_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `conditional_id` smallint(5) DEFAULT NULL,
  `img_name` varchar(150) DEFAULT NULL,
  `img_content` varchar(150) DEFAULT NULL,
  `img_status` tinyint(1) DEFAULT NULL,
  `conditional_type` smallint(2) DEFAULT NULL,
  `img_sequense` smallint(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_image
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_language`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_language`;
CREATE TABLE `tbl_language` (
  `lang_id` smallint(2) NOT NULL AUTO_INCREMENT,
  `lang_title` varchar(50) DEFAULT NULL,
  `lang_alias` varchar(5) DEFAULT NULL,
  `lang_flag` varchar(50) DEFAULT NULL,
  `lang_sequense` smallint(3) DEFAULT NULL,
  `lang_status` smallint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_language
-- ----------------------------
INSERT INTO `tbl_language` VALUES ('1', 'English', 'en', 'en-flag.png', '1', '1', '2014-08-11 10:28:34', '2014-10-02 11:05:43');
INSERT INTO `tbl_language` VALUES ('2', 'Khmer', 'km', 'km-flag.png', '2', '0', '2014-08-11 10:28:34', '2014-10-02 16:23:35');
INSERT INTO `tbl_language` VALUES ('3', 'Japanese', 'ja', 'jp-flag.png', '3', '0', '2014-08-11 10:28:34', '2014-08-11 10:28:38');
INSERT INTO `tbl_language` VALUES ('4', 'Chinese', 'zh', 'zh-flag.png', '4', '0', '2014-08-11 10:28:38', '2014-08-11 10:28:38');
INSERT INTO `tbl_language` VALUES ('5', 'Korean', 'kr', 'kr-flag.png', '5', '0', '2014-08-11 10:28:38', '2014-08-11 10:28:38');
INSERT INTO `tbl_language` VALUES ('6', 'Vietnamese', 'vn', 'vn-flag.png', '6', '0', '2014-08-11 10:54:25', '2015-01-30 13:48:02');
INSERT INTO `tbl_language` VALUES ('7', 'French', 'fr', 'fr-flag.png', '7', '0', '2015-05-19 08:00:16', '2015-05-19 09:00:25');

-- ----------------------------
-- Table structure for `tbl_menu`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE `tbl_menu` (
  `m_id` smallint(3) NOT NULL AUTO_INCREMENT,
  `m_parent` smallint(3) DEFAULT NULL,
  `m_title` varchar(100) DEFAULT NULL,
  `m_post` tinyint(1) DEFAULT NULL,
  `m_sequense` smallint(3) DEFAULT NULL,
  `m_link` varchar(50) DEFAULT NULL,
  `m_link_type` varchar(10) DEFAULT NULL,
  `m_status` tinyint(1) DEFAULT NULL,
  `cnt_id` smallint(2) DEFAULT NULL,
  `con_id` smallint(3) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_menu
-- ----------------------------
INSERT INTO `tbl_menu` VALUES ('1', '0', 'Home', '1', '1', 'home', 'internal', '1', '1', '1', '2016-03-07 10:12:23', '2016-03-07 03:12:23');
INSERT INTO `tbl_menu` VALUES ('2', '0', 'Contact Us', '1', '2', 'contact', 'external', '1', '5', '3', '2016-03-16 06:06:21', '2016-03-15 23:06:21');

-- ----------------------------
-- Table structure for `tbl_menu_translate`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_menu_translate`;
CREATE TABLE `tbl_menu_translate` (
  `mnt_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `m_id` smallint(3) DEFAULT NULL,
  `mnt_title` varchar(225) DEFAULT NULL,
  `lang_id` smallint(2) DEFAULT NULL,
  PRIMARY KEY (`mnt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_menu_translate
-- ----------------------------
INSERT INTO `tbl_menu_translate` VALUES ('1', '1', 'Home', '1');
INSERT INTO `tbl_menu_translate` VALUES ('2', '1', 'Contact Us', '1');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Tola', 'neang.tola@gmail.com', '$2y$10$ZwzAGznpy0fS.pF91F17V.wWf7DBe4qlqJxtMlzV4XaqcverQueHi', '4SIGPVU4KZIrSfoKYNh2nNxAoR5zy6flermUIYzGjWMhNfBM5CuOL7OEP0uR', '2016-03-15 07:28:54', '2016-03-25 02:27:25');
