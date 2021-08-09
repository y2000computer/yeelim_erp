/*
SQLyog Community Edition- MySQL GUI v6.51
MySQL - 5.7.26 : Database - yeelim_db_erp_uat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `tbl_prop_build_master` */

DROP TABLE IF EXISTS `tbl_prop_build_master`;

CREATE TABLE `tbl_prop_build_master` (
  `build_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `comp_id` varchar(6) NOT NULL DEFAULT '',
  `eng_name` varchar(200) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`build_id`),
  UNIQUE KEY `comp_id_build_id` (`comp_id`,`build_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_prop_build_master` */

insert  into `tbl_prop_build_master`(`build_id`,`comp_id`,`eng_name`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (1,'1','(1)Golden Ind Bldg\r\n',1,'sam.lam@y2kcomputer.com','2021-08-02 00:00:00','sam.lam@y2kcomputer.com','2021-08-02 00:00:00');
insert  into `tbl_prop_build_master`(`build_id`,`comp_id`,`eng_name`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (2,'1','(2)Yee Lim Ind Centre',1,'sam.lam@y2kcomputer.com','2021-08-02 00:00:00','sam.lam@y2kcomputer.com','2021-08-02 00:00:00');
insert  into `tbl_prop_build_master`(`build_id`,`comp_id`,`eng_name`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (3,'1','(3)Yee Lim Ind Stage 3',1,'sam.lam@y2kcomputer.com','2021-08-02 00:00:00','sam.lam@y2kcomputer.com','2021-08-02 00:00:00');
insert  into `tbl_prop_build_master`(`build_id`,`comp_id`,`eng_name`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (4,'1','(4)Golden Ind (Maint.Fee)',1,'sam.lam@y2kcomputer.com','2021-08-02 00:00:00','sam.lam@y2kcomputer.com','2021-08-02 00:00:00');

/*Table structure for table `tbl_prop_maint_inv` */

DROP TABLE IF EXISTS `tbl_prop_maint_inv`;

CREATE TABLE `tbl_prop_maint_inv` (
  `inv_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `build_id` bigint(20) NOT NULL DEFAULT '0',
  `tenant_id` bigint(20) NOT NULL DEFAULT '0',
  `inv_code` varchar(20) NOT NULL DEFAULT '',
  `inv_date` datetime DEFAULT NULL,
  `eng_name` varchar(200) NOT NULL DEFAULT '',
  `add_1` varchar(200) NOT NULL DEFAULT '',
  `add_2` varchar(200) NOT NULL DEFAULT '',
  `add_3` varchar(200) NOT NULL DEFAULT '',
  `ref_no` varchar(200) NOT NULL DEFAULT '',
  `shop_no` varchar(200) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `period_date_from` datetime DEFAULT NULL,
  `period_date_to` datetime DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `print_is` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`inv_id`),
  UNIQUE KEY `build_id_inv_code` (`build_id`,`inv_code`),
  KEY `build_id` (`build_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_prop_maint_inv` */

insert  into `tbl_prop_maint_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (1,1,1,'M100001','2021-01-01 00:00:00','minv eng.....','add 1...','add 2...','add 3...','ref...','shop..','description...','2021-01-01 00:00:00','2021-01-31 00:00:00','550.00','0.00',0,0,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_maint_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (2,1,1,'M100002','2021-02-01 00:00:00','minv eng.....','add 1...','add 2...','add 3...','ref...','shop..','description...','2021-02-01 00:00:00','2021-02-28 00:00:00','550.00','550.00',0,1,NULL,NULL,'sam.lam@y2kcomputer.com','2021-08-04 21:36:06');
insert  into `tbl_prop_maint_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (3,1,1,'M100003','2021-03-01 00:00:00','minv eng.....','add 1...','add 2...','add 3...','ref...','shop..','description...','2021-03-01 00:00:00','2021-03-31 00:00:00','550.00','550.00',0,1,NULL,NULL,'sam.lam@y2kcomputer.com','2021-08-04 21:36:09');
insert  into `tbl_prop_maint_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (4,1,1,'M100004','2021-04-01 00:00:00','minv eng.....','add 1...','add 2...','add 3...','ref...','shop..','description...','2021-04-01 00:00:00','2021-04-30 00:00:00','550.00','550.00',0,1,NULL,NULL,'sam.lam@y2kcomputer.com','2021-08-04 21:36:14');
insert  into `tbl_prop_maint_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (5,1,1,'M100005','2021-05-01 00:00:00','minv eng.....','add 1...','add 2...','add 3...','ref...','shop..','description...','2021-05-01 00:00:00','2021-05-31 00:00:00','550.00','550.00',0,1,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_prop_maint_payment` */

DROP TABLE IF EXISTS `tbl_prop_maint_payment`;

CREATE TABLE `tbl_prop_maint_payment` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `build_id` bigint(20) DEFAULT NULL,
  `inv_id` bigint(20) NOT NULL DEFAULT '0',
  `payment_code` varchar(20) NOT NULL DEFAULT '',
  `payment_date` datetime DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `inv_id` (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_prop_maint_payment` */

insert  into `tbl_prop_maint_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (1,1,1,'R00001','2021-08-04 00:00:00','3333.00',1,'sam.lam@y2kcomputer.com','2021-08-04 00:00:00','sam.lam@y2kcomputer.com','2021-08-04 00:00:00');
insert  into `tbl_prop_maint_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (2,1,2,'R00002','2021-08-05 00:00:00','444.00',1,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_maint_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (3,1,3,'R00003','2021-08-06 00:00:00','555.00',1,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_maint_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (4,1,4,'R00004','2021-08-07 00:00:00','6666.00',1,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_prop_rent_inv` */

DROP TABLE IF EXISTS `tbl_prop_rent_inv`;

CREATE TABLE `tbl_prop_rent_inv` (
  `inv_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `build_id` bigint(20) NOT NULL DEFAULT '0',
  `tenant_id` bigint(20) NOT NULL DEFAULT '0',
  `inv_code` varchar(20) NOT NULL DEFAULT '',
  `inv_date` datetime DEFAULT NULL,
  `eng_name` varchar(200) NOT NULL DEFAULT '',
  `add_1` varchar(200) NOT NULL DEFAULT '',
  `add_2` varchar(200) NOT NULL DEFAULT '',
  `add_3` varchar(200) NOT NULL DEFAULT '',
  `ref_no` varchar(200) NOT NULL DEFAULT '',
  `shop_no` varchar(200) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `period_date_from` datetime DEFAULT NULL,
  `period_date_to` datetime DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `print_is` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`inv_id`),
  UNIQUE KEY `build_id_inv_code` (`build_id`,`inv_code`),
  KEY `build_id` (`build_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_prop_rent_inv` */

insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (1,1,1,'111111','2021-01-01 00:00:00','inv eng name....2','add 1..','add 2..','add 3..','ref_no..','shop _no..','descript.1','2021-01-01 00:00:00','2021-01-30 00:00:00','100001.20','100000.00',0,1,NULL,NULL,'sam.lam@y2kcomputer.com','2021-08-04 20:55:11');
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (2,1,1,'111112','2021-02-01 00:00:00','inv eng name....3','add 1..','add 2..','add 3..','ref_no..','shop _no..','descript.1','2021-02-01 00:00:00','2021-02-28 00:00:00','100001.20','81501.20',0,1,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (3,1,1,'111113','2021-03-01 00:00:00','inv eng name....5','','','','ref_no..','shop _no..','descript.1','2021-03-01 00:00:00','2021-03-31 00:00:00','100001.20','99113.20',0,1,NULL,NULL,'sam.lam@y2kcomputer.com','2021-08-04 20:55:17');
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (4,1,1,'111114','2021-04-01 00:00:00','inv eng name....6','','','','ref_no..','shop _no..','descript.1','2021-04-01 00:00:00','2021-04-30 00:00:00','100001.20','100001.20',0,0,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (5,3,451,'111115','2021-08-01 00:00:00','SAM inv mname','','','','ref_no..','shop _no..','descript.1','2021-04-01 00:00:00','2021-04-30 00:00:00','888.00','880.00',0,1,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (6,2,452,'RV2100001','2021-07-01 00:00:00','OLYMPIC SQUARE ','WORKSHOP NO.5 ON 7/F.,','16-26 KWAI TAK ST., KWAI CHUNG.','GOLDEN IND. BLDG.','YL-7','5 ON 7/F.,','','2021-07-01 00:00:00','2021-07-31 00:00:00','1400.00','1400.00',0,1,'sam.lam@y2kcomputer.com','2021-08-09 11:55:59','sam.lam@y2kcomputer.com','2021-08-09 11:55:59');
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (7,2,452,'RV2100002','2021-08-01 00:00:00','OLYMPIC SQUARE ','WORKSHOP NO.5 ON 7/F.,','16-26 KWAI TAK ST., KWAI CHUNG.','GOLDEN IND. BLDG.','YL-7','5 ON 7/F.,','','2021-08-01 00:00:00','2021-08-31 00:00:00','2323.00','2323.00',0,1,'sam.lam@y2kcomputer.com','2021-08-09 13:08:50','sam.lam@y2kcomputer.com','2021-08-09 13:08:50');
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (8,2,452,'RV2100003','2021-09-01 00:00:00','OLYMPIC SQUARE ','WORKSHOP NO.5 ON 7/F.,','16-26 KWAI TAK ST., KWAI CHUNG.','GOLDEN IND. BLDG.','YL-7','5 ON 7/F.,','','2021-09-01 00:00:00','2021-08-31 00:00:00','5000.00','5000.00',0,1,'sam.lam@y2kcomputer.com','2021-08-09 13:09:30','sam.lam@y2kcomputer.com','2021-08-09 13:09:30');

/*Table structure for table `tbl_prop_rent_payment` */

DROP TABLE IF EXISTS `tbl_prop_rent_payment`;

CREATE TABLE `tbl_prop_rent_payment` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `build_id` bigint(20) DEFAULT NULL,
  `inv_id` bigint(20) NOT NULL DEFAULT '0',
  `payment_code` varchar(20) NOT NULL DEFAULT '',
  `payment_date` datetime DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `inv_id` (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_prop_rent_payment` */

insert  into `tbl_prop_rent_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (12,1,1,'RP2100001','2021-08-04 00:00:00','1.20',1,'sam.lam@y2kcomputer.com','2021-08-05 18:19:14','sam.lam@y2kcomputer.com','2021-08-05 18:19:43');
insert  into `tbl_prop_rent_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (13,1,2,'RP2100002','2021-08-05 00:00:00','18500.00',1,'sam.lam@y2kcomputer.com','2021-08-05 18:20:47','sam.lam@y2kcomputer.com','2021-08-05 18:21:13');
insert  into `tbl_prop_rent_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (14,1,3,'RP2100003','2021-08-04 00:00:00','100001.20',0,'sam.lam@y2kcomputer.com','2021-08-05 18:21:51','sam.lam@y2kcomputer.com','2021-08-05 18:22:18');
insert  into `tbl_prop_rent_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (15,1,3,'RP2100004','2021-08-05 00:00:00','888.00',1,'sam.lam@y2kcomputer.com','2021-08-05 18:22:33','sam.lam@y2kcomputer.com','2021-08-05 18:22:33');
insert  into `tbl_prop_rent_payment`(`payment_id`,`build_id`,`inv_id`,`payment_code`,`payment_date`,`amount`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (16,3,5,'RP2100001','2021-08-17 00:00:00','8.00',1,'sam.lam@y2kcomputer.com','2021-08-06 14:19:09','sam.lam@y2kcomputer.com','2021-08-06 14:19:09');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
