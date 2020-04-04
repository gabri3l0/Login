-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-04-2020 a las 07:11:36
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectofinal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `Reservada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `Reservada`) VALUES
(33, 1),
(34, 1),
(40, 1),
(44, 1),
(53, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `id_Reserva` int(11) NOT NULL,
  `id_Usuario` int(11) NOT NULL,
  `Nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Px` int(11) NOT NULL,
  `Px_Ingresado` int(11) DEFAULT NULL,
  `Comentarios` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Mesa` int(90) DEFAULT NULL,
  `Consumo` double NOT NULL,
  `Dia` date NOT NULL,
  `Inactivo` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `reservaciones`
--

INSERT INTO `reservaciones` (`id_Reserva`, `id_Usuario`, `Nombre`, `Px`, `Px_Ingresado`, `Comentarios`, `Mesa`, `Consumo`, `Dia`, `Inactivo`) VALUES
(69, 3, 'Fernando', 10, -9, 'frfrf', 33, 0, '2019-05-18', 1),
(72, 3, 'Fernando', 3, -9, 'frfrf', 33, 0, '2019-05-31', 1),
(75, 1, 'Fernando', 3, -9, '', 33, 0, '2019-05-25', 1),
(77, 19, 'Gabriel', 9, 5, '', 44, 0, '2019-05-21', 1),
(78, 19, 'Fernando', -9, -9, '', 33, 0, '2019-05-23', 1),
(79, 1, 'Gabriel', 10, 5, '', 44, 0, '2019-05-23', 1),
(80, 1, 'Gabriel1', 4, 5, '', 33, 0, '2019-05-23', 1),
(82, 1, 'Gabriel', 10, 5, '', 44, 0, '2019-05-23', 1),
(83, 1, 'Gabriel', 3, 5, '', 44, 0, '2019-05-30', 1),
(84, 1, 'jbhhub', 34, 23, 'trdtdghf', 40, 0, '2019-07-26', 0),
(85, 1, 'Ejemplo', 3, 12, '', 53, 0, '2019-08-08', 1),
(86, 22, 'Juan Carlos', 10, NULL, 'La mesa esta lista', NULL, 0, '2020-04-03', 0),
(87, 23, 'Manuel', 4, 12, '', 33, 0, '2020-04-03', 0),
(88, 23, 'test', 4, NULL, '', NULL, 0, '2020-04-03', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Telefono` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `idCoordinador` int(11) DEFAULT NULL,
  `idCapitan` int(11) DEFAULT NULL,
  `Correo` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Contrasena` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `Nombre`, `Telefono`, `idCoordinador`, `idCapitan`, `Correo`, `Contrasena`) VALUES
(22, 'Gabriel', '8341458910', 9, 9, 'gabriel.lopez@udem.edu', '$2y$10$KojYWZXdgcVTepbUu64Vz.1paw/RR0i64LVhF4Kg46M7nhzgoD7le'),
(23, 'Fernando', '8341458910', 22, NULL, 'fernando.cepeda@udem.edu', '$2y$10$E/g1JCxkpszAFD59zkPTGOM6QkASnU72otkpIZTSF/3UE7akdwwpm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`id_Reserva`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `id_Reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
