-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 07, 2019 alle 17:32
-- Versione del server: 10.1.37-MariaDB
-- Versione PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wxtracker`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `cldtypes`
--

CREATE TABLE `cldtypes` (
  `id` int(11) NOT NULL,
  `nube` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `cldtypes`
--

INSERT INTO `cldtypes` (`id`, `nube`) VALUES
(1, 'CIRRUS'),
(2, 'CIRROCUMULUS'),
(3, 'CIRROSTRATUS'),
(4, 'ALTOCUMULUS'),
(5, 'ALTOSTRATUS'),
(6, 'STRATOCUMULUS'),
(7, 'STRATUS'),
(8, 'CUMULUS HUMULIS'),
(9, 'CUMULUS CONGESTUS'),
(10, 'CUMULUS FRACTUS'),
(11, 'NEMBOSTRATUS'),
(12, 'CUMULONIMBUS');

-- --------------------------------------------------------

--
-- Struttura della tabella `prevdata`
--

CREATE TABLE `prevdata` (
  `id` int(11) NOT NULL,
  `pvTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pvValid` varchar(10) NOT NULL,
  `pvGeneral` varchar(120) NOT NULL,
  `pvSpecific` text NOT NULL,
  `pvRmk` varchar(150) NOT NULL,
  `pvNote` varchar(100) NOT NULL,
  `raw` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prevdata`
--

INSERT INTO `prevdata` (`id`, `pvTime`, `pvValid`, `pvGeneral`, `pvSpecific`, `pvRmk`, `pvNote`, `raw`) VALUES
(1, '2019-02-01 15:01:22', '0114/0224', '35005KT 5000 RA BR BKN035', 'TEMPO 0114/0118 03012KT\r\nBECMG 0202/0204 5000 BR BKN050\r\nBECMG 0212/0215 2000 RA', '', 'first', 'TAF LIDQ 011350Z 0114/0224 35005KT 5000 RA BR BKN035 TEMPO 0114/0118 03012KT BECMG 0202/0204 5000 BR BKN050'),
(2, '2019-02-02 14:07:28', '0214/0324', '03004KT 7000 BKN030', 'BECMG 0215/2018 4000 RADZ SCT015\r\nTEMPO 0302/0305 1500 RA BR\r\nBECMG 0305/0309 8000 BKN020\r\nBECMG 0315/0320 9999 NSW', '', '', 'TAF LIDQ 021320Z 0214/0324 03004KT 7000 BKN030 BECMG 0215/2018 4000 RADZ SCT015\r\nTEMPO 0302/0305 1500 RA BR\r\nBECMG 0305/0309 8000 BKN020\r\nBECMG 0315/0320 9999 NSW'),
(3, '2019-02-04 14:53:31', '0414/0524', '03008KT CAVOK', 'TEMPO 0504/0510 SCT090', '', '', 'TAF LIDQ 041350Z 0414/0524 03008KT CAVOK TEMPO 0504/0510 SCT090'),
(4, '2019-02-08 14:26:08', '0814/0924', '08003KT CAVOK', 'BECMG 0818/0824 36003KT SCT100\r\nPROB30 TEMPO 0910/0914 5000 BR SCT015\r\n\r\n', '', '', 'TAF LIDQ 081320Z 0814/0924 08003KT CAVOK BECMG 0818/0824 36003KT SCT100\r\nPROB30 TEMPO 0910/0914 5000 BR SCT015\r\n\r\n'),
(5, '2019-02-09 16:01:59', '0915/1024', '36002KT CAVOK', 'BECMG 0918/0922 FEW060\r\nBECMG 1004/1006 BKN025\r\nTEMPO 1008/1024 3000 RADZ', '', '', 'TAF LIDQ 091450Z 0915/1024 36002KT CAVOK BECMG 0918/0922 FEW060\r\nBECMG 1004/1006 BKN025\r\nTEMPO 1008/1024 3000 RADZ'),
(6, '2019-02-10 16:39:11', '1016/1124', '00000KT 2000 DZ BR OVC010', 'TEMPO 1016/1020 0400 RADZ PRFG\r\nBECMG 1100/1103 9999 SCT065\r\nPROB30 TEMPO 1106/1108 02010G20KT', '', '', 'TAF LIDQ 101520Z 1016/1124 00000KT 2000 DZ BR OVC010 TEMPO 1016/1020 0400 RADZ PRFG\r\nBECMG 1100/1103 9999 SCT065\r\nPROB30 TEMPO 1106/1108 02010G20KT'),
(7, '2019-02-11 15:41:19', '1115/1224', '01005KT 9999 SCT100', 'BECMG 1122/1124 CAVOK\r\nPROB40 BECMG 1205/1209 03015KT\r\n', '', '', 'TAF LIDQ 111450Z 1115/1224 01005KT 9999 SCT100 BECMG 1122/1124 CAVOK\r\nPROB40 BECMG 1205/1209 03015KT\r\n');

-- --------------------------------------------------------

--
-- Struttura della tabella `wxdata`
--

CREATE TABLE `wxdata` (
  `id` int(11) NOT NULL,
  `wxTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `wxDirV` varchar(3) NOT NULL DEFAULT '///',
  `wxVelV` varchar(6) NOT NULL DEFAULT '//',
  `wxVisib` varchar(60) DEFAULT NULL,
  `wxFen` varchar(60) NOT NULL,
  `wxNuv` varchar(60) DEFAULT '//////',
  `wxNuvType1` text,
  `wxNuvType2` text,
  `wxTempA` int(11) NOT NULL,
  `wxTempR` int(11) NOT NULL,
  `wxPress` varchar(4) NOT NULL DEFAULT '////',
  `trend` varchar(120) NOT NULL,
  `remarks` text NOT NULL,
  `raw` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `wxdata`
--

INSERT INTO `wxdata` (`id`, `wxTime`, `wxDirV`, `wxVelV`, `wxVisib`, `wxFen`, `wxNuv`, `wxNuvType1`, `wxNuvType2`, `wxTempA`, `wxTempR`, `wxPress`, `trend`, `remarks`, `raw`) VALUES
(7, '2018-12-16 20:02:51', '030', '01', '5000', 'BR', 'BKN030', '', NULL, 3, -2, '1016', '', 'first', 'METAR LIDQ 161820Z 03001KT 5000 BR BKN030 03/M01 Q1016'),
(9, '2018-12-16 23:20:41', '080', '07', '7000', 'MIFG', 'SCT015 BKN035', '', NULL, 2, -2, '1017', 'TEMPO 2000 BR', '', 'METAR LIDQ 162120Z 08007KT 7000 MIFG SCT015 BKN035 02/M02 Q1017 TEMPO 2000 BR'),
(10, '2018-12-17 15:20:32', 'VRB', '01', 'CAVOK', '', '', '', NULL, 8, -1, '1020', 'NOSIG', '', 'METAR LIDQ 171420Z VRB01KT CAVOK 08/M01 Q1020 NOSIG'),
(11, '2018-12-18 16:17:58', '030', '03', 'CAVOK', '', '', '', NULL, 4, -1, '1026', 'NOSIG', '', 'METAR LIDQ 181520Z 03003KT CAVOK 04/M01 Q1026 NOSIG'),
(12, '2018-12-19 15:47:21', 'VRB', '01', '7000', '-RADZ', 'SCT002 BKN035', '', NULL, 5, 1, '1021', '', '', 'METAR LIDQ 191450Z VRB01KT 7000 -RADZ SCT002 BKN035 05/01 Q1021 '),
(13, '2018-12-20 14:10:26', '180', '01', '9999', '', 'FEW013', '', NULL, 8, 3, '1021', 'NOSIG', '', 'METAR LIDQ 201320Z 18001KT 9999 FEW013 08/03 Q1021 NOSIG'),
(14, '2019-02-01 14:26:02', '020', '04', '8000', '-RADZ VCFG', 'SCT001 BKN012', '', NULL, 4, 3, '0995', 'TEMPO 3000 RA', '', 'METAR LIDQ 011320Z 02004KT 8000 -RADZ VCFG SCT001 BKN012 04/03 Q0995 TEMPO 3000 RA'),
(16, '2019-02-01 15:56:07', '000', '00', '4000', 'RA BR', 'BKN025 OVC040', '', NULL, 4, 3, '0995', 'NOSIG', '', 'METAR LIDQ 011450Z 00000KT 4000 RA BR BKN025 OVC040 04/03 Q0995 NOSIG'),
(17, '2019-02-02 13:19:59', '330', '01', '9999', '-RA', 'FEW030 BKN050', '', NULL, 5, 5, '0993', 'NOSIG', '', 'METAR LIDQ 020550Z 33001KT 9999 -RA FEW030 BKN050 05/05 Q0993 NOSIG'),
(18, '2019-02-02 13:21:53', 'VRB', '01', '6000 0600W', 'VCFG', 'BKN004', '', NULL, 7, 5, '0998', '', '', 'METAR LIDQ 021220Z VRB01KT 6000 0600W VCFG BKN004 07/05 Q0998 '),
(19, '2019-02-03 11:48:24', '360', '01', '9999', '', 'SCT015 BKN035', '', NULL, 7, 5, '1002', 'NOSIG', '', 'METAR LIDQ 031050Z 36001KT 9999 SCT015 BKN035 07/05 Q1002 NOSIG'),
(20, '2019-02-04 14:51:36', '360', '10', 'CAVOK', '', '', '', NULL, 8, -5, '1022', 'NOSIG', '', 'METAR LIDQ 040750Z 36010KT CAVOK 08/M05 Q1022 NOSIG'),
(21, '2019-02-04 14:52:04', '360', '05', 'CAVOK', '', '', '', NULL, 10, -4, '1024', 'NOSIG', '', 'METAR LIDQ 041350Z 36005KT CAVOK 10/M04 Q1024 NOSIG'),
(22, '2019-02-05 15:23:28', '030', '04', 'CAVOK', '', '', '', NULL, 0, -6, '1023', 'NOSIG', '', 'METAR LIDQ 050550Z 03004KT CAVOK 00/M06 Q1023 NOSIG'),
(23, '2019-02-05 15:23:55', '040', '01', 'CAVOK', '', '', '', NULL, 14, -2, '1023', 'NOSIG', '', 'METAR LIDQ 051420Z 04001KT CAVOK 14/M02 Q1023 NOSIG'),
(24, '2019-02-06 16:01:14', '360', '02', 'CAVOK', '', '', '', NULL, 12, -1, '1023', 'NOSIG', '', 'METAR LIDQ 061520Z 36002KT CAVOK 12/M01 Q1023 NOSIG'),
(25, '2019-02-08 14:19:11', '360', '04', 'CAVOK', '', '', '', NULL, 13, -3, '1019', 'NOSIG', '', 'METAR LIDQ 081320Z 36004KT CAVOK 13/M03 Q1019 NOSIG'),
(26, '2019-02-09 15:52:37', '000', '00', 'CAVOK', '', '', '', NULL, 12, 0, '1018', 'NOSIG', '', 'METAR LIDQ 091450Z 00000KT CAVOK 12/00 Q1018 NOSIG'),
(27, '2019-02-10 12:34:39', '000', '00', '3000', '-DZ BR', 'BKN030', '', NULL, 6, 4, '1014', 'NOSIG', '', 'METAR LIDQ 101120Z 00000KT 3000 -DZ BR BKN030 06/04 Q1014 NOSIG'),
(28, '2019-02-10 16:26:14', '000', '00', '0800', 'DZ FG', 'BKN006', '', NULL, 7, 5, '1010', '', '', 'METAR LIDQ 101520Z 00000KT 0800 DZ FG BKN006 07/05 Q1010 '),
(29, '2019-02-10 19:35:41', '000', '00', '0300', 'FG -RA', 'BKN001', '', NULL, 6, 6, '1007', '', '', 'METAR LIDQ 101820Z 00000KT 0300 FG -RA BKN001 06/06 Q1007 '),
(30, '2019-02-11 15:23:53', '000', '00', '9999', '', 'FEW090', '', NULL, 14, -2, '1011', 'NOSIG', '', 'METAR LIDQ 111420Z 00000KT 9999 FEW090 14/M02 Q1011 NOSIG'),
(31, '2019-02-12 15:45:27', '010', '03', 'CAVOK', '', '', '', NULL, 15, -6, '1022', 'NOSIG', '', 'METAR LIDQ 121450Z 01003KT CAVOK 15/M06 Q1022 NOSIG');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cldtypes`
--
ALTER TABLE `cldtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `prevdata`
--
ALTER TABLE `prevdata`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `wxdata`
--
ALTER TABLE `wxdata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `cldtypes`
--
ALTER TABLE `cldtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `prevdata`
--
ALTER TABLE `prevdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `wxdata`
--
ALTER TABLE `wxdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
