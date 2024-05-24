-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 24, 2024 alle 09:56
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

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
  `id_stazione` int(11) DEFAULT NULL,
  `codice_gps` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `bici`
--

INSERT INTO `bici` (`codice_identificativo`, `km_totali`, `isRented`, `id_stazione`, `codice_gps`) VALUES
(4, 890, 0, 5, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `carte_credito`
--

CREATE TABLE `carte_credito` (
  `ID` int(11) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `numero` varchar(16) NOT NULL,
  `codice_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE `clienti` (
  `codice_identificativo` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `codice_bici` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`codice_identificativo`, `username`, `password`, `email`, `isAdmin`, `codice_bici`) VALUES
(1, 'lv', '$2y$10$A69qRMkSlS5kzK48l87F7uCW37oZy9aDczWZS0Wtrhw7qRzlhG3GG', 'lorenzo@gmail.com', 1, NULL),
(9, 'pasqualino22', '$2y$10$YmqdyPNdPUa0L8xD2bKCJeP210g1UaglBG6QG6gy2gwNhbB5N7Hku', 'pasqualino22@gmail.com', 0, NULL),
(10, 'ciruzzo100', '$2y$10$aSpD7xRkE3qfSssVONcHl.I4rUWJlVTx2DiFT8jFo/qlu.KeuzW0.', 'ciruzzo100@gmail.com', 0, NULL),
(13, 'pasqualino45', '$2y$10$jSSzj4v/F7bRBXpHUb2kneKdJv4VHfYu5Eni8dWt6S6Ldf//2rFsi', 'pasqualino45@gmail.com', 0, NULL),
(26, 'Antonio88', '$2y$10$acyR/P.ZJEMXC129vEkItewkZ5LGxcUPttAOWHSQqXorywYYmUPL6', 'antoninoLoveFutbal@gmail.com', 0, NULL),
(27, 'alberto22', '$2y$10$ofZ6Z.nocqkzsm7OveyYTOQ8rUNaADnVymwWbYtQxX3gn9JaYvDIO', 'alberto@gmail.com', 0, NULL),
(28, 'nicola23', '$2y$10$r.8KZ1AZciqdSqhvmpHCqevWN6axugNetSBAZ6lml3rpzCjN5ojIG', 'nicola@gmail.com', 0, NULL),
(39, 'Finazzi90', '$2y$10$5Q8BKB3y6s8J0btYsMGvMO/pGc7LQc9dEWkpTiKe0jKPkYg/jZhk6', 'finazziGuidaOk@gmail.xom', 0, NULL),
(48, 'ver', '$2y$10$4bhVDcQ9Ap5IGBOkc9U7FOxQhLCciPXuJDgK2.YjH6W7bREfLvz82', 'verf@gmail.com', 0, NULL),
(49, 'ver2', '$2y$10$I93dgpgOk.6QHbD70oxx8eMrQehBqf74ZuchYfYCZsl4KQmAughUm', 'ss', 0, NULL),
(50, 'ver3', '$2y$10$VNxCasL33ACl6euHM09gR.Iycb9vzwmOZhFYK5s9LYR5L1OoDxMQG', 'ddd', 0, NULL),
(51, 'ver4', '$2y$10$L2TbntX7C2nlRQXVkmViuuVYAF4lNK5wYHafWCcgO8fVnG57cJZBW', 'a', 0, NULL);

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

--
-- Dump dei dati per la tabella `gps`
--

INSERT INTO `gps` (`codice_identificativo`, `tipo_batteria`, `isCharged`, `isOn`) VALUES
(0, 'Ricaricabile', 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi`
--

CREATE TABLE `indirizzi` (
  `ID` int(11) NOT NULL,
  `citta` varchar(32) NOT NULL,
  `via` varchar(32) NOT NULL,
  `numero_civico` varchar(5) NOT NULL,
  `cap` varchar(5) NOT NULL,
  `codice_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `indirizzi`
--

INSERT INTO `indirizzi` (`ID`, `citta`, `via`, `numero_civico`, `cap`, `codice_cliente`) VALUES
(7, 'Saronno', 'via dell\'alpino ', '22', '09999', 39),
(8, 'Milano', 'Via Giorgio Pallavicino', '22', '20154', NULL),
(9, 'Milano', 'Via Giulio Cesare Procaccini', '12', '20154', NULL),
(10, 'Milano', 'Via Cappuccini', '1', '20122', NULL),
(13, 'Milano', 'via passione', '12', '20122', NULL),
(38, 'Milano', 'Via passione', '12', '20122', NULL),
(40, 'Milano', 'Via Antonio Fogazzaro', '23', '20135', NULL),
(47, 'mariano', 'dfkdfdkkofod', '23', '34343', 48),
(48, 'ss', 'ss', '33', 'ss', 49),
(49, 'dd', 'dd ', '12', 'dd', 50),
(50, 'a', 'a', '22', 'a', 51);

-- --------------------------------------------------------

--
-- Struttura della tabella `richieste_blocco`
--

CREATE TABLE `richieste_blocco` (
  `ID` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `richieste_blocco`
--

INSERT INTO `richieste_blocco` (`ID`, `id_utente`, `username`) VALUES
(2, 50, 'ver3');

-- --------------------------------------------------------

--
-- Struttura della tabella `smart_cards`
--

CREATE TABLE `smart_cards` (
  `ID` int(11) NOT NULL,
  `codice_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `smart_cards`
--

INSERT INTO `smart_cards` (`ID`, `codice_cliente`) VALUES
(2, 9),
(3, 10),
(6, 13),
(15, 26),
(16, 27),
(17, 28),
(28, 39),
(41, 49),
(42, 51);

-- --------------------------------------------------------

--
-- Struttura della tabella `stazione`
--

CREATE TABLE `stazione` (
  `ID` int(11) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `longitudine` varchar(32) NOT NULL,
  `latitudine` varchar(32) NOT NULL,
  `num_slot` int(11) NOT NULL,
  `num_bici_disp` int(11) NOT NULL,
  `id_indirizzo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dump dei dati per la tabella `stazione`
--

INSERT INTO `stazione` (`ID`, `nome`, `longitudine`, `latitudine`, `num_slot`, `num_bici_disp`, `id_indirizzo`) VALUES
(1, 'Stazione 1', '9.162878267065034', '45.47161109266796', 20, 20, 8),
(2, 'Stazione 2', '9.173351600765779', '45.483881813937124', 20, 20, 9),
(3, 'Stazione 3', '9.201922282117052', '45.47033854298927', 89, 20, 10),
(5, 'Stazione Margherita', '9.209766', '45.457833', 54, 70, 40);

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
  ADD KEY `id_cliente` (`codice_cliente`);

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
-- Indici per le tabelle `richieste_blocco`
--
ALTER TABLE `richieste_blocco`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_utente` (`id_utente`);

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
-- AUTO_INCREMENT per la tabella `bici`
--
ALTER TABLE `bici`
  MODIFY `codice_identificativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `carte_credito`
--
ALTER TABLE `carte_credito`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `clienti`
--
ALTER TABLE `clienti`
  MODIFY `codice_identificativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT per la tabella `richieste_blocco`
--
ALTER TABLE `richieste_blocco`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `smart_cards`
--
ALTER TABLE `smart_cards`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT per la tabella `stazione`
--
ALTER TABLE `stazione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Limiti per la tabella `carte_credito`
--
ALTER TABLE `carte_credito`
  ADD CONSTRAINT `carte_credito_ibfk_1` FOREIGN KEY (`codice_cliente`) REFERENCES `clienti` (`codice_identificativo`);

--
-- Limiti per la tabella `clienti`
--
ALTER TABLE `clienti`
  ADD CONSTRAINT `clienti_ibfk_2` FOREIGN KEY (`codice_bici`) REFERENCES `bici` (`codice_identificativo`);

--
-- Limiti per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  ADD CONSTRAINT `indirizzi_ibfk_1` FOREIGN KEY (`codice_cliente`) REFERENCES `clienti` (`codice_identificativo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `richieste_blocco`
--
ALTER TABLE `richieste_blocco`
  ADD CONSTRAINT `richieste_blocco_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `clienti` (`codice_identificativo`);

--
-- Limiti per la tabella `smart_cards`
--
ALTER TABLE `smart_cards`
  ADD CONSTRAINT `smart_cards_ibfk_1` FOREIGN KEY (`codice_cliente`) REFERENCES `clienti` (`codice_identificativo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `stazione`
--
ALTER TABLE `stazione`
  ADD CONSTRAINT `stazione_ibfk_1` FOREIGN KEY (`id_indirizzo`) REFERENCES `indirizzi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
