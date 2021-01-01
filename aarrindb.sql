-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 31-12-2020 a las 18:29:32
-- Versión del servidor: 5.6.49-cll-lve
-- Versión de PHP: 7.3.6

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
  `AssignedTo` varchar(20) DEFAULT 'SALES_ROLE',
  `AppLanguage` varchar(25) NOT NULL,
  `LastCertificateStandard` varchar(50) DEFAULT NULL,
  `LastCertificateExpiration` date DEFAULT NULL,
  `LastCertificateCertifier` varchar(250) DEFAULT NULL,
  `LastCertificateResults` varchar(1500) DEFAULT NULL,
  `NumberEmployees` int(11) NOT NULL,
  `ExternalServicesProvider` varchar(500) DEFAULT NULL,
  `ReceiveConsultancy` tinyint(1) DEFAULT NULL,
  `ConsultantName` varchar(500) DEFAULT NULL,
  `AppComplement` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `AppDetail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `AppDate` datetime NOT NULL,
  `AppStatus` varchar(60) DEFAULT 'On Review'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `applications`
--

INSERT INTO `applications` (`IdApp`, `IdCompany`, `IdContact`, `IdService`, `IdSector`, `AssignedTo`, `AppLanguage`, `LastCertificateStandard`, `LastCertificateExpiration`, `LastCertificateCertifier`, `LastCertificateResults`, `NumberEmployees`, `ExternalServicesProvider`, `ReceiveConsultancy`, `ConsultantName`, `AppComplement`, `AppDetail`, `AppDate`, `AppStatus`) VALUES
(52, 20, 22, 2, 1068, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 252, NULL, NULL, NULL, '{\"IsTransfer\":false,\"CurrentStage\":\"\",\"IdApp\":\"51\",\"ScopeActivities\":\"Productos de limpieza\",\"NumberProcesses\":\"2\",\"LegalRequirements\":\"Ninguno\",\"OperationalControls\":\"Descarga de aguas\",\"CriticalComplaint\":\"Ninguna\",\"DesignResponsability\":false}', '[{\"IdAppDetail\":\"70\",\"IdApp\":\"51\",\"Address\":\"Planta\",\"Shift1\":\"From 06:00 to 14:00\",\"Shift1Employees\":\"100\",\"Shift1Activities\":\"operaciones\",\"Shift2\":\"From 14:00 to 22:00\",\"Shift2Employees\":\"30\",\"Shift2Activities\":\"operaciones\",\"Shift3\":\"From 22:00 to 06:00\",\"Shift3Employees\":\"60\",\"Shift3Activities\":\"operaciones\",\"OfficeShift\":\"From 08:00 to 17:00\",\"OfficeShiftEmployees\":\"30\",\"OfficeShiftActivities\":\"oficinas\",\"IdEstado\":\"14\",\"IdMunicipio\":\"618\",\"IdLocalidad\":\"132485\"},{\"IdAppDetail\":\"71\",\"IdApp\":\"51\",\"Address\":\"planta Tepic\",\"Shift1\":\"From 06:00 to 14:00\",\"Shift1Employees\":\"20\",\"Shift1Activities\":\"a\\u00f1sfkfjs\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":\"From 08:00 to 17:00\",\"OfficeShiftEmployees\":\"12\",\"OfficeShiftActivities\":\"contabilidad\",\"IdEstado\":\"14\",\"IdMunicipio\":\"618\",\"IdLocalidad\":\"132485\"}]', '2020-10-07 23:47:22', 'Expired'),
(53, 3, 11, 1, 1023, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 5, NULL, 0, NULL, '{\"ScopeActivities\":\"Creaci\\u00f3n de Inadores malvados\",\"NumberProcesses\":1,\"LegalRequirements\":\"Ninguno\",\"ProcessAutomationLevel\":\"Hay un robot ayudane\",\"Justification\":null,\"CriticalComplaint\":\"Ninguna\",\"DesignResponsability\":false,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":true,\"CurrentStage\":\"Surveillance Stage\"}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"Direcci\\u00f3n ficticia 12\",\"Shift1\":\"From 19:05 to 19:05\",\"Shift1Employees\":2,\"Shift1Activities\":\"Dise\\u00f1o y ensamblado de Inadores\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"14\",\"IdMunicipio\":\"618\",\"IdLocalidad\":\"132485\"},{\"IdLocalidad\":\"132485\",\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"P\\u00e1nfilo Natera 20-H\",\"Shift1\":\"From 19:06 to 19:06\",\"Shift1Employees\":3,\"Shift1Activities\":\"Creaci\\u00f3n de componentes de acuerdo a planos\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"14\",\"IdMunicipio\":\"618\"}]', '2020-10-22 18:05:33', 'Accepted'),
(54, 3, 11, 2, 1068, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 7, NULL, 0, NULL, '{\"ScopeActivities\":\"Activicades\",\"NumberProcesses\":1,\"LegalRequirements\":\"Ninguno\",\"ProcessAutomationLevel\":null,\"Justification\":null,\"CriticalComplaint\":\"Ninguna\",\"DesignResponsability\":false,\"OperationalControls\":\"Controles\",\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":true,\"CurrentStage\":\"Surveillance Stage\"}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"Avenida 120\",\"Shift1\":\"From 20:03 to 20:03\",\"Shift1Employees\":7,\"Shift1Activities\":\"askndaknds\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"1\",\"IdMunicipio\":\"1\",\"IdLocalidad\":\"197\"}]', '2020-10-22 19:02:18', 'Accepted'),
(55, 3, 11, 1, 1001, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 51, NULL, NULL, NULL, '{\"ScopeActivities\":\"afa\",\"NumberProcesses\":1,\"LegalRequirements\":\"oloasbol b\",\"ProcessAutomationLevel\":\"asdo\\u00b4jfpahns\\u00f1dnjhp\",\"Justification\":null,\"CriticalComplaint\":\"a\\u00f1sklmaskljdpoen \\u00f1fkn\",\"DesignResponsability\":false,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"Direcci\\u00f3n ficticia 12\",\"Shift1\":\"From 20:25 to 20:25\",\"Shift1Employees\":51,\"Shift1Activities\":\"as\\u00f1k asbidfasdasfasf\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"1\",\"IdMunicipio\":\"1\",\"IdLocalidad\":\"197\"}]', '2020-11-03 19:24:28', 'Expired'),
(56, 24, 26, 1, 1035, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 20, NULL, 1, 'Carlos Adrian', '{\"ScopeActivities\":\"Almacenaje de material.\",\"NumberProcesses\":2,\"LegalRequirements\":\"Ninguno---\",\"ProcessAutomationLevel\":\"ninguno\",\"Justification\":\"No tenemos dise\\u00f1o \",\"CriticalComplaint\":\"ninguna\",\"DesignResponsability\":false,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"Av. Guadalupe 6111\",\"Shift1\":\"From 09:00 to 18:00\",\"Shift1Employees\":12,\"Shift1Activities\":\"Almacen, administrativos\",\"Shift2\":\"From 11:00 to 22:00\",\"Shift2Employees\":8,\"Shift2Activities\":\"Almacen, logistica, compras\",\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"14\",\"IdMunicipio\":\"656\",\"IdLocalidad\":\"138421\"}]', '2020-11-17 16:24:30', 'On Review'),
(57, 19, 21, 1, 0, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 28, NULL, NULL, NULL, '{\"ScopeActivities\":\"afdaaefeafaef\",\"NumberProcesses\":1,\"LegalRequirements\":\"dvadvdavadvdav\",\"ProcessAutomationLevel\":\"advdadvadvadvav\",\"Justification\":\"afefqefaf\",\"CriticalComplaint\":\"advadvadv\",\"DesignResponsability\":true,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":true,\"CurrentStage\":\"Surveillance 1\"}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"wqqefqef\",\"Shift1\":\"From 14:45 to 14:49\",\"Shift1Employees\":28,\"Shift1Activities\":\"afefaefaf\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"1\",\"IdMunicipio\":\"10\",\"IdLocalidad\":\"2749\"}]', '2020-11-17 23:42:43', 'On Review'),
(58, 19, 21, 1, 0, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, '{\"ScopeActivities\":\"eaafaefaef\",\"NumberProcesses\":1,\"LegalRequirements\":\"aefaf\",\"ProcessAutomationLevel\":\"advdadvadvadvav\",\"Justification\":\"acadcdacda\",\"CriticalComplaint\":\"advadvadv\",\"DesignResponsability\":false,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"q3dqffefqefqef\",\"Shift1\":\"From 13:48 to 23:48\",\"Shift1Employees\":3,\"Shift1Activities\":\"aceacacecaec\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"5\",\"IdMunicipio\":\"36\",\"IdLocalidad\":\"21419\"}]', '2020-11-17 23:48:49', 'On Review'),
(59, 19, 21, 1, 1015, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 5, NULL, 0, NULL, '{\"ScopeActivities\":\"eafaefaef\",\"NumberProcesses\":1,\"LegalRequirements\":\"aefefaefae\",\"ProcessAutomationLevel\":\"advdadvadvadvav\",\"Justification\":\"acadcdacda\",\"CriticalComplaint\":\"advadvadv\",\"DesignResponsability\":false,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"efafefafae\",\"Shift1\":\"From 01:29 to 13:29\",\"Shift1Employees\":5,\"Shift1Activities\":\"aefaefaefef\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"8\",\"IdMunicipio\":\"208\",\"IdLocalidad\":\"61926\"}]', '2020-11-18 01:30:13', 'On Review'),
(60, 3, 11, 2, 1073, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '{\"ScopeActivities\":\"dafaeaef\",\"NumberProcesses\":1,\"LegalRequirements\":\"eafaefea\",\"ProcessAutomationLevel\":null,\"Justification\":null,\"CriticalComplaint\":\"aefaf\",\"DesignResponsability\":null,\"OperationalControls\":\"aefa\",\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"efaefaefe\",\"Shift1\":\"From 02:03 to 14:03\",\"Shift1Employees\":1,\"Shift1Activities\":\"afefaefeafaef\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"3\",\"IdMunicipio\":\"21\",\"IdLocalidad\":\"14876\"}]', '2020-11-18 14:03:30', 'On Review'),
(61, 3, 11, 1, 1003, 'SALESCDMX_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, '{\"ScopeActivities\":\"eaf\",\"NumberProcesses\":2,\"LegalRequirements\":\"efafaffefaf\",\"ProcessAutomationLevel\":\"advdadvadvadvav\",\"Justification\":\"acadcdacda\",\"CriticalComplaint\":\"eaff\",\"DesignResponsability\":false,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"efaeafef\",\"Shift1\":\"From 02:10 to 14:10\",\"Shift1Employees\":1,\"Shift1Activities\":\"afeeafaef\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"4\",\"IdMunicipio\":\"22\",\"IdLocalidad\":\"15061\"}]', '2020-11-18 14:10:45', 'On Proposal'),
(62, 3, 11, 1, 0, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, '{\"ScopeActivities\":\"dfafarfa\",\"NumberProcesses\":2,\"LegalRequirements\":\"arvrvarv\",\"ProcessAutomationLevel\":\"advdadvadvadvav\",\"Justification\":\"acadcdacda\",\"CriticalComplaint\":\"advadvadv\",\"DesignResponsability\":null,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"eafeafefa\",\"Shift1\":\"From 09:50 to 21:50\",\"Shift1Employees\":2,\"Shift1Activities\":\"adafafaf\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"4\",\"IdMunicipio\":\"23\",\"IdLocalidad\":\"15672\"}]', '2020-11-19 09:51:19', 'On Review'),
(63, 3, 11, 3, 0, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, '{\"ScopeActivities\":null,\"NumberProcesses\":null,\"LegalRequirements\":\"aefaefafefaefaefaef\",\"ProcessAutomationLevel\":null,\"Justification\":null,\"CriticalComplaint\":null,\"DesignResponsability\":null,\"OperationalControls\":null,\"NumberHACCP\":2,\"GeneralDescription\":\"efafefae\",\"NumberLinesProducts\":2,\"Seasonality\":\"fafefef\",\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"eaefeff\",\"Shift1\":\"From 09:52 to 21:52\",\"Shift1Employees\":2,\"Shift1Activities\":\"adfefaefeafaefae\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"4\",\"IdMunicipio\":\"22\",\"IdLocalidad\":\"15061\"}]', '2020-11-19 09:52:14', 'On Review'),
(64, 3, 11, 2, 1121, 'SALES_ROLE', 'Spanish', '', NULL, NULL, NULL, 1, NULL, 0, NULL, '{\"ScopeActivities\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos eos porro sint nihil similique incidunt mollitia molestiae sapiente aliquam. Ex consequatur quibusdam cum harum possimus, quos optio fuga excepturi nihil.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos eos porro sint nihil similique incidunt mollitia molestiae sapiente aliquam. Ex consequatur quibusdam cum harum possimus, quos optio fuga excepturi nihil.Lorem ipsum dolor sit amet, consectetur adipisicing \",\"NumberProcesses\":1,\"LegalRequirements\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos eos porro sint nihil similique incidunt mollitia molestiae sapiente aliquam. Ex consequatur quibusdam cum harum possimus, quos optio fuga excepturi nihil.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos eos porro sint nihil similique incidunt mollitia molestiae sapiente aliquam. Ex consequatur quibusdam cum harum possimus, quos optio fuga excepturi nihil.Lorem ipsum dolor sit amet, consectetur adipisicing \",\"ProcessAutomationLevel\":null,\"Justification\":null,\"CriticalComplaint\":\"advadvadv\",\"DesignResponsability\":false,\"OperationalControls\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos eos porro sint nihil similique incidunt mollitia molestiae sapiente aliquam. Ex consequatur quibusdam cum harum possimus, quos optio fuga excepturi nihil.\\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos eos porro sint nihil similique incidunt mollitia molestiae sapiente aliquam. Ex consequatur quibusdam cum harum possimus, quos optio fuga excepturi nihil.\\nLorem ipsum dolor sit amet, consectetur adipisicin\",\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"dcadcadc\",\"Shift1\":\"From 12:05 to 14:02\",\"Shift1Employees\":1,\"Shift1Activities\":\"adcadcadc\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"2\",\"IdMunicipio\":\"12\",\"IdLocalidad\":\"5463\"}]', '2020-12-08 12:03:03', 'On Review'),
(65, 3, 11, 2, 1126, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 40, NULL, 0, NULL, '{\"ScopeActivities\":\"Ense\\u00f1anza de nueva t\\u00e9cnicas para la creaci\\u00f3n de nuevos innadores\",\"NumberProcesses\":1,\"LegalRequirements\":\"Ninguno\",\"ProcessAutomationLevel\":null,\"Justification\":null,\"CriticalComplaint\":\"Ninguna\",\"DesignResponsability\":false,\"OperationalControls\":\"Control de pr\\u00e9stamo de herramienta para la creaci\\u00f3n de Innadores\",\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"\\u00c1vila Camacho #12\",\"Shift1\":\"From 07:00 to 15:00\",\"Shift1Employees\":20,\"Shift1Activities\":\"Ense\\u00f1anza de m\\u00e9todos y protocolos\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"14\",\"IdMunicipio\":\"550\",\"IdLocalidad\":\"121366\"},{\"IdLocalidad\":\"132485\",\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"Pedro Moreno #175\",\"Shift1\":\"From 07:00 to 13:00\",\"Shift1Employees\":20,\"Shift1Activities\":\"Ense\\u00f1anza de m\\u00e9todos y protocolos para la creaci\\u00f3n de nuevos Innadores\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"14\",\"IdMunicipio\":\"618\"}]', '2020-12-11 16:00:39', 'On Change Request'),
(66, 21, 23, 1, 1031, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 27, NULL, 0, NULL, '{\"ScopeActivities\":\"almacenaje y transportaci\\u00f3n de productos enlatados\",\"NumberProcesses\":4,\"LegalRequirements\":\"ninguno\",\"ProcessAutomationLevel\":\"no\",\"Justification\":\"No tenemos dise\\u00f1o \",\"CriticalComplaint\":\"ninguna\",\"DesignResponsability\":false,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"prueba\",\"Shift1\":\"From 10:00 to 18:00\",\"Shift1Employees\":15,\"Shift1Activities\":\"djdjdcclaloaiejdnnvhfj\",\"Shift2\":\"From 12:00 to 20:00\",\"Shift2Employees\":12,\"Shift2Activities\":\"djdkamdkoadmnd\",\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"14\",\"IdMunicipio\":\"580\",\"IdLocalidad\":\"125934\"}]', '2020-12-22 15:37:38', 'On Review'),
(67, 3, 11, 1, 0, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, '{\"ScopeActivities\":\"lkndcaipcjkacuehckanbcijcae\",\"NumberProcesses\":2,\"LegalRequirements\":\"kñcmañdjcpid caciphechpucahjnehcaneehdhaiejdñejduhaee\",\"ProcessAutomationLevel\":\"advdadvadvadvav\",\"Justification\":\"acadcdacda\",\"CriticalComplaint\":\"advadvadv\",\"DesignResponsability\":null,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"las cosas que suceden en mexico y en el musdo\",\"Shift1\":\"From 23:53 to 23:53\",\"Shift1Employees\":3,\"Shift1Activities\":\"cajchdjciaeicj iae\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"3\",\"IdMunicipio\":\"19\",\"IdLocalidad\":\"12330\"},{\"IdLocalidad\":\"12707\",\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"dcadcacaead\",\"Shift1\":\"From 23:54 to 23:54\",\"Shift1Employees\":2,\"Shift1Activities\":\"cadcnalcjcjñiacpieaj\",\"Shift2\":\"From 23:54 to 23:54\",\"Shift2Employees\":3,\"Shift2Activities\":\"cdcadcdacda\",\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"5\",\"IdMunicipio\":0}]', '2020-12-22 23:54:46', 'On Review'),
(68, 3, 11, 2, 1072, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 2, NULL, 0, NULL, '{\"ScopeActivities\":\"acdcaeaecadcad\",\"NumberProcesses\":2,\"LegalRequirements\":\"dacdacadc\",\"ProcessAutomationLevel\":null,\"Justification\":null,\"CriticalComplaint\":\"no ninguna\",\"DesignResponsability\":false,\"OperationalControls\":\"dcadcadcad\",\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"domicilio 2\",\"Shift1\":\"From 01:01 to 01:02\",\"Shift1Employees\":2,\"Shift1Activities\":\"dcadc\\u00f1jc\\u00f1ajc\\u00f1jd\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"10\",\"IdMunicipio\":\"292\",\"IdLocalidad\":\"85204\"}]', '2020-12-23 00:02:19', 'Accepted'),
(69, 3, 11, 0, 0, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, '{\"ScopeActivities\":null,\"NumberProcesses\":null,\"LegalRequirements\":null,\"ProcessAutomationLevel\":null,\"Justification\":null,\"CriticalComplaint\":null,\"DesignResponsability\":null,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":true,\"CurrentStage\":\"Surveillance 1\"}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"pruba a \",\"Shift1\":\"From 19:39 to 19:39\",\"Shift1Employees\":2,\"Shift1Activities\":\"scacacscas\",\"Shift2\":null,\"Shift2Employees\":null,\"Shift2Activities\":null,\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"3\",\"IdMunicipio\":\"21\",\"IdLocalidad\":\"14898\"}]', '2020-12-23 07:39:57', 'On Review'),
(70, 21, 23, 1, 1035, 'SALES_ROLE', 'Spanish', NULL, NULL, NULL, NULL, 28, NULL, 0, NULL, '{\"ScopeActivities\":\"Inyecci\\u00f3n de pl\\u00e1sticos\",\"NumberProcesses\":2,\"LegalRequirements\":\"ninguno\",\"ProcessAutomationLevel\":\"maquinaria\",\"Justification\":\"bajo especificaci\\u00f3n del cliente\",\"CriticalComplaint\":\"ninguna\",\"DesignResponsability\":false,\"OperationalControls\":null,\"NumberHACCP\":null,\"GeneralDescription\":null,\"NumberLinesProducts\":null,\"Seasonality\":null,\"FatalitiesRate\":null,\"AccidentsRate\":null,\"InjuriesRate\":null,\"NearMissRate\":null,\"OHSMSAudit\":null,\"HighLevelRisks\":null,\"IsTransfer\":false,\"CurrentStage\":null}', '[{\"IdAppDetail\":null,\"IdApp\":null,\"Address\":\"playa\",\"Shift1\":\"From 08:00 to 16:00\",\"Shift1Employees\":18,\"Shift1Activities\":\"jfjdkksmaalldmf\",\"Shift2\":\"From 10:00 to 18:00\",\"Shift2Employees\":10,\"Shift2Activities\":\"eisladnfwpfnosdjci\",\"Shift3\":null,\"Shift3Employees\":null,\"Shift3Activities\":null,\"OfficeShift\":null,\"OfficeShiftEmployees\":null,\"OfficeShiftActivities\":null,\"IdEstado\":\"14\",\"IdMunicipio\":\"603\",\"IdLocalidad\":\"130222\"}]', '2020-12-23 12:07:07', 'Accepted');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audit_plan`
--

CREATE TABLE `audit_plan` (
  `IdAuditPlan` int(100) NOT NULL,
  `IdLetter` int(11) NOT NULL,
  `AuditPlanDateStart` datetime DEFAULT NULL,
  `AuditPlanDateEnd` datetime DEFAULT NULL,
  `AuditPlanStatus` varchar(100) DEFAULT 'Start',
  `audit_planDatil` longtext NOT NULL,
  `Technical_Report` longtext NOT NULL,
  `Positive_Issues` text NOT NULL,
  `Oppor_impro` text NOT NULL,
  `Audit_Plant_Recommendation` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `audit_plan`
--

INSERT INTO `audit_plan` (`IdAuditPlan`, `IdLetter`, `AuditPlanDateStart`, `AuditPlanDateEnd`, `AuditPlanStatus`, `audit_planDatil`, `Technical_Report`, `Positive_Issues`, `Oppor_impro`, `Audit_Plant_Recommendation`) VALUES
(2, 1, '2020-12-23 16:37:15', NULL, 'Process', '', '', '', '', 0);

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
(3, 'Malvados y Asociados S.A de C.V.', 'MAL201910KU0', 'Independencia #425', 'https://malvados.asociados.mx', 'https://aarrin.com/mobile/app_resources/companies/logo_3.Image-MAL201910KU0.Clajhasd9ul3iu0a.ñohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(19, 'Organización Sin un Buen Acrónimo', 'OSBA020202JI9', 'Pánfilo Natera 20-H', 'https://phineasyferb.fandom.com/es/wiki/Doofenshmirtz_Malvados_y_Asociados', NULL, 'Active'),
(20, 'GreenTellus', 'GTE200109BEA', 'Tlaquepaque ', 'www.greentellus.com', NULL, 'Active'),
(21, 'Patitos Company. SA DE CV', 'PATC250520HJ8', 'AV. PATRIA 1120 Col. Chamichines, Guadalajara, Jal.', '', NULL, 'Active'),
(22, 'Instituto Tecnológico de Ciudad Guzmán', 'ITC202020LJ9', 'Avenida Tecnológico sn', 'http://www.itcg.edu.mx', 'https://aarrin.com/mobile/app_resources/companies/logo_22.Image-ITC202020LJ9.Clajhasd9ul3iu0a.ñohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(23, 'Prueba 03 julio', 'COSD940111MJ0', 'av patria 2020', 'www.p03.com', 'https://aarrin.com/mobile/app_resources/companies/logo_23.Image-COSD940111MJ0.Clajhasd9ul3iu0a.ñohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(24, 'Empresa de Prueba, S.A.', 'COSD941103MN9', 'Guadalajara Jalisco Mexico', '', NULL, 'Active'),
(25, 'Bursting Code', 'BRCO201003KU8', 'Pánfilo Natera #20-H, Sayula, Jalisco', 'https://www.burstingcode.com', NULL, 'Active'),
(28, 'Bursting Code', 'BUC201123KU8', 'Pánfilo Nátera #20-H, Sayula, Jalisco', '', NULL, 'Active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `confirmation_letters`
--

CREATE TABLE `confirmation_letters` (
  `IdLetter` int(11) NOT NULL,
  `IdContract` int(11) NOT NULL,
  `LetterCreationDate` datetime NOT NULL,
  `IdLetterReviewer` int(11) DEFAULT NULL,
  `LetterApproved` tinyint(1) DEFAULT '0',
  `LetterApprovedDate` datetime DEFAULT NULL,
  `LetterClientApprove` tinyint(1) DEFAULT '0',
  `LetterClientApproveDate` datetime DEFAULT NULL,
  `IdAuditLeader` int(11) DEFAULT NULL,
  `Auditors` longtext,
  `TecnicalExperts` longtext,
  `Observers` longtext,
  `IsBackToBack` tinyint(1) DEFAULT '0',
  `ReviewReport` tinytext,
  `InternalAuditReport` tinytext,
  `ProcessManual` tinytext,
  `ProcessInteractionMap` tinytext,
  `OperationalControls` tinytext,
  `HazardAnalysis` tinytext,
  `LetterStatus` varchar(60) DEFAULT 'Waiting for client files'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `confirmation_letters`
--

INSERT INTO `confirmation_letters` (`IdLetter`, `IdContract`, `LetterCreationDate`, `IdLetterReviewer`, `LetterApproved`, `LetterApprovedDate`, `LetterClientApprove`, `LetterClientApproveDate`, `IdAuditLeader`, `Auditors`, `TecnicalExperts`, `Observers`, `IsBackToBack`, `ReviewReport`, `InternalAuditReport`, `ProcessManual`, `ProcessInteractionMap`, `OperationalControls`, `HazardAnalysis`, `LetterStatus`) VALUES
(1, 26, '2020-12-04 17:32:16', 1, 1, '2020-12-31 15:50:54', 1, '2020-12-31 15:50:54', 12, '[{\"IdEmployee\":\"12\"},{\"IdMasterList\":\"40\",\"IdEmployee\":\"30\",\"EmployeeName\":\"Auditor \",\"EmployeeLastName\":\"P\\u00e9rez L\\u00f3pez\",\"EmployeeDegree\":null,\"EmployeeRFC\":\"APL900120AP7\",\"EmployeePhoto\":null,\"EmployeeStatus\":\"Active\"}]', '[]', NULL, 0, 'https://aarrin.com/mobile/app_resources/confirmation_letters/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/UmV2aWV3X1JlcG9ydF9ieV9BZG1pbl8x.jpg', 'https://aarrin.com/mobile/app_resources/confirmation_letters/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/SW50ZXJuYWxfQXVkaXRfUmVwb3J0XzE=.jpg', 'https://aarrin.com/mobile/app_resources/confirmation_letters/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/UHJvY2Vzc19NYW51YWxfMQ==.jpg', 'https://aarrin.com/mobile/app_resources/confirmation_letters/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/UHJvY2Nlc3NfSXRlcmFjdGlvbl9NYXBfMQ==.jpg', NULL, NULL, 'Letter approved'),
(3, 28, '2020-12-23 14:54:36', NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 'https://aarrin.com/mobile/app_resources/confirmation_letters/SVNPIDE0MDAxOjIwMTUgLSBFTlZJUk9OTUVOVEFMIE1BTkFHRU1FTlQgU1lTVEVN/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/UmV2aWV3X1JlcG9ydF9ieV9BZG1pbl8z.jpg', 'https://aarrin.com/mobile/app_resources/confirmation_letters/SVNPIDE0MDAxOjIwMTUgLSBFTlZJUk9OTUVOVEFMIE1BTkFHRU1FTlQgU1lTVEVN/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/SW50ZXJuYWxfQXVkaXRfUmVwb3J0XzM=.jpg', 'https://aarrin.com/mobile/app_resources/confirmation_letters/SVNPIDE0MDAxOjIwMTUgLSBFTlZJUk9OTUVOVEFMIE1BTkFHRU1FTlQgU1lTVEVN/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/UHJvY2Vzc19NYW51YWxfMw==.jpg', NULL, 'https://aarrin.com/mobile/app_resources/confirmation_letters/SVNPIDE0MDAxOjIwMTUgLSBFTlZJUk9OTUVOVEFMIE1BTkFHRU1FTlQgU1lTVEVN/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/T3BlcmF0aW9uYWxfQ29udHJvbHNfMw==.jpg', NULL, 'Waiting for ARI review'),
(2, 29, '2020-12-23 13:03:38', NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Waiting for client files');

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
(11, 3, 1, 'Heinz Doofmenshmirtz', '9874561230', 'evil_doof@mermelada.com', 'Genio Malvado', 0x2483bb4d9af50039ba5bd69f5a16eeb9, 'https://aarrin.com/mobile/app_resources/contacts/profile_11.Image-evil_doof@mermelada.com.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(12, 3, 0, 'Alois Everard Elizabeth Otto Wolfgang Hypatia Gunter Geilen Gary Cooper Von Rodenstein', '5555555555', 'evil_rodney@mermelada.com', 'Doctor del Mal', 0x2483bb4d9af50039ba5bd69f5a16eeb9, NULL, 'Active'),
(21, 19, 1, 'Mayor Francis Monograma', '3421006559', 'asm_1995@outlook.com', 'Lider de la organización', 0x2483bb4d9af50039ba5bd69f5a16eeb9, 'https://aarrin.com/mobile/app_resources/contacts/profile_21.Image-asm_1995@outlook.com.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(22, 20, 1, 'Alberto Tello', '3316051393', 'contact.greentellus@gmail.com', 'General Manager', 0x8b0d7e2cc3145de191f3483d06a1fbbe, NULL, 'Active'),
(23, 21, 1, 'Diana Cortés', '3311957480', 'dianjcortess@gmail.com', 'VENTAS', 0x35438abf65edc15410d84ee34c4d6ee3, 'https://aarrin.com/mobile/app_resources/contacts/profile_23.Image-dianjcortess@gmail.com.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(24, 22, 1, 'Yael Alejandro Santana Michel', '3421006559', 'yael15290765@itcg.edu.mx', 'Estudiante', 0x2483bb4d9af50039ba5bd69f5a16eeb9, 'https://aarrin.com/mobile/app_resources/contacts/profile_24.Image-yael15290765@itcg.edu.mx.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active'),
(25, 23, 1, 'Diana Silva', '33222145587', 'dianjcortess@hotmail.com', 'Sales', 0x9cb1fabc46f994fd51fb90b034ec6905, NULL, 'Active'),
(26, 24, 1, 'Lucina Cortes', '3311957480', 'ventas@im-prove.com.mx', 'Director', 0x96f2cd52391429cdbad2988e4817f5b0, NULL, 'Active'),
(27, 28, 1, 'Alejandro Santana Michel', '3421107062', 'knd5040122@gmail.com', 'Desarrollador', 0x5411a461e39fe28709a073078ffc3e42, 'https://aarrin.com/mobile/app_resources/contacts/profile_27.Image-knd5040122@gmail.com.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png', 'Active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contracts`
--

CREATE TABLE `contracts` (
  `IdContract` int(11) NOT NULL,
  `IdProposal` int(11) NOT NULL,
  `IdPersonal` int(11) NOT NULL,
  `IdService` int(11) NOT NULL,
  `CreationDate` datetime NOT NULL,
  `File` varchar(250) DEFAULT NULL,
  `Approve` tinyint(1) DEFAULT '0',
  `ApproveDate` datetime DEFAULT NULL,
  `UltimateFile` varchar(250) DEFAULT NULL,
  `ClientApprove` tinyint(1) DEFAULT '0',
  `ClientApproveDate` datetime DEFAULT NULL,
  `ClientFile` varchar(250) DEFAULT NULL,
  `CurrentStage` int(11) NOT NULL,
  `LegalRepresentativeID` varchar(250) DEFAULT NULL,
  `RFCFile` varchar(250) DEFAULT NULL,
  `OriginAccount` varchar(250) DEFAULT NULL,
  `ProofAddress` varchar(250) DEFAULT NULL,
  `PurchaseOrder` varchar(250) DEFAULT NULL,
  `Stage1Date` datetime DEFAULT NULL,
  `Stage2Date` datetime DEFAULT NULL,
  `Surveillance1Date` datetime DEFAULT NULL,
  `Surveillance2Date` datetime DEFAULT NULL,
  `RecertificationDate` datetime DEFAULT NULL,
  `ContractStatus` varchar(50) NOT NULL DEFAULT 'Waiting for client signature'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contracts`
--

INSERT INTO `contracts` (`IdContract`, `IdProposal`, `IdPersonal`, `IdService`, `CreationDate`, `File`, `Approve`, `ApproveDate`, `UltimateFile`, `ClientApprove`, `ClientApproveDate`, `ClientFile`, `CurrentStage`, `LegalRepresentativeID`, `RFCFile`, `OriginAccount`, `ProofAddress`, `PurchaseOrder`, `Stage1Date`, `Stage2Date`, `Surveillance1Date`, `Surveillance2Date`, `RecertificationDate`, `ContractStatus`) VALUES
(26, 14, 1, 1, '2020-11-25 03:13:15', 'https://aarrin.com/mobile/app_resources/contracts/ISO_9001:2015_-_QUALITY_MANAGEMENT_SYSTEM/Malvados_y_Asociados_S.A_de_C.V./Q29udHJhY3Q=.pdf', 0, NULL, NULL, 1, '2020-12-31 15:50:41', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/Q29udHJhY3QoQ2xpZW50X0FwcHJvdmVkKSgyMDIwLTEyLTE1IDE3OjU4OjUwKQ==.pdf', 1, 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/TGVnYWxfUmVwcmVzZW50YXRpdmVfSURfMjY=.png', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/UkZDX2NvcHlfMjY=.jpg', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/QWNjb3VudF9kYXRhXzI2.jpg', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/UHJvb2ZfYWRkcmVzc18yNg==.pdf', NULL, '2021-01-20 06:00:00', '2021-07-19 05:00:00', '2022-07-19 05:00:00', '2023-07-19 05:00:00', '2024-05-20 05:00:00', 'Waiting for ARI review'),
(27, 16, 6, 2, '2020-11-27 17:23:25', 'https://aarrin.com/mobile/app_resources/contracts/ISO_9001:2015_-_QUALITY_MANAGEMENT_SYSTEM/Malvados_y_Asociados_S.A_de_C.V./Q29udHJhY3Q=.pdf', 1, '2020-11-27 17:38:33', 'https://aarrin.com/mobile/app_resources/contracts/ISO_9001:2015_-_QUALITY_MANAGEMENT_SYSTEM/Malvados_y_Asociados_S.A_de_C.V./Q29udHJhY3QoRmluYWwpKEFwcHJvdmVkKQ==.png', 1, '2020-11-27 17:38:33', 'https://aarrin.com/mobile/app_resources/contracts/ISO_9001:2015_-_QUALITY_MANAGEMENT_SYSTEM/Malvados_y_Asociados_S.A_de_C.V./Q29udHJhY3QoQ2xpZW50X0FwcHJvdmVkKQ==.pdf', 1, 'https://aarrin.com/mobile/app_resources/contracts/ISO_9001:2015_-_QUALITY_MANAGEMENT_SYSTEM/Malvados_y_Asociados_S.A_de_C.V./TGVnYWxfUmVwcmVzZW50YXRpdmVfSUQ=.png', 'https://aarrin.com/mobile/app_resources/contracts/ISO_9001:2015_-_QUALITY_MANAGEMENT_SYSTEM/Malvados_y_Asociados_S.A_de_C.V./UkZDX2NvcHk=.jpg', 'https://aarrin.com/mobile/app_resources/contracts/ISO_9001:2015_-_QUALITY_MANAGEMENT_SYSTEM/Malvados_y_Asociados_S.A_de_C.V./QWNjb3VudF9kYXRh.jpg', 'https://aarrin.com/mobile/app_resources/contracts/ISO_9001:2015_-_QUALITY_MANAGEMENT_SYSTEM/Malvados_y_Asociados_S.A_de_C.V./UHJvb2ZfYWRkcmVzcw==.pdf', NULL, NULL, NULL, NULL, NULL, NULL, 'Approved'),
(28, 22, 10, 2, '2020-12-23 10:13:06', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/Q29udHJhY3QgKDIwMjAtMTItMjMgMTA6MTM6MDYp.pdf', 1, '2020-12-23 16:58:56', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/Q29udHJhY3QoRmluYWwpKEFwcHJvdmVkKSgyMDIwLTEyLTIzIDE0OjU0OjM4KQ==.pdf', 1, '2020-12-23 16:58:56', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/Q29udHJhY3QoQ2xpZW50X0FwcHJvdmVkKSgyMDIwLTEyLTIzIDExOjEyOjQ2KQ==.pdf', 3, NULL, NULL, 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/QWNjb3VudF9kYXRhXzI4.png', NULL, NULL, NULL, NULL, '2021-01-21 06:00:00', '2022-01-20 06:00:00', '2022-11-20 06:00:00', 'Approved'),
(29, 23, 11, 1, '2020-12-23 12:51:10', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/UGF0aXRvcyBDb21wYW55LiBTQSBERSBDVg==/Q29udHJhY3QgKDIwMjAtMTItMjMgMTI6NTE6MTAp.pdf', 1, '2020-12-23 13:03:46', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/UGF0aXRvcyBDb21wYW55LiBTQSBERSBDVg==/Q29udHJhY3QoRmluYWwpKEFwcHJvdmVkKSgyMDIwLTEyLTIzIDEzOjAzOjQ2KQ==.pdf', 1, '2020-12-23 13:03:46', 'https://aarrin.com/mobile/app_resources/contracts/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/UGF0aXRvcyBDb21wYW55LiBTQSBERSBDVg==/Q29udHJhY3QoQ2xpZW50X0FwcHJvdmVkKSgyMDIwLTEyLTIzIDEzOjAyOjEzKQ==.pdf', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Approved');

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
  `DaysCalculationDetail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `DaysCalculationStatus` varchar(30) DEFAULT 'Waiting for Approvement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `days_calculation`
--

INSERT INTO `days_calculation` (`IdDayCalculation`, `IdApp`, `IdCreatorEmployee`, `IdReviewerEmployee`, `DayCalculationDate`, `DayCalculationApproved`, `DayCalculationApprovedDate`, `DaysInitialStage`, `DaysSurveillance`, `DaysRR`, `DaysCalculationDetail`, `DaysCalculationStatus`) VALUES
(47, 52, 6, 1, '2020-10-08 22:33:44', 1, '2020-10-14 17:36:14', 19, 6.5, 13, '[{\"IdDayCalculationDetail\":\"18\",\"IdDayCalculation\":\"46\",\"NumberEmployees\":220,\"InitialMD\":12,\"SystemComplex\":null,\"SystemComplexComment\":null,\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"OutsourcedProcesses\":null,\"OutsourcedProcessesComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"DaysInitialStage\":12,\"DaysSurveillance\":4,\"DaysRR\":8,\"DesignResponsability\":false,\"SmallLargePersonnel\":false,\"UseInterpreter\":false,\"OffSiteStorage\":false,\"CertificationControlled\":false},{\"IdDayCalculationDetail\":\"19\",\"IdDayCalculation\":\"46\",\"NumberEmployees\":32,\"InitialMD\":7,\"SystemComplex\":null,\"SystemComplexComment\":null,\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"OutsourcedProcesses\":null,\"OutsourcedProcessesComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"DaysInitialStage\":7,\"DaysSurveillance\":2.5,\"DaysRR\":5,\"DesignResponsability\":false,\"SmallLargePersonnel\":false,\"UseInterpreter\":false,\"OffSiteStorage\":false,\"CertificationControlled\":false}]', 'Approved'),
(48, 53, 1, 12, '2020-10-22 19:30:27', 1, '2020-10-27 18:12:53', 4, 2, 3, '[{\"NumberEmployees\":2,\"InitialMD\":1.5,\"SystemComplex\":null,\"SystemComplexComment\":null,\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":1.5,\"OutsourcedProcesses\":false,\"SmallLargePersonnel\":false},{\"NumberEmployees\":3,\"InitialMD\":1.5,\"SystemComplex\":null,\"SystemComplexComment\":null,\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":1.5,\"OutsourcedProcesses\":false,\"SmallLargePersonnel\":false}]', 'Approved'),
(49, 54, 12, 1, '2020-11-03 19:14:28', 1, '2020-11-03 19:14:45', 3.5, 1.5, 2.5, '[{\"NumberEmployees\":7,\"InitialMD\":3.5,\"SystemComplex\":false,\"SystemComplexComment\":\"comentario\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"comentario\",\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":false,\"IndirectAspectsComment\":\"\",\"DifferentLanguage\":false,\"DifferentLanguageComment\":\"\",\"Maturity\":false,\"MaturityComment\":\"comentario\",\"AutomationLevel\":false,\"AutomationLevelComment\":\"\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":3.5,\"DaysSurveillance\":1.5,\"DaysRR\":2.5,\"OutsourcedProcesses\":false,\"OutsourcedProcessesComment\":\"comentario\",\"SmallLargePersonnel\":false}]', 'Approved'),
(50, 55, 1, 12, '2020-11-03 19:24:50', 1, '2020-11-04 22:35:57', 5, 2, 3.5, '[{\"NumberEmployees\":51,\"InitialMD\":5,\"SystemComplex\":null,\"SystemComplexComment\":null,\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":5,\"DaysSurveillance\":2,\"DaysRR\":3.5,\"OutsourcedProcesses\":false,\"SmallLargePersonnel\":false}]', 'Approved'),
(51, 56, 11, 1, '2020-11-17 17:42:31', 1, '2020-11-17 17:51:47', 2.5, 1, 1.5, '[{\"NumberEmployees\":20,\"InitialMD\":3,\"SystemComplex\":false,\"SystemComplexComment\":\"ddfcssa\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"aaaaaa\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"aaaaa\",\"DesignResponsability\":false,\"DesignResponsabilityComment\":\"aaaaa\",\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":false,\"DifferentLanguageComment\":\"\",\"Maturity\":false,\"MaturityComment\":\"\",\"AutomationLevel\":true,\"AutomationLevelComment\":\"aaaa\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2.5,\"DaysSurveillance\":1,\"DaysRR\":1.5}]', 'Approved'),
(52, 56, 11, 6, '2020-11-17 17:42:39', 1, '2020-11-17 17:44:11', 2.5, 1, 1.5, '[{\"NumberEmployees\":20,\"InitialMD\":3,\"SystemComplex\":false,\"SystemComplexComment\":\"ddfcssa\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"aaaaaa\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"aaaaa\",\"DesignResponsability\":false,\"DesignResponsabilityComment\":\"aaaaa\",\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":false,\"DifferentLanguageComment\":\"\",\"Maturity\":false,\"MaturityComment\":\"\",\"AutomationLevel\":true,\"AutomationLevelComment\":\"aaaa\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2.5,\"DaysSurveillance\":1,\"DaysRR\":1.5}]', 'Approved'),
(53, 59, 10, NULL, '2020-11-18 13:42:13', 0, NULL, 2, 1, 2, '[{\"NumberEmployees\":5,\"InitialMD\":1.5,\"SystemComplex\":true,\"SystemComplexComment\":\"dafadfa\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"afadfad\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"dafadfa\",\"DesignResponsability\":false,\"DesignResponsabilityComment\":\"afasfasfaf\",\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":true,\"DifferentLanguageComment\":\"asfasfafasfa\",\"Maturity\":false,\"MaturityComment\":\"\",\"AutomationLevel\":true,\"AutomationLevelComment\":\"asfasfsafas\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":2}]', 'Waiting for Approvement'),
(54, 60, 10, NULL, '2020-11-18 14:07:38', 0, NULL, 4, 1.5, 4, '[{\"NumberEmployees\":1,\"InitialMD\":3,\"SystemComplex\":true,\"SystemComplexComment\":\"faefaf\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"\",\"ScopeRegulation\":true,\"ScopeRegulationComment\":\"aeffaef\",\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":false,\"IndirectAspectsComment\":\"\",\"DifferentLanguage\":false,\"DifferentLanguageComment\":\"\",\"Maturity\":false,\"MaturityComment\":\"\",\"AutomationLevel\":false,\"AutomationLevelComment\":\"\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":4,\"DaysSurveillance\":1.5,\"DaysRR\":4,\"OutsourcedProcesses\":true,\"OutsourcedProcessesComment\":\"efafeafa\"}]', 'Waiting for Approvement'),
(55, 61, 10, NULL, '2020-11-18 14:11:54', 0, NULL, 2, 1, 1.5, '[{\"NumberEmployees\":1,\"InitialMD\":1.5,\"SystemComplex\":false,\"SystemComplexComment\":\"aefef\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"ecaeca\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"caecaaec\",\"DesignResponsability\":false,\"DesignResponsabilityComment\":\"aececace\",\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":true,\"DifferentLanguageComment\":\"aecaecaecae\",\"Maturity\":true,\"MaturityComment\":\"cecac\",\"AutomationLevel\":false,\"AutomationLevelComment\":\"\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":1.5}]', 'Waiting for Approvement'),
(56, 61, 10, NULL, '2020-11-18 14:14:00', 0, NULL, 2, 1, 2, '[{\"NumberEmployees\":1,\"InitialMD\":1.5,\"SystemComplex\":true,\"SystemComplexComment\":\"wdDw\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":2}]', 'Waiting for Approvement'),
(57, 61, 10, NULL, '2020-11-18 14:19:22', 0, NULL, 2, 1, 1.5, '[{\"NumberEmployees\":1,\"InitialMD\":1.5,\"SystemComplex\":true,\"SystemComplexComment\":\"faefeafafe\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"dcacadc\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"dcadcadcd\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"aceafeaf\",\"DesignResponsability\":false,\"DesignResponsabilityComment\":\"\",\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":false,\"DifferentLanguageComment\":\"efaefeaf\",\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":1.5,\"OutsourcedProcesses\":false,\"SmallLargePersonnel\":false}]', 'Waiting for Approvement'),
(58, 59, 10, NULL, '2020-11-19 10:43:18', 0, NULL, 2, 1, 1.5, '[{\"NumberEmployees\":5,\"InitialMD\":1.5,\"SystemComplex\":null,\"SystemComplexComment\":null,\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":1.5,\"OutsourcedProcesses\":false,\"SmallLargePersonnel\":false}]', 'Waiting for Approvement'),
(59, 59, 10, NULL, '2020-11-19 10:46:01', 0, NULL, 2, 1, 1.5, '[{\"NumberEmployees\":5,\"InitialMD\":1.5,\"SystemComplex\":null,\"SystemComplexComment\":null,\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":1.5,\"OutsourcedProcesses\":false,\"SmallLargePersonnel\":false}]', 'Waiting for Approvement'),
(60, 61, 10, 1, '2020-11-19 14:30:33', 1, '2020-11-20 14:28:26', 2, 1, 1.5, '[{\"NumberEmployees\":1,\"InitialMD\":1.5,\"SystemComplex\":false,\"SystemComplexComment\":\"affefafea\",\"ComplicatedLogistic\":true,\"ComplicatedLogisticComment\":\"efefqef\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"caeaeceac\",\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2,\"DaysSurveillance\":1,\"DaysRR\":1.5,\"OutsourcedProcesses\":false,\"SmallLargePersonnel\":false}]', 'Approved'),
(61, 64, 10, 11, '2020-12-08 12:13:17', 1, '2020-12-22 15:32:05', 2.5, 1, 2, '[{\"NumberEmployees\":1,\"InitialMD\":2.5,\"SystemComplex\":false,\"SystemComplexComment\":\"aae\\u00f1o\\u00f1vevovjq\\u00f1 efip  jijf\\u00f1ah\\u00f1fefqefef\",\"ComplicatedLogistic\":true,\"ComplicatedLogisticComment\":\"vvdvvfbsfb\",\"InterestedParties\":true,\"InterestedPartiesComment\":\"sfvfsvsvfv\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"eafe f\\u00f3a i\\u00f1fa bup haeluf aul wu\\u00f1r ghluabfa fefafa fqfeqef\",\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":false,\"IndirectAspectsComment\":\"dos dadpifphfeipv ifj fjf{\\u00f1a\\u00f1al\\u00f1akdckadcja9 eq\\u00f3f ackpiaj\\u00e1jfj\\u00b4vojeipf ae\\u00b4faefefaefaefeaef\",\"DifferentLanguage\":false,\"DifferentLanguageComment\":\"\",\"Maturity\":true,\"MaturityComment\":\"fvsfvfvsf\",\"AutomationLevel\":false,\"AutomationLevelComment\":\"feq f qefae f ff fwf  efwegwfqfa ffsgwrgsf teh ethet heth tehetgrg gr g e r rg  spi\\u00f1kaouh lo bonito de la vida esto solo son datos de pruebas \",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":2.5,\"DaysSurveillance\":1,\"DaysRR\":2,\"OutsourcedProcesses\":false,\"SmallLargePersonnel\":false}]', 'Approved'),
(62, 66, 11, NULL, '2020-12-22 15:46:27', 0, NULL, 3.5, 1.5, 2, '[{\"NumberEmployees\":27,\"InitialMD\":4,\"SystemComplex\":false,\"SystemComplexComment\":\"no complejo\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"ninguna queja\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"ninguno\",\"DesignResponsability\":false,\"DesignResponsabilityComment\":\"ninguno\",\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":true,\"DifferentLanguageComment\":\"dcadcadcac\",\"Maturity\":true,\"MaturityComment\":\"adadece\",\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":3.5,\"DaysSurveillance\":1.5,\"DaysRR\":2}]', 'Waiting for Approvement'),
(63, 66, 24, 10, '2020-12-22 16:04:10', 1, '2020-12-22 16:06:08', 4, 1.5, 3, '[{\"NumberEmployees\":27,\"InitialMD\":4,\"SystemComplex\":null,\"SystemComplexComment\":null,\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":4,\"DaysSurveillance\":1.5,\"DaysRR\":3}]', 'Approved'),
(64, 68, 10, NULL, '2020-12-23 00:07:04', 0, NULL, 3, 1, 2.5, '[{\"NumberEmployees\":2,\"InitialMD\":3,\"SystemComplex\":true,\"SystemComplexComment\":\"aeaeda\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"dcadcad\",\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":true,\"IndirectAspectsComment\":\"cacacadc\",\"DifferentLanguage\":true,\"DifferentLanguageComment\":\"caecaec\",\"Maturity\":true,\"MaturityComment\":\"advvave\",\"AutomationLevel\":true,\"AutomationLevelComment\":\"ffeefafe\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":3,\"DaysSurveillance\":1,\"DaysRR\":2.5,\"OutsourcedProcesses\":false,\"OutsourcedProcessesComment\":\"\"}]', 'Waiting for Approvement'),
(65, 68, 10, NULL, '2020-12-23 06:55:36', 0, NULL, 3.5, 1.5, 3, '[{\"NumberEmployees\":2,\"InitialMD\":3,\"SystemComplex\":true,\"SystemComplexComment\":\"saefaef\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"aveavea\",\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":false,\"IndirectAspectsComment\":\"\",\"DifferentLanguage\":false,\"DifferentLanguageComment\":\"\",\"Maturity\":false,\"MaturityComment\":\"\",\"AutomationLevel\":false,\"AutomationLevelComment\":\"\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":3.5,\"DaysSurveillance\":1.5,\"DaysRR\":3,\"OutsourcedProcesses\":false,\"OutsourcedProcessesComment\":\"\"}]', 'Waiting for Approvement'),
(66, 66, 10, 24, '2020-12-23 07:13:55', 1, '2020-12-23 07:17:11', 4.5, 1.5, 3.5, '[{\"NumberEmployees\":27,\"InitialMD\":4,\"SystemComplex\":false,\"SystemComplexComment\":\"acdcad\",\"ComplicatedLogistic\":false,\"ComplicatedLogisticComment\":\"\",\"InterestedParties\":true,\"InterestedPartiesComment\":\"ddfaf\",\"ScopeRegulation\":true,\"ScopeRegulationComment\":\"efeafefae\",\"DesignResponsability\":true,\"DesignResponsabilityComment\":\"\",\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":false,\"DifferentLanguageComment\":\"\",\"Maturity\":false,\"MaturityComment\":\"\",\"AutomationLevel\":false,\"AutomationLevelComment\":\"\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":4.5,\"DaysSurveillance\":1.5,\"DaysRR\":3.5}]', 'Approved'),
(67, 68, 10, 24, '2020-12-23 07:40:30', 1, '2020-12-23 07:42:02', 3.5, 1.5, 3, '[{\"NumberEmployees\":2,\"InitialMD\":3,\"SystemComplex\":true,\"SystemComplexComment\":\"fvsvvrvrav\",\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":null,\"InterestedPartiesComment\":null,\"ScopeRegulation\":null,\"ScopeRegulationComment\":null,\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":3.5,\"DaysSurveillance\":1.5,\"DaysRR\":3}]', 'Approved'),
(68, 70, 10, NULL, '2020-12-23 12:13:34', 0, NULL, 3, 1, 1.5, '[{\"NumberEmployees\":28,\"InitialMD\":4,\"SystemComplex\":false,\"SystemComplexComment\":\"dacadc\",\"ComplicatedLogistic\":null,\"ComplicatedLogisticComment\":null,\"InterestedParties\":false,\"InterestedPartiesComment\":\"adcadcadc\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"dcacda\",\"DesignResponsability\":null,\"DesignResponsabilityComment\":null,\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":null,\"DifferentLanguageComment\":null,\"Maturity\":null,\"MaturityComment\":null,\"AutomationLevel\":null,\"AutomationLevelComment\":null,\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":3,\"DaysSurveillance\":1,\"DaysRR\":1.5}]', 'Waiting for Approvement'),
(69, 70, 11, 10, '2020-12-23 12:26:45', 1, '2020-12-23 12:35:22', 3.5, 1.5, 2.5, '[{\"NumberEmployees\":28,\"InitialMD\":4,\"SystemComplex\":false,\"SystemComplexComment\":\"kkjhnb\",\"ComplicatedLogistic\":true,\"ComplicatedLogisticComment\":\"ujnggvv\",\"InterestedParties\":false,\"InterestedPartiesComment\":\"llkjmm\",\"ScopeRegulation\":false,\"ScopeRegulationComment\":\"no hay regulacion especifica\",\"DesignResponsability\":false,\"DesignResponsabilityComment\":\"Requerimientos del cliente\",\"IndirectAspects\":null,\"IndirectAspectsComment\":null,\"DifferentLanguage\":true,\"DifferentLanguageComment\":\"jknbgg\",\"Maturity\":true,\"MaturityComment\":\"kkkjby\",\"AutomationLevel\":false,\"AutomationLevelComment\":\"\",\"FTEHACCP\":null,\"FTEHACCPComment\":null,\"FTEHACCPIncrement\":null,\"FTEHACCPPlus\":null,\"FTEHACCPPlusComment\":null,\"FTEHACCPPlusIncrement\":null,\"AuditPreparation\":null,\"AuditPreparationComment\":null,\"AuditPreparationIncrement\":null,\"AuditReport\":null,\"AuditReportComment\":null,\"AuditReportIncrement\":null,\"UseInterpreter\":null,\"UseInterpreterComment\":null,\"UseInterpreterIncrement\":null,\"OffSiteStorage\":null,\"OffSiteStorageComment\":null,\"OffSiteStorageIncrement\":null,\"CertificationControlled\":null,\"CertificationControlledComment\":null,\"CertificationControlledIncrement\":null,\"DaysInitialStage\":3.5,\"DaysSurveillance\":1.5,\"DaysRR\":2.5}]', 'Approved');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_calendar`
--

CREATE TABLE `event_calendar` (
  `IdEvent` int(100) NOT NULL,
  `IdEmployee` int(11) DEFAULT NULL,
  `IdCompany` int(100) DEFAULT NULL,
  `IdLocalidad` int(11) DEFAULT NULL,
  `EventTitle` varchar(500) DEFAULT NULL,
  `EventStart` datetime NOT NULL,
  `EventEnd` datetime NOT NULL,
  `EventTask` text,
  `EventAddress` varchar(500) DEFAULT NULL,
  `EventColorPrimary` varchar(10) DEFAULT NULL,
  `EventColorSecundary` varchar(10) DEFAULT NULL,
  `EventAvailability` varchar(500) NOT NULL DEFAULT 'Available',
  `EventConfirmation` varchar(100) DEFAULT 'false',
  `EventAllDay` varchar(100) DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `event_calendar`
--

INSERT INTO `event_calendar` (`IdEvent`, `IdEmployee`, `IdCompany`, `IdLocalidad`, `EventTitle`, `EventStart`, `EventEnd`, `EventTask`, `EventAddress`, `EventColorPrimary`, `EventColorSecundary`, `EventAvailability`, `EventConfirmation`, `EventAllDay`) VALUES
(1, 10, 2, 0, 'Cosas por Cambiar', '2020-11-18 00:00:00', '2020-11-30 00:00:00', 'debes ir a la empresa a hacer una auditoria', 'cacacacaeceve', '#ffffffff', '#00000000', 'Available', 'false', 'false'),
(2, 10, 2, 0, 'hander: socorro', '2021-01-01 13:30:15', '2021-01-03 13:30:15', 'cosas por hacer matar un bufalo', 'tonila 412', '#5a8a9d', '#0040ff', 'Available', 'false', 'false'),
(4, 1, 19, 0, 'nueva empresa', '2021-01-08 15:49:39', '2021-01-28 15:49:39', 'afefaefaef', 'mikasa', '#ff0000', '#ff0000', 'Available', 'false', 'false'),
(6, 1, 3, 0, 'Comprarme algo bonito', '2021-01-01 15:46:35', '2021-01-01 15:46:35', 'cafdafafaefe', 'mi casa', '#ff0000', '#ff0000', 'Available', 'false', 'false'),
(49, 10, 4, 0, 'cosas elegantes', '2020-10-14 00:00:00', '2020-10-16 00:00:00', 'debes ir a la empresa a hacer una auditoria', 'cacacacaeceve', '#ffffffff', '#00000000', 'Available', 'false', 'false'),
(53, NULL, NULL, NULL, 'Title', '2020-12-01 00:00:00', '2020-12-01 00:00:00', 'hander esta aqui', 'tonila', '#fffff', '#fffff', 'Available', 'false', 'false'),
(54, NULL, 2, NULL, 'Title', '2020-12-01 00:00:00', '2020-12-01 00:00:00', 'hander esta aqui', 'tonila', '#fffff', '#fffff', 'Available', 'false', 'false'),
(58, NULL, 3, NULL, 'preuba de hora', '2020-12-31 18:00:00', '2020-12-31 18:00:00', 'probando la hora', 'probando la hora de salida', '#ffe51e', '#ffe51e', 'Available', 'false', 'false'),
(59, NULL, 3, NULL, 'preuba de hora', '1969-12-31 18:00:00', '1969-12-31 18:00:00', 'probando la hora', 'probando la hora de salida', '#ffe51e', '#ffe51e', 'Available', 'false', 'false'),
(60, NULL, 3, NULL, 'preuba de hora', '1969-12-31 18:00:00', '1969-12-31 18:00:00', 'probando la hora', 'probando la hora de salida', '#ffe51e', '#ffe51e', 'Available', 'false', 'false'),
(61, NULL, 3, NULL, 'preuba de hora', '1969-12-31 18:00:00', '1969-12-31 18:00:00', 'probando la hora', 'probando la hora de salida', '#3ebdff', '#7745ff', 'Available', 'false', 'false'),
(66, NULL, 3, NULL, 'prueba de horas ', '2020-12-02 15:02:00', '2020-12-02 16:01:00', 'un error de secuencia', 'tonila 417', '#7745ff', '#5a8a9d', 'Available', 'false', 'false'),
(68, 10, NULL, NULL, 'seguios con las pruebas', '2020-12-02 14:00:00', '2020-12-02 19:30:00', 'las pruebas son muy buenas hasta el momento', 'si que buena prueba', '#3ebdff', '#7745ff', 'Available', 'false', 'false'),
(71, NULL, 3, NULL, 'pruba A', '2020-12-03 00:00:00', '2020-12-03 23:59:59', 'dcd', 'cadcdc', '#ad2121', '#FAE3E3', 'Available', 'false', 'false'),
(75, NULL, 3, NULL, 'niño b', '2020-12-03 00:00:00', '2020-12-03 23:59:59', 'caecae', 'aceaecea', '#ffe51e', '#7745ff', 'Available', 'false', 'true'),
(76, NULL, 3, NULL, 'niño D', '2020-12-03 00:00:00', '2020-12-03 14:59:00', 'dcadcacd', 'acdcad', '#ad2121', '#FAE3E3', 'Available', 'false', 'false'),
(79, NULL, 3, NULL, 'que pasara?', '2020-12-03 09:00:00', '2020-12-03 22:59:00', 'dvfafa', 'fdfaf', '#3ebdff', '#ff4500', 'Available', 'false', 'false'),
(80, NULL, 3, NULL, 'hander', '2020-12-03 00:00:00', '2020-12-03 23:59:59', 'iafevccaase', 'eveav', '#7745ff', '#2bff00', 'Available', 'false', 'false'),
(81, 10, NULL, NULL, 'cosas que estan pasando el dia hoy', '2020-12-03 00:00:00', '2020-12-03 23:59:59', 'pruebas de vista', 'locacion local', '#ffe51e', '#24ffda', 'Available', 'false', 'true'),
(82, 10, NULL, NULL, 'ok ok', '2020-12-03 13:00:00', '2020-12-03 14:02:00', 'dadeda', 'aedaedae', '#3ebdff', '#3ebdff', 'Available', 'false', 'false'),
(83, NULL, 3, NULL, 'se me olvido que tenia aqui', '2020-12-10 00:00:00', '2020-12-11 23:59:00', 'cosas raras', 'en china', '#ad2121', '#FAE3E3', 'Available', 'false', 'false'),
(84, 10, NULL, NULL, 'nueva actividad', '2020-12-10 13:00:00', '2020-12-10 19:29:59', 'cambiando rapidamente de la tarea', 'mi casa', '#ad2121', '#FAE3E3', 'Available', 'false', 'false'),
(85, 10, NULL, NULL, 'title', '2020-12-14 09:00:00', '2020-12-16 15:00:00', '3aefaf', 'tonila', '#ffe51e', '#7745ff', 'Available', 'false', 'false');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `master_list`
--

CREATE TABLE `master_list` (
  `IdMasterList` int(11) NOT NULL,
  `ServiceShortName` varchar(20) NOT NULL,
  `IdSector` int(11) NOT NULL,
  `IdEmployee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `master_list`
--

INSERT INTO `master_list` (`IdMasterList`, `ServiceShortName`, `IdSector`, `IdEmployee`) VALUES
(2, '22K', 1047, 12),
(3, '14K', 1070, 12),
(6, '9K', 1006, 12),
(7, '14K', 1073, 12),
(8, '22K', 1048, 12),
(9, '22K', 1049, 12),
(10, '22K', 1050, 12),
(11, '22K', 1051, 12),
(12, '22K', 1052, 12),
(16, '14K', 1073, 12),
(17, '14K', 1073, 12),
(18, '14K', 1068, 12),
(19, '14K', 1068, 12),
(21, '45K', 1093, 12),
(22, '45K', 1084, 12),
(24, '9K', 1001, 12),
(25, '22K', 1054, 12),
(26, '22K', 1053, 12),
(27, '9K', 1002, 13),
(28, '14K', 1068, 12),
(29, '9K', 1023, 12),
(30, '9K', 1037, 12),
(31, '9K', 1023, 32),
(32, '9K', 1022, 32),
(33, '9K', 1024, 32),
(34, '9K', 1037, 32),
(35, '9K', 1022, 31),
(36, '9K', 1023, 31),
(37, '9K', 1024, 31),
(38, '9K', 1037, 31),
(39, '9K', 1022, 30),
(40, '9K', 1023, 30),
(41, '9K', 1024, 30),
(42, '9K', 1037, 30),
(43, '9K', 1023, 29),
(44, '9K', 1037, 29);

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
  `NotificationDate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`IdNotification`, `IdEmployee`, `IdCompany`, `Role_Type`, `Message`, `URL`, `Viewed`, `NotificationDate`) VALUES
(13, NULL, NULL, 'FINANCE_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/26', 0, '2020-11-27 16:30:09'),
(7, NULL, 3, 'COMPANY_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/26', 1, '2020-11-25 03:13:15'),
(6, NULL, NULL, 'FINANCE_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/26', 0, '2020-11-25 03:13:15'),
(5, NULL, NULL, 'ADMIN_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/26', 1, '2020-11-25 03:13:15'),
(12, NULL, NULL, 'COMPANY_ROLE', 'ARI request you a change, ARI says: El reporte interno de auditoría no está completo', '/p/contracts/contract/26', 0, '2020-11-27 16:11:41'),
(10, NULL, NULL, 'FINANCE_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/26', 0, '2020-11-25 03:28:01'),
(11, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/26', 1, '2020-11-25 03:28:01'),
(14, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/26', 1, '2020-11-27 16:30:09'),
(15, NULL, NULL, 'FINANCE_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/27', 0, '2020-11-27 17:23:26'),
(16, NULL, NULL, 'ADMIN_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/27', 1, '2020-11-27 17:23:26'),
(17, NULL, 3, 'COMPANY_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/27', 1, '2020-11-27 17:23:26'),
(18, NULL, NULL, 'FINANCE_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/27', 0, '2020-11-27 17:31:42'),
(19, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/27', 1, '2020-11-27 17:31:42'),
(20, NULL, NULL, 'FINANCE_ROLE', 'New contract approved by for  company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/27', 0, '2020-11-27 17:38:33'),
(21, NULL, 3, 'COMPANY_ROLE', 'ARI has approved your files for contract', '/p/contracts/contract/27', 1, '2020-11-27 17:38:33'),
(22, NULL, NULL, 'ADMIN_ROLE', 'New contract approved by for  company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/27', 1, '2020-11-27 17:38:33'),
(23, NULL, 3, 'COMPANY_ROLE', 'Please upload your management system files', '/p/confirmation_letters/letter/1/26', 1, '2020-12-04 17:32:17'),
(24, NULL, NULL, 'ADMIN_ROLE', 'New contract approved by for  company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/26', 1, '2020-12-04 17:32:21'),
(25, NULL, 3, 'COMPANY_ROLE', 'ARI has approved your files for contract', '/p/contracts/contract/26', 1, '2020-12-04 17:32:21'),
(26, NULL, NULL, 'FINANCE_ROLE', 'New contract approved by for  company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/26', 0, '2020-12-04 17:32:21'),
(27, NULL, NULL, 'SALES_ROLE', 'New Proposal for company Malvados y Asociados S.A de C.V.', '/queries/app-queryApp/61', 0, '2020-12-08 11:12:20'),
(28, NULL, NULL, 'ADMIN_ROLE', 'New Proposal for company Malvados y Asociados S.A de C.V.', '/queries/app-queryApp/61', 1, '2020-12-08 11:12:20'),
(29, NULL, NULL, 'ADMIN_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 1, '2020-12-08 12:03:03'),
(30, NULL, NULL, 'SALES_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 0, '2020-12-08 12:03:03'),
(31, NULL, NULL, 'SALESCDMX_ROLE', 'New applications assigned to you', '/queries/app-queryApp/64', 0, '2020-12-08 12:03:41'),
(32, NULL, NULL, 'SALES_ROLE', 'New applications assigned to you', '/queries/app-queryApp/64', 0, '2020-12-08 12:03:50'),
(33, NULL, 3, 'COMPANY_ROLE', 'Your application was modified for the next reasons: ok ya asido verificado', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:04:14'),
(34, NULL, NULL, 'ADMIN_ROLE', 'The application of Malvados y Asociados S.A de C.V. suffered some changes', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:04:14'),
(35, NULL, NULL, 'SALES_ROLE', 'The application of Malvados y Asociados S.A de C.V. suffered some changes', '/p/queries/app-queryApp/64', 0, '2020-12-08 12:04:14'),
(36, NULL, 3, 'COMPANY_ROLE', 'ARI request you a change in your application for standard: ISO 14001:2015 for this reasons: hay errores en el llenado', '/queries/app-queryApp/64', 1, '2020-12-08 12:05:51'),
(37, NULL, NULL, 'SALES_ROLE', 'The company Malvados y Asociados S.A de C.V. have edited an application', '/p/queries/app-queryApp/64', 0, '2020-12-08 12:08:45'),
(38, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. have edited an application', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:08:45'),
(39, NULL, 3, 'COMPANY_ROLE', 'ARI request you a change in your application for standard: ISO 14001:2015 for this reasons: ya solo hay un error en el llenado de la parte superior', 'p/queries/app-queryApp/64', 1, '2020-12-08 12:09:23'),
(40, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. have edited an application', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:09:35'),
(41, NULL, NULL, 'SALES_ROLE', 'The company Malvados y Asociados S.A de C.V. have edited an application', '/p/queries/app-queryApp/64', 0, '2020-12-08 12:09:35'),
(42, NULL, 3, 'COMPANY_ROLE', 'Your application was modified for the next reasons: tube que hacer lo cambios yo', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:11:03'),
(43, NULL, NULL, 'ADMIN_ROLE', 'The application of Malvados y Asociados S.A de C.V. suffered some changes', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:11:03'),
(44, NULL, NULL, 'SALES_ROLE', 'The application of Malvados y Asociados S.A de C.V. suffered some changes', '/p/queries/app-queryApp/64', 0, '2020-12-08 12:11:03'),
(45, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/64', 0, '2020-12-08 12:13:17'),
(46, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:13:17'),
(47, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:15:09'),
(48, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/64', 0, '2020-12-08 12:15:09'),
(49, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/64', 1, '2020-12-08 12:27:26'),
(50, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/64', 0, '2020-12-08 12:27:26'),
(51, NULL, NULL, 'ADMIN_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 1, '2020-12-11 16:00:39'),
(52, NULL, NULL, 'SALES_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 0, '2020-12-11 16:00:39'),
(53, NULL, NULL, 'SALESCDMX_ROLE', 'New applications assigned to you', '/queries/app-queryApp/65', 1, '2020-12-11 16:01:39'),
(54, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 1, '2020-12-15 18:39:41'),
(55, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 1, '2020-12-15 18:39:41'),
(56, NULL, NULL, 'SALESCDMX_ROLE', 'New applications assigned to you', '/queries/app-queryApp/65', 0, '2020-12-15 19:56:45'),
(57, NULL, NULL, 'SALES_ROLE', 'New applications assigned to you', '/queries/app-queryApp/65', 0, '2020-12-15 20:04:15'),
(58, NULL, 3, '', 'ARI request you a change for this reason: Razones de prueba', '/p/confirmation_letters/letter/1/26', 1, '2020-12-15 20:43:12'),
(59, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 1, '2020-12-15 20:45:11'),
(60, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 1, '2020-12-15 20:45:11'),
(61, NULL, 3, '', 'ARI request you a change for this reason: Razón de prueba', '/p/confirmation_letters/letter/1/26', 1, '2020-12-16 13:52:56'),
(62, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 0, '2020-12-16 13:53:22'),
(63, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 1, '2020-12-16 13:53:22'),
(64, NULL, 3, 'COMPANY_ROLE', 'ARI request you a change in your application for standard: ISO 14001:2015 for this reasons: hay un error', 'p/queries/app-queryApp/65', 1, '2020-12-16 14:21:26'),
(65, NULL, NULL, 'ADMIN_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 1, '2020-12-17 21:00:51'),
(66, NULL, 3, '', 'ARI approved your documents, review the info and approve', '/p/confirmation_letters/letter/1/26', 1, '2020-12-17 21:00:52'),
(67, NULL, NULL, 'PROGRAMMER_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-17 21:00:52'),
(68, NULL, 3, '', 'ARI request you a change for this reason: Regreso de prueba', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:06:22'),
(69, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:06:53'),
(70, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 0, '2020-12-18 00:06:54'),
(71, NULL, NULL, 'PROGRAMMER_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-18 00:09:11'),
(72, NULL, NULL, 'ADMIN_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:09:11'),
(73, NULL, 3, '', 'ARI approved your documents, review the info and approve', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:09:11'),
(74, NULL, 3, '', 'ARI request you a change for this reason: Probando', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:17:45'),
(75, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:18:00'),
(76, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 0, '2020-12-18 00:18:00'),
(77, NULL, NULL, 'ADMIN_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:18:42'),
(78, NULL, NULL, 'PROGRAMMER_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:18:43'),
(79, NULL, 3, '', 'ARI approved your documents, review the info and approve', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:18:43'),
(80, NULL, NULL, 'ADMIN_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:36:16'),
(81, NULL, 3, '', 'ARI approved your documents, review the info and approve', '/p/confirmation_letters/letter/1/26', 1, '2020-12-18 00:36:16'),
(82, NULL, NULL, 'PROGRAMMER_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-18 00:36:16'),
(83, NULL, NULL, 'ADMIN_ROLE', 'Client request a change for this reason: Solicito un cambio de equipo de auditores, no creo que sea necesario más de un solo auditor.', '/p/confirmation_letters/letter/1/26', 1, '2020-12-19 03:16:45'),
(84, NULL, NULL, 'PROGRAMMER_ROLE', 'Client request a change for this reason: Solicito un cambio de equipo de auditores, no creo que sea necesario más de un solo auditor.', '/p/confirmation_letters/letter/1/26', 0, '2020-12-19 03:16:45'),
(85, NULL, 3, '', 'ARI approved your documents, review the info and approve', '/p/confirmation_letters/letter/1/26', 1, '2020-12-19 03:17:05'),
(86, NULL, NULL, 'PROGRAMMER_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-19 03:17:05'),
(87, NULL, NULL, 'ADMIN_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-19 03:17:05'),
(88, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 0, '2020-12-19 03:17:19'),
(89, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 1, '2020-12-19 03:17:19'),
(90, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 0, '2020-12-21 20:04:24'),
(91, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 0, '2020-12-21 20:04:24'),
(92, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 1, '2020-12-21 20:05:25'),
(93, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 0, '2020-12-21 20:05:25'),
(94, NULL, NULL, 'SALES_ROLE', 'Proposal Approved by J. Silva', '/p/proposals/proposals/17', 0, '2020-12-22 15:26:02'),
(95, NULL, NULL, 'ADMIN_ROLE', 'Proposal Approved by J. Silva', '/p/proposals/proposals/17', 0, '2020-12-22 15:26:03'),
(96, NULL, 3, 'COMPANY_ROLE', 'You receive a new Proposal for your application', '/p/proposals/proposals/17', 1, '2020-12-22 15:26:03'),
(97, NULL, 3, '', 'ARI request you a change for this reason: Nueva fecha', '/p/confirmation_letters/letter/1/26', 1, '2020-12-22 15:30:21'),
(98, NULL, NULL, 'SALES_ROLE', 'Day Calculation Approved by J. Silva', '/p/days-calculations/days-calculation/61', 0, '2020-12-22 15:32:05'),
(99, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation Approved by J. Silva', '/p/days-calculations/days-calculation/61', 0, '2020-12-22 15:32:05'),
(100, NULL, NULL, 'ADMIN_ROLE', 'New Application registered by Patitos Company. SA DE CV', '/p/queries/queries-application', 1, '2020-12-22 15:37:38'),
(101, NULL, NULL, 'SALES_ROLE', 'New Application registered by Patitos Company. SA DE CV', '/p/queries/queries-application', 0, '2020-12-22 15:37:38'),
(102, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 15:46:27'),
(103, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 15:46:27'),
(104, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 1, '2020-12-22 15:50:10'),
(105, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 15:50:10'),
(106, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 15:57:24'),
(107, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 15:57:24'),
(108, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 15:57:29'),
(109, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 1, '2020-12-22 15:57:29'),
(110, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 1, '2020-12-22 15:58:15'),
(111, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 15:58:15'),
(112, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 1, '2020-12-22 15:58:42'),
(113, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 15:58:42'),
(114, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-22 16:04:10'),
(115, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 1, '2020-12-22 16:04:10'),
(116, NULL, NULL, 'SALES_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/63', 0, '2020-12-22 16:06:08'),
(117, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/63', 1, '2020-12-22 16:06:08'),
(118, NULL, NULL, 'SALES_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/62', 0, '2020-12-22 16:07:02'),
(119, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/62', 1, '2020-12-22 16:07:02'),
(120, NULL, NULL, 'SALES_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/queries/app-queryApp/66', 0, '2020-12-22 16:12:07'),
(121, NULL, NULL, 'ADMIN_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/queries/app-queryApp/66', 1, '2020-12-22 16:12:08'),
(122, NULL, NULL, 'ADMIN_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/queries/app-queryApp/66', 1, '2020-12-22 16:12:12'),
(123, NULL, NULL, 'SALES_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/queries/app-queryApp/66', 0, '2020-12-22 16:12:12'),
(124, NULL, NULL, 'SALES_ROLE', 'Proposal Approved by H. García', '/p/proposals/proposal/19', 0, '2020-12-22 16:25:59'),
(125, NULL, NULL, 'ADMIN_ROLE', 'Proposal Approved by H. García', '/p/proposals/proposal/19', 1, '2020-12-22 16:25:59'),
(126, NULL, 21, 'COMPANY_ROLE', 'You receive a new Proposal for your application', '/p/proposals/proposal/19', 1, '2020-12-22 16:26:00'),
(127, NULL, NULL, 'ADMIN_ROLE', 'The Company Patitos Company. SA DE CV have accepted the proposal.', '/p/proposals/proposal/19', 1, '2020-12-22 16:48:39'),
(128, NULL, NULL, 'FINANCE_ROLE', 'The Company Patitos Company. SA DE CV have accepted the proposal.', '/p/proposals/proposal/19', 0, '2020-12-22 16:48:40'),
(129, NULL, NULL, 'SALES_ROLE', 'The Company Patitos Company. SA DE CV have accepted the proposal.', '/p/proposals/proposal/19', 0, '2020-12-22 16:48:39'),
(130, NULL, NULL, 'ADMIN_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 1, '2020-12-22 23:54:47'),
(131, NULL, NULL, 'SALES_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 0, '2020-12-22 23:54:47'),
(132, NULL, NULL, 'ADMIN_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 1, '2020-12-23 00:02:19'),
(133, NULL, NULL, 'SALES_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 0, '2020-12-23 00:02:19'),
(134, NULL, NULL, 'SALESCDMX_ROLE', 'New applications assigned to you', '/queries/app-queryApp/68', 0, '2020-12-23 00:04:31'),
(135, NULL, NULL, 'SALES_ROLE', 'New applications assigned to you', '/queries/app-queryApp/68', 0, '2020-12-23 00:04:38'),
(136, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:07:04'),
(137, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:07:04'),
(138, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:07:53'),
(139, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:07:53'),
(140, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:08:48'),
(141, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:08:48'),
(142, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:10:16'),
(143, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:10:16'),
(144, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 00:15:21'),
(145, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:15:21'),
(146, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 00:15:52'),
(147, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:15:52'),
(148, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 00:19:06'),
(149, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:19:06'),
(150, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 00:20:26'),
(151, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:20:27'),
(152, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 00:23:20'),
(153, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 00:23:20'),
(154, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 06:34:12'),
(155, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:34:12'),
(156, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 06:34:48'),
(157, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:34:48'),
(158, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 06:35:26'),
(159, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:35:26'),
(160, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 06:35:27'),
(161, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:35:27'),
(162, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 06:37:13'),
(163, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:37:13'),
(164, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:55:36'),
(165, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:55:36'),
(166, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:56:18'),
(167, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 06:56:18'),
(168, NULL, 21, 'COMPANY_ROLE', 'Your application was modified for the next reasons: fssfrsf', '/p/queries/app-queryApp/66', 0, '2020-12-23 06:57:02'),
(169, NULL, NULL, 'ADMIN_ROLE', 'The application of Patitos Company. SA DE CV suffered some changes', '/p/queries/app-queryApp/66', 0, '2020-12-23 06:57:02'),
(170, NULL, NULL, 'SALES_ROLE', 'The application of Patitos Company. SA DE CV suffered some changes', '/p/queries/app-queryApp/66', 0, '2020-12-23 06:57:02'),
(171, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-23 07:13:58'),
(172, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 1, '2020-12-23 07:13:58'),
(173, NULL, NULL, 'SALES_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/66', 0, '2020-12-23 07:17:12'),
(174, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/66', 1, '2020-12-23 07:17:29'),
(175, NULL, NULL, 'SALES_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-23 07:20:43'),
(176, NULL, NULL, 'ADMIN_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 1, '2020-12-23 07:20:43'),
(177, NULL, NULL, 'SALES_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 0, '2020-12-23 07:31:35'),
(178, NULL, NULL, 'ADMIN_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/66', 1, '2020-12-23 07:31:35'),
(179, NULL, NULL, 'ADMIN_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 1, '2020-12-23 07:39:57'),
(180, NULL, NULL, 'SALES_ROLE', 'New Application registered by Malvados y Asociados S.A de C.V.', '/p/queries/queries-application', 0, '2020-12-23 07:39:57'),
(181, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 07:40:30'),
(182, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 07:40:31'),
(183, NULL, NULL, 'SALES_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/67', 0, '2020-12-23 07:42:03'),
(184, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/67', 1, '2020-12-23 07:42:03'),
(185, NULL, NULL, 'ADMIN_ROLE', 'New Proposal for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 1, '2020-12-23 07:43:48'),
(186, NULL, NULL, 'SALES_ROLE', 'New Proposal for company Malvados y Asociados S.A de C.V.', '/p/queries/app-queryApp/68', 0, '2020-12-23 07:43:48'),
(187, NULL, NULL, 'SALES_ROLE', 'Proposal Approved by H. García', '/p/proposals/proposals/22', 0, '2020-12-23 07:48:05'),
(188, NULL, NULL, 'ADMIN_ROLE', 'Proposal Approved by H. García', '/p/proposals/proposals/22', 1, '2020-12-23 07:48:05'),
(189, NULL, 3, 'COMPANY_ROLE', 'You receive a new Proposal for your application', '/p/proposals/proposal/22', 1, '2020-12-23 07:48:06'),
(190, NULL, NULL, 'ADMIN_ROLE', 'The Company Malvados y Asociados S.A de C.V. have accepted the proposal.', '/p/proposals/proposal/22', 1, '2020-12-23 09:29:27'),
(191, NULL, NULL, 'FINANCE_ROLE', 'The Company Malvados y Asociados S.A de C.V. have accepted the proposal.', '/p/proposals/proposal/22', 0, '2020-12-23 09:29:28'),
(192, NULL, NULL, 'SALES_ROLE', 'The Company Malvados y Asociados S.A de C.V. have accepted the proposal.', '/p/proposals/proposal/22', 0, '2020-12-23 09:29:28'),
(193, NULL, NULL, 'ADMIN_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/28', 1, '2020-12-23 10:13:06'),
(194, NULL, 3, 'COMPANY_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/28', 1, '2020-12-23 10:13:06'),
(195, NULL, NULL, 'FINANCE_ROLE', 'New contract created for company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/28', 0, '2020-12-23 10:13:06'),
(196, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/28', 1, '2020-12-23 10:20:12'),
(197, NULL, NULL, 'FINANCE_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/28', 0, '2020-12-23 10:20:12'),
(198, NULL, 3, 'COMPANY_ROLE', 'ARI request you a change, ARI says: hay un errror en este contrato', '/p/contracts/contract/28', 1, '2020-12-23 10:29:58'),
(199, NULL, NULL, 'FINANCE_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/28', 0, '2020-12-23 10:36:43'),
(200, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/28', 1, '2020-12-23 10:36:43'),
(201, NULL, 3, 'COMPANY_ROLE', 'ARI request you a change, ARI says: hay un error en los archivos', '/p/contracts/contract/28', 1, '2020-12-23 10:37:53'),
(202, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/28', 1, '2020-12-23 10:59:32'),
(203, NULL, NULL, 'FINANCE_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/28', 0, '2020-12-23 10:59:32'),
(204, NULL, 3, 'COMPANY_ROLE', 'ARI request you a change, ARI says: ok! contrato aceptado', '/p/contracts/contract/28', 1, '2020-12-23 11:06:17'),
(205, NULL, NULL, 'FINANCE_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/28', 0, '2020-12-23 11:12:47'),
(206, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. has signed a contract', '/p/contracts/contract/28', 1, '2020-12-23 11:12:47'),
(207, NULL, NULL, 'ADMIN_ROLE', 'New Application registered by Patitos Company. SA DE CV', '/p/queries/queries-application', 1, '2020-12-23 12:07:08'),
(208, NULL, NULL, 'SALES_ROLE', 'New Application registered by Patitos Company. SA DE CV', '/p/queries/queries-application', 0, '2020-12-23 12:07:08'),
(209, NULL, NULL, 'ADMIN_ROLE', 'The application of Patitos Company. SA DE CV suffered some changes', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:08:07'),
(210, NULL, NULL, 'SALES_ROLE', 'The application of Patitos Company. SA DE CV suffered some changes', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:08:07'),
(211, NULL, 21, 'COMPANY_ROLE', 'Your application was modified for the next reasons: cambio de sector', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:08:07'),
(212, NULL, 21, 'COMPANY_ROLE', 'ARI request you a change in your application for standard: ISO 9001:2015 for this reasons: agregar turno admon', 'p/queries/app-queryApp/70', 1, '2020-12-23 12:08:44'),
(213, NULL, NULL, 'SALES_ROLE', 'The company Patitos Company. SA DE CV have edited an application', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:09:16'),
(214, NULL, NULL, 'ADMIN_ROLE', 'The company Patitos Company. SA DE CV have edited an application', '/p/queries/app-queryApp/70', 1, '2020-12-23 12:09:16'),
(215, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:13:34'),
(216, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:13:34'),
(217, NULL, NULL, 'ADMIN_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:26:45'),
(218, NULL, NULL, 'SALES_ROLE', 'New Day Calculation for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:26:45'),
(219, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/70', 1, '2020-12-23 12:34:09'),
(220, NULL, NULL, 'SALES_ROLE', 'Day Calculation edited for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:34:09'),
(221, NULL, NULL, 'SALES_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/69', 0, '2020-12-23 12:35:23'),
(222, NULL, NULL, 'ADMIN_ROLE', 'Day Calculation Approved by H. García', '/p/days-calculations/days-calculation/69', 1, '2020-12-23 12:35:24'),
(223, NULL, NULL, 'SALES_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/70', 0, '2020-12-23 12:40:09'),
(224, NULL, NULL, 'ADMIN_ROLE', 'New Proposal for company Patitos Company. SA DE CV', '/p/queries/app-queryApp/70', 1, '2020-12-23 12:40:09'),
(225, NULL, NULL, 'SALES_ROLE', 'Proposal Approved by H. García', '/p/proposals/proposal/23', 0, '2020-12-23 12:40:32'),
(226, NULL, NULL, 'ADMIN_ROLE', 'Proposal Approved by H. García', '/p/proposals/proposal/23', 1, '2020-12-23 12:40:33'),
(227, NULL, 21, 'COMPANY_ROLE', 'You receive a new Proposal for your application', '/p/proposals/proposal/23', 1, '2020-12-23 12:40:33'),
(228, NULL, NULL, 'ADMIN_ROLE', 'The Company Patitos Company. SA DE CV have accepted the proposal.', '/p/proposals/proposal/23', 1, '2020-12-23 12:44:06'),
(229, NULL, NULL, 'FINANCE_ROLE', 'The Company Patitos Company. SA DE CV have accepted the proposal.', '/p/proposals/proposal/23', 0, '2020-12-23 12:44:06'),
(230, NULL, NULL, 'SALES_ROLE', 'The Company Patitos Company. SA DE CV have accepted the proposal.', '/p/proposals/proposal/23', 0, '2020-12-23 12:44:06'),
(231, NULL, NULL, 'FINANCE_ROLE', 'New contract created for company Patitos Company. SA DE CV', '/p/contracts/contract/29', 0, '2020-12-23 12:51:13'),
(232, NULL, NULL, 'ADMIN_ROLE', 'New contract created for company Patitos Company. SA DE CV', '/p/contracts/contract/29', 0, '2020-12-23 12:51:13'),
(233, NULL, 21, 'COMPANY_ROLE', 'New contract created for company Patitos Company. SA DE CV', '/p/contracts/contract/29', 1, '2020-12-23 12:51:13'),
(234, NULL, NULL, 'ADMIN_ROLE', 'The company Patitos Company. SA DE CV has signed a contract', '/p/contracts/contract/29', 1, '2020-12-23 13:02:13'),
(235, NULL, NULL, 'FINANCE_ROLE', 'The company Patitos Company. SA DE CV has signed a contract', '/p/contracts/contract/29', 0, '2020-12-23 13:02:13'),
(236, NULL, 21, 'COMPANY_ROLE', 'Please upload your management system files', '/p/confirmation_letters/letter/2/29', 0, '2020-12-23 13:03:39'),
(237, NULL, NULL, 'ADMIN_ROLE', 'New contract approved for  company Patitos Company. SA DE CV', '/p/contracts/contract/29', 0, '2020-12-23 13:03:46'),
(238, NULL, 21, 'COMPANY_ROLE', 'ARI has approved your files for contract', '/p/contracts/contract/29', 1, '2020-12-23 13:03:46'),
(239, NULL, NULL, 'FINANCE_ROLE', 'New contract approved for  company Patitos Company. SA DE CV', '/p/contracts/contract/29', 0, '2020-12-23 13:03:46'),
(240, NULL, 3, 'COMPANY_ROLE', 'Please upload your management system files', '/p/confirmation_letters/letter/3/28', 1, '2020-12-23 14:54:36'),
(241, NULL, NULL, 'ADMIN_ROLE', 'New contract approved for  company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/28', 0, '2020-12-23 14:54:38'),
(242, NULL, NULL, 'FINANCE_ROLE', 'New contract approved for  company Malvados y Asociados S.A de C.V.', '/p/contracts/contract/28', 0, '2020-12-23 14:54:38'),
(243, NULL, 3, 'COMPANY_ROLE', 'ARI has approved your files for contract', '/p/contracts/contract/28', 1, '2020-12-23 14:54:38'),
(244, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/3/28', 0, '2020-12-23 16:58:56'),
(245, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/3/28', 1, '2020-12-23 16:58:56'),
(246, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:25:29'),
(247, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. upload their management system files', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:25:29'),
(248, NULL, 3, '', 'ARI approved your documents, review the info and approve', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:26:27'),
(249, NULL, NULL, 'ADMIN_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:26:27'),
(250, NULL, NULL, 'PROGRAMMER_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:26:27'),
(251, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:27:00'),
(252, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:27:00'),
(253, NULL, 3, '', 'ARI needs to change something, please wait for the changes', '/p/confirmation_letters/letter/1/26', 1, '2020-12-31 15:39:37'),
(254, NULL, 3, '', 'ARI approved your documents, review the info and approve', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:50:41'),
(255, NULL, NULL, 'PROGRAMMER_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:50:41'),
(256, NULL, NULL, 'ADMIN_ROLE', 'Client documents approved by Yael Alejandro Santana Michel', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:50:41'),
(257, NULL, NULL, 'PROGRAMMER_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:50:54'),
(258, 30, NULL, 'AUDITOR_ROLE', 'Your are part of a audit for the company Malvados y Asociados S.A de C.V.', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:50:54'),
(259, NULL, NULL, 'ADMIN_ROLE', 'The company Malvados y Asociados S.A de C.V. approved all the letter info', '/p/confirmation_letters/letter/1/26', 0, '2020-12-31 15:50:54'),
(260, 12, NULL, 'AUDITOR_ROLE', 'You are the auditor leader on the audit for company Malvados y Asociados S.A de C.V.', '/p/confirmation_letters/letter/1/26', 1, '2020-12-31 15:50:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_content`
--

CREATE TABLE `page_content` (
  `id` int(11) NOT NULL,
  `codeHTML` longtext NOT NULL,
  `pagina` tinytext NOT NULL,
  `archivo` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `page_content`
--

INSERT INTO `page_content` (`id`, `codeHTML`, `pagina`, `archivo`) VALUES
(17, '<figure class=\"image image-style-align-right image_resized\" style=\"width:50%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/07/31k-1.jpg\"></figure><h4>ISO 31000:2018, Risk management</h4><p>ISO 31000:2018, Risk management – Guidelines, provides principles, framework and a process for managing risk. It can be used by any organization regardless of its size, activity or sector.</p><p>Using ISO 31000 can help organizations increase the likelihood of achieving objectives, improve the identification of opportunities and threats and effectively allocate and use resources for risk treatment.</p><p>However, ISO 31000 cannot be used for certification purposes, but does provide guidance for internal or external audit programmes. Organizations using it can compare their risk management practices with an internationally recognised benchmark, providing sound principles for effective management and corporate governance.</p><p>Source: <a href=\"http://www.iso.org/\">www.ISO.org</a></p>', 'news', NULL),
(18, '<figure class=\"image image_resized image-style-align-right\" style=\"width:50%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/07/iStock-476586896-1024x687.jpg\"></figure><p>The Foundation FSSC 22000 is proud to announce its newly developed Version 5 of the FSSC 22000 certification Scheme. This new edition incorporates all the improvements included in the new ISO 22000 standard which has been published in June 2018</p><p>“The adoption of the new ISO 22000 high level structure in Version 5 provides a great opportunity for organizations to enable the integration of their food safety management system with other management systems such as ISO 9001 for quality management. Along with a focus on operational risks, there is now additional consideration for organizational risks and opportunities which enable more sustainable and consistent business practices for all stakeholders along the food supply chain.”</p><p><a href=\"http://www.fssc22000.com/\">www.fssc22000.com</a></p>', 'news', NULL),
(93, '', 'promotions', 'https://aarrin.com/mobile/app_resources/page_content/Primary.jpg'),
(94, '<h2>American Registration Inc.</h2><p>Seeks to promote companies that intend to achieve certification under the requirements of international standards, offering a 15% discount on our Certification services for those who sign their contract during the month of November 2020.</p><ul><li>In this promotion, it applies to all certification schemes and compliance audits (ISO 9001: 2015, ISO 14001: 2015, ISO 22000: 2018, ISO 45001: 2018, etc.)</li><li>Promotion valid exclusively for new contracts signed during the period from November 01 to 30, 2020, be it initial certification or transfer of certification.</li><li>It is not necessary for the audit to be carried out during the following remaining months of 2020, the only condition is the signing of the contract during the aforementioned period.</li><li>Discount not cumulative.</li><li>Does not apply to other promotions.</li></ul><p>&nbsp;</p><h4><strong>CONTACT US</strong></h4><figure class=\"table\"><table><tbody><tr><td><h4><strong>CIUDAD DE MÉXICO</strong></h4><p><strong>Phone:</strong> <a href=\"tel:+52331 524 5253\">+52 (55) 5524 4994</a><br><strong>Phone:</strong> <a href=\"tel:+52331 524 5253\">+52 (55) 6130 8985</a><br><strong>Email:</strong> <a href=\"mailto:salesmx1@aarrin.com\">salesmx1@aarrin.com</a><br><strong>Email:</strong> <a href=\"mailto:salesmx2@aarrin.com\">salesmx2@aarrin.com</a></p></td><td><h4><strong>GUADALAJARA</strong></h4><p><strong>Phone:</strong> <a href=\"tel:+52331 524 5253\">+52 (33) 1524 5253</a><br><strong>Phone:</strong> <a href=\"tel:+52331 524 5253\">+52 (33) 3044 2083</a><br><strong>Email:</strong> <a href=\"mailto:sales@aarrin.com\">sales@aarrin.com</a></p></td></tr><tr><td><h4><strong>QUERETARO</strong></h4><p><strong>Email:</strong> <a href=\"mailto:contactqro@aarrin.com\">contactqro@aarrin.com</a></p></td><td><h4><strong>WHATSAPP®</strong></h4><p><a href=\"https://api.whatsapp.com/send?phone=+523330442083\">+52 (33) 3044 2083</a></p></td></tr></tbody></table></figure>', 'promotions', 'https://aarrin.com/mobile/app_resources/page_content/DesPagWeb.png'),
(22, '<figure class=\"image image_resized\" style=\"width:71.13%;\"><img src=\"https://aarrin.com/mobile/app_resources/page_content/NUEVO Logo ARI Inc-Institute.png\"></figure><p>If you would like to speak with someone at ARI, please contact our local office at the number below. If you have a question, you can write us an email.</p><h4><strong>OUR POLICIES</strong></h4><p>Complaints, disputes and appeals policy and process <a href=\"https://www.aarrin.com/wp-content/uploads/2019/04/ARI-A-05-Complaints-an-appeals-instructions.pdf\">Download</a></p><h4><strong>CONTACT US</strong></h4><figure class=\"table\"><table><tbody><tr><td><h4><strong>Ciudad de México</strong></h4><p><strong>Phone:</strong><br><a href=\"tel:+52331 524 5253\">+52 (55) 5524 4994</a><br><strong>Phone:</strong><br><a href=\"tel:+52331 524 5253\">+52 (55) 6130 8985</a><br><strong>Email:</strong>&nbsp;<br><a href=\"mailto:salesmx1@aarrin.com\">salesmx1@aarrin.com</a><br><strong>Email:</strong>&nbsp;<br><a href=\"mailto:salesmx2@aarrin.com\">salesmx2@aarrin.com</a></p></td><td><h4><strong>Guadalajara</strong></h4><p><strong>Phone:</strong>&nbsp;<br><a href=\"tel:+52331 524 5253\">+52 (33) 1524 5253</a><br><strong>Phone:</strong>&nbsp;<br><a href=\"tel:+52331 524 5253\">+52 (33) 3044 2083</a><br><strong>Email:</strong>&nbsp;<br><a href=\"mailto:sales@aarrin.com\">sales@aarrin.com</a></p></td></tr><tr><td><h4><strong>Queretaro</strong></h4><p><strong>Email:</strong>&nbsp;<br><a href=\"mailto:contactqro@aarrin.com\">contactqro@aarrin.com</a></p></td><td><h4><strong>Whatsapp®</strong></h4><p><a href=\"https://api.whatsapp.com/send?phone=+523330442083\">+52 (33) 3044 2083</a></p></td></tr></tbody></table></figure><p><br>&nbsp;</p><p><br>&nbsp;</p><p><br>&nbsp;</p><h4>&nbsp;</h4>', 'contact-us', NULL),
(21, '<figure class=\"image image_resized image-style-align-right\" style=\"width:50%;\"><img src=\"https://cdn2.hubspot.net/hub/2857693/hubfs/ANAB-web-logo.png?width=675&amp;name=ANAB-web-logo.png\"></figure><p>&nbsp;</p><h4><strong>Accreditation Certificate Number: MS-5965</strong></h4><p>For more information consult: <a href=\"https://anab.ansi.org/management-systems-accreditation/certification-bodies\">anab.ansi.org</a></p><p>Organizations that recognize the benefits of implementing management systems often seek independent verification of conformance to standards by third-party certification bodies (CBs). Accreditation by a recognized and respected body such as ANAB ensures the impartiality and competence of the CB and fosters confidence and acceptance of the CB´s certifications by end users in the public and private sectors. ANAB assesses and accredits management systems CBs that demonstrate competence to audit and certify organizations and conform with ISO/IEC 17021-1, the international standard for CBs.</p><h4><strong>CB Directory</strong></h4><ul><li>ISO 9001:2015</li><li>ISO 14001:2015</li><li>ISO 22000:2018</li></ul><p>For more information consult: <a href=\"https://anabdirectory.remoteauditor.com/\">Click here</a></p>', 'accreditation', NULL),
(24, '<figure class=\"image image_resized image-style-align-center\" style=\"width:100%;\"><img src=\"https://aarrin.com/assets/img/certificate/ISO%209001_2015.png\"></figure><h3><strong>ISO 9001:2015</strong></h3><p>QUALITY MANAGEMENT SYSTEM</p>', 'certificate', NULL),
(25, '<figure class=\"image image_resized image-style-align-center\" style=\"width:75%;\"><img src=\"https://aarrin.com/assets/img/certificate/ISO%2014001_2015.png\"></figure><h3><strong>ISO 14001:2015</strong></h3><p>ENVIRONMENTAL MANAGEMENT SYSTEM</p>', 'certificate', NULL),
(26, '<figure class=\"image image_resized image-style-align-center\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/certificate/ISO%2022000_2018.png\"></figure><h3><strong>ISO 22000:2018</strong></h3><p>FOOD SAFETY MANAGEMENT SYSTEM</p>', 'certificate', NULL),
(27, '<figure class=\"image image_resized image-style-align-center\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/certificate/ISO%2027001_2013.png\"></figure><h3><strong>ISO 27001:2013</strong></h3><p>INFORMATION SECURITY MANAGEMENT SYSTEM</p>', 'certificate', NULL),
(28, '<figure class=\"image image_resized image-style-align-center\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/certificate/ISO%2037001_2016.png\"></figure><h3><strong>ISO 37001:2016</strong></h3><p>ANTI - BRIBERY MANAGEMENT SYSTEM</p>', 'certificate', NULL),
(29, '<figure class=\"image image_resized image-style-align-center\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/certificate/ISO%2045001_2018.png\"></figure><h3><strong>ISO 45001:2018</strong></h3><p>HEALTH &amp; SAFETY MANAGEMENT SYSTEM</p>', 'certificate', NULL),
(30, '<figure class=\"image image_resized image-style-align-center\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/certificate/ISO%2050001_2018.png\"></figure><h3><strong>ISO 50001:2018</strong></h3><p>ENERGY MANAGEMENT SYSTEM</p>', 'certificate', NULL),
(31, '<figure class=\"image image_resized image-style-align-center\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/certificate/IATF.png\"></figure><h3><strong>IATF 16949:2016</strong></h3><p>INTERNATIONAL AUTOMOTIVE TASK FORCE</p>', 'certificate', NULL),
(16, '<figure class=\"image image_resized image-style-align-right\" style=\"width:50%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/07/FMEA-VDA-Cover.png\"></figure><h4>AIAG &amp; VDA FMEA Handbook</h4><p>Developed with a global team of OEM and Tier 1 supplier subject matter experts, the new AIAG &amp; VDA FMEA Handbook incorporates best practices from both AIAG and VDA methodologies into a harmonized, structured approach.</p><p>In addition to making it easier for suppliers to meet their customers’ needs during the FMEA development process, the handbook features major changes such as a new process for FMEA development – the 7-Step Approach – and a new chapter on Supplemental FMEA for Monitoring and System Response (FMEA-MSR). Additional important changes include the following:</p><p>Totally revised Severity, Occurrence and Detection Tables.</p><p>The Action Priority (AP) methodology and Tables to replace RPN.</p><p>New Form Sheets (spreadsheet users) and Software Report Views (software users).</p><p>Change point highlights from both the AIAG 4th edition FMEA Manual and the VDA Volume 4 FMEA Manual.</p>', 'news', NULL),
(15, '<figure class=\"image image-style-align-right image_resized\" style=\"width:48.66%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/07/iStock-475971188-1024x683.jpg\"></figure><h4>ISO 31010 Management System Tools</h4><p>During the years Management System Tools are develop to help organization to Manage Risks. Some of those tools have different approach and focus. ISO 31010 provides information for each tool and benefits.</p><ul><li>SWIFT<ul><li>Complexity: Some</li><li>Quantitative: Not</li></ul></li><li>Failure Tree Analysis<ul><li>Complexity: Medium</li><li>Quantitative: Yes</li></ul></li><li>HACCP<ul><li>Complexity: Medium</li><li>Quantitative: No</li></ul></li><li>FMEA<ul><li>Complexity: Medium</li><li>Quantitative: Yes</li></ul></li></ul><p>For more information please contac us and ask for the best tool to select according to your scope.</p>', 'news', NULL),
(34, '<h2><strong>Certificate Status</strong></h2><p><strong>Under request, the following clients will be public:</strong></p><figure class=\"table\"><table><thead><tr><th>Client</th><th>Standard</th><th>Status</th></tr></thead><tbody><tr><td rowspan=\"2\"><br>Autotransportes de Carga Cuauhtemoc, S.A. de C.V.</td><td>ISO 22000:2018</td><td rowspan=\"2\"><br>Active</td></tr><tr><td>ISO 9001:2015</td></tr></tbody></table></figure><p>For further information please contact American Registration Inc. SC<br><a href=\"http://localhost:4200/contact\">Click Here</a></p><p>Suspending Certificates</p><p>none...</p><p>Withdrawaul Certificates</p><p>none...</p>', 'certificate-note', NULL),
(35, '<h3><strong>ISO 9001:2015</strong></h3><p>QUALITY MANAGEMENT SYSTEM</p><p>This standard provides orientation and tolos to those Companies and Organisations who want to assure quality in their products and services. The new High Level Structure on ISO 9001, includes the orientation to Client requirements, but also focus on Stakeholders such as the Company itself.</p><p>This new versión try to balance the Quality principles, Client Satisfaction with the expectation from the Top Managements and Business perspective; and how the can be reach the results based on Risk Management approach.</p><p>BENEFITS</p><p>Risk evaluation for Product or Service requirements, increasing the Client Satisfaction and Stakeholders satisfaction.</p><ul><li>Process approach: Continuous improvement</li><li>Business approach: Productivity</li><li>KPI’s focus on results: Cost reduction</li><li>Rework</li><li>Client complaint, non conformity product</li><li>Process environment</li></ul>', 'CertificationServices', NULL),
(36, '<h3><strong>ISO 14001:2015</strong></h3><p>ENVIRONMENTAL MANAGEMENT SYSTEM</p><p>Environmental is always a concern when Organization have preventive pollution and environmental protection compromise.</p><p>ISO 14001:2015 and the ISO 14000 family, such as standard ISO 14006 are focus on Environmental systems to achieve the Environmental protection objectives.</p><p>ISO 14001:2015 helps to the Organizations to improve their Environmental performance, by promoting the efficiency on the use of resources, waste reduction and as consequence, the operation cost reduction and third parties confident.</p><p>BENEFITS</p><ul><li>Waste reduction</li><li>Use of Energy reduction (Gas, fuels, Electricity)</li><li>Legal compliance and penalties prevention.</li></ul>', 'CertificationServices', NULL),
(37, '<h3><strong>ISO 50001:2018</strong></h3><p>ENERGY MANAGEMENT SYSTEM</p><p>The efficient use of the energy helps to Organizations to save money, as well to save resources and contribute to the Climate change, ISO 50001 is compatible with Organizations an all sectors to use the energy in an efficient way through the use and development of the Energy Management System.</p><p>ISO 50001 os based on the Continuous Improvement Management System Model, also use the principles from other ISO standards, such as ISO 9001 and ISO 14001; this make more easy for those organizations to integrate all systems with the High Level Structure.</p><p>BENEFITS</p><ul><li>ISO 50001:2011 Energy Savings</li><li>Energy policy with the commitment on the resources efficiency</li><li>KPI’s focus on energy savings and cost reduction</li><li>Continuous Improvement</li></ul>', 'CertificationServices', NULL),
(38, '<h3><strong>ISO 27001:2013</strong></h3><p>INFORMATION SECURITY MANAGEMENT SYSTEM</p><p>The application of these family estándar helps to the Organizations to manage the information security for all Information resources, such as Financial Information, Intellectual property, employees details or any other third party information under your responsibility.</p><p>The ISMS has a simple systematic approach for the information Management System to protect the information confidentiality.</p><p>The information protection includes the process to control information used by employees, processes, and any other technology.</p><p>This estándar can helps to small to big Companies to manage their information resources to protect the information confidentiality.</p><p>BENEFITS</p><p>Prevention:</p><ul><li>Client information lost</li><li>Losses of financial information</li><li>Organization sensitive information lost</li><li>Hardware and Software management</li></ul>', 'CertificationServices', NULL),
(39, '<h3><strong>ISO 45001:2018</strong></h3><p>HEALTH AND SAFETY MANAGEMENT SYSTEM</p><p>About tan 6,300 person diez per month because of accidents or health because of work activities.</p><p>These accidents and health sickness because of work activities is really important for the employees and more important for the organization, because of the productivity, pensions, absenteeism, rotation, accident payment and other related with accidents.</p><p>To avoid the problem, ISO has develop the new estándar ISO 45001:2018 Health an Safety Management System, based on the recognized OHSAS 18001. These standards has the specific requirements to identify potential safety and health risks and to improve the organization performance, reducing to he acceptable levels the probability of accidents and improving the work environment, requested by the Quality Standards.</p><p>BENEFITS</p><ul><li>Prevention in: Insurances</li><li>Lost human life: Absenteeism and Rotation</li><li>Disability payments: Productivity</li></ul>', 'CertificationServices', NULL),
(40, '<h3><strong>ISO 39001:2016</strong></h3><p>ROAD SAFETY MANAGEMENT SYSTEM</p><p>ISO 39001 is focus on the requirements for Road Safety especially when we are transporting goods or persons. This standards allows organization to measure the traffic risks with the objective to reduce accidents or fatalities caused by Organization transportation equipments.</p><p>These requirements helps to the organization to establish policies, procedures and estrategias to measure the potential risks where can be implemented a contro. Evaluate the residual risk and established corrections and corrective actions that contribute with the KPIs and legal requirements.</p><p>BENEFITS</p><ul><li>Prevention in: Insurances</li><li>Lost human life: Productivity</li><li>Disability payments</li></ul>', 'CertificationServices', NULL),
(41, '<h3><strong>ISO 22000:2018</strong></h3><p>FOOD SAFETY MANAGEMENT SYSTEM</p><p>ISO 22000:20018 Food Safety Management System is focused to guarantee the effective implementation on controls to prevent that the food can harm customer during the Hazard Analysis based on Alimentarius CODEX to identify Hazard: Physical, Chemical, Biological, Radiological.</p><p>The consequences of unsafe food can be serious and ISO´s food safety management standards help organizations identify and control food safety hazards. As many of today’s food products repeatedly cross national boundaries, International Standards are needed to ensure the safety of the global food supply chain.</p><p>BENEFITS</p><p>Prevention in:</p><ul><li>Serious harm to customer health</li><li>Complains or legals persecution</li><li>Recall associated cost</li><li>Rework and scrap reduction</li></ul>', 'CertificationServices', NULL),
(42, '<h3><strong>IATF 16949:2016</strong></h3><p>INTERNATIONAL AUTOMOTIVE TASK FORCE</p><p>This International Automotive Management System (IATF) Standard, is focus on the specific automotive sector requirements.</p><p>The application of the Automotive Standard is fundamental for all Original Equipment Manufacturer (OEM´s), and is extensive for all supply chain (including suppliers).</p><p>The main objective in the development on IATF standard is to provide confident on the automotive manufacturing, focusing on the prevention of failures and reduction on process variation, the control of suppliers and continuous improve through Automotive Supply Chain.</p><p>BENEFITS</p><ul><li>Increase efficiency</li><li>Continuous Improvement, and Client Satisfaction</li><li>Process Variation reduction and Cost reduction</li></ul>', 'CertificationServices', NULL),
(57, '<figure class=\"image image-style-align-left image_resized\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/about-img.jpg\"></figure><figure class=\"table\"><table><tbody><tr><td><h2>About Us</h2><h3><i>The most important asset is the people. That is the reason because ARI has the commitment for:</i></h3><ul><li>SERVICE: because of their function, they must observe a permanent attitude of collaboration, providing support, friendly guidance to users and other staff itself.</li><li>IMPARTIALITY: Being impartial, and being perceived to be impartial, is necessary for a certification body to deliver certification that provides confidence. It is important that all internal and external personnel are aware of the need for impartiality. (ISO 17021-1. 4.2).</li><li>COMPETENCE: keep competent is always a way to offer a better service and employees must comply with their duties, aware of the commitment to quality service an organizational standard.</li><li>RESPONSIBILITY/ HONESTY: With all the people who have interaction and, in all situations, must behave with responsible and honest in the performance of their duties, it should be addressed with respect and tolerance for all people.</li><li>OPPENES: All involved must understand that different situations can occur during the Certification activities. That’s the reason they has to be open to provide service in accordance with the international standards and always trying to support clients and interested parties.</li><li>CONFIDENTIALITY: Information is a powerful tool. That’s the reason ARI keep all Client´s information highly confidential and make arrangements with involved personnel to keep it as confidential as possible.</li><li>LEGALITY: Personnel must know, comply and understand the implication with laws, regulations, guidelines and guidelines governing ARI and they related activities.</li><li>RESPONSIVENESS FOR COMPLAINTS: Any act has consequences, that’s why ARI keep processes to track on all interested parties complaints. And employees has the commitment to response and act for any complaint.</li><li>Risk-Based Approach: Personnel understand the risks related with Audit activities and the consequences and implications of not follow the rules and requirements.</li></ul></td></tr></tbody></table></figure>', 'about', NULL),
(58, '<figure class=\"image image_resized image-style-align-right\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/team-1.jpg\"></figure><figure class=\"table\"><table><tbody><tr><td><h2><strong>Add value product</strong></h2><h3><i>Evaluating commitments. The key factors that make our services added value are as follows:</i></h3><ul><li>Warmth and personal attention from the first contact.</li><li>Staff committed to the organization and highly skilled.</li><li>Training plans and ongoing training of all auditors &amp; staff.</li><li>Strategic prices according to market segment. With adherence to regulatory framework.</li><li>Constant updating and provision of after sales service to our customers.</li><li>Use of technological tools and communications, facilitating the interaction of our clients in administrative processes and operating on services performed.</li><li>With distinction and quality service.</li></ul></td></tr></tbody></table></figure><p>&nbsp;</p>', 'about', NULL),
(59, '<figure class=\"image image_resized image-style-align-left\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/team-3.jpg\"></figure><figure class=\"table\"><table><tbody><tr><td><p>All these factors make our meeting a benchmark of quality service to meet the needs and expectations of our customers and stakeholders.</p><p><i>MISSION: American Registration Inc. is a company dedicated to providing quality certification services, seeking the satisfaction and loyalty of our customers.</i></p><p><i>VISION: American Registration Inc., been the most attractive option for the companies to evaluate their Management Systems or Product Certification.</i></p></td></tr></tbody></table></figure>', 'about', NULL),
(60, '<figure class=\"image image_resized image-style-align-left\" style=\"width:50%;\"><img src=\"https://aarrin.com/assets/img/team-2.jpg\"></figure><figure class=\"table\"><table><tbody><tr><td><h2>Quality &amp; Impartiality Policy</h2><h3>&nbsp;</h3><p>In American Registration Inc., Our COMMITMENT is provide assessment audits with high quality and protecting the impartiality, as follow:</p><ul><li>We recognize that the source of our revenues are from clients, and that this may be a potential risk of impartiality;</li><li>The certification decision is based on objective evidence obtained during the audit process and reviewed by an independent Certification Committee, and will not have any influence from stakeholders, auditor/staff promises, family influences, or other;</li><li>No member of our company will act on their own or financial benefit. Our personnel is aware of this policy and report any activity that could threat impartiality, this includes but not limited to previous work or consultancy from last 2 years;</li><li>Our auditors recommend for certification We also have a Certification Committee who review of audit package and have the final decision to grant, reduce, suspend or withdraw a certificate;</li><li>Any threat of impartiality is communicated and taken into consideration in the final decision to grant the certificate;</li><li>We do not allow any commercial, financial or other pressure to threat impartiality;</li><li>ARI will not certify the management systems of other certification bodies;</li><li>ARI, will not have any subsidiaries offering or developing consultancy or internal audits to current clients, and will not share advertising with any consultancy company;</li><li>ARI, will not subcontract any consulting company or third part company to conduct audits on their behalf;</li><li>ARI will not outsource decisions for granting, refusing, maintaining of certification, expanding or reducing the scope of certification, renewing, suspending or restoring, or withdrawing of certification;</li><li>We understand the risk management process regarding with FSMS audit certification;</li><li>ARI, not offer consultancy services for any certification program;</li><li>Our commitments with the enviroment protection including contamination prevention and law compliance;</li><li>Our commitments with the healt and safety work conditions, risk reduction and law compliance.</li></ul></td></tr></tbody></table></figure>', 'about', NULL),
(61, '<h2><strong>Typical Process Flow for audit and certification process</strong></h2><ol><li>Contact ARI sales representative</li><li>Fillout the Application Form, with basic information to quote<ul><li>Quality</li><li>Environmental</li><li>Food Safety</li></ul></li><li>ARI will provide you with a Proposal for Certificatio Services</li><li>Ones approved the Proposal, will signed the Certification Agreement</li><li>Tipical process flow is as follow:</li></ol><figure class=\"image image_resized image-style-align-center\" style=\"width:75%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/03/steps-copia-e1564451920429-694x1024.jpg\"></figure>', 'stepFC', NULL),
(62, '<h2><strong>Suspending Certification flow proces</strong></h2><figure class=\"image image-style-align-center image_resized\" style=\"width:50%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/04/2-copia-791x1024.jpg\"></figure>', 'stepFC', NULL),
(63, '<h3>Reducing Scope flow process</h3><figure class=\"image image-style-align-center image_resized\" style=\"width:50%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/04/3-copia-791x1024.jpg\"></figure>', 'stepFC', NULL),
(64, '<h3>Short Notice flow process</h3><figure class=\"image image-style-align-center image_resized\" style=\"width:50%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/04/4-copia-791x1024.jpg\"></figure>', 'stepFC', NULL),
(65, '<h3>Information Upon Request flow process</h3><figure class=\"image image-style-align-center image_resized\" style=\"width:50%;\"><img src=\"https://www.aarrin.com/wp-content/uploads/2019/04/5-copia-791x1024.jpg\"></figure>', 'stepFC', NULL),
(68, '<h4><strong>FREQUENTLY QUESTIONS</strong></h4><p>Frequently Asked Questions<br><a href=\"https://aarrin.com/wp-content/uploads/2019/03/Frequently-Asked-Questions.pdf\">Download</a></p>', 'stepFCBooks', NULL),
(69, '<h4><strong>USE OF MARK</strong></h4><p>References to certifications marks<br><a href=\"https://aarrin.com/wp-content/uploads/2019/03/References-to-certifications-marks.pdf\">Download</a></p>', 'stepFCBooks', NULL),
(70, '<p>¡Improving your<br>management</p>', 'why-us-titleBlack', NULL),
(71, '<p>We do really believe a Management System, is more than just a paper. The Management System is a Commitment. But also is a tool to reach results.</p>', 'why-us-Opcion2', NULL),
(72, '<p>In our experience we have seen many management systems with focus only in obtain a piece of paper “The Certificate”.</p>', 'why-us-Opcion1', NULL),
(73, '<p>Around the world</p>', 'why-us-SubTitleTree', NULL),
(74, '<p><i>We have the conviction of promoting management systems to allows or­ganizations to improving your man­agement systems with the high­est quality standards.</i></p>', 'why-us-Paragraph', NULL),
(75, '<p>ISO Survey</p><p>Every year we perform a survey of certifications to our management system standards. The survey shows the number of valid certificates to ISO management standards (such as ISO 9001 and ISO 14001) reported for each country, each year.</p><p>ISO does not perform certification. Organizations looking to get certified to an ISO standard must contact an independent certification body. The ISO Survey counts the number of certificates issued by certification bodies that have been accredited by members of the <a href=\"https://www.iaf.nu/\">International Accreditation Forum (IAF)</a>.</p><p>The full Survey data is available in Excel format <a href=\"http://localhost:4200/\">here</a>.</p>', 'why-us-ParagraphTree', NULL),
(76, '<p>Systems!</p>', 'why-us-titleBlue', NULL),
(77, '<h4><strong>Results:</strong></h4><p>Results in organization objectives through the evaluation focus on the best practices such as: Balance Score Card, Risk Management, Strategic Objectives, Evaluation of Suppliers and Audits of first and second part, among others.</p>', 'why-us-Opcion3', NULL),
(78, '<h3>Why choose us?</h3>', 'why-us-SubTitle', NULL),
(79, '<p>Our service is a guarantee of conducting audits according to the client’s requirements, standard compliance and considering the applicable legal requirements. This means that we use auditor experience according to the sector of the organization and not just a generic audit. This allows the auditor use the Process Approach needed by the Organization Audit to reach better results, and not just an audit.</p>', 'why-us-ParagraphTwo', NULL),
(80, '<h3>PROCESS APPROACH</h3>', 'why-us-SubTitleTwo', NULL),
(86, '<h3><strong>Remote Audits during the COVID-19 Pandemic</strong></h3><p>&nbsp;</p><figure class=\"image image_resized image-style-align-right\" style=\"width:57.97%;\"><img src=\"https://aarrin.com/mobile/app_resources/page_content/iStock-499147978.jpg\"></figure><p>As a result of the health contingency due to COVID-19, uncertainty has arisen in certified companies or companies that are in the certification process as a result of the closure of activities required by the health authorities for several months, for this reason some organizations were affected in their processes and activities and have suffered a slight change or delay. This has led to a general concern and question in these companies ... What will happen to my certification audit?</p><p>In order to dispel these doubts, we present below alternatives of how the audit activities can be carried out during this situation.</p><p>Currently there are official documents from our accreditation body, as well as from the International Accreditation Forum (IAF), which give us clearer guidance on what alternative techniques can be used to provide an audit service that meets the established requirements.</p><p>IAF <a href=\"https://www.iaf.nu/upFiles/IAFID32011_Management_of_Extraordinary_Events_or_Circumstances.pdf\">ID3</a> (Informative Document for the Management of Events or Extraordinary Circumstances that Affect Certification Bodies ...), this document has the purpose of exhausting any possibility that the on-site audit can be performed to guarantee health and safety both of the audit team of the Certification Body, as well as the personnel of the Certified Organizations, in addition to having the objective of providing the best possible service and making sure not to affect the certification due to non-compliance \"as well as to maintain a solid accredited certification and guarantee that certified organizations receive the best possible service, for this they must have the following:</p><ul><li>Assess the risks involved in remote audits</li><li>Establish a Policy for conducting remote audits</li><li>Document a process that describes the steps to take in case of a certified organization is affected by an extraordinary event.</li></ul><p>For the above, the certification body must collect information in order to carry out an evaluation and determine the feasibility of performing the remote audit:</p><ul><li>When will the organization be able to function normally?</li><li>When will the organization be able to ship products or perform the defined service within the current scope of certification?</li><li>Will the organization need to use alternative manufacturing and / or distribution sites? If so, are they currently covered by the current certification or will they need to be evaluated?</li><li>Does the existing inventory still meet customer specifications, or will the certified organization contact its customers regarding potential concessions?</li><li>If the certified organization is certified to a management system standard that requires a disaster recovery plan or an emergency response plan, has the certified organization implemented the plan and was it effective?</li><li>Will some of the processes and / or services performed or products sent be subcontracted to other organizations? If so, how will the certified organization control the activities of the other organizations?</li><li>To what extent has the operation of the management system been affected?</li><li>Has the certified organization carried out an impact assessment?</li><li>Identification of alternative sampling sites, as appropriate.</li></ul><p>According to the IAF declaration on COVID-19 referring to remote audits and the Mandatory Document (IAF <a href=\"https://www.iaf.nu/upFiles/IAF%20MD4%20Issue%202%2003072018.pdf\">MD4</a>) for the Use of Information and Communication Technologies for Audit and Evaluation Purposes, in which the criteria that must be covered to be able to carry them out, in theory it is possible to carry out 100% remote audits, as long as all the requirements of the standard to be audited can be evaluated, however, there are some regulations that limit this use since the audit objectives may not be achieved, needing to perform part of the audit on site to evaluate the implementation and verification of specific operational controls that due to their level of risk must be evaluated on site (e.g., ISO 22000, HACCP, etc.); the certification body must evaluate each particular case with each of its clients and document the assessed risks.</p><p>In the case of Occupational Health and Safety Management Systems, it is only allowed to carry out the 100% remote evaluation during the period from May 07 to November 07, 2020 (see Answer 24 in the IAF link regarding <a href=\"https://iaffaq.com/faqs/\">FAQs</a>), this means that process control and OH&amp;S risk control can be audited using remote auditing techniques until the end of the COVID-19 emergency.</p><p>If the ICT audit approach is considered to be a viable option, the means to be used will be tested with the certified organization prior to the remote audit to confirm that they are appropriate, adequate and effective; feasibility also depends on the quality of the online connection. Weak bandwidth or limited hardware capacity can slow the process to the point of inefficiency.</p><p>In all cases that the ICTs used do not work properly or prevent a sound audit, it will be suspended, and the appropriate follow-up actions will be determined.</p>', 'news', NULL),
(96, '<h4><strong>Dear Customer</strong></h4><p>Because American Registration Inc. is responsible for collecting and processing personal data that it has obtained or that it will obtain, we have implemented mechanisms to guarantee the security of your personal data; for this reason, we do the following:</p><p>Notice of Privacy Based on articles 15, 16 and other applicable articles of the Federal Law on Protection of Personal Data Held by Private Parties and its regulations, we inform you that American Registration Inc. (hereinafter referred to as ARI), with address at Av. Guadalupe 6111, Zapopan, Jalisco, phone (33) 1524 5253, and the website www.aarrin.com is responsible for collecting, using and therefore protecting Personal Data, in compliance with the principles of legality, quality, consent, information, purpose, loyalty, proportionality and responsibility. Taking into consideration this Personal Data to ARI, directly, indirectly, personally or through its subsidiaries, affiliates, affiliates, controllers and / or commercial allies. The Personal Data that is collected through the competency examination process can be obtained by: corporate offices; Associations; email and / or telephone, and may include:</p><ul><li>Name</li><li>Corporate or Personal Phone</li><li>Corporate or Personal Email</li><li>Results and everything related to Competency Assessment The purposes for which they could be used are:<ul><li>Competency Assessment</li><li>Subsequent communications and sending of promotional material</li><li>International evaluations of the certification processes of American Registration Inc., Im-Prove (by ANAB or other regulatory body)</li><li>Direct contact by ANAB, if necessary for monitoring or status of the certificate.</li></ul></li></ul><p>The confidentiality of Personal Data, intellectual property is guaranteed and they are protected by administrative, technical and / or physical security measures, to avoid damage, loss, alteration, destruction, use, access or improper disclosure.</p><p>Personal Data may be transferred to subsidiaries, affiliates, affiliates, controllers and / or business allies, ARI personnel, within national territory, for the same purposes mentioned. In which case the consent of the Client will be requested in writing. Unless there is a legal process, in which consent is not requested. Likewise, it may be transmitted to the people mentioned below: legal, accounting and / or tax advisers, tax authorities and, any other that is necessary to fulfill the purposes for which you contacted us.</p><p>Important: Any modification to this Privacy Notice will be made known to you on this same website www.aarrin.com without it being necessary to communicate said modification to you individually.</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p><strong>Very truly yours</strong></p><h4>American Registration Inc.</h4>', 'privacy-policies', 'PERSONAL DATA PRIVACY POLICY');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `IdEmployee` int(11) NOT NULL,
  `IdLocalidad` int(11) DEFAULT NULL,
  `EmployeeName` varchar(75) NOT NULL,
  `EmployeeLastName` varchar(75) NOT NULL,
  `EmployeeDegree` varchar(200) DEFAULT NULL,
  `EmployeeBirth` date DEFAULT NULL,
  `EmployeeContractYear` year(4) NOT NULL,
  `EmployeeCharge` varchar(150) NOT NULL,
  `EmployeeAddress` varchar(500) DEFAULT NULL,
  `EmployeePhone` varchar(25) DEFAULT NULL,
  `EmployeeEmail` varchar(200) NOT NULL,
  `EmployeeInsurance` varchar(30) DEFAULT NULL,
  `EmployeeRFC` varchar(25) NOT NULL,
  `EmployeePassword` varbinary(20) NOT NULL,
  `EmployeePhoto` varchar(250) DEFAULT NULL,
  `EmployeeStatus` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`IdEmployee`, `IdLocalidad`, `EmployeeName`, `EmployeeLastName`, `EmployeeDegree`, `EmployeeBirth`, `EmployeeContractYear`, `EmployeeCharge`, `EmployeeAddress`, `EmployeePhone`, `EmployeeEmail`, `EmployeeInsurance`, `EmployeeRFC`, `EmployeePassword`, `EmployeePhoto`, `EmployeeStatus`) VALUES
(1, 0, 'Yael Alejandro', 'Santana Michel', 'Ing. Infórmatico', '1995-11-23', 2020, 'Desarrollador', 'Pánfilo Natera #20-H', '3421006559', 'ya_el1995@hotmail.com', 'SAMY951', 'SAMY951123KU8', 0x4d9afa4ab36f4fe0da2273d29561f9e3, 'https://aarrin.com/mobile/app_resources/personal/profile_1.Image-pqwe82354daloihd.png', 'Active'),
(6, 0, 'Alberto', 'Tello', '', '0000-00-00', 2000, 'Puesto', '', '', 'el_tello23@msn.com', '', 'ABCD000000pl9', 0x4a2439cb5a800f52ad60e5ac6daa7a18, NULL, 'Active'),
(9, 0, 'Adrian', 'Casillas', '', '0000-00-00', 2000, 'Representante LATAM', '', '', 'acasillas.bernal@gmail.com', '', 'ABCD000000LP0', 0x7d0a08de8767e941188fa3a37b4fdb13, NULL, 'Active'),
(10, 0, 'Hander', 'García Torres', 'Ing Infomatico', '1995-09-07', 2020, 'Programador', 'Tonila', '3411454677', 'handergarciatores@gmail.com', '313', 'mikjijijijijijijijiji', 0x7accd077b9a6cb80dde4fa04973a108a, 'https://aarrin.com/mobile/app_resources/personal/profile_10.Image-pqwe82354daloihd.png', 'Active'),
(11, 0, 'Jeanette', 'Silva', 'Mercadotecnia', '1994-03-11', 2010, 'Sales', 'jhjggg', '3365226685', 'sales@aarrin.com', 'ddddjdjdjdjd', 'CORD020202PL9', 0x737e9e71c85476b02df84cbb58d9586c, 'https://aarrin.com/mobile/app_resources/personal/profile_11.Image-pqwe82354daloihd.png', 'Active'),
(12, 0, 'Persona', 'De Prueba Castro', 'Lic. Contador', '1990-08-14', 2020, 'Sales', 'Dirección ficticia 12', '5555555555', 'test@test.com', 'PDP900814IMSS', 'PDP900814LO8', 0x066cff26d5e35df5ee74a9f26ff64f93, 'https://aarrin.com/mobile/app_resources/personal/profile_12.Image-pqwe82354daloihd.png', 'Active'),
(19, NULL, 'Persona', 'Profesional Real', '', '0000-00-00', 2020, 'Ventas CDMX', '', '', 'test2@test2.com', '', 'BRCO201003KU8', 0xcd71f4bd71a98ce1c4850e7f105cf928, NULL, 'Inactive'),
(24, 0, 'Hander', 'García Torres', 'Ing Infomatico', '1995-09-07', 2020, 'Programador', 'Tonila', '3411454677', 'der123@live.com.mx', '313', 'mikjijijijijijiji', 0x7accd077b9a6cb80dde4fa04973a108a, 'https://aarrin.com/mobile/app_resources/personal/profile_24.Image-pqwe82354daloihd.png', 'Active'),
(26, NULL, 'Selene', 'Venancio', '', '0000-00-00', 2020, 'auditor', '', '', 'mary_sele06@hotmail.com', '', 'ABCD123456FR1', 0x6a592a024926352f8c09f2d2bb5a7dc2, NULL, 'Inactive'),
(28, NULL, 'Aldair', 'Romo Torres', '', '0000-00-00', 2020, 'Programador', '', '', 'levelandluck@gmail.com', '', 'ROTA290896LV7', 0x62bdd42e05b19de2047a98f218e8ec67, NULL, 'Active'),
(29, NULL, 'Persona', 'Probando Registro', '', '0000-00-00', 2020, 'Sujeto de prueba', '', '', 'prueba@prueba.com', '', 'PRPP201214KU9', 0x5d0d0953df8e269c471bd19e536abaa4, NULL, 'Active'),
(30, NULL, 'Auditor ', 'Pérez López', '', '0000-00-00', 2020, 'Auditor', '', '', 'apl@apl.com', '', 'APL900120AP7', 0xe7105a4282e6c799a14d0713b3e5397e, NULL, 'Active'),
(31, NULL, 'Auditor 2', 'Larios Lucas', '', '0000-00-00', 2020, 'Auditor', '', '', 'a2ll@a2ll.com', '', 'LALA900220LL1', 0xe829ea16b8ff7dcc98fab7ac7e207755, NULL, 'Active'),
(32, NULL, 'Auditor 3', 'García Torres', '', '0000-00-00', 2020, 'Auditor', '', '', 'a3gt@a3gt.com', '', 'GATA900320GA1', 0xbad2003e95c51cd72b2f8ba4cbcba484, NULL, 'Active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proposals`
--

CREATE TABLE `proposals` (
  `IdProposal` bigint(20) NOT NULL,
  `IdDayCalculation` int(11) NOT NULL,
  `ProposalDate` datetime NOT NULL,
  `ProposalExpirationDate` datetime NOT NULL,
  `IdProposalCreator` int(11) NOT NULL,
  `IdProposalReviewer` int(11) DEFAULT NULL,
  `InitialYear` int(11) DEFAULT NULL,
  `CurrencyType` varchar(5) DEFAULT 'USD',
  `ProposalApproved` tinyint(1) DEFAULT '0',
  `ProposalApprovedDate` datetime DEFAULT NULL,
  `ProposalClientApproved` tinyint(1) DEFAULT '0',
  `ProposalClientApprovedDate` datetime DEFAULT NULL,
  `File` tinytext,
  `TotalInvestment` float NOT NULL,
  `IssueInitialStage` float DEFAULT NULL,
  `IssueSurveillance1` float DEFAULT NULL,
  `IssueSurveillance2` float DEFAULT NULL,
  `IssueRR` float DEFAULT NULL,
  `ProposalDetail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `LegalRepresentative` tinytext,
  `ProposalStatus` varchar(150) DEFAULT 'Waiting for review'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proposals`
--

INSERT INTO `proposals` (`IdProposal`, `IdDayCalculation`, `ProposalDate`, `ProposalExpirationDate`, `IdProposalCreator`, `IdProposalReviewer`, `InitialYear`, `CurrencyType`, `ProposalApproved`, `ProposalApprovedDate`, `ProposalClientApproved`, `ProposalClientApprovedDate`, `File`, `TotalInvestment`, `IssueInitialStage`, `IssueSurveillance1`, `IssueSurveillance2`, `IssueRR`, `ProposalDetail`, `LegalRepresentative`, `ProposalStatus`) VALUES
(14, 48, '2020-10-24 22:39:16', '2021-01-24 22:39:16', 1, 12, 1, 'USD', 1, '2020-11-25 03:13:15', 1, '2020-11-25 03:13:15', 'https://aarrin.com/mobile/app_resources/proposals/ISO%209001:2015%20-%20QUALITY%20MANAGEMENT%20SYSTEM/Malvados%20SA%20de%20CV/Proposal_Acepted.pdf', 9900, 0, NULL, NULL, NULL, '[{\"IdProposal\":\"14\",\"DaysStage1\":1,\"DaysStage2\":1.5,\"DaysSurveillance1\":1,\"DaysSurveillance2\":1,\"DaysRR\":1.5,\"InvestmentStage1\":900,\"InvestmentStage2\":1350,\"InvestmentSurveillance1\":900,\"InvestmentSurveillance2\":900,\"InvestmentRR\":1350},{\"IdProposal\":\"14\",\"DaysStage1\":0.5,\"DaysStage2\":1,\"DaysSurveillance1\":1,\"DaysSurveillance2\":1,\"DaysRR\":1.5,\"InvestmentStage1\":450,\"InvestmentStage2\":900,\"InvestmentSurveillance1\":900,\"InvestmentSurveillance2\":900,\"InvestmentRR\":1350}]', '{\"name\":\"Heinz Doofmenshmirtz\",\"position\":\"Genio Malvado\"}', 'Contract offered'),
(16, 49, '2020-11-03 19:15:05', '2021-02-03 19:15:05', 1, 12, 1, 'USD', 1, '2020-11-27 17:23:31', 1, '2020-11-27 17:23:31', 'https://aarrin.com/mobile/app_resources/proposals/ISO%2014001:2015%20-%20ENVIRONMENTAL%20MANAGEMENT%20SYSTEM/Malvados%20SA%20de%20CV/Proposal_Acepted.pdf', 8250, 150, NULL, NULL, NULL, '[{\"DaysStage1\":1,\"DaysStage2\":2.5,\"DaysSurveillance1\":1.5,\"DaysSurveillance2\":1.5,\"DaysRR\":2.5,\"InvestmentStage1\":900,\"InvestmentStage2\":2250,\"InvestmentSurveillance1\":1350,\"InvestmentSurveillance2\":1350,\"InvestmentRR\":2250}]', '{\"name\":\"Heinz Doofenshmirtz\",\"position\":\"Genio Malvado\"}', 'Contract offered'),
(17, 60, '2020-12-08 11:12:20', '2021-03-08 11:12:20', 10, 11, 1, 'USD', 1, '2020-12-22 16:50:00', 0, NULL, NULL, 5100, 150, NULL, NULL, NULL, '[{\"DaysStage1\":1,\"DaysStage2\":1,\"DaysSurveillance1\":1,\"DaysSurveillance2\":1,\"DaysRR\":1.5,\"InvestmentStage1\":900,\"InvestmentStage2\":900,\"InvestmentSurveillance1\":900,\"InvestmentSurveillance2\":900,\"InvestmentRR\":1350}]', '{\"name\":\"hander\",\"position\":\"garcia\"}', 'Waiting for client approvement'),
(18, 63, '2020-12-22 16:12:07', '2021-03-22 16:12:07', 10, NULL, NULL, 'USD', 0, NULL, 0, NULL, NULL, 6471, 150, 10, 5, 6, '[{\"DaysStage1\":1,\"DaysStage2\":3,\"DaysSurveillance1\":1.5,\"DaysSurveillance2\":1.5,\"DaysRR\":3,\"InvestmentStage1\":900,\"InvestmentStage2\":2700,\"InvestmentSurveillance1\":1350,\"InvestmentSurveillance2\":1350,\"InvestmentRR\":0}]', NULL, 'Waiting for review'),
(19, 63, '2020-12-22 16:12:12', '2021-03-22 16:12:12', 11, 10, NULL, 'MXN', 1, '2020-12-22 16:48:36', 1, '2020-12-22 16:48:36', 'https://aarrin.com/mobile/app_resources/proposals/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/UGF0aXRvcyBDb21wYW55LiBTQSBERSBDVg==/UHJvcG9zYWxfKEFjZXB0ZWQpXzE5.pdf', 192650, 3500, 150, NULL, NULL, '[{\"DaysStage1\":1,\"DaysStage2\":3,\"DaysSurveillance1\":1.5,\"DaysSurveillance2\":1.5,\"DaysRR\":3,\"InvestmentStage1\":18900,\"InvestmentStage2\":56700,\"InvestmentSurveillance1\":28350,\"InvestmentSurveillance2\":28350,\"InvestmentRR\":56700}]', '{\"name\":\"Diana Cort\\u00e9s S.\",\"position\":\"Legal Representative\"}', 'Approved for all interested parties'),
(20, 66, '2020-12-23 07:20:43', '2021-03-23 07:20:43', 10, NULL, NULL, 'USD', 0, NULL, 0, NULL, NULL, 22286, 0, 0, NULL, NULL, '[{\"DaysStage1\":1,\"DaysStage2\":3.5,\"DaysSurveillance1\":1.5,\"DaysSurveillance2\":1.5,\"DaysRR\":3.5,\"InvestmentStage1\":2026,\"InvestmentStage2\":7091,\"InvestmentSurveillance1\":3039,\"InvestmentSurveillance2\":3039,\"InvestmentRR\":7091}]', NULL, 'Waiting for review'),
(21, 66, '2020-12-23 07:31:34', '2021-03-23 07:31:34', 10, NULL, NULL, 'USD', 0, NULL, 0, NULL, NULL, 10050, 150, NULL, NULL, NULL, '[{\"DaysStage1\":1,\"DaysStage2\":3.5,\"DaysSurveillance1\":1.5,\"DaysSurveillance2\":1.5,\"DaysRR\":3.5,\"InvestmentStage1\":900,\"InvestmentStage2\":3150,\"InvestmentSurveillance1\":1350,\"InvestmentSurveillance2\":1350,\"InvestmentRR\":3150}]', NULL, 'Waiting for review'),
(22, 67, '2020-12-23 07:43:47', '2021-03-23 07:43:47', 10, 24, NULL, 'USD', 1, '2020-12-23 10:13:06', 1, '2020-12-23 10:13:06', 'https://aarrin.com/mobile/app_resources/proposals/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/TWFsdmFkb3MgeSBBc29jaWFkb3MgUy5BIGRlIEMuVi4=/UHJvcG9zYWxfKEFjZXB0ZWQpXzIy.pdf', 19247, 0, NULL, NULL, NULL, '[{\"DaysStage1\":1,\"DaysStage2\":2.5,\"DaysSurveillance1\":1.5,\"DaysSurveillance2\":1.5,\"DaysRR\":3,\"InvestmentStage1\":2026,\"InvestmentStage2\":5065,\"InvestmentSurveillance1\":3039,\"InvestmentSurveillance2\":3039,\"InvestmentRR\":6078}]', '{\"name\":\"\",\"position\":\"\"}', 'Contract offered'),
(23, 69, '2020-12-23 12:40:09', '2021-03-23 12:40:09', 11, 10, NULL, 'MXN', 1, '2020-12-23 12:51:13', 1, '2020-12-23 12:51:13', 'https://aarrin.com/mobile/app_resources/proposals/SVNPIDkwMDE6MjAxNSAtIFFVQUxJVFkgTUFOQUdFTUVOVCBTWVNURU0=/UGF0aXRvcyBDb21wYW55LiBTQSBERSBDVg==/UHJvcG9zYWxfKEFjZXB0ZWQpXzIz.pdf', 165500, 3500, NULL, NULL, NULL, '[{\"DaysStage1\":1,\"DaysStage2\":2.5,\"DaysSurveillance1\":1.5,\"DaysSurveillance2\":1.5,\"DaysRR\":2.5,\"InvestmentStage1\":18000,\"InvestmentStage2\":45000,\"InvestmentSurveillance1\":27000,\"InvestmentSurveillance2\":27000,\"InvestmentRR\":45000}]', '{\"name\":\"DIANA\",\"position\":\"REPRESENTANTE\"}', 'Contract offered');

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
(133, 11, 'ADMIN_ROLE'),
(139, 12, 'SALES_ROLE'),
(142, 12, 'PROGRAMMER_ROLE'),
(145, 12, 'AUDITOR_ROLE'),
(146, 12, 'FINANCE_ROLE'),
(147, 12, 'COMMITTEE_ROLE'),
(152, 13, 'SALESCDMX_ROLE'),
(153, 13, 'SALES_ROLE'),
(155, 13, 'ADMIN_ROLE'),
(156, 9, 'COMMITTEE_ROLE'),
(157, 12, 'SALESCDMX_ROLE'),
(158, 12, 'ADMIN_ROLE'),
(159, 10, 'ADMIN_ROLE'),
(169, 11, 'SALES_ROLE'),
(170, 28, 'ADMIN_ROLE'),
(179, 31, 'AUDITOR_ROLE'),
(180, 32, 'AUDITOR_ROLE'),
(182, 30, 'AUDITOR_ROLE'),
(183, 29, 'AUDITOR_ROLE'),
(184, 24, 'SALES_ROLE'),
(185, 24, 'COMMITTEE_ROLE'),
(186, 24, 'PROGRAMMER_ROLE'),
(187, 24, 'ADMIN_ROLE');

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
(1131, '14K', NULL, NULL, 'Local authorities', NULL, 'Special Case', 'Active'),
(1132, '45K', NULL, NULL, 'Other services', NULL, 'Low', 'Active');

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
-- Volcado de datos para la tabla `validation_keys`
--

INSERT INTO `validation_keys` (`IdKey`, `ValidationCode`, `ValidationDate`, `ValidationEmail`) VALUES
(4, 'UNHCXT', '2020-11-17 17:26:37', 'test2@test2.com'),
(7, 'TQALWE', '2020-11-17 17:28:20', 'ventasim-prove@hotmail.com'),
(8, 'L3BMZK', '2020-11-17 17:28:32', 'ventasim-prove@hotmail.com'),
(11, '7GN6K6', '2020-11-17 17:30:32', 'ventasim-prove@hotmail.com'),
(12, '2KVIE1', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(13, 'O4H2MZ', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(14, 'IF206H', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(15, '09G6KP', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(16, 'NMCFM8', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(17, 'RGZF6S', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(18, 'UW8NOW', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(19, 'LM17OZ', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(20, 'D3J8YN', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(21, '8DKLDV', '2020-11-17 20:24:27', 'handergarciatores@gmail.com'),
(22, '4NPPXC', '2020-11-17 20:25:06', 'handergarciatores@gmail.com'),
(23, 'XJAYAJ', '2020-11-17 20:25:49', 'handergarciatores@gmail.com'),
(24, '6C1L9G', '2020-11-19 14:36:43', 'mary_sele06@hotmail.com'),
(25, 'ILN181', '2020-11-19 14:38:32', 'mary_sele06@hotmail.com'),
(26, 'OV7RN6', '2020-11-26 12:23:27', 'mary_sele06@hotmail.com'),
(27, '0CW2SJ', '2020-11-26 12:30:36', 'handergarciatores@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`IdApp`);

--
-- Indices de la tabla `audit_plan`
--
ALTER TABLE `audit_plan`
  ADD PRIMARY KEY (`IdAuditPlan`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`IdCompany`),
  ADD UNIQUE KEY `CompanyRFC` (`CompanyRFC`);

--
-- Indices de la tabla `confirmation_letters`
--
ALTER TABLE `confirmation_letters`
  ADD PRIMARY KEY (`IdLetter`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`IdContact`);

--
-- Indices de la tabla `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`IdContract`);

--
-- Indices de la tabla `days_calculation`
--
ALTER TABLE `days_calculation`
  ADD UNIQUE KEY `IdDayCalculation` (`IdDayCalculation`);

--
-- Indices de la tabla `event_calendar`
--
ALTER TABLE `event_calendar`
  ADD PRIMARY KEY (`IdEvent`);

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
-- Indices de la tabla `page_content`
--
ALTER TABLE `page_content`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`IdEmployee`),
  ADD UNIQUE KEY `unique_email` (`EmployeeEmail`),
  ADD UNIQUE KEY `unique_rfc` (`EmployeeRFC`);

--
-- Indices de la tabla `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`IdProposal`);

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
  MODIFY `IdApp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `audit_plan`
--
ALTER TABLE `audit_plan`
  MODIFY `IdAuditPlan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `IdCompany` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `confirmation_letters`
--
ALTER TABLE `confirmation_letters`
  MODIFY `IdLetter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `IdContact` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `contracts`
--
ALTER TABLE `contracts`
  MODIFY `IdContract` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `days_calculation`
--
ALTER TABLE `days_calculation`
  MODIFY `IdDayCalculation` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `event_calendar`
--
ALTER TABLE `event_calendar`
  MODIFY `IdEvent` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `master_list`
--
ALTER TABLE `master_list`
  MODIFY `IdMasterList` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `IdNotification` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT de la tabla `page_content`
--
ALTER TABLE `page_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `IdEmployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `proposals`
--
ALTER TABLE `proposals`
  MODIFY `IdProposal` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `IdRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `sectors`
--
ALTER TABLE `sectors`
  MODIFY `IdSector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1133;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `IdService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `validation_keys`
--
ALTER TABLE `validation_keys`
  MODIFY `IdKey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
