CREATE DATABASE  IF NOT EXISTS `intranetASM` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `intranetASM`;
-- MySQL dump 10.13  Distrib 5.7.15, for Linux (x86_64)
--
-- Host: localhost    Database: intranetASM
-- ------------------------------------------------------
-- Server version	5.7.15-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `action_plan_histories`
--

DROP TABLE IF EXISTS `action_plan_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_plan_histories` (
  `action_plan_history_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_plan_id` int(11) NOT NULL,
  `approval_type_id` int(11) NOT NULL,
  `action_plan_history_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`action_plan_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_plan_histories`
--

LOCK TABLES `action_plan_histories` WRITE;
/*!40000 ALTER TABLE `action_plan_histories` DISABLE KEYS */;
INSERT INTO `action_plan_histories` VALUES (1,2,1,'Tahun Baru Bos','1',13,0,'2016-09-07 01:21:26','2016-09-07 01:21:26'),(2,3,1,'Kabisat tanpa file','1',13,0,'2016-09-07 01:51:34','2016-09-07 01:51:34'),(3,5,1,'bula','1',13,0,'2016-09-07 03:02:00','2016-09-07 03:02:00'),(4,6,1,'test','1',13,0,'2016-09-07 03:03:21','2016-09-07 03:03:21'),(5,6,3,'Deleting','1',13,0,'2016-09-08 21:15:45','2016-09-08 21:15:45'),(6,7,1,'Jalan jalan maret bersama bobo','1',13,0,'2016-09-14 00:11:43','2016-09-14 00:11:43'),(7,8,1,'Event many many file upload','1',13,0,'2016-09-14 00:40:13','2016-09-14 00:40:13'),(8,5,3,'Deleting','1',13,0,'2016-09-15 00:25:34','2016-09-15 00:25:34'),(9,4,3,'Deleting','1',13,0,'2016-09-15 00:27:46','2016-09-15 00:27:46'),(10,1,4,'Oke sudah finished','1',9,0,'2016-09-15 01:59:32','2016-09-15 01:59:32'),(11,1,4,'Oke sudah finished','1',9,0,'2016-09-15 01:59:50','2016-09-15 01:59:50'),(12,1,4,'Oke sudah finished','1',9,0,'2016-09-15 02:00:12','2016-09-15 02:00:12'),(13,1,4,'Oke sudah finished','1',9,0,'2016-09-15 02:00:29','2016-09-15 02:00:29'),(14,1,4,'Oke sudah finished','1',9,0,'2016-09-15 02:01:13','2016-09-15 02:01:13'),(15,9,1,'Bermain bersama di ulang tahun xy','1',13,0,'2016-09-15 02:04:44','2016-09-15 02:04:44'),(16,9,4,'bagus','1',9,0,'2016-09-15 02:06:04','2016-09-15 02:06:04'),(17,2,3,'ada yang kurang','1',9,0,'2016-09-15 02:33:14','2016-09-15 02:33:14'),(18,2,1,'Tahun Baru Bos','1',13,0,'2016-09-15 03:35:53','2016-09-15 03:35:53'),(19,2,3,'file nya ketinggalan','1',9,0,'2016-09-15 03:38:54','2016-09-15 03:38:54'),(20,2,1,'Tahun Baru Bos','1',13,0,'2016-09-15 03:39:45','2016-09-15 03:39:45'),(21,2,2,'Oke. Lengkap','1',9,0,'2016-09-15 03:42:03','2016-09-15 03:42:03'),(22,10,1,'Dari dua dua','1',4,0,'2016-09-15 21:07:32','2016-09-15 21:07:32'),(23,10,2,'Sip Mantap','1',9,0,'2016-09-15 21:17:18','2016-09-15 21:17:18'),(24,11,1,'Kertas Non Event','1',4,0,'2016-09-18 20:54:54','2016-09-18 20:54:54'),(25,11,2,'oke','1',9,0,'2016-09-18 21:17:54','2016-09-18 21:17:54'),(26,12,1,'Makan Siang','1',4,0,'2016-09-18 22:02:37','2016-09-18 22:02:37'),(27,12,3,'ga ada file nya','1',9,0,'2016-09-18 22:03:08','2016-09-18 22:03:08'),(28,12,1,'Makan Siang','1',4,0,'2016-09-18 22:03:44','2016-09-18 22:03:44'),(29,12,2,'oke, bagus..','1',9,0,'2016-09-18 22:04:45','2016-09-18 22:04:45'),(30,7,2,'oke','1',9,0,'2016-09-18 23:29:53','2016-09-18 23:29:53'),(31,7,2,'oke','1',9,0,'2016-09-18 23:30:34','2016-09-18 23:30:34'),(32,3,3,'upload file nya dong','1',9,0,'2016-09-18 23:32:01','2016-09-18 23:32:01'),(33,3,1,'Kabisat tanpa file','1',13,0,'2016-09-18 23:33:14','2016-09-18 23:33:14'),(34,3,2,'oke oke','1',9,0,'2016-09-18 23:34:45','2016-09-18 23:34:45'),(35,8,3,'reject','1',9,0,'2016-09-18 23:38:38','2016-09-18 23:38:38'),(36,8,1,'Event many many file upload','1',13,0,'2016-09-18 23:39:07','2016-09-18 23:39:07'),(37,8,3,'REJECT','1',9,0,'2016-09-18 23:42:27','2016-09-18 23:42:27'),(38,8,1,'Event many many file upload','1',13,0,'2016-09-18 23:44:41','2016-09-18 23:44:41'),(39,8,3,'gagal','1',9,0,'2016-09-18 23:53:21','2016-09-18 23:53:21'),(40,8,3,'gagal','1',9,0,'2016-09-18 23:54:03','2016-09-18 23:54:03'),(41,8,3,'gagal','1',9,0,'2016-09-18 23:54:13','2016-09-18 23:54:13'),(42,8,3,'gagal','1',9,0,'2016-09-18 23:54:21','2016-09-18 23:54:21'),(43,8,1,'Event many many file upload','1',13,0,'2016-09-18 23:54:47','2016-09-18 23:54:47'),(44,8,2,'ok','1',9,0,'2016-09-18 23:55:17','2016-09-18 23:55:17'),(45,13,1,'Three','1',4,0,'2016-09-19 03:18:41','2016-09-19 03:18:41'),(46,13,2,'oke','1',9,0,'2016-09-19 03:19:55','2016-09-19 03:19:55');
/*!40000 ALTER TABLE `action_plan_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_plan_media`
--

DROP TABLE IF EXISTS `action_plan_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_plan_media` (
  `action_plan_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_plan_media`
--

LOCK TABLES `action_plan_media` WRITE;
/*!40000 ALTER TABLE `action_plan_media` DISABLE KEYS */;
INSERT INTO `action_plan_media` VALUES (1,7),(2,7),(3,7),(4,7),(5,7),(6,7),(7,7),(8,7),(9,7),(10,7),(11,7),(12,7),(13,7);
/*!40000 ALTER TABLE `action_plan_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_plan_media_edition`
--

DROP TABLE IF EXISTS `action_plan_media_edition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_plan_media_edition` (
  `action_plan_id` int(11) NOT NULL,
  `media_edition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_plan_media_edition`
--

LOCK TABLES `action_plan_media_edition` WRITE;
/*!40000 ALTER TABLE `action_plan_media_edition` DISABLE KEYS */;
INSERT INTO `action_plan_media_edition` VALUES (2,3),(3,3),(10,3),(11,3),(12,3),(13,3);
/*!40000 ALTER TABLE `action_plan_media_edition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_plan_upload_file`
--

DROP TABLE IF EXISTS `action_plan_upload_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_plan_upload_file` (
  `action_plan_id` int(11) NOT NULL,
  `upload_file_id` int(11) NOT NULL,
  `revision_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_plan_upload_file`
--

LOCK TABLES `action_plan_upload_file` WRITE;
/*!40000 ALTER TABLE `action_plan_upload_file` DISABLE KEYS */;
INSERT INTO `action_plan_upload_file` VALUES (1,1,0),(1,2,0),(2,3,0),(2,4,0),(4,5,0),(4,6,0),(6,7,0),(6,8,0),(6,9,0),(6,10,0),(6,11,0),(7,12,1),(7,13,1),(7,14,1),(8,15,0),(8,16,0),(8,17,0),(8,18,0),(8,19,0),(8,20,0),(8,21,0),(8,22,0),(8,23,0),(9,24,0),(9,25,0),(2,26,0),(2,27,0),(2,28,2),(10,29,0),(12,30,1),(3,31,1),(8,32,1),(8,33,2),(8,34,6),(13,35,0),(13,36,0),(13,37,0);
/*!40000 ALTER TABLE `action_plan_upload_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_plans`
--

DROP TABLE IF EXISTS `action_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_plans` (
  `action_plan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_type_id` int(11) NOT NULL,
  `action_plan_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `action_plan_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `action_plan_startdate` date NOT NULL,
  `action_plan_enddate` date NOT NULL,
  `flow_no` int(11) NOT NULL,
  `revision_no` int(11) NOT NULL,
  `current_user` int(11) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`action_plan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_plans`
--

LOCK TABLES `action_plans` WRITE;
/*!40000 ALTER TABLE `action_plans` DISABLE KEYS */;
INSERT INTO `action_plans` VALUES (1,1,'Bermain bersama bobo','Bermain bersama bobo','2017-01-01','2017-01-01',98,0,9,'1',13,NULL,'2016-09-07 01:18:38','2016-09-15 01:59:49'),(2,2,'Tahun Baru Edot','Tahun Baru Bos','2017-01-01','2017-01-02',98,2,13,'1',13,9,'2016-09-07 01:21:26','2016-09-15 03:42:03'),(3,2,'Kabisat Tanpa File','Kabisat tanpa file','2017-02-01','2017-02-01',98,1,13,'1',13,9,'2016-09-07 01:51:34','2016-09-18 23:34:45'),(4,1,'Eveb','Evenmt','2017-01-01','2017-01-02',2,0,9,'0',13,13,'2016-09-07 02:59:36','2016-09-15 00:27:46'),(5,1,'ta ','bula','2017-01-02','2017-02-02',2,0,9,'0',13,13,'2016-09-07 03:02:00','2016-09-15 00:25:34'),(6,1,'ge','test','2017-02-02','2017-02-15',2,0,9,'0',13,13,'2016-09-07 03:03:20','2016-09-08 21:15:45'),(7,1,'Jalan Jalan Maret','Jalan jalan maret bersama bobo','2017-03-03','2017-03-04',98,1,13,'1',13,9,'2016-09-14 00:11:43','2016-09-18 23:29:53'),(8,1,'Event Many Many File Upload','Event many many file upload','2017-03-03','2017-03-05',98,6,13,'1',13,9,'2016-09-14 00:40:12','2016-09-18 23:55:17'),(9,1,'Ulang Tahun XY','Bermain bersama di ulang tahun xy','2017-02-05','2017-02-06',98,0,13,'1',13,NULL,'2016-09-15 02:04:44','2016-09-15 02:06:04'),(10,1,'Dari Dua Dua','Dari dua dua','2017-02-01','2017-02-02',98,0,4,'1',4,9,'2016-09-15 21:07:31','2016-09-15 21:17:18'),(11,2,'Kertas','Kertas Non Event','2017-01-21','2017-01-21',98,0,4,'1',4,9,'2016-09-18 20:54:54','2016-09-18 21:17:54'),(12,1,'Makan Siang','Makan Siang','2017-02-21','2017-02-22',98,1,4,'1',4,9,'2016-09-18 22:02:36','2016-09-18 22:04:45'),(13,1,'Three','Three','2016-11-01','2016-11-01',98,0,4,'1',4,9,'2016-09-19 03:18:40','2016-09-19 03:19:55');
/*!40000 ALTER TABLE `action_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_types`
--

DROP TABLE IF EXISTS `action_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_types` (
  `action_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_type_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `action_type_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`action_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_types`
--

LOCK TABLES `action_types` WRITE;
/*!40000 ALTER TABLE `action_types` DISABLE KEYS */;
INSERT INTO `action_types` VALUES (1,'Event','Event\r\n','1',1,1,'2016-06-22 23:55:32','2016-08-31 19:53:10'),(2,'Non Event','Non Event','1',1,1,'2016-06-22 23:56:11','2016-08-31 19:53:36'),(3,'Action Type 3','','0',1,1,'2016-06-23 00:15:40','2016-08-31 19:55:23');
/*!40000 ALTER TABLE `action_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `action_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `action_alias` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `action_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions`
--

LOCK TABLES `actions` WRITE;
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` VALUES (1,'Create','C','Action Control to Create New Item','1',1,1,'2016-05-25 20:50:06','2016-05-25 21:01:44'),(2,'Read','R','Action Control to Read/View an Item','1',1,1,'2016-05-25 20:51:29','2016-05-25 21:02:36'),(3,'Update','U','Action Control to Update an Item','1',1,NULL,'2016-05-25 21:02:22','2016-05-25 21:02:22'),(4,'Delete','D','Action Control to Delete an Item','1',1,NULL,'2016-05-25 21:03:13','2016-05-25 21:03:13'),(5,'Download','DL','Action Control to Download an Item','1',1,NULL,'2016-05-25 21:05:51','2016-05-25 21:05:51'),(6,'Upload','UL','Action Control to Upload an Item','1',1,NULL,'2016-05-25 21:06:16','2016-05-25 21:06:16'),(7,'delete test','delete test','deleting test','0',1,1,'2016-05-25 21:07:16','2016-05-25 21:07:54'),(8,'Approval','A','Action Control to Approve','1',1,1,'2016-06-02 20:55:27','2016-06-02 20:55:52'),(9,'Print','P','Action Control to Print','1',1,NULL,'2016-06-02 20:56:21','2016-06-02 20:56:21');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actions_modules`
--

DROP TABLE IF EXISTS `actions_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions_modules` (
  `action_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions_modules`
--

LOCK TABLES `actions_modules` WRITE;
/*!40000 ALTER TABLE `actions_modules` DISABLE KEYS */;
INSERT INTO `actions_modules` VALUES (1,2),(2,2),(3,2),(4,2),(2,1),(2,4),(1,5),(2,5),(3,5),(4,5),(2,6),(1,7),(2,7),(3,7),(4,7),(1,8),(2,8),(3,8),(4,8),(1,9),(2,9),(3,9),(4,9),(1,10),(2,10),(3,10),(4,10),(1,11),(2,12),(1,13),(1,14),(2,14),(3,14),(4,14),(2,3),(1,4),(3,4),(4,4),(1,6),(3,6),(4,6),(2,11),(3,11),(4,11),(1,12),(3,12),(4,12),(2,13),(3,13),(4,13),(1,15),(2,15),(3,15),(4,15),(1,16),(2,16),(3,16),(4,16),(1,17),(2,17),(3,17),(4,17),(1,18),(2,18),(3,18),(4,18),(1,19),(2,19),(3,19),(4,19),(1,20),(2,20),(3,20),(4,20),(1,21),(2,21),(3,21),(4,21),(1,22),(2,22),(3,22),(4,22),(1,23),(2,23),(3,23),(4,23),(1,24),(2,24),(3,24),(4,24),(1,25),(2,25),(3,25),(4,25),(1,26),(2,26),(3,26),(4,26),(1,27),(2,27),(3,27),(4,27),(1,28),(2,28),(3,28),(4,28),(5,28),(6,28),(2,29),(1,30),(2,30),(3,30),(4,30),(1,31),(2,31),(3,31),(4,31),(8,28);
/*!40000 ALTER TABLE `actions_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advertise_positions`
--

DROP TABLE IF EXISTS `advertise_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertise_positions` (
  `advertise_position_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `advertise_position_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `advertise_position_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`advertise_position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertise_positions`
--

LOCK TABLES `advertise_positions` WRITE;
/*!40000 ALTER TABLE `advertise_positions` DISABLE KEYS */;
INSERT INTO `advertise_positions` VALUES (1,'Cover Page','Advertise Position on Cover Page','1',1,0,'2016-06-15 01:05:30','2016-06-15 01:05:30'),(2,'Back Page','Advertise Position on Back Page (edit)\r\n','1',1,1,'2016-06-15 01:05:47','2016-06-15 01:06:00'),(3,'Top Page','Top Page Position','1',1,0,'2016-06-15 01:10:00','2016-06-15 01:10:00'),(4,'Bottom Page','Bottom Page Position','1',1,0,'2016-06-15 01:10:14','2016-06-15 01:10:14'),(5,'Left Page','Left Page','1',1,0,'2016-06-15 01:10:40','2016-06-15 01:10:40'),(6,'Right Page','Right','1',1,0,'2016-06-15 01:10:52','2016-06-15 01:10:52'),(7,'Side Page','Side Page','1',1,0,'2016-06-15 01:11:11','2016-06-15 01:11:11'),(8,'Middle Page','Middle Page','1',1,0,'2016-06-15 01:12:37','2016-06-15 01:12:37'),(9,'Header','Header on a web page','1',1,1,'2016-06-15 01:12:53','2016-06-15 01:13:26'),(10,'Footer','Footer on a web page','1',1,0,'2016-06-15 01:13:09','2016-06-15 01:13:09'),(11,'Sticky Article','For a web page','1',1,0,'2016-06-15 01:13:51','2016-06-15 01:13:51');
/*!40000 ALTER TABLE `advertise_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advertise_rates`
--

DROP TABLE IF EXISTS `advertise_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertise_rates` (
  `advertise_rate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `advertise_position_id` int(11) NOT NULL,
  `advertise_size_id` int(11) NOT NULL,
  `advertise_rate_code` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `advertise_rate_normal` double NOT NULL,
  `advertise_rate_discount` double NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`advertise_rate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertise_rates`
--

LOCK TABLES `advertise_rates` WRITE;
/*!40000 ALTER TABLE `advertise_rates` DISABLE KEYS */;
INSERT INTO `advertise_rates` VALUES (1,6,1,2,'AU1100M',50,0,'0',1,1,'2016-06-15 21:24:44','2016-06-15 21:44:15'),(2,6,1,1,'AUC1100M',100000000,50000000,'1',1,1,'2016-06-15 21:40:54','2016-06-15 22:47:29'),(3,1,1,2,'NOCH50M',50000000,0,'1',1,1,'2016-06-15 21:43:07','2016-06-15 22:48:06'),(4,11,1,2,'HAI30M',999999.99,0,'1',1,0,'2016-06-15 21:45:38','2016-06-15 21:45:38'),(5,12,1,2,'KAW20M',999999.99,0,'1',1,0,'2016-06-15 21:47:19','2016-06-15 21:47:19'),(6,7,2,1,'BO50M',50000000,0,'1',1,1,'2016-06-15 21:50:24','2016-06-15 22:47:47'),(7,4,1,2,'NAK10M',10000000,0,'1',1,1,'2016-06-15 21:54:14','2016-06-15 22:55:42'),(8,6,2,1,'ABBACK40M',40000000,0,'1',1,0,'2016-06-15 21:58:49','2016-06-15 21:58:49'),(9,1,2,1,'NOBACK30M',30000000,0,'1',1,0,'2016-06-15 21:59:39','2016-06-15 21:59:39'),(10,1,1,1,'NOVCOV50M',50000000,0,'1',1,0,'2016-06-15 22:00:16','2016-06-15 22:00:16'),(11,4,2,1,'NAKBAC35M',35000000,0,'1',1,1,'2016-06-15 22:40:02','2016-06-15 22:48:19');
/*!40000 ALTER TABLE `advertise_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advertise_sizes`
--

DROP TABLE IF EXISTS `advertise_sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertise_sizes` (
  `advertise_size_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `advertise_size_code` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `advertise_size_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `advertise_size_desc` text COLLATE utf8_unicode_ci,
  `unit_id` int(11) NOT NULL,
  `advertise_size_width` double(8,2) NOT NULL,
  `advertise_size_length` double(8,2) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`advertise_size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertise_sizes`
--

LOCK TABLES `advertise_sizes` WRITE;
/*!40000 ALTER TABLE `advertise_sizes` DISABLE KEYS */;
INSERT INTO `advertise_sizes` VALUES (1,'001','1 Halaman 170 x 223 mm','Ukuran 170 x 223 mm',2,170.00,223.00,'1',1,1,'2016-06-15 00:25:52','2016-06-15 00:28:18'),(2,'002','1/2 Halaman 170 x 111.5 mm','1/2 Halaman 170 x 111.5 mm',2,170.00,111.50,'1',1,0,'2016-06-15 00:29:38','2016-06-15 00:29:38'),(3,'003','1 x 100 mmk','1 x 100 mmk',5,1.00,100.00,'1',1,0,'2016-06-15 00:31:52','2016-06-15 00:31:52'),(4,'004','1 x 50 mmk','1 x 50 mmk',5,1.00,50.00,'1',1,0,'2016-06-15 00:33:06','2016-06-15 00:33:06'),(5,'676','7','',1,9.00,9.00,'0',1,1,'2016-06-15 00:34:49','2016-06-15 00:34:55');
/*!40000 ALTER TABLE `advertise_sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approval_types`
--

DROP TABLE IF EXISTS `approval_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `approval_types` (
  `approval_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `approval_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`approval_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approval_types`
--

LOCK TABLES `approval_types` WRITE;
/*!40000 ALTER TABLE `approval_types` DISABLE KEYS */;
INSERT INTO `approval_types` VALUES (1,'Submitted','1',1,1,'2015-12-31 17:00:00','2015-12-31 17:00:00'),(2,'Approved','1',1,1,'2015-12-31 17:00:00','2015-12-31 17:00:00'),(3,'Rejected','1',1,1,'2015-12-31 17:00:00','2015-12-31 17:00:00'),(4,'Finished','1',1,1,'2015-12-31 17:00:00','2015-12-31 17:00:00');
/*!40000 ALTER TABLE `approval_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `brand_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subindustry_id` int(11) NOT NULL,
  `brand_code` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `brand_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `brand_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,1,'100001000010000','Milkita','','1',1,0,'2016-06-16 23:39:11','2016-06-16 23:39:11'),(2,3,'100001000011000','Sonice','jadi food 3','1',1,1,'2016-06-16 23:39:42','2016-06-16 23:50:27'),(3,2,'100001100010000','Indomie','','1',1,0,'2016-06-16 23:40:36','2016-06-16 23:40:36'),(4,2,'100001100011000','Supermi','','0',1,1,'2016-06-16 23:41:09','2016-06-16 23:55:29');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_contacts`
--

DROP TABLE IF EXISTS `client_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_contacts` (
  `client_contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `client_contact_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `client_contact_gender` enum('1','2') COLLATE utf8_unicode_ci NOT NULL,
  `client_contact_birthdate` date DEFAULT NULL,
  `religion_id` int(11) NOT NULL,
  `client_contact_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `client_contact_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_contact_position` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`client_contact_id`),
  UNIQUE KEY `client_contacts_client_contact_phone_unique` (`client_contact_phone`),
  UNIQUE KEY `client_contacts_client_contact_email_unique` (`client_contact_email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_contacts`
--

LOCK TABLES `client_contacts` WRITE;
/*!40000 ALTER TABLE `client_contacts` DISABLE KEYS */;
INSERT INTO `client_contacts` VALUES (1,1,'Soni','1','1995-12-12',1,'081212121212','soni@zero.com','Manager','1',1,0,'2016-06-24 00:36:23','2016-06-24 00:36:23'),(2,0,'Adni Dan','2','1985-11-12',1,'08444541112','adni@zero.com','Supervisor','1',1,1,'2016-06-24 00:41:00','2016-06-27 01:02:39'),(3,1,'Dini','2','1985-10-15',1,'085655445544','dini@zero.com','Staff','1',1,1,'2016-06-24 00:43:08','2016-06-27 01:11:49'),(8,1,'test','1','1977-10-12',1,'01848454521','test@gmal.com','test','1',1,0,'2016-06-24 00:45:18','2016-06-24 00:45:18'),(11,1,'test 2','1','1980-10-10',4,'05555','test@gma.com','test','1',1,0,'2016-06-24 00:47:55','2016-06-24 00:47:55'),(13,1,'Yahya','1','1978-12-12',1,'08874144','sf@gd.cc','Satff','1',1,0,'2016-06-24 00:50:12','2016-06-24 00:50:12'),(14,1,'r','1','1966-02-12',1,'084511442142','ff@ghgh.co','f','0',1,1,'2016-06-24 00:54:12','2016-06-27 01:29:26'),(15,1,'test','2','1888-12-12',5,'084451111','test','test','1',1,1,'2016-06-24 01:17:42','2016-06-27 01:36:27'),(16,1,'test','1','1980-12-12',1,'1234','testsaja','test','1',1,0,'2016-06-24 01:22:31','2016-06-24 01:22:31'),(17,1,'testst','1','1998-12-12',1,'123444','testsajaff','sgsdg','0',1,1,'2016-06-24 01:25:41','2016-06-27 01:29:38'),(18,1,'Aku Soni','1','1988-01-01',1,'081762761712','akusoni@zero.com','Ini','1',1,1,'2016-06-24 01:28:53','2016-06-27 01:11:32'),(19,1,'Yayat ','1','1996-08-17',1,'08121212121','yayat@zero.com','Staff','1',1,1,'2016-06-27 00:18:56','2016-06-27 01:52:24'),(20,1,'Zeni','1','1990-08-17',1,'081212121211','zeni@zero.com','Staff','1',1,0,'2016-06-27 00:19:59','2016-06-27 00:19:59'),(21,1,'dari luar','1','1992-12-12',4,'08927829827','luar@zero.com','luar','1',1,0,'2016-06-27 02:08:21','2016-06-27 02:08:21');
/*!40000 ALTER TABLE `client_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_products`
--

DROP TABLE IF EXISTS `client_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_products` (
  `client_product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `subindustry_id` int(11) NOT NULL,
  `client_product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`client_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_products`
--

LOCK TABLES `client_products` WRITE;
/*!40000 ALTER TABLE `client_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_types`
--

DROP TABLE IF EXISTS `client_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_types` (
  `client_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_type_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `client_type_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`client_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_types`
--

LOCK TABLES `client_types` WRITE;
/*!40000 ALTER TABLE `client_types` DISABLE KEYS */;
INSERT INTO `client_types` VALUES (1,'Agency','Agency','1',1,1,'2016-06-19 23:39:02','2016-06-19 23:39:39'),(2,'Company','Company','1',1,0,'2016-06-19 23:39:13','2016-06-19 23:39:13');
/*!40000 ALTER TABLE `client_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `client_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_type_id` int(11) NOT NULL,
  `client_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_formal_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_mail_address` text COLLATE utf8_unicode_ci NOT NULL,
  `client_mail_postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `client_npwp` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `client_npwp_address` text COLLATE utf8_unicode_ci NOT NULL,
  `client_npwp_postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `client_invoice_address` text COLLATE utf8_unicode_ci NOT NULL,
  `client_invoice_postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `client_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `client_fax` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `client_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `clients_client_email_unique` (`client_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,1,'Zero to Hero','PT Zero To Hero','Jalan Keboyaran Lama No 80 Jakarta Selatan','11200','424242424242424242','Jalan Keboyaran Lama No 80 Jakarta Selatan','11200','Jalan Keboyaran Lama No 80 Jakarta Selatan','11200','0215477123','0215477123','zerotohero@testing.com','20160622082558wika.jpg','1',1,1,'2016-06-22 01:02:21','2016-06-22 01:26:09');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configs` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `config_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `config_desc` text COLLATE utf8_unicode_ci,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`config_id`),
  UNIQUE KEY `configs_config_key_unique` (`config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `downloads`
--

DROP TABLE IF EXISTS `downloads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `downloads` (
  `download_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `upload_file_id` int(11) NOT NULL,
  `download_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `download_device` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `download_os` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `download_browser` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`download_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `downloads`
--

LOCK TABLES `downloads` WRITE;
/*!40000 ALTER TABLE `downloads` DISABLE KEYS */;
INSERT INTO `downloads` VALUES (1,17,'127.0.0.1','PC','Linux','Firefox',13,0,'2016-09-14 21:16:39','2016-09-14 21:16:39'),(2,23,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-14 21:26:03','2016-09-14 21:26:03'),(3,1,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-14 21:49:32','2016-09-14 21:49:32'),(4,24,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-15 02:05:48','2016-09-15 02:05:48'),(5,25,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-15 02:05:53','2016-09-15 02:05:53'),(6,28,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-15 03:41:52','2016-09-15 03:41:52'),(7,29,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-15 21:17:08','2016-09-15 21:17:08'),(8,30,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-18 22:04:31','2016-09-18 22:04:31'),(9,31,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-18 23:34:33','2016-09-18 23:34:33'),(10,35,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-19 03:19:28','2016-09-19 03:19:28'),(11,36,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-19 03:19:31','2016-09-19 03:19:31'),(12,37,'127.0.0.1','PC','Linux','Firefox',9,0,'2016-09-19 03:19:35','2016-09-19 03:19:35');
/*!40000 ALTER TABLE `downloads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flow_groups`
--

DROP TABLE IF EXISTS `flow_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flow_groups` (
  `flow_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `flow_group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flow_group_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`flow_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flow_groups`
--

LOCK TABLES `flow_groups` WRITE;
/*!40000 ALTER TABLE `flow_groups` DISABLE KEYS */;
INSERT INTO `flow_groups` VALUES (1,28,'Action Plan','Action Plan Flow System','1',1,0,'2016-08-22 00:05:55','2016-08-22 00:05:55');
/*!40000 ALTER TABLE `flow_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flows`
--

DROP TABLE IF EXISTS `flows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flows` (
  `flow_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `flow_group_id` int(11) NOT NULL,
  `flow_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `flow_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flow_no` int(11) NOT NULL,
  `flow_prev` int(11) NOT NULL,
  `flow_next` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `flow_by` enum('AUTHOR','GROUP','INDUSTRY','PIC','MEDIA') CHARACTER SET utf8 NOT NULL,
  `flow_parallel` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `flow_condition` enum('EQUAL','NOT_EQUAL','GREATER','LESS','GREATER_EQUAL','LESS_EQUAL') COLLATE utf8_unicode_ci NOT NULL,
  `flow_condition_value` int(11) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`flow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flows`
--

LOCK TABLES `flows` WRITE;
/*!40000 ALTER TABLE `flows` DISABLE KEYS */;
INSERT INTO `flows` VALUES (1,1,'Creating Action Plan','/plan/actionplan/create',1,1,2,12,'AUTHOR','false','EQUAL',0,'1',1,1,'2016-08-29 00:29:36','2016-08-29 02:00:24'),(2,1,'Appoval Action Plan','/plan/actionplan/approval/',2,1,3,18,'GROUP','false','EQUAL',0,'1',1,1,'2016-08-29 00:30:38','2016-08-29 02:30:09'),(3,1,'wrponmg','',3,2,4,12,'AUTHOR','false','EQUAL',0,'0',1,1,'2016-08-29 01:26:42','2016-08-29 01:26:52'),(4,1,'Sisipan Flow','/sisispan',2,1,3,16,'INDUSTRY','false','EQUAL',0,'0',1,1,'2016-08-29 02:29:34','2016-08-29 02:30:09');
/*!40000 ALTER TABLE `flows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `group_desc` text,
  `active` enum('0','1') DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Sales 1A','Sales 1A\r\n','1',1,NULL,'2016-06-10 06:31:03','2016-06-10 06:31:03'),(2,'Sales 1B','Sales 1B','1',1,NULL,'2016-06-10 06:31:48','2016-06-10 06:31:48'),(3,'Planner 1','','1',1,NULL,'2016-06-10 06:32:00','2016-06-10 06:32:00'),(4,'Planner 2','','1',1,NULL,'2016-06-10 06:32:10','2016-06-10 06:32:10'),(5,'Planner 3','','1',1,NULL,'2016-06-10 06:32:19','2016-06-10 06:32:19'),(6,'Publisher Bobo','Publisher Bobo','1',1,NULL,'2016-08-30 04:31:42','2016-08-30 04:31:42');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holidays` (
  `holiday_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `holiday_date` date NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
INSERT INTO `holidays` VALUES (1,'Tahun Baru 2016','2016-01-01','1',1,0,'2016-06-08 21:01:01','2016-06-08 21:01:01'),(2,'Tahun Baru Cina','0000-00-00','1',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'Tahun Baru Saka','0000-00-00','1',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'Good Friday','0000-00-00','0',1,1,'0000-00-00 00:00:00','2016-06-08 22:26:36'),(5,'Hari Buruh Internasional','0000-00-00','1',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'test','0000-00-00','1',1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'lagi lagi','0000-00-00','1',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'Kawqa','0000-00-00','1',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,'Binga','2016-03-01','1',1,0,'2016-06-08 21:37:55','2016-06-08 21:37:55'),(10,'Ya ya ya','2011-11-11','1',1,1,'0000-00-00 00:00:00','2016-06-08 17:00:00'),(11,'Natal','2016-12-25','1',1,0,'2016-06-08 21:45:53','2016-06-08 21:45:53'),(12,'Jijiji','0000-00-00','1',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,'Iii','0000-00-00','1',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,'again','2014-12-11','1',1,1,'0000-00-00 00:00:00','2016-06-08 17:00:00'),(15,'Bir','2016-09-06','1',1,0,'2016-06-08 21:55:26','2016-06-08 21:55:26'),(16,'gagaga','2015-01-01','1',1,0,'2016-06-08 17:00:00','2016-06-08 17:00:00'),(17,'Format','2012-05-01','1',1,1,'0000-00-00 00:00:00','2016-06-08 22:23:11');
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `industries`
--

DROP TABLE IF EXISTS `industries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `industries` (
  `industry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `industry_code` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `industry_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `industry_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`industry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `industries`
--

LOCK TABLES `industries` WRITE;
/*!40000 ALTER TABLE `industries` DISABLE KEYS */;
INSERT INTO `industries` VALUES (1,'10000','FOODS','Industry of food','1',1,1,'2016-06-16 00:45:21','2016-06-16 00:47:04'),(2,'20000','BEVERAGES','Industry of beverages\r\n','1',1,1,'2016-06-16 00:45:44','2016-06-16 00:47:18');
/*!40000 ALTER TABLE `industries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_types`
--

DROP TABLE IF EXISTS `inventory_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_types` (
  `inventory_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inventory_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inventory_type_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`inventory_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_types`
--

LOCK TABLES `inventory_types` WRITE;
/*!40000 ALTER TABLE `inventory_types` DISABLE KEYS */;
INSERT INTO `inventory_types` VALUES (1,'Type 1','Type 1','1',1,0,'2016-06-22 23:38:59','2016-06-22 23:38:59'),(2,'Type 2','Type 2','1',1,1,'2016-06-22 23:39:15','2016-06-22 23:39:37'),(3,'Type 3','Type 3','1',1,0,'2016-06-22 23:39:28','2016-06-22 23:39:28'),(4,'Type 4','Type 4','1',1,0,'2016-06-22 23:40:36','2016-06-22 23:40:36'),(5,'Type 5','Type 5','1',1,0,'2016-06-22 23:40:48','2016-06-22 23:40:48'),(6,'Type 6','Type 6','1',1,0,'2016-06-22 23:41:02','2016-06-22 23:41:02');
/*!40000 ALTER TABLE `inventory_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_categories`
--

DROP TABLE IF EXISTS `media_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_categories` (
  `media_category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `media_category_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`media_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_categories`
--

LOCK TABLES `media_categories` WRITE;
/*!40000 ALTER TABLE `media_categories` DISABLE KEYS */;
INSERT INTO `media_categories` VALUES (1,'Print','Media Print','1',1,1,'2016-06-07 02:21:10','2016-06-07 02:22:21'),(2,'Digital','Media Digital','1',1,0,'2016-06-07 02:22:36','2016-06-07 02:22:36'),(3,'et','te','0',1,1,'2016-06-07 02:22:47','2016-06-07 02:23:00');
/*!40000 ALTER TABLE `media_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_editions`
--

DROP TABLE IF EXISTS `media_editions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_editions` (
  `media_edition_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `media_edition_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `media_edition_publish_date` date NOT NULL,
  `media_edition_deadline_date` date NOT NULL,
  `media_edition_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`media_edition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_editions`
--

LOCK TABLES `media_editions` WRITE;
/*!40000 ALTER TABLE `media_editions` DISABLE KEYS */;
INSERT INTO `media_editions` VALUES (1,6,'1/2016','0000-00-00','0000-00-00','test','0',1,1,'2016-06-10 02:03:24','2016-06-10 03:32:26'),(2,6,'2/2016','2016-01-08','2016-01-01','','0',1,1,'2016-06-10 02:06:13','2016-06-23 23:49:34'),(3,7,'1/2016','2016-01-03','2016-12-28','','1',1,0,'2016-06-10 02:07:21','2016-06-10 02:07:21'),(4,6,'3/2016','2016-02-17','2016-02-10','','1',1,0,'2016-06-10 02:45:27','2016-06-10 02:45:27'),(5,6,'4/2016','2016-03-01','2016-02-24','','1',1,0,'2016-06-10 03:29:54','2016-06-10 03:29:54'),(6,6,'5/2016','2016-05-01','2016-04-24','','0',1,1,'2016-06-10 03:30:28','2016-06-23 23:48:50'),(7,6,'1/2016','2016-01-01','2015-12-25','','1',1,0,'2016-06-10 03:33:07','2016-06-10 03:33:07'),(8,11,'I/HAI/2016','2016-01-04','2015-12-25','','0',1,1,'2016-06-14 00:25:49','2016-06-14 00:46:26'),(9,11,'II/HAI/2016','2016-01-11','2015-12-28','','1',1,0,'2016-06-14 00:29:24','2016-06-14 00:29:24'),(10,11,'III/HAI/2016','2016-01-18','2016-01-11','','1',1,0,'2016-06-14 00:30:03','2016-06-14 00:30:03'),(11,11,'IV/HAI/2016','2016-01-25','2016-01-14','','1',1,0,'2016-06-14 00:30:31','2016-06-14 00:30:31'),(12,11,'V/HAI/2016','2016-02-01','2016-01-25','','1',1,0,'2016-06-14 00:31:11','2016-06-14 00:31:11'),(13,11,'VI/HAI/2016','2016-02-08','2016-02-01','','1',1,0,'2016-06-14 00:31:52','2016-06-14 00:31:52'),(14,11,'VII/HAI/2016','2016-02-15','2016-02-08','','1',1,0,'2016-06-14 00:34:50','2016-06-14 00:34:50'),(15,11,'IX/HAI/2016','2016-03-02','2016-02-22','','1',1,1,'2016-06-14 00:49:35','2016-06-14 01:59:55'),(16,11,'X','2016-09-09','2016-09-03','','1',1,0,'2016-06-14 00:52:40','2016-06-14 00:52:40'),(17,6,'6','2016-06-06','2016-06-01','','1',1,1,'2016-06-14 00:57:15','2016-06-14 02:01:50'),(18,11,'7/2016','2016-08-17','2016-08-17','edited','0',1,1,'2016-06-14 01:03:08','2016-06-14 01:51:11'),(19,11,'XI','2016-10-10','2016-10-01','','1',1,0,'2016-06-14 01:06:29','2016-06-14 01:06:29'),(20,11,'VIII/2016','2016-08-20','2016-08-12','test','1',1,1,'2016-06-14 01:06:51','2016-06-14 02:00:22');
/*!40000 ALTER TABLE `media_editions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_groups`
--

DROP TABLE IF EXISTS `media_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_groups` (
  `media_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_group_code` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `media_group_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `media_group_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`media_group_id`),
  UNIQUE KEY `media_groups_media_group_code_unique` (`media_group_code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_groups`
--

LOCK TABLES `media_groups` WRITE;
/*!40000 ALTER TABLE `media_groups` DISABLE KEYS */;
INSERT INTO `media_groups` VALUES (1,'CWM','Children Woman Media','Children Woman Media','1',1,1,'2016-06-07 01:40:58','2016-06-07 01:45:49'),(2,'GIM','General Interest Media','General Interest Media','1',1,0,'2016-06-07 01:41:31','2016-06-07 01:41:31'),(3,'SIM','Special Interest Media','Special Interest Media','1',1,0,'2016-06-07 01:41:59','2016-06-07 01:41:59'),(4,'DIGI','Digital','Digital','1',1,0,'2016-06-07 01:42:17','2016-06-07 01:42:17'),(5,'dle','elef','ldgfd','0',1,1,'2016-06-07 01:47:30','2016-06-07 01:49:04');
/*!40000 ALTER TABLE `media_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medias`
--

DROP TABLE IF EXISTS `medias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medias` (
  `media_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_group_id` int(11) NOT NULL,
  `media_category_id` int(11) NOT NULL,
  `media_code` char(12) COLLATE utf8_unicode_ci NOT NULL,
  `media_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `media_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'logo.jpg',
  `media_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medias`
--

LOCK TABLES `medias` WRITE;
/*!40000 ALTER TABLE `medias` DISABLE KEYS */;
INSERT INTO `medias` VALUES (1,1,1,'NOVA','Tabloid Nova','logo.jpg','Tabloid Nova\r\n','1',1,0,'2016-06-09 00:17:42','2016-06-09 00:17:42'),(2,1,2,'NOVACOM','tabloidnova.com','logo.jpg','tabloid-nova.com','1',1,1,'2016-06-09 00:18:55','2016-06-09 00:27:28'),(3,2,2,'delte','tete','logo.jpg','fdfd','0',1,1,'2016-06-09 00:28:08','2016-06-09 00:28:14'),(4,1,1,'NAKITA','Tabloid Nakita','logo.jpg','Tabloid Nakita','1',1,0,'2016-06-09 00:29:25','2016-06-09 00:29:25'),(5,3,2,'AUTOBOL','Autobild Online','autobild online.png','Auto bild online berbah','1',1,1,'2016-06-09 01:05:30','2016-06-09 02:03:10'),(6,3,1,'AUTOBILD','Majalah Auto Bild','logo.jpg','Majalah Print Auto Bild','1',1,0,'2016-06-09 01:09:19','2016-06-09 01:09:19'),(7,1,1,'BOBO','Majalah Bobo','bobo_cover2.jpg','majalah bobo','1',1,0,'2016-06-09 01:10:07','2016-06-09 01:10:07'),(8,1,2,'double','test double','20160609090245hai.jpg','double','1',1,1,'2016-06-09 01:26:08','2016-06-09 02:02:45'),(9,2,2,'Laig','test','2016-06-09 08:27:54autobild online.png','test','1',1,0,'2016-06-09 01:27:54','2016-06-09 01:27:54'),(10,1,2,'tiga','tiga','20160609083024autobild online.png','test','1',1,0,'2016-06-09 01:30:24','2016-06-09 01:30:24'),(11,2,1,'HAI','Majalah Hai','20160609090748hai.jpg','Majalah hai','1',1,0,'2016-06-09 02:07:48','2016-06-09 02:07:48'),(12,2,1,'KWKU','Majalah Kawanku','20160609090835kawanku3.jpg','Majalah Kawanku','1',1,0,'2016-06-09 02:08:35','2016-06-09 02:08:35');
/*!40000 ALTER TABLE `medias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `menu_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `menu_desc` text COLLATE utf8_unicode_ci,
  `menu_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_order` int(11) NOT NULL,
  `menu_parent` int(11) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,1,'Home','Menu for Home','zmdi zmdi-home',2,0,'1',1,1,'2016-07-13 21:05:14','2016-07-19 21:13:50'),(2,2,'Users Management','Menu for Users Management',NULL,2,0,'1',1,NULL,'2016-07-13 21:06:01','2016-07-13 21:06:01'),(3,3,'Master Data','Menu for Master Data',NULL,3,0,'1',1,NULL,'2016-07-13 21:06:47','2016-07-13 21:06:47'),(4,4,'Action Controls Management','Menu for Action Controls Management',NULL,1,3,'1',1,NULL,'2016-07-13 21:07:36','2016-07-13 21:07:36'),(5,5,'Action Types Management','Menu for Action Types Management',NULL,2,3,'1',1,NULL,'2016-07-13 21:08:29','2016-07-13 21:08:29'),(6,6,'Advertise Positions Management','Menu for Advertise Position Management',NULL,3,3,'1',1,NULL,'2016-07-13 21:09:20','2016-07-13 21:09:20'),(7,7,'Advertise Rates Management','Menu for Advertise Rates Management',NULL,4,3,'1',1,NULL,'2016-07-13 21:10:04','2016-07-13 21:10:04'),(8,8,'Advertise Sizes Management','Menu for Advertise Sizes Management',NULL,5,3,'1',1,NULL,'2016-07-13 21:10:55','2016-07-13 21:10:55'),(9,9,'Brands Management','Menu for Brand Management',NULL,6,3,'1',1,NULL,'2016-07-13 21:11:56','2016-07-13 21:11:56'),(10,10,'Clients Management','Menu for Clients Management',NULL,7,3,'1',1,NULL,'2016-07-13 21:12:36','2016-07-13 21:12:36'),(11,11,'Client Types Management','Menu for Client Types Management',NULL,8,3,'1',1,NULL,'2016-07-13 21:14:14','2016-07-13 21:14:14'),(12,12,'Groups Management','Menu for Groups Management',NULL,11,3,'1',1,1,'2016-07-13 21:14:54','2016-08-22 01:18:19'),(13,13,'Holidays Management','Menu for Holiday Management',NULL,12,3,'1',1,1,'2016-07-13 21:15:37','2016-08-22 01:18:19'),(14,14,'Industries Management','Menu for Industries Management',NULL,13,3,'1',1,1,'2016-07-13 21:16:20','2016-08-22 01:18:19'),(15,15,'Inventory Types Management','Menu for Inventory Types Management',NULL,14,3,'1',1,1,'2016-07-13 21:17:25','2016-08-22 01:18:19'),(16,16,'Media Management','Menu for Media Management',NULL,15,3,'1',1,1,'2016-07-13 21:18:05','2016-08-22 01:18:19'),(17,17,'Media Categories Management','Menu for Media Categories Management',NULL,28,3,'1',1,1,'2016-07-13 21:18:46','2016-08-31 20:41:45'),(18,18,'Media Groups Management','Menu for Media Groups Management',NULL,17,3,'1',1,1,'2016-07-13 21:19:58','2016-08-22 01:18:19'),(19,19,'Menus Management','Menu for Menus Management',NULL,18,3,'1',1,1,'2016-07-13 21:20:30','2016-08-22 01:18:19'),(20,20,'Modules Management','Menu for Modules Management',NULL,21,3,'1',1,1,'2016-07-13 21:21:42','2016-08-31 20:41:45'),(21,21,'Paper Types Management','Menu for Paper Types Management',NULL,22,3,'1',1,1,'2016-07-13 21:22:20','2016-08-31 20:41:45'),(22,22,'Proposal Types Management','Menu for Proposal Types Management',NULL,23,3,'1',1,1,'2016-07-13 21:23:10','2016-08-31 20:41:45'),(23,23,'Religions Management','Menu for Religions Management',NULL,24,3,'1',1,1,'2016-07-13 21:23:45','2016-08-31 20:41:45'),(24,24,'Roles Management','Menu for Roles Management',NULL,25,3,'1',1,1,'2016-07-13 21:24:30','2016-08-31 20:41:45'),(25,25,'Sub Industries Management','Menu for Sub Industries Management',NULL,26,3,'1',1,1,'2016-07-13 21:25:05','2016-08-31 20:41:45'),(26,26,'Units Management','Menu for Units Management',NULL,27,3,'1',1,1,'2016-07-13 21:25:57','2016-08-31 20:41:45'),(27,27,'Flow Groups Management','Menu for Flow Groups Management','zmdi zmdi-home',10,3,'1',1,1,'2016-07-20 21:39:34','2016-08-22 01:18:20'),(28,29,'Plan','Menu for plan modules','zmdi zmdi-home',4,0,'1',1,NULL,'2016-08-19 00:29:52','2016-08-19 00:29:52'),(29,28,'Action Plan','Menu for Action Plan','zmdi zmdi-home',1,28,'1',1,NULL,'2016-08-19 00:30:32','2016-08-19 00:30:32'),(30,30,'Flows Management','Menu for Flows Management','zmdi zmdi-home',9,3,'1',1,NULL,'2016-08-22 01:18:20','2016-08-22 01:18:20'),(31,31,'Notification Types Management','Menu for Notification Types Management','zmdi zmdi-home',20,3,'1',1,1,'2016-08-31 20:41:45','2016-09-01 01:52:07');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus_modules`
--

DROP TABLE IF EXISTS `menus_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus_modules` (
  `menu_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus_modules`
--

LOCK TABLES `menus_modules` WRITE;
/*!40000 ALTER TABLE `menus_modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `menus_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_05_11_093524_create_roles_table',1),('2016_05_11_094826_create_users_roles_table',1),('2016_05_11_094847_create_modules_table',1),('2016_05_11_094858_create_menus_table',1),('2016_05_11_094918_create_actions_table',1),('2016_05_11_094929_create_configs_table',1),('2016_05_11_094943_create_menus_modules_table',1),('2016_05_11_094955_create_roles_modules_table',1),('2016_05_12_071210_create_users_medias_table',1),('2016_05_12_071232_create_users_subindustries_table',1),('2016_05_12_071452_create_media_groups_table',1),('2016_05_12_071922_create_media_categories_table',1),('2016_05_12_072147_create_medias_table',1),('2016_05_12_072517_create_media_editions_table',1),('2016_05_12_072947_create_papers',1),('2016_05_12_073325_create_units_table',1),('2016_05_12_073601_create_advertise_sizes_table',1),('2016_05_12_073613_create_advertise_positions_table',1),('2016_05_12_073625_create_advertise_rates_table',1),('2016_05_12_080341_create_holidays_table',1),('2016_05_12_080353_create_religions_table',1),('2016_05_12_080404_create_industries_table',1),('2016_05_12_080412_create_subindustries_table',1),('2016_05_12_080418_create_brands_table',1),('2016_05_12_081334_create_client_types_table',1),('2016_05_12_081343_create_clients_table',1),('2016_05_12_081350_create_clients_contacts_table',1),('2016_05_12_083328_create_client_products_table',1),('2016_05_12_083339_create_flow_groups_table',1),('2016_05_12_083347_create_flows_table',1),('2016_05_12_084514_create_action_types_table',1),('2016_05_12_084528_create_inventory_types_table',1),('2016_05_12_084540_create_proposal_types_table',1),('2016_05_12_084553_create_rkk_inventories_table',1),('2016_05_12_084600_create_rkk_proposals_table',1),('2016_05_26_072328_create_actions_modules_table',2),('2016_06_10_043804_create_groups_table',2),('2016_07_21_031419_create_users_groups_table',2),('2016_08_19_042103_create_action_plans_table',2),('2016_08_19_042635_create_action_plan_media_table',2),('2016_08_19_042654_create_action_plan_media_edition_table',2),('2016_08_19_042706_create_action_plan_uploads_table',2),('2016_08_19_083415_create_upload_files_table',3),('2016_08_19_083724_create_action_plan_upload_file_table',3),('2016_09_01_032400_create_notification_types_table',4),('2016_09_01_032410_create_notifications_table',4),('2016_09_02_040009_create_role_levels_table',5),('2016_09_02_093034_create_action_plan_histories_table',6),('2016_09_14_090001_create_download_table',7),('2016_09_15_094726_create_approval_type_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `module_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `module_action` text COLLATE utf8_unicode_ci NOT NULL,
  `module_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'/home','','Home for dashboard','1',1,NULL,'2016-07-13 20:37:38','2016-07-13 20:37:38'),(2,'/user','','Module for user management','1',1,NULL,'2016-07-13 20:38:20','2016-07-13 20:38:20'),(3,'/master/#','','Module for master data parent','1',1,NULL,'2016-07-13 20:39:14','2016-07-13 20:39:14'),(4,'/master/action','','Module for Action Control Management','1',1,1,'2016-07-13 20:40:30','2016-07-13 20:41:32'),(5,'/master/actiontype','','Module for Action Type Mangement','1',1,NULL,'2016-07-13 20:41:08','2016-07-13 20:41:08'),(6,'/master/advertiseposition','','Module for Advertise Position Management','1',1,NULL,'2016-07-13 20:42:29','2016-07-13 20:42:29'),(7,'/master/advertiserate','','Module for Advertise Rate Management','1',1,NULL,'2016-07-13 20:43:39','2016-07-13 20:43:39'),(8,'/master/advertisesize','','Module for Advertise Size Management','1',1,NULL,'2016-07-13 20:44:18','2016-07-13 20:44:18'),(9,'/master/brand','','Module for Brand Management','1',1,NULL,'2016-07-13 20:48:22','2016-07-13 20:48:22'),(10,'/master/client','','Module for Client Management','1',1,NULL,'2016-07-13 20:48:50','2016-07-13 20:48:50'),(11,'/master/clienttype','','Module for Client Type Management','1',1,NULL,'2016-07-13 20:49:22','2016-07-13 20:49:22'),(12,'/master/group','','Module for Group Management','1',1,NULL,'2016-07-13 20:49:51','2016-07-13 20:49:51'),(13,'/master/holiday','','Module for Holiday Management','1',1,NULL,'2016-07-13 20:50:21','2016-07-13 20:50:21'),(14,'/master/industry','','Module for Industry Management','1',1,NULL,'2016-07-13 20:52:45','2016-07-13 20:52:45'),(15,'/master/inventorytype','','Module for Inventory Type Management','1',1,NULL,'2016-07-13 20:53:19','2016-07-13 20:53:19'),(16,'/master/media','','Module for Media Management','1',1,NULL,'2016-07-13 20:53:57','2016-07-13 20:53:57'),(17,'/master/mediacategory','','Module for Media Category Management','1',1,NULL,'2016-07-13 20:55:05','2016-07-13 20:55:05'),(18,'/master/mediagroup','','Module for Media Group Management','1',1,NULL,'2016-07-13 20:56:55','2016-07-13 20:56:55'),(19,'/master/menu','','Module for Menu Management','1',1,NULL,'2016-07-13 20:57:30','2016-07-13 20:57:30'),(20,'/master/module','','Module for Module Management','1',1,NULL,'2016-07-13 20:58:39','2016-07-13 20:58:39'),(21,'/master/paper','','Module for Paper Type Management','1',1,1,'2016-07-13 20:59:21','2016-07-13 21:00:11'),(22,'/master/proposaltype','','Module for Proposal Type Management','1',1,NULL,'2016-07-13 20:59:54','2016-07-13 20:59:54'),(23,'/master/religion','','Module for Religion Management','1',1,NULL,'2016-07-13 21:00:40','2016-07-13 21:00:40'),(24,'/master/role','','Module for Role Management','1',1,NULL,'2016-07-13 21:01:10','2016-07-13 21:01:10'),(25,'/master/subindustry','','Module for Sub Industry Management','1',1,NULL,'2016-07-13 21:01:46','2016-07-13 21:01:46'),(26,'/master/unit','','Module for Unit Management','1',1,NULL,'2016-07-13 21:02:11','2016-07-13 21:02:11'),(27,'/master/flowgroup','','Module for Flow Group Management','1',1,NULL,'2016-07-20 21:38:03','2016-07-20 21:38:03'),(28,'/plan/actionplan','','Module for Action Plan','1',1,1,'2016-08-19 00:27:44','2016-09-01 01:53:03'),(29,'/plan/#','','Parent menu for plan','1',1,NULL,'2016-08-19 00:28:49','2016-08-19 00:28:49'),(30,'/master/flow','','Flow Management','1',1,NULL,'2016-08-22 01:16:35','2016-08-22 01:16:35'),(31,'/master/notificationtype','','Module for Master Notification Type','1',1,NULL,'2016-08-31 20:40:21','2016-08-31 20:40:21');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_types`
--

DROP TABLE IF EXISTS `notification_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_types` (
  `notification_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notification_type_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notification_type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notification_type_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notification_type_desc` text CHARACTER SET utf8,
  `notification_type_need_confirmation` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`notification_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_types`
--

LOCK TABLES `notification_types` WRITE;
/*!40000 ALTER TABLE `notification_types` DISABLE KEYS */;
INSERT INTO `notification_types` VALUES (1,'actionplanapproval','Action Plan Approval','/plan/actionplan','Action Plan Approval','1','1',1,0,'2016-08-31 21:16:04','2016-09-18 20:36:52'),(2,'actionplanfinished','Action Plan Finished','/plan/actionplan','Action Plan Finished','0','1',1,0,'2016-09-15 01:54:54','2016-09-18 22:57:44'),(3,'actionplanreject','Action Plan Reject','/plan/actionplan','Action Plan Reject','1','1',1,0,'2016-09-15 02:31:06','2016-09-15 02:31:06');
/*!40000 ALTER TABLE `notification_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `notification_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notification_type_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notification_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notification_ref_id` int(11) NOT NULL,
  `notification_receiver` int(11) NOT NULL,
  `notification_senttime` datetime NOT NULL,
  `notification_readtime` datetime NOT NULL,
  `notification_status` int(11) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'actionplanapproval','Please check ',2,9,'2016-09-19 04:41:18','0000-00-00 00:00:00',1,'0',13,9,'2016-09-07 01:21:26','2016-09-18 21:41:18'),(2,'actionplanapproval','Please check ',3,9,'2016-09-19 04:41:18','0000-00-00 00:00:00',1,'0',13,9,'2016-09-07 01:51:34','2016-09-18 21:41:18'),(3,'actionplanapproval','Please check ',5,9,'2016-09-19 04:41:18','0000-00-00 00:00:00',1,'0',13,9,'2016-09-07 03:02:00','2016-09-18 21:41:18'),(4,'actionplanapproval','Please check ',6,9,'2016-09-19 04:41:12','0000-00-00 00:00:00',1,'0',13,9,'2016-09-07 03:03:21','2016-09-18 21:41:12'),(5,'actionplanapproval','Please check ',7,9,'2016-09-19 04:41:12','0000-00-00 00:00:00',1,'0',13,9,'2016-09-14 00:11:43','2016-09-18 21:41:12'),(6,'actionplanapproval','Please check ',8,9,'2016-09-19 04:41:12','0000-00-00 00:00:00',1,'0',13,9,'2016-09-14 00:40:13','2016-09-18 21:41:12'),(7,'actionplanfinished','Action Plan \"Bermain bersama bobo\" has been approved.',1,9,'2016-09-19 04:41:12','0000-00-00 00:00:00',1,'0',9,9,'2016-09-15 01:59:50','2016-09-18 21:41:12'),(8,'actionplanfinished','Action Plan \"Bermain bersama bobo\" has been approved.',1,9,'2016-09-19 04:41:12','0000-00-00 00:00:00',1,'0',9,9,'2016-09-15 02:00:12','2016-09-18 21:41:12'),(9,'actionplanfinished','Action Plan \"Bermain bersama bobo\" has been approved.',1,9,'2016-09-19 04:41:12','0000-00-00 00:00:00',1,'0',9,9,'2016-09-15 02:00:29','2016-09-18 21:41:12'),(10,'actionplanfinished','Action Plan \"Bermain bersama bobo\" has been approved.',1,9,'2016-09-19 05:01:43','0000-00-00 00:00:00',1,'0',9,9,'2016-09-15 02:01:13','2016-09-18 22:01:43'),(11,'actionplanapproval','Please check Action Plan \"Ulang Tahun XY\"',9,9,'2016-09-19 05:01:42','0000-00-00 00:00:00',1,'0',13,9,'2016-09-15 02:04:44','2016-09-18 22:01:42'),(12,'actionplanfinished','Action Plan \"Ulang Tahun XY\" has been approved.',9,13,'2016-09-19 05:49:30','0000-00-00 00:00:00',1,'0',9,13,'2016-09-15 02:06:04','2016-09-18 22:49:30'),(13,'actionplanreject','Action Plan \"Tahun Baru\" rejected.',2,13,'2016-09-19 05:49:30','0000-00-00 00:00:00',1,'0',9,13,'2016-09-15 02:33:14','2016-09-18 22:49:30'),(14,'actionplanapproval','Please check Action Plan \"Tahun Baru Edot\"',2,9,'2016-09-19 05:01:42','0000-00-00 00:00:00',1,'0',13,9,'2016-09-15 03:35:53','2016-09-18 22:01:42'),(15,'actionplanreject','Action Plan \"Tahun Baru Edot\" rejected.',2,13,'2016-09-19 05:49:30','0000-00-00 00:00:00',1,'0',9,13,'2016-09-15 03:38:54','2016-09-18 22:49:30'),(16,'actionplanapproval','Please check Action Plan \"Tahun Baru Edot\"',2,9,'2016-09-19 05:01:42','0000-00-00 00:00:00',1,'0',13,9,'2016-09-15 03:39:45','2016-09-18 22:01:42'),(17,'actionplanfinished','Action Plan \"Tahun Baru Edot\" has been approved.',2,13,'2016-09-19 05:49:30','0000-00-00 00:00:00',1,'0',9,13,'2016-09-15 03:42:03','2016-09-18 22:49:30'),(18,'actionplanapproval','Please check Action Plan \"Dari Dua Dua\"',10,9,'2016-09-19 05:01:42','0000-00-00 00:00:00',1,'0',4,9,'2016-09-15 21:07:32','2016-09-18 22:01:42'),(19,'actionplanfinished','Action Plan \"Dari Dua Dua\" has been approved.',10,4,'2016-09-19 05:58:00','2016-09-19 06:08:20',1,'0',9,4,'2016-09-15 21:17:18','2016-09-18 23:08:20'),(20,'actionplanapproval','Please check Action Plan \"Kertas\"',11,9,'2016-09-19 05:01:42','0000-00-00 00:00:00',1,'0',4,9,'2016-09-18 20:54:54','2016-09-18 22:01:42'),(21,'actionplanfinished','Action Plan \"Kertas\" has been approved.',11,4,'2016-09-19 05:58:00','2016-09-19 06:08:14',1,'0',9,4,'2016-09-18 21:17:54','2016-09-18 23:08:14'),(22,'actionplanapproval','Please check Action Plan \"Makan Siang\"',12,9,'2016-09-19 05:02:42','0000-00-00 00:00:00',1,'0',4,9,'2016-09-18 22:02:37','2016-09-18 22:02:42'),(23,'actionplanreject','Action Plan \"Makan Siang\" rejected.',12,4,'2016-09-19 06:25:37','2016-09-19 06:08:06',1,'0',9,4,'2016-09-18 22:03:08','2016-09-18 23:25:37'),(24,'actionplanapproval','Please check Action Plan \"Makan Siang\"',12,9,'2016-09-19 05:04:11','0000-00-00 00:00:00',1,'0',4,9,'2016-09-18 22:03:44','2016-09-18 22:04:11'),(25,'actionplanfinished','Action Plan \"Makan Siang\" has been approved.',12,4,'2016-09-19 05:58:00','2016-09-19 06:07:59',1,'0',9,4,'2016-09-18 22:04:45','2016-09-18 23:07:59'),(26,'actionplanfinished','Action Plan \"Jalan Jalan Maret\" has been approved.',7,13,'2016-09-19 06:31:29','2016-09-19 06:31:35',1,'0',9,13,'2016-09-18 23:30:34','2016-09-18 23:31:35'),(27,'actionplanreject','Action Plan \"Kabisat Tanpa File\" rejected.',3,13,'2016-09-19 06:32:36','2016-09-19 06:32:51',1,'0',9,13,'2016-09-18 23:32:01','2016-09-18 23:33:14'),(28,'actionplanapproval','Please check Action Plan \"Kabisat Tanpa File\"',3,9,'2016-09-19 06:34:03','2016-09-19 06:35:45',1,'0',13,9,'2016-09-18 23:33:14','2016-09-18 23:35:45'),(29,'actionplanfinished','Action Plan \"Kabisat Tanpa File\" has been approved.',3,13,'2016-09-19 06:35:15','2016-09-19 06:36:04',1,'0',9,13,'2016-09-18 23:34:45','2016-09-18 23:36:04'),(30,'actionplanreject','Action Plan \"Event Many Many File Upload\" rejected.',8,13,'2016-09-19 06:38:48','0000-00-00 00:00:00',1,'0',9,13,'2016-09-18 23:38:38','2016-09-18 23:39:07'),(31,'actionplanapproval','Please check Action Plan \"Event Many Many File Upload\"',8,9,'2016-09-19 06:39:15','2016-09-19 06:39:33',1,'0',13,9,'2016-09-18 23:39:07','2016-09-18 23:54:21'),(32,'actionplanreject','Action Plan \"Event Many Many File Upload\" rejected.',8,13,'2016-09-19 06:43:08','2016-09-19 06:44:29',1,'0',9,13,'2016-09-18 23:42:27','2016-09-18 23:54:47'),(33,'actionplanapproval','Please check Action Plan \"Event Many Many File Upload\"',8,9,'2016-09-19 06:45:19','0000-00-00 00:00:00',1,'0',13,9,'2016-09-18 23:44:41','2016-09-18 23:55:17'),(34,'actionplanreject','Action Plan \"Event Many Many File Upload\" rejected.',8,13,'2016-09-19 06:54:34','0000-00-00 00:00:00',1,'0',9,13,'2016-09-18 23:54:21','2016-09-18 23:54:34'),(35,'actionplanapproval','Please check Action Plan \"Event Many Many File Upload\"',8,9,'2016-09-19 06:54:59','2016-09-19 09:16:38',1,'0',13,9,'2016-09-18 23:54:47','2016-09-19 02:16:38'),(36,'actionplanfinished','Action Plan \"Event Many Many File Upload\" has been approved.',8,13,'2016-09-19 06:55:49','0000-00-00 00:00:00',1,'0',9,13,'2016-09-18 23:55:17','2016-09-18 23:55:49'),(37,'actionplanapproval','Please check Action Plan \"Three\"',13,9,'2016-09-19 10:19:07','2016-09-19 10:19:15',1,'0',4,9,'2016-09-19 03:18:41','2016-09-19 03:19:55'),(38,'actionplanfinished','Action Plan \"Three\" has been approved.',13,4,'2016-09-19 10:20:09','2016-09-19 10:20:15',1,'0',9,4,'2016-09-19 03:19:55','2016-09-19 03:20:15');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `papers`
--

DROP TABLE IF EXISTS `papers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `papers` (
  `paper_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `paper_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paper_width` double(8,2) NOT NULL,
  `paper_length` double(8,2) NOT NULL,
  `paper_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`paper_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `papers`
--

LOCK TABLES `papers` WRITE;
/*!40000 ALTER TABLE `papers` DISABLE KEYS */;
INSERT INTO `papers` VALUES (1,2,'A4',270.00,330.00,'Kertas Ukuran A4','1',1,1,'2016-06-08 01:45:55','2016-06-08 02:00:23'),(2,2,'A5',165.00,270.00,'Kertas ukuran A5','1',1,1,'2016-06-08 01:46:35','2016-06-08 02:00:13'),(3,3,'F5',100.00,1000.00,'terst','0',1,1,'2016-06-08 02:08:32','2016-06-08 02:08:49');
/*!40000 ALTER TABLE `papers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal_types`
--

DROP TABLE IF EXISTS `proposal_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proposal_types` (
  `proposal_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `proposal_type_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `proposal_type_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`proposal_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal_types`
--

LOCK TABLES `proposal_types` WRITE;
/*!40000 ALTER TABLE `proposal_types` DISABLE KEYS */;
INSERT INTO `proposal_types` VALUES (1,'Ad Package','1 hari','1',1,1,'2016-06-23 00:20:14','2016-06-23 00:21:06'),(2,'Etalase','','1',1,0,'2016-06-23 00:20:24','2016-06-23 00:20:24'),(3,'Integrated','','1',1,0,'2016-06-23 00:20:39','2016-06-23 00:20:39'),(4,'Non Integrated','','1',1,0,'2016-06-23 00:20:50','2016-06-23 00:20:50');
/*!40000 ALTER TABLE `proposal_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `religions`
--

DROP TABLE IF EXISTS `religions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `religions` (
  `religion_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `religion_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`religion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `religions`
--

LOCK TABLES `religions` WRITE;
/*!40000 ALTER TABLE `religions` DISABLE KEYS */;
INSERT INTO `religions` VALUES (1,'Islam','1',1,1,'2016-05-19 02:00:10','2016-05-19 02:00:10'),(2,'Kristen Katolik','1',1,1,'2016-05-19 02:00:10','2016-05-19 02:00:10'),(3,'Kristen Protestan','1',1,1,'2016-05-19 02:00:10','2016-05-19 02:00:10'),(4,'Hindu','1',1,1,'2016-05-19 02:00:10','2016-05-19 02:00:10'),(5,'Budha','1',1,1,'2016-05-19 02:00:10','2016-05-19 02:00:10'),(6,'Konghucu Edit','0',1,1,'2016-05-23 02:08:49','2016-05-23 02:10:41'),(7,'tujuh','1',1,0,'2016-05-25 01:58:21','2016-05-25 01:58:21');
/*!40000 ALTER TABLE `religions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rkk_inventories`
--

DROP TABLE IF EXISTS `rkk_inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rkk_inventories` (
  `rkk_inventory_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `inventory_type_id` int(11) NOT NULL,
  `rkk_inventory_day` int(11) NOT NULL,
  `rkk_inventory_value` int(11) NOT NULL,
  `rkk_inventory_poin` int(11) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rkk_inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rkk_inventories`
--

LOCK TABLES `rkk_inventories` WRITE;
/*!40000 ALTER TABLE `rkk_inventories` DISABLE KEYS */;
/*!40000 ALTER TABLE `rkk_inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rkk_proposals`
--

DROP TABLE IF EXISTS `rkk_proposals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rkk_proposals` (
  `rkk_proposal_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `proposal_type_id` int(11) NOT NULL,
  `rkk_proposal_day` int(11) NOT NULL,
  `rkk_proposal_value` int(11) NOT NULL,
  `rkk_proposal_poin` int(11) NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rkk_proposal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rkk_proposals`
--

LOCK TABLES `rkk_proposals` WRITE;
/*!40000 ALTER TABLE `rkk_proposals` DISABLE KEYS */;
/*!40000 ALTER TABLE `rkk_proposals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_levels`
--

DROP TABLE IF EXISTS `role_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_levels` (
  `role_level_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_level_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_level_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_levels`
--

LOCK TABLES `role_levels` WRITE;
/*!40000 ALTER TABLE `role_levels` DISABLE KEYS */;
INSERT INTO `role_levels` VALUES (1,'Level 1','Staff','1',1,1,'2016-09-01 21:22:39','2016-09-01 21:22:39'),(2,'Level 2','Superintendent','1',1,1,'2016-09-01 21:22:39','2016-09-01 21:22:39'),(3,'Level 3','Manager','1',1,1,'2016-09-01 21:22:39','2016-09-01 21:22:39'),(4,'Level 4','Division Head','1',1,1,'2016-09-01 21:22:39','2016-09-01 21:22:39'),(5,'Level 5','General Manager','1',1,1,'2016-09-01 21:22:39','2016-09-01 21:22:39'),(6,'Level 6','Administrator','1',1,1,'2016-09-01 21:22:39','2016-09-01 21:22:39'),(7,'Level 7','Super Administrator','1',1,1,'2016-09-01 21:22:39','2016-09-01 21:22:39');
/*!40000 ALTER TABLE `role_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_level_id` int(11) DEFAULT NULL,
  `role_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `role_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,7,'Super Administrator','Role for Super Administrator','1',1,1,'2016-05-19 02:00:10','2016-09-02 00:29:53'),(2,6,'Administrator','Role for Adminstrator','1',1,1,'2016-05-20 00:31:22','2016-09-02 00:30:33'),(3,1,'Operator','Role for operator','1',1,1,'2016-05-20 00:33:20','2016-07-13 21:35:02'),(4,1,'Secretary','Role untuk secretary','1',1,1,'2016-05-20 00:35:15','2016-07-13 21:39:09'),(5,1,'Traffic Officer','Traffic officer','1',1,1,'2016-05-20 00:51:39','2016-05-23 00:35:06'),(6,1,'Implementer Officer','Implementer officer','1',1,1,'2016-05-20 00:52:37','2016-07-13 21:37:15'),(7,1,'Sales Officer','Sales Officer','1',1,1,'2016-05-20 00:55:04','2016-07-13 21:38:12'),(8,1,'test dulu','testst','1',1,1,'2016-05-20 01:17:47','2016-05-23 00:34:49'),(9,1,'remo','remo','1',1,1,'2016-05-20 01:18:57','2016-05-23 00:24:21'),(10,1,'Ka','operatero','1',1,1,'2016-05-20 01:19:39','2016-07-13 21:45:08'),(11,1,'tets','ststs','1',1,1,'2016-05-20 03:25:28','2016-05-23 00:32:10'),(12,1,'Publisher Officer','Roles for Editorial or Marcom','1',1,2,'2016-05-20 03:29:41','2016-09-14 21:29:45'),(13,1,'zz','baru lagi','1',1,1,'2016-05-23 01:01:33','2016-07-13 21:35:57'),(14,1,'ngetes lagi','ngetes','1',1,1,'2016-05-23 01:03:03','2016-07-13 21:37:29'),(15,1,'z','gfd','1',1,1,'2016-05-23 01:36:00','2016-07-13 21:35:22'),(16,1,'fdsfa','fsdafas','1',1,1,'2016-05-23 01:36:07','2016-07-13 21:36:25'),(17,1,'fsdfasf','fsafasf','1',1,NULL,'2016-05-23 01:36:15','2016-05-23 01:36:15'),(18,2,'Publisher Superintendent','Roles for Editorial or Marcom Superintendent','1',1,1,'2016-05-23 01:36:24','2016-09-02 00:31:31'),(19,1,'ola','ola','1',1,1,'2016-05-23 01:38:11','2016-07-13 21:37:49'),(20,1,'Soni Role','Soni Role','1',1,1,'2016-07-12 21:07:45','2016-07-12 21:19:37'),(21,1,'Soni Role','Soni Role','1',1,1,'2016-07-12 21:08:08','2016-07-13 21:39:22'),(22,1,'Soni Role','Soni Role','1',1,1,'2016-07-12 21:08:30','2016-07-13 21:39:37'),(23,1,'Soni Role','Soni Role','1',1,1,'2016-07-12 21:09:31','2016-07-13 21:39:55'),(24,1,'Soni Role','Soni Role','1',1,1,'2016-07-12 21:10:43','2016-07-13 21:40:10'),(25,1,'Tole','Tole','1',1,1,'2016-07-12 21:19:00','2016-07-13 21:40:26'),(26,1,'Haha','haha','1',1,1,'2016-07-12 21:19:58','2016-07-12 21:22:57'),(27,1,'Haha','haha','1',1,1,'2016-07-12 21:21:29','2016-07-12 21:23:04'),(28,1,'Haha','haha','1',1,1,'2016-07-12 21:21:39','2016-07-12 21:23:16'),(29,1,'Haha','haha','1',1,1,'2016-07-12 21:21:47','2016-07-13 21:36:38'),(30,1,'homwe','home','1',1,1,'2016-07-12 22:01:24','2016-07-13 21:36:54');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_modules`
--

DROP TABLE IF EXISTS `roles_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_modules` (
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_modules`
--

LOCK TABLES `roles_modules` WRITE;
/*!40000 ALTER TABLE `roles_modules` DISABLE KEYS */;
INSERT INTO `roles_modules` VALUES (15,1,2,1),(13,1,2,1),(16,1,2,1),(29,1,2,1),(30,1,2,1),(6,1,2,1),(14,1,2,1),(19,1,2,1),(7,1,2,1),(4,1,2,1),(21,1,2,1),(22,1,2,1),(23,1,2,1),(24,1,2,1),(25,1,2,1),(10,1,2,1),(3,1,2,1),(3,3,2,1),(3,4,2,1),(3,4,3,1),(3,5,1,1),(3,5,2,1),(3,5,3,1),(3,5,4,1),(3,6,1,1),(3,6,2,1),(3,6,3,1),(3,6,4,1),(3,7,1,1),(3,7,2,1),(3,7,3,1),(3,7,4,1),(3,8,1,1),(3,8,2,1),(3,8,3,1),(3,8,4,1),(3,9,1,1),(3,9,2,1),(3,9,3,1),(3,9,4,1),(3,10,1,1),(3,10,2,1),(3,10,3,1),(3,10,4,1),(3,11,1,1),(3,11,2,1),(3,11,3,1),(3,11,4,1),(3,12,1,1),(3,12,2,1),(3,12,3,1),(3,12,4,1),(3,13,1,1),(3,13,2,1),(3,13,3,1),(3,13,4,1),(3,14,1,1),(3,14,2,1),(3,14,3,1),(3,14,4,1),(3,15,1,1),(3,15,2,1),(3,15,3,1),(3,15,4,1),(3,16,1,1),(3,16,2,1),(3,16,3,1),(3,18,2,1),(3,18,3,1),(3,21,1,1),(3,21,2,1),(3,21,3,1),(3,21,4,1),(3,22,1,1),(3,22,2,1),(3,22,3,1),(3,22,4,1),(3,25,1,1),(3,25,2,1),(3,25,3,1),(3,25,4,1),(3,26,1,1),(3,26,2,1),(3,26,3,1),(3,26,4,1),(1,1,2,1),(1,2,1,1),(1,2,2,1),(1,2,3,1),(1,2,4,1),(1,3,2,1),(1,4,1,1),(1,4,2,1),(1,4,3,1),(1,4,4,1),(1,5,1,1),(1,5,2,1),(1,5,3,1),(1,5,4,1),(1,6,1,1),(1,6,2,1),(1,6,3,1),(1,6,4,1),(1,7,1,1),(1,7,2,1),(1,7,3,1),(1,7,4,1),(1,8,1,1),(1,8,2,1),(1,8,3,1),(1,8,4,1),(1,9,1,1),(1,9,2,1),(1,9,3,1),(1,9,4,1),(1,10,1,1),(1,10,2,1),(1,10,3,1),(1,10,4,1),(1,11,1,1),(1,11,2,1),(1,11,3,1),(1,11,4,1),(1,30,1,1),(1,30,2,1),(1,30,3,1),(1,30,4,1),(1,27,1,1),(1,27,2,1),(1,27,3,1),(1,27,4,1),(1,12,1,1),(1,12,2,1),(1,12,3,1),(1,12,4,1),(1,13,1,1),(1,13,2,1),(1,13,3,1),(1,13,4,1),(1,14,1,1),(1,14,2,1),(1,14,3,1),(1,14,4,1),(1,15,1,1),(1,15,2,1),(1,15,3,1),(1,15,4,1),(1,16,1,1),(1,16,2,1),(1,16,3,1),(1,16,4,1),(1,18,1,1),(1,18,2,1),(1,18,3,1),(1,18,4,1),(1,19,1,1),(1,19,2,1),(1,19,3,1),(1,19,4,1),(1,31,1,1),(1,31,2,1),(1,31,3,1),(1,31,4,1),(1,20,1,1),(1,20,2,1),(1,20,3,1),(1,20,4,1),(1,21,1,1),(1,21,2,1),(1,21,3,1),(1,21,4,1),(1,22,1,1),(1,22,2,1),(1,22,3,1),(1,22,4,1),(1,23,1,1),(1,23,2,1),(1,23,3,1),(1,23,4,1),(1,24,1,1),(1,24,2,1),(1,24,3,1),(1,24,4,1),(1,25,1,1),(1,25,2,1),(1,25,3,1),(1,25,4,1),(1,26,1,1),(1,26,2,1),(1,26,3,1),(1,26,4,1),(1,17,1,1),(1,17,2,1),(1,17,3,1),(1,17,4,1),(1,29,2,1),(1,28,1,1),(1,28,2,1),(1,28,3,1),(1,28,4,1),(1,28,5,1),(1,28,6,1),(1,28,8,1),(2,1,2,1),(2,2,1,1),(2,2,2,1),(2,2,3,1),(2,3,2,1),(2,4,1,1),(2,4,2,1),(2,4,3,1),(2,5,1,1),(2,5,2,1),(2,5,3,1),(2,5,4,1),(2,6,1,1),(2,6,2,1),(2,6,3,1),(2,6,4,1),(2,7,1,1),(2,7,2,1),(2,7,3,1),(2,7,4,1),(2,8,1,1),(2,8,2,1),(2,8,3,1),(2,8,4,1),(2,9,1,1),(2,9,2,1),(2,9,3,1),(2,9,4,1),(2,10,1,1),(2,10,2,1),(2,10,3,1),(2,10,4,1),(2,11,1,1),(2,11,2,1),(2,11,3,1),(2,11,4,1),(2,12,1,1),(2,12,2,1),(2,12,3,1),(2,12,4,1),(2,13,1,1),(2,13,2,1),(2,13,3,1),(2,13,4,1),(2,14,1,1),(2,14,2,1),(2,14,3,1),(2,14,4,1),(2,15,1,1),(2,15,2,1),(2,15,3,1),(2,15,4,1),(2,16,1,1),(2,16,2,1),(2,16,3,1),(2,16,4,1),(2,18,1,1),(2,18,2,1),(2,18,3,1),(2,18,4,1),(2,19,1,1),(2,19,2,1),(2,19,3,1),(2,31,1,1),(2,31,2,1),(2,31,3,1),(2,31,4,1),(2,20,1,1),(2,20,2,1),(2,20,3,1),(2,21,1,1),(2,21,2,1),(2,21,3,1),(2,21,4,1),(2,22,1,1),(2,22,2,1),(2,22,3,1),(2,22,4,1),(2,23,1,1),(2,23,2,1),(2,23,3,1),(2,23,4,1),(2,24,1,1),(2,24,2,1),(2,24,3,1),(2,25,1,1),(2,25,2,1),(2,25,3,1),(2,25,4,1),(2,26,1,1),(2,26,2,1),(2,26,3,1),(2,26,4,1),(2,17,1,1),(2,17,2,1),(2,17,3,1),(2,17,4,1),(2,29,2,1),(2,28,1,1),(2,28,2,1),(2,28,3,1),(2,28,4,1),(2,28,5,1),(2,28,6,1),(2,28,8,1),(18,1,2,1),(18,29,2,1),(18,28,2,1),(18,28,3,1),(18,28,4,1),(18,28,5,1),(18,28,6,1),(18,28,8,1),(12,1,2,1),(12,29,2,1),(12,28,1,1),(12,28,2,1),(12,28,3,1),(12,28,4,1),(12,28,5,1),(12,28,6,1),(12,28,8,1);
/*!40000 ALTER TABLE `roles_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subindustries`
--

DROP TABLE IF EXISTS `subindustries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subindustries` (
  `subindustry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `industry_id` int(11) NOT NULL,
  `subindustry_code` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `subindustry_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `subindustry_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`subindustry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subindustries`
--

LOCK TABLES `subindustries` WRITE;
/*!40000 ALTER TABLE `subindustries` DISABLE KEYS */;
INSERT INTO `subindustries` VALUES (1,1,'1000010000','Food 1','','1',1,0,'2016-06-16 01:52:51','2016-06-16 01:52:51'),(2,1,'1000011000','Food 2','Food 2','1',1,0,'2016-06-16 01:53:38','2016-06-16 01:53:38'),(3,1,'1000012000','Food 3','','1',1,1,'2016-06-16 01:54:46','2016-06-16 01:55:52'),(4,2,'2000010000','Bev 1','','1',1,0,'2016-06-16 23:27:03','2016-06-16 23:27:03');
/*!40000 ALTER TABLE `subindustries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `unit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_code` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `unit_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unit_desc` text COLLATE utf8_unicode_ci,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'cm','Centimeter','Centimeter','1',1,1,'2016-06-07 23:57:19','2016-06-07 23:59:51'),(2,'mm','Milimeter','Milimeter','1',1,0,'2016-06-07 23:57:40','2016-06-07 23:57:40'),(3,'px','Pixel','Pixels','1',1,0,'2016-06-08 00:00:15','2016-06-08 00:00:15'),(4,'delet','delete it','dekete it','0',1,1,'2016-06-08 00:03:13','2016-06-08 00:03:20'),(5,'mmk','Milimeter Kolom','Milimeter Kolom\r\n','1',1,0,'2016-06-15 00:31:10','2016-06-15 00:31:10');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `upload_files`
--

DROP TABLE IF EXISTS `upload_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `upload_files` (
  `upload_file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `upload_file_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upload_file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upload_file_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upload_file_size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upload_file_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`upload_file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `upload_files`
--

LOCK TABLES `upload_files` WRITE;
/*!40000 ALTER TABLE `upload_files` DISABLE KEYS */;
INSERT INTO `upload_files` VALUES (1,'jpg','bobo_cover2.jpg','uploads/files','32912','','1',13,NULL,'2016-09-07 01:18:39','2016-09-07 01:18:39'),(2,'jpeg','images.jpeg','uploads/files','14089','','1',13,NULL,'2016-09-07 01:18:39','2016-09-07 01:18:39'),(3,'jpg','bobo_cover227.jpg','uploads/files','32912','','1',13,NULL,'2016-09-07 01:21:26','2016-09-07 01:21:26'),(4,'png','pasang_iklan.png','uploads/files','52087','','1',13,NULL,'2016-09-07 01:21:26','2016-09-07 01:21:26'),(5,'html','404.html','uploads/files','3413','','1',13,NULL,'2016-09-07 02:59:36','2016-09-07 02:59:36'),(6,'png','ideaonline.png','uploads/files','13836','','1',13,NULL,'2016-09-07 02:59:36','2016-09-07 02:59:36'),(7,'html','breadcrumb-demo.html','uploads/files','63614','','1',13,NULL,'2016-09-07 03:03:20','2016-09-07 03:03:20'),(8,'html','buttons.html','uploads/files','68710','','1',13,NULL,'2016-09-07 03:03:20','2016-09-07 03:03:20'),(9,'html','calendar.html','uploads/files','50090','','1',13,NULL,'2016-09-07 03:03:20','2016-09-07 03:03:20'),(10,'html','colors.html','uploads/files','49190','','1',13,NULL,'2016-09-07 03:03:21','2016-09-07 03:03:21'),(11,'html','components.html','uploads/files','163756','','1',13,NULL,'2016-09-07 03:03:21','2016-09-07 03:03:21'),(12,'png','ideaonline82.png','uploads/files','13836','','1',13,NULL,'2016-09-14 00:11:43','2016-09-14 00:11:43'),(13,'jpg','iklan-lucu-3.jpg','uploads/files','24852','','1',13,NULL,'2016-09-14 00:11:43','2016-09-14 00:11:43'),(14,'jpeg','images78.jpeg','uploads/files','14089','','1',13,NULL,'2016-09-14 00:11:43','2016-09-14 00:11:43'),(15,'jpeg','36-angkasa.jpeg','uploads/files','148792','','1',13,NULL,'2016-09-14 00:40:12','2016-09-14 00:40:12'),(16,'html','alerts.html','uploads/files','42966','','1',13,NULL,'2016-09-14 00:40:12','2016-09-14 00:40:12'),(17,'png','autobild online.png','uploads/files','5276','','1',13,NULL,'2016-09-14 00:40:12','2016-09-14 00:40:12'),(18,'jpg','bobo_cover279.jpg','uploads/files','32912','','1',13,NULL,'2016-09-14 00:40:12','2016-09-14 00:40:12'),(19,'jpg','hai.jpg','uploads/files','25190','','1',13,NULL,'2016-09-14 00:40:12','2016-09-14 00:40:12'),(20,'png','ideaonline9.png','uploads/files','13836','','1',13,NULL,'2016-09-14 00:40:12','2016-09-14 00:40:12'),(21,'jpg','iklan-lucu-382.jpg','uploads/files','24852','','1',13,NULL,'2016-09-14 00:40:12','2016-09-14 00:40:12'),(22,'jpeg','images70.jpeg','uploads/files','14089','','1',13,NULL,'2016-09-14 00:40:13','2016-09-14 00:40:13'),(23,'txt','ngetest.txt','uploads/files','20','','1',13,NULL,'2016-09-14 00:40:13','2016-09-14 00:40:13'),(24,'html','buttons57.html','uploads/files','68710','','1',13,NULL,'2016-09-15 02:04:44','2016-09-15 02:04:44'),(25,'jpg','iklan-lucu-340.jpg','uploads/files','24852','','1',13,NULL,'2016-09-15 02:04:44','2016-09-15 02:04:44'),(26,'jpg','hai86.jpg','uploads/files','25190','','1',13,NULL,'2016-09-15 03:35:53','2016-09-15 03:35:53'),(27,'jpg','iklan-lucu-340.jpg','uploads/files','24852','','1',13,NULL,'2016-09-15 03:35:53','2016-09-15 03:35:53'),(28,'jpg','wika.jpg','uploads/files','258970','','1',13,NULL,'2016-09-15 03:39:45','2016-09-15 03:39:45'),(29,'jpg','bobo_cover278.jpg','uploads/files','32912','','1',4,NULL,'2016-09-15 21:07:31','2016-09-15 21:07:31'),(30,'jpg','iklan-lucu-370.jpg','uploads/files','24852','','1',4,NULL,'2016-09-18 22:03:44','2016-09-18 22:03:44'),(31,'jpg','Rebeca Tamara iklan kartu im339.jpg','uploads/files','69193','','1',13,NULL,'2016-09-18 23:33:14','2016-09-18 23:33:14'),(32,'jpg','kawanku3.jpg','uploads/files','113708','','1',13,NULL,'2016-09-18 23:39:06','2016-09-18 23:39:06'),(33,'jpg','wika86.jpg','uploads/files','258970','','1',13,NULL,'2016-09-18 23:44:41','2016-09-18 23:44:41'),(34,'jpeg','images70.jpeg','uploads/files','14089','','1',13,NULL,'2016-09-18 23:54:47','2016-09-18 23:54:47'),(35,'jpeg','36-angkasa2.jpeg','uploads/files','148792','','1',4,NULL,'2016-09-19 03:18:40','2016-09-19 03:18:40'),(36,'png','ideaonline56.png','uploads/files','13836','','1',4,NULL,'2016-09-19 03:18:40','2016-09-19 03:18:40'),(37,'jpg','iklan-lucu-38.jpg','uploads/files','24852','','1',4,NULL,'2016-09-19 03:18:40','2016-09-19 03:18:40');
/*!40000 ALTER TABLE `upload_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_gender` enum('1','2') COLLATE utf8_unicode_ci NOT NULL,
  `religion_id` int(11) NOT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_lastlogin` datetime DEFAULT NULL,
  `user_lastip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_status` enum('ACTIVE','INACTIVE','BLOCKED','EXPIRED') COLLATE utf8_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_user_name_unique` (`user_name`),
  UNIQUE KEY `users_user_email_unique` (`user_email`),
  KEY `users_user_firstname_user_phone_user_birthdate_index` (`user_firstname`,`user_phone`,`user_birthdate`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'025407','soni@gramedia-majalah.com','$2y$10$kU3cWH/ZW5N0zUgN0hzhueztuyRG8u0cmu8B5lvhDgbUorqk2HBeS','Soni','Rahayu','081111111111','1',1,'1990-01-01',NULL,NULL,'avatar.jpg','ACTIVE','1',1,1,'o5SMcV2Lg98y3WsfTu2Pka3VN8WFNW7xnza6z02VquZlb837I2gSTdzuYViL','2016-05-19 02:00:10','2016-09-18 23:26:38'),(2,'004108','beni@gramedia-majalah.com','$2y$10$lOqanPVTfMtPN4AXJ/nTuOlXPzyiKt4JRi8hNE6.wug4gOVd7Lbha','Beni','Iskandar','','1',1,'1984-01-01',NULL,NULL,'avatar.jpg','ACTIVE','1',1,1,'VA0CQMAhJ6fHWZGe6W03K7WOy6DOH9S4ihxHUlyglr99Bg3MVCnfzGkIhtz5','2016-05-24 04:59:05','2016-09-15 21:13:25'),(3,'234249','duadga@gramedia-majalah.com','$2y$10$JpGbeQFZy/q8mz2uAqNgl.0MeBpO54QcMpndOesdGEC9erbVszFtG','Dua','','','1',1,NULL,NULL,NULL,'avatar.jpg','INACTIVE','0',1,1,NULL,'2016-05-24 04:59:37','2016-05-25 02:31:35'),(4,'033331','duadggga@gramedia-majalah.com','$2y$10$Kjv2kut085y7F7OQcbP.nO1h3iiujZ9IXl7U3XXwu7mVbqZjIaY16','Dua','Dua','','1',1,'2016-09-16',NULL,NULL,'avatar.jpg','ACTIVE','1',1,1,'TKekEFFMFu7CshSynCp45q0tmGKQTss6n8PUdI7FMD1QQbPxGCxZXQGoyBLt','2016-05-24 05:05:40','2016-09-19 03:18:53'),(5,'077161','nanank@gramedia-majalah.com','$2y$10$vrjq/6JdUSGL8SOPwmjRZukYsQooOgB0j38udUwhw2rxzt7WfSiQ6','Nanank','Suryanank','','1',1,'2016-05-25',NULL,NULL,'avatar.jpg','ACTIVE','1',1,1,NULL,'2016-05-24 05:07:04','2016-05-25 01:10:03'),(6,'f43r3fd','jj@jj.com','$2y$10$yxU1bvCevUEqUA/eQZQLj.yAYzs/kno6hVsciDu/79uRwUk4Fu6li','fdfs','sfdfsdf','','1',1,NULL,NULL,NULL,'avatar.jpg','INACTIVE','0',1,1,NULL,'2016-05-24 05:12:27','2016-07-12 20:10:09'),(7,'9i9i9i99','fdfdsoni@gramedia-majalah.com','$2y$10$XjC9PUIT252i.WJ6KhEJ2ewcpl0BXsCnNKkvb0Un6ujePM8.B9Yz.','ojiojoii','jojiojo','','1',1,NULL,NULL,NULL,'avatar.jpg','INACTIVE','0',1,1,NULL,'2016-05-24 05:13:08','2016-05-25 02:31:41'),(8,'9i9ifd9i99','fdfdsonfdi@gramedia-majalah.com','$2y$10$bmg8OEGkFtEOdtXufHjG7uPCfWw9mMEq9BeCG9pfqRbKdwb3M5XtK','ojiojoii','jojiojo','','1',1,NULL,NULL,NULL,'avatar.jpg','INACTIVE','0',1,1,NULL,'2016-05-24 05:13:48','2016-07-12 20:10:05'),(9,'032322','indra@gramedia-majalah.com','$2y$10$S.JYbtA5c6cWnj9fsX6jlenu7A4uAHzJuTWxMP/oHbYf7Hz9Thpm.','Superintendent','Publisher','08761616712','1',2,'1998-12-12',NULL,NULL,'avatar.jpg','ACTIVE','1',1,1,'7T0IJ0OCVI3w2PSu3Hehu8WphXRtKeJloPJ5Fhp2vw3uMSdTdG93wZ8kJVdw','2016-05-24 20:42:20','2016-09-19 03:20:01'),(10,'025405','bimo@gramedia-majalah.com','$2y$10$CV4MsFOmUCT4L/um/YI2CeGNlZ8kI54mv/d3HHsgk4UYUb6DhAJ4a','Bimo','Hendratomo','08817212341','1',1,NULL,NULL,NULL,'avatar.jpg','ACTIVE','1',1,NULL,NULL,'2016-05-24 20:53:01','2016-05-24 20:53:01'),(11,'001199','akhmadheryawan@gmail.com','$2y$10$XQkZzrztwC4vJHkvaBAUH.bwDKko8XEmrLLOhBWP9YzGZAecI7jTC','Akhmad','Heryawan','0818119123','1',5,'1977-01-01',NULL,NULL,'avatar.jpg','ACTIVE','1',1,1,NULL,'2016-05-24 21:17:20','2016-05-25 01:56:16'),(12,'administrsadsdator','rte@gr5.h','$2y$10$1jCyeUjXGkPpOjnDPS8IHuIQNIsla.Ire8YFBOEG0lmh6pfztGRma','Akhmsadasdad','asdasda','','2',3,'5227-07-24',NULL,NULL,'avatar.jpg','INACTIVE','0',1,1,NULL,'2016-05-25 00:35:08','2016-05-25 02:34:34'),(13,'033333','widya.wati@gramedia-majalah.com','$2y$10$/WwJCJwBP6.Nb5qc6uZElOFZstCJnWZDFzbLIJTPOb2IdSrnVsVpS','Widya','Wati','08122827121','2',1,'1980-12-10',NULL,NULL,'avatar.jpg','ACTIVE','1',1,1,'5cH8ZiuKc421ROTztQlYRCnYtARTbS4Y14XEsyq1EBf2vjqEtdsUvru4J1uq','2016-05-25 00:48:05','2016-09-19 02:36:39'),(14,'006329','dimas_tri@gramedia-majalah.com','$2y$10$r4e1XSHoWZLl/cwm4DZwbOyllCdpOvj7ZF8ThjSfQTkck/Uoyt8RK','Antonius Dimas','Triwicaksono','081252455162','1',2,'1985-01-01',NULL,NULL,'avatar.jpg','ACTIVE','1',1,1,'LLLQ7qCKVQl268Ndi0lXP0VtfVoiF8j5zzSy1TgU6T8u0lDZeqcWNVXT8Y9W','2016-06-10 00:17:00','2016-08-18 20:28:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (11,3),(13,6),(9,6),(2,3),(2,4),(2,5),(2,6),(2,1),(2,2),(4,6);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_medias`
--

DROP TABLE IF EXISTS `users_medias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_medias` (
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_medias`
--

LOCK TABLES `users_medias` WRITE;
/*!40000 ALTER TABLE `users_medias` DISABLE KEYS */;
INSERT INTO `users_medias` VALUES (1,1),(1,2),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(14,1),(14,4),(14,12),(11,5),(11,6),(13,7),(9,7),(2,5),(2,6),(2,7),(2,11),(2,12),(2,4),(2,1),(2,2),(2,9),(4,7);
/*!40000 ALTER TABLE `users_medias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles`
--

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` VALUES (1,1,1,1,'2016-05-19 02:00:10','2016-05-19 02:00:10'),(8,1,0,NULL,NULL,NULL),(8,4,0,NULL,NULL,NULL),(8,7,0,NULL,NULL,NULL),(10,7,0,NULL,NULL,NULL),(11,2,0,NULL,NULL,NULL),(12,1,0,NULL,NULL,NULL),(5,1,0,NULL,NULL,NULL),(14,3,0,NULL,NULL,NULL),(13,12,0,NULL,NULL,NULL),(9,18,0,NULL,NULL,NULL),(2,1,0,NULL,NULL,NULL),(4,12,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_subindustries`
--

DROP TABLE IF EXISTS `users_subindustries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_subindustries` (
  `user_id` int(11) NOT NULL,
  `subindustry_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_subindustries`
--

LOCK TABLES `users_subindustries` WRITE;
/*!40000 ALTER TABLE `users_subindustries` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_subindustries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'intranetASM'
--

--
-- Dumping routines for database 'intranetASM'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-20 14:36:56
