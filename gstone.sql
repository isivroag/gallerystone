-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-08-2020 a las 04:28:07
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gstone`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prospecto`
--

CREATE TABLE `prospecto` (
  `id_pros` bigint(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `calle` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `num` varchar(20) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `col` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `cd` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `edo` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `tel` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cel` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `status` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `prospecto`
--

INSERT INTO `prospecto` (`id_pros`, `nombre`, `calle`, `num`, `col`, `cp`, `cd`, `edo`, `tel`, `cel`, `status`) VALUES
(1, 'ISRAEL IVAN ROMERO AGUILAR', 'OBISPO', '66', 'INFONAVIT LOMA ALTA', 91183, 'XALAPA', 'VERACRUZ', '2288136913', '2281199040', b'1'),
(2, 'ISRAEL IVAN ROMERO AGUILAR', 'OBISPO', '66', 'INFONAVIT LOMA ALTA', 91183, 'XALAPA', 'VERACRUZ', '2288136913', '2281199040', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(1, 'usuario'),
(2, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `w_usuario`
--

CREATE TABLE `w_usuario` (
  `id_usuario` bigint(20) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `edo_usuario` bit(1) NOT NULL DEFAULT b'1',
  `rol_usuario` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `w_usuario`
--

INSERT INTO `w_usuario` (`id_usuario`, `username`, `nombre`, `email`, `password`, `edo_usuario`, `rol_usuario`) VALUES
(1, 'usuario', 'Israel Romero', 'correo@correo.com', '827ccb0eea8a706c4c34a16891f84e7b', b'1', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `prospecto`
--
ALTER TABLE `prospecto`
  ADD PRIMARY KEY (`id_pros`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `w_usuario`
--
ALTER TABLE `w_usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `prospecto`
--
ALTER TABLE `prospecto`
  MODIFY `id_pros` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `w_usuario`
--
ALTER TABLE `w_usuario`
  MODIFY `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
