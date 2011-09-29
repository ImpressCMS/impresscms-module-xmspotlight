# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Dec 12, 2005 at 10:20 PM
# Server version: 4.1.1
# PHP Version: 4.3.6
# 
# Database : `moddev`
# 

# --------------------------------------------------------

#
# Table structure for table `xmspotlight`
#

CREATE TABLE `xmspotlight` (
  `xmspotlight_id` int(5) NOT NULL auto_increment,
  `xmspotlight_desc` varchar(25) NOT NULL,
  `xmspotlight_sid` text NOT NULL,
  PRIMARY KEY  (`xmspotlight_id`)
);

INSERT INTO `xmspotlight` VALUES (1, 'News Spotlight', '');
INSERT INTO `xmspotlight` VALUES (2, 'Category 1', '');
INSERT INTO `xmspotlight` VALUES (3, 'Category 2', '');
INSERT INTO `xmspotlight` VALUES (4, 'Category 3', '');
INSERT INTO `xmspotlight` VALUES (5, 'Category 4', '');
INSERT INTO `xmspotlight` VALUES (6, 'Category 5', '');
INSERT INTO `xmspotlight` VALUES (7, 'Category 6', '');
INSERT INTO `xmspotlight` VALUES (8, 'Category 7', '');
INSERT INTO `xmspotlight` VALUES (9, 'Category 8', '');
INSERT INTO `xmspotlight` VALUES (10, 'Category 9', '');
INSERT INTO `xmspotlight` VALUES (11, 'Category 10', '');
INSERT INTO `xmspotlight` VALUES (12, 'Category 11', '');
INSERT INTO `xmspotlight` VALUES (13, 'Category 12', '');
INSERT INTO `xmspotlight` VALUES (14, 'Misc', '');

#
# Dumping data for table `xmspotlight`
#
