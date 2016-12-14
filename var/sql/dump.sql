-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: silex
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1-log

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `upic` varchar(50) DEFAULT NULL,
  `last_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `acl_role_id` smallint(5) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('social','phone','location','email','messenger') COLLATE utf8_unicode_ci NOT NULL,
  `subtype` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_primary` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,'social','facebook','https://www.facebook.com/ostc.com.ua',1),(2,'social','vk','http://vk.com/ostc_od',1),(3,'phone','mobile','095 022 9119',1),(4,'email','','ostc.pr@gmail.com',1),(5,'location','address','ул. Малая Арнаутская, 105 (код 83)',1),(6,'location','coordinates','46.4713402,30.7341595',1),(7,'messenger','skype','mathilda_lando',1);
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `upic` varchar(100) DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  `link_media` varchar(150) DEFAULT NULL,
  `sort_order` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `training_id` int(10) unsigned NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `location` varchar(255) NOT NULL,
  `coordinates` point NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,1,'2015-11-21 11:00:00','2015-11-21 14:00:00',1,'','','IMG_9061.JPG'),(2,2,'2015-11-28 11:00:00','2015-11-28 14:00:00',1,'','','IMG_9061.JPG'),(3,3,'2015-11-29 15:00:00','2015-11-28 22:00:00',1,'','','IMG_9061.JPG'),(4,3,'2015-12-03 15:00:00','2015-12-03 22:00:00',1,'','','IMG_9061.JPG'),(5,1,'2015-11-29 11:00:00','2015-11-21 15:00:00',1,'','','IMG_9061.JPG'),(6,1,'2015-11-30 11:00:00','2015-11-30 15:00:00',1,'','','IMG_9061.JPG'),(7,2,'2015-11-30 11:00:00','2015-11-30 15:00:00',1,'','','IMG_9061.JPG'),(8,2,'2015-11-30 11:00:00','2015-11-30 15:00:00',1,'','','IMG_9061.JPG');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_instructor`
--

DROP TABLE IF EXISTS `event_instructor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_instructor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `instructor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_instructor`
--

LOCK TABLES `event_instructor` WRITE;
/*!40000 ALTER TABLE `event_instructor` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_instructor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_media`
--

DROP TABLE IF EXISTS `event_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `media_type` enum('image','video') DEFAULT 'image',
  `filename` varchar(100) NOT NULL,
  `views` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_media`
--

LOCK TABLES `event_media` WRITE;
/*!40000 ALTER TABLE `event_media` DISABLE KEYS */;
INSERT INTO `event_media` VALUES (1,1,NULL,'image','1.jpg',0),(2,1,NULL,'image','2.jpg',0),(3,1,NULL,'image','3.jpg',0),(4,1,NULL,'image','4.jpg',0),(5,1,NULL,'image','5.jpg',0),(6,1,NULL,'image','6.jpg',0),(7,1,NULL,'image','7.jpg',0),(8,1,NULL,'image','8.jpg',0),(9,2,NULL,'image','1.jpg',0),(10,2,NULL,'image','2.jpg',0),(11,2,NULL,'image','3.jpg',0),(12,2,NULL,'image','4.jpg',0),(13,2,NULL,'image','5.jpg',0),(14,2,NULL,'image','6.jpg',0),(15,2,NULL,'image','7.jpg',0),(16,2,NULL,'image','8.jpg',0),(17,3,NULL,'image','1.jpg',0),(18,3,NULL,'image','2.jpg',0),(19,3,NULL,'image','3.jpg',0),(20,3,NULL,'image','4.jpg',0),(21,3,NULL,'image','5.jpg',0),(22,3,NULL,'image','6.jpg',0),(23,3,NULL,'image','7.jpg',0),(24,3,NULL,'image','8.jpg',0),(25,4,NULL,'image','1.jpg',0),(26,4,NULL,'image','2.jpg',0),(27,4,NULL,'image','3.jpg',0),(28,4,NULL,'image','4.jpg',0),(29,4,NULL,'image','5.jpg',0),(30,4,NULL,'image','6.jpg',0),(31,4,NULL,'image','7.jpg',0),(33,5,NULL,'image','1.jpg',0),(34,5,NULL,'image','2.jpg',0),(35,5,NULL,'image','3.jpg',0),(36,5,NULL,'image','4.jpg',0),(37,5,NULL,'image','5.jpg',0),(38,5,NULL,'image','6.jpg',0),(39,5,NULL,'image','7.jpg',0),(40,5,NULL,'image','8.jpg',0),(41,6,NULL,'image','1.jpg',0),(42,6,NULL,'image','2.jpg',0),(43,6,NULL,'image','3.jpg',0),(44,6,NULL,'image','4.jpg',0),(45,7,NULL,'image','1.jpg',0),(46,7,NULL,'image','2.jpg',0),(47,7,NULL,'image','3.jpg',0),(48,7,NULL,'image','4.jpg',0),(49,8,NULL,'image','1.jpg',0),(50,8,NULL,'image','2.jpg',0),(51,8,NULL,'image','3.jpg',0),(52,8,NULL,'image','4.jpg',0);
/*!40000 ALTER TABLE `event_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructor`
--

DROP TABLE IF EXISTS `instructor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `upic` varchar(150) DEFAULT NULL,
  `fb_link` varchar(150) DEFAULT NULL,
  `vk_link` varchar(150) DEFAULT NULL,
  `insta_link` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `skype` varchar(100) DEFAULT NULL,
  `age` smallint(5) unsigned DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructor`
--

LOCK TABLES `instructor` WRITE;
/*!40000 ALTER TABLE `instructor` DISABLE KEYS */;
/*!40000 ALTER TABLE `instructor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructor_certificate`
--

DROP TABLE IF EXISTS `instructor_certificate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructor_certificate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `vendor` varchar(255) DEFAULT NULL,
  `vendor_link` varchar(255) DEFAULT NULL,
  `vendor_date` datetime DEFAULT NULL,
  `vendor_report_link` varchar(255) DEFAULT NULL,
  `upic` varchar(150) DEFAULT NULL,
  `sort_order` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructor_certificate`
--

LOCK TABLES `instructor_certificate` WRITE;
/*!40000 ALTER TABLE `instructor_certificate` DISABLE KEYS */;
/*!40000 ALTER TABLE `instructor_certificate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructor_training`
--

DROP TABLE IF EXISTS `instructor_training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructor_training` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `instructor_id` int(10) unsigned NOT NULL,
  `training_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructor_training`
--

LOCK TABLES `instructor_training` WRITE;
/*!40000 ALTER TABLE `instructor_training` DISABLE KEYS */;
/*!40000 ALTER TABLE `instructor_training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci,
  `date_posted` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `type` enum('trivial','important') COLLATE utf8_unicode_ci DEFAULT 'trivial',
  `logo` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `readmore_link` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Расписание ближайших тренингов!','Интервью с нашим курсантом Семёном. У его двухлетней малышки была остановка дыхания на фоне судорог и высокой температуры и папа, не растерявшись, смог выполнить сердечно-легочную реанимацию и вернуть ребенка к жизни','В связи с тем, что в новостях появилось сообщение об укусе ребенка бешеным животным в Одесской области, мы хотим напомнить вам о правилах поведения при укусах любыми животными.\nВирус бешенства вызывает специфический энцефалит и передаётся со слюной при укусе больным животным. &lt;br&gt;\nДо 2005 года бешенство считалось абсолютно смертельным для человека если проявились симптомы болезни. С другой стороны, заболевание эффективно предотвращается вакцинацией, если её провести сразу после предполагаемого заражения.&lt;br&gt;&lt;br&gt;\n1. Не допускайте контакта с посторонними животными!&lt;br&gt;\n2. Если у животного наблюдаются нарастающее беспокойство, склонность к поеданию инородных предметов, агрессивность, водобоязнь, обильное слюноотделение, походка становится шаткой, то стоит очень сильно насторожиться.&lt;br&gt;\nЕсли животное вас укусило :&lt;br&gt;\nСледует очень быстро промыть рану мыльным раствором под давлением (с помощью шприца или пластиковой бутылки). Процедуру надо проводить в течении 10 минут.&lt;br&gt; \n&lt;b&gt;Немедленно обратитесь за медицинской помощью! &lt;b/&gt;&lt;br&gt;\nНе откладывайте это до возвращения домой, особенно если вы на отдыхе!&lt;br&gt;\n','2015-11-01 15:12:10',0,'trivial','',''),(2,'','В связи с тем, что в новостях появилось сообщение об укусе ребенка бешеным животным в Одесской области, мы хотим напомнить вам о правилах поведения при укусах любыми животными.','В связи с тем, что в новостях появилось сообщение об укусе ребенка бешеным животным в Одесской области, мы хотим напомнить вам о правилах поведения при укусах любыми животными.\nВирус бешенства вызывает специфический энцефалит и передаётся со слюной при укусе больным животным. <br />\nДо 2005 года бешенство считалось абсолютно смертельным для человека если проявились симптомы болезни. С другой стороны, заболевание эффективно предотвращается вакцинацией, если её провести сразу после предполагаемого заражения.<br />\n1. Не допускайте контакта с посторонними животными!<br />\n2. Если у животного наблюдаются нарастающее беспокойство, склонность к поеданию инородных предметов, агрессивность, водобоязнь, обильное слюноотделение, походка становится шаткой, то стоит очень сильно насторожиться.<br />\nЕсли животное вас укусило:<br />\nСледует очень быстро промыть рану мыльным раствором под давлением (с помощью шприца или пластиковой бутылки). Процедуру надо проводить в течении 10 минут.<br /> \n<br />\n<b>Немедленно обратитесь за медицинской помощью! </b><br />\n<br />\nНе откладывайте это до возвращения домой, особенно если вы на отдыхе!<br />\n','2015-11-19 17:00:00',1,'trivial','bakterii.jpg','http://silex.loc/');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slider`
--

DROP TABLE IF EXISTS `slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `welcome_text` varchar(255) DEFAULT NULL,
  `center_text` varchar(255) DEFAULT NULL,
  `bottom_text` varchar(255) DEFAULT NULL,
  `alter_text` varchar(255) DEFAULT NULL,
  `sort_order` smallint(5) unsigned DEFAULT '0',
  `link` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slider`
--

LOCK TABLES `slider` WRITE;
/*!40000 ALTER TABLE `slider` DISABLE KEYS */;
INSERT INTO `slider` VALUES (5,'IMG_9244.JPG','Welcome to OCST','Odessa Center of Special Preparation','We can teach and help!','alter text 5',5,''),(6,'IMG_9135.JPG','Welcome to OCST','Odessa Center of Special Preparation','We can teach and help!','alter text 6',6,''),(7,'IMG_9146.JPG','Welcome to OCST','Odessa Center of Special Preparation','We can teach and help!','alter text 7',7,''),(8,'milaha_4.jpg','Welcome to OCST','Odessa Center of Special Preparation','We can teach and help!','alter text 8',8,'');
/*!40000 ALTER TABLE `slider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training`
--

DROP TABLE IF EXISTS `training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `training` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `intro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `status` tinyint(1) DEFAULT '1',
  `regularity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag_new` tinyint(1) DEFAULT '0',
  `sort_order` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_name` (`url_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training`
--

LOCK TABLES `training` WRITE;
/*!40000 ALTER TABLE `training` DISABLE KEYS */;
INSERT INTO `training` VALUES (1,'Первая помощь детям при травме','bls','Что делать, если ребенок упал с лестницы? Как зафиксировать перелом? Какой повязкой остановить кровотечение? Что делать, если малыш обжегся?','В смерти нет ничего забавного, даже если она произошла при самых глупых обстоятельствах. Впрочем, никто и не смеется – чаще всего эти ситуации настолько невероятны, что пропадает дар речи и остается только один вопрос: чем думали эти люди? Хотя пара пунктов этого списка рассказывают о действительно трагических случайностях, большинство героев просто поплатились за свою глупость. Встречайте номинантов на премию Дарвина 2015.<br><br><br>\n<b>10. Девушка заморозила себя в криокамере насмерть</b><br>\nКриотерапию, то есть лечение холодом, используют для восстановления поврежденных тканей, а многие женщины прибегают к ней, чтобы предотвратить старение кожи. Благодаря жидкому азоту, температура в криокамере за считанные минуты достигает сверхнизких показателей (от -130 до −150°С), так что, казалось бы, можно догадаться, что просто так соваться туда не стоит. 24-летняя Челси Эйк, очевидно, не догадалась – замороженное тело сотрудницы салона красоты нашли в камере, в которой она провела больше десяти часов. Никто не знает, как она там очутилась, но вскрытие показало, что девушка умерла буквально за секунды.<br><br>\n<b>9. Мужчина погиб, катаясь на магазинной тележке</b><br>\nБудем честными – мы все это делали, и это было весело. Но вряд ли кому-то из нас приходило в голову скатиться на тележке вниз с холма со скоростью 80 км/ч, а именно это и привело к смерти мужчины в Австралии. Он нашел брошенную на стороне дороги магазинную тележку, когда возвращался домой вместе с другом. Один из них запрыгнул в тележку, второй уцепился за нее сзади, и они покатились вниз с холма. Друзья успели развить скорость до 80 км/ч, когда врезались в машину. Один из них умер на месте, второго доставили в больницу с серьезными травмами.<br>',1,NULL,0,1),(2,'Юридические основы оборота оружия в Украине. Необходимая оборона','gun','Почему обычный складной нож в вашем кармане может быть холодным оружием? В каком случае за стартовый пистолет можно \"получить срок\", как за огнестрельный? Что делать, если домой пришел участковый с предписанием на проверку оружия?','',1,NULL,0,1),(3,'Первая помощь в спорте','sport','Что делать, если человек потерял сознание во время занятий спортом? Как оказать помощь при судорожном припадке? Как эффективно провести реанимацию утонувшему человеку?','',1,NULL,0,1),(4,'Первая помощь при травме','trauma','Как транспортировать пострадавшего без риска навредить? Как остановить кровотечение?','',1,NULL,0,1),(5,'Первая помощь при травме 2','trauma2','Как транспортировать пострадавшего без риска навредить? Как остановить кровотечение?','',1,NULL,0,1);
/*!40000 ALTER TABLE `training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training_image`
--

DROP TABLE IF EXISTS `training_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `training_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `training_id` int(10) unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('header_big','header_small') COLLATE utf8_unicode_ci DEFAULT NULL,
  `alter_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training_image`
--

LOCK TABLES `training_image` WRITE;
/*!40000 ALTER TABLE `training_image` DISABLE KEYS */;
INSERT INTO `training_image` VALUES (1,1,'news_img.png','header_small','BLS'),(2,2,'news_img.png','header_small','Gun'),(3,3,'rasskaji_mne.jpg','header_small','Sport'),(4,4,'rasskaji_mne.jpg','header_small','Trauma'),(5,5,'news_img.png','header_small','Trauma'),(6,1,'rasskaji_mne.jpg',NULL,'BLS'),(7,1,'krav_maga_bar.jpg','header_big','BLS');
/*!40000 ALTER TABLE `training_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_logged` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `roles` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w==','2015-12-01 00:13:10','ROLE_ADMIN');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-06  9:35:37
