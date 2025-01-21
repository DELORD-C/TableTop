/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.20-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: database.internal    Database: main
-- ------------------------------------------------------
-- Server version	11.0.6-MariaDB-deb12-log

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_64C19C19EEA759` (`inventory_id`),
  CONSTRAINT `FK_64C19C19EEA759` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Divers',1),(2,'Pièces détachées',1),(3,'Consomables',1),(4,'Miguel',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20250110065908','2025-01-10 06:59:17',2251),('DoctrineMigrations\\Version20250114094342','2025-01-14 09:47:48',640);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notes` longtext DEFAULT NULL,
  `map` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `ambiance` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (1,'\"Je m\'appelle Sin, Juste Sin\"\r\n\r\nOn a buté un mec lors de la réunion des 3 cultistes sur la plage. Gelé comme un mister freeze. La quête pour retrouver la sœur et le pote de kaël reste en suspend.','map-6780cced6cebc.jpg','JDR','jdr','chill');
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B12D4A36E48FD905` (`game_id`),
  CONSTRAINT `FK_B12D4A36E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (1,188,1);
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F1B251E12469DE2` (`category_id`),
  CONSTRAINT `FK_1F1B251E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (1,1,'Fourchette usée',NULL,1),(9,1,'Pierre de mana',NULL,1),(10,1,'Cristaux d\'arcane corrompu ',NULL,1),(11,1,'Bûche avec des runes',NULL,1),(12,1,'Cristaux d\'arcane ',NULL,4),(13,1,'Poison de scarabée de feu',NULL,4),(14,1,'Livre de connaissance d\'ingénierie draconique',NULL,1),(15,1,'Medaillon de Faye',NULL,4),(16,16,'Ration',NULL,1);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `music`
--

DROP TABLE IF EXISTS `music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `music` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `list` int(11) NOT NULL,
  `played` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `music`
--

LOCK TABLES `music` WRITE;
/*!40000 ALTER TABLE `music` DISABLE KEYS */;
INSERT INTO `music` VALUES (1,'You-Know-Nothing.mp3',0,NULL),(2,'Yes-I-Do.mp3',0,NULL),(3,'Winterfell.mp3',0,NULL),(4,'Wind-Guide-You.mp3',0,NULL),(5,'What-If-Main-Theme-Epic-Version.mp3',0,NULL),(6,'Under-an-Ancient-Sun.mp3',0,NULL),(7,'Unbound.mp3',0,NULL),(8,'Two-Vows-Here-Tonight.mp3',0,NULL),(9,'The-White-River.mp3',0,NULL),(10,'The-Vagabond.mp3',0,NULL),(11,'The-Unassuming-Happy-Docks-Tiny-Tina-s-Assault-on-Dragon-Keep.mp3',0,NULL),(12,'The-Tree-When-We-Sat-Once.mp3',0,NULL),(13,'The-Streets-of-Whiterun.mp3',0,NULL),(14,'The-Journey-to-the-Grey-Havens-feat-Sir-James-Galway.mp3',0,NULL),(15,'The-Hunter-s-Path.mp3',0,NULL),(16,'The-Great-Cleansing.mp3',0,NULL),(17,'The-Gathering-Storm.mp3',0,NULL),(18,'The-City-Gates.mp3',0,NULL),(19,'Tavern-At-The-End-Of-World.mp3',0,NULL),(20,'Standing-Stones.mp3',0,NULL),(21,'Spikeroog.mp3',0,NULL),(22,'Solitude.mp3',0,NULL),(23,'Skyrim-Atmospheres.mp3',0,NULL),(24,'Sky-Above-Voice-Within.mp3',0,NULL),(25,'Silent-Footsteps.mp3',0,NULL),(26,'Secunda.mp3',0,NULL),(27,'Round-of-Applause.mp3',0,NULL),(28,'River-Of-Life.mp3',0,NULL),(29,'Peaceful-Moments.mp3',0,NULL),(30,'Mother-Of-Dragons.mp3',0,NULL),(31,'Masser.mp3',0,NULL),(32,'Mannavegr.mp3',0,NULL),(33,'Late-Wee-Pups-Don-t-Get-to-Bark.mp3',0,NULL),(34,'Kyne-s-Peace.mp3',0,NULL),(35,'Kill-Them-All.mp3',0,NULL),(36,'Kaer-Morhen.mp3',0,NULL),(37,'Journey-s-End.mp3',0,NULL),(38,'I-Name-Thee-Dea-And-Embrace-Thee-As-My-Daughter.mp3',0,NULL),(39,'Imperial-Throne.mp3',0,NULL),(40,'I-Am-Hers-She-Is-Mine.mp3',0,NULL),(41,'Heir-to-Winterfell.mp3',0,NULL),(42,'Goodbye-Illyana.mp3',0,NULL),(43,'Goodbye-Brother.mp3',0,NULL),(44,'Frostfall.mp3',0,NULL),(45,'From-Past-to-Present.mp3',0,NULL),(46,'For-the-Realm.mp3',0,NULL),(47,'Folkvangr.mp3',0,NULL),(48,'Flotsam-At-Sunrise.mp3',0,NULL),(49,'Far-Horizons.mp3',0,NULL),(50,'Evenstar.mp3',0,NULL),(51,'Elmshore.mp3',0,NULL),(52,'Dusk-Of-A-Northern-Kingdom.mp3',0,NULL),(53,'Do-You-Remember.mp3',0,NULL),(54,'Distant-Horizons.mp3',0,NULL),(55,'Defiance-Bay.mp3',0,NULL),(56,'Dawn.mp3',0,NULL),(57,'Back-On-The-Path.mp3',0,NULL),(58,'A-Winter-s-Tale.mp3',0,NULL),(59,'Awake.mp3',0,NULL),(60,'Aurora.mp3',0,NULL),(61,'A-Nearly-Peaceful-Place.mp3',0,NULL),(62,'Ancient-Stones.mp3',0,NULL),(63,'Warcraft.mp3',2,NULL),(64,'Unwilling-Violence.mp3',2,NULL),(65,'This-Little-Pig-Went-To-Market.mp3',2,NULL),(66,'The-Men-After-Me.mp3',2,NULL),(67,'The-Hunt-Is-Coming.mp3',2,NULL),(68,'The-Dweller.mp3',2,NULL),(69,'The-Brotherhood-Escapes.mp3',2,NULL),(70,'The-Battle-of-Kerak.mp3',2,NULL),(71,'Struggle-and-Strife.mp3',2,NULL),(72,'Spartan-Fight.mp3',2,NULL),(73,'Shift-Change.mp3',2,NULL),(74,'Orb-Of-Destruction.mp3',2,NULL),(75,'On-Thin-Ice.mp3',2,NULL),(76,'On-the-Battlefield.mp3',2,NULL),(77,'No-Surrender.mp3',2,NULL),(78,'North-Sea-Storm.mp3',2,NULL),(79,'New-Foe.mp3',2,NULL),(80,'Nemesis.mp3',2,NULL),(81,'Lawgiver.mp3',2,NULL),(82,'Hunt-for-the-Great-Scar-Bear.mp3',2,NULL),(83,'Verdadeira-Arte.mp3',1,NULL),(84,'Transmissao.mp3',1,NULL),(85,'Title.mp3',1,NULL),(87,'The-Upside-Down.mp3',1,NULL),(88,'The-Unveiling.mp3',1,NULL),(89,'The-Obsession.mp3',1,NULL),(90,'The-Cycle-of-Violence.mp3',1,NULL),(91,'Temporarily-Virtual.mp3',1,NULL),(92,'Tampala.mp3',1,NULL),(93,'Spiralis.mp3',1,NULL),(94,'Smugglers.mp3',1,NULL),(95,'Salvation-Is-Coming.mp3',1,NULL),(96,'Running-as-a-Pack.mp3',1,NULL),(97,'Potestatem.mp3',1,NULL),(98,'Parasita.mp3',1,NULL),(99,'Ordem.mp3',1,NULL),(100,'On-the-Edge.mp3',1,NULL),(101,'No-Weapons.mp3',1,NULL),(102,'Negan.mp3',1,NULL);
/*!40000 ALTER TABLE `music` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pin`
--

DROP TABLE IF EXISTS `pin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `x` double NOT NULL,
  `y` double NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `team` tinyint(1) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B5852DF3E48FD905` (`game_id`),
  CONSTRAINT `FK_B5852DF3E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pin`
--

LOCK TABLES `pin` WRITE;
/*!40000 ALTER TABLE `pin` DISABLE KEYS */;
INSERT INTO `pin` VALUES (1,51.254089422028,49.099836333879,'Valdrakken','Capitale des Iles aux dragons',0,'green',1),(20,46.346782988004,76.759410801964,'Tour d\'Azure',NULL,0,'blue',1),(21,58.12101910828,24.731182795699,'Temple de l\'aube',NULL,0,'orange',1),(22,55.573248407643,18.757467144564,'Village côtier',NULL,0,'white',1);
/*!40000 ALTER TABLE `pin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `race` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `pvm` int(11) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  `pcm` int(11) DEFAULT NULL,
  `pc` int(11) DEFAULT NULL,
  `pmm` int(11) DEFAULT NULL,
  `pm` int(11) DEFAULT NULL,
  `pd` int(11) DEFAULT NULL,
  `lvl` int(11) DEFAULT NULL,
  `lore` longtext DEFAULT NULL,
  `activ` longtext DEFAULT NULL,
  `passiv` longtext DEFAULT NULL,
  `dmg_dice` varchar(255) DEFAULT NULL,
  `dmg_fixed` int(11) DEFAULT NULL,
  `intel` int(11) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `social` int(11) DEFAULT NULL,
  `perception` int(11) DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `is_fighting` tinyint(1) NOT NULL,
  `is_playing` tinyint(1) NOT NULL,
  `game_id` int(11) NOT NULL,
  `token_id` int(11) DEFAULT NULL,
  `spec` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `temp` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_98197A65F85E0677` (`username`),
  KEY `IDX_98197A65E48FD905` (`game_id`),
  KEY `IDX_98197A6541DEE7B9` (`token_id`),
  CONSTRAINT `FK_98197A6541DEE7B9` FOREIGN KEY (`token_id`) REFERENCES `token` (`id`),
  CONSTRAINT `FK_98197A65E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player`
--

LOCK TABLES `player` WRITE;
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` VALUES (1,'Zulgard','[\"ROLE_MJ\"]','$2y$13$vv12xDm/zC.0QdrpXE4OAu2XDOP0.U4VqTpwvH4UZO0xV.QPXir8O',NULL,NULL,NULL,10,10,1,1,0,0,1,1,NULL,NULL,NULL,'1',0,10,10,10,10,10,0,0,1,NULL,NULL,NULL,NULL),(4,'Marco','[]','$2y$13$SHYF/oSa1yq6L2uk9uHUJuYh3RkkSwX3K2A/vjjOHfnSIw4HcwRBO','Belgin','Mechagnome','Chasseur',10,17,1,1,0,0,1,1,NULL,NULL,NULL,'1',0,50,20,50,50,50,1,0,1,17,NULL,NULL,NULL),(5,'Sin','[]','$2y$13$0iypc0gUMFgMWzF2b67e7.DqVRHYyVtlnQKGjOlDQPqoPayFHUhaW','Juste','Dranei','Paladin',10,10,1,1,0,0,1,1,NULL,NULL,NULL,'1',0,10,10,10,10,30,1,1,1,18,NULL,NULL,NULL),(6,'Miguel','[]','$2y$13$yAJNhs2Hn0WVY27ilO4m/.Jj1bsiJ/dw2FmJJW9yPK95Ad/SrkdAG','Tulio','Humain','Voleur',17,19,5,3,2,1,1,1,NULL,'Riposte Vicieuse: 1 fois/jour; j.Physique; 0PM;  Esquive un coup et contre-attaque (attaque de base)\r\n\r\nEviscération: 1PM; 1D6+2/COMBO Dgts; Consomme tout les points de combo\r\n\r\nInvisibilité:1PM','Combo: gagne 1 point de combo/attaque réussie (cumul max=5)\r\n\r\nRédemption: +20 au jet de resistance et liberaton de contrôle\r\n\r\nGoût du risque: échec non critique=>+5% échec critique; Réussite critique=>+5% reussite critique','1',0,30,50,40,80,10,1,0,1,16,NULL,NULL,NULL),(7,'Meulan','[]','$2y$13$b9DbUXZdz1TLSC792auGLeuHzaMTF6lsHBQgklhokCakrLRZzG2Pm','Racine Cornue','Tauren','Druide',10,10,1,1,0,0,1,1,NULL,NULL,NULL,'1',0,10,10,10,10,40,1,0,1,19,NULL,NULL,NULL);
/*!40000 ALTER TABLE `player` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pnj`
--

DROP TABLE IF EXISTS `pnj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pnj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pvm` int(11) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `dmg_dice` varchar(255) DEFAULT NULL,
  `dmg_fixed` int(11) DEFAULT NULL,
  `is_fighting` tinyint(1) NOT NULL,
  `is_playing` tinyint(1) NOT NULL,
  `hit` int(11) DEFAULT NULL,
  `game_id` int(11) NOT NULL,
  `token_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FDA97F2DE48FD905` (`game_id`),
  KEY `IDX_FDA97F2D41DEE7B9` (`token_id`),
  CONSTRAINT `FK_FDA97F2D41DEE7B9` FOREIGN KEY (`token_id`) REFERENCES `token` (`id`),
  CONSTRAINT `FK_FDA97F2DE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pnj`
--

LOCK TABLES `pnj` WRITE;
/*!40000 ALTER TABLE `pnj` DISABLE KEYS */;
INSERT INTO `pnj` VALUES (1,10,10,NULL,30,'Monstre','1',0,0,0,50,1,5),(2,20,20,NULL,50,'Monstre (boss)','1',0,0,0,50,1,4),(3,10,9,NULL,30,'Scarabé','1',0,0,0,50,1,11),(4,10,9,NULL,30,'Scarabé-bis','1',0,0,0,50,1,11),(5,10,9,NULL,30,'Scarabé-bis-bis','1',0,0,0,50,1,11),(6,10,10,NULL,30,'Scarabé-bis-bis-bis','1',0,0,0,50,1,11),(7,10,10,NULL,30,'Scarabé-bis-bis-bis-bis','1',0,0,0,50,1,11),(8,10,10,NULL,30,'Scarabé-bis-bis-bis-bis-bis','1',0,0,0,50,1,11);
/*!40000 ALTER TABLE `pnj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sound`
--

DROP TABLE IF EXISTS `sound`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sound` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F88EC384E48FD905` (`game_id`),
  CONSTRAINT `FK_F88EC384E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sound`
--

LOCK TABLES `sound` WRITE;
/*!40000 ALTER TABLE `sound` DISABLE KEYS */;
INSERT INTO `sound` VALUES (1,'victory.mp3','hand-peace',1),(2,'levelup.mp3','arrow-up',1),(3,'fireball.mp3','fire',1),(4,'critical.mp3','dice-six',1),(5,'critical-failure.mp3','dice-one',1);
/*!40000 ALTER TABLE `sound` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` VALUES (1,'Défaut','default.png'),(2,'Gobelin','goblin.png'),(3,'Lizard','lizard-6780cce59eed4.png'),(4,'Ch\'tulu','ch-tulu-6780cd0ddf1cc.png'),(5,'Ork','ork-6780cd162210c.png'),(6,'Skeleton','skeleton-6780cd2100646.png'),(9,'Dwarf','dwarf-6780cdb3f20d5.png'),(10,'Hunter','hunter-6780cdbf11589.png'),(11,'Scarab','scarab-6782c4d7720fb.png'),(12,'Draenei','draenei-6782c5d91ee9b.png'),(13,'Rogue','rogue-6782c5e3dd8d8.png'),(14,'Gnome','gnome-6782c5ee2b531.png'),(15,'Tauren','tauren-6782c5fbf1416.png'),(16,'Miguel','Miguel-678332e77b656.png'),(17,'Marco','Marco-678332f45996f.png'),(18,'Sin','Sin-67833301c5c87.png'),(19,'Meulan','Meulan-6783330fe3a81.png');
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-21  5:41:19
