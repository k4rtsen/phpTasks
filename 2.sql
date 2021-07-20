-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 20 2021 г., 00:39
-- Версия сервера: 5.7.33-log
-- Версия PHP: 7.1.33

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
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `a_price`
--

CREATE TABLE `a_price` (
  `ID` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `type_price` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `a_product`
--

CREATE TABLE `a_product` (
  `ID` int(10) UNSIGNED NOT NULL,
  `code` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `a_category`
--
ALTER TABLE `a_category`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `parentID` (`parentID`);

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
  ADD KEY `id_category` (`id_category`);

--
-- Индексы таблицы `a_property`
--
ALTER TABLE `a_property`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `product_code` (`product_code`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `a_category`
--
ALTER TABLE `a_category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `a_price`
--
ALTER TABLE `a_price`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `a_product`
--
ALTER TABLE `a_product`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `a_property`
--
ALTER TABLE `a_property`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `a_category`
--
ALTER TABLE `a_category`
  ADD CONSTRAINT `a_category_ibfk_1` FOREIGN KEY (`parentID`) REFERENCES `a_category` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `a_price`
--
ALTER TABLE `a_price`
  ADD CONSTRAINT `a_price_ibfk_1` FOREIGN KEY (`product_code`) REFERENCES `a_product` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `a_product`
--
ALTER TABLE `a_product`
  ADD CONSTRAINT `a_product_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `a_category` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `a_property`
--
ALTER TABLE `a_property`
  ADD CONSTRAINT `a_property_ibfk_1` FOREIGN KEY (`product_code`) REFERENCES `a_product` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
