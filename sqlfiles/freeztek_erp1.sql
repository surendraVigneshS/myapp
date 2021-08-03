-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2021 at 07:26 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `emp_id` int(10) UNSIGNED NOT NULL,
  `emp_no` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `emp_org` int(11) DEFAULT NULL,
  `emp_email` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_mobile` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `emp_password` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `emp_creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `emp_role` tinyint(4) NOT NULL,
  `team_leader` int(10) NOT NULL DEFAULT 0,
  `emp_dep_type` int(10) DEFAULT NULL,
  `last_logged_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `emp_status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`emp_id`, `emp_no`, `emp_org`, `emp_email`, `emp_name`, `emp_mobile`, `emp_password`, `emp_creation_date`, `emp_role`, `team_leader`, `emp_dep_type`, `last_logged_in`, `emp_status`) VALUES
(1, 'EMP-1234', 1, 'admin@g.com', 'Vencar Admin ', '6384825639', 'kQF0IZJJKdB0', '2021-03-25 12:57:20', 1, 0, 2, '2021-03-25 07:27:20', 1),
(2, 'EMP-1', 1, 'md@g.com', 'Prabhakaran', '9443311886', 'kQF0IZJJKdB0', '2021-04-19 01:55:16', 2, 0, 2, '2021-04-19 08:55:16', 1),
(3, 'EMP-2', 1, 'pl@g.com', 'SathisKumar', '6384825639', 'kQF0IZJJKdB0', '2021-04-19 01:57:14', 7, 0, 2, '2021-04-19 08:57:14', 1),
(37, 'EMP-2', 1, 'u@g.com', 'user', '6384825639', 'kQF0IZJJKdB0', '2021-04-19 01:57:14', 6, 38, 2, '2021-04-19 08:57:14', 1),
(38, 'EMP-2', 1, 'tl@g.com', 'teamlead', '6384825639', 'kQF0IZJJKdB0', '2021-04-19 01:57:14', 3, 0, 2, '2021-04-19 08:57:14', 1),
(39, 'EMP-2', 5, 'ol@g.com', 'teamlead', '6384825639', 'kQF0IZJJKdB0', '2021-04-19 01:57:14', 11, 0, 2, '2021-04-19 08:57:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `close_expenditure`
--

CREATE TABLE `close_expenditure` (
  `close_ID` int(11) NOT NULL,
  `org_name` varchar(250) DEFAULT NULL,
  `team_leader` int(11) DEFAULT NULL,
  `bill_no` varchar(100) DEFAULT NULL,
  `UTR_no` varchar(100) DEFAULT NULL,
  `upload_file` varchar(250) DEFAULT NULL,
  `approve_status` tinyint(4) DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `raised_by` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expenditures`
--

CREATE TABLE `expenditures` (
  `exp_id` int(11) NOT NULL,
  `exp_name` varchar(220) NOT NULL,
  `exp_amount` int(11) NOT NULL,
  `exp_credit` float DEFAULT NULL,
  `exp_credit_left` float DEFAULT NULL,
  `exp_files` varchar(100) DEFAULT NULL,
  `exp_created_by` int(11) NOT NULL,
  `exp_created_time` varchar(100) DEFAULT NULL,
  `exp_month` date DEFAULT NULL,
  `exp_approval_1` int(11) DEFAULT 0,
  `exp_approval1_time` varchar(100) DEFAULT NULL,
  `exp_approval1_by` int(11) DEFAULT NULL,
  `exp_approval_2` int(11) DEFAULT 0,
  `exp_approval2_time` varchar(100) DEFAULT NULL,
  `exp_approval2_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expenditure_amount`
--

CREATE TABLE `expenditure_amount` (
  `amount_ID` int(11) NOT NULL,
  `pay_id` int(11) DEFAULT NULL,
  `amount` varchar(100) NOT NULL,
  `rasisd_for` int(11) NOT NULL,
  `raised_date` datetime DEFAULT NULL,
  `total_credit` varchar(50) DEFAULT NULL,
  `closed_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expenditure_history`
--

CREATE TABLE `expenditure_history` (
  `sl_no` int(11) NOT NULL,
  `close_ID` int(11) NOT NULL,
  `aprrove_status` int(11) NOT NULL,
  `approve_status_text` varchar(100) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `approve_admin_role` int(11) NOT NULL,
  `approval_type` int(50) NOT NULL,
  `approval_type_text` varchar(100) NOT NULL,
  `approve_time` datetime NOT NULL,
  `history_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `followup_modes`
--

CREATE TABLE `followup_modes` (
  `id` int(11) NOT NULL,
  `follow_name` varchar(30) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `followup_modes`
--

INSERT INTO `followup_modes` (`id`, `follow_name`, `status`) VALUES
(1, 'Bill (Purchase Team )', 1),
(2, 'Advance (Accounts Team)', 1),
(3, 'Remainder (Remainder Team)', 1),
(4, 'Expenditure', 1),
(5, 'None of the above', 1);

-- --------------------------------------------------------

--
-- Table structure for table `followup_payments`
--

CREATE TABLE `followup_payments` (
  `id` int(11) NOT NULL,
  `pay_id` int(11) NOT NULL,
  `followup_raised_by` int(11) NOT NULL,
  `followup_type` int(11) NOT NULL COMMENT '1= purchase , 2 = accounts',
  `followup_status` int(11) NOT NULL DEFAULT 0,
  `followup_completed_time` varchar(220) NOT NULL,
  `followup_completed_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ft_allowances`
--

CREATE TABLE `ft_allowances` (
  `allowance_id` int(30) NOT NULL,
  `allowance` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_allowances`
--

INSERT INTO `ft_allowances` (`allowance_id`, `allowance`) VALUES
(1, 'House Rents'),
(2, 'surendar');

-- --------------------------------------------------------

--
-- Table structure for table `ft_dc`
--

CREATE TABLE `ft_dc` (
  `dc_id` int(11) NOT NULL,
  `dc_date` date NOT NULL,
  `dc_code` varchar(25) NOT NULL,
  `dc_short_code` int(11) NOT NULL,
  `dc_type` int(11) NOT NULL COMMENT '1=return,2=nonreturn,3=receipt',
  `dc_product_count` int(11) NOT NULL,
  `dc_issued_to` int(11) NOT NULL,
  `dc_issued_by` int(11) NOT NULL,
  `dc_issued_time` datetime NOT NULL,
  `dc_file` varchar(220) DEFAULT NULL,
  `dc_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_dc`
--

INSERT INTO `ft_dc` (`dc_id`, `dc_date`, `dc_code`, `dc_short_code`, `dc_type`, `dc_product_count`, `dc_issued_to`, `dc_issued_by`, `dc_issued_time`, `dc_file`, `dc_remarks`) VALUES
(1, '1984-07-06', 'GDCR/0001/21-22', 1, 1, 1, 9, 1, '2021-08-01 15:46:59', NULL, NULL),
(2, '1984-07-06', 'GDCR/0002/21-22', 2, 1, 1, 9, 1, '2021-08-01 15:49:27', NULL, NULL),
(3, '1984-07-06', 'GDCR/0003/21-22', 3, 1, 1, 9, 1, '2021-08-01 15:50:39', NULL, NULL),
(4, '1984-07-06', 'GDCR/0004/21-22', 4, 1, 1, 9, 1, '2021-08-01 15:51:23', NULL, NULL),
(5, '1984-07-06', 'GDCR/0005/21-22', 5, 1, 1, 9, 1, '2021-08-01 15:54:10', NULL, NULL),
(6, '1984-07-06', 'GDCR/0006/21-22', 6, 1, 1, 9, 1, '2021-08-01 15:54:19', NULL, NULL),
(7, '1984-07-06', 'GDCR/0007/21-22', 7, 1, 1, 9, 1, '2021-08-01 15:54:24', NULL, NULL),
(8, '1984-07-06', 'GDCR/0008/21-22', 8, 1, 1, 9, 1, '2021-08-01 15:54:38', NULL, NULL),
(9, '1984-07-06', 'GDCR/0009/21-22', 9, 1, 1, 9, 1, '2021-08-01 15:55:59', NULL, NULL),
(10, '1979-08-15', 'GDCNR/0010/21-22', 10, 2, 1, 3, 1, '2021-08-01 15:56:23', 'fec84_WhatsApp Image 2021-07-26 at 9.35.14 AM.jpeg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ft_dc_details`
--

CREATE TABLE `ft_dc_details` (
  `dc_details_id` int(11) NOT NULL,
  `dc_id` int(11) NOT NULL,
  `dc_product_id` int(11) NOT NULL,
  `dc_product_remarks` text DEFAULT NULL,
  `dc_issued_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_dc_details`
--

INSERT INTO `ft_dc_details` (`dc_details_id`, `dc_id`, `dc_product_id`, `dc_product_remarks`, `dc_issued_qty`) VALUES
(1, 2, 1, 'Voluptas obcaecati m', 80),
(2, 3, 1, 'Voluptas obcaecati m', 80),
(3, 4, 1, 'Voluptas obcaecati m', 80),
(4, 5, 1, 'Voluptas obcaecati m', 80),
(5, 6, 1, 'Voluptas obcaecati m', 80),
(6, 7, 1, 'Voluptas obcaecati m', 80),
(7, 8, 1, 'Voluptas obcaecati m', 80),
(8, 9, 1, 'Voluptas obcaecati m', 80),
(9, 10, 3, 'Nulla pariatur Reru', 270);

-- --------------------------------------------------------

--
-- Table structure for table `ft_deductions`
--

CREATE TABLE `ft_deductions` (
  `deduction_id` int(30) NOT NULL,
  `deduction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_deductions`
--

INSERT INTO `ft_deductions` (`deduction_id`, `deduction`) VALUES
(1, 'Advance Amount'),
(2, 'Sample Deduction'),
(3, 'sa'),
(4, 'asdsad'),
(5, 'checkingasd'),
(6, 'zdxtfcygvuhbijn');

-- --------------------------------------------------------

--
-- Table structure for table `ft_inward`
--

CREATE TABLE `ft_inward` (
  `pi_id` int(11) NOT NULL,
  `pi_po_id` int(11) NOT NULL,
  `pi_code` varchar(15) NOT NULL,
  `pi_short_code` int(11) NOT NULL,
  `pi_date` varchar(50) NOT NULL,
  `pi_product_count` int(11) NOT NULL,
  `pi_total_qty` int(11) NOT NULL,
  `pi_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=complete,2=partial',
  `pi_remarks` text DEFAULT NULL,
  `pi_created_by` int(11) NOT NULL,
  `pi_created_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_inward`
--

INSERT INTO `ft_inward` (`pi_id`, `pi_po_id`, `pi_code`, `pi_short_code`, `pi_date`, `pi_product_count`, `pi_total_qty`, `pi_status`, `pi_remarks`, `pi_created_by`, `pi_created_time`) VALUES
(1, 1, 'PIN/0001/21-22', 1, '2021-07-31', 1, 100, 2, 'sdasd', 37, '2021-07-31 15:10:59'),
(2, 2, 'PIN/0002/21-22', 2, '2021-07-31', 2, 45, 2, 'ghvjbkn', 37, '2021-07-31 15:48:28'),
(3, 4, 'PIN/0003/21-22', 3, '2021-07-31', 1, 45, 1, '', 37, '2021-07-31 16:18:14'),
(4, 5, 'PIN/0004/21-22', 4, '2021-07-31', 1, 450, 1, '', 1, '2021-07-31 23:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `ft_inward_details`
--

CREATE TABLE `ft_inward_details` (
  `pi_details_id` int(11) NOT NULL,
  `pi_id` int(11) NOT NULL,
  `pi_po_id` int(11) NOT NULL,
  `pi_product_id` int(11) NOT NULL,
  `pi_po_product_qty` int(11) NOT NULL,
  `pi_received_qty` int(11) DEFAULT NULL,
  `pi_pending_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_inward_details`
--

INSERT INTO `ft_inward_details` (`pi_details_id`, `pi_id`, `pi_po_id`, `pi_product_id`, `pi_po_product_qty`, `pi_received_qty`, `pi_pending_qty`) VALUES
(1, 1, 1, 1, 150, 100, 50),
(2, 2, 2, 1, 45, 45, 0),
(3, 2, 2, 1, 50, 0, 0),
(4, 3, 4, 1, 45, 45, 0),
(5, 4, 5, 3, 450, 450, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ft_item_group`
--

CREATE TABLE `ft_item_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `group_short_code` varchar(100) NOT NULL,
  `group_status` int(11) NOT NULL,
  `group_qr` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_item_group`
--

INSERT INTO `ft_item_group` (`group_id`, `group_name`, `group_short_code`, `group_status`, `group_qr`) VALUES
(1, 'S.S / M.S PLATE & PIPE', 'SS', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ft_po`
--

CREATE TABLE `ft_po` (
  `po_id` int(11) NOT NULL,
  `po_pr_id` int(11) DEFAULT NULL,
  `po_type` varchar(50) NOT NULL,
  `po_code` varchar(15) NOT NULL,
  `po_short_code` int(11) NOT NULL,
  `po_date` varchar(50) NOT NULL,
  `po_due_date` varchar(50) DEFAULT NULL,
  `po_supplier_id` int(11) NOT NULL,
  `po_product_count` int(11) NOT NULL,
  `po_product_type` varchar(70) NOT NULL,
  `po_additions_amount` float DEFAULT NULL,
  `po_total_amount` float NOT NULL,
  `po_final_amount` float NOT NULL,
  `amount_in_words` text DEFAULT NULL,
  `po_transport_mode` varchar(20) DEFAULT NULL,
  `po_transport_name` varchar(20) DEFAULT NULL,
  `po_file` text DEFAULT NULL COMMENT '/assets/pdf/purchase/',
  `po_file_attachment` varchar(200) DEFAULT NULL COMMENT '/assets/pdf/poattachment/',
  `po_qr_code` varchar(250) DEFAULT NULL,
  `po_remarks` text DEFAULT NULL,
  `po_created_by` int(11) NOT NULL,
  `po_updated_by` int(11) DEFAULT NULL,
  `po_created_time` datetime NOT NULL,
  `po_updated_time` datetime DEFAULT NULL,
  `po_terms` text DEFAULT NULL,
  `ft_bill_file` varchar(220) DEFAULT NULL,
  `created_from` int(11) NOT NULL DEFAULT 1 COMMENT '1=from po, 2 = from pr',
  `po_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=created,2=inward done,3=Transit,4=payment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_po`
--

INSERT INTO `ft_po` (`po_id`, `po_pr_id`, `po_type`, `po_code`, `po_short_code`, `po_date`, `po_due_date`, `po_supplier_id`, `po_product_count`, `po_product_type`, `po_additions_amount`, `po_total_amount`, `po_final_amount`, `amount_in_words`, `po_transport_mode`, `po_transport_name`, `po_file`, `po_file_attachment`, `po_qr_code`, `po_remarks`, `po_created_by`, `po_updated_by`, `po_created_time`, `po_updated_time`, `po_terms`, `ft_bill_file`, `created_from`, `po_status`) VALUES
(1, NULL, 'Purchase Order', 'PO/0001/21-22', 1, '2021-07-31', NULL, 12, 1, 'Capital Goods', 0, 675000, 675000, 'Six Hundred Seventy Five Thousand  Rupees ', NULL, NULL, '10713992022095809_BAKER ALEXANDERSDAF.pdf', NULL, '61051a8972ecb.png', '', 37, NULL, '2021-07-31 15:10:25', NULL, NULL, NULL, 1, 2),
(2, 7, 'Purchase Order', 'PO/0002/21-22', 2, '2021-07-31', NULL, 12, 2, 'Capital Goods', 7245, 40250, 47495, 'Forty Seven Thousand Four Hundred Ninety Five Rupees ', NULL, NULL, '10713994241352535_BAKER ALEXANDERSDAF.pdf', NULL, '610522cd80dcb.png', '', 37, NULL, '2021-07-31 15:45:41', NULL, NULL, NULL, 2, 2),
(3, NULL, 'Job Order', 'JO/0003/21-22', 3, '2004-08-13', NULL, 8, 1, 'Tools & Dies', 0, 240000, 240000, 'Two Hundred Forty   Thousand  Rupees ', NULL, NULL, '10713995470083940_DAFDSGF.pdf', NULL, '610527617fff1.png', 'Amet consectetur o', 37, NULL, '2021-07-31 16:05:13', NULL, NULL, NULL, 1, 1),
(4, NULL, 'Purchase Order', 'PO/0004/21-22', 4, '2021-07-31', NULL, 12, 1, 'Capital Goods', 0, 22500, 22500, 'Twenty Two Thousand Five Hundred    Rupees ', NULL, NULL, '10713996275222408_BAKER ALEXANDERSDAF.pdf', NULL, '61052a6154ca9.png', '', 37, NULL, '2021-07-31 16:18:01', NULL, NULL, NULL, 1, 2),
(5, NULL, 'Purchase Order', 'PO/0005/21-22', 5, '2021-07-31', NULL, 12, 1, 'Capital Goods', 0, 38250000, 38250000, 'Thirty Eight Million Two Hundred Fifty   Thousand  Rupees ', NULL, NULL, '10714023048690494_BAKER ALEXANDERSDAF.pdf', NULL, '61058e1e91760.png', 'dsafsvfd', 1, NULL, '2021-07-31 23:23:34', NULL, NULL, NULL, 1, 2),
(6, NULL, 'Job Order', 'JO/0006/21-22', 6, '1976-06-29', NULL, 8, 1, 'Tools & Dies', 0, 32385, 32385, 'Thirty Two Thousand Three Hundred Eighty Five Rupees ', NULL, NULL, '10714024892046047_DAFDSGF.pdf', NULL, '610594fc6b710.png', 'Quidem quisquam arch', 1, NULL, '2021-07-31 23:52:52', NULL, NULL, NULL, 1, 1),
(7, NULL, 'Purchase Order', 'PO/0007/21-22', 7, '2021-08-01', NULL, 12, 1, 'Capital Goods', 0, 170000, 170000, 'One Hundred Seventy   Thousand  Rupees ', NULL, NULL, '10714026000034517_BAKER ALEXANDERSDAF.pdf', NULL, '6105991d092de.png', '', 1, NULL, '2021-08-01 00:10:28', NULL, NULL, NULL, 1, 1),
(8, NULL, 'Job Order', 'JO/0008/21-22', 8, '2013-01-02', NULL, 11, 1, 'Packaging Materials', 0, 8437.44, 8437.44, 'Eight Thousand Four Hundred Thirty Seven Rupees  and Forty Four paise', 'gjhb,m.', '', '10714027088584099_SJAKD.pdf', NULL, '61059d2b6984d.png', 'Voluptates irure eos', 1, NULL, '2021-08-01 00:27:47', NULL, NULL, NULL, 1, 1),
(9, NULL, 'Purchase Order', 'PO/0009/21-22', 9, '2010-09-19', NULL, 6, 1, 'Raw Material', 0, 16650, 16650, 'Sixteen Thousand Six Hundred Fifty   Rupees ', ' ghhn', 'Justine Bartlett', '10714027133263621_DAFDSGF.pdf', NULL, '61059d560ab3b.png', 'Ut officiis exercita', 1, NULL, '2021-08-01 00:28:29', NULL, NULL, NULL, 1, 1),
(10, 7, 'Purchase Order', 'PO/0010/21-22', 10, '2021-08-01', NULL, 12, 1, 'Capital Goods', 0, 202500, 202500, 'Two Hundred  Two Thousand Five Hundred    Rupees ', ' ghhn', '', '10714027646960368_BAKER ALEXANDERSDAF.pdf', NULL, '61059f3fe0595.png', '', 1, NULL, '2021-08-01 00:36:39', NULL, NULL, NULL, 2, 1),
(11, NULL, 'Purchase Order', 'PO/0011/21-22', 11, '2021-08-01', NULL, 12, 1, 'Capital Goods', 0, 170000, 170000, 'One Hundred Seventy   Thousand  Rupees ', ' ghhn', 'gvhb', '10714062789430506_BAKER ALEXANDERSDAF.pdf', NULL, '6106222a5547a.png', '', 1, NULL, '2021-08-01 09:55:14', NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ft_po_add_details`
--

CREATE TABLE `ft_po_add_details` (
  `po_add_id` int(11) NOT NULL,
  `po_add_po_id` int(11) NOT NULL,
  `po_add_type` int(11) NOT NULL COMMENT '1=tax,2=add,3=deduction',
  `po_add_name` varchar(100) NOT NULL,
  `po_add_per` float DEFAULT NULL,
  `po_add_amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_po_add_details`
--

INSERT INTO `ft_po_add_details` (`po_add_id`, `po_add_po_id`, `po_add_type`, `po_add_name`, `po_add_per`, `po_add_amount`) VALUES
(1, 2, 1, ' CGST 18%', 18, 7245);

-- --------------------------------------------------------

--
-- Table structure for table `ft_po_details`
--

CREATE TABLE `ft_po_details` (
  `po_details_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `po_product_id` int(11) NOT NULL,
  `po_product_name` varchar(250) NOT NULL,
  `po_product_desc` text DEFAULT NULL,
  `po_product_qty` int(11) NOT NULL,
  `po_product_sub_amount` float NOT NULL,
  `po_product_disc_per` float DEFAULT NULL,
  `po_product_disc_amount` float DEFAULT NULL,
  `po_product_final_amount` float NOT NULL,
  `po_supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_po_details`
--

INSERT INTO `ft_po_details` (`po_details_id`, `po_id`, `po_product_id`, `po_product_name`, `po_product_desc`, `po_product_qty`, `po_product_sub_amount`, `po_product_disc_per`, `po_product_disc_amount`, `po_product_final_amount`, `po_supplier_id`) VALUES
(1, 1, 1, 'Demo Product', '', 150, 4500, 0, 0, 675000, 12),
(2, 2, 1, 'Demo Product', '', 45, 450, 0, 0, 20250, 12),
(3, 2, 1, 'demo product2', '', 50, 400, 0, 0, 20000, 12),
(4, 3, 1, 'Demo Product', 'Impedit eum amet u', 481, 500, 99.7921, 500, 240000, 8),
(5, 4, 1, 'last product', '', 45, 500, 0, 0, 22500, 12),
(6, 5, 3, 'last product', '', 450, 85000, 0, 0, 38250000, 12),
(7, 6, 3, 'last product', 'Officia sed molestia', 381, 85, 0, 0, 32385, 8),
(8, 7, 3, 'last product', '', 2, 85000, 0, 0, 170000, 12),
(9, 8, 1, 'Demo Product', 'Rerum animi commodo', 136, 66, 6, 538.56, 8437.44, 11),
(10, 9, 2, 'demo product2', 'Quod rem dolore arch', 37, 450, 100, 0, 16650, 6),
(11, 10, 1, 'Demo Product', '', 450, 450, 0, 0, 202500, 12),
(12, 11, 3, 'last product', '', 2, 85000, 0, 0, 170000, 12);

-- --------------------------------------------------------

--
-- Table structure for table `ft_po_status`
--

CREATE TABLE `ft_po_status` (
  `status_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `po_status_text` varchar(220) NOT NULL,
  `po_status` int(11) NOT NULL,
  `status_added_by` int(11) NOT NULL,
  `status_added_time` datetime NOT NULL,
  `overall_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_po_status`
--

INSERT INTO `ft_po_status` (`status_id`, `po_id`, `po_status_text`, `po_status`, `status_added_by`, `status_added_time`, `overall_status`) VALUES
(1, 6, 'PO Created', 1, 1, '2021-07-31 23:52:52', 1),
(2, 7, 'PO Created', 1, 1, '2021-08-01 00:10:28', 1),
(3, 8, 'PO Created', 1, 1, '2021-08-01 00:27:47', 1),
(4, 9, 'PO Created', 1, 1, '2021-08-01 00:28:29', 1),
(5, 10, 'PO Created', 1, 1, '2021-08-01 00:36:39', 1),
(6, 11, 'PO Created', 1, 1, '2021-08-01 09:55:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ft_po_terms`
--

CREATE TABLE `ft_po_terms` (
  `sl_no` int(11) NOT NULL,
  `ft_terms_po_id` int(11) NOT NULL,
  `ft_terms_id` int(11) NOT NULL,
  `ft_terms_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_po_terms`
--

INSERT INTO `ft_po_terms` (`sl_no`, `ft_terms_po_id`, `ft_terms_id`, `ft_terms_content`) VALUES
(1, 1, 2, ''),
(2, 2, 3, 'gyhjk'),
(3, 3, 2, 'Proident ipsa qui '),
(4, 4, 2, ''),
(5, 5, 3, 'dSAFSFBDGF'),
(6, 6, 2, 'Praesentium consequa'),
(7, 7, 3, 'jlk'),
(8, 7, 3, ';lk'),
(9, 8, 2, 'Voluptate soluta fug'),
(10, 9, 2, 'Aut labore id aut ne'),
(11, 10, 2, ''),
(12, 11, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `ft_product_details`
--

CREATE TABLE `ft_product_details` (
  `details_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `details_amount` float DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `purc_dt_id` int(11) DEFAULT NULL,
  `quo_file` varchar(250) DEFAULT NULL COMMENT '/assets/quotations/',
  `quo_created_by` int(11) DEFAULT NULL,
  `quo_created_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_product_details`
--

INSERT INTO `ft_product_details` (`details_id`, `product_id`, `details_amount`, `supplier_id`, `purc_dt_id`, `quo_file`, `quo_created_by`, `quo_created_time`) VALUES
(1, 2, 4000, 12, NULL, '', 37, '2021-07-31 15:16:54'),
(2, 2, 500, 8, NULL, '', 37, '2021-07-31 15:16:54'),
(3, 2, 450, 6, NULL, '', 37, '2021-07-31 15:16:54'),
(4, 1, 85000, 12, NULL, '70159_WhatsApp Image 2021-07-26 at 9.35.14 AM.jpeg', 37, '2021-07-31 16:11:18'),
(5, 3, 45000, 6, NULL, '70159_WhatsApp Image 2021-07-26 at 9.35.14 AM.jpeg', 37, '2021-07-31 16:11:18'),
(6, 3, 1200, 7, NULL, '70159_WhatsApp Image 2021-07-26 at 9.35.14 AM.jpeg', 37, '2021-07-31 16:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `ft_product_master`
--

CREATE TABLE `ft_product_master` (
  `product_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_shortcode` int(11) DEFAULT NULL,
  `product_group` int(11) NOT NULL,
  `product_name` varchar(250) DEFAULT NULL,
  `product_specification` varchar(250) DEFAULT NULL,
  `product_unit` varchar(100) DEFAULT NULL,
  `product_type` varchar(100) DEFAULT NULL,
  `min_qty` int(11) DEFAULT NULL,
  `max_qty` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `product_qr` text NOT NULL COMMENT 'assets/qr/product',
  `product_image` varchar(250) DEFAULT NULL COMMENT 'assets/images/product',
  `product_consumable` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1=active,2=inactive',
  `product_remarks` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_product_master`
--

INSERT INTO `ft_product_master` (`product_id`, `project_id`, `product_code`, `product_shortcode`, `product_group`, `product_name`, `product_specification`, `product_unit`, `product_type`, `min_qty`, `max_qty`, `location_id`, `product_qr`, `product_image`, `product_consumable`, `status`, `product_remarks`, `created_by`, `created_time`) VALUES
(1, NULL, 'SS-001', 1, 1, 'Demo Product', '4x4', 'Kg', 'Purchase Item', 20, 200, NULL, '6104dd99a2f2e.png', 'd8885_WhatsApp Image 2021-07-26 at 9.35.14 AM.jpeg', 'Yes', 1, 'dsasd', 37, '2021-07-31 10:50:25'),
(2, NULL, 'SS-002', 2, 1, 'demo product2', 'sdas', 'Kg', 'Purchase Item', 40, 450, NULL, '61051c0e6ee29.png', NULL, 'Yes', 1, '', 37, '2021-07-31 15:16:54'),
(3, NULL, 'SS-003', 3, 1, 'last product', 'hj', 'Kg', 'Purchase Item', 10, 20, NULL, '610528ce6aa93.png', '70159_WhatsApp Image 2021-07-26 at 9.35.14 AM.jpeg', 'No', 1, 'ghvjb', 37, '2021-07-31 16:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `ft_projects_tb`
--

CREATE TABLE `ft_projects_tb` (
  `project_id` int(11) NOT NULL,
  `project_title` varchar(250) NOT NULL,
  `project_incharge` int(11) NOT NULL,
  `project_date` date DEFAULT NULL,
  `project_target_date` date DEFAULT NULL,
  `items_count` int(11) DEFAULT NULL,
  `project_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=created',
  `created_by` int(11) NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `added_from` int(11) NOT NULL DEFAULT 1 COMMENT '1=project,2=purcharse_req'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_projects_tb`
--

INSERT INTO `ft_projects_tb` (`project_id`, `project_title`, `project_incharge`, `project_date`, `project_target_date`, `items_count`, `project_status`, `created_by`, `created_time`, `added_from`) VALUES
(1, 'Demo Project', 3, '2021-07-31', '2021-07-31', 1, 1, 37, '2021-07-31 10:48:06', 1),
(2, 'demo 2', 2, '2021-07-31', '2021-07-31', 2, 1, 37, '2021-07-31 15:17:54', 1),
(3, 'demo project3', 0, NULL, NULL, 1, 1, 37, '2021-07-31 15:35:15', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ft_project_details`
--

CREATE TABLE `ft_project_details` (
  `project_deatils_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_product_id` int(11) NOT NULL,
  `project_product_qty` int(11) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `added_time` datetime DEFAULT NULL,
  `project_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=active,0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_project_details`
--

INSERT INTO `ft_project_details` (`project_deatils_id`, `project_id`, `project_product_id`, `project_product_qty`, `added_by`, `added_time`, `project_status`) VALUES
(1, 1, 1, 40, 37, '2021-07-31 10:50:25', 1),
(2, 2, 2, 100, 37, '2021-07-31 15:17:54', 1),
(3, 2, 1, 100, 37, '2021-07-31 15:17:54', 1),
(4, 3, 3, 150, 37, '2021-07-31 16:11:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ft_quotation_table`
--

CREATE TABLE `ft_quotation_table` (
  `quo_id` int(11) NOT NULL,
  `quo_purchase_id` int(11) DEFAULT NULL,
  `quo_product_id` int(11) DEFAULT NULL,
  `quo_file` varchar(250) NOT NULL,
  `quo_created_by` int(11) NOT NULL,
  `quo_created_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_quotation_table`
--

INSERT INTO `ft_quotation_table` (`quo_id`, `quo_purchase_id`, `quo_product_id`, `quo_file`, `quo_created_by`, `quo_created_time`) VALUES
(1, NULL, 1, 'ea8e9_WhatsApp Image 2021-07-26 at 9.35.14 AM.jpeg', 1, '2021-07-26 11:00:35'),
(2, NULL, 1, 'a1da1_WhatsApp_Image_2021-07-19_at_4.12.43_PM-removebg (1).png', 1, '2021-07-26 11:00:35'),
(3, NULL, 1, '4f381_WhatsApp_Image_2021-07-19_at_4.12.43_PM-removebg.png', 1, '2021-07-26 12:56:10'),
(4, NULL, 1, 'c8a2f_WhatsApp Image 2021-07-19 at 4.12.43 PM.jpeg', 1, '2021-07-26 12:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `ft_stock_master`
--

CREATE TABLE `ft_stock_master` (
  `stock_id` int(11) NOT NULL,
  `product_group` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_issued_qty` int(11) DEFAULT NULL,
  `product_current_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_stock_master`
--

INSERT INTO `ft_stock_master` (`stock_id`, `product_group`, `product_id`, `product_issued_qty`, `product_current_qty`) VALUES
(1, 1, 1, 80, -40),
(8, 1, 3, 270, 180);

-- --------------------------------------------------------

--
-- Table structure for table `ft_store_room`
--

CREATE TABLE `ft_store_room` (
  `store_id` int(11) NOT NULL,
  `store_name` varchar(250) NOT NULL,
  `store_qr` text NOT NULL,
  `store_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=active,0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_store_room`
--

INSERT INTO `ft_store_room` (`store_id`, `store_name`, `store_qr`, `store_status`) VALUES
(1, 'Kennedy Ball', '60f854da4cad1.png', 0),
(4, 'Irma Osborne', '60f854da4cad1.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ft_tax`
--

CREATE TABLE `ft_tax` (
  `tax_id` int(11) NOT NULL,
  `tax_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_tax`
--

INSERT INTO `ft_tax` (`tax_id`, `tax_name`) VALUES
(1, 'cgst 10%'),
(2, 'CGST 18%'),
(3, 'fsagdsfndgf'),
(4, 'IGST 18%');

-- --------------------------------------------------------

--
-- Table structure for table `ft_terms`
--

CREATE TABLE `ft_terms` (
  `terms_id` int(11) NOT NULL,
  `terms_heading` varchar(250) NOT NULL,
  `terms_remarks` text NOT NULL,
  `terms_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_terms`
--

INSERT INTO `ft_terms` (`terms_id`, `terms_heading`, `terms_remarks`, `terms_status`) VALUES
(1, 'adsd', 'asdnaskdnsa das,mdnalksdnlasdad d\\asdasd\r\nasd\r\nasdasd\r\nasdasd\r\nasd\r\nasda\r\nsdasdasdasdda', 0),
(2, 'Minerva Anderson', 'asdasdsad\'asdasd\'asdasdsadasd dasd asd\r\nsdas d asd as dasdasd a sd ad asd asd asd asd', 1),
(3, 'Delivery', 'checking delivery Terms', 1),
(4, 'payment ', 'akjd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ft_transport_mode`
--

CREATE TABLE `ft_transport_mode` (
  `transport_id` int(11) NOT NULL,
  `transport_mode` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_transport_mode`
--

INSERT INTO `ft_transport_mode` (`transport_id`, `transport_mode`) VALUES
(1, ' ghhn'),
(2, 'gjhb,m.');

-- --------------------------------------------------------

--
-- Table structure for table `ft_uom`
--

CREATE TABLE `ft_uom` (
  `uom_id` int(11) NOT NULL,
  `uom_name` varchar(150) NOT NULL,
  `uom_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ft_uom`
--

INSERT INTO `ft_uom` (`uom_id`, `uom_name`, `uom_status`) VALUES
(1, 'Kg', 1),
(2, 'Nos', 1),
(3, 'ML\r\n', 1),
(4, 'Minerva Anderson', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `sl_no` int(10) NOT NULL,
  `pay_id` int(10) NOT NULL,
  `pay_code` varchar(250) DEFAULT NULL,
  `message_content` varchar(1000) DEFAULT NULL,
  `trigger_from` int(10) DEFAULT NULL,
  `trigger_from_time` datetime DEFAULT current_timestamp(),
  `trigger_to` int(10) DEFAULT NULL,
  `trigger_to_time` datetime DEFAULT current_timestamp(),
  `sender` int(10) DEFAULT NULL,
  `reply` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `organization_name` varchar(150) NOT NULL,
  `org_address` text DEFAULT NULL,
  `org_flow` int(11) DEFAULT 0,
  `org_color` varchar(10) DEFAULT NULL,
  `first_approval` tinyint(4) DEFAULT NULL,
  `orglead_approval` tinyint(4) DEFAULT NULL,
  `second_approval` tinyint(4) DEFAULT NULL,
  `third_approval` tinyint(4) DEFAULT NULL,
  `fourth_apporval` tinyint(4) DEFAULT NULL,
  `purchase_orglead_approval` tinyint(4) DEFAULT NULL,
  `purchase_fisrt_approval` tinyint(4) DEFAULT NULL,
  `purchase_second_approval` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `organization_name`, `org_address`, `org_flow`, `org_color`, `first_approval`, `orglead_approval`, `second_approval`, `third_approval`, `fourth_apporval`, `purchase_orglead_approval`, `purchase_fisrt_approval`, `purchase_second_approval`, `status`) VALUES
(1, 'SVCGPL', NULL, 0, '#000000', 1, 0, 1, 1, 1, 0, 1, 1, 1),
(2, 'Agem', NULL, 0, '#0000ff', 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 'Other', NULL, 0, '#ff4500', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, ' Super Gas CO', NULL, 0, '#ca0202', 1, 1, 1, 1, 1, 1, 1, 1, 1),
(5, 'Freeze Tech', NULL, 0, '#ff0000', 1, 1, 1, 1, 1, 1, 1, 1, 1),
(6, 'Swathi air products', NULL, 0, '#ff0ad6', 1, 0, 1, 1, 1, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `sl_no` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `aprrove_status` int(11) NOT NULL,
  `approve_status_text` varchar(100) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `approve_admin_role` int(11) NOT NULL,
  `approval_type` int(50) NOT NULL,
  `approval_type_text` varchar(100) NOT NULL,
  `approve_time` datetime NOT NULL,
  `history_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`sl_no`, `payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`, `approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES
(1, 1, 1, 'Approved', 1, 1, 2, 'Second Approval', '2021-07-20 16:39:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_pdf`
--

CREATE TABLE `payment_pdf` (
  `id` int(10) NOT NULL,
  `pay_id` int(11) NOT NULL,
  `pay_code` varchar(200) DEFAULT NULL,
  `uploaded_type` varchar(100) NOT NULL,
  `po_filename` varchar(250) DEFAULT NULL,
  `uploaded_by` tinyint(4) NOT NULL,
  `uploaded_time` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` varchar(100) NOT NULL,
  `advance_amount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_pdf`
--

INSERT INTO `payment_pdf` (`id`, `pay_id`, `pay_code`, `uploaded_type`, `po_filename`, `uploaded_by`, `uploaded_time`, `total_amount`, `advance_amount`) VALUES
(1, 1, 'PAY-7837202', 'Bill', NULL, 1, '2021-07-20 16:39:36', 'Eius volu', '0');

-- --------------------------------------------------------

--
-- Table structure for table `payment_request`
--

CREATE TABLE `payment_request` (
  `pay_id` int(11) NOT NULL,
  `pay_code` varchar(200) NOT NULL,
  `team_leader` int(10) DEFAULT NULL,
  `incharge_name` varchar(250) NOT NULL,
  `company_name` varchar(250) NOT NULL,
  `org_name` varchar(250) DEFAULT NULL,
  `project_title` varchar(250) DEFAULT NULL,
  `bill_no` varchar(240) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `po_no` varchar(250) DEFAULT NULL,
  `amount` float NOT NULL,
  `advanced_amonut` varchar(10) NOT NULL,
  `advance_step` int(11) NOT NULL DEFAULT 0,
  `balance_amount` varchar(10) NOT NULL,
  `amount_words` text NOT NULL,
  `payment_type` varchar(250) NOT NULL,
  `payment_against` varchar(250) NOT NULL,
  `gst` tinyint(4) NOT NULL,
  `gst_no` varchar(100) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `po_file` varchar(250) DEFAULT NULL,
  `supplier_mobile` varchar(12) NOT NULL,
  `supplier_mail` varchar(250) NOT NULL,
  `supplier_branch` varchar(250) DEFAULT NULL,
  `acc_no` varchar(250) DEFAULT NULL,
  `ifsc_code` varchar(250) DEFAULT NULL,
  `utr_no` varchar(100) DEFAULT NULL,
  `acc_po` varchar(100) DEFAULT NULL,
  `user_cancel` tinyint(4) DEFAULT 0,
  `user_cancel_by` int(10) DEFAULT NULL,
  `user_cancel_time` datetime DEFAULT NULL,
  `first_approval` tinyint(4) NOT NULL DEFAULT 0,
  `first_approval_by` int(11) NOT NULL,
  `first_approval_time` datetime DEFAULT NULL,
  `orglead_approval` tinyint(4) DEFAULT 0,
  `orglead_approval_by` int(10) DEFAULT 0,
  `orglead_approval_time` datetime DEFAULT NULL,
  `second_approval` tinyint(4) NOT NULL DEFAULT 0,
  `second_approval_by` int(11) NOT NULL,
  `second_approval_time` datetime DEFAULT NULL,
  `third_approval` tinyint(4) DEFAULT 0,
  `third_approval_by` int(11) NOT NULL,
  `third_approval_time` datetime DEFAULT NULL,
  `fourth_approval` tinyint(4) NOT NULL DEFAULT 0,
  `fourth_approval_by` int(10) NOT NULL DEFAULT 0,
  `fourth_approval_time` datetime DEFAULT NULL,
  `cancel_reason` mediumtext DEFAULT NULL,
  `created_by` int(55) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `raised_by` tinyint(4) NOT NULL,
  `pay_status` tinyint(4) NOT NULL DEFAULT 1,
  `pur_id` int(11) DEFAULT NULL,
  `purchase_payment` tinyint(4) NOT NULL DEFAULT 0,
  `close_pay` tinyint(4) NOT NULL DEFAULT 0,
  `closed_by` int(10) NOT NULL,
  `closed_time` datetime DEFAULT NULL,
  `resubmit` int(10) NOT NULL DEFAULT 0,
  `resubmit_by` int(10) NOT NULL,
  `expenditure_status` int(11) DEFAULT NULL,
  `expenditure_amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_request`
--

INSERT INTO `payment_request` (`pay_id`, `pay_code`, `team_leader`, `incharge_name`, `company_name`, `org_name`, `project_title`, `bill_no`, `reason`, `po_no`, `amount`, `advanced_amonut`, `advance_step`, `balance_amount`, `amount_words`, `payment_type`, `payment_against`, `gst`, `gst_no`, `remarks`, `po_file`, `supplier_mobile`, `supplier_mail`, `supplier_branch`, `acc_no`, `ifsc_code`, `utr_no`, `acc_po`, `user_cancel`, `user_cancel_by`, `user_cancel_time`, `first_approval`, `first_approval_by`, `first_approval_time`, `orglead_approval`, `orglead_approval_by`, `orglead_approval_time`, `second_approval`, `second_approval_by`, `second_approval_time`, `third_approval`, `third_approval_by`, `third_approval_time`, `fourth_approval`, `fourth_approval_by`, `fourth_approval_time`, `cancel_reason`, `created_by`, `created_date`, `raised_by`, `pay_status`, `pur_id`, `purchase_payment`, `close_pay`, `closed_by`, `closed_time`, `resubmit`, `resubmit_by`, `expenditure_status`, `expenditure_amount`) VALUES
(1, 'PAY-7837202', 0, 'Vencar Admin ', 'Brennan and Salas Plc', '2', 'Marsden Donaldson', '', '', '', 0, '', 0, '', 'Pariatur Aut aperia', 'Immediate', '1', 0, '', 'Ut eos ut sunt impe', NULL, 'Beach and Fi', 'wupozihyq@mailinator.com', 'Fox Pearson LLC', 'Vitae atque culpa d', 'Architecto ', NULL, NULL, 0, NULL, NULL, 1, 1, '2021-07-20 16:39:35', 2, 1, '2021-07-20 16:39:35', 1, 1, '2021-07-20 16:39:35', 0, 0, NULL, 0, 0, NULL, NULL, 1, '2021-07-20 16:39:35', 2, 1, NULL, 0, 0, 0, NULL, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `payment_value` int(10) NOT NULL,
  `payment_name` varchar(250) DEFAULT NULL,
  `payment_ref` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`payment_value`, `payment_name`, `payment_ref`) VALUES
(1, 'Payment', 'Normal-Payment'),
(2, 'Bill Payment', 'Bill'),
(3, 'Purchase / Travel Advance', 'Advance'),
(4, 'Salary Advance', 'Salary-Advance'),
(5, 'Credit Statement', 'Credit-Advance'),
(6, 'Deposit Refund', 'Deposit-Refund'),
(7, 'Fund Refund', 'Fund-Refund'),
(8, 'Job / Civil Works', 'Job-CivilWorks'),
(9, 'Expenditure', 'Expenditure');

-- --------------------------------------------------------

--
-- Table structure for table `payment_user_flow`
--

CREATE TABLE `payment_user_flow` (
  `flow_ID` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `org_Id` int(10) NOT NULL,
  `first_approval` tinyint(4) DEFAULT NULL,
  `orglead_approval` tinyint(4) DEFAULT NULL,
  `second_approval` tinyint(4) DEFAULT NULL,
  `third_approval` tinyint(4) DEFAULT NULL,
  `fourth_apporval` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchased_products`
--

CREATE TABLE `purchased_products` (
  `sl_no` int(11) NOT NULL,
  `pr_product_id` int(11) NOT NULL,
  `pr_purchase_id` int(100) DEFAULT NULL,
  `pr_project_id` int(11) DEFAULT NULL,
  `pr_supplier_id` int(11) DEFAULT NULL,
  `pr_qty` varchar(900) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchased_products`
--

INSERT INTO `purchased_products` (`sl_no`, `pr_product_id`, `pr_purchase_id`, `pr_project_id`, `pr_supplier_id`, `pr_qty`) VALUES
(3, 3, 1, 11, 12, '33'),
(4, 1, 1, 11, 12, '11'),
(5, 2, 1, 11, 12, '66'),
(6, 3, 2, 2, 6, '55'),
(7, 4, 3, 2, 7, '44'),
(8, 3, 4, 2, 6, '55'),
(9, 3, 5, 2, 6, '55'),
(10, 4, 6, 2, 12, '10'),
(11, 1, 7, 3, 12, '403');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `sl_no` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `aprrove_status` int(11) NOT NULL,
  `approve_status_text` varchar(100) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `approve_admin_role` int(11) NOT NULL,
  `approval_type` int(50) NOT NULL,
  `approval_type_text` varchar(100) NOT NULL,
  `approve_time` datetime NOT NULL,
  `history_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`sl_no`, `purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`, `approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES
(1, 1, 1, 'Approved', 39, 11, 1, 'Lead Approval', '2021-07-30 11:24:52', 1),
(2, 1, 1, 'Approved', 2, 2, 1, 'First Approval', '2021-07-30 11:57:57', 1),
(3, 1, 1, 'Payment Processed', 1, 1, 1, 'Second Approval', '2021-07-30 12:44:24', 1),
(4, 2, 1, 'Cancelled', 2, 2, 0, '', '2021-07-30 13:09:22', 1),
(5, 6, 1, 'Approved', 2, 2, 1, 'First Approval', '2021-07-30 22:56:44', 1),
(6, 4, 1, 'Cancelled', 2, 2, 0, '', '2021-07-30 23:01:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request`
--

CREATE TABLE `purchase_request` (
  `pur_id` int(11) NOT NULL,
  `purchase_code` varchar(200) DEFAULT NULL,
  `pr_name` varchar(250) DEFAULT NULL,
  `org_name` varchar(50) DEFAULT NULL,
  `pr_supplier_id` int(11) DEFAULT NULL,
  `supplier_name` varchar(250) DEFAULT NULL,
  `supplier_email` varchar(200) DEFAULT NULL,
  `supplier_mobile` varchar(12) DEFAULT NULL,
  `supplier_ifsccode` varchar(100) DEFAULT NULL,
  `supplier_accno` varchar(100) DEFAULT NULL,
  `supplier_ref` varchar(250) DEFAULT NULL,
  `pr_project_id` int(11) DEFAULT NULL,
  `purchase_type` varchar(150) DEFAULT NULL,
  `others` mediumtext DEFAULT NULL,
  `if_po_done` tinyint(4) NOT NULL DEFAULT 0,
  `total_amount` varchar(50) DEFAULT NULL,
  `advance_amount` varchar(50) DEFAULT NULL,
  `balance_amount` varchar(50) DEFAULT NULL,
  `amount_words` text DEFAULT NULL,
  `bill_no` varchar(240) DEFAULT NULL,
  `bill_file` varchar(250) DEFAULT NULL,
  `po_no` varchar(250) DEFAULT NULL,
  `po_file` varchar(250) DEFAULT NULL,
  `orglead_approval` tinyint(4) DEFAULT 0,
  `orglead_approval_by` int(11) DEFAULT 0,
  `orglead_approval_time` datetime DEFAULT NULL,
  `first_approval` tinyint(4) NOT NULL DEFAULT 0,
  `first_approved_by` int(11) NOT NULL,
  `frist_approval_time` timestamp NULL DEFAULT NULL,
  `second_approval` tinyint(4) NOT NULL DEFAULT 0,
  `second_approved_by` int(11) NOT NULL,
  `second_approval_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `third_approval` tinyint(4) NOT NULL DEFAULT 0,
  `third_approved_by` int(11) NOT NULL,
  `third_approval_time` timestamp NULL DEFAULT NULL,
  `cancel_reason` mediumtext DEFAULT NULL,
  `cancelled_by` int(100) DEFAULT NULL,
  `cancelled_admin_role` int(100) DEFAULT NULL,
  `cancelled_time` timestamp NULL DEFAULT NULL,
  `created_by` int(55) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `team_leader` int(11) DEFAULT NULL,
  `purchase_status` tinyint(4) NOT NULL DEFAULT 1,
  `purchase_payment` int(11) NOT NULL DEFAULT 0,
  `already_purchased` tinyint(4) NOT NULL DEFAULT 0,
  `completed` tinyint(4) NOT NULL DEFAULT 0,
  `completed_time` datetime DEFAULT NULL,
  `mail_sent` tinyint(4) NOT NULL DEFAULT 0,
  `pofile_uploaded` tinyint(4) NOT NULL DEFAULT 0,
  `resubmit` int(11) NOT NULL DEFAULT 0,
  `resubmit_by` int(11) NOT NULL DEFAULT 0,
  `expected_date` varchar(100) DEFAULT NULL,
  `pr_po_convert` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_request`
--

INSERT INTO `purchase_request` (`pur_id`, `purchase_code`, `pr_name`, `org_name`, `pr_supplier_id`, `supplier_name`, `supplier_email`, `supplier_mobile`, `supplier_ifsccode`, `supplier_accno`, `supplier_ref`, `pr_project_id`, `purchase_type`, `others`, `if_po_done`, `total_amount`, `advance_amount`, `balance_amount`, `amount_words`, `bill_no`, `bill_file`, `po_no`, `po_file`, `orglead_approval`, `orglead_approval_by`, `orglead_approval_time`, `first_approval`, `first_approved_by`, `frist_approval_time`, `second_approval`, `second_approved_by`, `second_approval_time`, `third_approval`, `third_approved_by`, `third_approval_time`, `cancel_reason`, `cancelled_by`, `cancelled_admin_role`, `cancelled_time`, `created_by`, `created_date`, `team_leader`, `purchase_status`, `purchase_payment`, `already_purchased`, `completed`, `completed_time`, `mail_sent`, `pofile_uploaded`, `resubmit`, `resubmit_by`, `expected_date`, `pr_po_convert`) VALUES
(1, 'PUR-8863897', 'user', '5', 12, NULL, NULL, NULL, NULL, NULL, NULL, 11, 'Normal', 'sdasd', 1, '555', '555', '0', 'Five Hundred and Fifty Five Rupees Only', NULL, NULL, NULL, NULL, 1, 39, '2021-07-30 11:24:52', 1, 2, '2021-07-30 06:27:57', 1, 1, '2021-07-31 03:24:51', 0, 0, NULL, NULL, NULL, NULL, NULL, 37, '2021-07-30 05:52:18', 38, 1, 1, 0, 0, NULL, 0, 0, 0, 0, '31-07-2021', 1),
(2, 'PUR-8685912', 'user', '5', 6, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'Normal', 'SDACD', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 37, '2021-07-30 12:53:24', 4, 2, NULL, 0, 0, '2021-07-31 03:24:52', 0, 0, NULL, 'dsasd', 2, 2, '2021-07-30 07:39:22', 37, '2021-07-30 07:23:24', 38, 1, 0, 0, 0, NULL, 0, 0, 0, 0, '01-08-2021', 1),
(3, 'PUR-5723189', 'user', '5', 7, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'Normal', 'dwfs', 0, '5500', NULL, NULL, 'Five Thousand Five Hundred  Rupees Only', '5', '1d0c6_WhatsApp Image 2021-07-26 at 9.35.14 AM.jpeg', NULL, NULL, 2, 37, '2021-07-30 13:02:15', 0, 0, NULL, 0, 0, '2021-07-31 03:24:53', 0, 0, NULL, NULL, NULL, NULL, NULL, 37, '2021-07-30 07:32:15', 38, 1, 0, 1, 0, NULL, 0, 0, 0, 0, '07-08-2021', 1),
(4, 'PUR-2696560', 'Vencar Admin ', '5', 6, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'Normal', 'SDACD', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2021-07-30 14:01:22', 4, 2, NULL, 0, 0, '2021-07-31 03:24:54', 0, 0, NULL, 'asdvd', 2, 2, '2021-07-30 17:31:10', 1, '2021-07-30 08:31:22', 0, 1, 0, 0, 0, NULL, 0, 0, 0, 0, '01-08-2021', 1),
(5, 'PUR-2302786', 'Vencar Admin ', '5', 6, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'Normal', 'SDACD', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2021-07-30 14:01:54', 0, 0, NULL, 0, 0, '2021-07-31 03:24:56', 0, 0, NULL, NULL, NULL, NULL, NULL, 1, '2021-07-30 08:31:54', 0, 1, 0, 0, 0, NULL, 0, 0, 0, 0, '01-08-2021', 1),
(6, 'PUR-2577669', 'user', '1', 12, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'One Day Purchase', 'awfsdgxbc ', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 25, '2021-07-30 22:56:44', 1, 2, '2021-07-30 17:26:44', 0, 0, '2021-07-31 03:24:57', 0, 0, NULL, NULL, NULL, NULL, NULL, 37, '2021-07-30 17:25:21', 38, 1, 0, 0, 0, NULL, 0, 0, 0, 0, '31-07-2021', 1),
(7, 'PUR-3359334', 'user', '5', 12, NULL, NULL, NULL, NULL, NULL, NULL, 3, 'One Day Purchase', 'Laborum Aut quos cu', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 37, '2021-07-31 15:35:15', 0, 0, NULL, 0, 0, '2021-07-31 10:05:15', 0, 0, NULL, NULL, NULL, NULL, NULL, 37, '2021-07-31 10:05:15', 38, 1, 0, 0, 0, NULL, 0, 0, 0, 0, '13-08-2021', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_user_flow`
--

CREATE TABLE `purchase_user_flow` (
  `flow_ID` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `org_Id` int(11) NOT NULL,
  `orglead_approval` tinyint(4) DEFAULT NULL,
  `first_approval` tinyint(4) DEFAULT NULL,
  `second_approval` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recovery_keys`
--

CREATE TABLE `recovery_keys` (
  `recoveryid` int(11) NOT NULL,
  `token` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `customer_ID` int(11) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 1,
  `valid` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `remainder`
--

CREATE TABLE `remainder` (
  `id` int(11) NOT NULL,
  `remainder_pay_id` int(11) DEFAULT NULL,
  `remainder_supplier_id` int(11) DEFAULT NULL,
  `remainder_amount` float DEFAULT NULL,
  `remainder_type` int(11) NOT NULL COMMENT '1=remainder , 2 = payment',
  `remainder_created_by` int(11) DEFAULT NULL,
  `remainder_created_time` varchar(100) DEFAULT NULL,
  `remainder_status` int(11) DEFAULT NULL COMMENT '0=new,1=pending,2=complete',
  `remainder_date` varchar(50) DEFAULT NULL,
  `remainder_updated_by` int(11) DEFAULT NULL,
  `remainder_updated_time` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_details`
--

CREATE TABLE `supplier_details` (
  `cust_id` int(11) NOT NULL,
  `supplier_name` varchar(250) NOT NULL,
  `supplier_gst` varchar(20) DEFAULT NULL,
  `supplier_email` varchar(250) NOT NULL,
  `supplier_mobile` varchar(10) NOT NULL,
  `supplier_branch` varchar(250) DEFAULT NULL,
  `supplier_acc_no` varchar(30) DEFAULT NULL,
  `supplier_ifsc_code` varchar(11) DEFAULT NULL,
  `supplier_address` text DEFAULT NULL,
  `supplier_city` varchar(50) DEFAULT NULL,
  `supplier_pincode` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier_details`
--

INSERT INTO `supplier_details` (`cust_id`, `supplier_name`, `supplier_gst`, `supplier_email`, `supplier_mobile`, `supplier_branch`, `supplier_acc_no`, `supplier_ifsc_code`, `supplier_address`, `supplier_city`, `supplier_pincode`) VALUES
(1, 'sastha traders', ' 33AACCS4557R1ZS', 'sales.sastha016@gmail.com', '7299133872', 'Maduravoyal', '12356789012345', 'HDFC0001234', '1/147, Ganga Nagar, Maduravoyal, Chennai', 'Chennai', '600095'),
(2, 'Steven Reed', NULL, 'gycok@mailinator.com', 'Iure fugit', 'Maduravoyal', 'Non incidunt doloru', 'Modi expedi', NULL, NULL, NULL),
(3, 'Hiram Ford', NULL, 'cosiqat@mailinator.com', 'Voluptatib', 'Maduravoyal', 'Pariatur Id omnis ', 'Lorem sint ', NULL, NULL, NULL),
(6, 'DAFDSGF', NULL, 'EDGDFWW@GMAIL.COM', '3212435125', 'QWER', '435464532143', '2344`2314T5', NULL, NULL, NULL),
(7, 'DAFDSGF', NULL, 'EDGDFWW@GMAIL.COM', '3212435125', 'QWER', '435464532143', '2344`2314T5', NULL, NULL, NULL),
(8, 'DAFDSGF', NULL, 'EDGDFWW@GMAIL.COM', '3212435125', 'QWER', '435464532143', '2344`2314T5', NULL, NULL, NULL),
(9, 'DAFDSGF', NULL, 'EDGDFWW@GMAIL.COM', '3212435125', 'QWER', '435464532143', '2344`2314T5', NULL, NULL, NULL),
(10, 'DAFDSGF', NULL, 'EDGDFWW@GMAIL.COM', '3212435125', 'QWER', '435464532143', '2344`2314T5', NULL, NULL, NULL),
(11, 'sjakd', NULL, 'ksjka@gmail.com', '2132', 'askjda', '23', 'qwe', NULL, NULL, NULL),
(12, 'Baker Alexandersdaf', NULL, 'vytovyk@mailinator.com', 'Veniam en', 'Kemp Warner Trading', 'Excepturi quis aut o', 'Modi volupt', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_role` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_role`, `status`, `sort_order`) VALUES
(1, 'Admin', 1, 1),
(2, 'Managing Director', 1, 2),
(3, 'Team Lead', 1, 7),
(4, 'Finance', 1, 3),
(5, 'Purchase Team', 1, 6),
(6, 'User', 1, 8),
(7, 'Purchase Lead', 1, 5),
(8, 'Accounts Team', 1, 4),
(9, 'AGEM Finance', 1, 3),
(10, 'Remainder Team', 1, 10),
(11, 'Organization Lead', 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user_visit`
--

CREATE TABLE `user_visit` (
  `sl_no` int(10) NOT NULL,
  `pay_id` int(10) NOT NULL,
  `visit_status` tinyint(4) NOT NULL,
  `visit_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `close_expenditure`
--
ALTER TABLE `close_expenditure`
  ADD PRIMARY KEY (`close_ID`);

--
-- Indexes for table `expenditures`
--
ALTER TABLE `expenditures`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `expenditure_amount`
--
ALTER TABLE `expenditure_amount`
  ADD PRIMARY KEY (`amount_ID`);

--
-- Indexes for table `expenditure_history`
--
ALTER TABLE `expenditure_history`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `followup_modes`
--
ALTER TABLE `followup_modes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followup_payments`
--
ALTER TABLE `followup_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ft_allowances`
--
ALTER TABLE `ft_allowances`
  ADD PRIMARY KEY (`allowance_id`);

--
-- Indexes for table `ft_dc`
--
ALTER TABLE `ft_dc`
  ADD PRIMARY KEY (`dc_id`);

--
-- Indexes for table `ft_dc_details`
--
ALTER TABLE `ft_dc_details`
  ADD PRIMARY KEY (`dc_details_id`);

--
-- Indexes for table `ft_deductions`
--
ALTER TABLE `ft_deductions`
  ADD PRIMARY KEY (`deduction_id`);

--
-- Indexes for table `ft_inward`
--
ALTER TABLE `ft_inward`
  ADD PRIMARY KEY (`pi_id`);

--
-- Indexes for table `ft_inward_details`
--
ALTER TABLE `ft_inward_details`
  ADD PRIMARY KEY (`pi_details_id`);

--
-- Indexes for table `ft_item_group`
--
ALTER TABLE `ft_item_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `ft_po`
--
ALTER TABLE `ft_po`
  ADD PRIMARY KEY (`po_id`);

--
-- Indexes for table `ft_po_add_details`
--
ALTER TABLE `ft_po_add_details`
  ADD PRIMARY KEY (`po_add_id`);

--
-- Indexes for table `ft_po_details`
--
ALTER TABLE `ft_po_details`
  ADD PRIMARY KEY (`po_details_id`);

--
-- Indexes for table `ft_po_status`
--
ALTER TABLE `ft_po_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `ft_po_terms`
--
ALTER TABLE `ft_po_terms`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `ft_product_details`
--
ALTER TABLE `ft_product_details`
  ADD PRIMARY KEY (`details_id`);

--
-- Indexes for table `ft_product_master`
--
ALTER TABLE `ft_product_master`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `ft_projects_tb`
--
ALTER TABLE `ft_projects_tb`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `ft_project_details`
--
ALTER TABLE `ft_project_details`
  ADD PRIMARY KEY (`project_deatils_id`);

--
-- Indexes for table `ft_quotation_table`
--
ALTER TABLE `ft_quotation_table`
  ADD PRIMARY KEY (`quo_id`);

--
-- Indexes for table `ft_stock_master`
--
ALTER TABLE `ft_stock_master`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `ft_store_room`
--
ALTER TABLE `ft_store_room`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `ft_tax`
--
ALTER TABLE `ft_tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `ft_terms`
--
ALTER TABLE `ft_terms`
  ADD PRIMARY KEY (`terms_id`);

--
-- Indexes for table `ft_transport_mode`
--
ALTER TABLE `ft_transport_mode`
  ADD PRIMARY KEY (`transport_id`);

--
-- Indexes for table `ft_uom`
--
ALTER TABLE `ft_uom`
  ADD PRIMARY KEY (`uom_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `payment_pdf`
--
ALTER TABLE `payment_pdf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_request`
--
ALTER TABLE `payment_request`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`payment_value`);

--
-- Indexes for table `payment_user_flow`
--
ALTER TABLE `payment_user_flow`
  ADD PRIMARY KEY (`flow_ID`);

--
-- Indexes for table `purchased_products`
--
ALTER TABLE `purchased_products`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `purchase_request`
--
ALTER TABLE `purchase_request`
  ADD PRIMARY KEY (`pur_id`);

--
-- Indexes for table `purchase_user_flow`
--
ALTER TABLE `purchase_user_flow`
  ADD PRIMARY KEY (`flow_ID`);

--
-- Indexes for table `recovery_keys`
--
ALTER TABLE `recovery_keys`
  ADD PRIMARY KEY (`recoveryid`);

--
-- Indexes for table `remainder`
--
ALTER TABLE `remainder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_details`
--
ALTER TABLE `supplier_details`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_visit`
--
ALTER TABLE `user_visit`
  ADD PRIMARY KEY (`sl_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `emp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `close_expenditure`
--
ALTER TABLE `close_expenditure`
  MODIFY `close_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenditures`
--
ALTER TABLE `expenditures`
  MODIFY `exp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenditure_amount`
--
ALTER TABLE `expenditure_amount`
  MODIFY `amount_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenditure_history`
--
ALTER TABLE `expenditure_history`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followup_modes`
--
ALTER TABLE `followup_modes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `followup_payments`
--
ALTER TABLE `followup_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_allowances`
--
ALTER TABLE `ft_allowances`
  MODIFY `allowance_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ft_dc`
--
ALTER TABLE `ft_dc`
  MODIFY `dc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ft_dc_details`
--
ALTER TABLE `ft_dc_details`
  MODIFY `dc_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ft_deductions`
--
ALTER TABLE `ft_deductions`
  MODIFY `deduction_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ft_inward`
--
ALTER TABLE `ft_inward`
  MODIFY `pi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ft_inward_details`
--
ALTER TABLE `ft_inward_details`
  MODIFY `pi_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ft_item_group`
--
ALTER TABLE `ft_item_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ft_po`
--
ALTER TABLE `ft_po`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ft_po_add_details`
--
ALTER TABLE `ft_po_add_details`
  MODIFY `po_add_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ft_po_details`
--
ALTER TABLE `ft_po_details`
  MODIFY `po_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ft_po_status`
--
ALTER TABLE `ft_po_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ft_po_terms`
--
ALTER TABLE `ft_po_terms`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ft_product_details`
--
ALTER TABLE `ft_product_details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ft_product_master`
--
ALTER TABLE `ft_product_master`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ft_projects_tb`
--
ALTER TABLE `ft_projects_tb`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ft_project_details`
--
ALTER TABLE `ft_project_details`
  MODIFY `project_deatils_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ft_quotation_table`
--
ALTER TABLE `ft_quotation_table`
  MODIFY `quo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ft_stock_master`
--
ALTER TABLE `ft_stock_master`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ft_store_room`
--
ALTER TABLE `ft_store_room`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ft_tax`
--
ALTER TABLE `ft_tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ft_terms`
--
ALTER TABLE `ft_terms`
  MODIFY `terms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ft_transport_mode`
--
ALTER TABLE `ft_transport_mode`
  MODIFY `transport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ft_uom`
--
ALTER TABLE `ft_uom`
  MODIFY `uom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_pdf`
--
ALTER TABLE `payment_pdf`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_request`
--
ALTER TABLE `payment_request`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `payment_value` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_user_flow`
--
ALTER TABLE `payment_user_flow`
  MODIFY `flow_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchased_products`
--
ALTER TABLE `purchased_products`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_request`
--
ALTER TABLE `purchase_request`
  MODIFY `pur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase_user_flow`
--
ALTER TABLE `purchase_user_flow`
  MODIFY `flow_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recovery_keys`
--
ALTER TABLE `recovery_keys`
  MODIFY `recoveryid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remainder`
--
ALTER TABLE `remainder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_details`
--
ALTER TABLE `supplier_details`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_visit`
--
ALTER TABLE `user_visit`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
