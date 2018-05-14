-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 14. Mai 2018 um 11:54
-- Server-Version: 10.1.31-MariaDB
-- PHP-Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `das`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login`
--

CREATE TABLE `login` (
  `Benutzername` varchar(255) NOT NULL,
  `Passwort` varchar(129) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `realm` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `login`
--

INSERT INTO `login` (`Benutzername`, `Passwort`, `nickname`, `realm`) VALUES
('Raffael', '64e953d2b576796fc43ab1ba61d368b3', 'Raffi', '2c8dad59d9e047a61af4161e3dab7606'),
('Andreas', 'f2b70e56c465dd32d7526d022f85b0df', 'Andi', '3b210148086038cb4b8feed5d2ffcb82'),
('Paula', '04ab28f7dd308e3b0f84b92ef2b3315b', 'Pauli', 'b21d4417c2eef6f58231f443df518cf8');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
