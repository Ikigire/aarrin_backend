<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table) ----------------------------------------------------------------*/
        case 'GET':
            if (isset($_GET['t']) && isset($_GET['IdApplication'])) {
                if (TokenTool::isValid($_GET['t'])) {
                    $idApplication = $_GET['IdApplication'];
                    $query ="SELECT IdApp, IdCompany, IdContact, IdService, IdSector, AppLenguage, LastCertificateExpiration, LastCertificateCertifier, LastCertificateResults, NumberEmployees, ExternalServicesProvider, ReceiveConsultancy, ConsultantName, AppDate, AppStatus FROM applications WHERE IdApp = $idApplication;";
                    $consult = $dbConnection->prepare($query);
                    $consult->execute();
                    if ($consult->rowCount()) {
                        $consult->SetFetchMode(PDO::FETCH_ASSOC);
                        $appData = $consult->fetchAll()[0];
                        $query = "SELECT IdAppDetail, IdApp, Address, Shift1, Shift1Employees, Shift2, Shift2Employees, Shift3, Shift3Employees, Activities FROM app_detail WHERE IdApp = $idApplication;";
                        $consult = $dbConnection->prepare($query);
                        $consult->execute();
                        $consult->SetFetchMode(PDO::FETCH_ASSOC);
                        $appData['AppDetail'] = $consult->fetchAll();

                        $serviceRequest = $dbConnection->prepare("SELECT ServiceShortName FROM services WHERE IdService = ". $appData['IdService']);
                        $serviceRequest->execute();
                        $serviceRequest->setFetchMode(PDO::FETCH_ASSOC);
                        $serviceShortName = $serviceRequest->fetchAll()[0]['ServiceShortName'];

                        switch (strtolower($serviceShortName)) {
                            case '9k':
                                $query = "SELECT IdApp, ScopeActivities, NumberProcesses, LegalRequirements, CriticalComplaint, ProcessAutomationLevel, DesignResponsability, Justification FROM iso9kcomplement WHERE IdApp = $idApplication;";
                                $consult = $dbConnection->prepare($query);
                                $consult->execute();
                                $consult->SetFetchMode(PDO::FETCH_ASSOC);
                                $appData['AppComplement'] = $consult->fetchAll();
                                break;

                            case '14k':
                                $query = "SELECT IdApp, ScopeActivities, NumberProcesses, LegalRequirements, OperationalControls, CriticalComplaint FROM iso14kcomplement WHERE IdApp = $idApplication;";
                                $consult = $dbConnection->prepare($query);
                                $consult->execute();
                                $consult->SetFetchMode(PDO::FETCH_ASSOC);
                                $appData['AppComplement'] = $consult->fetchAll();
                                break;

                            case '22k':
                                $query = "SELECT IdApp, NumberHACCP, GeneralDescription, NumberLinesProducts, Seasonality, LegalRequirements FROM iso22kcomplement WHERE IdApp = $idApplication;";
                                $consult = $dbConnection->prepare($query);
                                $consult->execute();
                                $consult->SetFetchMode(PDO::FETCH_ASSOC);
                                $appData['AppComplement'] = $consult->fetchAll();
                                break;
                            
                            case '45k':
                                $query = "SELECT IdApp, ScopeActivities, NumberProcesses, LegalRequirements, FatalitiesRate, AccidentsRate, InjuriesRate, NearMissRate, OHSMSAudit, HighLevelRisks FROM iso45kcomplement WHERE IdApp = $idApplication;";
                                $consult = $dbConnection->prepare($query);
                                $consult->execute();
                                $consult->SetFetchMode(PDO::FETCH_ASSOC);
                                $appData['AppComplement'] = $consult->fetchAll();
                                break;
                            
                            default:
                                $dbConnection->rollBack();
                                header("HTTP/1.1 409 Conflict");
                                exit();
                                break;
                        }
                        header("HTTP/1.1 200 Ok");
                        header("Content-Type: application/json");
                        echo json_encode($appData);
                    } else {
                        header("HTTP/1.1 404 Not Found");
                        exit();
                    }
                } else {
                    header("HTTP/1.1 401 Unhautorized");
                }
            } elseif (isset($_GET['t']) && isset($_GET['IdCompany'])) {
                if (TokenTool::isValid($_GET['t'])) {
                    $idCompany = $_GET['IdCompany'];
                    $query = "SELECT app.IdApp, c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.AppLenguage, app.LastCertificateExpiration, app.LastCertificateCertifier, app.LastCertificateResults, app.NumberEmployees, app.ExternalServicesProvider, app.ReceiveConsultancy, app.ConsultantName, app.AppDate, app.AppStatus FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector WHERE app.IdCompany = $idCompany;";
                    $consult = $dbConnection->prepare($query);
                    $consult->execute();
                    $consult->setFetchMode(PDO::FETCH_ASSOC);
                    header("HTTP/1.1 200 OK");
                    header("Content-Type: application/json");
                    echo json_encode($consult->fetchAll());
                } else {
                    header("HTTP/1.1 401 Unhautorized");
                }
            } elseif (isset($_GET['t'])) {
                if (TokenTool::isValid($_GET['t'])) {
                    $query = "SELECT app.IdApp, c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.AppLenguage, app.LastCertificateExpiration, app.LastCertificateCertifier, app.LastCertificateResults, app.NumberEmployees, app.ExternalServicesProvider, app.ReceiveConsultancy, app.ConsultantName, app.AppDate, app.AppStatus FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector;";
                    $consult = $dbConnection->prepare($query);
                    $consult->execute();
                    $consult->setFetchMode(PDO::FETCH_ASSOC);
                    header("HTTP/1.1 200 OK");
                    header("Content-Type: application/json");
                    echo json_encode($consult->fetchAll());
                } else {
                    header("HTTP/1.1 401 Unhautorized");
                }
            } else {
                header("HTTP/1.1 412 Precondition Failed");
            }
            exit();
            break;


/**-----Post request (request for create a new employee (Admin)) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['IdCompany']) && isset($_POST['IdContact']) && isset($_POST['IdService']) && isset($_POST['IdSector']) && isset($_POST['AppLenguage']) && isset($_POST['NumberEmployees']) && isset($_POST['AppDetail']) && isset($_POST['AppComplement']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    $idCompany = $_POST['IdCompany'];
                    $idContact = $_POST['IdContact'];
                    $idService = $_POST['IdService'];
                    $idSector = $_POST['IdSector'];
                    $appLenguage = $_POST['AppLenguage'];
                    $numberEmployees = $_POST['NumberEmployees'];
                    $date = new DateTime("now");
                    $currentDate = $date->format('Y-m-d H:i:s');
                    $appDetail = json_encode($_POST['AppDetail'], true);
                    $appDetail = json_decode($_POST['AppDetail'], true);
                    $appComplement = json_decode($_POST['AppComplement'], true);
                    $initialPart = "INSERT INTO applications (IdCompany, IdContact, IdService, IdSector, AppLenguage, NumberEmployees, AppDate";
                    $values = "VALUES ($idCompany, $idContact, $idService, $idSector, '$appLenguage', $numberEmployees, '$currentDate'";
                    if (isset($_POST['LastCertificationExpire'])) {
                        $lastCertificationExpire = $_POST['LastCertificationExpire'];
                        $initialPart .= ", LastCertificationExpire";
                        $values .= ", '$lastCertificationExpire'";
                    }
                    
                    if (isset($_POST['LastCertificationCertifier'])) {
                        $lastCertificationCertifier = $_POST['LastCertificationCertifier'];
                        $initialPart .= ",LastCertificationCertifier";
                        $values .= ", '$lastCertificationCertifier'";
                    }
                    
                    if (isset($_POST['LastCertificationResults'])) {
                        $lastCertificationResults = $_POST['LastCertificationResults'];
                        $initialPart .= ", LastCertificationResults";
                        $values .= ", '$lastCertificationResults'";
                    }
                    
                    if (isset($_POST['ExternalServicesProvider'])) {
                        $externalServicesProvider = $_POST['ExternalServicesProvider'];
                        $initialPart .= ", ExternalServicesProvider";
                        $values .= ", '$externalServicesProvider'";
                    }
                    
                    if (isset($_POST['ReceiveConsultancy'])) {
                        $receiveConsultancy = $_POST['ReceiveConsultancy'];
                        $consultantName = $_POST['ConsultantName'];
                        $initialPart .= ", ReceiveConsultancy, ConsultantName";
                        $values .= ", $receiveConsultancy, '$consultantName'";
                    }

                    $query = $initialPart . ") " . $values . ");";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $createApp = $dbConnection->prepare($query);
                    try {
                        $createApp->execute();
                        $idApp = $dbConnection->lastInsertId();
                    } catch (\Throwable $th) {
                        $dbConnection->rollBack();
                        header("HTTP/1.1 409 Conflict");
                        exit();
                    }
                    
                    for ($i=0; $i < count($appDetail); $i++) { 
                        $detail = $appDetail[$i];
                        $address = $detail['Address'];
                        $activities = $detail['Activities'];
                        $initialPart = "INSERT INTO app_detail (IdApp, Address, Activities";
                        $values = "Values ($idApp, '$address', '$activities'";

                        if (isset($detail['Shift1'])){
                            $shift1 = $detail['Shift1'];
                            $initialPart .= ", Shift1";
                            $values .= ", '$shift1'";
                        }
                        if (isset($detail['Shift1Employees'])){
                            $shift1Employees = $detail['Shift1Employees'];
                            $initialPart .= ", Shift1Employees";
                            $values .= ", $shift1Employees";
                        }
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

                        $query = $initialPart. ") ". $values. ");";
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

                            $initialPart = "INSERT INTO iso9kcomplement (IdApp, ScopeActivities, NumberProcesses, LegalRequirements, ProcessAutomationLevel, Justification";
                            $values = "VALUES ($idApp, '$scopeActivities', $numberProcesses, '$legalRequirements', '$automationLevel', '$justification'";

                            if (isset($appComplement['CriticalComplaint'])) {
                                $criticalComplaint = $appComplement['CriticalComplaint'];
                                $initialPart .= ", CriticalComplaint";
                                $values .= ", '$criticalComplaint'";
                            }
                            if (isset($appComplement['DesignResponsability'])) {
                                $designResponsability = $appComplement['DesignResponsability'];
                                $initialPart .= ", DesignResponsability";
                                $values .= ", '$designResponsability'";
                            }
                            $query = $initialPart. ") ". $values. ")";
                            $saveAppComplement = $dbConnection->prepare($query);
                            try {
                                $saveAppComplement->execute();
                                $dbConnection->commit();
                                header('Content-Type: application/json');
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

                            $initialPart = "INSERT INTO iso14kcomplement (IdApp, ScopeActivities, NumberProcesses, LegalRequirements, OperationalControls";
                            $values = "VALUES ($idApp, '$scopeActivities', $numberProcesses, '$legalRequirements', '$operationalControls'";

                            if (isset($appComplement['CriticalComplaint'])) {
                                $criticalComplaint = $appComplement['CriticalComplaint'];
                                $initialPart .= ", CriticalComplaint";
                                $values .= ", '$criticalComplaint'";
                            }
                            $query = $initialPart. ") ". $values. ")";
                            $saveAppComplement = $dbConnection->prepare($query);
                            try {
                                $saveAppComplement->execute();
                                $dbConnection->commit();
                                header('Content-Type: application/json');
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
                            $query = "INSERT INTO iso22kcomplement (IdApp, NumberHACCP, GeneralDescription, NumberLinesProducts, Seasonality, LegalRequirements) VALUES ($idApp, $numberHACCP, '$generalDescription', $linesProduts, '$seasonality', '$legalRequirements');";
                            $saveAppComplement = $dbConnection->prepare($query);
                            try {
                                $saveAppComplement->execute();
                                $dbConnection->commit();
                                header('Content-Type: application/json');
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
                            $query = "INSERT INTO iso45kcomplement (IdApp, ScopeActivities, NumberProcesses, LegalRequirements, FatalitiesRate,
                            AccidentsRate, InjuriesRate, NearMissRate, OHSMSAudit, HighLevelRisks) VALUES ($idApp, '$scopeActivities', $numberProcesses,
                            '$legalRequirements', $fatalities, $accidents, $injuries, $nearMiss, '$ohsmsAudit', '$risksList')";
                            $saveAppComplement = $dbConnection->prepare($query);
                            try {
                                $saveAppComplement->execute();
                                $dbConnection->commit();
                                header('Content-Type: application/json');
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


/**-----Put request (request for change information in the table) -----------------------------------------------------------------------------------------------------------*/
        case 'PUT':
            
            exit();
            break;


/**-----Patch request (request for change employee photo in the table) -----------------------------------------------------------------------------------------------------------*/
        case 'PATCH':
            
            break;

        case 'OPTIONS':
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            break;
        
        default:
            header("HTTP/1.1 405 Allow; GET, POST, PUT, PATCH");
            exit();
            break;
    }
