/*
Navicat MySQL Data Transfer

Source Server         : sms_manager
Source Server Version : 50170
Source Host           : abuango.net:3306
Source Database       : ango1200_sms

Target Server Type    : MYSQL
Target Server Version : 50170
File Encoding         : 65001

Date: 2013-11-20 18:36:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `contacts`
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `c_id` int(6) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(75) NOT NULL,
  `c_number` varchar(15) NOT NULL,
  `c_birthdate` varchar(10) NOT NULL,
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_number` (`c_number`)
) ENGINE=InnoDB AUTO_INCREMENT=670 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Table structure for `groupings`
-- ----------------------------
DROP TABLE IF EXISTS `groupings`;
CREATE TABLE `groupings` (
  `gr_id` int(4) NOT NULL AUTO_INCREMENT,
  `c_id` int(4) NOT NULL,
  `g_id` int(4) NOT NULL,
  PRIMARY KEY (`gr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Table structure for `groups`
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `g_id` int(3) NOT NULL AUTO_INCREMENT,
  `g_name` varchar(50) NOT NULL,
  `g_desc` varchar(150) NOT NULL,
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('3', 'Guys', 'bobos');
INSERT INTO `groups` VALUES ('4', 'Juma\'ah List', 'Jumaa\'ah Message List');
INSERT INTO `groups` VALUES ('5', 'classmates', 'classmates');
INSERT INTO `groups` VALUES ('6', 'WebDev Class', '000000');
INSERT INTO `groups` VALUES ('7', 'dc', 'dc');

-- ----------------------------
-- Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `log_id` int(7) NOT NULL AUTO_INCREMENT,
  `log_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_desc` varchar(250) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Table structure for `schedules`
-- ----------------------------
DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
  `sch_id` int(6) NOT NULL AUTO_INCREMENT,
  `sch_name` varchar(25) NOT NULL,
  `sch_desc` varchar(250) NOT NULL,
  `sch_startdate` date DEFAULT NULL,
  `sch_fixeddate` date DEFAULT NULL,
  `sch_dates` varchar(50) DEFAULT NULL,
  `sch_rec` enum('r','nr') DEFAULT NULL,
  `sch_recp_type` varchar(15) NOT NULL,
  `sch_msg_type` varchar(15) NOT NULL,
  `sch_recipient` int(5) DEFAULT NULL,
  `sch_msg` int(5) DEFAULT NULL,
  `sch_runcount` int(5) DEFAULT '0',
  `sch_enable` tinyint(1) DEFAULT '1',
  `sch_type` enum('d','w','m','y') DEFAULT NULL,
  PRIMARY KEY (`sch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Table structure for `sms_list`
-- ----------------------------
DROP TABLE IF EXISTS `sms_list`;
CREATE TABLE `sms_list` (
  `sl_id` int(4) NOT NULL AUTO_INCREMENT,
  `sl_name` varchar(25) NOT NULL,
  `sl_desc` varchar(150) NOT NULL,
  PRIMARY KEY (`sl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Table structure for `sms_list_sms`
-- ----------------------------
DROP TABLE IF EXISTS `sms_list_sms`;
CREATE TABLE `sms_list_sms` (
  `sls_id` int(4) NOT NULL AUTO_INCREMENT,
  `sl_id` int(4) NOT NULL,
  `sls_sms` varchar(500) NOT NULL,
  `sls_order` int(6) NOT NULL DEFAULT '0',
  `sls_used` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sls_id`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `u_id` int(4) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(75) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(75) NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


