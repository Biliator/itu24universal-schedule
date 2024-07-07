-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2023 at 10:17 PM
-- Server version: 5.7.44
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xvorob02`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivity`
--

CREATE TABLE `aktivity` (
  `id_aktivity` int(8) NOT NULL,
  `predmet` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nazev` varchar(32) CHARACTER SET latin1 NOT NULL,
  `den` varchar(2) COLLATE utf8_czech_ci DEFAULT NULL,
  `cas` time DEFAULT NULL,
  `delka` smallint(6) NOT NULL,
  `typ` tinyint(4) NOT NULL,
  `mistnost` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vyucujici` varchar(10) COLLATE utf8_czech_ci DEFAULT NULL,
  `pozadavek` varchar(512) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `aktivity`
--

INSERT INTO `aktivity` (`id_aktivity`, `predmet`, `nazev`, `den`, `cas`, `delka`, `typ`, `mistnost`, `vyucujici`, `pozadavek`) VALUES
(0, 'IDM', 'cviceni', '1', '08:00:00', 2, 2, 'A-111', '	\nxvyucu00', NULL),
(1, 'IEL', 'prednaska', '1', '11:00:00', 3, 0, 'D-105', 'xadmin00', NULL),
(2, 'IEL', 'hromadne cviceni', '1', '14:00:00', 1, 1, 'D-205', '	\nxvyucu00', NULL),
(3, 'IEL', 'ciceni', '2', '09:00:00', 1, 2, 'A-211', '	\nxvyucu00', NULL),
(4, 'ILG', 'cviceni', '4', '10:00:00', 2, 2, 'C-123', '	\nxvyucu00', NULL),
(5, 'ILG', 'prednaska', '2', '11:00:00', 3, 0, 'A-218', '	\nxvyucu00', NULL),
(6, 'ILG', 'prednaska', '4', '12:00:00', 2, 0, 'A-211', '	\nxvyucu00', NULL),
(7, 'IUS', 'cviceni', '2', '13:00:00', 1, 2, 'D-105', '	\nxvyucu00', NULL),
(8, 'IEL', 'prednaska', '4', '11:00:00', 3, 0, 'D-105', '	\nxvyucu00', NULL),
(9, 'IDM', 'prednaska', '3', '13:00:00', 2, 0, 'D-206', '	\nxvyucu00', NULL),
(10, 'IEL', 'cviceni', '2', '15:00:00', 1, 2, 'A-111', '	\nxvyucu00', NULL),
(11, 'IZP', 'prednaska', '4', '09:00:00', 3, 0, 'C-123', '	\nxvyucu00', NULL),
(12, 'ILG', 'prednaska', '5', '10:00:00', 3, 0, 'D-105', '	\nxvyucu00', NULL),
(13, 'INC', 'prednaska', '2', '11:00:00', 2, 0, 'D-205', '	\nxvyucu00', NULL),
(14, 'IOS', 'prednaska', '3', '13:00:00', 2, 0, 'D-206', '	\nxvyucu00', NULL),
(15, 'ILG', 'cviceni', '5', '08:00:00', 1, 2, 'A-111', '	\nxvyucu00', NULL),
(20, 'ILG', 'cviceni', '5', '08:00:00', 1, 2, 'A-112', '	\nxvyucu00', NULL),
(21, 'ILG', 'cviceni', '5', '09:00:00', 1, 2, 'A-211', '	\nxvyucu00', NULL),
(22, 'ILG', 'cviceni', '5', '10:00:00', 1, 2, 'A-112', '	\nxvyucu00', NULL),
(23, 'ILG', 'cviceni', '5', '10:00:00', 1, 2, 'A-111', '	\nxvyucu00', NULL),
(24, 'ILG', 'cviceni', '5', '11:00:00', 1, 2, 'A-111', '	\nxvyucu00', NULL),
(25, 'ILG', 'cviceni', '5', '11:00:00', 1, 2, 'C-123', '	\nxvyucu00', NULL),
(26, 'ILG', 'cviceni', '5', '12:00:00', 1, 2, 'A-112', '	\nxvyucu00', NULL),
(27, 'IFJ', 'Prednaska', '2', '15:00:00', 2, 0, 'A-112', '	\nxvyucu00', NULL),
(30, 'AIT', 'Cviceno', NULL, NULL, 2, 2, NULL, NULL, 'Kapacita alespon 50'),
(31, 'IMA', 'Prednaska', NULL, NULL, 4, 0, NULL, NULL, 'Misnost bez oken'),
(32, 'ISU', 'Prednaska', NULL, NULL, 2, 0, NULL, NULL, 'Kapacita 200'),
(33, 'INC', 'Prednaska', NULL, NULL, 2, 0, NULL, NULL, 'Voldemort'),
(34, 'INC', 'Prednaska', NULL, NULL, 2, 0, NULL, NULL, 'Voldemort'),
(35, 'INC', 'Prednaska', NULL, NULL, 2, 1, NULL, NULL, 'Voldemort'),
(36, 'ITY', 'Cviko', '2', '15:00:00', 2, 1, NULL, NULL, 'fdfdfdfd'),
(37, 'IBS', 'Bezpecnost', '3', '14:00:00', 3, 1, 'A-112', NULL, NULL),
(38, 'IAL', 'Algoritmy', '4', '17:00:00', 2, 1, 'D-105', NULL, NULL),
(40, 'INP', 'Prednaska', NULL, NULL, 1, 1, NULL, NULL, 'Voldemort'),
(41, 'IFJ', 'Prednaska', '3', '15:00:00', 2, 0, 'D-105', 'xvyucu00', NULL),
(42, 'ICS', 'Prednaska', '1', '12:00:00', 3, 0, 'D-205', 'xvyucu02', NULL),
(43, 'INP', 'Prednaska', '5', '15:00:00', 3, 0, 'D-105', 'xvyucu00', NULL),
(44, 'IAL', 'Prednaska', '0', '15:00:00', 2, 0, 'D-205', 'xvyucu02', NULL),
(45, 'IAL', 'Cviko', '3', '08:00:00', 2, 2, 'A-111', 'xvyucu00', NULL),
(46, 'IAL', 'Cviko', '3', '12:00:00', 2, 2, 'A-111', 'xvyucu00', NULL),
(47, 'IPT', 'Cviko', '1', '08:00:00', 2, 2, 'A-111', 'xvyucu00', NULL),
(48, 'ISS', 'Cviko', '2', '12:00:00', 2, 2, 'A-111', 'xvyucu00', NULL),
(50, 'ITY', 'Prednaska', '5', '08:00:00', 2, 0, 'C-123', 'xvyucu00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mistnosti`
--

CREATE TABLE `mistnosti` (
  `cislo` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nazev` varchar(32) CHARACTER SET latin1 NOT NULL,
  `kapacita` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `mistnosti`
--

INSERT INTO `mistnosti` (`cislo`, `nazev`, `kapacita`) VALUES
('A', 'A', -5),
('A-111', 'Poslucharna 64', 50),
('A-112', 'Poslucharna 65', 50),
('A-211', 'Obhajovaci laborator', 50),
('A-218', 'Seminarni mistnost', 50),
('C-123', 'Studovna', 5),
('D-105', 'Poslucharna 4', 300),
('D-205', 'Poslucharna 32', 60),
('D-206', 'Poslucharna 123', 60);

-- --------------------------------------------------------

--
-- Table structure for table `Predmety`
--

CREATE TABLE `Predmety` (
  `zkratka` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nazev` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `kredity` int(1) NOT NULL,
  `semestr` varchar(5) COLLATE utf8_czech_ci NOT NULL,
  `fakulta` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `rocnik` int(1) NOT NULL,
  `garant` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `Predmety`
--

INSERT INTO `Predmety` (`zkratka`, `nazev`, `kredity`, `semestr`, `fakulta`, `rocnik`, `garant`) VALUES
('AIT', 'Anglictina', 3, 'letni', 'Inf. Tech.', 1, 'xgaran00'),
('IAL', 'Algoritmy', 5, 'zimni', 'Inf. Tech.', 2, 'xgaran00'),
('IBS', 'Bezpecnost', 4, 'zimni', 'Inf. Tech.', 2, 'xgaran00'),
('ICS', 'Seminar C#', 4, 'zimni', 'Inf. Tech.', 2, 'xgaran00'),
('IDM', 'Diskretni matematika', 5, 'zimni', 'Inf. Tech.', 1, 'xgaran00'),
('IDS', 'Databazove Systemy', 5, 'letni', 'Inf. Tech.', 2, 'xgaran00'),
('IEL', 'Elektronika', 6, 'letni', 'Inf. Tech.', 3, 'xgaran00'),
('IFJ', 'Formalni jazyky', 5, 'zimni', 'Inf. Tech.', 2, 'xmedun00'),
('IJA', 'Java', 4, 'letni', 'Inf. Tech.', 2, 'xgaran00'),
('ILG', 'Linearni Algebra', 5, 'zimni', 'Inf. Tech.', 1, 'xgaran00'),
('IMA', 'Matematika', 4, 'letni', 'Inf. Tech.', 1, 'xgaran00'),
('INC', 'Design dig. sys.', 5, 'letni', 'Inf. Tech.', 1, 'xgaran00'),
('INP', 'Design poc. sys.', 6, 'zimni', 'Inf. Tech.', 2, 'xgaran00'),
('IOS', 'Operacni systemy', 5, 'letni', 'Inf. Tech.', 1, 'xgaran00'),
('IPK', 'Site', 4, 'letni', 'Inf. Tech.', 2, 'xgaran00'),
('IPT', 'Statistika', 5, 'zimni', 'Inf. Tech.', 2, 'xgaran00'),
('ISA', 'Sprava site', 5, 'zimni', 'Inf. Tech.', 3, 'xgaran00'),
('ISS', 'Signaly a systemy', 6, 'zimni', 'Inf. Tech.', 2, 'xgaran00'),
('ISU', 'Asemblery', 6, 'letni', 'Inf. Tech.', 1, 'xgaran00'),
('ITY', 'Typografie', 4, 'zimni', 'Inf. Tech.', 2, 'xgaran00'),
('IUS', 'Software', 5, 'zimni', 'Inf. Tech.', 1, 'xgaran00'),
('IZG', 'Grafika', 6, 'letni', 'Inf. Tech.', 1, 'xgaran00'),
('IZP', 'Programovani', 7, 'zimni', 'Inf. Tech.', 1, 'xgaran00'),
('VA', 'Vlastni Aktivita', 99, '99', 'Inf. Tech.', 99, 'xaaxxx00');

-- --------------------------------------------------------

--
-- Table structure for table `prihlasen`
--

CREATE TABLE `prihlasen` (
  `osobni_cislo` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_aktivity` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `prihlasen`
--

INSERT INTO `prihlasen` (`osobni_cislo`, `id_aktivity`) VALUES
('xkanko03', 27),
('xstude00', 27),
('xvyucu00', 27),
('xstude00', 37),
('xstude00', 38),
('xstude00', 42),
('xvyucu00', 42),
('xstude00', 43),
('xstude00', 50);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `osobni_cislo` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `rok_narozeni` date NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `tel` int(9) NOT NULL,
  `prava` int(1) NOT NULL,
  `rocnik` int(1) UNSIGNED DEFAULT '1',
  `pozadavky` varchar(128) CHARACTER SET ascii DEFAULT NULL,
  `barva` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`osobni_cislo`, `pass`, `name`, `surname`, `rok_narozeni`, `email`, `tel`, `prava`, `rocnik`, `pozadavky`, `barva`) VALUES
('xaaxxx00', '$2y$10$gl7Fq8p7PzTX3.0rkNJhl.b.cKJ/NTrPOWql33KX9C0gybDMx/lXG', 'AA', 'AA', '1111-11-11', 'AA@aa.cz', 111, 1, NULL, NULL, '#A81515,#3EBDDA,#39A01C'),
('xadmin00', '$2y$10$G5wNp9qGVviDt88jEhIdfel1nR8SBLRAY4VZSjfaKcxVCh38QaISC', 'Admin', 'Admin', '1974-01-01', 'admin@admin.com', 158, 4, 0, '0101010101010110101010101010010101010101011010110010101010101011111111', '#A81515,#3EBDDA,#39A01C'),
('xgaran00', '$2y$10$fewAUR/NtXq3EKY3.wmfxOUMlBpGXqg8WqCxGnfRvWN.d42RZjPgC', 'Garant', 'Garant', '1990-01-01', 'garant@admin.com', 150, 3, 0, '0000111111111100111111111111000111111111111111111111111100111111110000', '#f8b500,#f7f7f7,#5c636e'),
('xjanxx00', '$2y$10$7fEJl6HxVfqEEUrtTW6DEOXfpWKu/kiAfxagynKVzrZC6O6cAFbDO', 'Vali', 'Jan', '2023-11-16', 'vorob@vorob.cz', 123, 0, 1, NULL, '#A81515,#3EBDDA,#39A01C'),
('xkanko00', '$2y$10$LdphGOGxy6eKy.3tEuKS3ep1dSLXZlBWE3MSxMjLQeL25BjttSfPy', 'Michal', 'Kankovsky', '2023-12-31', 'michalkankovsky@gmail.com', 555, 4, 0, NULL, '#A81515,#3EBDDA,#39A01C'),
('xkanko01', '$2y$10$I2F3kJprmgRkNYS79AWMSOC9mqgBf.rCTazkq7bWN9hUS749iGCke', 'Michal', 'Kankovsky', '2023-12-31', 'michalkankovsky@gmail.com', 555, 0, 2, NULL, '#A81515,#3EBDDA,#9db6e7'),
('xkanko02', '$2y$10$k2fdOyeFtTBzEMnJMIy.Tec93NivWOZKSOtnsQGDpyI7102asiJbi', 'Michal', 'Kankovsky', '2023-11-29', 'michalkankovsky@gmail.com', 555, 0, 3, '0101010101010110101010101010010101010101011010101010101001010101010101', '#A81515,#3EBDDA,#39A01C'),
('xkanko03', '$2y$10$6vgDU0IYGagHr7ENVwf.ketKSXi0lS26TB9z8H8Xb75tOwqOXBGwG', 'Michal', 'Kankovsky', '2023-11-29', 'michalkankovsky@gmail.com', 555, 0, 1, NULL, '#A81515,#3EBDDA,#39A01C'),
('xmedun00', '$2y$10$KsCYc.GCEFcXeHF5.L3px.iX2gsMjDrYEN7R5dxfdXup9atTttEAK', 'Garant', 'Meduna', '1993-01-01', 'meduna@admin.com', 150, 3, NULL, NULL, '#A81515,#3EBDDA,#39A01C'),
('xrozvr00', '$2y$10$GURtOGjrhMW.G1joIn0yjOuQC8VVDDOw9DduTUmQAzZW9/ocyduAO', 'Rozvrhujici', 'Rozvrhar', '1996-01-01', 'rozvrh@admin.com', 132, 2, NULL, NULL, '#A81515,#3EBDDA,#39A01C'),
('xstude00', '$2y$10$PALG9oQUUZdHpyNQVNJRhuycpZ7wiMYfQLt5AUlsSSld7IqR6jWLK', 'Vzorny', 'Student', '2002-01-01', 'stude@admin.com', 821, 0, 2, '0101010101010110101010101010010101010101011010101010101001010101010101', '#3772a9,#b04545,#5c636e'),
('xstude22', '$2y$10$PALG9oQUUZdHpyNQVNJRhuycpZ7wiMYfQLt5AUlsSSld7IqR6jWLK', 'Karel', 'Karel', '2023-12-11', 'karel@karel.com', 1234567890, 0, 1, '0101010101010110101010101010010101010101011010110010101010101011111111', '#A81515,#3EBDDA,#39A01C'),
('xvorob00', '$2y$10$.HpY3Wfoc59wRt5y9LIEoOYH7RPIlrvX0NW83RZWh1XZthlJJes7W', 'Vali', 'Vorobec', '2023-11-16', 'vorob@vorob.cz', 123, 0, 3, NULL, '#A81515,#3EBDDA,#39A01C'),
('xvorob01', '$2y$10$gNMsxL4CIPl9nMy5qLcMOuTs7GjDeR8Y8FWU9SYLxufC1wgNUp9qi', 'Vali', 'Vorobec', '2023-11-16', 'vorob@vorob.cz', 123, 0, 3, NULL, '#A81515,#3EBDDA,#39A01C'),
('xvyucu00', '$2y$10$sOHYNfZLNrwFoVIPhhiXZO9KsT9TMEsLY5IZAct/5Au.ut6QJgDU.', 'Pepa', 'Vyucujici', '1999-02-02', 'vyucu@mail.com', 148, 1, NULL, '0000111111111100111111111111111111111111110011111111111111111111100000', '#A81515,#3EBDDA,#39A01C');

-- --------------------------------------------------------

--
-- Table structure for table `vlastni_aktivity`
--

CREATE TABLE `vlastni_aktivity` (
  `id` int(11) NOT NULL,
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `den` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `cas` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `delka` smallint(6) NOT NULL,
  `osobni_cislo` varchar(8) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zapsan`
--

CREATE TABLE `zapsan` (
  `osobni_cislo` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `zkratka` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `typ` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `zapsan`
--

INSERT INTO `zapsan` (`osobni_cislo`, `zkratka`, `typ`) VALUES
('xadmin00', 'IAL', 0),
('xadmin00', 'ICS', 0),
('xadmin00', 'IFJ', 0),
('xadmin00', 'INP', 0),
('xadmin00', 'IPT', 0),
('xadmin00', 'ISS', 0),
('xkanko00', 'IAL', 0),
('xkanko00', 'ICS', 0),
('xkanko00', 'IFJ', 0),
('xkanko00', 'INP', 0),
('xkanko00', 'IPT', 0),
('xkanko00', 'ISS', 0),
('xkanko01', 'IBS', 0),
('xkanko01', 'INP', 0),
('xkanko01', 'IPT', 0),
('xkanko01', 'ITY', 0),
('xkanko02', 'IAL', 0),
('xkanko02', 'IBS', 0),
('xkanko02', 'ICS', 0),
('xkanko02', 'IFJ', 0),
('xkanko02', 'INP', 0),
('xkanko02', 'IPT', 0),
('xkanko02', 'ISS', 0),
('xkanko02', 'ITY', 0),
('xkanko03', 'IAL', 0),
('xkanko03', 'IBS', 0),
('xkanko03', 'ICS', 0),
('xkanko03', 'IFJ', 0),
('xkanko03', 'INP', 0),
('xkanko03', 'IPT', 0),
('xkanko03', 'ISS', 0),
('xkanko03', 'ITY', 0),
('xstude00', 'IAL', 0),
('xstude00', 'IBS', 0),
('xstude00', 'ICS', 0),
('xstude00', 'IFJ', 0),
('xstude00', 'INP', 0),
('xstude00', 'IPT', 0),
('xstude00', 'ISS', 0),
('xstude00', 'ITY', 0),
('xstude22', 'IAL', 0),
('xstude22', 'IBS', 0),
('xstude22', 'ICS', 0),
('xstude22', 'IFJ', 0),
('xstude22', 'INP', 0),
('xstude22', 'IPT', 0),
('xstude22', 'ISS', 0),
('xstude22', 'ITY', 0),
('xvyucu00', 'ICS', 1),
('xvyucu00', 'IFJ', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivity`
--
ALTER TABLE `aktivity`
  ADD PRIMARY KEY (`id_aktivity`),
  ADD KEY `probiha v` (`mistnost`),
  ADD KEY `mistnost` (`mistnost`),
  ADD KEY `predmet` (`predmet`),
  ADD KEY `vyucujici` (`vyucujici`);

--
-- Indexes for table `mistnosti`
--
ALTER TABLE `mistnosti`
  ADD PRIMARY KEY (`cislo`);

--
-- Indexes for table `Predmety`
--
ALTER TABLE `Predmety`
  ADD PRIMARY KEY (`zkratka`),
  ADD KEY `garant` (`garant`);

--
-- Indexes for table `prihlasen`
--
ALTER TABLE `prihlasen`
  ADD PRIMARY KEY (`osobni_cislo`,`id_aktivity`),
  ADD KEY `id_aktivity` (`id_aktivity`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`osobni_cislo`);

--
-- Indexes for table `vlastni_aktivity`
--
ALTER TABLE `vlastni_aktivity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `osobni_cislo` (`osobni_cislo`);

--
-- Indexes for table `zapsan`
--
ALTER TABLE `zapsan`
  ADD PRIMARY KEY (`osobni_cislo`,`zkratka`),
  ADD KEY `zkratka` (`zkratka`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vlastni_aktivity`
--
ALTER TABLE `vlastni_aktivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivity`
--
ALTER TABLE `aktivity`
  ADD CONSTRAINT `aktivity_ibfk_2` FOREIGN KEY (`mistnost`) REFERENCES `mistnosti` (`cislo`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `aktivity_ibfk_3` FOREIGN KEY (`predmet`) REFERENCES `Predmety` (`zkratka`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Predmety`
--
ALTER TABLE `Predmety`
  ADD CONSTRAINT `Predmety_ibfk_1` FOREIGN KEY (`garant`) REFERENCES `Users` (`osobni_cislo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `prihlasen`
--
ALTER TABLE `prihlasen`
  ADD CONSTRAINT `prihlasen_ibfk_1` FOREIGN KEY (`osobni_cislo`) REFERENCES `Users` (`osobni_cislo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prihlasen_ibfk_2` FOREIGN KEY (`id_aktivity`) REFERENCES `aktivity` (`id_aktivity`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zapsan`
--
ALTER TABLE `zapsan`
  ADD CONSTRAINT `zapsan_ibfk_1` FOREIGN KEY (`osobni_cislo`) REFERENCES `Users` (`osobni_cislo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zapsan_ibfk_2` FOREIGN KEY (`zkratka`) REFERENCES `Predmety` (`zkratka`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
