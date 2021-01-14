<?php
/**
* Operaciones a utilizar y descripción a utilizar:
* @package ari-mobile-api
*/



switch ($url[5]) {
    /**
     * metodo: GET, 
     * datos-solicitados: {}
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
        $idAuditPlan = (int) $url[6];

        if (TokenTool::isValid($token)) {
            
            $query = "SELECT idTechReport, idQuestion, st1, st1compliance, st2, st2compliance, surv1, surv1compliance, surv2, surv2compliance FROM tech_report WHERE idAuditPlan = :idAuditPlan";
            $data = DBManager::query($query, array(':idAuditPlan' => $idAuditPlan));

            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['idTechReport']    = (int)   $data[$i]['idTechReport'];
                    $data[$i]['idQuestion']      = (int)   $data[$i]['idQuestion'];
                    $data[$i]['st1compliance']   = (bool)  $data[$i]['st1compliance'];
                    $data[$i]['st2compliance']   = (bool)  $data[$i]['st2compliance'];
                    $data[$i]['surv1compliance'] = (bool)  $data[$i]['surv1compliance'];
                    $data[$i]['surv2compliance'] = (bool)  $data[$i]['surv2compliance'];
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

        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            if (isset($data['idAuditPlan'])) {
                
                $initialPart = "INSERT INTO tech_report(idTechReport, idAuditPlan, idQuestion, st1, st1compliance, st2, st2compliance, surv1, surv1compliance, surv2, surv2compliance";
                $values = "VALUES (null, :idAuditPlan, :idQuestion , :st1, :st1compliance, :st2, :st2compliance, :surv1, :surv1compliance, :surv2, :surv2compliance";

                $params = array(
                    ':idAuditPlan'     => $data['idAuditPlan'],
                    ':idQuestion'      => $data['idQuestion'],
                    ':st1'             => $data['st1'],
                    ':st1compliance'   => (int) $data['st1compliance'],
                    ':st2'             => $data['st2'],
                    ':st2compliance'   => (int) $data['st2compliance'],
                    ':surv1'           => $data['surv1'],
                    ':surv1compliance' => (int) $data['surv1compliance'],
                    ':surv2'           => $data['surv2'],
                    ':surv2compliance' => (int) $data['surv2compliance'],
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
    case 'edit':
            if ($method !== 'PUT') {
                header('HTTP/1.1 405 Allow: PUT');
                exit();
            }
    
            if (!isset($url[6])) {
                header(HTTP_CODE_412);
                exit();
            }
    
    
            $idTechReport = (int) $url[6];
    
            $data = json_decode(file_get_contents('php://input'), true);
    
            if (!isset($data)) {
                header(HTTP_CODE_412);
                exit();
            }
    
            if (TokenTool::isValid($token)) {
            
                    $query = "UPDATE tech_report SET ";
    
                    if (isset($data['st1'])) {
                        $params[':st1'] = $data['st1'];
                        $query .= " st1 = :st1";
                    }

                    if (isset($data['st2'])) {
                        $params[':st2'] = $data['st2'];
                        $query .= ", st2 = :st2";
                    }

                    if (isset($data['st1compliance'])) {
                        $params[':st1compliance'] = (int) $data['st1compliance'];
                        $query .= ", st1compliance = :st1compliance";
                    }

                    if (isset($data['st2compliance'])) {
                        $params[':st2compliance'] = (int) $data['st2compliance'];
                        $query .= ", st2compliance = :st2compliance";
                    }

                    if (isset($data['surv1'])) {
                        $params[':surv1'] = $data['surv1'];
                        $query .= ", surv1 = :surv1";
                    }

                    if (isset($data['surv2'])) {
                        $params[':surv2'] = $data['surv2'];
                        $query .= ", surv2 = :surv2";
                    }

                    if (isset($data['surv1compliance'])) {
                        $params[':surv1compliance'] = (int) $data['surv1compliance'];
                        $query .= ", surv1compliance = :surv1compliance";
                    }

                    if (isset($data['surv2compliance'])) {
                        $params[':surv2compliance'] = (int) $data['surv2compliance'];
                        $query .= ", surv2compliance = :surv2compliance";
                    }
    
                    $query .= " WHERE idTechReport = :idTechReport";
                    $params[':idTechReport'] = $idTechReport;
    
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