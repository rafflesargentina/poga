# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: app.poga.mavaite.com (MySQL 5.6.44)
# Base de datos: poga
# Tiempo de Generación: 2019-08-08 01:48:29 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla departamentos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `departamentos`;

CREATE TABLE `departamentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pais` int(10) unsigned NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enum_estado` enum('ACTIVO','INACTIVO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departamentos_id_pais_foreign` (`id_pais`),
  CONSTRAINT `departamentos_id_pais_foreign` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;

INSERT INTO `departamentos` (`id`, `id_pais`, `nombre`, `enum_estado`, `created_at`, `updated_at`)
VALUES
	(1,182,'Capital','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(2,182,'Concepción','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(3,182,'San Pedro','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(4,182,'Cordillera','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(5,182,'Guairá','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(6,182,'Caaguazú','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(7,182,'Caazapá','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(8,182,'Itapúa','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(9,182,'Misiones','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(10,182,'Paraguarí','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(11,182,'Alto Paraná','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(12,182,'Central','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(13,182,'Ñeembucú','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(14,182,'Amambay','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(15,182,'Canindeyú','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(16,182,'Presidente Hayes','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(17,182,'Boquerón','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08'),
	(18,182,'Alto Paraguay','ACTIVO','2019-08-08 01:48:08','2019-08-08 01:48:08');

/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
