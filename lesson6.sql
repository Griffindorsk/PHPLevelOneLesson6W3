-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 20 2021 г., 14:52
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lesson6`
--

-- --------------------------------------------------------

--
-- Структура таблицы `catalogue`
--

CREATE TABLE `catalogue` (
  `id` int NOT NULL,
  `pr_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pr_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `size` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color` tinytext NOT NULL,
  `photo` tinytext NOT NULL,
  `price` float NOT NULL,
  `on_stock` smallint NOT NULL,
  `selected` smallint NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE `colors` (
  `id_color` tinyint NOT NULL,
  `color` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id_color`, `color`) VALUES
(1, 'белый'),
(2, 'бирюзово-зеленый'),
(3, 'бирюзовый'),
(4, 'желтый'),
(5, 'красный'),
(6, 'кремовый'),
(7, 'оранжевый'),
(8, 'темно-бирюзовый'),
(9, 'темно-желтый'),
(10, 'темно-зеленый'),
(11, 'фиолетовый'),
(12, 'черный');

-- --------------------------------------------------------

--
-- Структура таблицы `descriptions`
--

CREATE TABLE `descriptions` (
  `id_description` tinyint NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `descriptions`
--

INSERT INTO `descriptions` (`id_description`, `description`) VALUES
(1, 'Футболка из натурального хлопка премиум класса, прямого кроя и округлым вырезом - настоящая классика. Выполнена из плотного и мягкого хлопкового полотна приятного к телу. Прямой крой подходит ко всем видам фигур - что подтверждают отзывы наших довольных покупателей. Авторский принт подчеркивает ее уникальность. Не скатывается, сохраняет форму и цвет после множества стирок.'),
(2, 'Хенли – простая модель с длинными рукавами, без воротника, но с глубоким вырезом на пуговицах, из тонкого хлопка.'),
(3, 'Футболка с круглым вырезом однотонная.'),
(4, 'Футболка с круглым вырезом однотонная с принтом.'),
(5, 'Модель с воротником отложного типа, классическая, с длинным рукавом.');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` tinyint NOT NULL,
  `photoname` tinytext NOT NULL,
  `color` tinytext NOT NULL,
  `imagepath` text NOT NULL,
  `iconpath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `photoname`, `color`, `imagepath`, `iconpath`) VALUES
(1, '01_t_shirt_black.jpg', 'черный', 'products/images/', 'products/icons/'),
(2, '02_t_shirt_darkgreen.jpg', 'темно-зеленый', 'products/images/', 'products/icons/'),
(3, '03_t_shirt_cian.jpg', 'бирюзовый', 'products/images/', 'products/icons/'),
(4, '04_t_shirt_ocean.jpg', 'бирюзово-зеленый', 'products/images/', 'products/icons/'),
(5, '05_t_shirt_violet.jpg', 'фиолетовый', 'products/images/', 'products/icons/'),
(6, '06_t_shirt_bisque.jpg', 'кремовый', 'products/images/', 'products/icons/'),
(7, '07_t_shirt_brightyellow.jpg', 'желтый', 'products/images/', 'products/icons/'),
(8, '08_t_shirt_darkocean.jpg', 'темно-бирюзовый', 'products/images/', 'products/icons/'),
(9, '09_t_shirt_white.jpg', 'белый', 'products/images/', 'products/icons/'),
(10, '10_t_shirt_darkyellow.jpg', 'темно-желтый', 'products/images/', 'products/icons/'),
(11, '11_t_shirt_simplyred.jpg', 'красный', 'products/images/', 'products/icons/'),
(12, '12_t_shirt_orange.jpg', 'оранжевый', 'products/images/', 'products/icons/');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `catalogue`
--
ALTER TABLE `catalogue`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id_color`);

--
-- Индексы таблицы `descriptions`
--
ALTER TABLE `descriptions`
  ADD PRIMARY KEY (`id_description`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `catalogue`
--
ALTER TABLE `catalogue`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT для таблицы `colors`
--
ALTER TABLE `colors`
  MODIFY `id_color` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `descriptions`
--
ALTER TABLE `descriptions`
  MODIFY `id_description` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
