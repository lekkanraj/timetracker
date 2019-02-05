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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `master_breaks` */

insert  into `master_breaks`(`id`,`break_name`) values 
(1,'Tea Break1'),
(2,'Lunch'),
(3,'Tea Break2'),
(4,'Break 3');

/*Table structure for table `master_projects` */

DROP TABLE IF EXISTS `master_projects`;

CREATE TABLE `master_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_start_time` time DEFAULT NULL,
  `shift_end_time` time DEFAULT NULL,
  `breaks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `master_projects` */

insert  into `master_projects`(`id`,`name`,`shift_start_time`,`shift_end_time`,`breaks`,`created_by`,`isActive`) values 
(1,'test','12:50:52','12:50:52','1,2,3',NULL,1),
(2,'test2','12:53:15','12:53:15','1',NULL,1),
(3,'Team3','20:08:34','20:08:34','3',NULL,1),
(4,'Team1','10:05:13','10:05:13','1,2,3',NULL,1);

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
(1,'admin@bewithdhanu.in','$2y$10$SAvFim22ptA9gHVORtIaru1dn9rhgerJlJCPxRNA02MjQaJnkxawq','Manager','9890098900',1,1,0,0,'2015-07-01 18:56:49',1,'2017-06-19 09:22:53'),
(2,'manager@bewithdhanu.in','$2y$10$Gkl9ILEdGNoTIV9w/xpf3.mSKs0LB1jkvvPKK7K0PSYDsQY7GE9JK','Team Lead','9890098900',2,1,0,1,'2016-12-09 17:49:56',1,'2019-01-31 20:01:25'),
(3,'employee@bewithdhanu.in','$2y$10$MB5NIu8i28XtMCnuExyFB.Ao1OXSteNpCiZSiaMSRPQx1F1WLRId2','Employee','9890098900',3,2,0,1,'2016-12-09 17:50:22',1,'2019-01-31 20:01:32'),
(4,'Lead1@bewithdhanu.in','$2y$10$2QUQrMYTLw4YV8uVEh34DegWPxpony68GPTDV/KVenAs2UVkOT9Eq','Lead1','1234567880',2,1,0,1,'2019-01-24 13:16:30',NULL,NULL),
(5,'emp1@gmail.com','$2y$10$.C1XDN7WGZ2xyuhhFIgnVuukjEPZfwW4RuELsK4cheziBsYBC/E5q','Emp','1223343435',3,1,0,2,'2019-01-24 13:43:31',1,'2019-02-04 06:22:35'),
(6,'emp2@gmail.com','$2y$10$x1SFPJNLemStX4.fA.NTfugLdFjS9J0slLmqoTsl/Xr2.qMXYOc92','Emp2','1234567890',3,2,1,2,'2019-01-24 13:58:10',1,'2019-01-31 20:06:00'),
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
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_daily_breaks` */

insert  into `user_daily_breaks`(`id`,`user_tracking_id`,`userid`,`breakid`,`break_start`,`break_end`,`break_hours`,`remarks`,`created_on`) values 
(59,19,1,1,'2019-02-01 12:23:51','2019-02-01 12:23:51','00:00:07',NULL,'2019-02-01'),
(60,19,1,2,'2019-02-01 12:23:48',NULL,NULL,NULL,'2019-02-01'),
(61,22,1,1,'2019-02-03 17:38:13','2019-02-03 17:38:13','00:02:28',NULL,'2019-02-03'),
(62,22,1,2,'2019-02-03 17:41:31','2019-02-03 17:41:31','00:03:10',NULL,'2019-02-03'),
(63,22,1,3,'2019-02-03 17:42:25','2019-02-03 17:42:25','00:00:48',NULL,'2019-02-03'),
(64,23,2,1,'2019-02-03 17:49:10','2019-02-03 17:49:10','00:00:08',NULL,'2019-02-03'),
(65,23,2,2,'2019-02-03 17:51:04','2019-02-03 17:51:04','00:01:07',NULL,'2019-02-03'),
(69,27,2,1,'2019-02-04 10:12:48','2019-02-04 10:12:48','00:21:04',NULL,'2019-02-04'),
(77,27,2,2,'2019-02-04 10:20:05',NULL,NULL,NULL,'2019-02-04'),
(81,24,1,2,'2019-02-04 23:08:02','2019-02-04 23:08:02','00:00:05',NULL,'2019-02-04'),
(82,24,1,1,'2019-02-04 23:08:15','2019-02-04 23:08:15','00:00:09',NULL,'2019-02-04'),
(83,24,1,3,'2019-02-04 23:08:12','2019-02-04 23:08:12','00:00:03',NULL,'2019-02-04'),
(84,29,1,1,'2019-02-05 06:49:58','2019-02-05 06:49:58','00:01:13',NULL,'2019-02-05'),
(85,29,1,2,'2019-02-05 06:50:11','2019-02-05 06:50:11','00:00:08',NULL,'2019-02-05'),
(86,29,1,3,'2019-02-05 06:50:25','2019-02-05 06:50:25','00:00:10',NULL,'2019-02-05');

/*Table structure for table `user_daily_tracking` */

DROP TABLE IF EXISTS `user_daily_tracking`;

CREATE TABLE `user_daily_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `day_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `day_end` timestamp NULL DEFAULT NULL,
  `spend_hours` time DEFAULT NULL,
  `break_hours` time DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_daily_tracking` */

insert  into `user_daily_tracking`(`id`,`userid`,`day_start`,`day_end`,`spend_hours`,`break_hours`,`remarks`,`created_on`) values 
(16,1,'2019-01-31 21:21:07','2019-01-31 21:21:07','00:15:08',NULL,NULL,'2019-01-31'),
(19,1,'2019-02-01 12:23:07','2019-02-01 12:23:07',NULL,NULL,NULL,'2019-02-01'),
(21,1,'2019-02-02 21:11:12',NULL,NULL,NULL,NULL,'2019-02-02'),
(22,1,'2019-02-03 18:11:00','2019-02-03 17:42:31','00:06:53','00:01:00',NULL,'2019-02-03'),
(23,2,'2019-02-03 18:05:27','2019-02-03 18:05:27','00:14:18','00:01:00',NULL,'2019-02-03'),
(24,1,'2019-02-04 22:51:52','2019-02-04 22:51:52','16:30:08','00:01:00',NULL,'2019-02-04'),
(27,2,'2019-02-04 07:14:13','2019-02-04 07:14:13','00:36:41','00:00:00',NULL,'2019-02-04'),
(28,5,'2019-02-04 07:13:40','2019-02-04 07:13:40','00:32:00','00:00:00',NULL,'2019-02-04'),
(29,1,'2019-02-05 06:58:43','2019-02-05 06:58:43','00:44:19','00:01:00',NULL,'2019-02-05');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
