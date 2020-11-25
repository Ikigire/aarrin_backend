<?php
/**
* Controlador de funciones para tabla contracts
*
* Manejo de acciones sobre la tabla contracts
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todas los contatos en modo lista-> url: .../api/v1-2/contracts/listview, metodo: GET, datos-solicitados: {}

* Solicitar los contratos de una compañía-> url: .../api/v1-2/contracts/company/:idCompany, metodo: GET, datos-solicitados: {}

* Solicitar la información de un contrato-> url: .../api/v1-2/contracts/get/:idContract, metodo: GET, datos-solicitados: {}

* Crear un nuevo contrato-> url: .../api/v1-2/contracts/add, metodo: POST, datos-solicitados: {data: jsonString}

* Editar la información de un contrato-> url: .../api/v1-2/contracts/edit/:idContract, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/


/**
 * Función para guardar archivos decodificados en base64
 * @param string $base64 Datos del archivo (debe contener la extensión del archivo)
 * @param string $path Ruta de la carpeta enla que va a guardar el archivo
 * @param string $name Nombre con el que será guardado el archivo
 * @return string|bool Regresa la URL con la que se accede al archivo o false en caso de fallar
 */
function saveFile(string $base64, string $path, string $name) {
    $extFiles = array(
        'png' => '.png',
        'pdf' => '.pdf',
        'jpeg' => '.jpg'
    );

    $pathToFile = 'https://aarrin.com/mobile/app_resources/contracts/'.$path;
    $pathToSave = __DIR__. "/../../app_resources/contracts/". $path;

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
 * @var int $idCompany ID de la compañia
 */
$idCompany = -1;

/**
 * @var mixed $data datos del contrato
 */
$data = array();


switch ($url[5]) {
    /**
     * Solicitar todas los contatos en modo lista-> 
     * url: .../api/v1-2/contracts/listview, 
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
            $query = "SELECT con.*, prop.CurrencyType, prop.TotalInvestment, comp.*, ser.*, sec.* FROM contracts AS con JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector ORDER BY con.CreationDate DESC";

            $data = DBManager::query($query);
            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['Approve'] = (bool) $data[$i]['Approve'];
                    $data[$i]['ClientApprove'] = (bool) $data[$i]['ClientApprove'];
                }
                header(HTTP_CODE_200);
                echo json_encode($data);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar los contratos de una compañía-> 
     * url: .../api/v1-2/contracts/company/:idCompany, 
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
            $query = "SELECT con.*, prop.CurrencyType, prop.TotalInvestment, comp.*, ser.*, sec.* FROM contracts AS con JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector WHERE comp.IdCompany = :idCompany ORDER BY con.CreationDate DESC";

            $params = array(':idCompany' => $idCompany);

            $data = DBManager::query($query, $params);

            if ($data) {
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['Approve'] = (bool) $data[$i]['Approve'];
                    $data[$i]['ClientApprove'] = (bool) $data[$i]['ClientApprove'];
                }
                header(HTTP_CODE_200);
                echo json_encode($data);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar la información de un contrato-> 
     * url: .../api/v1-2/contracts/get/:idContract, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int IdContract ID del contrato solicitada, deberá ir al final de la url
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
        $idContract = (int) $url[6];

        if (TokenTool::isValid($token)){
            if (isset($_GET['loadFiles']) && !(bool)$_GET['loadFiles']){
                $query = "SELECT IdContract, IdProposal, IdPersonal, IdService, CreationDate, Approve, ApproveDate, UltimateFile, ClientApprove, ClientApproveDate, ClientFile, ContractStatus FROM contracts WHERE IdContract = :idContract;;";
            } else {
                $query ="SELECT * FROM contracts WHERE IdContract = :idContract;";
            }

            $params = array(':idContract' => $idContract);

            $data = DBManager::query($query, $params);
            if ($data) {
                $contractData = $data[0];
                $contractData['Approve'] = (bool) $contractData['Approve'];
                $contractData['ClientApprove'] = (bool) $contractData['ClientApprove'];
                header(HTTP_CODE_200);
                echo json_encode($contractData);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Crear un nuevo contrato-> 
     * url: .../api/v1-2/contracts/add, 
     * metodo: POST, 
     * datos-solicitados: {data: jsonString}
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

            $name = 'contract.docx';
            $path = "https://aarrin.com/mobile/app_resources/contracts/template/$name";
            if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../app_resources/contracts/template/$name")){
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
     * Crear un nuevo contrato-> 
     * url: .../api/v1-2/contracts/add, 
     * metodo: POST, 
     * datos-solicitados: {data: jsonString}
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data) || !isset($data['IdProposal']) || !isset($data['IdPersonal']) || !isset($data['IdService']) || !isset($data['File'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $query = "SELECT comp.CompanyName, ser.ServiceStandard FROM proposals AS prop JOIN days_calculation AS dc on prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp on app.IdCompany = comp.IdCompany JOIN services AS ser on app.IdService WHERE prop.IdProposal = :idProposal";
            
            $auxData = DBManager::query($query, array(':idProposal' => $data['IdProposal']))[0];

            $cancel = false;
            $folder = str_replace(' ', '_', $auxData['ServiceStandard']) . '/'. str_replace(' ', '_', $auxData['CompanyName']);
            $path = saveFile($data['File'], $folder, base64_encode('Contract'));
            if ($path === false){
                $cancel = true;
            }

            if($cancel){
                header(HTTP_CODE_409);
                exit();
            }
            
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');

            $params = array(
                ':idProposal'   => $data['IdProposal'],
                ':idPersonal'   => $data['IdPersonal'],
                ':idService'    => $data['IdService'],
                ':creationDate' => $currentDate,
                ':file'         => $path
            );

            $query = "INSERT INTO contracts (IdContract, IdProposal, IdPersonal, IdService, CreationDate, File) VALUES(null, :idProposal, :idPersonal, :idService, :creationDate, :file)";

            $response = DBManager::query($query, $params);
            if ($response) {
                header(HTTP_CODE_201);
                echo json_encode(array('IdContract' => $response));
            }else {
                header(HTTP_CODE_409);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Editar la información de un contrato-> 
     * url: .../api/v1-2/contracts/edit/:idContract, 
     * metodo: PUT, 
     * datos-solicitados: {data: jsonString}
     * @param int idcontract ID del contrato a editar
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
        $idContract = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data) || !isset($data['IdProposal']) || !isset($data['IdPersonal']) || !isset($data['IdService']) || !isset($data['ContractStatus'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');

            $query = "SELECT comp.CompanyName, ser.ServiceStandard FROM proposals AS prop JOIN days_calculation AS dc on prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp on app.IdCompany = comp.IdCompany JOIN services AS ser on app.IdService WHERE prop.IdProposal = :idProposal";
            $auxData = DBManager::query($query, array(':idProposal' => $data['IdProposal']))[0];

            $folder = str_replace(' ', '_', $auxData['ServiceStandard']) . '/'. str_replace(' ', '_', $auxData['CompanyName']);

            $params = array(
                ':idContract' => $idContract,
                ':idProposal' => $data['IdProposal'],
                ':idPersonal' => $data['IdPersonal'],
                ':idService' => $data['IdService'],
                ':contractStatus' => $data['ContractStatus']
            );

            $query = "UPDATE contracts SET IdProposal = :idProposal, IdPersonal = :idPersonal, IdService = :idService, ContractStatus = :contractStatus";

            if ($data['Approve']) {
                $params[':approve'] = (int) $data['Approve'];
                $params[':approveDate'] = $currentDate;
                $params[':ultimateFile'] = strpos($data['UltimateFile'], '://aarrin.com') >0 ? $data['UltimateFile'] : saveFile($data['UltimateFile'], $folder, base64_encode('Contract(Final)(Approved)'));
                $query .= ", Approve = :approve, ApproveDate = :approveDate, UltimateFile = :ultimateFile";
            } else {
                $params[':approve'] = (int) $data['Approve'];
                $query .= ", Approve = :approve, ApproveDate = null, UltimateFile = null";
            }

            if ($data['ClientApprove']) {
                $params[':clientApprove'] = (int) $data['ClientApprove'];
                $params[':clientApproveDate'] = $currentDate;
                $params[':clientFile'] = strpos($data['ClientFile'], '://aarrin.com') >0 ? $data['ClientFile'] : saveFile($data['ClientFile'], $folder, base64_encode('Contract(Client_Approved)'));
                $query .= ", ClientApprove = :clientApprove, ClientApproveDate = :clientApproveDate, ClientFile = :clientFile";
            } else {
                $params[':clientApprove'] = (int) $data['ClientApprove'];
                $query .= ", ClientApprove = :clientApprove, ClientApproveDate = null, ClientFile = null";
            }

            #### Sección para el manejo de archivos del cliente
            if(isset($data['File'])){
                $params[':file'] = strpos($data['File'], '://aarrin.com') > 0 ? $data['File'] : saveFile($data['File'], $folder, base64_encode('Contract'));
                $query .= ", File = :file";
            } else {
                $query .= ", File = null";
            }

            if(isset($data['LegalRepresentativeID'])){
                $params[':legalRepresentativeID'] = strpos($data['LegalRepresentativeID'], '://aarrin.com') > 0 ? $data['LegalRepresentativeID'] : saveFile($data['LegalRepresentativeID'], $folder, base64_encode('Legal_Representative_ID'));
                $query .= ", LegalRepresentativeID = :legalRepresentativeID";
            } else {
                $query .= ", LegalRepresentativeID = null";
            }

            if(isset($data['RFCFile'])){
                $params[':rfcFile'] = strpos($data['RFCFile'], '://aarrin.com') > 0 ? $data['RFCFile'] : saveFile($data['RFCFile'], $folder, base64_encode('RFC_copy'));
                $query .= ", RFCFile = :rfcFile";
            } else {
                $query .= ", RFCFile = null";
            }

            if(isset($data['OriginAccount'])){
                $params[':originAccount'] = strpos($data['OriginAccount'], '://aarrin.com') > 0 ? $data['OriginAccount'] : saveFile($data['OriginAccount'], $folder, base64_encode('Account_data'));
                $query .= ", OriginAccount = :originAccount";
            } else {
                $query .= ", OriginAccount = null";
            }

            if(isset($data['ProofAddress'])){
                $params[':proofAddress'] = strpos($data['ProofAddress'], '://aarrin.com') > 0 ? $data['ProofAddress'] : saveFile($data['ProofAddress'], $folder, base64_encode('Proof_address'));
                $query .= ", ProofAddress = :proofAddress";
            } else {
                $query .= ", ProofAddress = null";
            }

            if(isset($data['PurchaseOrder'])){
                $params[':purchaseOrder'] = strpos($data['PurchaseOrder'], '://aarrin.com') > 0 ? $data['PurchaseOrder'] : saveFile($data['PurchaseOrder'], $folder, base64_encode('Purchase_Order'));
                $query .= ", PurchaseOrder = :purchaseOrder";
            } else {
                $query .= ", PurchaseOrder = null";
            }

            if(isset($data['ReviewReport'])){
                $params[':reviewReport'] = strpos($data['ReviewReport'], '://aarrin.com') > 0 ? $data['ReviewReport'] : saveFile($data['ReviewReport'], $folder, base64_encode('Review_Report_by_Admin'));
                $query .= ", ReviewReport = :reviewReport";
            } else {
                $query .= ", ReviewReport = null";
            }

            if(isset($data['InternalAuditReport'])){
                $params[':internalAuditReport'] = strpos($data['InternalAuditReport'], '://aarrin.com') > 0 ? $data['InternalAuditReport'] : saveFile($data['InternalAuditReport'], $folder, base64_encode('Internal_Audit_Report'));
                $query .= ", InternalAuditReport = :internalAuditReport";
            } else {
                $query .= ", InternalAuditReport = null";
            }

            if(isset($data['ProcessManual'])){
                $params[':processManual'] = strpos($data['ProcessManual'], '://aarrin.com') > 0 ? $data['ProcessManual'] : saveFile($data['ProcessManual'], $folder, base64_encode('Process_Manual'));
                $query .= ", ProcessManual = :processManual";
            } else {
                $query .= ", ProcessManual = null";
            }

            if(isset($data['ProcessInteractionMap'])){
                $params[':processInteractionMap'] = strpos($data['ProcessInteractionMap'], '://aarrin.com') > 0 ? $data['ProcessInteractionMap'] : saveFile($data['ProcessInteractionMap'], $folder, base64_encode('Proccess_Iteraction_Map'));
                $query .= ", ProcessInteractionMap = :processInteractionMap";
            } else {
                $query .= ", ProcessInteractionMap = null";
            }

            if(isset($data['OperationalControls'])){
                $params[':operationalControls'] = strpos($data['OperationalControls'], '://aarrin.com') > 0 ? $data['OperationalControls'] : saveFile($data['OperationalControls'], $folder, base64_encode('Operational_Controls'));
                $query .= ", OperationalControls = :operationalControls";
            } else {
                $query .= ", OperationalControls = null";
            }

            if(isset($data['HazardAnalysis'])){
                $params[':hazardAnalysis'] = strpos($data['HazardAnalysis'], '://aarrin.com') > 0 ? $data['HazardAnalysis'] : saveFile($data['HazardAnalysis'], $folder, base64_encode('Hazard_Analisys'));
                $query .= ", HazardAnalysis = :hazardAnalysis";
            } else {
                $query .= ", HazardAnalysis = null";
            }

            $query .= " WHERE IdContract = :idContract;";
            if (DBManager::query($query, $params)){
                header(HTTP_CODE_200);
                echo json_encode(array('result' => 'Updated'));
            }else {
                header(HTTP_CODE_409);
                echo "<p>$query</p>";
                print_r($params);
            }
        } else {
            header(HTTP_CODE_401);
        }

        break;

    default:
        header(HTTP_CODE_404);
        break;
}