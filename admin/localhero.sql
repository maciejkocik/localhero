-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 24 Paź 2019, 16:21
-- Wersja serwera: 5.7.19
-- Wersja PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `localhero`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cleaned_up`
--

DROP TABLE IF EXISTS `cleaned_up`;
CREATE TABLE IF NOT EXISTS `cleaned_up` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `id_post` int(11) NOT NULL,
  `status` enum('waiting','approved','removed','') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_post` (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `cleaned_up`
--

INSERT INTO `cleaned_up` (`id`, `id_user`, `description`, `date`, `id_post`, `status`) VALUES
(9, 3, 'ewew', '2019-10-23', 55, 'approved'),
(10, 3, 'sggfd', '2019-10-23', 6, 'approved');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `comment`
--

INSERT INTO `comment` (`id`, `id_post`, `id_user`, `text`, `date`, `status`) VALUES
(4, 54, 3, 'erwttr', '2019-10-22', 1),
(5, 54, 3, 'wrtwetr', '2019-10-22', 1),
(6, 54, 3, 'wt', '2019-10-22', 1),
(7, 54, 3, '', '2019-10-22', 1),
(8, 54, 3, '', '2019-10-22', 1),
(9, 54, 3, 'wtwet', '2019-10-22', 0),
(10, 54, 3, 'wtwer', '2019-10-22', 1),
(11, 54, 3, 'wtewtr', '2019-10-22', 1),
(12, 54, 3, 'rwtewt', '2019-10-22', 1),
(13, 54, 3, 'etewert', '2019-10-22', 1),
(14, 54, 3, '', '2019-10-22', 1),
(15, 54, 3, '', '2019-10-22', 0),
(16, 54, 3, '', '2019-10-22', 1),
(17, 54, 3, '', '2019-10-22', 1),
(18, 54, 3, '', '2019-10-22', 1),
(19, 54, 3, '', '2019-10-22', 1),
(20, 54, 3, 'tweetwtewetertert', '2019-10-22', 1),
(21, 54, 3, 'ertwetet', '2019-10-22', 1),
(22, 54, 3, 'wetwetewwer', '2019-10-22', 0),
(23, 54, 3, 'wetewrtewr', '2019-10-22', 0),
(24, 54, 3, 'ertewrt', '2019-10-22', 0),
(25, 54, 3, '', '2019-10-22', 0),
(26, 54, 3, 'sa', '2019-10-23', 0),
(27, 54, 3, '', '2019-10-23', 0),
(28, 54, 3, '', '2019-10-23', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `title` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `lat` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `lng` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('waiting','approved','removed','') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `post`
--

INSERT INTO `post` (`id`, `id_user`, `title`, `description`, `date`, `lat`, `lng`, `status`) VALUES
(6, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(7, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(8, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(9, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(27, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(36, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(43, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(45, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(52, 3, '1234', 'wqwqsswq', '2019-10-19', '0', '0', 'waiting'),
(53, 3, 'sfdfsfsf', 'wqswqdwqd', '2019-10-21', '0', '0', 'approved'),
(54, 3, 'sfdfsfsf', 'wqswqdwqd', '2019-10-21', '0', '0', 'approved'),
(55, 3, 'adfsfsd', 'sdffsdfd', '2019-10-22', '0', '0', 'waiting'),
(56, 3, 'dqwdwqdwqdwdq', 'wdqdqwwdqdwq', '2019-10-22', '0', '0', 'approved'),
(58, 3, 'ewewfe', 'ewfewfew', '2019-10-22', '0', '0', 'approved');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `post_reaction`
--

DROP TABLE IF EXISTS `post_reaction`;
CREATE TABLE IF NOT EXISTS `post_reaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `reaction` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `post_reaction`
--

INSERT INTO `post_reaction` (`id`, `id_post`, `id_user`, `reaction`) VALUES
(56, 54, 11, 1),
(57, 56, 11, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `e_mail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `moderator` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `e_mail`, `date`, `moderator`, `status`) VALUES
(3, 'nauczyciel', '827ccb0eea8a706c4c34a16891f84e7b', 'topiterek@gmail.com', '2019-10-19', 1, 1),
(5, 'nauczy', '827ccb0eea8a706c4c34a16891f84e7b', 'topiterek@gmail.com', '2019-10-19', 0, 1),
(6, 'naurtetweg', '827ccb0eea8a706c4c34a16891f84e7b', 'topiterek@gmail.c', '2019-10-19', 0, 1),
(7, 'wrwe', '827ccb0eea8a706c4c34a16891f84e7b', 'topiterk@gmail.com', '2019-10-19', 0, 1),
(8, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'topiterek@gail.com', '2019-10-19', 0, 1),
(9, 'admin123', '827ccb0eea8a706c4c34a16891f84e7b', 'torek@gail.com', '2019-10-19', 0, 1),
(10, 'nauczyciel21', '827ccb0eea8a706c4c34a16891f84e7b', 'to@gmail.com', '2019-10-19', 0, 1),
(11, '123', '827ccb0eea8a706c4c34a16891f84e7b', '1@w.pl', '2019-10-22', 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_reaction`
--

DROP TABLE IF EXISTS `user_reaction`;
CREATE TABLE IF NOT EXISTS `user_reaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_to` int(11) NOT NULL,
  `id_user_from` int(11) NOT NULL,
  `reaction` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_to` (`id_user_to`),
  KEY `id_user_from` (`id_user_from`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `cleaned_up`
--
ALTER TABLE `cleaned_up`
  ADD CONSTRAINT `cleaned_up_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cleaned_up_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `post_reaction`
--
ALTER TABLE `post_reaction`
  ADD CONSTRAINT `post_reaction_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_reaction_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `user_reaction`
--
ALTER TABLE `user_reaction`
  ADD CONSTRAINT `user_reaction_ibfk_1` FOREIGN KEY (`id_user_from`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_reaction_ibfk_2` FOREIGN KEY (`id_user_to`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
