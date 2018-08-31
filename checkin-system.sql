-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-08-2018 a las 17:12:09
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

DROP TABLE IF EXISTS `certificado`;
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
(6, 15, 'Certificado para probar Checkin y Evento', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n	<meta charset=\"utf-8\">\r\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n	<title>HTML de mPDF</title>\r\n	<link rel=\"stylesheet\" href=\"\">\r\n</head>\r\n<body>\r\n	<div style=\"width: 100%\">\r\n		<div style=\"padding: 0px 15px;\">\r\n			<div style=\"margin: auto; text-align: center;\">\r\n				<h1>\r\n					Certificado de prueba\r\n				</h1>\r\n				<br>\r\n				<span style=\"font-size: 25px;\">Felicidades <span style=\"font-weight: bold;\">@name</span> por su asistencia nuestro evento.</span><br>\r\n				<img src=\"http://palmera.marketing/check-in_system/assets/images/header_gracias.png\" alt=\"\" width=\"100%\">\r\n			</div>\r\n		</div>\r\n	</div>\r\n</body>\r\n</html>\r\n'),
(7, 16, 'Certificado de Evaluacion', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n	<meta charset=\"utf-8\">\r\n	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n	<title>HTML de mPDF</title>\r\n	<link rel=\"stylesheet\" href=\"\">\r\n</head>\r\n<body>\r\n	<div style=\"width: 100%\">\r\n		<div style=\"padding: 0px 15px;\">\r\n			<div style=\"margin: auto; text-align: center;\">\r\n				<h1>\r\n					Certificado de prueba\r\n				</h1>\r\n				<br>\r\n				<span style=\"font-size: 25px;\">Felicidades <span style=\"font-weight: bold;\">@name</span> por su asistencia nuestro evento.</span><br>\r\n				<img src=\"http://palmera.marketing/check-in_system/assets/images/header_gracias.png\" alt=\"\" width=\"100%\">\r\n			</div>\r\n		</div>\r\n	</div>\r\n</body>\r\n</html>\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clave_participante`
--

DROP TABLE IF EXISTS `clave_participante`;
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
(7, '150-20', 20, 150, 'Activo'),
(8, '16-21', 21, 150, 'Activo'),
(9, '16-22', 22, 16, 'Activo'),
(10, '16-23', 23, 16, 'Activo'),
(11, '16-24', 24, 16, 'Activo'),
(12, '150-25', 25, 150, 'Activo'),
(13, '150-26', 26, 150, 'Activo'),
(14, '16-27', 27, 16, 'Activo'),
(15, '16-28', 28, 16, 'Activo'),
(16, '16-29', 29, 16, 'Activo'),
(17, '16-30', 30, 16, 'Activo'),
(18, '16-31', 31, 16, 'Activo'),
(19, '150-33', 33, 150, 'Activo'),
(20, '16-35', 35, 16, 'Activo'),
(21, '16-37', 37, 16, 'Activo'),
(22, '16-40', 40, 16, 'Activo'),
(23, '45-41', 41, 45, 'Activo'),
(24, '16-42', 42, 16, 'Activo'),
(25, '45-45', 45, 45, 'Activo'),
(26, '45-46', 46, 45, 'Activo'),
(27, '45-47', 47, 45, 'Activo'),
(28, '45-48', 48, 45, 'Activo'),
(29, '45-49', 49, 45, 'Activo'),
(30, '16-51', 51, 16, 'Activo'),
(31, '45-52', 52, 45, 'Activo'),
(32, '45-53', 53, 45, 'Activo'),
(33, '45-54', 54, 45, 'Activo'),
(34, '45-55', 55, 45, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

DROP TABLE IF EXISTS `evento`;
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

DROP TABLE IF EXISTS `participantes`;
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
(10, 'Yanuelwwwww', 'Leal2', 'Tortoza2', 'Programacion2', '12345', '04166228987', 'yanueltexx@gmail.com', 'Caracas2', 'Venezuela2', 'Los Teques2', '3234234234234', 'Sin asistencia'),
(15, 'Yanuel Prueba', 'Leal', 'Tortoza', 'Programacion', '550321', '04166228987', 'prueba@esprueba.com', 'Caracas', 'Venezuela', 'Los Teques', '0416622898777', 'Sin asistencia'),
(18, 'Yanuel P1', 'Leal P1', 'Tortoza P1', 'Programado P1', '123456789', '1112312312312', 'Prueba1@prueba1.com', 'Los teques', 'Venezuela', 'los teques', '3234234234234', 'Con asistencia'),
(19, 'Yanuel P2', 'Leal P2', 'Tortoza P2', 'Programado P2', '123456789', '1112312312312', 'Prueba2@prueba.com', 'Los teques', 'Venezuela3', 'Los Teques', '0416622898777', 'Sin asistencia'),
(20, 'Yanuel P2', 'Leal P2', 'Tortoza P2', 'Programado P2', '123456789', '04166228987', 'Prueba2@prueba1.com', 'Los teques', 'Venezuela3', 'Los Teques', '04126515', 'Con asistencia'),
(24, 'Dariana', 'Garcia', 'Martinez', 'Web Master', '852', '04123971680', 'dariana@palmera.marketing', 'Caracas', 'Venezuela', 'Altamira', '02128374657', 'Con asistencia'),
(30, 'vielman', 'paredes', 'espinoza', 'medico', '2224', '42525245', 'vielman2@palmera.marketing', 'caracas', 'venezuela', 'altamira', '45454545', 'Sin asistencia'),
(31, 'Yanuel', 'Leal', 'Tortoza', 'Programacion', '0123456', '04166228987', 'yanuel@palmera.marketing', 'Caracas', 'Venezuela', 'Los Teques', '02123216202', 'Con asistencia'),
(33, 'vielman', 'paredes', 'espinoza', 'medico', '2224', '42525245', 'vielman@palmera.marketing', 'caracas', 'venezuela', 'altamira', '45454545', 'Con asistencia'),
(41, 'Ana MarÃ¬a', 'Palacios', 'Moreno', 'OdontologÃ­a', '413258', '04125427709', 'carmenmende55@gmail.com', 'Caracas', 'Colombia', 'La Candelaria', '04126104574', 'Con asistencia'),
(47, 'Angel', 'Palacios', 'Mendez', 'pediatria', '963241', '04128524712', 'mileydi@palmera.marketing', 'Caracas', 'Venezuela', 'victaria', '041485473201', 'Con asistencia'),
(48, 'Myriam', 'pereez', 'olivares', 'ginecologÃ­a', '063818', '04125427709', 'daniel@palmera.marketing', 'BogotÃ¡', 'Colombia', 'La Candelaria', '04126104574', 'Con asistencia'),
(49, 'Daniela', 'Palacios', 'Ãturbe', 'OdontologÃ­a', '044618', '04125427709', 'mileidysantos@yahoo.com', 'BogotÃ¡', 'Colombia', 'Calle 49', '02129847412', 'Sin asistencia'),
(51, 'Yanuel', 'Leal', 'Tortoza', 'Programador', '20746625', '04166228987', 'yanueltex@gmail.com', 'Los teques', 'Venezuela', 'Los Teques', '02123216202', 'Con asistencia'),
(52, 'Dariana', 'Garcia', 'Martinez', 'Web master', '153', '04169986532', 'darimartinez_26@hotmail.com', 'Caracas', 'Venezuela', 'Altamira', '02123659874', 'Con asistencia'),
(53, 'Luis', 'Hernadez', 'Perez', 'Dermatologo', '785', '04169986532', 'luis@hotmail.com', 'Valencia', 'Venezuela', 'Las palmeras', '02120529974', 'Con asistencia'),
(54, 'Alejandro', 'Tortoza', 'Leal', 'Programador', '21746625', '04166228987', 'neongelion@hotmail.com', 'Los teques', 'Venezuela', 'Los Teques', '3234234234234', 'Sin asistencia'),
(55, 'Ana MaeÃ­a', 'PerÃ©z', 'Monasterios', 'PediatrÃ­a', '061718', '04125427709', 'mileidy.santos@gmail.com', 'Caracas', 'Venezuela', 'Plaza Venezuela', '041485473201', 'Sin asistencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
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
(1, 'darimartinez_26@hotmail.com', 'dariana', '202cb962ac59075b964b07152d234b70', 'admin', 1, 1),
(2, 'prueba@prueba.prueba', 'prueba', 'c893bad68927b457dbed39460e6afd62', 'admin', 1, 1),
(3, 'mileidy.santos@gmail.com', 'Visitador081', '64178bf83cb7cc8292b626bc65ae89ce', 'admin', 1, 1),
(4, 'carmenmende55@gmail.com', 'Visitador 2', '92f655dad01d85cb71d71def26931ebd', 'admin', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_participante`
--

DROP TABLE IF EXISTS `usuario_participante`;
CREATE TABLE `usuario_participante` (
  `id` int(255) NOT NULL,
  `fk_usuario` int(255) NOT NULL,
  `fk_participante` int(255) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_participante`
--

INSERT INTO `usuario_participante` (`id`, `fk_usuario`, `fk_participante`, `fecha`) VALUES
(2, 3, 18, '2018-08-28 13:35:12'),
(3, 0, 25, '2018-08-29 07:59:41'),
(4, 0, 26, '2018-08-29 08:00:43'),
(5, 0, 27, '2018-08-29 08:01:47'),
(6, 0, 28, '2018-08-29 08:10:28'),
(7, 0, 29, '2018-08-29 08:24:12'),
(8, 0, 30, '2018-08-29 08:32:27'),
(9, 0, 31, '2018-08-29 08:39:55'),
(10, 1, 33, '2018-08-29 08:56:37'),
(11, 0, 35, '2018-08-30 08:16:01'),
(12, 0, 37, '2018-08-30 08:46:44'),
(13, 0, 40, '2018-08-30 12:34:15'),
(14, 4, 41, '2018-08-30 12:39:41'),
(15, 0, 42, '2018-08-30 12:49:47'),
(16, 0, 45, '2018-08-30 13:06:28'),
(17, 4, 46, '2018-08-30 13:09:57'),
(18, 0, 47, '2018-08-30 13:12:56'),
(19, 0, 48, '2018-08-30 14:00:32'),
(20, 3, 49, '2018-08-30 14:04:22'),
(21, 0, 51, '2018-08-30 14:19:58'),
(22, 0, 52, '2018-08-30 14:37:06'),
(23, 0, 53, '2018-08-30 14:42:17'),
(24, 3, 54, '2018-08-30 15:32:36'),
(25, 4, 55, '2018-08-30 15:35:10');

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
-- Indices de la tabla `usuario_participante`
--
ALTER TABLE `usuario_participante`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `clave_participante`
--
ALTER TABLE `clave_participante`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario_participante`
--
ALTER TABLE `usuario_participante`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
