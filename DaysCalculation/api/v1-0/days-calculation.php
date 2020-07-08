<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header('Content-Type: application/json');
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table) ----------------------------------------------------------------*/
        case 'GET':
            if (isset($_GET['t']) && isset($_GET['IdApp'])) {
               if (TokenTool::isValid($_GET['t'])) {
                  $idApp = $_GET['IdApp'];
                  $query = "SELECT * FROM days_calculation WHERE IdApp = $idApp;";
                  $consult = $dbConnection->prepare($query);
                  $consult->execute();
                  if ($consult->rowCount() > 0) {
                     $consult->SetFetchMode(PDO::FETCH_ASSOC);
                     $dayCalculationData = $consult->fetchAll()[0];

                     $serviceRequest = $dbConnection->prepare("SELECT s.ServiceShortName FROM services AS s JOIN applications AS a ON a.IdService = s.IdService WHERE a.IdApp = ". $dayCalculationData['IdApp']);
                     $serviceRequest->execute();
                     $serviceRequest->setFetchMode(PDO::FETCH_ASSOC);
                     $serviceShortName = $serviceRequest->fetchAll()[0]['ServiceShortName'];

                     $idDayCalculation = $dayCalculationData['IdDayCalculation'];

                     switch (strtolower($serviceShortName)) {
                        case '9k':
                              $query = "SELECT * FROM days_calculation_detail9k WHERE IdDayCalculation = $idDayCalculation;";
                              $consult = $dbConnection->prepare($query);
                              $consult->execute();
                              $consult->SetFetchMode(PDO::FETCH_ASSOC);
                              $dayCalculationData['DaysCalculationDetail'] = $consult->fetchAll();
                              break;

                        case '14k':
                              $query = "SELECT * FROM days_calculation_detail14k WHERE IdDayCalculation = $idDayCalculation;";
                              $consult = $dbConnection->prepare($query);
                              $consult->execute();
                              $consult->SetFetchMode(PDO::FETCH_ASSOC);
                              $dayCalculationData['DaysCalculationDetail'] = $consult->fetchAll();
                              break;

                        case '22k':
                              $query = "SELECT * FROM days_calculation_detail22k WHERE IdDayCalculation = $idDayCalculation;";
                              $consult = $dbConnection->prepare($query);
                              $consult->execute();
                              $consult->SetFetchMode(PDO::FETCH_ASSOC);
                              $dayCalculationData['DaysCalculationDetail'] = $consult->fetchAll();
                              break;
                        
                        case '45k':
                              $query = "SELECT * FROM days_calculation_detail45k WHERE IdDayCalculation = $idDayCalculation;";
                              $consult = $dbConnection->prepare($query);
                              $consult->execute();
                              $consult->SetFetchMode(PDO::FETCH_ASSOC);
                              $dayCalculationData['DaysCalculationDetail'] = $consult->fetchAll();
                              break;
                        
                        default:
                              $dbConnection->rollBack();
                              header("HTTP/1.1 409 Conflict");
                              exit();
                              break;
                     }
                     header("HTTP/1.1 200 Ok");
                     
                     echo json_encode($dayCalculationData);
                  } else {
                     header("HTTP/1.1 404 Not Found");
                     exit();
                  }
               } else {
                  header("HTTP/1.1 401 Unhautorized");
               }
            } elseif (isset($_GET['t']) && isset($_GET['IdDayCalculation'])) {
               if (TokenTool::isValid($_GET['t'])) {
                  $idDayCalculation = $_GET['IdDayCalculation'];
                  $query = "SELECT IdDayCalculation, IdApp, IdCreatorEmployee, IdReviewerEmployee DayCalculationDate, DayCalculationApproved, DayCalculationApprovedDate, DaysInitialStage, DaysSurveillance, DaysRR, DaysCalculationStatus FROM days_calculation WHERE IdDayCalculation = $idDayCalculation;";
                  $consult = $dbConnection->prepare($query);
                  $consult->execute();
                  if ($consult->rowCount() > 0) {
                     $consult->SetFetchMode(PDO::FETCH_ASSOC);
                     $dayCalculationData = $consult->fetchAll()[0];

                     $serviceRequest = $dbConnection->prepare("SELECT s.ServiceShortName FROM services AS s JOIN applications AS a ON a.IdService = s.IdService WHERE a.IdApp = ". $dayCalculationData['IdApp']);
                     $serviceRequest->execute();
                     $serviceRequest->setFetchMode(PDO::FETCH_ASSOC);
                     $serviceShortName = $serviceRequest->fetchAll()[0]['ServiceShortName'];

                     switch (strtolower($serviceShortName)) {
                        case '9k':
                              $query = "SELECT * FROM days_calculation_detail9k WHERE IdDayCalculation = $idDayCalculation;";
                              $consult = $dbConnection->prepare($query);
                              $consult->execute();
                              $consult->SetFetchMode(PDO::FETCH_ASSOC);
                              $dayCalculationData['DaysCalculationDetail'] = $consult->fetchAll();
                              break;

                        case '14k':
                              $query = "SELECT * FROM days_calculation_detail14k WHERE IdDayCalculation = $idDayCalculation;";
                              $consult = $dbConnection->prepare($query);
                              $consult->execute();
                              $consult->SetFetchMode(PDO::FETCH_ASSOC);
                              $dayCalculationData['DaysCalculationDetail'] = $consult->fetchAll();
                              break;

                        case '22k':
                              $query = "SELECT * FROM days_calculation_detail22k WHERE IdDayCalculation = $idDayCalculation;";
                              $consult = $dbConnection->prepare($query);
                              $consult->execute();
                              $consult->SetFetchMode(PDO::FETCH_ASSOC);
                              $dayCalculationData['DaysCalculationDetail'] = $consult->fetchAll();
                              break;
                        
                        case '45k':
                              $query = "SELECT * FROM days_calculation_detail45k WHERE IdDayCalculation = $idDayCalculation;";
                              $consult = $dbConnection->prepare($query);
                              $consult->execute();
                              $consult->SetFetchMode(PDO::FETCH_ASSOC);
                              $dayCalculationData['DaysCalculationDetail'] = $consult->fetchAll();
                              break;
                        
                        default:
                              $dbConnection->rollBack();
                              header("HTTP/1.1 409 Conflict");
                              exit();
                              break;
                     }
                     header("HTTP/1.1 200 Ok");
                     
                     echo json_encode($dayCalculationData);
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
                  $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.NumberEmployees, app.AppDate, app.AppStatus, dc.*, emp1.EmployeeName + ' ' + emp1.EmployeeLastName AS 'EmployeeCreator', emp1.EmployeePhoto AS 'EmployeeCreatorPhoto', emp2.EmployeeName + ' ' + emp2.EmployeeLastName AS 'EmployeeReviewer', emp2.EmployeePhoto AS 'EmployeeReviewerPhoto' FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN personal AS emp1 ON dc.IdCreatorEmployee = emp1.IdEmployee JOIN personal AS emp2 ON dc.IdReviewerEmployee = emp2.IdEmployee WHERE app.IdCompany = $idCompany ORDER BY dc.DayCalculationDate DESC;";
                  $consult = $dbConnection->prepare($query);
                  $consult->execute();
                  if ($consult->rowCount()) {
                        $consult->setFetchMode(PDO::FETCH_ASSOC);
                        header("HTTP/1.1 200 OK");
                        
                        echo json_encode($consult->fetchAll());
                  } else {
                        header("HTTP/1.1 404 Not Found");
                  }
               } else {
                  header("HTTP/1.1 401 Unhautorized");
               }
            } elseif (isset($_GET['t'])) {
               if (TokenTool::isValid($_GET['t'])) {
                  $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.NumberEmployees, app.AppDate, app.AppStatus, dc.*, emp1.EmployeeName + ' ' + emp1.EmployeeLastName AS 'EmployeeCreator', emp1.EmployeePhoto AS 'EmployeeCreatorPhoto', emp2.EmployeeName + ' ' + emp2.EmployeeLastName AS 'EmployeeReviewer', emp2.EmployeePhoto AS 'EmployeeReviewerPhoto' FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN personal AS emp1 ON dc.IdCreatorEmployee = emp1.IdEmployee JOIN personal AS emp2 ON dc.IdReviewerEmployee = emp2.IdEmployee ORDER BY app.AppDate DESC;";
                  $consult = $dbConnection->prepare($query);
                  $consult->execute();
                  $consult->setFetchMode(PDO::FETCH_ASSOC);
                  header("HTTP/1.1 200 OK");
                  
                  echo json_encode($consult->fetchAll());
               } else {
                  header("HTTP/1.1 401 Unhautorized");
               }
            } else {
               header("HTTP/1.1 412 Precondition Failed");
            }
            
            break;


/**-----Post request (request for create a Days calcuation (Admin)) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['IdApp']) && isset($_POST['IdCreatorEmployee']) && isset($_POST['DaysInitialStage']) && isset($_POST['DaysSurveillance']) && isset($_POST['DaysRR']) && isset($_POST['DaysCalculationDetail']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    $idApp = $_POST['IdApp'];
                    $idCreator = $_POST['IdCreatorEmployee'];
                    $daysInitialStage = $_POST['DaysInitialStage'];
                    $daysSurveillance = $_POST['DaysSurveillance'];
                    $daysRR = $_POST['DaysRR'];
                    $date = new DateTime("now");
                    $currentDate = $date->format('Y-m-d H:i:s');
                    $daysCalculationDetail = json_encode($_POST['DaysCalculationDetail'], true);
                    $daysCalculationDetail = json_decode($_POST['DaysCalculationDetail'], true);

                    $dbConnection->beginTransaction();//starts a transaction in the database

                    $query = "INSERT INTO days_calculation (IdApp, IdCreatorEmployee, DayCalculationDate, DaysInitialStage, DaysSurveillance, DaysRR) VALUES ($idApp, $idCreator, '$currentDate', $daysInitialStage, $daysSurveillance, $daysRR);";

                    
                    try {
                        $createApp = $dbConnection->prepare($query);
                        $createApp->execute();
                        $idDayCalculation = $dbConnection->lastInsertId();
                    } catch (\Throwable $th) {
                        $dbConnection->rollBack();
                        header("HTTP/1.1 409 Conflict");
                        echo json_encode(array(
                            'Request_Status' => 'Error',
                            'Request_Message' => 'Header bad request:'
                        ));
                        exit();
                    }
                    
                    
                    $query = "SELECT s.ServiceShortName FROM services AS s JOIN applications AS a ON a.IdService = s.IdService WHERE a.IdApp = $idApp";
                    
                    $serviceRequest = $dbConnection->prepare($query);
                    try {
                        $serviceRequest->execute();
                        $serviceRequest->setFetchMode(PDO::FETCH_ASSOC);
                        $serviceShortName = $serviceRequest->fetchAll()[0]['ServiceShortName'];
                    } catch (\Throwable $th) {
                        header("HTTP/1.1 409 Conflict");
                        echo json_encode(array(
                            'Request_Status' => 'Error',
                            'Request_Message' => 'App service no identified request:'. $th,
                        ));
                        $dbConnection->rollBack();
                        exit();
                    }
                    

                    switch (strtolower($serviceShortName)) {
                        case '9k':
                           for ($i=0; $i < count($daysCalculationDetail); $i++) { 
                              $detail = $daysCalculationDetail[$i];

                              $initialMD = $detail['InitialMD'];
                              $numberEmployees = $detail['NumberEmployees'];
                              $daysInitialStage = $detail['DaysInitialStage'];
                              $daysSurveillance = $detail['DaysSurveillance'];
                              $daysRR = $detail['DaysRR'];

                              $initialPart = "INSERT INTO days_calculation_detail9k (IdDayCalculation, InitialMD, NumberEmployees, DaysInitialStage, DaysSurveillance, DaysRR";
                              $values = "VALUES ($idDayCalculation, $initialMD, $numberEmployees, $daysInitialStage, $daysSurveillance, $daysRR";

                              if (isset($detail['SystemComplex']) && $detail['SystemComplex'] !== null) {
                                 $tag = $detail['SystemComplex'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['SystemComplexComment'];
                                 $initialPart .= ", SystemComplex, SystemComplexComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['ComplicatedLogistic'])) {
                                 $tag = $detail['ComplicatedLogistic'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ComplicatedLogisticComment'];
                                 $initialPart .= ", ComplicatedLogistic, ComplicatedLogisticComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['InterestedParties'])) {
                                 $tag = $detail['InterestedParties'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['InterestedPartiesComment'];
                                 $initialPart .= ", InterestedParties, InterestedPartiesComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['ScopeRegulation'])) {
                                 $tag = $detail['ScopeRegulation'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ScopeRegulationComment'];
                                 $initialPart .= ", ScopeRegulation, ScopeRegulationComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['DesignResponsability'])) {
                                 $tag = $detail['DesignResponsability'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['DesignResponsabilityComment'];
                                 $initialPart .= ", DesignResponsability, DesignResponsabilityComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['DifferentLanguage'])) {
                                 $tag = $detail['DifferentLanguage'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['DifferentLanguageComment'];
                                 $initialPart .= ", DifferentLanguage, DifferentLanguageComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['Maturity'])) {
                                 $tag = $detail['Maturity'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['MaturityComment'];
                                 $initialPart .= ", Maturity, MaturityComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['AutomationLevel'])) {
                                 $tag = $detail['AutomationLevel'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['AutomationLevelComment'];
                                 $initialPart .= ", AutomationLevel, AutomationLevelComment";
                                 $values .= ", $tagValue, '$comment'";
                              }

                              $query = $initialPart. ") ". $values. ")";
                              
                              try {
                                 $saveAppComplement = $dbConnection->prepare($query);
                                 $saveAppComplement->execute();
                              } catch (\Throwable $th) {
                                 $dbConnection->rollBack();
                                 header("HTTP/1.1 409 Conflict");
                                 echo json_encode(array(
                                    'Request_Status' => 'Error',
                                    'Request_Message' => 'Detail bad request:'. $query
                                 ));
                                 exit();
                              }
                           }
                           $dbConnection->commit();
                                 
                           echo json_encode(array(
                              'Request_Status' => 'Saved',
                              'Request_Message' => 'Application Saved'
                           ));
                           break;

                        case '14k':
                           for ($i=0; $i < count($daysCalculationDetail); $i++) { 
                              $detail = $daysCalculationDetail[$i];
                              
                              $initialMD = $detail['InitialMD'];
                              $numberEmployees = $detail['NumberEmployees'];
                              $daysInitialStage = $detail['DaysInitialStage'];
                              $daysSurveillance = $detail['DaysSurveillance'];
                              $daysRR = $detail['DaysRR'];

                              $initialPart = "INSERT INTO days_calculation_detail14k (IdDayCalculation, InitialMD, NumberEmployees, DaysInitialStage, DaysSurveillance, DaysRR";
                              $values = "VALUES ($idDayCalculation, $initialMD, $numberEmployees, $daysInitialStage, $daysSurveillance, $daysRR";

                              if (isset($detail['SystemComplex'])) {
                                 $tag = $detail['SystemComplex'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['SystemComplexComment'];
                                 $initialPart .= ", SystemComplex, SystemComplexComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['ComplicatedLogistic'])) {
                                 $tag = $detail['ComplicatedLogistic'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ComplicatedLogisticComment'];
                                 $initialPart .= ", ComplicatedLogistic, ComplicatedLogisticComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['InterestedParties'])) {
                                 $tag = $detail['InterestedParties'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['InterestedPartiesComment'];
                                 $initialPart .= ", InterestedParties, InterestedPartiesComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['ScopeRegulation'])) {
                                 $tag = $detail['ScopeRegulation'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ScopeRegulationComment'];
                                 $initialPart .= ", ScopeRegulation, ScopeRegulationComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['OutsourcedProcesses'])) {
                                 $tag = $detail['OutsourcedProcesses'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['OutsourcedProcessesComment'];
                                 $initialPart .= ", OutsourcedProcesses, OutsourcedProcessesComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['IndirectAspects'])) {
                                 $tag = $detail['IndirectAspects'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['IndirectAspectsComment'];
                                 $initialPart .= ", IndirectAspects, IndirectAspectsComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['DifferentLanguage'])) {
                                 $tag = $detail['DifferentLanguage'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['DifferentLanguageComment'];
                                 $initialPart .= ", DifferentLanguage, DifferentLanguageComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['Maturity'])) {
                                 $tag = $detail['Maturity'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['MaturityComment'];
                                 $initialPart .= ", Maturity, MaturityComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['AutomationLevel'])) {
                                 $tag = $detail['AutomationLevel'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['AutomationLevelComment'];
                                 $initialPart .= ", AutomationLevel, AutomationLevelComment";
                                 $values .= ", $tagValue, '$comment'";
                              }

                              $query = $initialPart. ") ". $values. ")";
                              
                              try {
                                 $saveAppComplement = $dbConnection->prepare($query);
                                 $saveAppComplement->execute();
                              } catch (\Throwable $th) {
                                 $dbConnection->rollBack();
                                 header("HTTP/1.1 409 Conflict");
                                 echo json_encode(array(
                                    'Request_Status' => 'Error',
                                    'Request_Message' => 'Detail bad request:'. $query
                                 ));
                                 exit();
                              }
                           }
                           $dbConnection->commit();
                                 
                           echo json_encode(array(
                              'Request_Status' => 'Saved',
                              'Request_Message' => 'Application Saved'
                           ));
                           break;

                        case '22k':
                           for ($i=0; $i < count($daysCalculationDetail); $i++) { 
                              $detail = $daysCalculationDetail[$i];

                              $initialMD = $detail['InitialMD'];
                              $numberEmployees = $detail['NumberEmployees'];
                              $daysInitialStage = $detail['DaysInitialStage'];
                              $daysSurveillance = $detail['DaysSurveillance'];
                              $daysRR = $detail['DaysRR'];

                              $initialPart = "INSERT INTO days_calculation_detail22k (IdDayCalculation, InitialMD, NumberEmployees, DaysInitialStage, DaysSurveillance, DaysRR";
                              $values = "VALUES ($idDayCalculation, $initialMD, $numberEmployees, $daysInitialStage, $daysSurveillance, $daysRR";

                              if (isset($detail['FTEHACCP'])) {
                                 $tag = $detail['FTEHACCP'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['FTEHACCPComment'];
                                 $increment = $detail['FTEHACCPIncrement'];
                                 $initialPart .= ", FTEHACCP, FTEHACCPComment, FTEHACCPIncrement";
                                 $values .= ", $tagValue, '$comment', $increment";
                              }
                              if (isset($detail['FTEHACCPPlus'])) {
                                 $tag = $detail['FTEHACCPPlus'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['FTEHACCPPlusComment'];
                                 $increment = $detail['FTEHACCPPlusIncrement'];
                                 $initialPart .= ", FTEHACCPPlus, FTEHACCPPlusComment, FTEHACCPPlusIncrement";
                                 $values .= ", $tagValue, '$comment', $increment";
                              }
                              if (isset($detail['AuditPreparation'])) {
                                 $tag = $detail['AuditPreparation'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['AuditPreparationComment'];
                                 $increment = $detail['AuditPreparationIncrement'];
                                 $initialPart .= ", AuditPreparation, AuditPreparationComment, AuditPreparationIncrement";
                                 $values .= ", $tagValue, '$comment', $increment";
                              }
                              if (isset($detail['AuditReport'])) {
                                 $tag = $detail['AuditReport'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['AuditReportComment'];
                                 $increment = $detail['AuditReportIncrement'];
                                 $initialPart .= ", AuditReport, AuditReportComment, AuditReportIncrement";
                                 $values .= ", $tagValue, '$comment', $increment";
                              }
                              if (isset($detail['UseInterpreter'])) {
                                 $tag = $detail['UseInterpreter'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['UseInterpreterComment'];
                                 $increment = $detail['UseInterpreterIncrement'];
                                 $initialPart .= ", UseInterpreter, UseInterpreterComment, UseInterpreterIncrement";
                                 $values .= ", $tagValue, '$comment', $increment";
                              }
                              if (isset($detail['OffSiteStorage'])) {
                                 $tag = $detail['OffSiteStorage'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['OffSiteStorageComment'];
                                 $increment = $detail['OffSiteStorageIncrement'];
                                 $initialPart .= ", OffSiteStorage, OffSiteStorageComment, OffSiteStorageIncrement";
                                 $values .= ", $tagValue, '$comment', $increment";
                              }
                              if (isset($detail['CertificationControlled'])) {
                                 $tag = $detail['CertificationControlled'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['CertificationControlledComment'];
                                 $increment = $detail['CertificationControlledIncrement'];
                                 $initialPart .= ", CertificationControlled, CertificationControlledComment, CertificationControlledIncrement";
                                 $values .= ", $tagValue, '$comment', $increment";
                              }

                              $query = $initialPart. ") ". $values. ")";
                              
                              try {
                                 $saveAppComplement = $dbConnection->prepare($query);
                                 $saveAppComplement->execute();
                              } catch (\Throwable $th) {
                                 $dbConnection->rollBack();
                                 header("HTTP/1.1 409 Conflict");
                                 echo json_encode(array(
                                    'Request_Status' => 'Error',
                                    'Request_Message' => 'Detail bad request:'. $query
                                 ));
                                 exit();
                              }
                           }
                           $dbConnection->commit();
                                 
                           echo json_encode(array(
                              'Request_Status' => 'Saved',
                              'Request_Message' => 'Application Saved'
                           ));
                           break;
                        
                        case '45k':
                           for ($i=0; $i < count($daysCalculationDetail); $i++) { 
                              $detail = $daysCalculationDetail[$i];
                              
                              $initialMD = $detail['InitialMD'];
                              $numberEmployees = $detail['NumberEmployees'];
                              $daysInitialStage = $detail['DaysInitialStage'];
                              $daysSurveillance = $detail['DaysSurveillance'];
                              $daysRR = $detail['DaysRR'];

                              $initialPart = "INSERT INTO days_calculation_detail45k (IdDayCalculation, InitialMD, NumberEmployees, DaysInitialStage, DaysSurveillance, DaysRR";
                              $values = "VALUES ($idDayCalculation, $initialMD, $numberEmployees, $daysInitialStage, $daysSurveillance, $daysRR";

                              if (isset($detail['SystemComplex'])) {
                                 $tag = $detail['SystemComplex'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['SystemComplexComment'];
                                 $initialPart .= ", SystemComplex, SystemComplexComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['ComplicatedLogistic'])) {
                                 $tag = $detail['ComplicatedLogistic'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ComplicatedLogisticComment'];
                                 $initialPart .= ", ComplicatedLogistic, ComplicatedLogisticComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['InterestedParties'])) {
                                 $tag = $detail['InterestedParties'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['InterestedPartiesComment'];
                                 $initialPart .= ", InterestedParties, InterestedPartiesComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['ScopeRegulation'])) {
                                 $tag = $detail['ScopeRegulation'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ScopeRegulationComment'];
                                 $initialPart .= ", ScopeRegulation, ScopeRegulationComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['SmallLargePersonnel'])) {
                                 $tag = $detail['SmallLargePersonnel'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['SmallLargePersonnelComment'];
                                 $initialPart .= ", SmallLargePersonnel, SmallLargePersonnelComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['IndirectAspects'])) {
                                 $tag = $detail['IndirectAspects'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['IndirectAspectsComment'];
                                 $initialPart .= ", IndirectAspects, IndirectAspectsComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['DifferentLanguage'])) {
                                 $tag = $detail['DifferentLanguage'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['DifferentLanguageComment'];
                                 $initialPart .= ", DifferentLanguage, DifferentLanguageComment";
                                 $values .= ", $tagValue, '$comment'";
                              }
                              if (isset($detail['Maturity'])) {
                                 $tag = $detail['Maturity'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['MaturityComment'];
                                 $initialPart .= ", Maturity, MaturityComment";
                                 $values .= ", $tagValue, '$comment'";
                              }

                              $query = $initialPart. ") ". $values. ")";
                              
                              try {
                                 $saveAppComplement = $dbConnection->prepare($query);
                                 $saveAppComplement->execute();
                              } catch (\Throwable $th) {
                                 $dbConnection->rollBack();
                                 header("HTTP/1.1 409 Conflict");
                                 echo json_encode(array(
                                    'Request_Status' => 'Error',
                                    'Request_Message' => 'Detail bad request:'. $query
                                 ));
                                 exit();
                              }
                           }
                           $dbConnection->commit();
                                 
                           echo json_encode(array(
                              'Request_Status' => 'Saved',
                              'Request_Message' => 'Application Saved'
                           ));
                           break;
                        
                        default:
                           $dbConnection->rollBack();
                           header("HTTP/1.1 409 Conflict");
                           echo json_encode(array(
                              'Request_Status' => 'Error',
                              'Request_Message' => 'Service not found'
                           ));
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
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            break;
        
        default:
            header("HTTP/1.1 405 Allow; GET, POST, PUT, PATCH");
            exit();
            break;
    }
