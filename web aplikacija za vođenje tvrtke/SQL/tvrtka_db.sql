-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 09:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tvrtka_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `izlazni_proizvodi`
--

CREATE TABLE `izlazni_proizvodi` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `napomena` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `izlazni_proizvodi`
--

INSERT INTO `izlazni_proizvodi` (`id`, `naziv`, `cijena`, `napomena`) VALUES
(8, 'Instalacija rasvjete', 45.00, 'Montaža i spajanje rasvjetnog tijela koristeći kabel, prekidač i rasvjetu'),
(9, 'Instalacija utičnice', 25.00, 'Postavljanje i spajanje jedne zidne utičnice'),
(10, 'Postavljanje kabela za rasvjetu', 3.50, 'Postavljanje kabela NYM-J 3x1.5 po metru'),
(11, 'Postavljanje kabela za utičnice', 4.00, 'Postavljanje kabela NYM-J 3x2.5 po metru'),
(12, 'Montaža LED panela 60x60', 45.00, 'Ugradnja LED panela u poslovnim ili uredskim prostorima'),
(13, 'Instalacija LED trake', 18.00, 'Postavljanje i spajanje LED trake po metru'),
(14, 'Ugradnja automatskog osigurača B16', 20.00, 'Ugradnja zaštitnog osigurača za strujni krug utičnica'),
(15, 'Ugradnja automatskog osigurača B10', 18.00, 'Ugradnja zaštitnog osigurača za rasvjetni krug'),
(16, 'Ugradnja FID sklopke', 55.00, 'Postavljanje FID sklopke za zaštitu električne instalacije'),
(17, 'Montaža razvodne kutije', 15.00, 'Postavljanje razvodne kutije i priprema za spajanje vodiča'),
(18, 'Spajanje vodiča u razvodnoj kutiji', 20.00, 'Spajanje električnih vodiča unutar razvodne kutije'),
(19, 'Montaža razvodnog ormara 24 modula', 120.00, 'Montaža i priprema razvodnog ormara za spajanje instalacije'),
(20, 'Spajanje razvodnog ormara', 450.00, 'Spajanje osigurača, FID sklopki i vodiča u razvodnom ormaru'),
(21, 'Zamjena stare utičnice', 18.00, 'Demontaža stare i postavljanje nove zidne utičnice'),
(22, 'Zamjena prekidača', 16.00, 'Demontaža starog i postavljanje novog jednopolnog prekidača'),
(23, 'Izrada rasvjetnog kruga', 180.00, 'Izrada kompletnog rasvjetnog kruga s kabelima, prekidačem i zaštitom'),
(24, 'Izrada kruga utičnica', 220.00, 'Izrada strujnog kruga za utičnice s kabelima i osiguračem'),
(25, 'Kompletna elektroinstalacija manje prostorije', 650.00, 'Postavljanje kablova, utičnica, prekidača, rasvjete i zaštitne opreme'),
(26, 'Servis elektroinstalacija', 80.00, 'Pregled, dijagnostika i manji popravci elektroinstalacija'),
(27, 'Održavanje rasvjete', 60.00, 'Zamjena ili popravak rasvjetnih elemenata i pripadajuće instalacije');

-- --------------------------------------------------------

--
-- Table structure for table `izlazni_proizvod_materijali`
--

CREATE TABLE `izlazni_proizvod_materijali` (
  `id` int(11) NOT NULL,
  `izlazni_proizvod_id` int(11) NOT NULL,
  `materijal_id` int(11) NOT NULL,
  `potrosena_kolicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `izlazni_proizvod_materijali`
--

INSERT INTO `izlazni_proizvod_materijali` (`id`, `izlazni_proizvod_id`, `materijal_id`, `potrosena_kolicina`) VALUES
(1, 8, 10, 10),
(2, 10, 1, 250),
(3, 13, 11, 10),
(9, 19, 12, 2),
(11, 11, 2, 1200),
(12, 22, 8, 5),
(13, 21, 7, 21),
(14, 16, 6, 4),
(15, 16, 1, 4000),
(16, 18, 9, 7),
(17, 14, 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `materijali`
--

CREATE TABLE `materijali` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `kategorija` varchar(100) DEFAULT NULL,
  `jedinica_mjere` varchar(30) DEFAULT NULL,
  `kolicina` int(11) NOT NULL,
  `minimalna_kolicina_pri_narucivanju` int(11) DEFAULT 0,
  `cijena` decimal(10,2) DEFAULT NULL,
  `dobavljac` varchar(100) DEFAULT NULL,
  `napomena` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materijali`
--

INSERT INTO `materijali` (`id`, `naziv`, `kategorija`, `jedinica_mjere`, `kolicina`, `minimalna_kolicina_pri_narucivanju`, `cijena`, `dobavljac`, `napomena`) VALUES
(1, 'Kabel NYM-J 3x1.5', 'Kabeli', 'metar', 10750, 500, 0.85, 'ElektroCentar d.o.o.', 'Za rasvjetne instalacije'),
(2, 'Kabel NYM-J 3x2.5', 'Kabeli', 'metar', 8980, 500, 1.20, 'ElektroCentar d.o.o.', 'Za utičnice'),
(3, 'Kabel P/F 1x2.5', 'Kabeli', 'metar', 1180, 500, 0.45, 'ElektroCentar d.o.o.', 'Za razvodne ormare'),
(4, 'Automatski osigurač B16', 'Zaštitna oprema', 'komad', 27, 10, 4.50, 'Schneider Electric', 'Standardni osigurač za utičnice'),
(5, 'Automatski osigurač B10', 'Zaštitna oprema', 'komad', 28, 10, 4.30, 'Schneider Electric', 'Za rasvjetne krugove'),
(6, 'FID sklopka 40A 30mA', 'Zaštitna oprema', 'komad', 6, 3, 32.00, 'ElektroPartner d.o.o.', 'Za zaštitu instalacija'),
(7, 'Utičnica bijela', 'Elektro materijal', 'komad', 78, 20, 2.30, 'ElektroCentar d.o.o.', 'Standardna zidna utičnica'),
(8, 'Prekidač jednopolni bijeli', 'Elektro materijal', 'komad', 48, 20, 2.10, 'ElektroCentar d.o.o.', 'Standardni prekidač'),
(9, 'Razvodna kutija', 'Instalacijski materijal', 'komad', 53, 15, 1.40, 'Instal Elektro d.o.o.', 'Za spajanje vodiča'),
(10, 'LED panel 60x60', 'Rasvjeta', 'komad', 99, 5, 28.00, 'Rasvjeta Plus', 'Za uredske prostore'),
(11, 'LED traka 12V', 'Rasvjeta', 'metar', 31, 10, 3.20, 'Rasvjeta Plus', 'Dekorativna rasvjeta'),
(12, 'Razvodni ormar 24 modula', 'Razvodni ormari', 'komad', 7, 2, 45.00, 'ElektroPartner d.o.o.', 'Za manje objekte'),
(13, 'Razvodni ormar 82 modula', 'Razvodni ormari', 'komad', 9, 1, 130.00, 'ElektroPartner d.o.o.', 'Za velike objekte');

-- --------------------------------------------------------

--
-- Table structure for table `prihodi`
--

CREATE TABLE `prihodi` (
  `id` int(11) NOT NULL,
  `naziv_prihoda` varchar(150) NOT NULL,
  `tvrtka` varchar(100) DEFAULT NULL,
  `vrsta_prihoda` varchar(100) DEFAULT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `datum_isplate` date DEFAULT NULL,
  `napomena` text DEFAULT NULL,
  `projekt_id` int(11) DEFAULT NULL,
  `izlazni_proizvod_id` int(11) DEFAULT NULL,
  `kolicina` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prihodi`
--

INSERT INTO `prihodi` (`id`, `naziv_prihoda`, `tvrtka`, `vrsta_prihoda`, `cijena`, `datum_isplate`, `napomena`, `projekt_id`, `izlazni_proizvod_id`, `kolicina`) VALUES
(5, 'Instalacija rasvjete', 'Privatni investitor', 'Izlazni proizvod / usluga', 350.00, '2026-05-03', 'Montaža i spajanje rasvjetnog tijela koristeći kabel, prekidač i rasvjetu | Količina: 10 | Cijena po jedinici: 35.00 €', NULL, 8, 10),
(7, 'Instalacija vanjske rasvjete', 'Privatni investitor', 'Završeni projekt', 890.00, '2026-05-20', 'Automatski dodano nakon označavanja projekta kao završenog.', 10, NULL, 1),
(9, 'Montaža razvodnog ormara 24 modula', 'Metal Mont d.o.o.	', 'Izlazni proizvod / usluga', 240.00, '2026-01-05', 'Montaža i priprema razvodnog ormara za spajanje instalacije | Količina: 2 | Cijena po jedinici: 120.00 €', NULL, 19, 2),
(11, 'Elektroinstalacije poslovnog prostora', 'Metal Mont d.o.o.', 'Završeni projekt', 3200.00, '2026-05-20', 'Automatski dodano nakon označavanja projekta kao završenog.', 7, NULL, 1),
(14, 'Postavljanje LED rasvjete u skladištu', 'Interpol d.o.o.', 'Završeni projekt', 2300.00, '2026-05-25', 'Automatski dodano nakon označavanja projekta kao završenog.', 8, NULL, 1),
(15, 'Elektroinstalacije utovarno-istovarne zone', 'LogiCore d.o.o.', 'Završeni projekt', 11700.00, '2026-05-26', 'Automatski dodano nakon označavanja projekta kao završenog.', 13, NULL, 1),
(16, 'Instalacija industrijske LED rasvjete', 'Metalis Inženjering d.o.o.', 'Završeni projekt', 14000.00, '2026-05-26', 'Automatski dodano nakon označavanja projekta kao završenog.', 14, NULL, 1),
(17, 'Modernizacija rasvjete poslovnog objekta', 'InterPol d.o.o.', 'Završeni projekt', 19000.00, '2026-05-26', 'Automatski dodano nakon označavanja projekta kao završenog.', 15, NULL, 1),
(18, 'Napajanje proizvodne linije', 'Industria Nova d.o.o.', 'Završeni projekt', 18900.00, '2026-05-26', 'Automatski dodano nakon označavanja projekta kao završenog.', 16, NULL, 1),
(19, 'Rekonstrukcija elektroinstalacija radionice', 'Metalis Inženjering d.o.o.', 'Završeni projekt', 11000.00, '2026-05-26', 'Automatski dodano nakon označavanja projekta kao završenog.', 17, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `projekti`
--

CREATE TABLE `projekti` (
  `id` int(11) NOT NULL,
  `naziv_projekta` varchar(100) NOT NULL,
  `tvrtka` varchar(100) NOT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `status` enum('Aktivan','Završen') DEFAULT 'Aktivan',
  `rok_zavrsetka` date DEFAULT NULL,
  `grad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projekti`
--

INSERT INTO `projekti` (`id`, `naziv_projekta`, `tvrtka`, `cijena`, `status`, `rok_zavrsetka`, `grad`) VALUES
(7, 'Elektroinstalacije poslovnog prostora', 'Metal Mont d.o.o.', 3200.00, 'Završen', '2026-07-23', 'Zagreb'),
(8, 'Postavljanje LED rasvjete u skladištu', 'Interpol d.o.o.', 2300.00, 'Završen', '2026-05-03', 'Bjelovar'),
(9, 'Zamjena stare elektroinstalacije', 'Stanogradnja Centar d.o.o.', 5590.00, 'Aktivan', '2026-09-24', 'Osijek'),
(10, 'Instalacija vanjske rasvjete', 'Privatni investitor', 890.00, 'Završen', '2025-09-08', 'Virovitica'),
(11, 'Spajanje razvodnih ormara', 'Elektroloop d.o.o.', 7899.00, 'Aktivan', '2027-02-17', 'Slavonski Brod'),
(13, 'Elektroinstalacije utovarno-istovarne zone', 'LogiCore d.o.o.', 11700.00, 'Završen', '2026-05-04', 'Osijek'),
(14, 'Instalacija industrijske LED rasvjete', 'Metalis Inženjering d.o.o.', 14000.00, 'Završen', '2025-02-20', 'Koprivnica'),
(15, 'Modernizacija rasvjete poslovnog objekta', 'InterPol d.o.o.', 19000.00, 'Završen', '2025-11-11', 'Bjelovar'),
(16, 'Napajanje proizvodne linije', 'Industria Nova d.o.o.', 18900.00, 'Završen', '2025-07-08', 'Čakovec'),
(17, 'Rekonstrukcija elektroinstalacija radionice', 'Metalis Inženjering d.o.o.', 11000.00, 'Završen', '2025-12-17', 'Sisak'),
(18, 'Pametna rasvjeta uredskog prostora', 'Poslovni Centar Alfa d.o.o.', 22000.00, 'Aktivan', '2026-10-15', 'Varaždin'),
(19, 'Elektroinstalacije stambene zgrade', 'TehnoGradnja d.o.o.', 55000.00, 'Aktivan', '2027-06-24', 'Zadar'),
(20, 'Ugradnja punionica za električna vozila', 'LogiCore d.o.o.', 71600.00, 'Aktivan', '2027-02-23', 'Karlovac');

-- --------------------------------------------------------

--
-- Table structure for table `projekt_materijali`
--

CREATE TABLE `projekt_materijali` (
  `id` int(11) NOT NULL,
  `projekt_id` int(11) NOT NULL,
  `materijal_id` int(11) NOT NULL,
  `potrosena_kolicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projekt_materijali`
--

INSERT INTO `projekt_materijali` (`id`, `projekt_id`, `materijal_id`, `potrosena_kolicina`) VALUES
(1, 7, 3, 120),
(2, 7, 6, 3),
(3, 9, 6, 4),
(4, 11, 12, 4),
(5, 7, 1, 4000),
(6, 13, 7, 88),
(7, 13, 8, 66),
(8, 13, 6, 9),
(9, 13, 13, 3),
(10, 13, 2, 8000),
(11, 13, 1, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `ulazni_proizvodi`
--

CREATE TABLE `ulazni_proizvodi` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `napomena` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulazni_proizvodi`
--

INSERT INTO `ulazni_proizvodi` (`id`, `naziv`, `cijena`, `napomena`) VALUES
(17, 'LED panel 60x60', 28.00, 'Za uredske prostore'),
(18, 'LED traka 12V', 3.20, 'Dekorativna rasvjeta'),
(19, 'Razvodni ormar 24 modula', 45.00, 'Za manje objekte'),
(23, 'Kabel NYM-J 3x1.5', 0.85, 'Za rasvjetne instalacije'),
(24, 'Kabel NYM-J 3x2.5', 1.20, 'Za utičnice'),
(25, 'Kabel P/F 1x2.5', 0.45, 'Za razvodne ormare'),
(26, 'Automatski osigurač B16', 4.50, 'Standardni osigurač za utičnice'),
(27, 'Automatski osigurač B10', 4.30, 'Za rasvjetne krugove'),
(28, 'FID sklopka 40A 30mA', 32.00, 'Za zaštitu instalacija'),
(29, 'Utičnica bijela', 2.30, 'Standardna zidna utičnica'),
(30, 'Prekidač jednopolni bijeli', 2.10, 'Standardni prekidač'),
(31, 'Razvodna kutija', 1.40, 'Za spajanje vodiča'),
(32, 'LED panel 60x60', 28.00, 'Za uredske prostore'),
(33, 'LED traka 12V', 3.20, 'Dekorativna rasvjeta'),
(34, 'Razvodni ormar 24 modula', 45.00, 'Za manje objekte'),
(38, 'Razvodni ormar 82 modula', 130.00, 'Za velike objekte');

-- --------------------------------------------------------

--
-- Table structure for table `zaposlenici`
--

CREATE TABLE `zaposlenici` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `pozicija` varchar(50) NOT NULL,
  `placa` decimal(10,2) NOT NULL,
  `odradeni_sati` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zaposlenici`
--

INSERT INTO `zaposlenici` (`id`, `ime`, `prezime`, `pozicija`, `placa`, `odradeni_sati`) VALUES
(2, 'Marko', 'Marić', 'Voditelj projekta', 20.00, 230.00),
(3, 'Luka', 'Novak', 'Monter', 15.00, 220.00),
(4, 'Lovro', 'Livin', 'Monter', 14.00, 216.00),
(5, 'Ivan', 'Sitiv', 'Električar', 14.00, 240.00),
(6, 'Nikola', 'Radić', 'Električar', 16.00, 220.00),
(7, 'Slavko', 'Šimić', 'Monter', 16.00, 235.00),
(8, 'Tin', 'Julić', 'Voditelj projekta', 21.00, 170.00),
(9, 'Drago', 'Hulek', 'Električar', 11.00, 225.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `izlazni_proizvodi`
--
ALTER TABLE `izlazni_proizvodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `izlazni_proizvod_materijali`
--
ALTER TABLE `izlazni_proizvod_materijali`
  ADD PRIMARY KEY (`id`),
  ADD KEY `izlazni_proizvod_id` (`izlazni_proizvod_id`),
  ADD KEY `materijal_id` (`materijal_id`);

--
-- Indexes for table `materijali`
--
ALTER TABLE `materijali`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prihodi`
--
ALTER TABLE `prihodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projekti`
--
ALTER TABLE `projekti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projekt_materijali`
--
ALTER TABLE `projekt_materijali`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projekt_id` (`projekt_id`),
  ADD KEY `materijal_id` (`materijal_id`);

--
-- Indexes for table `ulazni_proizvodi`
--
ALTER TABLE `ulazni_proizvodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zaposlenici`
--
ALTER TABLE `zaposlenici`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `izlazni_proizvodi`
--
ALTER TABLE `izlazni_proizvodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `izlazni_proizvod_materijali`
--
ALTER TABLE `izlazni_proizvod_materijali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `materijali`
--
ALTER TABLE `materijali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `prihodi`
--
ALTER TABLE `prihodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `projekti`
--
ALTER TABLE `projekti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `projekt_materijali`
--
ALTER TABLE `projekt_materijali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ulazni_proizvodi`
--
ALTER TABLE `ulazni_proizvodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `zaposlenici`
--
ALTER TABLE `zaposlenici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `izlazni_proizvod_materijali`
--
ALTER TABLE `izlazni_proizvod_materijali`
  ADD CONSTRAINT `izlazni_proizvod_materijali_ibfk_1` FOREIGN KEY (`izlazni_proizvod_id`) REFERENCES `izlazni_proizvodi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `izlazni_proizvod_materijali_ibfk_2` FOREIGN KEY (`materijal_id`) REFERENCES `materijali` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projekt_materijali`
--
ALTER TABLE `projekt_materijali`
  ADD CONSTRAINT `projekt_materijali_ibfk_1` FOREIGN KEY (`projekt_id`) REFERENCES `projekti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projekt_materijali_ibfk_2` FOREIGN KEY (`materijal_id`) REFERENCES `materijali` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
