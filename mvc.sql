-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 27 2022 г., 22:18
-- Версия сервера: 8.0.24
-- Версия PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mvc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `block_users`
--

CREATE TABLE `block_users` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `block_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `block_users`
--

INSERT INTO `block_users` (`id`, `user_id`, `block_time`) VALUES
(8, 26, '2022-07-31 10:12:00'),
(9, 27, '2022-07-30 10:22:00');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `name`, `title`, `message`, `created_at`, `status`) VALUES
(13, 'Andridsdsada', 'sadsadasdasd', 'sadsadasdasd', '2022-08-25 12:50:14', 0),
(14, 'Andridsdsada', 'Andridsdsada', 'Andridsdsada', '2022-08-20 12:50:16', 0),
(15, 'Andridsdsada', 'Andridsdsada', 'Andridsdsada', '2022-08-28 12:50:19', 0),
(16, 'prevRefprevRef', 'prevRefprevRef', 'prevRefprevRef', '2022-08-28 12:57:41', 0),
(17, 'prevRefprevRef', 'prevRefprevRef', 'prevRefprevRefprevRef', '2022-08-21 12:57:45', 0),
(18, 'prevRefprevRef', 'prevRefprevRef', 'prevRefprevRefprevRef', '2022-07-29 12:57:47', 0),
(19, 'prevRefprevRef', 'prevRefprevRef', 'prevRefprevRefprevRef', '2022-07-29 12:57:49', 0),
(20, 'prevRefprevRefprevRef', 'prevRefprevRefprevRef', 'prevReprevReff', '2022-06-28 12:57:55', 0),
(21, 'Andrih132', '1232131232131232', '213213213213213', '2022-08-27 00:05:23', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `url_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `url_key`) VALUES
(3, 'My first Lorem Ipsum', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,\r\nmolestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum\r\nnumquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium\r\noptio, eaque rerum! Provident similique accusantium nemo autem. Veritatis\r\nobcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam\r\nnihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,\r\ntenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,\r\nquia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos \r\nsapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam\r\nrecusandae alias error harum maxime adipisci amet laborum. Perspici', 'lorem_ipsuma'),
(21, 'About Aboba', 'LROejfiuewnhfnvmbmbekeieeeoodck,,vmvsmakkewqpoeppdpcc,vbmgkflfd', 'About_Aboba');

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `request_role` int DEFAULT NULL,
  `state` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `request_role`, `state`) VALUES
(48, 33, 10, 1),
(61, 34, 10, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `permissions`) VALUES
(1, 'Admin', '[\"delete_messages\",\"edit_messages\", \"control_pages\", \"create_page\",  \"add_messages\",\"block_users\",\"add_roles\",\"edit_roles\", \"rise_users\", \"modify_roles\", \"statistics\"]'),
(2, 'User', '[\"add_messages\",\"send_rise_request\"]'),
(3, 'Vasya123+', '[\"block_users\"]'),
(28, 'Bondar', '[\"delete_messages\",\"block_users\",\"modify_roles\",\"control_pages\"]');

-- --------------------------------------------------------

--
-- Структура таблицы `statistics`
--

CREATE TABLE `statistics` (
  `visits` int NOT NULL,
  `pass_errors` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `statistics`
--

INSERT INTO `statistics` (`visits`, `pass_errors`) VALUES
(102, 14);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `login`, `password`, `role`) VALUES
(5, 'dmitro.getsko@gmail.com', 'dimka1', '$2y$10$24HR5EjWkpvSiaOCt95pD.CfvUKYMLGfLajyA7skKp38BLEtiHTvO', 1),
(28, 'erere@gmail.com', 'dimka5', '$2y$10$0XrZAdJv/tGVs7zArnWAouVn/MOBOaysBWC1bW7wkDv9m5IBWCzkW', 9),
(29, '1ere@gmail.com', 'aboba', '$2y$10$gGlZPGcD4Xuf/jc9HnkBUOHAIZEM.7aney2Q2/Z4lOvrE0294rAtq', 2),
(30, '223@34', 'xxxx', '$2y$10$ucq4nCFKXdvHhAk006zutebZi95Xhg0zWOjSEUx17WDK2OGDFb2Ui', 2),
(31, '123@32', 'xxxz', '$2y$10$.zzvyj8Edr7PqEnMrzlKeO4U5BFCiorCPGQwKM1xgqkc1ZPcOXjv2', 2),
(32, 'eresre@gmail.com', '123213', '$2y$10$/ap4Apml1t2uXf5R12ZJTeTnCq3/SRQx0bt4SecvzMp.YuYs.kd5y', 2),
(33, 'aerere@gmail.com', '123123', '$2y$10$tCFMKv2S2QxJE.gr9YwSAu2vYLkiE7EmgISkN8tNDvEJXoZN6u4UW', 2),
(34, '213123dsa@s', 'qwe123', '$2y$10$EuT1b67d7cX57Ev1su6iXupg1qXGSc4oGx0cDZTT0kMkC.yRdHqse', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `block_users`
--
ALTER TABLE `block_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `block_users`
--
ALTER TABLE `block_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
