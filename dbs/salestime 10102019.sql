-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 09, 2019 at 11:39 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jizan_test`
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=cp1256;

--
-- Dumping data for table `pos_accounts`
--

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
('company', 'GANA GROCERY'),
('company_ar', 'مؤسسة جنى عبدالرحمن بن عيسى شماخي'),
('company_logo', ''),
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
('derive_sale_quantity', '0'),
('dinner_table_enable', '0'),
('disable_add_duplicate', '1'),
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
('receipt_template', 'receipt_default'),
('receiving_calculate_average_price', '1'),
('recv_invoice_format', '{CO}'),
('return_policy', 'CUSTOMER  SIGNATURE'),
('return_policy_ar', ' '),
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
('theme', 'Deafult'),
('thousands_separator', 'thousands_separator'),
('timeformat', 'H:i:s'),
('timezone', 'Asia/Riyadh'),
('vat_no', '٣١٠٣٧٧٤١٦٤٠٠٠٠٣'),
('version_code', 'MTU2OTE0MTYzMw=='),
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_attribute_definitions`
--



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

--
-- Dumping data for table `pos_attribute_links`
--


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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_attribute_values`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_expenses`
--

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
('config', 1, 'office'),
('employees', 1, 'office'),
('home', 1, 'office'),
('office', 1, 'home');
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_inventory`
--
 

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_items`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_item_kits`
--


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

--
-- Dumping data for table `pos_item_kit_items`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_people`
--

INSERT INTO `pos_people` (`first_name`, `last_name`, `gender`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES
('Admin', 'User', 1, '555-555-5555', 'mail@email.com', 'Address 1', '', '', '', '', '', '', 1);

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
('accounts_Store', 'accounts', 1),
('attributes', 'attributes', NULL),
('cashups', 'cashups', NULL),
('config', 'config', NULL),
('customers', 'customers', NULL),
('customers_Store', 'customers', 1),
('employees', 'employees', NULL),
('expenses', 'expenses', NULL),
('expenses_categories', 'expenses_categories', NULL),
('giftcards', 'giftcards', NULL),
('home', 'home', NULL),
('items', 'items', NULL),
('items_Store', 'items', 1),
('item_kits', 'item_kits', NULL),
('office', 'office', NULL),
('receivings', 'receivings', NULL),
('receivings_pdfrequisition', 'receivings', NULL),
('receivings_Store', 'receivings', 1),
('reports', 'reports', NULL),
('reports_cashonhands', 'reports', NULL),
('reports_cash_flows', 'reports', NULL),
('reports_categories', 'reports', NULL),
('reports_customers', 'reports', NULL),
('reports_discounts', 'reports', NULL),
('reports_employees', 'reports', NULL),
('reports_expenses_categories', 'reports', NULL),
('reports_generate_tax_report', 'reports', NULL),
('reports_inventory', 'reports', NULL),
('reports_items', 'reports', NULL),
('reports_payables', 'reports', NULL),
('reports_payments', 'reports', NULL),
('reports_receivable', 'reports', NULL),
('reports_receivables', 'reports', NULL),
('reports_receivings', 'reports', NULL),
('reports_receivingtaxes', 'reports', NULL),
('reports_sales', 'reports', NULL),
('reports_suppliers', 'reports', NULL),
('reports_taxes', 'reports', NULL),
('reports_taxfullreport', 'reports', NULL),
('reports_taxgeneratereport', 'reports', NULL),
('reports_tax_full_report', 'reports', NULL),
('sales', 'sales', NULL),
('sales_delete', 'sales', NULL),
('sales_disablenegative', 'sales', NULL),
('sales_pdfprint', 'sales', NULL),
('sales_rate', 'sales', NULL),
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_receivings`
--


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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_receivings_accounts`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_sales`
--


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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_sales_accounts`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pos_stock_locations`
--

INSERT INTO `pos_stock_locations` (`location_id`, `location_name`, `deleted`) VALUES
(1, 'Store', 0);

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

--
-- Dumping data for table `pos_suppliers`
--


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
(1, 'Standard', 10);

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=cp1256;

--
-- Dumping data for table `pos_total_tax`
--

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
