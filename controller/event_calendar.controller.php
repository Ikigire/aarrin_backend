<?php
/**
* Controlador de funciones para tabla eventcalendar
*
* Manejo de acciones sobre la tabla eventcalendar
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los eventcalendars-> url: .../api/v1-2/eventcalendar/all, metodo: GET, datos-solicitados: {}

* Solicitar todos los eventcalendars activos (Esta opción no necesitará token)-> url: .../api/v1-2/eventcalendar/allactive, metodo: GET, datos-solicitados: {}

* Solicitar datos completos de un eventcalendar (ISO)-> url: .../api/v1-2/eventcalendar/get/:idEvent, metodo: GET, datos-solicitados: {}

* Crear un nuevo eventcalendar-> url: .../api/v1-2/eventcalendar/add, metodo: POST, datos-solicitados: {standard: string, shortmane: string, description: string}

* Editar los datos de un eventcalendar-> url: .../api/v1-2/eventcalendar/edit/:idEvent, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int ID Evento Calendar
 */
$dEvent = -1;
/**
 * @var string color primario del evento
 */
$eventcolorPrimary = '';
/**
 * @var string color secundario del evento
 */
$eventcolorSecundary = '';
/**
 * @var string fecha inicial del evento
 */
$eventstart	= '';
/**
 * @var string fecha final del evento
 */
$eventend = '';
	
switch ($url[5]) {
    /**
     * Solicitar todos los eventcalendar-> 
     * url: .../api/v1-2/eventcalendar/all, 
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
            $query = "SELECT idEvent,eventcolorPrimary,eventcolorSecundary,eventstart,eventend FROM eventcalendar";
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
     * Solicitar todos los eventcalendar activos (Esta opcíon no necesitará token)-> 
     * url: .../api/v1-2/eventcalendar/allactive, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString Todos los registros
     */
    case 'allactive':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        $query = "SELECT idEvent,eventcolorPrimary,eventcolorSecundary,eventstart,eventend FROM eventcalendar";
        $data = DBManager::query($query);

        if ($data) {
            header(HTTP_CODE_200);
            echo json_encode($data);
        }else{
            header(HTTP_CODE_204);
        }
        break;


    /**
     * Solicitar datos completos de un eventcalendar (ISO)-> 
     * url: .../api/v1-2/eventcalendar/get/:idEvent, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idEvent- Id del eventcalendar, el cual deberá ir al final de la URL
     * @return jsonString|null Los datos del eventcalendar con ese ID, 
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
        $idEvent = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT idEvent,eventcolorPrimary,eventcolorSecundary,eventstart,eventend FROM eventcalendar";
            $data = DBManager::query($query, array(':id' => $idEvent));

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
     * Crear un nuevo eventcalendar-> 
     * url: .../api/v1-2/eventcalendar/add, 
     * metodo: POST, 
     * datos-solicitados: {eventstart: string, eventend: string, eventcolorPrimary: string, eventcolorSecundary: string}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if(TokenTool::isValid($token)){
            if(isset($data['eventstart']) && isset($data['eventend']) && isset($data['eventcolorPrimary']) && isset($data['eventcolorSecundary'])){
                $eventstart    = $_POST['eventstart'];
                $eventend    = $_POST['eventend'];
                $eventcolorPrimary   = trim($_POST['eventcolorPrimary']);
                $eventcolorSecundary   = trim($_POST['eventcolorSecundary']);

                $params = array(
                    ':eventstart'           => $eventstart,
                    ':eventend'             => $eventend,
                    ':eventcolorPrimary'    => $eventcolorPrimary,
                    ':eventcolorSecundary'  => $eventcolorSecundary
                );

                $query = "INSERT INTO eventcalendar(idEvent, eventcolorPrimary, eventcolorSecundary, eventstart, eventend) VALUES (null, :eventcolorPrimary, :eventcolorSecundary, :eventstart, :eventend);";
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('idEvent' => $response));
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
     * Editar los datos de un eventcalendar-> 
     * url: .../api/v1-2/eventcalendar/edit/:idEvent, 
     * metodo: PUT, 
     * datos-solicitados: {data: jsonString}
     * @param int idevent Id del eventcalendar, deberá ir al final de url
     * @return jsonString Datos actualizados del eventcalendar ya actualizados
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
        $idEvent = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $eventstart    = $_POST['eventstart'];
            $eventend    = $_POST['eventend'];
            $eventcolorPrimary   = trim($_POST['eventcolorPrimary']);
            $eventcolorSecundary   = trim($_POST['eventcolorSecundary']);

            $params = array(
                ':idEvent'              => $idEvent,
                ':eventstart'           => $eventstart,
                ':eventend'             => $eventend,
                ':eventcolorPrimary'    => $eventcolorPrimary,
                ':eventcolorSecundary'  => $eventcolorSecundary
            );

            $query = "UPDATE eventcalendar SET eventcolorPrimary=:eventcolorPrimary, eventcolorSecundary=:eventcolorSecundary, eventstart=:eventstart, eventend=:eventend";
          
            $query .= " WHERE idEvent = :idEvent;";
            
            if (DBManager::query($query, $params)){
                header(HTTP_CODE_200);
                echo json_encode($data);
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