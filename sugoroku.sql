-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 2022-02-09 15:11:48
-- サーバのバージョン： 5.7.24
-- PHP のバージョン: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `sugoroku`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `boad_table`
--

CREATE TABLE `boad_table` (
  `id` int(11) NOT NULL,
  `bonus` int(11) NOT NULL,
  `stop_status` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `boad_table`
--

INSERT INTO `boad_table` (`id`, `bonus`, `stop_status`, `text`) VALUES
(1, 0, 0, 'スタート'),
(2, 1, 0, '1マスすすむ'),
(3, 0, 0, ''),
(4, 0, 0, 'どうぶつのものまねをする'),
(5, 0, 1, '1かいやすみ'),
(6, 0, 0, ''),
(7, -6, 0, 'スタートにもどる'),
(8, 3, 0, '3マスすすむ'),
(9, 0, 0, ''),
(10, -1, 0, '1マスもどる'),
(11, 0, 0, ''),
(12, 2, 0, '2マスすすむ'),
(13, 0, 0, ''),
(14, 0, 0, 'へんがおをする'),
(15, 0, 0, ''),
(16, 2, 0, '2マスすすむ'),
(17, 0, 0, ''),
(18, -3, 0, '3マスもどる'),
(19, 0, 0, ''),
(20, 0, 0, ''),
(21, 4, 0, 'ワープ'),
(22, 0, 0, ''),
(23, 3, 0, '3マスすすむ'),
(24, 0, 0, ''),
(25, 0, 0, 'すきなうたをうたおう'),
(26, 0, 0, ''),
(27, 0, 1, '１かいやすみ'),
(28, 0, 0, ''),
(29, 0, 0, 'ゴール！');

-- --------------------------------------------------------

--
-- テーブルの構造 `game_table`
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
-- テーブルのデータのダンプ `game_table`
--

INSERT INTO `game_table` (`id`, `turn`, `user_id`, `dice`, `bonus`, `position`) VALUES
(1, 1, 1, 2, 0, 3),
(2, 1, 2, 2, 0, 3),
(3, 2, 1, 5, 3, 11),
(4, 2, 2, 5, 3, 11),
(5, 3, 1, 2, 0, 13),
(6, 3, 2, 2, 0, 13),
(7, 4, 1, 4, 0, 17),
(8, 4, 2, 4, 0, 17),
(9, 5, 1, 5, 0, 22),
(10, 5, 2, 5, 0, 22),
(11, 6, 1, 2, 0, 24),
(12, 6, 2, 1, 3, 26),
(13, 7, 1, 6, 0, 29);

-- --------------------------------------------------------

--
-- テーブルの構造 `user_count`
--

CREATE TABLE `user_count` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `user_count`
--

INSERT INTO `user_count` (`number`) VALUES
(2);

-- --------------------------------------------------------

--
-- テーブルの構造 `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` text CHARACTER SET utf8 NOT NULL,
  `position` int(11) NOT NULL,
  `stop_status` int(11) NOT NULL,
  `goal` int(11) NOT NULL DEFAULT '29'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_name`, `position`, `stop_status`, `goal`) VALUES
(1, 'えー', 29, 0, 0),
(2, 'びー', 26, 0, 3);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `boad_table`
--
ALTER TABLE `boad_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `game_table`
--
ALTER TABLE `game_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `game_table`
--
ALTER TABLE `game_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- テーブルの AUTO_INCREMENT `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
