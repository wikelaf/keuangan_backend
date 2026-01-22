/*
SQLyog Ultimate v8.55 
MySQL - 8.0.30 : Database - dbapiserver2025_2210046
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbapiserver2025_2210046` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `dbapiserver2025_2210046`;

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `kas_2210046` */

DROP TABLE IF EXISTS `kas_2210046`;

CREATE TABLE `kas_2210046` (
  `notrans_2210046` char(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_2210046` date NOT NULL,
  `jumlahuang_2210046` double NOT NULL DEFAULT '0',
  `keterangan_2210046` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_2210046` enum('masuk','keluar') COLLATE utf8mb4_general_ci NOT NULL,
  `iduser_2210046` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`notrans_2210046`),
  KEY `iduser_2210046` (`iduser_2210046`),
  CONSTRAINT `kas_ibfk_1` FOREIGN KEY (`iduser_2210046`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kas_2210046` */

insert  into `kas_2210046`(`notrans_2210046`,`tanggal_2210046`,`jumlahuang_2210046`,`keterangan_2210046`,`jenis_2210046`,`iduser_2210046`,`created_at`,`updated_at`) values ('K2201202619870','2026-01-22',100000,'Keluar','keluar',10,'2026-01-22 11:45:41','2026-01-22 11:45:41'),('K2201202670894','2026-01-22',100000,'Keluar','keluar',9,'2026-01-22 11:42:42','2026-01-22 11:42:42'),('KU220120260442559910-IN','2026-01-22',100000,'Terima Transfer Uang dari bb','masuk',10,'2026-01-22 11:42:55','2026-01-22 11:42:55'),('KU220120260442559910-OUT','2026-01-22',100000,'Kirim Uang ke Wikel','keluar',9,'2026-01-22 11:42:55','2026-01-22 11:42:55'),('KU2201202604455494157-IN','2026-01-22',100000,'Terima Transfer Uang dari Wikel','masuk',9,'2026-01-22 11:45:54','2026-01-22 11:45:54'),('KU2201202604455494157-OUT','2026-01-22',100000,'Kirim Uang ke bb','keluar',10,'2026-01-22 11:45:54','2026-01-22 11:45:54'),('KU2201202605362686997-IN','2026-01-22',100000,'Terima Transfer Uang dari Wikel','masuk',11,'2026-01-22 12:36:26','2026-01-22 12:36:26'),('KU2201202605362686997-OUT','2026-01-22',100000,'Kirim Uang ke Caca','keluar',10,'2026-01-22 12:36:26','2026-01-22 12:36:26'),('M2201202618730','2026-01-22',5000000,'Gaji','masuk',9,'2026-01-22 11:42:25','2026-01-22 11:42:25'),('M2201202656750','2026-01-22',5000000,'Gaji','masuk',10,'2026-01-22 11:45:26','2026-01-22 11:45:26'),('MU22012026044311483539-IN','2026-01-22',100000,'Terima Permintaan Uang dari Wikel','masuk',9,'2026-01-22 11:46:37','2026-01-22 11:46:37'),('MU22012026044311483539-OUT','2026-01-22',100000,'Bayar Scan QR ke Benjamin','keluar',10,'2026-01-22 11:46:37','2026-01-22 12:31:44'),('MU220120260528196999710-IN','2026-01-22',100000,'Terima Scan QR dari Benjamin','masuk',10,'2026-01-22 12:29:02','2026-01-22 12:29:02'),('MU220120260528196999710-OUT','2026-01-22',100000,'Bayar Scan QR ke Wikel','keluar',9,'2026-01-22 12:29:02','2026-01-22 12:29:02');

/*Table structure for table `kirimuang_2210046` */

DROP TABLE IF EXISTS `kirimuang_2210046`;

CREATE TABLE `kirimuang_2210046` (
  `noref_2210046` char(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'No.Referensi',
  `tglkirim_2210046` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dari_iduser_2210046` bigint unsigned NOT NULL,
  `ke_iduser_2210046` bigint unsigned NOT NULL,
  `jumlahuang_2210046` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`noref_2210046`),
  KEY `dari_iduser_2210046` (`dari_iduser_2210046`),
  KEY `ke_iduser_2210046` (`ke_iduser_2210046`),
  CONSTRAINT `kirimuang_ibfk_1` FOREIGN KEY (`dari_iduser_2210046`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `kirimuang_ibfk_2` FOREIGN KEY (`ke_iduser_2210046`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kirimuang_2210046` */

insert  into `kirimuang_2210046`(`noref_2210046`,`tglkirim_2210046`,`dari_iduser_2210046`,`ke_iduser_2210046`,`jumlahuang_2210046`) values ('KU220120260442559910','2026-01-22 11:42:55',9,10,100000),('KU2201202604455494157','2026-01-22 11:45:54',10,9,100000),('KU2201202605362686997','2026-01-22 12:36:26',10,11,100000);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_11_04_101048_create_personal_access_tokens_table',1),(5,'2025_11_04_101155_add_ip_and_user_agent_to_users_table',1);

/*Table structure for table `mintauang_2210046` */

DROP TABLE IF EXISTS `mintauang_2210046`;

CREATE TABLE `mintauang_2210046` (
  `noref_2210046` char(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tglminta_2210046` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dari_iduser_2210046` bigint unsigned DEFAULT NULL,
  `ke_iduser_2210046` bigint unsigned DEFAULT NULL,
  `jumlahuang_2210046` double DEFAULT NULL,
  `stt_2210046` enum('pending','sukses') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tglsukses_2210046` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`noref_2210046`),
  KEY `dari_iduser_2210046` (`dari_iduser_2210046`),
  KEY `ke_iduser_2210046` (`ke_iduser_2210046`),
  CONSTRAINT `mintauang_2210046_ibfk_1` FOREIGN KEY (`dari_iduser_2210046`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `mintauang_2210046_ibfk_2` FOREIGN KEY (`ke_iduser_2210046`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `mintauang_2210046` */

insert  into `mintauang_2210046`(`noref_2210046`,`tglminta_2210046`,`dari_iduser_2210046`,`ke_iduser_2210046`,`jumlahuang_2210046`,`stt_2210046`,`tglsukses_2210046`) values ('MU22012026044311483539','2026-01-22 11:43:11',9,10,100000,'sukses','2026-01-22 04:46:37'),('MU220120260528196999710','2026-01-22 12:28:19',10,9,100000,'sukses','2026-01-22 05:29:02');

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

insert  into `personal_access_tokens`(`id`,`tokenable_type`,`tokenable_id`,`name`,`token`,`abilities`,`last_used_at`,`expires_at`,`created_at`,`updated_at`) values (1,'App\\Models\\User',5,'auth_token','b26e6c75f114cf1fb52298531c6c0708e93e273c59d6c448356555c0ab81d1c9','[\"*\"]',NULL,NULL,'2025-11-04 11:12:47','2025-11-04 11:12:47'),(3,'App\\Models\\User',7,'auth_token','5227e993fba9f59cb14502a39f3aee847ca5a88eb5810fc19a821762c424f1e8','[\"*\"]',NULL,NULL,'2025-11-05 10:37:42','2025-11-05 10:37:42'),(32,'App\\Models\\User',5,'auth_token','7f578a4ad988ea9b8896b47cba8a1f50a1f3fa41531744f781f10edbcb3a5a56','[\"*\"]',NULL,NULL,'2025-12-03 02:59:01','2025-12-03 02:59:01'),(45,'App\\Models\\User',7,'auth_token','78b819b912fa5c605b6179715538083998cc653080029fa8a8ae3af567ca04ba','[\"*\"]',NULL,NULL,'2025-12-03 03:29:25','2025-12-03 03:29:25'),(46,'App\\Models\\User',7,'auth_token','563c2e7cd7a64d5f3e7da8085158fc4444926463293b46572dd61700adf59ec9','[\"*\"]',NULL,NULL,'2025-12-03 03:29:26','2025-12-03 03:29:26'),(47,'App\\Models\\User',7,'auth_token','b1e12555c5c00edc8894344ed37e91feeceb3998e8b7b9bfc5ebc4ddcf09ebec','[\"*\"]',NULL,NULL,'2025-12-03 03:29:28','2025-12-03 03:29:28'),(48,'App\\Models\\User',7,'auth_token','5d379b6e3ff253707082c47b8dc102b367de182e4486e317bd767337f7b99c94','[\"*\"]',NULL,NULL,'2025-12-03 03:29:29','2025-12-03 03:29:29'),(49,'App\\Models\\User',7,'auth_token','83d8b6f1268fa32478b09b4634f6981f6832cc7cb8cb98dbfc480c62ce2f7d05','[\"*\"]',NULL,NULL,'2025-12-03 03:29:30','2025-12-03 03:29:30'),(51,'App\\Models\\User',5,'auth_token','451f048fb5f4b8fc54e4702d07943e2016ae2495f4661471156f96f8507a4ee5','[\"*\"]','2025-12-03 10:21:01',NULL,'2025-12-03 10:20:22','2025-12-03 10:21:01'),(72,'App\\Models\\User',5,'auth_token','14334a015cdbbc882ebcef891693312f90d00167b0376ff73e1ee7e0e72eb8a9','[\"*\"]','2025-12-17 07:44:03',NULL,'2025-12-17 07:34:18','2025-12-17 07:44:03'),(73,'App\\Models\\User',5,'auth_token','918c80b1d852fcd4556dceeecefa71b19426d90da2dd0adc40ca3d1fb7e9ecc8','[\"*\"]','2025-12-17 07:46:47',NULL,'2025-12-17 07:45:41','2025-12-17 07:46:47'),(110,'App\\Models\\User',11,'auth_token','5a00040b99c56214a8dc6e5b737030e6f63d257664b4758b40b9de2f89369f3f','[\"*\"]','2026-01-13 02:26:29',NULL,'2026-01-13 02:15:07','2026-01-13 02:26:29'),(111,'App\\Models\\User',11,'auth_token','a3ae002953bffa20dabb724f9ee0870ef40100f40e296051e39f37dc83003995','[\"*\"]','2026-01-13 15:11:07',NULL,'2026-01-13 14:47:25','2026-01-13 15:11:07'),(112,'App\\Models\\User',11,'auth_token','4b13c5c5b779a19252e8511a8de34bc3ad401c08f8f62d109ea262826f31fc5b','[\"*\"]','2026-01-14 10:41:28',NULL,'2026-01-14 10:40:50','2026-01-14 10:41:28'),(126,'App\\Models\\User',10,'auth_token','c55df999791b56a72cc26223843ccfcf44a09b3e1d01a4cab9b4d4bff8113557','[\"*\"]','2026-01-22 06:18:17',NULL,'2026-01-22 05:58:50','2026-01-22 06:18:17');

/*Table structure for table `saldouser_2210046` */

DROP TABLE IF EXISTS `saldouser_2210046`;

CREATE TABLE `saldouser_2210046` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `iduser_2210046` bigint unsigned NOT NULL,
  `jumlahsaldo_2210046` double DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `iduser_2210046` (`iduser_2210046`),
  CONSTRAINT `saldouser_ibfk_1` FOREIGN KEY (`iduser_2210046`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `saldouser_2210046` */

insert  into `saldouser_2210046`(`id`,`iduser_2210046`,`jumlahsaldo_2210046`,`created_at`,`updated_at`) values (2,9,4900000,'2025-12-23 10:54:09','2026-01-22 05:29:02'),(3,10,4800000,'2025-12-23 11:40:25','2026-01-22 05:36:26'),(4,11,100000,'2026-01-07 10:26:26','2026-01-22 05:36:26');

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values ('qDRsAkxReB6RjmmN5XxMxxEePebik0w0Wi5Zmm3O',NULL,'172.25.48.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNnpBTVM3NXpsWFI0eGtjcGRTOXBwVWs3RG1OZjhKVVduc1V4a1dIZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly8xNzIuMjUuNDguMTo4MDAwIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1762581047),('tBNtjqrGqFoEG5kINIueosRbFrBUxev5Jh9cWyLI',NULL,'10.168.64.87','okhttp/4.9.2','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOXBFbElqaWtzV1pMVEFBM2JkOFo4M1JMUVJoTTQ2Rlh3NzBhZW9UcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly8xMC4xNjguNjQuMjA2OjgwMDAiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1765362162);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_thumb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcmtoken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`,`ip_address`,`user_agent`,`photo`,`photo_thumb`,`fcmtoken`) values (9,'Benjamin','b@gmail.com',NULL,'$2y$12$DbFfynRJkfAIAXp/97J3lep9dknEpnZElET9NKqKoNsvva4.OiEnW',NULL,'2025-12-23 10:54:09','2026-01-12 15:07:06','10.161.33.146','okhttp/4.9.2','/storage/photos/1766489960.jpg','/storage/photos/thumbnail/thumb_1766489960.jpg','d0ESLuyaQi6u_YTQSwrP3O:APA91bFViS6Imt3kvj6auQgmKtAekozfjIhJpPW1jbJwSJ7hplEEUdbz_tNaLwDXhQBZkmE87sWlALjyHFfges2gHhXoVQj1Zj-8pveDCn_K0oUCZ9cZ_yI'),(10,'Wikel','wikel@gmail.com',NULL,'$2y$12$DbFfynRJkfAIAXp/97J3lep9dknEpnZElET9NKqKoNsvva4.OiEnW',NULL,'2025-12-23 11:40:25','2026-01-22 06:18:16','10.161.33.146','okhttp/4.9.2','/storage/photos/1769062696.jpg','/storage/photos/thumbnail/thumb_1769062696.jpg','d0ESLuyaQi6u_YTQSwrP3O:APA91bFViS6Imt3kvj6auQgmKtAekozfjIhJpPW1jbJwSJ7hplEEUdbz_tNaLwDXhQBZkmE87sWlALjyHFfges2gHhXoVQj1Zj-8pveDCn_K0oUCZ9cZ_yI'),(11,'Caca','c@gmail.com',NULL,'$2y$12$6c1cAjh9/zY23thlTdwWh.nzOW.ZigcerwpCPMjGDc/XTej2Mg6Jy',NULL,'2026-01-07 10:26:26','2026-01-13 02:15:07','10.161.33.206','Thunder Client (https://www.thunderclient.com)',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
