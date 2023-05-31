-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2023 at 12:46 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbms`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `INVENTORY_UPDATE_EXPIRATION_DATE` (`I_ID` INTEGER, `NEW_QTY` INTEGER, `PREV_QTY` INTEGER)   BEGIN
    DECLARE DIFF INTEGER;
    DECLARE O_ID INTEGER;
    DECLARE QNTY INTEGER;
    DECLARE TEMP INTEGER;
    DECLARE done INT DEFAULT FALSE;
    DECLARE C CURSOR FOR SELECT in_ord_id , o_amount FROM inventory_orders WHERE in_id = I_ID ORDER BY e_date ASC;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    SET DIFF = PREV_QTY - NEW_QTY;
    
    OPEN C;
    
    cursor_loop: LOOP
        FETCH C INTO O_ID, QNTY;
        IF (DIFF = 0) THEN
            LEAVE cursor_loop;
        END IF;
    
        IF (DIFF >= QNTY) THEN
            SET DIFF = DIFF - QNTY;
            DELETE FROM inventory_orders WHERE in_ord_id = O_ID;
        ELSE
            SET TEMP = QNTY - DIFF;
            SET DIFF = 0;
            UPDATE inventory_orders SET o_amount = TEMP WHERE in_ord_id = O_ID;
        END IF;
    END LOOP;
    CLOSE C;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MENU_COST_UPDATE_ING_AMOUNT_CHNG` (`M_ID` INTEGER, `I_ID` INTEGER, `NEW_QTY` INTEGER, `PREV_QTY` INTEGER)   BEGIN
    DECLARE NEW_COST INTEGER;
    DECLARE PREV_COST INTEGER;
    DECLARE PRICE INTEGER;
    SELECT menu_cost INTO PREV_COST FROM menu WHERE menu_id = M_ID; 
    SELECT in_price INTO PRICE FROM inventories WHERE in_id = I_ID;
	SET NEW_COST = (PREV_COST + ((NEW_QTY-PREV_QTY)*PRICE));
    UPDATE menu SET menu_cost=NEW_COST WHERE menu_id = M_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MENU_COST_UPDATE_ING_INSERT` (`M_ID` INTEGER, `I_ID` INTEGER, `QTY` INTEGER)   BEGIN
    DECLARE NEW_COST INTEGER;
    DECLARE PREV_COST INTEGER;
    DECLARE PRICE INTEGER;
    SELECT menu_cost INTO PREV_COST FROM menu WHERE menu_id = M_ID; 
    SELECT in_price INTO PRICE FROM inventories WHERE in_id = I_ID;
	SET NEW_COST = (PREV_COST + (QTY*PRICE));
    UPDATE menu SET menu_cost=NEW_COST WHERE menu_id = M_ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MENU_COST_UPDATE_ING_PRICE_CHNG` (`I_ID` INTEGER, `NEW_PRICE` INTEGER, `PREV_PRICE` INTEGER)   BEGIN
    DECLARE NEW_COST INTEGER;
    DECLARE PREV_COST INTEGER;
    DECLARE PRICE INTEGER;
	DECLARE M_ID INTEGER;
    DECLARE QTY INTEGER;
	DECLARE done INT DEFAULT FALSE;
	DECLARE C CURSOR FOR SELECT menu_id,ing_amount FROM ingredients WHERE in_id=I_ID;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	OPEN C;
	cursor_loop: LOOP
    	FETCH C INTO M_ID, QTY;
    	IF done THEN
        	LEAVE cursor_loop;
    	END IF;
		SELECT menu_cost INTO PREV_COST FROM menu WHERE menu_id = M_ID;
        SET PRICE = NEW_PRICE - PREV_PRICE;
		SET NEW_COST = (PREV_COST + (QTY*PRICE));
        UPDATE menu SET menu_cost=NEW_COST WHERE menu_id = M_ID;
	END LOOP; 
	CLOSE C;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `ASSIGN_ID` (`NAME` VARCHAR(50)) RETURNS VARCHAR(100) CHARSET utf8mb4  BEGIN
    DECLARE A_NAME VARCHAR(20);
    DECLARE A_YEAR VARCHAR(20);
    DECLARE A_MONTH VARCHAR(20);
    DECLARE A_DAY VARCHAR(20);
    DECLARE A_SEQ INTEGER;
    DECLARE A_SEQ_ID VARCHAR(20);
    DECLARE A_ID VARCHAR(100);
    DECLARE C_DATE DATE;
    SET A_SEQ = NEXTVAL(ACC_ID);
    SET A_SEQ_ID = LPAD(A_SEQ, 2, '0');
    SET C_DATE = CURDATE();
    SET A_NAME = UPPER(SUBSTRING(NAME, 1, 3));
    SET A_DAY = DATE_FORMAT(C_DATE, '%d');
    SET A_MONTH = DATE_FORMAT(C_DATE, '%m');
    SET A_YEAR = DATE_FORMAT(C_DATE, '%Y');
    SET A_ID = CONCAT(A_YEAR, A_MONTH, A_DAY, '_',A_NAME, '_', A_SEQ_ID);
    RETURN A_ID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `acc_id`
--

CREATE TABLE `acc_id` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `acc_id`
--

INSERT INTO `acc_id` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(21, 1, 99, 1, 1, 20, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `e_id` varchar(100) NOT NULL,
  `e_name` varchar(100) NOT NULL,
  `e_password` varchar(100) NOT NULL,
  `e_pfp` varchar(100) DEFAULT NULL,
  `e_dob` date NOT NULL,
  `e_address` varchar(100) NOT NULL,
  `e_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`e_id`, `e_name`, `e_password`, `e_pfp`, `e_dob`, `e_address`, `e_email`) VALUES
('20230526_NAZ_14', 'Nazmul Hossain', '$2y$10$IxEjYXRRr7VZ7U81wKnGz.7n1A4bHhmk2ndBdDQV3mdvCaws824M6', 'IMG-64773ab5be1a82.13295496.png', '2000-07-16', '220/A-220/D, Transparent Crown, Begum Rokeya Sharani, Shewrapara, West Kafrul, Dhaka-1207, 6-B', 'nazmulhossain@iut-dhaka.edu'),
('20230526_SHA_07', 'Shanta Maria', '$2y$10$zk/53H7w/tAWsqaBjhiuWeGnMIOFkgQaTxNvhj70G7oAU8PCkik.O', 'IMG-64773a49248306.62698258.png', '2001-03-24', 'Islamic University of Technology, Board Bazar, Gazipur, Dhaka-1704, South Hall', 'nazmul4532@gmail.com'),
('20230527_NAZ_30', 'Nazrul Islam', '$2y$10$PUyHwmMTWEyrlmVOOvNsMOFcf3Pp13aJ20spwVoXySBbsdCGXB4Q2', 'IMG-64773a562661d0.19413909.png', '1963-06-01', '220/A-220/D, Transparent Crown, Begum Rokeya Sharani, Shewrapara, West Kafrul, Dhaka-1207, 6-B', 'nislam3456@gmail.com'),
('20230529_MAR_65', 'Markooz IUT', '$2y$10$MG.WHRYlPnHFPPOkrK0Qu.4PXmRa4bw4SkGhHy6H3f4qfCiD4QAmO', 'IMG-64773a5eeebe18.98325261.png', '2023-01-05', '178/2-B, West Kafrul,Sher-E-Bangla Nagar, Agargaon, Taltola, Dhaka-1207', 'markooziut@gmail.com'),
('20230530_ENZ_87', 'EnzOrg', '$2y$10$GmS1BnrwcVOkq46BqVoLUOX2uLfBUjss7FezoQP.1tDkOAt5F40N.', 'IMG-64773a78438539.23176426.png', '2022-05-25', 'Islamic University of Technology, Board Bazar, Gazipur, Dhaka-1704, South Hall', 'enzorg4532@gmail.com'),
('20230530_JAH_88', 'Jahan Ara Negum', '$2y$10$vUkBnz.qr11W34j7AIMaJujXfjiFIBMMFlJlvd3yRAeUlnGcEB6fK', 'IMG-64773a7ec94840.59765832.png', '1970-09-29', '220/A-220/D, Transparent Crown, Begum Rokeya Sharani, Shewrapara, West Kafrul, Dhaka-1207, 6-B', 'jahanbegumbsa@gmail.com');

--
-- Triggers `employee`
--
DELIMITER $$
CREATE TRIGGER `AUTO_ASSIGN_ID` BEFORE INSERT ON `employee` FOR EACH ROW BEGIN
    SET NEW.e_id = ASSIGN_ID(NEW.e_name);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `menu_id` int(11) NOT NULL,
  `in_id` int(11) NOT NULL,
  `ing_amount` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`menu_id`, `in_id`, `ing_amount`) VALUES
(29, 34, 2),
(29, 35, 2),
(29, 38, 3),
(29, 39, 1),
(30, 35, 3),
(30, 39, 3),
(30, 42, 2),
(30, 44, 2),
(31, 35, 2),
(31, 38, 4),
(31, 44, 3),
(32, 34, 3),
(32, 35, 2),
(32, 39, 2),
(32, 44, 2);

--
-- Triggers `ingredients`
--
DELIMITER $$
CREATE TRIGGER `MENU_COST_UPDATE_ON_ING_INSERT` BEFORE INSERT ON `ingredients` FOR EACH ROW BEGIN
    CALL MENU_COST_UPDATE_ING_INSERT(NEW.menu_id, NEW.in_id, NEW.ing_amount); 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `MENU_COST_UPDATE_ON_ING_UPDATE` BEFORE UPDATE ON `ingredients` FOR EACH ROW BEGIN
    CALL MENU_COST_UPDATE_ING_AMOUNT_CHNG(OLD.menu_id, OLD.in_id, NEW.ing_amount, OLD.ing_amount); 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `in_id` int(11) NOT NULL,
  `in_name` varchar(100) NOT NULL,
  `in_amount` int(100) NOT NULL,
  `in_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`in_id`, `in_name`, `in_amount`, `in_price`) VALUES
(34, 'Milk', 2021, 10),
(35, 'Sugar', 7669, 5),
(38, 'Ground Coffee', 1711, 15),
(39, 'Cream', 2630, 20),
(40, 'Cake', 2718, 200),
(41, 'Cookies', 260, 50),
(42, 'Chocolate Syrup', 2618, 15),
(44, 'Fresh Coffee Beans', 871, 25),
(45, 'Beverages', 1760, 25);

--
-- Triggers `inventories`
--
DELIMITER $$
CREATE TRIGGER `INVENTORY_UPDATE_SELLING` BEFORE UPDATE ON `inventories` FOR EACH ROW BEGIN
    IF (NEW.in_amount<OLD.in_amount) THEN
    	CALL INVENTORY_UPDATE_EXPIRATION_DATE(OLD.in_id, NEW.in_amount, OLD.in_amount);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `MENU_COST_UPDATE_ON_ING_PRICE_CHNG` BEFORE UPDATE ON `inventories` FOR EACH ROW BEGIN
	IF NEW.in_price!=OLD.in_price THEN
    	CALL MENU_COST_UPDATE_ING_PRICE_CHNG(OLD.in_id, NEW.in_price, OLD.in_price); 
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_orders`
--

CREATE TABLE `inventory_orders` (
  `in_ord_id` int(11) NOT NULL,
  `in_id` int(11) NOT NULL,
  `o_amount` int(100) NOT NULL,
  `o_date` date NOT NULL,
  `e_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_orders`
--

INSERT INTO `inventory_orders` (`in_ord_id`, `in_id`, `o_amount`, `o_date`, `e_date`) VALUES
(80, 34, 161, '2023-05-31', '2023-06-09'),
(81, 34, 650, '2023-05-31', '2023-06-10'),
(82, 34, 1200, '2023-05-31', '2023-06-09'),
(83, 42, 1418, '2023-05-31', '2023-06-08'),
(84, 42, 1200, '2023-05-31', '2023-06-10'),
(85, 41, 250, '2023-05-31', '2023-06-08'),
(86, 40, 150, '2023-05-31', '2023-06-08'),
(87, 39, 1130, '2023-05-31', '2023-06-10'),
(88, 39, 1500, '2023-05-31', '2023-06-10'),
(90, 38, 650, '2023-05-31', '2023-06-10'),
(91, 38, 1011, '2023-05-31', '2023-06-09'),
(94, 35, 1169, '2023-05-31', '2023-06-10'),
(95, 40, 2500, '2023-05-31', '2023-06-22'),
(96, 35, 6500, '2023-05-31', '2023-06-21'),
(119, 44, 837, '2023-06-01', '2023-06-07'),
(122, 38, 25, '2023-06-01', '2023-06-15'),
(123, 45, 1500, '2023-06-01', '2023-06-17'),
(124, 45, 250, '2023-06-01', '2023-06-03'),
(126, 44, 5, '2023-06-01', '2023-06-03'),
(127, 41, 10, '2023-06-01', '2023-06-15'),
(128, 45, 10, '2023-06-01', '2023-06-15'),
(129, 44, 5, '2023-06-01', '2023-06-02'),
(133, 34, 10, '2023-06-01', '2023-06-10'),
(134, 38, 25, '2023-06-01', '2023-06-10'),
(135, 40, 68, '2023-06-01', '2023-06-24'),
(136, 44, 24, '2023-06-01', '2023-06-17');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `m_id` varchar(100) NOT NULL,
  `m_name` varchar(100) NOT NULL,
  `m_password` varchar(100) NOT NULL,
  `m_pfp` varchar(100) NOT NULL,
  `m_dob` date NOT NULL,
  `m_address` varchar(100) NOT NULL,
  `m_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`m_id`, `m_name`, `m_password`, `m_pfp`, `m_dob`, `m_address`, `m_email`) VALUES
('20230526_IUT_02', 'IUTea', '$2y$10$gAuSXk1jT.qfVslOsO/Pfe6x6w0JHMVVEC6B0tEC9v10URKivxkKm', 'IMG-6477913e7b1091.92440474.jpg', '2021-03-23', 'Islamic University of Technology, Board Bazar, Gazipur, Dhaka-1704', 'teaspillers4532@gmail.com');

--
-- Triggers `manager`
--
DELIMITER $$
CREATE TRIGGER `AUTO_ASSIGN_MANAGER_ID` BEFORE INSERT ON `manager` FOR EACH ROW BEGIN
    SET NEW.m_id = ASSIGN_ID(NEW.m_name);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_price` float NOT NULL,
  `menu_pfp` varchar(100) NOT NULL,
  `menu_cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_price`, `menu_pfp`, `menu_cost`) VALUES
(29, 'Capuccino', 200, 'IMG-64778fbec22bb1.69196263.png', 95),
(30, 'Latte', 300, 'IMG-6477aa5a875b77.63953783.jpg', 155),
(31, 'Espresso', 280, 'IMG-6477a970636a46.48295157.png', 145),
(32, 'Machiato', 250, 'IMG-6477aa649b3ea8.50182503.jpg', 130);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `n_id` int(11) NOT NULL,
  `n_desc` varchar(500) NOT NULL,
  `n_reason` varchar(100) NOT NULL,
  `n_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `c_name` varchar(100) NOT NULL,
  `c_number` varchar(100) NOT NULL,
  `total_price` bigint(20) NOT NULL,
  `total_cost` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `c_name`, `c_number`, `total_price`, `total_cost`) VALUES
(1, '2023-05-30', 'Nazmul Hossain', '01533974249', 12500, 0),
(2, '2023-05-31', 'Nazmul Hossain', '01533974249', 400, 115),
(3, '2023-05-31', 'Nazmul Hossain', '01713015432', 1400, 460),
(4, '2023-05-31', 'Shanta Maria', '01743969076', 18750, 5750),
(5, '2023-06-01', 'Shanta Maria', '01713015432', 2920, 1460),
(6, '2023-06-01', 'Nazrul Islam', '01727222896', 6250, 3100),
(7, '2023-06-01', 'Jahan Begum', '01758361968', 22930, 10345),
(8, '2023-06-01', 'Nafisa  Maliyat', '01533974249', 1600, 760),
(9, '2023-06-01', 'Ayesha Afroza', '01743969076', 14000, 6500),
(10, '2023-06-01', 'Nawsheen Mehreen', '01744562810', 3750, 1860),
(12, '2023-06-01', 'Rhidwan Rashid', '01584565958', 1910, 845),
(13, '2023-06-01', 'Mashrur Ahsan', '0153789456', 2090, 905),
(14, '2023-06-01', 'Mahfuz Anan', '0153445689', 2360, 1160),
(15, '2023-06-01', 'Jawadul Islam', '0153385625', 1150, 475),
(16, '2023-06-01', 'Nazmul Hossain', '123123123', 13550, 5875);

-- --------------------------------------------------------

--
-- Table structure for table `passwordreset`
--

CREATE TABLE `passwordreset` (
  `passwordResetID` int(11) NOT NULL,
  `passwordResetEmail` text NOT NULL,
  `passwordResetSelector` text NOT NULL,
  `passwordResetToken` longtext NOT NULL,
  `passwordResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`menu_id`,`in_id`),
  ADD KEY `in_id` (`in_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`in_id`);

--
-- Indexes for table `inventory_orders`
--
ALTER TABLE `inventory_orders`
  ADD PRIMARY KEY (`in_ord_id`),
  ADD KEY `in_id` (`in_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `passwordreset`
--
ALTER TABLE `passwordreset`
  ADD PRIMARY KEY (`passwordResetID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `in_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `inventory_orders`
--
ALTER TABLE `inventory_orders`
  MODIFY `in_ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `n_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `passwordreset`
--
ALTER TABLE `passwordreset`
  MODIFY `passwordResetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`),
  ADD CONSTRAINT `ingredients_ibfk_3` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`),
  ADD CONSTRAINT `ingredients_ibfk_4` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ingredients_ibfk_5` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ingredients_ibfk_6` FOREIGN KEY (`in_id`) REFERENCES `inventories` (`in_id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_orders`
--
ALTER TABLE `inventory_orders`
  ADD CONSTRAINT `inventory_orders_ibfk_1` FOREIGN KEY (`in_id`) REFERENCES `inventories` (`in_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
