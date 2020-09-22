-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 22 2020 г., 13:10
-- Версия сервера: 5.5.25
-- Версия PHP: 5.6.19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `database`
--

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `action` longblob,
  `url` varchar(200) DEFAULT NULL,
  `user` varchar(200) DEFAULT NULL,
  `ip` varchar(200) DEFAULT NULL,
  `user_agent` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`log_id`, `datetime`, `action`, `url`, `user`, `ip`, `user_agent`) VALUES
(1, '2020-09-22 15:43:17', 0x5061676520766965773a20284c6f6729, 'http://localhost/git/db/root/html/logs.php', 'Admin User [admin]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `contact_id` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `name` longtext,
  `head` longtext,
  `contact_number_home` varchar(20) DEFAULT NULL,
  `contact_number_mobile` varchar(20) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address_line_1` varchar(100) DEFAULT NULL,
  `address_line_2` varchar(100) DEFAULT NULL,
  `address_town` varchar(100) DEFAULT NULL,
  `address_county` varchar(100) DEFAULT NULL,
  `address_post_code` varchar(20) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `city` longtext,
  `job` longtext,
  `web` longtext,
  `photo` longtext,
  `reason` longtext,
  `reason2` longtext,
  `added` longtext,
  `updated` longtext,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`contact_id`, `first_name`, `middle_name`, `last_name`, `name`, `head`, `contact_number_home`, `contact_number_mobile`, `contact_email`, `date_of_birth`, `address_line_1`, `address_line_2`, `address_town`, `address_county`, `address_post_code`, `gender`, `birthday`, `city`, `job`, `web`, `photo`, `reason`, `reason2`, `added`, `updated`) VALUES
('dJyKjb80d6ET', NULL, NULL, 'sgsdg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fgddfg', NULL, '20.05.2020 23:03', NULL),
('vUdSTRzXOzHy', NULL, NULL, 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Test news', NULL, '22.09.2020 16:06', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `org`
--

CREATE TABLE IF NOT EXISTS `org` (
  `contact_id` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `name` longtext,
  `head` longtext,
  `contact_number_home` varchar(20) DEFAULT NULL,
  `contact_number_mobile` varchar(20) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address_line_1` varchar(100) DEFAULT NULL,
  `address_line_2` varchar(100) DEFAULT NULL,
  `address_town` varchar(100) DEFAULT NULL,
  `address_county` varchar(100) DEFAULT NULL,
  `address_post_code` varchar(20) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `city` longtext,
  `job` longtext,
  `web` longtext,
  `photo` longtext,
  `reason` longtext,
  `reason2` longtext,
  `added` longtext,
  `updated` longtext,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `org`
--

INSERT INTO `org` (`contact_id`, `first_name`, `middle_name`, `last_name`, `name`, `head`, `contact_number_home`, `contact_number_mobile`, `contact_email`, `date_of_birth`, `address_line_1`, `address_line_2`, `address_town`, `address_county`, `address_post_code`, `gender`, `birthday`, `city`, `job`, `web`, `photo`, `reason`, `reason2`, `added`, `updated`) VALUES
('j8aQy0HtYyjq', NULL, NULL, NULL, 'Toy company ', 'Tim Robinson', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Chicago', NULL, 'Instagram', '../../uploads/orgs/Toy company _22.09.2020/happy teddy bear day pics.jpg', '  <div>Test decription</div>', NULL, '22.09.2020', '22.09.2020 16:06'),
('JUBdpRUELmuJ', NULL, NULL, NULL, 'Metallurgical factory', 'Nick Husky', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'San-Francisco', NULL, 'Facebook', '../../uploads/orgs/Metallurgical factory_22.09.2020/dark-machine-intelligent-factory-material-dark-machine-graphics-factory-png-650_651.png', '    Test description', NULL, '22.09.2020', '22.09.2020 16:06');

-- --------------------------------------------------------

--
-- Структура таблицы `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `contact_id` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `contact_number_home` varchar(20) DEFAULT NULL,
  `contact_number_mobile` varchar(20) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `address_line_1` varchar(100) DEFAULT NULL,
  `address_line_2` varchar(100) DEFAULT NULL,
  `address_town` varchar(100) DEFAULT NULL,
  `address_county` varchar(100) DEFAULT NULL,
  `address_post_code` varchar(20) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `city` longtext,
  `job` longtext,
  `web` longtext,
  `photo` longtext,
  `reason` longtext,
  `added` longtext,
  `updated` longtext,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `persons`
--

INSERT INTO `persons` (`contact_id`, `last_name`, `first_name`, `middle_name`, `date_of_birth`, `contact_number_home`, `contact_number_mobile`, `contact_email`, `address_line_1`, `address_line_2`, `address_town`, `address_county`, `address_post_code`, `gender`, `birthday`, `city`, `job`, `web`, `photo`, `reason`, `added`, `updated`) VALUES
('aZe0QhAUNkdr', 'Charles ', 'Xavier', NULL, '1995-09-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Male', NULL, 'New York', 'Designer', 'Facebook', '../../uploads/persons/Charles _Xavier_22.09.2020/Logo-1.png', '<div>Description 123</div>', '22.09.2020', '22.09.2020 16:08');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(12) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `hashed_password` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `username`, `hashed_password`, `full_name`) VALUES
('PB0gY2TZKYTc', 'admin', '$2y$10$gr8pHxs0vpqdCqrpleh18u0UL0z6YndmgdLCZDd/0X9t1FlP/SmFO', 'Admin User');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
