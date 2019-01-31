/*
SQLyog Community v12.3.3 (64 bit)
MySQL - 10.1.35-MariaDB : Database - timetracker
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`timetracker` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `timetracker`;

/*Table structure for table `master_breaks` */

DROP TABLE IF EXISTS `master_breaks`;

CREATE TABLE `master_breaks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `break_name` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `master_breaks` */

/*Table structure for table `master_projects` */

DROP TABLE IF EXISTS `master_projects`;

CREATE TABLE `master_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_start_time` time DEFAULT NULL,
  `shift_end_time` time DEFAULT NULL,
  `breaks_count` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `master_projects` */

insert  into `master_projects`(`id`,`name`,`shift_start_time`,`shift_end_time`,`breaks_count`,`created_by`,`isActive`) values 
(1,'test','12:50:52','12:50:52',0,NULL,1),
(2,'test2','12:53:15','12:53:15',0,NULL,1);

/*Table structure for table `tbl_reset_password` */

DROP TABLE IF EXISTS `tbl_reset_password`;

CREATE TABLE `tbl_reset_password` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` bigint(20) NOT NULL DEFAULT '1',
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_reset_password` */

/*Table structure for table `tbl_roles` */

DROP TABLE IF EXISTS `tbl_roles`;

CREATE TABLE `tbl_roles` (
  `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text',
  PRIMARY KEY (`roleId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_roles` */

insert  into `tbl_roles`(`roleId`,`role`) values 
(1,'Manager'),
(2,'Team Lead'),
(3,'Employee');

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `projectId` tinyint(4) DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`userId`,`email`,`password`,`name`,`mobile`,`roleId`,`projectId`,`isDeleted`,`createdBy`,`createdDtm`,`updatedBy`,`updatedDtm`) values 
(1,'admin@bewithdhanu.in','$2y$10$SAvFim22ptA9gHVORtIaru1dn9rhgerJlJCPxRNA02MjQaJnkxawq','Manager','9890098900',1,NULL,0,0,'2015-07-01 18:56:49',1,'2017-06-19 09:22:53'),
(2,'manager@bewithdhanu.in','$2y$10$Gkl9ILEdGNoTIV9w/xpf3.mSKs0LB1jkvvPKK7K0PSYDsQY7GE9JK','Team Lead','9890098900',2,NULL,0,1,'2016-12-09 17:49:56',1,'2017-06-19 09:22:29'),
(3,'employee@bewithdhanu.in','$2y$10$MB5NIu8i28XtMCnuExyFB.Ao1OXSteNpCiZSiaMSRPQx1F1WLRId2','Employee','9890098900',3,NULL,0,1,'2016-12-09 17:50:22',1,'2017-06-19 09:23:21'),
(4,'Lead1@bewithdhanu.in','$2y$10$2QUQrMYTLw4YV8uVEh34DegWPxpony68GPTDV/KVenAs2UVkOT9Eq','Lead1','1234567880',2,1,0,1,'2019-01-24 13:16:30',NULL,NULL),
(5,'emp@gmail.com','$2y$10$ngO/WvIWc16QMxNNA0JzWu5vHO1H/CXMvVWiF/3yh9nIl1.daIOfC','Emp','1223343435',3,2,0,2,'2019-01-24 13:43:31',NULL,NULL),
(6,'emp2@gmail.com','$2y$10$x1SFPJNLemStX4.fA.NTfugLdFjS9J0slLmqoTsl/Xr2.qMXYOc92','Emp2','1234567890',3,2,0,2,'2019-01-24 13:58:10',NULL,NULL),
(7,'em2@df.ff','$2y$10$IBbozxaLEMy0KV8UJFcNmu8s5GUYuR.8ipWf/aStKUOTz.H8BPg7i','Em','3453432423',2,1,0,1,'2019-01-31 13:54:03',NULL,NULL);

/*Table structure for table `user_daily_breaks` */

DROP TABLE IF EXISTS `user_daily_breaks`;

CREATE TABLE `user_daily_breaks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_tracking_id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `breakid` int(11) DEFAULT NULL,
  `break_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `break_end` timestamp NULL DEFAULT NULL,
  `break_hours` time DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_daily_breaks` */

insert  into `user_daily_breaks`(`id`,`user_tracking_id`,`userid`,`breakid`,`break_start`,`break_end`,`break_hours`,`remarks`,`created_on`) values 
(40,8,1,1,'2019-01-31 10:07:19','2019-01-31 10:07:19','00:00:12',NULL,'2019-01-31'),
(41,8,1,2,'2019-01-31 10:10:53','2019-01-31 10:10:53','00:00:05',NULL,'2019-01-31'),
(42,8,1,3,'2019-01-31 10:10:58','2019-01-31 10:10:58','00:00:02',NULL,'2019-01-31'),
(43,9,2,1,'2019-01-31 10:36:35','2019-01-31 10:36:35','00:00:20',NULL,'2019-01-31'),
(44,9,2,2,'2019-01-31 10:37:59','2019-01-31 10:37:59','00:00:02',NULL,'2019-01-31'),
(47,9,2,3,'2019-01-31 10:40:55','2019-01-31 10:40:55','00:00:04',NULL,'2019-01-31');

/*Table structure for table `user_daily_tracking` */

DROP TABLE IF EXISTS `user_daily_tracking`;

CREATE TABLE `user_daily_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `day_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `day_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `spend_hours` time DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_daily_tracking` */

insert  into `user_daily_tracking`(`id`,`userid`,`day_start`,`day_end`,`spend_hours`,`remarks`,`created_on`) values 
(7,1,'2019-01-30 14:26:21','2019-01-30 02:26:21','00:02:00',NULL,'2019-01-30'),
(8,1,'2019-01-31 10:36:06','2019-01-31 10:36:06','01:00:04',NULL,'2019-01-31'),
(9,2,'2019-01-31 10:36:10','2019-01-31 10:36:10',NULL,NULL,'2019-01-31');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
