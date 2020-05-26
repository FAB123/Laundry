-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 09, 2019 at 03:51 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sell-25-10-19`
--

-- --------------------------------------------------------

--
-- Table structure for table `pos_accounts`
--

DROP TABLE IF EXISTS `pos_accounts`;
CREATE TABLE IF NOT EXISTS `pos_accounts` (
  `tid` int(8) NOT NULL AUTO_INCREMENT,
  `thedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(125) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_id` int(10) NOT NULL,
  `accounts` varchar(125) DEFAULT NULL,
  `type` text,
  `credit_amount` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT '0.00',
  `debit_amount` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT '0.00',
  `location_id` varchar(10) DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `INTY` decimal(2,0) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tid`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=cp1256;

--
-- Dumping data for table `pos_accounts`
--

INSERT INTO `pos_accounts` (`tid`, `thedate`, `description`, `employee_id`, `accounts`, `type`, `credit_amount`, `cost`, `debit_amount`, `tax`, `location_id`, `deleted`, `INTY`) VALUES
(1, '2019-10-28 00:00:40', 'RECV 1', 1, '-1', 'Purchase', NULL, '0.00', '52.50', '-2.50', '1', 0, '1'),
(2, '2019-10-29 20:44:58', 'POS 1', 1, '-1', 'Sales', '61.00', '25.00', NULL, '5.50', '1', 0, '1'),
(3, '2019-10-29 21:21:16', 'POS 2', 1, '-1', 'Sales', '61.00', '25.00', NULL, '5.50', '1', 0, '1'),
(4, '2019-10-30 23:27:07', 'RECV 4', 1, '-1', 'Purchase', NULL, '0.00', '26.25', '-1.25', '1', 0, '1'),
(5, '2019-10-30 23:27:40', 'RECV 5', 1, '-1', 'Purchase', NULL, '0.00', '26.25', '-1.25', '1', 0, '1'),
(6, '2019-10-30 23:34:32', 'RECV 6', 1, '-1', 'Purchase', NULL, '0.00', '52.50', '-2.50', '1', 0, '1'),
(7, '2019-10-30 23:35:06', 'RECV 7', 1, '-1', 'Purchase', NULL, '0.00', '26.25', '-1.25', '1', 0, '1'),
(8, '2019-10-30 23:35:44', 'RECV 8', 1, '-1', 'Purchase', NULL, '0.00', '26.25', '-1.25', '1', 0, '1'),
(9, '2019-11-01 00:17:38', 'POS 3', 1, '-1', 'Sales', '58.00', '25.00', NULL, '2.75', '1', 0, '1'),
(10, '2019-11-06 08:15:50', 'POS 4', 1, '2', 'Sales', '528.00', '25.00', NULL, '50.00', '1', 0, '1'),
(11, '2019-11-08 23:08:02', 'POS 5', 1, '-1', 'Sales', '3607238.00', '25.00', NULL, '171773.25', '1', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `pos_accounts_history`
--

DROP TABLE IF EXISTS `pos_accounts_history`;
CREATE TABLE IF NOT EXISTS `pos_accounts_history` (
  `tid` int(8) NOT NULL AUTO_INCREMENT,
  `thedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(125) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_id` int(10) NOT NULL,
  `accounts` varchar(125) DEFAULT NULL,
  `type` text,
  `amount` decimal(10,2) DEFAULT NULL,
  `location_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1256;

-- --------------------------------------------------------

--
-- Table structure for table `pos_app_config`
--

DROP TABLE IF EXISTS `pos_app_config`;
CREATE TABLE IF NOT EXISTS `pos_app_config` (
  `key` varchar(50) NOT NULL,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_app_config`
--

INSERT INTO `pos_app_config` (`key`, `value`) VALUES
('address', 'Gizan\r\n'),
('address_ar', 'جازان '),
('allow_duplicate_barcodes', '0'),
('arabic_support', '1'),
('barcode_content', 'number'),
('barcode_first_row', 'company_name'),
('barcode_font', 'Arial.ttf'),
('barcode_font_size', '7'),
('barcode_formats', 'null'),
('barcode_fourth_row', 'custom_label'),
('barcode_generate_if_empty', '0'),
('barcode_height', '30'),
('barcode_num_in_row', '1'),
('barcode_page_cellspacing', '0'),
('barcode_page_width', '100'),
('barcode_second_row', 'item_code'),
('barcode_third_row', 'name'),
('barcode_type', 'Ean13'),
('barcode_width', '100'),
('cash_decimals', '2'),
('cash_rounding_code', '2'),
('company', 'GANA GROCERY '),
('company_ar', 'مؤسسة جنى عبدالرحمن بن عيسى شماخي'),
('company_logo', 'company_logo6.png'),
('country_codes', 'SA'),
('currency_decimals', '2'),
('currency_symbol', 'SAR'),
('customer_reward_enable', '0'),
('customer_sales_tax_support', '0'),
('dateformat', 'd/m/Y'),
('date_or_time_format', 'date_or_time_format'),
('default_origin_tax_code', ''),
('default_register_mode', 'sale'),
('default_sales_discount', '0'),
('default_sales_discount_type', '0'),
('default_tax_1_name', 'VAT'),
('default_tax_1_rate', '5'),
('default_tax_2_name', ''),
('default_tax_2_rate', ''),
('default_tax_category', 'Standard'),
('default_tax_rate', '8'),
('derive_sale_quantity', '1'),
('dinner_table_enable', '0'),
('disable_add_duplicate', '0'),
('email', ''),
('email_receipt_check_behaviour', 'last'),
('enforce_privacy', ''),
('fax', ''),
('financial_year', '1'),
('gcaptcha_enable', '0'),
('gcaptcha_secret_key', ''),
('gcaptcha_site_key', ''),
('giftcard_number', 'series'),
('invoice_default_comments', 'This is a default comment'),
('invoice_email_message', 'Dear {CU}, In attachment the receipt for sale {ISEQ}'),
('invoice_enable', '1'),
('language', 'english'),
('language_code', 'en-US'),
('last_used_invoice_number', '2'),
('last_used_quote_number', '4'),
('last_used_work_order_number', '0'),
('lines_per_page', '25'),
('line_sequence', '0'),
('mailchimp_api_key', ''),
('mailchimp_list_id', ''),
('mailpath', '/usr/sbin/sendmail'),
('msg_msg', ''),
('msg_pwd', ''),
('msg_src', ''),
('msg_uid', ''),
('multi_pack_enabled', '1'),
('notify_horizontal_position', 'center'),
('notify_vertical_position', 'bottom'),
('number_locale', 'en_US'),
('payment_options_order', 'cashdebitcredit'),
('phone', '0504723785'),
('print_bottom_margin', ''),
('print_delay_autoreturn', '0'),
('print_footer', '0'),
('print_header', '0'),
('print_left_margin', ''),
('print_receipt_check_behaviour', 'last'),
('print_right_margin', ''),
('print_silently', '0'),
('print_top_margin', ''),
('protocol', 'smtp'),
('quantity_decimals', '2'),
('quote_default_comments', 'This is a default quote comment'),
('quote_default_comments_ar', 'لتنبلابينلابي بال بيل ت بيلتبي'),
('quote_template', 'quote_pdf'),
('receipt_font_size', '40'),
('receipt_show_amount_change', '0'),
('receipt_show_company_name', '1'),
('receipt_show_description', '0'),
('receipt_show_payments', '0'),
('receipt_show_serialnumber', '1'),
('receipt_show_taxes', '1'),
('receipt_show_total_discount', '1'),
('receipt_show_watermark', '0'),
('receipt_template', 'receipt_a5_pdf'),
('receiving_calculate_average_price', '1'),
('recv_invoice_format', '{CO}'),
('return_policy', 'PHP TCPDF::Header - 5 examples found. These are the top rated real world PHP examples of TCPDF::Header extracted from open source projects. You can rate examples to help us improve the quality of examples.'),
('return_policy_ar', ' يتبنميايبي ايخهبايخهب هخيهب يب  يتبنميايبي ايخهبايخهب هخيهب يب يتبنميايبي ايخهبايخهب هخيهب يب  يتبنميايبي ايخهبايخهب هخيهب يب  يتبنميايبي ايخهبايخهب هخيهب يب  يتبنميايبي ايخهبايخهب هخيهب يب يتبنميايبي ايخهبايخهب هخيهب يب \r\n'),
('sales_focus_on_item', '0'),
('sales_invoice_format', '{CO}'),
('sales_pos_mode', ''),
('sales_quote_format', 'Q%y{QSEQ:6}'),
('smtp_crypto', 'ssl'),
('smtp_host', 'mail.gmail.com'),
('smtp_pass', ''),
('smtp_port', '465'),
('smtp_timeout', '5'),
('smtp_user', 'fysalkt@gmail.com'),
('spinner', 'dna'),
('suggestions_first_column', 'name'),
('suggestions_second_column', ''),
('suggestions_third_column', ''),
('tax_decimals', '2'),
('tax_included', '0'),
('theme', 'Default'),
('thousands_separator', 'thousands_separator'),
('timeformat', 'H:i:s'),
('timezone', 'Asia/Riyadh'),
('vat_no', '٣١٠٣٧٧٤١٦٤٠٠٠٠٣'),
('version_code', 'MTU3MTA5NjU1NQ=='),
('version_info', '5c1a8891f23d55bc1c9196adc7056d2b'),
('website', ''),
('work_order_enable', '0'),
('work_order_format', 'W%y{WSEQ:6}');

-- --------------------------------------------------------

--
-- Table structure for table `pos_attribute_definitions`
--

DROP TABLE IF EXISTS `pos_attribute_definitions`;
CREATE TABLE IF NOT EXISTS `pos_attribute_definitions` (
  `definition_id` int(10) NOT NULL AUTO_INCREMENT,
  `definition_name` varchar(255) NOT NULL,
  `definition_type` varchar(45) NOT NULL,
  `definition_flags` tinyint(4) NOT NULL,
  `definition_fk` int(10) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`definition_id`),
  KEY `definition_fk` (`definition_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_attribute_links`
--

DROP TABLE IF EXISTS `pos_attribute_links`;
CREATE TABLE IF NOT EXISTS `pos_attribute_links` (
  `attribute_id` int(11) DEFAULT NULL,
  `definition_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `receiving_id` int(11) DEFAULT NULL,
  UNIQUE KEY `attribute_links_uq1` (`attribute_id`,`definition_id`,`item_id`,`sale_id`,`receiving_id`),
  KEY `attribute_id` (`attribute_id`),
  KEY `definition_id` (`definition_id`),
  KEY `item_id` (`item_id`),
  KEY `sale_id` (`sale_id`),
  KEY `receiving_id` (`receiving_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_attribute_values`
--

DROP TABLE IF EXISTS `pos_attribute_values`;
CREATE TABLE IF NOT EXISTS `pos_attribute_values` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(45) DEFAULT NULL,
  `attribute_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_cash_up`
--

DROP TABLE IF EXISTS `pos_cash_up`;
CREATE TABLE IF NOT EXISTS `pos_cash_up` (
  `cashup_id` int(10) NOT NULL AUTO_INCREMENT,
  `open_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `close_date` timestamp NULL DEFAULT NULL,
  `open_amount_cash` decimal(15,2) NOT NULL,
  `transfer_amount_cash` decimal(15,2) NOT NULL,
  `note` int(1) NOT NULL,
  `closed_amount_cash` decimal(15,2) NOT NULL,
  `closed_amount_card` decimal(15,2) NOT NULL,
  `closed_amount_check` decimal(15,2) NOT NULL,
  `closed_amount_credit` decimal(15,2) DEFAULT NULL,
  `closed_amount_total` decimal(15,2) NOT NULL,
  `total_receiving_cash` decimal(15,2) NOT NULL,
  `total_expanse_cash` decimal(15,2) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `open_employee_id` int(10) NOT NULL,
  `close_employee_id` int(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `closed_amount_due` decimal(15,2) NOT NULL,
  PRIMARY KEY (`cashup_id`),
  KEY `open_employee_id` (`open_employee_id`),
  KEY `close_employee_id` (`close_employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_customers`
--

DROP TABLE IF EXISTS `pos_customers`;
CREATE TABLE IF NOT EXISTS `pos_customers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `taxable` int(1) NOT NULL DEFAULT '1',
  `sales_tax_code` varchar(32) NOT NULL DEFAULT '1',
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(2) NOT NULL DEFAULT '0',
  `package_id` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `employee_id` int(10) NOT NULL,
  `consent` int(1) NOT NULL DEFAULT '0',
  `Vat_no` text,
  `stock_location` varchar(10) DEFAULT NULL,
  `customer_type` varchar(255) DEFAULT NULL,
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`),
  KEY `package_id` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_customers`
--

INSERT INTO `pos_customers` (`person_id`, `company_name`, `account_number`, `taxable`, `sales_tax_code`, `discount`, `discount_type`, `package_id`, `points`, `deleted`, `date`, `employee_id`, `consent`, `Vat_no`, `stock_location`, `customer_type`) VALUES
(2, NULL, NULL, 1, '', '0.00', 0, NULL, NULL, 0, '2019-11-06 08:14:50', 1, 1, NULL, '1', 'unit_price');

-- --------------------------------------------------------

--
-- Table structure for table `pos_customers_packages`
--

DROP TABLE IF EXISTS `pos_customers_packages`;
CREATE TABLE IF NOT EXISTS `pos_customers_packages` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(255) DEFAULT NULL,
  `points_percent` float NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_customers_packages`
--

INSERT INTO `pos_customers_packages` (`package_id`, `package_name`, `points_percent`, `deleted`) VALUES
(1, 'Default', 0, 0),
(2, 'Bronze', 10, 0),
(3, 'Silver', 20, 0),
(4, 'Gold', 30, 0),
(5, 'Premium', 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_customers_points`
--

DROP TABLE IF EXISTS `pos_customers_points`;
CREATE TABLE IF NOT EXISTS `pos_customers_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `points_earned` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `package_id` (`package_id`),
  KEY `sale_id` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_dinner_tables`
--

DROP TABLE IF EXISTS `pos_dinner_tables`;
CREATE TABLE IF NOT EXISTS `pos_dinner_tables` (
  `dinner_table_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dinner_table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_dinner_tables`
--

INSERT INTO `pos_dinner_tables` (`dinner_table_id`, `name`, `status`, `deleted`) VALUES
(1, 'Delivery', 0, 0),
(2, 'Take Away', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_employees`
--

DROP TABLE IF EXISTS `pos_employees`;
CREATE TABLE IF NOT EXISTS `pos_employees` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `hash_version` int(1) NOT NULL DEFAULT '2',
  `language` varchar(48) DEFAULT NULL,
  `language_code` varchar(8) DEFAULT NULL,
  UNIQUE KEY `username` (`username`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_employees`
--

INSERT INTO `pos_employees` (`username`, `password`, `person_id`, `deleted`, `hash_version`, `language`, `language_code`) VALUES
('admin', '$2y$10$DZ28dJ3PvR8uQ3jvbevuge3pNslE6jrS8dFHypXJlPOCTNOwfL4Le', 1, 0, 2, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pos_expenses`
--

DROP TABLE IF EXISTS `pos_expenses`;
CREATE TABLE IF NOT EXISTS `pos_expenses` (
  `expense_id` int(10) NOT NULL AUTO_INCREMENT,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(15,2) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `employee_id` int(10) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `supplier_tax_code` varchar(255) DEFAULT NULL,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `supplier_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`expense_id`),
  KEY `expense_category_id` (`expense_category_id`),
  KEY `employee_id` (`employee_id`),
  KEY `pos_expenses_ibfk_3` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_expense_categories`
--

DROP TABLE IF EXISTS `pos_expense_categories`;
CREATE TABLE IF NOT EXISTS `pos_expense_categories` (
  `expense_category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `category_description` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`expense_category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_expense_categories`
--

INSERT INTO `pos_expense_categories` (`expense_category_id`, `category_name`, `category_description`, `deleted`) VALUES
(1, 'OFFICE EXPENSE', 'OFFICE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_giftcards`
--

DROP TABLE IF EXISTS `pos_giftcards`;
CREATE TABLE IF NOT EXISTS `pos_giftcards` (
  `record_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `giftcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftcard_number` varchar(255) DEFAULT NULL,
  `value` decimal(15,2) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `person_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`giftcard_id`),
  UNIQUE KEY `giftcard_number` (`giftcard_number`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_grants`
--

DROP TABLE IF EXISTS `pos_grants`;
CREATE TABLE IF NOT EXISTS `pos_grants` (
  `permission_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  `menu_group` varchar(32) DEFAULT 'home',
  PRIMARY KEY (`permission_id`,`person_id`),
  KEY `pos_grants_ibfk_2` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_grants`
--

INSERT INTO `pos_grants` (`permission_id`, `person_id`, `menu_group`) VALUES
('accounts', 1, 'home'),
('accounts_all', 1, '--'),
('accounts_Stock2', 1, '--'),
('accounts_Store', 1, '--'),
('attributes', 1, 'home'),
('cashups', 1, 'home'),
('config', 1, 'office'),
('customers', 1, 'home'),
('customers_Stock2', 1, '--'),
('customers_Store', 1, '--'),
('employees', 1, 'office'),
('expenses', 1, 'home'),
('expenses_categories', 1, 'office'),
('expenses_Stock2', 1, '--'),
('giftcards', 1, 'home'),
('home', 1, 'office'),
('items', 1, 'home'),
('items_Stock2', 1, '--'),
('items_Store', 1, '--'),
('item_kits', 1, 'home'),
('office', 1, 'home'),
('receivings', 1, 'home'),
('receivings_pdfrequisition', 1, '--'),
('receivings_Stock2', 1, '--'),
('receivings_Store', 1, '--'),
('reports', 1, 'home'),
('reports_cashonhands', 1, '--'),
('reports_cash_flows', 1, '--'),
('reports_categories', 1, '--'),
('reports_customers', 1, '--'),
('reports_damages', 1, '--'),
('reports_discounts', 1, '--'),
('reports_employees', 1, '--'),
('reports_expenses_categories', 1, '--'),
('reports_inventory', 1, '--'),
('reports_items', 1, '--'),
('reports_payables', 1, '--'),
('reports_payments', 1, '--'),
('reports_receivables', 1, '--'),
('reports_receivings', 1, '--'),
('reports_receivingtaxes', 1, '--'),
('reports_sales', 1, '--'),
('reports_suppliers', 1, '--'),
('reports_taxes', 1, '--'),
('reports_taxfullreport', 1, '--'),
('reports_taxgeneratereport', 1, '--'),
('reports_tracks', 1, '--'),
('sales', 1, 'home'),
('sales_delete', 1, '--'),
('sales_edit', 1, '--'),
('sales_rate', 1, '--'),
('sales_Stock2', 1, '--'),
('sales_Store', 1, '--'),
('suppliers', 1, 'home'),
('taxes', 1, 'home');

-- --------------------------------------------------------

--
-- Table structure for table `pos_inventory`
--

DROP TABLE IF EXISTS `pos_inventory`;
CREATE TABLE IF NOT EXISTS `pos_inventory` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_items` int(11) NOT NULL DEFAULT '0',
  `trans_user` int(11) NOT NULL DEFAULT '0',
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_comment` text NOT NULL,
  `trans_location` int(11) NOT NULL,
  `trans_inventory` decimal(15,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`trans_id`),
  KEY `trans_items` (`trans_items`),
  KEY `trans_user` (`trans_user`),
  KEY `trans_location` (`trans_location`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_inventory`
--

INSERT INTO `pos_inventory` (`trans_id`, `trans_items`, `trans_user`, `trans_date`, `trans_comment`, `trans_location`, `trans_inventory`) VALUES
(1, 1, 1, '2019-10-27 08:30:49', 'Manual Edit of Quantity', 2, '0.000'),
(2, 1, 1, '2019-10-27 08:30:49', 'Manual Edit of Quantity', 1, '0.000'),
(3, 1, 1, '2019-10-27 10:23:58', '', 2, '1.000'),
(4, 1, 1, '2019-10-27 10:24:20', '', 2, '1.000'),
(5, 1, 1, '2019-10-27 10:26:46', '', 2, '1.000'),
(6, 1, 1, '2019-10-27 10:27:56', '', 2, '-2.000'),
(7, 1, 1, '2019-10-27 10:28:15', '', 2, '1.000'),
(8, 1, 1, '2019-10-27 10:54:05', 'total Damages', 2, '-1.000'),
(9, 1, 1, '2019-10-27 11:34:41', 'Warranty Sent/Permanent Damage', 2, '-1.000'),
(10, 1, 1, '2019-10-27 20:16:39', 'Warranty Sent/Permanent Damage', 2, '-1.000'),
(11, 1, 1, '2019-10-27 20:18:20', 'Warranty Sent/Permanent Damage', 2, '-1.000'),
(12, 1, 1, '2019-10-27 20:19:09', 'Warranty Sent/Permanent Damage', 2, '-1.000'),
(13, 1, 1, '2019-10-27 20:20:24', 'Warranty Sent/Permanent Damage', 2, '-1.000'),
(14, 1, 1, '2019-10-27 20:24:11', 'Warranty Sent/Permanent Damage', 2, '-1.000'),
(15, 1, 1, '2019-10-27 20:24:36', 'Warranty Sent/Permanent Damage', 2, '-1.000'),
(16, 1, 1, '2019-10-27 20:24:52', 'Warranty Received', 2, '2.000'),
(17, 1, 1, '2019-10-27 21:15:46', 'Warranty Sent/Permanent Damage', 2, '-2.000'),
(18, 1, 1, '2019-10-27 21:16:41', 'Warranty Sent/Permanent Damage', 1, '-1.000'),
(19, 1, 1, '2019-10-28 00:00:40', 'RECV 1', 1, '2.000'),
(20, 1, 1, '2019-10-29 20:44:58', 'POS 1', 1, '-1.000'),
(21, 1, 1, '2019-10-29 21:21:16', 'POS 2', 1, '-1.000'),
(24, 1, 1, '2019-10-30 23:27:07', 'RECV 4', 1, '1.000'),
(25, 1, 1, '2019-10-30 23:27:40', 'RECV 5', 1, '1.000'),
(26, 1, 1, '2019-10-30 23:34:32', 'RECV 6', 1, '2.000'),
(27, 1, 1, '2019-10-30 23:35:06', 'RECV 7', 1, '1.000'),
(28, 1, 1, '2019-10-30 23:35:44', 'RECV 8', 1, '1.000'),
(29, 1, 1, '2019-11-01 00:17:38', 'POS 3', 1, '-1.000'),
(30, 1, 1, '2019-11-06 08:15:50', 'POS 4', 1, '-1.000'),
(31, 1, 1, '2019-11-08 23:08:01', 'POS 5', 1, '-1.000');

-- --------------------------------------------------------

--
-- Table structure for table `pos_items`
--

DROP TABLE IF EXISTS `pos_items`;
CREATE TABLE IF NOT EXISTS `pos_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` decimal(15,2) NOT NULL,
  `minimum_price` decimal(10,0) DEFAULT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `wholesale_price` decimal(12,2) DEFAULT NULL,
  `reorder_level` decimal(15,3) NOT NULL DEFAULT '0.000',
  `receiving_quantity` decimal(15,3) NOT NULL DEFAULT '1.000',
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `pic_filename` varchar(255) DEFAULT NULL,
  `allow_alt_description` tinyint(1) NOT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  `stock_type` tinyint(2) NOT NULL DEFAULT '0',
  `item_type` tinyint(2) NOT NULL DEFAULT '0',
  `tax_category_id` int(10) NOT NULL DEFAULT '1',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `unit_type` varchar(20) DEFAULT NULL,
  `qty_per_pack` decimal(15,3) NOT NULL DEFAULT '1.000',
  `pack_name` varchar(8) DEFAULT 'Each',
  `low_sell_item_id` int(10) DEFAULT '0',
  `sp` tinyint(4) DEFAULT '0',
  `custom_label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `item_number` (`item_number`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_items`
--

INSERT INTO `pos_items` (`name`, `category`, `supplier_id`, `item_number`, `description`, `cost_price`, `minimum_price`, `unit_price`, `wholesale_price`, `reorder_level`, `receiving_quantity`, `item_id`, `pic_filename`, `allow_alt_description`, `is_serialized`, `stock_type`, `item_type`, `tax_category_id`, `deleted`, `unit_type`, `qty_per_pack`, `pack_name`, `low_sell_item_id`, `sp`, `custom_label`) VALUES
('Alfa', 'Network', NULL, NULL, '', '25.00', '45', '55.00', '50.00', '1.000', '1.000', 1, NULL, 0, 1, 0, 0, 0, 0, 'PCS', '1.000', 'Each', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `pos_items_taxes`
--

DROP TABLE IF EXISTS `pos_items_taxes`;
CREATE TABLE IF NOT EXISTS `pos_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,3) NOT NULL,
  PRIMARY KEY (`item_id`,`name`,`percent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_items_taxes`
--

INSERT INTO `pos_items_taxes` (`item_id`, `name`, `percent`) VALUES
(1, 'VAT', '5.000');

-- --------------------------------------------------------

--
-- Table structure for table `pos_item_damages`
--

DROP TABLE IF EXISTS `pos_item_damages`;
CREATE TABLE IF NOT EXISTS `pos_item_damages` (
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quantity` decimal(15,3) NOT NULL DEFAULT '0.000',
  `thedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` int(10) NOT NULL,
  `employee_id` int(10) DEFAULT NULL,
  `value` decimal(12,2) NOT NULL DEFAULT '0.00',
  KEY `item_id` (`item_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_item_damages`
--

INSERT INTO `pos_item_damages` (`item_id`, `location_id`, `quantity`, `thedate`, `type`, `employee_id`, `value`) VALUES
(1, 2, '2.000', '2019-10-27 21:15:46', 0, 1, '50.00'),
(1, 1, '1.000', '2019-10-27 21:16:41', 0, 1, '25.00');

-- --------------------------------------------------------

--
-- Table structure for table `pos_item_kits`
--

DROP TABLE IF EXISTS `pos_item_kits`;
CREATE TABLE IF NOT EXISTS `pos_item_kits` (
  `item_kit_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `item_id` int(10) NOT NULL DEFAULT '0',
  `kit_discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `kit_discount_type` tinyint(2) NOT NULL DEFAULT '0',
  `price_option` tinyint(2) NOT NULL DEFAULT '0',
  `print_option` tinyint(2) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_item_kit_items`
--

DROP TABLE IF EXISTS `pos_item_kit_items`;
CREATE TABLE IF NOT EXISTS `pos_item_kit_items` (
  `item_kit_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `kit_sequence` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_kit_id`,`item_id`,`quantity`),
  KEY `pos_item_kit_items_ibfk_2` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_item_quantities`
--

DROP TABLE IF EXISTS `pos_item_quantities`;
CREATE TABLE IF NOT EXISTS `pos_item_quantities` (
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quantity` decimal(15,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`item_id`,`location_id`),
  KEY `item_id` (`item_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_item_quantities`
--

INSERT INTO `pos_item_quantities` (`item_id`, `location_id`, `quantity`) VALUES
(1, 1, '2.000'),
(1, 2, '-3.000');

-- --------------------------------------------------------

--
-- Table structure for table `pos_migrations`
--

DROP TABLE IF EXISTS `pos_migrations`;
CREATE TABLE IF NOT EXISTS `pos_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_migrations`
--

INSERT INTO `pos_migrations` (`version`) VALUES
(20181015100000);

-- --------------------------------------------------------

--
-- Table structure for table `pos_modules`
--

DROP TABLE IF EXISTS `pos_modules`;
CREATE TABLE IF NOT EXISTS `pos_modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `icon` text,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_modules`
--

INSERT INTO `pos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`, `icon`) VALUES
('module_accounts', 'module_accounts_desc', 112, 'accounts', 'calculator '),
('module_attributes', 'module_attributes_desc', 107, 'attributes', 'star'),
('module_cashups', 'module_cashups_desc', 110, 'cashups', 'usd '),
('module_config', 'module_config_desc', 900, 'config', 'cog'),
('module_customers', 'module_customers_desc', 10, 'customers', 'users '),
('module_employees', 'module_employees_desc', 80, 'employees', 'user-circle '),
('module_expenses', 'module_expenses_desc', 108, 'expenses', 'credit-card '),
('module_expenses_categories', 'module_expenses_categories_desc', 109, 'expenses_categories', 'usd '),
('module_giftcards', 'module_giftcards_desc', 90, 'giftcards', 'gift '),
('module_home', 'module_home_desc', 1, 'home', 'dashboard'),
('module_items', 'module_items_desc', 20, 'items', 'tasks'),
('module_item_kits', 'module_item_kits_desc', 30, 'item_kits', 'cube'),
('module_messages', 'module_messages_desc', 98, 'messages', 'whatsapp'),
('module_office', 'module_office_desc', 999, 'office', 'cog'),
('module_receivings', 'module_receivings_desc', 60, 'receivings', 'truck '),
('module_reports', 'module_reports_desc', 50, 'reports', 'bar-chart'),
('module_sales', 'module_sales_desc', 70, 'sales', 'shopping-cart'),
('module_suppliers', 'module_suppliers_desc', 40, 'suppliers', 'address-book'),
('module_taxes', 'module_taxes_desc', 105, 'taxes', 'money');

-- --------------------------------------------------------

--
-- Table structure for table `pos_people`
--

DROP TABLE IF EXISTS `pos_people`;
CREATE TABLE IF NOT EXISTS `pos_people` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` int(1) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`person_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_people`
--

INSERT INTO `pos_people` (`first_name`, `last_name`, `gender`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES
('Admin', 'User', 1, '555-555-5555', 'mail@email.com', 'Address 1', '', '', '', '', '', '', 1),
('Fas', 'lo', NULL, '', '', '', '', '', '', '', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pos_permissions`
--

DROP TABLE IF EXISTS `pos_permissions`;
CREATE TABLE IF NOT EXISTS `pos_permissions` (
  `permission_id` varchar(255) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `location_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `module_id` (`module_id`),
  KEY `pos_permissions_ibfk_2` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_permissions`
--

INSERT INTO `pos_permissions` (`permission_id`, `module_id`, `location_id`) VALUES
('accounts', 'accounts', NULL),
('accounts_all', 'accounts', NULL),
('accounts_Stock2', 'accounts', 2),
('accounts_Store', 'accounts', 1),
('attributes', 'attributes', NULL),
('cashups', 'cashups', NULL),
('config', 'config', NULL),
('customers', 'customers', NULL),
('customers_Stock2', 'customers', 2),
('customers_Store', 'customers', 1),
('employees', 'employees', NULL),
('expenses', 'expenses', NULL),
('expenses_categories', 'expenses_categories', NULL),
('expenses_Stock2', 'expenses', 2),
('giftcards', 'giftcards', NULL),
('home', 'home', NULL),
('items', 'items', NULL),
('items_Stock2', 'items', 2),
('items_Store', 'items', 1),
('item_kits', 'item_kits', NULL),
('office', 'office', NULL),
('receivings', 'receivings', NULL),
('receivings_pdfrequisition', 'receivings', NULL),
('receivings_Stock2', 'receivings', 2),
('receivings_Store', 'receivings', 1),
('reports', 'reports', NULL),
('reports_cashonhands', 'reports', NULL),
('reports_cash_flows', 'reports', NULL),
('reports_categories', 'reports', NULL),
('reports_customers', 'reports', NULL),
('reports_damages', 'reports', NULL),
('reports_discounts', 'reports', NULL),
('reports_employees', 'reports', NULL),
('reports_expenses_categories', 'reports', NULL),
('reports_inventory', 'reports', NULL),
('reports_items', 'reports', NULL),
('reports_payables', 'reports', NULL),
('reports_payments', 'reports', NULL),
('reports_receivables', 'reports', NULL),
('reports_receivings', 'reports', NULL),
('reports_receivingtaxes', 'reports', NULL),
('reports_sales', 'reports', NULL),
('reports_suppliers', 'reports', NULL),
('reports_taxes', 'reports', NULL),
('reports_taxfullreport', 'reports', NULL),
('reports_taxgeneratereport', 'reports', NULL),
('reports_tracks', 'reports', NULL),
('sales', 'sales', NULL),
('sales_delete', 'sales', NULL),
('sales_disablenegative', 'sales', NULL),
('sales_edit', 'sales', NULL),
('sales_pdfprint', 'sales', NULL),
('sales_rate', 'sales', NULL),
('sales_Stock2', 'sales', 2),
('sales_Store', 'sales', 1),
('suppliers', 'suppliers', NULL),
('taxes', 'taxes', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pos_receivings`
--

DROP TABLE IF EXISTS `pos_receivings`;
CREATE TABLE IF NOT EXISTS `pos_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text,
  `receiving_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(20) DEFAULT NULL,
  `reference` varchar(32) DEFAULT NULL,
  `receivings_type` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`receiving_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`),
  KEY `reference` (`reference`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_receivings`
--

INSERT INTO `pos_receivings` (`receiving_time`, `supplier_id`, `employee_id`, `comment`, `receiving_id`, `payment_type`, `reference`, `receivings_type`) VALUES
('2019-10-28 00:00:40', NULL, 1, '', 1, 'Cash', NULL, 0),
('2019-10-30 23:27:07', NULL, 1, '', 4, 'Cash', NULL, 0),
('2019-10-30 23:27:40', NULL, 1, '', 5, 'Cash', NULL, 0),
('2019-10-30 23:34:32', NULL, 1, '', 6, 'Cash', NULL, 0),
('2019-10-30 23:35:06', NULL, 1, '', 7, 'Cash', NULL, 0),
('2019-10-30 23:35:44', NULL, 1, '', 8, 'Cash', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_receivings_accounts`
--

DROP TABLE IF EXISTS `pos_receivings_accounts`;
CREATE TABLE IF NOT EXISTS `pos_receivings_accounts` (
  `trans_id` int(10) NOT NULL AUTO_INCREMENT,
  `thedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(125) NOT NULL,
  `notes` varchar(125) DEFAULT NULL,
  `employee_id` int(10) DEFAULT NULL,
  `account_id` int(10) NOT NULL,
  `location_id` varchar(10) DEFAULT NULL,
  `credit_amount` decimal(10,2) DEFAULT NULL,
  `debit_amount` decimal(10,2) DEFAULT NULL,
  `balance_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pos_receivings_items`
--

DROP TABLE IF EXISTS `pos_receivings_items`;
CREATE TABLE IF NOT EXISTS `pos_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` decimal(15,3) NOT NULL DEFAULT '0.000',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(2) NOT NULL DEFAULT '0',
  `item_location` int(11) NOT NULL,
  `receiving_quantity` decimal(15,3) NOT NULL DEFAULT '1.000',
  PRIMARY KEY (`receiving_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_receivings_items`
--

INSERT INTO `pos_receivings_items` (`receiving_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount`, `discount_type`, `item_location`, `receiving_quantity`) VALUES
(1, 1, '', NULL, 1, '2.000', '25.00', '25.00', '0.00', 0, 1, '1.000'),
(4, 1, '', '', 1, '1.000', '25.00', '25.00', '0.00', 0, 1, '1.000'),
(5, 1, 'ssds', NULL, 1, '1.000', '25.00', '25.00', '0.00', 0, 1, '1.000'),
(6, 1, 'fysal', '3232', 1, '2.000', '25.00', '25.00', '0.00', 0, 1, '1.000'),
(7, 1, 'fysal', '346893764, 34638734, 3463463', 1, '1.000', '25.00', '25.00', '0.00', 0, 1, '1.000'),
(8, 1, '', '', 1, '1.000', '25.00', '25.00', '0.00', 0, 1, '1.000');

-- --------------------------------------------------------

--
-- Table structure for table `pos_receivings_items_taxes`
--

DROP TABLE IF EXISTS `pos_receivings_items_taxes`;
CREATE TABLE IF NOT EXISTS `pos_receivings_items_taxes` (
  `receiving_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax_type` tinyint(2) NOT NULL DEFAULT '0',
  `rounding_code` tinyint(2) NOT NULL DEFAULT '0',
  `cascade_tax` tinyint(2) NOT NULL DEFAULT '0',
  `cascade_sequence` tinyint(2) NOT NULL DEFAULT '0',
  `item_tax_amount` decimal(15,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`receiving_id`,`item_id`,`line`,`name`,`percent`),
  KEY `receiving_id` (`receiving_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_receivings_items_taxes`
--

INSERT INTO `pos_receivings_items_taxes` (`receiving_id`, `item_id`, `line`, `name`, `percent`, `tax_type`, `rounding_code`, `cascade_tax`, `cascade_sequence`, `item_tax_amount`) VALUES
(1, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '2.5000'),
(4, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '1.2500'),
(5, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '1.2500'),
(6, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '2.5000'),
(7, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '1.2500'),
(8, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '1.2500');

-- --------------------------------------------------------

--
-- Table structure for table `pos_receivings_payments`
--

DROP TABLE IF EXISTS `pos_receivings_payments`;
CREATE TABLE IF NOT EXISTS `pos_receivings_payments` (
  `receiving_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`receiving_id`,`payment_type`),
  KEY `receiving_id` (`receiving_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_receivings_payments`
--

INSERT INTO `pos_receivings_payments` (`receiving_id`, `payment_type`, `payment_amount`) VALUES
(1, 'Cash', '52.50'),
(4, 'Cash', '26.25'),
(5, 'Cash', '26.25'),
(6, 'Cash', '52.50'),
(7, 'Cash', '26.25'),
(8, 'Cash', '26.25');

-- --------------------------------------------------------

--
-- Table structure for table `pos_receivings_taxes`
--

DROP TABLE IF EXISTS `pos_receivings_taxes`;
CREATE TABLE IF NOT EXISTS `pos_receivings_taxes` (
  `receiving_id` int(10) NOT NULL,
  `tax_type` smallint(2) NOT NULL,
  `tax_group` varchar(32) NOT NULL,
  `sale_tax_basis` decimal(15,4) NOT NULL,
  `sale_tax_amount` decimal(15,4) NOT NULL,
  `print_sequence` tinyint(2) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `tax_rate` decimal(15,4) NOT NULL,
  `sales_tax_code` varchar(32) NOT NULL DEFAULT '',
  `rounding_code` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`receiving_id`,`tax_type`,`tax_group`),
  KEY `print_sequence` (`receiving_id`,`print_sequence`,`tax_type`,`tax_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_receivings_taxes`
--

INSERT INTO `pos_receivings_taxes` (`receiving_id`, `tax_type`, `tax_group`, `sale_tax_basis`, `sale_tax_amount`, `print_sequence`, `name`, `tax_rate`, `sales_tax_code`, `rounding_code`) VALUES
(1, 1, '5% VAT', '50.0000', '2.5000', 0, 'VAT', '5.0000', '', 1),
(4, 1, '5% VAT', '25.0000', '1.2500', 0, 'VAT', '5.0000', '', 1),
(5, 1, '5% VAT', '25.0000', '1.2500', 0, 'VAT', '5.0000', '', 1),
(6, 1, '5% VAT', '50.0000', '2.5000', 0, 'VAT', '5.0000', '', 1),
(7, 1, '5% VAT', '25.0000', '1.2500', 0, 'VAT', '5.0000', '', 1),
(8, 1, '5% VAT', '25.0000', '1.2500', 0, 'VAT', '5.0000', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales`
--

DROP TABLE IF EXISTS `pos_sales`;
CREATE TABLE IF NOT EXISTS `pos_sales` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text,
  `invoice_number` varchar(32) DEFAULT NULL,
  `quote_number` varchar(32) DEFAULT NULL,
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `sale_status` tinyint(2) NOT NULL DEFAULT '0',
  `dinner_table_id` int(11) DEFAULT NULL,
  `work_order_number` varchar(32) DEFAULT NULL,
  `sale_type` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`),
  UNIQUE KEY `invoice_number` (`invoice_number`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  KEY `sale_time` (`sale_time`),
  KEY `dinner_table_id` (`dinner_table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_sales`
--

INSERT INTO `pos_sales` (`sale_time`, `customer_id`, `employee_id`, `comment`, `invoice_number`, `quote_number`, `sale_id`, `sale_status`, `dinner_table_id`, `work_order_number`, `sale_type`) VALUES
('2019-10-29 20:44:57', NULL, 1, '', NULL, NULL, 1, 0, NULL, NULL, 0),
('2019-10-29 21:21:16', NULL, 1, '', NULL, NULL, 2, 0, NULL, NULL, 0),
('2019-11-01 00:17:38', NULL, 1, '', NULL, NULL, 3, 0, NULL, NULL, 0),
('2019-11-06 08:15:50', 2, 1, '', NULL, NULL, 4, 0, NULL, NULL, 0),
('2019-11-08 23:08:01', NULL, 1, '', NULL, NULL, 5, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales_accounts`
--

DROP TABLE IF EXISTS `pos_sales_accounts`;
CREATE TABLE IF NOT EXISTS `pos_sales_accounts` (
  `trans_id` int(10) NOT NULL AUTO_INCREMENT,
  `thedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(125) DEFAULT NULL,
  `notes` varchar(125) DEFAULT NULL,
  `employee_id` int(10) DEFAULT NULL,
  `account_id` int(10) NOT NULL,
  `location_id` varchar(10) DEFAULT NULL,
  `credit_amount` decimal(10,2) DEFAULT NULL,
  `debit_amount` decimal(10,2) DEFAULT NULL,
  `balance_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_sales_accounts`
--

INSERT INTO `pos_sales_accounts` (`trans_id`, `thedate`, `description`, `notes`, `employee_id`, `account_id`, `location_id`, `credit_amount`, `debit_amount`, `balance_amount`) VALUES
(1, '2019-11-06 08:15:50', 'SINV - POS 4', NULL, 1, 2, NULL, '528.00', '1050.00', '522.00');

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales_items`
--

DROP TABLE IF EXISTS `pos_sales_items`;
CREATE TABLE IF NOT EXISTS `pos_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(15,3) NOT NULL DEFAULT '0.000',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_type` tinyint(2) NOT NULL DEFAULT '0',
  `item_location` int(11) NOT NULL,
  `print_option` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `sale_id` (`sale_id`),
  KEY `item_id` (`item_id`),
  KEY `item_location` (`item_location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_sales_items`
--

INSERT INTO `pos_sales_items` (`sale_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount`, `discount_type`, `item_location`, `print_option`) VALUES
(1, 1, '', '', 1, '1.000', '25.00', '55.00', '0.00', 0, 1, 0),
(2, 1, '', '', 1, '1.000', '25.00', '55.00', '0.00', 0, 1, 0),
(3, 1, '', '3232', 1, '1.000', '25.00', '55.00', '0.00', 0, 1, 0),
(4, 1, '', '', 1, '1.000', '25.00', '1000.00', '0.00', 0, 1, 0),
(5, 1, '', '', 1, '1.000', '25.00', '3435465.00', '0.00', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales_items_taxes`
--

DROP TABLE IF EXISTS `pos_sales_items_taxes`;
CREATE TABLE IF NOT EXISTS `pos_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax_type` tinyint(2) NOT NULL DEFAULT '0',
  `rounding_code` tinyint(2) NOT NULL DEFAULT '0',
  `cascade_tax` tinyint(2) NOT NULL DEFAULT '0',
  `cascade_sequence` tinyint(2) NOT NULL DEFAULT '0',
  `item_tax_amount` decimal(15,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `sale_id` (`sale_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_sales_items_taxes`
--

INSERT INTO `pos_sales_items_taxes` (`sale_id`, `item_id`, `line`, `name`, `percent`, `tax_type`, `rounding_code`, `cascade_tax`, `cascade_sequence`, `item_tax_amount`) VALUES
(1, 1, 1, 'Standard', '10.0000', 1, 1, 0, 0, '5.5000'),
(2, 1, 1, 'Standard', '10.0000', 1, 1, 0, 0, '5.5000'),
(3, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '2.7500'),
(4, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '50.0000'),
(5, 1, 1, 'VAT', '5.0000', 1, 1, 0, 0, '171773.2500');

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales_payments`
--

DROP TABLE IF EXISTS `pos_sales_payments`;
CREATE TABLE IF NOT EXISTS `pos_sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`),
  KEY `sale_id` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_sales_payments`
--

INSERT INTO `pos_sales_payments` (`sale_id`, `payment_type`, `payment_amount`) VALUES
(1, 'Cash', '60.50'),
(2, 'Cash', '60.50'),
(3, 'Cash', '57.75'),
(4, 'Cash', '100.00'),
(4, 'Check', '155.00'),
(4, 'Credit', '522.00'),
(4, 'Credit Card', '123.00'),
(4, 'Debit Card', '150.00'),
(5, 'Cash', '3607238.25');

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales_reward_points`
--

DROP TABLE IF EXISTS `pos_sales_reward_points`;
CREATE TABLE IF NOT EXISTS `pos_sales_reward_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `earned` float NOT NULL,
  `used` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_sales_taxes`
--

DROP TABLE IF EXISTS `pos_sales_taxes`;
CREATE TABLE IF NOT EXISTS `pos_sales_taxes` (
  `sale_id` int(10) NOT NULL,
  `tax_type` smallint(2) NOT NULL,
  `tax_group` varchar(32) NOT NULL,
  `sale_tax_basis` decimal(15,4) NOT NULL,
  `sale_tax_amount` decimal(15,4) NOT NULL,
  `print_sequence` tinyint(2) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `tax_rate` decimal(15,4) NOT NULL,
  `sales_tax_code` varchar(32) NOT NULL DEFAULT '',
  `rounding_code` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`tax_type`,`tax_group`),
  KEY `print_sequence` (`sale_id`,`print_sequence`,`tax_type`,`tax_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_sales_taxes`
--

INSERT INTO `pos_sales_taxes` (`sale_id`, `tax_type`, `tax_group`, `sale_tax_basis`, `sale_tax_amount`, `print_sequence`, `name`, `tax_rate`, `sales_tax_code`, `rounding_code`) VALUES
(1, 1, '10% Standard', '55.0000', '5.5000', 5, 'Standard', '10.0000', 'VAT 10%', 1),
(2, 1, '10% Standard', '55.0000', '5.5000', 5, 'Standard', '10.0000', 'VAT 10%', 1),
(3, 1, '5% VAT', '55.0000', '2.7500', 0, 'VAT', '5.0000', '', 1),
(4, 1, '5% VAT', '1000.0000', '50.0000', 0, 'VAT', '5.0000', '', 1),
(5, 1, '5% VAT', '3435465.0000', '171773.2500', 0, 'VAT', '5.0000', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_sessions`
--

DROP TABLE IF EXISTS `pos_sessions`;
CREATE TABLE IF NOT EXISTS `pos_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_sessions`
--

INSERT INTO `pos_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('4127u2jr0q7t8nsci2brteoio4td1912', '::1', 1572478005, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323437383030353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f636172747c613a313a7b693a313b613a31393a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31313a226974656d5f6e756d626572223b4e3b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a303a22223b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2231223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a383a227175616e74697479223b693a313b733a383a22646973636f756e74223b693a303b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a363a222d312e303030223b733a353a227072696365223b733a353a2232352e3030223b733a31383a22726563656976696e675f7175616e74697479223b733a353a22312e303030223b733a32363a22726563656976696e675f7175616e746974795f63686f69636573223b613a313a7b693a313b733a323a227831223b7d733a353a22746f74616c223b733a373a2232352e30303030223b7d7d726563765f6d6f64657c733a373a2272656365697665223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b726563765f737570706c6965727c693a2d313b),
('ct3e5udi9jslsfgcaqrqlfrica8ih9e3', '::1', 1572478429, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323437383432393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b726563765f636172747c613a313a7b693a313b613a31393a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31313a226974656d5f6e756d626572223b4e3b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a303a22223b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2231223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a383a227175616e74697479223b693a323b733a383a22646973636f756e74223b693a303b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22312e303030223b733a353a227072696365223b733a353a2232352e3030223b733a31383a22726563656976696e675f7175616e74697479223b733a353a22312e303030223b733a32363a22726563656976696e675f7175616e746974795f63686f69636573223b613a313a7b693a313b733a323a227831223b7d733a353a22746f74616c223b733a373a2235302e30303030223b7d7d726563765f6d6f64657c733a373a2272656365697665223b726563765f737570706c6965727c693a2d313b),
('om8og2mbcv51vp0l1idiq3vg63u4aceb', '::1', 1572478962, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323437383936323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('abl2tks3ac8ctmlrrvvukp7bml0qlli5', '::1', 1572479319, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323437393331393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('5tlrqpp5dt5p0mh9hm1esv29lk1s6ks8', '::1', 1572479656, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323437393635363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('70om0dl5l3360f3u5t4hfr4hcfb06l5q', '::1', 1572479995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323437393939353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('qq33pl6dkmdcbs3n0qirrljv8go4d3ue', '::1', 1572480429, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323438303432393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('nub21uf1r3n8qt7ck4cvfa4o3hpsb1ij', '::1', 1572480731, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323438303733313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('7ji00i8epnfs3qlvmlh43as2n77nsvbj', '::1', 1572481111, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323438313131313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('efvac1tfvtmdvabrotcve61f0pb7d4ie', '::1', 1572481511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323438313531313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('cn6r3p8kvjdem1ftvcb3mp72156p5vqo', '::1', 1572481633, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323438313531313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b726563765f73746f636b5f736f757263657c733a313a2231223b726563765f73746f636b5f64657374696e6174696f6e7c733a313a2231223b),
('tbopb7je9i5ffolnbu8su2rl8t59koqo', '::1', 1572517790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323531373739303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('3a6s2rpb9psjorcenu2aou1q1au442p1', '::1', 1572518740, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323531383734303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('hu4i8e1lfrr40bghmek4b0583qcfcok6', '::1', 1572519417, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323531393431373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('a1v4msuk7s7rf73ma3u7tcfv9o1pipbd', '::1', 1572519833, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323531393833333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('am15s0vtipobqse9o59emgdm8okta8iu', '::1', 1572520869, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323532303836393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('ke6f493ekp9migosaf87cmnbe79skjtv', '::1', 1572521205, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323532313230353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('16ftlvq0t63243ja1juuoo5vmo38prjh', '::1', 1572521461, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323532313230353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('qrqra3693rt8kedelkb2ruajhg3t000d', '::1', 1572541999, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534313939393b),
('ai92j3bl68l446vgunifn3gm0cqaag89', '::1', 1572542434, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534323433343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('06c8o5ctn0jd6n5uoo9bcnoh5nl8u75e', '::1', 1572542739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534323733393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('socur6mtg1ib7lv15odvfkkvta4rceih', '::1', 1572543777, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534333737373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('1d88uk1jbslne3vbp34b9m29jkkndt78', '::1', 1572544287, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534343238373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('brt7qd3u8rg6betpiksjjbabdntkbj4b', '::1', 1572544600, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534343630303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('hvp6tin82820d06b783at8g59nledm08', '::1', 1572544951, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534343935313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('39latmcfu4ghh47h0sufsa9agu2craq6', '::1', 1572545381, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534353338313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('dspg0do8l1ug20l87aoa0beqeqj73sp5', '::1', 1572546207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534363230373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('qi82jjbr8uijghtdgdml4p7907pl4o3h', '::1', 1572546894, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534363839343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('69lpsbb6trji66120batnehlbpenblpa', '::1', 1572546895, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323534363839343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('669imhb9qhuas2v8t56830s0itthdd7l', '::1', 1572563178, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536333137383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('0ce94l6j43lr0chf4ua5qfnsj9u6if9j', '::1', 1572564008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536343030383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('hul74r9pvi7gi33sofig8cqc1veqq74s', '::1', 1572564367, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536343336373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('fss9d9tpl8h83ro3gd9555i1ck26em7b', '::1', 1572564701, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536343730313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('uletd3j5t6otenfm315bpkhqpsjtei6f', '::1', 1572565169, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536353136393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('ldu79imv7apud2dlsqh07gjtu04ivlfd', '::1', 1572565546, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536353534363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('5l9mpvp6g6s4etfafc5btttd79fgc3v2', '::1', 1572566116, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536363131363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('lfa184c9qsncv2nbt3c7mrf5s50nvr9g', '::1', 1572566442, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536363434323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('7n367g6rkl935a23qk68u3tudl7l2cm5', '::1', 1572566768, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536363736383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('clom27jcrc68kfhplv8ga74mholacs8n', '::1', 1572567118, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536373131383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('shubvk5884rfai32ooe2jm4plk5jht11', '::1', 1572567419, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536373431393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('ns4uuom50kqhjee97k6uge4ur97vugh8', '::1', 1572567752, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536373735323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b),
('gmb2754jeqhg0v2jeoonbh5500pgjqku', '::1', 1572567975, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323536373735323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b),
('cgvb7blahosksgje07srcb1qg1or04ur', '::1', 1572639796, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323633393739363b),
('setvu0cjc5dk1m6tii3hfum3932pk48q', '::1', 1572639802, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323633393739363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f636172747c613a303a7b7d73616c65735f637573746f6d65727c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b7461625f6c6f636174696f6e7c733a353a22236974656d223b73616c65735f7061796d656e74737c613a303a7b7d636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f696e766f6963655f6e756d6265727c4e3b),
('uruvi4gqacsa2d3m369jr2uveavhcf32', '::1', 1572775010, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737353031303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c733a313a2233223b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f637573746f6d65727c693a2d313b73616c65735f636172747c613a313a7b693a313b613a32353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226974656d5f6e756d626572223b4e3b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a343a2233323332223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a393a22756e69745f74797065223b733a333a22504353223b733a383a227175616e74697479223b733a353a22312e303030223b733a383a22646973636f756e74223b733a343a22302e3030223b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22342e303030223b733a353a227072696365223b733a353a2235352e3030223b733a31303a22636f73745f7072696365223b733a353a2232352e3030223b733a353a22746f74616c223b733a373a2235352e30303030223b733a31363a22646973636f756e7465645f746f74616c223b733a373a2235352e30303030223b733a31323a227072696e745f6f7074696f6e223b733a313a2230223b733a31303a2273746f636b5f74797065223b733a313a2230223b733a393a226974656d5f74797065223b733a313a2230223b733a31353a227461785f63617465676f72795f6964223b733a313a2230223b733a31303a2274617865645f72617465223b643a322e37353b7d7d73616c65735f7061796d656e74737c613a313a7b733a343a2243617368223b613a323a7b733a31323a227061796d656e745f74797065223b733a343a2243617368223b733a31343a227061796d656e745f616d6f756e74223b733a353a2235372e3735223b7d7d73616c65735f71756f74655f6e756d6265727c4e3b73616c655f747970657c733a313a2230223b73616c65735f636f6d6d656e747c733a303a22223b64696e6e65725f7461626c657c4e3b),
('k93u9fn70pnh0sp2kl0uic3n9terb52a', '::1', 1572775637, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737353633373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('1kgam55mol507lnskknjjk0jmgre3g72', '::1', 1572776048, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737363034383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c733a313a2233223b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f637573746f6d65727c693a2d313b73616c65735f636172747c613a313a7b693a313b613a32353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226974656d5f6e756d626572223b4e3b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a343a2233323332223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a393a22756e69745f74797065223b733a333a22504353223b733a383a227175616e74697479223b733a353a22312e303030223b733a383a22646973636f756e74223b733a343a22302e3030223b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22342e303030223b733a353a227072696365223b733a353a2235352e3030223b733a31303a22636f73745f7072696365223b733a353a2232352e3030223b733a353a22746f74616c223b733a373a2235352e30303030223b733a31363a22646973636f756e7465645f746f74616c223b733a373a2235352e30303030223b733a31323a227072696e745f6f7074696f6e223b733a313a2230223b733a31303a2273746f636b5f74797065223b733a313a2230223b733a393a226974656d5f74797065223b733a313a2230223b733a31353a227461785f63617465676f72795f6964223b733a313a2230223b733a31303a2274617865645f72617465223b643a322e37353b7d7d73616c65735f7061796d656e74737c613a313a7b733a343a2243617368223b613a323a7b733a31323a227061796d656e745f74797065223b733a343a2243617368223b733a31343a227061796d656e745f616d6f756e74223b733a353a2235372e3735223b7d7d73616c65735f71756f74655f6e756d6265727c4e3b73616c655f747970657c733a313a2230223b73616c65735f636f6d6d656e747c733a303a22223b64696e6e65725f7461626c657c4e3b),
('392qtt62vvaonp6if0nhe7no1jtspt65', '::1', 1572776405, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737363430353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('68oobfr1sivvnniet0vbus3dq5rh20rt', '::1', 1572776734, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737363733343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('1rc2p7qpbmebqrs7kf9vhdcvb8r69h1l', '::1', 1572777060, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737373036303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('d53lsvdfn0kaihkpvtngh0826djkckv1', '::1', 1572777513, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737373531333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('qllpap2ukb4qcbehirr2l8h9scjp5e43', '::1', 1572777826, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737373832363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('8m0hcpdv51i8a0b8mg0aimmd12n26je0', '::1', 1572778311, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737383331313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('fj93v2ilq853rgrof5qg5a0k8dhlof4d', '::1', 1572778646, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737383634363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('m7k4icl50do7t8v7rcv17r49tcl39me0', '::1', 1572779015, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737393031353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('qi3t71t3icqen0rniq4gn93ba004gdci', '::1', 1572779402, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737393430323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('4vjdo5e1g2mqdo8odiv82arti62v4kbv', '::1', 1572779738, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323737393733383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('iro24j3pg39aoprbv473oesnfucciac2', '::1', 1572780085, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323738303038353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('s9thjq35522fdopsjea0k2gfg3p9ke77', '::1', 1572780207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323738303038353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('7q02mc5257tqoo65tb0v9kd85u29http', '::1', 1572804874, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323830343837343b),
('h4ek0qqvjogc0f26jqaoa8etao6ebpfh', '::1', 1572805228, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323830353232383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f636172747c613a313a7b693a313b613a32353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226974656d5f6e756d626572223b4e3b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a303a22223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a393a22756e69745f74797065223b733a333a22504353223b733a383a227175616e74697479223b693a313b733a383a22646973636f756e74223b733a313a2230223b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22342e303030223b733a353a227072696365223b733a353a2235352e3030223b733a31303a22636f73745f7072696365223b733a353a2232352e3030223b733a353a22746f74616c223b733a353a2235352e3030223b733a31363a22646973636f756e7465645f746f74616c223b733a373a2235352e30303030223b733a31323a227072696e745f6f7074696f6e223b693a303b733a31303a2273746f636b5f74797065223b733a313a2230223b733a393a226974656d5f74797065223b733a313a2230223b733a31353a227461785f63617465676f72795f6964223b733a313a2230223b733a31303a2274617865645f72617465223b643a322e37353b7d7d73616c65735f637573746f6d65727c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b7461625f6c6f636174696f6e7c733a353a222e74616232223b73616c65735f7061796d656e74737c613a303a7b7d636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f696e766f6963655f6e756d6265727c4e3b),
('n5vb7uq6j2lirk2u5o4kr7dp126fkj2c', '::1', 1572805228, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323830353232383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f636172747c613a313a7b693a313b613a32353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226974656d5f6e756d626572223b4e3b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a343a2233323332223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a393a22756e69745f74797065223b733a333a22504353223b733a383a227175616e74697479223b643a313b733a383a22646973636f756e74223b733a313a2230223b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22342e303030223b733a353a227072696365223b643a35353b733a31303a22636f73745f7072696365223b733a353a2232352e3030223b733a353a22746f74616c223b733a323a223535223b733a31363a22646973636f756e7465645f746f74616c223b733a373a2235352e30303030223b733a31323a227072696e745f6f7074696f6e223b693a303b733a31303a2273746f636b5f74797065223b733a313a2230223b733a393a226974656d5f74797065223b733a313a2230223b733a31353a227461785f63617465676f72795f6964223b733a313a2230223b733a31303a2274617865645f72617465223b643a322e37353b7d7d73616c65735f637573746f6d65727c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b7461625f6c6f636174696f6e7c733a353a22236974656d223b73616c65735f7061796d656e74737c613a303a7b7d636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f696e766f6963655f6e756d6265727c4e3b),
('ed1l2u7uls919msqm42qpn757getr5td', '::1', 1572822342, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832323334323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b),
('kqgpb7sqtn0kphd71comr1pubja7co5n', '::1', 1572822728, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832323732383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a303b6974656d5f6c6f636174696f6e7c733a313a2231223b),
('sa2iana6fhrk8l89nslcv2vrdadq84gi', '::1', 1572823054, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832333035343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('m65nq3daaa526m8ovsb4cpvk8vg727vr', '::1', 1572823377, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832333337373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('4a7bo8c63484663pv6l0otkkon39ta09', '::1', 1572823696, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832333639363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('2iosvgthnkc9ntkn6f8r92be91q6t8a2', '::1', 1572824001, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832343030313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('rp8eeuhsq2ie81tr1r9ggvqe1p6p0dh3', '::1', 1572824454, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832343435343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('ki1f0r27u5ietnf6981jji6drrrgqr17', '::1', 1572824766, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832343736363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('hefgr60ikk1s6l9nkbino01qajaqo99m', '::1', 1572825122, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832353132323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('l7jn8rnr60fei06efs3tok5b2rm4csa8', '::1', 1572825531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832353533313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('khcji7epd75udrup3lqle2rq1en2h232', '::1', 1572825853, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832353835333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('c8ht293mes8bo7mq3h9a3edl5ej37n68', '::1', 1572825932, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323832353835333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b6974656d5f6c6f636174696f6e7c733a313a2231223b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('7jo1mj4aakii63bjmvhl3mhq4bp9vv1d', '::1', 1572866605, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323836363630343b),
('n8ddkv17p7ntb0e8cil8930arap52fm4', '::1', 1573027982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333032373938323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b),
('viophql4uqfh5768njpa91ur9fnggihp', '::1', 1573028306, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333032383330363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('vfbih8o85al9v0s7pqotec47oj5t484d', '::1', 1573028637, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333032383633373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('qpfj4a2u3csok027bju1t9ov2gf56jfn', '::1', 1573028995, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333032383939353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('j10o2kni2cjirh8mfokg7lfu7tuk87be', '::1', 1573031476, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333033313437363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('rn10dfnv5p4i5q1apc6hmafn73h35gt7', '::1', 1573034531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333033343533313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('1etfv9qpqp7ll1r51d8omi5gt3tp9g9u', '::1', 1573034924, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333033343932343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('m8am4vik468ej059ju806qakcse82trv', '::1', 1573035349, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333033353334393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('91v446jtkkmsgar8kmu1o6n0p2ntg8gt', '::1', 1573035653, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333033353635333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('v1oepf01rjah7a0j4bc0j4dhnqgnnlt8', '::1', 1573035933, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333033353635333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b637573746f6d65725f6c6f636174696f6e7c733a313a2231223b),
('a4cbqob7shfd6a6srcs4i9ar6h6vu1s5', '::1', 1573241670, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234313637303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('bvt69m1nplrkn5g2bab29rrk427asukm', '::1', 1573242031, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234323033313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('pcfu2mnkervtgh65vrmu1oual7nr7bba', '::1', 1573242344, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234323334343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('fjuhq6rta186jtrb9bnh8m75ar7bplgg', '::1', 1573242666, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234323636363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('1eslttq963hlb5voocgi20b4ddoerpkl', '::1', 1573242982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234323938323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('e59u6t15jg50bh2bi4ia67itm7agfcg8', '::1', 1573243356, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234333335363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('bh17esgps25ca39bicpk96eggru8lekr', '::1', 1573244514, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234343531343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('1qms8bmk9mh9se2u7m2d24se4fke91eh', '::1', 1573245354, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234353335343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('dui5mpuno5f2i6bc6oab2g0hbsgps3b9', '::1', 1573245739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234353733393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('j7ur3v9lcsvsi13l0l5libilukf9vodb', '::1', 1573246059, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234363035393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('om0n2njn7081rbl11u08fn6dk0ln8vtg', '::1', 1573246410, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234363431303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('1pi2h8d339hsf23kabqpmjcikp1so045', '::1', 1573246718, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234363731383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('74n50oq5qps6atktg5tkqdhpc2vn0ol1', '::1', 1573247024, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234373032343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('sl0liopet6o16g707g30uq2fblq3evaq', '::1', 1573247347, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234373334373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b);
INSERT INTO `pos_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('kst3m0nts32t9gfui6q0re54eppkfju9', '::1', 1573247662, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234373636323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c733a313a2234223b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f637573746f6d65727c733a313a2232223b73616c65735f636172747c613a313a7b693a313b613a32353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226974656d5f6e756d626572223b4e3b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a303a22223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a393a22756e69745f74797065223b733a333a22504353223b733a383a227175616e74697479223b733a353a22312e303030223b733a383a22646973636f756e74223b733a343a22302e3030223b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22332e303030223b733a353a227072696365223b733a373a22313030302e3030223b733a31303a22636f73745f7072696365223b733a353a2232352e3030223b733a353a22746f74616c223b733a393a22313030302e30303030223b733a31363a22646973636f756e7465645f746f74616c223b733a393a22313030302e30303030223b733a31323a227072696e745f6f7074696f6e223b733a313a2230223b733a31303a2273746f636b5f74797065223b733a313a2230223b733a393a226974656d5f74797065223b733a313a2230223b733a31353a227461785f63617465676f72795f6964223b733a313a2230223b733a31303a2274617865645f72617465223b643a35303b7d7d73616c65735f7061796d656e74737c613a353a7b733a343a2243617368223b613a323a7b733a31323a227061796d656e745f74797065223b733a343a2243617368223b733a31343a227061796d656e745f616d6f756e74223b733a363a223130302e3030223b7d733a353a22436865636b223b613a323a7b733a31323a227061796d656e745f74797065223b733a353a22436865636b223b733a31343a227061796d656e745f616d6f756e74223b733a363a223135352e3030223b7d733a363a22437265646974223b613a323a7b733a31323a227061796d656e745f74797065223b733a363a22437265646974223b733a31343a227061796d656e745f616d6f756e74223b733a363a223532322e3030223b7d733a31313a224372656469742043617264223b613a323a7b733a31323a227061796d656e745f74797065223b733a31313a224372656469742043617264223b733a31343a227061796d656e745f616d6f756e74223b733a363a223132332e3030223b7d733a31303a2244656269742043617264223b613a323a7b733a31323a227061796d656e745f74797065223b733a31303a2244656269742043617264223b733a31343a227061796d656e745f616d6f756e74223b733a363a223135302e3030223b7d7d73616c65735f71756f74655f6e756d6265727c4e3b73616c655f747970657c733a313a2230223b73616c65735f636f6d6d656e747c733a303a22223b64696e6e65725f7461626c657c4e3b),
('lt8haaess0b8gfhaprh25fd5nc73556l', '::1', 1573249936, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333234393933363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('484i2pqg05j71ob4oplj100v14b609nm', '::1', 1573250289, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235303238393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('n6899171nag3kig38vmfvaho0ge1fcpn', '::1', 1573250604, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235303630343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('rvjkhvtnhl3h4mkvmivj529836q7b2h7', '::1', 1573250905, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235303930353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('1u8450ie2the0nb74mm7pjhm12pfd6of', '::1', 1573251213, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235313231333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c733a313a2231223b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f637573746f6d65727c693a2d313b73616c65735f636172747c613a313a7b693a313b613a32353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226974656d5f6e756d626572223b4e3b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a303a22223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a393a22756e69745f74797065223b733a333a22504353223b733a383a227175616e74697479223b733a353a22312e303030223b733a383a22646973636f756e74223b733a343a22302e3030223b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22332e303030223b733a353a227072696365223b733a353a2235352e3030223b733a31303a22636f73745f7072696365223b733a353a2232352e3030223b733a353a22746f74616c223b733a373a2235352e30303030223b733a31363a22646973636f756e7465645f746f74616c223b733a373a2235352e30303030223b733a31323a227072696e745f6f7074696f6e223b733a313a2230223b733a31303a2273746f636b5f74797065223b733a313a2230223b733a393a226974656d5f74797065223b733a313a2230223b733a31353a227461785f63617465676f72795f6964223b733a313a2230223b733a31303a2274617865645f72617465223b643a322e37353b7d7d73616c65735f7061796d656e74737c613a313a7b733a343a2243617368223b613a323a7b733a31323a227061796d656e745f74797065223b733a343a2243617368223b733a31343a227061796d656e745f616d6f756e74223b733a353a2236302e3530223b7d7d73616c65735f71756f74655f6e756d6265727c4e3b73616c655f747970657c733a313a2230223b73616c65735f636f6d6d656e747c733a303a22223b64696e6e65725f7461626c657c4e3b),
('kbs19bhjgec8bat68b4jju8e6cucuc54', '::1', 1573251588, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235313538383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('4r5p8n5p5k9mb25f5j468i6ua59eltnb', '::1', 1573252063, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235323036333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('mt900t4t3ifgovmnnd859mv3adup3b6i', '::1', 1573252364, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235323336343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('1ft26f8i5cvf15rhpigm7jauiq0k5b2r', '::1', 1573252689, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235323638393b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('voqjcds3vb5ko71ns66ausv9inuv0hpt', '::1', 1573253004, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235333030343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('jf5tasbtsmsc8n0stqqhtubot85riimf', '::1', 1573253316, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235333331363b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('9smqje2gt9kh2ia70peh1lquavgiqde2', '::1', 1573253668, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235333636383b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('ie9emk7rdjc9mfpja5vdttd8t2ia876t', '::1', 1573254267, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235343236373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('qmje64f95tha8of3juj6hkqoj5hjdgol', '::1', 1573254575, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235343537353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('nr7ap6l4rbua75ei51iu5mgme2ov9t2n', '::1', 1573254912, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235343931323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('jiplndvc4v35g5fuojbpuif6a51g0a55', '::1', 1573255271, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235353237313b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('i3qu4das2a5e7cl4464l0p7da6vn2f8e', '::1', 1573255592, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235353539323b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c733a313a2234223b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f637573746f6d65727c733a313a2232223b73616c65735f636172747c613a313a7b693a313b613a32353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226974656d5f6e756d626572223b4e3b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a303a22223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a393a22756e69745f74797065223b733a333a22504353223b733a383a227175616e74697479223b733a353a22312e303030223b733a383a22646973636f756e74223b733a343a22302e3030223b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22322e303030223b733a353a227072696365223b733a373a22313030302e3030223b733a31303a22636f73745f7072696365223b733a353a2232352e3030223b733a353a22746f74616c223b733a393a22313030302e30303030223b733a31363a22646973636f756e7465645f746f74616c223b733a393a22313030302e30303030223b733a31323a227072696e745f6f7074696f6e223b733a313a2230223b733a31303a2273746f636b5f74797065223b733a313a2230223b733a393a226974656d5f74797065223b733a313a2230223b733a31353a227461785f63617465676f72795f6964223b733a313a2230223b733a31303a2274617865645f72617465223b643a35303b7d7d73616c65735f7061796d656e74737c613a353a7b733a343a2243617368223b613a323a7b733a31323a227061796d656e745f74797065223b733a343a2243617368223b733a31343a227061796d656e745f616d6f756e74223b733a363a223130302e3030223b7d733a353a22436865636b223b613a323a7b733a31323a227061796d656e745f74797065223b733a353a22436865636b223b733a31343a227061796d656e745f616d6f756e74223b733a363a223135352e3030223b7d733a363a22437265646974223b613a323a7b733a31323a227061796d656e745f74797065223b733a363a22437265646974223b733a31343a227061796d656e745f616d6f756e74223b733a363a223532322e3030223b7d733a31313a224372656469742043617264223b613a323a7b733a31323a227061796d656e745f74797065223b733a31313a224372656469742043617264223b733a31343a227061796d656e745f616d6f756e74223b733a363a223132332e3030223b7d733a31303a2244656269742043617264223b613a323a7b733a31323a227061796d656e745f74797065223b733a31303a2244656269742043617264223b733a31343a227061796d656e745f616d6f756e74223b733a363a223135302e3030223b7d7d73616c65735f71756f74655f6e756d6265727c4e3b73616c655f747970657c733a313a2230223b73616c65735f636f6d6d656e747c733a303a22223b64696e6e65725f7461626c657c4e3b),
('pbs3e8fls0ojhjhtafvttnntnbkh0otq', '::1', 1573255923, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235353932333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('ib7252353nmihn8nes45b75lmen8brev', '::1', 1573256224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235363232343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('hfu42lv3ljbjhh6u9rnq1i57v0f9nq13', '::1', 1573256545, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235363534353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('4aq9f1fui9bs8lbaqf35khk7kl0smakg', '::1', 1573256850, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235363835303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('0dmknmofgrkog7lf17t9nest8bt7s0bj', '::1', 1573257184, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235373138343b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c733a313a2234223b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b636173685f6d6f64657c693a303b636173685f726f756e64696e677c693a303b73616c65735f637573746f6d65727c733a313a2232223b73616c65735f636172747c613a313a7b693a313b613a32353a7b733a373a226974656d5f6964223b733a313a2231223b733a31333a226974656d5f6c6f636174696f6e223b733a313a2231223b733a31303a2273746f636b5f6e616d65223b733a353a2253746f7265223b733a343a226c696e65223b693a313b733a343a226e616d65223b733a31313a22416c6661207c2045616368223b733a31313a226974656d5f6e756d626572223b4e3b733a31363a226174747269627574655f76616c756573223b733a303a22223b733a31313a226465736372697074696f6e223b733a303a22223b733a31323a2273657269616c6e756d626572223b733a303a22223b733a32313a22616c6c6f775f616c745f6465736372697074696f6e223b733a313a2230223b733a31333a2269735f73657269616c697a6564223b733a313a2231223b733a393a22756e69745f74797065223b733a333a22504353223b733a383a227175616e74697479223b733a353a22312e303030223b733a383a22646973636f756e74223b733a343a22302e3030223b733a31333a22646973636f756e745f74797065223b733a313a2230223b733a383a22696e5f73746f636b223b733a353a22322e303030223b733a353a227072696365223b733a373a22313030302e3030223b733a31303a22636f73745f7072696365223b733a353a2232352e3030223b733a353a22746f74616c223b733a393a22313030302e30303030223b733a31363a22646973636f756e7465645f746f74616c223b733a393a22313030302e30303030223b733a31323a227072696e745f6f7074696f6e223b733a313a2230223b733a31303a2273746f636b5f74797065223b733a313a2230223b733a393a226974656d5f74797065223b733a313a2230223b733a31353a227461785f63617465676f72795f6964223b733a313a2230223b733a31303a2274617865645f72617465223b643a35303b7d7d73616c65735f7061796d656e74737c613a353a7b733a343a2243617368223b613a323a7b733a31323a227061796d656e745f74797065223b733a343a2243617368223b733a31343a227061796d656e745f616d6f756e74223b733a363a223130302e3030223b7d733a353a22436865636b223b613a323a7b733a31323a227061796d656e745f74797065223b733a353a22436865636b223b733a31343a227061796d656e745f616d6f756e74223b733a363a223135352e3030223b7d733a363a22437265646974223b613a323a7b733a31323a227061796d656e745f74797065223b733a363a22437265646974223b733a31343a227061796d656e745f616d6f756e74223b733a363a223532322e3030223b7d733a31313a224372656469742043617264223b613a323a7b733a31323a227061796d656e745f74797065223b733a31313a224372656469742043617264223b733a31343a227061796d656e745f616d6f756e74223b733a363a223132332e3030223b7d733a31303a2244656269742043617264223b613a323a7b733a31323a227061796d656e745f74797065223b733a31303a2244656269742043617264223b733a31343a227061796d656e745f616d6f756e74223b733a363a223135302e3030223b7d7d73616c65735f71756f74655f6e756d6265727c4e3b73616c655f747970657c733a313a2230223b73616c65735f636f6d6d656e747c733a303a22223b64696e6e65725f7461626c657c4e3b),
('q3lr9hrk142qoqi36bca8ggupate8pd4', '::1', 1573257490, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235373439303b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('8o4pc477784j734055cfg86lgp2amer4', '::1', 1573257967, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235373936373b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('skqmpcepf698mq5orn8a3pjmhqvpm4d2', '::1', 1573258283, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235383238333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a363a226f6666696365223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('tsnb3hhk0ujp54rslr4hgtce7rqvmmm9', '::1', 1573258327, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333235383238333b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b616c6c6f775f74656d705f6974656d737c693a313b73616c655f69647c693a2d313b73616c65735f6d6f64657c733a343a2273616c65223b73616c65735f6c6f636174696f6e7c733a313a2231223b73616c65735f696e766f6963655f6e756d6265725f656e61626c65647c623a303b73616c65735f656d706c6f7965657c733a313a2231223b73616c65735f776f726b5f6f726465725f6e756d6265727c4e3b),
('bcdsdlte0ofr714mlftupcii8mtfgl05', '::1', 1573284403, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537333238343339353b706572736f6e5f69647c733a313a2231223b6d656e755f67726f75707c733a343a22686f6d65223b);

-- --------------------------------------------------------

--
-- Table structure for table `pos_stock_locations`
--

DROP TABLE IF EXISTS `pos_stock_locations`;
CREATE TABLE IF NOT EXISTS `pos_stock_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_stock_locations`
--

INSERT INTO `pos_stock_locations` (`location_id`, `location_name`, `deleted`) VALUES
(1, 'Store', 0),
(2, 'Stock2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_suppliers`
--

DROP TABLE IF EXISTS `pos_suppliers`;
CREATE TABLE IF NOT EXISTS `pos_suppliers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `agency_name` varchar(255) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `taxable` int(1) NOT NULL DEFAULT '1',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `category` tinyint(4) NOT NULL,
  `Vat_no` text,
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pos_tax_categories`
--

DROP TABLE IF EXISTS `pos_tax_categories`;
CREATE TABLE IF NOT EXISTS `pos_tax_categories` (
  `tax_category_id` int(10) NOT NULL AUTO_INCREMENT,
  `tax_category` varchar(32) NOT NULL,
  `tax_group_sequence` tinyint(2) NOT NULL,
  PRIMARY KEY (`tax_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_tax_categories`
--

INSERT INTO `pos_tax_categories` (`tax_category_id`, `tax_category`, `tax_group_sequence`) VALUES
(1, 'Standard', 5);

-- --------------------------------------------------------

--
-- Table structure for table `pos_tax_codes`
--

DROP TABLE IF EXISTS `pos_tax_codes`;
CREATE TABLE IF NOT EXISTS `pos_tax_codes` (
  `tax_code` varchar(32) NOT NULL,
  `tax_code_name` varchar(255) NOT NULL DEFAULT '',
  `tax_code_type` tinyint(2) NOT NULL DEFAULT '0',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`tax_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_tax_codes`
--

INSERT INTO `pos_tax_codes` (`tax_code`, `tax_code_name`, `tax_code_type`, `city`, `state`) VALUES
('VAT 10%', 'VAT Name 10%', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pos_tax_code_rates`
--

DROP TABLE IF EXISTS `pos_tax_code_rates`;
CREATE TABLE IF NOT EXISTS `pos_tax_code_rates` (
  `rate_tax_code` varchar(32) NOT NULL,
  `rate_tax_category_id` int(10) NOT NULL,
  `tax_rate` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `rounding_code` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rate_tax_code`,`rate_tax_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_tax_code_rates`
--

INSERT INTO `pos_tax_code_rates` (`rate_tax_code`, `rate_tax_category_id`, `tax_rate`, `rounding_code`) VALUES
('Vat 10%', 1, '10.0000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_total_tax`
--

DROP TABLE IF EXISTS `pos_total_tax`;
CREATE TABLE IF NOT EXISTS `pos_total_tax` (
  `taxid` int(8) NOT NULL AUTO_INCREMENT,
  `thedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(125) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `typ` text,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) DEFAULT '0.00',
  `total` decimal(10,2) DEFAULT '0.00',
  `taxed` int(11) NOT NULL DEFAULT '1',
  `deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`taxid`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=cp1256;

--
-- Dumping data for table `pos_total_tax`
--

INSERT INTO `pos_total_tax` (`taxid`, `thedate`, `description`, `employee_id`, `customer_id`, `typ`, `tax`, `subtotal`, `total`, `taxed`, `deleted`) VALUES
(1, '2019-10-28 00:00:40', 'RECV 1', 1, -1, 'Purchase', '2.50', '50.00', '52.50', 1, 0),
(2, '2019-10-29 20:44:58', 'POS 1', 1, -1, 'Sales', '5.50', '55.00', '60.50', 1, 0),
(3, '2019-10-29 21:21:16', 'POS 2', 1, -1, 'Sales', '5.50', '55.00', '60.50', 1, 0),
(4, '2019-10-30 23:27:07', 'RECV 4', 1, -1, 'Purchase', '1.25', '25.00', '26.25', 1, 0),
(5, '2019-10-30 23:27:40', 'RECV 5', 1, -1, 'Purchase', '1.25', '25.00', '26.25', 1, 0),
(6, '2019-10-30 23:34:32', 'RECV 6', 1, -1, 'Purchase', '2.50', '50.00', '52.50', 1, 0),
(7, '2019-10-30 23:35:06', 'RECV 7', 1, -1, 'Purchase', '1.25', '25.00', '26.25', 1, 0),
(8, '2019-10-30 23:35:44', 'RECV 8', 1, -1, 'Purchase', '1.25', '25.00', '26.25', 1, 0),
(9, '2019-11-01 00:17:38', 'POS 3', 1, -1, 'Sales', '2.75', '55.00', '57.75', 1, 0),
(10, '2019-11-06 08:15:50', 'POS 4', 1, 2, 'Sales', '50.00', '1000.00', '1050.00', 1, 0),
(11, '2019-11-08 23:08:02', 'POS 5', 1, -1, 'Sales', '171773.25', '3435465.00', '3607238.25', 1, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pos_accounts`
--
ALTER TABLE `pos_accounts`
  ADD CONSTRAINT `pos_accounts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `pos_employees` (`person_id`);

--
-- Constraints for table `pos_attribute_definitions`
--
ALTER TABLE `pos_attribute_definitions`
  ADD CONSTRAINT `fk_pos_attribute_definitions_ibfk_1` FOREIGN KEY (`definition_fk`) REFERENCES `pos_attribute_definitions` (`definition_id`);

--
-- Constraints for table `pos_attribute_links`
--
ALTER TABLE `pos_attribute_links`
  ADD CONSTRAINT `pos_attribute_links_ibfk_1` FOREIGN KEY (`definition_id`) REFERENCES `pos_attribute_definitions` (`definition_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pos_attribute_links_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `pos_attribute_values` (`attribute_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pos_attribute_links_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`),
  ADD CONSTRAINT `pos_attribute_links_ibfk_4` FOREIGN KEY (`receiving_id`) REFERENCES `pos_receivings` (`receiving_id`),
  ADD CONSTRAINT `pos_attribute_links_ibfk_5` FOREIGN KEY (`sale_id`) REFERENCES `pos_sales` (`sale_id`);

--
-- Constraints for table `pos_cash_up`
--
ALTER TABLE `pos_cash_up`
  ADD CONSTRAINT `pos_cash_up_ibfk_1` FOREIGN KEY (`open_employee_id`) REFERENCES `pos_employees` (`person_id`),
  ADD CONSTRAINT `pos_cash_up_ibfk_2` FOREIGN KEY (`close_employee_id`) REFERENCES `pos_employees` (`person_id`);

--
-- Constraints for table `pos_customers`
--
ALTER TABLE `pos_customers`
  ADD CONSTRAINT `pos_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `pos_people` (`person_id`),
  ADD CONSTRAINT `pos_customers_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `pos_customers_packages` (`package_id`);

--
-- Constraints for table `pos_customers_points`
--
ALTER TABLE `pos_customers_points`
  ADD CONSTRAINT `pos_customers_points_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `pos_customers` (`person_id`),
  ADD CONSTRAINT `pos_customers_points_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `pos_customers_packages` (`package_id`),
  ADD CONSTRAINT `pos_customers_points_ibfk_3` FOREIGN KEY (`sale_id`) REFERENCES `pos_sales` (`sale_id`);

--
-- Constraints for table `pos_employees`
--
ALTER TABLE `pos_employees`
  ADD CONSTRAINT `pos_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `pos_people` (`person_id`);

--
-- Constraints for table `pos_expenses`
--
ALTER TABLE `pos_expenses`
  ADD CONSTRAINT `pos_expenses_ibfk_1` FOREIGN KEY (`expense_category_id`) REFERENCES `pos_expense_categories` (`expense_category_id`),
  ADD CONSTRAINT `pos_expenses_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `pos_employees` (`person_id`),
  ADD CONSTRAINT `pos_expenses_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `pos_suppliers` (`person_id`);

--
-- Constraints for table `pos_giftcards`
--
ALTER TABLE `pos_giftcards`
  ADD CONSTRAINT `pos_giftcards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `pos_people` (`person_id`);

--
-- Constraints for table `pos_grants`
--
ALTER TABLE `pos_grants`
  ADD CONSTRAINT `pos_grants_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `pos_permissions` (`permission_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pos_grants_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `pos_employees` (`person_id`) ON DELETE CASCADE;

--
-- Constraints for table `pos_inventory`
--
ALTER TABLE `pos_inventory`
  ADD CONSTRAINT `pos_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `pos_items` (`item_id`),
  ADD CONSTRAINT `pos_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `pos_employees` (`person_id`),
  ADD CONSTRAINT `pos_inventory_ibfk_3` FOREIGN KEY (`trans_location`) REFERENCES `pos_stock_locations` (`location_id`);

--
-- Constraints for table `pos_items`
--
ALTER TABLE `pos_items`
  ADD CONSTRAINT `pos_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `pos_suppliers` (`person_id`);

--
-- Constraints for table `pos_items_taxes`
--
ALTER TABLE `pos_items_taxes`
  ADD CONSTRAINT `pos_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `pos_item_kit_items`
--
ALTER TABLE `pos_item_kit_items`
  ADD CONSTRAINT `pos_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `pos_item_kits` (`item_kit_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pos_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `pos_item_quantities`
--
ALTER TABLE `pos_item_quantities`
  ADD CONSTRAINT `pos_item_damages_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`),
  ADD CONSTRAINT `pos_item_damages_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `pos_stock_locations` (`location_id`),
  ADD CONSTRAINT `pos_item_quantities_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`),
  ADD CONSTRAINT `pos_item_quantities_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `pos_stock_locations` (`location_id`);

--
-- Constraints for table `pos_permissions`
--
ALTER TABLE `pos_permissions`
  ADD CONSTRAINT `pos_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `pos_modules` (`module_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pos_permissions_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `pos_stock_locations` (`location_id`) ON DELETE CASCADE;

--
-- Constraints for table `pos_receivings`
--
ALTER TABLE `pos_receivings`
  ADD CONSTRAINT `pos_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `pos_employees` (`person_id`),
  ADD CONSTRAINT `pos_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `pos_suppliers` (`person_id`);

--
-- Constraints for table `pos_receivings_items`
--
ALTER TABLE `pos_receivings_items`
  ADD CONSTRAINT `pos_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`),
  ADD CONSTRAINT `pos_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `pos_receivings` (`receiving_id`);

--
-- Constraints for table `pos_receivings_items_taxes`
--
ALTER TABLE `pos_receivings_items_taxes`
  ADD CONSTRAINT `pos_receivings_items_taxes_ibfk_1` FOREIGN KEY (`receiving_id`) REFERENCES `pos_receivings_items` (`receiving_id`),
  ADD CONSTRAINT `pos_receivings_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`);

--
-- Constraints for table `pos_sales`
--
ALTER TABLE `pos_sales`
  ADD CONSTRAINT `pos_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `pos_employees` (`person_id`),
  ADD CONSTRAINT `pos_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `pos_customers` (`person_id`),
  ADD CONSTRAINT `pos_sales_ibfk_3` FOREIGN KEY (`dinner_table_id`) REFERENCES `pos_dinner_tables` (`dinner_table_id`);

--
-- Constraints for table `pos_sales_items`
--
ALTER TABLE `pos_sales_items`
  ADD CONSTRAINT `pos_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`),
  ADD CONSTRAINT `pos_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `pos_sales` (`sale_id`),
  ADD CONSTRAINT `pos_sales_items_ibfk_3` FOREIGN KEY (`item_location`) REFERENCES `pos_stock_locations` (`location_id`);

--
-- Constraints for table `pos_sales_items_taxes`
--
ALTER TABLE `pos_sales_items_taxes`
  ADD CONSTRAINT `pos_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `pos_sales_items` (`sale_id`),
  ADD CONSTRAINT `pos_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `pos_items` (`item_id`);

--
-- Constraints for table `pos_sales_reward_points`
--
ALTER TABLE `pos_sales_reward_points`
  ADD CONSTRAINT `pos_sales_reward_points_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `pos_sales` (`sale_id`);

--
-- Constraints for table `pos_suppliers`
--
ALTER TABLE `pos_suppliers`
  ADD CONSTRAINT `pos_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `pos_people` (`person_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
