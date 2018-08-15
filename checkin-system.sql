-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-08-2018 a las 09:26:42
-- Versión del servidor: 5.6.39-cll-lve
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `checkin-system`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificado`
--

CREATE TABLE `certificado` (
  `id` int(255) NOT NULL,
  `id_evento` int(255) NOT NULL,
  `nombre_certificado` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `data_html` mediumtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `certificado`
--

INSERT INTO `certificado` (`id`, `id_evento`, `nombre_certificado`, `data_html`) VALUES
(5, 150, 'Certificado de prueba', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n	<meta charset=\"utf-8\">\r\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n	<title>HTML de mPDF</title>\r\n	<link rel=\"stylesheet\" href=\"\">\r\n</head>\r\n<body>\r\n	<div style=\"width: 100%\">\r\n		<div style=\"padding: 0px 15px;\">\r\n			<div style=\"margin: auto; text-align: center;\">\r\n				<h1>\r\n					Certificado de prueba\r\n				</h1>\r\n				<br>\r\n				<span style=\"font-size: 25px;\">Felicidades <span style=\"font-weight: bold;\">@name</span> por su asistencia nuestro evento.</span><br>\r\n				<img src=\"http://palmera.marketing/check-in_system/assets/images/header_gracias.png\" alt=\"\" width=\"100%\">\r\n			</div>\r\n		</div>\r\n	</div>\r\n</body>\r\n</html>'),
(6, 15, 'Certificado para probar Checkin y Evento', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n	<meta charset=\"utf-8\">\r\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n	<title>HTML de mPDF</title>\r\n	<link rel=\"stylesheet\" href=\"\">\r\n</head>\r\n<body>\r\n	<div style=\"width: 100%\">\r\n		<div style=\"padding: 0px 15px;\">\r\n			<div style=\"margin: auto; text-align: center;\">\r\n				<h1>\r\n					Certificado de prueba\r\n				</h1>\r\n				<br>\r\n				<span style=\"font-size: 25px;\">Felicidades <span style=\"font-weight: bold;\">@name</span> por su asistencia nuestro evento.</span><br>\r\n				<img src=\"http://palmera.marketing/check-in_system/assets/images/header_gracias.png\" alt=\"\" width=\"100%\">\r\n			</div>\r\n		</div>\r\n	</div>\r\n</body>\r\n</html>\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clave_participante`
--

CREATE TABLE `clave_participante` (
  `id` int(255) NOT NULL,
  `clave` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `id_participante` int(255) NOT NULL,
  `id_evento` int(255) NOT NULL,
  `estatus` varchar(25) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clave_participante`
--

INSERT INTO `clave_participante` (`id`, `clave`, `id_participante`, `id_evento`, `estatus`) VALUES
(1, '150-9', 9, 150, 'Activo'),
(2, '150-10', 10, 150, 'Activo'),
(3, '150-13', 13, 150, 'Activo'),
(4, '150-15', 15, 150, 'Activo'),
(5, '15-18', 18, 15, 'Activo'),
(6, '150-19', 19, 150, 'Activo'),
(7, '150-20', 20, 150, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id` int(255) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `estatus` varchar(25) COLLATE utf8_spanish_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `nombre`, `fecha`, `direccion`, `estatus`) VALUES
(1, 'Prueba', '2018-07-13', 'Direccion de Prueba', '1'),
(15, 'Evento de prueba con sistema Evento', '2018-08-08', 'Caracas', '1'),
(150, 'Prueba', '2018-07-13', 'Direccion de Prueba', '1'),
(154, 'prueba2', '2018-07-27', 'Caracas', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes`
--

CREATE TABLE `participantes` (
  `id` int(255) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_1` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_2` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `especialidad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `colegiado` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `celular` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pais` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `asistencia` varchar(70) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Sin asistencia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `participantes`
--

INSERT INTO `participantes` (`id`, `nombre`, `apellido_1`, `apellido_2`, `especialidad`, `colegiado`, `celular`, `email`, `ciudad`, `pais`, `direccion`, `telefono`, `asistencia`) VALUES
(9, 'Yanuel', 'Leal3', 'Tortoza3', 'Programacion3', '12345', '04166228987', 'yanuel@palmera.marketing', 'Caracas3', 'Venezuela3', 'Los Teques3', '3234234234234', 'Con asistencia'),
(10, 'Yanuelwwwww', 'Leal2', 'Tortoza2', 'Programacion2', '12345', '04166228987', 'yanueltexx@gmail.com', 'Caracas2', 'Venezuela2', 'Los Teques2', '3234234234234', 'Sin asistencia'),
(13, 'Yanuel', 'Leal', 'Tortoza', 'Programacion', '550321', '04166228987', 'yanueltex@gmail.com', 'Caracas', 'Venezuela', 'Los Teques', '02123216202', 'Con asistencia'),
(15, 'Yanuel Prueba', 'Leal', 'Tortoza', 'Programacion', '550321', '04166228987', 'prueba@esprueba.com', 'Caracas', 'Venezuela', 'Los Teques', '0416622898777', 'Sin asistencia'),
(18, 'Yanuel P1', 'Leal P1', 'Tortoza P1', 'Programado P1', '123456789', '1112312312312', 'Prueba1@prueba1.com', 'Los teques', 'Venezuela', 'los teques', '3234234234234', 'Con asistencia'),
(19, 'Yanuel P2', 'Leal P2', 'Tortoza P2', 'Programado P2', '123456789', '1112312312312', 'Prueba2@prueba.com', 'Los teques', 'Venezuela3', 'Los Teques', '0416622898777', 'Sin asistencia'),
(20, 'Yanuel P2', 'Leal P2', 'Tortoza P2', 'Programado P2', '123456789', '04166228987', 'Prueba2@prueba1.com', 'Los teques', 'Venezuela3', 'Los Teques', '04126515', 'Con asistencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `nombre` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `tipo` char(64) COLLATE utf8mb4_bin NOT NULL,
  `estatus` int(1) NOT NULL,
  `logeado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `nombre`, `password`, `tipo`, `estatus`, `logeado`) VALUES
(1, 'darimartinez_26@hotmail.com', 'dariana', '202cb962ac59075b964b07152d234b70', 'admin', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_evento` (`id_evento`);

--
-- Indices de la tabla `clave_participante`
--
ALTER TABLE `clave_participante`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clave_participante`
--
ALTER TABLE `clave_participante`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
