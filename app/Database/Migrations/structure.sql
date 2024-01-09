-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 10 2020 г., 01:36
-- Версия сервера: 8.0.19
-- Версия PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ytuber`
--

-- --------------------------------------------------------

--
-- Структура таблицы `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `account_type_id` int NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `account_type`
--

DROP TABLE IF EXISTS `account_type`;
CREATE TABLE `account_type` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pattern` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `example` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_english` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `client_js`
--

DROP TABLE IF EXISTS `client_js`;
CREATE TABLE `client_js` (
  `id` int NOT NULL,
  `start_key` varchar(255) NOT NULL,
  `private_key` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int NOT NULL,
  `task_id` int NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `status` tinyint NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `done`
--

DROP TABLE IF EXISTS `done`;
CREATE TABLE `done` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `task_id` int NOT NULL,
  `type_id` int NOT NULL,
  `ip_bin` varbinary(16) NOT NULL,
  `action_cost` decimal(15,3) NOT NULL,
  `cost_rule` int NOT NULL,
  `youtube` int NOT NULL,
  `time` int NOT NULL,
  `check_count` int NOT NULL,
  `check_time` int NOT NULL,
  `expires` int NOT NULL,
  `timeout` int NOT NULL,
  `data` int NOT NULL,
  `domain` tinyint NOT NULL,
  `status` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `geo_city`
--

DROP TABLE IF EXISTS `geo_city`;
CREATE TABLE `geo_city` (
  `id` int NOT NULL,
  `country_id` int NOT NULL,
  `region_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_code` varchar(4) NOT NULL,
  `region_code` varchar(4) NOT NULL,
  `population` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `geo_country`
--

DROP TABLE IF EXISTS `geo_country`;
CREATE TABLE `geo_country` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_english` varchar(255) NOT NULL,
  `iso_2` varchar(2) NOT NULL,
  `iso_3` varchar(3) NOT NULL,
  `iso_n` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `geo_region`
--

DROP TABLE IF EXISTS `geo_region`;
CREATE TABLE `geo_region` (
  `id` int NOT NULL,
  `country_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_code` varchar(4) NOT NULL,
  `iso_code` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `geo_to_task`
--

DROP TABLE IF EXISTS `geo_to_task`;
CREATE TABLE `geo_to_task` (
  `id` int NOT NULL,
  `country_id` int NOT NULL,
  `region_id` int NOT NULL,
  `city_id` int NOT NULL,
  `task_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `loginfail`
--

DROP TABLE IF EXISTS `loginfail`;
CREATE TABLE `loginfail` (
  `ip` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `mailing`
--

DROP TABLE IF EXISTS `mailing`;
CREATE TABLE `mailing` (
  `id` int NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  `sended` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `task_id` int NOT NULL,
  `task_type_id` int NOT NULL,
  `task_time` int NOT NULL,
  `data` text NOT NULL,
  `cost` decimal(15,3) NOT NULL,
  `type` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `paycode`
--

DROP TABLE IF EXISTS `paycode`;
CREATE TABLE `paycode` (
  `id` int NOT NULL,
  `code` varchar(255) NOT NULL,
  `sum` decimal(15,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `system` varchar(255) NOT NULL,
  `payment_system_id` int NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `commission` decimal(15,3) NOT NULL,
  `sum` decimal(15,3) NOT NULL,
  `detail` text NOT NULL,
  `created` int NOT NULL,
  `time` int NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_system`
--

DROP TABLE IF EXISTS `payment_system`;
CREATE TABLE `payment_system` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `system` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payout`
--

DROP TABLE IF EXISTS `payout`;
CREATE TABLE `payout` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `system` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `rub` decimal(15,3) NOT NULL,
  `created` datetime NOT NULL,
  `payed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `penalty`
--

DROP TABLE IF EXISTS `penalty`;
CREATE TABLE `penalty` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment_id` varchar(255) NOT NULL,
  `task_id` int NOT NULL,
  `data` text NOT NULL,
  `cost` decimal(15,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `refund`
--

DROP TABLE IF EXISTS `refund`;
CREATE TABLE `refund` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `task_id` int NOT NULL,
  `value` double NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT '0',
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` int NOT NULL,
  `key` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `type_id` int NOT NULL,
  `report` int NOT NULL,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `total_cost` decimal(15,3) NOT NULL,
  `action_cost` decimal(15,3) NOT NULL,
  `action_done` int NOT NULL,
  `action_fail` int NOT NULL,
  `action_refund` int NOT NULL,
  `hour_limit` int NOT NULL,
  `hour_done` int NOT NULL,
  `youtube` int NOT NULL,
  `youtube_initial` int NOT NULL,
  `youtube_extend` text NOT NULL,
  `extend` longtext NOT NULL,
  `order` decimal(15,6) NOT NULL,
  `added` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `completion` datetime NOT NULL,
  `geo` tinyint(1) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `removed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


--
-- Структура таблицы `task_alternate_ids`
--

DROP TABLE IF EXISTS `task_alternate_ids`;
CREATE TABLE `task_alternate_ids` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `vid` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Структура таблицы `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int NOT NULL,
  `sender` int NOT NULL,
  `recipient` int NOT NULL,
  `sum` decimal(15,4) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_english` varchar(255) NOT NULL,
  `extend` text NOT NULL,
  `hour_limit` int NOT NULL,
  `complete_days` int NOT NULL,
  `complete_waiting_timeout` int NOT NULL,
  `window_pattern` varchar(255) NOT NULL,
  `noty_icon` varchar(255) NOT NULL,
  `noty` varchar(255) NOT NULL,
  `order` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL,
  `banned` int NOT NULL,
  `ban_reason` varchar(255) NOT NULL,
  `gid` varchar(255) NOT NULL,
  `refresh_token` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `moderator` tinyint(1) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `forgot_token` varchar(255) NOT NULL,
  `referrer_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `channel_published` datetime NOT NULL,
  `channel_available` tinyint NOT NULL DEFAULT '1',
  `balance` decimal(15,3) NOT NULL,
  `earned` decimal(15,3) NOT NULL,
  `rub` decimal(15,3) NOT NULL,
  `confirm` varchar(255) NOT NULL,
  `confirm_sended` int NOT NULL,
  `done` int NOT NULL,
  `done_day` int NOT NULL,
  `done_confirmed` int NOT NULL,
  `allow_transaction` tinyint(1) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `sub_news` tinyint(1) NOT NULL DEFAULT '1',
  `sub_transaction` tinyint(1) NOT NULL DEFAULT '1',
  `sub_statistic` tinyint(1) NOT NULL DEFAULT '1',
  `sub_notification` tinyint NOT NULL DEFAULT '1',
  `soc_vk` varchar(255) NOT NULL,
  `soc_twitter` varchar(255) NOT NULL,
  `soc_fb` varchar(255) NOT NULL,
  `domain` smallint NOT NULL,
  `ip` varchar(255) NOT NULL,
  `lastip` varchar(255) NOT NULL,
  `last_mailing_id` int NOT NULL,
  `daily_bonus_received` tinyint(1) NOT NULL,
  `daily_bonus_count` int NOT NULL,
  `recaptcha_score` float DEFAULT NULL,
  `time` datetime NOT NULL,
  `lastseen` datetime NOT NULL,
  `activity` int NOT NULL,
  `activity_updated_at` datetime DEFAULT NULL,
  `test_time` datetime NOT NULL,
  `test_status` tinyint(1) NOT NULL,
  `disabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `client_js`
--
ALTER TABLE `client_js`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `done`
--
ALTER TABLE `done`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time` (`time`),
  ADD KEY `user_id` (`user_id`,`task_id`,`time`) USING BTREE,
  ADD KEY `ip_bin` (`ip_bin`),
  ADD KEY `check_time` (`check_time`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `geo_city`
--
ALTER TABLE `geo_city`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `geo_country`
--
ALTER TABLE `geo_country`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `geo_region`
--
ALTER TABLE `geo_region`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `geo_to_task`
--
ALTER TABLE `geo_to_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`,`region_id`,`city_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Индексы таблицы `loginfail`
--
ALTER TABLE `loginfail`
  ADD KEY `ip` (`ip`),
  ADD KEY `time` (`time`);

--
-- Индексы таблицы `mailing`
--
ALTER TABLE `mailing`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `paycode`
--
ALTER TABLE `paycode`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payment_system`
--
ALTER TABLE `payment_system`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payout`
--
ALTER TABLE `payout`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `penalty`
--
ALTER TABLE `penalty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`comment_id`);

--
-- Индексы таблицы `refund`
--
ALTER TABLE `refund`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `last_activity_idx` (`timestamp`);

--
-- Индексы таблицы `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key` (`key`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_index` (`user_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `total_cost` (`total_cost`),
  ADD KEY `action_cost` (`action_cost`),
  ADD KEY `hour_limit` (`hour_limit`),
  ADD KEY `hour_done` (`hour_done`),
  ADD KEY `total_cost_2` (`total_cost`,`action_cost`),
  ADD KEY `hour_limit_2` (`hour_limit`,`hour_done`),
  ADD KEY `disabled` (`disabled`),
  ADD KEY `geo` (`geo`),
  ADD KEY `order` (`order`);

--
-- Индексы таблицы `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `api_key` (`api_key`),
  ADD KEY `referrer_id` (`referrer_id`),
  ADD KEY `time` (`time`),
  ADD KEY `lastseen` (`lastseen`),
  ADD KEY `earned` (`earned`),
  ADD KEY `gid` (`gid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `account`
--
ALTER TABLE `account`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `client_js`
--
ALTER TABLE `client_js`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `done`
--
ALTER TABLE `done`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `geo_city`
--
ALTER TABLE `geo_city`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `geo_country`
--
ALTER TABLE `geo_country`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `geo_region`
--
ALTER TABLE `geo_region`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `geo_to_task`
--
ALTER TABLE `geo_to_task`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mailing`
--
ALTER TABLE `mailing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `paycode`
--
ALTER TABLE `paycode`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `payment_system`
--
ALTER TABLE `payment_system`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `payout`
--
ALTER TABLE `payout`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `penalty`
--
ALTER TABLE `penalty`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `refund`
--
ALTER TABLE `refund`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;



--
-- Индексы таблицы `task_alternate_ids`
--
ALTER TABLE `task_alternate_ids`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `task_alternate_ids`
--
ALTER TABLE `task_alternate_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  
--
-- AUTO_INCREMENT для таблицы `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `type`
--
ALTER TABLE `type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
