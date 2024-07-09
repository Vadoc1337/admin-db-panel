-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Хост: mysql-206956.srv.hoster.ru
-- Время создания: Июл 09 2024 г., 00:32
-- Версия сервера: 5.6.40
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `srv206956_test_php_db`
--
CREATE DATABASE IF NOT EXISTS `srv206956_test_php_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `srv206956_test_php_db`;

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `admin_username`, `admin_password`) VALUES
(1, 'admin', '$2y$10$q5S0CR1FqykxvCNBn3M1p.Bn5Mptf2ULnUR62mTJVo4f5pdyostgG');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `first_name`, `last_name`, `gender`, `birth_date`) VALUES
(5, 'test', '$2y$10$EOae7dG1nZl7yVx.zC9faOt2ZVAjR8ZuIKOu5sDohtevHofblB9.q', 'test', 'test', 'male', '0322-12-02'),
(6, 'Рептилоид', '$2y$10$eLwfBRrpKaQHtrKae0tENuyIY5N96sJWttif8Z86dSf2oPH0G8xz.', 'Мировое', 'Правительство', 'male', '0001-01-01'),
(7, 'Vadick', '$2y$10$YqodClmGLSxclJNPB6e.CuFlYp9k71/kObYra3ZVazNsMQcoRzyKG', 'Vadim', 'Lobanov', 'male', '1999-07-19'),
(16, 'user004', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Laura', 'Miller', 'male', '1985-04-05'),
(17, 'user005', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Rodriguez', 'male', '2015-04-03'),
(20, 'user008', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Martinez', 'male', '1997-06-17'),
(21, 'user009', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Miller', 'female', '1993-11-09'),
(22, 'user010', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Miller', 'male', '1982-09-24'),
(27, 'user015', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Williams', 'female', '2019-11-12'),
(28, 'user016', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'David', 'Smith', 'male', '2004-06-21'),
(30, 'user018', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Brown', 'male', '1988-10-13'),
(31, 'user019', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Smith', 'male', '1979-02-08'),
(33, 'user021', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Smith', 'male', '1988-12-18'),
(34, 'user022', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emma', 'Brown', 'male', '2000-08-09'),
(35, 'user023', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Chris', 'Brown', 'female', '1987-10-25'),
(36, 'user024', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Martinez', 'female', '2003-04-03'),
(37, 'user025', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Laura', 'Davis', 'male', '1989-05-04'),
(40, 'user028', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Smith', 'female', '2010-01-15'),
(41, 'user029', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Davis', 'male', '2014-07-22'),
(43, 'user031', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Davis', 'female', '1989-08-25'),
(44, 'user032', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Jones', 'male', '2004-11-14'),
(45, 'user033', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Brown', 'male', '1996-02-22'),
(47, 'user035', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Brown', 'male', '1983-09-19'),
(48, 'user036', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Smith', 'female', '1979-12-12'),
(49, 'user037', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Jones', 'male', '1971-07-29'),
(50, 'user038', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Jones', 'male', '2003-12-08'),
(51, 'user039', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Johnson', 'male', '1989-06-20'),
(52, 'user040', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'David', 'Williams', 'female', '2001-02-23'),
(54, 'user042', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Rodriguez', 'female', '1981-07-16'),
(55, 'user043', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Garcia', 'female', '1995-02-10'),
(57, 'user045', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Smith', 'female', '1973-10-31'),
(58, 'user046', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sarah', 'Brown', 'female', '1998-03-29'),
(59, 'user047', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Laura', 'Brown', 'male', '2002-06-23'),
(60, 'user048', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emma', 'Miller', 'female', '1977-02-16'),
(63, 'user051', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Brown', 'male', '1982-11-26'),
(64, 'user052', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'David', 'Garcia', 'male', '1994-08-24'),
(65, 'user053', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Davis', 'male', '1982-10-03'),
(68, 'user056', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Davis', 'female', '2009-02-21'),
(69, 'user057', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Johnson', 'female', '2006-03-10'),
(71, 'user059', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Brown', 'female', '2014-01-17'),
(72, 'user060', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Williams', 'female', '1970-01-20'),
(73, 'user061', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'David', 'Johnson', 'female', '2018-02-08'),
(74, 'user062', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Rodriguez', 'female', '1977-04-19'),
(75, 'user063', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Chris', 'Rodriguez', 'male', '1975-12-16'),
(77, 'user065', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Jones', 'male', '1982-09-13'),
(80, 'user068', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emma', 'Miller', 'male', '1988-03-11'),
(81, 'user069', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Williams', 'male', '2019-03-28'),
(85, 'user073', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sarah', 'Martinez', 'male', '1993-06-15'),
(86, 'user074', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Garcia', 'male', '2012-08-26'),
(87, 'user075', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Jones', 'male', '2008-04-14'),
(88, 'user076', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Garcia', 'male', '2003-12-16'),
(91, 'user079', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Laura', 'Davis', 'female', '2013-06-12'),
(92, 'user080', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Smith', 'female', '1979-04-18'),
(93, 'user081', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Garcia', 'female', '1988-02-15'),
(94, 'user082', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Johnson', 'female', '1986-11-11'),
(98, 'user086', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Smith', 'female', '1970-01-17'),
(99, 'user087', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Martinez', 'male', '1995-07-11'),
(100, 'user088', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Chris', 'Martinez', 'female', '1976-09-01'),
(103, 'user091', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Chris', 'Miller', 'male', '1978-05-12'),
(105, 'user093', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Brown', 'female', '1978-05-09'),
(106, 'user094', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emma', 'Jones', 'male', '1994-09-08'),
(110, 'user098', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Johnson', 'male', '1975-06-20'),
(111, 'user099', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Chris', 'Rodriguez', 'male', '1987-07-28'),
(112, 'user100', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Jones', 'male', '2007-04-25'),
(114, 'user102', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emma', 'Miller', 'female', '2013-11-04'),
(116, 'user104', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Miller', 'male', '1975-11-27'),
(118, 'user106', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Smith', 'male', '1980-11-16'),
(119, 'user107', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Rodriguez', 'female', '1991-09-26'),
(121, 'user109', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Laura', 'Martinez', 'female', '2005-05-30'),
(122, 'user110', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Smith', 'male', '1995-11-29'),
(123, 'user111', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Jones', 'female', '1992-06-04'),
(124, 'user112', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Chris', 'Miller', 'female', '2016-09-05'),
(125, 'user113', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Miller', 'female', '1974-04-19'),
(126, 'user114', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mike', 'Johnson', 'male', '2010-11-30'),
(130, 'user118', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Jones', 'female', '2001-08-28'),
(131, 'user119', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'David', 'Williams', 'male', '1984-05-07'),
(132, 'user120', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Emily', 'Smith', 'male', '1979-02-20'),
(133, 'user121', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Miller', 'male', '1992-10-21'),
(134, 'user122', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Martinez', 'female', '2006-07-04'),
(136, 'user124', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Johnson', 'male', '2018-04-29'),
(137, 'user125', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Johnson', 'female', '1992-09-09'),
(140, 'bobanov_grossmeister', '$2y$10$RV/d2d2fPf6yo.c6JqPoy.B7tcVB0rw424y8W9K6XBKL9LEpuksjW', 'Semyon', 'Bobanov', 'male', '2006-09-26'),
(141, 'Аслан', '$2y$10$MDfxEnV5ZAsxv5woFyuuIutD64ziCdQBDIWkGFYyBuSKauG/qv/hq', 'Аслан', 'Асланович', 'male', '1333-12-13'),
(147, 'a', '$2y$10$DZxp0ltTlmUuPfNH4dla8O4d52E31NDgtWTCxnvsxruPivbT9CwFS', 'a', 'a', 'male', '3333-02-20'),
(149, 't', '$2y$10$bvYl6E.ud2PUyIJehfrK7uezzlgoRvMAW8PRVyBR6CThOidzePIda', 't', 't', 'male', '1111-11-11'),
(150, 'Альфа', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Doe', 'male', '2024-05-15'),
(151, 'final_test', '$2y$10$wn1D9WT350fgheiWPtgQkuX4LHRIsJM4pO5wUxHRDHrMqufUL6eFe', 'final', 'testik', 'male', '2222-12-12'),
(152, 'fasdf', '$2y$10$TH43WUBA4LKGlSkwHxGiHeYBBZ0.DLVqQ5zbYDjF5JywnMM01q/wG', 'asdf', 'Johnson', 'male', '1232-03-12'),
(153, 'sdf', '$2y$10$1gbdaLqh56MSKW1O6eOeX.eZfo1vzcONIevYFN9kufaVT3.y1X3Gi', 'dsfdsf', 'Johnson', 'male', '4544-12-11');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_username` (`admin_username`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `login_2` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
