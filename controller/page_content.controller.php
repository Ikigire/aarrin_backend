<?php
/**
* Controlador de funciones para tabla page_content
*
* Manejo de acciones sobre la tabla page_content
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los contenidos de una página (No se necesita Token)-> url: .../api/v1-2/page_content/page/:pagina, metodo: GET, datos-solicitados: {}

* Solicitar los datos de un contenido de página en específico (No se necesita Token)-> url: .../api/v1-2/page_content/get/:id, metodo: get, datos-solicitados: {}

* Crear un nuevo contenido de página-> url: ../api/v1-2/page_content/add, método: POST, datos-solicitados: {data: jsonString}

* Subir una archivo al servidor-> url: ../api/v1-2/page_content/upload, método: POST, datos-solicitados: {file: File}

* Editar un contenido de página-> url: ../api/v1-2/page_content/edit/:id, método: PUT, datos-solicitados{data: jsonString}

* Borrar un contenido-> url: ../api/v1-2/page_content/delete/:id, método: DELETE, datos-solicitados: {}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $id ID del contenido de página
 */
$id = -1;

/**
 * @var string $codeHTML Código HTML del contenido
 */
$codeHTML = '';

/**
 * @var string $pagina Nombre de la página a la cual pertenece el contenido
 */
$pagina = '';

switch ($url[5]) {
    /**
     * Solicitar todos los contenidos de una página (No se necesita Token)-> 
     * url: .../api/v1-2/page_content/page/:pagina, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param pagina String Nombre de la página 
     * @return jsonString|null Todos los contenidos de esa página 
     */
    case 'page':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }
        $pagina = (string) $url[6];

        $query = "SELECT * FROM page_content WHERE pagina = :pagina";
        $data = DBManager::query($query, array(':pagina' => $pagina));

        if ($data) {
            header(HTTP_CODE_200);
            echo json_encode($data);
        } else {
            header(HTTP_CODE_204);
        }
        break;


    /**
     * Solicitar los datos de un contenido de página en específico (No se necesita Token)-> 
     * url: .../api/v1-2/page_content/get/:id, 
     * metodo: get, 
     * datos-solicitados: {}
     * @param int id ID del contenido de página a buscar
     * @return jsonString Datos del contenido de página con ese ID
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

        $id = (int) $url[6];

        $query = "SELECT * FROM page_content WHERE id = :id;";

        $data = DBManager::query($query, array(':id' => $id));
        if ($data) {
            header(HTTP_CODE_201);
            echo json_encode($data[0]);
        }else {
            header(HTTP_CODE_409);
        }
        exit();
        break;

    /**
     * Crear un nuevo contenido de página-> 
     * url: ../api/v1-2/page_content/add, 
     * método: POST, 
     * datos-solicitados: {data: jsonString}
     * @return jsonString objeto json cno el resultado de la operación
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
            $query = "INSERT INTO page_content VALUES(null, :codeHTML, :pagina)";
            $response = DBManager::query($query, array(':codeHTML' => $data['codeHTML'], ':pagina' => $data['pagina']));
            if ($response) {
                header(HTTP_CODE_201);
                echo json_encode(array('id' => $response));
            }else {
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Subir una archivo al servidor-> 
     * url: ../api/v1-2/page_content/upload, 
     * método: POST, 
     * datos-solicitados: {file: File}
     * @return string La ruta de la imagen guardada
     */
    case 'upload':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if(!isset($_FILES['file'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            $f = $_FILES['file'];
            $ext = pathinfo($f['name'])['extension'];
            $name = pathinfo($f['name'])['filename'].'.'.$ext;
            $path = "https://aarrin.com/mobile/app_resources/page_content/$name";
            if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../app_resources/page_content/$name")){
                header(HTTP_CODE_201);
                echo json_encode(array('path' => $path));
            }else{
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;
    
    /**
     * Editar un contenido de página-> 
     * url: ../api/v1-2/page_content/edit/:id, 
     * método: PUT, 
     * datos-solicitados{data: jsonString}
     * @param id int El ID del contenido de página a editar
     * @return jsonString Objeto con los datos actualizados
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
        $id = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            $query = "UPDATE page_content SET codeHTML = :codeHTML, pagina = :pagina WHERE id = :id";
            if (DBManager::query($query, array(':id' => $id, ':codeHTML' => $data['codeHTML'], ':pagina' => $data['pagina']))) {
                header(HTTP_CODE_201);
                echo json_encode($data);
            }else {
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Borrar un contenido-> 
     * url: ../api/v1-2/page_content/delete/:id, 
     * método: DELETE, 
     * datos-solicitados: {}
     * @param id int ID del contenido de página a eliminar
     * @return string mensaje de resultado de operación 
     */
    case 'delete':
        if ($method !== 'DELETE') {
            header('HTTP/1.1 405 Allow: DELETE');
            exit();
        }
        
        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }

        $id = (int) $url[6];

        if (TokenTool::isValid($token)) {
            $query = "DELETE FROM page_content WHERE id = :id";
            if (DBManager::query($query, array(':id' => $id))) {
                header(HTTP_CODE_201);
                echo json_encode(array('message' => 'Content deleted'));
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