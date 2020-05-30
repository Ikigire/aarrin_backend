-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2020 a las 05:27:41
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `IdContact` int(11) NOT NULL,
  `IdService` int(11) NOT NULL,
  `IdSector` int(11) NOT NULL,
  `AppLenguage` varchar(25) NOT NULL,
  `LastCertificateExpiration` date DEFAULT NULL,
  `LastCertificateCertifier` varchar(250) DEFAULT NULL,
  `LastCertificateResults` varchar(1500) DEFAULT NULL,
  `NumberEmployees` int(11) NOT NULL,
  `ExternalServicesProvider` varchar(500) DEFAULT NULL,
  `ReceiveConsultancy` tinyint(1) DEFAULT NULL,
  `ConsultantName` varchar(500) DEFAULT NULL,
  `AppDate` datetime NOT NULL,
  `AppStatus` varchar(60) DEFAULT 'On Review'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `applications`
--

INSERT INTO `applications` (`IdApp`, `IdCompany`, `IdContact`, `IdService`, `IdSector`, `AppLenguage`, `LastCertificateExpiration`, `LastCertificateCertifier`, `LastCertificateResults`, `NumberEmployees`, `ExternalServicesProvider`, `ReceiveConsultancy`, `ConsultantName`, `AppDate`, `AppStatus`) VALUES
(4, 20, 22, 3, 1022, 'Spanish', NULL, NULL, NULL, 25, NULL, NULL, NULL, '2020-05-27 21:22:30', 'On Review'),
(5, 19, 21, 2, 1029, 'Spanish', NULL, NULL, NULL, 15, NULL, NULL, NULL, '2020-05-28 07:22:32', 'On Review'),
(6, 3, 12, 2, 1029, 'English', NULL, NULL, NULL, 6, NULL, NULL, NULL, '2020-05-29 04:26:11', 'On Review');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_detail`
--

CREATE TABLE `app_detail` (
  `IdAppDetail` int(11) NOT NULL,
  `IdApp` int(11) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `Shift1` varchar(20) DEFAULT NULL,
  `Shift1Employees` int(11) DEFAULT NULL,
  `Shift2` varchar(20) DEFAULT NULL,
  `Shift2Employees` int(11) DEFAULT NULL,
  `Shift3` varchar(20) DEFAULT NULL,
  `Shift3Employees` int(11) DEFAULT NULL,
  `Activities` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `app_detail`
--

INSERT INTO `app_detail` (`IdAppDetail`, `IdApp`, `Address`, `Shift1`, `Shift1Employees`, `Shift2`, `Shift2Employees`, `Shift3`, `Shift3Employees`, `Activities`) VALUES
(7, 4, 'Dirección', NULL, 10, NULL, NULL, NULL, NULL, 'Actividades'),
(8, 4, 'Dirección', NULL, 10, NULL, NULL, NULL, NULL, 'Actividades'),
(9, 5, 'Dirección', NULL, 10, NULL, NULL, NULL, NULL, 'Actividades'),
(10, 6, 'Dirección', NULL, 6, NULL, NULL, NULL, NULL, 'Actividades');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `IdCompany` int(100) NOT NULL,
  `CompanyName` varchar(250) NOT NULL,
  `CompanyRFC` varchar(20) NOT NULL,
  `CompanyAddress` varchar(500) NOT NULL,
  `CompanyWebsite` varchar(250) DEFAULT NULL,
  `CompanyLogo` varchar(250) DEFAULT NULL,
  `CompanyStatus` varchar(20) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`IdCompany`, `CompanyName`, `CompanyRFC`, `CompanyAddress`, `CompanyWebsite`, `CompanyLogo`, `CompanyStatus`) VALUES
(2, 'Prueba S.A de C.V.', 'PRUEBA22222', 'Ramón Corona 125', 'https://www.prueba.com.mx', NULL, 'Active'),
(3, 'Malvados y Asociados S.A de C.V.', 'MALASO4589', 'Independencia 425', 'https://malvados.asociados.mx', NULL, 'Active'),
(19, 'Organización Sin un Buen Acrónimo', 'OSBA020202JI9', 'Pánfilo Natera 20-H', 'https://phineasyferb.fandom.com/es/wiki/Doofenshmirtz_Malvados_y_Asociados', NULL, 'Active'),
(20, 'GreenTellus', 'GTE200109BEA', 'Tlaquepaque ', 'www.greentellus.com', NULL, 'Active'),
(21, 'Patitos Company. SA DE CV', 'PATC250520HJ8', 'AV. PATRIA 1120 Col. Chamichines, Guadalajara, Jal.', '', NULL, 'Active');

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
  `ContactPhoto` varchar(500) DEFAULT NULL,
  `ContactStatus` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`IdContact`, `IdCompany`, `MainContact`, `ContactName`, `ContactPhone`, `ContactEmail`, `ContactCharge`, `ContactPassword`, `ContactPhoto`, `ContactStatus`) VALUES
(11, 3, 1, 'Heinz Doofmenshmirtz', '123456789', 'evil_doof@mermelada.com', 'Genio Malvado', 0x2483bb4d9af50039ba5bd69f5a16eeb9, NULL, 'Active'),
(12, 3, 0, 'Alois Everard Elizabeth Otto Wolfgang Hypatia Gunter Geilen Gary Cooper Von Rodenstein', '5555555555', 'evil_rodney@mermelada.com', 'Doctor del Mal', 0x2483bb4d9af50039ba5bd69f5a16eeb9, NULL, 'Active'),
(21, 19, 1, 'Mayor Francis Monograma', '3421006559', 'asm_1995@outlook.com', 'Lider de la organización', 0x2483bb4d9af50039ba5bd69f5a16eeb9, NULL, 'Active'),
(22, 20, 1, 'Alberto', '3316051393', 'contact.greentellus@gmail.com', 'General Manager', 0x8b0d7e2cc3145de191f3483d06a1fbbe, NULL, 'Active'),
(23, 21, 1, 'Diana Cortés', '3311957480', 'dianjcortess@gmail.com', 'VENTAS', 0x35438abf65edc15410d84ee34c4d6ee3, NULL, 'Active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso9kcomplement`
--

CREATE TABLE `iso9kcomplement` (
  `IdApp` int(11) NOT NULL,
  `ScopeActivities` varchar(500) NOT NULL,
  `NumberProcesses` int(11) NOT NULL,
  `LegalRequirements` varchar(500) NOT NULL,
  `CriticalComplaint` varchar(500) DEFAULT NULL,
  `ProcessAutomationLevel` varchar(500) NOT NULL,
  `DesignResponsability` varchar(500) DEFAULT NULL,
  `Justification` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso14kcomplement`
--

CREATE TABLE `iso14kcomplement` (
  `IdApp` int(11) NOT NULL,
  `ScopeActivities` varchar(500) NOT NULL,
  `NumberProcesses` int(11) NOT NULL,
  `LegalRequirements` varchar(500) NOT NULL,
  `OperationalControls` varchar(500) NOT NULL,
  `CriticalComplaint` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `iso14kcomplement`
--

INSERT INTO `iso14kcomplement` (`IdApp`, `ScopeActivities`, `NumberProcesses`, `LegalRequirements`, `OperationalControls`, `CriticalComplaint`) VALUES
(5, 'Actividades', 3, 'Requerimiento Legales', 'Safety Control', NULL),
(6, 'Actividades', 3, 'Requerimiento Legales', 'Safety Control', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso22kcomplement`
--

CREATE TABLE `iso22kcomplement` (
  `IdApp` int(11) NOT NULL,
  `NumberHACCP` int(11) NOT NULL,
  `GeneralDescription` varchar(500) NOT NULL,
  `NumberLinesProducts` int(11) NOT NULL,
  `Seasonality` varchar(500) NOT NULL,
  `LegalRequirements` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `iso22kcomplement`
--

INSERT INTO `iso22kcomplement` (`IdApp`, `NumberHACCP`, `GeneralDescription`, `NumberLinesProducts`, `Seasonality`, `LegalRequirements`) VALUES
(4, 2, 'Descripción', 6, 'Primavera', 'Requerimiento Legales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso45kcomplement`
--

CREATE TABLE `iso45kcomplement` (
  `IdApp` int(11) NOT NULL,
  `ScopeActivities` varchar(500) NOT NULL,
  `NumberProcesses` int(11) NOT NULL,
  `LegalRequirements` varchar(500) NOT NULL,
  `FatalitiesRate` int(11) NOT NULL,
  `AccidentsRate` int(11) NOT NULL,
  `InjuriesRate` int(11) NOT NULL,
  `NearMissRate` int(11) NOT NULL,
  `OHSMSAudit` varchar(500) DEFAULT NULL,
  `HighLevelRisks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `EmployeePhoto` varchar(250) DEFAULT NULL,
  `EmployeeStatus` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`IdEmployee`, `EmployeeName`, `EmployeeLastName`, `EmployeeDegree`, `EmployeeBirth`, `EmployeeContractYear`, `EmployeeCharge`, `EmployeeAddress`, `EmployeePhone`, `EmployeeEmail`, `EmployeeInsurance`, `EmployeeRFC`, `EmployeePassword`, `EmployeePhoto`, `EmployeeStatus`) VALUES
(1, 'Yael Alejandro', 'Santana Michel', 'Ing. Infórmatico', '1995-11-23', 2020, 'Desarrollador', 'Pánfilo Natera 20', '3421006559', 'ya_el1995@hotmail.com', 'SAMY951', 'SAMY951123KU8', 0x4d9afa4ab36f4fe0da2273d29561f9e3, 'https://aarrin.com/mobile/app_resources/personal/profile_1.Imageimage-pqwe82354daloihd.jpeg', 'Active'),
(6, 'Alberto', 'Tello', '', '0000-00-00', 2000, 'Puesto', '', '', 'el_tello23@msn.com', '', 'ABCD000000pl9', 0x4a2439cb5a800f52ad60e5ac6daa7a18, NULL, 'Active'),
(9, 'Adrian', 'Casillas', '', '0000-00-00', 2000, 'Representante LATAM', '', '', 'acasillas.bernal@gmail.com', '', 'ABCD000000LP0', 0x7d0a08de8767e941188fa3a37b4fdb13, NULL, 'Active'),
(10, 'Hander', 'García Torres', 'Ing Infomatico', '1995-09-07', 2020, 'Programador', 'Tonila', '3411454677', 'handergarciatores@gmail.com', '313', 'GATH950202PL9', 0x7accd077b9a6cb80dde4fa04973a108a, 'https://aarrin.com/mobile/app_resources/personal/profile_10.Imageimage-pqwe82354daloihd.jpeg', 'Active'),
(11, 'Diana', 'Cortes', '', '0000-00-00', 2010, 'Sales', '', '', 'sales@aarrin.com', '', 'CORD020202PL9', 0x737e9e71c85476b02df84cbb58d9586c, NULL, 'Active'),
(12, 'Diana', 'Cortéz', '', '0000-00-00', 2020, 'Sales', '', '', 'dianjcortess@gmail.com', '', 'CORD020202PL6', 0x0396802127f6ad2b3231213477d97aa0, NULL, 'Active'),
(13, 'Hander', 'García Torres', '', '0000-00-00', 2020, 'Programador', '', '', 'der123@live.com.mx', '', 'GATH950202PL9', 0x8d11c4ea548084c8b4652c704d6de6b3, NULL, 'Active');

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
(104, 6, 'ADMIN_ROLE'),
(108, 9, 'ADMIN_ROLE'),
(129, 10, 'AUDITOR_ROLE'),
(130, 10, 'SALES_ROLE'),
(131, 10, 'FINANCE_ROLE'),
(132, 10, 'PROGRAMMER_ROLE'),
(133, 11, 'ADMIN_ROLE'),
(134, 12, 'ADMIN_ROLE'),
(136, 13, 'ADMIN_ROLE'),
(138, 10, 'ADMIN_ROLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectors`
--

CREATE TABLE `sectors` (
  `IdSector` int(11) NOT NULL,
  `SectorISO` varchar(20) NOT NULL,
  `IAF_MD5` int(11) DEFAULT NULL,
  `SectorCluster` varchar(60) DEFAULT NULL,
  `SectorCategory` varchar(120) NOT NULL,
  `SectorSubcategory` varchar(100) DEFAULT NULL,
  `SectorRiskLevel` varchar(30) DEFAULT NULL,
  `SectorStatus` varchar(15) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sectors`
--

INSERT INTO `sectors` (`IdSector`, `SectorISO`, `IAF_MD5`, `SectorCluster`, `SectorCategory`, `SectorSubcategory`, `SectorRiskLevel`, `SectorStatus`) VALUES
(1001, '9K', 1, NULL, 'Agriculture, forestry and fishing\r\n', NULL, NULL, 'Active'),
(1002, '9K', 2, NULL, 'Mining and quarrying', NULL, NULL, 'Active'),
(1003, '9K', 3, NULL, 'Food products, beverages and tobacco', NULL, NULL, 'Active'),
(1004, '9K', 4, NULL, 'Textiles and textile products', NULL, NULL, 'Active'),
(1005, '9K', 5, NULL, 'Leather and leather products', NULL, NULL, 'Active'),
(1006, '9K', 6, NULL, 'Wood and wood products', NULL, NULL, 'Active'),
(1007, '9K', 7, NULL, 'Pulp, paper and paper products', NULL, NULL, 'Active'),
(1008, '9K', 8, NULL, 'Publishing companies', NULL, NULL, 'Active'),
(1009, '9K', 9, NULL, 'Printing companies', NULL, NULL, 'Active'),
(1010, '9K', 10, NULL, 'Manufacture of coke and refined petroleum products', NULL, NULL, 'Active'),
(1011, '9K', 11, NULL, 'Nuclear fuel', NULL, NULL, 'Active'),
(1012, '9K', 12, NULL, 'Chemicals, chemical products and fibres', NULL, NULL, 'Active'),
(1013, '9K', 13, NULL, 'Pharmaceuticals', NULL, NULL, 'Active'),
(1014, '9K', 14, NULL, 'Rubber and plastic products', NULL, NULL, 'Active'),
(1015, '9K', 15, NULL, 'Non-metallic mineral products', NULL, NULL, 'Active'),
(1016, '9K', 16, NULL, 'Concrete, cement, lime, plaster etc', NULL, NULL, 'Active'),
(1017, '9K', 17, NULL, 'Basic metals and fabricated metal products', NULL, NULL, 'Active'),
(1018, '9K', 18, NULL, 'Machinery and equipment', NULL, NULL, 'Active'),
(1019, '9K', 19, NULL, 'Electrical and optical equipment', NULL, NULL, 'Active'),
(1020, '9K', 20, NULL, 'Shipbuilding', NULL, NULL, 'Active'),
(1021, '9K', 21, NULL, 'Aerospace', NULL, NULL, 'Active'),
(1022, '9K', 22, NULL, 'Other transport equipment', NULL, NULL, 'Active'),
(1023, '9K', 23, NULL, 'Manufacturing not elsewhere classified', NULL, NULL, 'Active'),
(1024, '9K', 24, NULL, 'Recycling', NULL, NULL, 'Active'),
(1025, '9K', 25, NULL, 'Electricity supply', NULL, NULL, 'Active'),
(1026, '9K', 26, NULL, 'Gas supply', NULL, NULL, 'Active'),
(1027, '9K', 27, NULL, 'Water supply', NULL, NULL, 'Active'),
(1028, '9K', 28, NULL, 'Construction', NULL, NULL, 'Active'),
(1029, '9K', 29, NULL, 'Wholesale and retail trade; Repair of motor vehicles, motorcycles and personal and household goods', NULL, NULL, 'Active'),
(1030, '9K', 30, NULL, 'Hotels and restaurants', NULL, NULL, 'Active'),
(1031, '9K', 31, NULL, 'Transport, storage and communication', NULL, NULL, 'Active'),
(1032, '9K', 32, NULL, 'Financial intermediation; real estate; renting', NULL, NULL, 'Active'),
(1033, '9K', 33, NULL, 'Information technology', NULL, NULL, 'Active'),
(1034, '9K', 34, NULL, 'Engineering services', NULL, NULL, 'Active'),
(1035, '9K', 35, NULL, 'Other services ', NULL, NULL, 'Active'),
(1036, '9K', 36, NULL, 'Public administration', NULL, NULL, 'Active'),
(1037, '9K', 37, NULL, 'Education', NULL, NULL, 'Active'),
(1038, '9K', 38, NULL, 'Health and social work', NULL, NULL, 'Active'),
(1039, '9K', 39, NULL, 'Other social services', NULL, NULL, 'Active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `IdService` int(11) NOT NULL,
  `ServiceStandard` varchar(250) NOT NULL,
  `ServiceShortName` varchar(10) NOT NULL,
  `ServiceStatus` varchar(15) DEFAULT 'Active',
  `ServiceDescription` varchar(1500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`IdService`, `ServiceStandard`, `ServiceShortName`, `ServiceStatus`, `ServiceDescription`) VALUES
(1, 'ISO 9001:2015', '9K', 'Active', 'This standard provides orientation and tolos to those Companies and Organisations who want to assure quality in their products and services. The new High Level Structure on ISO 9001, includes the orientation to Client requirements, but also focus on Stakeholders such as the Company itself.\r\n\r\n\r\nThis new versión try to balance the Quality principles, Client Satisfaction with the expectation from the Top Managements and Business perspective; and how the can be reach the results based on Risk Management approach.'),
(2, 'ISO 14001:2015', '14K', 'Active', 'Environmental is always a concern when Organization have preventive pollution and environmental protection compromise.\r\n\r\nISO 14001:2015 and the ISO 14000 family, such as standard ISO 14006 are focus on Environmental systems to achieve the Environmental protection objectives.\r\n\r\nISO 14001:2015 helps to the Organizations to improve their Environmental performance, by promoting the efficiency on the use of resources, waste reduction and as consequence, the operation cost reduction and third parties confident.'),
(3, 'ISO 22001:2015', '22K', 'Active', 'ISO 22000:2005 Food Safety Management System is focused to guarantee the effective implementation on controls to prevent that the food can harm customer during the Hazard Analysis based on Alimentarius CODEX to identify Hazard: Physical, Chemical, Biological, Radiological.\r\n\r\nThe consequences of unsafe food can be serious and ISO´s food safety management standards help organizations identify and control food safety hazards. As many of today’s food products repeatedly cross national boundaries, International Standards are needed to ensure the safety of the global food supply chain.'),
(4, 'ISO 45001:2015', '45K', 'Active', 'About tan 6,300 person diez per month because of accidents or health because of work activities.\r\n\r\nThese accidents and health sickness because of work activities is really important for the employees and more important for the organization, because of the productivity, pensions, absenteeism, rotation, accident payment and other related with accidents.\r\n\r\nTo avoid the problem, ISO has develop the new estándar ISO 45001:2018 Health an Safety Management System, based on the recognized OHSAS 18001. These standards has the specific requirements to identify potential safety and health risks and to improve the organization performance, reducing to he acceptable levels the probability of accidents and improving the work environment, requested by the Quality Standards.');

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
  ADD UNIQUE KEY `CompanyRFC` (`CompanyRFC`);

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
  MODIFY `IdApp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `app_detail`
--
ALTER TABLE `app_detail`
  MODIFY `IdAppDetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `IdCompany` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `IdContact` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `master_list`
--
ALTER TABLE `master_list`
  MODIFY `IdMasterList` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `IdEmployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `IdRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

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
  MODIFY `IdKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_services` FOREIGN KEY (`IdService`) REFERENCES `services` (`IdService`) ON UPDATE NO ACTION;

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
