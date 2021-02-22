<?php
/**
* Controlador de funciones para tabla audit_report
*
* Manejo de acciones sobre la tabla audit_report
* Operaciones a utilizar y descripción a utilizar:

* Solicitar la información de reportes de auditoría por su plan de auditoría-> url: .../api/v1-2/audit_reports/audit_plan/:idAuditPlan, metodo: GET, datos-solicitados: {}

* Solicitar la información de un reporte de auditoría por su ID-> url: .../api/v1-2/audit_reports/audit_report/:idAuditReport, metodo: GET, datos-solicitados: {}

* Solicitar la información de un reporte de auditoría por su Contrato y Etapa de auditoría-> url: .../api/v1-2/audit_reports/contract_stage/:idContract/:auditStage, metodo: GET, datos-solicitados: {}

* Registrar un nuevo reporte de auditoría-> url: .../api/v1-2/audit_reports/create, metodo: POST, datos-solicitados: {auditReport: jsonString}

* Editar los datos de un reporte de auditoría ya registrado-> url: .../api/v1-2/audit_reports/edit/:idAuditReport, metodo: PUT, datos-solicitados: {auditReport: jsonString}

* Eliminar un reporte de auditoría-> url: .../api/v1-2/audit_reports/delete/:idAuditReport, metodo: DELETE, datos-solicitados: {}

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
        'png'  => '.png',
        'pdf'  => '.pdf',
        'jpeg' => '.jpg',
        'zip'  => '.zip'
    );

    $pathToFile = 'https://aarrin.com/mobile/app_resources/audit_plans/non_conformities/'.$folder;
    $pathToSave = __DIR__. "/../../app_resources/audit_plans/non_conformities/". $folder;

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
 * @var int $idAuditReport ID del reporte de auditoría
 */
$idAuditReport = 0;

/**
 * @var int $idAuditPlan ID de plan de auditoría
 * */
$idAuditPlan = 0;


switch ($url[5]) {
     /**
     * trae todos la lista de audit report
     * url: .../api/v1-2/,
     * metodo: GET
     */
    case 'getall':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if (TokenTool::isValid($token)) {
            $query = "SELECT ar.IdAuditReport, ap.IdAuditPlan, con.IdContract, cl.IdLetter, ar.ActionPlanDueDate, ar.Acceptance, ar.AuditReportCreationDate, ar.AuditReportStatus, cl.Auditors, cl.TecnicalExperts, comp.*, ser.*, sec.* FROM audit_plan AS ap JOIN confirmation_letters AS cl ON ap.IdLetter = cl.IdLetter JOIN contracts AS con ON cl.IdContract=con.IdContract JOIN proposals AS prop ON con.IdProposal = prop.IdProposal JOIN days_calculation AS dc ON prop.IdDayCalculation = dc.IdDayCalculation JOIN applications AS app on dc.IdApp = app.IdApp JOIN companies AS comp ON app.IdCompany = comp.IdCompany JOIN services AS ser ON app.IdService = ser.IdService JOIN sectors AS sec ON app.IdSector = sec.IdSector JOIN audit_report AS ar on ar.IdAuditPlan = ap.IdAuditPlan ORDER BY ap.AuditPlanCreationDate DESC";
            $data = DBManager::query($query);

            if ($data) {
                header(HTTP_CODE_200);
                for ($i=0; $i < count($data); $i++) { 
                    $data[$i]['IdAuditReport']           = (int) $data[$i]['IdAuditReport'];
                    $data[$i]['IdAuditPlan']           = (int) $data[$i]['IdAuditPlan'];
                    $data[$i]['IdLetter']              = (int) $data[$i]['IdLetter'];
                    $data[$i]['AuditPlanApproved']     = (bool) $data[$i]['AuditPlanApproved'];
                    $data[$i]['Acceptance']     = json_decode($data[$i]['Acceptance']);
                    $data[$i]['Auditors']     = json_decode($data[$i]['Auditors']);
                    $data[$i]['TecnicalExperts']     = json_decode($data[$i]['TecnicalExperts']);
                }
                echo json_encode($data);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    
    /**
     * Solicitar la información de reportes de auditoría por su plan de auditoría-> 
     * url: .../api/v1-2/audit_reports/audit_plan/:idAuditPlan, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idAuditplan ID del plan de auditoría, deberá ir al final de de la URL
     * @return jsonString|null El reporte de auditoría asociado a ese polan de auditoría
     */
    case 'audit_plan':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if(!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }
        $idAuditPlan = (int) $url[6];

        if (TokenTool::isValid($token)){
            $query = "SELECT * FROM audit_report Where IdAuditPlan = :idAuditPlan LIMIT 1";

            $data = DBManager::query($query, array(':idAuditPlan' => $idAuditPlan));

            if ($data) {
                $auditReport = $data[0];
                $auditReport['IdAuditReport'] = (int) $auditReport['IdAuditReport'];
                $auditReport['IdAuditPlan'] = (int) $auditReport['IdAuditPlan'];
                $auditReport['NonConformities'] = json_decode($auditReport['NonConformities'], true);
                $auditReport['AreasOfConcern'] = json_decode($auditReport['AreasOfConcern'], true);
                $auditReport['AuditObjetives'] = json_decode($auditReport['AuditObjetives'], true);
                $auditReport['ExtraAuditObjetives'] = json_decode($auditReport['ExtraAuditObjetives'], true);
                $auditReport['Acceptance'] = json_decode($auditReport['Acceptance'], true);
                $auditReport['AuditProgram'] = json_decode($auditReport['AuditProgram'], true);
                $auditReport['CompanyRepresentative'] = json_decode($auditReport['CompanyRepresentative'], true);
                $auditReport['ContinueNextStage'] = (bool) $auditReport['ContinueNextStage'];
                $auditReport['ContinueAfterIssuesSolved'] = (bool) $auditReport['ContinueAfterIssuesSolved'];
                $auditReport['ClosureAuditNeeded'] = (bool) $auditReport['ClosureAuditNeeded'];
                $auditReport['RestartCertificationProcess'] = (bool) $auditReport['RestartCertificationProcess'];

                header(HTTP_CODE_200);
                echo json_encode($auditReport);
            } else {
                header(HTTP_CODE_204);
            }
        } else {
            header(HTTP_CODE_401);
        }
        break;

    
    /**
     * Solicitar la información de un reporte de auditoría por su ID-> 
     * url: .../api/v1-2/audit_reports/audit_report/:idAuditReport, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idAuditplan ID del plan de auditoría, deberá ir al final de de la URL
     * @return jsonString|null El reporte de auditoría asociado a ese polan de auditoría
     */
    case 'audit_report':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if(!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }
        $idAuditReport = (int) $url[6];

        if(TokenTool::isValid($token)){
            $query = "SELECT * FROM audit_report Where IdAuditReport = :idAuditReport LIMIT 1";

            $data = DBManager::query($query, array(':idAuditReport' => $idAuditReport));

            if ($data) {
                $auditReport = $data[0];
                $auditReport['IdAuditReport'] = (int) $auditReport['IdAuditReport'];
                $auditReport['IdAuditPlan'] = (int) $auditReport['IdAuditPlan'];
                $auditReport['NonConformities'] = json_decode($auditReport['NonConformities'], true);
                $auditReport['AreasOfConcern'] = json_decode($auditReport['AreasOfConcern'], true);
                $auditReport['AuditObjetives'] = json_decode($auditReport['AuditObjetives'], true);
                $auditReport['ExtraAuditObjetives'] = json_decode($auditReport['ExtraAuditObjetives'], true);
                $auditReport['Acceptance'] = json_decode($auditReport['Acceptance'], true);
                $auditReport['AuditProgram'] = json_decode($auditReport['AuditProgram'], true);
                $auditReport['CompanyRepresentative'] = json_decode($auditReport['CompanyRepresentative'], true);
                $auditReport['ContinueNextStage'] = (bool) $auditReport['ContinueNextStage'];
                $auditReport['ContinueAfterIssuesSolved'] = (bool) $auditReport['ContinueAfterIssuesSolved'];
                $auditReport['ClosureAuditNeeded'] = (bool) $auditReport['ClosureAuditNeeded'];
                $auditReport['RestartCertificationProcess'] = (bool) $auditReport['RestartCertificationProcess'];

                header(HTTP_CODE_200);
                echo json_encode($auditReport);
            } else {
                header(HTTP_CODE_204);
            }
        } else{
            header(HTTP_CODE_401);
        }

        break;

    /**
     * Solicitar la información de un reporte de auditoría por su Contrato y Etapa de auditoría-> 
     * url: .../api/v1-2/audit_reports/contract_stage/:idContract/:auditStage, 
     * metodo: GET, 
     * datos-solicitados: {}
     * @param int idContract ID del contrato al que pertenece el reporte de auditoría
     * @param int auditStage Número de la etapa que se busca
     * @return jsonString|null Respuesta con los datos solicitados
     */
    case 'contract_stage':
        if ($method !== 'GET') {
            header('HTTP/1.1 405 Allow; GET');
            exit();
        }

        if(!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }
        $idContract = (int) $url[6];

        if(!isset($url[7])){
            header(HTTP_CODE_412);
            exit();
        }
        $auditStage = (int) $url[7];

        if(TokenTool::isValid($token)){
            $query = "SELECT ar.* FROM audit_report AS ar JOIN audit_plan AS ap on ar.IdAuditPlan = ap.IdAuditPlan JOIN confirmation_letters AS cl ON ap.IdLetter = cl.IdLetter JOIN contracts AS co ON cl.IdContract = co.IdContract Where co.IdContract = :idContract AND cl.AuditStage = :auditStage LIMIT 1";

            $data = DBManager::query($query, array(':idContract' => $idContract, ':auditStage' => $auditStage));

            if ($data) {
                $auditReport = $data[0];
                $auditReport['IdAuditReport'] = (int) $auditReport['IdAuditReport'];
                $auditReport['IdAuditPlan'] = (int) $auditReport['IdAuditPlan'];
                $auditReport['NonConformities'] = json_decode($auditReport['NonConformities'], true);
                $auditReport['AreasOfConcern'] = json_decode($auditReport['AreasOfConcern'], true);
                $auditReport['AuditObjetives'] = json_decode($auditReport['AuditObjetives'], true);
                $auditReport['ExtraAuditObjetives'] = json_decode($auditReport['ExtraAuditObjetives'], true);
                $auditReport['Acceptance'] = json_decode($auditReport['Acceptance'], true);
                $auditReport['AuditProgram'] = json_decode($auditReport['AuditProgram'], true);
                $auditReport['CompanyRepresentative'] = json_decode($auditReport['CompanyRepresentative'], true);
                $auditReport['ContinueNextStage'] = (bool) $auditReport['ContinueNextStage'];
                $auditReport['ContinueAfterIssuesSolved'] = (bool) $auditReport['ContinueAfterIssuesSolved'];
                $auditReport['ClosureAuditNeeded'] = (bool) $auditReport['ClosureAuditNeeded'];
                $auditReport['RestartCertificationProcess'] = (bool) $auditReport['RestartCertificationProcess'];

                header(HTTP_CODE_200);
                echo json_encode($auditReport);
            } else {
                header(HTTP_CODE_204);
            }
        } else{
            header(HTTP_CODE_401);
        }

        break;
    
    /**
     * Registrar un nuevo reporte de auditoría-> 
     * url: .../api/v1-2/audit_reports/create, 
     * metodo: POST, 
     * datos-solicitados: {auditReport: jsonString}
     * @return JsonString respuesta de resultado de la acción
     */
    case 'create':
        if ($method !== 'POST') {
            header('HTTP/1.1 405 Allow; POST');
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if ($data && isset($data['IdAuditPlan']) && isset($data['CompanyRepresentative']) && isset($data['AuditObjetives']) && isset($data['Acceptance'])) {
            if (TokenTool::isValid($token)) {
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');

                $params = array(
                    ':idAuditPlan'             => $data['IdAuditPlan'],
                    ':auditReportCreationDate' => $currentDate,
                    ':companyRepresentative'   => json_encode($data['CompanyRepresentative']),
                    ':auditObjetives'          => json_encode($data['AuditObjetives']),
                    ':acceptance'              => json_encode($data['Acceptance']),
                );

                $initPart = "INSERT INTO audit_report (IdAuditReport, IdAuditPlan, AuditReportCreationDate, CompanyRepresentative, AuditObjetives, Acceptance";
                $valPart  = "VALUES (null, :idAuditPlan, :auditReportCreationDate, :companyRepresentative, :auditObjetives, :acceptance";
                
                if (isset($data['JustificationNotAllShiftAudited'])) {
                    $params[':justificationNotAllShiftAudited'] = $data['JustificationNotAllShiftAudited'];
                    $initPart .= ", JustificationNotAllShiftAudited";
                    $valPart  .= ", :justificationNotAllShiftAudited";
                }

                if (isset($data['PossibleNonConformities'])) {
                    $params[':PossibleNonConformities'] = $data['PossibleNonConformities'];
                    $initPart .= ", PossibleNonConformities";
                    $valPart  .= ", :PossibleNonConformities";
                }

                if (isset($data['AreasOfConcern'])) {
                    $params[':areasOfConcern'] = json_encode($data['AreasOfConcern']);
                    $initPart .= ", AreasOfConcern";
                    $valPart  .= ", :areasOfConcern";
                }

                if (isset($data['PositiveIssues'])) {
                    $params[':positiveIssues'] = $data['PositiveIssues'];
                    $initPart .= ", PositiveIssues";
                    $valPart  .= ", :positiveIssues";
                }

                if (isset($data['OportunitiesToImprove'])) {
                    $params[':oportunitiesToImprove'] = $data['OportunitiesToImprove'];
                    $initPart .= ", OportunitiesToImprove";
                    $valPart  .= ", :oportunitiesToImprove";
                }

                if (isset($data['NonConformities'])) {
                    $params[':nonConformities'] = json_encode($data['NonConformities']);
                    $initPart .= ", NonConformities";
                    $valPart  .= ", :nonConformities";

                    $params[':actionPlanDueDate'] = convertDateTime($data['ActionPlanDueDate']);
                    $initPart .= ", ActionPlanDueDate";
                    $valPart  .= ", :actionPlanDueDate";
                }

                if (isset($data['PendingIssues'])) {
                    $params[':pendingIssues'] = $data['PendingIssues'];
                    $initPart .= ", PendingIssues";
                    $valPart  .= ", :pendingIssues";
                }

                if (isset($data['ExtraAuditObjetives'])) {
                    $params[':ExtraAuditObjetives'] = json_encode($data['ExtraAuditObjetives']);
                    $initPart .= ", ExtraAuditObjetives";
                    $valPart  .= ", :ExtraAuditObjetives";
                }

                if (isset($data['ContinueNextStage'])) {
                    $params[':ContinueNextStage'] = (int) $data['ContinueNextStage'];
                    $initPart .= ", ContinueNextStage";
                    $valPart  .= ", :ContinueNextStage";
                }

                if (isset($data['ContinueAfterIssuesSolved'])) {
                    $params[':ContinueAfterIssuesSolved'] = (int) $data['ContinueAfterIssuesSolved'];
                    $initPart .= ", ContinueAfterIssuesSolved";
                    $valPart  .= ", :ContinueAfterIssuesSolved";
                }

                if (isset($data['ClosureAuditNeeded'])) {
                    $params[':ClosureAuditNeeded'] = (int) $data['ClosureAuditNeeded'];
                    $initPart .= ", ClosureAuditNeeded";
                    $valPart  .= ", :ClosureAuditNeeded";
                }

                if (isset($data['RestartCertificationProcess'])) {
                    $params[':RestartCertificationProcess'] = (int) $data['RestartCertificationProcess'];
                    $initPart .= ", RestartCertificationProcess";
                    $valPart  .= ", :RestartCertificationProcess";
                }

                if (isset($data['AuditProgram'])) {
                    $params[':AuditProgram'] = json_encode($data['AuditProgram']);
                    $initPart .= ", AuditProgram";
                    $valPart  .= ", :AuditProgram";
                }

                if (isset($data['AuditProgramChangesJustification'])) {
                    $params[':AuditProgramChangesJustification'] = $data['AuditProgramChangesJustification'];
                    $initPart .= ", AuditProgramChangesJustification";
                    $valPart  .= ", :AuditProgramChangesJustification";
                }

                if (isset($data['AuditReportStatus'])) {
                    $params[':AuditReportStatus'] = $data['AuditReportStatus'];
                    $initPart .= ", AuditReportStatus";
                    $valPart  .= ", :AuditReportStatus";
                }
                
                $query = $initPart. ") ". $valPart. ")";
                
                $idAuditReport = DBManager::query($query, $params);
                if ($idAuditReport) {
                    header(HTTP_CODE_201);
                    echo json_encode(array('IdAuditReport' => $idAuditReport));
                } else {
                    header(HTTP_CODE_409);
                }
            } else {
                header(HTTP_CODE_401);
            }
        }
        else{
            header(HTTP_CODE_412);
        }
        break;


    /**
     * Editar los datos de un reporte de auditoría ya registrado-> 
     * url: .../api/v1-2/audit_reports/edit/:idAuditReport, 
     * metodo: PUT, 
     * datos-solicitados: {auditReport: jsonString}
     * @return JsonString respuesta de resultado de la acción
     */
    case 'edit':
        if ($method !== 'PUT') {
            header('HTTP/1.1 405 Allow; PUT');
            exit();
        }
        
        if(!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }
        $idAuditReport = (int) $url[6];

        $data = json_decode(file_get_contents('php://input'), true);
        if ($data && isset($data['IdAuditPlan']) && isset($data['CompanyRepresentative']) && isset($data['AuditObjetives']) && isset($data['Acceptance'])) {
            if (TokenTool::isValid($token)) {
                $date = new DateTime("now");
                $currentDate = $date->format('Y-m-d H:i:s');

                if ((int) $idAuditReport !== (int) $data['IdAuditReport']) {
                    header(HTTP_CODE_400);
                    exit();
                }

                $params = array(
                    ':idAuditReport'           => $data['IdAuditReport'],
                    ':companyRepresentative'   => json_encode($data['CompanyRepresentative']),
                    ':auditObjetives'          => json_encode($data['AuditObjetives']),
                    ':acceptance'              => json_encode($data['Acceptance']),
                    ':AuditReportStatus'       => $data['AuditReportStatus']
                );

                $query = "UPDATE audit_report SET CompanyRepresentative = :companyRepresentative, AuditObjetives = :auditObjetives, Acceptance = :acceptance, AuditReportStatus = :AuditReportStatus";
                
                if (isset($data['JustificationNotAllShiftAudited'])) {
                    $params[':justificationNotAllShiftAudited'] = $data['JustificationNotAllShiftAudited'];
                    $query .= ", JustificationNotAllShiftAudited = :justificationNotAllShiftAudited";
                } else {
                    $query .= ", JustificationNotAllShiftAudited = null";
                }

                if (isset($data['PossibleNonConformities'])) {
                    $params[':possibleNonConformities'] = $data['PossibleNonConformities'];
                    $query .= ", PossibleNonConformities = :possibleNonConformities";
                } else {
                    $query .= ", PossibleNonConformities = null";
                }

                if (isset($data['AreasOfConcern'])) {
                    $params[':areasOfConcern'] = json_encode($data['AreasOfConcern']);
                    $query .= ", AreasOfConcern = :areasOfConcern";
                } else {
                    $query .= ", AreasOfConcern = null";
                }

                if (isset($data['PositiveIssues'])) {
                    $params[':positiveIssues'] = $data['PositiveIssues'];
                    $query .= ", PositiveIssues = :positiveIssues";
                } else {
                    $query .= ", PositiveIssues = null";
                }

                if (isset($data['OportunitiesToImprove'])) {
                    $params[':oportunitiesToImprove'] = $data['OportunitiesToImprove'];
                    $query .= ", OportunitiesToImprove = :oportunitiesToImprove";
                } else {
                    $query .= ", OportunitiesToImprove = null";
                }

                if (isset($data['NonConformities'])) {
                    if (is_array($data['NonConformities'])) {
                        $folder = base64_encode('Audit_Report_For_AuditPlan_'. $data['IdAuditPlan']);

                        for ($i=0; $i < count($data['NonConformities']); $i++) { 
                            $data['NonConformities'][$i]['EvidenceFiles'] = strpos($data['NonConformities'][$i]['EvidenceFiles'], '://aarrin.com') > 0 ? $data['NonConformities'][$i]['EvidenceFiles'] : saveFile($data['NonConformities'][$i]['EvidenceFiles'], $folder, base64_encode('Evidence_Files_'. $i));
                        }
                    }
                    $params[':nonConformities'] = json_encode($data['NonConformities']);
                    $query .= ", NonConformities = :nonConformities";
                } else {
                    $query .= ", NonConformities = null";
                }

                if (isset($data['ActionPlanDueDate'])) {
                    $params[':actionPlanDueDate'] = $data['ActionPlanDueDate'];
                    $query .= ", ActionPlanDueDate = :actionPlanDueDate";
                } else {
                    $query .= ", ActionPlanDueDate = null";
                }

                if (isset($data['PendingIssues'])) {
                    $params[':pendingIssues'] = $data['PendingIssues'];
                    $query .= ", PendingIssues = :pendingIssues";
                } else {
                    $query .= ", PendingIssues = null";
                }

                if (isset($data['ExtraAuditObjetives'])) {
                    $params[':ExtraAuditObjetives'] = json_encode($data['ExtraAuditObjetives']);
                    $query .= ", ExtraAuditObjetives = :ExtraAuditObjetives";
                } else {
                    $query .= ", ExtraAuditObjetives = null";
                }

                if (isset($data['ContinueNextStage'])) {
                    $params[':ContinueNextStage'] = (int) $data['ContinueNextStage'];
                    $query .= ", ContinueNextStage = :ContinueNextStage";
                } else {
                    $query .= ", ContinueNextStage = null";
                }

                if (isset($data['ContinueAfterIssuesSolved'])) {
                    $params[':ContinueAfterIssuesSolved'] = (int) $data['ContinueAfterIssuesSolved'];
                    $query .= ", ContinueAfterIssuesSolved = :ContinueAfterIssuesSolved";
                } else {
                    $query .= ", ContinueAfterIssuesSolved = null";
                }

                if (isset($data['ClosureAuditNeeded'])) {
                    $params[':ClosureAuditNeeded'] = (int) $data['ClosureAuditNeeded'];
                    $query .= ", ClosureAuditNeeded = :ClosureAuditNeeded";
                } else {
                    $query .= ", ClosureAuditNeeded = null";
                }

                if (isset($data['RestartCertificationProcess'])) {
                    $params[':RestartCertificationProcess'] = (int) $data['RestartCertificationProcess'];
                    $query .= ", RestartCertificationProcess = :RestartCertificationProcess";
                } else {
                    $query .= ", RestartCertificationProcess = null";
                }

                if (isset($data['AuditProgram'])) {
                    $params[':AuditProgram'] = json_encode($data['AuditProgram']);
                    $query .= ", AuditProgram = :AuditProgram";
                } else {
                    $query .= ", AuditProgram = null";
                }

                if (isset($data['AuditProgramChangesJustification'])) {
                    $params[':AuditProgramChangesJustification'] = $data['AuditProgramChangesJustification'];
                    $query .= ", AuditProgramChangesJustification = :AuditProgramChangesJustification";
                } else {
                    $query .= ", AuditProgramChangesJustification = null";
                }
                
                $query .= " WHERE IdAuditReport = :idAuditReport";

                if (DBManager::query($query, $params)) {
                    header(HTTP_CODE_205);
                    echo json_encode($data);
                } else {
                    header(HTTP_CODE_409);
                }
            } else {
                header(HTTP_CODE_401);
            }
        }
        else{
            header(HTTP_CODE_412);
        }
        break;


    /**
     * Eliminar un reporte de auditoría-> 
     * url: .../api/v1-2/audit_reports/delete/:idAuditReport, 
     * metodo: DELETE, 
     * datos-solicitados: {}
     * @return JsonString respuesta de resultado de la acción que incluye los datos del usuario y un token válido
     */
    case 'delete':
        if ($method !== 'DELETE') {
            header('HTTP/1.1 405 Allow: DELETE');
            exit();
        }
        
        if(!isset($url[6])){
            header(HTTP_CODE_412);
            exit();
        }
        $idAuditReport = (int) $url[6];

        if (TokenTool::isValid($token)) {
            $query = "DELETE FROM audit_report WHERE IdAuditReport = :idAuditReport";

            if (DBManager::query($query, array(':idAuditReport' => $idAuditReport))) {
                header(HTTP_CODE_200);
                echo json_encode(array('Result' => 'Deleted successfully'));
            } else {
                header(HTTP_CODE_409);
                echo json_encode(array('Result' => 'Some error occurred'));
            }
            
        } else {
            header(HTTP_CODE_401);
        }
        break;

    default:
        header(HTTP_CODE_404);
        break;
}