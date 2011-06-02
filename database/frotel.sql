-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: frotel1
-- ------------------------------------------------------
-- Server version	5.1.49-1ubuntu8.1

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
-- Table structure for table `ge_rules`
--

DROP TABLE IF EXISTS `ge_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_rules`
--

LOCK TABLES `ge_rules` WRITE;
/*!40000 ALTER TABLE `ge_rules` DISABLE KEYS */;
INSERT INTO `ge_rules` VALUES (1,'blogger');
/*!40000 ALTER TABLE `ge_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ge_rules_tasks`
--

DROP TABLE IF EXISTS `ge_rules_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_rules_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rule_id` (`rule_id`,`task_id`),
  KEY `fk_ge_rules_tasks_ge_tasks1` (`task_id`),
  KEY `fk_ge_rules_tasks_ge_rules1` (`rule_id`),
  CONSTRAINT `fk_ge_rules_tasks_ge_rules1` FOREIGN KEY (`rule_id`) REFERENCES `ge_rules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ge_rules_tasks_ge_tasks1` FOREIGN KEY (`task_id`) REFERENCES `ge_tasks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_rules_tasks`
--

LOCK TABLES `ge_rules_tasks` WRITE;
/*!40000 ALTER TABLE `ge_rules_tasks` DISABLE KEYS */;
INSERT INTO `ge_rules_tasks` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6);
/*!40000 ALTER TABLE `ge_rules_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ge_sites`
--

DROP TABLE IF EXISTS `ge_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_ge_sites_ge_templates1` (`template_id`),
  CONSTRAINT `ge_sites_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `ge_templates` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_sites`
--

LOCK TABLES `ge_sites` WRITE;
/*!40000 ALTER TABLE `ge_sites` DISABLE KEYS */;
INSERT INTO `ge_sites` VALUES (1,1,1),(2,1,1);
/*!40000 ALTER TABLE `ge_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ge_subdomains`
--

DROP TABLE IF EXISTS `ge_subdomains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_subdomains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `active` int(1) DEFAULT '0',
  `sub_domain` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_id_UNIQUE` (`site_id`),
  KEY `fk_ge_subdomains_ge_sites1` (`site_id`),
  CONSTRAINT `ge_subdomains_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `ge_sites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_subdomains`
--

LOCK TABLES `ge_subdomains` WRITE;
/*!40000 ALTER TABLE `ge_subdomains` DISABLE KEYS */;
INSERT INTO `ge_subdomains` VALUES (1,1,1,'m'),(2,2,1,'amin');
/*!40000 ALTER TABLE `ge_subdomains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ge_tasks`
--

DROP TABLE IF EXISTS `ge_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_tasks`
--

LOCK TABLES `ge_tasks` WRITE;
/*!40000 ALTER TABLE `ge_tasks` DISABLE KEYS */;
INSERT INTO `ge_tasks` VALUES (1,'template'),(2,'post'),(3,'link'),(4,'setting'),(5,'edituser'),(6,'tag');
/*!40000 ALTER TABLE `ge_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ge_templates`
--

DROP TABLE IF EXISTS `ge_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main` text COLLATE utf8_persian_ci NOT NULL,
  `post` text COLLATE utf8_persian_ci NOT NULL,
  `comment` text COLLATE utf8_persian_ci NOT NULL,
  `shop` text COLLATE utf8_persian_ci NOT NULL,
  `item` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_templates`
--

LOCK TABLES `ge_templates` WRITE;
/*!40000 ALTER TABLE `ge_templates` DISABLE KEYS */;
INSERT INTO `ge_templates` VALUES (1,'','','','','');
/*!40000 ALTER TABLE `ge_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ge_users`
--

DROP TABLE IF EXISTS `ge_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_users`
--

LOCK TABLES `ge_users` WRITE;
/*!40000 ALTER TABLE `ge_users` DISABLE KEYS */;
INSERT INTO `ge_users` VALUES (1,'admin','admin','admin','admin@admin.admin','2010-06-28 16:07:25'),(2,'blogger','19ba2dd6c65780fa1fb20f8f32b92aa3','bloggerist','blog@admin.com','2010-11-28 14:24:06'),(5,'mostafa','19ba2dd6c65780fa1fb20f8f32b92aa3','مطفی جلمبادانی','arash.j13@gmail.com','2010-12-09 13:39:35'),(6,'amin','202cb962ac59075b964b07152d234b70','Amin','tigmin@gmail.com','2010-12-17 14:38:15');
/*!40000 ALTER TABLE `ge_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ge_users_rules`
--

DROP TABLE IF EXISTS `ge_users_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_users_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL,
  `param` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `fk_ge_users_rules_ge_users1` (`user_id`),
  KEY `fk_ge_users_rules_ge_rules1` (`rule_id`),
  CONSTRAINT `fk_ge_users_rules_ge_rules1` FOREIGN KEY (`rule_id`) REFERENCES `ge_rules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ge_users_rules_ge_users1` FOREIGN KEY (`user_id`) REFERENCES `ge_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_users_rules`
--

LOCK TABLES `ge_users_rules` WRITE;
/*!40000 ALTER TABLE `ge_users_rules` DISABLE KEYS */;
INSERT INTO `ge_users_rules` VALUES (1,2,1,0),(2,6,1,2);
/*!40000 ALTER TABLE `ge_users_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ge_users_sites`
--

DROP TABLE IF EXISTS `ge_users_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ge_users_sites` (
  `site_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('admin','writer') COLLATE utf8_persian_ci NOT NULL,
  KEY `fk_ge_users_sites_ge_users1` (`user_id`),
  KEY `fk_ge_users_sites_ge_sites1` (`site_id`),
  CONSTRAINT `ge_users_sites_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `ge_sites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ge_users_sites_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ge_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ge_users_sites`
--

LOCK TABLES `ge_users_sites` WRITE;
/*!40000 ALTER TABLE `ge_users_sites` DISABLE KEYS */;
INSERT INTO `ge_users_sites` VALUES (1,2,'admin'),(2,6,'admin');
/*!40000 ALTER TABLE `ge_users_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sh_groups`
--

DROP TABLE IF EXISTS `sh_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sh_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8_persian_ci NOT NULL,
  `site_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sh_groups_ge_sites1` (`site_id`),
  CONSTRAINT `fk_sh_groups_ge_sites1` FOREIGN KEY (`site_id`) REFERENCES `ge_sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sh_groups`
--

LOCK TABLES `sh_groups` WRITE;
/*!40000 ALTER TABLE `sh_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `sh_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sh_images`
--

DROP TABLE IF EXISTS `sh_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sh_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text COLLATE utf8_persian_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sh_images_sh_items1` (`item_id`),
  CONSTRAINT `fk_sh_images_sh_items1` FOREIGN KEY (`item_id`) REFERENCES `sh_items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sh_images`
--

LOCK TABLES `sh_images` WRITE;
/*!40000 ALTER TABLE `sh_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `sh_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sh_items`
--

DROP TABLE IF EXISTS `sh_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sh_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` tinytext COLLATE utf8_persian_ci NOT NULL,
  `full_description` text COLLATE utf8_persian_ci NOT NULL,
  `price` int(11) NOT NULL,
  `off_price` double(10,2) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sh_items`
--

LOCK TABLES `sh_items` WRITE;
/*!40000 ALTER TABLE `sh_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `sh_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sh_items_requests`
--

DROP TABLE IF EXISTS `sh_items_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sh_items_requests` (
  `items_id` int(11) NOT NULL,
  `requests_id` int(11) NOT NULL,
  PRIMARY KEY (`items_id`,`requests_id`),
  KEY `fk_sh_items_has_sh_requests_sh_requests1` (`requests_id`),
  KEY `fk_sh_items_has_sh_requests_sh_items1` (`items_id`),
  CONSTRAINT `fk_sh_items_has_sh_requests_sh_items1` FOREIGN KEY (`items_id`) REFERENCES `sh_items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sh_items_has_sh_requests_sh_requests1` FOREIGN KEY (`requests_id`) REFERENCES `sh_requests` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sh_items_requests`
--

LOCK TABLES `sh_items_requests` WRITE;
/*!40000 ALTER TABLE `sh_items_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `sh_items_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sh_requests`
--

DROP TABLE IF EXISTS `sh_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sh_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) COLLATE utf8_persian_ci NOT NULL,
  `status` enum('pending','sent','cancel','return') COLLATE utf8_persian_ci NOT NULL,
  `payment_type` enum('cash','post') COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(45) COLLATE utf8_persian_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `city` varchar(45) COLLATE utf8_persian_ci NOT NULL,
  `address` text COLLATE utf8_persian_ci NOT NULL,
  `register_date` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sh_requests`
--

LOCK TABLES `sh_requests` WRITE;
/*!40000 ALTER TABLE `sh_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `sh_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sh_subgroups`
--

DROP TABLE IF EXISTS `sh_subgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sh_subgroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8_persian_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sh_subgroups_sh_groups1` (`group_id`),
  CONSTRAINT `fk_sh_subgroups_sh_groups1` FOREIGN KEY (`group_id`) REFERENCES `sh_groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sh_subgroups`
--

LOCK TABLES `sh_subgroups` WRITE;
/*!40000 ALTER TABLE `sh_subgroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `sh_subgroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sh_subgroups_items`
--

DROP TABLE IF EXISTS `sh_subgroups_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sh_subgroups_items` (
  `subgroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`subgroup_id`,`item_id`),
  KEY `fk_sh_subgroups_has_sh_items_sh_items1` (`item_id`),
  KEY `fk_sh_subgroups_has_sh_items_sh_subgroups1` (`subgroup_id`),
  CONSTRAINT `fk_sh_subgroups_has_sh_items_sh_items1` FOREIGN KEY (`item_id`) REFERENCES `sh_items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sh_subgroups_has_sh_items_sh_subgroups1` FOREIGN KEY (`subgroup_id`) REFERENCES `sh_subgroups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sh_subgroups_items`
--

LOCK TABLES `sh_subgroups_items` WRITE;
/*!40000 ALTER TABLE `sh_subgroups_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `sh_subgroups_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_articles`
--

DROP TABLE IF EXISTS `wb_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weblog_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `content` text COLLATE utf8_persian_ci NOT NULL,
  `more_content` text COLLATE utf8_persian_ci,
  `date` datetime NOT NULL,
  `status` enum('draft','published') COLLATE utf8_persian_ci NOT NULL DEFAULT 'published',
  `password` varchar(32) COLLATE utf8_persian_ci DEFAULT NULL,
  `comment_approve` int(1) NOT NULL DEFAULT '0',
  `comment_exp` datetime DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `visite_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_wb_articles_ge_users1` (`user_id`),
  KEY `fk_wb_articles_wb_weblogs1` (`weblog_id`),
  KEY `fk_wb_articles_wb_subject1` (`subject_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `wb_articles_ibfk_1` FOREIGN KEY (`weblog_id`) REFERENCES `wb_weblogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wb_articles_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `wb_subjects` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `wb_articles_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `ge_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wb_articles_ibfk_4` FOREIGN KEY (`tag_id`) REFERENCES `wb_tags` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_articles`
--

LOCK TABLES `wb_articles` WRITE;
/*!40000 ALTER TABLE `wb_articles` DISABLE KEYS */;
INSERT INTO `wb_articles` VALUES (1,1,1,1,1,'عشق تخیلی ','عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی ','عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی عشق تخیلی ','2010-06-28 17:13:39','published',NULL,0,NULL,'love',0),(3,1,2,1,2,'جفنگیات جدید','<table class=\"contentpaneopen\">\r\n<tbody>\r\n<tr>\r\n<td class=\"contentheading\" width=\"100%\">معرفی شرکت</td>\r\n<td class=\"buttonheading\" width=\"100%\" align=\"right\"><a title=\"مشاهده در قالب پی دی اف\" rel=\"nofollow\" href=\"http://localhost/rajman/index.php?view=article&amp;id=1:about&amp;format=pdf\"><img src=\"http://localhost/rajman/images/M_images/pdf_button.png\" alt=\"مشاهده در قالب پی دی اف\" /></a></td>\r\n<td class=\"buttonheading\" width=\"100%\" align=\"right\"><a title=\"چاپ\" rel=\"nofollow\" href=\"http://localhost/rajman/index.php?view=article&amp;id=1:about&amp;tmpl=component&amp;print=1&amp;layout=default&amp;page=\"><img src=\"http://localhost/rajman/images/M_images/printButton.png\" alt=\"چاپ\" /></a></td>\r\n<td class=\"buttonheading\" width=\"100%\" align=\"right\"><a title=\"فرستادن به ایمیل\" href=\"http://localhost/rajman/index.php/component/mailto/?tmpl=component&amp;link=aHR0cDovL2xvY2FsaG9zdC9yYWptYW4vaW5kZXgucGhwL2NvbXBvbmVudC9jb250ZW50L2FydGljbGUvMS1hYm91dA%3D%3D\"><img src=\"http://localhost/rajman/images/M_images/emailButton.png\" alt=\"فرستادن به ایمیل\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p style=\"padding: 7px;\"><img style=\"padding: 5px; background: none repeat scroll 0% 0% #f9f9f9; margin: 0pt 10px 0pt 0pt;\" src=\"http://localhost/rajman/images/stories/watercover.png\" border=\"0\" alt=\"\" width=\"150\" align=\"left\" />به  استناد مفاد قانون تشکیل شرکتهای آب و فاضلاب مصوب دی ماه 1369 مجلس شورای  اسلامی شرکت آب وفاضلاب استان خراسان رضوی در تاریخ&nbsp; 17 اسفندماه 1371 با  هدف ایجاد و بهره برداری از تاسیسات تامین و توزیع آب شرب و بهداشتی و  ایجاد و بهره برداری از تاسیسات مرتبط با جمع آوری انتقال ، تصفیه و دفع  بهداشتی فاضلاب در حوزه عمل شرکت (کل شهرهای استان خراسان رضوی بجز شهر  مشهد) تشکیل شد. شرکت آب و فاضلاب استان خراسان رضوی از همان ابتدا با توجه  به مقوله بهبود مدیریت و ارتقاء سیستم های مدیریتی و نیز توجه به سرمایه  منابع انسانی و اکنون در مسیر بهبود مستمر علی رغم مواجه شدن با چالشهای  جدی در زمینه های اقتصادی، وسعت حوزه خدماتی و تغییر تشکیلات یکی از  دستگاههای موفق در زمینه ارائه خدمات به مردم شریـف استـان خراسـان رضـوی  می باشد.</p>\r\n<p style=\"padding: 7px;\">این شرکت 69 شهر استان به جز شهر مشهد&nbsp;را با  جمعیتی در حدود 1598700 نفر تحت پوشش داشته و تأمین آب شرب مورد نیاز بالغ  بر 447342 مشترک آب را از طریق 372 حلقه چاه، چشمه و قنات با 1252 کیلومتر  خط انتقال و 4374 کیلومتر شبکه تأمین و توزیع برعهده دارد. همچنین وظیفه  جمع&zwnj;آوری فاضلاب 66270 انشعاب فاضلاب با استفاده از 761 کیلومتر طول شبکه  جمع&zwnj;آوری فاضلاب و 34 کیلومتر طول شبکه انتقال فاضلاب به همراه 4  تصفیه&zwnj;خانه بر عهده این شرکت می&zwnj;باشد.</p>','','2010-11-28 09:30:00','published','123',0,'2010-11-28 09:33:01','',0),(4,1,3,1,2,'تست پرداخت دار','<p><span style=\"font-weight: bold; color: #0000cd;\">سرویس بین الملل &laquo;تابناک&raquo; ـ</span> در هفته ای که گذشت نشست منامه، خود کفایی ایران در تولید کیک زرد،  مذاکرات ژنو 3، دستگیری دو آلمانی، آلودگی هوا و... از جمله سوژه هایی بود  که از سوی رسانه های خارجی در مورد ایران مورد توجه قرار گرفت. &nbsp; <br /><br /><span style=\"font-weight: bold; color: #ff0000;\">ـــ</span> روز شنبه 13 آذر ماه (4 دسامبر) مجله فارین پالیسی در گزارشی نوشت:  اظهارات کلینتون و متکی در هفتمین اجلاس گفتگوی منامه در&lrm; &lrm;بحرین زیر ذربین  جهانیان قرار داشت که در این میان سخنان وزیر خارجه آمریکا مورد استقبال  نمایندگان کشورهای عرب حاشیه خلیج فارس قرار گرفت. به تصور آن ها او حامل  یک پیام شفاف و در عین حال صمیمانه بود که ضمن خودداری از انتقادات همیشگی  آمریکا از ایران به حق ایران در دستیابی به انرژی هسته ای اشاره کرد.<br /><br /></p>\r\n<div style=\"text-align: center;\"><img style=\"border: medium none; margin: 5px;\" src=\"http://www.tabnak.ir/files/fa/news/1389/9/18/77091_383.jpg\" alt=\"\" /></div>\r\n<p><br /><span style=\"font-weight: bold; color: #ff0000;\">ـــ </span>روز  یکشنبه 14 آذر ماه (5 دسامبر) شینهووا، خبرگزاری رسمی چین، خبر دستیابی  ایران به توان تولید کیک زرد را از سوی علی اکبر صالحی، رییس سازمان انرژی  اتمی کشورمان، انعکاس داد.<br /><br /></p>\r\n<div style=\"text-align: center;\"><img style=\"border: medium none; margin: 5px;\" src=\"http://www.tabnak.ir/files/fa/news/1389/9/18/77090_322.jpg\" alt=\"\" /></div>\r\n<p><br /><span style=\"font-weight: bold; color: #ff0000;\">ـــ </span>خبرگزاری  فرانسه با اختصاص مطلبی به دو روزنامه نگار آلمانی که در ایران در بازداشت  به سر می برند به نقل از اسفندیار رحیم مشایی نوشت: ما هیچگاه اعلام نکرده  ایم که آن ها متهم به جاسوسی هستند، بلکه آنها با نقض قانون و با در دست  داشتن ویزای توریستی اقدام به تهیه خبر کرده اند.</p>','','2010-12-10 06:36:00','published','741',0,NULL,'',0);
/*!40000 ALTER TABLE `wb_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_comment`
--

DROP TABLE IF EXISTS `wb_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `content` text COLLATE utf8_persian_ci NOT NULL,
  `private` bit(1) DEFAULT b'0',
  `status` varchar(45) COLLATE utf8_persian_ci DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `IP` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wb_comment_wb_articles1` (`article_id`),
  CONSTRAINT `fk_wb_comment_wb_articles1` FOREIGN KEY (`article_id`) REFERENCES `wb_articles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_comment`
--

LOCK TABLES `wb_comment` WRITE;
/*!40000 ALTER TABLE `wb_comment` DISABLE KEYS */;
INSERT INTO `wb_comment` VALUES (1,1,'amin','tigmin@gmail.com','www.google.com','asdsadasdasdsad','\0','approve','2010-08-16 14:56:17','127.0.0.1');
/*!40000 ALTER TABLE `wb_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_friends`
--

DROP TABLE IF EXISTS `wb_friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_friends` (
  `id` int(11) NOT NULL,
  `weblog_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wb_friends_wb_weblogs1` (`weblog_id`),
  KEY `fk_wb_friends_wb_weblogs2` (`friend_id`),
  CONSTRAINT `fk_wb_friends_wb_weblogs1` FOREIGN KEY (`weblog_id`) REFERENCES `wb_weblogs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_wb_friends_wb_weblogs2` FOREIGN KEY (`friend_id`) REFERENCES `wb_weblogs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_friends`
--

LOCK TABLES `wb_friends` WRITE;
/*!40000 ALTER TABLE `wb_friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_links`
--

DROP TABLE IF EXISTS `wb_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weblog_id` int(11) NOT NULL,
  `active` int(1) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `type` enum('daily','static') COLLATE utf8_persian_ci NOT NULL DEFAULT 'static',
  PRIMARY KEY (`id`),
  KEY `fk_wb_links_wb_weblogs1` (`weblog_id`),
  CONSTRAINT `fk_wb_links_wb_weblogs1` FOREIGN KEY (`weblog_id`) REFERENCES `wb_weblogs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_links`
--

LOCK TABLES `wb_links` WRITE;
/*!40000 ALTER TABLE `wb_links` DISABLE KEYS */;
INSERT INTO `wb_links` VALUES (4,1,0,'adasdasdsad','http://asdasdasdasd','daily'),(5,1,0,'adasdasdsad','asdasdasdasdasdsadasdasdas','daily'),(6,1,0,'amin','http://amin.co','static');
/*!40000 ALTER TABLE `wb_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_subject`
--

DROP TABLE IF EXISTS `wb_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_subject` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_subject`
--

LOCK TABLES `wb_subject` WRITE;
/*!40000 ALTER TABLE `wb_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_subjects`
--

DROP TABLE IF EXISTS `wb_subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_subjects`
--

LOCK TABLES `wb_subjects` WRITE;
/*!40000 ALTER TABLE `wb_subjects` DISABLE KEYS */;
INSERT INTO `wb_subjects` VALUES (1,'تخیلی'),(2,'ترسناک'),(3,'اجتماعی');
/*!40000 ALTER TABLE `wb_subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_tags`
--

DROP TABLE IF EXISTS `wb_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weblog_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wb_tags_wb_weblogs1` (`weblog_id`),
  CONSTRAINT `fk_wb_tags_wb_weblogs1` FOREIGN KEY (`weblog_id`) REFERENCES `wb_weblogs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_tags`
--

LOCK TABLES `wb_tags` WRITE;
/*!40000 ALTER TABLE `wb_tags` DISABLE KEYS */;
INSERT INTO `wb_tags` VALUES (1,1,'تخیلی');
/*!40000 ALTER TABLE `wb_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_tags_articles`
--

DROP TABLE IF EXISTS `wb_tags_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_tags_articles` (
  `tag_ID` int(11) NOT NULL,
  `article_ID` int(11) NOT NULL,
  KEY `fk_wb_tags_articles_wb_tags1` (`tag_ID`),
  KEY `fk_wb_tags_articles_wb_articles1` (`article_ID`),
  CONSTRAINT `fk_wb_tags_articles_wb_articles1` FOREIGN KEY (`article_ID`) REFERENCES `wb_articles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_wb_tags_articles_wb_tags1` FOREIGN KEY (`tag_ID`) REFERENCES `wb_tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_tags_articles`
--

LOCK TABLES `wb_tags_articles` WRITE;
/*!40000 ALTER TABLE `wb_tags_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb_tags_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb_weblogs`
--

DROP TABLE IF EXISTS `wb_weblogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb_weblogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `active` int(1) DEFAULT '1',
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `desc` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `about` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `custom_html` text COLLATE utf8_persian_ci,
  `post_in_page` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wb_weblogs_ge_sites1` (`site_id`),
  KEY `fk_wb_weblogs_ge_sites2` (`site_id`),
  KEY `fk_wb_weblogs_wb_subject1` (`subject_id`),
  CONSTRAINT `wb_weblogs_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `wb_subjects` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `wb_weblogs_ibfk_3` FOREIGN KEY (`site_id`) REFERENCES `ge_sites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb_weblogs`
--

LOCK TABLES `wb_weblogs` WRITE;
/*!40000 ALTER TABLE `wb_weblogs` DISABLE KEYS */;
INSERT INTO `wb_weblogs` VALUES (1,1,2,0,'عشق تخیلی','info@mostafa.com','درباره عشق های تخیلی','0000-00-00 00:00:00','یه آدم تخیلی','تخیل عشقی','<strong>:D:DD:D</strong>',104),(2,2,1,1,'amin','tigmin@gmail.com','Weblog chizi','0000-00-00 00:00:00',NULL,NULL,NULL,10);
/*!40000 ALTER TABLE `wb_weblogs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-03-26  9:05:14
