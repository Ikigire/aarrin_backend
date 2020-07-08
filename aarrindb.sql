-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 28-06-2020 a las 01:39:58
-- Versión del servidor: 5.6.47-cll-lve
-- Versión de PHP: 7.2.7

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
  `IdContact` int(11) NOT NULL,
  `IdService` int(11) NOT NULL,
  `IdSector` int(11) NOT NULL,
  `AppLenguage` varchar(25) NOT NULL,
  `LastCertificateStandard` varchar(50) DEFAULT NULL,
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

INSERT INTO `applications` (`IdApp`, `IdCompany`, `IdContact`, `IdService`, `IdSector`, `AppLenguage`, `LastCertificateStandard`, `LastCertificateExpiration`, `LastCertificateCertifier`, `LastCertificateResults`, `NumberEmployees`, `ExternalServicesProvider`, `ReceiveConsultancy`, `ConsultantName`, `AppDate`, `AppStatus`) VALUES
(4, 20, 22, 3, 1049, 'Spanish', NULL, NULL, NULL, NULL, 30, NULL, NULL, NULL, '2020-05-27 21:22:30', 'On Review'),
(5, 19, 21, 2, 1120, 'Spanish', NULL, NULL, NULL, NULL, 45, 'Entrega de productos nuevos a los cliente', 1, 'General Motors', '2020-05-28 07:22:32', 'On Review'),
(6, 3, 12, 2, 1029, 'English', NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, '2020-05-29 04:26:11', 'On Review'),
(23, 3, 11, 1, 1037, 'Spanish', NULL, NULL, NULL, NULL, 45, NULL, NULL, NULL, '2020-06-01 22:45:31', 'On Review'),
(24, 3, 11, 1, 1037, 'English', '9001:2015', '2020-10-26', 'NQA', 'Todo bien', 49, NULL, NULL, NULL, '2020-06-01 22:50:34', 'On Review'),
(25, 3, 11, 4, 1086, 'Spanish', NULL, NULL, NULL, NULL, 40, '1', NULL, NULL, '2020-06-03 22:32:33', 'On Review'),
(26, 3, 11, 2, 1044, 'Spanish', NULL, NULL, NULL, NULL, 85, '1', NULL, NULL, '2020-06-03 22:42:58', 'On Review'),
(27, 21, 23, 1, 1030, 'Spanish', NULL, NULL, NULL, NULL, 5, '1', NULL, NULL, '2020-06-04 09:57:07', 'On Review'),
(28, 21, 23, 2, 1126, 'Spanish', NULL, NULL, NULL, NULL, 35, '1', NULL, NULL, '2020-06-04 10:03:27', 'On Review'),
(29, 21, 23, 3, 1053, 'Spanish', NULL, NULL, NULL, NULL, 25, '1', NULL, NULL, '2020-06-04 10:13:51', 'On Review'),
(30, 20, 22, 1, 1035, 'Spanish', NULL, NULL, NULL, NULL, 1, '1', NULL, NULL, '2020-06-04 17:58:58', 'On Review'),
(32, 3, 11, 2, 1076, 'Spanish', '14001:2018', '2020-12-22', 'NQA', 'No hubo ninguna no conformidad', 25, NULL, 1, 'NQA', '2020-06-07 21:08:30', 'On Review'),
(33, 21, 23, 2, 1073, 'Spanish', NULL, NULL, NULL, NULL, 25, NULL, 1, 'saaadd', '2020-06-08 09:01:26', 'On Review'),
(34, 21, 23, 1, 1004, 'Spanish', NULL, NULL, NULL, NULL, 30, NULL, NULL, NULL, '2020-06-08 09:02:56', 'On Review'),
(35, 21, 23, 4, 1086, 'Spanish', NULL, NULL, NULL, NULL, 63, NULL, NULL, NULL, '2020-06-08 09:27:19', 'On Review'),
(36, 20, 22, 4, 1079, 'English', '45001:2015', '2020-05-05', 'ARI', '1 NC', 10, NULL, NULL, NULL, '2020-06-08 09:36:10', 'On Change Request'),
(38, 19, 21, 3, 1056, 'Spanish', NULL, NULL, NULL, NULL, 65, NULL, NULL, NULL, '2020-06-22 14:58:45', 'On Review');

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
  `Shift1Activities` text NOT NULL,
  `Shift2` varchar(20) DEFAULT NULL,
  `Shift2Employees` int(11) DEFAULT NULL,
  `Shift2Activities` text,
  `Shift3` varchar(20) DEFAULT NULL,
  `Shift3Employees` int(11) DEFAULT NULL,
  `Shift3Activities` text,
  `OfficeShift` varchar(20) DEFAULT NULL,
  `OfficeShiftEmployees` int(11) DEFAULT NULL,
  `OfficeShiftActivities` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `app_detail`
--

INSERT INTO `app_detail` (`IdAppDetail`, `IdApp`, `Address`, `Shift1`, `Shift1Employees`, `Shift1Activities`, `Shift2`, `Shift2Employees`, `Shift2Activities`, `Shift3`, `Shift3Employees`, `Shift3Activities`, `OfficeShift`, `OfficeShiftEmployees`, `OfficeShiftActivities`) VALUES
(8, 4, 'Dirección', 'From 09:00 to 14:00', 10, 'Actividades', NULL, NULL, NULL, NULL, NULL, 'Actividades', NULL, NULL, NULL),
(9, 5, 'Dirección', 'From 09:00 to 16:00', 15, ' Actividades del turno uno', 'From 16:00 to 00:00', 15, 'Actividades del turno dos', 'From 00:00 to 08:00', 5, 'Actividades turno nocturno', 'From 08:00 to 14:00', 10, 'Actividades de oficina'),
(28, 23, 'Pánfilo Natera 20-H', NULL, 15, '', NULL, 15, NULL, NULL, 15, '*Registro', NULL, NULL, NULL),
(29, 24, 'Pánfilo Natera 20-H', NULL, 25, '', NULL, 14, NULL, NULL, 10, '*Revisión\n*Nuevos estudiantes', NULL, NULL, NULL),
(30, 25, 'Pánfilo Natera 20-H', 'From 07:00 to 15:00', 20, '', 'From 15:00 to 23:00', 20, NULL, NULL, NULL, '*Manejo de carga pesada\n*Creación de metales\n*Manejo de Hornos', NULL, NULL, NULL),
(31, 26, 'La cañada SN', 'From 07:00 to 14:00', 35, '', 'From 14:00 to 22:00', 30, NULL, 'From 23:00 to 07:00', 20, 'Extracción de carbón', NULL, NULL, NULL),
(32, 27, 'camichines', 'From 09:00 to 13:00', 5, '', NULL, NULL, NULL, NULL, NULL, 'ajdjdueurnfndsfspgk', NULL, NULL, NULL),
(33, 28, 'camichines', 'From 10:30 to 16:30', 20, '', 'From 14:30 to 20:30', 15, NULL, NULL, NULL, 'dfjfdkkaallñeñw.f', NULL, NULL, NULL),
(34, 29, 'dcadjcncdia', 'From 10:11 to 15:15', 25, '', NULL, NULL, NULL, NULL, NULL, 'zzdzfdevcdffgnfg', NULL, NULL, NULL),
(35, 30, 'Tlaquepaque', 'From 09:00 to 18:00', 1, '', NULL, NULL, NULL, NULL, NULL, 'Consultancy', NULL, NULL, NULL),
(36, 32, 'Dirección ficticia 12', 'From 05:00 to 13:00', 10, 'Pesca', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 32, 'Pánfilo Natera 20-H', 'From 12:00 to 18:00', 15, 'Procesamiento de producto recolectado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 33, 'camichines', 'From 08:00 to 17:00', 10, 'dfgdfgfvrtesfdf', 'From 11:00 to 20:00', 15, 'ddgrgdvghr', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 34, 'camichines', 'From 09:00 to 18:00', 30, 'cddsfrgdfvhyfg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 35, 'camichines', 'From 07:00 to 17:00', 63, 'fhjjuhfddfgh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 36, 'Main Site', 'From 06:00 to 14:00', 10, 'chemicals', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 37, 'Dirección', '', 6, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 38, 'Pánfilo Natera #20-H', 'From 08:00 to 16:00', 25, 'Elaboración de producto, enlatado y empaquetado del mismo', 'From 16:00 to 20:00', 25, 'Elaboración de producto, enlatado y empaquetado del mismo', NULL, NULL, NULL, NULL, NULL, NULL),
(44, 38, 'Gato #12', 'From 09:30 to 16:30', 15, 'Actividades de oficina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 4, 'gato #12', 'From 14:00 to 20:00', 20, 'Actividades del turno', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 6, 'Pánfilo Natera 20-', 'From 16:39 to 16:39', 5, 'Actividades', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(2, 'Prueba S.A de C.V.', 'PRUEBA22222', 'Ramón Corona 125', 'https://www.prueba.com.mx', 'https://aarrin.com/mobile/app_resources/companies/logo_2.Image-.Clajhasd9ul3iu0a.ñohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(3, 'Malvados y Asociados S.A de C.V.', 'MALASO4589', 'Independencia 425', 'https://malvados.asociados.mx', 'https://aarrin.com/mobile/app_resources/companies/logo_3.Image-.Clajhasd9ul3iu0a.ñohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
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
  `MainContact` tinyint(1) DEFAULT '0',
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
(11, 3, 1, 'Heinz Doofmenshmirtz', '123456789', 'evil_doof@mermelada.com', 'Genio Malvado', 0x2483bb4d9af50039ba5bd69f5a16eeb9, 'https://aarrin.com/mobile/app_resources/contacts/profile_11.Image-evil_doof@mermelada.com.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(12, 3, 0, 'Alois Everard Elizabeth Otto Wolfgang Hypatia Gunter Geilen Gary Cooper Von Rodenstein', '5555555555', 'evil_rodney@mermelada.com', 'Doctor del Mal', 0x2483bb4d9af50039ba5bd69f5a16eeb9, NULL, 'Active'),
(21, 19, 1, 'Mayor Francis Monograma', '3421006559', 'asm_1995@outlook.com', 'Lider de la organización', 0x2483bb4d9af50039ba5bd69f5a16eeb9, NULL, 'Active'),
(22, 20, 1, 'Alberto Tello', '3316051393', 'contact.greentellus@gmail.com', 'General Manager', 0x8b0d7e2cc3145de191f3483d06a1fbbe, NULL, 'Active'),
(23, 21, 1, 'Diana Cortés', '3311957480', 'dianjcortess@gmail.com', 'VENTAS', 0x35438abf65edc15410d84ee34c4d6ee3, 'https://aarrin.com/mobile/app_resources/contacts/profile_23.Image-dianjcortess@gmail.com.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days_calculation`
--

CREATE TABLE `days_calculation` (
  `IdDayCalculation` bigint(20) UNSIGNED NOT NULL,
  `IdApp` int(11) NOT NULL,
  `IdCreatorEmployee` int(11) NOT NULL,
  `IdReviewerEmployee` int(11) DEFAULT NULL,
  `DayCalculationDate` datetime NOT NULL,
  `DayCalculationApproved` tinyint(1) DEFAULT '0',
  `DayCalculationApprovedDate` datetime DEFAULT NULL,
  `DaysInitialStage` float NOT NULL,
  `DaysSurveillance` float NOT NULL,
  `DaysRR` float NOT NULL,
  `DaysCalculationStatus` varchar(30) DEFAULT 'Waiting for Approvement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `days_calculation`
--

INSERT INTO `days_calculation` (`IdDayCalculation`, `IdApp`, `IdCreatorEmployee`, `IdReviewerEmployee`, `DayCalculationDate`, `DayCalculationApproved`, `DayCalculationApprovedDate`, `DaysInitialStage`, `DaysSurveillance`, `DaysRR`, `DaysCalculationStatus`) VALUES
(17, 38, 1, 6, '2020-06-23 00:21:25', 1, '2020-06-25 16:45:41', 6.5, 2.5, 5.5, 'Approved'),
(18, 36, 1, NULL, '2020-06-23 00:22:18', 0, NULL, 5, 2, 4, 'Waiting for Approvement'),
(19, 32, 1, NULL, '2020-06-23 00:59:07', 0, NULL, 6.5, 2.5, 4.5, 'Waiting for Approvement'),
(20, 24, 1, NULL, '2020-06-23 01:02:58', 0, NULL, 5, 2, 3.5, 'Waiting for Approvement'),
(21, 32, 1, NULL, '2020-06-23 01:03:28', 0, NULL, 6.5, 2.5, 4.5, 'Waiting for Approvement'),
(22, 33, 1, NULL, '2020-06-23 01:06:14', 0, NULL, 5.5, 2, 4, 'Waiting for Approvement'),
(29, 30, 1, NULL, '2020-06-23 02:07:11', 0, NULL, 2.5, 1, 2, 'Waiting for Approvement'),
(30, 5, 1, NULL, '2020-06-23 03:02:44', 0, NULL, 6.5, 2.5, 5.5, 'Waiting for Approvement'),
(31, 4, 1, 12, '2020-06-23 14:58:12', 1, '2020-06-23 15:25:32', 5, 2, 4.5, 'Approved'),
(32, 6, 12, NULL, '2020-06-25 16:40:37', 0, NULL, 3, 1, 2, 'Waiting for Approvement');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days_calculation_detail9k`
--

CREATE TABLE `days_calculation_detail9k` (
  `IdDayCalculationDetail` bigint(20) UNSIGNED NOT NULL,
  `IdDayCalculation` int(11) NOT NULL,
  `NumberEmployees` int(11) NOT NULL,
  `InitialMD` float NOT NULL,
  `SystemComplex` tinyint(1) DEFAULT NULL,
  `SystemComplexComment` varchar(1500) DEFAULT NULL,
  `ComplicatedLogistic` tinyint(1) DEFAULT NULL,
  `ComplicatedLogisticComment` varchar(1500) DEFAULT NULL,
  `InterestedParties` tinyint(1) DEFAULT NULL,
  `InterestedPartiesComment` varchar(1500) DEFAULT NULL,
  `ScopeRegulation` tinyint(1) DEFAULT NULL,
  `ScopeRegulationComment` varchar(1500) DEFAULT NULL,
  `DesignResponsability` tinyint(1) DEFAULT NULL,
  `DesignResponsabilityComment` varchar(1500) DEFAULT NULL,
  `DifferentLanguage` tinyint(1) DEFAULT NULL,
  `DifferentLanguageComment` varchar(1500) DEFAULT NULL,
  `Maturity` tinyint(1) DEFAULT NULL,
  `MaturityComment` varchar(1500) DEFAULT NULL,
  `AutomationLevel` tinyint(1) DEFAULT NULL,
  `AutomationLevelComment` varchar(1500) DEFAULT NULL,
  `DaysInitialStage` float NOT NULL,
  `DaysSurveillance` float NOT NULL,
  `DaysRR` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `days_calculation_detail9k`
--

INSERT INTO `days_calculation_detail9k` (`IdDayCalculationDetail`, `IdDayCalculation`, `NumberEmployees`, `InitialMD`, `SystemComplex`, `SystemComplexComment`, `ComplicatedLogistic`, `ComplicatedLogisticComment`, `InterestedParties`, `InterestedPartiesComment`, `ScopeRegulation`, `ScopeRegulationComment`, `DesignResponsability`, `DesignResponsabilityComment`, `DifferentLanguage`, `DifferentLanguageComment`, `Maturity`, `MaturityComment`, `AutomationLevel`, `AutomationLevelComment`, `DaysInitialStage`, `DaysSurveillance`, `DaysRR`) VALUES
(12, 20, 49, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 2, 3.5),
(13, 29, 1, 1.5, 1, 'x<vzsdgsfdg', 0, '', 1, 'sdfsdfgsgsdgfsfdhdgjjkdgkf', 0, 'djhdgjfjdghsdfg', 1, '', 0, '', 0, '', 0, '', 2.5, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days_calculation_detail14k`
--

CREATE TABLE `days_calculation_detail14k` (
  `IdDayCalculationDetail` bigint(20) UNSIGNED NOT NULL,
  `IdDayCalculation` int(11) NOT NULL,
  `NumberEmployees` int(11) NOT NULL,
  `InitialMD` float NOT NULL,
  `SystemComplex` tinyint(1) DEFAULT NULL,
  `SystemComplexComment` varchar(1500) DEFAULT NULL,
  `ComplicatedLogistic` tinyint(1) DEFAULT NULL,
  `ComplicatedLogisticComment` varchar(1500) DEFAULT NULL,
  `InterestedParties` tinyint(1) DEFAULT NULL,
  `InterestedPartiesComment` varchar(1500) DEFAULT NULL,
  `ScopeRegulation` tinyint(1) DEFAULT NULL,
  `ScopeRegulationComment` varchar(1500) DEFAULT NULL,
  `OutsourcedProcesses` tinyint(1) DEFAULT NULL,
  `OutsourcedProcessesComment` varchar(1500) DEFAULT NULL,
  `IndirectAspects` tinyint(1) DEFAULT NULL,
  `IndirectAspectsComment` varchar(1500) DEFAULT NULL,
  `DifferentLanguage` tinyint(1) DEFAULT NULL,
  `DifferentLanguageComment` varchar(1500) DEFAULT NULL,
  `Maturity` tinyint(1) DEFAULT NULL,
  `MaturityComment` varchar(1500) DEFAULT NULL,
  `AutomationLevel` tinyint(1) DEFAULT NULL,
  `AutomationLevelComment` varchar(1500) DEFAULT NULL,
  `DaysInitialStage` float NOT NULL,
  `DaysSurveillance` float NOT NULL,
  `DaysRR` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `days_calculation_detail14k`
--

INSERT INTO `days_calculation_detail14k` (`IdDayCalculationDetail`, `IdDayCalculation`, `NumberEmployees`, `InitialMD`, `SystemComplex`, `SystemComplexComment`, `ComplicatedLogistic`, `ComplicatedLogisticComment`, `InterestedParties`, `InterestedPartiesComment`, `ScopeRegulation`, `ScopeRegulationComment`, `OutsourcedProcesses`, `OutsourcedProcessesComment`, `IndirectAspects`, `IndirectAspectsComment`, `DifferentLanguage`, `DifferentLanguageComment`, `Maturity`, `MaturityComment`, `AutomationLevel`, `AutomationLevelComment`, `DaysInitialStage`, `DaysSurveillance`, `DaysRR`) VALUES
(1, 19, 10, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 2),
(2, 19, 15, 3.5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3.5, 1.5, 2.5),
(3, 21, 10, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 2),
(4, 21, 15, 3.5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3.5, 1.5, 2.5),
(5, 22, 25, 5.5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5.5, 2, 4),
(6, 30, 35, 4, 1, 'System cover highly complex processes', 0, '', 0, '', 1, 'The scope have a high degree of regulation', 0, '', 0, '', 0, '', 0, '', 0, '', 6.5, 2.5, 5.5),
(7, 32, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Comentario', NULL, NULL, 3, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days_calculation_detail22k`
--

CREATE TABLE `days_calculation_detail22k` (
  `IdDayCalculationDetail` bigint(20) UNSIGNED NOT NULL,
  `IdDayCalculation` int(11) NOT NULL,
  `NumberEmployees` int(11) NOT NULL,
  `InitialMD` float NOT NULL,
  `FTEHACCP` tinyint(1) DEFAULT NULL,
  `FTEHACCPComment` varchar(1500) DEFAULT NULL,
  `FTEHACCPIncrement` float DEFAULT NULL,
  `FTEHACCPPlus` tinyint(1) DEFAULT NULL,
  `FTEHACCPPlusComment` varchar(1500) DEFAULT NULL,
  `FTEHACCPPlusIncrement` float DEFAULT NULL,
  `AuditPreparation` tinyint(1) DEFAULT NULL,
  `AuditPreparationComment` varchar(1500) DEFAULT NULL,
  `AuditPreparationIncrement` float DEFAULT NULL,
  `AuditReport` tinyint(1) DEFAULT NULL,
  `AuditReportComment` varchar(1500) DEFAULT NULL,
  `AuditReportIncrement` float DEFAULT NULL,
  `UseInterpreter` tinyint(1) DEFAULT NULL,
  `UseInterpreterComment` varchar(1500) DEFAULT NULL,
  `UseInterpreterIncrement` float DEFAULT NULL,
  `OffSiteStorage` tinyint(1) DEFAULT NULL,
  `OffSiteStorageComment` varchar(1500) DEFAULT NULL,
  `OffSiteStorageIncrement` float DEFAULT NULL,
  `CertificationControlled` tinyint(1) DEFAULT NULL,
  `CertificationControlledComment` varchar(1500) DEFAULT NULL,
  `CertificationControlledIncrement` float DEFAULT NULL,
  `DaysInitialStage` float NOT NULL,
  `DaysSurveillance` float NOT NULL,
  `DaysRR` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `days_calculation_detail22k`
--

INSERT INTO `days_calculation_detail22k` (`IdDayCalculationDetail`, `IdDayCalculation`, `NumberEmployees`, `InitialMD`, `FTEHACCP`, `FTEHACCPComment`, `FTEHACCPIncrement`, `FTEHACCPPlus`, `FTEHACCPPlusComment`, `FTEHACCPPlusIncrement`, `AuditPreparation`, `AuditPreparationComment`, `AuditPreparationIncrement`, `AuditReport`, `AuditReportComment`, `AuditReportIncrement`, `UseInterpreter`, `UseInterpreterComment`, `UseInterpreterIncrement`, `OffSiteStorage`, `OffSiteStorageComment`, `OffSiteStorageIncrement`, `CertificationControlled`, `CertificationControlledComment`, `CertificationControlledIncrement`, `DaysInitialStage`, `DaysSurveillance`, `DaysRR`) VALUES
(5, 17, 50, 3.75, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'uso de interprete necesario', 0.25, 1, 'Tienen almacén externo', 0.5, NULL, NULL, NULL, 4.5, 1.5, 3.5),
(6, 17, 15, 1.375, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 2),
(7, 31, 10, 1.5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Se necesita un interprete', 0.5, 1, 'La compañía tiene un almacén externo', 0.5, NULL, NULL, NULL, 2.5, 1, 2),
(8, 31, 20, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'La auditoría será controlada por la oficina central', 1.5, 2.5, 1, 2.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `days_calculation_detail45k`
--

CREATE TABLE `days_calculation_detail45k` (
  `IdDayCalculationDetail` bigint(20) UNSIGNED NOT NULL,
  `IdDayCalculation` int(11) NOT NULL,
  `NumberEmployees` int(11) NOT NULL,
  `InitialMD` float NOT NULL,
  `SystemComplex` tinyint(1) DEFAULT NULL,
  `SystemComplexComment` varchar(1500) DEFAULT NULL,
  `ComplicatedLogistic` tinyint(1) DEFAULT NULL,
  `ComplicatedLogisticComment` varchar(1500) DEFAULT NULL,
  `InterestedParties` tinyint(1) DEFAULT NULL,
  `InterestedPartiesComment` varchar(1500) DEFAULT NULL,
  `ScopeRegulation` tinyint(1) DEFAULT NULL,
  `ScopeRegulationComment` varchar(1500) DEFAULT NULL,
  `IndirectAspects` tinyint(1) DEFAULT NULL,
  `IndirectAspectsComment` varchar(1500) DEFAULT NULL,
  `DifferentLanguage` tinyint(1) DEFAULT NULL,
  `DifferentLanguageComment` varchar(1500) DEFAULT NULL,
  `Maturity` tinyint(1) DEFAULT NULL,
  `MaturityComment` varchar(1500) DEFAULT NULL,
  `SmallLargePersonnel` tinyint(1) DEFAULT NULL,
  `SmallLargePersonnelComment` varchar(1500) DEFAULT NULL,
  `DaysInitialStage` float NOT NULL,
  `DaysSurveillance` float NOT NULL,
  `DaysRR` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `days_calculation_detail45k`
--

INSERT INTO `days_calculation_detail45k` (`IdDayCalculationDetail`, `IdDayCalculation`, `NumberEmployees`, `InitialMD`, `SystemComplex`, `SystemComplexComment`, `ComplicatedLogistic`, `ComplicatedLogisticComment`, `InterestedParties`, `InterestedPartiesComment`, `ScopeRegulation`, `ScopeRegulationComment`, `IndirectAspects`, `IndirectAspectsComment`, `DifferentLanguage`, `DifferentLanguageComment`, `Maturity`, `MaturityComment`, `SmallLargePersonnel`, `SmallLargePersonnelComment`, `DaysInitialStage`, `DaysSurveillance`, `DaysRR`) VALUES
(1, 18, 10, 3.5, 1, 'Systen have a highly complex', 0, '', 1, 'The accidents rate is more than 10%', 1, 'The scope has a high degree of regulation', 0, '', 1, 'The audit language is English', 0, '', 1, 'The site is not a large place', 5, 2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso9kcomplement`
--

CREATE TABLE `iso9kcomplement` (
  `IdComplement` bigint(20) UNSIGNED NOT NULL,
  `IdApp` int(11) NOT NULL,
  `ScopeActivities` varchar(500) NOT NULL,
  `NumberProcesses` int(11) NOT NULL,
  `LegalRequirements` varchar(500) NOT NULL,
  `CriticalComplaint` varchar(500) DEFAULT NULL,
  `ProcessAutomationLevel` varchar(500) NOT NULL,
  `DesignResponsability` varchar(500) DEFAULT NULL,
  `Justification` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `iso9kcomplement`
--

INSERT INTO `iso9kcomplement` (`IdComplement`, `IdApp`, `ScopeActivities`, `NumberProcesses`, `LegalRequirements`, `CriticalComplaint`, `ProcessAutomationLevel`, `DesignResponsability`, `Justification`) VALUES
(2, 23, '*Registro', 1, '', NULL, 'Tenemos una aplicación que nos permite registrar las cosas con la menor cantidad de errores humanos', NULL, ''),
(3, 24, '*Revisión\n*Nuevos estudiantes', 2, 'Requerimientos legales', 'Ninguna', 'Tenemos una aplicación que nos permite registrar las cosas con la menor cantidad de errores humanos', '1', 'El diseño fue realizado específicamente para nuestros procesos'),
(4, 27, 'Preparación de comida rapida', 5, 'ddggedgbf', 'ninguna', 'no', NULL, ''),
(5, 30, 'Consulting services and development of environmental projects', 1, 'N/A', 'No current complaints', 'Only administrative activities', '', ''),
(6, 34, 'ffdvxsedxzzdf', 3, 'ffffffffferfgrrege', 'gggghhhhhh', 'ggggggggg', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso14kcomplement`
--

CREATE TABLE `iso14kcomplement` (
  `IdComplement` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `iso14kcomplement` (`IdComplement`, `IdApp`, `ScopeActivities`, `NumberProcesses`, `LegalRequirements`, `OperationalControls`, `CriticalComplaint`) VALUES
(1, 5, 'Reparación de motores', 3, 'Requerimiento Legales', 'Safety Control', 'N/A'),
(2, 6, 'Actividades', 3, 'Requerimiento Legales', 'Safety Control', NULL),
(3, 5, 'Reparación de motores', 3, 'Requerimiento Legales', 'Safety Control', 'N/A'),
(4, 6, 'Actividades', 3, 'Requerimiento Legales', 'Safety Control', NULL),
(5, 26, 'Extracción de carbón', 1, '', 'Controles de seguridad de acceso a minas', NULL),
(6, 28, 'djkjxjskfunxvkngd', 10, 'xxxxffffff', 'wwsmxmvnnf b', 'ddfs'),
(7, 32, 'Pesca y procesamiento de producto', 2, 'La legal procedencia de los productos pesqueros se comprobará,\nLas plantas procesadoras mantendrán un registro de los volúmenes que entren y salgan,\npara que la autoridad competente lo revise en caso de así requerirlo', 'OHSAS 18001 norma', 'Ninguna'),
(8, 33, 'ddgghtuyjnnghm', 2, 'iuhbhvgvcxz', 'sadsefedfwfcd', 'adsdedcsaad'),
(9, 37, 'Actividades', 3, 'Requerimiento Legales', 'Safety Control', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso22kcomplement`
--

CREATE TABLE `iso22kcomplement` (
  `IdComplement` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `iso22kcomplement` (`IdComplement`, `IdApp`, `NumberHACCP`, `GeneralDescription`, `NumberLinesProducts`, `Seasonality`, `LegalRequirements`) VALUES
(1, 4, 2, 'Descripción', 6, 'Primavera', 'Requerimiento Legales'),
(2, 4, 2, 'Descripción', 6, 'Primavera', 'Requerimiento Legales'),
(3, 29, 2, 'gfgncvcvcfgdxbbn cb cghfgh', 2, 'aaaasgsfgf', ''),
(4, 38, 2, 'Descripción de productos', 1, 'Todo el año', 'Deberá comprobarse la legalidad y calidad de la adquisición de los productos tanto utilizados para la producción como el producto final');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso45kcomplement`
--

CREATE TABLE `iso45kcomplement` (
  `IdComplement` bigint(20) UNSIGNED NOT NULL,
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

--
-- Volcado de datos para la tabla `iso45kcomplement`
--

INSERT INTO `iso45kcomplement` (`IdComplement`, `IdApp`, `ScopeActivities`, `NumberProcesses`, `LegalRequirements`, `FatalitiesRate`, `AccidentsRate`, `InjuriesRate`, `NearMissRate`, `OHSMSAudit`, `HighLevelRisks`) VALUES
(1, 25, 'Creación de nuevos productos', 1, '', 4, 10, 4, 1, '', '*Aplastamiento\n*Quemaduras\n*Lesiones por exceso de carga\n*Maquinaria pesada'),
(2, 35, 'ddfe<fegdeccs', 6, 'aaaaaaawssss', 0, 1, 2, 5, 'gggggggg', 'hghcfctgnhjkibjgvgv'),
(3, 36, 'Processing minerals', 2, 'STPS', 0, 1, 5, 10, 'PASST', 'Meshing\nChemical\n');

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
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `IdNotification` bigint(20) UNSIGNED NOT NULL,
  `IdEmployee` int(11) DEFAULT NULL,
  `IdCompany` int(11) DEFAULT NULL,
  `Role_Type` varchar(20) NOT NULL,
  `Message` text NOT NULL,
  `URL` varchar(250) NOT NULL,
  `Viewed` tinyint(1) NOT NULL DEFAULT '0',
  `NotficationDate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
(11, 'Jeanette', 'Silva', 'Mercadotecnia', '1994-03-11', 2010, 'Sales', 'jhjggg', '3365226685', 'sales@aarrin.com', 'ddddjdjdjdjd', 'CORD020202PL9', 0x737e9e71c85476b02df84cbb58d9586c, NULL, 'Active'),
(12, 'Persona', 'De Prueba', 'Lic. Contador', '1990-08-14', 2020, 'Sales', 'Dirección ficticia 12', '5555555555', 'test@test.com', 'PDP900814IMSS', 'PDP900814LO8', 0x066cff26d5e35df5ee74a9f26ff64f93, 'https://aarrin.com/mobile/app_resources/personal/profile_12.Image-pqwe82354daloihd.png', 'Active'),
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
(136, 13, 'ADMIN_ROLE'),
(138, 10, 'ADMIN_ROLE'),
(139, 12, 'SALES_ROLE'),
(142, 12, 'PROGRAMMER_ROLE'),
(143, 12, 'ADMIN_ROLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectors`
--

CREATE TABLE `sectors` (
  `IdSector` int(11) NOT NULL,
  `SectorISO` varchar(20) NOT NULL,
  `IAF_MD5` int(11) DEFAULT NULL,
  `SectorCluster` varchar(60) DEFAULT NULL,
  `SectorCategory` varchar(180) NOT NULL,
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
(1039, '9K', 39, NULL, 'Other social services', NULL, NULL, 'Active'),
(1044, '14K', NULL, NULL, 'Mining and Quarrynig', NULL, 'High', 'Active'),
(1045, '14K', NULL, NULL, 'Oil and Gas extraction', NULL, 'High', 'Active'),
(1046, '14K', NULL, NULL, 'Tanning of textiles and clothing', NULL, 'High', 'Active'),
(1047, '22K', NULL, 'Farming', 'A - Farming of Animals', 'AI - Farming of Animals for Meat/ Milk/ Eggs/ Honey', NULL, 'Active'),
(1048, '22K', NULL, 'Farming', 'A - Farming of Animals', 'AII - Farming of Fish and Seafood', NULL, 'Active'),
(1049, '22K', NULL, 'Farming', 'B - Farming of Plants', 'BI - Farming of Plants (Other tahn grains and pulse)', NULL, 'Active'),
(1050, '22K', NULL, 'Farming', 'B - Farming of Plants', 'BII - Farming of Grains and Pulses', NULL, 'Active'),
(1051, '22K', NULL, 'Food and Feed Processing', 'C - Food Manufacturing', 'CI - Processing of Perishable Animal Products', NULL, 'Active'),
(1052, '22K', NULL, 'Food and Feed Processing', 'C - Food Manufacturing', 'CII - Processing of Perishable Plant Products', NULL, 'Active'),
(1053, '22K', NULL, 'Food and Feed Processing', 'C - Food Manufacturing', 'CIII - Processing of Perishable Animal and Plants Products (mixed products)', NULL, 'Active'),
(1054, '22K', NULL, 'Food and Feed Processing', 'C - Food Manufacturing', 'CIV - Processing of Ambient Stable Products', NULL, 'Active'),
(1055, '22K', NULL, 'Food and Feed Processing', 'D - Animal Feed Production', 'DI - Productions of Feed', NULL, 'Active'),
(1056, '22K', NULL, 'Food and Feed Processing', 'D - Animal Feed Production', 'DII - Productions of Pet Food', NULL, 'Active'),
(1057, '22K', NULL, 'Catering', 'E - Catering', NULL, NULL, 'Active'),
(1058, '22K', NULL, 'Retail Transport and Storage', 'F - Distribution', 'FI - Retail/ Wholesale', NULL, 'Active'),
(1059, '22K', NULL, 'Retail Transport and Storage', 'F - Distribution', 'FII - Food Broking/ Trading', NULL, 'Active'),
(1060, '22K', NULL, 'Retail Transport and Storage', 'G - Provision of Transport and Storage Services', 'GI - Provision of Transport and Storage Services for Perishable Food and Feed', NULL, 'Active'),
(1061, '22K', NULL, 'Retail Transport and Storage', 'G - Provision of Transport and Storage Services', 'GII - Provision of Transport and Storage Services for Ambient Stable Food and Feed', NULL, 'Active'),
(1062, '22K', NULL, 'Auxiliary Services', 'H - Services', NULL, NULL, 'Active'),
(1063, '22K', NULL, 'Auxiliary Services', 'I - Productions of Food Packaging and Packaging Material', NULL, NULL, 'Active'),
(1064, '22K', NULL, 'Auxiliary Services', 'J - Equipment Manufacturing', NULL, NULL, 'Active'),
(1065, '22K', NULL, 'Biochemical', 'K - Production of (bio) Chemicals', NULL, NULL, 'Active'),
(1066, '14K', NULL, NULL, 'Pulping part of paper manufacturing, including paper recycling processing', NULL, 'High', 'Active'),
(1067, '14K', NULL, NULL, 'Oil Refining', NULL, 'High', 'Active'),
(1068, '14K', NULL, NULL, 'Chemicals and Pharmaceuticals', NULL, 'High', 'Active'),
(1069, '14K', NULL, NULL, 'Primary Productions', NULL, 'High', 'Active'),
(1070, '14K', NULL, NULL, 'Metals', NULL, 'High', 'Active'),
(1071, '14K', NULL, NULL, 'Non-metallics processing and products covering ceramics and cement', NULL, 'High', 'Active'),
(1072, '14K', NULL, NULL, 'Coal-based electricity generation', NULL, 'High', 'Active'),
(1073, '14K', NULL, NULL, 'Civil construction and demolition', NULL, 'High', 'Active'),
(1074, '14K', NULL, NULL, 'Hazardous and non-hazardous wate processing, e.g. incinerations, etc', NULL, 'High', 'Active'),
(1075, '14K', NULL, NULL, 'Effluent and sewerage processing', NULL, 'High', 'Active'),
(1076, '14K', NULL, NULL, 'Fishing/ Farming/ Forestry', NULL, 'Medium', 'Active'),
(1077, '14K', NULL, NULL, 'Textiles and clothing except for tanning', NULL, 'Medium', 'Active'),
(1078, '14K', NULL, NULL, 'Manufacturing of boards, treatment/ impregnant of wood and wooden products', NULL, 'Medium', 'Active'),
(1079, '45K', NULL, NULL, 'Mining and Quarrynig', NULL, 'High', 'Active'),
(1080, '45K', NULL, NULL, 'Oil and Gas extraction', NULL, 'High', 'Active'),
(1081, '45K', NULL, NULL, 'Tanning of textiles and clothing', NULL, 'High', 'Active'),
(1082, '45K', NULL, NULL, 'Pulping part of paper manufacturing, including paper recycling processing', NULL, 'High', 'Active'),
(1083, '45K', NULL, NULL, 'Oil refining', NULL, 'High', 'Active'),
(1084, '45K', NULL, NULL, 'Chemicals and pharmaceuticals', NULL, 'High', 'Active'),
(1085, '45K', NULL, NULL, 'Primary productions', NULL, 'High', 'Active'),
(1086, '45K', NULL, NULL, 'Metals', NULL, 'High', 'Active'),
(1087, '45K', NULL, NULL, 'Non- metallics processing and products covering ceramics and cement', NULL, 'High', 'Active'),
(1088, '45K', NULL, NULL, 'Coal-based electricity generation', NULL, 'High', 'Active'),
(1089, '45K', NULL, NULL, 'Civil construction and demolition', NULL, 'High', 'Active'),
(1090, '45K', NULL, NULL, 'Hazardous and non-hazardous waste processing, e.g. incineration, etc.', NULL, 'High', 'Active'),
(1091, '45K', NULL, NULL, 'Effluent and sewerage processing', NULL, 'High', 'Active'),
(1092, '45K', NULL, NULL, 'Fishing/ farming/ forestry', NULL, 'Medium', 'Active'),
(1093, '45K', NULL, NULL, 'Textiles and clothing except for tanning', NULL, 'Medium', 'Active'),
(1094, '45K', NULL, NULL, 'Manufacturing of boards, treatment/ impregnation of wood and wooden products', NULL, 'Medium', 'Active'),
(1095, '45K', NULL, NULL, 'Paper production and printing, excluding pulping', NULL, 'Medium', 'Active'),
(1096, '45K', NULL, NULL, 'Non-metallics processing and products covering glass, clay, lime, etc.', NULL, 'Medium', 'Active'),
(1097, '14K', NULL, NULL, 'Paper production and printing, excluding pulping', NULL, 'Medium', 'Active'),
(1098, '14K', NULL, NULL, 'Non-metallics processing and products covering glass, clay, lime, etc.', NULL, 'Medium', 'Active'),
(1099, '14K', NULL, NULL, 'Surface and other chemically-based treatment for metal fabricated products, excluding primary production', NULL, 'Medium', 'Active'),
(1100, '14K', NULL, NULL, 'Production of bare printed circuit boards for electronics industry', NULL, 'Medium', 'Active'),
(1101, '14K', NULL, NULL, 'Manufacturing of transport equipment', NULL, 'Medium', 'Active'),
(1102, '14K', NULL, NULL, 'Road, rail, air, ships', NULL, 'Medium', 'Active'),
(1103, '14K', NULL, NULL, 'Non-coal-based electricity generation and distribution', NULL, 'Medium', 'Active'),
(1104, '14K', NULL, NULL, 'Gas production, storage and distribution (note: extraction is graded high)', NULL, 'Medium', 'Active'),
(1105, '14K', NULL, NULL, 'Water abstraction, purification and distribution, including river management ', NULL, 'Medium', 'Active'),
(1106, '14K', NULL, NULL, 'Fossil fuel wholesale and retail', NULL, 'Medium', 'Active'),
(1107, '14K', NULL, NULL, 'Food and tobacco processing', NULL, 'Medium', 'Active'),
(1108, '14K', NULL, NULL, 'Transport and distribution by sea, air, land', NULL, 'Medium', 'Active'),
(1109, '14K', NULL, NULL, 'Commercial estate agency, estate management, industrial cleaning, hygiene cleaning, dry cleaning normally part of general business services', NULL, 'Medium', 'Active'),
(1110, '14K', NULL, NULL, 'Recycling, composting, landfill (of non-hazardous waste)', NULL, 'Medium', 'Active'),
(1111, '14K', NULL, NULL, 'Technical testing and laboratories', NULL, 'Medium', 'Active'),
(1112, '14K', NULL, NULL, 'Healthcare/hospitals/veterinary', NULL, 'Medium', 'Active'),
(1113, '14K', NULL, NULL, 'Leisure services and personal services, excluding hotels/restaurants', NULL, 'Medium', 'Active'),
(1114, '14K', NULL, NULL, 'Hotels/restaurants', NULL, 'Low', 'Active'),
(1115, '14K', NULL, NULL, 'Wood and wooden products, excluding manufacturing of boards, treatment and impregnation of wood', NULL, 'Low', 'Active'),
(1116, '14K', NULL, NULL, 'Paper products, excluding printing, pulping, and paper making', NULL, 'Low', 'Active'),
(1117, '14K', NULL, NULL, 'Rubber and plastic injection moulding, forming and assembly, excluding manufacturing of rubber ', NULL, 'Low', 'Active'),
(1118, '14K', NULL, NULL, 'Hot and cold forming and metal fabrication, excluding surface treatment and other chemical-based treatments and primary production', NULL, 'Low', 'Active'),
(1119, '14K', NULL, NULL, 'General mechanical engineering assembly, excluding surface treatment and other chemical-based treatments', NULL, 'Low', 'Active'),
(1120, '14K', NULL, NULL, 'Wholesale and retail', NULL, 'Low', 'Active'),
(1121, '14K', NULL, NULL, 'Electrical and electronic equipment assembly, excluding manufacturing of bare printed circuit boards', NULL, 'Low', 'Active'),
(1122, '14K', NULL, NULL, 'Corporate activities and management, HQ and management of holding companies', NULL, 'Limited', 'Active'),
(1123, '14K', NULL, NULL, 'Transport and distribution management services with no actual fleet to manage', NULL, 'Limited', 'Active'),
(1124, '14K', NULL, NULL, 'Telecommunications', NULL, 'Limited', 'Active'),
(1125, '14K', NULL, NULL, 'General business services, except commercial estate agency, estate management, industrial cleaning, hygiene cleaning, dry ', NULL, 'Limited', 'Active'),
(1126, '14K', NULL, NULL, 'Education services', NULL, 'Limited', 'Active'),
(1127, '14K', NULL, NULL, 'Nuclear ', NULL, 'Special Case', 'Active'),
(1128, '14K', NULL, NULL, 'Nuclear electricity generation', NULL, 'Special Case', 'Active'),
(1129, '14K', NULL, NULL, 'Storage of large quantities of hazardous material ', NULL, 'Special Case', 'Active'),
(1130, '14K', NULL, NULL, 'Public administration', NULL, 'Special Case', 'Active'),
(1131, '14K', NULL, NULL, 'Local authorities', NULL, 'Special Case', 'Active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `IdService` int(11) NOT NULL,
  `ServiceStandard` varchar(250) NOT NULL,
  `ServiceShortName` varchar(10) NOT NULL,
  `ServiceStatus` varchar(15) DEFAULT 'Active',
  `ServiceDescription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`IdService`, `ServiceStandard`, `ServiceShortName`, `ServiceStatus`, `ServiceDescription`) VALUES
(1, 'ISO 9001:2015 - QUALITY MANAGEMENT SYSTEM', '9K', 'Active', 'This standard provides orientation and tools to those Companies and Organizations who want to assure quality in their products and services. The new High Level Structure on ISO 9001, includes the orientation to Client requirements, but also focus on Stakeholders such as the Company itself.'),
(2, 'ISO 14001:2015 - ENVIRONMENTAL MANAGEMENT SYSTEM', '14K', 'Active', 'Environmental is always a concern when Organization have preventive pollution and environmental protection compromise. ISO 14001:2015 and the ISO 14000 family, such as standard ISO 14006 are focus on Environmental systems to achieve the Environmental protection objectives.'),
(3, 'ISO 22000:2018 - FOOD SAFETY MANAGEMENT SYSTEM', '22K', 'Active', 'ISO 22000:2005 Food Safety Management System is focused to guarantee the effective implementation on controls to prevent that the food can harm customer during the Hazard Analysis based on Alimentarius CODEX to identify Hazard: Physical, Chemical, Biological, Radiological.\r\n\r\nThe consequences of unsafe food can be serious and ISO´s food safety management standards help organizations identify and control food safety hazards. As many of today’s food products repeatedly cross national boundaries, International Standards are needed to ensure the safety of the global food supply chain.'),
(4, 'ISO 45001:2018 - HEALTH AND SAFETY MANAGEMENT SYSTEM', '45K', 'Active', 'About than 6,300 person dies per month because of accidents or health because of work activities.These accidents and health sickness because of work activities is really important for the employees and more important for the organization, because of the productivity, pensions, absenteeism, rotation, accident payment and other related with accidents.To avoid the problem, ISO has develop the new estándar ISO 45001:2018 Health an Safety Management System, based on the recognized OHSAS 18001. These standards has the specific requirements to identify potential safety and health risks and to improve the organization performance, reducing to he acceptable levels the probability of accidents and improving the work environment, requested by the Quality Standards.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `validation_keys`
--

CREATE TABLE `validation_keys` (
  `IdKey` int(11) NOT NULL,
  `ValidationCode` varchar(6) NOT NULL,
  `ValidationDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `ValidationEmail` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`IdApp`);

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
  ADD PRIMARY KEY (`IdContact`);

--
-- Indices de la tabla `days_calculation`
--
ALTER TABLE `days_calculation`
  ADD UNIQUE KEY `IdDayCalculation` (`IdDayCalculation`);

--
-- Indices de la tabla `days_calculation_detail9k`
--
ALTER TABLE `days_calculation_detail9k`
  ADD UNIQUE KEY `IdDayCalculationDetail` (`IdDayCalculationDetail`);

--
-- Indices de la tabla `days_calculation_detail14k`
--
ALTER TABLE `days_calculation_detail14k`
  ADD UNIQUE KEY `IdDayCalculationDetail` (`IdDayCalculationDetail`);

--
-- Indices de la tabla `days_calculation_detail22k`
--
ALTER TABLE `days_calculation_detail22k`
  ADD UNIQUE KEY `IdDayCalculationDetail` (`IdDayCalculationDetail`);

--
-- Indices de la tabla `days_calculation_detail45k`
--
ALTER TABLE `days_calculation_detail45k`
  ADD UNIQUE KEY `IdDayCalculationDetail` (`IdDayCalculationDetail`);

--
-- Indices de la tabla `iso9kcomplement`
--
ALTER TABLE `iso9kcomplement`
  ADD UNIQUE KEY `IdComplement` (`IdComplement`);

--
-- Indices de la tabla `iso14kcomplement`
--
ALTER TABLE `iso14kcomplement`
  ADD UNIQUE KEY `IdComplement` (`IdComplement`);

--
-- Indices de la tabla `iso22kcomplement`
--
ALTER TABLE `iso22kcomplement`
  ADD UNIQUE KEY `IdComplement` (`IdComplement`);

--
-- Indices de la tabla `iso45kcomplement`
--
ALTER TABLE `iso45kcomplement`
  ADD UNIQUE KEY `IdComplement` (`IdComplement`);

--
-- Indices de la tabla `master_list`
--
ALTER TABLE `master_list`
  ADD PRIMARY KEY (`IdMasterList`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD UNIQUE KEY `IdNotification` (`IdNotification`);

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
  ADD PRIMARY KEY (`IdRole`);

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
  MODIFY `IdApp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `app_detail`
--
ALTER TABLE `app_detail`
  MODIFY `IdAppDetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
-- AUTO_INCREMENT de la tabla `days_calculation`
--
ALTER TABLE `days_calculation`
  MODIFY `IdDayCalculation` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `days_calculation_detail9k`
--
ALTER TABLE `days_calculation_detail9k`
  MODIFY `IdDayCalculationDetail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `days_calculation_detail14k`
--
ALTER TABLE `days_calculation_detail14k`
  MODIFY `IdDayCalculationDetail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `days_calculation_detail22k`
--
ALTER TABLE `days_calculation_detail22k`
  MODIFY `IdDayCalculationDetail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `days_calculation_detail45k`
--
ALTER TABLE `days_calculation_detail45k`
  MODIFY `IdDayCalculationDetail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `iso9kcomplement`
--
ALTER TABLE `iso9kcomplement`
  MODIFY `IdComplement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `iso14kcomplement`
--
ALTER TABLE `iso14kcomplement`
  MODIFY `IdComplement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `iso22kcomplement`
--
ALTER TABLE `iso22kcomplement`
  MODIFY `IdComplement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `iso45kcomplement`
--
ALTER TABLE `iso45kcomplement`
  MODIFY `IdComplement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `master_list`
--
ALTER TABLE `master_list`
  MODIFY `IdMasterList` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `IdNotification` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `IdEmployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `IdRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de la tabla `sectors`
--
ALTER TABLE `sectors`
  MODIFY `IdSector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1132;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `IdService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `validation_keys`
--
ALTER TABLE `validation_keys`
  MODIFY `IdKey` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
