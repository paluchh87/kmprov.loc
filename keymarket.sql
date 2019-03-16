-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 16 2019 г., 13:42
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `keymarket`
--

-- --------------------------------------------------------

--
-- Структура таблицы `fullprice`
--

CREATE TABLE `fullprice` (
  `id` int(11) NOT NULL,
  `week` text NOT NULL,
  `shopid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `status` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `kolvo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fullprice_new`
--

CREATE TABLE `fullprice_new` (
  `id` int(11) NOT NULL,
  `shopid` int(11) NOT NULL,
  `productid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fullprice_products_count`
--

CREATE TABLE `fullprice_products_count` (
  `id` int(11) NOT NULL,
  `week` text NOT NULL,
  `productid` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `shop` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fullprice_report_shopid`
--

CREATE TABLE `fullprice_report_shopid` (
  `id` int(11) NOT NULL,
  `shopid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `Product` text NOT NULL,
  `Brand` text NOT NULL,
  `Group` text NOT NULL,
  `Deleted` text NOT NULL,
  `Shop` text NOT NULL,
  `City` text NOT NULL,
  `Address` text NOT NULL,
  `Region` text NOT NULL,
  `Customer` text NOT NULL,
  `Info` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fullprice_report_universal`
--

CREATE TABLE `fullprice_report_universal` (
  `id` int(11) NOT NULL,
  `week` text NOT NULL,
  `productid` int(11) NOT NULL,
  `Product` text NOT NULL,
  `Brand` text NOT NULL,
  `Group` text NOT NULL,
  `Deleted` text NOT NULL,
  `count_sh` int(11) NOT NULL,
  `count_pr` int(11) NOT NULL,
  `rr` double NOT NULL,
  `shop` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fullprice_shops`
--

CREATE TABLE `fullprice_shops` (
  `id` int(11) NOT NULL,
  `week` text NOT NULL,
  `shopid` int(11) NOT NULL,
  `status` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fullprice_shops_count`
--

CREATE TABLE `fullprice_shops_count` (
  `id` int(11) NOT NULL,
  `week` text NOT NULL,
  `count` int(11) NOT NULL,
  `shop` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fullprice_update`
--

CREATE TABLE `fullprice_update` (
  `id` int(11) NOT NULL,
  `week` text NOT NULL,
  `shopid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `shop` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `Product` text NOT NULL,
  `Brand` text NOT NULL,
  `Group` text NOT NULL,
  `Series` text NOT NULL,
  `Deleted` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `kolvo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `shopid` int(11) NOT NULL,
  `Shop` text NOT NULL,
  `City` text NOT NULL,
  `Address` text NOT NULL,
  `Customer` text NOT NULL,
  `Merchandiser` text NOT NULL,
  `Attribute` text NOT NULL,
  `Attribute5` text NOT NULL,
  `Latitude` text NOT NULL,
  `Longtitude` text NOT NULL,
  `Region` text NOT NULL,
  `Info` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `kolvo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `fullprice`
--
ALTER TABLE `fullprice`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fullprice_new`
--
ALTER TABLE `fullprice_new`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fullprice_products_count`
--
ALTER TABLE `fullprice_products_count`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fullprice_report_shopid`
--
ALTER TABLE `fullprice_report_shopid`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fullprice_report_universal`
--
ALTER TABLE `fullprice_report_universal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fullprice_shops`
--
ALTER TABLE `fullprice_shops`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fullprice_shops_count`
--
ALTER TABLE `fullprice_shops_count`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fullprice_update`
--
ALTER TABLE `fullprice_update`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productid` (`productid`),
  ADD KEY `productid_2` (`productid`);

--
-- Индексы таблицы `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shopid` (`shopid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `fullprice`
--
ALTER TABLE `fullprice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120081;

--
-- AUTO_INCREMENT для таблицы `fullprice_new`
--
ALTER TABLE `fullprice_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fullprice_products_count`
--
ALTER TABLE `fullprice_products_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fullprice_report_shopid`
--
ALTER TABLE `fullprice_report_shopid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fullprice_report_universal`
--
ALTER TABLE `fullprice_report_universal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fullprice_shops`
--
ALTER TABLE `fullprice_shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fullprice_shops_count`
--
ALTER TABLE `fullprice_shops_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fullprice_update`
--
ALTER TABLE `fullprice_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11287;

--
-- AUTO_INCREMENT для таблицы `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4826;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
