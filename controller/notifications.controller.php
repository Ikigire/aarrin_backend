<?php
/**
* Controlador de funciones para tabla notifications
*
* Manejo de acciones sobre la tabla notifications
* Operaciones a utilizar y descripción a utilizar:

* Solicitar las notificaciones de un empleado-> url: .../api/v1-2/notifications/employee/:idEmployee, metodo: GET, datos-solicitados: {Role_Type?: string}

* Solicitar las notificaciones de una compañía-> url: .../api/v1-2/notifications/company/:idCompany, metodo: GET, datos-solicitados: {}

* Crear una nueva notificación-> url: .../api/v1-2/notifications/add, metodo: POST, datos-solicitados: {Message: string, URL: string, Role_Type: string}

* Marcar una notificación como vista-> url: .../api/v1-2/notifications/viewed/:idNotification, metodo: PUT, datos-solicitados: {}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idEmployee ID del empleado
 */
$idEmployee = -1;

/**
 * @var int $idCompany ID de la compañia
 */
$idCompany = -1;

/**
 * @var string $roleType El tipo de rol 
 */
$roleType = '';

/**
 * @var string $message Mensaje de la notificación
 */
$message = '';

/**
 * @var string $notificationUrl URL a la que dirigirá la notificación
 */
$notificationUrl = '';

switch ($url[5]) {
    /**
     * Solicitar las notificaciones de un empleado-> 
     * url: .../api/v1-2/notifications/employee/:idEmployee, 
     * metodo: GET, 
     * datos-solicitados: {Role_Type?: string}
     * @param int IdEmployee- ID del empleado al obtener sus notificaciones, el cual deberá ir al final de la URL
     * @return jsonString|null Las notificaciones del empleado con ese ID, 
     */
    case 'employee':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idEmployee = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT IdNotification, IdEmployee, IdCompany, Role_Type, Message, URL, Viewed, NotificationDate FROM notifications WHERE IdEmployee = :idEmployee";

            $params = array(':idEmployee' => $idEmployee);

            if (isset($_GET['Role_Type'])) {
                $role = $_GET['Role_Type'];
                $query .= " OR Role_Type = :roleType";
                $params[':roleType'] = $roleType;
            }
            
            $query .= " ORDER BY NotificationDate DESC";
            $data = DBManager::query($query, $params);

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
     * Solicitar las notificaciones de una compañía-> 
     * url: .../api/v1-2/notifications/company/:idCompany, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idCompany Id de la compañía
     * @return jsonString Todas las notificaciones se la compañía
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

        if (TokenTool::isValid($token)){
            $query = "SELECT IdNotification, IdEmployee, IdCompany, Role_Type, Message, URL, Viewed, NotificationDate FROM notifications WHERE IdCompany = :idCompany ORDER BY NotificationDate DESC";

            $params = array(':idCompany' => $idCompany);

            $data = DBManager::query($query, $params);

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
     * Crear una nueva notificación-> 
     * url: .../api/v1-2/notifications/add, 
     * metodo: POST, 
     * datos-solicitados: {Message: string, URL: string, Role_Type: string}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (TokenTool::isValid($token)){
            if (isset($_POST['Message']) && isset($_POST['URL']) && isset($_POST['Role_Type'])) {
                $message = $_POST['Message'];
                $notificationUrl = $_POST['URL'];
                $roleType = $_POST['Role_Type'];
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');

                $initialPart = "INSERT INTO notifications (Role_Type, Message, URL, NotificationDate";
                $values = "VALUES(:roleType, :message, :notificationUrl', :currentDate";

                $params = array(
                    ':message' => $message,
                    ':notificationUrl' => $notificationUrl,
                    ':roleType' => $roleType,
                    ':currentDate' => $currentDate
                );
                
                if (isset($_POST['IdEmployee'])) {
                    $idEmployee = $_POST['IdEmployee'];
                    $initialPart .= ", IdEmployee";
                    $values .= ", :idEmployee";
                    $params[':idEmployee'] = $idEmployee;
                }

                if (isset($_POST['IdCompany'])) {
                    $idCompany = $_POST['IdCompany'];
                    $initialPart .= ", IdCompany";
                    $values .= ", :idCompany";
                    $params[':idCompany'] = $idCompany;
                }

                $query = $initialPart. ") ". $values. ");";

                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdNotification' => $response));
                }else {
                    header(HTTP_CODE_409);
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
     * Marcar una notificación como vista-> 
     * url: .../api/v1-2/notifications/viewed/:idNotification, 
     * metodo: PUT, 
     * datos-solicitados: {}
     * @param int idNotification ID de la notficación a marcar como visto
     * @return jsonString resultado de la operación
     */
    case 'viewed':
        if ($method !== 'PUT'){
            header('HTTP/1.1 405 Allow: PUT');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idNotification = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "UPDATE notifications SET Viewed = 1 WHERE IdNotification = :idNotification";

            if (DBManager::query($query, array(':idNotification' => $idNotification))){
                header(HTTP_CODE_205);
                echo json_encode(array('result' => 'Updated'));
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