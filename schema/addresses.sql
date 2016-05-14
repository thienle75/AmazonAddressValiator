/*
SQLyog Enterprise v11.11 (64 bit)
MySQL - 5.5.41-0ubuntu0.12.04.1 : Database - teammob
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `addresses` */

DROP TABLE IF EXISTS `addresses`;

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('civic','pobox','pobox_civic','rural','rural_civic') COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The type of the address',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Name for the address',
  `street_number` int(50) DEFAULT NULL COMMENT 'The street number( e.g. 123)',
  `street_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The name of the street',
  `street_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Street, Avenue, Boulevard, ect.',
  `street_direction` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'North, South, East, West',
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Postal Code for Canada, Zip for USA',
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Province or state',
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suite` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Suite, Unit, or Apartment number',
  `buzzer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Buzzer number',
  `pobox` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'e.g. PO BOX 4001',
  `rural_route` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'e.g. RR 6',
  `station` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'e.g. STN A',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_at` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
