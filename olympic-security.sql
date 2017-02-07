-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-10-2016 a las 04:16:28
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `olympic-security`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `IdRol` int(11) NOT NULL,
  `NombreRol` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`IdRol`, `NombreRol`) VALUES
(1, 'Operador'),
(2, 'Deportista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema`
--

CREATE TABLE IF NOT EXISTS `sistema` (
  `NombreSistema` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `PassSistema` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `NombreUsuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `PassUsuario` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`NombreUsuario`, `PassUsuario`) VALUES
('Avenger001', '$2y$10$AiMp6F12gcOAcoZHuzX1WefqAIHS2kgOe7WZ46YBwVwyi0Nvi45w.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioocuparol`
--

CREATE TABLE IF NOT EXISTS `usuarioocuparol` (
  `NombreUsuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `NombreSistema` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `IdRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarioocuparol`
--

INSERT INTO `usuarioocuparol` (`NombreUsuario`, `NombreSistema`, `IdRol`) VALUES
('Avenger001', 'Avenger001', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariotienesistema`
--

CREATE TABLE IF NOT EXISTS `usuariotienesistema` (
  `NombreUsuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `NombreSistema` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indices de la tabla `sistema`
--
ALTER TABLE `sistema`
  ADD PRIMARY KEY (`NombreSistema`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`NombreUsuario`);

--
-- Indices de la tabla `usuarioocuparol`
--
ALTER TABLE `usuarioocuparol`
  ADD PRIMARY KEY (`NombreUsuario`,`NombreSistema`,`IdRol`);

--
-- Indices de la tabla `usuariotienesistema`
--
ALTER TABLE `usuariotienesistema`
  ADD PRIMARY KEY (`NombreUsuario`,`NombreSistema`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `IdRol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
