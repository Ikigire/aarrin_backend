<?php
/**
* Controlador de funciones para tabla contacts
*
* Manejo de acciones sobre la tabla contacts
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todos los datos en modo lista-> url: .../api/v1-2/contacts/company/:idCompany, metodo: GET, datos-solicitados: {}

* Solicitar datos completos de un contacto-> url: .../api/v1-2/contacts/get/:idContact, metodo: GET, datos-solicitados. {}

* Solicitar login de un contacto-> url: .../api/v1-2/contacts/login (Este caso no necesitará de un token), metodo: GET, datos-solicitados. {email: string, password: string}

* Registrar un nuevo contacto-> url: .../api/v1-2/contacts/add, metodo: POST, datos-solicitados. {idCompany: int, name: string, phone: string, email: string, charge: strinf, main: bool, password: string}

* Cambiar la foto de perfil del contacto-> url: .../api/v1-2/contacts/edit-photo/:idContact, metodo: POST, datos-solicitados. {email: string, photo: File}

* Editar los datos de un contacto-> url: .../api/v1-2/contacts/edit/:idContact, metodo: PUT, datos-solicitados. {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/


/**
 * @var int $idCompany ID de la compañía a solicitar datos de los contactos
 */
$idCompany = -1;
/**
 * @var int $idContact ID del contacto a solicitar datos
 */
$idContact = -1;
/**
 * @var string $contactName Nombre completo del contacto
 */
$contactName = '';
/**
 * @var string $contactPhone Número telefónico del contacto
 */
$contactPhone = '';
/**
 * @var string $contactEmail Email del contacto que será parte de las credenciales de acceso
 */
$contactEmail = '';
/**
 * @var string $contactCharge Puesto del contacto
 */
$contactCharge = '';

/**
 * @var string $contactPassword Contraseña de acceso a la plataforma
 */
$contactPassword = '';

switch ($url[5]) {
    /**
     * Solicitar todos los datos en modo lista-> 
     * url: .../api/v1-2/contacts/company/:idCompany, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idCompany- ID de la compañía, deberá ir al final de la url
     * @return jsonString Todos los contactos registrados de una compñia
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
        $idCompany = $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, ContactPhoto FROM contacts WHERE IdCompany = :idCompany";
            $data = DBManager::query($query, array(':idCompany' => $idCompany));

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
     * Solicitar datos completos de un contacto-> 
     * url: .../api/v1-2/contacts/get/:idContact, 
     * metodo: GET, 
     * datos-solicitados. {}
     * @param int idContact- ID del empleado, deberá ir al final de la url
     * @return JsonString|null Datos del empleado con el ID correspondiente 
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
        $idContact = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, ContactPhoto FROM contacts WHERE IdContact = :idContact";
            $data = DBManager::query($query, array(':idContact' => $idContact));

            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data[0]);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Solicitar login de un contacto-> 
     * url: .../api/v1-2/contacts/login (Este caso no necesitará de un token), 
     * metodo: GET, 
     * datos-solicitados. {email: string, password: string}
     * @return jsonString|null Token de sesión para el contacto en donde van incluidos sus datos
     */
    case 'login':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow: GET');
            exit();
        }

        if(isset($_GET['email']) && isset($_GET['password'])){
            $contactEmail      = $_GET['email'];
            $contactPassword   = $_GET['password'];

            $params = array(
                ':contactEmail'    => $contactEmail,
                ':contactPassword' => $contactPassword,
            );

            $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, AES_DECRYPT(ContactPassword, '@Company') AS 'ContactPassword', ContactPhoto FROM contacts WHERE ContactEmail = :contactEmail AND AES_DECRYPT(ContactPassword, '@Company') = :contactPassword AND ContactStatus = 'Active';";
            $data = DBManager::query($query, $params);

            if($data){
                $contactData = $data[0];

                $contactData['Token'] = TokenTool::createToken($contactData);
                header(HTTP_CODE_200);
                echo json_encode($contactData);
                exit();
            }else{
                header(HTTP_CODE_204);
                exit();
            }
        }
        
        break;


    /**
     * Registrar un nuevo contacto-> 
     * url: .../api/v1-2/contacts/add, 
     * metodo: POST, 
     * datos-solicitados. {idCompany: int, name: string, phone: string, email: string, charge: strinf, main: bool, password: string}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if(isset($_POST['idCompany']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['charge']) && isset($_POST['main']) && isset($_POST['password'])){
            if (TokenTool::isValid($token)){
                $idCompany       = $_POST['idCompany'];
                $contactName     = $_POST['name'];
                $contactPhone    = $_POST['phone'];
                $contactEmail    = $_POST['email'];
                $contactCharge   = $_POST['charge'];
                $mainContact     = $_POST['main'];
                $contactPassword = $_POST['password'];

                $params = array(
                    ':idCompany'       => $idCompany,
                    ':contactName'     => $contactName,
                    ':contactPhone'    => $contactPhone,
                    ':contactEmail'    => $contactEmail,
                    ':contactCharge'   => $contactCharge,
                    ':contactPassword' => $contactPassword,
                    ':mainContact'     => $mainContact
                );

                if ($mainContact) {
                    //to ensure that the new contact will convert in the only main contact of the company
                    $query = "UPDATE contacts SET MainContact = 0 WHERE IdCompany = :idCompany;";
                    if(!DBManager::query($query, array(':idCompany' => $idCompany))){
                        header("HTTP/1.1 409 Conflict with the Server");
                        exit();
                    }
                }
                $query = "INSERT INTO contacts(IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, ContactPassword) VALUES (:idCompany, :mainContact, :contactName, :contactPhone, :contactEmail, contactCharge, AES_ENCRYPT(:contactPassword, '@Company'));";
                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo array('IdContact' => $response);
                } else {
                    header(HTTP_CODE_409);
                }
                exit();
            }
            else{
                header(HTTP_CODE_401);
            }
            exit();
        }else{
            header(HTTP_CODE_412);
            exit();
        }
        break;


    /**
     * Cambiar la foto de perfil del contacto-> 
     * url: .../api/v1-2/contacts/edit-photo/:idContact, 
     * metodo: POST, 
     * datos-solicitados. {email: string, photo: File}
     * @param int idContact ID del contacto a editar la foto, deberá de ir al final de la URL
     * @return jsonString Los datos actualizados del contacto
     */
    case 'edit-photo':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idContact = (int) $url[6];

        if(isset( $_POST['email']) && isset($_FILES['photo'])){
            if (TokenTool::isValid($token)){
                $contactEmail = $_POST['email'];

                $f = $_FILES['photo'];
                $name = "profile_$idContact.Image-$contactEmail.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png";
                $path = "https://aarrin.com/mobile/app_resources/contacts/$name";

                if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../../../app_resources/contacts/$name")){
                    $query = "UPDATE contacts SET ContactPhoto = :path WHERE IdContact = :idContact";
                    $response = DBManager::query($query, array(':path' => $path, ':idContact' => $idContact));

                    if ($response){
                        $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, AES_DECRYPT(ContactPassword, '@Company') AS 'ContactPassword', ContactPhoto FROM contacts WHERE IdContact = :idContact;";
                        $data = DBManager::query($query, array(':idContact' => $idContact));
                        $contactData = $data[0];

                        $contactData['Token'] = TokenTool::createToken($contactData);
                        header(HTTP_CODE_205);
                        echo json_encode($contactData); //Return the data
                    } else {
                        header(HTTP_CODE_409);//info for the client
                    }
                } else {
                    header(HTTP_CODE_409);
                }
            }
            else{
                header(HTTP_CODE_401);
            }
            exit();
        }else{
            header(HTTP_CODE_412);
            exit();
        }
        break;

    /**
     * Editar los datos de un contacto-> 
     * url: .../api/v1-2/contacts/edit/:idContact, 
     * metodo: PUT, 
     * datos-solicitados. {data: jsonString} deberá ir en el cuerpo de la solicitud
     * @param int idContact ID del contacto, deberá ir al final de la url
     * @return jsonString Datos actualizados del empleado
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
        $idContact = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $contactName = $data['ContactName'];
            $contactPhone = $data['ContactPhone'];
            $contactEmail = $data['ContactEmail'];
            $contactCharge = $data['ContactCharge'];
            $idCompany = $data['IdCompany'];

            $params = array(
                ':contactName'     => $contactName,
                ':contactPhone'    => $contactPhone,
                ':contactEmail'    => $contactEmail,
                ':contactCharge'   => $contactCharge,
                ':idContact'       => $idContact
            );

            $updateQuery = "UPDATE contacts SET ContactName = :contactName, ContactPhone = :contactPhone, ContactEmail = :contactEmail, ContactCharge = :contactCharge";

            $mainContact = 0;
            if (isset($data['MainContact'])) {
                $mainContact = $data['MainContact'] ? 1 : 0;
                $updateQuery = $updateQuery. ", MainContact = :mainContact";
                $params[':mainContact'] = $mainContact;
            }
            if (isset($data['ContactPassword']) && trim($data['ContactPassword']) !== '') {
                $contactPassword = $data['ContactPassword'];
                $updateQuery = $updateQuery. ", ContactPassword = AES_ENCRYPT(:contactPassword, '@Company')";
                $params[':contactPassword'] = $contactPassword;
            }

            if ($mainContact === 1) {
                $query = "UPDATE contacts SET MainContact = 0 WHERE IdCompany = :idCompany;";
                if(!DBManager::query($query, array(':idCompany' => $idCompany))) { 
                    header(HTTP_CODE_409);
                    exit();
                }
            }

            $updateQuery = $updateQuery. " WHERE IdContact = :idContact;";

            if (DBManager::query($updateQuery, $params)){
                $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, AES_DECRYPT(ContactPassword, '@Company') AS 'ContactPassword', ContactPhoto FROM contacts WHERE IdContact = :idContact";
                $data = DBManager::query($query, array(':idContact' => $idContact));

                if($data){
                    $contactData = $data[0];

                    $contactData['Token'] = TokenTool::createToken($contactData);
                    header(HTTP_CODE_200);
                    echo json_encode($contactData);
                }
            }else{
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