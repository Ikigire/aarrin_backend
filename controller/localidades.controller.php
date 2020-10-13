<?php
/**
* Controlador de funciones para tabla localidades
*
* Manejo de acciones sobre la tabla localidades
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos las localidades de un municipio-> url: .../api/v1-2/localidades/municipio/:idMunicipio, metodo: GET, datos-solicitados: {}

* Solicitar los datos de una localidad-> url: .../api/v1-2/localidades/get/:idLocalidad, metodo: get, datos-solicitados: {}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idLocalidad ID de la localidad
 */
$idLocalidad = -1;

/**
 * @var int $idMunicipio ID del municipio
 */
$idMunicipio = -1;

switch ($url[5]) {
    /**
     * Solicitar todos las localidades de un municipio-> 
     * url: .../api/v1-2/localidades/municipio/:idMunicipio, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idMunicipio ID del municipio del cual solicitan las localidades
     * @return jsonString|null Todas las localidades de ese municipio
     */
    case 'municipio':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idMunicipio = (int) $url[6];

        $query = "SELECT * FROM localidades WHERE municipio_id = :idMunicipio ORDER BY nombre";
        $data = DBManager::query($query, array(':idMunicipio' => $idMunicipio));

        if ($data) {
            header(HTTP_CODE_200);
            echo json_encode($data);
        } else {
            header(HTTP_CODE_204);
        }
        break;


    /**
     * Solicitar los datos de una localidad-> 
     * url: .../api/v1-2/localidades/get/:idLocalidad, 
     * metodo: get, 
     * datos-solicitados: {}
     * @param int idLocalidad ID de la localidad a buscar
     * @return jsonString Datos de la localidad con ese ID
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

        $idLocalidad = (int) $url[6];

        $query = "SELECT * FROM localidades WHERE id = :idLocalidad;";

        $data = DBManager::query($query, array(':idLocalidad' => $idLocalidad));
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