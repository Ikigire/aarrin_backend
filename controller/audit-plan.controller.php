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
function convertDateTime(string $date)
{
    $date = (string) $date;
    if (!is_bool(strpos($date, 'T'))) {
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

        if (TokenTool::isValid($token)) {
            $query = "SELECT ap.IdAuditPlan, con.IdContract, cl.IdLetter, ap.AuditPlanApproved, ap.AuditPlanReviewDate, ap.AuditPlanCreationDate, ap.AuditPlanRevision, ap.AuditPlanStatus, cl.Auditors, cl.TecnicalExperts, comp.*, ser.*, sec.* FROM audit_plan AS ap JOIN confirmation_letters AS cl ON ap.IdLetter = cl.IdLetter JOIN contracts AS con ON cl.IdContract=con.IdContract JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector ORDER BY ap.AuditPlanCreationDate DESC";
            $data = DBManager::query($query);

            if ($data) {
                header(HTTP_CODE_200);
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['IdAuditPlan']           = (int) $data[$i]['IdAuditPlan'];
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
     * trae todos los datos del empleado y de la carta confirmacion
     * url: .../api/v1-2/,
     * metodo: GET
     */
    case 'company':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idCompany = (int) $url[6];

        if (TokenTool::isValid($token)) {
            $query = "SELECT ap.IdAuditPlan, con.IdContract, cl.IdLetter, ap.AuditPlanApproved, ap.AuditPlanReviewDate, ap.AuditPlanCreationDate, ap.AuditPlanRevision, ap.AuditPlanStatus, comp.*, ser.*, sec.* FROM audit_plan AS ap JOIN confirmation_letters AS cl ON ap.IdLetter = cl.IdLetter JOIN contracts AS con ON cl.IdContract=con.IdContract JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector WHERE comp.IdCompany = :idCompany ORDER BY ap.AuditPlanCreationDate DESC";
            $data = DBManager::query($query, array(':idCompany' => $idCompany));

            if ($data) {
                header(HTTP_CODE_200);
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['IdAuditPlan']           = (int) $data[$i]['IdAuditPlan'];
                    $data[$i]['IdLetter']              = (int) $data[$i]['IdLetter'];
                    $data[$i]['AuditPlanApproved']     = (bool) $data[$i]['AuditPlanApproved'];
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
     * Obtener todos los datos de un plan de auditoría
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
        $idAuditPlan = (int) $url[6];

        if (TokenTool::isValid($token)) {
            $query = "SELECT * FROM audit_plan Where IdAuditPlan = :id";
            $data = DBManager::query($query, array(':id' => $idAuditPlan));

            if ($data) {
                header(HTTP_CODE_200);
                $auditPlan = $data[0];

                $auditPlan['IdAuditPlan'] = (int) $auditPlan['IdAuditPlan'];
                $auditPlan['IdLetter'] = (int) $auditPlan['IdLetter'];
                $auditPlan['IdPlanReviewer'] = $auditPlan['IdPlanReviewer'] ? (int) $auditPlan['IdPlanReviewer'] : null;
                $auditPlan['AuditPlanApproved'] = (bool) $auditPlan['AuditPlanApproved'];
                $auditPlan['AuditPlanActivities'] = json_decode($auditPlan['AuditPlanActivities']);
                $auditPlan['AuditPlanSitesDate'] = json_decode($auditPlan['AuditPlanSitesDate']);
                echo json_encode($auditPlan);
            } else {
                header(HTTP_CODE_404);
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
            if (isset($data['IdLetter']) && isset($data['AuditPlanSitesDate']) && isset($data['AuditPlanObjetives']) && isset($data['AuditPlanActivities'])) {
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');

                $initialPart = "INSERT INTO audit_plan(IdLetter, AuditPlanCreationDate, AuditPlanSitesDate, AuditPlanObjetives, AuditPlanActivities";
                $values = "VALUES (:idLetter, :planCreationDate, :auditPlanSitesDate, :auditPlanObjetives, :activities";

                $params = array(
                    ':idLetter'           => $data['IdLetter'],
                    ':planCreationDate'   => $currentDate,
                    ':auditPlanSitesDate' => json_encode($data['AuditPlanSitesDate']),
                    ':auditPlanObjetives' => $data['AuditPlanObjetives'],
                    ':activities'         => json_encode($data['AuditPlanActivities']),
                );

                $query = $initialPart .")" .$values .");";
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdAuditPlan' => $response));
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
         * 
         * url: .../api/v1-2/
         * metodo: PUT
         * datos-solicitados. {data: jsonString} deberá ir en el cuerpo de la solicitud
         * @param int
         * @return jsonString
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


        $idAuditPlan = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            if (isset($data['IdLetter']) && isset($data['AuditPlanSitesDate']) && isset($data['AuditPlanObjetives']) && isset($data['AuditPlanActivities'])) {
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');


                $params = array(
                    ':auditPlanSitesDate' => json_encode($data['AuditPlanSitesDate']),
                    ':auditPlanObjetives' => $data['AuditPlanObjetives'],
                    ':activities'         => json_encode($data['AuditPlanActivities']),
                );


                $query = "UPDATE audit_plan SET AuditPlanSitesDate= :auditPlanSitesDate, AuditPlanObjetives = :auditPlanObjetives, AuditPlanActivities = :activities";

                if (isset($data['AuditPlanStatus'])) {
                    $params[':auditPlanStatus'] = $data['AuditPlanStatus'];
                    $query .= ", AuditPlanStatus = :auditPlanStatus";
                }

                if (isset($data['AuditPlanApproved'])) {
                    $params[':auditPlanApproved'] = (int) $data['AuditPlanApproved'];
                    $params[':idPlanReviewer'] = $data['IdPlanReviewer'];
                    $params[':approvedDate'] = $currentDate;
                    $query .= ", AuditPlanApproved = :auditPlanApproved, IdPlanReviewer = :idPlanReviewer, AuditPlanReviewDate = :approvedDate";
                } else {
                    $params[':auditPlanApproved'] = (int) $data['AuditPlanApproved'];
                    $query .= ", AuditPlanApproved = :auditPlanApproved, IdPlanReviewer = null, AuditPlanReviewDate = null";
                }

                if (isset($data['AuditPlanRevision'])) {
                    $params[':auditPlanRevision'] = $data['AuditPlanRevision'];
                    $query .= ", AuditPlanRevision = :auditPlanRevision";
                } else {
                    $query .= ", AuditPlanRevision = null";
                }

                $query .= " WHERE IdAuditPlan = :idAuditPlan";
                $params[':idAuditPlan'] = $idAuditPlan;

                if (DBManager::query($query, $params)) {
                    header(HTTP_CODE_200);
                    echo json_encode($data);
                } else {
                    header(HTTP_CODE_409);
                }
            } else {
                header(HTTP_CODE_412);
            }
        } else {
            header(HTTP_CODE_401);
        }

        break;

        case 'editRevision':
            if ($method !== 'PUT') {
                header('HTTP/1.1 405 Allow: PUT');
                exit();
            }
    
            if (!isset($url[6])) {
                header(HTTP_CODE_412);
                exit();
            }
    
    
            $idAuditReport = (int) $url[6];
    
            $data = json_decode(file_get_contents('php://input'), true);
    
            if (!isset($data)) {
                header(HTTP_CODE_412);
                exit();
            }
    
            if (TokenTool::isValid($token)) {
                
                $params = array(
                    ':auditPlanRevision' => $data['AuditPlanRevision'],
                );
                
                $query = "UPDATE audit_plan SET AuditPlanRevision = :auditPlanRevision";
    
                $query .= " WHERE IdAuditPlan = :idAuditPlan";
                $params[':idAuditPlan'] = $idAuditPlan;
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

        case 'delete':
            if ($method !== 'DELETE') {
                header('HTTP/1.1 405 Allow: PUT');
                exit();
            }
    
            if (!isset($url[6])) {
                $idAuditPlan = (int)$url[6];
                header(HTTP_CODE_412);
                exit();
            }

            if (TokenTool::isValid($token)) {
                $params = array(
                    ':id' => $idAuditPlan
                );

                $query = "DELETE FROM audit_plan WHERE IdAuditPlan = :id";

                if (DBManager::query($query, $params)) {
                    header(HTTP_CODE_200);
                    echo json_encode(array('Deleted' => true));
                } else {
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
