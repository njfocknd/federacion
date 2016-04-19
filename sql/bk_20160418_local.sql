-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: localhost    Database: federacion
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `audittrail`
--

DROP TABLE IF EXISTS `audittrail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audittrail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `script` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `user` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `table` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `field` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `keyvalue` longtext COLLATE utf8_spanish_ci,
  `oldvalue` longtext COLLATE utf8_spanish_ci,
  `newvalue` longtext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audittrail`
--

LOCK TABLES `audittrail` WRITE;
/*!40000 ALTER TABLE `audittrail` DISABLE KEYS */;
INSERT INTO `audittrail` VALUES (1,'2016-04-14 22:39:53','/federacion/app/login.php','admin','Ingreso','::1','','','',''),(2,'2016-04-19 01:21:21','/federacion/app/login.php','admin','Ingreso','::1','','','',''),(3,'2016-04-19 02:53:52','/federacion/app/federacionadd.php','Administrador','A','federacion','nombre','1','','FEDERACIÓN NACIONAL DE AJEDREZ'),(4,'2016-04-19 02:53:52','/federacion/app/federacionadd.php','Administrador','A','federacion','nomenclatura','1','','TEDEFE-FEDE-AJE'),(5,'2016-04-19 02:53:52','/federacion/app/federacionadd.php','Administrador','A','federacion','idfederacion_tipo','1','','1'),(6,'2016-04-19 02:53:52','/federacion/app/federacionadd.php','Administrador','A','federacion','iddeporte','1','','1'),(7,'2016-04-19 02:53:52','/federacion/app/federacionadd.php','Administrador','A','federacion','idfederacion','1','','1'),(8,'2016-04-19 02:54:24','/federacion/app/puesto_tipoadd.php','Administrador','A','puesto_tipo','nombre','1','','Presidente'),(9,'2016-04-19 02:54:24','/federacion/app/puesto_tipoadd.php','Administrador','A','puesto_tipo','idpuesto_tipo','1','','1'),(10,'2016-04-19 02:56:33','/federacion/app/personaadd.php','Administrador','A','persona','cui','1','','1997 46869 0101'),(11,'2016-04-19 02:56:33','/federacion/app/personaadd.php','Administrador','A','persona','nombre','1','','MARCOS EFRAÍN'),(12,'2016-04-19 02:56:33','/federacion/app/personaadd.php','Administrador','A','persona','apellido','1','','LOPEZ GARCÍA'),(13,'2016-04-19 02:56:33','/federacion/app/personaadd.php','Administrador','A','persona','direccion','1','','10 AVENIDA \"A\", 25-01, ZONA 5, CIUDAD'),(14,'2016-04-19 02:56:33','/federacion/app/personaadd.php','Administrador','A','persona','telefonos','1','','4601 6364'),(15,'2016-04-19 02:56:33','/federacion/app/personaadd.php','Administrador','A','persona','idpersona','1','','1'),(16,'2016-04-19 03:00:56','/federacion/app/puestoadd.php','Administrador','A','puesto','idpuesto_tipo','1','','1'),(17,'2016-04-19 03:00:56','/federacion/app/puestoadd.php','Administrador','A','puesto','idpersona','1','','1'),(18,'2016-04-19 03:00:56','/federacion/app/puestoadd.php','Administrador','A','puesto','idfederacion','1','','1'),(19,'2016-04-19 03:00:56','/federacion/app/puestoadd.php','Administrador','A','puesto','idorgano','1','','1'),(20,'2016-04-19 03:00:56','/federacion/app/puestoadd.php','Administrador','A','puesto','fecha_inicio','1','','2016-04-18'),(21,'2016-04-19 03:00:56','/federacion/app/puestoadd.php','Administrador','A','puesto','fecha_fin','1','','2016-04-18'),(22,'2016-04-19 03:00:56','/federacion/app/puestoadd.php','Administrador','A','puesto','status','1','','Electo'),(23,'2016-04-19 03:00:56','/federacion/app/puestoadd.php','Administrador','A','puesto','idpuesto','1','','1'),(24,'2016-04-19 03:13:03','/federacion/app/personaedit.php','Administrador','U','persona','fotografia','1',NULL,'avatar-Goku.png'),(25,'2016-04-19 04:46:31','/federacion/app/personaedit.php','Administrador','U','persona','fotografia','1','avatar-Goku.png','X2_xdash.jpg'),(26,'2016-04-19 04:46:56','/federacion/app/personaedit.php','Administrador','U','persona','fotografia','1','X2_xdash.jpg','avatar-Goku(1).png'),(27,'2016-04-19 04:52:44','/federacion/app/personaedit.php','Administrador','U','persona','fotografia','1','avatar-Goku(1).png','X2_xdash(1).jpg');
/*!40000 ALTER TABLE `audittrail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `siglas` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idpais` int(11) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`iddepartamento`),
  KEY `fk_departamento_idpais_idx` (`idpais`),
  CONSTRAINT `fk_departamento_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (1,'GUATEMALA','GT',1,'Activo','2016-04-14 16:12:46'),(2,'EL PROGRESO','ELP',1,'Activo','2016-04-14 16:12:46'),(3,'SACATEPEQUEZ','SACAT',1,'Activo','2016-04-14 16:12:46'),(4,'CHIMALTENANGO','CHM',1,'Activo','2016-04-14 16:12:46'),(5,'ESCUINTLA','ESC',1,'Activo','2016-04-14 16:12:46'),(6,'SANTA ROSA','SR',1,'Activo','2016-04-14 16:12:46'),(7,'SOLOLA','SOL',1,'Activo','2016-04-14 16:12:46'),(8,'TOTONICAPAN','TOT',1,'Activo','2016-04-14 16:12:46'),(9,'QUETZALTENANGO','QUET',1,'Activo','2016-04-14 16:12:46'),(10,'SUCHITEPEQUEZ','SUCH',1,'Activo','2016-04-14 16:12:46'),(11,'RETALHULEU','RETAL',1,'Activo','2016-04-14 16:12:46'),(12,'SAN MARCOS','SM',1,'Activo','2016-04-14 16:12:46'),(13,'HUEHUETENANGO','HUE',1,'Activo','2016-04-14 16:12:46'),(14,'QUICHE','QUIC',1,'Activo','2016-04-14 16:12:46'),(15,'BAJA VERAPAZ','BV',1,'Activo','2016-04-14 16:12:46'),(16,'ALTA VERAPAZ','AV',1,'Activo','2016-04-14 16:12:46'),(17,'PETEN','PET',1,'Activo','2016-04-14 16:12:46'),(18,'IZABAL','IZA',1,'Activo','2016-04-14 16:12:46'),(19,'ZACAPA','ZAC',1,'Activo','2016-04-14 16:12:46'),(20,'CHIQUIMULA','CHQ',1,'Activo','2016-04-14 16:12:46'),(21,'JALAPA','JAL',1,'Activo','2016-04-14 16:12:46'),(22,'JUTIAPA','JUT',1,'Activo','2016-04-14 16:12:46');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`departamento_BEFORE_INSERT` BEFORE INSERT ON `departamento` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `deporte`
--

DROP TABLE IF EXISTS `deporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deporte` (
  `iddeporte` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `siglas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `alias` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`iddeporte`),
  UNIQUE KEY `siglas_UNIQUE` (`siglas`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deporte`
--

LOCK TABLES `deporte` WRITE;
/*!40000 ALTER TABLE `deporte` DISABLE KEYS */;
INSERT INTO `deporte` VALUES (1,'AJEDREZ','AJE','AJEDREZ','Activo','2016-04-14 15:28:37'),(2,'ANDINISMO','ANDI','ANDINISMO','Activo','2016-04-14 15:28:37'),(3,'ATLETISMO','ATLE','ATLETISMO','Activo','2016-04-14 15:28:37'),(4,'BÁDMINTON','BAD','BÁDMINTON','Activo','2016-04-14 15:28:37'),(5,'BALONCESTO','BALONC','BALONCESTO','Activo','2016-04-14 15:28:38'),(6,'BALONMANO','BALONM','BALONMANO','Activo','2016-04-14 15:28:38'),(7,'BÉISBOL','BEI','BÉISBOL','Activo','2016-04-14 15:28:38'),(8,'BOLICHE','BOLI','BOLICHE','Activo','2016-04-14 15:28:38'),(9,'BOXEO','BOX','BOXEO','Activo','2016-04-14 15:28:38'),(10,'CICLISMO','CICLI','CICLISMO','Activo','2016-04-14 15:28:38'),(11,'ESGRIMA','ESG','ESGRIMA','Activo','2016-04-14 15:28:38'),(12,'FISICOCULTURISMO','FISI','FISICOCULTURISMO','Activo','2016-04-14 15:28:39'),(13,'FÚTBOL','FUT','FÚTBOL','Activo','2016-04-14 15:28:39'),(14,'GIMNASIA','GIM','GIMNASIA','Activo','2016-04-14 15:28:39'),(15,'JUDO','JUD','JUDO','Activo','2016-04-14 15:28:39'),(16,'KARATE DO','KART','KARATE DO','Activo','2016-04-14 15:28:39'),(17,'LEVANTAMIENTO DE PESAS','LEVPE','LEVANTAMIENTO DE PESAS','Activo','2016-04-14 15:28:39'),(18,'LEVANTAMIENTO DE POTENCIA','LEVPO','LEVANTAMIENTO DE POTENCIA','Activo','2016-04-14 15:28:39'),(19,'LUCHAS','LUCH','LUCHAS','Activo','2016-04-14 15:28:39'),(20,'MOTOCICLISMO','MOTO','MOTOCICLISMO','Activo','2016-04-14 15:28:39'),(21,'NATACIÓN','NATA','NATACIÓN','Activo','2016-04-14 15:28:40'),(22,'PATINAJE SOBRE RUEDAS','PATI','PATINAJE SOBRE RUEDAS','Activo','2016-04-14 15:28:40'),(23,'REMO Y CANOTAJE','REMO','REMO Y CANOTAJE','Activo','2016-04-14 15:28:40'),(24,'TAEKWON DO','TAEK','TAEKWON DO','Activo','2016-04-14 15:28:40'),(25,'TENIS DE CAMPO','TENIC','TENIS DE CAMPO','Activo','2016-04-14 15:28:40'),(26,'TENIS DE MESA','TENIM','TENIS DE MESA','Activo','2016-04-14 15:28:40'),(27,'TIRO','TIRO','TIRO','Activo','2016-04-14 15:28:40'),(28,'TRIATLÓN, DUATLÓN Y AQUATLÓN','TRIA','TRIATLÓN, DUATLÓN Y AQUATLÓN','Activo','2016-04-14 15:28:40'),(29,'VOLEIBOL','VOLE','VOLEIBOL','Activo','2016-04-14 15:28:40'),(30,'BILLAR','BILL','BILLAR','Activo','2016-04-14 15:28:40'),(31,'ECUESTRES','ECUE','ECUESTRES','Activo','2016-04-14 15:28:41'),(32,'GOLF','GOLF','GOLF','Activo','2016-04-14 15:28:41'),(33,'NAVEGACIÓN A VELA','NAVE','NAVEGACIÓN A VELA','Activo','2016-04-14 15:28:41'),(34,'PARACAIDISMO','PARA','PARACAIDISMO','Activo','2016-04-14 15:28:41'),(35,'PENTATLÓN MODERNO','PENTA','PENTATLÓN MODERNO','Activo','2016-04-14 15:28:41'),(36,'PESCA DEPORTIVA','PESCA','PESCA DEPORTIVA','Activo','2016-04-14 15:28:41'),(37,'POLO','POLO','POLO','Activo','2016-04-14 15:28:41'),(38,'RAQUETBOL','RAQUE','RAQUETBOL','Activo','2016-04-14 15:28:41'),(39,'SOFTBOL','SOFT','SOFTBOL','Activo','2016-04-14 15:28:41'),(40,'SQUASH','SQUA','SQUASH','Activo','2016-04-14 15:28:41'),(41,'SURF','SURF','SURF','Activo','2016-04-14 15:28:42'),(42,'TIRO CON ARCO','TIRA','TIRO CON ARCO','Activo','2016-04-14 15:28:42'),(43,'TIRO CON ARMA DE CAZA','TIROC','TIRO CON ARMA DE CAZA','Activo','2016-04-14 15:28:42'),(44,'VUELO LIBRE','VUELO','VUELO LIBRE','Activo','2016-04-14 15:28:42'),(45,'FRONTÓN','FRONT','FRONTÓN','Activo','2016-04-14 15:28:42'),(46,'BRIDGE','BRID','BRIDGE','Activo','2016-04-14 15:28:42'),(47,'KENDO','KEND','KENDO','Activo','2016-04-14 15:28:42'),(48,'RUGBY','RUG','RUGBY','Activo','2016-04-14 15:28:42'),(49,'HOCKEY','HOCK','HOCKEY','Activo','2016-04-14 15:28:42');
/*!40000 ALTER TABLE `deporte` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`deporte_BEFORE_INSERT` BEFORE INSERT ON `deporte` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`deporte_BEFORE_UPDATE` BEFORE UPDATE ON `deporte` FOR EACH ROW
BEGIN
	if old.fecha_insercion != new.fecha_insercion then
		set new.fecha_insercion = old.fecha_insercion;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `federacion`
--

DROP TABLE IF EXISTS `federacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `federacion` (
  `idfederacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nomenclatura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idfederacion_tipo` int(11) NOT NULL,
  `iddeporte` int(11) NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idfederacion`),
  KEY `fk_federacion_idfederacion_tipo_idx` (`idfederacion_tipo`),
  KEY `fk_federacion_iddeporte_idx` (`iddeporte`),
  CONSTRAINT `fk_federacion_idfederacion_tipo` FOREIGN KEY (`idfederacion_tipo`) REFERENCES `federacion_tipo` (`idfederacion_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_federacion_iddeporte` FOREIGN KEY (`iddeporte`) REFERENCES `deporte` (`iddeporte`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `federacion`
--

LOCK TABLES `federacion` WRITE;
/*!40000 ALTER TABLE `federacion` DISABLE KEYS */;
INSERT INTO `federacion` VALUES (1,'FEDERACIÓN NACIONAL DE AJEDREZ','TEDEFE-FEDE-AJE',1,1,'Activo','2016-04-18 20:53:52');
/*!40000 ALTER TABLE `federacion` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`federacion_BEFORE_INSERT` BEFORE INSERT ON `federacion` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`federacion_BEFORE_UPDATE` BEFORE UPDATE ON `federacion` FOR EACH ROW
BEGIN
	if old.fecha_insercion != new.fecha_insercion then
		set new.fecha_insercion = old.fecha_insercion;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `federacion_tipo`
--

DROP TABLE IF EXISTS `federacion_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `federacion_tipo` (
  `idfederacion_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `siglas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idfederacion_tipo`),
  UNIQUE KEY `siglas_UNIQUE` (`siglas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `federacion_tipo`
--

LOCK TABLES `federacion_tipo` WRITE;
/*!40000 ALTER TABLE `federacion_tipo` DISABLE KEYS */;
INSERT INTO `federacion_tipo` VALUES (1,'FEDERACIÓN','FEDE','Activo','2016-04-14 14:59:47'),(2,'ASOCIACIÓN','ASO','Activo','2016-04-14 14:59:53'),(3,'ASOCIACIÓN DEPARTAMENTAL','ASODEPT','Activo','2016-04-14 15:00:03'),(4,'ASOCIACIÓN MUNICIPAL','ASOMUNI','Activo','2016-04-14 15:00:08');
/*!40000 ALTER TABLE `federacion_tipo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`federacion_tipo_BEFORE_INSERT` BEFORE INSERT ON `federacion_tipo` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`federacion_tipo_BEFORE_UPDATE` BEFORE UPDATE ON `federacion_tipo` FOR EACH ROW
BEGIN
	if old.fecha_insercion != new.fecha_insercion then
		set new.fecha_insercion = old.fecha_insercion;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `municipio`
--

DROP TABLE IF EXISTS `municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `municipio` (
  `idmunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `siglas` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `iddepartamento` int(11) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idmunicipio`),
  KEY `fk_municipio_iddepartamento_idx` (`iddepartamento`),
  CONSTRAINT `fk_municipio_iddepartamento` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=341 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipio`
--

LOCK TABLES `municipio` WRITE;
/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
INSERT INTO `municipio` VALUES (1,'GUATEMALA','GUATEMALA',1,'Activo','0000-00-00 00:00:00'),(2,'SANTA CATARINA PINULA','SANTA CATARINA PINULA',1,'Activo','0000-00-00 00:00:00'),(3,'SAN JOSE PINULA','SAN JOSE PINULA',1,'Activo','0000-00-00 00:00:00'),(4,'SAN JOSE DEL GOLFO','SAN JOSE DEL GOLFO',1,'Activo','0000-00-00 00:00:00'),(5,'PALENCIA','PALENCIA',1,'Activo','0000-00-00 00:00:00'),(6,'CHINAUTLA','CHINAUTLA',1,'Activo','0000-00-00 00:00:00'),(7,'SAN PEDRO AYAMPUC','SAN PEDRO AYAMPUC',1,'Activo','0000-00-00 00:00:00'),(8,'MIXCO','MIXCO',1,'Activo','0000-00-00 00:00:00'),(9,'SAN PEDRO SACATEPEQUEZ','SAN PEDRO SACATEPEQUEZ',1,'Activo','0000-00-00 00:00:00'),(10,'SAN JUAN SACATEPEQUEZ','SAN JUAN SACATEPEQUEZ',1,'Activo','0000-00-00 00:00:00'),(11,'SAN RAYMUNDO','SAN RAYMUNDO',1,'Activo','0000-00-00 00:00:00'),(12,'CHUARRANCHO','CHUARRANCHO',1,'Activo','0000-00-00 00:00:00'),(13,'FRAIJANES','FRAIJANES',1,'Activo','0000-00-00 00:00:00'),(14,'AMATITLAN','AMATITLAN',1,'Activo','0000-00-00 00:00:00'),(15,'VILLA NUEVA','VILLA NUEVA',1,'Activo','0000-00-00 00:00:00'),(16,'VILLA CANALES','VILLA CANALES',1,'Activo','0000-00-00 00:00:00'),(17,'SAN MIGUEL PETAPA','SAN MIGUEL PETAPA',1,'Activo','0000-00-00 00:00:00'),(18,'ANTIGUA GUATEMALA','ANTIGUA GUATEMALA',3,'Activo','0000-00-00 00:00:00'),(19,'JOCOTENANGO','JOCOTENANGO',3,'Activo','0000-00-00 00:00:00'),(20,'PASTORES','PASTORES',3,'Activo','0000-00-00 00:00:00'),(21,'SUMPANGO','SUMPANGO',3,'Activo','0000-00-00 00:00:00'),(22,'SANTO DOMINGO XENACOJ','SANTO DOMINGO XENACOJ',3,'Activo','0000-00-00 00:00:00'),(23,'SANTIAGO SACATEPEQUEZ','SANTIAGO SACATEPEQUEZ',3,'Activo','0000-00-00 00:00:00'),(24,'SAN BARTOLOME MILPAS ALTAS','SAN BARTOLOME MILPAS ALTAS',3,'Activo','0000-00-00 00:00:00'),(25,'SAN LUCAS SACATEPEQUEZ','SAN LUCAS SACATEPEQUEZ',3,'Activo','0000-00-00 00:00:00'),(26,'SANTA LUCIA MILPAS ALTAS','SANTA LUCIA MILPAS ALTAS',3,'Activo','0000-00-00 00:00:00'),(27,'MAGDALENA MILPAS ALTAS','MAGDALENA MILPAS ALTAS',3,'Activo','0000-00-00 00:00:00'),(28,'SANTA MARIA DE JESUS','SANTA MARIA DE JESUS',3,'Activo','0000-00-00 00:00:00'),(29,'CIUDAD VIEJA','CIUDAD VIEJA',3,'Activo','0000-00-00 00:00:00'),(30,'SAN MIGUEL DUENAS','SAN MIGUEL DUENAS',3,'Activo','0000-00-00 00:00:00'),(31,'SAN JUAN ALOTENANGO','SAN JUAN ALOTENANGO',3,'Activo','0000-00-00 00:00:00'),(32,'SAN ANTONIO AGUAS CALIENTES','SAN ANTONIO AGUAS CALIENTES',3,'Activo','0000-00-00 00:00:00'),(33,'SANTA CATARINA BARAHONA','SANTA CATARINA BARAHONA',3,'Activo','0000-00-00 00:00:00'),(34,'CHIMALTENANGO','CHIMALTENANGO',4,'Activo','0000-00-00 00:00:00'),(35,'SAN JOSE POAQUIL','SAN JOSE POAQUIL',4,'Activo','0000-00-00 00:00:00'),(36,'SAN MARTIN JILOTEPEQUE','SAN MARTIN JILOTEPEQUE',4,'Activo','0000-00-00 00:00:00'),(37,'SAN JUAN COMALAPA','SAN JUAN COMALAPA',4,'Activo','0000-00-00 00:00:00'),(38,'SANTA APOLONIA','SANTA APOLONIA',4,'Activo','0000-00-00 00:00:00'),(39,'TECPAN GUATEMALA','TECPAN GUATEMALA',4,'Activo','0000-00-00 00:00:00'),(40,'PATZUN','PATZUN',4,'Activo','0000-00-00 00:00:00'),(41,'POCHUTA','POCHUTA',4,'Activo','0000-00-00 00:00:00'),(42,'PATZICIA','PATZICIA',4,'Activo','0000-00-00 00:00:00'),(43,'SANTA CRUZ BALANYA','SANTA CRUZ BALANYA',4,'Activo','0000-00-00 00:00:00'),(44,'ACATENANGO','ACATENANGO',4,'Activo','0000-00-00 00:00:00'),(45,'SAN PEDRO YEPOCAPA','SAN PEDRO YEPOCAPA',4,'Activo','0000-00-00 00:00:00'),(46,'SAN ANDRES ITZAPA','SAN ANDRES ITZAPA',4,'Activo','0000-00-00 00:00:00'),(47,'PARRAMOS','PARRAMOS',4,'Activo','0000-00-00 00:00:00'),(48,'ZARAGOZA','ZARAGOZA',4,'Activo','0000-00-00 00:00:00'),(49,'SAN MIGUEL EL TEJAR','SAN MIGUEL EL TEJAR',4,'Activo','0000-00-00 00:00:00'),(50,'GUASTATOYA','GUASTATOYA',2,'Activo','0000-00-00 00:00:00'),(51,'MORAZAN','MORAZAN',2,'Activo','0000-00-00 00:00:00'),(52,'SAN AGUSTIN ACASAGUASTLAN','SAN AGUSTIN ACASAGUASTLAN',2,'Activo','0000-00-00 00:00:00'),(53,'SAN CRISTOBAL ACASAGUASTLAN','SAN CRISTOBAL ACASAGUASTLAN',2,'Activo','0000-00-00 00:00:00'),(54,'EL JICARO','EL JICARO',2,'Activo','0000-00-00 00:00:00'),(55,'SANSARE','SANSARE',2,'Activo','0000-00-00 00:00:00'),(56,'SANARATE','SANARATE',2,'Activo','0000-00-00 00:00:00'),(57,'SAN ANTONIO LA PAZ','SAN ANTONIO LA PAZ',2,'Activo','0000-00-00 00:00:00'),(58,'ESCUINTLA','ESCUINTLA',5,'Activo','0000-00-00 00:00:00'),(59,'SANTA LUCIA COTZUMALGUAPA','SANTA LUCIA COTZUMALGUAPA',5,'Activo','0000-00-00 00:00:00'),(60,'LA DEMOCRACIA','LA DEMOCRACIA',5,'Activo','0000-00-00 00:00:00'),(61,'SIQUINALA','SIQUINALA',5,'Activo','0000-00-00 00:00:00'),(62,'MASAGUA','MASAGUA',5,'Activo','0000-00-00 00:00:00'),(63,'PUEBLO NUEVO TIQUISATE','PUEBLO NUEVO TIQUISATE',5,'Activo','0000-00-00 00:00:00'),(64,'LA GOMERA','LA GOMERA',5,'Activo','0000-00-00 00:00:00'),(65,'GUANAGAZAPA','GUANAGAZAPA',5,'Activo','0000-00-00 00:00:00'),(66,'PUERTO SAN JOSE','PUERTO SAN JOSE',5,'Activo','0000-00-00 00:00:00'),(67,'ITZAPA','ITZAPA',5,'Activo','0000-00-00 00:00:00'),(68,'PALIN','PALIN',5,'Activo','0000-00-00 00:00:00'),(69,'SAN VICENTE PACAYA','SAN VICENTE PACAYA',5,'Activo','0000-00-00 00:00:00'),(70,'NUEVA CONCEPCION','NUEVA CONCEPCION',5,'Activo','0000-00-00 00:00:00'),(71,'CUILAPA','CUILAPA',6,'Activo','0000-00-00 00:00:00'),(72,'BARBERENA','BARBERENA',6,'Activo','0000-00-00 00:00:00'),(73,'SANTA ROSA DE LIMA','SANTA ROSA DE LIMA',6,'Activo','0000-00-00 00:00:00'),(74,'CASILLAS','CASILLAS',6,'Activo','0000-00-00 00:00:00'),(75,'SAN RAFAEL LAS FLORES','SAN RAFAEL LAS FLORES',6,'Activo','0000-00-00 00:00:00'),(76,'EL ORATORIO','EL ORATORIO',6,'Activo','0000-00-00 00:00:00'),(77,'SAN JUAN TECUACO','SAN JUAN TECUACO',6,'Activo','0000-00-00 00:00:00'),(78,'CHIQUIMULILLA','CHIQUIMULILLA',6,'Activo','0000-00-00 00:00:00'),(79,'TAXISCO','TAXISCO',6,'Activo','0000-00-00 00:00:00'),(80,'SANTA MARIA IXHUATAN','SANTA MARIA IXHUATAN',6,'Activo','0000-00-00 00:00:00'),(81,'GUAZACAPAN','GUAZACAPAN',6,'Activo','0000-00-00 00:00:00'),(82,'SANTA CRUZ NARANJO','SANTA CRUZ NARANJO',6,'Activo','0000-00-00 00:00:00'),(83,'PUEBLO NUEVO VINAS','PUEBLO NUEVO VINAS',6,'Activo','0000-00-00 00:00:00'),(84,'NUEVA SANTA ROSA','NUEVA SANTA ROSA',6,'Activo','0000-00-00 00:00:00'),(85,'SOLOLA','SOLOLA',7,'Activo','0000-00-00 00:00:00'),(86,'SAN JOSE CHACAYA','SAN JOSE CHACAYA',7,'Activo','0000-00-00 00:00:00'),(87,'SANTA MARIA VISITACION','SANTA MARIA VISITACION',7,'Activo','0000-00-00 00:00:00'),(88,'SANTA LUCIA UTATLAN','SANTA LUCIA UTATLAN',7,'Activo','0000-00-00 00:00:00'),(89,'NAHUALA','NAHUALA',7,'Activo','0000-00-00 00:00:00'),(90,'SANTA CATARINA IXTAHUATAN','SANTA CATARINA IXTAHUATAN',7,'Activo','0000-00-00 00:00:00'),(91,'SANTA CLARA LAGUNA','SANTA CLARA LAGUNA',7,'Activo','0000-00-00 00:00:00'),(92,'CONCEPCION','CONCEPCION',7,'Activo','0000-00-00 00:00:00'),(93,'SAN ANDRES SEMETABAJ','SAN ANDRES SEMETABAJ',7,'Activo','0000-00-00 00:00:00'),(94,'PANAJACHEL','PANAJACHEL',7,'Activo','0000-00-00 00:00:00'),(95,'SANTA CATARINA PALOPO','SANTA CATARINA PALOPO',7,'Activo','0000-00-00 00:00:00'),(96,'SAN ANTONIO PALOPO','SAN ANTONIO PALOPO',7,'Activo','0000-00-00 00:00:00'),(97,'SAN LUCAS TOLIMAN','SAN LUCAS TOLIMAN',7,'Activo','0000-00-00 00:00:00'),(98,'SANTA CRUZ LA LAGUNA','SANTA CRUZ LA LAGUNA',7,'Activo','0000-00-00 00:00:00'),(99,'SAN PABLO LA LAGUNA','SAN PABLO LA LAGUNA',7,'Activo','0000-00-00 00:00:00'),(100,'SAN MARCOS LA LAGUNA','SAN MARCOS LA LAGUNA',7,'Activo','0000-00-00 00:00:00'),(101,'SAN JUAN LA LAGUNA','SAN JUAN LA LAGUNA',7,'Activo','0000-00-00 00:00:00'),(102,'SAN PEDRO LA LAGUNA','SAN PEDRO LA LAGUNA',7,'Activo','0000-00-00 00:00:00'),(103,'SANTIAGO ATITLAN','SANTIAGO ATITLAN',7,'Activo','0000-00-00 00:00:00'),(104,'TOTONICAPAN','TOTONICAPAN',8,'Activo','0000-00-00 00:00:00'),(105,'SAN CRISTOBAL TOTONICAPAN','SAN CRISTOBAL TOTONICAPAN',8,'Activo','0000-00-00 00:00:00'),(106,'SAN FRANCISCO EL ALTO','SAN FRANCISCO EL ALTO',8,'Activo','0000-00-00 00:00:00'),(107,'SAN ANDRES XECUL','SAN ANDRES XECUL',8,'Activo','0000-00-00 00:00:00'),(108,'MOMOSTENANGO','MOMOSTENANGO',8,'Activo','0000-00-00 00:00:00'),(109,'SANTA MARIA CHIQUIMULA','SANTA MARIA CHIQUIMULA',8,'Activo','0000-00-00 00:00:00'),(110,'SANTA LUCIA LA REFORMA','SANTA LUCIA LA REFORMA',8,'Activo','0000-00-00 00:00:00'),(111,'SAN BARTOLO','SAN BARTOLO',8,'Activo','0000-00-00 00:00:00'),(112,'QUETZALTENANGO','QUETZALTENANGO',9,'Activo','0000-00-00 00:00:00'),(113,'SALCAJA','SALCAJA',9,'Activo','0000-00-00 00:00:00'),(114,'OLINTEPEQUE','OLINTEPEQUE',9,'Activo','0000-00-00 00:00:00'),(115,'SAN CARLOS SIJA','SAN CARLOS SIJA',9,'Activo','0000-00-00 00:00:00'),(116,'SIBILIA','SIBILIA',9,'Activo','0000-00-00 00:00:00'),(117,'CABRICAN','CABRICAN',9,'Activo','0000-00-00 00:00:00'),(118,'CAJOLA','CAJOLA',9,'Activo','0000-00-00 00:00:00'),(119,'SAN MIGUEL SIGUILA','SAN MIGUEL SIGUILA',9,'Activo','0000-00-00 00:00:00'),(120,'SAN JUAN OSTUNCALCO','SAN JUAN OSTUNCALCO',9,'Activo','0000-00-00 00:00:00'),(121,'SAN MATEO','SAN MATEO',9,'Activo','0000-00-00 00:00:00'),(122,'CONCEPCION CHIQUIRICHAPA','CONCEPCION CHIQUIRICHAPA',9,'Activo','0000-00-00 00:00:00'),(123,'SAN MARTIN SACATEPEQUEZ','SAN MARTIN SACATEPEQUEZ',9,'Activo','0000-00-00 00:00:00'),(124,'ALMOLONGA','ALMOLONGA',9,'Activo','0000-00-00 00:00:00'),(125,'CANTEL','CANTEL',9,'Activo','0000-00-00 00:00:00'),(126,'HUITAN','HUITAN',9,'Activo','0000-00-00 00:00:00'),(127,'ZUNIL','ZUNIL',9,'Activo','0000-00-00 00:00:00'),(128,'COLOMBA','COLOMBA',9,'Activo','0000-00-00 00:00:00'),(129,'SAN FRANCISCO LA UNION','SAN FRANCISCO LA UNION',9,'Activo','0000-00-00 00:00:00'),(130,'EL PALMAR','EL PALMAR',9,'Activo','0000-00-00 00:00:00'),(131,'COATEPEQUE','COATEPEQUE',9,'Activo','0000-00-00 00:00:00'),(132,'GENOVA','GENOVA',9,'Activo','0000-00-00 00:00:00'),(133,'FLORES COSTA CUCA','FLORES COSTA CUCA',9,'Activo','0000-00-00 00:00:00'),(134,'LA ESPERANZA','LA ESPERANZA',9,'Activo','0000-00-00 00:00:00'),(135,'PALESTINA DE LOS ALTOS','PALESTINA DE LOS ALTOS',9,'Activo','0000-00-00 00:00:00'),(136,'MAZATENANGO','MAZATENANGO',10,'Activo','0000-00-00 00:00:00'),(137,'CUYOTENANGO','CUYOTENANGO',10,'Activo','0000-00-00 00:00:00'),(138,'SAN FRANCISCO ZAPOTITLAN','SAN FRANCISCO ZAPOTITLAN',10,'Activo','0000-00-00 00:00:00'),(139,'SAN BERNARDINO','SAN BERNARDINO',10,'Activo','0000-00-00 00:00:00'),(140,'SAN JOSE EL IDOLO','SAN JOSE EL IDOLO',10,'Activo','0000-00-00 00:00:00'),(141,'SANTO DOMINGO SUCHITEPEQUEZ','SANTO DOMINGO SUCHITEPEQUEZ',10,'Activo','0000-00-00 00:00:00'),(142,'SAN LORENZO','SAN LORENZO',10,'Activo','0000-00-00 00:00:00'),(143,'SAMAYAC','SAMAYAC',10,'Activo','0000-00-00 00:00:00'),(144,'SAN PABLO JOCOPILAS','SAN PABLO JOCOPILAS',10,'Activo','0000-00-00 00:00:00'),(145,'SAN ANTONIO SUCHITEPEQUEZ','SAN ANTONIO SUCHITEPEQUEZ',10,'Activo','0000-00-00 00:00:00'),(146,'SAN MIGUEL PANAN','SAN MIGUEL PANAN',10,'Activo','0000-00-00 00:00:00'),(147,'SAN GABRIEL','SAN GABRIEL',10,'Activo','0000-00-00 00:00:00'),(148,'CHICACAO','CHICACAO',10,'Activo','0000-00-00 00:00:00'),(149,'PATULUL','PATULUL',10,'Activo','0000-00-00 00:00:00'),(150,'SANTA BARBARA','SANTA BARBARA',10,'Activo','0000-00-00 00:00:00'),(151,'SAN JUAN BAUTISTA','SAN JUAN BAUTISTA',10,'Activo','0000-00-00 00:00:00'),(152,'SANTO TOMAS LA UNION','SANTO TOMAS LA UNION',10,'Activo','0000-00-00 00:00:00'),(153,'ZUNILITO','ZUNILITO',10,'Activo','0000-00-00 00:00:00'),(154,'PUEBLO NUEVO','PUEBLO NUEVO',10,'Activo','0000-00-00 00:00:00'),(155,'RIO BRAVO','RIO BRAVO',10,'Activo','0000-00-00 00:00:00'),(156,'RETALHULEU','RETALHULEU',11,'Activo','0000-00-00 00:00:00'),(157,'SAN SEBASTIAN','SAN SEBASTIAN',11,'Activo','0000-00-00 00:00:00'),(158,'SANTA CRUZ MULUA','SANTA CRUZ MULUA',11,'Activo','0000-00-00 00:00:00'),(159,'SAN MARTIN ZAPOTITLAN','SAN MARTIN ZAPOTITLAN',11,'Activo','0000-00-00 00:00:00'),(160,'SAN FELIPE REU','SAN FELIPE REU',11,'Activo','0000-00-00 00:00:00'),(161,'SAN ANDRES VILLA SECA','SAN ANDRES VILLA SECA',11,'Activo','0000-00-00 00:00:00'),(162,'CHAMPERICO','CHAMPERICO',11,'Activo','0000-00-00 00:00:00'),(163,'NUEVO SAN CARLOS','NUEVO SAN CARLOS',11,'Activo','0000-00-00 00:00:00'),(164,'EL ASINTAL','EL ASINTAL',11,'Activo','0000-00-00 00:00:00'),(165,'SAN MARCOS','SAN MARCOS',12,'Activo','0000-00-00 00:00:00'),(166,'SAN PEDRO SACATEPEQUEZ','SAN PEDRO SACATEPEQUEZ',12,'Activo','0000-00-00 00:00:00'),(167,'SAN ANTONIO SACATEPEQUEZ','SAN ANTONIO SACATEPEQUEZ',12,'Activo','0000-00-00 00:00:00'),(168,'COMINTACILLO','COMINTACILLO',12,'Activo','0000-00-00 00:00:00'),(169,'SAN MIGUEL IXTAHUACAN','SAN MIGUEL IXTAHUACAN',12,'Activo','0000-00-00 00:00:00'),(170,'CONCEPCION TUTUAPA','CONCEPCION TUTUAPA',12,'Activo','0000-00-00 00:00:00'),(171,'TACANA','TACANA',12,'Activo','0000-00-00 00:00:00'),(172,'SIBINAL','SIBINAL',12,'Activo','0000-00-00 00:00:00'),(173,'TAJUMULCO','TAJUMULCO',12,'Activo','0000-00-00 00:00:00'),(174,'TEJUTLA','TEJUTLA',12,'Activo','0000-00-00 00:00:00'),(175,'SAN RAFAEL PIE DE LA CUESTA','SAN RAFAEL PIE DE LA CUESTA',12,'Activo','0000-00-00 00:00:00'),(176,'NUEVO PROGRESO','NUEVO PROGRESO',12,'Activo','0000-00-00 00:00:00'),(177,'EL TUMBADOR','EL TUMBADOR',12,'Activo','0000-00-00 00:00:00'),(178,'SAN JOSE EL RODEO','SAN JOSE EL RODEO',12,'Activo','0000-00-00 00:00:00'),(179,'MALACATAN','MALACATAN',12,'Activo','0000-00-00 00:00:00'),(180,'CATARINA','CATARINA',12,'Activo','0000-00-00 00:00:00'),(181,'AYUTLA','AYUTLA',12,'Activo','0000-00-00 00:00:00'),(182,'OCOS','OCOS',12,'Activo','0000-00-00 00:00:00'),(183,'SAN PABLO','SAN PABLO',12,'Activo','0000-00-00 00:00:00'),(184,'EL QUETZAL','EL QUETZAL',12,'Activo','0000-00-00 00:00:00'),(185,'LA REFORMA','LA REFORMA',12,'Activo','0000-00-00 00:00:00'),(186,'PAJAPITA','PAJAPITA',12,'Activo','0000-00-00 00:00:00'),(187,'IXCHIGUAN','IXCHIGUAN',12,'Activo','0000-00-00 00:00:00'),(188,'SAN JOSE OJETENAM','SAN JOSE OJETENAM',12,'Activo','0000-00-00 00:00:00'),(189,'SAN CRISTOBAL CUCHO','SAN CRISTOBAL CUCHO',12,'Activo','0000-00-00 00:00:00'),(190,'SIPACAPA','SIPACAPA',12,'Activo','0000-00-00 00:00:00'),(191,'ESQUIPULAS PALO GORDO','ESQUIPULAS PALO GORDO',12,'Activo','0000-00-00 00:00:00'),(192,'RIO BLANCO','RIO BLANCO',12,'Activo','0000-00-00 00:00:00'),(193,'SAN LORENZO','SAN LORENZO',12,'Activo','0000-00-00 00:00:00'),(194,'HUEHUETENANGO','HUEHUETENANGO',13,'Activo','0000-00-00 00:00:00'),(195,'CHIANTLA','CHIANTLA',13,'Activo','0000-00-00 00:00:00'),(196,'MALACATANCITO','MALACATANCITO',13,'Activo','0000-00-00 00:00:00'),(197,'CUILCO','CUILCO',13,'Activo','0000-00-00 00:00:00'),(198,'NENTON','NENTON',13,'Activo','0000-00-00 00:00:00'),(199,'SAN PEDRO NECTA','SAN PEDRO NECTA',13,'Activo','0000-00-00 00:00:00'),(200,'JACALTENANGO','JACALTENANGO',13,'Activo','0000-00-00 00:00:00'),(201,'SAN PEDRO SOLOMA','SAN PEDRO SOLOMA',13,'Activo','0000-00-00 00:00:00'),(202,'SAN ILD. IXTAHUACAN','SAN ILD. IXTAHUACAN',13,'Activo','0000-00-00 00:00:00'),(203,'SANTA BARBARA','SANTA BARBARA',13,'Activo','0000-00-00 00:00:00'),(204,'LA LIBERTAD','LA LIBERTAD',13,'Activo','0000-00-00 00:00:00'),(205,'LA DEMOCRACIA','LA DEMOCRACIA',13,'Activo','0000-00-00 00:00:00'),(206,'SAN MIGUEL ACATAN','SAN MIGUEL ACATAN',13,'Activo','0000-00-00 00:00:00'),(207,'SAN RAFAEL INDEPENDENCIA','SAN RAFAEL INDEPENDENCIA',13,'Activo','0000-00-00 00:00:00'),(208,'TODOS SANTOS CUCHUMATANES','TODOS SANTOS CUCHUMATANES',13,'Activo','0000-00-00 00:00:00'),(209,'SAN JUAN ATITAN','SAN JUAN ATITAN',13,'Activo','0000-00-00 00:00:00'),(210,'SANTA EULALIA','SANTA EULALIA',13,'Activo','0000-00-00 00:00:00'),(211,'SAN MATEO IXTATAN','SAN MATEO IXTATAN',13,'Activo','0000-00-00 00:00:00'),(212,'COLOTENANGO','COLOTENANGO',13,'Activo','0000-00-00 00:00:00'),(213,'SAN SEBASTIAN HUEHUETENANGO','SAN SEBASTIAN HUEHUETENANGO',13,'Activo','0000-00-00 00:00:00'),(214,'TECTITAN','TECTITAN',13,'Activo','0000-00-00 00:00:00'),(215,'CONCEPCION HUISTA','CONCEPCION HUISTA',13,'Activo','0000-00-00 00:00:00'),(216,'SAN JUAN IXCOY','SAN JUAN IXCOY',13,'Activo','0000-00-00 00:00:00'),(217,'SAN ANTONIO HUISTA','SAN ANTONIO HUISTA',13,'Activo','0000-00-00 00:00:00'),(218,'SAN SEBASTIAN COATAN','SAN SEBASTIAN COATAN',13,'Activo','0000-00-00 00:00:00'),(219,'SANTA CRUZ BARILLAS','SANTA CRUZ BARILLAS',13,'Activo','0000-00-00 00:00:00'),(220,'AGUACATAN','AGUACATAN',13,'Activo','0000-00-00 00:00:00'),(221,'SAN RAFAEL PETZAL','SAN RAFAEL PETZAL',13,'Activo','0000-00-00 00:00:00'),(222,'SAN GASPAR IXCHIL','SAN GASPAR IXCHIL',13,'Activo','0000-00-00 00:00:00'),(223,'SANTIAGO CHIMALTENANGO','SANTIAGO CHIMALTENANGO',13,'Activo','0000-00-00 00:00:00'),(224,'SANTA ANA HUISTA','SANTA ANA HUISTA',13,'Activo','0000-00-00 00:00:00'),(225,'CANTINIL','CANTINIL',13,'Activo','0000-00-00 00:00:00'),(226,'SANTA CRUZ DEL QUICHE','SANTA CRUZ DEL QUICHE',14,'Activo','0000-00-00 00:00:00'),(227,'CHICHE','CHICHE',14,'Activo','0000-00-00 00:00:00'),(228,'CHINIQUE','CHINIQUE',14,'Activo','0000-00-00 00:00:00'),(229,'ZACUALPA','ZACUALPA',14,'Activo','0000-00-00 00:00:00'),(230,'CHAJUL','CHAJUL',14,'Activo','0000-00-00 00:00:00'),(231,'CHICHICASTENANGO','CHICHICASTENANGO',14,'Activo','0000-00-00 00:00:00'),(232,'PATZITE','PATZITE',14,'Activo','0000-00-00 00:00:00'),(233,'SAN ANTONIO ILOTENANGO','SAN ANTONIO ILOTENANGO',14,'Activo','0000-00-00 00:00:00'),(234,'SAN PEDRO JOCOPILAS','SAN PEDRO JOCOPILAS',14,'Activo','0000-00-00 00:00:00'),(235,'CUNEN','CUNEN',14,'Activo','0000-00-00 00:00:00'),(236,'SAN JUAN COTZAL','SAN JUAN COTZAL',14,'Activo','0000-00-00 00:00:00'),(237,'JOYABAJ','JOYABAJ',14,'Activo','0000-00-00 00:00:00'),(238,'NEBAJ','NEBAJ',14,'Activo','0000-00-00 00:00:00'),(239,'SAN ANDRES SAJCABAJA','SAN ANDRES SAJCABAJA',14,'Activo','0000-00-00 00:00:00'),(240,'USPANTAN','USPANTAN',14,'Activo','0000-00-00 00:00:00'),(241,'SACAPULAS','SACAPULAS',14,'Activo','0000-00-00 00:00:00'),(242,'SAN BARTOLOME JOCOTENANGO','SAN BARTOLOME JOCOTENANGO',14,'Activo','0000-00-00 00:00:00'),(243,'CANILLA','CANILLA',14,'Activo','0000-00-00 00:00:00'),(244,'CHICAMAN','CHICAMAN',14,'Activo','0000-00-00 00:00:00'),(245,'IXCAN PLAYA GRANDE','IXCAN PLAYA GRANDE',14,'Activo','0000-00-00 00:00:00'),(246,'PACHALUM','PACHALUM',14,'Activo','0000-00-00 00:00:00'),(247,'SALAMA','SALAMA',15,'Activo','0000-00-00 00:00:00'),(248,'SAN MIGUEL CHICAJ','SAN MIGUEL CHICAJ',15,'Activo','0000-00-00 00:00:00'),(249,'RABINAL','RABINAL',15,'Activo','0000-00-00 00:00:00'),(250,'CUBULCO','CUBULCO',15,'Activo','0000-00-00 00:00:00'),(251,'GRANADOS','GRANADOS',15,'Activo','0000-00-00 00:00:00'),(252,'EL CHOL','EL CHOL',15,'Activo','0000-00-00 00:00:00'),(253,'SAN JERONIMO','SAN JERONIMO',15,'Activo','0000-00-00 00:00:00'),(254,'PURULHA','PURULHA',15,'Activo','0000-00-00 00:00:00'),(255,'COBAN','COBAN',16,'Activo','0000-00-00 00:00:00'),(256,'SANTA CRUZ VERAPAZ','SANTA CRUZ VERAPAZ',16,'Activo','0000-00-00 00:00:00'),(257,'SAN CRISTOBAL VERAPAZ','SAN CRISTOBAL VERAPAZ',16,'Activo','0000-00-00 00:00:00'),(258,'TACTIC','TACTIC',16,'Activo','0000-00-00 00:00:00'),(259,'TAMAHU','TAMAHU',16,'Activo','0000-00-00 00:00:00'),(260,'SAN MIGUEL TUCURU','SAN MIGUEL TUCURU',16,'Activo','0000-00-00 00:00:00'),(261,'PANZOS','PANZOS',16,'Activo','0000-00-00 00:00:00'),(262,'SENAHU','SENAHU',16,'Activo','0000-00-00 00:00:00'),(263,'SAN PEDRO CARCHA','SAN PEDRO CARCHA',16,'Activo','0000-00-00 00:00:00'),(264,'SAN JUAN CHAMELCO','SAN JUAN CHAMELCO',16,'Activo','0000-00-00 00:00:00'),(265,'LANQUIN','LANQUIN',16,'Activo','0000-00-00 00:00:00'),(266,'SANTA MA. CAHABON','SANTA MA. CAHABON',16,'Activo','0000-00-00 00:00:00'),(267,'CHISEC','CHISEC',16,'Activo','0000-00-00 00:00:00'),(268,'CHAHAL','CHAHAL',16,'Activo','0000-00-00 00:00:00'),(269,'FRAYBARTOLOME DE LAS CASAS','FRAYBARTOLOME DE LAS CASAS',16,'Activo','0000-00-00 00:00:00'),(270,'SANTA CATALINA LA TINTA','SANTA CATALINA LA TINTA',16,'Activo','0000-00-00 00:00:00'),(271,'CIUDAD FLORES','CIUDAD FLORES',17,'Activo','0000-00-00 00:00:00'),(272,'SAN JOSE','SAN JOSE',17,'Activo','0000-00-00 00:00:00'),(273,'SAN BENITO','SAN BENITO',17,'Activo','0000-00-00 00:00:00'),(274,'SAN ANDRES','SAN ANDRES',17,'Activo','0000-00-00 00:00:00'),(275,'LA LIBERTAD','LA LIBERTAD',17,'Activo','0000-00-00 00:00:00'),(276,'SAN FRANCISCO','SAN FRANCISCO',17,'Activo','0000-00-00 00:00:00'),(277,'SANTA ANA','SANTA ANA',17,'Activo','0000-00-00 00:00:00'),(278,'DOLORES','DOLORES',17,'Activo','0000-00-00 00:00:00'),(279,'SAN LUIS','SAN LUIS',17,'Activo','0000-00-00 00:00:00'),(280,'SAYAXCHE','SAYAXCHE',17,'Activo','0000-00-00 00:00:00'),(281,'MELCHOR DE MENCOS','MELCHOR DE MENCOS',17,'Activo','0000-00-00 00:00:00'),(282,'POPTUN','POPTUN',17,'Activo','0000-00-00 00:00:00'),(283,'PUERTO BARRIOS','PUERTO BARRIOS',18,'Activo','0000-00-00 00:00:00'),(284,'LIVINGSTON','LIVINGSTON',18,'Activo','0000-00-00 00:00:00'),(285,'EL ESTOR','EL ESTOR',18,'Activo','0000-00-00 00:00:00'),(286,'MORALES','MORALES',18,'Activo','0000-00-00 00:00:00'),(287,'LOS AMATES','LOS AMATES',18,'Activo','0000-00-00 00:00:00'),(288,'ZACAPA','ZACAPA',19,'Activo','0000-00-00 00:00:00'),(289,'ESTANZUELA','ESTANZUELA',19,'Activo','0000-00-00 00:00:00'),(290,'RIO HONDO','RIO HONDO',19,'Activo','0000-00-00 00:00:00'),(291,'GUALAN','GUALAN',19,'Activo','0000-00-00 00:00:00'),(292,'TECULUTAN','TECULUTAN',19,'Activo','0000-00-00 00:00:00'),(293,'USUMATLAN','USUMATLAN',19,'Activo','0000-00-00 00:00:00'),(294,'CABANAS','CABANAS',19,'Activo','0000-00-00 00:00:00'),(295,'SAN DIEGO','SAN DIEGO',19,'Activo','0000-00-00 00:00:00'),(296,'LA UNION','LA UNION',19,'Activo','0000-00-00 00:00:00'),(297,'HUITE','HUITE',19,'Activo','0000-00-00 00:00:00'),(298,'CHIQUIMULA','CHIQUIMULA',20,'Activo','0000-00-00 00:00:00'),(299,'SAN JOSE LA ARADA','SAN JOSE LA ARADA',20,'Activo','0000-00-00 00:00:00'),(300,'SAN JUAN ERMITA','SAN JUAN ERMITA',20,'Activo','0000-00-00 00:00:00'),(301,'JOCOTAN','JOCOTAN',20,'Activo','0000-00-00 00:00:00'),(302,'CAMOTAN','CAMOTAN',20,'Activo','0000-00-00 00:00:00'),(303,'OLOPA','OLOPA',20,'Activo','0000-00-00 00:00:00'),(304,'ESQUIPULAS','ESQUIPULAS',20,'Activo','0000-00-00 00:00:00'),(305,'CONCEPCION LAS MINAS','CONCEPCION LAS MINAS',20,'Activo','0000-00-00 00:00:00'),(306,'QUETZALTEPEQUE','QUETZALTEPEQUE',20,'Activo','0000-00-00 00:00:00'),(307,'SAN JACINTO','SAN JACINTO',20,'Activo','0000-00-00 00:00:00'),(308,'IPALA','IPALA',20,'Activo','0000-00-00 00:00:00'),(309,'JALAPA','JALAPA',21,'Activo','0000-00-00 00:00:00'),(310,'SAN PEDRO PINULA','SAN PEDRO PINULA',21,'Activo','0000-00-00 00:00:00'),(311,'SAN LUIS JILOTEPEQUE','SAN LUIS JILOTEPEQUE',21,'Activo','0000-00-00 00:00:00'),(312,'SAN MANUEL CHAPARRON','SAN MANUEL CHAPARRON',21,'Activo','0000-00-00 00:00:00'),(313,'SAN CARLOS ALZATATE','SAN CARLOS ALZATATE',21,'Activo','0000-00-00 00:00:00'),(314,'MONJAS','MONJAS',21,'Activo','0000-00-00 00:00:00'),(315,'MATAQUESCUINTLA','MATAQUESCUINTLA',21,'Activo','0000-00-00 00:00:00'),(316,'JUTIAPA','JUTIAPA',22,'Activo','0000-00-00 00:00:00'),(317,'EL PROGRESO','EL PROGRESO',22,'Activo','0000-00-00 00:00:00'),(318,'SANTA CATARINA MITA','SANTA CATARINA MITA',22,'Activo','0000-00-00 00:00:00'),(319,'AGUA BLANCA','AGUA BLANCA',22,'Activo','0000-00-00 00:00:00'),(320,'ASUNCION MITA','ASUNCION MITA',22,'Activo','0000-00-00 00:00:00'),(321,'YUPILTEPEQUE','YUPILTEPEQUE',22,'Activo','0000-00-00 00:00:00'),(322,'ATESCATEMPA','ATESCATEMPA',22,'Activo','0000-00-00 00:00:00'),(323,'JEREZ','JEREZ',22,'Activo','0000-00-00 00:00:00'),(324,'EL ADELANTO','EL ADELANTO',22,'Activo','0000-00-00 00:00:00'),(325,'ZAPOTITLAN','ZAPOTITLAN',22,'Activo','0000-00-00 00:00:00'),(326,'COMAPA','COMAPA',22,'Activo','0000-00-00 00:00:00'),(327,'JALPATAGUA','JALPATAGUA',22,'Activo','0000-00-00 00:00:00'),(328,'CONGUACO','CONGUACO',22,'Activo','0000-00-00 00:00:00'),(329,'MOYUTA','MOYUTA',22,'Activo','0000-00-00 00:00:00'),(330,'PASACO','PASACO',22,'Activo','0000-00-00 00:00:00'),(331,'SAN JOSE ACATEMPA','SAN JOSE ACATEMPA',22,'Activo','0000-00-00 00:00:00'),(332,'QUEZADA','QUEZADA',22,'Activo','0000-00-00 00:00:00'),(333,'RAXUHA','RAXUHA',16,'Activo','0000-00-00 00:00:00'),(334,'EL CHAL','EL CHAL',17,'Activo','0000-00-00 00:00:00'),(335,'LAS CRUCES','LAS CRUCES',17,'Activo','0000-00-00 00:00:00'),(336,'SAN JORGE','SAN JORGE',19,'Activo','0000-00-00 00:00:00'),(337,'SAN JOSE LA MAQUINA','SAN JOSE LA MAQUINA',10,'Activo','0000-00-00 00:00:00'),(338,'SIPACATE','SIPACATE',5,'Activo','0000-00-00 00:00:00'),(339,'PETATÁN','PETATÁN',13,'Activo','0000-00-00 00:00:00'),(340,'LA BLANCA','LA BLANCA',12,'Activo','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `municipio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organo`
--

DROP TABLE IF EXISTS `organo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organo` (
  `idorgano` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `siglas` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idorgano`),
  UNIQUE KEY `siglas_UNIQUE` (`siglas`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organo`
--

LOCK TABLES `organo` WRITE;
/*!40000 ALTER TABLE `organo` DISABLE KEYS */;
INSERT INTO `organo` VALUES (1,'COMITÉ EJECUTIVO','CE','Activo','2016-04-14 15:22:06'),(2,'ÓRGANO DISCIPLINARIO','OD','Activo','2016-04-14 15:22:06'),(3,'COMISIÓN TÉCNICO DEPORTIVA','CTD','Activo','2016-04-14 15:22:06');
/*!40000 ALTER TABLE `organo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`organo_BEFORE_INSERT` BEFORE INSERT ON `organo` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`organo_BEFORE_UPDATE` BEFORE UPDATE ON `organo` FOR EACH ROW
BEGIN
	if old.fecha_insercion != new.fecha_insercion then
		set new.fecha_insercion = old.fecha_insercion;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `idpais` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `siglas` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `gentilicio_masculino` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `gentilicio_femenino` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idpais`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'Guatemala','GTM','Guatemalteco','Guatemalteca','Activo',NULL);
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de tabla',
  `cui` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Identificador Unico Personal (DPI)',
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `telefonos` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime NOT NULL,
  `fotografia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla para el control de personas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'1997 46869 0101','MARCOS EFRAÍN','LOPEZ GARCÍA','10 AVENIDA \"A\", 25-01, ZONA 5, CIUDAD','4601 6364','Activo','2016-04-18 20:56:33','X2_xdash(1).jpg');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`persona_BEFORE_INSERT` BEFORE INSERT ON `persona` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`persona_AFTER_INSERT` AFTER INSERT ON `persona` FOR EACH ROW
BEGIN
	if new.fotografia is not null then
		INSERT INTO persona_fotografia (idpersona, fotografia) VALUES (new.idpersona, new.fotografia );
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`persona_BEFORE_UPDATE` BEFORE UPDATE ON `persona` FOR EACH ROW
BEGIN
	if old.fecha_insercion != new.fecha_insercion then
		set new.fecha_insercion = old.fecha_insercion;
    end if;
    if old.fotografia != new.fotografia then
		if new.fotografia is not null then
			INSERT INTO persona_fotografia (idpersona, fotografia) VALUES (new.idpersona, new.fotografia );
		end if;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `persona_fotografia`
--

DROP TABLE IF EXISTS `persona_fotografia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona_fotografia` (
  `idpersona_fotografia` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL DEFAULT '1',
  `fotografia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_insercion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idpersona_fotografia`),
  KEY `fk_persona_fotografia_idx` (`idpersona`),
  CONSTRAINT `fk_persona_fotografia` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona_fotografia`
--

LOCK TABLES `persona_fotografia` WRITE;
/*!40000 ALTER TABLE `persona_fotografia` DISABLE KEYS */;
INSERT INTO `persona_fotografia` VALUES (1,1,'X2_xdash(1).jpg','2016-04-18 22:52:44','Activo');
/*!40000 ALTER TABLE `persona_fotografia` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`persona_fotografia_BEFORE_INSERT` BEFORE INSERT ON `persona_fotografia` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`persona_fotografia_BEFORE_UPDATE` BEFORE UPDATE ON `persona_fotografia` FOR EACH ROW
BEGIN
	if old.fecha_insercion != new.fecha_insercion then
		set new.fecha_insercion = old.fecha_insercion;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `puesto`
--

DROP TABLE IF EXISTS `puesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puesto` (
  `idpuesto` int(11) NOT NULL AUTO_INCREMENT,
  `idpuesto_tipo` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `idfederacion` int(11) NOT NULL,
  `idorgano` int(11) NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `status` enum('Electo','Ejerciendo') COLLATE latin1_spanish_ci NOT NULL DEFAULT 'Electo',
  `estado` enum('Activo','Inactivo') COLLATE latin1_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idpuesto`),
  KEY `fk_puesto_idpuesto_tipo_idx` (`idpuesto_tipo`),
  KEY `fk_puesto_idpersona_idx` (`idpersona`),
  KEY `fk_puesto_idfederacion_idx` (`idfederacion`),
  KEY `fk_puesto_idorgano_idx` (`idorgano`),
  CONSTRAINT `fk_puesto_idorgano` FOREIGN KEY (`idorgano`) REFERENCES `organo` (`idorgano`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_puesto_idfederacion` FOREIGN KEY (`idfederacion`) REFERENCES `federacion` (`idfederacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_puesto_idpersona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_puesto_idpuesto_tipo` FOREIGN KEY (`idpuesto_tipo`) REFERENCES `puesto_tipo` (`idpuesto_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='tabla para el control de puestos de una persona';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puesto`
--

LOCK TABLES `puesto` WRITE;
/*!40000 ALTER TABLE `puesto` DISABLE KEYS */;
INSERT INTO `puesto` VALUES (1,1,1,1,1,'2016-04-18 00:00:00','2016-04-18 00:00:00','Electo','Activo','2016-04-18 21:00:56');
/*!40000 ALTER TABLE `puesto` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`puesto_BEFORE_INSERT` BEFORE INSERT ON `puesto` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`puesto_BEFORE_UPDATE` BEFORE UPDATE ON `puesto` FOR EACH ROW
BEGIN
	if old.fecha_insercion != new.fecha_insercion then
		set new.fecha_insercion = old.fecha_insercion;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `puesto_tipo`
--

DROP TABLE IF EXISTS `puesto_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puesto_tipo` (
  `idpuesto_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idpuesto_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puesto_tipo`
--

LOCK TABLES `puesto_tipo` WRITE;
/*!40000 ALTER TABLE `puesto_tipo` DISABLE KEYS */;
INSERT INTO `puesto_tipo` VALUES (1,'Presidente','Activo','2016-04-18 20:54:24');
/*!40000 ALTER TABLE `puesto_tipo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`puesto_tipo_BEFORE_INSERT` BEFORE INSERT ON `puesto_tipo` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `federacion`.`puesto_tipo_BEFORE_UPDATE` BEFORE UPDATE ON `puesto_tipo` FOR EACH ROW
BEGIN
	if old.fecha_insercion != new.fecha_insercion then
		set new.fecha_insercion = old.fecha_insercion;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'federacion'
--

--
-- Dumping routines for database 'federacion'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-18 23:02:40
