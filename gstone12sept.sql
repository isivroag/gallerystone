-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.40-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para gstone
CREATE DATABASE IF NOT EXISTS `gstone` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci */;
USE `gstone`;

-- Volcando estructura para tabla gstone.citap
CREATE TABLE IF NOT EXISTS `citap` (
  `folio_citap` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pros` bigint(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `concepto` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `obs` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado_citap` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`folio_citap`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.citap: ~12 rows (aproximadamente)
DELETE FROM `citap`;
/*!40000 ALTER TABLE `citap` DISABLE KEYS */;
INSERT INTO `citap` (`folio_citap`, `id_pros`, `fecha`, `concepto`, `obs`, `estado_citap`) VALUES
	(1, 1, '2020-09-01 20:00:00', 'cita 1', 'casa verde', 1),
	(2, 4, '2020-09-30 10:00:00', 'presupuesto 10', 'hablar antes', 1),
	(3, 4, '2020-09-17 11:00:00', 'presupuesto 10', 'hablar antes', 1),
	(4, 4, '2020-09-03 12:00:00', 'presupuesto 10', 'hablar antes', 1),
	(5, 4, '2020-09-27 16:00:00', 'presupuesto 10', 'hablar antes', 1),
	(6, 4, '2020-09-05 14:00:00', 'presupuesto 10', 'hablar antes', 1),
	(7, 4, '2020-09-15 18:00:00', 'presupuesto', '', 1),
	(8, 1, '2020-09-20 20:00:00', 'MAQUILA', 'cambio', 1),
	(9, 1, '2020-09-25 18:00:00', 'presupuesto', '', 1),
	(10, 4, '2020-09-06 17:00:00', 'Presupuesto para acondicionamiento de Cocina', '', 1),
	(11, 4, '2020-09-30 15:00:00', 'ESCALERAS', '', 1),
	(12, 1, '2020-09-07 18:00:00', 'presupuesto', '', 1);
/*!40000 ALTER TABLE `citap` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.concepto
CREATE TABLE IF NOT EXISTS `concepto` (
  `id_concepto` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_concepto` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_t_concepto` bigint(20) NOT NULL,
  `id_subt_concepto` bigint(20) NOT NULL,
  `estado_concepto` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id_concepto`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.concepto: ~19 rows (aproximadamente)
DELETE FROM `concepto`;
/*!40000 ALTER TABLE `concepto` DISABLE KEYS */;
INSERT INTO `concepto` (`id_concepto`, `nom_concepto`, `id_t_concepto`, `id_subt_concepto`, `estado_concepto`) VALUES
	(3, 'LAMBRIN', 1, 1, b'1'),
	(4, 'BARRA DE SERVICIO', 1, 1, b'1'),
	(5, 'COMEDOR', 1, 1, b'1'),
	(6, 'CUBIERTA DE BAÑO', 1, 2, b'1'),
	(7, 'OVALIN', 1, 2, b'1'),
	(8, 'CUBIERTA DE BAÑO DE PEDESTAL', 1, 2, b'1'),
	(9, 'ESCALERAS', 1, 3, b'1'),
	(10, 'MAQUILA COCINA', 1, 4, b'1'),
	(11, 'MAQUILA BAÑO', 1, 4, b'1'),
	(12, 'MAQUILA ISLA', 1, 4, b'1'),
	(13, 'MAQUILA BARRA DE BAR', 1, 4, b'1'),
	(14, 'SUMINISTRO Y COLOCACION', 2, 0, b'1'),
	(15, 'COLOCACION', 2, 0, b'1'),
	(16, 'SUMINISTRO', 2, 0, b'1'),
	(17, 'DETALLES', 3, 0, b'1'),
	(18, 'MANTENIMIENTO', 3, 0, b'1'),
	(19, 'OTRO CONCEPTO', 1, 3, b'1'),
	(20, 'CONCEPTO 20', 2, 0, b'1'),
	(21, 'Romero', 1, 3, b'1');
/*!40000 ALTER TABLE `concepto` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.material
CREATE TABLE IF NOT EXISTS `material` (
  `id_mat` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_mat` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `precio_mat` decimal(10,2) DEFAULT NULL,
  `estado_mat` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id_mat`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.material: ~7 rows (aproximadamente)
DELETE FROM `material`;
/*!40000 ALTER TABLE `material` DISABLE KEYS */;
INSERT INTO `material` (`id_mat`, `nom_mat`, `precio_mat`, `estado_mat`) VALUES
	(1, 'GRANITO VENECIANO AMARILLO', 3500.00, b'1'),
	(2, 'GRANITO PLATINO AZUL', 5500.00, b'1'),
	(3, 'GRANITO IMPERIAL CAFÉ', 3800.00, b'1'),
	(4, 'MARMOL MARFIL CREMA', 3500.00, b'1'),
	(5, 'CUARZO AZUL ESTELAR', 5500.00, b'1'),
	(6, 'CUARZO ROJO FERRARI', 5500.00, b'1'),
	(7, 'CANTERA MARRON CAFÉ', 320.00, b'1');
/*!40000 ALTER TABLE `material` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.presupuesto
CREATE TABLE IF NOT EXISTS `presupuesto` (
  `folio_pres` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `id_pros` bigint(20) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado_pres` bit(1) DEFAULT b'1',
  PRIMARY KEY (`folio_pres`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.presupuesto: ~0 rows (aproximadamente)
DELETE FROM `presupuesto`;
/*!40000 ALTER TABLE `presupuesto` DISABLE KEYS */;
INSERT INTO `presupuesto` (`folio_pres`, `fecha`, `id_pros`, `subtotal`, `iva`, `total`, `estado_pres`) VALUES
	(1, '2020-09-06', 1, 1500.00, 300.00, 1800.00, b'1');
/*!40000 ALTER TABLE `presupuesto` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.prospecto
CREATE TABLE IF NOT EXISTS `prospecto` (
  `id_pros` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `calle` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `num` varchar(20) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `col` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `cd` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `edo` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tel` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cel` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `status` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id_pros`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.prospecto: ~2 rows (aproximadamente)
DELETE FROM `prospecto`;
/*!40000 ALTER TABLE `prospecto` DISABLE KEYS */;
INSERT INTO `prospecto` (`id_pros`, `nombre`, `correo`, `calle`, `num`, `col`, `cp`, `cd`, `edo`, `tel`, `cel`, `status`) VALUES
	(1, 'ISRAEL IVAN', 'isivroag@hotmail.com', 'OBISPO', '66', 'INFONAVIT LOMA ALTA', 91183, 'XALAPA', 'VERACRUZ', '2288136913', '2281199040', b'1'),
	(4, 'Teresa Aguilar', 'teresa_gtz@hotmail.com', 'OBISPO', '66', 'INFONAVIT LOMA ALTA', 91170, 'Xalapa', 'Veracruz', '255545', '55455', b'1');
/*!40000 ALTER TABLE `prospecto` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.rol
CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla gstone.rol: ~2 rows (aproximadamente)
DELETE FROM `rol`;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` (`id`, `rol`) VALUES
	(1, 'usuario'),
	(2, 'administrador');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.subtipo_concepto
CREATE TABLE IF NOT EXISTS `subtipo_concepto` (
  `id_subt_concepto` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_t_concepto` bigint(20) NOT NULL,
  `nom_subt_concepto` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado_subt_concepto` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id_subt_concepto`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.subtipo_concepto: 4 rows
DELETE FROM `subtipo_concepto`;
/*!40000 ALTER TABLE `subtipo_concepto` DISABLE KEYS */;
INSERT INTO `subtipo_concepto` (`id_subt_concepto`, `id_t_concepto`, `nom_subt_concepto`, `estado_subt_concepto`) VALUES
	(1, 1, 'COCINA', b'1'),
	(2, 1, 'BAÑO', b'1'),
	(3, 1, 'ESCALERAS', b'1'),
	(4, 1, 'MAQUILA', b'1');
/*!40000 ALTER TABLE `subtipo_concepto` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.tipo_concepto
CREATE TABLE IF NOT EXISTS `tipo_concepto` (
  `id_t_concepto` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_t_concepto` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado_t_concepto` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id_t_concepto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.tipo_concepto: ~3 rows (aproximadamente)
DELETE FROM `tipo_concepto`;
/*!40000 ALTER TABLE `tipo_concepto` DISABLE KEYS */;
INSERT INTO `tipo_concepto` (`id_t_concepto`, `nom_t_concepto`, `estado_t_concepto`) VALUES
	(1, 'TRANSFORMACION', b'1'),
	(2, 'SUMNISTRO Y COLOCACION', b'1'),
	(3, 'MUEBLES DE DISEÑO', b'1');
/*!40000 ALTER TABLE `tipo_concepto` ENABLE KEYS */;

-- Volcando estructura para vista gstone.vcitap
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vcitap` (
	`id` BIGINT(20) NOT NULL,
	`id_pros` BIGINT(11) UNSIGNED NOT NULL,
	`title` VARCHAR(100) NULL COLLATE 'utf8mb4_spanish_ci',
	`descripcion` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`color` VARCHAR(6) NOT NULL COLLATE 'utf8mb4_general_ci',
	`textcolor` VARCHAR(7) NOT NULL COLLATE 'utf8mb4_general_ci',
	`start` DATETIME NOT NULL,
	`end` DATETIME NULL,
	`obs` VARCHAR(500) NOT NULL COLLATE 'utf8mb4_spanish_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista gstone.vconceptos
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vconceptos` (
	`id_concepto` BIGINT(20) NOT NULL,
	`nom_concepto` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`id_t_concepto` BIGINT(20) NOT NULL,
	`nom_tipo` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`id_subt_concepto` BIGINT(20) NOT NULL,
	`nom_subtipo` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`estado_concepto` BIT(1) NOT NULL
) ENGINE=MyISAM;

-- Volcando estructura para vista gstone.viewcitap
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `viewcitap` (
	`folio_citap` BIGINT(20) NOT NULL,
	`fecha` DATETIME NOT NULL,
	`id_pros` BIGINT(20) NOT NULL,
	`nombre` VARCHAR(100) NULL COLLATE 'utf8mb4_spanish_ci',
	`concepto` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`estado_citap` TINYINT(1) NOT NULL
) ENGINE=MyISAM;

-- Volcando estructura para vista gstone.vpresupuesto
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vpresupuesto` (
	`folio_pres` BIGINT(20) NOT NULL,
	`fecha` DATE NULL,
	`id_pros` BIGINT(20) NULL,
	`nombre` VARCHAR(100) NULL COLLATE 'utf8mb4_spanish_ci',
	`subtotal` DECIMAL(10,2) NULL,
	`iva` DECIMAL(10,2) NULL,
	`total` DECIMAL(10,2) NULL,
	`estado_pres` BIT(1) NULL
) ENGINE=MyISAM;

-- Volcando estructura para vista gstone.vsubtipo_concepto
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vsubtipo_concepto` (
	`id_t_concepto` BIGINT(20) NOT NULL,
	`nom_t_concepto` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`id_subt_concepto` BIGINT(20) NOT NULL,
	`nom_subt_concepto` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`estado_subt_concepto` BIT(1) NULL
) ENGINE=MyISAM;

-- Volcando estructura para tabla gstone.w_usuario
CREATE TABLE IF NOT EXISTS `w_usuario` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `edo_usuario` bit(1) NOT NULL DEFAULT b'1',
  `rol_usuario` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.w_usuario: ~3 rows (aproximadamente)
DELETE FROM `w_usuario`;
/*!40000 ALTER TABLE `w_usuario` DISABLE KEYS */;
INSERT INTO `w_usuario` (`id_usuario`, `username`, `nombre`, `email`, `password`, `edo_usuario`, `rol_usuario`) VALUES
	(1, 'admin', 'Israel Romero', 'correo@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', b'1', 2),
	(2, 'demo', 'Romero', 'isivroag@gmail.com', '2d95666e2649fcfc6e3af75e09f5adb9', b'1', 1),
	(3, 'ivan', 'usuario', 'isivroag@gmail.com', '149815eb972b3c370dee3b89d645ae14', b'1', 2);
/*!40000 ALTER TABLE `w_usuario` ENABLE KEYS */;

-- Volcando estructura para vista gstone.vcitap
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vcitap`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vcitap` AS select `citap`.`folio_citap` AS `id`,`prospecto`.`id_pros` AS `id_pros`,`prospecto`.`nombre` AS `title`,`citap`.`concepto` AS `descripcion`,'#FF0F0' AS `color`,'#FFFFFF' AS `textcolor`,`citap`.`fecha` AS `start`,(`citap`.`fecha` + interval 1 hour) AS `end`,`citap`.`obs` AS `obs` from (`citap` join `prospecto` on((`citap`.`id_pros` = `prospecto`.`id_pros`))) order by `citap`.`folio_citap` ;

-- Volcando estructura para vista gstone.vconceptos
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vconceptos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vconceptos` AS select `concepto`.`id_concepto` AS `id_concepto`,`concepto`.`nom_concepto` AS `nom_concepto`,`concepto`.`id_t_concepto` AS `id_t_concepto`,`tipo_concepto`.`nom_t_concepto` AS `nom_tipo`,if(isnull(`concepto`.`id_subt_concepto`),0,`concepto`.`id_subt_concepto`) AS `id_subt_concepto`,if(isnull(`subtipo_concepto`.`nom_subt_concepto`),'ND',`subtipo_concepto`.`nom_subt_concepto`) AS `nom_subtipo`,`concepto`.`estado_concepto` AS `estado_concepto` from ((`concepto` join `tipo_concepto` on((`concepto`.`id_t_concepto` = `tipo_concepto`.`id_t_concepto`))) left join `subtipo_concepto` on(((`concepto`.`id_t_concepto` = `subtipo_concepto`.`id_t_concepto`) and (`concepto`.`id_subt_concepto` = `subtipo_concepto`.`id_subt_concepto`)))) order by `concepto`.`id_concepto` ;

-- Volcando estructura para vista gstone.viewcitap
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `viewcitap`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewcitap` AS select `citap`.`folio_citap` AS `folio_citap`,`citap`.`fecha` AS `fecha`,`citap`.`id_pros` AS `id_pros`,`prospecto`.`nombre` AS `nombre`,`citap`.`concepto` AS `concepto`,`citap`.`estado_citap` AS `estado_citap` from (`citap` join `prospecto` on((`citap`.`id_pros` = `prospecto`.`id_pros`))) order by `citap`.`fecha` ;

-- Volcando estructura para vista gstone.vpresupuesto
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vpresupuesto`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vpresupuesto` AS select `presupuesto`.`folio_pres` AS `folio_pres`,`presupuesto`.`fecha` AS `fecha`,`presupuesto`.`id_pros` AS `id_pros`,`prospecto`.`nombre` AS `nombre`,`presupuesto`.`subtotal` AS `subtotal`,`presupuesto`.`iva` AS `iva`,`presupuesto`.`total` AS `total`,`presupuesto`.`estado_pres` AS `estado_pres` from (`presupuesto` join `prospecto` on((`presupuesto`.`id_pros` = `prospecto`.`id_pros`))) order by `presupuesto`.`folio_pres` ;

-- Volcando estructura para vista gstone.vsubtipo_concepto
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vsubtipo_concepto`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vsubtipo_concepto` AS SELECT subtipo_concepto.id_t_concepto,tipo_concepto.nom_t_concepto,subtipo_concepto.id_subt_concepto,subtipo_concepto.nom_subt_concepto,subtipo_concepto.estado_subt_concepto
FROM subtipo_concepto JOIN tipo_concepto
ON subtipo_concepto.id_t_concepto=tipo_concepto.id_t_concepto order by subtipo_concepto.id_t_concepto,subtipo_concepto.id_subt_concepto ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
