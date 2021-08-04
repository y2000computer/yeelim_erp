/*
SQLyog Community Edition- MySQL GUI v6.51
MySQL - 5.5.5-10.3.14-MariaDB : Database - yeelim_db_erp_uat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `tbl_prop_rent_inv` */

DROP TABLE IF EXISTS `tbl_prop_rent_inv`;

CREATE TABLE `tbl_prop_rent_inv` (
  `inv_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `build_id` bigint(20) NOT NULL DEFAULT 0,
  `tenant_id` bigint(20) NOT NULL DEFAULT 0,
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
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `print_is` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `create_user` varchar(50) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `modify_user` varchar(50) DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`inv_id`),
  UNIQUE KEY `build_id_inv_code` (`build_id`,`inv_code`),
  KEY `build_id` (`build_id`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_prop_rent_inv` */

insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (1,1,1,'111111','2021-01-01 00:00:00','','','','','','','','2021-01-01 00:00:00','2021-01-30 00:00:00','100001.20','0.00',0,1,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (2,1,1,'111112','2021-02-01 00:00:00','','','','','','','','2021-02-01 00:00:00','2021-02-28 00:00:00','100001.20','100001.20',0,1,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (3,1,1,'111113','2021-03-01 00:00:00','','','','','','','','2021-03-01 00:00:00','2021-03-31 00:00:00','100001.20','100001.20',0,1,NULL,NULL,NULL,NULL);
insert  into `tbl_prop_rent_inv`(`inv_id`,`build_id`,`tenant_id`,`inv_code`,`inv_date`,`eng_name`,`add_1`,`add_2`,`add_3`,`ref_no`,`shop_no`,`description`,`period_date_from`,`period_date_to`,`amount`,`balance`,`print_is`,`status`,`create_user`,`create_datetime`,`modify_user`,`modify_datetime`) values (4,1,1,'111114','2021-04-01 00:00:00','','','','','','','','2021-04-01 00:00:00','2021-04-30 00:00:00','100001.20','100001.20',0,0,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
