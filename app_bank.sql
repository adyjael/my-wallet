-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Dez-2022 às 21:26
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `app_bank`
--
CREATE DATABASE IF NOT EXISTS `app_bank` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `app_bank`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `amount_total`
--

DROP TABLE IF EXISTS `amount_total`;
CREATE TABLE IF NOT EXISTS `amount_total` (
  `id_user` int(11) DEFAULT NULL,
  `saldo` decimal(20,2) NOT NULL,
  `saldo_retirado` decimal(20,2) NOT NULL,
  `saldo_enviado` decimal(20,2) NOT NULL,
  `saldo_recebido` decimal(20,2) NOT NULL,
  `saldo_depositado` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `amount_total`
--

INSERT DELAYED IGNORE INTO `amount_total` (`id_user`, `saldo`, `saldo_retirado`, `saldo_enviado`, `saldo_recebido`, `saldo_depositado`) VALUES
(2, '236.00', '878.00', '790.00', '0.00', '1904.00'),
(5, '1310.00', '0.00', '0.00', '1310.00', '0.00'),
(6, '1340.00', '610.00', '600.00', '350.00', '2200.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `deposit`
--

DROP TABLE IF EXISTS `deposit`;
CREATE TABLE IF NOT EXISTS `deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(20,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `deposit`
--

INSERT DELAYED IGNORE INTO `deposit` (`id`, `amount`, `user_id`, `date`) VALUES
(77, '200.00', 6, '2022-12-17 17:19:44'),
(78, '400.00', 6, '2022-12-17 17:19:49'),
(79, '400.00', 6, '2022-12-17 17:19:54'),
(80, '200.00', 6, '2022-12-17 17:19:58'),
(81, '1000.00', 6, '2022-12-17 17:21:18'),
(82, '200.00', 2, '2022-12-19 20:04:48'),
(83, '1000.00', 2, '2022-12-19 20:04:58'),
(84, '200.00', 2, '2022-12-19 20:10:05'),
(85, '354.00', 2, '2022-12-19 20:11:12'),
(86, '150.00', 2, '2022-12-19 20:13:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `take_money`
--

DROP TABLE IF EXISTS `take_money`;
CREATE TABLE IF NOT EXISTS `take_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(20,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `motivo` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `take_money`
--

INSERT DELAYED IGNORE INTO `take_money` (`id`, `amount`, `user_id`, `motivo`, `date`) VALUES
(65, '10.00', 6, 'Comprar pc gamer', '2022-12-17 17:20:07'),
(66, '100.00', 6, 'Comprar pão', '2022-12-17 17:20:15'),
(67, '200.00', 6, 'Cortar cabelo', '2022-12-17 17:20:22'),
(68, '200.00', 6, 'Comprar pão', '2022-12-17 17:20:32'),
(69, '100.00', 6, 'Feliz', '2022-12-17 17:20:43'),
(70, '200.00', 2, 'Comprar pc gamer', '2022-12-19 20:05:06'),
(71, '200.00', 2, 'Comprar pão', '2022-12-19 20:05:40'),
(72, '143.00', 2, 'Fazer janta', '2022-12-19 20:10:43'),
(73, '35.00', 2, 'Cortar cabelo', '2022-12-19 20:11:46'),
(74, '300.00', 2, 'Dar mendigo', '2022-12-19 20:13:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `transfer_money`
--

DROP TABLE IF EXISTS `transfer_money`;
CREATE TABLE IF NOT EXISTS `transfer_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(20,2) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `from_userid` int(11) NOT NULL,
  `to_userid` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `transfer_money`
--

INSERT DELAYED IGNORE INTO `transfer_money` (`id`, `amount`, `description`, `from_userid`, `to_userid`, `date`) VALUES
(44, '400.00', 'Feliz aniversario', 6, 2, '2022-12-17 17:20:58'),
(45, '100.00', 'Comprar pc gamer', 6, 2, '2022-12-17 17:21:10'),
(46, '100.00', 'Comprar pc gamer', 6, 2, '2022-12-17 17:21:27'),
(47, '100.00', 'Pagar divida de case ', 2, 6, '2022-12-19 20:05:18'),
(48, '400.00', 'Pagar divida de case ', 2, 5, '2022-12-19 20:11:21'),
(49, '250.00', 'Feliz aniversario', 2, 6, '2022-12-19 20:12:41'),
(50, '40.00', 'Comprar pc gamer', 2, 5, '2022-12-19 20:17:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(245) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT DELAYED IGNORE INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(2, 'Adyjael', 'adyjaelneto399@gmail.com', '$2y$10$aBQineiHxWxdR3DL.0oqWeUxCdYTpXNjPApLrNTcTbchSkYqPuyRe', '2022-12-14 22:14:49'),
(5, 'zarkff', 'zarkff@gmail.com', '$2y$10$DpFiFfiLryfMzvx.UeB8U.QK5Kt8afAYQG8/JZAyHKJ/oKN8mL4dq', '2022-12-14 22:26:29'),
(6, 'adyjaelneto', 'adyjaelneto66@gmail.com', '$2y$10$TlxQe79BnrrThmVCZY9j.e/ZeZspSl9sb0QwEhrSq6vVnXO/0l7Py', '2022-12-15 15:19:22');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `deposit`
--
ALTER TABLE `deposit`
  ADD CONSTRAINT `deposit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `take_money`
--
ALTER TABLE `take_money`
  ADD CONSTRAINT `take_money_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
