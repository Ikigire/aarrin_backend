<?php
/**
* Controlador de funciones para tabla proposals
*
* Manejo de acciones sobre la tabla proposals
* Operaciones a utilizar y descripción a utilizar:

* Solicitar todas las propuestas-> url: .../api/v1-2/proposals/getall/, metodo: GET, datos-solicitados: {}

* Solicitar todas las propuestas de una compañía-> url: .../api/v1-2/proposals/company/:idCompany, metodo: GET, datos-solicitados: {}

* Buscar los datos de una propuesta por un cálculo de días-> url: .../api/v1-2/proposals/daycalculation/:idDayCalculation, metodo: GET, datos-solicitados: {}

* Solicitar los datos de una propuesta-> url: .../api/v1-2/proposals/get/:idProposal, metodo: GET, datos-solicitados: {}

* Crear un nueva propuesta-> url: .../api/v1-2/proposals/add, metodo: POST, datos-solicitados: {IdDayCalculation: int, IdProposalCreator: int, TotalInvestment: float, ProposalDetail: jsonString, }

* Editar la información de una propuesta-> url: .../api/v1-2/proposals/edit/:idProposal, metodo: PUT, datos-solicitados: {data: jsonString}
*
* @author Yael Alejandro Santana Michel
* @author ya_el1995@hotmail.com
*
* @package ari-mobile-api
*/

/**
 * @var int $idDayCalculation ID del cálculo de días
 */
$idDayCalculation = -1;

/**
 * @var int $idCompany ID de la compañía
 */
$idCompany = -1;

/**
 * @var int $idProposal ID de la propuesta
 */
$idProposal = -1;

/**
 * @var int $idProposalCreator ID del creador de la propuesta
 */
$idProposalCreator = -1;

/**
 * @var float $totalInvestment Monto total de la inversión
 */
$totalInvestment = -1;

/**
 * @var array $daysCalculationDetail Detalle del cálculo de días
 */
$daysCalculationDetail = array();

/**
 * Función para guardar archivos decodificados en base64
 * @param string $base64 Datos del archivo (debe contener la extensión del archivo)
 * @param string $folder Ruta de la carpeta enla que va a guardar el archivo
 * @param string $name Nombre con el que será guardado el archivo
 * @return string|bool Regresa la URL con la que se accede al archivo o false en caso de fallar
 */
function saveFile(string $base64, string $folder, string $name) {
    $extFiles = array(
        'png' => '.png',
        'pdf' => '.pdf',
        'jpeg' => '.jpg'
    );

    $pathToFile = 'https://aarrin.com/mobile/app_resources/proposals/'.$folder;
    $pathToSave = __DIR__. "/../../app_resources/proposals/". $folder;

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

switch ($url[5]) {
    /**
     * Solicitar todas las propuestas-> 
     * url: .../api/v1-2/proposals/getall/, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @return jsonString|null Todas las propuestas registradas 
     */
    case 'getall':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($_GET['rol'])) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $rol = $_GET['rol'];
            $params = array();

            $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, pr.IdProposal, pr.ProposalStatus, pr.ProposalDate, pr.ProposalExpirationDate, pr.CurrencyType, pr.TotalInvestment, pr.ProposalApproved, pr.ProposalClientApproved FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN proposals AS pr ON pr.IdDayCalculation = dc.IdDayCalculation";

            if ($rol !== 'ADMIN_ROLE' && $rol !== 'SALES_ROLE' && $rol !== 'FINANCE_ROLE') {
                $params[':rol'] = $rol;
                $query .= " WHERE app.AssignedTo = :rol";
            }

            $query .= " ORDER BY app.AppDate DESC;";

            $data = DBManager::query($query, $params);
            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar todas las propuestas de una compañía-> 
     * url: .../api/v1-2/proposals/company/:idCompany, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idCompany ID de la compañía 
     * @return jsonString Todas las propuestas de esa compañía
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
            $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, pr.IdProposal, pr.ProposalStatus, pr.ProposalDate, pr.ProposalExpirationDate, pr.CurrencyType, pr.TotalInvestment, pr.ProposalApproved, pr.ProposalClientApproved FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN proposals AS pr ON pr.IdDayCalculation = dc.IdDayCalculation WHERE app.IdCompany = :idCompany ORDER BY dc.DayCalculationDate DESC;";

            $data = DBManager::query($query, array(':idCompany' =>$idCompany));

            if ($data) {
                header(HTTP_CODE_200);
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Buscar los datos de una propuesta por un cálculo de días-> 
     * url: .../api/v1-2/proposals/daycalculation/:idDayCalculation, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idDayCalculation ID de la cálculo de días 
     * @return jsonString Propuesta para el Cálculo de días con ese ID
     */
    case 'daycalculation':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (!isset($url[6])) {
            header(HTTP_CODE_412);
            exit();
        }
        $idDayCalculation = (int) $url[6];

        if (TokenTool::isValid($token)){
            if (isset($_GET['loadFiles']) && !(bool)$_GET['loadFiles']){
                $query = "SELECT IdProposal, IdDayCalculation, ProposalDate, ProposalExpirationDate, IdProposalCreator, IdProposalReviewer, CurrencyType, ProposalApproved, ProposalApprovedDate, ProposalClientApproved, ProposalClientApprovedDate, TotalInvestment, IssueInitialStage, IssueSurveillance1, IssueSurveillance2, IssueRR, ProposalDetail, LegalRepresentative, ProposalStatus FROM proposals WHERE IdDayCalculation = :idDayCalculation;";
            } else {
                $query = "SELECT * FROM proposals WHERE IdDayCalculation = :idDayCalculation;";
            }

            $data = DBManager::query($query, array(':idDayCalculation' =>$idDayCalculation));

            if ($data) {
                $proposalData = $data[0];
                $proposalData['ProposalApproved'] = (bool) $proposalData['ProposalApproved'];
                $proposalData['ProposalClientApproved'] = (bool) $proposalData['ProposalClientApproved'];
                $proposalData['ProposalDetail'] = json_decode($proposalData['ProposalDetail']);
                header(HTTP_CODE_200);
                echo json_encode($proposalData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Solicitar los datos de una propuesta-> 
     * url: .../api/v1-2/proposals/get/:idProposal, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idProposal ID de la propuesta solicitado, deberá ir al final de la url
     * @return jsonString|null La información de la propuesta con ese ID, 
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
        $idProposal = (int) $url[6];

        if (TokenTool::isValid($token)){
            if (isset($_GET['loadFiles']) && !(bool)$_GET['loadFiles']){
                $query = "SELECT IdProposal, IdDayCalculation, ProposalDate, ProposalExpirationDate, IdProposalCreator, IdProposalReviewer, CurrencyType, ProposalApproved, ProposalApprovedDate, ProposalClientApproved, ProposalClientApprovedDate, TotalInvestment, IssueInitialStage, IssueSurveillance1, IssueSurveillance2, IssueRR, ProposalDetail, LegalRepresentative, ProposalStatus FROM proposals WHERE IdProposal = :idProposal;";
            } else {
                $query = "SELECT * FROM proposals WHERE IdProposal = :idProposal;";
            }
            $data = DBManager::query($query, array(':idProposal' => $idProposal));
            if ($data) {
                $proposalData = $data[0];
                $proposalData['ProposalApproved'] = (bool) $proposalData['ProposalApproved'];
                $proposalData['ProposalClientApproved'] = (bool) $proposalData['ProposalClientApproved'];
                $proposalData['ProposalDetail'] = json_decode($proposalData['ProposalDetail'], true);
                $proposalData['LegalRepresentative'] = json_decode($proposalData['LegalRepresentative'], true);
                header(HTTP_CODE_200);
                echo json_encode($proposalData);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    /**
     * Crear un nueva propuesta-> 
     * url: .../api/v1-2/proposals/add, 
     * metodo: POST, 
     * datos-solicitados: {IdDayCalculation: int, IdProposalCreator: int, TotalInvestment: float, ProposalDetail: jsonString, }
     */
    case 'add':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow: POST');
            exit();
        }

        if (TokenTool::isValid($token)){
            if (isset($_POST['IdDayCalculation']) && isset($_POST['IdProposalCreator']) && isset($_POST['TotalInvestment']) && isset($_POST['ProposalDetail'])) {
                $idDayCalculation = $_POST['IdDayCalculation'];
                $idProposalCreator = $_POST['IdProposalCreator'];
                $totalInvestment = $_POST['TotalInvestment'];
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');
                $date->add(new DateInterval("P3M"));
                $expirationDate = $date->format('Y-m-d H:i:s');
                $proposalDetail = json_decode($_POST['ProposalDetail'], true);

                $params = array(
                    ':idDayCalculation' =>$idDayCalculation,
                    ':idProposalCreator' => $idProposalCreator,
                    ':totalInvestment' => $totalInvestment,
                    ':currentDate' => $currentDate,
                    ':expirationDate' => $expirationDate,
                    ':proposalDetail' => json_encode($proposalDetail),
                );

                $initialPart = "INSERT INTO proposals (IdDayCalculation, IdProposalCreator, TotalInvestment, ProposalDate, ProposalExpirationDate, ProposalDetail";
                $values ="VALUES (:idDayCalculation, :idProposalCreator, :totalInvestment, :currentDate, :expirationDate, :proposalDetail";
                
                if (isset($_POST['CurrencyType'])) {
                    $params[':currencyType'] = $_POST['CurrencyType'];
                    
                    $initialPart .= ", CurrencyType";
                    $values .= ", :currencyType";
                }
                if (isset($_POST['IssueInitialStage'])) {
                    $params[':issueInitialStage'] = $_POST['IssueInitialStage'];
                    
                    $initialPart .= ", IssueInitialStage";
                    $values .= ", :issueInitialStage";
                }
                if (isset($_POST['IssueSurveillance1'])) {
                    $params[':issueSurveillance1'] = $_POST['IssueSurveillance1'];
                    
                    $initialPart .= ", IssueSurveillance1";
                    $values .= ", :issueSurveillance1";
                }
                if (isset($_POST['IssueSurveillance2'])) {
                    $params[':issueSurveillance2'] = $_POST['IssueSurveillance2'];
                    
                    $initialPart .= ", IssueSurveillance2";
                    $values .= ", :issueSurveillance2";
                }
                if (isset($_POST['IssueRR'])) {
                    $params[':issueRR'] = $_POST['IssueRR'];
                    
                    $initialPart .= ", IssueRR";
                    $values .= ", :issueRR";
                }
                if(isset($data['InitialYear'])){
                    $params[':initialYear'] = $data['InitialYear'];
    
                    $initialPart .= ", InitialYear";
                    $values .= ", :initialYear";
                }

                $query = $initialPart. ") ". $values. ")";

                $response = DBManager::query($query, $params);
                if ($response) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdProposal' => $response));
                }else {
                    header(HTTP_CODE_409);
                }
            } else {
                header(HTTP_CODE_412);
            }
            exit();
        } else {
            header(HTTP_CODE_401);
        }
        break;


    /**
     * Editar la información de una propuesta-> 
     * url: .../api/v1-2/proposals/edit/:idProposal, 
     * metodo: PUT, 
     * datos-solicitados: {data: jsonString}
     * @param int idProposal ID de la propuiesta a editar
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
        $idProposal = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data)) {
            header(HTTP_CODE_412);
            exit();
        }

        if (TokenTool::isValid($token)){
            $totalInvestment = $data['TotalInvestment'];
            $proposalDetail = $data['ProposalDetail'];

            $date = new DateTime("now");

            $params = array(
                ':idProposal' => $idProposal,
                ':totalInvestment' => $totalInvestment,
                ':proposalDetail' => json_encode($proposalDetail),
            );

            $query = "UPDATE proposals SET TotalInvestment = :totalInvestment, ProposalDetail = :proposalDetail";

            if (isset($data['ProposalApproved'])) {
                if ($data['ProposalApproved']) {                    
                    $params[':approveDate'] = $date->format('Y-m-d H:i:s');
                    $params[':idProposalReviewer'] = $data['IdProposalReviewer'];

                    $query .= ", IdProposalReviewer = :idProposalReviewer, ProposalApproved = 1, ProposalApprovedDate = :approveDate";
                } else {
                    $query .= ", IdProposalReviewer = null, ProposalApproved = 0, ProposalApprovedDate = null";
                }
            }
            if (isset($data['ProposalClientApproved'])) {
                if ($data['ProposalClientApproved']) {
                    if (strpos($data['File'], '://aarrin.com') <= 0 ) {
                        $auxQuery = "SELECT comp.CompanyName, ser.ServiceStandard FROM proposals AS prop JOIN days_calculation AS dc on prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp on app.IdCompany = comp.IdCompany JOIN services AS ser on app.IdService WHERE prop.IdProposal = :idProposal";
                    
                        $auxData = DBManager::query($auxQuery, array(':idProposal' => $idProposal))[0];

                        $folder = base64_encode($auxData['ServiceStandard']) . '/'. base64_encode($auxData['CompanyName']);

                        $data['File'] = saveFile($data['File'], $folder, base64_encode("Proposal_(Acepted)_". $idProposal));
                    }

                    $params[':file'] = $data['File'];

                    $params[':clientApprovedDate'] = $date->format('Y-m-d H:i:s');

                    $query .= ", ProposalClientApproved = 1, File = :file, ProposalClientApprovedDate = :clientApprovedDate";
                } else {
                    $query .= ", ProposalClientApproved = 0, File = null, ProposalClientApprovedDate = null";
                }
            }
            if (isset($data['CurrencyType'])) {
                $params[':currencyType'] = $data['CurrencyType'];
                $query .= ", CurrencyType = :currencyType";
            }
            if (isset($data['ProposalStatus'])) {
                $params[':proposalStatus'] = $data['ProposalStatus'];
                $query .= ", ProposalStatus = :proposalStatus";
            }
            if (isset($data['IssueInitialStage'])) {
                $params[':issueInitialStage'] = $data['IssueInitialStage'];
                
                $query .= ", IssueInitialStage = :issueInitialStage";
            }
            if (isset($data['IssueSurveillance1'])) {
                $params[':issueSurveillance1'] = $data['IssueSurveillance1'];
                
                $query .= ", IssueSurveillance1 = :issueSurveillance1";
            }
            if (isset($data['IssueSurveillance2'])) {
                $params[':issueSurveillance2'] = $data['IssueSurveillance2'];
                
                $query .= ", IssueSurveillance2 = :issueSurveillance2";
            }
            if (isset($data['IssueRR'])) {
                $params[':issueRR'] = $data['IssueRR'];
                
                $query .= ", IssueRR = :issueRR";
            }
            if(isset($data['LegalRepresentative'])){
                $params[':legalRepresentative'] = json_encode($data['LegalRepresentative']);

                $query .= ", LegalRepresentative = :legalRepresentative";
            }
            if(isset($data['InitialYear'])){
                $params[':initialYear'] = $data['InitialYear'];

                $query .= ", InitialYear = :initialYear";
            }

            $query .= " WHERE IdProposal = :idProposal";
            
            if (DBManager::query($query, $params)){
                header(HTTP_CODE_200);
                echo json_encode(array('result' => 'Updated'));
            }else {
                echo "<br><br><br> $query  <br><br><br>";
                print_r($params);
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