-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2022 a las 03:26:29
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cap_softura_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_tipo_contacto`
--

CREATE TABLE `catalogo_tipo_contacto` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipo_catalogo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `catalogo_tipo_contacto`
--

INSERT INTO `catalogo_tipo_contacto` (`id`, `tipo_catalogo`) VALUES
(1, 'Teléfono '),
(2, 'Correo'),
(3, 'WhatsApp'),
(4, 'Movil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto_empleados`
--

CREATE TABLE `contacto_empleados` (
  `id` int(10) UNSIGNED NOT NULL,
  `dato_contacto` varchar(250) DEFAULT NULL,
  `catalogo_tipo_contacto_id` int(10) UNSIGNED NOT NULL,
  `empleados_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `paterno` varchar(45) NOT NULL,
  `materno` varchar(45) DEFAULT NULL,
  `direccion` tinytext NOT NULL,
  `genero` enum('H','M') DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `estado_civil` enum('S','C','D','V') DEFAULT NULL COMMENT 'S = soltero\nC = casado\nD = divorciado\nV = viudo ',
  `seguro_social` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo_tipo_contacto`
--
ALTER TABLE `catalogo_tipo_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacto_empleados`
--
ALTER TABLE `contacto_empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contacto_empleados_catalogo_tipo_contacto_idx` (`catalogo_tipo_contacto_id`),
  ADD KEY `fk_contacto_empleados_empleados1_idx` (`empleados_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo_tipo_contacto`
--
ALTER TABLE `catalogo_tipo_contacto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `contacto_empleados`
--
ALTER TABLE `contacto_empleados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contacto_empleados`
--
ALTER TABLE `contacto_empleados`
  ADD CONSTRAINT `fk_contacto_empleados_catalogo_tipo_contacto` FOREIGN KEY (`catalogo_tipo_contacto_id`) REFERENCES `catalogo_tipo_contacto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contacto_empleados_empleados1` FOREIGN KEY (`empleados_id`) REFERENCES `empleados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
