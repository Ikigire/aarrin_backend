<?php
/**
* Controlador de funciones para tabla roles
*
* Manejo de acciones sobre la tabla roles
* Operaciones a utilizar y descripción a utilizar:

* Solicitar los roles de un empleado-> url: .../api/v1-2/roles/employee/:idEmployee, metodo: GET, datos-solicitados: {}

* Crear un nuevo rol-> url: .../api/v1-2/roles/add/:idEmployee/:roleType, metodo: POST, datos-solicitados: {}

* Eliminar un rol a un empleado-> url: .../api/v1-2/roles/delete/:idEmployee/:roleType, metodo: DELETE, datos-solicitados: {}
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
 * @var string $roleType El tipo de rol 
 */
$roleType = '';

switch ($url[5]) {
    /**
     * Solicitar los roles de un empleado-> 
     * url: .../api/v1-2/roles/employee/:idEmployee, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdEmployee- ID del empleado al obtener sus roles, el cual deberá ir al final de la URL
     * @return jsonString|null Los roles del empleado con ese ID, 
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
            $query = "SELECT Role_Type FROM roles WHERE IdEmployee = :id ORDER BY Role_Type";
            $data = DBManager::query($query, array(':id' => $idEmployee));

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
     * Crear un nuevo rol-> 
     * url: .../api/v1-2/roles/add/:idEmployee/:roleType, 
     * metodo: POST, 
     * datos-solicitados: {}
     * @param int idEmployee ID del empleado al agregar un rol
     * @param string roleType Rol a agregar al empleado
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (!isset($url[6]) || !isset($url[7])){
            header(HTTP_CODE_412);
            exit();
        }

        $idEmployee = (int) $url[6];
        $roleType   = $url[7];

        if (TokenTool::isValid($token)){
            $query = "INSERT INTO roles(IdEmployee, Role_Type) VALUES (:idEmployee, :roleType);";

            $params = array(
                ':idEmployee' => $idEmployee,
                ':roleType'   => $roleType
            );

            $response = DBManager::query($query, $params);
            if ($response) {
                header(HTTP_CODE_201);
                echo json_encode(array('IdRole' => $response));
            }else {
                header(HTTP_CODE_409);
            }
            exit();
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Eliminar un rol a un empleado-> 
     * url: .../api/v1-2/roles/delete/:idEmployee/:roleType, 
     * metodo: DELETE, 
     * datos-solicitados: {}
     * @param int idEmployee ID del empleado al agregar un rol
     * @param string roleType Rol a agregar al empleado
     * @return jsonString resultado de la operación
     */
    case 'delete':
        if ($method !== 'DELETE'){
            header('HTTP/1.1 405 Allow: DELETE');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idEmployee = (int) $url[6];

        if (!isset($url[7])) {
            header(HTTP_CODE_412);
            exit();
        }
        $roleType = $url[7];

        if (TokenTool::isValid($token)){
            $query = "DELETE FROM roles WHERE IdEmployee = :idEmployee And Role_Type = :roleType";
            
            $params = array(
                ':idEmployee' => $idEmployee,
                ':roleType'   => $roleType
            );

            if (DBManager::query($query, $params)){
                header(HTTP_CODE_200);
                echo json_encode(array('result' => 'Deleted'));
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