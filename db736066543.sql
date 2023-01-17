-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: db736066543.db.1and1.com
-- Generation Time: Apr 18, 2019 at 06:32 PM
-- Server version: 5.5.60-0+deb7u1-log
-- PHP Version: 7.0.33-0+deb9u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db736066543`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `account_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique number for each user',
  `fullname` varchar(255) COLLATE latin1_general_ci NOT NULL COMMENT 'User''s full name',
  `email` varchar(255) COLLATE latin1_general_ci NOT NULL COMMENT 'User''s email',
  `username` varchar(30) COLLATE latin1_general_ci NOT NULL COMMENT 'Username for the user',
  `password` varchar(255) COLLATE latin1_general_ci NOT NULL COMMENT 'Password of the user',
  `signup_date` date NOT NULL,
  `user_score` float NOT NULL,
  `weekly_user_score` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `token` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `token_expire` datetime NOT NULL,
  PRIMARY KEY (`account_ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='User data table' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE IF NOT EXISTS `tbl_comments` (
  `comment_ID` int(11) NOT NULL AUTO_INCREMENT,
  `parent_comment_ID` int(11) DEFAULT NULL,
  `account_ID` int(11) NOT NULL,
  `img_ID` int(11) NOT NULL,
  `comment` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `comment_time` datetime NOT NULL,
  PRIMARY KEY (`comment_ID`),
  KEY `account_ID` (`account_ID`),
  KEY `img_ID` (`img_ID`),
  KEY `parent_comment_ID` (`parent_comment_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE IF NOT EXISTS `tbl_images` (
  `img_ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_ID` int(11) NOT NULL,
  `img_URL` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `img_title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `img_desc` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `upld_date` datetime NOT NULL,
  `rating_avg` float NOT NULL,
  `rating_votes` int(11) NOT NULL,
  PRIMARY KEY (`img_ID`),
  KEY `account_ID` (`account_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_preferences`
--

CREATE TABLE IF NOT EXISTS `tbl_preferences` (
  `preference_ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_ID` int(11) NOT NULL,
  `profile_img` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `background_img` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `dark_mode` int(1) DEFAULT NULL,
  PRIMARY KEY (`preference_ID`),
  KEY `account_ID` (`account_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE IF NOT EXISTS `tbl_rating` (
  `rating_ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_ID` int(11) NOT NULL,
  `img_ID` int(11) NOT NULL,
  `img_rating` int(11) NOT NULL,
  PRIMARY KEY (`rating_ID`),
  KEY `account_ID` (`account_ID`),
  KEY `img_ID` (`img_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=421 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_relationship`
--

CREATE TABLE IF NOT EXISTS `tbl_relationship` (
  `follow_ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_ID` int(11) NOT NULL,
  `following_ID` int(11) NOT NULL,
  PRIMARY KEY (`follow_ID`),
  KEY `account_ID` (`account_ID`),
  KEY `following_ID` (`following_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_stats`
--

CREATE TABLE IF NOT EXISTS `tbl_user_stats` (
  `user_stats_ID` int(11) NOT NULL AUTO_INCREMENT,
  `account_ID` int(11) NOT NULL,
  `user_score` float NOT NULL,
  `weekly_user_score` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`user_stats_ID`),
  KEY `account_ID` (`account_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD CONSTRAINT `tbl_comments_ibfk_1` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`account_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_comments_ibfk_2` FOREIGN KEY (`img_ID`) REFERENCES `tbl_images` (`img_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD CONSTRAINT `tbl_images_ibfk_1` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`account_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_preferences`
--
ALTER TABLE `tbl_preferences`
  ADD CONSTRAINT `tbl_preferences_ibfk_1` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`account_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD CONSTRAINT `tbl_rating_ibfk_1` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`account_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_rating_ibfk_2` FOREIGN KEY (`img_ID`) REFERENCES `tbl_images` (`img_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_relationship`
--
ALTER TABLE `tbl_relationship`
  ADD CONSTRAINT `tbl_relationship_ibfk_1` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`account_ID`),
  ADD CONSTRAINT `tbl_relationship_ibfk_2` FOREIGN KEY (`following_ID`) REFERENCES `accounts` (`account_ID`);

--
-- Constraints for table `tbl_user_stats`
--
ALTER TABLE `tbl_user_stats`
  ADD CONSTRAINT `tbl_user_stats_ibfk_1` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`account_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
