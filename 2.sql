-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 13 2021 г., 21:08
-- Версия сервера: 5.7.33
-- Версия PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_samson`
--

-- --------------------------------------------------------

--
-- Структура таблицы `a_category`
--

CREATE TABLE `a_category` (
  `ID` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `a_category`
--

INSERT INTO `a_category` (`ID`, `name`) VALUES
(28, 'Бумага'),
(29, 'Принтеры'),
(30, 'МФУ');

-- --------------------------------------------------------

--
-- Структура таблицы `a_price`
--

CREATE TABLE `a_price` (
  `ID` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `typePrice` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `a_price`
--

INSERT INTO `a_price` (`ID`, `product_code`, `typePrice`, `price`) VALUES
(121, 201, 'Базовая', 11.5),
(122, 201, 'Москва', 12.5),
(123, 202, 'Базовая', 18.5),
(124, 202, 'Москва', 22.5),
(125, 302, 'Базовая', 3010),
(126, 302, 'Москва', 3500),
(127, 305, 'Базовая', 3310),
(128, 305, 'Москва', 2999);

-- --------------------------------------------------------

--
-- Структура таблицы `a_product`
--

CREATE TABLE `a_product` (
  `ID` int(10) UNSIGNED NOT NULL,
  `code` int(11) NOT NULL,
  `product_type` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `a_product`
--

INSERT INTO `a_product` (`ID`, `code`, `product_type`, `name`) VALUES
(1, 201, 28, 'Бумага А4'),
(2, 202, 28, 'Бумага А3'),
(3, 302, 30, 'Принтер Canon'),
(4, 305, 30, 'Принтер HP');

-- --------------------------------------------------------

--
-- Структура таблицы `a_property`
--

CREATE TABLE `a_property` (
  `ID` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `name_property` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `val_property` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `a_property`
--

INSERT INTO `a_property` (`ID`, `product_code`, `name_property`, `val_property`) VALUES
(18, 201, 'density', '100'),
(19, 201, 'whiteness', '150'),
(20, 202, 'density', '90'),
(21, 202, 'whiteness', '100'),
(22, 302, 'format', 'A4'),
(23, 302, 'format', 'A3'),
(24, 302, 'type', 'Лазерный'),
(25, 305, 'format', 'A3'),
(26, 305, 'type', 'Лазерный');

-- --------------------------------------------------------

--
-- Структура таблицы `rubricator`
--

CREATE TABLE `rubricator` (
  `parentID` int(11) NOT NULL,
  `childID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `a_category`
--
ALTER TABLE `a_category`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `a_price`
--
ALTER TABLE `a_price`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `product_code` (`product_code`);

--
-- Индексы таблицы `a_product`
--
ALTER TABLE `a_product`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `a_product_ibfk_1` (`product_type`);

--
-- Индексы таблицы `a_property`
--
ALTER TABLE `a_property`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `rubricator`
--
ALTER TABLE `rubricator`
  ADD KEY `parentID` (`parentID`),
  ADD KEY `childID` (`childID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `a_category`
--
ALTER TABLE `a_category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `a_price`
--
ALTER TABLE `a_price`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT для таблицы `a_product`
--
ALTER TABLE `a_product`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `a_property`
--
ALTER TABLE `a_property`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
