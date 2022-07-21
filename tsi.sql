/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.22-MariaDB : Database - uktv2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ts` */

DROP TABLE IF EXISTS `ts`;

CREATE TABLE `ts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_next` int(10) unsigned DEFAULT NULL,
  `ts_before` int(10) unsigned DEFAULT NULL,
  `created_user` int(11) NOT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `deleted_user` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ts` */

insert  into `ts`(`id`,`name`,`ts_code`,`ts_next`,`ts_before`,`created_user`,`updated_user`,`deleted_user`,`deleted_at`,`created_at`,`updated_at`) values 
(1,'Semua Tingkatan','ALL',0,0,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(2,'Pratama Taruna','PT',3,0,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(3,'Pratama Madya','PM',4,2,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(4,'Pratama Utama','PU',5,3,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(5,'Satria Taruna','ST',6,4,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(6,'Satria Madya','SM',7,5,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(7,'Satria Utama','SU',8,6,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(8,'Pendekar Muda Taruna','PMT',9,7,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(9,'Pendekar Muda Madya','PMM',10,8,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(10,'Pendekar Muda Utama','PMU',11,9,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30'),
(11,'Dewan Guru','DG',0,10,1,NULL,NULL,NULL,'2022-07-21 11:50:30','2022-07-21 11:50:30');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
