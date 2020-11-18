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
            $query ="SELECT * FROM contracts WHERE IdContract = :idContract;";

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
            $path = "https://aarrin.com/mobile/app_resources/contracts/$name";
            if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../app_resources/contracts/$name")){
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
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');

            $params = array(
                ':idProposal' => $data['IdProposal'],
                ':idPersonal' => $data['IdPersonal'],
                ':idService' => $data['IdService'],
                ':creationDate' => $currentDate
            );

            $query = "INSERT INTO contracts (IdContract, IdProposal, IdPersonal, IdService, CreationDate) VALUES(null, :idProposal, :idPersonal, :idService, :creationDate)";

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
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $date = new DateTime("now");
            $currentDate = $date->format('Y-m-d H:i:s');

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
                $params[':ultimateFile'] = $data['UltimateFile'];
                $query .= ", Approve = :approve, ApproveDate = :approveDate, UltimateFile = :ultimateFile";
            } else {
                $params[':approve'] = (int) $data['Approve'];
                $query .= ", Approve = :approve, ApproveDate = null, UltimateFile = null";
            }

            if ($data['ClientApprove']) {
                $params[':clientApprove'] = (int) $data['ClientApprove'];
                $params[':clientApproveDate'] = $currentDate;
                $params[':clientFile'] = $data['ClientFile'];
                $query .= ", ClientApprove = :clientApprove, ClientApproveDate = :clientApproveDate, ClientFile = :clientFile";
            } else {
                $params[':clientApprove'] = (int) $data['ClientApprove'];
                $query .= ", ClientApprove = :clientApprove, ClientApproveDate = null, ClientFile = null";
            }

            #### Sección para el manejo de archivos del cliente
            if(isset($data['ReviewReport'])){
                $params[':reviewReport'] = $data['ReviewReport'];
                $query .= ", ReviewReport = :reviewReport";
            } else {
                $query .= ", ReviewReport = null";
            }

            if(isset($data['InternalAuditReport'])){
                $params[':internalAuditReport'] = $data['InternalAuditReport'];
                $query .= ", InternalAuditReport = :internalAuditReport";
            } else {
                $query .= ", InternalAuditReport = null";
            }

            if(isset($data['ProcessManual'])){
                $params[':processManual'] = $data['ProcessManual'];
                $query .= ", ProcessManual = :processManual";
            } else {
                $query .= ", ProcessManual = null";
            }

            if(isset($data['ProcessInteractionMap'])){
                $params[':processInteractionMap'] = $data['ProcessInteractionMap'];
                $query .= ", ProcessInteractionMap = :processInteractionMap";
            } else {
                $query .= ", ProcessInteractionMap = null";
            }

            if(isset($data['OperationalControls'])){
                $params[':operationalControls'] = $data['OperationalControls'];
                $query .= ", OperationalControls = :operationalControls";
            } else {
                $query .= ", OperationalControls = null";
            }

            if(isset($data['HazardAnalysis'])){
                $params[':hazardAnalysis'] = $data['HazardAnalysis'];
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
            }
        } else {
            header(HTTP_CODE_401);
        }

        break;

    default:
        header(HTTP_CODE_404);
        break;
}