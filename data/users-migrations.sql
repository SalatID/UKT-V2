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

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(19,'2014_10_12_100000_create_password_resets_table',1),
(20,'2019_08_19_000000_create_failed_jobs_table',1),
(21,'2019_12_14_000001_create_personal_access_tokens_table',1),
(22,'2022_05_25_153650_create_log_program_table',1),
(23,'2022_06_17_033748_create_jurus_table',1),
(24,'2022_06_17_034046_create_kelompok_table',1),
(25,'2022_06_17_034100_create_komwil_table',1),
(27,'2022_06_17_034119_create_penilai_table',1),
(29,'2022_06_17_034138_create_ts_table',1),
(30,'2022_06_17_034148_create_unit_table',1),
(34,'2022_06_17_062147_create_event_member_table',1),
(38,'2022_06_17_034128_create_peserta_table',4),
(39,'2022_06_17_034214_create_event_table',5),
(40,'2014_10_12_000000_create_users_table',6),
(44,'2022_06_17_034109_create_nilai_table',7),
(46,'2022_06_17_040845_create_summary_nilai_table',8),
(48,'2022_07_12_085321_create_jobs_table',10),
(51,'2022_06_17_041225_create_summary_nilai_detail_table',11);

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`phone`,`phone_verified_at`,`role`,`komwil_id`,`unit_id`,`event_id`,`deleted_user`,`created_user`,`updated_user`,`deleted_at`,`remember_token`,`created_at`,`updated_at`) values 
(3,'Super Admin','sa@smijakartabarat.com','2022-07-11 15:15:26','$2y$10$2Yq07LLxMIDVIShbISAeeOuO6ZVmOL/D.q92RcW4qV1MOEVfRnK56',NULL,NULL,'SPADM',1,1,NULL,NULL,1,NULL,NULL,NULL,'2022-07-11 15:15:26','2022-07-11 15:15:26'),
(4,'Komwil Jakarta Utara','komwiljakut@smijakartabarat.org',NULL,'$2y$10$aysQAqax305sGn0TEI2RfeOxHCnA391EYv/ccn6OihX60n20x3rsK',NULL,NULL,'KOMWL',2,21,1,NULL,3,NULL,NULL,NULL,'2022-07-11 15:21:30','2022-07-11 15:21:30'),
(5,'Komwil Jakarta Selatan','komwiljaksel@smijakartabarat.org',NULL,'$2y$10$ZZ0yqY6h.kNf1QsS0nUKUOvnBqWozqLFIbvDRiYS8K44Epti96HoC',NULL,NULL,'KOMWL',3,23,1,NULL,3,NULL,NULL,NULL,'2022-07-11 15:29:35','2022-07-11 15:29:35');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
