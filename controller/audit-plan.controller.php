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
            $query = "SELECT * FROM audit_plan_listview";
            $data = DBManager::query($query);

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
            $query = "SELECT * FROM audit_plan_listview WHERE IdCompany = :idCompany";
            $data = DBManager::query($query, array(':idCompany' => $idCompany));

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
                $auditPlan['AuditPlanReviewDate'] = $auditPlan['AuditPlanReviewDate'] ? new DateTime($auditPlan['AuditPlanReviewDate']) : null;
                $auditPlan['AuditPlanApproved'] = (bool) $auditPlan['AuditPlanApproved'];
                $auditPlan['AuditPlanCreationDate'] = new DateTime($auditPlan['AuditPlanCreationDate']);
                $auditPlan['AuditPlanDateStart'] = new DateTime($auditPlan['AuditPlanDateStart']);
                $auditPlan['AuditPlanDateEnd'] = new DateTime($auditPlan['AuditPlanDateEnd']);
                $auditPlan['AuditPlanActivities'] = json_decode($auditPlan['AuditPlanActivities']);
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
            if (isset($data['IdLetter']) && isset($data['AuditPlanDateStart']) && isset($data['AuditPlanDateEnd']) && isset($data['AuditPlanActivities'])) {
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');

                $initialPart = "INSERT INTO audit_plan(IdLetter, AuditPlanCreationDate, AuditPlanDateStart, AuditPlanDateEnd, AuditPlanActivities";
                $values = "VALUES (:idLetter, :planCreationDate, :auditPlanDateStart, :auditPlanDateEnd, :activities";

                $params = array(
                    ':idLetter'           => $data['IdLetter'],
                    ':planCreationDate'   => $currentDate,
                    ':auditPlanDateStart' => convertDateTime($data['AuditPlanDateStart']),
                    ':auditPlanDateEnd'   => convertDateTime($data['AuditPlanDateEnd']),
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
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');


            $params = array(
                ':auditPlanDateStart' => convertDateTime($data['AuditPlanDateStart']),
                ':auditPlanDateEnd'   => convertDateTime($data['AuditPlanDateEnd']),
                ':activities'         => json_encode($data['AuditPlanActivities']),
            );


            $query = "UPDATE audit_plan SET AuditPlanDateStart= :auditPlanDateStart, AuditPlanDateEnd = :auditPlanDateEnd, AuditPlanActivities = :activities";

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

        /**
         * Error en la entrada
         */
    default:
        header(HTTP_CODE_404);
        break;
}
