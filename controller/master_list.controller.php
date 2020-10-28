<?php
/**
* Controlador de funciones para tabla master_list
*
* Manejo de acciones sobre la tabla master_list
* Operaciones a utilizar y descripción a utilizar:

* Obtener la vista de la lista maestra para un cierto iso-> url: .../api/v1-2/master_list/iso/:isoSN, metodo: GET, datos-solicitados: {}

* Obtener la vista de la lista maestra para un cierto Sector-> url: .../api/v1-2/master_list/sector/:idSector, metodo: GET, datos-solicitados: {}

* Obtener todas las cualidades de un empleado-> url: .../api/v1-2/master_list/employee/:idEmployee, metodo: get, datos-solicitados: {}

* Crear una nueva cualidad a un empleado-> url: ../api/v1-2/master_list/add, método: POST, datos-solicitados: {data: jsonString}

* Borrar una cualidad de un empleado-> url: ../api/v1-2/master_list/delete/:idMasterList, método: DELETE, datos-solicitados: {}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idMasterList ID de lista maestra
 */
$idMasterList = -1;

/**
 * @var string $isoSN Nombre corto del servicio al que se acredita el empleado
 */
$isoSN = '';

/**
 * @var int $idSector ID del sector en el cual se especializa el empleado
 */
$idSector = -1;

/**
 * @var int $idEmployee ID del empleado
 */
$idEmployee = -1;

switch ($url[5]) {
    /**
     * Obtener la vista de la lista maestra para un cierto iso-> 
     * url: .../api/v1-2/master_list/iso/:isoSN, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param isoSN String Nombre corto del servicio
     * @return jsonString|null Todos los empleados con cualidades para ese servicio
     */
    case 'iso':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }
        $isoSN = (string) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT ml.IdMasterList, ml.ServiceShortName, sec.*, per.IdEmployee, per.EmployeeName, per.EmployeeLastName, per.EmployeeDegree, per.EmployeeRFC, per.EmployeePhoto FROM master_list AS ml JOIN sectors AS sec ON ml.IdSector = sec.IdSector JOIN personal AS per ON ml.IdEmployee = per.IdEmployee WHERE ml.ServiceShortName = :isoSN ORDER BY sec.IAF_MD5, sec.SectorRiskLevel, sec.SectorCategory, sec.SectorSubcategory, sec.SectorCluster";
            $data = DBManager::query($query, array(':isoSN' => $isoSN));

            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else{
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Obtener la vista de la lista maestra para un cierto Sector-> 
     * url: .../api/v1-2/master_list/sector/:idSector, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idSector ID del sector a buscar
     * @return jsonString Datos de los empleados con cualidades para ese sector
     */
    case 'sector':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow: GET');
            exit();
        }

        if (!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }

        $idSector = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT ml.IdMasterList, ml.ServiceShortName, sec.*, per.IdEmployee, per.EmployeeName, per.EmployeeLastName, per.EmployeeDegree, per.EmployeeRFC, per.EmployeePhoto FROM master_list AS ml JOIN sectors AS sec ON ml.IdSector = sec.IdSector JOIN personal AS per ON ml.IdEmployee = per.IdEmployee WHERE ml.IdSector = :idSector ORDER BY sec.IAF_MD5, sec.SectorRiskLevel, sec.SectorCategory, sec.SectorSubcategory, sec.SectorCluster";

            $data = DBManager::query($query, array(':idSector' => $idSector));
            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            }else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Obtener todas las cualidades de un empleado-> 
     * url: .../api/v1-2/master_list/employee/:idEmployee, 
     * metodo: get, 
     * datos-solicitados: {}
     * @param int idEmployee ID del empleado a buscar
     * @return jsonString Datos de las cualidades del empleado con ese ID
     */
    case 'employee':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow: GET');
            exit();
        }

        if (!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }

        $idEmployee = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT ml.IdMasterList, ml.ServiceShortName, sec.*, per.IdEmployee, per.EmployeeName, per.EmployeeLastName, per.EmployeeDegree, per.EmployeeRFC, per.EmployeePhoto FROM master_list AS ml JOIN sectors AS sec ON ml.IdSector = sec.IdSector JOIN personal AS per ON ml.IdEmployee = per.IdEmployee WHERE ml.IdEmployee = :idEmployee ORDER BY sec.IAF_MD5, sec.SectorRiskLevel, sec.SectorCategory, sec.SectorSubcategory, sec.SectorCluster";

            $data = DBManager::query($query, array(':idEmployee' => $idEmployee));
            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            }else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Crear una nueva cualidad a un empleado-> 
     * url: ../api/v1-2/master_list/add, 
     * método: POST, 
     * datos-solicitados: {data: jsonString}
     * @return jsonString objeto json con el resultado de la operación
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            $query = "INSERT INTO master_list VALUES(null, :serviceShortName, :idSector, :idEmployee)";
            $response = DBManager::query($query, array(':serviceShortName' => $data['ServiceShortName'], ':idSector' => $data['IdSector'], ':idEmployee' => $data['IdEmployee']));
            if ($response) {
                header(HTTP_CODE_201);
                echo json_encode(array('idMasterList' => $response));
            }else {
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Borrar una cualidad de un empleado-> 
     * url: ../api/v1-2/master_list/delete/:idMasterList, 
     * método: DELETE, 
     * datos-solicitados: {}
     * @param id int ID de lista maestra a eliminar
     * @return string mensaje de resultado de operación 
     */
    case 'delete':
        if ($method !== 'DELETE') {
            header('HTTP/1.1 405 Allow: DELETE');
            exit();
        }
        
        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }

        $idMasterList = (int) $url[6];

        if (TokenTool::isValid($token)) {
            $query = "DELETE FROM master_list WHERE idMasterList = :id";
            if (DBManager::query($query, array(':id' => $idMasterList))) {
                header(HTTP_CODE_201);
                echo json_encode(array('message' => 'Content deleted'));
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