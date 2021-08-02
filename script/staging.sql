
DROP TABLE IF EXISTS `tbl_prop_build_master`;

CREATE TABLE `tbl_prop_build_master` (
  `build_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `comp_id` varchar(6) NOT NULL DEFAULT '',
  `build_name` varchar(200) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 1,
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`build_id`),
  UNIQUE KEY `comp_id_build_id` (`comp_id`,`build_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tbl_prop_tenant_info`;

CREATE TABLE `tbl_prop_tenant_info` (
  `tenant_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `build_id` bigint(20) NOT NULL DEFAULT '0',
  `tenant_code` varchar(20) NOT NULL DEFAULT '',
  `eng_name` varchar(200) NOT NULL DEFAULT '',
  `add_1` varchar(200) NOT NULL DEFAULT '',
  `add_2` varchar(200) NOT NULL DEFAULT '',
  `add_3` varchar(200) NOT NULL DEFAULT '',
  `ref_no` varchar(200) NOT NULL DEFAULT '',
  `shop_no` varchar(200) NOT NULL DEFAULT '',
  `rent_date` datetime DEFAULT NULL,
  `rent_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `maint_date` datetime DEFAULT NULL,
  `maint_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ptype` int(11) DEFAULT 0, 
  `status` int(11) NOT NULL DEFAULT 1,
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`tenant_id`),
  KEY `build_id` (`build_id`),
  UNIQUE KEY `build_id_tenant_code` (`build_id`,`tenant_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tbl_prop_rent_inv`;

CREATE TABLE `tbl_prop_rent_inv` (
  `inv_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `build_id` bigint(20) NOT NULL DEFAULT '0',
  `tenant_id` bigint(20) NOT NULL DEFAULT '0',
  `inv_code` varchar(20) NOT NULL DEFAULT '',
  `eng_name` varchar(200) NOT NULL DEFAULT '',
  `add_1` varchar(200) NOT NULL DEFAULT '',
  `add_2` varchar(200) NOT NULL DEFAULT '',
  `add_3` varchar(200) NOT NULL DEFAULT '',
  `ref_no` varchar(200) NOT NULL DEFAULT '',
  `shop_no` varchar(200) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `period_date_from` datetime DEFAULT NULL,
  `period_date_to` datetime DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `print_is` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`inv_id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `build_id` (`build_id`),
  KEY `tenant_id` (`tenant_id`),
  UNIQUE KEY `build_id_inv_code` (`build_id`,`inv_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

