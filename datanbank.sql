-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 24. Mai 2023 um 23:13
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `speisekarte_jwe`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `id` int(10) UNSIGNED NOT NULL,
  `benutzername` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `passwort` varchar(255) NOT NULL,
  `letztes_login` datetime DEFAULT NULL,
  `anzahl_logins` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`id`, `benutzername`, `email`, `passwort`, `letztes_login`, `anzahl_logins`) VALUES
(1, 'ardalan', 'Ardalan@gmail.com', 'ardi123', '2023-03-18 11:40:19', 1),
(2, 'ardi', 'lisa123@gmail.com', '$2y$10$5/.mbVFOhm7kr7AVlNCGdutMY/iWb5g5/zrR.4cJADdp9ttZmKw1C', '2023-05-24 22:16:19', 19),
(3, 'ardi', 'ardi@gmx.at', 'asdf', '2023-05-24 22:16:19', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `getraeke`
--

CREATE TABLE `getraeke` (
  `id` int(10) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `menge` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `getraeke`
--

INSERT INTO `getraeke` (`id`, `titel`, `menge`) VALUES
(1, 'Cola', 0.25);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezepte`
--

CREATE TABLE `rezepte` (
  `id` int(10) UNSIGNED NOT NULL,
  `benutzer_id` int(10) UNSIGNED DEFAULT NULL,
  `titel` varchar(190) DEFAULT NULL,
  `beschreibung` text DEFAULT NULL,
  `img_url` varchar(255) NOT NULL,
  `preis` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `rezepte`
--

INSERT INTO `rezepte` (`id`, `benutzer_id`, `titel`, `beschreibung`, `img_url`, `preis`) VALUES
(1, 2, 'Kaiserschmarren', 'Frische Kaiserschmarren', 'http://localhost/Speisekarte/speisekarte/img/kaiserschmarn.webp', '8.50 €'),
(2, 2, 'Margherita', 'Tomatensauce, Mozarella, Basilikum', 'http://localhost/Speisekarte/speisekarte/img/Pizza%20Margaritha%20Mild.jpg\n\n', '10.50 €'),
(4, 2, 'Pomodoro', 'Tomatensauce, Tomaten, Pizzakäse, Basilikum, Knoblauchrand', 'http://localhost/Speisekarte/speisekarte/img/Pizza%20Margaritha.jpg', '11.50 €'),
(5, 2, 'Ruccola', 'Tomatensauce, Mozarella, frische Ruccola, Parmesan', 'http://localhost/Speisekarte/speisekarte/img/Pizza%20Rucola.jpg', '12.50 €'),
(6, 2, 'Salami', 'Tomatensauce, Mozarella, Salami, Peperoni, Oliven', 'http://localhost/Speisekarte/speisekarte/img/Pizza%20Salami.jpg', '13.50 €'),
(7, 2, 'Bella', 'Jogurt, Pizzakäse, Speck, Zwiebel, Kartoffel, Knoblauchrand', 'http://localhost/Speisekarte/speisekarte/img/Pizza%20Bella.jpg', '13.50€'),
(8, 2, 'Funghi', 'Tomatensauce, Mozarella, Champignons, Zwiebel, rosmarin, Knoblauchrand', 'http://localhost/Speisekarte/speisekarte/img/Piizza%20Champion.jpg', '11.50 €'),
(9, 2, 'Verdura', 'Tomatensauce, Mozarella, Gemüse der Saison', 'http://localhost/Speisekarte/speisekarte/img/Pizza%20Special.jpg', '14.50 €'),
(10, 2, 'Quattro Formaggi', 'Knoblauchrand, Tomatensauce, Käse, Schwarze Oliven, Champignons, Artischocken, Schinken, Basilikum', 'http://localhost/Speisekarte/speisekarte/img/pizza%20quattro%20formaggi.jpg', '14.50 €');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutaten`
--

CREATE TABLE `zutaten` (
  `id` int(10) UNSIGNED NOT NULL,
  `titel` varchar(190) NOT NULL,
  `kcal_pro_100` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zutaten`
--

INSERT INTO `zutaten` (`id`, `titel`, `kcal_pro_100`) VALUES
(1, 'Mehl', NULL),
(2, 'Milch', NULL),
(4, 'Basilikum', NULL),
(5, 'Petersilie', 2),
(6, 'Jogurt', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutaten_zu_rezepte`
--

CREATE TABLE `zutaten_zu_rezepte` (
  `id` int(10) UNSIGNED NOT NULL,
  `rezepte_id` int(10) UNSIGNED NOT NULL,
  `zutaten_id` int(10) UNSIGNED NOT NULL,
  `menge` int(11) DEFAULT NULL,
  `einheit` varchar(190) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zutaten_zu_rezepte`
--

INSERT INTO `zutaten_zu_rezepte` (`id`, `rezepte_id`, `zutaten_id`, `menge`, `einheit`) VALUES
(3, 5, 4, 2, 'StÃ¼ck'),
(4, 6, 5, 5, 'kg'),
(5, 6, 2, 0, ''),
(6, 6, 1, 0, ''),
(7, 6, 6, 0, ''),
(10, 1, 1, 0, ''),
(11, 1, 2, 0, ''),
(12, 7, 1, 1, 'g');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `getraeke`
--
ALTER TABLE `getraeke`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benutzer_id` (`benutzer_id`);

--
-- Indizes für die Tabelle `zutaten`
--
ALTER TABLE `zutaten`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `zutaten_zu_rezepte`
--
ALTER TABLE `zutaten_zu_rezepte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rezepte_id` (`rezepte_id`),
  ADD KEY `zutaten_id` (`zutaten_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `getraeke`
--
ALTER TABLE `getraeke`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `zutaten`
--
ALTER TABLE `zutaten`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `zutaten_zu_rezepte`
--
ALTER TABLE `zutaten_zu_rezepte`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  ADD CONSTRAINT `rezepte_ibfk_1` FOREIGN KEY (`benutzer_id`) REFERENCES `benutzer` (`id`);

--
-- Constraints der Tabelle `zutaten_zu_rezepte`
--
ALTER TABLE `zutaten_zu_rezepte`
  ADD CONSTRAINT `zutaten_zu_rezepte_ibfk_1` FOREIGN KEY (`rezepte_id`) REFERENCES `rezepte` (`id`),
  ADD CONSTRAINT `zutaten_zu_rezepte_ibfk_2` FOREIGN KEY (`zutaten_id`) REFERENCES `zutaten` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
