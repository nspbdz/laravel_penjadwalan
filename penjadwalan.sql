-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 05, 2023 at 10:10 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjadwalan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama`, `foto`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin JTI', 'admin1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

DROP TABLE IF EXISTS `dosen`;
CREATE TABLE IF NOT EXISTS `dosen` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `nidn` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`kode`, `nidn`, `nama`, `alamat`, `telp`) VALUES
(1, '0410108601 / 09098630', 'A. Sumarudin, S.Pd., MT., M.Sc.', 'asumarudin@gmail.com', '085222629105'),
(2, '0409078101 / 198107092021211005', 'Eka Ismantohadi, S.Kom., M.Eng.', 'ekaismanto@gmail.com', '085323043616'),
(3, '0420078502 / 198507202019032015', 'Munengsih Sari Bunga, S.Kom., M.Eng.', 'nengslim85@gmail.com', '087727602434'),
(4, '0407038004 / 198003072021211006', 'Mohammad Yani, ST., MT., M.Sc', 'myani0703@gmail.com', '081586691068'),
(5, '0404108601 / 198610042019031004', 'Willy Permana Putra, ST., M.Eng.', 'putranunuk@gmail.com', '085878356247'),
(6, '0410058601 / 198605102019031011', 'Ahmad Lubis Ghozali, S.Kom., M.Kom.', 'alghoz@gmail.com', '082126542727'),
(7, '0406098102 / 198109062021212004', 'Darsih, S.kom., M.kom.', 'darsih82@gmail.com', '083838451031'),
(8, '0419056503 / 196505192021211002', 'Ir. Muh. Lukman Sifa', 'lukmanpolindra@yahoo.co.id', '082320833013'),
(9, '00010890 / 199008012019031014', 'Iryanto,S.Si., M.Si., M.Sc', 'iryanto.math@gmail.com', '085795163129'),
(10, '0005059202 / 199205052019031011', 'Muhamad Mustamiin, S.Pd., M.Kom,', 'm.mustamiin@gmail.com', '087828723432'),
(11, '- / 17039101', 'Arya Sony, ST., M.Eng.', 'aryasny@gmail.com', '08112721709'),
(12, '- / 17038902', 'Azran Budi Arief, ST., MT', 'azran.azr07@gmail.com', '081217882373'),
(13, '0022039001 / 199003222019031007', 'Adi Suheryadi, S.ST., M.Kom.', 'adi.suheryadi@gmail.com', '085224100065'),
(14, '0023049201 / 199204232018031001', 'Fachrul Pralienka Bani Muhammad, M.kom.', 'fachrul.pbm@gmail.com', '082219226664'),
(16, '-', 'Drs. M.A Rosyid, MM', '-', '-'),
(17, '-', 'Deddy S.', '-', '-'),
(18, '-', 'Ojo Suharja', '-', '-'),
(19, '-', 'Abdul Gofur', '-', '-'),
(20, '0028059301 / 199305282019032024', 'Alifia Puspaningrum, S.Pd., M.Kom', '-', '-'),
(21, '0002038504 / 198503022018031001', 'Kurnia Adi Cahyanto, ST., M.Kom', '-', '-'),
(22, '0616039001 / 199003162018032001 ', 'Esti Mulyani, S.Kom., M.Kom', '-', '0'),
(23, '0428029002 / 199002282019031012', 'Muhammad Anis Al Hilmi, S.Si., M.T.', '-', '-'),
(24, '0018018910 / 198901182022031002', 'Moh. Ali Fikri, S.Kom., M.Kom', '-', '-'),
(25, '1016118705 / 198711162022031001', 'Nur Budi Nugraha, S.Kom., MT', '-', '-'),
(26, '0017059015 / 199005172022031003', 'Robieth Sohiburoyyan, S.Si., M.Si', '-', '-'),
(27, '0013129205 / 199212132022031007', 'Rendi, S,.Kom., M.Kom', '-', '-'),
(28, '0002119206 / 199211022022032014', 'Yaqutina Marjani Santosa, S.Pd., M.Cs', '-', '-'),
(29, '0422078701 / 198707222022031001', 'Robi Robiyanto, S.Kom., M.TI', '-', '-'),
(30, '0002079403 / 199407022022031005', 'Salamet Nur Himawan, S.Si., M.Si', '-', '-'),
(31, '0002079403 / 199407022022031005', 'Salamet Nur Himawan, S.Si., M.Si', '-', '-'),
(32, '0622059103 / 199105222022031003', 'Fauzan Ishlakhuddin, S.Kom., M.Cs', '-', '-'),
(33, '0628029301 / 199302282022031007', 'Dian Pramadhana, S.Kom., M.Kom', '-', '-'),
(34, '0411058904 / 198905112022031005', 'Riyan Farismana, S.Kom., M.Kom', '-', '-'),
(35, '0402038802 / 198803022022032005', 'Dita Rizki Amalia, S.Pd., M.Kom', '-', '-'),
(36, '0418038701 / 198703182019032014', 'Sonty Lena, S.Kom., M.M., M.Kom', '-', '-'),
(37, '0409078403 / -', 'Renol Burjulius, S.T., M.Kom', '-', '-'),
(38, '-', 'Pratiwi Budiyani, SH.,MH', '-', '08'),
(39, '-', 'Ahmad Mastun P, S.Pd I., M.Pd I', '-', '0'),
(40, '-', 'Noviasari Dwi Gartika Putri, M.Pd', '-', '0'),
(41, '-', 'Ahmad Rifa\'i, M.Kom', '-', '0'),
(42, '0025096406 / -', 'Dr. Raswa, M.Pd', '-', '0');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hari`
--

DROP TABLE IF EXISTS `hari`;
CREATE TABLE IF NOT EXISTS `hari` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hari`
--

INSERT INTO `hari` (`kode`, `nama`) VALUES
(1, 'Senin'),
(2, 'Selasa'),
(3, 'Rabu'),
(4, 'Kamis'),
(5, 'Jumat');

-- --------------------------------------------------------

--
-- Table structure for table `jadwalkuliah`
--

DROP TABLE IF EXISTS `jadwalkuliah`;
CREATE TABLE IF NOT EXISTS `jadwalkuliah` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `kode_pengampu` int DEFAULT NULL,
  `kode_jam` int DEFAULT NULL,
  `kode_hari` int DEFAULT NULL,
  `kode_ruang` int DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1 COMMENT='hasil proses';

--
-- Dumping data for table `jadwalkuliah`
--

INSERT INTO `jadwalkuliah` (`kode`, `kode_pengampu`, `kode_jam`, `kode_hari`, `kode_ruang`) VALUES
(1, 575, 5, 3, 22),
(2, 592, 9, 5, 5),
(3, 620, 7, 2, 11),
(4, 619, 5, 2, 14),
(5, 538, 3, 5, 1),
(6, 603, 5, 4, 4),
(7, 585, 5, 1, 6),
(8, 555, 6, 2, 9),
(9, 639, 2, 2, 1),
(10, 608, 1, 3, 11),
(11, 526, 4, 4, 13),
(12, 613, 10, 1, 17),
(13, 593, 10, 5, 15),
(14, 537, 1, 1, 12),
(15, 597, 2, 2, 5),
(16, 534, 5, 3, 13),
(17, 517, 9, 3, 20),
(18, 511, 3, 4, 13),
(19, 546, 8, 1, 6),
(20, 543, 2, 1, 2),
(21, 590, 3, 3, 20),
(22, 516, 8, 2, 24),
(23, 535, 3, 2, 8),
(24, 545, 8, 3, 14),
(25, 528, 9, 4, 18),
(26, 560, 6, 2, 18),
(27, 610, 4, 3, 26),
(28, 565, 3, 5, 8),
(29, 518, 6, 4, 24),
(30, 611, 2, 5, 15),
(31, 602, 5, 3, 9),
(32, 566, 2, 1, 13),
(33, 540, 6, 1, 14),
(34, 600, 5, 1, 18),
(35, 547, 6, 4, 18),
(36, 523, 8, 3, 13),
(37, 609, 6, 3, 8),
(38, 529, 8, 4, 19),
(39, 591, 7, 4, 16),
(40, 583, 2, 5, 3),
(41, 623, 2, 4, 8),
(42, 572, 8, 5, 16),
(43, 569, 8, 2, 9),
(44, 559, 9, 1, 11),
(45, 636, 4, 3, 13),
(46, 570, 5, 2, 25),
(47, 627, 9, 3, 4),
(48, 601, 4, 5, 2),
(49, 549, 5, 3, 13),
(50, 629, 10, 4, 6),
(51, 568, 7, 4, 12),
(52, 557, 10, 3, 12),
(53, 605, 8, 2, 24),
(54, 532, 7, 1, 13),
(55, 579, 9, 2, 1),
(56, 522, 9, 3, 25),
(57, 533, 2, 5, 21),
(58, 634, 8, 2, 8),
(59, 552, 10, 2, 23),
(60, 589, 8, 4, 24),
(61, 604, 8, 4, 3),
(62, 587, 6, 4, 21),
(63, 637, 1, 2, 1),
(64, 595, 3, 4, 14),
(65, 638, 7, 1, 16),
(66, 536, 8, 2, 21),
(67, 525, 2, 4, 26),
(68, 631, 9, 4, 15),
(69, 577, 4, 3, 16),
(70, 558, 7, 1, 9),
(71, 612, 2, 2, 6),
(72, 594, 7, 3, 28),
(73, 550, 4, 5, 3),
(74, 633, 9, 3, 12),
(75, 622, 1, 1, 5),
(76, 564, 4, 3, 12),
(77, 578, 5, 3, 7),
(78, 642, 2, 5, 22),
(79, 531, 7, 4, 23),
(80, 563, 7, 2, 16),
(81, 542, 2, 3, 13),
(82, 512, 6, 4, 16),
(83, 567, 4, 4, 9),
(84, 551, 7, 5, 21),
(85, 580, 1, 5, 15),
(86, 553, 4, 4, 15),
(87, 541, 5, 1, 3),
(88, 519, 7, 2, 14),
(89, 576, 1, 1, 15),
(90, 607, 6, 3, 18),
(91, 628, 4, 2, 26),
(92, 618, 8, 3, 4),
(93, 624, 3, 2, 18),
(94, 513, 2, 1, 15),
(95, 626, 7, 3, 1),
(96, 521, 7, 5, 14),
(97, 520, 8, 4, 21),
(98, 574, 6, 1, 5),
(99, 581, 9, 2, 7),
(100, 635, 9, 4, 8),
(101, 625, 6, 4, 13),
(102, 584, 1, 5, 13),
(103, 640, 9, 5, 4),
(104, 641, 3, 2, 27),
(105, 554, 1, 4, 11),
(106, 588, 2, 1, 6),
(107, 606, 2, 5, 28),
(108, 614, 7, 3, 17),
(109, 514, 3, 4, 17),
(110, 548, 5, 3, 2),
(111, 632, 10, 4, 16),
(112, 562, 10, 2, 3),
(113, 524, 9, 1, 15),
(114, 598, 2, 4, 12),
(115, 615, 4, 3, 3),
(116, 539, 9, 4, 2),
(117, 617, 8, 5, 9),
(118, 561, 4, 2, 3),
(119, 571, 10, 4, 25),
(120, 527, 4, 3, 13),
(121, 530, 5, 1, 16),
(122, 616, 9, 1, 16),
(123, 582, 4, 2, 16),
(124, 621, 6, 1, 4),
(125, 556, 6, 3, 28),
(126, 515, 7, 3, 17),
(127, 544, 4, 2, 4),
(128, 586, 6, 2, 17),
(129, 596, 4, 4, 2),
(130, 573, 5, 4, 11),
(131, 630, 6, 4, 11),
(132, 599, 4, 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `jadwalkuliah_old`
--

DROP TABLE IF EXISTS `jadwalkuliah_old`;
CREATE TABLE IF NOT EXISTS `jadwalkuliah_old` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `kode_pengampu` int DEFAULT NULL,
  `kode_jam` int DEFAULT NULL,
  `kode_hari` int DEFAULT NULL,
  `kode_ruang` int DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1 COMMENT='hasil proses';

--
-- Dumping data for table `jadwalkuliah_old`
--

INSERT INTO `jadwalkuliah_old` (`kode`, `kode_pengampu`, `kode_jam`, `kode_hari`, `kode_ruang`) VALUES
(1, 511, 4, 4, 15),
(2, 512, 7, 1, 14),
(3, 513, 8, 1, 16),
(4, 518, 7, 2, 24),
(5, 519, 7, 5, 14),
(6, 524, 7, 4, 12),
(7, 525, 2, 3, 23),
(8, 530, 8, 4, 15),
(9, 531, 4, 1, 27),
(10, 532, 7, 3, 15),
(11, 533, 3, 4, 28),
(12, 538, 1, 2, 4),
(13, 539, 7, 2, 7),
(14, 540, 8, 2, 13),
(15, 541, 5, 4, 5),
(16, 542, 8, 5, 18),
(17, 543, 1, 2, 11),
(18, 544, 3, 3, 5),
(19, 545, 9, 5, 18),
(20, 546, 1, 2, 3),
(21, 547, 8, 5, 13),
(22, 548, 9, 2, 7),
(23, 549, 5, 4, 18),
(24, 550, 9, 3, 8),
(25, 551, 7, 5, 27),
(26, 552, 9, 1, 19),
(27, 557, 7, 4, 17),
(28, 558, 5, 2, 11),
(29, 559, 3, 3, 11),
(30, 560, 4, 1, 18),
(31, 561, 9, 1, 3),
(32, 562, 9, 1, 11),
(33, 563, 2, 3, 13),
(34, 564, 4, 2, 14),
(35, 565, 8, 1, 5),
(36, 566, 1, 2, 14),
(37, 567, 5, 4, 4),
(38, 568, 10, 3, 17),
(39, 569, 7, 1, 3),
(40, 570, 8, 4, 19),
(41, 571, 3, 2, 19),
(42, 572, 7, 1, 18),
(43, 577, 10, 4, 15),
(44, 578, 9, 5, 5),
(45, 579, 5, 1, 2),
(46, 580, 1, 3, 18),
(47, 581, 8, 2, 3),
(48, 582, 3, 3, 12),
(49, 583, 7, 4, 8),
(50, 584, 8, 4, 16),
(51, 585, 1, 5, 9),
(52, 586, 10, 2, 13),
(53, 587, 5, 2, 25),
(54, 588, 7, 5, 7),
(55, 589, 3, 1, 19),
(56, 590, 1, 4, 26),
(57, 591, 1, 4, 16),
(58, 592, 8, 3, 5),
(59, 597, 5, 3, 2),
(60, 598, 1, 4, 14),
(61, 599, 2, 4, 7),
(62, 600, 7, 2, 16),
(63, 601, 5, 1, 10),
(64, 602, 3, 3, 4),
(65, 603, 1, 5, 5),
(66, 604, 9, 2, 11),
(67, 605, 1, 1, 24),
(68, 606, 9, 1, 26),
(69, 607, 5, 2, 13),
(70, 612, 1, 5, 3),
(71, 613, 9, 5, 14),
(72, 614, 2, 1, 18),
(73, 615, 1, 4, 5),
(74, 616, 10, 3, 18),
(75, 617, 8, 4, 1),
(76, 618, 1, 3, 3),
(77, 619, 9, 5, 17),
(78, 620, 4, 1, 1),
(79, 621, 1, 5, 2),
(80, 622, 8, 1, 10),
(81, 623, 2, 3, 24),
(82, 624, 8, 2, 22),
(83, 625, 8, 3, 12),
(84, 630, 2, 3, 1),
(85, 631, 9, 3, 15),
(86, 632, 1, 1, 14),
(87, 633, 2, 1, 15),
(88, 634, 8, 4, 7),
(89, 635, 9, 4, 10),
(90, 636, 8, 4, 14),
(91, 637, 7, 1, 1),
(92, 638, 4, 4, 18),
(93, 639, 7, 1, 7),
(94, 640, 8, 3, 1),
(95, 641, 2, 1, 27),
(96, 642, 9, 2, 26);

-- --------------------------------------------------------

--
-- Table structure for table `jam`
--

DROP TABLE IF EXISTS `jam`;
CREATE TABLE IF NOT EXISTS `jam` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `range_jam` varchar(50) DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jam`
--

INSERT INTO `jam` (`kode`, `range_jam`, `aktif`) VALUES
(1, '07:30-08:20', NULL),
(2, '08:20-09:10', NULL),
(3, '09:10-10:00', NULL),
(4, '10:00-10:50', NULL),
(5, '10:50-11:40', NULL),
(6, '11:40-12:40', NULL),
(7, '12:40-13:30', NULL),
(8, '13:30-14:20', NULL),
(9, '14:20-15:10', NULL),
(10, '15:10-16:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
CREATE TABLE IF NOT EXISTS `kelas` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelas` enum('rpl','ti') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`kode`, `nama`, `jenis_kelas`) VALUES
(1, 'D3TI1A', 'ti'),
(2, 'D3TI1B', 'ti'),
(3, 'D3TI1C', 'ti'),
(4, 'D3TI2A', 'ti'),
(5, 'D3TI2B', 'ti'),
(6, 'D3TI2C', 'ti'),
(7, 'D3TI3A', 'ti'),
(8, 'D3TI3B', 'ti'),
(9, 'D3TI3C', 'ti'),
(10, 'D4RPL1A', 'rpl'),
(11, 'D4RPL1B', 'rpl'),
(12, 'D4RPL1C', 'rpl'),
(13, 'D4RPL2A', 'rpl'),
(14, 'D4RPL2B', 'rpl'),
(15, 'D4RPL3', 'rpl'),
(16, 'D4RPL4', 'rpl');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_old`
--

DROP TABLE IF EXISTS `kelas_old`;
CREATE TABLE IF NOT EXISTS `kelas_old` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas_old`
--

INSERT INTO `kelas_old` (`kode`, `nama`) VALUES
(1, 'D3TI1A'),
(2, 'D3TI1B'),
(3, 'D3TI1C');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

DROP TABLE IF EXISTS `matakuliah`;
CREATE TABLE IF NOT EXISTS `matakuliah` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `kode_mk` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `sks` int DEFAULT NULL,
  `semester` int DEFAULT NULL,
  `prodi` enum('rpl','ti') NOT NULL,
  `tahun` varchar(20) NOT NULL,
  `aktif` enum('True','False') DEFAULT 'True',
  `jenis` enum('TEORI','PRAKTIKUM','PROYEK','BAHASA') DEFAULT 'TEORI',
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1 COMMENT='example kode_mk = 0765109 ';

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`kode`, `kode_mk`, `nama`, `sks`, `semester`, `prodi`, `tahun`, `aktif`, `jenis`) VALUES
(1, 'KUPB3032', 'pancasila (T)', 4, 7, 'rpl', '2022-2023', 'True', 'TEORI'),
(2, 'KUPB3042', 'Kewarganegaraan (T)', 4, 7, 'rpl', '2022-2023', 'True', 'TEORI'),
(3, 'KUPB3052', 'Bahasa Indonesia (T)', 4, 7, 'rpl', '2022-2023', 'True', 'TEORI'),
(4, 'KUPB3022', 'Sistem Multimedia (T)', 2, 7, 'rpl', '2022-2023', 'True', 'TEORI'),
(5, 'KUPB3022', 'Sistem Multimedia (P)', 2, 7, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(6, 'KUPB3012', 'Sistem Multimedia (T)', 2, 7, 'rpl', '2022-2023', 'True', 'TEORI'),
(7, 'KUPB3012', 'Sistem Multimedia (P)', 2, 7, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(8, 'SE1101', 'Pengolahan Citra Digital (T)', 1, 6, 'rpl', '2022-2023', 'True', 'TEORI'),
(9, 'SE1101', 'Pengolahan Citra (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(10, 'SE1102', 'Proyek III (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PROYEK'),
(11, 'SE1103', 'Sistem Informasi (T)', 2, 6, 'rpl', '2022-2023', 'True', 'TEORI'),
(12, 'SE1101', 'Pengolahan Citra (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(13, 'SE1104', 'Metodologi Penelitian (T)', 3, 6, 'rpl', '2022-2023', 'True', 'TEORI'),
(14, 'SE1103', 'Sistem Informasi (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(15, 'SE1105', 'Sistem Terdistribusi (T)', 1, 6, 'rpl', '2022-2023', 'True', 'TEORI'),
(16, 'SE1105', 'Sistem Terdistribusi (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(17, 'SE1106', 'ArtificialIntelligence (T)', 2, 6, 'rpl', '2022-2023', 'True', 'TEORI'),
(18, 'SE1106', 'ArtificialIntelligence (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(19, 'SE1107', 'Bahasa Inggris Profesional (T)', 1, 6, 'rpl', '2022-2023', 'True', 'TEORI'),
(20, 'SE1107', 'Bahasa Inggris Profesional (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(21, 'SE1105', 'Sistem Terdistribusi (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(22, 'SE1102', 'Proyek III (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PROYEK'),
(23, 'SE1102', 'Proyek III (P)', 2, 6, 'rpl', '2022-2023', 'True', 'PROYEK'),
(24, 'SE1111', 'Pemrograman Perangkat Lunak OO (T)', 2, 4, 'rpl', '2022-2023', 'True', 'TEORI'),
(25, 'SE1112', 'Pengujian & Penjaminan Kualitas PL (T)', 2, 4, 'rpl', '2022-2023', 'True', 'TEORI'),
(26, 'SE1114', 'Proyek I (P)', 2, 4, 'rpl', '2022-2023', 'True', 'PROYEK'),
(27, 'SE1115', 'Pemrograman Web 2 (T)', 2, 4, 'rpl', '2022-2023', 'True', 'TEORI'),
(28, 'SE1116', 'Metode Numerik (P)', 2, 4, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(29, 'SE1112', 'Pengujian & Penjaminan Kualitas PL (P)', 4, 4, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(30, 'SE1115', 'Pemrograman Web 2 (P)', 2, 4, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(31, 'SE1117', 'Jaringan Komputer (T)', 2, 4, 'rpl', '2022-2023', 'True', 'TEORI'),
(32, 'SE1116', 'Metode Numerik (T)', 2, 4, 'rpl', '2022-2023', 'True', 'TEORI'),
(33, 'SE1118', 'Jaringan Komputer (P)', 2, 4, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(34, 'SE1111', 'Pemrograman Perangkat Lunak OO (P)', 4, 4, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(35, 'SE1114', 'Proyek I (P)', 2, 4, 'rpl', '2022-2023', 'True', 'PROYEK'),
(36, 'SE1114', 'Proyek I (P)', 2, 4, 'rpl', '2022-2023', 'True', 'PROYEK'),
(37, 'SE1121', 'Sistem Basis Data 1 (T)', 1, 2, 'rpl', '2022-2023', 'True', 'TEORI'),
(38, 'SE1121', 'Sistem Basis Data 1 (P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(39, 'SE1121', 'Sistem Basis Data 1 (P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(40, 'SE1122', 'Struktur Data (T)', 1, 2, 'rpl', '2022-2023', 'True', 'TEORI'),
(41, 'SE1122', 'Struktur Data (P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(42, 'SE1123', 'Pemrograman Web 1 (T)', 1, 2, 'rpl', '2022-2023', 'True', 'TEORI'),
(43, 'SE1123', 'Pemrograman Web 1 (P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(45, 'SE1122', 'Struktur Data (P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(46, 'SE1124', 'Desain Perangkat Lunak 1(P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(47, 'SE1124', 'Desain Perangkat Lunak 1(P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(48, 'SE1124', 'Desain Perangkat Lunak 1(T)', 1, 2, 'rpl', '2022-2023', 'True', 'TEORI'),
(49, 'SE1125', 'Aljabar Linear (T)', 2, 2, 'rpl', '2022-2023', 'True', 'TEORI'),
(50, 'SE1126', 'Jaringan Komputer (P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(51, 'SE1126', 'Jaringan Komputer (P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(52, 'SE1126', 'Jaringan Komputer (T)', 1, 2, 'rpl', '2022-2023', 'True', 'TEORI'),
(53, 'SE1127', 'Rekayasa Kebutuhan PL (T)', 1, 2, 'rpl', '2022-2023', 'True', 'TEORI'),
(54, 'SE1127', 'Rekayasa Kebutuhan PL (P)', 2, 2, 'rpl', '2022-2023', 'True', 'PRAKTIKUM'),
(55, 'KUPK3001', 'Kewarganegaraan (T)', 2, 6, 'ti', '2022-2023', 'True', 'TEORI'),
(56, 'KUPK3002', 'Agama (T)', 2, 6, 'ti', '2022-2023', 'True', 'TEORI'),
(57, 'KUPK3003', 'Etika Profesi (T)', 2, 6, 'ti', '2022-2023', 'True', 'TEORI'),
(58, 'KUPK3004', 'Tugas Akhir', 4, 6, 'ti', '2022-2023', 'True', 'PROYEK'),
(59, 'KUPK3005', 'Kewirausahaan (T)', 2, 6, 'ti', '2022-2023', 'True', 'TEORI'),
(60, 'KUPK3006', 'Pancasila (T)', 2, 6, 'ti', '2022-2023', 'True', 'TEORI'),
(61, 'TIKB2001', 'Rekayasa Perangkat Lunak (T)', 1, 4, 'ti', '2022-2023', 'True', 'TEORI'),
(62, 'TIKB2001', 'Rekayasa Perangkat Lunak (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(63, 'TIKB2001', 'Rekayasa Perangkat Lunak (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(64, 'TIKB2002', 'Proyek III (P)', 2, 4, 'ti', '2022-2023', 'True', 'PROYEK'),
(65, 'TIKB2003', 'Pemrog. Perangkat Bergerak (T)', 1, 4, 'ti', '2022-2023', 'True', 'TEORI'),
(66, 'TIKB2003', 'Pemrog. Perangkat Bergerak (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(67, 'TIKB2003', 'Pemrog. Perangkat Bergerak (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(68, 'TIKB2004', 'Basis Data Lanjut  (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(69, 'TIKB2004', 'Basis Data Lanjut  (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(70, 'KUPK3007', 'Bahasa Indonesia (T)', 2, 4, 'ti', '2022-2023', 'True', 'TEORI'),
(71, 'TIKB2004', 'Basis Data Lanjut (T)', 1, 4, 'ti', '2022-2023', 'True', 'TEORI'),
(72, 'TIKB2005', 'Pengolahan Citra Digital (T)', 1, 4, 'ti', '2022-2023', 'True', 'TEORI'),
(73, 'TIKB2005', 'Pengolahan Citra Digital (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(74, 'TIKB2006', 'Kecerdasan Buatan (T)', 1, 4, 'ti', '2022-2023', 'True', 'TEORI'),
(75, 'TIKB2006', 'Kecerdasan Buatan (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(76, 'TIKB2007', 'Keamanan Komputer (T)', 1, 4, 'ti', '2022-2023', 'True', 'TEORI'),
(77, 'TIKB2007', 'Keamanan Komputer (P)', 2, 4, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(78, 'TIKB2011', 'Jaringan Komputer Lanjut (T)', 1, 2, 'ti', '2022-2023', 'True', 'TEORI'),
(79, 'TIKB2011', 'Jaringan Komputer Lanjut (P)', 2, 2, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(80, 'TIKB2012', 'Interaksi Manusia & Komputer (T)', 2, 2, 'ti', '2022-2023', 'True', 'TEORI'),
(81, 'TIKB2012', 'Interaksi Manusia & Komputer (P)', 2, 2, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(82, 'TIKB2013', 'Proyek I (P)', 2, 2, 'ti', '2022-2023', 'True', 'PROYEK'),
(83, 'TIKB2014', 'Struktur Data (T)', 1, 2, 'ti', '2022-2023', 'True', 'TEORI'),
(84, 'TIKB2014', 'Struktur Data (P)', 2, 2, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(85, 'TIKB2017', 'Basis Data (T)', 1, 2, 'ti', '2022-2023', 'True', 'TEORI'),
(86, 'TIKK2020', 'Matematika Diskrit (T)', 2, 2, 'ti', '2022-2023', 'True', 'TEORI'),
(87, 'TIKB2017', 'Basis Data  (P)', 2, 2, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(88, 'TIKB2016', 'Pemrograman Web (P)', 2, 2, 'ti', '2022-2023', 'True', 'PRAKTIKUM'),
(89, 'TIKB2016', 'Pemrograman Web (T)', 1, 2, 'ti', '2022-2023', 'True', 'TEORI'),
(90, 'KUPB3082', 'Bahasa inggris fundamental (T)', 2, 2, 'ti', '2022-2023', 'True', 'BAHASA');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengampu`
--

DROP TABLE IF EXISTS `pengampu`;
CREATE TABLE IF NOT EXISTS `pengampu` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `kode_mk` int DEFAULT NULL,
  `kode_dosen` int DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `tahun_akademik` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=658 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengampu`
--

INSERT INTO `pengampu` (`kode`, `kode_mk`, `kode_dosen`, `kelas`, `tahun_akademik`) VALUES
(511, 55, 30, 'D3TI3A', '2022-2023'),
(512, 57, 42, 'D3TI3A', '2022-2023'),
(513, 56, 39, 'D3TI3A', '2022-2023'),
(514, 59, 21, 'D3TI3A', '2022-2023'),
(515, 60, 38, 'D3TI3A', '2022-2023'),
(516, 58, 24, 'D3TI3A', '2022-2023'),
(517, 58, 25, 'D3TI3A', '2022-2023'),
(518, 58, 24, 'D3TI3A', '2022-2023'),
(519, 57, 42, 'D3TI3B', '2022-2023'),
(520, 58, 24, 'D3TI3B', '2022-2023'),
(521, 55, 23, 'D3TI3B', '2022-2023'),
(522, 58, 25, 'D3TI3B', '2022-2023'),
(523, 60, 30, 'D3TI3B', '2022-2023'),
(524, 55, 38, 'D3TI3B', '2022-2023'),
(525, 58, 24, 'D3TI3B', '2022-2023'),
(526, 56, 39, 'D3TI3C', '2022-2023'),
(527, 57, 26, 'D3TI3C', '2022-2023'),
(528, 59, 34, 'D3TI3C', '2022-2023'),
(529, 58, 24, 'D3TI3C', '2022-2023'),
(530, 60, 30, 'D3TI3C', '2022-2023'),
(531, 58, 25, 'D3TI3C', '2022-2023'),
(532, 55, 38, 'D3TI3C', '2022-2023'),
(533, 58, 24, 'D3TI3C', '2022-2023'),
(534, 61, 22, 'D3TI2A', '2022-2023'),
(535, 62, 22, 'D3TI2A', '2022-2023'),
(536, 64, 2, 'D3TI2A', '2022-2023'),
(537, 65, 14, 'D3TI2A', '2022-2023'),
(538, 66, 14, 'D3TI2A', '2022-2023'),
(539, 68, 10, 'D3TI2A', '2022-2023'),
(540, 76, 23, 'D3TI2A', '2022-2023'),
(541, 77, 23, 'D3TI2A', '2022-2023'),
(542, 74, 32, 'D3TI2A', '2022-2023'),
(543, 75, 32, 'D3TI2A', '2022-2023'),
(544, 66, 14, 'D3TI2A', '2022-2023'),
(545, 71, 10, 'D3TI2A', '2022-2023'),
(546, 69, 10, 'D3TI2A', '2022-2023'),
(547, 70, 4, 'D3TI2A', '2022-2023'),
(548, 62, 22, 'D3TI2A', '2022-2023'),
(549, 72, 42, 'D3TI2A', '2022-2023'),
(550, 73, 42, 'D3TI2A', '2022-2023'),
(551, 64, 10, 'D3TI2A', '2022-2023'),
(552, 64, 32, 'D3TI2A', '2022-2023'),
(553, 65, 14, 'D3TI2B', '2022-2023'),
(554, 66, 14, 'D3TI2B', '2022-2023'),
(555, 62, 22, 'D3TI2B', '2022-2023'),
(556, 64, 27, 'D3TI2B', '2022-2023'),
(557, 76, 23, 'D3TI2B', '2022-2023'),
(558, 77, 23, 'D3TI2B', '2022-2023'),
(559, 69, 2, 'D3TI2B', '2022-2023'),
(560, 72, 21, 'D3TI2B', '2022-2023'),
(561, 73, 21, 'D3TI2B', '2022-2023'),
(562, 66, 14, 'D3TI2B', '2022-2023'),
(563, 70, 35, 'D3TI2B', '2022-2023'),
(564, 71, 2, 'D3TI2B', '2022-2023'),
(565, 69, 2, 'D3TI2B', '2022-2023'),
(566, 61, 22, 'D3TI2B', '2022-2023'),
(567, 63, 22, 'D3TI2B', '2022-2023'),
(568, 74, 32, 'D3TI2B', '2022-2023'),
(569, 75, 32, 'D3TI2B', '2022-2023'),
(570, 64, 20, 'D3TI2B', '2022-2023'),
(571, 64, 13, 'D3TI2B', '2022-2023'),
(572, 76, 23, 'D3TI2C', '2022-2023'),
(573, 77, 23, 'D3TI2C', '2022-2023'),
(574, 62, 2, 'D3TI2C', '2022-2023'),
(575, 64, 4, 'D3TI2C', '2022-2023'),
(576, 74, 21, 'D3TI2C', '2022-2023'),
(577, 61, 2, 'D3TI2C', '2022-2023'),
(578, 62, 2, 'D3TI2C', '2022-2023'),
(579, 69, 10, 'D3TI2C', '2022-2023'),
(580, 71, 10, 'D3TI2C', '2022-2023'),
(581, 66, 25, 'D3TI2C', '2022-2023'),
(582, 72, 42, 'D3TI2C', '2022-2023'),
(583, 73, 42, 'D3TI2C', '2022-2023'),
(584, 70, 33, 'D3TI2C', '2022-2023'),
(585, 69, 10, 'D3TI2C', '2022-2023'),
(586, 65, 25, 'D3TI2C', '2022-2023'),
(587, 64, 22, 'D3TI2C', '2022-2023'),
(588, 66, 25, 'D3TI2C', '2022-2023'),
(589, 64, 22, 'D3TI2C', '2022-2023'),
(590, 64, 14, 'D3TI2C', '2022-2023'),
(591, 78, 5, 'D3TI1A', '2022-2023'),
(592, 79, 5, 'D3TI1A', '2022-2023'),
(593, 80, 7, 'D3TI1A', '2022-2023'),
(594, 82, 20, 'D3TI1A', '2022-2023'),
(595, 83, 30, 'D3TI1A', '2022-2023'),
(596, 84, 30, 'D3TI1A', '2022-2023'),
(597, 81, 7, 'D3TI1A', '2022-2023'),
(598, 85, 10, 'D3TI1A', '2022-2023'),
(599, 87, 10, 'D3TI1A', '2022-2023'),
(600, 86, 9, 'D3TI1A', '2022-2023'),
(601, 88, 24, 'D3TI1A', '2022-2023'),
(602, 79, 5, 'D3TI1A', '2022-2023'),
(603, 84, 30, 'D3TI1A', '2022-2023'),
(604, 87, 10, 'D3TI1A', '2022-2023'),
(605, 82, 26, 'D3TI1A', '2022-2023'),
(606, 82, 4, 'D3TI1A', '2022-2023'),
(607, 83, 25, 'D3TI1B', '2022-2023'),
(608, 84, 25, 'D3TI1B', '2022-2023'),
(609, 79, 5, 'D3TI1B', '2022-2023'),
(610, 82, 9, 'D3TI1B', '2022-2023'),
(611, 78, 5, 'D3TI1B', '2022-2023'),
(612, 79, 5, 'D3TI1B', '2022-2023'),
(613, 86, 9, 'D3TI1B', '2022-2023'),
(614, 89, 22, 'D3TI1B', '2022-2023'),
(615, 88, 22, 'D3TI1B', '2022-2023'),
(616, 85, 24, 'D3TI1B', '2022-2023'),
(617, 87, 24, 'D3TI1B', '2022-2023'),
(618, 88, 22, 'D3TI1B', '2022-2023'),
(619, 80, 35, 'D3TI1B', '2022-2023'),
(620, 81, 35, 'D3TI1B', '2022-2023'),
(621, 84, 25, 'D3TI1B', '2022-2023'),
(622, 87, 24, 'D3TI1B', '2022-2023'),
(623, 82, 13, 'D3TI1B', '2022-2023'),
(624, 82, 21, 'D3TI1B', '2022-2023'),
(625, 85, 2, 'D3TI1C', '2022-2023'),
(626, 87, 2, 'D3TI1C', '2022-2023'),
(627, 84, 25, 'D3TI1C', '2022-2023'),
(628, 82, 14, 'D3TI1C', '2022-2023'),
(629, 87, 2, 'D3TI1C', '2022-2023'),
(630, 79, 26, 'D3TI1C', '2022-2023'),
(631, 80, 7, 'D3TI1C', '2022-2023'),
(632, 86, 9, 'D3TI1C', '2022-2023'),
(633, 83, 25, 'D3TI1C', '2022-2023'),
(634, 84, 25, 'D3TI1C', '2022-2023'),
(635, 81, 7, 'D3TI1C', '2022-2023'),
(636, 89, 22, 'D3TI1C', '2022-2023'),
(637, 88, 22, 'D3TI1C', '2022-2023'),
(638, 78, 26, 'D3TI1C', '2022-2023'),
(639, 79, 26, 'D3TI1C', '2022-2023'),
(640, 88, 22, 'D3TI1C', '2022-2023'),
(641, 82, 34, 'D3TI1C', '2022-2023'),
(642, 82, 23, 'D3TI1C', '2022-2023');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

DROP TABLE IF EXISTS `ruang`;
CREATE TABLE IF NOT EXISTS `ruang` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `kapasitas` int DEFAULT NULL,
  `jenis` enum('TEORI','LABORATORIUM','PROYEK','BAHASA') DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`kode`, `nama`, `kapasitas`, `jenis`) VALUES
(1, 'Lab. SOC', 30, 'LABORATORIUM'),
(2, 'Lab. IoT', 30, 'LABORATORIUM'),
(3, 'Lab. HPC', 30, 'LABORATORIUM'),
(4, 'Lab. Data Science', 30, 'LABORATORIUM'),
(5, 'Lab. Animasi', 30, 'LABORATORIUM'),
(6, 'Lab. Multimedia', 30, 'LABORATORIUM'),
(7, 'Lab. SO', 30, 'LABORATORIUM'),
(8, 'Lab. RPL', 30, 'LABORATORIUM'),
(9, 'Lab. Komdas', 30, 'LABORATORIUM'),
(10, 'Lab. Basis Data', 30, 'LABORATORIUM'),
(11, 'Lab. TUK', 30, 'LABORATORIUM'),
(12, 'RK. 409', 30, 'TEORI'),
(13, 'RK. 410', 30, 'TEORI'),
(14, 'RK. 411', 30, 'TEORI'),
(15, 'RK. 510', 30, 'TEORI'),
(16, 'RK. 511', 30, 'TEORI'),
(17, 'RK. 603', 30, 'TEORI'),
(18, 'RK. 607', 30, 'TEORI'),
(19, 'Lab. SOC', 30, 'PROYEK'),
(20, 'Lab. IoT', 30, 'PROYEK'),
(21, 'Lab. HPC', 30, 'PROYEK'),
(22, 'Lab. Animasi', 30, 'PROYEK'),
(23, 'Lab. Multimedia', 30, 'PROYEK'),
(24, 'Lab. SO', 30, 'PROYEK'),
(25, 'Lab. RPL', 30, 'PROYEK'),
(26, 'Lab. Komdas', 30, 'PROYEK'),
(27, 'Lab. Basis Data', 30, 'PROYEK'),
(28, 'Lab. TUK', 30, 'PROYEK'),
(37, 'Lab. Bahasa Inggris', 30, 'BAHASA');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Munir Santiago', 'admin@gmail.com', 'admin', NULL, '21232f297a57a5a743894a0e4a801fc3', NULL, '2023-05-15 09:08:11', '2023-05-15 09:08:11'),
(2, NULL, 'admin1@gmail.com', 'admin1', NULL, '$2y$10$MrdFWtuhQIYaSGInoiWH3.eRzRnKwrARouKa56PnV85SiOGDT1wDK', NULL, '2023-05-15 09:18:07', '2023-05-15 09:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `waktu_bersedia`
--

DROP TABLE IF EXISTS `waktu_bersedia`;
CREATE TABLE IF NOT EXISTS `waktu_bersedia` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `kode_pengampu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_hari` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_jam` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_ruang` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waktu_bersedia`
--

INSERT INTO `waktu_bersedia` (`kode`, `kode_pengampu`, `kode_hari`, `kode_jam`, `kode_ruang`) VALUES
(2, '623', '4', '2', '8'),
(3, '624', '2', '1', '18');

-- --------------------------------------------------------

--
-- Table structure for table `waktu_tidak_bersedia`
--

DROP TABLE IF EXISTS `waktu_tidak_bersedia`;
CREATE TABLE IF NOT EXISTS `waktu_tidak_bersedia` (
  `kode` int NOT NULL AUTO_INCREMENT,
  `kode_dosen` int DEFAULT NULL,
  `kode_hari` int DEFAULT NULL,
  `kode_jam` int DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waktu_tidak_bersedia`
--

INSERT INTO `waktu_tidak_bersedia` (`kode`, `kode_dosen`, `kode_hari`, `kode_jam`) VALUES
(2, 2, NULL, NULL),
(3, 16, NULL, NULL),
(4, 2, 5, 2),
(6, 17, 1, 9),
(7, 17, 1, 10),
(8, 17, 2, 4),
(9, 17, 2, 5),
(10, 17, 2, 6),
(11, 17, 2, 7),
(12, 17, 2, 8),
(13, 17, 2, 9),
(14, 17, 2, 10),
(15, 17, 3, 4),
(16, 17, 3, 5),
(17, 17, 3, 6),
(18, 17, 3, 7),
(19, 17, 3, 8),
(20, 17, 3, 9),
(21, 17, 3, 10),
(22, 17, 4, 2),
(23, 17, 4, 4),
(24, 17, 4, 5),
(25, 17, 4, 6),
(26, 17, 4, 7),
(27, 17, 4, 8),
(28, 17, 4, 9),
(29, 17, 4, 10),
(30, 17, 5, 4),
(31, 17, 5, 5),
(32, 17, 5, 6),
(33, 17, 5, 7),
(34, 17, 5, 8),
(35, 17, 5, 9),
(36, 17, 5, 10),
(37, 3, 2, 2),
(38, 16, 1, 2),
(39, 16, 1, 3),
(40, 16, 1, 4),
(41, 16, 1, 5),
(42, 16, 1, 6),
(43, 16, 1, 7),
(44, 16, 1, 8),
(45, 16, 1, 9),
(46, 16, 1, 10),
(47, 16, 2, 1),
(48, 16, 2, 2),
(49, 16, 2, 3),
(50, 16, 2, 4),
(51, 16, 2, 5),
(52, 16, 2, 6),
(53, 16, 2, 7),
(54, 16, 2, 8),
(55, 16, 2, 9),
(56, 16, 2, 10),
(57, 16, 4, 1),
(58, 16, 4, 2),
(59, 16, 4, 3),
(60, 16, 4, 4),
(61, 16, 4, 5),
(62, 16, 4, 6),
(63, 16, 4, 7),
(64, 16, 4, 8),
(65, 16, 4, 9),
(66, 16, 4, 10),
(67, 16, 5, 1),
(68, 16, 5, 2),
(69, 16, 5, 3),
(70, 16, 5, 4),
(71, 16, 5, 5),
(72, 16, 5, 6),
(73, 16, 5, 7),
(74, 16, 5, 8),
(75, 16, 5, 9),
(76, 16, 5, 10),
(77, 18, 2, 1),
(78, 18, 2, 2),
(79, 18, 2, 3),
(80, 18, 2, 4),
(81, 18, 2, 5),
(82, 18, 2, 6),
(83, 18, 2, 7),
(84, 18, 2, 8),
(85, 18, 2, 9),
(86, 18, 2, 10),
(87, 18, 3, 1),
(88, 18, 3, 2),
(89, 18, 3, 3),
(90, 18, 3, 4),
(91, 18, 3, 5),
(92, 18, 3, 6),
(93, 18, 3, 7),
(94, 18, 3, 8),
(95, 18, 3, 9),
(96, 18, 3, 10),
(97, 18, 4, 1),
(98, 18, 4, 2),
(99, 18, 4, 3),
(100, 18, 4, 4),
(101, 18, 4, 5),
(102, 18, 4, 6),
(103, 18, 4, 7),
(104, 18, 4, 8),
(105, 18, 4, 9),
(107, 18, 5, 1),
(108, 18, 5, 2),
(109, 18, 5, 3),
(110, 18, 5, 4),
(111, 18, 5, 5),
(112, 18, 5, 6),
(113, 18, 5, 7),
(114, 18, 5, 8),
(115, 18, 5, 9),
(116, 18, 5, 10),
(117, 19, 1, 6),
(118, 19, 1, 7),
(119, 19, 1, 8),
(120, 19, 1, 9),
(121, 19, 1, 10),
(122, 19, 3, 1),
(123, 19, 3, 2),
(124, 19, 3, 3),
(125, 19, 3, 4),
(126, 19, 3, 5),
(127, 19, 3, 6),
(128, 19, 3, 7),
(129, 19, 3, 8),
(130, 19, 3, 9),
(131, 19, 3, 10),
(132, 19, 4, 1),
(133, 14, 4, 10),
(134, 19, 4, 3),
(135, 19, 4, 4),
(136, 19, 4, 5),
(137, 19, 4, 6),
(138, 19, 4, 7),
(139, 19, 4, 8),
(140, 19, 4, 9),
(141, 19, 4, 10),
(142, 19, 5, 1),
(143, 19, 5, 2),
(144, 19, 5, 3),
(145, 19, 5, 4),
(146, 19, 5, 5),
(147, 19, 5, 6),
(148, 19, 5, 7),
(149, 19, 5, 8),
(150, 19, 5, 9),
(151, 1, 3, 7),
(155, 17, 1, 8),
(158, NULL, 1, 1),
(159, NULL, NULL, NULL),
(160, NULL, NULL, NULL),
(161, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
