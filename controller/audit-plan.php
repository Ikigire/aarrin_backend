<?php
/**
* Controlador de funciones para tabla eventcalendar
*
* Manejo de acciones sobre la tabla eventcalendar
* Operaciones a utilizar y descripción a utilizar:
*
* @package ari-mobile-api
*/

switch ($url[5]) {
    /**
     * 
     * url: .../api/v1-2/,
     * metodo: GET
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
            $query = "SELECT p.EmployeeName, p.EmployeeLastName, p.EmployeePhone, p.EmployeeEmail, p.EmployeePhoto, ap.AuditPlanDateStart, ap.AuditPlanDateEnd FROM audit_plan as ap INNER JOIN confirmation_letters as cl on cl.IdLetter = ap.IdLetter INNER JOIN contracts As ct on ct.IdContract = cl.IdContract INNER JOIN personal As p on p.IdEmployee = ct.IdPersonal";
            $data = DBManager::query($query, array(':' => $idEvent));

            if ($data) {
                header(HTTP_CODE_200);
                $eventCalendarData = $data[0];
                echo json_encode($eventCalendarData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * 
     * url: .../api/v1-2/
     * metodo: POST
     * datos-solicitados. {}
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
     * 
     * url: .../api/v1-2/
     * metodo: PUT
     * datos-solicitados. {data: jsonString} deberá ir en el cuerpo de la solicitud
     * @param int
     * @return jsonString
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
            

            $initialPart = "UPDATE event_calendar SET EventTitle = :eventTitle, EventStart = :eventStart, EventEnd = :eventEnd, EventTask = :eventTask, EventAddress = :eventAddress, EventColorPrimary = :eventColorPrimary, EventColorSecundary = :eventColorSecundary, EventAvailability = :eventAvailability, EventConfirmation = :eventConfirmation, EventAllDay = :eventAllDay";
                
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
    /**
     * 
     * url: .../api/v1-2/
     * metodo: PUT
     * datos-solicitados. {data: jsonString} deberá ir en el cuerpo de la solicitud
     * @param int
     * @return jsonString
     */
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
    /**
     * Error en la entrada
     */
    default:
        header(HTTP_CODE_404);
        break;
}