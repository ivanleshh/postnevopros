-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 25 2024 г., 01:36
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `postnevopros`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE `comment` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `post_id` int UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `text`, `created_at`, `parent_id`) VALUES
(2, 2, 4, 'Добрый день!', '2024-12-24 20:31:56', NULL),
(3, 2, 4, 'Интересный пост', '2024-12-24 20:33:15', NULL),
(4, 3, 4, 'Здравствуйте!', '2024-12-24 20:34:41', 2),
(6, 3, 4, 'Благодарю', '2024-12-24 20:35:33', 3),
(7, 4, 4, 'Php', '2024-12-24 20:44:37', NULL),
(8, 3, 4, 'Текст комментария', '2024-12-24 22:34:19', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `theme_id` int UNSIGNED DEFAULT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int UNSIGNED NOT NULL,
  `preview` varchar(255) NOT NULL,
  `status_id` int UNSIGNED NOT NULL,
  `other_theme` varchar(255) DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cancel_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`id`, `title`, `theme_id`, `text`, `created_at`, `user_id`, `preview`, `status_id`, `other_theme`, `photo`, `updated_at`, `cancel_reason`) VALUES
(1, 'Окунь', NULL, 'Корабли лавировали лавировали да не вылавировали Корабли лавировали лавировали да не вылавировали Корабли лавировали лавировали да не вылавировали Корабли лавировали лавировали да не вылавировали Корабли лавировали лавировали да не вылавировали Корабли лавировали лавировали да не вылавировали Корабли лавировали лавировали да не вылавировали Корабли лавировали лавировали да не вылавировали Корабли лавировали лавировали да не вылавировали', '2024-12-18 08:55:39', 3, 'Огромный', 4, 'Рыбы', '3_1734512204_YozVxhanxVklfVyuGBvywOCd08UQgH2I.jpg', '2024-12-24 20:34:00', NULL),
(3, 'Жираф', NULL, '123', '2024-12-24 20:14:44', 3, '123', 3, 'Животные', '3_1735071284_irqv1yygiD36_BQn8EeoctuqspM1_syA.png', '2024-12-24 20:28:42', NULL),
(4, 'Php', 1, 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet', '2024-12-24 20:16:28', 3, 'preview', 3, NULL, '3_1735071388_YIwGSxTWdGgA8GLfEAExHCvhtnMbzu-9.jpg', '2024-12-24 20:28:29', NULL),
(5, 'Коньки', NULL, ' Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест Тест', '2024-12-24 20:31:10', 2, 'Превью', 4, 'Спорт', '2_1735072270_MtBAwzrqde-cww5eWW7Zc9ts_CdmZHNz.jpg', '2024-12-24 20:31:20', NULL),
(6, 'Тест', 1, 'тест превьютест превьютест превью', '2024-12-24 20:42:43', 4, 'тест превью', 2, NULL, '4_1735072963_t3MvRgzBwE2Ko8GyqDR1EqYepIQ4JMmi.jpg', '2024-12-24 22:27:47', '123');

-- --------------------------------------------------------

--
-- Структура таблицы `reaction`
--

CREATE TABLE `reaction` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `post_id` int UNSIGNED NOT NULL,
  `reaction` enum('-1','0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `reaction`
--

INSERT INTO `reaction` (`id`, `user_id`, `post_id`, `reaction`) VALUES
(5, 2, 1, '1'),
(7, 2, 4, '1'),
(8, 2, 3, '-1'),
(9, 4, 4, '1'),
(10, 4, 3, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `title`) VALUES
(1, 'администратор системы'),
(2, 'автор');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `title`) VALUES
(1, 'Редактирование'),
(2, 'Запрещён'),
(3, 'Одобрен'),
(4, 'Модерация');

-- --------------------------------------------------------

--
-- Структура таблицы `theme`
--

CREATE TABLE `theme` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `theme`
--

INSERT INTO `theme` (`id`, `title`) VALUES
(1, 'Зима'),
(2, 'Осень'),
(3, 'Лето'),
(4, 'Весна');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `auth_key` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int UNSIGNED NOT NULL,
  `is_block` tinyint NOT NULL DEFAULT '0',
  `expire_block` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `patronymic`, `login`, `email`, `phone`, `password`, `avatar`, `auth_key`, `created_at`, `role_id`, `is_block`, `expire_block`) VALUES
(1, 'Валерий', 'Валерьевич', 'Валерьев', 'admin-bloger', 'admin@admin.admin', '+7(243)-435-24-52', '$2y$13$aRy9hnAztBKQQDjKDsOkFehaZ0pWE.EIl3fBlfAjhB0b9aWoKouXS', NULL, 'rBZ05540urCtcXQR_NiVwPF3qMdaqbBV', '2024-12-18 08:38:49', 1, 0, NULL),
(2, 'Иванов', 'Иван', '', 'user', 'user@user.user', '+7(423)-534-52-31', '$2y$13$qO6pxsN7sgPZl5r8VSCuQOUfI4Kao6PxQiygmeWELznslky371hWW', '7azZ4RMaXLGcrxQ6FCAWE3bv-8yAy3x6_1733656373.jpg', 'MSLbXYazIVNes94ENt1uir1BgIh4sSzC', '2024-12-18 08:40:16', 2, 0, NULL),
(3, 'Николай', 'Николаевич', '', 'userr', 'userr@userr.userr', '+7(423)-523-51-51', '$2y$13$Rtosh4LocCT8BnDzV0YxWOi6Extl9oQARps6XazvVnMD5qKaygxHu', '31_1733591207_WDVap81P-kHiQJiLbzfBe_hIoi21o3F_.png', 'y60fM4jD3kzFH4bgzoQEDS8G3Wa9FSPq', '2024-12-18 08:50:46', 2, 0, NULL),
(4, 'Тест', 'Тест', '', 'test', 'test@test.test', '+7(231)-414-14-11', '$2y$13$kpEnsdaaBHZojVg9nt1d0emmlz5BEbuebwrXYAu6KCB7EgtadBOnC', NULL, 'MJO7WU2hs0rTR5140xdkFFIjBOtcaj_I', '2024-12-24 20:41:50', 2, 0, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `theme_id` (`theme_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `reaction`
--
ALTER TABLE `reaction`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `reaction`
--
ALTER TABLE `reaction`
  ADD CONSTRAINT `reaction_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reaction_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
