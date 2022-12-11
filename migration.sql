-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.25-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.2.0.6576
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table uktv2.activity_log
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table uktv2.activity_log: ~9 rows (approximately)
DELETE FROM `activity_log`;
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
	(1, 'default', 'created', 'App\\Models\\Peserta', 'created', 2, 'App\\Models\\User', 1, '[]', NULL, '2022-12-09 03:15:05', '2022-12-09 03:15:05'),
	(2, 'default', 'created', 'App\\Models\\Peserta', 'created', 3, 'App\\Models\\User', 1, '[]', NULL, '2022-12-09 03:15:49', '2022-12-09 03:15:49'),
	(3, 'default', 'created', 'App\\Models\\Peserta', 'created', 4, 'App\\Models\\User', 1, '[]', NULL, '2022-12-09 03:31:35', '2022-12-09 03:31:35'),
	(4, 'peserta', 'created', 'App\\Models\\Peserta', 'created', 8, 'App\\Models\\User', 1, '{"attributes":{"id":8,"no_peserta":"008","name":"dadaf","ts_awal_id":3,"ts_akhir_id":null,"tempat_lahir":"Tangerang","tgl_lahir":"2022-12-06","komwil_id":1,"unit_id":2,"kelompok_id":null,"event_id":0,"tingkat":"TK","foto":"foto_peserta\\/DCsuDXtgjf6kJOk_dadaf.jpg","created_user":1,"updated_user":null,"deleted_user":null,"deleted_at":null,"created_at":"2022-12-09T10:35:28.000000Z","updated_at":"2022-12-09T10:35:28.000000Z"}}', NULL, '2022-12-09 03:35:28', '2022-12-09 03:35:28'),
	(5, 'peserta', 'updated', 'App\\Models\\Peserta', 'updated', 3, 'App\\Models\\User', 1, '{"attributes":{"id":3,"no_peserta":"003","name":"adddfrsdfa","ts_awal_id":3,"ts_akhir_id":null,"tempat_lahir":"Tangerang","tgl_lahir":"2022-12-08","komwil_id":1,"unit_id":3,"kelompok_id":null,"event_id":0,"tingkat":"TK","foto":"foto_peserta\\/jtPiYDwzXJMvwVA_a.jpg","created_user":1,"updated_user":1,"deleted_user":null,"deleted_at":null,"created_at":"2022-12-09T10:15:49.000000Z","updated_at":"2022-12-09T10:39:12.000000Z"},"old":{"id":3,"no_peserta":"003","name":"adddfr","ts_awal_id":3,"ts_akhir_id":null,"tempat_lahir":"Tangerang","tgl_lahir":"2022-12-08","komwil_id":1,"unit_id":3,"kelompok_id":null,"event_id":0,"tingkat":"TK","foto":"foto_peserta\\/jtPiYDwzXJMvwVA_a.jpg","created_user":1,"updated_user":1,"deleted_user":null,"deleted_at":null,"created_at":"2022-12-09T10:15:49.000000Z","updated_at":"2022-12-09T10:36:41.000000Z"}}', NULL, '2022-12-09 03:39:12', '2022-12-09 03:39:12'),
	(6, 'event', 'created', 'App\\Models\\EventMaster', 'created', 1, 'App\\Models\\User', 1, '{"attributes":{"id":1,"name":"Ujian Kenaikan Tingkat","event_alias":"ujian-kenaikan-tingkat-2022","tgl_mulai":"2022-12-28 00:00:00","tgl_selesai":"2022-12-28 00:00:00","lokasi":"Cibubur","penyelenggara":"PPS Satria Muda Indonesia Komda DKI Jakarta","komwil_id":"1","gambar":"banner_event\\/9viPjzuixu7ZkNZ_ujian-kenaikan-tingkat-2022.png","blangko_sertifikat":"admin.sertifikat.blangko.jakartabarat","no_sertifikat":"\\/UKT\\/PPS-SMI\\/KOMDA-DKI\\/VIII\\/2022","created_user":1,"updated_user":null,"deleted_user":null,"deleted_at":null,"created_at":"2022-12-09T10:51:30.000000Z","updated_at":"2022-12-09T10:51:30.000000Z"}}', NULL, '2022-12-09 03:51:30', '2022-12-09 03:51:30'),
	(7, 'users', 'created', 'App\\Models\\User', 'created', 2, 'App\\Models\\User', 1, '{"attributes":{"id":2,"name":"Jakarta Barat","email":"jakartabarat@smijakartabarat.org","email_verified_at":null,"password":"$2y$10$ofeBctizaMJSvHgvzqIYN.Ra9b192KzWcUw0nfAg4vGi6oTlchsZa","phone":"1","phone_verified_at":null,"role":"KOMWL","komwil_id":1,"unit_id":3,"event_id":1,"deleted_user":null,"created_user":1,"updated_user":null,"deleted_at":null,"remember_token":null,"created_at":"2022-12-09T10:52:09.000000Z","updated_at":"2022-12-09T10:52:09.000000Z"}}', NULL, '2022-12-09 03:52:09', '2022-12-09 03:52:09'),
	(8, 'komwil', 'updated', 'App\\Models\\Komwil', 'updated', 5, 'App\\Models\\User', 1, '{"attributes":{"id":5,"name":"Lampung","address":null,"created_user":1,"updated_user":null,"deleted_user":null,"deleted_at":null,"created_at":"2022-12-04T12:41:11.000000Z","updated_at":"2022-12-09T10:52:36.000000Z"},"old":{"id":5,"name":"Jakarta Lampung","address":null,"created_user":1,"updated_user":null,"deleted_user":null,"deleted_at":null,"created_at":"2022-12-04T12:41:11.000000Z","updated_at":"2022-12-04T12:41:11.000000Z"}}', NULL, '2022-12-09 03:52:36', '2022-12-09 03:52:36'),
	(9, 'unit', 'created', 'App\\Models\\Unit', 'created', 5, 'App\\Models\\User', 1, '{"attributes":{"id":5,"name":"SDN 012 Pengadungan","tingkat":"SD","komwil_id":1,"created_user":1,"updated_user":null,"deleted_user":null,"deleted_at":null,"created_at":"2022-12-09T10:53:14.000000Z","updated_at":"2022-12-09T10:53:14.000000Z"}}', NULL, '2022-12-09 03:53:14', '2022-12-09 03:53:14');

-- Dumping structure for table uktv2.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table uktv2.migrations: ~21 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2022_05_25_153650_create_log_program_table', 2),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 3),
	(6, '2022_06_17_033748_create_jurus_table', 3),
	(7, '2022_06_17_034046_create_kelompok_table', 3),
	(8, '2022_06_17_034100_create_komwil_table', 3),
	(9, '2022_06_17_034109_create_nilai_table', 3),
	(10, '2022_06_17_034119_create_penilai_table', 3),
	(11, '2022_06_17_034128_create_peserta_table', 3),
	(12, '2022_06_17_034138_create_ts_table', 3),
	(13, '2022_06_17_034148_create_unit_table', 3),
	(14, '2022_06_17_034214_create_event_table', 3),
	(15, '2022_06_17_040845_create_summary_nilai_table', 3),
	(16, '2022_06_17_041225_create_summary_nilai_detail_table', 3),
	(17, '2022_06_17_062147_create_event_member_table', 3),
	(18, '2022_07_12_085321_create_jobs_table', 3),
	(19, '2022_12_09_095936_create_activity_log_table', 4),
	(20, '2022_12_09_095937_add_event_column_to_activity_log_table', 4),
	(21, '2022_12_09_095938_add_batch_uuid_column_to_activity_log_table', 4);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
