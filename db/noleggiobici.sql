-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 29, 2024 alle 18:55
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noleggiobici`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `bici`
--

CREATE TABLE `bici` (
  `codice_identificativo` int(11) NOT NULL,
  `km_totali` int(11) NOT NULL,
  `isRented` tinyint(1) NOT NULL,
  `id_stazione` int(11) NOT NULL,
  `codice_gps` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `carte_credito`
--

CREATE TABLE `carte_credito` (
  `ID` int(11) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `numero` varchar(16) NOT NULL,
  `cvv` int(11) NOT NULL,
  `data_scadenza` date NOT NULL,
  `codice_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE `clienti` (
  `codice_identificativo` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `codice_bici` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `gps`
--

CREATE TABLE `gps` (
  `codice_identificativo` int(11) NOT NULL,
  `tipo_batteria` varchar(16) NOT NULL,
  `isCharged` tinyint(1) NOT NULL,
  `isOn` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi`
--

CREATE TABLE `indirizzi` (
  `ID` int(11) NOT NULL,
  `città` varchar(32) NOT NULL,
  `via` varchar(32) NOT NULL,
  `numero_civico` int(11) NOT NULL,
  `cap` varchar(5) NOT NULL,
  `codice_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `smart_cards`
--

CREATE TABLE `smart_cards` (
  `ID` int(11) NOT NULL,
  `codice_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `stazione`
--

CREATE TABLE `stazione` (
  `ID` int(11) NOT NULL,
  `longitudine` varchar(32) NOT NULL,
  `latitudine` varchar(32) NOT NULL,
  `num_slot` int(11) NOT NULL,
  `num_bici_disp` int(11) NOT NULL,
  `id_indirizzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `bici`
--
ALTER TABLE `bici`
  ADD PRIMARY KEY (`codice_identificativo`),
  ADD KEY `id_sede` (`id_stazione`,`codice_gps`),
  ADD KEY `codice_gps` (`codice_gps`),
  ADD KEY `id_stazione` (`id_stazione`);

--
-- Indici per le tabelle `carte_credito`
--
ALTER TABLE `carte_credito`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_cliente` (`codice_cliente`),
  ADD KEY `codice_cliente` (`codice_cliente`);

--
-- Indici per le tabelle `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`codice_identificativo`),
  ADD KEY `codice_bici` (`codice_bici`);

--
-- Indici per le tabelle `gps`
--
ALTER TABLE `gps`
  ADD PRIMARY KEY (`codice_identificativo`);

--
-- Indici per le tabelle `indirizzi`
--
ALTER TABLE `indirizzi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `username_cliente` (`codice_cliente`),
  ADD KEY `codice_cliente` (`codice_cliente`);

--
-- Indici per le tabelle `smart_cards`
--
ALTER TABLE `smart_cards`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `codice_cliente` (`codice_cliente`);

--
-- Indici per le tabelle `stazione`
--
ALTER TABLE `stazione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_indirizzo` (`id_indirizzo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `carte_credito`
--
ALTER TABLE `carte_credito`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `smart_cards`
--
ALTER TABLE `smart_cards`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `stazione`
--
ALTER TABLE `stazione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bici`
--
ALTER TABLE `bici`
  ADD CONSTRAINT `bici_ibfk_1` FOREIGN KEY (`codice_gps`) REFERENCES `gps` (`codice_identificativo`),
  ADD CONSTRAINT `bici_ibfk_2` FOREIGN KEY (`id_stazione`) REFERENCES `stazione` (`ID`);

--
-- Limiti per la tabella `clienti`
--
ALTER TABLE `clienti`
  ADD CONSTRAINT `clienti_ibfk_1` FOREIGN KEY (`codice_identificativo`) REFERENCES `carte_credito` (`codice_cliente`),
  ADD CONSTRAINT `clienti_ibfk_2` FOREIGN KEY (`codice_bici`) REFERENCES `bici` (`codice_identificativo`);

--
-- Limiti per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  ADD CONSTRAINT `indirizzi_ibfk_1` FOREIGN KEY (`codice_cliente`) REFERENCES `clienti` (`codice_identificativo`);

--
-- Limiti per la tabella `smart_cards`
--
ALTER TABLE `smart_cards`
  ADD CONSTRAINT `smart_cards_ibfk_1` FOREIGN KEY (`codice_cliente`) REFERENCES `clienti` (`codice_identificativo`);

--
-- Limiti per la tabella `stazione`
--
ALTER TABLE `stazione`
  ADD CONSTRAINT `stazione_ibfk_1` FOREIGN KEY (`id_indirizzo`) REFERENCES `indirizzi` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
