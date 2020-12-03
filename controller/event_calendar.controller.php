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
 * @var int $idEvent ID Evento Calendar
 */
$idEvent = -1;
/** 
 * @var int $idEmployee ID empleado / Personal
 */
$idEmployee = -1;
/** 
 * @var int $idCompany ID compañia
 */
$idCompany = -1;
/** 
 * @var int $idLocalidad ID localidad
 */
$idLocalidad = -1;
/** 
 * @var int $eventTitle titulo de evento
 */
$eventTitle = '';
/** 
 * @var string $eventStart fecha inicial del evento
 */
$eventStart = '';
/** 
 * @var string $eventEnd fecha final del evento
 */
$eventEnd = '';
/** 
 * @var string $eventTask descripcion de la tarea del evento
 */
$eventTask = '';
/** 
 * @var string $eventAddress dirección
 */
$eventAddress = '';
/** 
 * @var string $eventColorPrimary color del identificacion del evento
 */
$eventColorPrimary = '';
/** 
 * @var string $eventColorSecundary color secundario de evento
 */
$eventColorSecundary = '';
	
switch ($url[5]) {
    /**
     * Solicitar todos los eventcalendar-> 
     * url: .../api/v1-2/eventcalendar/all, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString Todos los registros
     */
    case 'allmondeyyear':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }
        if(isset($_GET['eventStart'])){
            $eventStart = $_GET['eventStart'];
            if (TokenTool::isValid($token)){
                $query = "SELECT `IdEvent`, `IdEmployee`, `IdCompany`, `IdLocalidad`, `EventTitle`, `EventStart`, `EventEnd`, `EventTask`, `EventAddress`, `EventColorPrimary`, `EventColorSecundary`, `EventAvailability`, `EventConfirmation`, `EventAllDay` FROM `event_calendar` WHERE MONTH(EventStart) = MONTH('$eventStart') AND YEAR(EventStart) =  YEAR('$eventStart')";
                 if (isset($_GET['idCompany'])){
                    $idCompany = $_GET['idCompany'];
                    $query .= "AND `IdCompany` = $idCompany";
                } else if (isset($_GET['idEmployee'])) {
                    $IdEmployee = $_GET['idEmployee'];
                    $query .= "AND `IdEmployee` = $IdEmployee";
                }
                $data = DBManager::query($query);
                if ($data) {
                    header(HTTP_CODE_200);
                    for ($i=0; $i < count($data); $i++) { 
                        $data[$i]['EventAllDay'] = (bool) $data[$i]['EventAllDay'];
                        $data[$i]['EventConfirmation'] = (bool) $data[$i]['EventConfirmation'];
                    }
                    echo json_encode($data);
                }else{
                    header(HTTP_CODE_204);
                }
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;
    /**
     * 
     */
    case 'allcalendar':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }
        if(isset($_GET['eventStart'])){
            $eventStart = $_GET['eventStart'];
            if (TokenTool::isValid($token)){

                $query = "SELECT `IdEvent`, `IdEmployee`, `IdCompany`, `IdLocalidad`, `EventTitle`, `EventStart`, `EventEnd`, `EventTask`, `EventAddress`, `EventColorPrimary`, `EventColorSecundary`, `EventAvailability`, `EventConfirmation`, `EventAllDay` FROM `event_calendar` WHERE ((MONTH(EventStart) BETWEEN MONTH('$eventStart')-1 AND MONTH('$eventStart')+1) AND YEAR(EventStart) = YEAR('$eventStart')";
                if (isset($_GET['idCompany'])){
                   $idCompany = $_GET['idCompany'];
                   $query .= " AND `IdCompany` = $idCompany";
                } else if (isset($_GET['idEmployee'])) {
                   $IdEmployee = $_GET['idEmployee'];
                   $query .= " AND `IdEmployee` = $IdEmployee";
                }
                 $query.= ")";
                 
                if (date("n", strtotime($eventStart)) == 12) {
                    $query .= " OR ((MONTH(EventStart) = MONTH('2020-01-01 00:00:00') AND YEAR(EventStart) = YEAR('$eventStart')+1)";
                } else if (date("n", strtotime($eventStart)) == 1) {
                    $query .= " OR ((MONTH(EventStart) = MONTH('2020-12-01 00:00:00') AND YEAR(EventStart) = YEAR('$eventStart')-1)"; 
                    
                }

                if (date("n", strtotime($eventStart)) == 12 || date("n", strtotime($eventStart)) == 1) {
                    if (isset($_GET['idCompany'])){
                        $idCompany = $_GET['idCompany'];
                        $query .= " AND `IdCompany` = $idCompany";
                    } else if (isset($_GET['idEmployee'])) {
                        $IdEmployee = $_GET['idEmployee'];
                        $query .= " AND `IdEmployee` = $IdEmployee";
                    }
                    $query.= ")";
                }


                $data = DBManager::query($query);
                if ($data) {
                    header(HTTP_CODE_200);
                    for ($i=0; $i < count($data); $i++) { 
                        $data[$i]['EventAllDay'] = (bool) $data[$i]['EventAllDay'];
                        $data[$i]['EventConfirmation'] = (bool) $data[$i]['EventConfirmation'];
                    }
                    echo json_encode($data);
                }else{
                    header(HTTP_CODE_204);
                }
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;
    /**
     * 
     */
    case 'notificationcalendar':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }
        if(isset($_GET['eventStart'])){
            
            $eventStart = $_GET['eventStart'];
            if (TokenTool::isValid($token)){
                $query = "SELECT `IdEvent`, personal.IdEmployee, personal.EmployeeName, personal.EmployeeLastName, personal.EmployeeEmail, personal.EmployeeRFC, companies.IdCompany,companies.CompanyName,companies.CompanyRFC, companies.CompanyLogo,companies.CompanyWebsite, event_calendar.IdLocalidad, `EventTitle`, `EventStart`, `EventEnd`, `EventTask`, `EventAddress`, `EventColorPrimary`, `EventColorSecundary`, `EventAvailability`, `EventConfirmation` FROM `event_calendar` INNER JOIN personal on personal.IdEmployee =  event_calendar.IdEmployee INNER JOIN companies on companies.IdCompany = event_calendar.IdCompany WHERE event_calendar.EventStart >= '$eventStart'";
                $data = DBManager::query($query);
                if ($data) {
                    header(HTTP_CODE_200);
                    echo json_encode($data);
                }else{
                    header(HTTP_CODE_204);
                }
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;
    /**
     * 
     */
    case 'notificationcalendaremployee':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }
        if(isset($_GET['eventStart']) && isset($_GET['idEmployee'])){
            
            $eventStart = $_GET['eventStart'];
            $idEmployee = (int) $_GET['idEmployee'];
            if (TokenTool::isValid($token)){
                $query = "SELECT `IdEvent`, personal.IdEmployee, personal.EmployeeName, personal.EmployeeLastName, personal.EmployeeEmail, personal.EmployeeRFC, companies.IdCompany,companies.CompanyName,companies.CompanyRFC, companies.CompanyLogo,companies.CompanyWebsite, event_calendar.IdLocalidad, `EventTitle`, `EventStart`, `EventEnd`, `EventTask`, `EventAddress`, `EventColorPrimary`, `EventColorSecundary` FROM `event_calendar` INNER JOIN personal on personal.IdEmployee =  event_calendar.IdEmployee INNER JOIN companies on companies.IdCompany = event_calendar.IdCompany WHERE companies.CompanyStatus = 'Active' and event_calendar.EventStart >= '$eventstart' AND personal.IdEmployee = $idEmployee";
                $data = DBManager::query($query);
                if ($data) {
                    header(HTTP_CODE_200);
                    echo json_encode($data);
                }else{
                    header(HTTP_CODE_204);
                }
            }
        }
        else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * 
     */
    case 'notificationcalendarcompany':
            if ($method !== 'GET') {
                header('HTTP/1.1 405 Allow; GET');
                exit();
            }
            if(isset($_GET['eventStart']) && isset($_GET['idCompany'])){
                
                $eventStart = $_GET['eventStart'];
                $idCompany = (int) $_GET['idCompany'];
                if (TokenTool::isValid($token)){
                    $query = "SELECT `IdEvent`, personal.IdEmployee, personal.EmployeeName, personal.EmployeeLastName, personal.EmployeeEmail, personal.EmployeeRFC, companies.IdCompany,companies.CompanyName,companies.CompanyRFC, companies.CompanyLogo,companies.CompanyWebsite, event_calendar.IdLocalidad, `EventTitle`, `EventStart`, `EventEnd`, `EventTask`, `EventAddress`, `EventColorPrimary`, `EventColorSecundary`, `EventAvailability`, `EventConfirmation` FROM `event_calendar` INNER JOIN personal on personal.IdEmployee =  event_calendar.IdEmployee INNER JOIN companies on companies.IdCompany = event_calendar.IdCompany WHERE event_calendar.EventStart >= '$eventStart' AND companies.IdCompany = $idCompany";
                    $data = DBManager::query($query);
                    if ($data) {
                        header(HTTP_CODE_200);
                        echo json_encode($data);
                    }else{
                        header(HTTP_CODE_204);
                    }
                }
            }
            else {
                header(HTTP_CODE_401);
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
    case 'getall':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }
        if(isset($_GET['eventStart'])){
            $eventStart = $_GET['eventStart'];
            if (TokenTool::isValid($token)){
                $query = "SELECT `IdEvent`, `IdEmployee`, `IdCompany`, `IdLocalidad`, `EventTitle`, `EventStart`, `EventEnd`, `EventTask`, `EventAddress`, `EventColorPrimary`, `EventColorSecundary`, `EventAvailability`, `EventConfirmation`,`EventAllDay` FROM `event_calendar` WHERE `EventStart` >= '$eventStart'";

                if (isset($_GET['idCompany'])){
                    $idCompany = $_GET['idCompany'];
                    $query .= "AND `IdCompany` = $idCompany";
                } else if (isset($_GET['idEmployee'])) {
                    $IdEmployee = $_GET['idEmployee'];
                    $query .= "AND `IdEmployee` = $IdEmployee";
                }

                $data = DBManager::query($query);
                if ($data) {
                    header(HTTP_CODE_200);
                    for ($i=0; $i < count($data); $i++) { 
                        $data[$i]['EventAllDay'] = (bool) $data[$i]['EventAllDay'];
                        $data[$i]['EventConfirmation'] = (bool) $data[$i]['EventConfirmation'];
                    }
                    echo json_encode($data);
                }else{
                    header(HTTP_CODE_204);
                }
            } else {
                header(HTTP_CODE_401);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;
    /**
     * 
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

        if(TokenTool::isValid($token)){
            if(isset($_POST['eventStart']) && isset($_POST['eventEnd']) && isset($_POST['eventColorPrimary']) && isset($_POST['eventColorSecundary']) && isset($_POST['eventAllDay'])){
                $eventTitle           = $_POST['eventTitle'];
                $dateStart            = $_POST['eventStart'];
                $eventStart           = date("Y-m-d H:i:s", strtotime($dateStart));           
                $dateEnd              = $_POST['eventEnd'];
                $eventEnd             = date("Y-m-d H:i:s", strtotime($dateEnd));           
                $eventTask            = $_POST['eventTask'];
                $eventAddress         = $_POST['eventAddress'];
                $eventColorPrimary    = $_POST['eventColorPrimary'];
                $eventColorSecundary  = $_POST['eventColorSecundary'];
                $eventAvailability    = $_POST['eventAvailability'];
                $eventConfirmation    = $_POST['eventConfirmation'];
                $eventAllDay          = $_POST['eventAllDay'];

                

                $initialPart = "INSERT INTO event_calendar(EventTitle, EventStart, EventEnd, EventTask, EventAddress, EventColorPrimary, EventColorSecundary, EventAvailability, EventConfirmation, EventAllDay";
                $values = "VALUES (:eventTitle, :eventStart, :eventEnd, :eventTask, :eventAddress, :eventColorPrimary, :eventColorSecundary, :eventAvailability, :eventConfirmation, :eventAllDay";

                $params = array(
                    ':eventTitle'          => $eventTitle,
                    ':eventStart'          => $eventStart,
                    ':eventEnd'            => $eventEnd,
                    ':eventTask'           => $eventTask,
                    ':eventAddress'        => $eventAddress,
                    ':eventColorPrimary'   => $eventColorPrimary,
                    ':eventColorSecundary' => $eventColorSecundary,
                    ':eventAvailability'   => $eventAvailability,
                    ':eventConfirmation'   => $eventConfirmation,
                    ':eventAllDay'         => $eventAllDay
                );

                

                if (isset($_POST['idEmployee'])) {
                    $idEmployee = $_POST['idEmployee'];
                    $initialPart .= ", IdEmployee";
                    $values .= ", :idEmployee";
                    $params[':idEmployee'] = $idEmployee;
                }

                if (isset($_POST['idCompany'])) {
                    $idCompany = $_POST['idCompany'];
                    $initialPart .= ", IdCompany";
                    $values .= ", :idCompany";
                    $params[':idCompany'] = $idCompany;
                }

                if (isset($_POST['idLocalidad'])) {
                    $idLocalidad = $_POST['idLocalidad'];
                    $initialPart .= ", IdLocalidad";
                    $values .= ", :idLocalidad";
                    $params[':idLocalidad'] = $idLocalidad;
                }

                $query = $initialPart. ") ". $values. ")";
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdEvent' => $response));
                }else {
                    header(HTTP_CODE_409);
                }
                exit();
            } else{
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

        if (!isset($data)){
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $eventTitle           = $data['EventTitle'];
            $dateStart            = $data['EventStart'];
            $eventStart           = date("Y-m-d H:i:s", strtotime($dateStart));           
            $dateEnd              = $data['EventEnd'];
            $eventEnd             = date("Y-m-d H:i:s", strtotime($dateEnd));           
            $eventTask            = $data['EventTask'];
            $eventAddress         = $data['EventAddress'];
            $eventColorPrimary    = $data['EventColorPrimary'];
            $eventColorSecundary  = $data['EventColorSecundary'];
            $eventAvailability    = $data['EventAvailability'];
            $eventConfirmation    = $data['EventConfirmation'];
            $eventAllDay          = $data['EventAllDay'];

            $params = array(
                ':eventTitle'          => $eventTitle,
                ':eventStart'          => $eventStart,
                ':eventEnd'            => $eventEnd,
                ':eventTask'           => $eventTask,
                ':eventAddress'        => $eventAddress,
                ':eventColorPrimary'   => $eventColorPrimary,
                ':eventColorSecundary' => $eventColorSecundary,
                ':eventAvailability'   => $eventAvailability,
                ':eventConfirmation'   => $eventConfirmation,
                ':eventAllDay'         => $eventAllDay
            );
            

            $initialPart = "UPDATE event_calendar SET EventTitle = :eventTitle, EventStart = :eventStart, EventEnd = :eventEnd, EventTask = :eventTask, EventAddress = :eventAddress, EventColorPrimary = :eventColorPrimary, EventColorSecundary = :eventColorSecundary, EventAvailability = :eventAvailability";
                

            $eventAllDay = 0;
            if (isset($data['EventAllDay']) && trim($data['EventAllDay']) !== '') {
                $eventAllDay = $data['EventAllDay'] ? 1 : 0;
                $initialPart .= ", EventAllDay = :eventAllDay";
                $params[':eventAllDay'] = $eventAllDay;
            }


            $eventConfirmation = 0;
            if (isset($data['EventConfirmation']) && trim($data['EventConfirmation']) !== '') {
                $eventConfirmation = $data['EventConfirmation'] ? 1 : 0;
                $initialPart .= ", EventConfirmation = :eventConfirmation";
                $params[':eventConfirmation'] = $eventConfirmation;
            }

            if (isset($data['IdEmployee']) && trim($data['IdEmployee']) !== '') {
                $idEmployee = $data['IdEmployee'];
                $initialPart .= ", IdEmployee = :idEmployee";
                $params[':idEmployee'] = $idEmployee;
            }

            if (isset($data['IdCompany']) && trim($data['IdCompany']) !== '') {
                $idCompany = $data['IdCompany'];
                $initialPart .= ", IdCompany = :idCompany";
                $params[':idCompany'] = $idCompany;
            }

            if (isset($data['IdLocalidad']) && trim($data['IdLocalidad']) !== '') {
                $idLocalidad = $data['IdLocalidad'];
                $initialPart .= ", IdLocalidad = :idLocalidad";
                $params[':idLocalidad'] = $idLocalidad;
            }

            $query = $initialPart;
            

            $query .= " WHERE IdEvent = :idEvent";
            $params[':idEvent'] = $idEvent;

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

    case 'editDate':
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

        if (!isset($data)){
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $dateStart            = $data['EventStart'];
            $eventStart           = date("Y-m-d H:i:s", strtotime($dateStart));           
            $dateEnd              = $data['EventEnd'];
            $eventEnd             = date("Y-m-d H:i:s", strtotime($dateEnd));

            $params = array(
                ':eventStart'          => $eventStart,
                ':eventEnd'            => $eventEnd,
            );
            

            $query = "UPDATE event_calendar SET EventStart = :eventStart, EventEnd = :eventEnd";
                            
            $query .= " WHERE IdEvent = :idEvent";
            $params[':idEvent'] = $idEvent;

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

    case 'delete':
        if ($method !== 'DELETE') {
            header('HTTP/1.1 405 Allow: DELETE');
            exit();
        }
        
        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }

        $idEvent = (int) $url[6];

        if (TokenTool::isValid($token)) {
            $query = "DELETE FROM event_calendar WHERE IdEvent = :IdEvent";
            if (DBManager::query($query, array(':IdEvent' => $idEvent))) {
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