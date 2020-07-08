<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header('Content-Type: application/json');
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {

/**-----Post request (request for create a Days calcuation (Admin)) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['IdProposal']) && isset($_POST['IdDayCalculation']) && isset($_POST['IdProposalCreator']) && isset($_POST['TotalInvestment']) && isset($_POST['ProposalDetail']) && isset($_POST['t'])){
               if (TokenTool::isValid($_POST['t'])){
                  $idProposal = $_POST['IdProposal'];
                  $idDayCalculation = $_POST['IdDayCalculation'];
                  $idProposalCreator = $_POST['IdProposalCreator'];
                  $totalInvestment = $_POST['TotalInvestment'];
                  $date = new DateTime("now");
                  $currentDate = $date->format('Y-m-d H:i:s');
                  $proposalDetail = json_decode($_POST['ProposalDetail'], true);

                  $dbConnection->beginTransaction();//starts a transaction in the database

                  $query = "UPDATE proposals SET TotalInvestment = $totalInvestment";

                  if (isset($_POST['IdProposalReviewer'])) {
                     $value = $_POST['IdProposalReviewer'];
                     $query .= ", IdProposalReviewer = $value";
                  }
                  if (isset($_POST['ProposalApproved'])) {
                     $value = $_POST['ProposalApproved'];
                     if ($value) {
                        $value = 1;
                     } else {
                        $value = 0;
                     }
                     $query .= ", ProposalApproved = $value";
                     if ($value === 1) {
                        if (!isset($_POST['ProposalApprovedDate'])){
                           $query .= ", ProposalApprovedDate = '$currentDate'";
                        }
                     } else {
                        $query .= ", ProposalApprovedDate = null";
                     }
                  }
                  if (isset($_POST['ProposalClientApproved'])) {
                     $value = $_POST['ProposalClientApproved'];
                     if ($value) {
                        $value = 1;
                     } else {
                        $value = 0;
                     }
                     $query .= ", ProposalClientApproved = $value";
                     
                     if (isset($_FILES['proposalFile'])) {
                        $f = $_FILES['proposalFile'];
                        $path = "https://aarrin.com/mobile/app_resources/proposals/";
                        
                        $auxQuery = "SELECT c.CompanyName, s.ServiceStandard  FROM companies AS c JOIN applications AS app on app.IdCompany = c.IdCompany JOIN services AS s on app.IdService = s.IdService JOIN days_calculation AS dc on dc.IdApp = app.IdApp JOIN proposals AS p on dc.IdDayCalculation = p.IdDayCalculation WHERE p.IdProposal = $idProposal LIMIT 1";
                        $consult = $dbConnection->prepare($auxQuery);
                        $consult->execute();
                        $consult->setFetchMode(PDO::FETCH_ASSOC);
                        $auxiliarData = $consult->fetchAll()[0];

                        $ext = pathinfo($f['name'])['extension'];
                        $name = "Proposal_for_". str_replace(' ', '_', $auxiliarData['ServiceStandard']). "(". str_replace(' ', '_', $auxiliarData['CompanyName']). ")(Signed).". $ext;

                        $pathToMove = __DIR__. "/../../../../app_resources/proposals/". $auxiliarData['ServiceStandard']. "/". $auxiliarData['CompanyName'];

                        if (!file_exists($pathToMove)) {
                           mkdir($pathToMove, 0777, true);
                        }

                        $path .= $auxiliarData['ServiceStandard']. "/". $auxiliarData['CompanyName']. "/$name";
                        $pathToMove .= "/$name";

                        if (move_uploaded_file($f['tmp_name'], $pathToMove)) {
                           $query .= ", FileUrl = '$path'";
                        }
                     }

                     if ($value === 1) {
                        $query .= ", ProposalClientApprovedDate = '$currentDate'";
                     } else {
                        $query .= ", ProposalClientApprovedDate = null";
                     }
                  }
                  if (isset($_POST['CurrencyType'])) {
                     $value = $_POST['CurrencyType'];
                     $query .= ", CurrencyType = '$value'";
                  }
                  if (isset($_POST['ProposalStatus'])) {
                     $value = $_POST['ProposalStatus'];
                     $query .= ", ProposalStatus = '$value'";
                  }
                  if (isset($_POST['IssueInitialStage'])) {
                     $tag = $_POST['IssueInitialStage'];
                     
                     $query .= ", IssueInitialStage = '$tag'";
                  }
                  if (isset($_POST['IssueSurveillance1'])) {
                     $tag = $_POST['IssueSurveillance1'];
                     
                     $query .= ", IssueSurveillance1 = '$tag'";
                  }
                  if (isset($_POST['IssueSurveillance2'])) {
                     $tag = $_POST['IssueSurveillance2'];
                     
                     $query .= ", IssueSurveillance2 = '$tag'";
                  }
                  if (isset($_POST['IssueRR'])) {
                     $tag = $_POST['IssueRR'];
                     
                     $query .= ", IssueRR = '$tag'";
                  }

                  $query .= " WHERE IdProposal = $idProposal";
                  
                  try {
                     $updateProposal = $dbConnection->prepare($query);
                     $updateProposal->execute();
                  } catch (\Throwable $th) {
                     $dbConnection->rollBack();
                     header("HTTP/1.1 409 Conflict");
                     echo json_encode(array(
                           'Request_Status' => 'Error',
                           'Request_Message' => 'Header bad request: ' . $query
                     ));
                     exit();
                  }
                  
                  for ($i=0; $i < count($proposalDetail); $i++) {
                     $detail = $proposalDetail[$i];
                     $exist = isset($detail['IdProposalDetail']);
                     if ($exist) {
                        $idProposalDetail = $detail['IdProposalDetail'];
                        $daysStage1 = $detail['DaysStage1'];
                        $daysStage2 = $detail['DaysStage2'];
                        $daysSurveillance1 = $detail['DaysSurveillance1'];
                        $daysSurveillance2 = $detail['DaysSurveillance2'];
                        $daysRR = $detail['DaysRR'];
                        $investmentStage1 = $detail['InvestmentStage1'];
                        $investmentStage2 = $detail['InvestmentStage2'];
                        $investmentSurveillance1 = $detail['InvestmentSurveillance1'];
                        $investmentSurveillance2 = $detail['InvestmentSurveillance2'];
                        $investmentRR = $detail['InvestmentRR'];
                        
                        $query = "UPDATE proposal_detail SET DaysStage1 = $daysStage1, DaysStage2 = $daysStage2, DaysSurveillance1 = $daysSurveillance1, DaysSurveillance2 = $daysSurveillance2, DaysRR = $daysRR, InvestmentStage1 = $investmentStage1, InvestmentStage2 = $investmentStage2, InvestmentSurveillance1 = $investmentSurveillance1, InvestmentSurveillance2 = $investmentSurveillance2, InvestmentRR = $investmentRR";

                        $query .= " WHERE IdProposalDetail = $idProposalDetail";
                     } else {
                        $daysStage1 = $detail['DaysStage1'];
                        $daysStage2 = $detail['DaysStage2'];
                        $daysSurveillance1 = $detail['DaysSurveillance1'];
                        $daysSurveillance2 = $detail['DaysSurveillance2'];
                        $daysRR = $detail['DaysRR'];
                        $investmentStage1 = $detail['InvestmentStage1'];
                        $investmentStage2 = $detail['InvestmentStage2'];
                        $investmentSurveillance1 = $detail['InvestmentSurveillance1'];
                        $investmentSurveillance2 = $detail['InvestmentSurveillance2'];
                        $investmentRR = $detail['InvestmentRR'];
                        
                        $initialPart = "INSERT INTO proposal_detail (IdProposal, DaysStage1, DaysStage2, DaysSurveillance1, DaysSurveillance2, DaysRR, InvestmentStage1, InvestmentStage2, InvestmentSurveillance1, InvestmentSurveillance2, InvestmentRR";
                        $values = "VALUES ($idProposal, $daysStage1, $daysStage2, $daysSurveillance1, $daysSurveillance2, $daysRR, $investmentStage1, $investmentStage2, $investmentSurveillance1, $investmentSurveillance2, $investmentRR";

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
                           'Request_Message' => 'Detail bad request:'. $query
                        ));
                        exit();
                     }
                  }

                  $dbConnection->commit();
                        
                  echo json_encode(array(
                     'Request_Status' => 'Saved',
                     'Request_Message' => 'Proposal Saved'
                  ));
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
