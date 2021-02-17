<?php
/**
* Controlador de funciones para tabla tech_report
*
* Manejo de acciones sobre la tabla tech_report
* Operaciones a utilizar y descripción a utilizar:

* Solicitar la información de technical report por su plan de auditoría-> url: .../api/v1-2/tech_report/getauditplan/:idAuditPlan, metodo: GET, datos-solicitados: {}

* Registra una respuesta de technical report -> url: .../api/v1-2/tech_report/add,metodo: POST, datos-solicitados: {}

* Editar los datos de los registros technical report url: .../api/v1-2/tech_report/edit/:IdCertification, metodo: PUT, datos-solicitados: {tech_report: jsonString}
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
    case 'get':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idAuditPlant = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query ="SELECT IdCertification, IdAuditPlant, CertificationReviewEmployee, CertificationCheckListAdmin, CertificationCheckListTech, CertificationInitialDate, CertificationDecisionDate, CertificationExpirationDate, CertificationStatus FROM certification_checklist WHERE IdAuditPlant= :idAuditPlant";

            $params = array(':idAuditPlant' => $idAuditPlant);

            $data = DBManager::query($query, $params);
            if ($data) {
                $appData = $data[0];
                $appData['CertificationReviewEmployee'] = json_decode($appData['CertificationReviewEmployee']);
                $appData['CertificationCheckListAdmin'] = json_decode($appData['CertificationCheckListAdmin']);
                $appData['CertificationCheckListTech'] = json_decode($appData['CertificationCheckListTech']);
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

        if (TokenTool::isValid($token)){
            if (isset($data['IdAuditPlant'])) {
                $certificationInitialDate = new DateTime("now");
                $certificationInitialDate = $certificationInitialDate->format('Y-m-d H:i:s');

                $params = array(
                    ':idAuditPlant'                => $data['IdAuditPlant'],
                    ':certificationInitialDate'    => $certificationInitialDate,
                    ':certificationStatus'         => $data['CertificationStatus'],
                );

                $initialPart = "INSERT INTO certification_checklist(IdAuditPlant, CertificationInitialDate, CertificationStatus";
                $values ="VALUES ( :idAuditPlant, :certificationInitialDate,  :certificationStatus";

                if (isset($data['CertificationReviewEmployee'])) {
                    $params[':certificationReviewEmployee'] = json_encode($data['CertificationReviewEmployee']);
                    $initialPart .= ", CertificationReviewEmployee";
                    $values .= ", :certificationReviewEmployee";
                }

                if (isset($data['CertificationCheckListAdmin'])) {
                    $params[':certificationCheckListAdmin'] = json_encode($data['CertificationCheckListAdmin']);
                    $initialPart .= ", CertificationCheckListAdmin";
                    $values .= ", :certificationCheckListAdmin";
                }

                if (isset($data['CertificationCheckListTech'])) {
                    $params[':certificationCheckListTech'] = json_encode($data['CertificationCheckListTech']);
                    $initialPart .= ", CertificationCheckListTech";
                    $values .= ", :certificationCheckListTech";
                }

                $query = $initialPart. ") ". $values. ")";

                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdCertification' => $response));
                } else {
                    header(HTTP_CODE_209);
                }
            } else {
                header(HTTP_CODE_412);
            }
            exit();
        } else {
            header(HTTP_CODE_401);
        }
    break;

    /**
     * Editar los datos de los registros technical report
     * url: .../api/v1-2/tech_report/edit/:IdCertification,
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


        $idCertification = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {

            $params = array(
                ':certificationReviewEmployee' => json_encode($data['CertificationReviewEmployee']),
                ':certificationCheckListTech'  => json_encode($data['CertificationCheckListTech']),
                ':certificationCheckListAdmin' => json_encode($data['CertificationCheckListAdmin']),
            );
        
            $query = "UPDATE certification_checklist SET CertificationReviewEmployee = :certificationReviewEmployee, CertificationCheckListAdmin = :certificationCheckListAdmin, CertificationCheckListTech = :certificationCheckListTech";


            if (isset($data['CertificationDecisionDate'])) {
                $datesDecision = $data['CertificationDecisionDate'];
                $params[':certificationDecisionDate'] = date("Y-m-d H:i:s", strtotime($datesDecision)); 
                $query .= ", CertificationDecisionDate = :certificationDecisionDate";
            }

            if (isset($data['CertificationExpirationDate'])) {
                $datesDecision = $data['CertificationExpirationDate'];
                $params[':certificationExpirationDate'] = date("Y-m-d H:i:s", strtotime($datesDecision));
                $query .= ", CertificationExpirationDate = :certificationExpirationDate";
            }

            if (isset($data['CertificationStatus'])) {
                $params[':certificationStatus'] = $data['CertificationStatus'];
                $query .= ", CertificationStatus = :certificationStatus";
            }

            $query .= " WHERE IdCertification = :idCertification";
            $params[':idCertification'] = $idCertification;
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

    /**
     * Editar los datos de los registros technical report
     * url: .../api/v1-2/tech_report/edit/:IdCertification,
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


        $idCertification = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (!isset($data['CertificationStatus'])){
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {

            $params = array(
                ':certificationStatus' => json_encode($data['CertificationStatus']),
            );
        
            $query = "UPDATE certification_checklist SET CertificationStatus = :certificationStatus";

            $query .= " WHERE IdCertification = :idCertification";
            $params[':idCertification'] = $idCertification;
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