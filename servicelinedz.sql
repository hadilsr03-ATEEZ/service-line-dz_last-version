-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2026 at 02:27 AM
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
-- Database: `servicelinedz`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateur`
--

CREATE TABLE `administrateur` (
  `idAdmin` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `artisan`
--

CREATE TABLE `artisan` (
  `idArtisan` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `statut` enum('EN_ATTENTE','APPROUVE','REJETE') DEFAULT 'EN_ATTENTE',
  `dateVerification` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artisan`
--

INSERT INTO `artisan` (`idArtisan`, `idUtilisateur`, `statut`, `dateVerification`) VALUES
(1, 2, 'EN_ATTENTE', NULL),
(3, 6, 'EN_ATTENTE', NULL),
(5, 9, 'EN_ATTENTE', NULL),
(6, 10, 'EN_ATTENTE', NULL),
(7, 11, 'EN_ATTENTE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

CREATE TABLE `avis` (
  `idAvis` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idArtisan` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text DEFAULT NULL,
  `dateCreation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avis`
--

INSERT INTO `avis` (`idAvis`, `idClient`, `idArtisan`, `note`, `commentaire`, `dateCreation`) VALUES
(1, 1, 5, 5, 'Excellent work, highly recommended.', '2026-06-15 17:26:17'),
(2, 1, 7, 5, 'Excellent work, highly recommended.', '2026-06-15 18:42:35'),
(3, 2, 7, 4, 'Serious,Fast response and high-quality workmanship.', '2026-06-15 18:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `idCategorie` int(11) NOT NULL,
  `nomCategorie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `nomCategorie`) VALUES
(1, 'Plumbing'),
(2, 'Electrical'),
(3, 'Painting'),
(4, 'Cleaning'),
(5, 'Web Development'),
(6, 'Tailoring'),
(7, 'Cooking & Catering'),
(8, 'Technician'),
(9, 'Carpentry'),
(10, 'HVAC & Refrigeration'),
(11, 'Welding & Metalwork'),
(12, 'Gardening & Landscaping'),
(13, 'Graphic Design'),
(14, 'Photography & Video Editing'),
(15, 'Mobile App Development');

-- --------------------------------------------------------

--
-- Table structure for table `categorie_artisan`
--

CREATE TABLE `categorie_artisan` (
  `idCategorieArtisan` int(11) NOT NULL,
  `idProfil` int(11) NOT NULL,
  `idCategorie` int(11) NOT NULL,
  `type` enum('MAIN','ADDITIONAL') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie_artisan`
--

INSERT INTO `categorie_artisan` (`idCategorieArtisan`, `idProfil`, `idCategorie`, `type`) VALUES
(1, 1, 9, 'MAIN'),
(2, 1, 2, 'ADDITIONAL'),
(3, 1, 10, 'ADDITIONAL'),
(4, 4, 14, 'MAIN'),
(5, 4, 13, 'ADDITIONAL'),
(6, 5, 1, 'MAIN'),
(7, 5, 2, 'ADDITIONAL'),
(8, 5, 10, 'ADDITIONAL');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`idClient`, `idUtilisateur`) VALUES
(1, 1),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `disponibilite`
--

CREATE TABLE `disponibilite` (
  `idDisponibilite` int(11) NOT NULL,
  `idProfil` int(11) NOT NULL,
  `jourSemaine` varchar(20) DEFAULT NULL,
  `heureDebut` time DEFAULT NULL,
  `heureFin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disponibilite`
--

INSERT INTO `disponibilite` (`idDisponibilite`, `idProfil`, `jourSemaine`, `heureDebut`, `heureFin`) VALUES
(7, 4, 'sunday', '08:00:00', '17:00:00'),
(8, 4, 'monday', '08:00:00', '17:00:00'),
(9, 4, 'tuesday', '08:00:00', '17:00:00'),
(10, 4, 'wednesday', '08:00:00', '17:00:00'),
(11, 4, 'thursday', '08:00:00', '17:00:00'),
(12, 5, 'sunday', '08:00:00', '18:00:00'),
(13, 5, 'monday', '08:00:00', '18:00:00'),
(14, 5, 'tuesday', '08:00:00', '18:00:00'),
(15, 5, 'wednesday', '08:00:00', '18:00:00'),
(16, 5, 'thursday', '08:00:00', '18:00:00'),
(17, 5, 'saturday', '08:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `favori`
--

CREATE TABLE `favori` (
  `idFavori` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idArtisan` int(11) NOT NULL,
  `dateAjout` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil_artisan`
--

CREATE TABLE `profil_artisan` (
  `idProfil` int(11) NOT NULL,
  `idArtisan` int(11) NOT NULL,
  `idVille` int(11) NOT NULL,
  `photoProfil` varchar(255) DEFAULT NULL,
  `photoCouverture` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `anneesExperience` varchar(20) DEFAULT NULL,
  `qualifications` text DEFAULT NULL,
  `diplomes` text DEFAULT NULL,
  `portfolio` text DEFAULT NULL,
  `serviceAreas` text DEFAULT NULL,
  `whatsapp` varchar(30) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `urgence` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil_artisan`
--

INSERT INTO `profil_artisan` (`idProfil`, `idArtisan`, `idVille`, `photoProfil`, `photoCouverture`, `description`, `adresse`, `anneesExperience`, `qualifications`, `diplomes`, `portfolio`, `serviceAreas`, `whatsapp`, `instagram`, `facebook`, `tiktok`, `urgence`) VALUES
(1, 5, 6, 'uploads/6a2eda790bad6_profile_download (36).jfif', 'uploads/6a2eda790bf2a_cover_🪩.jfif', 'wjhdwa skfladnksjkdrtsll vsirdtfosv', 'ben souna', '3-5', 'hdfisvosdury jzskcxlkzid usfszlvh', '[\"uploads\\/6a2eda790cf4e_qualification_database_class_diagram.pdf\"]', '[\"uploads\\/6a2eda790c468_portfolio_meoww.jfif\",\"uploads\\/6a2eda790c9d5_portfolio_\\ud53c\\ud53c (@Pinkpinknabi) on X.jfif\"]', '[\"chlef\"]', '0655994477', 'www.instagram.com', 'www.facebook.com', 'www.tiktok.com', 1),
(4, 6, 6, 'uploads/6a2ef021f3a75_profile_download (37).jfif', 'uploads/6a2ef021f3f7e_cover_🪩.jfif', 'jdfks sakjfie fsjdnfalkf mcxnfvkdziuf zxjfdisxndzllewij f jv sajjxnkjzoia', 'ben souna', '1-2', 'qwertyuiop asdfghjkl zxcvbnm, sdfghjk wertyui', '[\"uploads\\/6a2ef02200fdb_qualification_database_class_diagram.pdf\"]', '[\"uploads\\/6a2ef022002cb_portfolio_download (35).jfif\",\"uploads\\/6a2ef02200937_portfolio_Flower sticker 1.jfif\"]', '[\"chlef\",\"ben souna\",\"la city\"]', '0699097026', 'www.instagram.com', 'www.facebook.com', 'www.tiktok.com', 1),
(5, 7, 122, 'uploads/6a3038b153fe1_profile_download (39).jfif', 'uploads/6a3038b154501_cover_Protected_  The Benefits of Hiring a Local Plumber in San Jose.jfif', 'Experienced plumber dedicated to providing reliable and efficient plumbing services. Specialized in leak repairs, pipe installation, bathroom renovations, and maintenance. Focused on quality work, customer satisfaction, and timely service.', 'Rue Mohamed Boudiaf', '5-10', 'Vocational Diploma in Plumbing.\r\nProfessional certifications in plumbing maintenance and water heater installation.\r\nWorkplace safety training.\r\nBasic HVAC and refrigeration knowledge.\r\n6 years of professional experience.', '[\"uploads\\/6a3038b15798d_qualification_Professional_Certificates_Yacine_Merabet.pdf.pdf\"]', '[\"uploads\\/6a3038b154a14_portfolio_Why Santino\\u2019s A+ Handyman Service Leads Oceanside, CA for Shower Replacement and Bathroom Remodeling.jfif\",\"uploads\\/6a3038b154fb8_portfolio_Top 5 Reasons to Invest in a New Boiler Today.jfif\",\"uploads\\/6a3038b1554a8_portfolio_Reliable Plumbing Services You Can Trust.jfif\",\"uploads\\/6a3038b15584e_portfolio_Protected_ \\u00a0The Benefits of Hiring a Local Plumber in San Jose.jfif\",\"uploads\\/6a3038b155c8b_portfolio_Pipe Leak Repair in Brentwood.jfif\",\"uploads\\/6a3038b15625c_portfolio_New Orleans Drain Cleaning and Repair Specialists.jfif\",\"uploads\\/6a3038b1566f6_portfolio_How to Install a Drop-In Kitchen Sink _ Lowe\'s.jfif\",\"uploads\\/6a3038b156b48_portfolio_How To Handle Common Plumbing Repairs At Home.jfif\",\"uploads\\/6a3038b156fa3_portfolio_Bathroom Upgrade Service.jfif\",\"uploads\\/6a3038b157417_portfolio_Easy Dishwasher Installation & Drain Connection Marietta.jfif\"]', '[\"El Khroub\",\"Constantine Centre\",\"Ain Smara\"]', '0661457823', 'https://www.instagram.com/yacine.plumbing', 'https://www.facebook.com/yacine.merabet.plumbing', 'https://www.tiktok.com/@yacine.plumbing', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `idService` int(11) NOT NULL,
  `idProfil` int(11) NOT NULL,
  `titre` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`idService`, `idProfil`, `titre`, `description`, `prix`) VALUES
(1, 4, 'service1', 'the first service', 5000.00),
(2, 5, 'Leak Repair', ' Detection and repair of water leaks in residential and commercial properties.', 1500.00),
(3, 5, 'Water Heater Installation', 'Installation and maintenance of electric and gas water heaters.', 8000.00),
(4, 5, 'Drain Cleaning', 'Fast and effective cleaning of blocked drains and sewer pipes.', 2500.00);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `nomComplet` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `dateCreation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `nomComplet`, `email`, `telephone`, `motDePasse`, `dateCreation`) VALUES
(1, 'Hadil', 'hadil03@gmail.com', '0567800366', '$2y$10$mWC0TenxroQTh7ddzS0DjefqnTyhuaoQEJCd2M.RqYh2sIVVmc7cq', '2026-06-13 21:28:33'),
(2, 'asdfg', 'asdfg@gmail.com', '0789756423', '$2y$10$XKsPh0W5hRX7bnoHjZ0ZYOgCBFqLmZ3bshEmFw2z9DmX0IVY5joui', '2026-06-13 21:42:33'),
(3, 'Daisy Josephine', 'daisyjosephine03@gmail.com', '0567800365', '$2y$10$rlB6h3BsPPldXUviIhUmD.2jX6gAd.AuIwDyF9Rp.rBZ.vpR7CiYy', '2026-06-13 21:44:06'),
(6, 'mmmm', 'mmm@gmail.com', '0789756423', '$2y$10$1yQwJX9DBRoOdCmJAKGM2uUWnAXH1cvQd5FCOArIz5wI6LWmM6mtu', '2026-06-13 22:13:40'),
(9, 'pro1', 'pro1@gmail.com', '0789726423', '$2y$10$lJXgRaawjofhVrttdVE0.OSvsSLP2oS7Sb1fUicEPS.UlPze71PJu', '2026-06-14 05:33:14'),
(10, 'imane sahar', 'imane10@gmail.com', '0699097026', '$2y$10$lKKMsMkLJOKcwltlDfGToeypuVO9a.gQuijQkObSfQoIjHwAtb0GO', '2026-06-14 19:14:12'),
(11, 'Yasine Merabet', 'yacine.merabet@gmail.com', '0661457823', '$2y$10$wR3HoVnkmZ0ZpzH2vXwUAu.CwjwHeOw4M/q.EVZ0fQ6rkH46GlmqK', '2026-06-15 17:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `ville`
--

CREATE TABLE `ville` (
  `idVille` int(11) NOT NULL,
  `idWilaya` int(11) NOT NULL,
  `nomVille` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ville`
--

INSERT INTO `ville` (`idVille`, `idWilaya`, `nomVille`) VALUES
(1, 1, 'Adrar'),
(2, 1, 'Reggane'),
(3, 1, 'Aoulef'),
(4, 1, 'Timimoun'),
(5, 1, 'Fenoughil'),
(6, 2, 'Chlef'),
(7, 2, 'Tenes'),
(8, 2, 'Oued Fodda'),
(9, 2, 'Boukadir'),
(10, 2, 'El Karimia'),
(11, 3, 'Laghouat'),
(12, 3, 'Aflou'),
(13, 3, 'Hassi R\'Mel'),
(14, 3, 'Ksar El Hirane'),
(15, 3, 'Brida'),
(16, 4, 'Oum El Bouaghi'),
(17, 4, 'Ain Beida'),
(18, 4, 'Ain M\'Lila'),
(19, 4, 'Meskiana'),
(20, 4, 'Sigus'),
(21, 5, 'Batna'),
(22, 5, 'Barika'),
(23, 5, 'Arris'),
(24, 5, 'Merouana'),
(25, 5, 'Tazoult'),
(26, 6, 'Bejaia'),
(27, 6, 'Akbou'),
(28, 6, 'Amizour'),
(29, 6, 'Kherrata'),
(30, 6, 'Seddouk'),
(31, 7, 'Biskra'),
(32, 7, 'Tolga'),
(33, 7, 'Sidi Okba'),
(34, 7, 'Zeribet El Oued'),
(35, 7, 'Ouled Djellal'),
(36, 8, 'Bechar'),
(37, 8, 'Kenadsa'),
(38, 8, 'Abadla'),
(39, 8, 'Taghit'),
(40, 8, 'Beni Ounif'),
(41, 9, 'Blida'),
(42, 9, 'Boufarik'),
(43, 9, 'Larbaa'),
(44, 9, 'Mouzaia'),
(45, 9, 'Bouinan'),
(46, 10, 'Bouira'),
(47, 10, 'Lakhdaria'),
(48, 10, 'Sour El Ghozlane'),
(49, 10, 'M\'Chedallah'),
(50, 10, 'Kadiria'),
(51, 11, 'Tamanrasset'),
(52, 11, 'In Salah'),
(53, 11, 'In Guezzam'),
(54, 11, 'Abalessa'),
(55, 11, 'Tazrouk'),
(56, 12, 'Tebessa'),
(57, 12, 'Bir El Ater'),
(58, 12, 'Cheria'),
(59, 12, 'El Aouinet'),
(60, 12, 'Negrine'),
(61, 13, 'Tlemcen'),
(62, 13, 'Maghnia'),
(63, 13, 'Ghazaouet'),
(64, 13, 'Nedroma'),
(65, 13, 'Remchi'),
(66, 14, 'Tiaret'),
(67, 14, 'Sougueur'),
(68, 14, 'Frenda'),
(69, 14, 'Mahdia'),
(70, 14, 'Ain Deheb'),
(71, 15, 'Tizi Ouzou'),
(72, 15, 'Azazga'),
(73, 15, 'Boghni'),
(74, 15, 'Draa Ben Khedda'),
(75, 15, 'Larbaa Nath Irathen'),
(76, 16, 'Alger Centre'),
(77, 16, 'Bab Ezzouar'),
(78, 16, 'El Harrach'),
(79, 16, 'Rouiba'),
(80, 16, 'Bir Mourad Rais'),
(81, 17, 'Djelfa'),
(82, 17, 'Messaad'),
(83, 17, 'Ain Oussera'),
(84, 17, 'Hassi Bahbah'),
(85, 17, 'Dar Chioukh'),
(86, 18, 'Jijel'),
(87, 18, 'Taher'),
(88, 18, 'El Milia'),
(89, 18, 'Chekfa'),
(90, 18, 'Ziama Mansouriah'),
(91, 19, 'Setif'),
(92, 19, 'El Eulma'),
(93, 19, 'Ain Oulmene'),
(94, 19, 'Bougaa'),
(95, 19, 'Ain Arnat'),
(96, 20, 'Saida'),
(97, 20, 'Ain El Hadjar'),
(98, 20, 'Sidi Boubekeur'),
(99, 20, 'Youb'),
(100, 20, 'Ouled Khaled'),
(101, 21, 'Skikda'),
(102, 21, 'Azzaba'),
(103, 21, 'Collo'),
(104, 21, 'El Harrouch'),
(105, 21, 'Tamalous'),
(106, 22, 'Sidi Bel Abbes'),
(107, 22, 'Telagh'),
(108, 22, 'Ras El Ma'),
(109, 22, 'Sfisef'),
(110, 22, 'Ben Badis'),
(111, 23, 'Annaba'),
(112, 23, 'El Bouni'),
(113, 23, 'Berrahal'),
(114, 23, 'Seraidi'),
(115, 23, 'Chetaibi'),
(116, 24, 'Guelma'),
(117, 24, 'Oued Zenati'),
(118, 24, 'Hammam Debagh'),
(119, 24, 'Heliopolis'),
(120, 24, 'Boumahra Ahmed'),
(121, 25, 'Constantine'),
(122, 25, 'El Khroub'),
(123, 25, 'Hamma Bouziane'),
(124, 25, 'Ain Smara'),
(125, 25, 'Didouche Mourad'),
(126, 26, 'Medea'),
(127, 26, 'Berrouaghia'),
(128, 26, 'Ksar El Boukhari'),
(129, 26, 'Tablat'),
(130, 26, 'Ouzera'),
(131, 27, 'Mostaganem'),
(132, 27, 'Ain Nouissy'),
(133, 27, 'Hassi Mameche'),
(134, 27, 'Sidi Ali'),
(135, 27, 'Achaacha'),
(136, 28, 'M\'Sila'),
(137, 28, 'Bou Saada'),
(138, 28, 'Sidi Aissa'),
(139, 28, 'Ain El Hadjel'),
(140, 28, 'Magra'),
(141, 29, 'Mascara'),
(142, 29, 'Sig'),
(143, 29, 'Mohammadia'),
(144, 29, 'Tighennif'),
(145, 29, 'Ghriss'),
(146, 30, 'Ouargla'),
(147, 30, 'Hassi Messaoud'),
(148, 30, 'Touggourt'),
(149, 30, 'Rouissat'),
(150, 30, 'N\'Goussa'),
(151, 31, 'Oran'),
(152, 31, 'Bir El Djir'),
(153, 31, 'Es Senia'),
(154, 31, 'Arzew'),
(155, 31, 'Ain El Turk'),
(156, 32, 'El Bayadh'),
(157, 32, 'Rogassa'),
(158, 32, 'Brezina'),
(159, 32, 'Boualem'),
(160, 32, 'El Abiodh Sidi Cheikh'),
(161, 33, 'Illizi'),
(162, 33, 'Djanet'),
(163, 33, 'In Amenas'),
(164, 33, 'Debdeb'),
(165, 33, 'Bordj Omar Driss'),
(166, 34, 'Bordj Bou Arreridj'),
(167, 34, 'Ras El Oued'),
(168, 34, 'El Achir'),
(169, 34, 'Mansoura'),
(170, 34, 'Medjana'),
(171, 35, 'Boumerdes'),
(172, 35, 'Dellys'),
(173, 35, 'Thenia'),
(174, 35, 'Boudouaou'),
(175, 35, 'Khemis El Khechna'),
(176, 36, 'El Tarf'),
(177, 36, 'El Kala'),
(178, 36, 'Bouteldja'),
(179, 36, 'Drean'),
(180, 36, 'Ben M\'Hidi'),
(181, 37, 'Tindouf'),
(182, 37, 'Oum El Assel'),
(183, 37, 'Hassi Khebi'),
(184, 37, 'Merkala'),
(185, 37, 'Tindouf Centre'),
(186, 38, 'Tissemsilt'),
(187, 38, 'Theniet El Had'),
(188, 38, 'Khemisti'),
(189, 38, 'Bordj Emir Abdelkader'),
(190, 38, 'Lazharia'),
(191, 39, 'El Oued'),
(192, 39, 'Guemar'),
(193, 39, 'Robbah'),
(194, 39, 'Debila'),
(195, 39, 'Magrane'),
(196, 40, 'Khenchela'),
(197, 40, 'Kais'),
(198, 40, 'Bouhmama'),
(199, 40, 'Chechar'),
(200, 40, 'El Hamma'),
(201, 41, 'Souk Ahras'),
(202, 41, 'Sedrata'),
(203, 41, 'Taoura'),
(204, 41, 'M\'Daourouch'),
(205, 41, 'Hanancha'),
(206, 42, 'Tipaza'),
(207, 42, 'Cherchell'),
(208, 42, 'Kolea'),
(209, 42, 'Hadjout'),
(210, 42, 'Fouka'),
(211, 43, 'Mila'),
(212, 43, 'Chelghoum Laid'),
(213, 43, 'Tadjenanet'),
(214, 43, 'Ferdjioua'),
(215, 43, 'Grarem Gouga'),
(216, 44, 'Ain Defla'),
(217, 44, 'Miliana'),
(218, 44, 'Khemis Miliana'),
(219, 44, 'El Attaf'),
(220, 44, 'Djelida'),
(221, 45, 'Naama'),
(222, 45, 'Mecheria'),
(223, 45, 'Ain Sefra'),
(224, 45, 'Tiout'),
(225, 45, 'Sfissifa'),
(226, 46, 'Ain Temouchent'),
(227, 46, 'Beni Saf'),
(228, 46, 'Hammam Bou Hadjar'),
(229, 46, 'El Malah'),
(230, 46, 'Chaabet El Ham'),
(231, 47, 'Ghardaia'),
(232, 47, 'Metlili'),
(233, 47, 'Berriane'),
(234, 47, 'El Atteuf'),
(235, 47, 'Guerrara'),
(236, 48, 'Relizane'),
(237, 48, 'Oued Rhiou'),
(238, 48, 'Mazouna'),
(239, 48, 'Djidiouia'),
(240, 48, 'Yellel'),
(241, 49, 'Timimoun'),
(242, 49, 'Aougrout'),
(243, 49, 'Tinerkouk'),
(244, 49, 'Charouine'),
(245, 49, 'Metarfa'),
(246, 50, 'Bordj Badji Mokhtar'),
(247, 50, 'Timiaouine'),
(248, 50, 'Bordj Centre'),
(249, 50, 'Timiaouine Nord'),
(250, 50, 'Timiaouine Sud'),
(251, 51, 'Ouled Djellal'),
(252, 51, 'Sidi Khaled'),
(253, 51, 'Ras El Miad'),
(254, 51, 'Doucen'),
(255, 51, 'Chaiba'),
(256, 52, 'Beni Abbes'),
(257, 52, 'Kerzaz'),
(258, 52, 'Igli'),
(259, 52, 'Ouled Khoudir'),
(260, 52, 'Tamtert'),
(261, 53, 'In Salah'),
(262, 53, 'Foggaret Ezzaouia'),
(263, 53, 'In Ghar'),
(264, 53, 'Hassi El Fouhal'),
(265, 53, 'Ain Salah Centre'),
(266, 54, 'In Guezzam'),
(267, 54, 'Tin Zaouatine'),
(268, 54, 'In Guezzam Centre'),
(269, 54, 'Tin Zaouatine Nord'),
(270, 54, 'Tin Zaouatine Sud'),
(271, 55, 'Touggourt'),
(272, 55, 'Temacine'),
(273, 55, 'Nezla'),
(274, 55, 'Tebesbest'),
(275, 55, 'Zaouia El Abidia'),
(276, 56, 'Djanet'),
(277, 56, 'Bordj El Haouas'),
(278, 56, 'Djanet Centre'),
(279, 56, 'Bordj El Haouas Nord'),
(280, 56, 'Bordj El Haouas Sud'),
(281, 57, 'El M\'Ghair'),
(282, 57, 'Djamaa'),
(283, 57, 'Sidi Amrane'),
(284, 57, 'Oum Touyour'),
(285, 57, 'Still'),
(286, 58, 'El Meniaa'),
(287, 58, 'Hassi Gara'),
(288, 58, 'Mansoura'),
(289, 58, 'Hassi Fhel'),
(290, 58, 'El Meniaa Centre');

-- --------------------------------------------------------

--
-- Table structure for table `wilaya`
--

CREATE TABLE `wilaya` (
  `idWilaya` int(11) NOT NULL,
  `nomWilaya` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wilaya`
--

INSERT INTO `wilaya` (`idWilaya`, `nomWilaya`) VALUES
(1, 'Adrar'),
(2, 'Chlef'),
(3, 'Laghouat'),
(4, 'Oum El Bouaghi'),
(5, 'Batna'),
(6, 'Béjaïa'),
(7, 'Biskra'),
(8, 'Béchar'),
(9, 'Blida'),
(10, 'Bouira'),
(11, 'Tamanrasset'),
(12, 'Tébessa'),
(13, 'Tlemcen'),
(14, 'Tiaret'),
(15, 'Tizi Ouzou'),
(16, 'Alger'),
(17, 'Djelfa'),
(18, 'Jijel'),
(19, 'Sétif'),
(20, 'Saïda'),
(21, 'Skikda'),
(22, 'Sidi Bel Abbès'),
(23, 'Annaba'),
(24, 'Guelma'),
(25, 'Constantine'),
(26, 'Médéa'),
(27, 'Mostaganem'),
(28, 'M\'Sila'),
(29, 'Mascara'),
(30, 'Ouargla'),
(31, 'Oran'),
(32, 'El Bayadh'),
(33, 'Illizi'),
(34, 'Bordj Bou Arreridj'),
(35, 'Boumerdès'),
(36, 'El Tarf'),
(37, 'Tindouf'),
(38, 'Tissemsilt'),
(39, 'El Oued'),
(40, 'Khenchela'),
(41, 'Souk Ahras'),
(42, 'Tipaza'),
(43, 'Mila'),
(44, 'Aïn Defla'),
(45, 'Naâma'),
(46, 'Aïn Témouchent'),
(47, 'Ghardaïa'),
(48, 'Relizane'),
(49, 'Timimoun'),
(50, 'Bordj Badji Mokhtar'),
(51, 'Ouled Djellal'),
(52, 'Béni Abbès'),
(53, 'In Salah'),
(54, 'In Guezzam'),
(55, 'Touggourt'),
(56, 'Djanet'),
(57, 'El M\'Ghair'),
(58, 'El Meniaa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`idAdmin`),
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- Indexes for table `artisan`
--
ALTER TABLE `artisan`
  ADD PRIMARY KEY (`idArtisan`),
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- Indexes for table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`idAvis`),
  ADD UNIQUE KEY `idClient` (`idClient`,`idArtisan`),
  ADD KEY `idArtisan` (`idArtisan`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Indexes for table `categorie_artisan`
--
ALTER TABLE `categorie_artisan`
  ADD PRIMARY KEY (`idCategorieArtisan`),
  ADD KEY `idProfil` (`idProfil`),
  ADD KEY `idCategorie` (`idCategorie`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- Indexes for table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD PRIMARY KEY (`idDisponibilite`),
  ADD KEY `idProfil` (`idProfil`);

--
-- Indexes for table `favori`
--
ALTER TABLE `favori`
  ADD PRIMARY KEY (`idFavori`),
  ADD KEY `idClient` (`idClient`),
  ADD KEY `idArtisan` (`idArtisan`);

--
-- Indexes for table `profil_artisan`
--
ALTER TABLE `profil_artisan`
  ADD PRIMARY KEY (`idProfil`),
  ADD UNIQUE KEY `idArtisan` (`idArtisan`),
  ADD KEY `idVille` (`idVille`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`idService`),
  ADD KEY `idProfil` (`idProfil`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`idVille`),
  ADD KEY `idWilaya` (`idWilaya`);

--
-- Indexes for table `wilaya`
--
ALTER TABLE `wilaya`
  ADD PRIMARY KEY (`idWilaya`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artisan`
--
ALTER TABLE `artisan`
  MODIFY `idArtisan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `avis`
--
ALTER TABLE `avis`
  MODIFY `idAvis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categorie_artisan`
--
ALTER TABLE `categorie_artisan`
  MODIFY `idCategorieArtisan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `disponibilite`
--
ALTER TABLE `disponibilite`
  MODIFY `idDisponibilite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `favori`
--
ALTER TABLE `favori`
  MODIFY `idFavori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profil_artisan`
--
ALTER TABLE `profil_artisan`
  MODIFY `idProfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `idService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ville`
--
ALTER TABLE `ville`
  MODIFY `idVille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `wilaya`
--
ALTER TABLE `wilaya`
  MODIFY `idWilaya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `administrateur_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `artisan`
--
ALTER TABLE `artisan`
  ADD CONSTRAINT `artisan_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`) ON DELETE CASCADE,
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`idArtisan`) REFERENCES `artisan` (`idArtisan`) ON DELETE CASCADE;

--
-- Constraints for table `categorie_artisan`
--
ALTER TABLE `categorie_artisan`
  ADD CONSTRAINT `categorie_artisan_ibfk_1` FOREIGN KEY (`idProfil`) REFERENCES `profil_artisan` (`idProfil`) ON DELETE CASCADE,
  ADD CONSTRAINT `categorie_artisan_ibfk_2` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`) ON DELETE CASCADE;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD CONSTRAINT `disponibilite_ibfk_1` FOREIGN KEY (`idProfil`) REFERENCES `profil_artisan` (`idProfil`) ON DELETE CASCADE;

--
-- Constraints for table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `favori_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`) ON DELETE CASCADE,
  ADD CONSTRAINT `favori_ibfk_2` FOREIGN KEY (`idArtisan`) REFERENCES `artisan` (`idArtisan`) ON DELETE CASCADE;

--
-- Constraints for table `profil_artisan`
--
ALTER TABLE `profil_artisan`
  ADD CONSTRAINT `profil_artisan_ibfk_1` FOREIGN KEY (`idArtisan`) REFERENCES `artisan` (`idArtisan`) ON DELETE CASCADE,
  ADD CONSTRAINT `profil_artisan_ibfk_2` FOREIGN KEY (`idVille`) REFERENCES `ville` (`idVille`);

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`idProfil`) REFERENCES `profil_artisan` (`idProfil`) ON DELETE CASCADE;

--
-- Constraints for table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_1` FOREIGN KEY (`idWilaya`) REFERENCES `wilaya` (`idWilaya`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
