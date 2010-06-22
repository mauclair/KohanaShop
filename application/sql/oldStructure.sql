-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pondělí 07. června 2010, 20:24
-- Verze MySQL: 5.1.41
-- Verze PHP: 5.3.2-1ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Databáze: `bylinarstvicz`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `auth_user_md5`
--

CREATE TABLE IF NOT EXISTS `auth_user_md5` (
  `user_id` varchar(32) NOT NULL DEFAULT '',
  `username` varchar(32)  NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '',
  `perms` varchar(255) DEFAULT NULL,
  `reset_key` varchar(32) DEFAULT NULL,
  `reset_password` varchar(32) DEFAULT NULL,
  `advertisement` char(1) NOT NULL DEFAULT 'N',
  `checked` char(1) NOT NULL DEFAULT 'N',
  `chceVelkoobchod` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `k_username` (`username`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(128) NOT NULL DEFAULT '',
  `category_description` text,
  `category_publish` char(1) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL,
  `category_url` varchar(255) DEFAULT NULL,
  `vaha` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  ;

-- --------------------------------------------------------

--
-- Struktura tabulky `category_xref`
--

CREATE TABLE IF NOT EXISTS `category_xref` (
  `category_parent_id` int(11) NOT NULL DEFAULT '0',
  `category_child_id` int(11) NOT NULL DEFAULT '0',
  `category_list` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_parent_id`,`category_child_id`),
  KEY `category_child_id` (`category_child_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `clanky`
--

CREATE TABLE IF NOT EXISTS `clanky` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `category` varchar(128) NOT NULL DEFAULT '',
  `cteno` int(11) NOT NULL DEFAULT '0',
  `cdate` int(11) NOT NULL DEFAULT '0',
  `body` text NOT NULL,
  `top_menu` char(1) NOT NULL DEFAULT 'N',
  `language` char(3) NOT NULL DEFAULT 'cze',
  `weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM   ;

-- --------------------------------------------------------

--
-- Struktura tabulky `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL DEFAULT '0',
  `country_name` varchar(64) DEFAULT NULL,
  `country_3_code` varchar(3) DEFAULT NULL,
  `country_2_code` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `csv`
--

CREATE TABLE IF NOT EXISTS `csv` (
  `csv_product_sku` int(2) DEFAULT NULL,
  `csv_product_s_desc` int(2) DEFAULT NULL,
  `csv_product_desc` int(2) DEFAULT NULL,
  `csv_product_thumb_image` int(2) DEFAULT NULL,
  `csv_product_full_image` int(2) DEFAULT NULL,
  `csv_product_weight` int(2) DEFAULT NULL,
  `csv_product_weight_uom` int(2) DEFAULT NULL,
  `csv_product_length` int(2) DEFAULT NULL,
  `csv_product_width` int(2) DEFAULT NULL,
  `csv_product_height` int(2) DEFAULT NULL,
  `csv_product_lwh_uom` int(2) DEFAULT NULL,
  `csv_product_in_stock` int(2) DEFAULT NULL,
  `csv_product_available_date` int(2) DEFAULT NULL,
  `csv_product_special` int(2) DEFAULT NULL,
  `csv_product_discount_id` int(2) DEFAULT NULL,
  `csv_product_name` int(2) DEFAULT NULL,
  `csv_product_price` int(2) DEFAULT NULL,
  `csv_category_path` int(2) DEFAULT NULL
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(64) DEFAULT NULL,
  `currency_code` varchar(3) DEFAULT NULL,
  `format` varchar(15) NOT NULL,
  `multiplier` float NOT NULL DEFAULT '1',
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM  ;

-- --------------------------------------------------------

--
-- Struktura tabulky `function`
--

CREATE TABLE IF NOT EXISTS `function` (
  `function_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) DEFAULT NULL,
  `function_name` varchar(32) DEFAULT NULL,
  `function_class` varchar(32) DEFAULT NULL,
  `function_method` varchar(32) DEFAULT NULL,
  `function_description` text,
  `function_perms` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`function_id`)
) ENGINE=MyISAM   ;

-- --------------------------------------------------------

--
-- Struktura tabulky `indikace`
--

CREATE TABLE IF NOT EXISTS `indikace` (
  `indikace_id` int(11) NOT NULL AUTO_INCREMENT,
  `indikace_desc` varchar(64)  NOT NULL,
  `indikace_cze` varchar(100)  NOT NULL,
  `indikace_sk` varchar(100)  NOT NULL,
  `indikace_language_id` int(11) NOT NULL DEFAULT '0',
  `indikace_popis` text  NOT NULL,
  PRIMARY KEY (`indikace_id`)
) ENGINE=MyISAM     ;

-- --------------------------------------------------------

--
-- Struktura tabulky `indikace_joined`
--

CREATE TABLE IF NOT EXISTS `indikace_joined` (
  `product_id` int(11) NOT NULL,
  `i_refs_cze` text  NOT NULL,
  `i_refs_sk` text  NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM  ;

-- --------------------------------------------------------

--
-- Struktura tabulky `indikace_xref`
--

CREATE TABLE IF NOT EXISTS `indikace_xref` (
  `product_id` int(11) NOT NULL DEFAULT '0',
  `indikace_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`indikace_id`),
  KEY `indikace_id` (`indikace_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(64) DEFAULT NULL,
  `language_code` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) DEFAULT NULL,
  `module_description` text,
  `module_perms` varchar(255) DEFAULT NULL,
  `module_header` varchar(255) DEFAULT NULL,
  `module_footer` varchar(255) DEFAULT NULL,
  `module_publish` char(1) DEFAULT NULL,
  `list_order` int(11) DEFAULT NULL,
  `language_code_1` varchar(4) DEFAULT NULL,
  `language_code_2` varchar(4) DEFAULT NULL,
  `language_code_3` varchar(4) DEFAULT NULL,
  `language_code_4` varchar(4) DEFAULT NULL,
  `language_code_5` varchar(4) DEFAULT NULL,
  `language_file_1` varchar(255) DEFAULT NULL,
  `language_file_2` varchar(255) DEFAULT NULL,
  `language_file_3` varchar(255) DEFAULT NULL,
  `language_file_4` varchar(255) DEFAULT NULL,
  `language_file_5` varchar(255) DEFAULT NULL,
  `module_label_1` varchar(255) DEFAULT NULL,
  `module_label_2` varchar(255) DEFAULT NULL,
  `module_label_3` varchar(255) DEFAULT NULL,
  `module_label_4` varchar(255) DEFAULT NULL,
  `module_label_5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) NOT NULL DEFAULT '',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `order_number` int(32) DEFAULT NULL,
  `user_info_id` int(11) DEFAULT NULL,
  `order_subtotal` decimal(10,2) DEFAULT NULL,
  `order_tax` decimal(10,2) DEFAULT NULL,
  `order_shipping` decimal(10,2) DEFAULT NULL,
  `order_shipping_tax` decimal(10,2) DEFAULT NULL,
  `order_currency` varchar(16) DEFAULT NULL,
  `order_status` char(1) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL,
  `ship_method_id` int(11) DEFAULT NULL,
  `order_currency_multiplier` float NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `user_info_id` (`user_info_id`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `user_info_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_item_price` float DEFAULT NULL,
  `order_item_currency` varchar(16) DEFAULT NULL,
  `order_status` char(1) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `order_log`
--

CREATE TABLE IF NOT EXISTS `order_log` (
  `order_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32)  NOT NULL,
  `order_id` int(11) NOT NULL,
  `old_status` char(1)  NOT NULL,
  `new_status` char(1)  NOT NULL,
  `email_sent` char(1)  NOT NULL DEFAULT 'N',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`order_log_id`)
) ENGINE=MyISAM     ;

-- --------------------------------------------------------

--
-- Struktura tabulky `order_payment`
--

CREATE TABLE IF NOT EXISTS `order_payment` (
  `order_id` int(11) NOT NULL DEFAULT '0',
  `payment_method_id` int(11) DEFAULT NULL,
  `order_payment_number` blob,
  `order_payment_expire` int(11) DEFAULT NULL,
  `order_payment_name` varchar(255) DEFAULT NULL,
  `order_payment_log` text,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `order_status`
--

CREATE TABLE IF NOT EXISTS `order_status` (
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status_code` char(1) NOT NULL DEFAULT '',
  `order_status_name` varchar(64) DEFAULT NULL,
  `list_order` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_status_id`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `payment_method`
--

CREATE TABLE IF NOT EXISTS `payment_method` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) DEFAULT NULL,
  `payment_method_name` varchar(255) DEFAULT NULL,
  `shopper_group_id` int(11) DEFAULT NULL,
  `payment_method_discount` decimal(10,2) DEFAULT NULL,
  `list_order` int(11) DEFAULT NULL,
  `payment_method_code` varchar(8) DEFAULT NULL,
  `enable_processor` char(1) DEFAULT NULL,
  PRIMARY KEY (`payment_method_id`)
) ENGINE=MyISAM  ;

-- --------------------------------------------------------

--
-- Struktura tabulky `poradna`
--

CREATE TABLE IF NOT EXISTS `poradna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `title` varchar(125) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `has_child` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(125) NOT NULL DEFAULT '',
  `user_id` varchar(32) NOT NULL DEFAULT '',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `cdate` int(11) NOT NULL DEFAULT '0',
  `username` varchar(128) NOT NULL DEFAULT '',
  `referer` varchar(255) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Parent` (`parent_id`)
) ENGINE=MyISAM   ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `product_parent_id` int(11) DEFAULT NULL,
  `product_s_desc` varchar(255)  DEFAULT NULL,
  `product_desc` text ,
  `product_thumb_image` varchar(255)  DEFAULT NULL,
  `product_full_image` varchar(255)  DEFAULT NULL,
  `product_publish` char(1)  NOT NULL DEFAULT '''',
  `product_url` varchar(255)  DEFAULT NULL,
  `product_in_stock` int(11) DEFAULT NULL,
  `product_available_date` int(11) DEFAULT NULL,
  `product_special` char(1)  DEFAULT NULL,
  `product_discount_id` int(11) DEFAULT NULL,
  `product_taxes_id` int(11) DEFAULT '1',
  `ship_code_id` int(11) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL,
  `product_name` varchar(64)  DEFAULT NULL,
  `product_code` varchar(32)  NOT NULL,
  `product_expiration_date` int(11) NOT NULL,
  `PDK_kod` varchar(64)  NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `vendor` (`vendor_id`),
  KEY `product_taxes_id` (`product_taxes_id`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_attribute`
--

CREATE TABLE IF NOT EXISTS `product_attribute` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `attribute_name` char(255) NOT NULL DEFAULT '',
  `attribute_value` char(255) DEFAULT NULL,
  PRIMARY KEY (`attribute_id`),
  KEY `produkt` (`product_id`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_attribute_sku`
--

CREATE TABLE IF NOT EXISTS `product_attribute_sku` (
  `product_id` int(11) NOT NULL DEFAULT '0',
  `attribute_name` char(255) NOT NULL DEFAULT '',
  `attribute_list` int(11) DEFAULT NULL
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_category_xref`
--

CREATE TABLE IF NOT EXISTS `product_category_xref` (
  `category_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `product_list` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_clanky_xref`
--

CREATE TABLE IF NOT EXISTS `product_clanky_xref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unikatni` (`cid`,`product_id`)
) ENGINE=MyISAM   AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_comments`
--

CREATE TABLE IF NOT EXISTS `product_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `comment_added` int(11) NOT NULL,
  `comment_modified` int(11) NOT NULL,
  `comment_user` varchar(255)  NOT NULL,
  `comment_text` text  NOT NULL,
  `comment_parent` int(11) DEFAULT NULL,
  `comment_title` varchar(255)  NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_details`
--

CREATE TABLE IF NOT EXISTS `product_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `language_code` varchar(3)  NOT NULL,
  `contains` text  NOT NULL,
  `warning` text  NOT NULL,
  `aplication` text  NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM  ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_price`
--

CREATE TABLE IF NOT EXISTS `product_price` (
  `product_price_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `product_price` float DEFAULT NULL,
  `product_currency` char(16) DEFAULT NULL,
  `product_price_vdate` int(11) DEFAULT NULL,
  `product_price_edate` int(11) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL,
  `shopper_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_price_id`),
  KEY `product_id` (`product_id`),
  KEY `shopper_group_id` (`shopper_group_id`)
) ENGINE=MyISAM   ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_product_xref`
--

CREATE TABLE IF NOT EXISTS `product_product_xref` (
  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id_1` int(11) NOT NULL,
  `product_id_2` int(11) NOT NULL,
  PRIMARY KEY (`pp_id`),
  KEY `product_id_1` (`product_id_1`),
  KEY `product_id_2` (`product_id_2`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `product_taxes`
--

CREATE TABLE IF NOT EXISTS `product_taxes` (
  `product_taxes_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_taxes_name` varchar(64) NOT NULL DEFAULT '',
  `product_taxes_value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_taxes_id`)
) ENGINE=MyISAM   ;

-- --------------------------------------------------------

--
-- Struktura tabulky `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `search_id` int(11) NOT NULL AUTO_INCREMENT,
  `search_word` varchar(255)  NOT NULL,
  PRIMARY KEY (`search_id`)
) ENGINE=MyISAM   ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shipping`
--

CREATE TABLE IF NOT EXISTS `shipping` (
  `shipping_id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_name` varchar(128) NOT NULL DEFAULT '',
  `shipping_cost` float NOT NULL DEFAULT '0',
  `shipping_limit` int(11) NOT NULL DEFAULT '-1',
  `shipping_desc` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`shipping_id`)
) ENGINE=MyISAM    ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shopper_group`
--

CREATE TABLE IF NOT EXISTS `shopper_group` (
  `shopper_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) DEFAULT NULL,
  `shopper_group_name` varchar(32) DEFAULT NULL,
  `shopper_group_desc` text,
  PRIMARY KEY (`shopper_group_id`)
) ENGINE=MyISAM  ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shopper_vendor_xref`
--

CREATE TABLE IF NOT EXISTS `shopper_vendor_xref` (
  `user_id` varchar(32) NOT NULL DEFAULT '',
  `vendor_id` int(11) DEFAULT NULL,
  `shopper_group_id` int(11) DEFAULT NULL,
  `customer_number` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `shopper_group_id` (`shopper_group_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `tax_rate`
--

CREATE TABLE IF NOT EXISTS `tax_rate` (
  `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) DEFAULT NULL,
  `tax_state` varchar(64) DEFAULT NULL,
  `tax_country` varchar(64) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL,
  `tax_rate` decimal(10,4) DEFAULT NULL,
  PRIMARY KEY (`tax_rate_id`),
  KEY `vendor_id` (`vendor_id`)
) ENGINE=MyISAM  ;

-- --------------------------------------------------------

--
-- Struktura tabulky `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `user_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) NOT NULL DEFAULT '',
  `address_type` varchar(2) DEFAULT NULL,
  `address_type_name` varchar(32) DEFAULT NULL,
  `company` varchar(64) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `last_name` varchar(32)   DEFAULT NULL,
  `first_name` varchar(32)   DEFAULT NULL,
  `middle_name` varchar(32) DEFAULT NULL,
  `phone_1` varchar(32) DEFAULT NULL,
  `phone_2` varchar(32) DEFAULT NULL,
  `fax` varchar(32) DEFAULT NULL,
  `address_1` varchar(64) NOT NULL DEFAULT '',
  `address_2` varchar(64) DEFAULT NULL,
  `city` varchar(32) NOT NULL DEFAULT '',
  `state` varchar(32) NOT NULL DEFAULT '',
  `country` varchar(32) NOT NULL DEFAULT 'US',
  `zip` varchar(32) NOT NULL DEFAULT '',
  `user_email` varchar(255) DEFAULT NULL,
  `extra_field_1` varchar(255) DEFAULT NULL,
  `extra_field_2` varchar(255) DEFAULT NULL,
  `extra_field_3` varchar(255) DEFAULT NULL,
  `extra_field_4` char(1) DEFAULT NULL,
  `extra_field_5` char(1) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL,
  `ico` varchar(20) NOT NULL DEFAULT '',
  `dico` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_info_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(64) DEFAULT NULL,
  `contact_last_name` varchar(32) NOT NULL DEFAULT '',
  `contact_first_name` varchar(32) NOT NULL DEFAULT '',
  `contact_middle_name` varchar(32) DEFAULT NULL,
  `contact_title` varchar(32) DEFAULT NULL,
  `contact_phone_1` varchar(32) NOT NULL DEFAULT '',
  `contact_phone_2` varchar(32) DEFAULT NULL,
  `contact_fax` varchar(32) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `vendor_phone` varchar(32) DEFAULT NULL,
  `vendor_address_1` varchar(64) NOT NULL DEFAULT '',
  `vendor_address_2` varchar(64) DEFAULT NULL,
  `vendor_city` varchar(32) NOT NULL DEFAULT '',
  `vendor_state` varchar(32) NOT NULL DEFAULT '',
  `vendor_country` varchar(32) NOT NULL DEFAULT 'US',
  `vendor_zip` varchar(32) NOT NULL DEFAULT '',
  `vendor_store_name` varchar(128) NOT NULL DEFAULT '',
  `vendor_store_desc` text,
  `vendor_category_id` int(11) DEFAULT NULL,
  `vendor_thumb_image` varchar(255) DEFAULT NULL,
  `vendor_full_image` varchar(255) DEFAULT NULL,
  `vendor_currency` varchar(16) DEFAULT NULL,
  `cdate` int(11) DEFAULT NULL,
  `mdate` int(11) DEFAULT NULL,
  `vendor_image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`vendor_id`)
) ENGINE=MyISAM   ;

-- --------------------------------------------------------

--
-- Struktura tabulky `vendor_category`
--

CREATE TABLE IF NOT EXISTS `vendor_category` (
  `vendor_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_category_name` varchar(64) DEFAULT NULL,
  `vendor_category_desc` text,
  PRIMARY KEY (`vendor_category_id`)
) ENGINE=MyISAM   ;

-- --------------------------------------------------------

--
-- Struktura tabulky `zone_country`
--

CREATE TABLE IF NOT EXISTS `zone_country` (
  `country_id` int(11) NOT NULL DEFAULT '0',
  `zone_id` int(11) NOT NULL DEFAULT '1',
  `country_name` varchar(64) DEFAULT NULL,
  `country_3_code` varchar(3) DEFAULT NULL,
  `country_2_code` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM ;

-- --------------------------------------------------------

--
-- Struktura tabulky `zone_shipping`
--

CREATE TABLE IF NOT EXISTS `zone_shipping` (
  `zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_name` varchar(255) DEFAULT NULL,
  `zone_cost` decimal(10,2) DEFAULT NULL,
  `zone_limit` decimal(10,2) DEFAULT NULL,
  `zone_description` text NOT NULL,
  PRIMARY KEY (`zone_id`),
  KEY `zone_id` (`zone_id`)
) ENGINE=MyISAM   ;
