-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 27, 2017 alle 22:42
-- Versione del server: 10.1.21-MariaDB
-- Versione PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3dbcentral`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `apikeys`
--

CREATE TABLE `apikeys` (
  `apikey` char(16) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` varchar(64) NOT NULL,
  `expiration_date` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `apikeys`
--

INSERT INTO `apikeys` (`apikey`, `creation_date`, `user_id`, `expiration_date`) VALUES
('J3rPnyUo4HSB80Th', '2017-08-26 07:42:32', 'admin@example.com', '09:42:32');

-- --------------------------------------------------------

--
-- Struttura della tabella `dbcols`
--

CREATE TABLE `dbcols` (
  `id` varchar(16) NOT NULL,
  `table_id` varchar(16) NOT NULL,
  `database_id` varchar(32) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` char(32) NOT NULL,
  `isnull` tinyint(1) NOT NULL DEFAULT '0',
  `isprimary` tinyint(1) NOT NULL DEFAULT '0',
  `isunique` tinyint(1) NOT NULL DEFAULT '0',
  `length` int(10) DEFAULT NULL,
  `attributes` varchar(32) DEFAULT NULL,
  `default_val` varchar(32) DEFAULT NULL,
  `extra` tinyint(1) DEFAULT NULL,
  `comments` varchar(1024) DEFAULT NULL,
  `virtuality` varchar(32) DEFAULT NULL,
  `mime` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `dbcols`
--

INSERT INTO `dbcols` (`id`, `table_id`, `database_id`, `user_id`, `name`, `type`, `isnull`, `isprimary`, `isunique`, `length`, `attributes`, `default_val`, `extra`, `comments`, `virtuality`, `mime`) VALUES
('2pr0mVVvDrfjGjqs', 'QRXNHl4BKPV7OZgM', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col2', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('4pF0jeKEWEFmCq3t', 'yY0ejv30T61jU3ty', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col3', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('6JoFgTGBgPVJiYzD', 'efM8GtsFyOIoud98', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col3', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('9K39MWA1CUcyHcbA', 'DLhW3YVAn2gbARsR', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col1', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('bifF0mr8o4qXodEF', 'dSKI0oFKhupY4EZ3', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col3', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('cBcDx7ZG7OYyyTdv', 'dSKI0oFKhupY4EZ3', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col0', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('dANQ7nqQkfKP7FPu', 'hhGsoF233LJNw46T', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col0', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('dF6A3vjXgdo574MY', 'QRXNHl4BKPV7OZgM', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col3', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('DHhJu3jxBMfELgvw', 'HlWbmmWXcDFAhp4P', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col1', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('hENZfib9jTBBxSel', 'dSKI0oFKhupY4EZ3', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col2', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('Hre42VIrQ9HivM8I', 'yY0ejv30T61jU3ty', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col1', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('Hx93KaCyCKqTbHGm', 'QRXNHl4BKPV7OZgM', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col1', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('I1USY7oBsGZ2TYRE', 'DLhW3YVAn2gbARsR', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col0', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('J6WtDDRj86elInMZ', 'DLhW3YVAn2gbARsR', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col2', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('JECw8gZXVQVRyZnH', 'QRXNHl4BKPV7OZgM', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col0', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('Jvzb37jSDFzct5Q2', 'efM8GtsFyOIoud98', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col1', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('K6cTcX6MVd28Zj4w', 'efM8GtsFyOIoud98', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col2', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('KAph4wMc21ErYzGs', 'QRXNHl4BKPV7OZgM', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col4', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('lByu2ESWDUA1oxGO', 'asICC4g4nU0jBct6', 'uJYJdaSbqH1wop1hQpXwPoTvF9SVPgug', 'admin@example.com', 'email', 'VARCHAR', 0, 0, 0, 16, 'UNSIGNED', 'NULL', 0, 'user email', 'NULL', 'NULL'),
('mDhEbZos95vOgsPC', 'HlWbmmWXcDFAhp4P', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col0', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('PL3OyVTdWpGwxyC0', 'dSKI0oFKhupY4EZ3', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com', 'col1', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('ttMm3iW5SK26W8WP', 'yY0ejv30T61jU3ty', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col0', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('wckAJYkBMKovyD5k', 'asICC4g4nU0jBct6', 'uJYJdaSbqH1wop1hQpXwPoTvF9SVPgug', 'admin@example.com', 'name', 'VARCHAR', 0, 0, 0, 64, 'UNSIGNED', 'NULL', 0, 'user name', 'NULL', 'NULL'),
('yf4Lnrb6QIuyW4TS', 'yY0ejv30T61jU3ty', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com', 'col2', 'TINYINT', 0, 0, 0, 12, 'UNSIGNED', 'NULL', 0, 'NULL', 'NULL', 'NULL'),
('yYGqA4vucXdMGtC8', 'asICC4g4nU0jBct6', 'uJYJdaSbqH1wop1hQpXwPoTvF9SVPgug', 'admin@example.com', 'surname', 'VARCHAR', 0, 0, 0, 64, 'UNSIGNED', 'NULL', 0, 'user surname', 'NULL', 'NULL');

-- --------------------------------------------------------

--
-- Struttura della tabella `dbdatabases`
--

CREATE TABLE `dbdatabases` (
  `id` varchar(32) NOT NULL,
  `name` varchar(30) NOT NULL,
  `encoding` varchar(30) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `server_address` varchar(1024) DEFAULT NULL,
  `server_password` varchar(64) DEFAULT NULL,
  `server_username` varchar(64) DEFAULT NULL,
  `server_port` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `dbdatabases`
--

INSERT INTO `dbdatabases` (`id`, `name`, `encoding`, `user_id`, `server_address`, `server_password`, `server_username`, `server_port`) VALUES
('57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'DB1', 'latin1_swedish_ci', 'admin@example.com', 'localhost', '', 'root', 21),
('KloExKokuc1MWmIICOko7Eap0Ogd794f', 'DB1', 'utf8_general_ci', 'admin@example.com', 'localhost', 'new password2', 'newusername2', 21),
('Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'DB2', 'latin1_swedish_ci', 'admin@example.com', 'localhost', '', 'root', 21),
('uJYJdaSbqH1wop1hQpXwPoTvF9SVPgug', 'Users', 'latin1_swedish_ci', 'admin@example.com', 'localhost', 'pass', 'root', 21);

-- --------------------------------------------------------

--
-- Struttura della tabella `dbtables`
--

CREATE TABLE `dbtables` (
  `id` varchar(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `encoding` varchar(32) NOT NULL,
  `database_id` varchar(32) NOT NULL,
  `user_id` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `dbtables`
--

INSERT INTO `dbtables` (`id`, `name`, `encoding`, `database_id`, `user_id`) VALUES
('2g320Ckkq2CurbwJ', 'NEWTAB', 'utf8_general_ci', 'KloExKokuc1MWmIICOko7Eap0Ogd794f', 'admin@example.com'),
('3tUzGcZCm8XuaI3Z', 'TableModified', 'another_encoding', 'KloExKokuc1MWmIICOko7Eap0Ogd794f', 'admin@example.com'),
('asICC4g4nU0jBct6', 'User', 'latin1_swedish_ci', 'uJYJdaSbqH1wop1hQpXwPoTvF9SVPgug', 'admin@example.com'),
('DLhW3YVAn2gbARsR', 'table4', 'latin1_swedish_ci', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com'),
('dSKI0oFKhupY4EZ3', 'table1', 'latin1_swedish_ci', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com'),
('efM8GtsFyOIoud98', 'table2', 'latin1_swedish_ci', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com'),
('hhGsoF233LJNw46T', 'table2', 'latin1_swedish_ci', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com'),
('HlWbmmWXcDFAhp4P', 'table1', 'latin1_swedish_ci', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com'),
('JzvEfFckUyL0cXWA', 'NEWTAB', 'utf8_general_ci', 'KloExKokuc1MWmIICOko7Eap0Ogd794f', 'admin@example.com'),
('oh1QpMYVqErhB1No', 'NEWTAB', 'utf8_general_ci', 'KloExKokuc1MWmIICOko7Eap0Ogd794f', 'admin@example.com'),
('QRXNHl4BKPV7OZgM', 'table3', 'latin1_swedish_ci', 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV', 'admin@example.com'),
('SwAUw9y2BgRcrNaV', 'NEWTAB', 'utf8_general_ci', 'KloExKokuc1MWmIICOko7Eap0Ogd794f', 'admin@example.com'),
('yY0ejv30T61jU3ty', 'table3', 'latin1_swedish_ci', '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5', 'admin@example.com'),
('ZuQhnCze5QlHPyQD', 'NEWTAB', 'utf8_general_ci', 'KloExKokuc1MWmIICOko7Eap0Ogd794f', 'admin@example.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `object3d`
--

CREATE TABLE `object3d` (
  `x` float NOT NULL,
  `y` float NOT NULL,
  `z` float NOT NULL,
  `size` double NOT NULL,
  `material` varchar(64) DEFAULT NULL,
  `opacity` double NOT NULL,
  `texture` varchar(64) DEFAULT NULL,
  `color` varchar(16) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `referto` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `object3d`
--

INSERT INTO `object3d` (`x`, `y`, `z`, `size`, `material`, `opacity`, `texture`, `color`, `id`, `referto`) VALUES
(289.968, 187.591, 148.013, 50, 'MeshBasicMaterial', 1, 'null', '0xf3b1d', 2, '57fXjub0UsaCPcn5KmQKY5EJdr2Cg5C5'),
(-603.999, 238.624, 598.811, 50, 'MeshPhongMaterial', 1, '8', '0xffffff', 3, 'KloExKokuc1MWmIICOko7Eap0Ogd794f'),
(-856.232, 183.534, -818.24, 30, 'MeshPhongMaterial', 1, '6', '0xffffff', 4, 'Rj3netrV2jzx9FzeSMmX1NoH3oAikMZV'),
(-74.9606, -101.675, -97.918, 30, 'MeshPhongMaterial', 1, 'null', '0xfd8437', 5, 'DLhW3YVAn2gbARsR'),
(-7.17332, 198.681, -164.569, 30, 'MeshPhongMaterial', 1, 'null', '0xf0bb03', 6, 'dSKI0oFKhupY4EZ3'),
(-103.641, 82.2467, 168.974, 30, 'MeshPhongMaterial', 1, 'null', '0xf0bb03', 7, 'hhGsoF233LJNw46T'),
(314.965, -97.9635, 57.183, 30, 'MeshPhongMaterial', 1, '8', '0xffffff', 8, 'QRXNHl4BKPV7OZgM'),
(-31.8836, -87.2287, -33.1618, 20, 'MeshPhongMaterial', 1, '14', '0xffffff', 9, 'oh1QpMYVqErhB1No'),
(89.739, 36.7087, 42.1385, 20, 'MeshPhongMaterial', 1, '14', '0xffffff', 10, 'JzvEfFckUyL0cXWA'),
(-72.5101, 55.8222, -135.547, 20, 'MeshPhongMaterial', 1, '14', '0xffffff', 11, '3tUzGcZCm8XuaI3Z'),
(39.1553, -20.2718, 116.167, 20, 'MeshPhongMaterial', 1, '14', '0xffffff', 12, '2g320Ckkq2CurbwJ'),
(103.437, -66.6676, -2.96229, 20, 'MeshPhongMaterial', 1, '14', '0xffffff', 13, 'ZuQhnCze5QlHPyQD'),
(-84.5467, -8.37282, 11.6338, 20, 'MeshPhongMaterial', 1, '14', '0xffffff', 14, 'SwAUw9y2BgRcrNaV'),
(-34.8983, -237.091, 53.8861, 30, 'MeshBasicMaterial', 1, 'null', '0xa401', 15, 'efM8GtsFyOIoud98'),
(15.3086, 112.213, 57.6334, 30, 'MeshBasicMaterial', 1, 'null', '0xa401', 16, 'HlWbmmWXcDFAhp4P'),
(-239.37, 93.0701, -293.002, 30, 'MeshBasicMaterial', 1, 'null', '0xa401', 17, 'yY0ejv30T61jU3ty'),
(-54.9765, -60.3487, -127.373, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 18, 'Jvzb37jSDFzct5Q2'),
(-14.2245, -8.2826, 75.9808, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 19, '6JoFgTGBgPVJiYzD'),
(-29.8112, 122.599, -7.81087, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 20, 'DHhJu3jxBMfELgvw'),
(57.6387, -33.1849, -7.90732, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 21, 'K6cTcX6MVd28Zj4w'),
(-86.1222, 56.0657, -132.062, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 22, '4pF0jeKEWEFmCq3t'),
(31.251, -21.7771, 110.438, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 23, 'mDhEbZos95vOgsPC'),
(-50.1845, -116.38, -48.7151, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 24, 'Hre42VIrQ9HivM8I'),
(5.79201, 160.714, 18.9884, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 25, 'ttMm3iW5SK26W8WP'),
(109.349, -32.8216, -2.39836, 20, 'MeshPhongMaterial', 1, 'null', '0xff00', 26, 'yf4Lnrb6QIuyW4TS'),
(33.362, -81.8789, -42.9504, 20, 'MeshPhongMaterial', 1, 'null', '0xfd8437', 27, 'I1USY7oBsGZ2TYRE'),
(-2.6293, -23.7166, -101.522, 20, 'MeshPhongMaterial', 1, 'null', '0xfd8437', 28, '9K39MWA1CUcyHcbA'),
(-59.2507, -178.09, 89.2185, 20, 'MeshPhongMaterial', 1, 'null', '0xfd8437', 29, 'J6WtDDRj86elInMZ'),
(56.3745, -137.685, -177.266, 20, 'MeshPhongMaterial', 1, 'null', '0xfd8437', 30, 'bifF0mr8o4qXodEF'),
(-235.257, 129.013, -176.529, 20, 'MeshPhongMaterial', 1, 'null', '0xf0bb03', 31, 'cBcDx7ZG7OYyyTdv'),
(37.4238, 56.9927, -140.011, 20, 'MeshPhongMaterial', 1, 'null', '0xfd8437', 32, 'hENZfib9jTBBxSel'),
(-37.4377, 142.06, -43.3795, 20, 'MeshPhongMaterial', 1, 'null', '0xf0bb03', 33, 'PL3OyVTdWpGwxyC0'),
(33.2915, 73.9818, 53.5616, 20, 'MeshPhongMaterial', 1, '13', '0xffffff', 34, '2pr0mVVvDrfjGjqs'),
(150.351, -16.7555, -53.3937, 20, 'MeshPhongMaterial', 1, '11', '0xffffff', 35, 'JECw8gZXVQVRyZnH'),
(81.829, 67.8502, -254.527, 20, 'MeshPhongMaterial', 1, '12', '0xffffff', 36, 'KAph4wMc21ErYzGs'),
(50.6947, -108.46, 159.36, 20, 'MeshPhongMaterial', 1, '9', '0xffffff', 37, 'dF6A3vjXgdo574MY'),
(76.1597, -120.877, -58.5179, 20, 'MeshPhongMaterial', 1, '10', '0xffffff', 38, 'Hx93KaCyCKqTbHGm'),
(-78.3265, 49.7118, 57.4453, 20, 'MeshPhongMaterial', 1, 'null', '0xf0bb03', 39, 'dANQ7nqQkfKP7FPu'),
(-583.787, 601.13, 33.7314, 30, 'MeshPhongMaterial', 1, '7', '0xffffff', 4324, 'uJYJdaSbqH1wop1hQpXwPoTvF9SVPgug'),
(97.6451, -12.9333, -61.9866, 20, 'MeshPhongMaterial', 1, '5', '0xffffff', 4325, 'wckAJYkBMKovyD5k'),
(70.2572, 10.1166, 92.7709, 20, 'MeshPhongMaterial', 1, '13', '0xffffff', 4326, 'lByu2ESWDUA1oxGO'),
(-146.124, 201.677, -0.044283, 20, 'MeshPhongMaterial', 1, '11', '0xffffff', 4327, 'yYGqA4vucXdMGtC8'),
(108.187, -27.3059, 73.135, 30, 'MeshPhongMaterial', 1, '9', '0xffffff', 4328, 'asICC4g4nU0jBct6');

-- --------------------------------------------------------

--
-- Struttura della tabella `userlogs`
--

CREATE TABLE `userlogs` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` varchar(64) NOT NULL,
  `type` char(3) NOT NULL,
  `info` varchar(32) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `userlogs`
--

INSERT INTO `userlogs` (`id`, `timestamp`, `user_id`, `type`, `info`, `level`) VALUES
(146, '2017-08-26 07:42:32', 'admin@example.com', 'USE', 'registration', 0),
(147, '2017-08-26 07:42:46', 'admin@example.com', 'ACC', 'login', 1),
(148, '2017-08-26 07:46:58', 'admin@example.com', 'ACC', 'logout', 1),
(149, '2017-08-26 07:47:11', 'admin@example.com', 'ACC', 'login', 1),
(150, '2017-08-26 07:47:18', 'admin@example.com', 'ACC', 'logout', 1),
(151, '2017-08-26 07:52:32', 'admin@example.com', 'ACC', 'login', 1),
(152, '2017-08-26 08:13:41', 'admin@example.com', 'ACC', 'logout', 1),
(153, '2017-08-26 08:13:53', 'admin@example.com', 'ACC', 'login', 1),
(154, '2017-08-26 08:16:20', 'admin@example.com', 'DAT', 'database insert - success', 1),
(155, '2017-08-26 08:17:12', 'admin@example.com', 'DAT', 'table insert - success', 1),
(156, '2017-08-26 08:17:20', 'admin@example.com', 'DAT', 'table insert - success', 1),
(157, '2017-08-26 08:17:32', 'admin@example.com', 'DAT', 'table insert - success', 1),
(158, '2017-08-26 08:17:48', 'admin@example.com', 'DAT', 'col insert - success', 1),
(159, '2017-08-26 08:18:19', 'admin@example.com', 'DAT', 'col insert - success', 1),
(160, '2017-08-26 08:21:45', 'admin@example.com', 'DAT', 'col delete - success', 1),
(161, '2017-08-26 08:21:50', 'admin@example.com', 'DAT', 'col delete - success', 1),
(162, '2017-08-26 08:21:55', 'admin@example.com', 'DAT', 'database delete - success', 1),
(163, '2017-08-28 08:59:17', 'admin@example.com', 'ACC', 'login', 1),
(164, '2017-09-01 13:53:59', 'admin@example.com', 'DAT', 'database insert - success', 1),
(165, '2017-09-01 13:54:11', 'admin@example.com', 'DAT', 'table insert - success', 1),
(166, '2017-09-01 13:54:20', 'admin@example.com', 'DAT', 'table insert - success', 1),
(167, '2017-09-01 13:54:32', 'admin@example.com', 'DAT', 'table insert - success', 1),
(168, '2017-09-01 13:54:50', 'admin@example.com', 'DAT', 'col insert - success', 1),
(169, '2017-09-01 13:55:02', 'admin@example.com', 'DAT', 'col insert - success', 1),
(170, '2017-09-01 13:55:13', 'admin@example.com', 'DAT', 'col insert - success', 1),
(171, '2017-09-03 07:16:10', 'admin@example.com', 'DAT', 'database insert - success', 1),
(172, '2017-09-03 08:36:25', 'admin@example.com', 'DAT', 'table insert - success', 1),
(173, '2017-09-03 08:36:34', 'admin@example.com', 'DAT', 'table insert - success', 1),
(174, '2017-09-03 08:36:42', 'admin@example.com', 'DAT', 'table insert - success', 1),
(175, '2017-09-03 08:36:55', 'admin@example.com', 'DAT', 'table insert - success', 1),
(176, '2017-09-03 09:12:16', 'admin@example.com', 'DAT', 'col insert - success', 1),
(177, '2017-09-03 09:12:36', 'admin@example.com', 'DAT', 'col insert - success', 1),
(178, '2017-09-03 09:12:49', 'admin@example.com', 'DAT', 'col insert - success', 1),
(179, '2017-09-03 09:13:00', 'admin@example.com', 'DAT', 'col insert - success', 1),
(180, '2017-09-03 09:13:11', 'admin@example.com', 'DAT', 'col insert - success', 1),
(181, '2017-09-03 09:13:24', 'admin@example.com', 'DAT', 'col insert - success', 1),
(182, '2017-09-03 09:13:39', 'admin@example.com', 'DAT', 'col insert - success', 1),
(183, '2017-09-03 09:13:49', 'admin@example.com', 'DAT', 'col insert - success', 1),
(184, '2017-09-03 09:13:57', 'admin@example.com', 'DAT', 'col insert - success', 1),
(185, '2017-09-03 09:14:07', 'admin@example.com', 'DAT', 'col insert - success', 1),
(186, '2017-09-03 09:14:16', 'admin@example.com', 'DAT', 'col insert - success', 1),
(187, '2017-09-03 09:14:24', 'admin@example.com', 'DAT', 'col insert - success', 1),
(188, '2017-09-03 09:14:37', 'admin@example.com', 'DAT', 'col insert - success', 1),
(189, '2017-09-03 09:14:47', 'admin@example.com', 'DAT', 'col insert - success', 1),
(190, '2017-09-03 09:14:55', 'admin@example.com', 'DAT', 'col insert - success', 1),
(191, '2017-09-03 09:15:03', 'admin@example.com', 'DAT', 'col insert - success', 1),
(192, '2017-09-03 09:15:11', 'admin@example.com', 'DAT', 'col insert - success', 1),
(193, '2017-09-03 09:15:21', 'admin@example.com', 'DAT', 'col insert - success', 1),
(194, '2017-09-03 09:15:28', 'admin@example.com', 'DAT', 'col insert - success', 1),
(195, '2017-09-21 16:59:31', 'admin@example.com', 'DAT', 'database insert - success', 1),
(196, '2017-09-21 17:13:15', 'admin@example.com', 'DAT', 'table insert - success', 1),
(197, '2017-09-21 17:13:27', 'admin@example.com', 'DAT', 'table insert - success', 1),
(198, '2017-09-21 17:14:01', 'admin@example.com', 'DAT', 'table insert - success', 1),
(199, '2017-09-21 17:14:16', 'admin@example.com', 'DAT', 'table insert - success', 1),
(200, '2017-09-21 17:14:58', 'admin@example.com', 'DAT', 'col insert - success', 1),
(201, '2017-09-21 17:15:26', 'admin@example.com', 'DAT', 'col insert - success', 1),
(202, '2017-09-21 17:15:53', 'admin@example.com', 'DAT', 'col insert - success', 1),
(203, '2017-09-25 11:13:09', 'admin@example.com', 'DAT', 'table delete - success', 1),
(204, '2017-09-25 11:13:15', 'admin@example.com', 'DAT', 'table delete - success', 1),
(205, '2017-09-27 10:42:54', 'admin@example.com', 'ACC', 'login', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `email` varchar(64) NOT NULL,
  `name` char(30) NOT NULL,
  `surname` char(30) NOT NULL,
  `password` varchar(64) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`email`, `name`, `surname`, `password`, `registration_date`, `description`) VALUES
('admin@example.com', 'Admin', 'Example', '$2y$10$6E86wGsWTDzRop/Gly9.1uwLPgjNkDAyV61CDWrYmfvVlIagttT1.', '2017-08-26 07:42:32', '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `apikeys`
--
ALTER TABLE `apikeys`
  ADD PRIMARY KEY (`apikey`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `dbcols`
--
ALTER TABLE `dbcols`
  ADD PRIMARY KEY (`id`),
  ADD KEY `database_id` (`database_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `dbcols_ibfk_6` (`table_id`);

--
-- Indici per le tabelle `dbdatabases`
--
ALTER TABLE `dbdatabases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `dbtables`
--
ALTER TABLE `dbtables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `database_id` (`database_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `object3d`
--
ALTER TABLE `object3d`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `userlogs`
--
ALTER TABLE `userlogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `object3d`
--
ALTER TABLE `object3d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4329;
--
-- AUTO_INCREMENT per la tabella `userlogs`
--
ALTER TABLE `userlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `apikeys`
--
ALTER TABLE `apikeys`
  ADD CONSTRAINT `apikeys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`email`);

--
-- Limiti per la tabella `dbcols`
--
ALTER TABLE `dbcols`
  ADD CONSTRAINT `dbcols_ibfk_1` FOREIGN KEY (`database_id`) REFERENCES `dbdatabases` (`id`),
  ADD CONSTRAINT `dbcols_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`email`),
  ADD CONSTRAINT `dbcols_ibfk_6` FOREIGN KEY (`table_id`) REFERENCES `dbtables` (`id`);

--
-- Limiti per la tabella `dbdatabases`
--
ALTER TABLE `dbdatabases`
  ADD CONSTRAINT `dbdatabases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`email`);

--
-- Limiti per la tabella `dbtables`
--
ALTER TABLE `dbtables`
  ADD CONSTRAINT `dbtables_ibfk_1` FOREIGN KEY (`database_id`) REFERENCES `dbdatabases` (`id`),
  ADD CONSTRAINT `dbtables_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`email`);

--
-- Limiti per la tabella `userlogs`
--
ALTER TABLE `userlogs`
  ADD CONSTRAINT `userlogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`email`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
