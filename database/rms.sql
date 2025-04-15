-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 15, 2025 at 08:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rms`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_details`
--

CREATE TABLE `billing_details` (
  `billing_id` int(10) NOT NULL,
  `member_id` int(15) NOT NULL,
  `Street_Address` varchar(100) NOT NULL,
  `P_O_Box_No` varchar(15) NOT NULL,
  `City` text NOT NULL,
  `Mobile_No` varchar(15) NOT NULL,
  `Landline_No` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `billing_details`
--

INSERT INTO `billing_details` (`billing_id`, `member_id`, `Street_Address`, `P_O_Box_No`, `City`, `Mobile_No`, `Landline_No`) VALUES
(8, 15, 'fagba,Lagos', '7502', 'Lagos', '08022233344', '013455678'),
(9, 16, 'Sample', '1231', 'Sample', '+123456', '+456 456 4623'),
(10, 17, '45', '200 - 0200', 'mombasa', '0789898989', '09987637'),
(11, 19, '3738', '200 - 0200', 'nairobi', '0789898989', '09987637');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `cart_id` int(15) NOT NULL,
  `member_id` int(15) NOT NULL,
  `lt` varchar(10) NOT NULL DEFAULT 'food',
  `food_id` int(15) NOT NULL,
  `quantity_id` int(15) NOT NULL,
  `total` float NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart_details`
--

INSERT INTO `cart_details` (`cart_id`, `member_id`, `lt`, `food_id`, `quantity_id`, `total`, `flag`) VALUES
(1, 15, 'food', 24, 34, 100, 1),
(2, 15, 'food', 25, 34, 200, 1),
(3, 15, 'food', 24, 35, 200, 1),
(4, 15, 'food', 24, 35, 200, 1),
(5, 15, 'food', 24, 34, 100, 1),
(6, 15, 'food', 25, 33, 1000, 1),
(7, 15, 'food', 24, 33, 500, 1),
(8, 15, 'food', 24, 33, 500, 1),
(9, 16, 'food', 24, 34, 100, 1),
(10, 16, 'food', 25, 34, 200, 1),
(14, 16, 'special', 8, 36, 1050, 1),
(17, 16, 'food', 24, 33, 500, 1),
(18, 17, 'food', 30, 33, 2500, 1),
(19, 17, 'food', 30, 33, 2500, 1),
(20, 17, 'special', 0, 33, 0, 0),
(21, 17, 'food', 30, 35, 1000, 1),
(22, 17, 'special', 0, 33, 0, 0),
(23, 17, 'food', 30, 33, 2500, 1),
(24, 17, 'food', 30, 34, 500, 1),
(25, 19, 'food', 30, 34, 500, 1),
(26, 17, 'special', 0, 34, 0, 0),
(27, 17, 'food', 30, 34, 500, 1),
(28, 17, 'special', 0, 34, 0, 0),
(29, 17, 'food', 30, 34, 500, 1),
(30, 17, 'special', 0, 34, 0, 0),
(31, 17, 'special', 0, 34, 0, 0),
(32, 17, 'special', 10, 34, 1000, 1),
(33, 17, 'special', 10, 34, 1000, 1),
(34, 17, 'special', 10, 34, 1000, 1),
(35, 17, 'food', 30, 37, 2000, 1),
(36, 17, 'special', 10, 34, 1000, 1),
(37, 17, 'food', 30, 34, 500, 1),
(38, 20, 'food', 31, 34, 600, 0),
(39, 17, 'special', 10, 34, 1000, 1),
(40, 17, 'food', 38, 34, 4500, 1),
(41, 17, 'food', 34, 34, 1500, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(15) NOT NULL,
  `category_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(17, 'Sample Category'),
(27, 'Breakfast'),
(28, 'lunch'),
(29, 'Dinner'),
(30, 'Desserts'),
(31, 'special deals'),
(32, 'snacks');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `currency_id` int(5) NOT NULL,
  `currency_symbol` varchar(15) NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currency_id`, `currency_symbol`, `flag`) VALUES
(7, 'KSH', 0),
(11, '$', 0);

-- --------------------------------------------------------

--
-- Table structure for table `food_details`
--

CREATE TABLE `food_details` (
  `food_id` int(15) NOT NULL,
  `food_name` varchar(45) NOT NULL,
  `food_description` text NOT NULL,
  `food_price` float NOT NULL,
  `food_photo` text NOT NULL,
  `food_category` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `food_details`
--

INSERT INTO `food_details` (`food_id`, `food_name`, `food_description`, `food_price`, `food_photo`, `food_category`) VALUES
(30, 'chicken wings', 'tastey chicken', 500, 'res.jpeg', 15),
(31, 'breakfast', 'enjoy', 600, '2.2.png', 25),
(32, 'ugari matumbo', 'tastey asf', 200, 'Aaccounts - Copy.png', 15),
(33, 'Nutera chocolate chip', 'nutera for you date', 780, 'nutera chocchip.jpg', 30),
(34, 'pipper steak', 'best for light lunch', 1500, 'pepper steak.jpg', 29),
(35, 'cajun sousage', 'Eat to your full every time you pass by', 2000, 'cajun sousage.jpg', 28),
(36, 'milkshake', 'milkshakes for you', 900, 'milkshake.jpg', 17),
(37, 'velvetstrawberry', 'cakes for you', 1050, 'dessertVelvetstrawberry.jpg', 30),
(38, 'ugari fish platter', 'supper for three', 4500, 'ugariFish.jpg', 31);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `question_id` int(5) NOT NULL,
  `answer` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `firstname`, `lastname`, `login`, `passwd`, `question_id`, `answer`) VALUES
(21, 'Kevin', 'kibe', 'kibe@gmail.com', 'd93591bdf7860e1e4ee2fca799911215', 8, 'e4a938ba9d2b880ac99f216a386cb422'),
(20, 'aunga', 'gekonge', 'gekongeaunga@gmail.com', '56ee8e134f369eafbae4d2f372a11714', 8, '1ebfd5913ef450b92b9e65b6de09acad'),
(17, 'larry', 'steven', 'larry@gmail.com', 'd8a427f5d61c5fe57ae869281bf3b7c9', 8, 'bf3a66a531e7b93155ce3eafac68e99d'),
(18, 'larry', 'steven', 'jarry@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 9, 'bf3a66a531e7b93155ce3eafac68e99d'),
(19, 'jeremiah', 'aunga', 'whaletech92@gmail.com', '20b54a672c078b1a51b9d31ba8e1d7ba', 9, 'aeaea0ec16e3ee7c6df2d4eb88941aa3'),
(22, 'jeremiah', 'steven', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 8, 'bf3a66a531e7b93155ce3eafac68e99d');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(15) NOT NULL,
  `message_from` varchar(25) NOT NULL,
  `message_date` date NOT NULL,
  `message_time` time NOT NULL,
  `message_subject` text NOT NULL,
  `message_text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `message_from`, `message_date`, `message_time`, `message_subject`, `message_text`) VALUES
(8, 'administrator', '2025-04-06', '14:28:39', 'sytem fairure', 'system dawntime');

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `order_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `billing_id` int(10) NOT NULL,
  `cart_id` int(15) NOT NULL,
  `delivery_date` date NOT NULL,
  `StaffID` int(15) NOT NULL,
  `flag` int(1) NOT NULL,
  `time_stamp` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`order_id`, `member_id`, `billing_id`, `cart_id`, `delivery_date`, `StaffID`, `flag`, `time_stamp`) VALUES
(25, 17, 10, 18, '2025-04-03', 1, 1, '18:22:42'),
(63, 17, 10, 41, '2025-04-07', 4, 0, '07:52:12'),
(62, 17, 10, 40, '2025-04-06', 4, 0, '21:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `partyhalls`
--

CREATE TABLE `partyhalls` (
  `partyhall_id` int(5) NOT NULL,
  `partyhall_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partyhalls`
--

INSERT INTO `partyhalls` (`partyhall_id`, `partyhall_name`) VALUES
(1, 'Conference'),
(2, 'Naming hall');

-- --------------------------------------------------------

--
-- Table structure for table `pizza_admin`
--

CREATE TABLE `pizza_admin` (
  `Admin_ID` int(45) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pizza_admin`
--

INSERT INTO `pizza_admin` (`Admin_ID`, `Username`, `Password`) VALUES
(3, 'admin', 'Whale7@g123');

-- --------------------------------------------------------

--
-- Table structure for table `polls_details`
--

CREATE TABLE `polls_details` (
  `poll_id` int(15) NOT NULL,
  `member_id` int(15) NOT NULL,
  `food_id` int(15) NOT NULL,
  `rate_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `polls_details`
--

INSERT INTO `polls_details` (`poll_id`, `member_id`, `food_id`, `rate_id`) VALUES
(25, 16, 24, 4),
(26, 16, 29, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quantities`
--

CREATE TABLE `quantities` (
  `quantity_id` int(5) NOT NULL,
  `quantity_value` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quantities`
--

INSERT INTO `quantities` (`quantity_id`, `quantity_value`) VALUES
(34, 1),
(35, 2),
(36, 3),
(37, 4),
(38, 6),
(39, 0),
(40, 9),
(41, 5),
(42, 7),
(43, 8),
(44, 10);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(5) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_text`) VALUES
(8, 'what is your maiden name?'),
(9, 'who is your first girlfriend?');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rate_id` int(5) NOT NULL,
  `rate_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rate_id`, `rate_name`) VALUES
(1, 'Excellent'),
(2, 'Good'),
(3, 'Average'),
(4, 'Bad'),
(5, 'Worse');

-- --------------------------------------------------------

--
-- Table structure for table `reservations_details`
--

CREATE TABLE `reservations_details` (
  `ReservationID` int(15) NOT NULL,
  `member_id` int(15) NOT NULL,
  `table_id` int(5) NOT NULL,
  `partyhall_id` int(5) NOT NULL,
  `Reserve_Date` date NOT NULL,
  `Reserve_Time` time NOT NULL,
  `StaffID` int(15) NOT NULL,
  `flag` int(1) NOT NULL,
  `table_flag` int(1) NOT NULL,
  `partyhall_flag` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reservations_details`
--

INSERT INTO `reservations_details` (`ReservationID`, `member_id`, `table_id`, `partyhall_id`, `Reserve_Date`, `Reserve_Time`, `StaffID`, `flag`, `table_flag`, `partyhall_flag`) VALUES
(46, 17, 16, 0, '2025-04-08', '11:55:00', 5, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `specials`
--

CREATE TABLE `specials` (
  `special_id` int(15) NOT NULL,
  `special_name` varchar(25) NOT NULL,
  `special_description` text NOT NULL,
  `special_price` float NOT NULL,
  `special_start_date` date NOT NULL,
  `special_end_date` date NOT NULL,
  `special_photo` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `specials`
--

INSERT INTO `specials` (`special_id`, `special_name`, `special_description`, `special_price`, `special_start_date`, `special_end_date`, `special_photo`) VALUES
(12, 'pilau samaki', 'enjoy samaki with pilau at discounted prices this week', 900, '2025-04-07', '2025-04-11', 'pilau samaki.jpg'),
(11, 'milkshake', 'milk shakes at your disposal', 250, '2025-04-07', '2025-04-08', 'milkshake.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(15) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `Street_Address` text NOT NULL,
  `Mobile_Tel` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `firstname`, `lastname`, `Street_Address`, `Mobile_Tel`) VALUES
(4, 'Tunde', 'Wale', 'Ibadan', '0901122334'),
(5, 'Sayo', 'Adegbola', 'Ibadan', '09022334455'),
(1, 'whale', 'whale', 'ruaka', '0799887766'),
(6, 'yvonne', 'bennedete', '67', '07998846338');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_id` int(5) NOT NULL,
  `table_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `table_name`) VALUES
(13, 'Vip'),
(14, 'Presidential'),
(16, 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `timezone_id` int(5) NOT NULL,
  `timezone_reference` varchar(45) NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`timezone_id`, `timezone_reference`, `flag`) VALUES
(1, 'GMT', 0),
(2, 'GMT-02', 0),
(3, '1', 0),
(4, '2', 0),
(5, '3', 0),
(6, 'GMT+08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` smallint(6) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing_details`
--
ALTER TABLE `billing_details`
  ADD PRIMARY KEY (`billing_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `food_details`
--
ALTER TABLE `food_details`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `partyhalls`
--
ALTER TABLE `partyhalls`
  ADD PRIMARY KEY (`partyhall_id`);

--
-- Indexes for table `pizza_admin`
--
ALTER TABLE `pizza_admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `polls_details`
--
ALTER TABLE `polls_details`
  ADD PRIMARY KEY (`poll_id`);

--
-- Indexes for table `quantities`
--
ALTER TABLE `quantities`
  ADD PRIMARY KEY (`quantity_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `reservations_details`
--
ALTER TABLE `reservations_details`
  ADD PRIMARY KEY (`ReservationID`);

--
-- Indexes for table `specials`
--
ALTER TABLE `specials`
  ADD PRIMARY KEY (`special_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`timezone_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing_details`
--
ALTER TABLE `billing_details`
  MODIFY `billing_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `cart_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `currency_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `food_details`
--
ALTER TABLE `food_details`
  MODIFY `food_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `partyhalls`
--
ALTER TABLE `partyhalls`
  MODIFY `partyhall_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pizza_admin`
--
ALTER TABLE `pizza_admin`
  MODIFY `Admin_ID` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `polls_details`
--
ALTER TABLE `polls_details`
  MODIFY `poll_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `quantities`
--
ALTER TABLE `quantities`
  MODIFY `quantity_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rate_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservations_details`
--
ALTER TABLE `reservations_details`
  MODIFY `ReservationID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `specials`
--
ALTER TABLE `specials`
  MODIFY `special_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `timezone_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
