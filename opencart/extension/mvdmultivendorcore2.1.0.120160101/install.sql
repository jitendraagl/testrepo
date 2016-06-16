-- Replace prefix oc_ according to your database tables prefix before import

-- Dumping permission fields to `user` table
ALTER TABLE `oc_user` ADD cat_permission text COLLATE utf8_bin NOT NULL;
ALTER TABLE `oc_user` ADD store_permission text COLLATE utf8_bin NOT NULL;
ALTER TABLE `oc_user` ADD vendor_permission int(11) NOT NULL;
ALTER TABLE `oc_user` ADD folder varchar(128) COLLATE utf8_bin NOT NULL;
ALTER TABLE `oc_user` ADD user_date_start date NOT NULL;
ALTER TABLE `oc_user` ADD user_date_end date NOT NULL;

-- Dumping permission to `user_group` table
INSERT INTO `oc_user_group` (`user_group_id`, `name`, `permission`) VALUES
(50, 'Vendor', 'a:2:{s:6:"access";a:40:{i:0;s:21:"catalog/vdi_attribute";i:1;s:27:"catalog/vdi_attribute_group";i:2;s:20:"catalog/vdi_category";i:3;s:20:"catalog/vdi_download";i:4;s:23:"catalog/vdi_information";i:5;s:18:"catalog/vdi_option";i:6;s:19:"catalog/vdi_product";i:7;s:26:"catalog/vdi_vendor_profile";i:8;s:20:"common/vdi_dashboard";i:9;s:22:"common/vdi_filemanager";i:10;s:17:"common/vdi_header";i:11;s:16:"common/vdi_stats";i:12;s:19:"dashboard/vdi_chart";i:13;s:17:"dashboard/vdi_map";i:14;s:19:"dashboard/vdi_order";i:15;s:25:"dashboard/vdi_order_stock";i:16;s:20:"dashboard/vdi_recent";i:17;s:18:"dashboard/vdi_sale";i:18;s:17:"extension/openbay";i:19;s:20:"localisation/country";i:20;s:25:"localisation/order_status";i:21;s:25:"localisation/stock_status";i:22;s:22:"localisation/tax_class";i:23;s:17:"localisation/zone";i:24;s:19:"marketing/affiliate";i:25;s:20:"marketing/vdi_coupon";i:26;s:28:"report/vdi_product_purchased";i:27;s:25:"report/vdi_product_viewed";i:28;s:22:"report/vdi_transaction";i:29;s:17:"sale/custom_field";i:30;s:13:"sale/customer";i:31;s:19:"sale/customer_group";i:32;s:25:"sale/vdi_contract_history";i:33;s:14:"sale/vdi_order";i:34;s:12:"sale/voucher";i:35;s:15:"setting/setting";i:36;s:13:"setting/store";i:37;s:11:"tool/upload";i:38;s:8:"user/api";i:39;s:22:"user/vdi_user_password";}s:6:"modify";a:24:{i:0;s:21:"catalog/vdi_attribute";i:1;s:27:"catalog/vdi_attribute_group";i:2;s:20:"catalog/vdi_download";i:3;s:23:"catalog/vdi_information";i:4;s:18:"catalog/vdi_option";i:5;s:19:"catalog/vdi_product";i:6;s:26:"catalog/vdi_vendor_profile";i:7;s:20:"common/vdi_dashboard";i:8;s:22:"common/vdi_filemanager";i:9;s:17:"common/vdi_header";i:10;s:16:"common/vdi_stats";i:11;s:19:"dashboard/vdi_chart";i:12;s:17:"dashboard/vdi_map";i:13;s:19:"dashboard/vdi_order";i:14;s:25:"dashboard/vdi_order_stock";i:15;s:20:"dashboard/vdi_recent";i:16;s:18:"dashboard/vdi_sale";i:17;s:20:"marketing/vdi_coupon";i:18;s:28:"report/vdi_product_purchased";i:19;s:25:"report/vdi_product_viewed";i:20;s:22:"report/vdi_transaction";i:21;s:25:"sale/vdi_contract_history";i:22;s:14:"sale/vdi_order";i:23;s:22:"user/vdi_user_password";}}'),
(51, 'Vendor_Hide_Category', 'a:2:{s:6:"access";a:40:{i:0;s:21:"catalog/vdi_attribute";i:1;s:27:"catalog/vdi_attribute_group";i:2;s:20:"catalog/vdi_category";i:3;s:20:"catalog/vdi_download";i:4;s:23:"catalog/vdi_information";i:5;s:18:"catalog/vdi_option";i:6;s:19:"catalog/vdi_product";i:7;s:26:"catalog/vdi_vendor_profile";i:8;s:20:"common/vdi_dashboard";i:9;s:22:"common/vdi_filemanager";i:10;s:17:"common/vdi_header";i:11;s:16:"common/vdi_stats";i:12;s:19:"dashboard/vdi_chart";i:13;s:17:"dashboard/vdi_map";i:14;s:19:"dashboard/vdi_order";i:15;s:25:"dashboard/vdi_order_stock";i:16;s:20:"dashboard/vdi_recent";i:17;s:18:"dashboard/vdi_sale";i:18;s:17:"extension/openbay";i:19;s:20:"localisation/country";i:20;s:25:"localisation/order_status";i:21;s:25:"localisation/stock_status";i:22;s:22:"localisation/tax_class";i:23;s:17:"localisation/zone";i:24;s:19:"marketing/affiliate";i:25;s:20:"marketing/vdi_coupon";i:26;s:28:"report/vdi_product_purchased";i:27;s:25:"report/vdi_product_viewed";i:28;s:22:"report/vdi_transaction";i:29;s:17:"sale/custom_field";i:30;s:13:"sale/customer";i:31;s:19:"sale/customer_group";i:32;s:25:"sale/vdi_contract_history";i:33;s:14:"sale/vdi_order";i:34;s:12:"sale/voucher";i:35;s:15:"setting/setting";i:36;s:13:"setting/store";i:37;s:11:"tool/upload";i:38;s:8:"user/api";i:39;s:22:"user/vdi_user_password";}s:6:"modify";a:24:{i:0;s:21:"catalog/vdi_attribute";i:1;s:27:"catalog/vdi_attribute_group";i:2;s:20:"catalog/vdi_download";i:3;s:23:"catalog/vdi_information";i:4;s:18:"catalog/vdi_option";i:5;s:19:"catalog/vdi_product";i:6;s:26:"catalog/vdi_vendor_profile";i:7;s:20:"common/vdi_dashboard";i:8;s:22:"common/vdi_filemanager";i:9;s:17:"common/vdi_header";i:10;s:16:"common/vdi_stats";i:11;s:19:"dashboard/vdi_chart";i:12;s:17:"dashboard/vdi_map";i:13;s:19:"dashboard/vdi_order";i:14;s:25:"dashboard/vdi_order_stock";i:15;s:20:"dashboard/vdi_recent";i:16;s:18:"dashboard/vdi_sale";i:17;s:20:"marketing/vdi_coupon";i:18;s:28:"report/vdi_product_purchased";i:19;s:25:"report/vdi_product_viewed";i:20;s:22:"report/vdi_transaction";i:21;s:25:"sale/vdi_contract_history";i:22;s:14:"sale/vdi_order";i:23;s:22:"user/vdi_user_password";}}');

-- Dumping vendor sales info to `order_product` table
ALTER TABLE `oc_order_product` ADD vendor_id int(11) NOT NULL;
ALTER TABLE `oc_order_product` ADD order_status_id int(11) NOT NULL DEFAULT '0';
ALTER TABLE `oc_order_product` ADD commission decimal(15,4) NOT NULL DEFAULT '0.0000';
ALTER TABLE `oc_order_product` ADD store_tax decimal(15,4) NOT NULL DEFAULT '0.0000';
ALTER TABLE `oc_order_product` ADD vendor_tax decimal(15,4) NOT NULL DEFAULT '0.0000';
ALTER TABLE `oc_order_product` ADD vendor_total decimal(15,4) NOT NULL DEFAULT '0.0000';
ALTER TABLE `oc_order_product` ADD vendor_paid_status tinyint(1) NOT NULL DEFAULT '0';
ALTER TABLE `oc_order_product` ADD title varchar(255) COLLATE utf8_bin NOT NULL;

-- Dumping vendor id info to `download` table
ALTER TABLE `oc_download` ADD vendor_id int(11) NOT NULL;

-- Dumping vendor id info to `information` table
ALTER TABLE `oc_information` ADD vendor_id int(11) NOT NULL;

-- Dumping vendor id info to `order history` table
ALTER TABLE `oc_order_history` ADD vendor_id int(11) NOT NULL;

-- Dumping vendor id info to `attribute` table
ALTER TABLE `oc_attribute` ADD vendor_id int(11) NOT NULL;

-- Dumping vendor id info to `attribute group` table
ALTER TABLE `oc_attribute_group` ADD vendor_id int(11) NOT NULL;

-- Dumping vendor id info to `option` table
ALTER TABLE `oc_option` ADD vendor_id int(11) NOT NULL;

-- Dumping vendor id info to `coupon` table
ALTER TABLE `oc_coupon` ADD vendor_id int(11) NOT NULL;

-- Table data structure for table `order_shipping`
CREATE TABLE IF NOT EXISTS `oc_order_shipping` (
  `order_shipping_id` int(11) NOT NULL AUTO_INCREMENT,	
  `shipping_paid_status` tinyint(4) NOT NULL,
  `order_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `weight` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(3) NOT NULL,
   PRIMARY KEY (`order_shipping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;

-- Table data structure for table `vendor`
CREATE TABLE IF NOT EXISTS `oc_vendor` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,	
  `vproduct_id` int(11) NOT NULL,
  `ori_country` varchar(128) COLLATE utf8_bin NOT NULL,
  `product_cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `shipping_method` int(2) NOT NULL DEFAULT '0',
  `prefered_shipping` int(2) NOT NULL DEFAULT '0',
  `shipping_cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `vtotal` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `product_url` text COLLATE utf8_bin NOT NULL,
  `vendor` int(11) NOT NULL,
  `wholesale` varchar(128) COLLATE utf8_bin NOT NULL,
  `date_add` datetime NOT NULL,
   PRIMARY KEY (`vendor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=49;

-- Table data structure for table `signup_fee_history `
CREATE TABLE IF NOT EXISTS `oc_signup_fee_history` (
  `signup_fee_id` int(11) NOT NULL AUTO_INCREMENT,	
  `user_id` int(11) NOT NULL,
  `signup_fee` decimal(15,2) NOT NULL DEFAULT '0.00',
  `commission_type` tinyint(2) NOT NULL,
  `paid_status` tinyint(1) NOT NULL Default '0',
  `signup_plan` varchar(256) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL Default '0',
  `vendor_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `username` varchar(256) COLLATE utf8_bin NOT NULL,
  `user_date_start` date NOT NULL,
  `user_date_end` date NOT NULL,
  `date_added` datetime NOT NULL,
   PRIMARY KEY (`signup_fee_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=49;

-- Table data structure for table `vendors`
CREATE TABLE IF NOT EXISTS `oc_vendors` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `vendor_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `commission_id` int(11) NOT NULL,
  `product_limit_id` int(11) NOT NULL,
  `company` varchar(256) COLLATE utf8_bin NOT NULL,
  `company_id` varchar(64) COLLATE utf8_bin NOT NULL,
  `vendor_description` text COLLATE utf8_bin NOT NULL,
  `telephone` varchar(20) COLLATE utf8_bin NOT NULL,
  `fax` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `paypal_email` varchar(50) COLLATE utf8_bin NOT NULL,
  `iban` varchar(128) COLLATE utf8_bin NOT NULL,
  `bank_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `bank_address` text COLLATE utf8_bin NOT NULL,
  `swift_bic` varchar(64) COLLATE utf8_bin NOT NULL,
  `tax_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `accept_paypal` tinyint(2) NOT NULL,
  `accept_cheques` tinyint(2) NOT NULL,
  `accept_bank_transfer` tinyint(2) NOT NULL,
  `store_url` text COLLATE utf8_bin NOT NULL,
  `vendor_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(128) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(128) COLLATE utf8_bin NOT NULL,
  `address_1` varchar(128) COLLATE utf8_bin NOT NULL,
  `address_2` varchar(128) COLLATE utf8_bin NOT NULL,
  `city` varchar(128) COLLATE utf8_bin NOT NULL,
  `postcode` varchar(10) COLLATE utf8_bin NOT NULL,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`vendor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;

-- Table data structure for table `courier`
CREATE TABLE IF NOT EXISTS `oc_courier` (
  `courier_id` int(11) NOT NULL AUTO_INCREMENT,
  `courier_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `description` varchar(128) COLLATE utf8_bin NOT NULL,
  `courier_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`courier_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- Dumping data for table `courier`
INSERT INTO `oc_courier` (`courier_id`, `courier_name`, `description`, `courier_image`, `sort_order`, `date_add`) VALUES
(1, 'DHL', '3-7 Days', 'data/post/dhlpost_t.jpg', 0, '0000-00-00 00:00:00'),
(2, 'EMS', '5-10 Days', 'data/post/ems_t.jpg', 0, '0000-00-00 00:00:00'),
(3, 'Fedex', '3-7 Days', 'data/post/fedex_t.jpg', 0, '0000-00-00 00:00:00'),
(4, 'JNE', '3-7 Days', 'data/post/JNE.jpg', 0, '0000-00-00 00:00:00'),
(5, 'TNT', '3-15 Days', 'data/post/tnt_t.jpg', 0, '0000-00-00 00:00:00'),
(6, 'UPS', '3-7 Days', 'data/post/ups_t.jpg', 0, '0000-00-00 00:00:00'),
(7, 'Normal Mail', '3-45 Days', 'data/post/normal.jpg', 0, '0000-00-00 00:00:00'),
(8, 'China Post Air Mail', '15-30 Days', 'data/post/chinapost_t.jpg', 0, '0000-00-00 00:00:00'),
(9, 'Hong Kong Air Mail', '15-30 Days', 'data/post/hongkongpost_t.jpg', 0, '0000-00-00 00:00:00');

-- Table data structure for table `commision`
CREATE TABLE IF NOT EXISTS `oc_commission` (
  `commission_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_limit_id` int(5) NOT NULL DEFAULT '1',
  `commission_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `commission_type` tinyint(4) NOT NULL, 
  `commission` varchar(64) COLLATE utf8_bin NOT NULL,
  `duration` tinyint(4) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`commission_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- Dumping data for table `commision`
INSERT INTO `oc_commission` (`commission_id`, `product_limit_id`, `commission_name`, `commission_type`, `commission`, `duration`, `sort_order`, `date_add`) VALUES
(1,  '1', 'No Commission', '1', '0', '0', '0', '0000-00-00 00:00:00'),
(2,  '1', 'Gold', '0', '5', '0', '1', '0000-00-00 00:00:00'),
(3,  '1', 'Silver', '1', '20', '0', '2', '0000-00-00 00:00:00'),
(4,  '1', 'Bronze', '0', '30', '0', '3', '0000-00-00 00:00:00'),
(5,  '1', '$1.00/month (USD) - 1 Year', '5', '12', '1', '8', '0000-00-00 00:00:00'),
(6,  '4', '$1.50/month (USD) - 6 Months', '4', '9', '6', '1', '0000-00-00 00:00:00');

-- Table data structure for table `product limit`
CREATE TABLE IF NOT EXISTS `oc_product_limit` (
  `product_limit_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `product_limit` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`product_limit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `oc_product_limit` (`product_limit_id`, `package_name`, `product_limit`, `sort_order`, `date_add`) VALUES
(1, 'Unlimited', 99999, 0, '0000-00-00 00:00:00'),
(2, 'Trial 30 Days', 10, 3, '0000-00-00 00:00:00'),
(3, 'Gold', 1000, 1, '0000-00-00 00:00:00'),
(4, '6 Months', 999, 1, '0000-00-00 00:00:00');

-- Table data structure for table `order status vendor update`
CREATE TABLE IF NOT EXISTS `oc_order_status_vendor_update` (
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `date_add` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- Table data structure for table `vendor_payment`
CREATE TABLE IF NOT EXISTS `oc_vendor_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `payment_info` longtext COLLATE utf8_bin NOT NULL,
  `payment_type` varchar(255) COLLATE utf8_bin NOT NULL,
  `payment_status` tinyint(5) NOT NULL,
  `payment_amount` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `payment_date` datetime NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `oc_product_shipping` (
  `product_shipping_id` int(11) NOT NULL AUTO_INCREMENT,
  `courier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL,
  `shipping_rate` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `geo_zone_id` int(11) NOT NULL,
  PRIMARY KEY (`product_shipping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `oc_vendor_discount` (
  `vendor_discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_bin NOT NULL,  
  `amount` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `coupon_paid_status` tinyint(5) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  PRIMARY KEY (`vendor_discount_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

