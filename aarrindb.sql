-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2020 a las 14:12:13
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aarrindb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `IdCompany` int(100) NOT NULL,
  `IdSector` int(11) NOT NULL,
  `CompanyName` varchar(250) NOT NULL,
  `CompanyRFC` varchar(20) NOT NULL,
  `CompanyAddress` varchar(500) NOT NULL,
  `CompanyWebsite` varchar(250) DEFAULT NULL,
  `CompanyPassword` varbinary(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`IdCompany`, `IdSector`, `CompanyName`, `CompanyRFC`, `CompanyAddress`, `CompanyWebsite`, `CompanyPassword`) VALUES
(2, 1001, 'Prueba S.A de C.V.', 'PRUEBA7845', 'Ramón Corona #125', 'https://www.prueba.com.mx', 0x5411a461e39fe28709a073078ffc3e42),
(3, 1015, 'Malvados y Asociados S.A de C.V.', 'MALASO4589', 'Independencia #425', 'https://malvados.asociados.mx', 0xdf3e0d5bbde5b0962b47b8b6cca37428);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `IdContact` int(100) NOT NULL,
  `IdCompany` int(11) NOT NULL,
  `MainContact` tinyint(1) DEFAULT 0,
  `ContactName` varchar(250) NOT NULL,
  `ContactPhone` varchar(15) NOT NULL,
  `ContactEmail` varchar(250) NOT NULL,
  `ContactCharge` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `contacts`
--
DELIMITER $$
CREATE TRIGGER `unique_main_contact_insert` AFTER INSERT ON `contacts` FOR EACH ROW IF (NEW.MainContact = 1) THEN BEGIN
UPDATE contacts SET MainContact = 0 WHERE IdCompany = NEW.IdCompany AND IdContact <> NEW.IdContact;
END; END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `unique_main_contact_update` AFTER UPDATE ON `contacts` FOR EACH ROW IF(NEW.MainContact = 1) THEN BEGIN
UPDATE contacts SET MainContact = 0 WHERE IdCompany = NEW.IdCompany AND IdContact <> NEW.IdContact;
END; END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectors`
--

CREATE TABLE `sectors` (
  `IdSector` int(10) NOT NULL,
  `SectorName` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sectors`
--

INSERT INTO `sectors` (`IdSector`, `SectorName`) VALUES
(1001, 'Agriculture, forestry and fishing\r\n'),
(1002, 'Mining and quarrying'),
(1003, 'Food products, beverages and tobacco'),
(1004, 'Textiles and textile products'),
(1005, 'Leather and leather products'),
(1006, 'Wood and wood products'),
(1007, 'Pulp, paper and paper products'),
(1008, 'Publishing companies'),
(1009, 'Printing companies'),
(1010, 'Manufacture of coke and refined petroleum products'),
(1011, 'Nuclear fuel'),
(1012, 'Chemicals, chemical products and fibres'),
(1013, 'Pharmaceuticals'),
(1014, 'Rubber and plastic products'),
(1015, 'Non-metallic mineral products'),
(1016, 'Concrete, cement, lime, plaster etc'),
(1017, 'Basic metals and fabricated metal products'),
(1018, 'Machinery and equipment'),
(1019, 'Electrical and optical equipment'),
(1020, 'Shipbuilding'),
(1021, 'Aerospace'),
(1022, 'Other transport equipment'),
(1023, 'Manufacturing not elsewhere classified'),
(1024, 'Recycling'),
(1025, 'Electricity supply'),
(1026, 'Gas supply'),
(1027, 'Water supply'),
(1028, 'Construction'),
(1029, 'Wholesale and retail trade; Repair of motor vehicles, motorcycles and personal and household goods'),
(1030, 'Hotels and restaurants'),
(1031, 'Transport, storage and communication'),
(1032, 'Financial intermediation; real estate; renting'),
(1033, 'Information technology'),
(1034, 'Engineering services'),
(1035, 'Other services '),
(1036, 'Public administration'),
(1037, 'Education'),
(1038, 'Health and social work'),
(1039, 'Other social services');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `validation_keys`
--

CREATE TABLE `validation_keys` (
  `IdKey` int(11) NOT NULL,
  `ValidationCode` varchar(6) NOT NULL,
  `ValidationDate` datetime DEFAULT current_timestamp(),
  `ValidationEmail` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`IdCompany`),
  ADD KEY `fk_sectors` (`IdSector`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`IdContact`),
  ADD KEY `fk_companies` (`IdCompany`);

--
-- Indices de la tabla `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`IdSector`);

--
-- Indices de la tabla `validation_keys`
--
ALTER TABLE `validation_keys`
  ADD PRIMARY KEY (`IdKey`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `IdCompany` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `IdContact` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sectors`
--
ALTER TABLE `sectors`
  MODIFY `IdSector` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1043;

--
-- AUTO_INCREMENT de la tabla `validation_keys`
--
ALTER TABLE `validation_keys`
  MODIFY `IdKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `fk_sectors` FOREIGN KEY (`IdSector`) REFERENCES `sectors` (`IdSector`) ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_companies` FOREIGN KEY (`IdCompany`) REFERENCES `companies` (`IdCompany`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
