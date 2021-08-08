/*
SQLyog Community Edition- MySQL GUI v6.51
MySQL - 5.5.5-10.3.14-MariaDB : Database - yeelim_db_erp_uat
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
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0(No-used) or 1(Active)',
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
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-MAINT-01-001','PROP -> Maintenance -> Rent Invoice Generation',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-MAINT-01-005','PROP -> Maintenance -> Maint. Invoice Generation',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-001','PROP -> Report -> Tenant Information',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-005','PROP -> Report -> Rent Invoice Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-010','PROP -> Report -> Rent Payment Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-015','PROP -> Report -> Maint. Invoice Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-020','PROP -> Report -> Maint. Payment Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-025','PROP -> Report -> Rent Overdue Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-030','PROP -> Report -> Maint. Overdue Report',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-035','PROP -> Report -> Rent Debit Note',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-REPORT-01-040','PROP -> Report -> Maint. Debit Note',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-001','PROP -> Transaction -> Tenant Information',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-005','PROP -> Transaction -> Rent Invoice',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-010','PROP -> Transaction -> Rent Payment',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-015','PROP -> Transaction -> Maint. Invoice',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('PROP-TRAN-01-020','PROP -> Transaction -> Maint. Payment',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('SYS-MAINT-01-001','System -> Maintenance -> Company Master',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('SYS-TRAN-01-001','System -> Transaction -> User Information',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('SYS-TRAN-01-005','System -> Transaction -> Security Policy Information',1);
insert  into `tbl_sys_module`(`module_code`,`eng_name`,`status`) values ('SYS-TRAN-01-010','System -> Transaction -> Security Network Information',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
