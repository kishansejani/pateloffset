-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: localhost    Database: pateloffset
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa-solid fa-print',
  `art` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'card',
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6d28d9',
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Visiting Cards','visiting-cards','fa-solid fa-address-card','card','#7c3aed','Make a bold first impression','Premium business cards in gloss, matt, velvet, texture, metal & PVC finishes.',NULL,0,1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(2,'Marketing Materials','marketing-materials','fa-solid fa-bullhorn','flyer','#ec4899','Flyers, brochures & pamphlets','Eye-catching flyers, brochures and pamphlets that bring customers to your door.',NULL,1,1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(3,'Flex & Banners','flex-banners','fa-solid fa-flag','banner','#f97316','Big prints, bigger impact','Solvent & eco-solvent flex, vinyl, backlit and roll-up banners in every size.',NULL,2,1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(4,'Stationery','stationery','fa-solid fa-file-lines','letterhead','#0ea5e9','Letterheads, envelopes & bill books','Professional office stationery that carries your brand on every page.',NULL,3,1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(5,'Stickers & Labels','stickers-labels','fa-solid fa-note-sticky','sticker','#22c55e','Stick your brand everywhere','Die-cut, round, vinyl, transparent and product labels in any shape.',NULL,4,1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(6,'Display & Signage','display-signage','fa-solid fa-display','standee','#eab308','Standees, frames & LED signs','Roll-up standees, acrylic frames, LED menu books and table-top displays.',NULL,5,1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(7,'Wedding & Invitations','wedding-invitations','fa-solid fa-heart','invite','#e11d48','Celebrate in style','Elegant wedding cards, invitations and greeting cards with foil and laser cut.',NULL,6,1,'2026-11-18 08:28:12','2026-11-18 08:28:12');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inquiries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'contact',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquiries`
--

/*!40000 ALTER TABLE `inquiries` DISABLE KEYS */;
/*!40000 ALTER TABLE `inquiries` ENABLE KEYS */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_11_18_000001_create_categories_table',1),(5,'2026_11_18_000002_create_orders_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` json DEFAULT NULL,
  `quantity` int unsigned NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `design_charge` decimal(12,2) NOT NULL DEFAULT '0.00',
  `design_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upload',
  `design_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,2,'Gold Foil Premium Visiting Card','{\"Printing Side\": \"Single Side\"}',500,2900.00,0.00,'upload','designs/HkjQ7xVcoRKQv52teHmfhdmvRIjnYaHoButT0Dwj.pdf','2026-11-18 08:42:14','2026-11-18 08:42:14'),(3,3,10,'Tri-Fold Brochure','{\"Lamination\": \"Gloss\"}',500,4500.00,0.00,'upload',NULL,'2026-11-18 08:56:59','2026-11-18 08:56:59'),(4,3,8,'A5 Flyer - 130 GSM','{\"Printing Side\": \"Single Side\"}',1000,1800.00,0.00,'upload',NULL,'2026-11-18 08:56:59','2026-11-18 08:56:59'),(5,4,8,'A5 Flyer - 130 GSM','{\"Printing Side\": \"Single Side\"}',1000,1800.00,0.00,'upload',NULL,'2026-11-18 09:06:20','2026-11-18 09:06:20'),(6,5,26,'Royal Wedding Card','[]',100,4500.00,0.00,'upload',NULL,'2026-11-18 09:08:16','2026-11-18 09:08:16'),(8,7,26,'Royal Wedding Card','[]',100,4500.00,0.00,'upload',NULL,'2026-11-18 09:15:59','2026-11-18 09:15:59');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `subtotal` decimal(12,2) NOT NULL,
  `design_charges` decimal(12,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(12,2) NOT NULL DEFAULT '0.00',
  `gst` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'razorpay',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `razorpay_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_razorpay_order_id_index` (`razorpay_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'PO2611181985','Zachery Brooks','piricik@mailinator.com','9897845898','Bates and Fowler Co','225','Non beatae est eum','Et nobis qui pariatu','Gujarat','362514','Laborum natus aperia',2900.00,0.00,0.00,522.00,3422.00,'razorpay','pending','pending',NULL,NULL,NULL,NULL,'2026-11-18 08:42:14','2026-11-18 08:42:14'),(3,'PO2611189182','Winifred Preston','bepezo@mailinator.com','9876543234','Jacobson and Hays Inc','530','Magni eos quis deser','Quia ut magna et qui','West Bengal','342345','Occaecat quos a quis',6300.00,0.00,0.00,1134.00,7434.00,'razorpay','pending','pending',NULL,NULL,NULL,NULL,'2026-11-18 08:56:59','2026-11-18 08:56:59'),(4,'PO2611184925','Audra Montoya','zata@mailinator.com','9638527412','Bailey and Gill Traders','881','Et molestiae odit ea','Vel aut minima Nam N','West Bengal','354678','Consequatur maiores',1800.00,0.00,0.00,324.00,2124.00,'razorpay','pending','pending',NULL,NULL,NULL,NULL,'2026-11-18 09:06:20','2026-11-18 09:06:20'),(5,'PO2611185539','Howard Mitchell','wawyna@mailinator.com','9876564568','Bailey and Rosario Associates','180','Aspernatur sit veri','Magnam anim totam se','Delhi','363456','Nisi libero magni ne',4500.00,0.00,0.00,810.00,5310.00,'razorpay','pending','pending','order_U1frYGNH8p9hqx',NULL,NULL,NULL,'2026-11-18 09:08:16','2026-11-18 09:12:28'),(7,'PO2611183548','Yael Wolf','kycuvyfim@mailinator.com','9685748596','Orr Hull Associates','693','Quod fugit nemo mod','Enim molestiae tenet','Delhi','362514','Voluptatem In proid',4500.00,0.00,0.00,810.00,5310.00,'razorpay','paid','confirmed','order_U1fySgNRuWXBv7','pay_U1fyqnG0kAldf1','a7b49ea9bb962b9d5d347c75340c64189ddf5ed1bd55985d65d8b63a45237352','2026-11-18 09:16:45','2026-11-18 09:15:59','2026-11-18 09:16:45');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `specifications` text COLLATE utf8mb4_unicode_ci,
  `art` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'card',
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6d28d9',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_tiers` json NOT NULL,
  `options` json DEFAULT NULL,
  `mrp_per_unit` decimal(10,2) DEFAULT NULL,
  `design_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dispatch_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3-4 Days',
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `is_bestseller` tinyint(1) NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `views` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Velvet UV Visiting Card','velvet-uv-visiting-card','350 GSM Matt Art Paper • Velvet lamination with spot UV','350 GSM Matt Art Paper\nVelvet lamination with spot UV\nRich soft-touch feel\nPremium quality cutting','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','card','#7f1d1d',NULL,'[{\"qty\": 500, \"price\": 1500}, {\"qty\": 1000, \"price\": 2500}]','[{\"name\": \"Printing Side\", \"values\": [{\"add\": 0, \"label\": \"Single Side\"}, {\"add\": 1, \"label\": \"Both Side\"}]}]',4.00,149.00,'6-7 Days',0,0,1,1,1,75,'2026-11-18 08:28:12','2026-11-18 08:58:40'),(2,1,'Gold Foil Premium Visiting Card','gold-foil-premium-visiting-card','800 GSM thick board • Real gold foil stamping','800 GSM thick board\nReal gold foil stamping\nDie-cut shapes available\nLuxury finish','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','card','#1c1917',NULL,'[{\"qty\": 250, \"price\": 1800}, {\"qty\": 500, \"price\": 2900}, {\"qty\": 1000, \"price\": 4800}]','[{\"name\": \"Printing Side\", \"values\": [{\"add\": 0, \"label\": \"Single Side\"}, {\"add\": 2, \"label\": \"Both Side\"}]}]',9.00,149.00,'7-8 Days',1,0,0,1,1,597,'2026-11-18 08:28:12','2026-11-18 08:41:14'),(3,1,'Matt Lamination Visiting Card','matt-lamination-visiting-card','350 GSM Art Card • Matt lamination both side','350 GSM Art Card\nMatt lamination both side\nStandard size 90 x 53 mm\nFast delivery','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','card','#1e3a8a',NULL,'[{\"qty\": 500, \"price\": 650}, {\"qty\": 1000, \"price\": 990}, {\"qty\": 2000, \"price\": 1800}]','[{\"name\": \"Printing Side\", \"values\": [{\"add\": 0, \"label\": \"Single Side\"}, {\"add\": 0.4, \"label\": \"Both Side\"}]}]',2.00,149.00,'3-4 Days',0,1,0,0,1,649,'2026-11-18 08:28:12','2026-11-18 09:10:39'),(4,1,'Gloss UV Coated Visiting Card','gloss-uv-coated-visiting-card','300 GSM Art Card • High gloss UV coating','300 GSM Art Card\nHigh gloss UV coating\nVibrant colours\nMost affordable','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','card','#0f766e',NULL,'[{\"qty\": 1000, \"price\": 450}, {\"qty\": 2000, \"price\": 850}, {\"qty\": 5000, \"price\": 2000}]','[{\"name\": \"Printing Side\", \"values\": [{\"add\": 0, \"label\": \"Single Side\"}, {\"add\": 0.2, \"label\": \"Both Side\"}]}]',1.00,149.00,'2-3 Days',0,1,1,0,1,360,'2026-11-18 08:28:12','2026-11-18 08:46:37'),(5,1,'Metal Visiting Card - Gold','metal-visiting-card-gold','Stainless steel metal card • Laser engraved text','Stainless steel metal card\nLaser engraved text\nGold colour finish\nLifetime durability','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','card','#a16207',NULL,'[{\"qty\": 50, \"price\": 3500}, {\"qty\": 100, \"price\": 6000}]',NULL,90.00,149.00,'8-10 Days',1,0,0,0,1,47,'2026-11-18 08:28:12','2026-11-18 08:48:10'),(6,1,'Non-Tearable PVC Visiting Card','non-tearable-pvc-visiting-card','Waterproof synthetic sheet • Non tearable','Waterproof synthetic sheet\nNon tearable\nGlossy lamination\nLong lasting','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','card','#4338ca',NULL,'[{\"qty\": 500, \"price\": 1100}, {\"qty\": 1000, \"price\": 1900}]','[{\"name\": \"Printing Side\", \"values\": [{\"add\": 0, \"label\": \"Single Side\"}, {\"add\": 0.6, \"label\": \"Both Side\"}]}]',3.00,149.00,'4-5 Days',0,0,0,0,1,526,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(7,1,'Texture 350 GSM Visiting Card','texture-350-gsm-visiting-card','Textured premium sheet • Elegant feel','Textured premium sheet\nElegant feel\nGloss coated\nCorporate look','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','card','#be185d',NULL,'[{\"qty\": 500, \"price\": 900}, {\"qty\": 1000, \"price\": 1500}]','[{\"name\": \"Printing Side\", \"values\": [{\"add\": 0, \"label\": \"Single Side\"}, {\"add\": 0.5, \"label\": \"Both Side\"}]}]',NULL,149.00,'4-5 Days',0,0,0,1,1,71,'2026-11-18 08:28:12','2026-11-18 08:38:05'),(8,2,'A5 Flyer - 130 GSM','a5-flyer-130-gsm','Size 5.8 x 8.3 inch (A5) • 130 GSM Art Paper','Size 5.8 x 8.3 inch (A5)\n130 GSM Art Paper\nFull colour printing\nPerfect for promotions','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','flyer','#db2777',NULL,'[{\"qty\": 1000, \"price\": 1800}, {\"qty\": 2000, \"price\": 3200}, {\"qty\": 5000, \"price\": 7000}]','[{\"name\": \"Printing Side\", \"values\": [{\"add\": 0, \"label\": \"Single Side\"}, {\"add\": 0.7, \"label\": \"Both Side\"}]}]',3.00,149.00,'3-4 Days',0,1,0,1,1,198,'2026-11-18 08:28:12','2026-11-18 09:05:57'),(9,2,'A4 Flyer - 90 GSM','a4-flyer-90-gsm','Size 8.3 x 11.7 inch (A4) • 90 GSM Maplitho','Size 8.3 x 11.7 inch (A4)\n90 GSM Maplitho\nBudget friendly\nBulk distribution','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','flyer','#9333ea',NULL,'[{\"qty\": 1000, \"price\": 2400}, {\"qty\": 3000, \"price\": 6300}, {\"qty\": 5000, \"price\": 9500}]','[{\"name\": \"Printing Side\", \"values\": [{\"add\": 0, \"label\": \"Single Side\"}, {\"add\": 0.8, \"label\": \"Both Side\"}]}]',NULL,149.00,'3-4 Days',0,0,1,0,1,238,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(10,2,'Tri-Fold Brochure','tri-fold-brochure','A4 open size, 3 panels • 170 GSM Art Paper','A4 open size, 3 panels\n170 GSM Art Paper\nCrease & fold included\nCorporate presentations','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','brochure','#c026d3',NULL,'[{\"qty\": 500, \"price\": 4500}, {\"qty\": 1000, \"price\": 7500}]','[{\"name\": \"Lamination\", \"values\": [{\"add\": 0, \"label\": \"Gloss\"}, {\"add\": 0, \"label\": \"Matt\"}, {\"add\": 0.5, \"label\": \"Velvet\"}]}]',12.00,149.00,'5-6 Days',1,0,0,0,1,423,'2026-11-18 08:28:12','2026-11-18 08:55:47'),(11,2,'Pamphlet - Single Colour','pamphlet-single-colour','Single colour printing • 70 GSM Paper','Single colour printing\n70 GSM Paper\nEconomical\nNewspaper inserts','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','flyer','#475569',NULL,'[{\"qty\": 2000, \"price\": 1600}, {\"qty\": 5000, \"price\": 3500}]',NULL,NULL,149.00,'2-3 Days',0,0,0,0,1,246,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(12,3,'Star Flex Banner (per sq.ft)','star-flex-banner-per-sqft','Star flex material • Solvent printing','Star flex material\nSolvent printing\nOutdoor weather resistant\nPrice per square foot','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','banner','#ea580c',NULL,'[{\"qty\": 10, \"price\": 180}, {\"qty\": 50, \"price\": 800}, {\"qty\": 100, \"price\": 1500}]','[{\"name\": \"Eyelets\", \"values\": [{\"add\": 0, \"label\": \"Without Eyelets\"}, {\"add\": 2, \"label\": \"With Eyelets\"}]}]',22.00,0.00,'1-2 Days',0,1,1,0,1,199,'2026-11-18 08:28:12','2026-11-18 08:53:26'),(13,3,'Backlit Flex (per sq.ft)','backlit-flex-per-sqft','Backlit flex material • Glow sign boards','Backlit flex material\nGlow sign boards\nEco-solvent print\nRich colours','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','banner','#0284c7',NULL,'[{\"qty\": 10, \"price\": 450}, {\"qty\": 50, \"price\": 2100}]',NULL,60.00,0.00,'2-3 Days',1,0,0,0,1,133,'2026-11-18 08:28:12','2026-11-18 08:46:43'),(14,3,'Roll-Up Standee - Aluminium','roll-up-standee-aluminium','Size 2.5 x 6 feet • Aluminium stand with bag','Size 2.5 x 6 feet\nAluminium stand with bag\nPrinted star flex\nEasy to carry','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','standee','#f59e0b',NULL,'[{\"qty\": 1, \"price\": 1600}, {\"qty\": 2, \"price\": 3000}, {\"qty\": 5, \"price\": 7000}]',NULL,3200.00,0.00,'2-3 Days',0,0,1,1,1,57,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(15,3,'Vinyl Sticker Print (per sq.ft)','vinyl-sticker-print-per-sqft','Solvent vinyl • Glossy or matt','Solvent vinyl\nGlossy or matt\nWall & glass application\nPrice per square foot','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','banner','#16a34a',NULL,'[{\"qty\": 10, \"price\": 400}, {\"qty\": 50, \"price\": 1800}]',NULL,80.00,0.00,'1-2 Days',0,0,0,0,1,483,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(16,4,'Letterhead - 100 GSM','letterhead-100-gsm','A4 size • 100 GSM Bond / Maplitho','A4 size\n100 GSM Bond / Maplitho\nFull colour printing\nProfessional look','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','letterhead','#0369a1',NULL,'[{\"qty\": 500, \"price\": 1800}, {\"qty\": 1000, \"price\": 2900}]',NULL,5.00,149.00,'4-5 Days',0,1,0,1,1,336,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(17,4,'Envelope 9 x 4 - 70 GSM','envelope-9-x-4-70-gsm','9 x 4 inch envelope • 70 GSM paper','9 x 4 inch envelope\n70 GSM paper\nCompany branding\nOffice use','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','envelope','#0891b2',NULL,'[{\"qty\": 500, \"price\": 1500}, {\"qty\": 1000, \"price\": 2500}]',NULL,NULL,149.00,'4-5 Days',0,0,1,0,1,643,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(18,4,'Bill Book (Duplicate)','bill-book-duplicate','50 sets per book • Carbonless NCR paper','50 sets per book\nCarbonless NCR paper\nSerial numbering\nA5 size','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','billbook','#1d4ed8',NULL,'[{\"qty\": 5, \"price\": 1100}, {\"qty\": 10, \"price\": 2000}, {\"qty\": 20, \"price\": 3600}]','[{\"name\": \"Copies\", \"values\": [{\"add\": 0, \"label\": \"Duplicate\"}, {\"add\": 60, \"label\": \"Triplicate\"}]}]',300.00,149.00,'3-4 Days',0,1,0,0,1,199,'2026-11-18 08:28:12','2026-11-18 08:49:15'),(19,4,'ID Card with Lanyard','id-card-with-lanyard','PVC ID card • Both side printing','PVC ID card\nBoth side printing\nPrinted lanyard & holder\nSchools & offices','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','idcard','#2563eb',NULL,'[{\"qty\": 10, \"price\": 900}, {\"qty\": 50, \"price\": 3800}]',NULL,120.00,149.00,'3-4 Days',1,0,0,0,1,289,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(20,5,'Round Sticker - PVC','round-sticker-pvc','PVC non tearable • Round die-cut','PVC non tearable\nRound die-cut\nGloss finish\nProduct labelling','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','sticker','#16a34a',NULL,'[{\"qty\": 500, \"price\": 700}, {\"qty\": 1000, \"price\": 1200}]',NULL,2.00,149.00,'3-4 Days',0,0,1,0,1,237,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(21,5,'Transparent Label Sticker','transparent-label-sticker','Transparent vinyl • Kiss cut','Transparent vinyl\nKiss cut\nWaterproof\nBottles & jars','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','sticker','#059669',NULL,'[{\"qty\": 500, \"price\": 1100}, {\"qty\": 1000, \"price\": 1900}]',NULL,NULL,149.00,'4-5 Days',1,0,0,0,1,478,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(22,5,'Custom Car Stickers','custom-car-stickers','Car body vinyl • UV resistant','Car body vinyl\nUV resistant\nAny shape\nEasy to apply','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','sticker','#dc2626',NULL,'[{\"qty\": 2, \"price\": 600}, {\"qty\": 5, \"price\": 1400}]',NULL,450.00,149.00,'2-3 Days',0,0,0,1,1,533,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(23,6,'Acrylic Display Frame A4','acrylic-display-frame-a4','Clear acrylic frame • A4 297 x 210 mm','Clear acrylic frame\nA4 297 x 210 mm\nTable top / wall\nUV print available','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','frame','#ca8a04',NULL,'[{\"qty\": 1, \"price\": 450}, {\"qty\": 5, \"price\": 2000}]',NULL,700.00,149.00,'3-4 Days',1,0,0,1,1,86,'2026-11-18 08:28:12','2026-11-18 08:38:47'),(24,6,'LED Menu Book A4','led-menu-book-a4','LED backlit menu • A4 size 2 pages','LED backlit menu\nA4 size 2 pages\nRechargeable\nRestaurants & cafes','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','frame','#7c2d12',NULL,'[{\"qty\": 1, \"price\": 2500}, {\"qty\": 2, \"price\": 4700}]',NULL,3000.00,149.00,'6-7 Days',1,0,0,0,1,332,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(25,6,'Table Top Card Stand A5','table-top-card-stand-a5','Acrylic L-shape stand • A5 148 x 210 mm','Acrylic L-shape stand\nA5 148 x 210 mm\nReception counters\nInsert print included','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','frame','#b45309',NULL,'[{\"qty\": 1, \"price\": 220}, {\"qty\": 10, \"price\": 1900}]',NULL,350.00,149.00,'2-3 Days',0,0,1,0,1,304,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(26,7,'Royal Wedding Card','royal-wedding-card','Premium hard card • Gold foil + embossing','Premium hard card\nGold foil + embossing\nWith envelope\nCustom design included','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','invite','#9f1239',NULL,'[{\"qty\": 100, \"price\": 4500}, {\"qty\": 300, \"price\": 12000}, {\"qty\": 500, \"price\": 18500}]',NULL,60.00,0.00,'8-10 Days',0,1,0,1,1,619,'2026-11-18 08:28:12','2026-11-18 09:10:50'),(27,7,'Laser Cut Invitation','laser-cut-invitation','Intricate laser cut • Shimmer sheet','Intricate laser cut\nShimmer sheet\nRibbon finishing\nLuxury feel','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','invite','#be123c',NULL,'[{\"qty\": 100, \"price\": 5500}, {\"qty\": 300, \"price\": 15000}]',NULL,70.00,0.00,'10-12 Days',1,0,0,0,1,503,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(28,7,'Greeting & Diwali Card','greeting-diwali-card','Festive designs • 300 GSM card','Festive designs\n300 GSM card\nFoil highlights\nCorporate gifting','Full Design Size (incl. bleed) : 3 mm extra on each side\nSafe text area : 3 mm inside cut line\nAccepted files : PDF, CDR, AI, PSD, JPG, PNG\nColour mode : CMYK, 300 DPI','invite','#c2410c',NULL,'[{\"qty\": 100, \"price\": 2200}, {\"qty\": 500, \"price\": 9000}]',NULL,NULL,0.00,'5-6 Days',0,0,1,0,1,322,'2026-11-18 08:28:12','2026-11-18 08:28:12');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(2,1,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(3,1,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(4,2,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(5,3,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(6,3,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(7,4,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(8,5,'Rahul Mehta',5,'Excellent print quality and colours came out exactly like the design. Delivered on time!',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(9,5,'Priya Shah',5,'Very professional team, they even helped fix my design for free. Highly recommended.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(10,5,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(11,6,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(12,6,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(13,7,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(14,8,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(15,8,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(16,8,'Vishal Rathod',4,'Nice work, WhatsApp support was quick to respond.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(17,9,'Rahul Mehta',5,'Excellent print quality and colours came out exactly like the design. Delivered on time!',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(18,10,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(19,10,'Vishal Rathod',4,'Nice work, WhatsApp support was quick to respond.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(20,11,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(21,11,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(22,12,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(23,13,'Priya Shah',5,'Very professional team, they even helped fix my design for free. Highly recommended.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(24,13,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(25,14,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(26,14,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(27,14,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(28,15,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(29,15,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(30,15,'Vishal Rathod',4,'Nice work, WhatsApp support was quick to respond.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(31,16,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(32,16,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(33,17,'Priya Shah',5,'Very professional team, they even helped fix my design for free. Highly recommended.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(34,17,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(35,17,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(36,18,'Rahul Mehta',5,'Excellent print quality and colours came out exactly like the design. Delivered on time!',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(37,18,'Priya Shah',5,'Very professional team, they even helped fix my design for free. Highly recommended.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(38,19,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(39,19,'Vishal Rathod',4,'Nice work, WhatsApp support was quick to respond.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(40,19,'Sneha Trivedi',5,'Best printing service in town. Smooth online payment too.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(41,20,'Rahul Mehta',5,'Excellent print quality and colours came out exactly like the design. Delivered on time!',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(42,20,'Priya Shah',5,'Very professional team, they even helped fix my design for free. Highly recommended.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(43,21,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(44,21,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(45,21,'Vishal Rathod',4,'Nice work, WhatsApp support was quick to respond.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(46,22,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(47,23,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(48,23,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(49,24,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(50,24,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(51,24,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(52,25,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(53,25,'Neha Joshi',5,'Fast delivery and the finishing is premium. Value for money.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(54,25,'Vishal Rathod',4,'Nice work, WhatsApp support was quick to respond.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(55,26,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(56,27,'Priya Shah',5,'Very professional team, they even helped fix my design for free. Highly recommended.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(57,27,'Kiran Desai',4,'Good quality and fair pricing. Packaging was neat and safe.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(58,27,'Amit Patel',5,'Ordered for my shop, customers loved the finish. Will order again.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(59,28,'Rahul Mehta',5,'Excellent print quality and colours came out exactly like the design. Delivered on time!',1,'2026-11-18 08:28:12','2026-11-18 08:28:12'),(60,28,'Priya Shah',5,'Very professional team, they even helped fix my design for free. Highly recommended.',1,'2026-11-18 08:28:12','2026-11-18 08:28:12');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscribers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribers`
--

/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@pateloffset.com',NULL,'$2y$12$zjlq4JmclHFAiya.cNixTuqc/JxpSRvMuZbjYz8vXKOJuoYkRA6JW',1,NULL,'2026-11-18 08:28:12','2026-11-18 08:28:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: localhost    Database: pateloffset
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
