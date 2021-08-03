-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2021 at 01:38 PM
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
(1, 'EMP-1234', 1, 'admin@freezek.com', 'Vencar Admin ', '6384825639', 'kQF0IZJJKdB0', '2021-03-25 12:57:20', 1, 0, 2, '2021-03-25 07:27:20', 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `ft_column`
--

CREATE TABLE `ft_column` (
  `column_id` int(11) NOT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `column_name` varchar(220) NOT NULL,
  `column_qr` varchar(220) NOT NULL,
  `column_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `ft_deductions`
--

CREATE TABLE `ft_deductions` (
  `deduction_id` int(30) NOT NULL,
  `deduction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `pi_locatoin_id` int(11) DEFAULT NULL,
  `pi_total_qty` int(11) NOT NULL,
  `pi_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=complete,2=partial',
  `pi_remarks` text DEFAULT NULL,
  `pi_created_by` int(11) NOT NULL,
  `pi_created_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'S.S BOLT & NUT', 'SSBN', 1, '6107bb5b0ef18.png'),
(2, 'S.S / M.S PLATE & PIPE', 'SSMP', 1, '6107bb6b8fb64.png'),
(3, 'S.S PRESSURE GAUGE', 'SSPG', 1, '6107bb7680ff4.png'),
(4, 'PNEUMATIC ITEMS', 'PI', 1, '6107bb8396e85.png'),
(5, 'S.S / M.S  FITTINGS', 'SSMF', 1, '6107bb9112019.png'),
(6, 'S.S VALVE', 'SSV', 1, '6107bb9d459ac.png'),
(7, 'FLANGE ', 'F', 1, '6107bbab45b69.png'),
(8, 'EQU FLUID', 'EF', 1, '6107bbb81202c.png');

-- --------------------------------------------------------

--
-- Table structure for table `ft_location`
--

CREATE TABLE `ft_location` (
  `location_id` int(11) NOT NULL,
  `lo_store_room_id` int(11) NOT NULL,
  `lo_rack_id` int(11) NOT NULL,
  `lo_column_id` int(11) NOT NULL,
  `lo_product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `po_status` int(11) NOT NULL DEFAULT 1 COMMENT '1=created,3=inward done,2=Transit,4=payment',
  `po_mail_sent` int(11) NOT NULL DEFAULT 0,
  `po_dc_entry` int(11) NOT NULL DEFAULT 0,
  `bill_no` varchar(50) DEFAULT NULL,
  `bill_file` text DEFAULT NULL COMMENT 'assets/pdf/purchase'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `ft_po_dc`
--

CREATE TABLE `ft_po_dc` (
  `dc_id` int(11) NOT NULL,
  `dc_no` varchar(150) NOT NULL,
  `dc_po_id` int(11) NOT NULL,
  `dc_date` date NOT NULL,
  `dc_created_by` int(11) NOT NULL,
  `dc_created_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `ft_po_mail`
--

CREATE TABLE `ft_po_mail` (
  `mail_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `mail_subject` varchar(250) NOT NULL,
  `mail_body` text NOT NULL,
  `mail_cc` varchar(250) DEFAULT NULL,
  `mail_sent_by` int(11) NOT NULL,
  `mail_sent_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `deatils_created_by` int(11) DEFAULT NULL,
  `deatils_created_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `ft_rack`
--

CREATE TABLE `ft_rack` (
  `rack_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `rack_name` varchar(250) NOT NULL,
  `rack_qr` varchar(250) NOT NULL,
  `rack_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `ft_tax`
--

CREATE TABLE `ft_tax` (
  `tax_id` int(11) NOT NULL,
  `tax_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'gjhb,m.adsafgdhfmgjhj'),
(3, 'hgvjbkn');

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
(3, 'ML\r\n', 1);

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
-- Indexes for table `ft_column`
--
ALTER TABLE `ft_column`
  ADD PRIMARY KEY (`column_id`);

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
-- Indexes for table `ft_location`
--
ALTER TABLE `ft_location`
  ADD PRIMARY KEY (`location_id`);

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
-- Indexes for table `ft_po_dc`
--
ALTER TABLE `ft_po_dc`
  ADD PRIMARY KEY (`dc_id`);

--
-- Indexes for table `ft_po_details`
--
ALTER TABLE `ft_po_details`
  ADD PRIMARY KEY (`po_details_id`);

--
-- Indexes for table `ft_po_mail`
--
ALTER TABLE `ft_po_mail`
  ADD PRIMARY KEY (`mail_id`);

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
-- Indexes for table `ft_rack`
--
ALTER TABLE `ft_rack`
  ADD PRIMARY KEY (`rack_id`);

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
  MODIFY `emp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
  MODIFY `allowance_id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_column`
--
ALTER TABLE `ft_column`
  MODIFY `column_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_dc`
--
ALTER TABLE `ft_dc`
  MODIFY `dc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_dc_details`
--
ALTER TABLE `ft_dc_details`
  MODIFY `dc_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_deductions`
--
ALTER TABLE `ft_deductions`
  MODIFY `deduction_id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_inward`
--
ALTER TABLE `ft_inward`
  MODIFY `pi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_inward_details`
--
ALTER TABLE `ft_inward_details`
  MODIFY `pi_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_item_group`
--
ALTER TABLE `ft_item_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ft_location`
--
ALTER TABLE `ft_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_po`
--
ALTER TABLE `ft_po`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_po_add_details`
--
ALTER TABLE `ft_po_add_details`
  MODIFY `po_add_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_po_dc`
--
ALTER TABLE `ft_po_dc`
  MODIFY `dc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_po_details`
--
ALTER TABLE `ft_po_details`
  MODIFY `po_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_po_mail`
--
ALTER TABLE `ft_po_mail`
  MODIFY `mail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_po_status`
--
ALTER TABLE `ft_po_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_po_terms`
--
ALTER TABLE `ft_po_terms`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_product_details`
--
ALTER TABLE `ft_product_details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_product_master`
--
ALTER TABLE `ft_product_master`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_projects_tb`
--
ALTER TABLE `ft_projects_tb`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_project_details`
--
ALTER TABLE `ft_project_details`
  MODIFY `project_deatils_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_quotation_table`
--
ALTER TABLE `ft_quotation_table`
  MODIFY `quo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_rack`
--
ALTER TABLE `ft_rack`
  MODIFY `rack_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_stock_master`
--
ALTER TABLE `ft_stock_master`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_store_room`
--
ALTER TABLE `ft_store_room`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_tax`
--
ALTER TABLE `ft_tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_terms`
--
ALTER TABLE `ft_terms`
  MODIFY `terms_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ft_transport_mode`
--
ALTER TABLE `ft_transport_mode`
  MODIFY `transport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_pdf`
--
ALTER TABLE `payment_pdf`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_request`
--
ALTER TABLE `payment_request`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `sl_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_request`
--
ALTER TABLE `purchase_request`
  MODIFY `pur_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT;

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
