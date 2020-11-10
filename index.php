<?php
/**
* Recepcionista de todas las peticiones a la API
*
* Recibe las peticiones http
* Secciona las peticiones de acuerdo a la url solicitada (nombre tabla)
* Deriva el trabajo al controlador adecuado.
* La url de base para las peticiones será https://aarin.com/mobile/...
*
* Toda petición deberá tener incluir en la URL el token de seguridad asignada como parametro 'token'
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');

include('classes/dbManager.php');
include('classes/TokenTool.php');



define('HTTP_CODE_200', 'HTTP/1.1 200 OK');
define('HTTP_CODE_201', "HTTP/1.1 201 Created");
define('HTTP_CODE_204', "HTTP/1.1 204 Not Found");
define('HTTP_CODE_205', 'HTTP/1.1 205 Reset Content');
define('HTTP_CODE_401', "HTTP/1.1 401 Unauthorized");
define('HTTP_CODE_403', 'HTTP/1.1 403 Forbidden');
define('HTTP_CODE_404', "HTTP/1.1 404 Not Found");
define('HTTP_CODE_409', "HTTP/1.1 409 Conflict with the Server");
define('HTTP_CODE_412', "HTTP/1.1 412 Preconditions Failed");

/**
 * @var string $method Verbo http solicitado (GET, POST, PUT, DELETE, OPTIONS, etc...)
 */
$method = $_SERVER['REQUEST_METHOD'];

/**
 * @var string $request_uri Url solicitada en la petición
 */
$request_uri = $_SERVER['REQUEST_URI'];

/**
 * @var string|null $token Token a validar las operaciones sobre la BD
 */
$token = null;


if ($method === 'OPTIONS') {
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    exit();
}

if (isset($_GET['token']) && $_GET['token'] !== null) {
    $token = $_GET['token'];
}

$url = filter_var($request_uri, FILTER_SANITIZE_URL);

$url = rtrim($request_uri, '/');

$pos = strpos($url, '?');

$url = $pos > 0? substr($url, 0, $pos): $url;

$url = explode('/', $url);

if ($url[3] === 'v1-2') {
    switch ($url[4]) {
        /**
         *   _____________________________
         *  /             KEYS            \
         * |                               |
         * |  TABLA DE KEYS PARA CONTROL   |
         * |  DE REGISTROS Y RESTAURACIÓN  |
         * |  DE CONTRASEÑAS               |
         * |                               |
         *  \_____________________________/
         * 
         */
        case 'keys':
            require_once('controller/keys.controller.php');
            break;

        /**
         *   ______________________________
         *  /          COMPANIES           \
         * |                                |
         * |  TABLA DE COMPANIES PARA       |
         * |  CONTROL DE REGISTROS SOLICITUD|
         * |  DE DATOS Y MODIFICACIONES     |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'companies':
            require_once('controller/companies.controller.php');
            break;


        /**
         *   ______________________________
         *  /           CONTACTS           \
         * |                                |
         * |  TABLA DE CONTACTS PARA        |
         * |  CONTROL DE REGISTROS SOLICITUD|
         * |  DE DATOS,  MODIFICACIONES E   |
         * |  INICIOS DE SESIÓN DE CLIENTES |
         *  \______________________________/
         * 
         */
        case 'contacts':
            require_once('controller/contacts.controller.php');
            break;

        /**
         *   ______________________________
         *  /           PERSONAL           \
         * |                                |
         * |  TABLA DE PERSONAL PARA        |
         * |  CONTROL DE REGISTROS SOLICITUD|
         * |  DE DATOS,  MODIFICACIONES E   |
         * |  INICIOS DE SESIÓN             |
         *  \______________________________/
         * 
         */
        case 'personal':
            require_once('controller/personal.controller.php');
            break;

        /**
         *   ______________________________
         *  /           SERVICES           \
         * |                                |
         * |  TABLA DE SERVICIOS A          |
         * |        CONTRATAR               |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'services':
            require_once('controller/services.controller.php');
            break;

        /**
         *   ______________________________
         *  /            SECTORS           \
         * |                                |
         * |  TABLA DE SECTORES PARA        |
         * |   EL REGISTRO DE APLICACIONES  |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'sectors':
            require_once('controller/sectors.controller.php');
            break;

        /**
         *   ______________________________
         *  /            ROLES             \
         * |                                |
         * |  TABLA DE ROLES DE LOS         |
         * |        EMPLEADOS               |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'roles':
            require_once('controller/roles.controller.php');
            break;

        /**
         *   ______________________________
         *  /        NOTIFICATIONS         \
         * |                                |
         * |  TABLA DE NOTICACIONES DE CADA |
         * |  USUARIO QUE ACCEDE            |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'notifications':
            require_once('controller/notifications.controller.php');
            break;

        /**
         *   ______________________________
         *  /         APPLICATIONS         \
         * |                                |
         * |  TABLA DE APLIACIONES PARA     |
         * |  CONTRATACIÓN DE SERVICIOS     |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'applications':
            require_once('controller/applications.controller.php');
            break;

        /**
         *   ______________________________
         *  /       DAYS CALCULATION       \
         * |                                |
         * |  TABLA DE CÁLCULO DE DÍAS      |
         * |  PARA GUARDAR INFORMACIÓN      |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'dayscalculation':
            require_once('controller/days-calculation.controller.php');
            break;

        /**
         *   ______________________________
         *  /           PROPOSALS          \
         * |                                |
         * | TABLA DE PROPUESTAS REALIZADAS |
         * |   REALIZADAS A LOS CLIENTES    |
         * |  PARA CONTRATO DE AUDITORÍAS   |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'proposals':
            require_once('controller/proposals.controller.php');
            break;


        /**
         *   ______________________________
         *  /            ESTADOS           \
         * |                                |
         * |  TABLA DE ESTADOS DE LA        |
         * |  REPÚBLICA MEXICANA            |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'estados':
            require_once('controller/estados.controller.php');
            break;

        /**
         *   ______________________________
         *  /          MUNICIPIOS          \
         * |                                |
         * |  TABLA DE MUNICIPIOS DE LA     |
         * |  REPÚBLICA MEXICANA            |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'municipios':
            require_once('controller/municipios.controller.php');
            break;


        /**
         *   ______________________________
         *  /         LOCALIDADES          \
         * |                                |
         * |  TABLA DE LOCALIDADES DE LA    |
         * |  REPÚBLICA MEXICANA            |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'localidades':
            require_once('controller/localidades.controller.php');
            break;

        /**
         *   ______________________________
         *  /     CONTENIDO DE PÁGINAS     \
         * |                                |
         * |  TABLA PARA EL MANEJO DE       |
         * |  CONTENIDO DE LAS PÁGINAS      |
         * |                                |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'page_content':
            require_once('controller/page_content.controller.php');
            break;

        /**
         *   ______________________________
         *  /        LISTA MAESTRA         \
         * |                                |
         * |  TABLA PARA EL MANEJO DE       |
         * |  CUALIDADES DE LOS AUDITORES   |
         * |  DE ARI                        |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'master_list':
            require_once('controller/master_list.controller.php');
            break;

        /**
         *   ______________________________
         *  /           CONTRATOS          \
         * |                                |
         * |  TABLA PARA EL MANEJO DE       |
         * |  CONTRATOS ENTRE LAS COMPAÑÍAS |
         * |  Y ARI                         |
         * |                                |
         *  \______________________________/
         * 
         */
        case 'contracts':
            require_once('controller/contracts.controller.php');
            break;

        default:
            header(HTTP_CODE_404);
            break;
    }
} else {
    header(HTTP_CODE_404);
}