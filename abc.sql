-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Cze 2016, 14:22
-- Wersja serwera: 10.1.10-MariaDB
-- Wersja PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `plan`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grupy`
--

CREATE TABLE `grupy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `id_rocznika` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `grupy`
--

INSERT INTO `grupy` (`id`, `nazwa`, `id_rocznika`) VALUES
(1, 'Lab. 12', 3),
(6, 'Lab. 2', 3),
(7, 'Ćw. 1', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opcje`
--

CREATE TABLE `opcje` (
  `id` int(11) NOT NULL,
  `dl_godz` int(11) NOT NULL DEFAULT '45',
  `dl_prz` int(11) NOT NULL DEFAULT '15',
  `startg` int(11) NOT NULL DEFAULT '8',
  `startm` int(11) NOT NULL DEFAULT '15'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `opcje`
--

INSERT INTO `opcje` (`id`, `dl_godz`, `dl_prz`, `startg`, `startm`) VALUES
(1, 45, 15, 8, 15);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plan`
--

CREATE TABLE `plan` (
  `id` int(11) NOT NULL,
  `id_przedmiot` int(11) NOT NULL,
  `id_grupa` int(11) NOT NULL,
  `id_nauczyciel` int(11) NOT NULL,
  `dzien` int(11) NOT NULL,
  `godzina` int(11) NOT NULL,
  `id_sala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `plan`
--

INSERT INTO `plan` (`id`, `id_przedmiot`, `id_grupa`, `id_nauczyciel`, `dzien`, `godzina`, `id_sala`) VALUES
(18, 2, 1, 5, 3, 1, 2),
(19, 4, 7, 2, 2, 1, 5),
(20, 1, 7, 2, 1, 6, 4),
(21, 2, 7, 10, 5, 1, 2),
(25, 2, 7, 10, 1, 1, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `stopien` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `imie` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `wykladowca` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `stopien`, `imie`, `nazwisko`, `wykladowca`, `admin`) VALUES
(2, 'Mgr', 'Radosław', 'Bukłaga', 1, 0),
(5, 'Prof.', 'Damian', 'Tak', 1, 0),
(9, '', 'admin', 'admin', 0, 1),
(10, 'Dr', 'Adam', 'Boss', 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `komentarz` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `przedmioty`
--

INSERT INTO `przedmioty` (`id`, `nazwa`, `komentarz`) VALUES
(1, 'Podstawy programowania', 'Dodatkowy'),
(2, 'Algorytmy i struktury danych', 'Obieralny'),
(4, 'Informatyka I', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rocznik`
--

CREATE TABLE `rocznik` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) COLLATE utf8_polish_ci NOT NULL DEFAULT '',
  `koniec` tinyint(4) NOT NULL DEFAULT '0',
  `id_opcje` int(11) NOT NULL DEFAULT '1',
  `Data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `rocznik`
--

INSERT INTO `rocznik` (`id`, `nazwa`, `koniec`, `id_opcje`, `Data`) VALUES
(3, 'Informatyka sem. 1', 1, 1, '2016-06-11'),
(4, 'Informatyka sem. 3', 0, 1, '2016-06-11');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `numer` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `rodzaj` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `sale`
--

INSERT INTO `sale` (`id`, `numer`, `rodzaj`) VALUES
(1, '109', NULL),
(2, '10', 'wykładowa'),
(3, '108a', NULL),
(4, '115c', NULL),
(5, '111', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nick` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `id_pracownika` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `nick`, `haslo`, `id_pracownika`) VALUES
(16, 'admin', 'haslo', 9);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `grupy`
--
ALTER TABLE `grupy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rocznika` (`id_rocznika`);

--
-- Indexes for table `opcje`
--
ALTER TABLE `opcje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sala` (`id_sala`),
  ADD KEY `id_nauczyciel` (`id_nauczyciel`),
  ADD KEY `id_grupa` (`id_grupa`),
  ADD KEY `id_przedmiot` (`id_przedmiot`) USING BTREE;

--
-- Indexes for table `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `rocznik`
--
ALTER TABLE `rocznik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_opcje` (`id_opcje`),
  ADD KEY `id_opcje_2` (`id_opcje`),
  ADD KEY `id_opcje_3` (`id_opcje`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pracownika` (`id_pracownika`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `grupy`
--
ALTER TABLE `grupy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT dla tabeli `opcje`
--
ALTER TABLE `opcje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `rocznik`
--
ALTER TABLE `rocznik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `grupy`
--
ALTER TABLE `grupy`
  ADD CONSTRAINT `grupy_ibfk_1` FOREIGN KEY (`id_rocznika`) REFERENCES `rocznik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `plan`
--
ALTER TABLE `plan`
  ADD CONSTRAINT `plan_ibfk_1` FOREIGN KEY (`id_przedmiot`) REFERENCES `przedmioty` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `plan_ibfk_2` FOREIGN KEY (`id_grupa`) REFERENCES `grupy` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `plan_ibfk_5` FOREIGN KEY (`id_sala`) REFERENCES `sale` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `plan_ibfk_6` FOREIGN KEY (`id_nauczyciel`) REFERENCES `pracownicy` (`id`);

--
-- Ograniczenia dla tabeli `rocznik`
--
ALTER TABLE `rocznik`
  ADD CONSTRAINT `rocznik_ibfk_1` FOREIGN KEY (`id_opcje`) REFERENCES `opcje` (`id`);

--
-- Ograniczenia dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`id_pracownika`) REFERENCES `pracownicy` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
