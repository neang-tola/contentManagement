/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50617
Source Host           : 127.0.0.1:3366
Source Database       : content_db

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-03-25 09:31:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table', '1');

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
  `cat_front` tinyint(1) DEFAULT '0',
  `cat_status` tinyint(1) DEFAULT NULL,
  `cat_sequense` smallint(3) DEFAULT NULL,
  `cat_image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_category
-- ----------------------------
INSERT INTO `tbl_category` VALUES ('1', 'Number one in Cambodia', '0', '1', '2', '_1458366518.jpg', '2016-03-19 23:23:30', '2016-03-19 23:23:30');
INSERT INTO `tbl_category` VALUES ('2', 'New product', '1', '1', '3', 'c_1458368887.jpg', '2016-03-19 23:23:33', '2016-03-19 23:23:33');
INSERT INTO `tbl_category` VALUES ('3', 'Second product', '1', '0', '1', null, '2016-03-19 23:31:16', '2016-03-19 23:31:16');

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
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ctd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_category_detail
-- ----------------------------
INSERT INTO `tbl_category_detail` VALUES ('1', '1', 'Product one Here', 'c_1458399762.jpg', '1', '1', '2016-03-19 22:02:43', '2016-03-19 15:02:42');
INSERT INTO `tbl_category_detail` VALUES ('2', '1', 'Product two', null, '0', '2', '2016-03-19 15:29:40', '2016-03-19 15:29:40');
INSERT INTO `tbl_category_detail` VALUES ('3', '1', 'Product three', null, '1', '3', '2016-03-19 14:10:57', '2016-03-19 14:11:07');
INSERT INTO `tbl_category_detail` VALUES ('4', '1', 'Product Four', null, '1', '4', '2016-03-19 14:10:57', '2016-03-19 14:11:10');
INSERT INTO `tbl_category_detail` VALUES ('5', '2', 'Photo 1', null, '0', '5', '2016-03-19 15:27:28', '2016-03-19 15:27:28');
INSERT INTO `tbl_category_detail` VALUES ('6', '2', 'Photo 2', null, '0', '6', '2016-03-19 15:24:49', '2016-03-19 15:24:49');
INSERT INTO `tbl_category_detail` VALUES ('8', '3', 'Nob Sophearaksa', 'c_1458464730.jpg', '0', '4', '2016-03-20 16:05:30', '2016-03-20 09:05:30');

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
  PRIMARY KEY (`ctdt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_category_detail_translate
-- ----------------------------
INSERT INTO `tbl_category_detail_translate` VALUES ('1', '1', '1', 'Product one Here', '<p>i am product one</p>\r\n');
INSERT INTO `tbl_category_detail_translate` VALUES ('2', '1', '2', 'ផលិតផលមួយ', 'ផលិតផល មួយរបស់ខ្ញុំ');
INSERT INTO `tbl_category_detail_translate` VALUES ('3', '2', '1', 'Product two here', 'i am product two');
INSERT INTO `tbl_category_detail_translate` VALUES ('4', '2', '2', 'ផលិតផល ចំនួនពីររបស់ខ្ញុំ', 'ផលិតផល ចំនួនពីរៗៗៗៗ');
INSERT INTO `tbl_category_detail_translate` VALUES ('8', '8', '1', 'Nob Sophearaksa', '<p>Here is the presentation article of Nob Sophearaksa.</p>\r\n');
INSERT INTO `tbl_category_detail_translate` VALUES ('9', '8', '2', 'ណុប សុភារក្សា', '<p>នេះជាអត្ថបទបង្ហាញរបស់ ណុបសភារក្សា</p>\r\n');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_category_translate
-- ----------------------------
INSERT INTO `tbl_category_translate` VALUES ('1', '1', 'Product', '1', 'here is my description product');
INSERT INTO `tbl_category_translate` VALUES ('2', '1', 'ផលិតផលរបស់ខ្ញុំ', '2', 'រីករាយ ក្នុងការបង្ហាញថ្ងៃនេះ');
INSERT INTO `tbl_category_translate` VALUES ('3', '2', 'Number one in Cambodia', '1', '<p>I would like to show i am number one in cambodia</p>\r\n');
INSERT INTO `tbl_category_translate` VALUES ('4', '2', 'ល្អផ្តាច់គេនៅកម្ពុជា', '2', '<p>ល្អផ្តាច់គេនៅកម្ពុជា</p>\r\n');
INSERT INTO `tbl_category_translate` VALUES ('5', '3', 'New product', '1', '<p>here is new product desctions....</p>\r\n');
INSERT INTO `tbl_category_translate` VALUES ('6', '3', 'No Translate', '2', '<p>No Translate</p>\r\n');
INSERT INTO `tbl_category_translate` VALUES ('7', '4', 'Second product', '1', '<p>hello my scond products</p>\r\n');
INSERT INTO `tbl_category_translate` VALUES ('8', '4', 'No Translate', '2', 'No Translate');

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
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`con_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_content
-- ----------------------------
INSERT INTO `tbl_content` VALUES ('1', '1', 'Home', null, '1', 'Young Shopping Mall, Cambodia, Khmer, Supper markert, Phnom Penh Shopping Mall', 'Musashi Advertising Provice services Mobile Truck Advertising, Indoor IDP Advertising, Graphic Design, Web Design, TV Commercials and Documentaries, Event Management: Press Conference, Post Production, Products Launching, Products Trade Show, Concerts, Grand Opening etc.', null, '2016-03-09 15:03:25', '2016-03-09 08:03:25');
INSERT INTO `tbl_content` VALUES ('2', '5', 'Contact Us', '<iframe width=\"730\" height=\"350\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?f=d&source=s_d&saddr=&daddr=Young+Shopping+Mall%4011.593891366058939,104.93033409118652&hl=en&geocode=FaPosAAdHhxBBg&sll=11.593891,104.930334&sspn=0.006401,0.010568&mra=ls&ie=UTF8&t=m&ll=11.593891,104.930334&spn=0.006401,0.010568&output=embed\"></iframe>', '0', 'contact my company', 'Musashi Advertising Provice services Mobile Truck Advertising, Indoor IDP Advertising, Graphic Design, Web Design, TV Commercials and Documentaries, Event Management: Press Conference, Post Production, Products Launching, Products Trade Show, Concerts, Grand Opening etc.', null, '2016-03-17 08:32:01', '2016-03-17 01:32:01');
INSERT INTO `tbl_content` VALUES ('3', '1', 'Link for out site', null, '0', null, null, null, '2016-03-09 10:25:52', '2016-03-09 10:25:52');
INSERT INTO `tbl_content` VALUES ('4', '1', 'Content was remove', null, '0', 'ds', 'sdf', null, '2016-03-20 10:10:38', '2016-03-20 10:10:38');
INSERT INTO `tbl_content` VALUES ('5', '4', 'Number two in Cambodia', null, '1', null, null, null, '2016-03-20 09:58:58', '2016-03-20 02:58:58');
INSERT INTO `tbl_content` VALUES ('7', '4', 'Cambodia Country Clubd', null, '0', '', '', null, '2016-03-19 10:10:18', '2016-03-19 03:10:18');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_content_translate
-- ----------------------------
INSERT INTO `tbl_content_translate` VALUES ('1', '3', 'Hello', '1', 'Here is my Hello description...');
INSERT INTO `tbl_content_translate` VALUES ('2', '3', 'សួរស្តី', '2', 'អត្ថបទសំរាប់សួរស្តី');
INSERT INTO `tbl_content_translate` VALUES ('3', '4', 'Cambodia number one page', '1', '<p><img alt=\"\" src=\"/images/1/no-logo.jpg\" style=\"float:left; height:152px; width:300px\" />My description for Number one article in cambodia</p>\r\n');
INSERT INTO `tbl_content_translate` VALUES ('4', '4', 'លេខមួយរបស់នៅកម្ពុជា', '2', '<p><img alt=\"\" src=\"/images/1/no-logo.jpg\" style=\"float:left; height:152px; width:300px\" />លេខមួយរបស់នៅកម្ពុជា អត្ថបទសំរាប់សួរស្តី</p>\r\n');
INSERT INTO `tbl_content_translate` VALUES ('5', '2', 'Contact Us', '1', '<p>Contact Us description</p>\r\n\r\n<p><img alt=\"\" src=\"/images/1/no-logo.jpg\" style=\"height:152px; width:300px\" /></p>\r\n');
INSERT INTO `tbl_content_translate` VALUES ('6', '2', 'ទំនាក់ទំនង', '2', '<p>នេះជាទំព័រពណ៏នាពី ពត៏មានដែលអាចទំនាក់ទំនងបាន</p>\r\n\r\n<p><img alt=\"\" src=\"/images/1/no-logo.jpg\" style=\"height:152px; width:300px\" /></p>\r\n');
INSERT INTO `tbl_content_translate` VALUES ('7', '7', 'Cambodia Country Clubd', '1', '<p>Now i would like to show about Cambodia Country Club is the most popular sport club in PhnomPenh.</p>\r\n\r\n<p><img alt=\"\" src=\"/images/1/sample-image2.jpg\" style=\"height:500px; width:333px\" /></p>\r\n');
INSERT INTO `tbl_content_translate` VALUES ('8', '7', 'No Translate', '2', 'No Translate');

-- ----------------------------
-- Table structure for `tbl_content_type`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_content_type`;
CREATE TABLE `tbl_content_type` (
  `cnt_id` smallint(2) NOT NULL AUTO_INCREMENT,
  `cnt_title` varchar(50) DEFAULT NULL,
  `cnt_des` varchar(150) DEFAULT NULL,
  `cnt_status` smallint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
INSERT INTO `tbl_content_type` VALUES ('6', 'Slideshow', null, '0', '2016-03-21 15:24:50', '2016-03-21 15:24:50');

-- ----------------------------
-- Table structure for `tbl_gallery`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_gallery`;
CREATE TABLE `tbl_gallery` (
  `gal_id` smallint(10) NOT NULL AUTO_INCREMENT,
  `gal_title` varchar(450) DEFAULT NULL,
  `gal_status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_gallery
-- ----------------------------
INSERT INTO `tbl_gallery` VALUES ('7', 'hello world', '0', '2016-03-18 09:11:59', null);

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
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_image
-- ----------------------------
INSERT INTO `tbl_image` VALUES ('8', '3', 'g_1458274133.jpg', null, null, '3', null, '2016-03-18 14:44:31', '2016-03-18 14:44:31');
INSERT INTO `tbl_image` VALUES ('9', '3', 'g_1458277318.jpg', null, null, '3', null, '2016-03-18 14:44:29', '2016-03-18 14:44:29');
INSERT INTO `tbl_image` VALUES ('10', '3', 'g_1458277398.jpg', null, null, '3', null, '2016-03-18 14:44:28', '2016-03-18 14:44:28');

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
INSERT INTO `tbl_language` VALUES ('2', 'Khmer', 'km', 'km-flag.png', '2', '1', '2014-08-11 10:28:34', '2014-10-02 16:23:35');
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
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_menu
-- ----------------------------
INSERT INTO `tbl_menu` VALUES ('1', '0', 'Home', '1', '1', 'home', 'internal', '1', '1', '1', '2016-03-07 10:12:23', '2016-03-07 03:12:23');
INSERT INTO `tbl_menu` VALUES ('2', '0', 'Contact Us', '1', '2', 'contact', 'external', '1', '5', '3', '2016-03-19 10:17:15', '2016-03-19 03:17:15');
INSERT INTO `tbl_menu` VALUES ('3', '2', 'About Us', '1', '3', 'about', 'internal', '1', '4', '2', '2016-03-09 10:30:01', '2016-03-09 10:30:01');
INSERT INTO `tbl_menu` VALUES ('4', '2', 'Product', '1', '4', 'product', 'internal', '0', '4', '2', '2016-03-08 11:07:06', '2016-03-08 11:07:06');
INSERT INTO `tbl_menu` VALUES ('5', '2', 'News', '1', '5', 'news', 'internal', '0', '4', '2', '2016-03-08 11:07:08', '2016-03-08 11:07:08');
INSERT INTO `tbl_menu` VALUES ('6', '0', 'Hello World', '1', '6', 'hello', 'external', '1', '4', '2', '2016-03-08 11:07:11', '2016-03-08 11:07:11');
INSERT INTO `tbl_menu` VALUES ('7', '0', 'Tola', '3', '7', 'october', 'internal', '0', '4', '4', null, null);
INSERT INTO `tbl_menu` VALUES ('8', '6', 'Test again', '1', '8', 'http://www.tola.com', 'external', '1', '4', '3', '2016-03-09 03:57:55', '2016-03-09 03:57:55');
INSERT INTO `tbl_menu` VALUES ('9', '6', 'just ok', '1', '9', 'just-ok', 'internal', '1', '5', '2', '2016-03-15 18:18:53', '2016-03-15 11:18:53');
INSERT INTO `tbl_menu` VALUES ('10', '7', 'kkkk', '1', '10', 'http://www.tola.com', 'external', '0', '4', '3', '2016-03-09 04:07:32', '2016-03-09 04:07:32');
INSERT INTO `tbl_menu` VALUES ('12', '0', 'soksan', '2', '12', 'soksan', 'internal', '0', '2', '1', '2016-03-09 04:13:12', '2016-03-09 04:13:12');
INSERT INTO `tbl_menu` VALUES ('13', '6', 'New Menu', '1', '13', 'menu-new', 'internal', '1', '4', '5', '2016-03-20 09:52:05', '2016-03-20 09:52:05');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_menu_translate
-- ----------------------------
INSERT INTO `tbl_menu_translate` VALUES ('1', '1', 'Home', '1');
INSERT INTO `tbl_menu_translate` VALUES ('2', '1', 'ទំព័រ ដើម', '2');
INSERT INTO `tbl_menu_translate` VALUES ('3', '2', 'Contact Us', '1');
INSERT INTO `tbl_menu_translate` VALUES ('4', '2', 'ទំព័រ ទំនាក់ទំនង', '2');
INSERT INTO `tbl_menu_translate` VALUES ('5', '7', 'Tola', null);
INSERT INTO `tbl_menu_translate` VALUES ('6', '7', 'តុលា', null);
INSERT INTO `tbl_menu_translate` VALUES ('7', '8', 'Test again', null);
INSERT INTO `tbl_menu_translate` VALUES ('8', '8', 'សាកល្បង ម្តងទៀត', null);
INSERT INTO `tbl_menu_translate` VALUES ('9', '9', 'just ok', null);
INSERT INTO `tbl_menu_translate` VALUES ('10', '10', 'kkkk', '1');
INSERT INTO `tbl_menu_translate` VALUES ('13', '12', 'soksan', '1');
INSERT INTO `tbl_menu_translate` VALUES ('14', '12', 'No Translate', '2');
INSERT INTO `tbl_menu_translate` VALUES ('15', '2', 'JA Contact', '3');
INSERT INTO `tbl_menu_translate` VALUES ('16', '13', 'New Menu', '1');
INSERT INTO `tbl_menu_translate` VALUES ('17', '13', 'មែននុយថ្មី', '2');

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
INSERT INTO `users` VALUES ('1', 'Tola', 'neang.tola@gmail.com', '$2y$10$ZL9ic/JQl5cMIDkzpPPoXeOeMUCaZF9O4qNj.JSfgqPiLrFYfhkcK', 'BtUYpeZ4kWQhwB1oAhG2Z6YV3BjpgxXVqvGiWzlZvvDZuV3kbnsDvMaWc9UC', '2016-03-15 07:28:54', '2016-03-22 01:41:43');
