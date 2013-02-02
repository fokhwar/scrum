-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2012 at 08:58 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scrum`
--

-- --------------------------------------------------------

--
-- Table structure for table `scrum_developers`
--

CREATE TABLE IF NOT EXISTS `scrum_developers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `scrum_developers`
--

INSERT INTO `scrum_developers` (`id`, `name`) VALUES
(1, 'HHA'),
(2, 'HLY'),
(3, 'ATZO'),
(4, 'NLT'),
(5, 'YNK'),
(6, 'SH'),
(7, 'SMA'),
(8, 'KMMN'),
(9, 'SYK');

-- --------------------------------------------------------

--
-- Table structure for table `scrum_results`
--

CREATE TABLE IF NOT EXISTS `scrum_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dev_id` int(11) NOT NULL,
  `to_do` text NOT NULL,
  `finish_task` text NOT NULL,
  `note` text NOT NULL,
  `createDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `scrum_results`
--

INSERT INTO `scrum_results` (`id`, `dev_id`, `to_do`, `finish_task`, `note`, `createDate`) VALUES
(1, 1, 'To write the model layer of HRMS.', '', '', '2012-05-15'),
(2, 3, 'To write Annual Fees of MCPA Project.', '', 'She needs one developer to help her. NLT will help her.', '2012-05-15'),
(3, 4, 'To write the inserting and updating process for scurm meeting result. ', '', '', '2012-05-15'),
(4, 5, 'To manage the processes of attandance management system.', '', '', '2012-05-15'),
(5, 6, 'To change the UI design of HRMS.', '', '', '2012-05-15'),
(6, 7, 'To write employee assignment for job in attandance management system.', '', '', '2012-05-15'),
(7, 8, 'To write the search function of member list.', '', '', '2012-05-15'),
(8, 9, 'To learn SQL', '', '', '2012-05-15');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
