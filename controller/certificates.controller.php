<?php
/**
* Controlador de funciones para tabla certificates
*
* Manejo de acciones sobre la tabla certificates
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todas los certificados en modo lista-> url: .../api/v1-2/certificates/all, metodo: GET, datos-solicitados: {}

* Solicitar los certificados de una compañía-> url: .../api/v1-2/certificates/company/:idCompany, metodo: GET, datos-solicitados: {}

* Solicitar la información de un certificado-> url: .../api/v1-2/certificates/certificate/:idCertificate, metodo: GET, datos-solicitados: {}

* Cambiar la plantilla-> url: .../api/v1-2/certificates/upload, metodo: POST, datos-solicitados: {upload: File}

* Crear un nuevo certificado-> url: .../api/v1-2/certificates/create, metodo: POST, datos-solicitados: {data: jsonString}

* Editar la información de un certificado-> url: .../api/v1-2/certificates/edit/:idCertificate, metodo: PUT, datos-solicitados: {data: jsonString}

* Solicitar la eliminación de un certificado-> url: .../api/v1-2/certificates/delete/:idCertificate, metodo: DELETE, datos-solicitados: {}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/


/**
 * Método para convertir fechas de otros lenguages a PHP
 * @param string $date Fecha a convertir
 * @return string Retorna la fecha seteada y lista para enviar a la BD
 */
function convertDateTime(string $date){
    $date = (string) $date;
    if (!is_bool(strpos($date, 'T'))){
        $date = str_replace('T', ' ', $date);
    }
    if (!is_bool(strpos($date, '.'))) {
        $date = substr($date, 0, strrpos($date, '.'));
    }

    return $date;
}

/**
 * Función para guardar archivos decodificados en base64
 * @param string $base64 Datos del archivo (debe contener la extensión del archivo)
 * @param string $folder Ruta de la carpeta enla que va a guardar el archivo
 * @param string $name Nombre con el que será guardado el archivo sin extensión
 * @return string|bool Regresa la URL con la que se accede al archivo o false en caso de fallar
 */
function saveFile(string $base64, string $folder, string $name) {
    $extFiles = array(
        'png' => '.png',
        'pdf' => '.pdf',
        'jpeg' => '.jpg'
    );

    $pathToFile = 'https://aarrin.com/mobile/app_resources/certificates/'.$folder;
    $pathToSave = __DIR__. "/../../app_resources/certificates/". $folder;

    $start = strpos($base64, '/');
    $end = strpos($base64, ';');

    $ext = substr($base64, $start+1, $end - $start -1);
    $ext = $extFiles[$ext];
    $name .= $ext;

    $pathToFile .= '/'. $name;

    $start = strpos($base64, ',');
    $data = substr($base64, $start+1);
    try {
        if (!file_exists($pathToSave)) {
            !mkdir($pathToSave, 0777, true);
            $htaccess = fopen($pathToSave. '/.htaccess', 'w+b');
            fwrite($htaccess, "Header set Access-Control-Allow-Origin \"https://aarrin.com\"");
            fflush($htaccess);
            fclose($htaccess);
         }
    
        if(file_put_contents($pathToSave. '/'. $name, base64_decode($data)) === false) {
            $pathToFile = false;
        }
    } catch (\Throwable $th) {
        echo $th;
    }
    return $pathToFile;
}

/**
 * @var int $idContract ID del contrato
 */
$idContract = -1;

/**
 * @var int $idCertificate ID del certificado
 */
$idCertificate = -1;

/**
 * @var mixed $data datos del contrato
 */
$data = array();


switch ($url[5]) {
    /**
     * Solicitar todas los certificados en modo lista-> 
     * url: .../api/v1-2/certificates/all, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString|null Todas los certificados registrados
     */
    case 'all':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)){
            $query = "SELECT cert.IdCertificate, cert.IdContract, cert.CertificateCreationDate, cert.CertificateClientApprove, cert.CertificateClientApproveDate, cert.CertificateStatus, comp.*, ser.*, sec.* FROM certificates AS cert JOIN contracts AS con ON cert.IdContract=con.IdContract JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector ORDER BY cert.CertificateCreationDate DESC";

            $data = DBManager::query($query);
            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['CertificateClientApprove'] = (bool) $data[$i]['CertificateClientApprove'];
                }
                header(HTTP_CODE_200);
                echo json_encode($data);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar los certificados de una compañía-> 
     * url: .../api/v1-2/certificates/company/:idCompany, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idCompany Id de la compañía
     * @return jsonString Todas los certificados de la compañía
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
            $query = "SELECT cert.IdCertificate, cert.IdContract, cert.CertificateCreationDate, cert.CertificateClientApprove, cert.CertificateClientApproveDate, cert.CertificateStatus, comp.*, ser.*, sec.* FROM certificates AS cert JOIN contracts AS con ON cert.IdContract=con.IdContract JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector WHERE comp.IdCompany = :idCompany ORDER BY cert.CertificateCreationDate DESC";

            $params = array(':idCompany' => $idCompany);

            $data = DBManager::query($query, $params);

            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['CertificateClientApprove'] = (bool) $data[$i]['CertificateClientApprove'];
                }
                header(HTTP_CODE_200);
                echo json_encode($data);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar la información de un certificado-> 
     * url: .../api/v1-2/certificates/certificate/:idCertificate, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdCertificate ID del certificado solicitado, deberá ir al final de la url
     * @return jsonString|null El certificado con ese ID, 
     */
    case 'certificate':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idCertificate = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query ="SELECT * FROM certificates WHERE IdCertificate = :idCertificate;";

            $params = array(':idCertificate' => $idCertificate);

            $data = DBManager::query($query, $params);
            if ($data) {
                $certificateData = $data[0];
                $certificateData['CertificateClientApprove'] = (bool) $certificateData['CertificateClientApprove'];
                $certificateData['CertificateData'] = json_decode($certificateData['CertificateData'], true);
                header(HTTP_CODE_200);
                echo json_encode($certificateData);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Cambiar la plantilla-> 
     * url: .../api/v1-2/certificates/upload, 
     * metodo: POST, 
     * datos-solicitados: {upload: File}
     */
    case 'upload':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (!isset($_FILES['upload'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)) {
            $f = $_FILES['upload'];
            $ext = pathinfo($f['name'])['extension'];

            if ($ext !== 'docx'){
                header(HTTP_CODE_412);
                exit();
            }

            $name = 'Certificate_Draft.docx';
            $path = "https://aarrin.com/mobile/app_resources/certificates/template/$name";
            if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../app_resources/certificates/template/$name")){
                header(HTTP_CODE_201);
                echo json_encode(array('url' => $path));
            }else{
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;
    
    
    /**
     * Crear un nuevo certificado-> 
     * url: .../api/v1-2/certificates/create, 
     * metodo: POST, 
     * datos-solicitados: {data: jsonString}
     */
    case 'create':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data) || !isset($data['IdContract']) || !isset($data['CertificateData']) || !isset($data['CertificateDraft'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');

            $query = "SELECT comp.CompanyName, ser.ServiceStandard FROM contracts AS con JOIN proposals AS prop ON con.IdProposal= prop.IdProposal JOIN days_calculation AS dc on prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp on app.IdCompany = comp.IdCompany JOIN services AS ser on app.IdService WHERE con.IdContract = :idContract";
            
            $auxData = DBManager::query($query, array(':idContract' => $data['IdContract']))[0];

            $cancel = false;
            $folder = base64_encode($auxData['ServiceStandard']) . '/'. base64_encode($auxData['CompanyName']);

            $params = array(
                ':idContract'              => $data['IdContract'],
                ':certificateCreationDate' => $currentDate,
                ':certificateData'         => json_encode($data['CertificateData']),
                ':certificateDraft'        => strpos($data['CertificateDraft'], '://aarrin.com') > 0 ? $data['CertificateDraft'] : saveFile($data['CertificateDraft'], $folder, base64_encode('Certificate_Draft_'. $data['IdContract']. $data['CertificateData']['company_name']))
            );

            $initialPart = "INSERT INTO certificates (IdContract, CertificateCreationDate, CertificateData, CertificateDraft";
            $values      = "VALUES (:idContract, :certificateCreationDate, :certificateData, :certificateDraft";

            if(isset($data['CertificateClientApprove']) && $data['CertificateClientApprove']){
                $params[':certificateClientApprove'] = (int) $data['CertificateClientApprove'];
                $params[':CertificateClientApproveDate'] = $currentDate;
                $initialPart .= ", CertificateClientApprove, CertificateClientApproveDate";
                $values      .= ", :certificateClientApprove, :certificateClientApproveDate";
            }

                
                $query .= ", CertificateDraft = :certificateDraft";

            if(isset($data['FinalCertificate'])){
                $params[':finalCertificate'] = strpos($data['FinalCertificate'], '://aarrin.com') > 0 ? $data['FinalCertificate'] : saveFile($data['FinalCertificate'], $folder, base64_encode('Certificate_'. $data['IdContract']. $data['CertificateData']['company_name']));
                $initialPart .= ", FinalCertificate";
                $values      .= ", :finalCertificate";
            } else {
                $query .= ", FinalCertificate = null";
            }

            if(isset($data['CertificateStatus'])){
                $params[':certificateStatus'] = $data['CertificateStatus'];
                $initialPart .= ", CertificateStatus";
                $values      .= ", :certificateStatus";
            }

            $query = $initialPart. ") ". $values. ")";

            $response = DBManager::query($query, $params);
            if ($response) {
                header(HTTP_CODE_201);
                echo json_encode(array('IdCertificate' => $response));
            }else {
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Editar la información de un certificado-> 
     * url: .../api/v1-2/certificates/edit/:idCertificate,
     * metodo: PUT,
     * datos-solicitados: {data: jsonString}
     * @param int idCertificate ID del certificado a editar
     * @return jsonString resultado de la operación
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
        $idCertificate = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data) || !isset($data['IdContract']) || !isset($data['CertificateData']) || !isset($data['CertificateDraft'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');

            $query = "SELECT comp.CompanyName, ser.ServiceStandard FROM contracts AS con JOIN proposals AS prop ON con.IdProposal= prop.IdProposal JOIN days_calculation AS dc on prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp on app.IdCompany = comp.IdCompany JOIN services AS ser on app.IdService WHERE con.IdContract = :idContract";
            
            $auxData = DBManager::query($query, array(':idContract' => $data['IdContract']))[0];

            $cancel = false;
            $folder = base64_encode($auxData['ServiceStandard']) . '/'. base64_encode($auxData['CompanyName']);

            $params = array(
                ':idCertificate'           => $idCertificate,
                ':certificateStatus'       => $data['CertificateStatus'],
                ':certificateData'         => json_encode($data['CertificateData']),
            );

            $query = "UPDATE certificates SET CertificateData = :certificateData, CertificateStatus = :certificateStatus";

            if ($data['CertificateClientApprove']) {
                $params[':certificateClientApprove'] = (int) $data['CertificateClientApprove'];
                $params[':certificateClientApproveDate'] = $currentDate;
                $query .= ", CertificateClientApprove = :certificateClientApprove, CertificateClientApproveDate = :certificateClientApproveDate";
            } else {
                $params[':certificateClientApprove'] = (int) $data['CertificateClientApprove'];
                $query .= ", CertificateClientApprove = :certificateClientApprove, CertificateClientApproveDate = null";
            }

            #### Sección para el manejo de archivos del cliente

            if(isset($data['CertificateDraft'])){
                $params[':certificateDraft'] = strpos($data['CertificateDraft'], '://aarrin.com') > 0 ? $data['CertificateDraft'] : saveFile($data['CertificateDraft'], $folder, base64_encode('Certificate_Draft_'. $data['IdContract']. $data['CertificateData']['company_name']));
                $query .= ", CertificateDraft = :certificateDraft";
            } else {
                $query .= ", CertificateDraft = null";
            }

            if(isset($data['FinalCertificate'])){
                $params[':finalCertificate'] = strpos($data['FinalCertificate'], '://aarrin.com') > 0 ? $data['FinalCertificate'] : saveFile($data['FinalCertificate'], $folder, base64_encode('Certificate_'. $data['IdContract']. $data['CertificateData']['company_name']));
                $query .= ", FinalCertificate = :finalCertificate";
            } else {
                $query .= ", FinalCertificate = null";
            }
            
            $query .= " WHERE IdCertificate  = :idCertificate ;";
            if (DBManager::query($query, $params)){
                header(HTTP_CODE_200);
                echo json_encode(array('outcome' => 'Updated'));
            }else {
                header(HTTP_CODE_409);
                echo $query. "<br><br><br>";
                print_r($params);
            }
        } else {
            header(HTTP_CODE_401);
        }

        break;

        /**
     * Solicitar la eliminación de un certificado-> 
     * url: .../api/v1-2/certificates/delete/:idCertificate, 
     * metodo: DELETE, 
     * datos-solicitados: {}
     * @param int IdCertificate ID del certificado a eliminar, deberá ir al final de la url
     * @return string Resultado de la operación
     */
    case 'delete':
        if ($method !== 'DELETE') {
            header('HTTP/1.1 405 Allow; DELETE');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idCertificate = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query ="DELETE FROM certificates WHERE IdCertificate = :idCertificate;";

            $params = array(':idCertificate' => $idCertificate);

            $result = DBManager::query($query, $params);
            if ($result) {
                header(HTTP_CODE_200);
                echo json_encode(array('result' => 'Deleted'));
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    default:
        header(HTTP_CODE_404);
        break;
}