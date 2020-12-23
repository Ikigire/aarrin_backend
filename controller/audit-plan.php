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

        if(TokenTool::isValid($token)){
            if( isset($_POST['auditPlanDateStart']) && isset($_POST['auditPlanDateEnd']) && isset($_POST['auditPlanStatus']) && isset($_POST['audit_planDatil'])){isset($_POST['technical_Report'])){isset($_POST['positive_Issues'])){isset($_POST['Oppor_impro'])){isset($_POST['audit_Plant_Recommendation'])){
                

                $idLetter                   = $_POST['idLetter']) 
                $auditPlanDateStart         = $_POST['auditPlanDateStart'];
                $auditPlanDateStart         = date("Y-m-d H:i:s", strtotime($auditPlanDateStart));           
                $auditPlanDateEnd           = $_POST['auditPlanDateEnd']; 
                $auditPlanDateEnd           = date("Y-m-d H:i:s", strtotime($auditPlanDateEnd)); 
                $auditPlanStatus            = $_POST['auditPlanStatus'];
                $audit_planDatil            = $_POST['audit_planDatil'];
                $technical_Report           = $_POST['technical_Report'];
                $positive_Issues            = $_POST['positive_Issues'];
                $oppor_impro                = $_POST['Oppor_impro'];
                $audit_Plant_Recommendation = $_POST['audit_Plant_Recommendation'];
                

                $initialPart = "INSERT INTO `audit_plan`(`IdAuditPlan`, `IdLetter`, `AuditPlanDateStart`, `AuditPlanDateEnd`, `AuditPlanStatus`, `audit_planDatil`, `Technical_Report`, `Positive_Issues`, `Oppor_impro`, `Audit_Plant_Recommendation`";
                $values = "VALUES ( :IdAuditPlan :IdLetter :AuditPlanDateStart :AuditPlanDateEnd :AuditPlanStatus :audit_planDatil :Technical_Report :Positive_Issues :Oppor_impro, :Audit_Plant_Recommendation";

                $params = array(
                    ':idLetter'                  = $idLetter,
                    ':auditPlanDateStart'        = $auditPlanDateStart,
                    ':auditPlanDateEnd'          = $auditPlanDateEnd,
                    ':auditPlanStatus'           = $auditPlanStatus,
                    ':audit_planDatil'           = $audit_planDatil,
                    ':technical_Report'          = $technical_Report, 
                    ':positive_Issues'           = $positive_Issues,
                    ':oppor_impro'               = $Oppor_impro,
                    ':audit_Plant_Recommendatio' = $audit_Plant_Recommendatio,
                );

                $query = $initialPart. ") ". $values. ")";
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
            $idLetter                   = $data['idLetter']) 
            $auditPlanDateStart         = $data['auditPlanDateStart'];
            $auditPlanDateStart         = date("Y-m-d H:i:s", strtotime($auditPlanDateStart));           
            $auditPlanDateEnd           = $data['auditPlanDateEnd']; 
            $auditPlanDateEnd           = date("Y-m-d H:i:s", strtotime($auditPlanDateEnd)); 
            $auditPlanStatus            = $data['auditPlanStatus'];
            $audit_planDatil            = $data['audit_planDatil'];
            $technical_Report           = $data['technical_Report'];
            $positive_Issues            = $data['positive_Issues'];
            $oppor_impro                = $data['Oppor_impro'];
            $audit_Plant_Recommendation = $data['audit_Plant_Recommendation'];

            $params = array(
                ':idLetter' = $idLetter,
                ':auditPlanDateStart' = $auditPlanDateStart,
                ':auditPlanDateEnd' = $auditPlanDateEnd,
                ':auditPlanStatus' = $auditPlanStatus
                ':audit_planDatil' = $audit_planDatil, 
                ':technical_Report' = $technical_Report, 
                ':positive_Issues' = $positive_Issues,
                ':oppor_impro' = $Oppor_impro,
                ':audit_Plant_Recommendatio' = $audit_Plant_Recommendatio,
            );
            

            $initialPart = "UPDATE `audit_plan` SET `IdLetter`= :idLetter,`AuditPlanDateStart`= :auditPlanDateStart,`AuditPlanDateEnd`= :auditPlanDateEnd,`AuditPlanStatus`= :auditPlanStatus,`audit_planDatil`=:audit_planDati,`Technical_Report`=:Technical_Report,`Positive_Issues`=:positive_Issues,`Oppor_impro`=:oppor_impro,`Audit_Plant_Recommendation`= :audit_Plant_Recommendation";
           

            $query = $initialPart;
            

            $query .= " WHERE IdAuditPlan = :IdAuditPlan";
            $params[':IdAuditPlan'] = $IdAuditPlan;

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
            $auditPlanDateStart = $data['auditPlanDateStart'];
            $auditPlanDateStart = date("Y-m-d H:i:s", strtotime($auditPlanDateStart));           
            $auditPlanDateEnd   = $data['auditPlanDateEnd']; 
            $auditPlanDateEnd   = date("Y-m-d H:i:s", strtotime($auditPlanDateEnd)); 

            $params = array(
                ':auditPlanDateStart' = $auditPlanDateStart,
                ':auditPlanDateEnd' = $auditPlanDateEnd,
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