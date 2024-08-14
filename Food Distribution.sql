-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 12, 2024 at 11:45 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Distribucija_hrane`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `ime`, `prezime`, `email`, `password`) VALUES
(1, 'Lazar', 'Birtasevic', 'lazar.birtasevic1@gmail.com', '$2y$10$t/UO2KptRk/YqHgojFFtAu.LVn/qEAz8uuvO5y.HHFfZjrTzekMue');

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE `komentari` (
  `id` int(11) NOT NULL,
  `proizvod_id` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id`, `proizvod_id`, `komentar`, `created_at`) VALUES
(4, 6, 'Komentar za picu\r\n', '2024-08-12 01:07:05');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `email`, `password`) VALUES
(1, 'Lazar', 'Birtasevic', 'lazar.birtasevic1@gmail.com', '$2y$10$pqLqpWW235PpbUvaX/Iwt.MJUePxnFxEBWuSPIuPhVtzvfWQCnDEC'),
(2, 'Ognjen', 'Birtasevic', 'ognjen@gmail.com', '$2y$10$D2lJ1v1q7SCp/lhFFFCh5uwlnddqZOe8CJAYZkTWVynr5WNhQJmhe');

-- --------------------------------------------------------

--
-- Table structure for table `porudzbine`
--

CREATE TABLE `porudzbine` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datum` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `porudzbine`
--

INSERT INTO `porudzbine` (`id`, `user_id`, `datum`) VALUES
(1, 1, '2024-08-12 13:25:37'),
(2, 2, '2024-08-12 13:31:18');

-- --------------------------------------------------------

--
-- Table structure for table `porudzbine_stavke`
--

CREATE TABLE `porudzbine_stavke` (
  `id` int(11) NOT NULL,
  `porudzbina_id` int(11) NOT NULL,
  `proizvod_id` int(11) NOT NULL,
  `kolicina` int(11) NOT NULL,
  `cena` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `porudzbine_stavke`
--

INSERT INTO `porudzbine_stavke` (`id`, `porudzbina_id`, `proizvod_id`, `kolicina`, `cena`) VALUES
(1, 1, 6, 1, 1699),
(2, 1, 7, 1, 199),
(3, 1, 8, 1, 259),
(4, 2, 7, 1, 199),
(5, 2, 8, 2, 259);

-- --------------------------------------------------------

--
-- Table structure for table `proizvodi`
--

CREATE TABLE `proizvodi` (
  `id` int(11) NOT NULL,
  `ime` varchar(100) NOT NULL,
  `opis` text,
  `cena` decimal(10,2) NOT NULL,
  `kategorija` varchar(50) DEFAULT NULL,
  `slika` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proizvodi`
--

INSERT INTO `proizvodi` (`id`, `ime`, `opis`, `cena`, `kategorija`, `slika`) VALUES
(6, 'Pica', 'Pica sa kačkavaljem i pečurkama.', '1699.00', 'Pekarski proizvodi', 'slike/pizza.jpg'),
(7, 'Narandza', 'Prirodna sveža i sočna narandza. ', '199.00', 'Voće', 'slike/narandza.jpg'),
(8, 'Paradajz', 'Paradajz iz baste organski.', '259.00', 'Povrće', 'slike/paradajz.jpeg'),
(9, 'Biftek', 'Teleći biftek najvećeg kvaliteta.', '2899.00', 'Meso', 'slike/biftek.jpg'),
(10, 'Milksejk', 'Osvežavajuci milksejk sa ukusima čokolade i jagode.', '1299.00', 'Mlečni proizvodi', 'slike/milksejk.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `komentari`
--
ALTER TABLE `komentari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proizvod_id` (`proizvod_id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `porudzbine`
--
ALTER TABLE `porudzbine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `porudzbine_stavke`
--
ALTER TABLE `porudzbine_stavke`
  ADD PRIMARY KEY (`id`),
  ADD KEY `porudzbina_id` (`porudzbina_id`),
  ADD KEY `proizvod_id` (`proizvod_id`);

--
-- Indexes for table `proizvodi`
--
ALTER TABLE `proizvodi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `komentari`
--
ALTER TABLE `komentari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `porudzbine`
--
ALTER TABLE `porudzbine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `porudzbine_stavke`
--
ALTER TABLE `porudzbine_stavke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `proizvodi`
--
ALTER TABLE `proizvodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentari_ibfk_1` FOREIGN KEY (`proizvod_id`) REFERENCES `proizvodi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `porudzbine`
--
ALTER TABLE `porudzbine`
  ADD CONSTRAINT `porudzbine_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `korisnici` (`id`);

--
-- Constraints for table `porudzbine_stavke`
--
ALTER TABLE `porudzbine_stavke`
  ADD CONSTRAINT `porudzbine_stavke_ibfk_1` FOREIGN KEY (`porudzbina_id`) REFERENCES `porudzbine` (`id`),
  ADD CONSTRAINT `porudzbine_stavke_ibfk_2` FOREIGN KEY (`proizvod_id`) REFERENCES `proizvodi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
