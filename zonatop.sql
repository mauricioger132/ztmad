/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.14-MariaDB : Database - db_usuariostest
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_usuariostest` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_usuariostest`;

/*Table structure for table `comment` */

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `file_id` (`file_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`),
  CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `comment` */

/*Table structure for table `datafiles` */

DROP TABLE IF EXISTS `datafiles`;

CREATE TABLE `datafiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(250) DEFAULT NULL,
  `dataname` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `download` int(11) DEFAULT 0,
  `is_public` int(11) DEFAULT NULL,
  `shared_data` int(11) DEFAULT 0,
  `file_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `datafiles` */

insert  into `datafiles`(`id`,`code`,`dataname`,`description`,`download`,`is_public`,`shared_data`,`file_id`,`created_at`) values (6,'M-so2ao8GekK','geom_desert_rose_nikko_culture_remix_-8014087692162036906.mp3','',0,0,0,42,'2020-12-10 17:50:13'),(8,'cIDF-ypUEdWA','descarga.jpg','',0,0,0,44,'2020-12-11 15:43:38'),(9,'a7BrWZSHpmjv','coffee_face_feat_sevenever_my_way_andrey_kravtsov_remix_7333071624008689129.mp3','',0,0,0,42,'2020-12-12 11:34:36');

/*Table structure for table `file` */

DROP TABLE IF EXISTS `file`;

CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(12) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `download` int(11) NOT NULL DEFAULT 0,
  `is_public` tinyint(1) NOT NULL,
  `shared_file` int(11) DEFAULT 0,
  `is_folder` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Data for the table `file` */

insert  into `file`(`id`,`code`,`filename`,`description`,`download`,`is_public`,`shared_file`,`is_folder`,`user_id`,`created_at`) values (42,'DYac53_jERMy','Musica de electronica','esta es musica electronica',0,0,0,1,3,'2020-12-10 17:50:01'),(43,'AszHzzolDF6E','descarga_1.jpg','Este es un archivin',0,0,0,0,3,'2020-12-11 13:50:34'),(44,'PpCk5CigkDam','Musica de bachata','Estas son canciones de bachata',0,0,0,1,6,'2020-12-11 15:43:26');

/*Table structure for table `permision` */

DROP TABLE IF EXISTS `permision`;

CREATE TABLE `permision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `shared` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file_id` (`file_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `permision_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`),
  CONSTRAINT `permision_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

/*Data for the table `permision` */

insert  into `permision`(`id`,`p_id`,`user_id`,`file_id`,`code`,`shared`,`created_at`) values (115,1,6,43,'AszHzzolDF6E',1,'2020-12-11 15:02:47'),(116,1,4,43,'AszHzzolDF6E',1,'2020-12-11 15:03:12'),(120,1,4,42,'DYac53_jERMy',1,'2020-12-11 19:21:24'),(121,1,4,42,'M-so2ao8GekK',2,'2020-12-12 11:32:09');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`fullname`,`email`,`password`,`image`,`is_active`,`is_admin`,`created_at`) values (3,'Mauricio German Alvarado','al221410963@gmail.com','464732fde4c3a6ee437487d4e905499a575abe03','default.png',1,0,'2020-12-01 17:35:03'),(4,'Diego Alberto Alvarez','mauricioger132@hotmail.com','464732fde4c3a6ee437487d4e905499a575abe03','default.png',1,0,'2020-12-01 17:36:25'),(6,'Denis valquir','deniselunico2016@gmail.com','464732fde4c3a6ee437487d4e905499a575abe03','default.png',1,0,'2020-12-10 20:54:18');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
