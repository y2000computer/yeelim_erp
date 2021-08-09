/*
SQLyog Community Edition- MySQL GUI v6.51
MySQL - 5.7.26 : Database - yeelim_db_erp_uat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `tbl_sys_module` */

DROP TABLE IF EXISTS `tbl_sys_module`;

CREATE TABLE `tbl_sys_module` (
  `module_code` varchar(50) NOT NULL,
  `eng_name` varchar(200) NOT NULL COMMENT 'Module name (English)',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0(No-used) or 1(Active)',
  PRIMARY KEY (`module_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_sys_module` */

insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-MAINT-01-001','GL -> Maintenance -> Chart Master',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-MAINT-01-010','GL -> Maintenance -> Year End',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-REPORT-01-001','GL -> Report -> Chart of Account',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-REPORT-01-010','GL -> Report -> Journal Entry',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-REPORT-01-020','GL -> Report -> General ledger',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-REPORT-01-030','GL -> Report -> Trial Balance',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-REPORT-01-040','GL -> Report -> Profit & Loss',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-REPORT-01-050','GL -> Report -> Balance Sheet',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('GL-TRAN-01-001','GL -> Transaction -> GL Entry',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-001','PROP -> Report -> Tenant Information',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-005','PROP -> Report -> Rent Invoice Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-010','PROP -> Report -> Rent Payment Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-015','PROP -> Report -> Maint. Invoice Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-020','PROP -> Report -> Maint. Payment Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-025','PROP -> Report -> Rent Overdue Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-030','PROP -> Report -> Maint. Overdue Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-001','PROP -> Transaction -> Tenant Information',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-005','PROP -> Transaction -> Rent Invoice',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-010','PROP -> Transaction -> Rent Payment',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-015','PROP -> Transaction -> Maint. Invoice',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-020','PROP -> Transaction -> Maint. Payment',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('SYS-MAINT-01-001','System -> Maintenance -> Company Master',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('SYS-TRAN-01-001','System -> Transaction -> User Information',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('SYS-TRAN-01-005','System -> Transaction -> Security Policy Information',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('SYS-TRAN-01-010','System -> Transaction -> Security Network Information',1);

/*Table structure for table `tbl_sys_policy` */

DROP TABLE IF EXISTS `tbl_sys_policy`;

CREATE TABLE `tbl_sys_policy` (
  `policy_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eng_name` varchar(200) NOT NULL COMMENT 'Policy name (English)',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_user` varchar(50) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `last_modify_user` varchar(50) NOT NULL,
  `last_modify_datetime` datetime NOT NULL,
  PRIMARY KEY (`policy_id`),
  UNIQUE KEY `eng_name` (`eng_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_sys_policy` */

insert  into `tbl_sys_policy`(`policy_id`,`eng_name`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (1,'system adminstrator',1,'admin','2016-10-18 14:37:14','sam.lam@hkber.com.hk','2020-03-25 16:05:38');
insert  into `tbl_sys_policy`(`policy_id`,`eng_name`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (2,'AC > Supervisor ',1,'admin','2016-10-18 14:37:14','sam.lam@y2kcomputer.com','2021-07-29 16:09:28');

/*Table structure for table `tbl_sys_policy_module` */

DROP TABLE IF EXISTS `tbl_sys_policy_module`;

CREATE TABLE `tbl_sys_policy_module` (
  `irow_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `policy_id` bigint(20) NOT NULL,
  `module_code` varchar(50) NOT NULL,
  `rights_level` tinyint(4) NOT NULL DEFAULT '1',
  `rights_create` tinyint(4) NOT NULL DEFAULT '1',
  `rights_update` tinyint(4) NOT NULL DEFAULT '1',
  `rights_void` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_user` varchar(50) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `last_modify_user` varchar(50) NOT NULL,
  `last_modify_datetime` datetime NOT NULL,
  PRIMARY KEY (`irow_id`),
  UNIQUE KEY `policy_id` (`policy_id`,`module_code`),
  KEY `module_code` (`module_code`),
  CONSTRAINT `tbl_sys_policy_module_ibfk_1` FOREIGN KEY (`module_code`) REFERENCES `tbl_sys_module` (`module_code`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_sys_policy_module` */

insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (40,1,'SYS-TRAN-01-001',1,1,1,1,1,'admin','2016-10-18 14:39:04','admin','2016-10-18 14:39:04');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (41,1,'SYS-TRAN-01-005',1,1,1,1,1,'admin','2016-10-18 14:39:04','admin','2016-10-18 14:39:04');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (42,1,'SYS-TRAN-01-010',1,1,1,1,1,'admin','2016-10-18 14:39:04','admin','2016-10-18 14:39:04');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (51,1,'GL-TRAN-01-001',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-03-24 17:18:36','sam.lam@hkber.com.hk','2020-03-25 16:05:25');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (52,1,'SYS-MAINT-01-001',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-03-25 11:34:14','sam.lam@hkber.com.hk','2020-03-25 11:34:14');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (59,1,'GL-MAINT-01-001',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-03-30 17:33:42','sam.lam@hkber.com.hk','2020-03-30 17:33:42');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (74,1,'GL-REPORT-01-001',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-09-15 11:41:41','sam.lam@hkber.com.hk','2020-09-15 11:41:41');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (75,1,'GL-REPORT-01-010',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-09-18 19:56:16','sam.lam@hkber.com.hk','2020-09-18 19:56:16');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (76,1,'GL-REPORT-01-020',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-09-18 19:56:20','sam.lam@hkber.com.hk','2020-09-18 19:56:20');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (77,1,'GL-REPORT-01-030',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-09-18 19:56:25','sam.lam@hkber.com.hk','2020-09-18 19:56:25');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (78,1,'GL-REPORT-01-040',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-09-18 19:56:29','sam.lam@hkber.com.hk','2020-09-18 19:56:29');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (79,1,'GL-REPORT-01-050',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-09-18 19:56:33','sam.lam@hkber.com.hk','2020-09-18 19:56:33');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (80,1,'GL-MAINT-01-010',1,1,1,1,1,'sam.lam@hkber.com.hk','2020-11-05 09:21:48','sam.lam@hkber.com.hk','2020-11-05 09:21:48');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (81,2,'GL-MAINT-01-001',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:09:58','sam.lam@y2kcomputer.com','2021-07-29 16:09:58');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (82,2,'GL-MAINT-01-010',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:07','sam.lam@y2kcomputer.com','2021-07-29 16:10:07');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (83,2,'GL-REPORT-01-001',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:11','sam.lam@y2kcomputer.com','2021-07-29 16:10:11');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (84,2,'GL-REPORT-01-010',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:15','sam.lam@y2kcomputer.com','2021-07-29 16:10:15');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (85,2,'GL-REPORT-01-020',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:18','sam.lam@y2kcomputer.com','2021-07-29 16:10:18');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (86,2,'GL-REPORT-01-030',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:22','sam.lam@y2kcomputer.com','2021-07-29 16:10:22');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (87,2,'GL-REPORT-01-040',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:27','sam.lam@y2kcomputer.com','2021-07-29 16:10:27');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (88,2,'GL-REPORT-01-050',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:31','sam.lam@y2kcomputer.com','2021-07-29 16:10:31');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (89,2,'GL-TRAN-01-001',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:36','sam.lam@y2kcomputer.com','2021-07-29 16:10:36');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (90,2,'SYS-MAINT-01-001',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:39','sam.lam@y2kcomputer.com','2021-07-29 16:10:39');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (91,2,'SYS-TRAN-01-001',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:44','sam.lam@y2kcomputer.com','2021-07-29 16:10:44');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (92,2,'SYS-TRAN-01-005',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:48','sam.lam@y2kcomputer.com','2021-07-29 16:10:48');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (93,2,'SYS-TRAN-01-010',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-07-29 16:10:52','sam.lam@y2kcomputer.com','2021-07-29 16:10:52');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (94,1,'PROP-TRAN-01-001',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-05 17:00:59','sam.lam@y2kcomputer.com','2021-08-05 17:00:59');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (95,1,'PROP-TRAN-01-005',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-05 17:01:02','sam.lam@y2kcomputer.com','2021-08-05 17:01:02');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (96,1,'PROP-TRAN-01-010',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-05 17:01:06','sam.lam@y2kcomputer.com','2021-08-05 17:01:06');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (97,1,'PROP-TRAN-01-015',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-05 17:01:10','sam.lam@y2kcomputer.com','2021-08-05 17:01:10');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (98,1,'PROP-TRAN-01-020',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-05 17:01:14','sam.lam@y2kcomputer.com','2021-08-05 17:01:14');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (99,1,'PROP-REPORT-01-001',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-06 08:57:12','sam.lam@y2kcomputer.com','2021-08-06 08:57:12');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (100,1,'PROP-REPORT-01-005',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-06 13:23:18','sam.lam@y2kcomputer.com','2021-08-06 13:23:18');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (101,1,'PROP-REPORT-01-010',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-06 14:08:36','sam.lam@y2kcomputer.com','2021-08-06 14:08:36');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (102,1,'PROP-REPORT-01-015',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-06 14:49:41','sam.lam@y2kcomputer.com','2021-08-06 14:49:41');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (103,1,'PROP-REPORT-01-020',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-06 14:59:55','sam.lam@y2kcomputer.com','2021-08-06 14:59:55');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (104,1,'PROP-REPORT-01-025',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-06 15:10:28','sam.lam@y2kcomputer.com','2021-08-06 15:10:28');
insert  into `tbl_sys_policy_module`(`irow_id`,`policy_id`,`module_code`,`rights_level`,`rights_create`,`rights_update`,`rights_void`,`status`,`create_user`,`create_datetime`,`last_modify_user`,`last_modify_datetime`) values (105,1,'PROP-REPORT-01-030',1,1,1,1,1,'sam.lam@y2kcomputer.com','2021-08-06 15:28:49','sam.lam@y2kcomputer.com','2021-08-06 15:28:49');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
