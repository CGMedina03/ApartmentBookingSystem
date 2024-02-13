-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 11:00 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpabs`
--

-- --------------------------------------------------------

--
-- Table structure for table `addson`
--

CREATE TABLE `addson` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `picture` longtext NOT NULL,
  `description` longtext NOT NULL,
  `price` bigint(255) NOT NULL,
  `availability` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addson`
--

INSERT INTO `addson` (`id`, `title`, `picture`, `description`, `price`, `availability`) VALUES
(22, 'Aircon ', 'uploads/medium02 (2).jpg', 'Our efficient Aircon unit will increase the comfort level in your space. It is designed to offer ideal cooling, resulting in a pleasant environment even on the warmest days. The Aircon blends perfectly into any room because to its elegant form and user-friendly features, such as changeable settings and silent operation. Say goodbye to pain and welcome to relaxation with this vital hotel amenity.', 250, 'Available'),
(23, 'Refrigerator', 'uploads/KSD157SA.png', 'Upgrade your kitchen with this dependable refrigerator, which is intended to fulfill all of your food storage requirements. With its large interior and excellent cooling mechanism, it keeps your groceries fresh and your beverages cold. The sleek design and adjustable shelf make organizing a pleasure, and the energy-efficient functioning reduces your electricity expense. With our essential Refrigerator, you can say goodbye to food deterioration and hello to convenience.', 200, 'Available'),
(24, 'Gas Range', 'uploads/W020230315354084881788.png', 'Enhance your culinary experience with our Gas Range, designed to provide precise cooking and energy economy. Whether you\'re a seasoned chef or a newbie cook, this equipment delivers dependable results for all of your culinary requirements. You can easily create excellent dishes because to the straightforward controls and equal heat distribution. The sleek design offers a modern touch to your kitchen while being durable and practical. Upgrade your cooking arsenal now with our Gas Range and unleash your culinary imagination.', 200, 'Available'),
(25, 'Water Heater', 'uploads/172911_2020.jpg', 'Our economical Water Heater allows you to enjoy the luxury of warm showers anytime you want them. It is designed for ease of use and comfort, providing quick hot water with the push of a button. Say goodbye to cold mornings and hello to relaxing showers that refresh your senses. With its dependable performance and streamlined appearance, our Water Heater is an essential addition to any modern bathroom. Upgrade your house now and enjoy the finest bathing experience with our premium water heater.', 150, 'Available'),
(26, 'Microwave oven', 'uploads/152151_2020.jpg', 'With our multifunctional Microwave Oven, you can make cooking more convenient. From rapid warming to defrosting and cooking, this gadget puts convenience at your fingertips. The user-friendly interface and straightforward controls make operation simple, and the compact form saves important countertop space. Whether you\'re making a quick dinner or preparing snacks for a movie night, our Microwave Oven produces reliable results each time. Upgrade your kitchen now and experience simple cooking with our dependable gadget.', 150, 'Sold'),
(27, 'Water Dispenser', 'uploads/hfswd-3100.jpg', 'Stay hydrated with our efficient Water Dispenser. This gadget can provide you with both calming hot drinks and refreshing cold water. Its elegant appearance and user-friendly features, including as changeable temperature settings and simple controls, let it to blend into any room. Say goodbye to the stress of refilling water bottles and welcome to simple hydration on demand. Upgrade your home or business with our dependable Water Dispenser and have pure, clean water anytime you need it.', 100, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `aID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `addOn` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`aID`, `title`, `fName`, `lName`, `email`, `date`, `addOn`, `timestamp`) VALUES
(384, 'Room B201', 'Arieldsdsd', 'Nazareno', 'nazarenoariel@yahoo.com', '2023-08-18', '', '2023-08-04 02:40:05');

--
-- Triggers `appointment`
--
DELIMITER $$
CREATE TRIGGER `tr_copy_appointment_to_toastnotif` AFTER INSERT ON `appointment` FOR EACH ROW BEGIN
    INSERT INTO toastnotif (aID, fName, lName, title, email, date, addOn, timestamp)
    VALUES (NEW.aID, NEW.fName, NEW.lName, NEW.title, NEW.email, NEW.date, NEW.addOn, NEW.timestamp);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `complete`
--

CREATE TABLE `complete` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `addOn` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complete`
--

INSERT INTO `complete` (`id`, `fName`, `lName`, `email`, `title`, `addOn`, `date`, `timestamp`) VALUES
(374, 'admin', '123', 'admin@gmail.com', 'Room A101', '', '2023-08-12', '2023-08-03 07:12:55'),
(375, 'Raiden', 'Shogun', 'ei@gmail.com', 'Room A101', '', '2023-08-18', '2023-08-03 07:55:12'),
(376, 'Genesis', 'Medina', 'a@b.com', 'Room A101', '', '2023-08-11', '2023-08-03 12:17:57'),
(378, 'Angel', 'Natividad', 'angel@gmail.com', 'Room A101', 'Aircon , Water Heater, Water Dispenser', '2023-08-04', '2023-08-03 13:22:31'),
(380, 'Genesis', 'Medina', 'c@g.com', 'Room B202', 'Refrigerator, Gas Range, Water Heater', '2023-08-12', '2023-08-03 14:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `ongoing`
--

CREATE TABLE `ongoing` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `addOn` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing`
--

INSERT INTO `ongoing` (`id`, `fName`, `lName`, `email`, `title`, `addOn`, `date`, `timestamp`) VALUES
(383, 'Arieldsdsd', 'Nazareno', 'nazarenoariel@yahoo.com', 'Room B201', '', '2023-08-15', '2023-08-04 02:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `rented`
--

CREATE TABLE `rented` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `pfPicture` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cPassword` varchar(255) NOT NULL,
  `addOn` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timeRented` timestamp NOT NULL DEFAULT current_timestamp(),
  `advancePayment` bigint(255) NOT NULL,
  `dateMoved` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rented`
--

INSERT INTO `rented` (`id`, `title`, `fName`, `lName`, `pfPicture`, `email`, `password`, `cPassword`, `addOn`, `timestamp`, `timeRented`, `advancePayment`, `dateMoved`) VALUES
(37, 'Room C301', 'Genesis', 'Medina', 'uploads/alhaitham-birthday-art-genshinimpact.jpg', 'a@b.com', '$2y$10$D96JcMQQw.eHb6Eg5Mehv.BO0ejs/SLH0l/S6A6gRQgzyRWr.mge2', '$2y$10$D96JcMQQw.eHb6Eg5Mehv.BO0ejs/SLH0l/S6A6gRQgzyRWr.mge2', 'Refrigerator, Gas Range', '2024-02-13 09:58:47', '2023-08-03 15:25:57', 2500, '2024-02-13'),
(38, 'Room A103', 'Raiden', 'Shogun', 'uploads/GenshinImpact_YaeMikoWallpaper4.jpg', 'miko@gmail.com', '$2y$10$HX8dcLYN349xC6q9MswipuA/LYyG63GLA8ATYCg/7a05JIg8i2roG', '$2y$10$HX8dcLYN349xC6q9MswipuA/LYyG63GLA8ATYCg/7a05JIg8i2roG', 'Refrigerator, Gas Range', '2024-02-13 09:59:15', '2023-08-03 15:31:59', 2800, '2024-02-13');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `star` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `fName`, `lName`, `star`, `content`) VALUES
(18, 'Raiden', 'Shogun', '3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nulla leo, elementum ac purus eu, mollis interdum diam. Praesent quis.'),
(19, 'Christian', 'Medina', '5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nulla leo, elementum ac purus eu, mollis interdum diam. Praesent quis.'),
(20, 'Angel', 'Natividad', '3', 'Ang ganda ganda ko hehe. I love you Jak Roberto heart heart'),
(21, 'Arieldsdsd', 'Nazareno', '2', 'cxcxcx');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `rID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `picture` longtext NOT NULL,
  `description` longtext NOT NULL,
  `roomSize` int(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `price` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`rID`, `title`, `picture`, `description`, `roomSize`, `status`, `price`) VALUES
(40, 'Room A103', 'uploads/3.jpg', 'Room A103 is a small place with basic furnishings, ideal for relaxation and concentrated work. Its neutral tones provide a relaxing and productive atmosphere. The room has comfy furniture, such as a soft chair and a large desk. During the day, wide windows let in natural light, which illuminates the room. It\'s a perfect location for solo efforts, with conveniences such as high-speed internet and a peaceful atmosphere. This room is available for rent and comfortably accommodates one person.', 1, 'Available', 2800),
(41, 'Room B201', 'uploads/4.jpg', 'Room B201 is a big and modern atmosphere that can easily accommodate three persons. It\'s ideal for both collaborative and solitary work, thanks to its elegant design and sufficient seats. Available for reserving now at a reasonable price of 3500. pesos', 3, 'Available', 3500),
(42, 'Room C301', 'uploads/5.jpeg', 'Room C301 provides a quiet and peaceful environment for one individual to work or rest peacefully. Its basic style and necessary conveniences provide a relaxing environment suited to concentration and work. Available for rental at a reasonable fee of 2500.', 1, 'Available', 2500),
(43, 'Room B202', 'uploads/6.jpeg', 'Room B202 provides a pleasant and beautiful setting designed just for one individual. Its elegant décor and basic conveniences create an ideal environment for concentrated work or leisure. Available for renting at a reasonable rate of 2800.', 1, 'Available', 2800),
(44, 'Room C302', 'uploads/7.jpeg', 'Room C302 provides a pleasant place for up to two people, with modern design and basic conveniences. It is ideal for team work or solo chores and creates an environment that promotes productivity. Available for rental at a reasonable price of 3000.', 2, 'Available', 3000),
(45, 'Room A104', 'uploads/8.jpg', 'Room A104 provides a pleasant and welcoming environment for one person, with comfortable furniture and basic design. It is ideal for concentrated work or leisure and includes all of the conveniences you need for a productive stay. Available for booking at a reasonable price of 2000.', 1, 'Available', 2000),
(46, 'Room B203', 'uploads/9.jpeg', 'Room B203 provides a comfortable and tranquil atmosphere for one person, with modern design and basic conveniences. It\'s ideal for concentrated work or leisure, and it creates a peaceful environment that encourages productivity. Available for booking at a reasonable price of 2000.', 1, 'Available', 2000),
(47, 'Room C303', 'uploads/10.jpg', 'Room C303 offers a spacious and comfortable environment for up to two people, with modern facilities and beautiful design. It is ideal for group work as well as solo chores, providing a productive setting. Available for hiring at a fair fee of 4000.', 2, 'Available', 4000),
(48, 'Room C304', 'uploads/2.jpg', 'Room C304 provides a spacious and welcoming environment for up to two people, complete with modern conveniences and beautiful design. It is ideal for team work or solo chores and creates an environment that promotes productivity. Available for renting at a low price of 3000.', 2, 'Available', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `toastnotif`
--

CREATE TABLE `toastnotif` (
  `toastID` int(11) NOT NULL,
  `aID` int(11) DEFAULT NULL,
  `fName` varchar(255) DEFAULT NULL,
  `lName` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `addOn` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `pfPicture` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cPassword` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `fName`, `lName`, `pfPicture`, `email`, `password`, `cPassword`, `timestamp`) VALUES
(1, 'admin', '123', '', 'admin@gmail.com', '$2y$10$evCiP99Bv2HQwY2IFaJdxuHb21R76iAGB9ibOAtEoedt7YIzXTedS', '$2y$10$evCiP99Bv2HQwY2IFaJdxuHb21R76iAGB9ibOAtEoedt7YIzXTedS', '2024-02-06 12:00:07'),
(101, 'Genesis', 'Medina', 'uploads/Eqic6LpUcAAQn0J.jpg', 'gen@gmail.com', '$2y$10$2S9ZX6BIOalMuf3byRNKcumoCvbcG/gVLnQCEjiuDhE6dIQN6iJrG', '$2y$10$2S9ZX6BIOalMuf3byRNKcumoCvbcG/gVLnQCEjiuDhE6dIQN6iJrG', '2024-02-06 12:04:39'),
(102, 'Arieldsdsd', 'Nazareno', 'uploads/E6tYdruXsAQrK-1.jpg', 'nazarenoariel@yahoo.com', '$2y$10$/5oEttk35mz5Cwrx5iENIu4ZxNnQGLKfumuU/k5ZMTjVNStdMJboe', '$2y$10$UZgCKNIuUpn4o7rzksmgGe/4/7yCN2jQ2h66DsQPOYoB9Wjsb640q', '2023-08-04 02:24:14'),
(103, 'Jose', 'Rizal', 'uploads/IMG_20230803_135530.jpg', 'joserizal@gmail.com', '$2y$10$AyXC5omeofeTmNubsmFv9uiVEbWlC0sjUydZ3btWbO39jWsA6WVr.', '$2y$10$AyXC5omeofeTmNubsmFv9uiVEbWlC0sjUydZ3btWbO39jWsA6WVr.', '2023-08-04 02:41:21');

--
-- Triggers `userinfo`
--
DELIMITER $$
CREATE TRIGGER `after_userinfo_delete` AFTER DELETE ON `userinfo` FOR EACH ROW BEGIN
    -- Delete the corresponding record from userinfocopy based on email
    DELETE FROM userinfocopy WHERE email = OLD.email;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `userinfo_after_insert` AFTER INSERT ON `userinfo` FOR EACH ROW BEGIN
    INSERT INTO userinfocopy (fName, lName, email, password, pfPicture, cPassword, timestamp)
    VALUES (NEW.fName, NEW.lName, NEW.email, NEW.password, NEW.pfPicture, NEW.cPassword, NEW.timestamp);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `userinfo_after_update` AFTER UPDATE ON `userinfo` FOR EACH ROW BEGIN
    -- Check if the password column has been updated
    IF NEW.password <> OLD.password THEN
        UPDATE userinfocopy
        SET password = NEW.password
        WHERE email = NEW.email;
    END IF;

    -- Check if any other columns (except id and password) have been updated
    IF NEW.fName <> OLD.fName OR
       NEW.lName <> OLD.lName OR
       NEW.email <> OLD.email OR
       NEW.pfPicture <> OLD.pfPicture OR
       NEW.cPassword <> OLD.cPassword OR
       NEW.timestamp <> OLD.timestamp THEN

        -- Update the other columns
        UPDATE userinfocopy
        SET
            fName = NEW.fName,
            lName = NEW.lName,
            email = NEW.email,
            pfPicture = NEW.pfPicture,
            cPassword = NEW.cPassword,
            timestamp = NEW.timestamp
        WHERE email = NEW.email;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `userinfocopy`
--

CREATE TABLE `userinfocopy` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) DEFAULT NULL,
  `lName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pfPicture` varchar(255) DEFAULT NULL,
  `cPassword` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfocopy`
--

INSERT INTO `userinfocopy` (`id`, `fName`, `lName`, `email`, `password`, `pfPicture`, `cPassword`, `timestamp`) VALUES
(42, 'Genesis', 'Medina', 'gen@gmail.com', '$2y$10$2S9ZX6BIOalMuf3byRNKcumoCvbcG/gVLnQCEjiuDhE6dIQN6iJrG', 'uploads/Eqic6LpUcAAQn0J.jpg', '$2y$10$2S9ZX6BIOalMuf3byRNKcumoCvbcG/gVLnQCEjiuDhE6dIQN6iJrG', '2024-02-06 12:04:39'),
(44, 'Jose', 'Rizal', 'joserizal@gmail.com', '$2y$10$AyXC5omeofeTmNubsmFv9uiVEbWlC0sjUydZ3btWbO39jWsA6WVr.', 'uploads/IMG_20230803_135530.jpg', '$2y$10$AyXC5omeofeTmNubsmFv9uiVEbWlC0sjUydZ3btWbO39jWsA6WVr.', '2023-08-04 02:41:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addson`
--
ALTER TABLE `addson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`aID`);

--
-- Indexes for table `complete`
--
ALTER TABLE `complete`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ongoing`
--
ALTER TABLE `ongoing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rented`
--
ALTER TABLE `rented`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`rID`);

--
-- Indexes for table `toastnotif`
--
ALTER TABLE `toastnotif`
  ADD PRIMARY KEY (`toastID`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfocopy`
--
ALTER TABLE `userinfocopy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addson`
--
ALTER TABLE `addson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `aID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=387;

--
-- AUTO_INCREMENT for table `complete`
--
ALTER TABLE `complete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=387;

--
-- AUTO_INCREMENT for table `ongoing`
--
ALTER TABLE `ongoing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=384;

--
-- AUTO_INCREMENT for table `rented`
--
ALTER TABLE `rented`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `rID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `toastnotif`
--
ALTER TABLE `toastnotif`
  MODIFY `toastID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `userinfocopy`
--
ALTER TABLE `userinfocopy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
