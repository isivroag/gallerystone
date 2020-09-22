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

-- Volcando estructura para tabla gstone.acabado
CREATE TABLE IF NOT EXISTS `acabado` (
  `id_acabado` bigint(20) NOT NULL AUTO_INCREMENT,
  `clave_acabado` varchar(4) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nom_acabado` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id_acabado`),
  UNIQUE KEY `clave_acabado` (`clave_acabado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.acabado: ~5 rows (aproximadamente)
DELETE FROM `acabado`;
/*!40000 ALTER TABLE `acabado` DISABLE KEYS */;
INSERT INTO `acabado` (`id_acabado`, `clave_acabado`, `nom_acabado`) VALUES
	(0, 'N/A', 'NO APLICA'),
	(1, '00', 'NATURAL'),
	(2, '01', 'PULIDO BRILLANTE'),
	(3, '02', 'MATE'),
	(4, '03', 'CEPILLADO');
/*!40000 ALTER TABLE `acabado` ENABLE KEYS */;

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
	(3, 4, '2020-09-18 11:00:00', 'presupuesto 10', 'hablar antes', 1),
	(4, 4, '2020-09-03 12:00:00', 'presupuesto 10', 'hablar antes', 1),
	(5, 4, '2020-09-27 16:00:00', 'presupuesto 10', 'hablar antes', 1),
	(6, 4, '2020-09-05 14:00:00', 'presupuesto 10', 'hablar antes', 1),
	(7, 4, '2020-09-15 18:00:00', 'presupuesto', '', 1),
	(8, 1, '2020-09-18 20:00:00', 'MAQUILA', 'cambio', 1),
	(9, 1, '2020-09-18 18:00:00', 'presupuesto', '', 1),
	(10, 4, '2020-09-06 17:00:00', 'Presupuesto para acondicionamiento de Cocina', '', 1),
	(11, 4, '2020-09-30 15:00:00', 'ESCALERAS', '', 1),
	(12, 1, '2020-09-07 18:00:00', 'presupuesto', '', 1);
/*!40000 ALTER TABLE `citap` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.color
CREATE TABLE IF NOT EXISTS `color` (
  `id_color` bigint(20) NOT NULL AUTO_INCREMENT,
  `clave_color` varchar(5) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nom_color` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_color`),
  UNIQUE KEY `clave_color` (`clave_color`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.color: ~12 rows (aproximadamente)
DELETE FROM `color`;
/*!40000 ALTER TABLE `color` DISABLE KEYS */;
INSERT INTO `color` (`id_color`, `clave_color`, `nom_color`) VALUES
	(0, 'N/A', 'NO APLICA'),
	(1, 'AM', 'AMARILLO'),
	(2, 'AZ', 'AZUL'),
	(3, 'BCO', 'BLANCO'),
	(4, 'CF', 'CAFÉ'),
	(5, 'CRM', 'CREMA'),
	(6, 'G', 'GRIS'),
	(7, 'NEG', 'NEGRO'),
	(8, 'RJ', 'ROJO'),
	(9, 'RS', 'ROSA'),
	(10, 'NJ', 'NARANJA'),
	(11, 'V', 'VERDE');
/*!40000 ALTER TABLE `color` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.concepto
CREATE TABLE IF NOT EXISTS `concepto` (
  `id_concepto` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_concepto` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_umedida` bigint(20) NOT NULL,
  `id_t_concepto` bigint(20) NOT NULL,
  `id_subt_concepto` bigint(20) DEFAULT NULL,
  `estado_concepto` bit(1) NOT NULL DEFAULT b'1',
  `uso_mat` varchar(2) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_concepto`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.concepto: ~15 rows (aproximadamente)
DELETE FROM `concepto`;
/*!40000 ALTER TABLE `concepto` DISABLE KEYS */;
INSERT INTO `concepto` (`id_concepto`, `nom_concepto`, `id_umedida`, `id_t_concepto`, `id_subt_concepto`, `estado_concepto`, `uso_mat`) VALUES
	(3, 'TRANSFORMACION DE LAMBRIN', 2, 1, 1, b'1', 'Si'),
	(4, 'TRANSFORMACIÓN DE BARRA DE SERVICIO', 1, 1, 1, b'1', 'Si'),
	(5, 'COMEDOR', 1, 1, 1, b'1', 'Si'),
	(6, 'CUBIERTA DE BAÑO', 1, 1, 2, b'1', 'Si'),
	(7, 'OVALIN', 1, 1, 2, b'1', 'Si'),
	(8, 'CUBIERTA DE BAÑO DE PEDESTAL', 1, 1, 2, b'1', 'Si'),
	(9, 'ESCALERAS', 1, 1, 3, b'1', 'Si'),
	(10, 'MAQUILA COCINA', 2, 1, 4, b'1', 'Si'),
	(11, 'MAQUILA BAÑO', 1, 1, 4, b'1', 'Si'),
	(12, 'MAQUILA ISLA', 1, 1, 4, b'1', 'Si'),
	(13, 'MAQUILA BARRA DE BAR', 1, 1, 4, b'1', 'Si'),
	(15, 'COLOCACION', 1, 2, 0, b'1', 'NO'),
	(16, 'SUMINISTRO', 1, 2, 0, b'1', 'Si'),
	(17, 'DETALLES', 3, 3, 0, b'1', 'NO'),
	(18, 'MANTENIMIENTO', 1, 3, 0, b'1', 'NO');
/*!40000 ALTER TABLE `concepto` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.detalle_tmp
CREATE TABLE IF NOT EXISTS `detalle_tmp` (
  `id_reg` bigint(20) NOT NULL AUTO_INCREMENT,
  `folio_pres` bigint(20) DEFAULT NULL,
  `id_concepto` bigint(20) DEFAULT NULL,
  `id_item` bigint(20) DEFAULT NULL,
  `id_precio` bigint(20) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_reg`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.detalle_tmp: ~3 rows (aproximadamente)
DELETE FROM `detalle_tmp`;
/*!40000 ALTER TABLE `detalle_tmp` DISABLE KEYS */;
INSERT INTO `detalle_tmp` (`id_reg`, `folio_pres`, `id_concepto`, `id_item`, `id_precio`, `precio`, `cantidad`, `total`) VALUES
	(1, 1, 3, 2, 3, 1000.00, 2.60, 2600.00),
	(2, 1, 4, 2, 2, 3522.00, 1.00, 3522.00),
	(3, 2, 3, 2, 3, 1000.00, 4.00, 4000.00);
/*!40000 ALTER TABLE `detalle_tmp` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.insumo
CREATE TABLE IF NOT EXISTS `insumo` (
  `id_insumo` bigint(20) NOT NULL AUTO_INCREMENT,
  `clave_insumo` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nom_insumo` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id_insumo`),
  UNIQUE KEY `clave_materia` (`clave_insumo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.insumo: ~8 rows (aproximadamente)
DELETE FROM `insumo`;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` (`id_insumo`, `clave_insumo`, `nom_insumo`) VALUES
	(0, 'N/A', 'NO APLICA'),
	(1, 'G', 'GRANITO'),
	(2, 'M', 'MARMOL'),
	(3, 'Q', 'CUARZO'),
	(4, 'CA', 'CANTERA'),
	(5, 'R', 'RECINTO'),
	(6, 'S', 'SLATE'),
	(7, 'CZ', 'CUARZITA');
/*!40000 ALTER TABLE `insumo` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.item
CREATE TABLE IF NOT EXISTS `item` (
  `id_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `clave_item` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nom_item` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_insumo` bigint(20) DEFAULT NULL,
  `id_color` bigint(20) DEFAULT NULL,
  `id_acabado` bigint(20) DEFAULT NULL,
  `tipo_item` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_item`),
  UNIQUE KEY `clave_mat` (`clave_item`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.item: ~10 rows (aproximadamente)
DELETE FROM `item`;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` (`id_item`, `clave_item`, `nom_item`, `id_insumo`, `id_color`, `id_acabado`, `tipo_item`) VALUES
	(1, 'G01-AM-VENECIANO', 'GRANITO VENECIANO AMARILLO PULIDO BRILLANTE', 1, 1, 2, 'Material'),
	(2, 'G01-AZ-ALADEMOSCA', 'ALA DE MOSCA', 1, 2, 2, 'Material'),
	(3, 'G01-AZ-PLATINO', 'PLATINO', 1, 2, 2, NULL),
	(4, 'G01-BCO-ARABESCO', 'ARABESCO', 1, 3, 2, NULL),
	(5, 'G01-BCO-SIENNA', 'SIENNA', 1, 3, 2, 'Material'),
	(6, 'G01-BCO-DALLAS/MARFIM', 'DALLAS/MARFIM', 1, 3, 2, NULL),
	(7, 'S00-G-TIKUL', 'SLATE TIKUL NATURAL GRIS', 6, 6, 1, NULL),
	(8, 'CL', 'COLOCACION', 0, 0, 0, 'Servicio'),
	(10, 'MAN', 'MANTENIMIENTO', 0, 0, 0, 'Servicio'),
	(11, 'MC', 'MESA DE CENTRO', 0, 0, 0, 'Servicio');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.precio
CREATE TABLE IF NOT EXISTS `precio` (
  `id_precio` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_item` bigint(20) NOT NULL,
  `id_umedida` bigint(20) NOT NULL,
  `formato` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_precio`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.precio: ~12 rows (aproximadamente)
DELETE FROM `precio`;
/*!40000 ALTER TABLE `precio` DISABLE KEYS */;
INSERT INTO `precio` (`id_precio`, `id_item`, `id_umedida`, `formato`, `monto`) VALUES
	(2, 2, 1, 'Metro Lineal', 3522.00),
	(3, 2, 2, 'M2', 1000.00),
	(4, 1, 1, 'Metro Lineal', 2000.00),
	(5, 1, 2, 'Metro Cuadrado', 220.00),
	(6, 7, 0, 'PLACA 30*30', 690.00),
	(7, 1, 2, 'Placa 30*30', 150.00),
	(9, 10, 1, 'ml', 200.00),
	(10, 8, 1, 'FORMATO PEQUEÑO', 150.00),
	(11, 8, 1, 'TIRA LARGA', 200.00),
	(12, 8, 1, 'PLACA GRANDE', 500.00),
	(13, 5, 1, 'ML', 5500.00),
	(14, 5, 2, 'M2', 2000.00);
/*!40000 ALTER TABLE `precio` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.presupuesto
CREATE TABLE IF NOT EXISTS `presupuesto` (
  `folio_pres` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `id_pros` bigint(20) DEFAULT NULL,
  `concepto_pres` varchar(1500) COLLATE utf8mb4_spanish_ci DEFAULT '1',
  `ubi_pres` varchar(1500) COLLATE utf8mb4_spanish_ci DEFAULT '1',
  `subtotal` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado_pres` bit(1) DEFAULT b'1',
  PRIMARY KEY (`folio_pres`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.presupuesto: ~1 rows (aproximadamente)
DELETE FROM `presupuesto`;
/*!40000 ALTER TABLE `presupuesto` DISABLE KEYS */;
INSERT INTO `presupuesto` (`folio_pres`, `fecha`, `id_pros`, `concepto_pres`, `ubi_pres`, `subtotal`, `iva`, `total`, `estado_pres`) VALUES
	(1, '2020-09-06', 1, '1', '1', 1500.00, 300.00, 1800.00, b'1');
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

-- Volcando estructura para tabla gstone.servicio
CREATE TABLE IF NOT EXISTS `servicio` (
  `id_servicio` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_umedida` bigint(20) NOT NULL,
  `nom_servicio` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `monto_servicio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.servicio: ~2 rows (aproximadamente)
DELETE FROM `servicio`;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` (`id_servicio`, `id_umedida`, `nom_servicio`, `monto_servicio`) VALUES
	(2, 4, 'COLOCACION DE PISO FORMATO PEQUEÑO', 220.00),
	(3, 1, 'INSTALACION DE FORMATO CHICO', 550.00);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;

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
  `token` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_t_concepto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.tipo_concepto: ~3 rows (aproximadamente)
DELETE FROM `tipo_concepto`;
/*!40000 ALTER TABLE `tipo_concepto` DISABLE KEYS */;
INSERT INTO `tipo_concepto` (`id_t_concepto`, `nom_t_concepto`, `estado_t_concepto`, `token`) VALUES
	(1, 'TRANSFORMACION', b'1', NULL),
	(2, 'SUMINISTRO Y COLOCACION', b'1', NULL),
	(3, 'MUEBLES DE DISEÑO', b'1', NULL);
/*!40000 ALTER TABLE `tipo_concepto` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.tmp_pres
CREATE TABLE IF NOT EXISTS `tmp_pres` (
  `folio_pres` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pros` bigint(20) DEFAULT '0',
  `fecha_pres` date NOT NULL,
  `concepto_pres` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT '0',
  `ubicacion` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `estado_pres` int(2) NOT NULL,
  `tokenid` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`folio_pres`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.tmp_pres: ~2 rows (aproximadamente)
DELETE FROM `tmp_pres`;
/*!40000 ALTER TABLE `tmp_pres` DISABLE KEYS */;
INSERT INTO `tmp_pres` (`folio_pres`, `id_pros`, `fecha_pres`, `concepto_pres`, `ubicacion`, `total`, `estado_pres`, `tokenid`) VALUES
	(1, 1, '2020-09-20', 'Instalación de cubierta de cocina', 'Montemagno 512', 0.00, 2, '21232f297a57a5a743894a0e4a801fc3'),
	(2, 4, '2020-09-20', 'presupuesto 2', 'Ubicacion', 0.00, 1, '21232f297a57a5a743894a0e4a801fc3');
/*!40000 ALTER TABLE `tmp_pres` ENABLE KEYS */;

-- Volcando estructura para tabla gstone.umedida
CREATE TABLE IF NOT EXISTS `umedida` (
  `id_umedida` int(11) NOT NULL AUTO_INCREMENT,
  `nom_umedida` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_umedida`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla gstone.umedida: ~4 rows (aproximadamente)
DELETE FROM `umedida`;
/*!40000 ALTER TABLE `umedida` DISABLE KEYS */;
INSERT INTO `umedida` (`id_umedida`, `nom_umedida`) VALUES
	(1, 'ML'),
	(2, 'M2'),
	(3, 'PZA'),
	(4, 'SERVICIO');
/*!40000 ALTER TABLE `umedida` ENABLE KEYS */;

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
	`id_umedida` BIGINT(20) NOT NULL,
	`nom_umedida` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`id_t_concepto` BIGINT(20) NOT NULL,
	`nom_tipo` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`id_subt_concepto` BIGINT(20) NULL,
	`nom_subtipo` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`estado_concepto` BIT(1) NOT NULL,
	`uso_mat` VARCHAR(2) NULL COLLATE 'utf8mb4_spanish_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista gstone.vdetalle_tmp
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vdetalle_tmp` (
	`id_reg` BIGINT(20) NOT NULL,
	`folio_pres` BIGINT(20) NULL,
	`id_concepto` BIGINT(20) NULL,
	`nom_concepto` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`id_item` BIGINT(20) NULL,
	`clave_item` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`nom_item` VARCHAR(100) NULL COLLATE 'utf8mb4_spanish_ci',
	`id_precio` BIGINT(20) NULL,
	`formato` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`id_umedida` BIGINT(20) NOT NULL,
	`nom_umedida` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`monto` DECIMAL(10,2) NOT NULL,
	`precio` DECIMAL(10,2) NULL,
	`cantidad` DECIMAL(10,2) NULL,
	`total` DECIMAL(10,2) NULL
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

-- Volcando estructura para vista gstone.vitem
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vitem` (
	`id_item` BIGINT(20) NOT NULL,
	`clave_item` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`nom_item` VARCHAR(100) NULL COLLATE 'utf8mb4_spanish_ci',
	`id_insumo` BIGINT(20) NULL,
	`clave_insumo` VARCHAR(20) NULL COLLATE 'utf8mb4_spanish_ci',
	`nom_insumo` VARCHAR(20) NULL COLLATE 'utf8mb4_spanish_ci',
	`id_color` BIGINT(20) NULL,
	`clave_color` VARCHAR(5) NULL COLLATE 'utf8mb4_spanish_ci',
	`nom_color` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`id_acabado` BIGINT(20) NULL,
	`clave_acabado` VARCHAR(4) NULL COLLATE 'utf8mb4_spanish_ci',
	`nom_acabado` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`tipo_item` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci'
) ENGINE=MyISAM;

-- Volcando estructura para vista gstone.vprecio
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vprecio` (
	`id_precio` BIGINT(20) NOT NULL,
	`id_item` BIGINT(20) NOT NULL,
	`id_umedida` BIGINT(20) NOT NULL,
	`nom_umedida` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci',
	`formato` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`monto` DECIMAL(10,2) NOT NULL
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

-- Volcando estructura para vista gstone.vservicio
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vservicio` (
	`id_servicio` BIGINT(20) NOT NULL,
	`nom_servicio` VARCHAR(500) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`monto_servicio` DECIMAL(10,2) NOT NULL,
	`id_umedida` BIGINT(20) NOT NULL,
	`nom_umedida` VARCHAR(50) NULL COLLATE 'utf8mb4_spanish_ci'
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

-- Volcando estructura para vista gstone.vtmppres
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `vtmppres` (
	`folio_pres` BIGINT(20) NOT NULL,
	`id_pros` BIGINT(20) NULL,
	`nombre` VARCHAR(100) NULL COLLATE 'utf8mb4_spanish_ci',
	`fecha_pres` DATE NOT NULL,
	`concepto_pres` VARCHAR(500) NULL COLLATE 'utf8mb4_spanish_ci',
	`ubicacion` VARCHAR(500) NULL COLLATE 'utf8mb4_spanish_ci',
	`total` DECIMAL(10,2) NULL,
	`estado_pres` INT(2) NOT NULL,
	`tokenid` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci'
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
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vconceptos` AS SELECT `concepto`.`id_concepto` AS `id_concepto`,`concepto`.`nom_concepto` AS `nom_concepto`,`concepto`.`id_umedida` AS `id_umedida`,`umedida`.`nom_umedida` AS `nom_umedida`,`concepto`.`id_t_concepto` AS `id_t_concepto`,`tipo_concepto`.`nom_t_concepto` AS `nom_tipo`, IF(ISNULL(`concepto`.`id_subt_concepto`),0,`concepto`.`id_subt_concepto`) AS `id_subt_concepto`, IF(ISNULL(`subtipo_concepto`.`nom_subt_concepto`),'ND',`subtipo_concepto`.`nom_subt_concepto`) AS `nom_subtipo`,`concepto`.`estado_concepto` AS `estado_concepto`,
concepto.uso_mat
from (((`concepto`
JOIN `tipo_concepto` ON((`concepto`.`id_t_concepto` = `tipo_concepto`.`id_t_concepto`)))
LEFT JOIN `subtipo_concepto` ON(((`concepto`.`id_t_concepto` = `subtipo_concepto`.`id_t_concepto`) AND (`concepto`.`id_subt_concepto` = `subtipo_concepto`.`id_subt_concepto`))))
LEFT JOIN `umedida` ON((`concepto`.`id_umedida` = `umedida`.`id_umedida`)))
ORDER BY `concepto`.`id_concepto` ;

-- Volcando estructura para vista gstone.vdetalle_tmp
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vdetalle_tmp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vdetalle_tmp` AS SELECT detalle_tmp.id_reg,detalle_tmp.folio_pres,detalle_tmp.id_concepto,concepto.nom_concepto,
detalle_tmp.id_item,item.clave_item,item.nom_item,detalle_tmp.id_precio,precio.formato,precio.id_umedida,
umedida.nom_umedida,precio.monto,detalle_tmp.precio,detalle_tmp.cantidad,detalle_tmp.total 
FROM detalle_tmp
JOIN concepto ON detalle_tmp.id_concepto =concepto.id_concepto
JOIN item ON detalle_tmp.id_item=item.id_item
JOIN precio ON detalle_tmp.id_precio=precio.id_precio
JOIN umedida ON concepto.id_umedida=umedida.id_umedida
order by detalle_tmp.id_reg ;

-- Volcando estructura para vista gstone.viewcitap
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `viewcitap`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewcitap` AS select `citap`.`folio_citap` AS `folio_citap`,`citap`.`fecha` AS `fecha`,`citap`.`id_pros` AS `id_pros`,`prospecto`.`nombre` AS `nombre`,`citap`.`concepto` AS `concepto`,`citap`.`estado_citap` AS `estado_citap` from (`citap` join `prospecto` on((`citap`.`id_pros` = `prospecto`.`id_pros`))) order by `citap`.`fecha` ;

-- Volcando estructura para vista gstone.vitem
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vitem`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vitem` AS SELECT `item`.`id_item` AS `id_item`,`item`.`clave_item` AS `clave_item`,`item`.`nom_item` AS `nom_item`,`item`.`id_insumo` AS `id_insumo`,`insumo`.`clave_insumo` AS `clave_insumo`,`insumo`.`nom_insumo` AS `nom_insumo`,`item`.`id_color` AS `id_color`,`color`.`clave_color` AS `clave_color`,`color`.`nom_color` AS `nom_color`,`item`.`id_acabado` AS `id_acabado`,`acabado`.`clave_acabado` AS `clave_acabado`,`acabado`.`nom_acabado` AS `nom_acabado`,item.tipo_item
FROM (((`item`
LEFT JOIN `insumo` ON((`item`.`id_insumo` = `insumo`.`id_insumo`)))
LEFT JOIN `color` ON((`item`.`id_color` = `color`.`id_color`)))
LEFT JOIN `acabado` ON((`item`.`id_acabado` = `acabado`.`id_acabado`)))
ORDER BY `item`.`id_item` ;

-- Volcando estructura para vista gstone.vprecio
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vprecio`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `vprecio` AS select `precio`.`id_precio` AS `id_precio`,`precio`.`id_item` AS `id_item`,`precio`.`id_umedida` AS `id_umedida`,`umedida`.`nom_umedida` AS `nom_umedida`,`precio`.`formato` AS `formato`,`precio`.`monto` AS `monto` from (`precio` left join `umedida` on((`precio`.`id_umedida` = `umedida`.`id_umedida`))) ;

-- Volcando estructura para vista gstone.vpresupuesto
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vpresupuesto`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vpresupuesto` AS select `presupuesto`.`folio_pres` AS `folio_pres`,`presupuesto`.`fecha` AS `fecha`,`presupuesto`.`id_pros` AS `id_pros`,`prospecto`.`nombre` AS `nombre`,`presupuesto`.`subtotal` AS `subtotal`,`presupuesto`.`iva` AS `iva`,`presupuesto`.`total` AS `total`,`presupuesto`.`estado_pres` AS `estado_pres` from (`presupuesto` join `prospecto` on((`presupuesto`.`id_pros` = `prospecto`.`id_pros`))) order by `presupuesto`.`folio_pres` ;

-- Volcando estructura para vista gstone.vservicio
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vservicio`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vservicio` AS SELECT servicio.id_servicio,servicio.nom_servicio,servicio.monto_servicio,servicio.id_umedida,umedida.nom_umedida
FROM servicio
JOIN umedida ON servicio.id_umedida = umedida.id_umedida ;

-- Volcando estructura para vista gstone.vsubtipo_concepto
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vsubtipo_concepto`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vsubtipo_concepto` AS select `subtipo_concepto`.`id_t_concepto` AS `id_t_concepto`,`tipo_concepto`.`nom_t_concepto` AS `nom_t_concepto`,`subtipo_concepto`.`id_subt_concepto` AS `id_subt_concepto`,`subtipo_concepto`.`nom_subt_concepto` AS `nom_subt_concepto`,`subtipo_concepto`.`estado_subt_concepto` AS `estado_subt_concepto` from (`subtipo_concepto` join `tipo_concepto` on((`subtipo_concepto`.`id_t_concepto` = `tipo_concepto`.`id_t_concepto`))) order by `subtipo_concepto`.`id_t_concepto`,`subtipo_concepto`.`id_subt_concepto` ;

-- Volcando estructura para vista gstone.vtmppres
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `vtmppres`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vtmppres` AS SELECT tmp_pres.folio_pres,tmp_pres.id_pros,prospecto.nombre,tmp_pres.fecha_pres,
tmp_pres.concepto_pres,tmp_pres.ubicacion,tmp_pres.total,tmp_pres.estado_pres,tmp_pres.tokenid
 FROM tmp_pres left JOIN prospecto on
 tmp_pres.id_pros = prospecto.id_pros ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
