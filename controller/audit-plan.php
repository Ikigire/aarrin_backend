<?php
/**
* Controlador de funciones para tabla eventcalendar
*
* Manejo de acciones sobre la tabla eventcalendar
* Operaciones a utilizar y descripción a utilizar:
*
* @package ari-mobile-api
*/


/**
 * Método para convertir fechas de otros lenguages a PHP
 * @param string $date Fecha a convertir
 * @return string Retorna la fecha seteada y lista para enviar a la BD
 */
function convertDateTime(string $date){
    $date = (string) $date;
    if (!is_bool(strpos($date, 'T'))){
        $date = str_replace('T', ' ', $date);
    }
    if (!is_bool(strpos($date, '.'))) {
        $date = substr($date, 0, strrpos($date, '.'));
    }

    return $date;
}

switch ($url[5]) {
    /**
     * trae todos los datos del empleado y de la carta confirmacion
     * url: .../api/v1-2/,
     * metodo: GET
     */
    case 'getall':
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
                $query = "SELECT `IdAuditPlan`, `IdLetter`, `AuditPlanDateStart`, `AuditPlanDateEnd`, `AuditPlanStatus`, `audit_planDatil`, `Technical_Report`, `Positive_Issues`, `Oppor_impro`, `Audit_Plant_Recommendation` FROM `audit_plan`";
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

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data)){
            header(HTTP_CODE_412);
            exit();
        }

        if(TokenTool::isValid($token)){
            if(isset($data['IdLetter']) && isset($data['AuditPlanDateStart']) && isset($data['AuditPlanDateEnd']) && isset($data['Activities'])){

                $initialPart = "INSERT INTO audit_plan(IdLetter, AuditPlanDateStart, AuditPlanDateEnd, Activities)";
                $values = "VALUES (:IdLetter :auditPlanDateStart, :auditPlanDateEnd, :activities)";

                $params = array(
                    ':idLetter'           => $data['IdLetter'],
                    ':auditPlanDateStart' => convertDateTime($data['AuditPlanDateStart']),
                    ':auditPlanDateEnd'   => convertDateTime($data['AuditPlanDateEnd']),
                    ':activities'         => $data['Activities'],
                );

                $query = $initialPart. $values;
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdAuditPlan' => $response));
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

        
        $idLetter = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data)){
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $idLetter                   = $data['IdLetter'];
            $auditPlanDateStart         = $data['AuditPlanDateStart'];
            $auditPlanDateStart         = date("Y-m-d H:i:s", strtotime($auditPlanDateStart));           
            $auditPlanDateEnd           = $data['auditPlanDateEnd']; 
            $auditPlanDateEnd           = date("Y-m-d H:i:s", strtotime($auditPlanDateEnd)); 
            $auditPlanStatus            = $data['AuditPlanStatus'];
            $audit_planDatil            = $data['Activities'];
            $technical_Report           = $data['Technical_Report'];
            $positive_Issues            = $data['Positive_Issues'];
            $oppor_impro                = $data['Oppor_impro'];
            $audit_Plant_Recommendation = $data['Audit_Plant_Recommendation'];


            $params = array(
                ':auditPlanDateStart' => convertDateTime($data['AuditPlanDateStart']),
                ':auditPlanDateEnd'   => convertDateTime($data['AuditPlanDateEnd']),
                ':activities'         => $data['Activities'],
            );
            

            $query = "UPDATE audit_plan SET AuditPlanDateStart= :auditPlanDateStart, AuditPlanDateEnd = :auditPlanDateEnd";

            if(isset($data['AuditPlanStatus'])){
                $params[':auditPlanStatus'] = $data['AuditPlanStatus']; 
                $query .= ", AuditPlanStatus = :auditPlanStatus";
            }

            if(isset($data['Technical_Report'])){
                $params[':technical_Report'] = $data['Technical_Report'];
                $query .= ", Technical_Report = :technical_Report";
            } else {
                $query .= ", Technical_Report = null";
            }

            if(isset($data['Positive_Issues'])){
                $params[':positive_Issues'] = $data['Positive_Issues'];
                $query .= ", Positive_Issues = :positive_Issues";
            } else {
                $query .= ", Positive_Issues = null";
            }

            if(isset($data['Oppor_Improve'])){
                $params[':oppor_Improve'] = $data['Oppor_Improve'];
                $query .= ", Oppor_Improve = :oppor_Improve";
            } else {
                $query .= ", Oppor_Improve = null";
            }

            if(isset($data['Audit_Plan_Recommendation'])){
                $params[':audit_Plan_Recommendation'] = $data['Audit_Plan_Recommendation'];
                $query .= ", Audit_Plan_Recommendation = :audit_Plan_Recommendation";
            } else {
                $query .= ", Audit_Plan_Recommendation = null";
            }            

            $query .= " WHERE IdAuditPlan = :idAuditPlan";
            $params[':idAuditPlan'] = $IdAuditPlan;

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