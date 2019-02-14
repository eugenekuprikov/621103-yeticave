-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 13 2019 г., 02:15
-- Версия сервера: 5.7.23-log
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `621103_yeticave_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `id` int(7) UNSIGNED NOT NULL,
  `user_id` int(7) UNSIGNED NOT NULL,
  `lot_id` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(7) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Доски и лыжи'),
(2, 'Крепления'),
(3, 'Ботинки'),
(4, 'Одежда'),
(5, 'Инструменты'),
(6, 'Разное');

-- --------------------------------------------------------

--
-- Структура таблицы `lots`
--

CREATE TABLE `lots` (
  `id` int(7) UNSIGNED NOT NULL,
  `category_id` int(7) UNSIGNED NOT NULL,
  `author_id` int(7) UNSIGNED NOT NULL,
  `winner_id` int(7) UNSIGNED NOT NULL,
  `date_creation` timestamp NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `initial_price` int(7) UNSIGNED NOT NULL,
  `completion_date` timestamp NOT NULL,
  `step_rate` int(7) UNSIGNED NOT NULL,
  `picture_link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lots`
--

INSERT INTO `lots` (`id`, `category_id`, `author_id`, `winner_id`, `date_creation`, `name`, `description`, `initial_price`, `completion_date`, `step_rate`, `picture_link`) VALUES
(1, 1, 1, 1, '2019-02-11 02:00:00', '2014 Prossignol District snowboard premier', 'Отличное качество', 10999, '2019-02-11 16:00:00', 100, 'img/lot-1.jpg'),
(2, 1, 2, 1, '2019-02-01 04:30:00', 'DC Ply Mens 2016/2017 Snowboard', 'Новая модель, не была в использовании', 159999, '2019-02-20 08:10:00', 1000, 'img/lot-2.jpg'),
(3, 2, 3, 2, '2019-02-05 03:18:00', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Выполнены из высококачественного металла, подходят для любой модели лыж', 8000, '2019-02-25 01:00:00', 100, 'img/lot-3.jpg'),
(4, 3, 4, 3, '2019-02-01 11:00:00', 'Ботинки для сноуборда DC Mutiny Charocal', 'Натуральная кожа, высокое качество', 10999, '2019-02-10 17:30:00', 100, 'img/lot-4.jpg'),
(5, 4, 1, 4, '2019-02-07 06:15:00', 'Куртка для сноуборда DC Mutiny Charocal', 'Куртка современной модели, с влагоотталкивающим эффектом', 7500, '2019-02-27 11:45:00', 100, 'img/lot-5.jpg'),
(6, 6, 2, 2, '2019-02-03 07:30:00', 'Маска Oakley Canopy', 'Легкая, плотно прилегает к лицу, пропускает воздух', 5400, '2019-02-28 18:00:00', 100, 'img/lot-6.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `rates`
--

CREATE TABLE `rates` (
  `id` int(7) UNSIGNED NOT NULL,
  `lot_id` int(7) UNSIGNED NOT NULL,
  `user_id` int(7) UNSIGNED NOT NULL,
  `date_rate` timestamp NOT NULL,
  `summ_rate` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rates`
--

INSERT INTO `rates` (`id`, `lot_id`, `user_id`, `date_rate`, `summ_rate`) VALUES
(1, 1, 1, '2019-02-11 15:00:00', 13000),
(2, 3, 2, '2019-02-10 11:40:00', 10400),
(3, 2, 3, '2019-02-08 07:11:00', 180000);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(7) UNSIGNED NOT NULL,
  `lot_id` int(7) UNSIGNED NOT NULL,
  `rate_id` int(7) UNSIGNED NOT NULL,
  `reg_date` timestamp NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  `contacts` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `lot_id`, `rate_id`, `reg_date`, `email`, `name`, `password`, `avatar`, `contacts`) VALUES
(1, 1, 1, '2019-01-31 20:00:00', 'abc@gmail.com', 'Даниил', '123', 'daniil_001.com', 'Москва'),
(2, 3, 2, '2019-02-02 08:00:00', 'ddfe@gmail.com', 'Денис', '456', 'den_01', 'Тула'),
(3, 2, 3, '2019-02-03 02:50:00', 'adfc@gmail.com', 'Ян', '789', 'yanyan', 'Владивосток');

-- --------------------------------------------------------

--
-- Структура таблицы `winners`
--

CREATE TABLE `winners` (
  `id` int(7) UNSIGNED NOT NULL,
  `user_id` int(7) UNSIGNED NOT NULL,
  `lot_id` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Индексы таблицы `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `winners`
--
ALTER TABLE `winners`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Получаем все категории
--
SELECT * FROM categories 

--
-- Получаем открытые лоты
--
SELECT c.name, l.id, l.name, initial_price, picture_link FROM lots l 
JOIN categories c ON l.category_id = c.id 
WHERE completion_date BETWEEN '2019-02-12' AND '2019-03-01'

--
-- Показываем лот по его id с названием категории
--
SELECT c.name, l.id, date_creation, l.name, description, initial_price, completion_date, step_rate, picture_link FROM lots l 
JOIN categories c ON l.category_id = c.id 
WHERE l.id = 2

--
-- Обновляем название лота по его идентификатору
--
UPDATE lots SET name = '2014 Prossignol District snowboard premier' 
WHERE id = 1

--
-- Получаем список самых свежих ставок для лота по его идентификатору
--
SELECT l.name, r.id, date_rate, summ_rate FROM rates r 
JOIN lots l ON r.lot_id = l.id 
WHERE date_rate BETWEEN '2019-02-10 11-30' AND '2019-02-15 16-00' AND l.id = 3
