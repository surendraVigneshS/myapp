-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 31, 2021 at 01:29 PM
-- Server version: 5.7.34-cll-lve
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freeztek_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ft_po_details`
--

CREATE TABLE `ft_po_details` (
  `po_details_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `po_product_id` int(11) NOT NULL,
  `po_product_name` varchar(250) NOT NULL,
  `po_product_qty` int(11) NOT NULL,
  `po_product_sub_amount` float NOT NULL,
  `po_product_disc_per` float DEFAULT NULL,
  `po_product_disc_amount` float DEFAULT NULL,
  `po_product_final_amount` float NOT NULL,
  `po_supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ft_po_details`
--
ALTER TABLE `ft_po_details`
  ADD PRIMARY KEY (`po_details_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ft_po_details`
--
ALTER TABLE `ft_po_details`
  MODIFY `po_details_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
