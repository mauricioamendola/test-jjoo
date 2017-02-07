-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2016 a las 07:43:54
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
  `IdActividad` double NOT NULL AUTO_INCREMENT,
  `IdLugar` double NOT NULL,
  `IdPersona` double NOT NULL,
  `FechahoraActvidad` date NOT NULL,
  `TipoActividad` enum('practica','competencia','asistencia','recreativa','otros') NOT NULL,
  `Observaciones` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`IdActividad`),
  KEY `IdLugar` (`IdLugar`),
  KEY `IdPersona` (`IdPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE IF NOT EXISTS `administrador` (
  `IdPersona` double NOT NULL,
  PRIMARY KEY (`IdPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE IF NOT EXISTS `auditoria` (
  `IdAuditoria` double NOT NULL AUTO_INCREMENT,
  `IdPersona` double NOT NULL,
  `FechahoraAuditoria` datetime NOT NULL,
  `Tabla` varchar(20) NOT NULL,
  `Atributo` varchar(20) NOT NULL,
  `ValorAnterior` varchar(260) NOT NULL,
  `ValorNuevo` varchar(260) NOT NULL,
  `Accion` enum('alta','baja','modificacion') NOT NULL,
  PRIMARY KEY (`IdAuditoria`),
  KEY `IdPersona` (`IdPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristica`
--

CREATE TABLE IF NOT EXISTS `caracteristica` (
  `IdCaracteristica` double NOT NULL AUTO_INCREMENT,
  `NombreCaracteristica` varchar(40) NOT NULL,
  `DescripcionCaracteristica` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdCaracteristica`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `IdCategoria` double NOT NULL AUTO_INCREMENT,
  `IdDisciplina` double NOT NULL,
  `NombreCategoria` varchar(50) NOT NULL,
  `Genero` enum('masculino','femenino','mixto') NOT NULL,
  `DescripcionCategoria` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`IdCategoria`),
  KEY `IdDisciplina` (`IdDisciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competencia`
--

CREATE TABLE IF NOT EXISTS `competencia` (
  `IdCompetencia` double NOT NULL AUTO_INCREMENT,
  `NombreCompetencia` varchar(50) NOT NULL,
  `CantidadCompetencia` int(11) DEFAULT NULL,
  `TipoCompetencia` enum('octavos','cuartos','semifinal','final','grupo') NOT NULL,
  PRIMARY KEY (`IdCompetencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competidor`
--

CREATE TABLE IF NOT EXISTS `competidor` (
  `IdCompetidor` double NOT NULL AUTO_INCREMENT,
  `IdEquipo` double NOT NULL,
  `FechaAnual` date NOT NULL,
  `IdEvento` double NOT NULL,
  `IdCompetencia` double NOT NULL,
  PRIMARY KEY (`IdCompetidor`),
  KEY `IdEquipo` (`IdEquipo`),
  KEY `IdEvento` (`IdEvento`),
  KEY `IdCompetencia` (`IdCompetencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conforma`
--

CREATE TABLE IF NOT EXISTS `conforma` (
  `IdEquipo` double NOT NULL,
  `IdPersona` double NOT NULL,
  PRIMARY KEY (`IdEquipo`),
  KEY `IdEquipo` (`IdEquipo`),
  KEY `IdPersona` (`IdPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deportista`
--

CREATE TABLE IF NOT EXISTS `deportista` (
  `IdPersona` double NOT NULL,
  `AlturaDeportista` int(11) DEFAULT NULL,
  `PesoDeportista` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disciplina`
--

CREATE TABLE IF NOT EXISTS `disciplina` (
  `IdDisciplina` double NOT NULL AUTO_INCREMENT,
  `NombreDisciplina` varchar(20) NOT NULL,
  `DescripcionDisciplina` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`IdDisciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distancia`
--

CREATE TABLE IF NOT EXISTS `distancia` (
  `IdResultado` double NOT NULL,
  `Metros` decimal(10,0) NOT NULL,
  PRIMARY KEY (`IdResultado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE IF NOT EXISTS `equipo` (
  `IdEquipo` double NOT NULL AUTO_INCREMENT,
  `IdCategoria` double NOT NULL,
  `NombreEquipo` varchar(50) NOT NULL,
  `CapacidadEquipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEquipo`),
  KEY `IdCategoria` (`IdCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `IdEvento` double NOT NULL AUTO_INCREMENT,
  `IdLugar` double NOT NULL,
  `FechahoraEvento` datetime NOT NULL,
  `PrecioEntrada` decimal(10,0) DEFAULT NULL,
  `EstadoEvento` enum('suspendido','activo','finalizado','programado') NOT NULL,
  PRIMARY KEY (`IdEvento`),
  KEY `IdLugar` (`IdLugar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico`
--

CREATE TABLE IF NOT EXISTS `historico` (
  `IdHistorico` double NOT NULL AUTO_INCREMENT,
  `IdCompetidor` double NOT NULL,
  `TipoHistorico` enum('oro','plata','bronce','mundial','olimpico','clasificacion') NOT NULL,
  `FechaHistorico` date NOT NULL,
  `PuntuacionHistorico` varchar(70) NOT NULL,
  `Posicion` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdHistorico`),
  KEY `IdCompetidor` (`IdCompetidor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instalacion`
--

CREATE TABLE IF NOT EXISTS `instalacion` (
  `IdLugar` double NOT NULL,
  `CapacidadInstalacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdLugar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interes`
--

CREATE TABLE IF NOT EXISTS `interes` (
  `IdInteres` double NOT NULL AUTO_INCREMENT,
  `IdVisitante` double DEFAULT NULL,
  `IdDeportista` double DEFAULT NULL,
  `IdDisciplina` double DEFAULT NULL,
  `IdEquipo` double DEFAULT NULL,
  `IdEvento` double DEFAULT NULL,
  `IdPais` double DEFAULT NULL,
  PRIMARY KEY (`IdInteres`),
  KEY `IdVisitante` (`IdVisitante`),
  KEY `IdPersona` (`IdDeportista`),
  KEY `IdDisciplina` (`IdDisciplina`),
  KEY `IdEquipo` (`IdEquipo`),
  KEY `IdEvento` (`IdEvento`),
  KEY `IdPais` (`IdPais`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

CREATE TABLE IF NOT EXISTS `lugar` (
  `IdLugar` double NOT NULL AUTO_INCREMENT,
  `IdSede` double NOT NULL,
  `NombreLugar` varchar(80) NOT NULL,
  `DireccionLugar` varchar(80) DEFAULT NULL,
  `SitiowebLugar` varchar(50) DEFAULT NULL,
  `LatitudLugar` float(10,6) DEFAULT NULL,
  `LongitudLugar` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`IdLugar`),
  KEY `IdSede` (`IdSede`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficina`
--

CREATE TABLE IF NOT EXISTS `oficina` (
  `IdLugar` double NOT NULL,
  PRIMARY KEY (`IdLugar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador`
--

CREATE TABLE IF NOT EXISTS `operador` (
  `IdPersona` double NOT NULL,
  PRIMARY KEY (`IdPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `IdPais` double NOT NULL AUTO_INCREMENT,
  `IdRegion` double NOT NULL,
  `NombrePais` varchar(40) NOT NULL,
  `CodigoPais` varchar(3) NOT NULL,
  PRIMARY KEY (`IdPais`),
  UNIQUE KEY `CodigoPais` (`CodigoPais`),
  KEY `IdRegion` (`IdRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante`
--

CREATE TABLE IF NOT EXISTS `participante` (
  `IdPersona` double NOT NULL,
  `IdPais` double NOT NULL,
  PRIMARY KEY (`IdPersona`),
  KEY `IdPais` (`IdPais`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `IdPersona` double NOT NULL AUTO_INCREMENT,
  `NombreUsuario` varchar(20) NOT NULL,
  `CorreoPersona` varchar(40) NOT NULL,
  `NombrePersona` varchar(50) DEFAULT NULL,
  `ApellidoPersona` varchar(50) DEFAULT NULL,
  `FotoPersona` varchar(40) DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`IdPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE IF NOT EXISTS `personal` (
  `IdPersona` double NOT NULL,
  `TipoPersonal` enum('medico','cocinero','tecnico','entrenador','otro') NOT NULL,
  PRIMARY KEY (`IdPersona`),
  KEY `IdPersona` (`IdPersona`),
  KEY `TipoPersonal` (`TipoPersonal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos`
--

CREATE TABLE IF NOT EXISTS `puntos` (
  `IdResultado` double NOT NULL,
  `Puntaje` int(11) NOT NULL,
  PRIMARY KEY (`IdResultado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `IdRegion` double NOT NULL AUTO_INCREMENT,
  `NombreRegion` varchar(30) NOT NULL,
  PRIMARY KEY (`IdRegion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado`
--

CREATE TABLE IF NOT EXISTS `resultado` (
  `IdResultado` double NOT NULL AUTO_INCREMENT,
  `IdCompetidor` double NOT NULL,
  `NombreResultado` varchar(20) NOT NULL,
  `TipoResultado` enum('valido','descalificado','doping','no_finalizo') NOT NULL,
  `Nota` varchar(250) DEFAULT NULL,
  `Final` tinyint(1) NOT NULL,
  PRIMARY KEY (`IdResultado`),
  KEY `IdCompetidor` (`IdCompetidor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE IF NOT EXISTS `sede` (
  `IdSede` double NOT NULL AUTO_INCREMENT,
  `NombreSede` varchar(40) NOT NULL,
  `LatitudSede` float(10,6) NOT NULL,
  `LongitudSede` float(10,6) NOT NULL,
  PRIMARY KEY (`IdSede`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE IF NOT EXISTS `servicio` (
  `IdLugar` double NOT NULL,
  `TipoServicio` enum('restaurant','hotel','seguridad','teatro','cine','shopping','atencion_medica') NOT NULL,
  PRIMARY KEY (`IdLugar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono`
--

CREATE TABLE IF NOT EXISTS `telefono` (
  `IdTelefono` double NOT NULL AUTO_INCREMENT,
  `IdLugar` double NOT NULL,
  `NumeroTelefono` varchar(30) NOT NULL,
  PRIMARY KEY (`IdTelefono`),
  KEY `IdLugar` (`IdLugar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempo`
--

CREATE TABLE IF NOT EXISTS `tiempo` (
  `IdResultado` double NOT NULL,
  `Hora` int(11) DEFAULT NULL,
  `Minuto` int(11) DEFAULT NULL,
  `Segundo` int(11) DEFAULT NULL,
  `Decima` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdResultado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiene`
--

CREATE TABLE IF NOT EXISTS `tiene` (
  `IdLugar` double NOT NULL,
  `IdCaracteristica` double NOT NULL,
  KEY `IdLugar` (`IdLugar`),
  KEY `IdCaracteristica` (`IdCaracteristica`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitante`
--

CREATE TABLE IF NOT EXISTS `visitante` (
  `IdPersona` double NOT NULL,
  `FnacVisitante` date DEFAULT NULL,
  `Nacionalidad` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`IdPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `fk_idlugar1` FOREIGN KEY (`IdLugar`) REFERENCES `lugar` (`IdLugar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idpersona1` FOREIGN KEY (`IdPersona`) REFERENCES `participante` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `fk_idpersona2` FOREIGN KEY (`IdPersona`) REFERENCES `persona` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `fk_idpersona3` FOREIGN KEY (`IdPersona`) REFERENCES `persona` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_iddisciplina1` FOREIGN KEY (`IdDisciplina`) REFERENCES `disciplina` (`IdDisciplina`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `competidor`
--
ALTER TABLE `competidor`
  ADD CONSTRAINT `fk_idcompetencia1` FOREIGN KEY (`IdCompetencia`) REFERENCES `competencia` (`IdCompetencia`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idequipo1` FOREIGN KEY (`IdEquipo`) REFERENCES `equipo` (`IdEquipo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idevento1` FOREIGN KEY (`IdEvento`) REFERENCES `evento` (`IdEvento`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `conforma`
--
ALTER TABLE `conforma`
  ADD CONSTRAINT `fk_idequipo2` FOREIGN KEY (`IdEquipo`) REFERENCES `equipo` (`IdEquipo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idpersona4` FOREIGN KEY (`IdPersona`) REFERENCES `persona` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `deportista`
--
ALTER TABLE `deportista`
  ADD CONSTRAINT `fk_idpersona5` FOREIGN KEY (`IdPersona`) REFERENCES `participante` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `distancia`
--
ALTER TABLE `distancia`
  ADD CONSTRAINT `fk_idresultado1` FOREIGN KEY (`IdResultado`) REFERENCES `resultado` (`IdResultado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `fk_idcategoria1` FOREIGN KEY (`IdCategoria`) REFERENCES `categoria` (`IdCategoria`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `fk_idlugar2` FOREIGN KEY (`IdLugar`) REFERENCES `lugar` (`IdLugar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `fk_idcompetidor1` FOREIGN KEY (`IdCompetidor`) REFERENCES `competidor` (`IdCompetidor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `instalacion`
--
ALTER TABLE `instalacion`
  ADD CONSTRAINT `fk_idlugar3` FOREIGN KEY (`IdLugar`) REFERENCES `lugar` (`IdLugar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `interes`
--
ALTER TABLE `interes`
  ADD CONSTRAINT `fk_iddeportista` FOREIGN KEY (`IdDeportista`) REFERENCES `deportista` (`IdPersona`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iddisciplina2` FOREIGN KEY (`IdDisciplina`) REFERENCES `disciplina` (`IdDisciplina`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idequipo3` FOREIGN KEY (`IdEquipo`) REFERENCES `equipo` (`IdEquipo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idevento2` FOREIGN KEY (`IdEvento`) REFERENCES `evento` (`IdEvento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idpais` FOREIGN KEY (`IdPais`) REFERENCES `pais` (`IdPais`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Idvisitante` FOREIGN KEY (`IdVisitante`) REFERENCES `visitante` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD CONSTRAINT `fk_idsede1` FOREIGN KEY (`IdSede`) REFERENCES `sede` (`IdSede`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `oficina`
--
ALTER TABLE `oficina`
  ADD CONSTRAINT `fk_idlugar4` FOREIGN KEY (`IdLugar`) REFERENCES `lugar` (`IdLugar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `operador`
--
ALTER TABLE `operador`
  ADD CONSTRAINT `fk_idpersona8` FOREIGN KEY (`IdPersona`) REFERENCES `persona` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pais`
--
ALTER TABLE `pais`
  ADD CONSTRAINT `fk_idregion1` FOREIGN KEY (`IdRegion`) REFERENCES `region` (`IdRegion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `participante`
--
ALTER TABLE `participante`
  ADD CONSTRAINT `fk_idpais1` FOREIGN KEY (`IdPais`) REFERENCES `pais` (`IdPais`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idpersona9` FOREIGN KEY (`IdPersona`) REFERENCES `persona` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `fk_idpersona10` FOREIGN KEY (`IdPersona`) REFERENCES `participante` (`IdPersona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD CONSTRAINT `fk_idresultado2` FOREIGN KEY (`IdResultado`) REFERENCES `resultado` (`IdResultado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `resultado`
--
ALTER TABLE `resultado`
  ADD CONSTRAINT `fk_idcompetidor2` FOREIGN KEY (`IdCompetidor`) REFERENCES `competidor` (`IdCompetidor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `fk_idlugar5` FOREIGN KEY (`IdLugar`) REFERENCES `lugar` (`IdLugar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD CONSTRAINT `fk_idlugar6` FOREIGN KEY (`IdLugar`) REFERENCES `lugar` (`IdLugar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tiempo`
--
ALTER TABLE `tiempo`
  ADD CONSTRAINT `fk_idresultado3` FOREIGN KEY (`IdResultado`) REFERENCES `resultado` (`IdResultado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tiene`
--
ALTER TABLE `tiene`
  ADD CONSTRAINT `fk_idcaracteristica1` FOREIGN KEY (`IdCaracteristica`) REFERENCES `caracteristica` (`IdCaracteristica`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idlugar8` FOREIGN KEY (`IdLugar`) REFERENCES `lugar` (`IdLugar`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `visitante`
--
ALTER TABLE `visitante`
  ADD CONSTRAINT `fk_idpersona11` FOREIGN KEY (`IdPersona`) REFERENCES `persona` (`IdPersona`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
