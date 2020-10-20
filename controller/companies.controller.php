<?php
/**
* Controlador de funciones para tabla Companies
*
* Manejo de acciones sobre la tabla companies
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos en modo lista-> url: .../api/v1-2/companies/all, metodo: GET, datos-solicitados: {}

* Solicitar datos completos de una compañia-> url: .../api/v1-2/companies/get/:idCompany, metodo: GET, datos-solicitados: {}

* Crear una nueva compañia-> url: .../api/v1-2/companies/add (Este caso no necesitará de un token), metodo: POST, datos-solicitados: {name: string, rfc: string, address: string, website(opcional): string|null}

* Cambiar el logo de una compañia-> url: .../api/v1-2/companies/edit-logo/:idCompany, metodo: POST, datos-solicitados: {}

* Editar los datos de una compañia-> url: .../api/v1-2/companies/edit/:idCompany, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idCompany ID de la compañia a solicitar datos
 */
$idCompany = null;

/**
 * @var string $companyName El nombre de la compañía
 */
$companyName = null;

/**
 * @var string $companyRFC El RFC de la compañía
 */
$companyRFC = null;

/**
 * @var string $companyAddress La dirección de la compañía
 */
$companyAddress = null;

/**
 * @var string $companyWebsite La dirección web de la compañia
 */
$companyWebsite = null;


switch ($url[5]) {
    /**
     * Solicitar todos en modo lista -> 
     * url: .../api/v1-2/companies/all, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString Todos los registros en vista de lista
     */
    case 'all':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)){
            $query = "SELECT IdCompany, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite, CompanyLogo FROM companies; ";
            $data = DBManager::query($query);

            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            }else{
                header(HTTP_CODE_204);
            }
        }
        else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Solicitar datos completos de una compañia -> 
     * url: .../api/v1-2/companies/get/:idCompany, 
     * metodo: GET, 
     * datos-solicitados: {}
     *
     * @param int IdCompany- Id de la compañía, el cual deberá ir al final de la URL
     * @return jsonString|null Los datos de la compañía con ese ID, 
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
        $idCompany = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT IdCompany, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite, CompanyLogo FROM companies WHERE IdCompany = :idCompany";
            $data = DBManager::query($query, array(':idCompany' => $idCompany));

            if ($data) {
                header(HTTP_CODE_200);
                $companyData = $data[0];
                echo json_encode($companyData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Crear una nueva compañia (Este caso no necesitará de un token), -> 
     * url: .../api/v1-2/companies/add 
     * metodo: POST, 
     * datos-solicitados: {name: string, rfc: string, address: string, website(opcional): string|null}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if(isset($_POST['name']) && isset($_POST['rfc']) && isset($_POST['address'])){
            $companyName    = $_POST['name'];
            $companyRFC     = strtoupper($_POST['rfc']);
            $companyAddress = $_POST['address'];

            $params = array(
                ':companyName'    => $companyName,
                ':companyRFC'     => $companyRFC,
                ':companyAddress' => $companyAddress
            );

            $query = "SELECT * FROM companies WHERE CompanyRFC = :companyRFC;";
            $data = DBManager::query($query, array(':companyRFC' => $companyRFC));

            if ($data) {
                echo json_encode(array(
                    'answer' => 'Error',
                    'status' => 'That company has already been registered'
                ));
                exit();
            }

            if(isset($_POST['website'])){
                
                $companyWebsite = $_POST['website'];
                $query = "INSERT INTO companies(CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite) VALUES (:companyName, :companyRFC, :companyAddress, :companyWebsite);";
                $params[':companyWebsite'] = $companyWebsite;
            }else{
                $query = "INSERT INTO companies(CompanyName, CompanyRFC, CompanyAddress) VALUES (:companyName, :companyRFC, :companyAddress);";
            }

            $response = DBManager::query($query, $params);
            if ($response) {
                $array = array('IdCompany' => $response);
                header(HTTP_CODE_201);
                echo json_encode($array);
            }else {
                header(HTTP_CODE_409);
            }
            exit();
        }
        else{
            header(HTTP_CODE_412);
            exit();
        }
        break;

    
    /**
     * Cambiar el logo de una compañia-> 
     * url: .../api/v1-2/companies/edit-logo/:idCompany, 
     * metodo: POST, 
     * datos-solicitados: {rfc: string, logo: File}
     * @param int idCompany- Id de la compañía, deberá ir al final de la url
     * @return jsonString Datos actualizados de la compañía ya actualizados
     */
    case 'edit-logo':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        $idCompany = null;

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idCompany = (int) $url[6];

        if(isset($_POST['rfc']) && isset($_FILES['logo'])){
            if (TokenTool::isValid($token)) {
                $companyRFC = $_POST['rfc'];
                $f = $_FILES['logo'];
                $name = "logo_$idCompany.Image-$companyRFC.Clajhasd9ul3iu0a.ñohsdf-jsdf.klsdj0ojmalsdasd.png";
                $path = "https://aarrin.com/mobile/app_resources/companies/$name";
                if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../../../app_resources/companies/$name")){
                    $query = "UPDATE companies SET CompanyLogo = :path WHERE IdCompany = :idCompany";
                    $response = DBManager::query($query, array(':path' => $path, ':idCompany' => $idCompany));
                    if ($response){
                        header(HTTP_CODE_205);
                        $query = "SELECT IdCompany, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite, CompanyLogo FROM companies WHERE IdCompany = :idCompany";
                        $data = DBManager::query($query, array(':idCompany' => $idCompany));
                        $companyData = $data[0];
                        echo json_encode($companyData);
                    }else{
                        header(HTTP_CODE_409);
                    }
                }else{
                    header(HTTP_CODE_409);
                }
                exit();
            } else {
                header(HTTP_CODE_401);
            }
        }
        else{
            header(HTTP_CODE_412);
            exit();
        }
        break;



    /**
     * Editar los datos de una compañia-> 
     * url: .../api/v1-2/companies/edit/:idCompany, 
     * metodo: PUT, 
     * datos-solicitados: {data: jsonString}
     * @param int idCompany: Id de la compañía, deberá ir al final de url
     * @return jsonString Datos actualizados de la compañía ya actualizados
     */
    case 'edit':
        if ($method !== 'PUT'){
            header('HTTP/1.1 405 Allow: PUT');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idCompany = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $companyName = $data['CompanyName'];
            $companyRFC = strtoupper($data['CompanyRFC']);
            $companyAddress = $data['CompanyAddress'];
            $params = array(
                ':idCompany'      => $idCompany,
                ':companyName'    => $companyName,
                ':companyRFC'     => $companyRFC,
                ':companyAddress' => $companyAddress
            );
            if(isset($data['CompanyWebsite']) && trim($data['CompanyWebsite']) !== ''){
                $companyWebsite = $data['CompanyWebsite'];
                $query = "UPDATE companies SET CompanyName = :companyName, CompanyRFC = :companyRFC, CompanyAddress = :companyAddress, CompanyWebsite = :companyWebsite WHERE IdCompany = :idCompany;";
                $params[':companyWebsite'] = $companyWebsite;
            }else{
                $query = "UPDATE companies SET CompanyName = :companyName, CompanyRFC = :companyRFC, CompanyAddress = :companyAddress WHERE IdCompany = :idCompany;";
            }
            
            $response = DBManager::query($query, $params);
            if ($response){
                header(HTTP_CODE_200);
                echo json_encode($data);
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