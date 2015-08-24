/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para money_tracker
CREATE DATABASE IF NOT EXISTS `money_tracker` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `money_tracker`;


-- Volcando estructura para tabla money_tracker.data
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concept` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `label` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `source` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- La exportación de datos fue deseleccionada.
