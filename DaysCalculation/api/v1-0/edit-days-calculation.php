<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header('Content-Type: application/json');
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {

/**-----Post request (request for edit a days calculation) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['IdDayCalculation']) && isset($_POST['IdApp']) && isset($_POST['IdCreatorEmployee']) && isset($_POST['DaysInitialStage']) && isset($_POST['DaysSurveillance']) && isset($_POST['DaysRR']) && isset($_POST['DaysCalculationDetail']) && isset($_POST['t'])){
               if (TokenTool::isValid($_POST['t'])){
                  $idDayCalculation = $_POST['IdDayCalculation'];
                  $idApp = $_POST['IdApp'];
                  $idCreator = $_POST['IdCreatorEmployee'];
                  $daysInitialStage = $_POST['DaysInitialStage'];
                  $daysSurveillance = $_POST['DaysSurveillance'];
                  $daysRR = $_POST['DaysRR'];
                  $daysCalculationDetail = json_encode($_POST['DaysCalculationDetail'], true);
                  $daysCalculationDetail = json_decode($_POST['DaysCalculationDetail'], true);
                  
                  $query = "UPDATE days_calculation SET IdCreatorEmployee = $idCreator, DaysInitialStage = $daysInitialStage, DaysSurveillance = $daysSurveillance, DaysRR = $daysRR";

                  if (isset($_POST['DayCalculationApproved'])){
                     $idReviewerEmployee = $_POST['IdReviewerEmployee'];
                     $dayCalculationApproved = $_POST['DayCalculationApproved'];
                     if ($dayCalculationApproved === '1'){
                        $date = new DateTime("now");
                        $currentDate = $date->format('Y-m-d H:i:s');
                        $query .= ", IdReviewerEmployee = $idReviewerEmployee, DayCalculationApproved = $dayCalculationApproved, DayCalculationApprovedDate = '$currentDate'";
                     } else {
                        $query .= ", IdReviewerEmployee = $idReviewerEmployee, DayCalculationApproved = $dayCalculationApproved, DayCalculationApprovedDate = null";
                     }
                  }

                  if (isset($_POST['DaysCalculationStatus'])) {
                     $status = $_POST['DaysCalculationStatus'];
                     $query .= ", DaysCalculationStatus = '$status'";
                  }

                  $query .= " WHERE IdDayCalculation = $idDayCalculation";

                  $dbConnection->beginTransaction();//starts a transaction in the database
                  
                  try {
                     $updateDaysCalculation = $dbConnection->prepare($query);
                     $updateDaysCalculation->execute();
                  } catch (\Throwable $th) {
                     $dbConnection->rollBack();
                     header("HTTP/1.1 409 Conflict");
                     echo json_encode(array(
                           'Request_Status' => 'Error',
                           'Request_Message' => 'Header bad request:'. $query
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

                           $exist = isset($detail['IdDayCalculationDetail']);
                           if ($exist) {
                              $idDayCalculationDetail = $detail['IdDayCalculationDetail'];
                              $initialMD = $detail['InitialMD'];
                              $numberEmployees = $detail['NumberEmployees'];
                              $daysInitialStage = $detail['DaysInitialStage'];
                              $daysSurveillance = $detail['DaysSurveillance'];
                              $daysRR = $detail['DaysRR'];

                              $query = "UPDATE days_calculation_detail9k SET InitialMD = $initialMD, NumberEmployees = $numberEmployees, DaysInitialStage = $daysInitialStage, DaysSurveillance = $daysSurveillance, DaysRR = $daysRR";

                              if (isset($detail['SystemComplex'])) {
                                 $tag = $detail['SystemComplex'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['SystemComplexComment'];
                                 $query .= ", SystemComplex = $tagValue, SystemComplexComment = '$comment'";
                              }
                              if (isset($detail['ComplicatedLogistic'])) {
                                 $tag = $detail['ComplicatedLogistic'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ComplicatedLogisticComment'];
                                 $query .= ", ComplicatedLogistic = $tagValue, ComplicatedLogisticComment = '$comment'";
                              }
                              if (isset($detail['InterestedParties'])) {
                                 $tag = $detail['InterestedParties'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['InterestedPartiesComment'];
                                 $query .= ", InterestedParties = $tagValue, InterestedPartiesComment = '$comment'";
                              }
                              if (isset($detail['ScopeRegulation'])) {
                                 $tag = $detail['ScopeRegulation'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ScopeRegulationComment'];
                                 $query .= ", ScopeRegulation = $tagValue, ScopeRegulationComment = '$comment'";
                              }
                              if (isset($detail['DesignResponsability'])) {
                                 $tag = $detail['DesignResponsability'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['DesignResponsabilityComment'];
                                 $query .= ", DesignResponsability = $tagValue, DesignResponsabilityComment = '$comment'";
                              }
                              if (isset($detail['DifferentLanguage'])) {
                                 $tag = $detail['DifferentLanguage'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['DifferentLanguageComment'];
                                 $query .= ", DifferentLanguage = $tagValue, DifferentLanguageComment = '$comment'";
                              }
                              if (isset($detail['Maturity'])) {
                                 $tag = $detail['Maturity'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['MaturityComment'];
                                 $query .= ", Maturity = $tagValue, MaturityComment = '$comment'";
                              }
                              if (isset($detail['AutomationLevel'])) {
                                 $tag = $detail['AutomationLevel'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['AutomationLevelComment'];
                                 $query .= ", AutomationLevel = $tagValue, AutomationLevelComment = '$comment'";
                              }

                              $query .= " WHERE IdDayCalculationDetail = $idDayCalculationDetail";
                           } else {
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
                           }
                           try {
                              $saveDetail = $dbConnection->prepare($query);
                              $saveDetail->execute();
                              
                           } catch (\Throwable $th) {
                              $dbConnection->rollBack();
                              header("HTTP/1.1 409 Conflict");
                              echo json_encode(array(
                                 'Request_Status' => 'Error',
                                 'Request_Message' => 'Detail bad request:'. $th
                              ));
                              exit();
                           }
                        }
                        $dbConnection->commit();
                              
                        echo json_encode(array(
                           'Request_Status' => 'Saved',
                           'Request_Message' => 'Days Calculation Saved'
                        ));
                        break;

                     case '14k':
                        for ($i=0; $i < count($daysCalculationDetail); $i++) { 
                           $detail = $daysCalculationDetail[$i];

                           $exist = isset($detail['IdDayCalculationDetail']);
                           if ($exist) {
                              $idDayCalculationDetail = $detail['IdDayCalculationDetail'];
                              $initialMD = $detail['InitialMD'];
                              $numberEmployees = $detail['NumberEmployees'];
                              $daysInitialStage = $detail['DaysInitialStage'];
                              $daysSurveillance = $detail['DaysSurveillance'];
                              $daysRR = $detail['DaysRR'];

                              $query = "UPDATE days_calculation_detail14k SET InitialMD = $initialMD, NumberEmployees = $numberEmployees, DaysInitialStage = $daysInitialStage, DaysSurveillance = $daysSurveillance, DaysRR = $daysRR";

                              if (isset($detail['SystemComplex'])) {
                                 $tag = $detail['SystemComplex'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['SystemComplexComment'];
                                 $query .= ", SystemComplex = $tagValue, SystemComplexComment = '$comment'";
                              }
                              if (isset($detail['ComplicatedLogistic'])) {
                                 $tag = $detail['ComplicatedLogistic'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ComplicatedLogisticComment'];
                                 $query .= ", ComplicatedLogistic = $tagValue, ComplicatedLogisticComment = '$comment'";
                              }
                              if (isset($detail['InterestedParties'])) {
                                 $tag = $detail['InterestedParties'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['InterestedPartiesComment'];
                                 $query .= ", InterestedParties = $tagValue, InterestedPartiesComment = '$comment'";
                              }
                              if (isset($detail['ScopeRegulation'])) {
                                 $tag = $detail['ScopeRegulation'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ScopeRegulationComment'];
                                 $query .= ", ScopeRegulation = $tagValue, ScopeRegulationComment = '$comment'";
                              }
                              if (isset($detail['OutsourcedProcesses'])) {
                                 $tag = $detail['OutsourcedProcesses'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['OutsourcedProcessesComment'];
                                 $query .= ", OutsourcedProcesses = $tagValue, OutsourcedProcessesComment = '$comment'";
                              }
                              if (isset($detail['IndirectAspects'])) {
                                 $tag = $detail['IndirectAspects'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['IndirectAspectsComment'];
                                 $query .= ", IndirectAspects = $tagValue, IndirectAspectsComment = '$comment'";
                              }
                              if (isset($detail['DifferentLanguage'])) {
                                 $tag = $detail['DifferentLanguage'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['DifferentLanguageComment'];
                                 $query .= ", DifferentLanguage = $tagValue, DifferentLanguageComment = '$comment'";
                              }
                              if (isset($detail['Maturity'])) {
                                 $tag = $detail['Maturity'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['MaturityComment'];
                                 $query .= ", Maturity = $tagValue, MaturityComment = '$comment'";
                              }
                              if (isset($detail['AutomationLevel'])) {
                                 $tag = $detail['AutomationLevel'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['AutomationLevelComment'];
                                 $query .= ", AutomationLevel = $tagValue, AutomationLevelComment = '$comment'";
                              }

                              $query .= " WHERE IdDayCalculationDetail = $idDayCalculationDetail";
                           } else {
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
                           }
                           try {
                              $saveDetail = $dbConnection->prepare($query);
                              $saveDetail->execute();
                              
                           } catch (\Throwable $th) {
                              $dbConnection->rollBack();
                              header("HTTP/1.1 409 Conflict");
                              echo json_encode(array(
                                 'Request_Status' => 'Error',
                                 'Request_Message' => 'Detail bad request:'. $th
                              ));
                              exit();
                           }
                        }
                        $dbConnection->commit();
                              
                        echo json_encode(array(
                           'Request_Status' => 'Saved',
                           'Request_Message' => 'Days Calculation Saved'
                        ));
                        break;

                     case '22k':
                        for ($i=0; $i < count($daysCalculationDetail); $i++) { 
                           $detail = $daysCalculationDetail[$i];

                           $exist = isset($detail['IdDayCalculationDetail']);
                           if ($exist) {
                              $idDayCalculationDetail = $detail['IdDayCalculationDetail'];
                              $initialMD = $detail['InitialMD'];
                              $numberEmployees = $detail['NumberEmployees'];
                              $daysInitialStage = $detail['DaysInitialStage'];
                              $daysSurveillance = $detail['DaysSurveillance'];
                              $daysRR = $detail['DaysRR'];

                              $query = "UPDATE days_calculation_detail22k SET InitialMD = $initialMD, NumberEmployees = $numberEmployees, DaysInitialStage = $daysInitialStage, DaysSurveillance = $daysSurveillance, DaysRR = $daysRR";

                              if (isset($detail['FTEHACCP'])) {
                                 $tag = $detail['FTEHACCP'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['FTEHACCPComment'];
                                 $increment = $detail['FTEHACCPIncrement'];
                                 $query .= ", FTEHACCP = $tagValue, FTEHACCPComment = '$comment', FTEHACCPIncrement = $increment";
                              }
                              if (isset($detail['FTEHACCPPlus'])) {
                                 $tag = $detail['FTEHACCPPlus'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['FTEHACCPPlusComment'];
                                 $increment = $detail['FTEHACCPPlusIncrement'];
                                 $query .= ", FTEHACCPPlus = $tagValue, FTEHACCPPlusComment = '$comment', FTEHACCPPlusIncrement = $increment";
                              }
                              if (isset($detail['AuditPreparation'])) {
                                 $tag = $detail['AuditPreparation'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['AuditPreparationComment'];
                                 $increment = $detail['AuditPreparationIncrement'];
                                 $query .= ", AuditPreparation = $tagValue, AuditPreparationComment = '$comment', AuditPreparationIncrement = $increment";
                              }
                              if (isset($detail['AuditReport'])) {
                                 $tag = $detail['AuditReport'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['AuditReportComment'];
                                 $increment = $detail['AuditReportIncrement'];
                                 $query .= ", AuditReport = $tagValue, AuditReportComment = '$comment', AuditReportIncrement = $increment";
                              }
                              if (isset($detail['UseInterpreter'])) {
                                 $tag = $detail['UseInterpreter'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['UseInterpreterComment'];
                                 $increment = $detail['UseInterpreterIncrement'];
                                 $query .= ", UseInterpreter = $tagValue, UseInterpreterComment = '$comment', UseInterpreterIncrement = $increment";
                              }
                              if (isset($detail['OffSiteStorage'])) {
                                 $tag = $detail['OffSiteStorage'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['OffSiteStorageComment'];
                                 $increment = $detail['OffSiteStorageIncrement'];
                                 $query .= ", OffSiteStorage = $tagValue, OffSiteStorageComment = '$comment', OffSiteStorageIncrement = $increment";
                              }
                              if (isset($detail['CertificationControlled'])) {
                                 $tag = $detail['CertificationControlled'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['CertificationControlledComment'];
                                 $increment = $detail['CertificationControlledIncrement'];
                                 $query .= ", CertificationControlled = $tagValue, CertificationControlledComment = '$comment', CertificationControlledIncrement = $increment";
                              }

                              $query .= " WHERE IdDayCalculationDetail = $idDayCalculationDetail";
                           } else {
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
                           }
                           try {
                              $saveDetail = $dbConnection->prepare($query);
                              $saveDetail->execute();
                           } catch (\Throwable $th) {
                              $dbConnection->rollBack();
                              header("HTTP/1.1 409 Conflict");
                              echo json_encode(array(
                                 'Request_Status' => 'Error',
                                 'Request_Message' => 'Detail bad request:'. $th
                              ));
                              exit();
                           }
                        }
                        $dbConnection->commit();
                              
                        echo json_encode(array(
                           'Request_Status' => 'Saved',
                           'Request_Message' => 'Days Calculation Saved'
                        ));
                        break;
                     
                     case '45k':
                        for ($i=0; $i < count($daysCalculationDetail); $i++) { 
                           $detail = $daysCalculationDetail[$i];

                           $exist = isset($detail['IdDayCalculationDetail']);
                           if ($exist) {
                              $idDayCalculationDetail = $detail['IdDayCalculationDetail'];
                              $initialMD = $detail['InitialMD'];
                              $numberEmployees = $detail['NumberEmployees'];
                              $daysInitialStage = $detail['DaysInitialStage'];
                              $daysSurveillance = $detail['DaysSurveillance'];
                              $daysRR = $detail['DaysRR'];

                              $query = "UPDATE days_calculation_detail45k SET InitialMD = $initialMD, NumberEmployees = $numberEmployees, DaysInitialStage = $daysInitialStage, DaysSurveillance = $daysSurveillance, DaysRR = $daysRR";

                              if (isset($detail['SystemComplex'])) {
                                 $tag = $detail['SystemComplex'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['SystemComplexComment'];
                                 $query .= ", SystemComplex = $tagValue, SystemComplexComment = '$comment'";
                              }
                              if (isset($detail['ComplicatedLogistic'])) {
                                 $tag = $detail['ComplicatedLogistic'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ComplicatedLogisticComment'];
                                 $query .= ", ComplicatedLogistic = $tagValue, ComplicatedLogisticComment = '$comment'";
                              }
                              if (isset($detail['InterestedParties'])) {
                                 $tag = $detail['InterestedParties'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['InterestedPartiesComment'];
                                 $query .= ", InterestedParties = $tagValue, InterestedPartiesComment = '$comment'";
                              }
                              if (isset($detail['ScopeRegulation'])) {
                                 $tag = $detail['ScopeRegulation'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['ScopeRegulationComment'];
                                 $query .= ", ScopeRegulation = $tagValue, ScopeRegulationComment = '$comment'";
                              }
                              if (isset($detail['SmallLargePersonnel'])) {
                                 $tag = $detail['SmallLargePersonnel'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['SmallLargePersonnelComment'];
                                 $query .= ", SmallLargePersonnel = $tagValue, SmallLargePersonnelComment = '$comment'";
                              }
                              if (isset($detail['IndirectAspects'])) {
                                 $tag = $detail['IndirectAspects'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['IndirectAspectsComment'];
                                 $query .= ", IndirectAspects = $tagValue, IndirectAspectsComment = '$comment'";
                              }
                              if (isset($detail['DifferentLanguage'])) {
                                 $tag = $detail['DifferentLanguage'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['DifferentLanguageComment'];
                                 $query .= ", DifferentLanguage = $tagValue, DifferentLanguageComment = '$comment'";
                              }
                              if (isset($detail['Maturity'])) {
                                 $tag = $detail['Maturity'];
                                 $tagValue = 0;
                                 if ($tag) {
                                    $tagValue = 1;
                                 }
                                 
                                 $comment = $detail['MaturityComment'];
                                 $query .= ", Maturity = $tagValue, MaturityComment = '$comment'";
                              }

                              $query .= " WHERE IdDayCalculationDetail = $idDayCalculationDetail";
                           } else {
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
                           }
                           try {
                              $saveDetail = $dbConnection->prepare($query);
                              $saveDetail->execute();
                              
                           } catch (\Throwable $th) {
                              $dbConnection->rollBack();
                              header("HTTP/1.1 409 Conflict");
                              echo json_encode(array(
                                 'Request_Status' => 'Error',
                                 'Request_Message' => 'Detail bad request:'. $th
                              ));
                              exit();
                           }
                        }
                        $dbConnection->commit();
                              
                        echo json_encode(array(
                           'Request_Status' => 'Saved',
                           'Request_Message' => 'Days Calculation Saved'
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
            header("Allow: POST, OPTIONS");
            break;
        
        default:
            header("HTTP/1.1 405 Allow; POST, OPTIONS");
            exit();
            break;
    }
