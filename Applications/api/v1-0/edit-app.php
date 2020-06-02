<?php
/** */
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");
    header('Content-Type: application/json');

    switch ($_SERVER['REQUEST_METHOD']) {
/**Update the data in application ------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['IdApp']) && isset($_POST['IdContact']) && isset($_POST['IdService']) && isset($_POST['IdSector']) && isset($_POST['AppLenguage']) && isset($_POST['NumberEmployees']) && isset($_POST['AppDetail']) && isset($_POST['AppComplement']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    $idApp = $_POST['IdApp'];
                    $idContact = $_POST['IdContact'];
                    $idService = $_POST['IdService'];
                    $idSector = $_POST['IdSector'];
                    $appLenguage = $_POST['AppLenguage'];
                    $numberEmployees = $_POST['NumberEmployees'];
                    $appDetail = json_decode($_POST['AppDetail'], true);
                    $appComplement = json_decode($_POST['AppComplement'], true);
                    $query = "UPDATE applications SET IdSector = $idSector, AppLenguage = '$appLenguage', NumberEmployees = $numberEmployees";
                    if (isset($_POST['LastCertificateExpiration'])) {
                        $lastCertificationExpire = $_POST['LastCertificateExpiration'];
                        $query .= ", LastCertificateExpiration = '$lastCertificationExpire'";
                    }
                    
                    if (isset($_POST['LastCertificateCertifier'])) {
                        $lastCertificationCertifier = $_POST['LastCertificateCertifier'];
                        $query .= ",LastCertificateCertifier = '$lastCertificationCertifier'";
                    }
                    
                    if (isset($_POST['LastCertificateResults'])) {
                        $lastCertificationResults = $_POST['LastCertificateResults'];
                        $query .= ", LastCertificateResults = '$lastCertificationResults'";
                    }
                    
                    if (isset($_POST['ExternalServicesProvider'])) {
                        $externalServicesProvider = $_POST['ExternalServicesProvider'];
                        $query .= ", ExternalServicesProvider = '$externalServicesProvider'";
                    }
                    
                    if (isset($_POST['ReceiveConsultancy'])) {
                        $receiveConsultancy = $_POST['ReceiveConsultancy'];
                        $consultantName = $_POST['ConsultantName'];
                        $query .= ", ReceiveConsultancy = $receiveConsultancy, ConsultantName = '$consultantName'";
                    }

                    $query .= " WHERE IdApp = $idApp;";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $createApp = $dbConnection->prepare($query);
                    try {
                        $createApp->execute();
                    } catch (\Throwable $th) {
                        $dbConnection->rollBack();
                        header("HTTP/1.1 409 Conflict");
                        exit();
                    }
                    
                    for ($i=0; $i < count($appDetail); $i++) { 
                        $detail = $appDetail[$i];
                        $idAppDetail = $detail['IdAppDetail'];
                        $address = $detail['Address'];
                        $activities = $detail['Activities'];
                        $query = "UPDATE app_detail SET Address = '$address', Activities = '$activities'";

                        if (isset($detail['Shift1'])){
                            $shift1 = $detail['Shift1'];
                            $query .= ", Shift1 = '$shift1'";
                        }
                        if (isset($detail['Shift1Employees'])){
                            $shift1Employees = $detail['Shift1Employees'];
                            $query .= ", Shift1Employees = $shift1Employees";
                        }
                        if (isset($detail['Shift2'])){
                            $shift2 = $detail['Shift2'];
                            $query .= ", Shift2 = '$shift2'";
                        }
                        if (isset($detail['Shift2Employees'])){
                            $shift2Employees = $detail['Shift2Employees'];
                            $query .= ", Shift2Employees = $shift2Employees";
                        }
                        if (isset($detail['Shift3'])){
                            $shift3 = $detail['Shift3'];
                            $query .= ", Shift3 = '$shift3'";
                        }
                        if (isset($detail['Shift3Employees'])){
                            $shift3Employees = $detail['Shift3Employees'];
                            $query .= ", Shift3Employees = $shift3Employees";
                        }

                        $query .= " WHERE IdAppDetail = $idAppDetail;";
                        $saveAppDetail = $dbConnection->prepare($query);
                        try {
                            $saveAppDetail->execute();
                        } catch (\Throwable $th) {
                            $dbConnection->rollBack();
                            header("HTTP/1.1 409 Conflict");
                            exit();
                        }
                    }
                    
                    $serviceRequest = $dbConnection->prepare("SELECT ServiceShortName FROM services WHERE IdService = $idService");
                    $serviceRequest->execute();
                    $serviceRequest->setFetchMode(PDO::FETCH_ASSOC);
                    $serviceShortName = $serviceRequest->fetchAll()[0]['ServiceShortName'];

                    switch (strtolower($serviceShortName)) {
                        case '9k':
                            $scopeActivities = $appComplement['ScopeActivities'];
                            $numberProcesses = $appComplement['NumberProcesses'];
                            $legalRequirements = $appComplement['LegalRequirements'];
                            $automationLevel = $appComplement['ProcessAutomationLevel'];
                            $justification = $appComplement['Justification'];

                            $query = "UPDATE iso9kcomplement SET ScopeActivities = '$scopeActivities', NumberProcesses = $numberProcesses, LegalRequirements = '$legalRequirements', ProcessAutomationLevel = '$automationLevel', Justification = '$justification'";

                            if (isset($appComplement['CriticalComplaint'])) {
                                $criticalComplaint = $appComplement['CriticalComplaint'];
                                $query .= ", CriticalComplaint = '$criticalComplaint'";
                            }
                            if (isset($appComplement['DesignResponsability'])) {
                                $designResponsability = $appComplement['DesignResponsability'];
                                $query .= ", DesignResponsability = '$designResponsability'";
                            }
                            $query .= " WHERE IdApp = $idApp";
                            $saveAppComplement = $dbConnection->prepare($query);
                            try {
                                $saveAppComplement->execute();
                                $dbConnection->commit();
                                
                                echo json_encode(array(
                                    'Request-Status' => 'Saved',
                                    'Request-Message' => 'Application Saved'
                                ));
                            } catch (\Throwable $th) {
                                $dbConnection->rollBack();
                                header("HTTP/1.1 409 Conflict");
                                exit();
                            }
                            break;

                        case '14k':
                            $scopeActivities = $appComplement['ScopeActivities'];
                            $numberProcesses = $appComplement['NumberProcesses'];
                            $legalRequirements = $appComplement['LegalRequirements'];
                            $operationalControls = $appComplement['OperationalControls'];

                            $query = "UPDATE iso14kcomplement SET ScopeActivities = '$scopeActivities', NumberProcesses = $numberProcesses, LegalRequirements = '$legalRequirements', OperationalControls = '$operationalControls'";

                            if (isset($appComplement['CriticalComplaint'])) {
                                $criticalComplaint = $appComplement['CriticalComplaint'];
                                $query .= ", CriticalComplaint = '$criticalComplaint'";
                            }
                            $query .= " WHERE IdApp = $idApp";
                            $saveAppComplement = $dbConnection->prepare($query);
                            try {
                                $saveAppComplement->execute();
                                $dbConnection->commit();
                                
                                echo json_encode(array(
                                    'Request-Status' => 'Saved',
                                    'Request-Message' => 'Application Saved'
                                ));
                            } catch (\Throwable $th) {
                                $dbConnection->rollBack();
                                header("HTTP/1.1 409 Conflict");
                                exit();
                            }
                            break;

                        case '22k':
                            $numberHACCP = $appComplement['NumberHACCP'];
                            $generalDescription = $appComplement['GeneralDescription'];
                            $linesProduts = $appComplement['NumberLinesProducts'];
                            $seasonality = $appComplement['Seasonality'];
                            $legalRequirements = $appComplement['LegalRequirements'];
                            $query = "UPDATE iso22kcomplement SET NumberHACCP = $numberHACCP, GeneralDescription = '$generalDescription', NumberLinesProducts = $linesProduts, Seasonality = '$seasonality', LegalRequirements = '$legalRequirements' WHERE IdApp = $idApp;";
                            $saveAppComplement = $dbConnection->prepare($query);
                            try {
                                $saveAppComplement->execute();
                                $dbConnection->commit();
                                
                                echo json_encode(array(
                                    'Request-Status' => 'Saved',
                                    'Request-Message' => 'Application Saved'
                                ));
                            } catch (\Throwable $th) {
                                $dbConnection->rollBack();
                                header("HTTP/1.1 409 Conflict");
                                exit();
                            }
                            break;
                        
                        case '45k':
                            $scopeActivities = $appComplement['ScopeActivities'];
                            $numberProcesses = $appComplement['NumberProcesses'];
                            $legalRequirements = $appComplement['LegalRequirements'];
                            $fatalities = $appComplement['FatalitiesRate'];
                            $accidents = $appComplement['AccidentsRate'];
                            $injuries = $appComplement['InjuriesRate'];
                            $nearMiss = $appComplement['NearMissRate'];
                            $ohsmsAudit = $appComplement['OHSMSAudit'];
                            $risksList = $appComplement['HighLevelRisks'];
                            $query = "UPDATE  iso45kcomplement SET ScopeActivities = '$scopeActivities', NumberProcesses = $numberProcesses, 
                            LegalRequirements = '$legalRequirements', FatalitiesRate = $fatalities,
                            AccidentsRate = $accidents, InjuriesRate = $injuries, NearMissRate = $nearMiss,
                            OHSMSAudit = '$ohsmsAudit', HighLevelRisks = '$risksList' WHERE IdApp = $idApp";
                            $saveAppComplement = $dbConnection->prepare($query);
                            try {
                                $saveAppComplement->execute();
                                $dbConnection->commit();
                                
                                echo json_encode(array(
                                    'Request-Status' => 'Saved',
                                    'Request-Message' => 'Application Saved'
                                ));
                            } catch (\Throwable $th) {
                                $dbConnection->rollBack();
                                header("HTTP/1.1 409 Conflict");
                                exit();
                            }
                            break;
                        
                        default:
                            $dbConnection->rollBack();
                            header("HTTP/1.1 409 Conflict");
                            exit();
                            break;
                    }

                }
                else{
                    header("HTTP/1.1 401 Unauthorized");
                }
                exit();
            }
            else{
                header("HTTP/1.1 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;

        case 'OPTIONS':
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            header("Allow: POST");
            break;
        
        default:
            header("HTTP/1.1 405 Allow; GET, POST, PUT, PATCH");
            exit();
            break;
    }
?>