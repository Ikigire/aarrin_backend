<?php
/**
* Controlador de funciones para tabla estados
*
* Manejo de acciones sobre la tabla estados
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los estados-> url: .../api/v1-2/estados/getall/, metodo: GET, datos-solicitados: {}

* Solicitar los datos de un estado-> url: .../api/v1-2/estados/get/:idEstado, metodo: get, datos-solicitados: {}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idEstado ID del estado
 */
$idEstado = -1;

switch ($url[5]) {
    /**
     * Solicitar todos los estados-> 
     * url: .../api/v1-2/estados/getall/, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString|null Todos los etados 
     */
    case 'getall':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        $query = "SELECT * FROM estados";
        $data = DBManager::query($query);

        if ($data) {
            header(HTTP_CODE_200);
            echo json_encode($data);
        } else {
            header(HTTP_CODE_204);
        }
        break;


    /**
     * Solicitar los datos de un estado-> 
     * url: .../api/v1-2/estados/get/:idEstado, 
     * metodo: get, 
     * datos-solicitados: {}
     * @param int idEstado ID del estado a buscar
     * @return jsonString Datos del estado con ese ID
     */
    case 'get':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow: GET');
            exit();
        }

        if (!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }

        $idEstado = (int) $url[6];

        $query = "SELECT * FROM estados WHERE id = :idEstado;";

        $data = DBManager::query($query, array(':idEstado' => $idEstado));
        if ($data) {
            header(HTTP_CODE_201);
            echo json_encode($data[0]);
        }else {
            header(HTTP_CODE_409);
        }
        exit();
        break;

    default:
        header(HTTP_CODE_404);
        break;
}