-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 11, 2022 at 04:36 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sugoroku`
--

-- --------------------------------------------------------

--
-- Table structure for table `boad_table`
--

CREATE TABLE `boad_table` (
  `id` int(11) NOT NULL,
  `bonus` int(11) NOT NULL,
  `stop_status` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `boad_table`
--

INSERT INTO `boad_table` (`id`, `bonus`, `stop_status`, `text`) VALUES
(1, 0, 0, 'スタート'),
(2, 0, 0, ''),
(3, 1, 0, '1マスすすむ'),
(4, 0, 0, ''),
(5, 0, 0, 'どうぶつのまねをする'),
(6, 0, 1, '1かいやすみ'),
(7, 0, 0, ''),
(8, -7, 0, 'スタートにもどる'),
(9, 3, 0, '特別ボーナス！3マスすすむ'),
(10, -1, 0, '1マスもどる'),
(11, 0, 0, ''),
(12, 2, 0, '2マスすすむ'),
(13, 0, 0, ''),
(14, 0, 0, 'へんがおをする'),
(15, 0, 0, ''),
(16, 3, 0, '3マスすすむ'),
(17, -3, 0, '3マスもどる'),
(18, 0, 0, ''),
(19, 0, 0, ''),
(20, 4, 0, 'ワープ！4マスすすむ'),
(21, 0, 0, ''),
(22, 1, 0, '1マスすすむ'),
(23, 0, 0, ''),
(24, 0, 0, 'すきなうたをうたおう'),
(25, 0, 0, ''),
(26, 0, 1, '1かいやすみ'),
(27, 0, 0, ''),
(28, -3, 0, '3マスもどる'),
(29, 0, 0, 'ゴール！');

-- --------------------------------------------------------

--
-- Table structure for table `game_table`
--

CREATE TABLE `game_table` (
  `id` int(11) NOT NULL,
  `turn` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dice` int(11) NOT NULL,
  `bonus` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `game_table`
--

INSERT INTO `game_table` (`id`, `turn`, `user_id`, `dice`, `bonus`, `position`) VALUES
(1, 1, 1, 3, 0, 4),
(2, 1, 2, 5, 0, 6),
(3, 2, 1, 5, 3, 12),
(4, 2, 2, 0, 0, 6),
(5, 3, 1, 2, 0, 14),
(6, 3, 2, 5, 0, 11),
(7, 4, 1, 4, 0, 18),
(8, 4, 2, 2, 0, 13),
(9, 5, 1, 1, 0, 19),
(10, 5, 2, 5, 0, 18),
(11, 6, 1, 2, 0, 21),
(12, 6, 2, 4, 1, 23),
(13, 7, 1, 2, 0, 23),
(14, 7, 2, 4, 0, 27),
(15, 8, 1, 6, 0, 29);

-- --------------------------------------------------------

--
-- Table structure for table `user_count`
--

CREATE TABLE `user_count` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_count`
--

INSERT INTO `user_count` (`number`) VALUES
(2);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` text CHARACTER SET utf8 NOT NULL,
  `position` int(11) NOT NULL,
  `stop_status` int(11) NOT NULL,
  `goal` int(11) NOT NULL DEFAULT '29'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_name`, `position`, `stop_status`, `goal`) VALUES
(1, 'えー', 29, 0, 0),
(2, 'びー', 27, 0, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boad_table`
--
ALTER TABLE `boad_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_table`
--
ALTER TABLE `game_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game_table`
--
ALTER TABLE `game_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
