-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 06:17 AM
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
-- Database: `gamestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `name`, `email`, `password`, `birth_date`) VALUES
(1, 'admin', 'a@email.com', '$2y$10$7d.h7Hhb3LXUoPRk9Bq4S.iwx92NopvsAsS0CI.AFxuX6ImKac5XG', '2000-01-17');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `bio` text DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `fav_genre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`user_id`, `username`, `password`, `name`, `email`, `birth_date`, `bio`, `avatar_url`, `fav_genre`) VALUES
(1, 'bat123', '$2y$10$Qm5gmq10.yHMzTqE6JhBxuCabC6TX8yxQvNLad7fM0XLrtvJfqNz6', 'batman', 'bat@email.com', '2020-01-02', 'hey', 'asd', 'Action'),
(4, 'spider123', '$2y$10$wPy31g0YaBi/G1opiQRNz.e.6aV5SVeW5J/rBMHDbROejySCuTj8a', 'spiderman', 'spider@email.com', '2016-02-02', '', '', 'Strategy');

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`user_id`, `friend_id`, `status`) VALUES
(1, 3, 'accepted'),
(2, 1, 'accepted'),
(4, 1, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `no_of_wishlists` int(11) DEFAULT 0,
  `publisher` varchar(100) NOT NULL,
  `release_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`game_id`, `title`, `price`, `genre`, `quantity`, `no_of_wishlists`, `publisher`, `release_date`) VALUES
(1, 'Elden Ring', 59.99, 'RPG', 43, 0, 'FromSoftware', '2022-02-25'),
(2, 'Cyberpunk 2077', 49.99, 'RPG', 29, 0, 'CD Projekt Red', '2020-12-10'),
(3, 'The Witcher 3: Wild Hunt', 39.99, 'RPG', 49, 2, 'CD Projekt Red', '2015-05-19'),
(4, 'Stardew Valley', 14.99, 'Simulation', 20, 0, 'ConcernedApe', '2016-02-26'),
(5, 'Red Dead Redemption 2', 59.99, 'Action', 38, 1, 'Rockstar Games', '2018-10-26'),
(6, 'Hades', 24.99, 'Action', 21, 0, 'Supergiant Games', '2020-09-17'),
(7, 'Grand Theft Auto V', 29.99, 'Action', 30, 0, 'Rockstar Games', '2013-09-17'),
(8, 'Minecraft', 26.95, 'Indie', 50, 0, 'Mojang Studios', '2011-11-18'),
(9, 'Valorant', 0.00, 'FPS', 30, 0, 'Riot Games', '2020-06-02'),
(10, 'Call of Duty: Warzone', 0.00, 'FPS', 20, 0, 'Activision', '2020-03-10'),
(11, 'Starfield', 69.99, 'Sci-Fi RPG', 32, 0, 'Bethesda', '2023-09-06'),
(12, 'Doom Eternal', 39.99, 'FPS', 38, 0, 'id Software', '2020-03-20'),
(13, 'Apex Legends', 0.00, 'Battle Royale', 35, 0, 'Respawn Entertainment', '2019-02-04'),
(14, 'It Takes Two', 39.99, 'Co-op Adventure', 31, 0, 'Electronic Arts', '2021-03-26'),
(15, 'Sekiro: Shadows Die Twice', 59.99, 'Action', 33, 0, 'Activision', '2019-03-22'),
(16, 'Forza Horizon 5', 59.99, 'Racing', 39, 0, 'Xbox Game Studios', '2021-11-09'),
(17, 'Street Fighter 6', 59.99, 'Fighting', 34, 0, 'Capcom', '2023-06-02'),
(18, 'Deathloop', 59.99, 'FPS', 30, 0, 'Bethesda', '2021-09-14'),
(19, 'Monster Hunter Rise', 39.99, 'Action RPG', 37, 0, 'Capcom', '2021-03-26'),
(20, 'Sea of Thieves', 39.99, 'Adventure', 36, 0, 'Rare', '2018-03-20'),
(21, 'Subnautica', 29.99, 'Survival', 40, 0, 'Unknown Worlds', '2018-01-23'),
(22, 'Cities: Skylines II', 49.99, 'Simulation', 32, 0, 'Paradox Interactive', '2023-10-24'),
(23, 'Dark Souls III', 59.99, 'Action RPG', 31, 0, 'Bandai Namco', '2016-04-12'),
(24, 'Lies of P', 59.99, 'Soulslike', 35, 0, 'Neowiz', '2023-09-19'),
(25, 'Ratchet & Clank: Rift Apart', 69.99, 'Platformer', 33, 0, 'Sony Interactive', '2021-06-11'),
(26, 'Alan Wake 2', 59.99, 'Psychological Horror', 34, 0, 'Remedy Entertainment', '2023-10-27'),
(27, 'Dead Space Remake', 59.99, 'Sci-Fi Horror', 38, 0, 'Electronic Arts', '2023-01-27'),
(28, 'Disco Elysium', 39.99, 'RPG', 39, 0, 'ZA/UM', '2019-10-15'),
(29, 'Among Us', 4.99, 'Party', 40, 0, 'Innersloth', '2018-06-15'),
(30, 'Tekken 8', 69.99, 'Fighting', 36, 0, 'Bandai Namco', '2024-01-26'),
(31, 'Black Myth: Wukong', 59.99, 'Action RPG', 33, 0, 'Game Science', '2024-08-20'),
(32, 'Dragon Age: The Veilguard', 69.99, 'RPG', 35, 0, 'Electronic Arts', '2024-10-31'),
(33, 'Helldivers 2', 39.99, 'Third-Person Shooter', 38, 0, 'Sony Interactive', '2024-02-08'),
(34, 'Warhammer 40k: Space Marine 2', 59.99, 'Action', 31, 0, 'Focus Entertainment', '2024-09-09'),
(35, 'Palworld', 29.99, 'Survival', 40, 0, 'Pocketpair', '2024-01-19'),
(36, 'Enshrouded', 29.99, 'Survival RPG', 34, 0, 'Keen Games', '2024-01-24'),
(37, 'Manor Lords', 39.99, 'Strategy', 32, 0, 'Hooded Horse', '2024-04-26'),
(38, 'Dragon\'s Dogma 2', 69.99, 'Action RPG', 30, 0, 'Capcom', '2024-03-22'),
(39, 'Frostpunk 2', 44.99, 'City Builder', 36, 0, '11 bit studios', '2024-09-20'),
(40, 'Silent Hill 2 Remake', 69.99, 'Horror', 33, 0, 'Konami', '2024-10-08'),
(41, 'Metaphor: ReFantazio', 69.99, 'JRPG', 37, 0, 'Atlus', '2024-10-11'),
(42, 'S.T.A.L.K.E.R. 2', 59.99, 'FPS Horror', 31, 0, 'GSC Game World', '2024-11-20'),
(43, 'Indiana Jones: The Great Circle', 69.99, 'Action-Adventure', 39, 0, 'Bethesda', '2024-12-09'),
(44, 'Satisfactory', 29.99, 'Simulation', 40, 0, 'Coffee Stain Studios', '2024-09-10'),
(45, 'Balatro', 14.99, 'Roguelike Deckbuilder', 38, 0, 'Playstack', '2024-02-20'),
(46, 'Animal Well', 24.99, 'Metroidvania', 35, 0, 'Bigmode', '2024-05-09'),
(47, 'Stellar Blade', 69.99, 'Action', 32, 0, 'Sony Interactive', '2024-04-26'),
(48, 'Monster Hunter Wilds', 69.99, 'Action RPG', 40, 0, 'Capcom', '2025-02-28'),
(49, 'Civilization VII', 69.99, 'Strategy', 34, 0, '2K Games', '2025-02-11'),
(50, 'Kingdom Come: Deliverance II', 59.99, 'Medieval RPG', 31, 0, 'Deep Silver', '2025-02-11'),
(51, 'Adobe Photoshop 2024', 239.88, 'Design', 32, 0, 'Adobe', '2023-10-15'),
(52, 'Microsoft Office 2021', 149.99, 'Productivity', 38, 0, 'Microsoft', '2021-10-05'),
(53, 'Windows 11 Pro', 199.99, 'Operating System', 35, 0, 'Microsoft', '2021-10-05'),
(54, 'Norton Antivirus Plus', 59.99, 'Security', 40, 0, 'NortonLifeLock', '2023-01-12'),
(55, 'FL Studio 21', 199.00, 'Audio Production', 31, 0, 'Image-Line', '2022-12-09'),
(56, 'NordVPN 2-Year Plan', 89.99, 'Security', 37, 0, 'Nord Security', '2024-01-01'),
(57, 'Vegas Pro 21', 399.00, 'Video Editing', 33, 0, 'Magix', '2023-08-14'),
(58, 'AutoCAD 2024', 1955.00, 'Engineering', 30, 0, 'Autodesk', '2023-03-28'),
(59, 'WinRAR Premium', 29.00, 'Utility', 40, 0, 'RARLAB', '2023-05-04'),
(60, 'Kaspersky Total Security', 49.99, 'Security', 36, 0, 'Kaspersky Lab', '2023-09-20'),
(61, 'Ableton Live 12', 449.00, 'Audio Production', 32, 0, 'Ableton', '2024-03-05'),
(62, 'CorelDRAW Graphics Suite', 429.00, 'Design', 34, 0, 'Corel', '2024-03-12'),
(63, 'Bitdefender Antivirus', 39.99, 'Security', 39, 0, 'Bitdefender', '2023-07-11'),
(64, 'Sublime Text 4', 99.00, 'Development', 40, 0, 'Sublime HQ', '2021-05-20'),
(65, 'Affinity Photo 2', 69.99, 'Design', 38, 0, 'Serif', '2022-11-09'),
(66, 'CleanMyMac X', 39.95, 'Utility', 35, 0, 'MacPaw', '2023-11-15'),
(67, 'Final Cut Pro', 299.99, 'Video Editing', 31, 0, 'Apple', '2023-05-23'),
(68, 'Unity Pro Subscription', 2040.00, 'Development', 30, 0, 'Unity Technologies', '2023-11-01'),
(69, 'VMware Workstation 17', 199.00, 'Virtualization', 33, 0, 'Broadcom', '2022-11-17'),
(70, 'Malwarebytes Premium', 44.99, 'Security', 37, 0, 'Malwarebytes', '2023-04-10');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `method_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`payment_id`, `user_id`, `method_type`) VALUES
(1, 1, 'paypal');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`user_id`, `game_id`, `purchase_date`) VALUES
(1, 3, '2026-01-05 05:01:29'),
(2, 1, '2026-01-03 07:01:50'),
(3, 1, '2026-01-04 12:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `rating_value` int(11) NOT NULL CHECK (`rating_value` between 0 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`user_id`, `game_id`, `rating_value`) VALUES
(1, 1, 4),
(1, 2, 3),
(1, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket`
--

CREATE TABLE `support_ticket` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_ticket`
--

INSERT INTO `support_ticket` (`ticket_id`, `user_id`, `title`, `description`, `status`) VALUES
(1, 1, 'The Witcher 3: Wild Hunt', 'It has lots of bugs. Specifically, the player sometimes gets stuck.', 'Fixed'),
(2, 1, 'Cyberpunk 2077', 'lots of bugs', 'Ongoing'),
(3, 1, 'Starfield', 'Game has bugs and crashes sometimes', 'Ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`user_id`, `game_id`) VALUES
(1, 3),
(2, 1),
(3, 1),
(3, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`user_id`,`friend_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`user_id`,`game_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`user_id`,`game_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `support_ticket`
--
ALTER TABLE `support_ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`user_id`,`game_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `support_ticket`
--
ALTER TABLE `support_ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD CONSTRAINT `fk_payment_user` FOREIGN KEY (`user_id`) REFERENCES `customers` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
