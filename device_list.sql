-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-11-13 03:55:52
-- 伺服器版本： 10.1.31-MariaDB
-- PHP 版本： 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `iodatadb`
--

-- --------------------------------------------------------

--
-- 資料表結構 `device_list`
--

CREATE TABLE `device_list` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_num` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_type` enum('co2_meter','pm10_meter','co2_rh_temp_meter','pm2.5_meter','acer_meter','co2_hcho_meter','co2_rh_temp_pm2.5_meter') COLLATE utf8mb4_unicode_ci NOT NULL,
  `air_exchange` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `co2_value` int(11) NOT NULL,
  `pm10_value` int(11) DEFAULT '0',
  `pm2.5_value` int(11) DEFAULT '0',
  `rh_value` double DEFAULT '0',
  `temp_value` double DEFAULT '0',
  `hcho_value` double DEFAULT '0',
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `device_list`
--

INSERT INTO `device_list` (`id`, `name`, `en_name`, `device_num`, `device_type`, `air_exchange`, `co2_value`, `pm10_value`, `pm2.5_value`, `rh_value`, `temp_value`, `hcho_value`, `time`) VALUES
(1, 'test', '', '101', 'co2_rh_temp_meter', '0', 581, 0, 4, 42.46, 29.81, 0, '2021-08-09 18:23:01');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `device_list`
--
ALTER TABLE `device_list`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `device_list`
--
ALTER TABLE `device_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
