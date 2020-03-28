-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 28 2020 г., 12:47
-- Версия сервера: 5.6.43
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `user_management_system`
--

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'Standart user', ''),
(2, 'Administrator', '{\"admin\":1}');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` text NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '1',
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `group_id`, `date`) VALUES
(1, '123456', '123456@ua.fm', '$2y$10$Ym.CkEr6zE.Z9WDccfiLpek1woOamQYS4HtN3gDZ7OK4H3XyeoAhq', 'ккекек', 1, '23/03/2020'),
(4, '1234560', '1234560@ua.fm', '$2y$10$S0yQAlZeujajB1PjtCEkIuIMFFCDcFfbfA6jUTTnfITk3Z1.pFKje', '55555', 2, '25/03/2020'),
(6, '123456000', '123456000@ua.fm', '$2y$10$nhiAunQL8i5JnE.HE4a3IOMwXGQtBwDHo06njx3Tuf5j7yI7YqpCm', '', 1, '27/03/2020'),
(7, '1234560000', '1234560000@ua.fm', '$2y$10$KlSTCQ8fPeZB909w.Z33lu5amy8spDTDDR.C9IjKQD8tpYvjGTHBm', 'проверка статуса', 1, '27/03/2020'),
(13, 'пароль admin', 'admin@admin.ru', '$2y$10$kHfpu1Xo7JuUIkBbwnGwLuOaRBDSVSFLFw/pqy4XAe25vO1KpK5vu', 'пароль admin login admin@admin.ru', 2, '27/03/2020'),
(14, '12345600', '12345600@ua.fm', '$2y$10$GaT/HAxkNvlmK0BRKdwkxeFux.QYLBZy11pqcQAxr6YkQ4Xwy0mvq', '44444444', 1, '28/03/2020'),
(15, '123450000000', '123450000000@ua.fm', '$2y$10$hZvbAuHtUmqV8gBqnrVNq.SnR6koBAisct0h5d39GH7W1SLBEd3ve', '', 1, '28/03/2020');

-- --------------------------------------------------------

--
-- Структура таблицы `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `hash`) VALUES
(1, 1, '1644dd75f9fcc7422cf1c66a41995eb81f84a6c3cf88bcc0ca7407bbb1b2feca'),
(2, 4, '2bd9b8cfbbe56b3ab30a78c4509a78413743156aeb0fa749d3a70bcea99dcd8f'),
(3, 15, 'f952cc8fee41ae0b095a7c313a54868c1b54fc36eb19b59bbddb54efa366577e');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
