<?php
/**
* Controlador de funciones para tabla tech_report
*
* Manejo de acciones sobre la tabla tech_report
* Operaciones a utilizar y descripción a utilizar:

* Solicitar la información de technical report por su plan de auditoría-> url: .../api/v1-2/tech_report/getauditplan/:idAuditPlan, metodo: GET, datos-solicitados: {}

* Registra una respuesta de technical report -> url: .../api/v1-2/tech_report/add,metodo: POST, datos-solicitados: {}

* Editar los datos de los registros technical report url: .../api/v1-2/tech_report/edit/:idTechReport, metodo: PUT, datos-solicitados: {tech_report: jsonString}
*
* @package ari-mobile-api
*/



switch ($url[5]) {
    /**
     * Solicita la informacion de la technical report por  su plan de auditoria
     * url: .../api/v1-2/tech_report/getauditplan/:idAuditPlan
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idAuditplan ID del plan de auditoría, deberá ir al final de de la URL
     * @return jsonString|null Todas los respuestas registradas
     */
    case 'getauditplan':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $IdAuditPlan = (int) $url[6];

        if (TokenTool::isValid($token)) {
            
            $query = "SELECT IdTechReport, TechReportIdQuestion, TechReportSt1, TechReportSt1compliance, TechReportSt2, TechReportSt2compliance, TechReportSurv1, TechReportSurv1compliance, TechReportSurv2, TechReportSurv2compliance FROM tech_report WHERE IdAuditPlan = :idAuditPlan";
            $data = DBManager::query($query, array(':idAuditPlan' => $IdAuditPlan));

            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['IdTechReport']              = (int)   $data[$i]['IdTechReport'];
                    $data[$i]['TechReportIdQuestion']      = (int)   $data[$i]['TechReportIdQuestion'];
                    $data[$i]['TechReportSt1compliance']   = (bool)  $data[$i]['TechReportSt1compliance'];
                    $data[$i]['TechReportSt2compliance']   = (bool)  $data[$i]['TechReportSt2compliance'];
                    $data[$i]['TechReportSurv1compliance'] = (bool)  $data[$i]['TechReportSurv1compliance'];
                    $data[$i]['TechReportSurv2compliance'] = (bool)  $data[$i]['TechReportSurv2compliance'];
                }
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
     * Solicita el CurrentStage del contracto
     * url: .../api/v1-2/tech_report/getCurrentStage/:idAuditPlan
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idAuditplan ID del plan de auditoría, deberá ir al final de de la URL
     * @return CurrentStage|null Todas los respuestas registradas
     */
    case 'getCurrentStage':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $IdAuditPlan = (int) $url[6];

        if (TokenTool::isValid($token)) {
            
            $query = "SELECT  ctts.CurrentStage, cl.IdAuditLeader FROM audit_plan AS ap INNER JOIN confirmation_letters AS cl on cl.IdLetter = ap.IdLetter INNER JOIN contracts As ctts on ctts.IdContract = cl.IdContract WHERE ap.IdAuditPlan = :idAuditPlan LIMIT 1";
            $data = DBManager::query($query, array(':idAuditPlan' => $IdAuditPlan));

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
     * Registra una respuesta de technical report ->
     * url: .../api/v1-2/tech_report/add,
     * metodo: POST, 
     * datos-solicitados: {}
     * @return JsonString respuesta de resultado de la acción
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
            if (isset($data['IdAuditPlan'])) {
                
                $initialPart = "INSERT INTO tech_report(IdTechReport, IdAuditPlan, TechReportIdQuestion, TechReportSt1, TechReportSt1compliance, TechReportSt2, TechReportSt2compliance, TechReportSurv1, TechReportSurv1compliance, TechReportSurv2, TechReportSurv2compliance";
                $values = "VALUES (null, :idAuditPlan, :techReportIdQuestion , :techReportSt1, :techReportSt1compliance,  :techReportSt2, :techReportSt2compliance, :techReportSurv1, :techReportSurv1compliance, :techReportSurv2, :techReportSurv2compliance";

                $params = array(
                    ':idAuditPlan'               => $data['IdAuditPlan'],
                    ':techReportIdQuestion'      => $data['TechReportIdQuestion'],
                    ':techReportSt1'             => $data['TechReportSt1'],
                    ':techReportSt1compliance'   => (int) $data['TechReportSt1compliance'],
                    ':techReportSt2'             => $data['TechReportSt2'],
                    ':techReportSt2compliance'   => (int) $data['TechReportSt2compliance'],
                    ':techReportSurv1'           => $data['TechReportSurv1'],
                    ':techReportSurv1compliance' => (int) $data['TechReportSurv1compliance'],
                    ':techReportSurv2'           => $data['TechReportSurv2'],
                    ':techReportSurv2compliance' => (int) $data['TechReportSurv2compliance'],
                );
                $query = $initialPart .")" .$values .");";
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode($data);
                } else {
                    header(HTTP_CODE_409);
                }
                exit();
            } else {
                header(HTTP_CODE_412);
                exit();
            }
        } else {
            header(HTTP_CODE_401);
        }
    break;

    /**
     * Editar los datos de los registros technical report
     * url: .../api/v1-2/tech_report/edit/:idTechReport,
     * metodo: PUT,
     * datos-solicitados: {tech_report: jsonString}
     * @return JsonString respuesta de resultado de la acción
     */
    case 'edit':
            if ($method !== 'PUT') {
                header('HTTP/1.1 405 Allow: PUT');
                exit();
            }
    
            if (!isset($url[6])) {
                header(HTTP_CODE_412);
                exit();
            }
    
    
            $IdTechReport = (int) $url[6];
    
            $data = json_decode(file_get_contents('php://input'), true);
    
            if (!isset($data)) {
                header(HTTP_CODE_412);
                exit();
            }
    
            if (TokenTool::isValid($token)) {
            
                    $query = "UPDATE tech_report SET ";

                    if (isset($data['TechReportSt1compliance'])) {
                        $params[':techReportSt1compliance'] = (int) $data['TechReportSt1compliance'];
                        $query .= "TechReportSt1compliance = :techReportSt1compliance";
                    }

                    if (isset($data['TechReportSt2compliance'])) {
                        $params[':techReportSt2compliance'] = (int) $data['TechReportSt2compliance'];
                        $query .= ", TechReportSt2compliance = :techReportSt2compliance";
                    }

                    if (isset($data['TechReportSurv1compliance'])) {
                        $params[':techReportSurv1compliance'] = (int) $data['TechReportSurv1compliance'];
                        $query .= ", TechReportSurv1compliance = :techReportSurv1compliance";
                    }

                    if (isset($data['TechReportSurv2compliance'])) {
                        $params[':techReportSurv2compliance'] = (int) $data['TechReportSurv2compliance'];
                        $query .= ", TechReportSurv2compliance = :techReportSurv2compliance";
                    }

                    if (isset($data['TechReportSt1'])) {
                        $params[':techReportSt1'] = $data['TechReportSt1'];
                        $query .= ", TechReportSt1 = :techReportSt1";
                    }

                    if (isset($data['TechReportSt2'])) {
                        $params[':techReportSt2'] = $data['TechReportSt2'];
                        $query .= ", TechReportSt2 = :techReportSt2";
                    }

                    if (isset($data['TechReportSurv1'])) {
                        $params[':techReportSurv1'] = $data['TechReportSurv1'];
                        $query .= ", TechReportSurv1 = :techReportSurv1";
                    }

                    if (isset($data['TechReportSurv2'])) {
                        $params[':techReportSurv2'] = $data['TechReportSurv2'];
                        $query .= ", TechReportSurv2 = :techReportSurv2";
                    }
    
                    $query .= " WHERE IdTechReport = :idTechReport";
                    $params[':idTechReport'] = $IdTechReport;
                    // echo $params;
                    if (DBManager::query($query, $params)) {
                        header(HTTP_CODE_200);
                        echo json_encode($data);
                    } else {
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