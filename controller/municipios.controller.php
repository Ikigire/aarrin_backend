<?php
/**
* Controlador de funciones para tabla municipios
*
* Manejo de acciones sobre la tabla municipios
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los municipios de un estado-> url: .../api/v1-2/municipios/estado/:idEstado, metodo: GET, datos-solicitados: {}

* Solicitar los datos de un municipio-> url: .../api/v1-2/municipios/get/:idMunicipio, metodo: get, datos-solicitados: {}
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

/**
 * @var int $idMunicipio ID del municipio
 */
$idMunicipio = -1;

switch ($url[5]) {
    /**
     * Solicitar todos los municipios de un estados-> 
     * url: .../api/v1-2/municipios/estado/:idEstado, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idEstado ID del estado del cual solicitan los municipios
     * @return jsonString|null Todos los municipios de ese etado
     */
    case 'estado':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idEstado = (int) $url[6];

        $query = "SELECT * FROM municipios WHERE estado_id = :idEstado ORDER BY nombre";
        $data = DBManager::query($query, array(':idEstado' => $idEstado));

        if ($data) {
            header(HTTP_CODE_200);
            echo json_encode($data);
        } else {
            header(HTTP_CODE_204);
        }
        break;


    /**
     * Solicitar los datos de un municipio-> 
     * url: .../api/v1-2/municipios/get/:idMunicipio, 
     * metodo: get, 
     * datos-solicitados: {}
     * @param int idMunicipio ID del municipio a buscar
     * @return jsonString Datos del municipio con ese ID
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

        $idMunicipio = (int) $url[6];

        $query = "SELECT * FROM municipios WHERE id = :idMunicipio;";

        $data = DBManager::query($query, array(':idMunicipio' => $idMunicipio));
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