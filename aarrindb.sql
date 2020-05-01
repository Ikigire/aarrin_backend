-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-05-2020 a las 17:47:10
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
  `CompanyPassword` varbinary(20) NOT NULL,
  `CompanyLogo` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`IdCompany`, `IdSector`, `CompanyName`, `CompanyRFC`, `CompanyAddress`, `CompanyWebsite`, `CompanyPassword`, `CompanyLogo`) VALUES
(2, 1001, 'Prueba S.A de C.V.', 'PRUEBA7845', 'Ramón Corona #125', 'https://www.prueba.com.mx', 0x5411a461e39fe28709a073078ffc3e42, NULL),
(3, 1015, 'Malvados y Asociados S.A de C.V.', 'MALASO4589', 'Independencia #425', 'https://malvados.asociados.mx', 0xdf3e0d5bbde5b0962b47b8b6cca37428, NULL);

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
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`IdContact`, `IdCompany`, `MainContact`, `ContactName`, `ContactPhone`, `ContactEmail`, `ContactCharge`) VALUES
(11, 3, 1, 'Heinz Doofenzmirt', '5555555555', 'evil_doof@mermelada.com', 'Genio malvado');

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
(1, 'Adrian', 'Casillas', 'Lic. Informático', '1985-01-01', 2000, 'Representante LATAM', 'Domicilio Particular #12', '5555555555', 'ya_el1995@hotmail.com', 'KIAS5849a8', 'CASA850101PL5', 0x066cff26d5e35df5ee74a9f26ff64f93, NULL);

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
(100, 1, 'ADMIN_ROLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectors`
--

CREATE TABLE `sectors` (
  `IdSector` int(11) NOT NULL,
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
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `IdService` int(11) NOT NULL,
  `ServiceStandard` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `IdContact` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `master_list`
--
ALTER TABLE `master_list`
  MODIFY `IdMasterList` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `IdEmployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `IdRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `sectors`
--
ALTER TABLE `sectors`
  MODIFY `IdSector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1043;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `IdService` int(11) NOT NULL AUTO_INCREMENT;

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
