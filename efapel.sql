-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 17 2018 г., 11:18
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
-- База данных: `efapel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE `colors` (
  `colorID` int(11) NOT NULL,
  `text` text NOT NULL,
  `langID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`colorID`, `text`, `langID`) VALUES
(1, 'WHITE', 1),
(1, 'БЕЛЫЙ', 2),
(1, 'ՍՊԻՏԱԿ', 3),
(2, 'IVORY', 1),
(2, 'ЦВЕТ СЛОНОВОЙ КОСТИ', 2),
(2, 'ՓՂՈՍԿՐԻ ԳՈՒՅՆ', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `default_colors`
--

CREATE TABLE `default_colors` (
  `seriesID` int(11) NOT NULL,
  `modelID` int(11) NOT NULL,
  `default_colorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `default_colors`
--

INSERT INTO `default_colors` (`seriesID`, `modelID`, `default_colorID`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `goodID` int(11) NOT NULL,
  `part_number` varchar(12) NOT NULL,
  `good_despID` int(11) NOT NULL,
  `good_typeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`goodID`, `part_number`, `good_despID`, `good_typeID`) VALUES
(1, '90910 TBR', 1, 1),
(2, '90920 TBR', 2, 1),
(3, '90930 TBR', 3, 1),
(4, '90940 TBR', 4, 1),
(5, '90950 TBR', 5, 1),
(6, '90910 TMF', 6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `goodTypes`
--

CREATE TABLE `goodTypes` (
  `goodTypeID` int(11) NOT NULL,
  `text` text NOT NULL,
  `langID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goodTypes`
--

INSERT INTO `goodTypes` (`goodTypeID`, `text`, `langID`) VALUES
(1, 'Frame', 1),
(1, 'Рамка\r\n', 2),
(1, 'Շրջանակ\r\n', 3),
(2, 'Mecanism\r\n', 1),
(2, 'Механизм\r\n', 2),
(2, 'Մեխանիզմ\r\n', 3),
(3, 'Cover\r\n', 1),
(3, 'Крышка', 2),
(3, 'Պատյան', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `good_colors`
--

CREATE TABLE `good_colors` (
  `goodID` int(11) NOT NULL,
  `colorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `good_colors`
--

INSERT INTO `good_colors` (`goodID`, `colorID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `good_description`
--

CREATE TABLE `good_description` (
  `good_despID` int(11) NOT NULL,
  `text` text NOT NULL,
  `langID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `good_description`
--

INSERT INTO `good_description` (`good_despID`, `text`, `langID`) VALUES
(1, 'SINGLE FRAME WHITE', 1),
(1, 'БЕЛАЯ ОДИНАРНАЯ РАМКА', 2),
(1, 'ՍՊԻՏԱԿ ՄԵԿ ՏԵՂԱՆՈՑ ՇՐՋԱՆԱԿ', 3),
(2, 'DOUBLE FRAME WHITE', 1),
(2, 'БЕЛАЯ ДВОЙНАЯ РАМКА', 2),
(2, 'ՍՊԻՏԱԿ ԵՐԿՈՒ ՏԵՂԱՆՈՑ ՇՐՋԱՆԱԿ', 3),
(3, 'TRIPLE FRAME WHITE', 1),
(3, 'БЕЛАЯ ТРОЙНАЯ РАМКА', 2),
(3, 'ՍՊԻՏԱԿ ԵՐԵՔ ՏԵՂԱՆՈՑ ՇՐՋԱՆԱԿ', 3),
(4, 'FOUR-GANG FRAME WHITE', 1),
(4, 'FOUR-GANG FRAME WHITE RUS', 2),
(4, 'ՍՊԻՏԱԿ ՉՈՐՍ ՏԵՂԱՆՈՑ ՇՐՋԱՆԱԿ', 3),
(5, 'FIVE-GANG FRAME WHITE', 1),
(5, 'FIVE-GANG FRAME WHITE RUS', 2),
(5, 'ՍՊԻՏԱԿ ՀԻՆԳ ՏԵՂԱՆՈՑ ՇՐՋԱՆԱԿ', 3),
(6, 'SINGLE FRAME IVORY', 1),
(6, 'SINGLE FRAME IVORY RUS', 2),
(6, 'ՓՂՈՍԿՐԵ ՄԵԿ ՏԵՂԱՆՈՑ ՇՐՋԱՆԱԿ', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `good_mecanisms`
--

CREATE TABLE `good_mecanisms` (
  `goodID` int(11) NOT NULL,
  `mecanismID` int(11) NOT NULL,
  `goodTypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `good_models`
--

CREATE TABLE `good_models` (
  `goodID` int(11) NOT NULL,
  `modelID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `good_models`
--

INSERT INTO `good_models` (`goodID`, `modelID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `good_series`
--

CREATE TABLE `good_series` (
  `goodID` int(11) NOT NULL,
  `seriesID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `good_series`
--

INSERT INTO `good_series` (`goodID`, `seriesID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `good_size`
--

CREATE TABLE `good_size` (
  `goodID` int(11) NOT NULL,
  `v_size` int(11) NOT NULL,
  `h_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `good_size`
--

INSERT INTO `good_size` (`goodID`, `v_size`, `h_size`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--

CREATE TABLE `languages` (
  `langID` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`langID`, `text`) VALUES
(1, 'English'),
(2, 'Russian'),
(3, 'Armenian');

-- --------------------------------------------------------

--
-- Структура таблицы `mecanisms`
--

CREATE TABLE `mecanisms` (
  `mecanismID` int(11) NOT NULL,
  `text` text NOT NULL,
  `langID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `models`
--

CREATE TABLE `models` (
  `modelID` int(11) NOT NULL,
  `text` text NOT NULL,
  `langID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `models`
--

INSERT INTO `models` (`modelID`, `text`, `langID`) VALUES
(1, 'Base', 1),
(1, 'Базовый', 2),
(1, 'Բազային', 3),
(2, 'Aquarella', 1),
(2, 'Акриловая', 2),
(2, 'Ակրիլային', 3),
(3, 'Animato', 1),
(3, 'Анимато', 2),
(3, 'Անիմաթո', 3),
(4, 'Cristal', 1),
(4, 'Кристальный', 2),
(4, 'Բյուրեղյա', 3),
(5, 'Metallo', 1),
(5, 'Металло', 2),
(5, 'Մետալո', 3),
(6, 'Arbore', 1),
(6, 'Арборе', 2),
(6, 'Արբորե', 3),
(7, 'Petra', 1),
(7, 'Петра', 2),
(7, 'Պետրա', 3),
(8, 'Classic', 1),
(8, 'Классический', 2),
(8, 'Դասական', 3),
(9, 'Ambient', 1),
(9, 'Внешний', 2),
(9, 'Արտաքին', 3),
(10, 'Metal', 1),
(10, 'Металлический', 2),
(10, 'Մետալիկ', 3),
(11, 'Wood', 1),
(11, 'Дерево', 2),
(11, 'Փայտ', 3),
(12, 'Standart', 1),
(12, 'Стандартный', 2),
(12, 'Ստանդարտ', 3),
(13, 'Metalized', 1),
(13, 'Металлизированный', 2),
(13, 'Մետաղական', 3),
(14, 'Quadro 45', 1),
(14, 'Квадро 45', 2),
(14, 'Կվադրո 45', 3),
(15, 'Quadro 45 SV', 1),
(15, 'Квадро 45 SV', 2),
(15, 'Կվադրո 45 SV', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `model_colors`
--

CREATE TABLE `model_colors` (
  `modelID` int(11) NOT NULL,
  `colorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `model_colors`
--

INSERT INTO `model_colors` (`modelID`, `colorID`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `prices`
--

CREATE TABLE `prices` (
  `priceID` int(11) NOT NULL,
  `text` text NOT NULL,
  `langID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `price_goods`
--

CREATE TABLE `price_goods` (
  `priceID` int(11) NOT NULL,
  `goodID` int(11) NOT NULL,
  `cost` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `series`
--

CREATE TABLE `series` (
  `seriesID` int(11) NOT NULL,
  `text` text NOT NULL,
  `langID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `series`
--

INSERT INTO `series` (`seriesID`, `text`, `langID`) VALUES
(1, 'Logus 90', 1),
(1, 'Логус 90', 2),
(1, 'Լոգուս 90', 3),
(2, 'Sirius 70', 1),
(2, 'Сириус 70', 2),
(2, 'Սիրիուս 70', 3),
(3, 'Apollo 5000', 1),
(3, 'Аполло 5000', 2),
(3, 'Ապոլլո 5000', 3),
(4, 'Quadro 45', 1),
(4, 'Квадро 45', 2),
(4, 'Կվադրո 45', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `series_model`
--

CREATE TABLE `series_model` (
  `seriesID` int(11) NOT NULL,
  `modelID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `series_model`
--

INSERT INTO `series_model` (`seriesID`, `modelID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(3, 12),
(3, 13),
(4, 14),
(4, 15);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`colorID`,`langID`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`goodID`);

--
-- Индексы таблицы `goodTypes`
--
ALTER TABLE `goodTypes`
  ADD PRIMARY KEY (`goodTypeID`,`langID`);

--
-- Индексы таблицы `good_description`
--
ALTER TABLE `good_description`
  ADD PRIMARY KEY (`good_despID`,`langID`);

--
-- Индексы таблицы `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`langID`);

--
-- Индексы таблицы `mecanisms`
--
ALTER TABLE `mecanisms`
  ADD PRIMARY KEY (`mecanismID`,`langID`);

--
-- Индексы таблицы `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`modelID`,`langID`);

--
-- Индексы таблицы `model_colors`
--
ALTER TABLE `model_colors`
  ADD PRIMARY KEY (`modelID`,`colorID`);

--
-- Индексы таблицы `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`priceID`,`langID`);

--
-- Индексы таблицы `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`seriesID`,`langID`);

--
-- Индексы таблицы `series_model`
--
ALTER TABLE `series_model`
  ADD PRIMARY KEY (`seriesID`,`modelID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `goodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
