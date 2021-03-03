<?php
/**
* Controlador de funciones para tabla tech_report
*
* Manejo de acciones sobre la tabla tech_report
* Operaciones a utilizar y descripción a utilizar:

* Solicitar la información de technical report por su contrato-> url: .../api/v1-2/tech_report/getauditplan/:idContract, metodo: GET, datos-solicitados: {}

* Registra una respuesta de technical report -> url: .../api/v1-2/tech_report/add,metodo: POST, datos-solicitados: {}

* Editar los datos de los registros technical report url: .../api/v1-2/tech_report/edit/:idTechReport, metodo: PUT, datos-solicitados: {tech_report: jsonString}
*
* @package ari-mobile-api
*/



switch ($url[5]) {

    /**
     * trae todos la lista de Tech Report
     * url: .../api/v1-2/,
     * metodo: GET
     */
    case 'getall':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)) {
            $query = "SELECT tr.IdTechReport, tr.TechReportCreationDate, tr.TechReportRevision, tr.TechReportStatus, con.IdContract, comp.*, ser.*, sec.* FROM contracts AS con JOIN tech_report AS tr ON tr.IdContract = con.IdContract JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app ON dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector ORDER BY con.CertificationCLInitialDate DESC";
            $data = DBManager::query($query);

            if ($data) {
                header(HTTP_CODE_200);
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['IdTechReport']           = (int) $data[$i]['IdTechReport'];
                    $data[$i]['IdContract']           = (int) $data[$i]['IdContract'];
                    $data[$i]['IdLetter']              = (int) $data[$i]['IdLetter'];
                    $data[$i]['AuditPlanApproved']     = (bool) $data[$i]['AuditPlanApproved'];
                    $data[$i]['Auditors']     = json_decode($data[$i]['Auditors']);
                    $data[$i]['TecnicalExperts']     = json_decode($data[$i]['TecnicalExperts']);
                }
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;
    /**
     * Solicita la informacion de la technical report por su contrato
     * url: .../api/v1-2/tech_report/getContract/:idContract
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdContract ID del contrato, deberá ir al final de de la URL
     * @return jsonString|null Todas los respuestas registradas
     */

    
    case 'getIdContract':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }

        $IdContract = (int) $url[6];

        if (TokenTool::isValid($token)) {
            
            $query = "SELECT tr.IdTechReport, tr.IdContract, tr.TechReportQuetion, tr.TechReportCreationDate, tr.TechReportFinalizedDate, tr.TechReportApproved, tr.TechReportRevision, tr.TechReportStatus, ctts.CurrentStage FROM tech_report AS tr INNER JOIN contracts AS ctts on ctts.IdContract = tr.IdContract WHERE tr.IdContract = :idContract";
            $data = DBManager::query($query, array(':idContract' => $IdContract));

            if ($data) {
                $appData = $data[0];
                $appData['TechReportQuetion'] = json_decode($appData['TechReportQuetion']);
                $appData['TechReportApproved'] = json_decode($appData['TechReportApproved']);
                header(HTTP_CODE_200);
                echo json_encode($appData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
    break;

    /**
     * Solicita la informacion de la technical report por ID TechReport
     * url: .../api/v1-2/tech_report/getTechReport/:idTechReport
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idTechReport ID del technical report, deberá ir al final de de la URL
     * @return jsonString|null Todas los respuestas registradas
     */
    case 'getIdTechReport':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $IdTechReport = (int) $url[6];

        if (TokenTool::isValid($token)) {
            
            $query = "SELECT tr.IdTechReport, tr.IdContract, tr.TechReportQuetion, tr.TechReportCreationDate, tr.TechReportFinalizedDate, tr.TechReportApproved, tr.TechReportRevision, tr.TechReportStatus, ctts.CurrentStage FROM tech_report AS tr INNER JOIN contracts AS ctts on ctts.IdContract = tr.IdContract WHERE tr.IdTechReport = :idTechReport";
            $data = DBManager::query($query, array(':idTechReport' => $IdTechReport));

            if ($data) {
                $appData = $data[0];
                $appData['TechReportQuetion'] = json_decode($appData['TechReportQuetion']);
                $appData['TechReportApproved'] = json_decode($appData['TechReportApproved']);
                header(HTTP_CODE_200);
                echo json_encode($appData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
    break;

    /**
     * Solicita una lista de la informacion de la technical report
     * url: .../api/v1-2/tech_report/getTechReport/:idTechReport
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idTechReport ID del technical report, deberá ir al final de de la URL
     * @return jsonString|null Todas los respuestas registradas
     */
    case 'get':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }


        if (TokenTool::isValid($token)) {
            
            $query = "SELECT tr.IdTechReport, tr.IdContract, tr.TechReportQuetion, tr.TechReportCreationDate, tr.TechReportFinalizedDate, tr.TechReportApproved, tr.TechReportRevision, tr.TechReportStatus, ctts.CurrentStage FROM tech_report AS tr INNER JOIN contracts AS ctts on ctts.IdContract = tr.IdContract";
            $data = DBManager::query($query);

            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['IdTechReport']              = (int)   $data[$i]['IdTechReport'];
                    $data[$i]['IdContract']                = (int)   $data[$i]['IdContract'];
                    $data[$i]['TechReportIdQuestion']      = json_decode($data[$i]['TechReportIdQuestion']);
                    $data[$i]['TechReportApproved']        = json_decode($data[$i]['TechReportApproved']);
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
     * url: .../api/v1-2/tech_report/getCurrentStage/:idContract
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdContract ID del contrato, deberá ir al final de de la URL
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
        $IdContract = (int) $url[6];

        if (TokenTool::isValid($token)) {
            
            $query = "SELECT ctts.CurrentStage, cl.IdAuditLeader, ctts.IdService FROM audit_plan AS ap INNER JOIN confirmation_letters AS cl on cl.IdLetter = ap.IdLetter INNER JOIN contracts As ctts on ctts.IdContract = cl.IdContract WHERE ctts.IdContract = :idContract";
            $data = DBManager::query($query, array(':idContract' => $IdAuditPlan));

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

        if (!isset($data) || !isset($data['IdContract']) || !isset($data['TechReportStatus'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            if (isset($data['IdContract'])) {
                
                $date = new DateTime("now");
                $TechReportCreationDate = $date->format('Y-m-d H:i:s');

                $initialPart = "INSERT INTO tech_report(IdTechReport, IdContract, TechReportCreationDate, TechReportStatus";
                $valuesPart = "VALUES (null, :idContract, :techReportCreationDate, :techReportStatus";

                $params = array(
                    ':idContract'             => (int) $data['IdContract'],
                    ':techReportCreationDate' => $TechReportCreationDate,
                    ':techReportStatus'       => $data['TechReportStatus'],
                );

                if (isset($data['TechReportFinalizedDate'])) {
                    $TechReportFinalizedDate = $data['TechReportFinalizedDate'];
                    $params[':techReportFinalizedDate'] = date("Y-m-d H:i:s", strtotime($TechReportFinalizedDate));
                    $initialPart .= ", TechReportFinalizedDate";
                    $valuesPart  .= ", :techReportFinalizedDate";
                }


                if (isset($data['TechReportQuetion'])) {
                    $params[':techReportQuetion'] = json_encode($data['TechReportQuetion']);
                    $initialPart .= ", TechReportQuetion";
                    $valuesPart  .= ", :techReportQuetion";
                }
    
                if (isset($data['TechReportApproved'])) {
                    $params[':techReportApproved'] = json_encode($data['TechReportApproved']);
                    $initialPart .= ", TechReportApproved";
                    $valuesPart  .= ", :techReportApproved";
                }


                $query = $initialPart .")" .$valuesPart .");";
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdTechReport' => $response));
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
                
                $params = array(
                    ':techReportStatus' => $data['TechReportStatus'],
                );
                
                $query = "UPDATE tech_report SET  TechReportStatus = :techReportStatus ";

                if (isset($data['TechReportQuetion'])) {
                    $params[':techReportQuetion'] = json_encode($data['TechReportQuetion']);
                    $query .= ", TechReportQuetion = :techReportQuetion";
                }

                if (isset($data['TechReportFinalizedDate'])) {
                    $TechReportFinalizedDate = $data['TechReportFinalizedDate'];
                    $params[':techReportFinalizedDate'] = date("Y-m-d H:i:s", strtotime($TechReportFinalizedDate));
                    $query .= ", TechReportFinalizedDate = :techReportFinalizedDate";
                }

                if (isset($data['TechReportApproved'])) {
                    $params[':techReportApproved'] = json_encode($data['TechReportApproved']);
                    $query .= ", TechReportApproved = :techReportApproved";
                }

                if (isset($data['TechReportRevision'])) {
                    $params[':techReportRevision'] = json_encode($data['TechReportRevision']);
                    $query .= ", TechReportRevision = :techReportRevision";
                }

                $query .= " WHERE IdTechReport = :idTechReport";
                $params[':idTechReport'] = $IdTechReport;
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
    /**
     * Editar los datos de los registros technical report
     * url: .../api/v1-2/tech_report/edit/:idTechReport,
     * metodo: PUT,
     * datos-solicitados: {tech_report: jsonString}
     * @return JsonString respuesta de resultado de la acción
     */
    case 'editStatus':
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

        if (!isset($data['TechReportStatus'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            
            $params = array(
                ':techReportStatus' => $data['TechReportStatus'],
            );
            
            $query = "UPDATE tech_report SET  TechReportStatus = :techReportStatus ";

            $query .= " WHERE IdTechReport = :idTechReport";
            $params[':idTechReport'] = $IdTechReport;
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
    /**
     * Editar los datos de los registros technical report
     * url: .../api/v1-2/tech_report/edit/:idTechReport,
     * metodo: PUT,
     * datos-solicitados: {tech_report: jsonString}
     * @return JsonString respuesta de resultado de la acción
     */
    case 'editRevision':
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

        if (!isset($data['TechReportRevision'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            
            $params = array(
                ':techReportRevision' => $data['TechReportRevision'],
            );
            
            $query = "UPDATE tech_report SET  TechReportRevision = :techReportRevision ";

            $query .= " WHERE IdTechReport = :idTechReport";
            $params[':idTechReport'] = $IdTechReport;
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