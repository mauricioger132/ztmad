/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.49-cll-lve : Database - db_usuariostest
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
  `comment` text,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `comment` */

/*Table structure for table `file` */

DROP TABLE IF EXISTS `file`;

CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(12) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `download` int(11) NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_folder` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `folder_id` int(11) DEFAULT NULL,
  `permision_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `folder_id` (`folder_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `file_ibfk_1` FOREIGN KEY (`folder_id`) REFERENCES `file` (`id`),
  CONSTRAINT `file_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `file` */

insert  into `file`(`id`,`code`,`filename`,`description`,`download`,`is_public`,`is_folder`,`user_id`,`folder_id`,`permision_id`,`created_at`) values (1,'t_2ZHP1ieulw','dani','',0,0,1,1,NULL,NULL,'2020-12-01 12:54:31'),(2,'i3CzhB59D6Lf','electro_agressive_mix.jpg','dsadsad',0,0,0,1,1,NULL,'2020-12-01 12:54:41'),(3,'iLRGCgeMUJVR','Musica','',0,0,1,2,NULL,NULL,'2020-12-01 13:22:13');

/*Table structure for table `permision` */

DROP TABLE IF EXISTS `permision`;

CREATE TABLE `permision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file_id` (`file_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `permision_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`),
  CONSTRAINT `permision_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `permision` */

insert  into `permision`(`id`,`p_id`,`user_id`,`file_id`,`created_at`) values (1,1,2,1,'2020-12-01 12:56:45'),(2,1,2,2,'2020-12-01 12:57:25'),(3,1,1,3,'2020-12-01 13:23:48');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`fullname`,`email`,`password`,`image`,`is_active`,`is_admin`,`created_at`) values (1,'denis valqui','deniselunico2016@gmail.com','adcd7048512e64b48da55b027577886ee5a36350','dani.jpg',1,0,'2020-12-01 12:52:58'),(2,'Mauricio German Alvarado','al221410963@gmail.com','bd6e26019e98460603a518155a99028d6539678f','default.png',1,0,'2020-12-01 12:54:03');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
