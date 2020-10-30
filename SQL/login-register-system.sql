-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2020 年 07 月 29 日 11:33
-- 伺服器版本： 5.5.57-MariaDB
-- PHP 版本： 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `login-register-system`
--

-- --------------------------------------------------------

--
-- 資料表結構 `info`
--

CREATE TABLE `info` (
  `sno` int(11) NOT NULL,
  `unique_id` varchar(23) COLLATE utf8_unicode_ci DEFAULT NULL,
  `head` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `longitude` int(18) DEFAULT NULL,
  `latitude` int(18) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `info`
--

INSERT INTO `info` (`sno`, `unique_id`, `head`, `type`, `text`, `time`, `longitude`, `latitude`) VALUES
(34, NULL, '建築學系座談', '演講', '地點：建築系館 \r\n講題：「企業文化與核心價值」\r\n\r\n主講者： 副總經理\r\n學歷-XX大學建築系\r\n經歷-副總經理(現職)\r\n\r\n除建築系師生外，歡迎本校各系所學生及校內教職員一同參加。', '2017-10-11 02:50:30', NULL, NULL),
(33, NULL, 'XX大學2018學生交流計畫', '國際交流', 'XX大學\r\n學生交流計畫2018 Student Exchange Program\r\n申請期間：2017.11.1(三)-2017.11.17(五)\r\n詳情請見：https://www', '2017-10-11 02:08:05', NULL, NULL),
(68, '59d5d3af7ad7a9.09467513', 'GG 服務已終止', '公告', '..........', '2019-09-25 02:22:43', 0, 0),
(66, '59d5d3af7ad7a9.09467513', 'OMO', '公告', 'mmmmmm.......', '2019-02-16 06:32:47', 5269, 5496);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `sno` int(11) NOT NULL,
  `unique_id` varchar(23) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `encrypted_password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`sno`, `unique_id`, `name`, `email`, `encrypted_password`, `salt`, `created_at`) VALUES
(2, '5925a115de71a7.71588340', 'fwefwe', 'wefweg@55.com', '$2y$10$ZPn7q72C/hR4Hok39ZiUDuyX6nsaaOPdMNS8urGjdGYbFk2sUJf8i', '619683db9e', '2017-05-24 23:04:53'),
(3, '5925a15ad5ed58.98701781', '123', '123@5.com', '$2y$10$PV1zeibOhcpfcSkmwMD/UOIQnCRP5WJWEAGHLlZPB1mC32nE43ViS', '1c1f8bd671', '2017-05-24 23:06:02'),
(4, '5925ad4379b4b5.09259389', '321', '321@321.com', '$2y$10$lu3iewWeqXB8/0dP5.cRVO9.fKi3JZBb7kEvTH3GzlxWE8veMlUmm', '48483b6156', '2017-05-24 23:56:51'),
(5, '59c278c0cdf230.81203444', '56414', '1561@516.com', '$2y$10$POKODCDMQcNjvmh6T3.Pke/jmLXL8LS0hElOKV1K3RcEXiChyhjvO', '2c384a5a83', '2017-09-20 22:18:40'),
(6, '59c9e967111759.59629458', '123', '555@555.com', '$2y$10$1ZkA44jR97yjV8BPC3ize.ozJOoZpTQVyWJ1cM7656zpWYVdZ6rkC', 'de43e7e60e', '2017-09-26 13:45:11'),
(7, '59cc9dcf2815b7.14079466', 'fghjj', '5@5.com', '$2y$10$I0C9SCNf.JG1ThJ9YIoaCOzNpupUyZs/JxY7pPfkSYwaUPlgQodlS', '463efc9337', '2017-09-28 14:59:27'),
(8, '59d2f650d85a64.05282842', '588', '7@7.com', '$2y$10$VKkXnwHe.Ug5luHtL07amexnTtGZ4m0yA7U.wZuFz4b4BZk..EEqu', '6015b3aae9', '2017-10-03 10:30:41'),
(9, '59d5d3af7ad7a9.09467513', '小波', '8@8.com', '$2y$10$1CEM8TUtzY1BOomMkZ75TOpEYJIXIElj16KYH8GarK2Zm2xy3Nsvq', '515ceff793', '2017-10-05 14:39:43'),
(10, '59ddc05fa13511.07236968', '998', '9@9.com', '$2y$10$4qDG2cLCoiBRN3VY0WGHRuiK9l9z6BUVfb1kFtZytEjKpr6NGGBM6', '5b384ce32d', '2017-10-11 14:55:27'),
(11, '59ef42e608f0c8.87059957', '34345', '11@11.com', '$2y$10$s2E5oEluW7BhgqMcn7rS4erWI5ek0jmt9lq0mnJ6rRi8wUab4s.t.', '96c27a37ab', '2017-10-24 21:40:54'),
(12, '5b9719c3f04232.94932390', '453', 'qqq@qqq.com', '$2y$10$NnxsxYvhgPnWgkgyihFBjObpcIghJzeHA0QW0ZuAuDE5AKmOJUrvy', '9ef6a2e7c9', '2018-09-11 09:26:28'),
(13, '5b98c400c0b691.23408118', 'OAO', 'a@a.com', '$2y$10$AHsp7KRF2cVSM8lM6UzmkeqkRESnAMwjYN2F9Jt1uPHds0Z.r2HTS', 'a4dd2d2d70', '2018-09-12 15:45:04');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`sno`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`sno`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `info`
--
ALTER TABLE `info`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
