/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.23-MariaDB, for linux-systemd (x86_64)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	10.6.23-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(191) NOT NULL,
  `url` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
INSERT INTO `banners` VALUES (12,'public/banner-image/2025-07-23-10-29-16.jpeg','google.com','2025-03-22 01:53:28','2025-09-11 00:47:49'),(16,'public/banner-image/2025-09-10-21-04-24.webp','thesina-r.ir','2025-09-11 00:34:25','2025-09-11 00:47:44');
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
INSERT INTO `categories` VALUES (13,'دندان پزشکی','2019-07-13 12:33:12','2025-03-22 01:50:08'),(18,'پزشکی مدرن','2022-03-13 17:28:22','2025-03-22 01:49:55'),(22,'پزشکی سنتی','2025-05-11 12:06:59',NULL),(23,'پوست و مو','2025-05-22 18:13:14',NULL);
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `status` enum('unseen','seen','approved') NOT NULL DEFAULT 'unseen',
  `selected` enum('1','2') NOT NULL DEFAULT '2',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`post_id`),
  KEY `user_id` (`user_id`),
  KEY `fk_doctor_id` (`doctor_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
INSERT INTO `comments` VALUES (42,NULL,NULL,1,'test',35,'approved','1','2025-05-20 18:30:56','2025-06-28 15:28:29'),(46,NULL,NULL,15,'new test from admin',35,'approved','2','2025-05-22 17:37:28','2025-08-12 16:52:05'),(47,NULL,784,NULL,'تست جدید با کاربر ',35,'approved','1','2025-07-30 14:56:03','2025-07-30 15:15:07'),(48,NULL,784,NULL,'تست اول',34,'approved','1','2025-07-30 15:10:08','2025-07-30 15:15:24'),(51,NULL,NULL,1,'this is a test comment',50,'seen','2','2025-07-31 15:00:01','2025-07-31 15:00:02'),(52,42,789,NULL,'test',35,'approved','2','2025-08-12 16:47:48','2025-08-12 16:52:01'),(56,NULL,NULL,1,'321456',35,'seen','2','2025-08-12 16:52:32','2025-09-10 23:57:37'),(58,47,NULL,1,'spdier',35,'seen','2','2025-08-12 16:52:54','2025-09-10 23:57:33'),(64,NULL,NULL,1,'Laborum excepteur fugiat aliquip eu culpa sunt \namet ipsum minim est. Voluptate cillum Lorem labore excepteur aliquip sit occaecat. Cillum mollit culpa culpa ipsum tempor exercitation enim \nirure ullamco amet deserunt nostrud. Minim ut qui est nisi elit veniam aliquip pariatur excepteur aliqua nulla est. Nulla voluptate enim duis officia sit consequat non occaecat occaecat do amet reprehenderit enim in. Exercitation aliqua esse ut non aliquip occaecat.\n Sint adipisicing aliquip amet ex eu laborum enim do eu ex voluptate occaecat.',35,'approved','2','2025-08-12 17:03:23','2025-08-12 17:10:30'),(68,64,NULL,1,'Exercitation aliqua esse ut non aliquip occaecat.\r\nSint adipisicing aliquip amet ex eu laborum enim do eu ex voluptate occaecat.',35,'approved','1','2025-08-12 17:10:47','2025-08-12 17:26:13'),(69,64,789,NULL,'Exercitation aliqua esse ut non aliquip occaecat.\r\nExercitation aliqua esse ut non aliquip occaecat.Exercitation aliqua esse ut non aliquip occaecat.\r\nExercitation aliqua esse ut non aliquip occaecat.sdcvaasdsad',35,'approved','2','2025-08-12 17:41:24',NULL),(71,NULL,NULL,1,'123',35,'approved','2','2025-09-09 17:09:05',NULL),(72,71,NULL,1,'432',35,'approved','2','2025-09-09 17:09:08',NULL),(73,NULL,789,NULL,'2333',34,'seen','2','2025-09-10 23:57:23','2025-09-10 23:57:31');
UNLOCK TABLES;

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_number` varchar(30) NOT NULL DEFAULT '-',
  `name` varchar(155) NOT NULL,
  `number` varchar(100) DEFAULT '',
  `surgery_phone` text DEFAULT NULL,
  `clinic` varchar(254) NOT NULL,
  `profile` varchar(255) NOT NULL DEFAULT 'public/user-image/profile.jpg',
  `location` varchar(200) NOT NULL,
  `coords` text NOT NULL,
  `city` varchar(200) NOT NULL,
  `expert` text DEFAULT NULL,
  `services` text NOT NULL,
  `experience` varchar(4) NOT NULL,
  `like_count` int(11) DEFAULT 0,
  `star_count` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
INSERT INTO `doctors` VALUES (1,'134928','سینا رحیم زاده','9159702153','0511233225','کلینیک آرام تهران','public/user-image/profile2.jpg','تهران، خیام، خیابان لاله زار، پلاک 6','37.119908,58.507695','قوچان','پزشک عمومی (دارای شماره نظام پزشکی)','عفونت (آبسه) دندان, لمینت دندان, کامپوزیت دندان, صاف کردن دندان, دندان مصنوعی, ایمپلنت دندان, ایمپلنت با پیوند استخوان, پروتز دندان, روکش ایمپلنت','1379',0,0,'2025-04-15 18:31:58','2025-08-04 12:30:37'),(15,'369349','یاقوتی','9370369349','051970215111','کلینیک آفتاب','public/user-image/2025-08-04-13-48-44.webp','مشهد، ابوذر غفاری، خ. ناصر خسرو 34، پلاک 6','36.285747,59.561968','تهران','پزشک پوست و مو','شفافیت پوست, جراحی پوست, طراحی خط لبخند, جراح, متخصص مو, جراحی پلاستیک, لیفت صورت, ترمیم سوختگی, جراحی پلک, جراحی گوش','1381',0,0,'2025-05-22 12:34:46','2025-08-05 19:51:42');
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL,
  `ask` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_faq_doctor` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
INSERT INTO `faq` VALUES (14,15,'چگونه می‌توانم نزدیک‌ترین بیمارستان به محل سکونتم را در این سایت پیدا کنم؟','جواب سوال 666','2025-05-22 13:05:43','2025-09-09 21:16:18'),(6,1,' آیا می‌توان از طریق سایت وقت ملاقات رزرو کرد؟1313','در حال حاضر، برخی از مراکز درمانی طرف قرارداد با سامانه دده است.2222222','2025-05-15 12:57:14','2025-05-18 19:24:02'),(8,1,'آیا اطلاعات تماس و موقعیت دقیق مراکز درمانی در سایت ارائه می‌شود؟',' بله. صفحه اختصاصی هر بیمارستان یا درمانگاه شامل آدرس کامل، شماره تماس، نقشه گوگل و در صورت وجود، لینک به وب‌سایت رسمی مرکز مربوطه است.','2025-05-18 13:32:16','2025-05-18 19:24:02'),(15,15,'چگونه می‌توانم نزدیک‌ترین بیمارستان به محل سکونتم را در این سایت پیدا کنم؟2131231323','جواب سوال 56578','2025-09-09 21:16:18',NULL);
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url` varchar(300) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
INSERT INTO `menus` VALUES (26,'ارتباط با ما','contact-us',NULL,'2025-03-19 15:15:22','2025-05-12 17:01:35');
UNLOCK TABLES;

--
-- Table structure for table `post_ratings`
--

DROP TABLE IF EXISTS `post_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `fk_post` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_ratings`
--

LOCK TABLES `post_ratings` WRITE;
INSERT INTO `post_ratings` VALUES (51,37,166,3,'2025-05-20 05:43:01',NULL),(50,34,162,4,'2025-05-08 12:08:28','2025-05-14 00:36:22'),(49,35,18,4,'2025-05-07 19:27:51','2025-05-07 22:58:02'),(48,35,162,4,'2025-05-07 19:20:20',NULL),(52,44,166,5,'2025-05-20 05:43:05',NULL),(53,38,166,2,'2025-05-20 05:56:57','2025-05-20 09:57:27'),(54,35,166,3,'2025-05-20 15:00:45',NULL),(55,35,15,4,'2025-05-22 14:22:19',NULL),(56,50,15,2,'2025-05-22 14:47:54',NULL),(57,51,15,2,'2025-05-26 20:57:22',NULL),(58,35,784,4,'2025-07-28 19:49:45','2025-07-30 14:59:05'),(59,50,784,3,'2025-07-28 19:50:04',NULL),(60,35,1,2,'2025-07-28 20:36:47','2025-07-30 15:15:55'),(61,50,1,4,'2025-07-28 20:36:53','2025-07-29 00:19:28');
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`shariatg_dentistproject`@`localhost`*/ /*!50003 TRIGGER `after_update_post_rating` AFTER UPDATE ON `post_ratings` FOR EACH ROW BEGIN
  DECLARE avg_rating FLOAT;
  
  -- اول ۵ تا از مقدار فعلی کم کن
  UPDATE posts 
  SET rating = GREATEST(rating - 5, 0) -- مطمئن شو منفی نشه
  WHERE id = NEW.post_id;
  
  -- بعد میانگین جدید rating‌ها رو حساب کن
  SELECT AVG(rating) INTO avg_rating 
  FROM post_ratings 
  WHERE post_id = NEW.post_id;
  
  -- اگر هیچ ریتی نبود → صفرش کن
  IF avg_rating IS NULL THEN
    SET avg_rating = 0;
  END IF;
  
  -- حالا میانگین جدید رو در جدول posts ذخیره کن
  UPDATE posts 
  SET rating = avg_rating 
  WHERE id = NEW.post_id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `summary` text NOT NULL,
  `body` text NOT NULL,
  `view` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` enum('disable','enable') NOT NULL DEFAULT 'disable',
  `rating` int(11) NOT NULL DEFAULT 0,
  `selected` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1 => select 2 => no select',
  `breaking_news` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1 => no breaking news 2 => breaking news',
  `published_at` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_post_doctor` FOREIGN KEY (`user_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
INSERT INTO `posts` VALUES (33,'اهمیت مراقبت از دندان‌ها برای سلامت عمومی','<p>مراقبت از دندان&zwnj;ها نه تنها برای حفظ زیبایی لبخند شما مهم است، بلکه تأثیر زیادی بر سلامت عمومی بدن دارد. در این مقاله، به دلایل اهمیت مراقبت از دندان&zwnj;ها و چگونگی تأثیر آن بر سایر بخش&zwnj;های بدن می&zwnj;پردازیم.</p>\n','<p>دندان&zwnj;ها یکی از مهم&zwnj;ترین بخش&zwnj;های بدن ما هستند که معمولاً نادیده گرفته می&zwnj;شوند. بسیاری از افراد تنها به زیبایی دندان&zwnj;ها توجه می&zwnj;کنند، اما آیا می&zwnj;دانستید که دندان&zwnj;های سالم می&zwnj;توانند بر سلامت عمومی بدن شما تأثیر زیادی بگذارند؟<br />\r\nمراقبت مناسب از دندان&zwnj;ها می&zwnj;تواند از بیماری&zwnj;های لثه جلوگیری کند که این بیماری&zwnj;ها با مشکلات قلبی، دیابت و حتی سکته مغزی مرتبط هستند. بیماری&zwnj;های لثه به دلیل وجود باکتری&zwnj;ها می&zwnj;توانند به خون وارد شوند و به سایر ارگان&zwnj;ها آسیب بزنند.<br />\r\nبرای پیشگیری از این مشکلات، مسواک زدن دو بار در روز، استفاده از نخ دندان و مراجعه منظم به دندانپزشک ضروری است.<br />\r\nهمچنین، تغذیه مناسب و پرهیز از مصرف مواد قندی می&zwnj;تواند به سلامت دندان&zwnj;های شما کمک کند. حفظ دندان&zwnj;های سالم، علاوه بر اینکه از مشکلات جدی جلوگیری می&zwnj;کند، می&zwnj;تواند باعث افزایش اعتماد به نفس و راحتی در صحبت کردن و خوردن شود.</p>\r\n',7,1,13,'public/post-image/2025-03-22-01-56-53.jpeg','disable',0,2,2,'2025-03-22','2025-03-22 01:56:53','2025-11-24 02:10:47'),(34,'چرا باید به دندانپزشک مراجعه کنیم؟','<p>مراجعه به دندانپزشک نباید تنها در صورت داشتن درد یا مشکل باشد. در این مقاله، به دلایلی می&zwnj;پردازیم که نشان می&zwnj;دهند چرا باید به طور منظم به دندانپزشک مراجعه کنید و چگونه این کار می&zwnj;تواند سلامت دندان&zwnj;های شما را تضمین کند.</p>\n','<p>بسیاری از مردم تنها وقتی به دندانپزشک مراجعه می&zwnj;کنند که درد یا مشکلی در دندان&zwnj;هایشان احساس کنند. اما این رویکرد می&zwnj;تواند منجر به بروز مشکلات بزرگ&zwnj;تری شود که درمان آن&zwnj;ها گاهی پیچیده و پرهزینه است.<br />\r\nمراجعه به دندانپزشک به صورت منظم، حتی زمانی که هیچ مشکلی ندارید، به شما کمک می&zwnj;کند تا مشکلات دندانی را در مراحل اولیه شناسایی کنید. مشکلاتی مانند پوسیدگی دندان، بیماری&zwnj;های لثه یا ترک&zwnj;خوردگی دندان&zwnj;ها ممکن است بدون علائم جدی شروع شوند و در صورت عدم درمان، می&zwnj;توانند به مشکلات جدی&zwnj;تری تبدیل شوند.<br />\r\nدندانپزشک با بررسی دقیق دهان و دندان&zwnj;ها، می&zwnj;تواند نشانه&zwnj;های اولیه بیماری&zwnj;های دهانی را شناسایی کرده و درمان&zwnj;های پیشگیرانه را توصیه کند.<br />\r\nدر نهایت، مراقبت پیشگیرانه همیشه ارزان&zwnj;تر و کم&zwnj;دردسرتر از درمان&zwnj;های پیچیده و طولانی است. پس از هم&zwnj;اکنون به دندانپزشک خود مراجعه کنید و از سلامت دندان&zwnj;های خود اطمینان حاصل کنید.</p>\r\n',14,1,13,'public/post-image/2025-03-22-01-58-07.jpeg','disable',4,1,2,'2025-04-09','2025-03-22 01:58:07','2025-11-24 02:10:36'),(35,'نکات مهم در استفاده از نخ دندان','<p>استفاده از نخ دندان یکی از مراحل مهم در مراقبت از دندان&zwnj;ها است. در این مقاله، نکات کلیدی برای استفاده صحیح از نخ دندان و فواید آن برای سلامت دندان&zwnj;های شما آورده شده است.</p>\r\n','<p>نخ دندان یکی از ابزارهای ضروری برای مراقبت از دندان&zwnj;هاست که بسیاری از افراد از آن غافل می&zwnj;شوند. استفاده منظم از نخ دندان می&zwnj;تواند از پوسیدگی دندان، بیماری&zwnj;های لثه و سایر مشکلات دندانی جلوگیری کند.<br />\r\nاستفاده صحیح از نخ دندان به این صورت است که به آرامی و با دقت نخ را بین دندان&zwnj;ها قرار دهید و به طرفین دندان حرکت دهید تا ذرات غذا و پلاک&zwnj;های میکروبی را از بین ببرید.<br />\r\nنخ دندان باید به طور روزانه استفاده شود، ترجیحاً بعد از مسواک زدن تا به حذف پلاک&zwnj;ها و باکتری&zwnj;های باقی&zwnj;مانده کمک کند. در صورتی که شما به دندان&zwnj;پزشک مراجعه کرده و از نظر بهداشت دهان و دندان مورد بررسی قرار بگیرید، ممکن است پزشک استفاده از نخ دندان را به عنوان بخشی از برنامه مراقبتی شما تجویز کند.<br />\r\nاگر از نخ دندان استفاده می&zwnj;کنید، همچنین بهتر است به غذای خود دقت کنید و از خوردن مواد غذایی چسبنده و قندی که ممکن است در دندان&zwnj;ها باقی بمانند، خودداری کنید. به یاد داشته باشید که نخ دندان تنها یکی از اجزای مراقبت از دندان&zwnj;هاست و باید همراه با مسواک زدن منظم و مراجعه به دندانپزشک صورت گیرد.</p>\r\n',38,1,18,'public/post-image/2025-03-22-02-00-42.jpeg','disable',21,1,1,'2025-03-22','2025-03-22 02:00:42','2025-12-13 21:29:38'),(46,'پزشکی مدرن: انقلابی در تشخیص و درمان','<p>پزشکی مدرن با تکیه بر تکنولوژی، هوش مصنوعی و تحقیقات پیشرفته، توانسته تحول عظیمی در تشخیص و درمان بیماری&zwnj;ها ایجاد کند.</p>\r\n','<p>پزشکی مدرن امروزه بر پایه داده&zwnj;های دقیق، تصویربرداری&zwnj;های پیشرفته مانند MRI و CT Scan، و داروهای نوین شکل گرفته است. با بهره&zwnj;گیری از هوش مصنوعی، تشخیص بیماری&zwnj;ها با دقتی بی&zwnj;سابقه انجام می&zwnj;شود. درمان&zwnj;های هدفمند، ژن&zwnj;درمانی و جراحی&zwnj;های رباتیک از جمله دستاوردهای مهم این حوزه هستند که موجب کاهش خطاهای انسانی و افزایش کیفیت زندگی بیماران شده&zwnj;اند.</p>\r\n',4,1,18,'public/post-image/2025-05-22-14-29-14.jpeg','disable',0,2,2,'1404-03-01','2025-05-22 17:59:14','2025-11-24 01:41:39'),(47,'درمان‌های سنتی؛ بازگشت به طبیعت','<p>پزشکی سنتی با تکیه بر گیاهان دارویی و شیوه&zwnj;های طبیعی، روشی تکمیلی برای حفظ سلامتی و درمان بیماری&zwnj;ها به شمار می&zwnj;رود.</p>\r\n','<p>درمان&zwnj;های سنتی از دل فرهنگ&zwnj;ها و تمدن&zwnj;های کهن برخاسته&zwnj;اند. استفاده از گیاهانی مانند زنجبیل، دارچین، اسطوخودوس و زردچوبه در کاهش التهاب و بهبود سیستم ایمنی موثر واقع شده است. همچنین، روش&zwnj;هایی چون حجامت، بادکش و طب سوزنی، امروزه به&zwnj;عنوان مکملی برای درمان&zwnj;های مدرن استفاده می&zwnj;شوند و توجه بسیاری از مردم را به خود جلب کرده&zwnj;اند.</p>\r\n',6,15,22,'public/post-image/2025-05-22-14-30-23.jpeg','disable',0,2,2,'0000-00-00','2025-05-22 18:00:23','2025-11-24 01:41:44'),(48,'ایمپلنت‌های دندانی؛ جایگزینی پایدار و زیبا','<p>ایمپلنت&zwnj;های دندانی یکی از پیشرفت&zwnj;های بزرگ در دندان&zwnj;پزشکی نوین هستند که به بازسازی لبخند کمک شایانی می&zwnj;کنند.</p>\r\n','<p>با از دست دادن دندان&zwnj;ها، مشکلاتی همچون اختلال در جویدن، کاهش اعتماد به&zwnj;نفس و تحلیل استخوان فک به&zwnj;وجود می&zwnj;آید. ایمپلنت دندانی با کاشت پایه&zwnj;ای تیتانیومی در فک، نه&zwnj;تنها زیبایی لبخند را بازمی&zwnj;گرداند بلکه عملکرد کامل دندان را نیز فراهم می&zwnj;کند. این روش با طول عمر بالا، جایگزینی ماندگار و مطمئن برای دندان&zwnj;های ازدست&zwnj;رفته محسوب می&zwnj;شود.</p>\r\n',3,15,13,'public/post-image/2025-05-22-14-41-09.jpeg','disable',0,2,1,'1400-03-04','2025-05-22 18:11:09','2025-11-24 01:41:28'),(49,'مقایسه طب سنتی و مدرن؛ تقابل یا تکامل؟','<p>طب سنتی و مدرن هر یک مزایا و معایب خاص خود را دارند؛ اما در نهایت می&zwnj;توانند مکمل یکدیگر باشند.</p>\r\n\r\n<p>&nbsp;</p>\r\n','<p>در حالی&zwnj;که پزشکی مدرن بر اساس آزمایش&zwnj;های علمی و داروهای شیمیایی شکل گرفته، طب سنتی بر اساس تجربه و طبیعت استوار است. تلفیق این دو می&zwnj;تواند موجب درمان بهتر و کامل&zwnj;تر شود. برای مثال، بیمارانی که با طب مدرن بهبود نیافته&zwnj;اند، گاهی با استفاده از طب سنتی نتایج مثبت&zwnj;تری می&zwnj;گیرند. امروزه تلفیق این دو نگرش در حوزه&zwnj;هایی مانند دردهای مزمن و بیماری&zwnj;های گوارشی اثربخش بوده است.</p>\r\n',6,15,22,'public/post-image/2025-05-22-14-41-55.jpeg','disable',0,2,1,'1393-08-20','2025-05-22 18:11:55','2025-11-24 01:41:30'),(50,'مراقبت از پوست؛ فراتر از زیبایی','<p>پوست، اولین خط دفاعی بدن در برابر عوامل بیرونی است و نیازمند مراقبت روزانه و تخصصی می&zwnj;باشد.</p>\r\n\r\n<p>&nbsp;</p>\r\n','<p>با توجه به آلودگی هوا، اشعه&zwnj;های مضر خورشید و تغذیه ناسالم، پوست ما در معرض آسیب&zwnj;های فراوانی قرار دارد. استفاده از ضدآفتاب، مرطوب&zwnj;کننده، شوینده&zwnj;های مناسب نوع پوست و مراجعه منظم به متخصص پوست، از ضروریات مراقبتی هستند. همچنین، انجام درمان&zwnj;هایی مانند میکرونیدلینگ، لیزر یا پاک&zwnj;سازی&zwnj;های عمیق می&zwnj;تواند به حفظ طراوت و سلامت پوست کمک شایانی کند.</p>\r\n',19,15,23,'public/post-image/2025-05-22-14-43-51.jpeg','disable',9,1,2,'1390-06-28','2025-05-22 18:13:51','2025-11-24 01:42:13'),(51,'گیاه‌درمانی در طب سنتی ایران','<p>گیاهان دارویی همچون گل&zwnj;گاوزبان، نعنا، آویشن و بابونه نقش مهمی در طب سنتی ایرانی دارند.</p>\r\n\r\n<p>&nbsp;</p>\r\n','<p>طب سنتی ایران با بهره&zwnj;گیری از خواص طبیعی گیاهان، هزاران سال است که به درمان بیماری&zwnj;های مختلف پرداخته است. گیاهانی مانند گل&zwnj;گاوزبان برای آرامش روان، نعنا برای مشکلات گوارشی و آویشن برای تسکین سرفه کاربرد دارند. امروزه با افزایش علاقه مردم به روش&zwnj;های طبیعی، گیاه&zwnj;درمانی مورد توجه بسیاری از پزشکان نیز قرار گرفته است.</p>\r\n',21,15,22,'public/post-image/2025-05-22-14-47-25.jpeg','disable',2,1,2,'1381-04-19','2025-05-22 18:17:25','2025-11-24 01:41:24'),(53,'لورم ایپسوم متن ساختگی با تولید','<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n','<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای <u>کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مور</u>د نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طر<span style=\"background-color:#e74c3c\">احان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.لورم ایپسوم متن </span>ساختگی با تولید سادگی نامفهوم از <s>صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپ</s>گرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و <span style=\"color:#c0392b\"><s><span style=\"background-color:#1abc9c\">کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال</span></s></span> و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتا<span style=\"background-color:#f1c40f\">بهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد</span><span style=\"background-color:#2ecc71\">.شسیشیشسیشسییشسی</span></p>\r\n',19,1,23,'public/post-image/2025-09-10-20-38-47.webp','disable',0,2,2,'1404-05-14','2025-07-31 19:07:33','2025-12-13 18:44:18');
UNLOCK TABLES;

--
-- Table structure for table `reservedtimes`
--

DROP TABLE IF EXISTS `reservedtimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservedtimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `additional` varchar(255) DEFAULT NULL,
  `price` text NOT NULL,
  `time` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `week` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_doctor_id` (`doctor_id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservedtimes`
--

LOCK TABLES `reservedtimes` WRITE;
INSERT INTO `reservedtimes` VALUES (40,784,1,NULL,'110000','12:17:00','1404-03-03','شنبه','2025-05-22 12:18:45','2025-05-22 12:20:05'),(48,784,15,NULL,'650000','12:00','1404-03-06','سه‌شنبه','2025-06-16 12:42:50',NULL),(53,784,1,NULL,'650000','12:00','1404-03-11','یکشنبه','2025-07-29 00:38:36',NULL),(54,784,15,NULL,'650000','09:15','1404-03-07','چهارشنبه','2025-07-29 00:47:14',NULL),(55,784,1,NULL,'1150000','13:25','1404-03-13','سه‌شنبه','2025-07-30 13:54:18',NULL),(56,784,1,NULL,'650000','12:00','1404-03-11','شنبه','2025-07-30 13:56:17',NULL),(57,784,1,NULL,'650000','17:30','1404-03-22','پنج‌شنبه','2025-07-30 14:05:24',NULL),(58,784,1,NULL,'650000','12:00','1404-03-17','شنبه','2025-07-30 14:12:33',NULL),(59,784,15,NULL,'650000','13:00','1404-03-31','شنبه','2025-07-30 14:13:53',NULL),(60,784,1,NULL,'650000','20:40','1404-03-22','پنج‌شنبه','2025-07-30 14:14:52',NULL),(61,784,1,NULL,'650000','6:14','1404-04-03','دوشنبه','2025-07-30 14:20:32',NULL),(62,784,1,NULL,'650000','12:00','1404-03-17','شنبه','2025-07-30 14:49:23',NULL),(64,786,15,NULL,'750000','14:38:00','1404-05-06','یکشنبه','2025-07-31 14:39:18',NULL),(65,788,1,'تست','750000','04:00','1404-05-30','پنج‌شنبه','2025-08-01 20:27:50','2025-08-12 21:00:10'),(72,789,1,'تست','1560000','8:41','1404-05-31','جمعه','2025-08-12 21:54:48',NULL),(68,791,1,'لمینت123','666','19:48','1404-05-22','چهارشنبه','2025-08-12 19:49:24',NULL),(76,789,1,NULL,'650000','12:00','1404-03-22','پنج‌شنبه','2025-09-10 23:52:25',NULL),(71,786,1,'کامپوزیت4','750000','20:47:00','1404-05-31','جمعه','2025-08-12 20:46:35','2025-08-12 20:47:30'),(78,1,1,'جرم گیری','770000','12:00','1404-03-14','چهارشنبه','2025-09-13 17:33:31',NULL),(79,1,1,'جرم گیری','1150000','17:30','1404-03-13','سه‌شنبه','2025-09-13 18:06:12',NULL);
UNLOCK TABLES;

--
-- Table structure for table `reserves`
--

DROP TABLE IF EXISTS `reserves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `additional` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `time` text NOT NULL,
  `day` varchar(50) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 1000000,
  `doctor_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_doctor` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=234 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserves`
--

LOCK TABLES `reserves` WRITE;
INSERT INTO `reserves` VALUES (80,'جرم گیری','1404-03-13','01:00','سه‌شنبه',1150000,1,'2025-05-27 01:19:00',NULL),(155,'جرم گیری','1404-05-04','22:30','شنبه',750000,1,'2025-07-31 14:11:08',NULL),(134,'جرم گیری','1404-05-13','09:20','دوشنبه',8000000,1,'2025-07-30 15:17:49',NULL),(135,'جرم گیری','1404-05-13','10:30','دوشنبه',8000000,1,'2025-07-30 15:17:49',NULL),(76,NULL,'1404-03-04','21:07','دوشنبه',65,15,'2025-05-25 17:28:51','2025-05-27 21:07:22'),(142,'کامپوزیت','1404-05-11','20:45','شنبه',150000,1,'2025-07-30 15:18:19',NULL),(71,NULL,'1404-03-31','12:00','شنبه',1500000,15,'2025-05-25 17:27:43','2025-05-27 22:16:42'),(140,'کامپوزیت','1404-05-11','19:45','شنبه',150000,1,'2025-07-30 15:18:19',NULL),(138,'لمینت','1404-05-13','18:30','دوشنبه',8000000,1,'2025-07-30 15:17:49',NULL),(158,NULL,'1404-05-14','16:20','سه‌شنبه',750000,15,'2025-08-04 13:50:57',NULL),(81,'لمینت','1404-03-13','01:15','سه‌شنبه',1150000,1,'2025-05-27 01:19:00',NULL),(141,'لمینت','1404-05-11','20:30','شنبه',150000,1,'2025-07-30 15:18:19',NULL),(84,'لمینت','1404-03-13','13:30','سه‌شنبه',1150000,1,'2025-05-27 01:19:00',NULL),(86,'جرم گیری','1404-03-13','19:30','سه‌شنبه',1150000,1,'2025-05-27 01:19:00',NULL),(200,'لمینت','1404-05-23','20:45','پنج‌شنبه',1111,1,'2025-08-12 19:18:09',NULL),(88,'جرم گیری','1404-03-13','21:35','سه‌شنبه',1150000,1,'2025-05-27 01:19:00',NULL),(230,'دندون','1404-06-24','19:45','دوشنبه',1000000,1,'2025-09-13 17:44:32',NULL),(91,'جرم گیری','1404-03-14','01:00','چهارشنبه',770000,1,'2025-05-27 01:20:02',NULL),(92,'جرم گیری','1404-03-14','04:00','چهارشنبه',770000,1,'2025-05-27 01:20:02',NULL),(93,'کامپوزیت','1404-03-14','04:30','چهارشنبه',770000,1,'2025-05-27 01:20:02',NULL),(147,'کامپوزیت','1404-05-21','17:25','سه‌شنبه',1550000,1,'2025-07-31 14:10:42',NULL),(95,'کامپوزیت','1404-03-14','07:35','چهارشنبه',770000,1,'2025-05-27 01:20:02',NULL),(129,NULL,'1404-03-26','19:20','دوشنبه',4250000,15,'2025-06-16 13:48:55',NULL),(97,NULL,'1404-03-06','01:00','سه‌شنبه',650000,15,'2025-05-27 01:20:32',NULL),(98,NULL,'1404-03-06','01:20','سه‌شنبه',650000,15,'2025-05-27 01:20:32',NULL),(99,NULL,'1404-03-06','17:20','سه‌شنبه',650000,15,'2025-05-27 01:20:32',NULL),(100,NULL,'1404-03-06','17:30','سه‌شنبه',650000,15,'2025-05-27 01:20:32',NULL),(101,NULL,'1404-03-06','19:30','سه‌شنبه',650000,15,'2025-05-27 01:20:32',NULL),(153,NULL,'1404-05-04','20:30','شنبه',750000,1,'2025-07-31 14:11:08',NULL),(154,'کامپوزیت','1404-05-04','21:30','شنبه',750000,1,'2025-07-31 14:11:08',NULL),(105,'کامپوزیت','1404-03-11','12:00','یکشنبه',650000,1,'2025-05-27 17:56:09',NULL),(106,'کامپوزیت','1404-03-11','12:00','یکشنبه',650000,1,'2025-05-27 17:56:09',NULL),(107,'کامپوزیت','1404-03-11','12:00','یکشنبه',650000,1,'2025-05-27 17:56:09',NULL),(108,NULL,'1404-03-11','12:00','یکشنبه',650000,1,'2025-05-27 17:56:09',NULL),(110,NULL,'1404-03-11','12:00','یکشنبه',650000,1,'2025-05-27 17:56:09',NULL),(152,NULL,'1404-05-04','18:30','شنبه',750000,1,'2025-07-31 14:11:08',NULL),(151,NULL,'1404-05-04','16:30','شنبه',750000,1,'2025-07-31 14:11:08',NULL),(149,NULL,'1404-05-21','19:35','سه‌شنبه',1550000,1,'2025-07-31 14:10:42',NULL),(208,'تست','1404-07-01','19:45','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(117,NULL,'1404-03-22','05:00','پنج‌شنبه',650000,1,'2025-05-27 17:57:09',NULL),(139,NULL,'1404-05-11','19:30','شنبه',150000,1,'2025-07-30 15:18:19',NULL),(128,NULL,'1404-03-26','18:25','دوشنبه',4250000,15,'2025-06-16 13:48:55',NULL),(137,NULL,'1404-05-13','11:45','دوشنبه',8000000,1,'2025-07-30 15:17:49',NULL),(121,NULL,'1404-03-07','15:16','پنج‌شنبه',650,1,'2025-05-27 17:57:09','2025-05-27 21:04:01'),(150,NULL,'1404-05-21','19:45','سه‌شنبه',1550000,1,'2025-07-31 14:10:42',NULL),(136,NULL,'1404-05-13','11:30','دوشنبه',8000000,1,'2025-07-30 15:17:49',NULL),(197,'کامپوزیت','1404-05-22','18:30','چهارشنبه',750000,1,'2025-08-12 19:17:25',NULL),(159,NULL,'1404-05-14','16:30','سه‌شنبه',750000,15,'2025-08-04 13:50:57',NULL),(160,NULL,'1404-05-14','16:40','سه‌شنبه',750000,15,'2025-08-04 13:50:57',NULL),(161,NULL,'1404-05-14','16:55','سه‌شنبه',750000,15,'2025-08-04 13:50:57',NULL),(162,NULL,'1404-05-14','17:30','سه‌شنبه',750000,15,'2025-08-04 13:50:57',NULL),(163,NULL,'1404-05-14','17:45','سه‌شنبه',750000,15,'2025-08-04 13:50:57',NULL),(164,NULL,'1404-05-15','09:30','چهارشنبه',750000,15,'2025-08-04 13:51:30',NULL),(165,NULL,'1404-05-15','09:55','چهارشنبه',750000,15,'2025-08-04 13:51:30',NULL),(166,NULL,'1404-05-15','11:15','چهارشنبه',750000,15,'2025-08-04 13:51:30',NULL),(167,NULL,'1404-05-15','11:30','چهارشنبه',750000,15,'2025-08-04 13:51:30',NULL),(168,NULL,'1404-05-15','17:30','چهارشنبه',750000,15,'2025-08-04 13:51:30',NULL),(169,NULL,'1404-05-15','21:30','چهارشنبه',750000,15,'2025-08-04 13:51:30',NULL),(170,NULL,'1404-05-16','19:30','پنج‌شنبه',750000,15,'2025-08-04 13:51:59',NULL),(171,NULL,'1404-05-16','19:40','پنج‌شنبه',750000,15,'2025-08-04 13:51:59',NULL),(172,NULL,'1404-05-16','19:50','پنج‌شنبه',750000,15,'2025-08-04 13:51:59',NULL),(173,NULL,'1404-05-16','21:30','پنج‌شنبه',750000,15,'2025-08-04 13:51:59',NULL),(174,NULL,'1404-05-16','21:40','پنج‌شنبه',750000,15,'2025-08-04 13:51:59',NULL),(175,NULL,'1404-05-16','21:55','پنج‌شنبه',750000,15,'2025-08-04 13:51:59',NULL),(176,'ترمیم سوختگی','1404-05-22','18:40','چهارشنبه',750000,15,'2025-08-04 13:52:42',NULL),(177,'لیفت صورت','1404-05-22','18:50','چهارشنبه',750000,15,'2025-08-04 13:52:42',NULL),(178,'لیفت صورت','1404-05-22','18:10','چهارشنبه',750000,15,'2025-08-04 13:52:42',NULL),(179,'لیفت صورت','1404-05-22','18:25','چهارشنبه',750000,15,'2025-08-04 13:52:42',NULL),(180,'ترمیم سوختگی','1404-05-22','21:25','چهارشنبه',750000,15,'2025-08-04 13:52:42',NULL),(181,'ترمیم سوختگی','1404-05-22','21:15','چهارشنبه',750000,15,'2025-08-04 13:52:42',NULL),(182,'ترمیم سوختگی','1404-05-22','21:45','چهارشنبه',750000,15,'2025-08-04 13:52:42',NULL),(183,'جرم گیری','1404-05-25','17:45','شنبه',67560000,15,'2025-08-04 13:53:29',NULL),(184,'جرم گیری','1404-05-25','20:20','شنبه',67560000,15,'2025-08-04 13:53:29',NULL),(185,'جرم گیری','1404-05-25','11:15','شنبه',67560000,15,'2025-08-04 13:53:29',NULL),(186,'جرم گیری','1404-05-25','07:25','شنبه',67560000,15,'2025-08-04 13:53:29',NULL),(187,'لمینت','1404-05-26','08:30','یکشنبه',110000000,15,'2025-08-04 13:54:11',NULL),(188,'لمینت','1404-05-26','08:55','یکشنبه',110000000,15,'2025-08-04 13:54:11',NULL),(189,'لمینت','1404-05-26','08:25','یکشنبه',110000000,15,'2025-08-04 13:54:11',NULL),(190,'کامپوزیت','1404-05-26','08:50','یکشنبه',110000000,15,'2025-08-04 13:54:11',NULL),(191,'کامپوزیت','1404-05-26','07:50','یکشنبه',110000000,15,'2025-08-04 13:54:11',NULL),(192,'کامپوزیت','1404-05-26','07:20','یکشنبه',110000000,15,'2025-08-04 13:54:11',NULL),(193,'کامپوزیت','1404-05-26','17:30','یکشنبه',110000000,15,'2025-08-04 13:54:11',NULL),(199,'لمینت','1404-05-23','5:40','پنج‌شنبه',1111,1,'2025-08-12 19:18:09','2025-08-12 19:20:06'),(195,NULL,'1404-05-04','18:35','شنبه',750000,1,'2025-08-12 19:13:50',NULL),(198,'کامپوزیت','1404-05-22','8:45','چهارشنبه',750000,1,'2025-08-12 19:17:25','2025-08-12 19:19:56'),(201,'لمینت','1404-05-23','22:45','پنج‌شنبه',1111,1,'2025-08-12 19:18:09',NULL),(202,'لمینت','1404-05-23','18:45','پنج‌شنبه',1111,1,'2025-08-12 19:18:09',NULL),(209,'تست','1404-07-01','21:45','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(210,'تست','1404-07-01','18:45','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(211,'تست','1404-07-01','19:45','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(212,'تست','1404-07-01','20:45','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(213,'تست','1404-07-01','23:55','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(214,'تست','1404-07-01','22:55','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(215,'تست','1404-07-01','17:55','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(216,'تست','1404-07-01','15:55','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(217,'تست','1404-07-01','16:55','سه‌شنبه',75001235,1,'2025-09-10 23:59:57',NULL),(231,'دندون','1404-06-24','19:20','دوشنبه',1000000,1,'2025-09-13 17:44:32',NULL),(232,'دندون','1404-06-24','17:45','دوشنبه',1000000,1,'2025-09-13 17:44:32',NULL),(233,'دندون','1404-06-24','17:25','دوشنبه',1000000,1,'2025-09-13 17:44:32',NULL);
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `number` varchar(100) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `permission` enum('admin','user') NOT NULL DEFAULT 'user',
  `accessedByDoctorId` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`number`),
  UNIQUE KEY `number` (`number`),
  KEY `fk_users_doctor` (`accessedByDoctorId`),
  CONSTRAINT `fk_users_doctor` FOREIGN KEY (`accessedByDoctorId`) REFERENCES `doctors` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (784,'شهرام رحیم زاده','9152222222',1,'user',NULL,'2025-07-28 20:33:35','2025-09-10 22:43:20'),(786,'سارینا اسمائیلی','1597021533',1,'user',NULL,'2025-07-31 14:39:18','2025-09-10 22:43:22'),(788,'شهرام','9152222222',0,'user',NULL,'2025-08-01 20:26:08','2025-09-10 22:43:24'),(789,'شهرام رحیم زاده','9302160953',1,'admin',1,'2025-08-12 13:15:47','2025-09-14 01:49:29'),(791,'صبا باقری','9169702155',1,'user',NULL,'2025-08-12 19:49:24','2025-09-10 22:43:25');
UNLOCK TABLES;

--
-- Table structure for table `websetting`
--

DROP TABLE IF EXISTS `websetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `websetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `intro_image_1` text DEFAULT NULL,
  `intro_text_1` text DEFAULT NULL,
  `intro_text_11` text DEFAULT NULL,
  `intro_image_2` text DEFAULT NULL,
  `intro_text_2` text DEFAULT NULL,
  `intro_text_22` text DEFAULT NULL,
  `intro_image_3` text DEFAULT NULL,
  `intro_text_3` text DEFAULT NULL,
  `intro_text_33` text DEFAULT NULL,
  `footer_text` text NOT NULL,
  `main_loc_address` text DEFAULT NULL,
  `main_email_address` text DEFAULT NULL,
  `main_number_address` text DEFAULT NULL,
  `socialmedia_1` varchar(100) DEFAULT NULL,
  `socialmedia_2` varchar(100) DEFAULT NULL,
  `socialmedia_3` varchar(100) DEFAULT NULL,
  `web_desc_title` varchar(200) NOT NULL,
  `web_description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_persian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `websetting`
--

LOCK TABLES `websetting` WRITE;
INSERT INTO `websetting` VALUES (1,'MediCare','رزرو نوبت دندان پزشکی','رزرو نوبت دندان پزشکی MediCare','public/setting/logo.png','public/setting/icon.png','public/setting/intro_image_1.webp','دندان‌های سفید، اعتماد به‌نفس بیشتر','لبخند زیبا، قدرت در نگاه','public/setting/intro_image_2.webp','لبخندی سالم، زندگی‌ای شاد','دندان سالم، دل شاد','public/setting/intro_image_3.webp','نوبت‌دهی سریع و آسان دندان‌پزشکی','وقت دندان‌پزشکی، سریع و راحت','با خدمات حرفه‌ای دندان‌پزشکی، لبخندی زیبا و سالم برایتان می‌سازیم. همین حالا نوبت         بگیرید.','  مشهد، بلوار سجاد، هاشمی ۱۰','  email@example.com','09302160953','  Medicare.dentist','  Medicare.resome','  051 123 3225','مدیکر نوبت دهی آنلاین','مدیکر، یک پلتفرم پیشرفته و راحت برای نوبت‌گیری آنلاین و مشاوره از معتبرترین پزشکان ایران است. پزشکان می‌توانند با استفاده از مدیکر، نوبت‌دهی آنلاین و مشاوره تلفنی خود را به راحتی فعال کرده و به بیماران خدمات خود را ارائه دهند. بدین ترتیب، بیماران دیگر نیازی به روش‌های سنتی مثل تماس تلفنی یا مراجعه حضوری برای دریافت نوبت نخواهند داشت. برای گرفتن نوبت ویزیت حضوری یا تلفنی از بهترین پزشکان متخصص و فوق تخصص، تنها کافی است به سایت یا اپلیکیشن مدیکر مراجعه کرده و نوبت خود را در زمان دلخواه رزرو کنید.','2019-06-09 19:54:37','2025-08-22 13:54:36');
UNLOCK TABLES;

--
-- Dumping events for database 'shariatg_dentist_project'
--

--
-- Dumping routines for database 'shariatg_dentist_project'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-14 17:14:36
