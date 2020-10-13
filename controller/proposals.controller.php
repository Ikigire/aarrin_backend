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

        if (TokenTool::isValid($token)){
            $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.NumberEmployees, app.AppDate, app.AppStatus, dc.*, emp1.EmployeeName + ' ' + emp1.EmployeeLastName AS 'EmployeeCreator', emp1.EmployeePhoto AS 'EmployeeCreatorPhoto', emp2.EmployeeName + ' ' + emp2.EmployeeLastName AS 'EmployeeReviewer', emp2.EmployeePhoto AS 'EmployeeReviewerPhoto' FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN personal AS emp1 ON dc.IdCreatorEmployee = emp1.IdEmployee JOIN personal AS emp2 ON dc.IdReviewerEmployee = emp2.IdEmployee ORDER BY app.AppDate DESC;";

            $data = DBManager::query($query);
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
            $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.NumberEmployees, app.AppDate, app.AppStatus, dc.*, emp1.EmployeeName + ' ' + emp1.EmployeeLastName AS 'EmployeeCreator', emp1.EmployeePhoto AS 'EmployeeCreatorPhoto', emp2.EmployeeName + ' ' + emp2.EmployeeLastName AS 'EmployeeReviewer', emp2.EmployeePhoto AS 'EmployeeReviewerPhoto' FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN personal AS emp1 ON dc.IdCreatorEmployee = emp1.IdEmployee JOIN personal AS emp2 ON dc.IdReviewerEmployee = emp2.IdEmployee WHERE app.IdCompany = :idCompany ORDER BY dc.DayCalculationDate DESC;";

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
            $query = "SELECT * FROM proposals WHERE IdDayCalculation = :idDayCalculation;";

            $data = DBManager::query($query, array(':idDayCalculation' =>$idDayCalculation));

            if ($data) {
                $proposalData = $data[0];
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
            $query = "SELECT * FROM proposals WHERE IdProposal = :idProposal;";

            $data = DBManager::query($query, array(':idProposal' => $idProposal));
            if ($data) {
                $proposalData = $data[0];
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

        if (!isset($_GET['data'])) {
            header(HTTP_CODE_412);
            exit();
        }

        $data = json_decode($_GET['data'], true);

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

            $query .= " WHERE IdProposal = :idProposal";
            
            if (DBManager::query($query, $params)){
                header(HTTP_CODE_205);
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