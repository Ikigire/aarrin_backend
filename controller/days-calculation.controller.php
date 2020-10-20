<?php
/**
* Controlador de funciones para tabla dayscalculation
*
* Manejo de acciones sobre la tabla dayscalculation
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los cálculos de días-> url: .../api/v1-2/dayscalculation/getall/, metodo: GET, datos-solicitados: {}

* Solicitar todos los cálculos de días de una compañía-> url: .../api/v1-2/dayscalculation/company/:idCompany, metodo: GET, datos-solicitados: {}

* Buscar los datos de un cálculo de días por aplicación-> url: .../api/v1-2/dayscalculation/application/:idApplication, metodo: GET, datos-solicitados: {}

* Solicitar los datos de un Cálculo de días-> url: .../api/v1-2/dayscalculation/get/:idDayCalculation, metodo: GET, datos-solicitados: {}

* Crear un nuevo cálculo de días-> url: .../api/v1-2/dayscalculation/add, metodo: POST, datos-solicitados: {IdApp: int, IdCreatorEmployee: int, DaysInitialSage: float, DaysSurveillance: float, DaysRR: float, DaysCalculationDetail: jsonString}

* Editar la información de un cálculo de días-> url: .../api/v1-2/dayscalculation/edit/:idDayCalculation, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idDayCalculation ID del cálculo de días
 */
$idDayCalculation = -1;

/**
 * @var int $idApplication ID de la aplicación
 */
$idApplication = -1;

/**
 * @var int $idCreator ID del empleado creador del cálculo de días
 */
$idCreator = -1;

/**
 * @var int $daysInitialStage Número de días de la etapa inicial
 */
$daysInitialStage = 0;

/**
 * @var int $daysSurveillance Número de días para la etapa de seguimiento
 */
$daysSurveillance = 0;

/**
 * @var int $daysRR Número de días para la etapa de Recertificación
 */
$daysRR = 0;

/**
 * @var array $daysCalculationDetail Detalle del cálculo de días
 */
$daysCalculationDetail = array();

switch ($url[5]) {
    /**
     * Solicitar todos los cálculos de días-> 
     * url: .../api/v1-2/dayscalculation/getall/, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString|null Todos los cálculos de días registrados
     */
    case 'getall':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)){
            $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.NumberEmployees, app.AppDate, app.AppStatus, dc.*, emp1.EmployeeName + ' ' + emp1.EmployeeLastName AS 'EmployeeCreator', emp1.EmployeePhoto AS 'EmployeeCreatorPhoto', emp2.EmployeeName + ' ' + emp2.EmployeeLastName AS 'EmployeeReviewer', emp2.EmployeePhoto AS 'EmployeeReviewerPhoto' FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN personal AS emp1 ON dc.IdCreatorEmployee = emp1.IdEmployee JOIN personal AS emp2 ON dc.IdReviewerEmployee = emp2.IdEmployee ORDER BY app.AppDate DESC;";

            $data = DBManager::query($query);
            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar todos los cálculos de días de una compañía-> 
     * url: .../api/v1-2/dayscalculation/company/:idCompany, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idCompany ID de la compañía 
     * @return jsonString Todos los cálculo de días de esa compañía
     */
    case 'company':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idCompany = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.NumberEmployees, app.AppDate, app.AppStatus, dc.*, emp1.EmployeeName + ' ' + emp1.EmployeeLastName AS 'EmployeeCreator', emp1.EmployeePhoto AS 'EmployeeCreatorPhoto', emp2.EmployeeName + ' ' + emp2.EmployeeLastName AS 'EmployeeReviewer', emp2.EmployeePhoto AS 'EmployeeReviewerPhoto' FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN personal AS emp1 ON dc.IdCreatorEmployee = emp1.IdEmployee JOIN personal AS emp2 ON dc.IdReviewerEmployee = emp2.IdEmployee WHERE app.IdCompany = :idCompany ORDER BY dc.DayCalculationDate DESC;";

            $data = DBManager::query($query, array(':idCompany' =>$idCompany));

            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Buscar los datos de un cálculo de días por aplicación->
     * url: .../api/v1-2/dayscalculation/application/:idApplication, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idApplication ID de la aplicación 
     * @return jsonString Cálculo de días de esa aplicación
     */
    case 'application':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idApplication = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT * FROM days_calculation WHERE IdApp = :idApplication;";

            $data = DBManager::query($query, array(':idApplication' =>$idApplication));

            if ($data) {
                $daysCalculationData = $data[0];
                $daysCalculationData['DaysCalculationDetail'] = json_decode($daysCalculationData['DaysCalculationDetail']);
                header(HTTP_CODE_200);
                echo json_encode($daysCalculationData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar los datos de un Cálculo de días-> 
     * url: .../api/v1-2/dayscalculation/get/:idDayCalculation, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idDayCalculation ID del cálculo de días solicitado, deberá ir al final de la url
     * @return jsonString|null La información del cálculo de días con ese ID, 
     */
    case 'get':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idDayCalculation = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT IdDayCalculation, IdApp, IdCreatorEmployee, IdReviewerEmployee, DayCalculationDate, DayCalculationApproved, DayCalculationApprovedDate, DaysInitialStage, DaysSurveillance, DaysRR, DaysCalculationDetail, DaysCalculationStatus FROM days_calculation WHERE IdDayCalculation = :idDayCalculation;";

            $data = DBManager::query($query, array(':idDayCalculation' => $idDayCalculation));
            if ($data) {
                $daysCalculationData = $data[0];
                $daysCalculationData['DaysCalculationDetail'] = json_decode($daysCalculationData['DaysCalculationDetail']);
                header(HTTP_CODE_200);
                echo json_encode($daysCalculationData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Crear un nuevo cálculo de días-> 
     * url: .../api/v1-2/dayscalculation/add, 
     * metodo: POST, 
     * datos-solicitados: {IdApp: int, IdCreatorEmployee: int, DaysInitialSage: float, DaysSurveillance: float, DaysRR: float, DaysCalculationDetail: jsonString}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (TokenTool::isValid($token)){
            if (isset($_POST['IdApp']) && isset($_POST['IdCreatorEmployee']) && isset($_POST['DaysInitialStage']) && isset($_POST['DaysSurveillance']) && isset($_POST['DaysRR']) && isset($_POST['DaysCalculationDetail'])) {
                $idApplication = $_POST['IdApp'];
                $idCreator = $_POST['IdCreatorEmployee'];
                $daysInitialStage = $_POST['DaysInitialStage'];
                $daysSurveillance = $_POST['DaysSurveillance'];
                $daysRR = $_POST['DaysRR'];
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');
                $daysCalculationDetail = json_decode($_POST['DaysCalculationDetail'], true);

                $params = array(
                    ':idApplication' => $idApplication,
                    ':idCreator' => $idCreator,
                    ':daysInitialStage' => $daysInitialStage,
                    ':daysSurveillance' => $daysSurveillance,
                    ':daysRR' => $daysRR,
                    ':currentDate' => $currentDate,
                    ':daysCalculationDetail' => json_encode($daysCalculationDetail),
                );

                $query = "INSERT INTO days_calculation (IdApp, IdCreatorEmployee, DayCalculationDate, DaysInitialStage, DaysSurveillance, DaysRR, DaysCalculationDetail) VALUES (:idApplication, :idCreator, :currentDate, :daysInitialStage, :daysSurveillance, :daysRR, :daysCalculationDetail);";

                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdDaysCalculation' => $response));
                }else {
                    header(HTTP_CODE_409);
                }
            } else {
                header(HTTP_CODE_412);
            }
            exit();
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Editar la información de un cálculo de días-> 
     * url: .../api/v1-2/dayscalculation/edit/:idDayCalculation, 
     * metodo: PUT, 
     * datos-solicitados: {data: jsonString}
     * @param int idAplication ID del cálculo de días a editar
     * @return jsonString resultado de la operación
     */
    case 'edit':
        if ($method !== 'PUT'){
            header('HTTP/1.1 405 Allow: PUT');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idDayCalculation = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $idApplication = $data['IdApp'];
            $idCreator = $data['IdCreatorEmployee'];
            $daysInitialStage = $data['DaysInitialStage'];
            $daysSurveillance = $data['DaysSurveillance'];
            $daysRR = $data['DaysRR'];
            $daysCalculationDetail = $data['DaysCalculationDetail'];

            $params = array(
                ':idDayCalculation' => $idDayCalculation,
                ':idCreator' => $idCreator,
                ':daysInitialStage' => $daysInitialStage,
                ':daysSurveillance' => $daysSurveillance,
                ':daysRR' => $daysRR,
                ':daysCalculationDetail' => json_encode($daysCalculationDetail),
            );

            $query = "UPDATE days_calculation SET IdCreatorEmployee = :idCreator, DaysInitialStage = :daysInitialStage, DaysSurveillance = :daysSurveillance, DaysRR = :daysRR, DaysCalculationDetail = :daysCalculationDetail";

            if (isset($data['DayCalculationApproved'])){
                if ($data['DayCalculationApproved']){
                    $params[':idReviewerEmployee'] = $data['IdReviewerEmployee'];
                    $date = new DateTime("now");
                    $currentDate = $date->format('Y-m-d H:i:s');
                    $params[':currentDate'] = $currentDate;
                    $query .= ", IdReviewerEmployee = :idReviewerEmployee, DayCalculationApproved = 1, DayCalculationApprovedDate = :currentDate";
                } else {
                    $query .= ", IdReviewerEmployee = null, DayCalculationApproved = 0, DayCalculationApprovedDate = null";
                }
            }

            if (isset($data['DaysCalculationStatus'])) {
                $params[':status'] = $data['DaysCalculationStatus'];
                $query .= ", DaysCalculationStatus = :status";
            }

            $query .= " WHERE IdDayCalculation = :idDayCalculation";
            
            if (DBManager::query($query, $params)){
                header(HTTP_CODE_200);
                echo json_encode(array('result' => 'Updated'));
            }else {
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }        

        break;

    default:
        header(HTTP_CODE_404);
        break;
}