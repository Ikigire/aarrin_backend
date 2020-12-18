<?php
/**
* Controlador de funciones para tabla confimation letters
*
* Manejo de acciones sobre la tabla confimation letters
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todas las cartas de confirmación en modo lista-> url: .../api/v1-2/confimation_letters/listview, metodo: GET, datos-solicitados: {}

* Solicitar las cartas de confirmación de una compañía-> url: .../api/v1-2/confimation_letters/company/:idCompany, metodo: GET, datos-solicitados: {}

* Solicitar la información de una carta de confirmación-> url: .../api/v1-2/confimation_letters/get/:idLetter, metodo: GET, datos-solicitados: {}

* Crear una nueva carta de confirmación-> url: .../api/v1-2/confimation_letters/add, metodo: POST, datos-solicitados: {data: jsonString}

* Editar la información de una carta de confirmación-> url: .../api/v1-2/confimation_letters/edit/:idLetter, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/


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

    $pathToFile = 'https://aarrin.com/mobile/app_resources/confirmation_letters/'.$folder;
    $pathToSave = __DIR__. "/../../app_resources/confirmation_letters/". $folder;

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
            fwrite($htaccess, "Header set Access-Control-Allow-Origin \"aarrin.com\"");
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
 * @var int $idLetter ID de la carta de confirmación
 */
$idLetter = -1;

/**
 * @var mixed $data datos de la letra
 */
$data = array();


switch ($url[5]) {
    /**
     * Solicitar todas las cartas de confirmación en modo lista-> 
     * url: .../api/v1-2/confimation_letters/listview, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString|null Todas los contratos registrados
     */
    case 'listview':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)){
            $query = "SELECT cl.IdLetter, cl.LetterCreationDate, cl.LetterApproved, cl.LetterApprovedDate, cl.LetterClientApprove, cl.LetterClientApproveDate, cl.IsBackToBack, cl.LetterStatus, comp.*, ser.*, sec.* FROM confirmation_letters AS cl JOIN contracts AS con ON cl.IdContract=con.IdContract JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector ORDER BY cl.LetterCreationDate DESC";

            $data = DBManager::query($query);
            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['LetterApproved'] = (bool) $data[$i]['LetterApproved'];
                    $data[$i]['LetterClientApprove'] = (bool) $data[$i]['LetterClientApprove'];
                    $data[$i]['IsBackToBack'] = (bool) $data[$i]['IsBackToBack'];
                }
                header(HTTP_CODE_200);
                echo json_encode($data);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar las cartas de confirmación de una compañía-> 
     * url: .../api/v1-2/confimation_letters/company/:idCompany, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idCompany Id de la compañía
     * @return jsonString Todas los contratos de la compañía
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
            $query = "SELECT cl.IdLetter, cl.LetterCreationDate, cl.LetterApproved, cl.LetterApprovedDate, cl.LetterClientApprove, cl.LetterClientApproveDate, cl.IsBackToBack, cl.LetterStatus, comp.*, ser.*, sec.* FROM confirmation_letters AS cl JOIN contracts AS con ON cl.IdContract=con.IdContract JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector WHERE comp.IdCompany = :idCompany ORDER BY cl.LetterCreationDate DESC";

            $params = array(':idCompany' => $idCompany);

            $data = DBManager::query($query, $params);

            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['LetterApproved'] = (bool) $data[$i]['LetterApproved'];
                    $data[$i]['LetterClientApprove'] = (bool) $data[$i]['LetterClientApprove'];
                    $data[$i]['IsBackToBack'] = (bool) $data[$i]['IsBackToBack'];
                }
                header(HTTP_CODE_200);
                echo json_encode($data);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar la información de una carta de confirmación-> 
     * url: .../api/v1-2/confimation_letters/get/:idLetter, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdLetter ID de la carta de confirmación solicitada, deberá ir al final de la url
     * @return jsonString|null El contrato con ese ID, 
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
        $idLetter = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query ="SELECT * FROM confirmation_letters WHERE IdLetter = :idLetter;";

            $params = array(':idLetter' => $idLetter);

            $data = DBManager::query($query, $params);
            if ($data) {
                $letterData = $data[0];
                $letterData['LetterApproved'] = (bool) $letterData['LetterApproved'];
                $letterData['LetterClientApprove'] = (bool) $letterData['LetterClientApprove'];
                $letterData['IsBackToBack'] = (bool) $letterData['IsBackToBack'];
                $letterData['Auditors'] = json_decode($letterData['Auditors'], true);
                $letterData['TecnicalExperts'] = json_decode($letterData['TecnicalExperts'], true);
                $letterData['Observers'] = json_decode($letterData['Observers'], true);
                header(HTTP_CODE_200);
                echo json_encode($letterData);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Crear una nueva carta de confirmación-> 
     * url: .../api/v1-2/confimation_letters/add, 
     * metodo: POST, 
     * datos-solicitados: {data: jsonString}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data) || !isset($data['IdContract'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');

            $params = array(
                ':idContract'   => $data['IdContract'],
                ':letterCreationDate' => $currentDate
            );

            $query = "INSERT INTO confirmation_letters (IdLetter, IdContract, LetterCreationDate) VALUES(null, :idContract, :letterCreationDate)";

            $response = DBManager::query($query, $params);
            if ($response) {
                header(HTTP_CODE_201);
                echo json_encode(array('IdLetter' => $response));
            }else {
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Editar la información de una carta de confirmación-> 
     * url: .../api/v1-2/confimation_letters/edit/:idLetter, 
     * metodo: PUT, datos-solicitados: {data: jsonString}
     * @param int idLetter ID de la carta de confirmación a editar
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
        $idLetter = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data) || !isset($data['IdContract']) || !isset($data['LetterStatus'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');

            $query = "SELECT com.CompanyName, ser.ServiceStandard FROM contracts AS con JOIN proposals AS pro ON pro.IdProposal = con.IdProposal JOIN days_calculation AS day ON day.IdDayCalculation = pro.IdDayCalculation JOIN applications AS app ON app.IdApp = day.IdApp JOIN companies AS com ON com.IdCompany = app.IdCompany JOIN services AS ser ON ser.IdService = app.IdService WHERE con.IdContract = :idContract";
            
            $auxData = DBManager::query($query, array(':idContract' => $data['IdContract']))[0];

            $cancel = false;

            $folder = base64_encode($auxData['ServiceStandard']) . '/'. base64_encode($auxData['CompanyName']);

            $params = array(
                ':idLetter' => $idLetter,
                ':idContract' => $data['IdContract'],
                ':letterStatus' => $data['LetterStatus']
            );

            $query = "UPDATE confirmation_letters SET IdContract = :idContract, LetterStatus = :letterStatus";

            if ($data['IdLetterReviewer']) {
                $params[':idLetterReviewer'] = $data['IdLetterReviewer'];
                $query .= ", IdLetterReviewer = :idLetterReviewer";
            }
            
            if ($data['LetterApproved']) {
                $params[':letterApproved'] = (int) $data['LetterApproved'];
                $params[':letterApprovedDate'] = $currentDate;
                $query .= ", LetterApproved = :letterApproved, LetterApprovedDate = :letterApprovedDate";
            } else {
                $params[':letterApproved'] = (int) $data['LetterApproved'];
                $query .= ", LetterApproved = :letterApproved, LetterApprovedDate = null";
            }

            if ($data['LetterClientApprove']) {
                $params[':clientApprove'] = (int) $data['LetterClientApprove'];
                $params[':clientApproveDate'] = $currentDate;
                $query .= ", LetterClientApprove = :clientApprove, LetterClientApproveDate = :clientApproveDate";
            } else {
                $params[':clientApprove'] = (int) $data['LetterClientApprove'];
                $query .= ", LetterClientApprove = :clientApprove, LetterClientApproveDate = null";
            }

            if (isset($data['IdAuditLeader'])) {
                $params[':idAuditLeader'] = $data['IdAuditLeader'];
                $query .= ", IdAuditLeader = :idAuditLeader";
            } else {
                $query .= ", IdAuditLeader = null";
            }

            if (isset($data['Auditors'])) {
                $params[':auditors'] = json_encode($data['Auditors']);
                $query .= ", Auditors = :auditors";
            } else {
                $query .= ", Auditors = null";
            }

            if (isset($data['TecnicalExperts'])) {
                $params[':tecnicalExperts'] = json_encode($data['TecnicalExperts']);
                $query .= ", TecnicalExperts = :tecnicalExperts";
            } else {
                $query .= ", TecnicalExperts = null";
            }

            if (isset($data['Observers'])) {
                $params[':observers'] = json_encode($data['Observers']);
                $query .= ", Observers = :observers";
            } else{
                $query .= ", Observers = null";
            }

            if ($data['IsBackToBack']) {
                $params[':isBackToBack'] = (int) $data['IsBackToBack'];
                $query .= ", IsBackToBack = :isBackToBack";
            } else {
                $params[':isBackToBack'] = (int) $data['IsBackToBack'];
                $query .= ", IsBackToBack = :isBackToBack";
            }

            #### Sección para el manejo de archivos del cliente
            if(isset($data['ReviewReport'])){
                $params[':reviewReport'] = strpos($data['ReviewReport'], '://aarrin.com') > 0 ? $data['ReviewReport'] : saveFile($data['ReviewReport'], $folder, base64_encode('Review_Report_by_Admin_'. $data['IdLetter']));
                $query .= ", ReviewReport = :reviewReport";
            } else {
                $query .= ", ReviewReport = null";
            }

            if(isset($data['InternalAuditReport'])){
                $params[':internalAuditReport'] = strpos($data['InternalAuditReport'], '://aarrin.com') > 0 ? $data['InternalAuditReport'] : saveFile($data['InternalAuditReport'], $folder, base64_encode('Internal_Audit_Report_'. $data['IdLetter']));
                $query .= ", InternalAuditReport = :internalAuditReport";
            } else {
                $query .= ", InternalAuditReport = null";
            }

            if(isset($data['ProcessManual'])){
                $params[':processManual'] = strpos($data['ProcessManual'], '://aarrin.com') > 0 ? $data['ProcessManual'] : saveFile($data['ProcessManual'], $folder, base64_encode('Process_Manual_'. $data['IdLetter']));
                $query .= ", ProcessManual = :processManual";
            } else {
                $query .= ", ProcessManual = null";
            }

            if(isset($data['ProcessInteractionMap'])){
                $params[':processInteractionMap'] = strpos($data['ProcessInteractionMap'], '://aarrin.com') > 0 ? $data['ProcessInteractionMap'] : saveFile($data['ProcessInteractionMap'], $folder, base64_encode('Proccess_Iteraction_Map_'. $data['IdLetter']));
                $query .= ", ProcessInteractionMap = :processInteractionMap";
            } else {
                $query .= ", ProcessInteractionMap = null";
            }

            if(isset($data['OperationalControls'])){
                $params[':operationalControls'] = strpos($data['OperationalControls'], '://aarrin.com') > 0 ? $data['OperationalControls'] : saveFile($data['OperationalControls'], $folder, base64_encode('Operational_Controls_'. $data['IdLetter']));
                $query .= ", OperationalControls = :operationalControls";
            } else {
                $query .= ", OperationalControls = null";
            }

            if(isset($data['HazardAnalysis'])){
                $params[':hazardAnalysis'] = strpos($data['HazardAnalysis'], '://aarrin.com') > 0 ? $data['HazardAnalysis'] : saveFile($data['HazardAnalysis'], $folder, base64_encode('Hazard_Analisys_'. $data['IdLetter']));
                $query .= ", HazardAnalysis = :hazardAnalysis";
            } else {
                $query .= ", HazardAnalysis = null";
            }

            $query .= " WHERE IdLetter = :idLetter;";
            if (DBManager::query($query, $params)){
                header(HTTP_CODE_200);
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