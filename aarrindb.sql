-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2020 a las 15:07:57
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
-- Estructura de tabla para la tabla `applications`
--

CREATE TABLE `applications` (
  `IdApp` int(11) NOT NULL,
  `IdCompany` int(11) NOT NULL,
  `IdService` int(11) NOT NULL,
  `AppLenguage` int(11) NOT NULL,
  `LastCertificateExpiration` date DEFAULT NULL,
  `LastCertificateCertifier` varchar(250) DEFAULT NULL,
  `LastCertificateResults` varchar(1500) DEFAULT NULL,
  `NumberEmployees` int(11) NOT NULL,
  `ExternalServicesProvider` varchar(500) DEFAULT NULL,
  `ReceiveConsultancy` tinyint(1) DEFAULT NULL,
  `ConsultantName` varchar(500) DEFAULT NULL,
  `AppDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_detail`
--

CREATE TABLE `app_detail` (
  `IdAppDetail` int(11) NOT NULL,
  `IdApp` int(11) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `ShiftEmployees1` int(11) NOT NULL,
  `ShiftEmployees2` int(11) NOT NULL,
  `ShiftEmployees3` int(11) NOT NULL,
  `Activities` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `CompanyLogo` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`IdCompany`, `IdSector`, `CompanyName`, `CompanyRFC`, `CompanyAddress`, `CompanyWebsite`, `CompanyLogo`) VALUES
(2, 1001, 'Prueba S.A de C.V.', 'PRUEBA7845', 'Ramón Corona #125', 'https://www.prueba.com.mx', NULL),
(3, 1015, 'Malvados y Asociados S.A de C.V.', 'MALASO4589', 'Independencia #425', 'https://malvados.asociados.mx', NULL);

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
  `ContactCharge` varchar(300) NOT NULL,
  `ContactPassword` varbinary(20) NOT NULL,
  `ContactPhoto` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`IdContact`, `IdCompany`, `MainContact`, `ContactName`, `ContactPhone`, `ContactEmail`, `ContactCharge`, `ContactPassword`, `ContactPhoto`) VALUES
(11, 3, 1, 'Heinz Doofmenshmirtz', '5555555555', 'evil_doof@mermelada.com', 'Genio Malvado', 0x2483bb4d9af50039ba5bd69f5a16eeb9, NULL),
(12, 3, 0, 'Alois Everard Elizabeth Otto Wolfgang Hypatia Gunter Geilen Gary Cooper Von Rodenstein', '5555555555', 'evil_rodney@mermelada.com', 'Doctor del Mal', 0x2483bb4d9af50039ba5bd69f5a16eeb9, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `master_list`
--

CREATE TABLE `master_list` (
  `IdMasterList` int(11) NOT NULL,
  `IdService` int(11) NOT NULL,
  `IdSector` int(11) NOT NULL,
  `IdEmployee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `IdEmployee` int(11) NOT NULL,
  `EmployeeName` varchar(75) NOT NULL,
  `EmployeeLastName` varchar(75) NOT NULL,
  `EmployeeDegree` varchar(200) NOT NULL,
  `EmployeeBirth` date NOT NULL,
  `EmployeeContractYear` year(4) NOT NULL,
  `EmployeeCharge` varchar(150) NOT NULL,
  `EmployeeAddress` varchar(500) NOT NULL,
  `EmployeePhone` varchar(25) NOT NULL,
  `EmployeeEmail` varchar(200) NOT NULL,
  `EmployeeInsurance` varchar(30) NOT NULL,
  `EmployeeRFC` varchar(25) NOT NULL,
  `EmployeePassword` varbinary(20) NOT NULL,
  `EmployeePhoto` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`IdEmployee`, `EmployeeName`, `EmployeeLastName`, `EmployeeDegree`, `EmployeeBirth`, `EmployeeContractYear`, `EmployeeCharge`, `EmployeeAddress`, `EmployeePhone`, `EmployeeEmail`, `EmployeeInsurance`, `EmployeeRFC`, `EmployeePassword`, `EmployeePhoto`) VALUES
(1, 'Yael Alejandro', 'Santana', 'Ingeniero Infórmatico', '1995-11-23', 2020, 'Programador', 'Pánfilo Natera #20-H', '3421006559', 'ya_el1995@hotmail.com', 'KIAS5849a8', 'SAMY951123KU8', 0x066cff26d5e35df5ee74a9f26ff64f93, NULL),
(5, 'Adrian', 'Casillas', '', '0000-00-00', 2005, 'Representante LATAM', '', '', 'adn@prueba.com', '', 'CASA900909PI9', 0xaa235da8368163fbdbde2dd718035e17, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `IdRole` int(11) NOT NULL,
  `IdEmployee` int(11) NOT NULL,
  `Role_Type` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`IdRole`, `IdEmployee`, `Role_Type`) VALUES
(100, 1, 'ADMIN_ROLE'),
(101, 5, 'ADMIN_ROLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectors`
--

CREATE TABLE `sectors` (
  `IdSector` int(11) NOT NULL,
  `SectorName` varchar(120) NOT NULL,
  `SectorStatus` varchar(15) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sectors`
--

INSERT INTO `sectors` (`IdSector`, `SectorName`, `SectorStatus`) VALUES
(1001, 'Agriculture, forestry and fishing\r\n', 'Active'),
(1002, 'Mining and quarrying', 'Active'),
(1003, 'Food products, beverages and tobacco', 'Active'),
(1004, 'Textiles and textile products', 'Active'),
(1005, 'Leather and leather products', 'Active'),
(1006, 'Wood and wood products', 'Active'),
(1007, 'Pulp, paper and paper products', 'Active'),
(1008, 'Publishing companies', 'Active'),
(1009, 'Printing companies', 'Active'),
(1010, 'Manufacture of coke and refined petroleum products', 'Active'),
(1011, 'Nuclear fuel', 'Active'),
(1012, 'Chemicals, chemical products and fibres', 'Active'),
(1013, 'Pharmaceuticals', 'Active'),
(1014, 'Rubber and plastic products', 'Active'),
(1015, 'Non-metallic mineral products', 'Active'),
(1016, 'Concrete, cement, lime, plaster etc', 'Active'),
(1017, 'Basic metals and fabricated metal products', 'Active'),
(1018, 'Machinery and equipment', 'Active'),
(1019, 'Electrical and optical equipment', 'Active'),
(1020, 'Shipbuilding', 'Active'),
(1021, 'Aerospace', 'Active'),
(1022, 'Other transport equipment', 'Active'),
(1023, 'Manufacturing not elsewhere classified', 'Active'),
(1024, 'Recycling', 'Active'),
(1025, 'Electricity supply', 'Active'),
(1026, 'Gas supply', 'Active'),
(1027, 'Water supply', 'Active'),
(1028, 'Construction', 'Active'),
(1029, 'Wholesale and retail trade; Repair of motor vehicles, motorcycles and personal and household goods', 'Active'),
(1030, 'Hotels and restaurants', 'Active'),
(1031, 'Transport, storage and communication', 'Active'),
(1032, 'Financial intermediation; real estate; renting', 'Active'),
(1033, 'Information technology', 'Active'),
(1034, 'Engineering services', 'Active'),
(1035, 'Other services ', 'Active'),
(1036, 'Public administration', 'Active'),
(1037, 'Education', 'Active'),
(1038, 'Health and social work', 'Active'),
(1039, 'Other social services', 'Active'),
(1043, 'Sector de Prueba', 'Inactive');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `IdService` int(11) NOT NULL,
  `ServiceStandard` varchar(250) NOT NULL,
  `ServiceShortName` varchar(10) NOT NULL,
  `ServiceStatus` varchar(15) DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`IdService`, `ServiceStandard`, `ServiceShortName`, `ServiceStatus`) VALUES
(1, 'ISO 9001:2015', '9K', 'Available'),
(2, 'ISO 14001:2015', '14k', 'Available'),
(3, 'ISO 50001:2011', '50k', 'Available'),
(4, 'ISO 27001:2015', '27K', 'Available');

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
-- Volcado de datos para la tabla `validation_keys`
--

INSERT INTO `validation_keys` (`IdKey`, `ValidationCode`, `ValidationDate`, `ValidationEmail`) VALUES
(154, 'Q49I4E', '2020-04-17 20:33:16', 'asm_1995@outlook.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`IdApp`),
  ADD KEY `fk_services` (`IdService`);

--
-- Indices de la tabla `app_detail`
--
ALTER TABLE `app_detail`
  ADD PRIMARY KEY (`IdAppDetail`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`IdCompany`),
  ADD UNIQUE KEY `CompanyRFC` (`CompanyRFC`),
  ADD KEY `fk_sectors` (`IdSector`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`IdContact`),
  ADD KEY `fk_companies` (`IdCompany`);

--
-- Indices de la tabla `master_list`
--
ALTER TABLE `master_list`
  ADD PRIMARY KEY (`IdMasterList`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`IdEmployee`),
  ADD UNIQUE KEY `unique_email` (`EmployeeEmail`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`IdRole`),
  ADD KEY `fk_personal` (`IdEmployee`);

--
-- Indices de la tabla `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`IdSector`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`IdService`);

--
-- Indices de la tabla `validation_keys`
--
ALTER TABLE `validation_keys`
  ADD PRIMARY KEY (`IdKey`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `applications`
--
ALTER TABLE `applications`
  MODIFY `IdApp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `app_detail`
--
ALTER TABLE `app_detail`
  MODIFY `IdAppDetail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `IdCompany` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `IdContact` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `master_list`
--
ALTER TABLE `master_list`
  MODIFY `IdMasterList` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `IdEmployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `IdRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `sectors`
--
ALTER TABLE `sectors`
  MODIFY `IdSector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1044;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `IdService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `validation_keys`
--
ALTER TABLE `validation_keys`
  MODIFY `IdKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_services` FOREIGN KEY (`IdService`) REFERENCES `services` (`IdService`) ON UPDATE NO ACTION;

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

--
-- Filtros para la tabla `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `fk_personal` FOREIGN KEY (`IdEmployee`) REFERENCES `personal` (`IdEmployee`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
