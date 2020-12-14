<?php
/**
* Controlador de funciones para tabla services
*
* Manejo de acciones sobre la tabla services
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los servicios-> url: .../api/v1-2/services/all, metodo: GET, datos-solicitados: {}

* Solicitar todos los servicios activos (Esta opción no necesitará token)-> url: .../api/v1-2/services/allactive, metodo: GET, datos-solicitados: {}

* Solicitar datos completos de un servicio (ISO)-> url: .../api/v1-2/services/get/:idService, metodo: GET, datos-solicitados: {}

* Crear un nuevo servicio-> url: .../api/v1-2/services/add, metodo: POST, datos-solicitados: {standard: string, shortmane: string, description: string}

* Editar los datos de un servicio-> url: .../api/v1-2/services/edit/:idService, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idService ID del servicio
 */
$idService = -1;

/**
 * @var string $serviceStandard El standard al cual corresponde el servicio
 */
$serviceStandard = '';

/**
 * @var string $serviceShortName Nombre corto del servicio
 */
$serviceShortName = '';

/**
 * @var string $serviceDescription Descripción de servicio
 */
$serviceDescription = '';

/**
 * @var string $serviceStatus Status del servicio
 */
$serviceStatus = '';


switch ($url[5]) {
    /**
     * Solicitar todos los servicios-> 
     * url: .../api/v1-2/services/all, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString Todos los registros
     */
    case 'all':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)){
            $query = "SELECT IdService, ServiceStandard, ServiceShortName, ServiceStatus, ServiceDescription FROM services ORDER BY ServiceStandard";
            $data = DBManager::query($query);

            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            }else{
                header(HTTP_CODE_204);
            }
        }
        else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar todos los servicios activos (Esta opcíon no necesitará token)-> 
     * url: .../api/v1-2/services/allactive, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString Todos los registros
     */
    case 'allactive':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        $query = "SELECT IdService, ServiceStandard, ServiceDescription FROM services WHERE ServiceStatus = 'Active' ORDER BY ServiceStandard";
        $data = DBManager::query($query);

        if ($data) {
            header(HTTP_CODE_200);
            echo json_encode($data);
        }else{
            header(HTTP_CODE_204);
        }
        break;


    /**
     * Solicitar datos completos de un servicio (ISO)-> 
     * url: .../api/v1-2/services/get/:idService, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdService- Id del servicio, el cual deberá ir al final de la URL
     * @return jsonString|null Los datos del servicio con ese ID, 
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
        $idService = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT IdService, ServiceStandard, ServiceShortName, ServiceStatus, ServiceDescription FROM services WHERE IdService = :id";
            $data = DBManager::query($query, array(':id' => $idService));

            if ($data) {
                header(HTTP_CODE_200);
                $companyData = $data[0];
                echo json_encode($companyData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Crear un nuevo servicio-> 
     * url: .../api/v1-2/services/add, 
     * metodo: POST, 
     * datos-solicitados: {standard: string, shortmane: string, description: string}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if(TokenTool::isValid($token)){
            if(isset($_POST['standard']) && isset($_POST['shortname']) && isset($_POST['description'])){
                $serviceStandard    = $_POST['standard'];
                $serviceDescription = $_POST['description'];
                $serviceShortName   = trim($_POST['shortname']);

                $params = array(
                    ':serviceStandard'      => $serviceStandard,
                    ':serviceDescription'   => $serviceDescription,
                    ':serviceShortName'     => $serviceShortName
                );

                $query = "INSERT INTO services(IdService, ServiceStandard, ServiceShortName, ServiceDescription) VALUES (null, :serviceStandard, :serviceShortName, :serviceDescription);";
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdService' => $response));
                }else {
                    header(HTTP_CODE_409);
                }
                exit();
            }
            else{
                header(HTTP_CODE_412);
                exit();
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Editar los datos de un servicio-> 
     * url: .../api/v1-2/services/edit/:idService, 
     * metodo: PUT, 
     * datos-solicitados: {data: jsonString}
     * @param int idservicio Id del servicio, deberá ir al final de url
     * @return jsonString Datos actualizados del servicio ya actualizados
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
        $idService = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $serviceStandard    = $data['ServiceStandard'];
            $serviceShortName   = trim($data['ServiceShortname']);
            $description        = $data['ServiceDescription'];

            $params = array(
                ':idService'          => $idService,
                ':serviceStandard'    => $serviceStandard,
                ':serviceShortName'   => $serviceShortName,
                ':serviceDescription' => $serviceDescription,
            );

            $query = "UPDATE services SET ServiceStandard = :serviceStandard, ServiceShortName = :serviceShortName, ServiceDescription = :serviceDescription";
            
            if(isset($data['ServiceStatus'])){
                $serviceStatus            = $data['ServiceStatus'];
                $query                    .= ", ServiceStatus = :serviceStatus";
                $params[':serviceStatus'] = $serviceStatus;
            }
            $query .= " WHERE IdService = :idService;";
            
            if (DBManager::query($query, $params)){
                $query = "SELECT IdService, ServiceStandard, ServiceShortName, ServiceStatus, ServiceDescription FROM services WHERE IdService = :idService";
                $data = DBManager::query($query, array(':idService' => $idService));
                header(HTTP_CODE_200);
                echo json_encode($data[0]);
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