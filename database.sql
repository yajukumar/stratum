-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2015 at 11:01 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `strtum_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `stm_access`
--

CREATE TABLE IF NOT EXISTS `stm_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `view_id` int(45) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_gizmos`
--

CREATE TABLE IF NOT EXISTS `stm_gizmos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gizmo_name` varchar(145) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_gizmo_position`
--

CREATE TABLE IF NOT EXISTS `stm_gizmo_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_gizmo_position_map`
--

CREATE TABLE IF NOT EXISTS `stm_gizmo_position_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) NOT NULL,
  `gizmo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_gizmo_usergroup_map`
--

CREATE TABLE IF NOT EXISTS `stm_gizmo_usergroup_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gizmo_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_menu`
--

CREATE TABLE IF NOT EXISTS `stm_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `block` tinyint(4) NOT NULL,
  `ordering` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_menu_item`
--

CREATE TABLE IF NOT EXISTS `stm_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `img` text NOT NULL,
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_sessions`
--

CREATE TABLE IF NOT EXISTS `stm_sessions` (
  `id` char(32) NOT NULL,
  `data` longtext NOT NULL,
  `last_accessed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stm_template`
--

CREATE TABLE IF NOT EXISTS `stm_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `owner` text NOT NULL,
  `defaults` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `author` text NOT NULL,
  `param` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='admin and site template data admin=1, site=0' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_template_assingment`
--

CREATE TABLE IF NOT EXISTS `stm_template_assingment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `view_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_users`
--

CREATE TABLE IF NOT EXISTS `stm_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `first_name` text,
  `last_name` text,
  `password` varchar(150) DEFAULT NULL,
  `block` tinyint(4) DEFAULT '0',
  `user_group_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL COMMENT 'Stores only basid information of user',
  `title` text NOT NULL,
  `middle_name` text NOT NULL,
  `designation` text NOT NULL,
  `department` text NOT NULL,
  `company` text NOT NULL,
  `address_one` text NOT NULL,
  `address_two` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `zip` varchar(45) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `county` text NOT NULL,
  `phone` varchar(12) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `token` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_group_id_idx` (`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_user_group`
--

CREATE TABLE IF NOT EXISTS `stm_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(45) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `block` tinyint(4) DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Type of users: Front desk, Nurse, counselor, etc' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_view`
--

CREATE TABLE IF NOT EXISTS `stm_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `view` varchar(45) NOT NULL,
  `home` int(11) NOT NULL,
  `alias` text NOT NULL,
  `metatag` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stm_view_gizmo_map`
--

CREATE TABLE IF NOT EXISTS `stm_view_gizmo_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gizmo_id` int(11) NOT NULL,
  `view_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
