-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Nov 2018 um 13:00
-- Server-Version: 10.1.21-MariaDB
-- PHP-Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `newfiary`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `idbenutzer` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`idbenutzer`, `username`, `email`, `password`) VALUES
(3, 'erneut', 'admin_biberbach@aon.at', '$2y$13$QSXNkDAhNFeeSzuRvy6gBOEvdWE3NEkYa.Sm97VDAZw19Q3rtVdJu'),
(4, 'ich', 'birgit_haselmayr@aon.de', '$2y$13$T0Ypky3FoquHD/LewXVuHeVVsS6Inbs/87a9KjwLajAYecivlSiuC');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einsatzart`
--

CREATE TABLE `einsatzart` (
  `ideinsatzart` int(10) UNSIGNED NOT NULL,
  `einsatzart_name` varchar(255) NOT NULL COMMENT 'lookup für logbuch.unterkategorie abhängig von logbuch.kategorie=einsatz'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `einsatzart`
--

INSERT INTO `einsatzart` (`ideinsatzart`, `einsatzart_name`) VALUES
(1, 'Brandeinsatz'),
(2, 'Technischer Einsatz'),
(3, 'Schadstoffeinsatz');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fahrzeug`
--

CREATE TABLE `fahrzeug` (
  `idfahrzeug` int(10) UNSIGNED NOT NULL,
  `fahrzeugart` varchar(255) NOT NULL,
  `fahrzeugbezeichnung` varchar(255) NOT NULL,
  `gesamtkilometer` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fahrzeug`
--

INSERT INTO `fahrzeug` (`idfahrzeug`, `fahrzeugart`, `fahrzeugbezeichnung`, `gesamtkilometer`) VALUES
(1, 'KDO', 'Kommandofahrzeug', NULL),
(2, 'HLF', '', NULL),
(3, 'VF', '', NULL),
(4, 'LFAB', '', NULL),
(5, 'privat', '', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fahrzeugbesatzung`
--

CREATE TABLE `fahrzeugbesatzung` (
  `idlogbuch_logbuch` int(10) UNSIGNED NOT NULL,
  `idfahrzeug_fahrzeug` int(10) UNSIGNED NOT NULL,
  `idmitglieder_mitglieder` int(10) UNSIGNED NOT NULL,
  `rolle` varchar(255) NOT NULL,
  `atemschutz` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `feed`
--

CREATE TABLE `feed` (
  `idfeed` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `feed` longtext NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `feed`
--

INSERT INTO `feed` (`idfeed`, `title`, `feed`, `date`) VALUES
(1, 'Neues Feuerwehrauto!', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '2018-11-20'),
(2, 'Problem Schlüsselabgabe', 'adfadfasdfasdf', '2018-11-20'),
(3, 'Neuigkeit im FF HAUS', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam', '2018-11-20'),
(4, 'Problem', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam', '2018-11-20');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorie`
--

CREATE TABLE `kategorie` (
  `idcategory` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL COMMENT 'lookup für logbuch.kategorie'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `kategorie`
--

INSERT INTO `kategorie` (`idcategory`, `category_name`) VALUES
(1, 'Einsatz'),
(2, 'Übung'),
(3, 'Tätigkeit');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logbuch`
--

CREATE TABLE `logbuch` (
  `idlogbuch` int(11) UNSIGNED NOT NULL,
  `kategorie` varchar(255) NOT NULL,
  `unterkategorie` varchar(255) NOT NULL,
  `beschreibung` varchar(255) NOT NULL,
  `alarmzeit` datetime NOT NULL,
  `anforderer_name` varchar(255) NOT NULL,
  `anforderer_telefon_nr` varchar(255) NOT NULL,
  `beginn_datum` date NOT NULL,
  `beginn_zeit` time NOT NULL,
  `ende_datum` date NOT NULL,
  `ende_zeit` time NOT NULL,
  `plz` int(11) NOT NULL,
  `ort` varchar(255) NOT NULL,
  `straße` varchar(255) NOT NULL,
  `hausnummer` varchar(255) NOT NULL,
  `betriebsmittel` varchar(255) NOT NULL,
  `bericht` longtext NOT NULL,
  `wetter` varchar(255) DEFAULT NULL,
  `bodenbeschaffenheit` varchar(255) DEFAULT NULL,
  `notizen` longtext NOT NULL,
  `idbenutzer_benutzer` int(10) UNSIGNED NOT NULL,
  `metadata` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `logbuch`
--

INSERT INTO `logbuch` (`idlogbuch`, `kategorie`, `unterkategorie`, `beschreibung`, `alarmzeit`, `anforderer_name`, `anforderer_telefon_nr`, `beginn_datum`, `beginn_zeit`, `ende_datum`, `ende_zeit`, `plz`, `ort`, `straße`, `hausnummer`, `betriebsmittel`, `bericht`, `wetter`, `bodenbeschaffenheit`, `notizen`, `idbenutzer_benutzer`, `metadata`) VALUES
(1, 'einsatz', 'brandeinsatz', 'es hat gebrannt', '2018-10-10 08:08:39', 'unbekannt', 'unterdrückt', '2018-10-11', '00:00:00', '2018-10-09', '00:00:00', 4232, 'Hagenberg', 'Softwarepark', '11', 'viele', 'nix passirt', '{\"Sonne\":\"1\", \"Nebel\":0} für alle Wetterbedingungen mit 0 bzw 1 abspeicher und das heißt hakerl gesetzt oder nicht', 'siehe wetter', 'irgendwas', 1, '2018-11-16 22:01:18');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitglieder`
--

CREATE TABLE `mitglieder` (
  `idmitglieder` int(10) UNSIGNED NOT NULL,
  `standesbuchnummer` int(11) NOT NULL,
  `dienstgrad` varchar(255) NOT NULL,
  `vorname` varchar(255) NOT NULL,
  `nachname` varchar(255) NOT NULL,
  `telefon_nr` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `atemschutztauglich` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `mitglieder`
--

INSERT INTO `mitglieder` (`idmitglieder`, `standesbuchnummer`, `dienstgrad`, `vorname`, `nachname`, `telefon_nr`, `adresse`, `email`, `atemschutztauglich`) VALUES
(1, 56, 'SB', 'Gregor', 'Leitner', '0650/7526088', 'Am Hang 434', 'leitnergregor@gmail.com', 1),
(2, 23, 'OBI', 'Erich', 'Theuerkauf', '0650235212', 'Musterhausen 1', 'erich.mustermann@gmail.com', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rolle`
--

CREATE TABLE `rolle` (
  `idrolle` int(11) NOT NULL,
  `rollenname` varchar(255) NOT NULL COMMENT 'lookup für fahrzeugbesatzung.rolle'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `rolle`
--

INSERT INTO `rolle` (`idrolle`, `rollenname`) VALUES
(1, 'Einsatzleiter'),
(2, 'Lenker'),
(3, 'Gruppenkommandant'),
(4, 'Maschinist');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `uebungsart`
--

CREATE TABLE `uebungsart` (
  `iduebungsart` int(10) UNSIGNED NOT NULL,
  `uebungsname` varchar(255) NOT NULL COMMENT 'lookup für logbuch.unterkategorie abhängig von logbuch.kategorie=übung',
  `gesamtzeit` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `uebungsart`
--

INSERT INTO `uebungsart` (`iduebungsart`, `uebungsname`, `gesamtzeit`) VALUES
(1, 'Atemschutzübung', '0.00'),
(2, 'Gesamtübung', '0.00'),
(3, 'Bewerbsübung', '0.00'),
(4, 'Übungsfahrt', '0.00');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`idbenutzer`),
  ADD UNIQUE KEY `UNIQ_36144FC7E7927C74` (`email`);

--
-- Indizes für die Tabelle `einsatzart`
--
ALTER TABLE `einsatzart`
  ADD PRIMARY KEY (`ideinsatzart`);

--
-- Indizes für die Tabelle `fahrzeug`
--
ALTER TABLE `fahrzeug`
  ADD PRIMARY KEY (`idfahrzeug`);

--
-- Indizes für die Tabelle `fahrzeugbesatzung`
--
ALTER TABLE `fahrzeugbesatzung`
  ADD PRIMARY KEY (`idlogbuch_logbuch`,`idfahrzeug_fahrzeug`,`idmitglieder_mitglieder`),
  ADD KEY `idlogbuch_logbuch` (`idlogbuch_logbuch`),
  ADD KEY `idfahrzeug_fahrzeug` (`idfahrzeug_fahrzeug`),
  ADD KEY `idmitglieder_mitglieder` (`idmitglieder_mitglieder`);

--
-- Indizes für die Tabelle `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`idfeed`);

--
-- Indizes für die Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`idcategory`);

--
-- Indizes für die Tabelle `logbuch`
--
ALTER TABLE `logbuch`
  ADD PRIMARY KEY (`idlogbuch`),
  ADD KEY `idbenutzer_benutzer` (`idbenutzer_benutzer`);

--
-- Indizes für die Tabelle `mitglieder`
--
ALTER TABLE `mitglieder`
  ADD PRIMARY KEY (`idmitglieder`);

--
-- Indizes für die Tabelle `rolle`
--
ALTER TABLE `rolle`
  ADD PRIMARY KEY (`idrolle`);

--
-- Indizes für die Tabelle `uebungsart`
--
ALTER TABLE `uebungsart`
  ADD PRIMARY KEY (`iduebungsart`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `idbenutzer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `einsatzart`
--
ALTER TABLE `einsatzart`
  MODIFY `ideinsatzart` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `fahrzeug`
--
ALTER TABLE `fahrzeug`
  MODIFY `idfahrzeug` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `feed`
--
ALTER TABLE `feed`
  MODIFY `idfeed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `idcategory` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `logbuch`
--
ALTER TABLE `logbuch`
  MODIFY `idlogbuch` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `mitglieder`
--
ALTER TABLE `mitglieder`
  MODIFY `idmitglieder` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `rolle`
--
ALTER TABLE `rolle`
  MODIFY `idrolle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `uebungsart`
--
ALTER TABLE `uebungsart`
  MODIFY `iduebungsart` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
