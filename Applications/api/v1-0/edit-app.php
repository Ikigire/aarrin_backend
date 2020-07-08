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
                    if (isset($_POST['LastCertificateStandard'])) {
                        $lastCertificationStandard = $_POST['LastCertificateStandard'];
                        $query .= ", LastCertificateStandard = '$lastCertificationStandard'";
                    }
                    
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

                    if (isset($_POST['AppStatus'])) {
                        $appStatus = $_POST['AppStatus'];
                        $query .= ", AppStatus = '$appStatus'";
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
                    
                    $listIdDetails = array();
                    for ($i=0; $i < count($appDetail); $i++) { 
                        $detail = $appDetail[$i];
                        $exist = isset($detail['IdAppDetail']);
                        if ($exist) {
                            $idAppDetail = $detail['IdAppDetail'];
                            $address = $detail['Address'];
                            $shift1 = $detail['Shift1'];
                            $shift1Employees = $detail['Shift1Employees'];
                            $shift1Activities = $detail['Shift1Activities'];
                            $query = "UPDATE app_detail SET Address = '$address', Shift1 = '$shift1', Shift1Employees = $shift1Employees, Shift1Activities = '$shift1Activities'";

                            if (isset($detail['Shift2'])){
                                $shift2 = $detail['Shift2'];
                                $query .= ", Shift2 = '$shift2'";
                            }
                            if (isset($detail['Shift2Employees'])){
                                $shift2Employees = $detail['Shift2Employees'];
                                $query .= ", Shift2Employees = $shift2Employees";
                            }
                            if (isset($detail['Shift2Activities'])) {
                                $shift2Activities = $detail['Shift2Activities'];
                                $query .= ", Shift2Activities = '$shift2Activities'";
                            }
                            if (isset($detail['Shift3'])){
                                $shift3 = $detail['Shift3'];
                                $query .= ", Shift3 = '$shift3'";
                            }
                            if (isset($detail['Shift3Employees'])){
                                $shift3Employees = $detail['Shift3Employees'];
                                $query .= ", Shift3Employees = $shift3Employees";
                            }
                            if (isset($detail['Shift3Activities'])) {
                                $shift3Activities = $detail['Shift3Activities'];
                                $query .= ", Shift3Activities = '$shift3Activities'";
                            }
                            if (isset($detail['OfficeShift'])){
                                $officeShift = $detail['OfficeShift'];
                                $query .= ", OfficeShift = '$officeShift'";
                            }
                            if (isset($detail['OfficeShiftEmployees'])){
                                $officeShiftEmployees = $detail['OfficeShiftEmployees'];
                                $query .= ", OfficeShiftEmployees = $officeShiftEmployees";
                            }
                            if (isset($detail['OfficeShiftActivities'])) {
                                $officeShiftActivities = $detail['OfficeShiftActivities'];
                                $query .= ", OfficeShiftActivities = '$officeShiftActivities'";
                            }

                            $query .= " WHERE IdAppDetail = $idAppDetail;";
                        } else {
                            $address = $detail['Address'];
                            $shift1 = $detail['Shift1'];
                            $shift1Employees = $detail['Shift1Employees'];
                            $shift1Activities = $detail['Shift1Activities'];
                            $initialPart = "INSERT INTO app_detail (IdApp, Address, Shift1, Shift1Employees, Shift1Activities";
                            $values = "Values ($idApp, '$address', '$shift1', $shift1Employees ,  '$shift1Activities'";
                        
                            if (isset($detail['Shift2'])){
                                $shift2 = $detail['Shift2'];
                                $initialPart .= ", Shift2";
                                $values .= ", '$shift2'";
                            }
                            if (isset($detail['Shift2Employees'])){
                                $shift2Employees = $detail['Shift2Employees'];
                                $initialPart .= ", Shift2Employees";
                                $values .= ", $shift2Employees";
                            }
                            if (isset($detail['Shift2Activities'])) {
                                $shift2Activities = $detail['Shift2Activities'];
                                $initialPart .= ", Shift2Activities";
                                $values .= ", '$shift2Activities'";
                            }
                            if (isset($detail['Shift3'])){
                                $shift3 = $detail['Shift3'];
                                $initialPart .= ", Shift3";
                                $values .= ", '$shift3'";
                            }
                            if (isset($detail['Shift3Employees'])){
                                $shift3Employees = $detail['Shift3Employees'];
                                $initialPart .= ", Shift3Employees";
                                $values .= ", $shift3Employees";
                            }
                            if (isset($detail['Shift3Activities'])) {
                                $shift3Activities = $detail['Shift3Activities'];
                                $initialPart .= ", Shift3Activities";
                                $values .= ", '$shift3Activities'";
                            }
                            if (isset($detail['OfficeShift'])){
                                $officeShift = $detail['OfficeShift'];
                                $initialPart .= ", OfficeShift";
                                $values .= ", '$officeShift'";
                            }
                            if (isset($detail['OfficeShiftEmployees'])){
                                $officeShiftEmployees = $detail['OfficeShiftEmployees'];
                                $initialPart .= ", OfficeShiftEmployees";
                                $values .= ", $officeShiftEmployees";
                            }
                            if (isset($detail['OfficeShiftActivities'])) {
                                $officeShiftActivities = $detail['OfficeShiftActivities'];
                                $initialPart .= ", OfficeShiftActivities";
                                $values .= ", '$officeShiftActivities'";
                            }

                            $query = $initialPart. ") ". $values. ");";
                        }
                        
                        $saveAppDetail = $dbConnection->prepare($query);
                        try {
                            $saveAppDetail->execute();
                            if ($exist) {
                                array_push($listIdDetails, $idAppDetail);
                            } else {
                                array_push($listIdDetails, $dbConnection->lastInsertId());
                            }
                        } catch (\Throwable $th) {
                            $dbConnection->rollBack();
                            header("HTTP/1.1 409 Conflict");
                            exit();
                        }
                    }

                    $query = "DELETE FROM app_detail WHERE IdApp = $idApp";
                    for ($i=0; $i < count($listIdDetails); $i++) { 
                            $query .= " AND IdAppDetail <> ". $listIdDetails[$i];
                    }
                    $removeUnnecessaryDetails = $dbConnection->prepare($query);
                    try {
                        $removeUnnecessaryDetails->execute();
                    } catch (\Throwable $th) {
                        $dbConnection->rollBack();
                        header("HTTP/1.1 409 Conflict");
                        exit();
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
            header("Allow: POST, OPTIONS");
            break;
        
        default:
            header("HTTP/1.1 405 Allow; POST, OPTIONS");
            exit();
            break;
    }
?>