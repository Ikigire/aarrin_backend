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
            if (isset($_GET['t']) && isset($_GET['IdDayCalculation'])) {
               if (TokenTool::isValid($_GET['t'])) {
                  $idDayCalculation = $_GET['IdDayCalculation'];
                  $query = "SELECT * FROM proposals WHERE IdDayCalculation = $idDayCalculation;";
                  $consult = $dbConnection->prepare($query);
                  $consult->execute();
                  if ($consult->rowCount() > 0) {
                     $consult->SetFetchMode(PDO::FETCH_ASSOC);
                     $proposalData = $consult->fetchAll()[0];

                     $idProposal = $proposalData['IdProposal'];

                     $query = "SELECT * FROM proposal_detail WHERE IdProposal = $idProposal;";
                     $consult = $dbConnection->prepare($query);
                     $consult->execute();
                     $consult->SetFetchMode(PDO::FETCH_ASSOC);
                     $proposalData['ProposalDetail'] = $consult->fetchAll();
                     
                     header("HTTP/1.1 200 Ok");
                     
                     echo json_encode($proposalData);
                  } else {
                     header("HTTP/1.1 404 Not Found");
                     exit();
                  }
               } else {
                  header("HTTP/1.1 401 Unhautorized");
               }
            } elseif (isset($_GET['t']) && isset($_GET['IdProposal'])) {
               if (TokenTool::isValid($_GET['t'])) {
                  $idProposal = $_GET['IdProposal'];
                  $query = "SELECT * FROM proposals WHERE IdProposal = $idProposal;";
                  $consult = $dbConnection->prepare($query);
                  $consult->execute();
                  if ($consult->rowCount() > 0) {
                     $consult->SetFetchMode(PDO::FETCH_ASSOC);
                     $proposalData = $consult->fetchAll()[0];

                     $query = "SELECT * FROM proposal_detail WHERE IdProposal = $idProposal;";
                     $consult = $dbConnection->prepare($query);
                     $consult->execute();
                     $consult->SetFetchMode(PDO::FETCH_ASSOC);
                     $proposalData['ProposalDetail'] = $consult->fetchAll();
                     
                     header("HTTP/1.1 200 Ok");
                     
                     echo json_encode($proposalData);
                  } else {
                     header("HTTP/1.1 404 Not Found");
                     exit();
                  }
               } else {
                  header("HTTP/1.1 401 Unhautorized");
               }
            } 
            // elseif (isset($_GET['t']) && isset($_GET['IdCompany'])) {
            //    if (TokenTool::isValid($_GET['t'])) {
            //       $idCompany = $_GET['IdCompany'];
            //       $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.NumberEmployees, app.AppDate, app.AppStatus, dc.*, emp1.EmployeeName + ' ' + emp1.EmployeeLastName AS 'EmployeeCreator', emp1.EmployeePhoto AS 'EmployeeCreatorPhoto', emp2.EmployeeName + ' ' + emp2.EmployeeLastName AS 'EmployeeReviewer', emp2.EmployeePhoto AS 'EmployeeReviewerPhoto' FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN personal AS emp1 ON dc.IdCreatorEmployee = emp1.IdEmployee JOIN personal AS emp2 ON dc.IdReviewerEmployee = emp2.IdEmployee WHERE app.IdCompany = $idCompany ORDER BY dc.DayCalculationDate DESC;";
            //       $consult = $dbConnection->prepare($query);
            //       $consult->execute();
            //       if ($consult->rowCount()) {
            //             $consult->setFetchMode(PDO::FETCH_ASSOC);
            //             header("HTTP/1.1 200 OK");
                        
            //             echo json_encode($consult->fetchAll());
            //       } else {
            //             header("HTTP/1.1 404 Not Found");
            //       }
            //    } else {
            //       header("HTTP/1.1 401 Unhautorized");
            //    }
            // } elseif (isset($_GET['t'])) {
            //    if (TokenTool::isValid($_GET['t'])) {
            //       $query = "SELECT c.CompanyName, c.CompanyLogo, co.ContactName, co.ContactPhone, co.ContactEmail, co.ContactCharge, co.ContactPhoto, s.ServiceShortName, sec.IAF_MD5, sec.SectorCluster, sec.SectorCategory, sec.SectorSubcategory, sec.SectorRiskLevel, app.NumberEmployees, app.AppDate, app.AppStatus, dc.*, emp1.EmployeeName + ' ' + emp1.EmployeeLastName AS 'EmployeeCreator', emp1.EmployeePhoto AS 'EmployeeCreatorPhoto', emp2.EmployeeName + ' ' + emp2.EmployeeLastName AS 'EmployeeReviewer', emp2.EmployeePhoto AS 'EmployeeReviewerPhoto' FROM applications AS app JOIN companies AS c ON app.IdCompany = c.IdCompany JOIN contacts AS co on app.IdContact = co.IdContact JOIN services as s ON app.IdService = s.IdService JOIN sectors As sec ON app.IdSector = sec.IdSector JOIN days_calculation AS dc ON dc.IdApp = app.IdApp JOIN personal AS emp1 ON dc.IdCreatorEmployee = emp1.IdEmployee JOIN personal AS emp2 ON dc.IdReviewerEmployee = emp2.IdEmployee ORDER BY app.AppDate DESC;";
            //       $consult = $dbConnection->prepare($query);
            //       $consult->execute();
            //       $consult->setFetchMode(PDO::FETCH_ASSOC);
            //       header("HTTP/1.1 200 OK");
                  
            //       echo json_encode($consult->fetchAll());
            //    } else {
            //       header("HTTP/1.1 401 Unhautorized");
            //    }
            // } 
            else {
               header("HTTP/1.1 412 Precondition Failed");
            }
            
            break;


/**-----Post request (request for create a Days calcuation (Admin)) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['IdDayCalculation']) && isset($_POST['IdProposalCreator']) && isset($_POST['TotalInvestment']) && isset($_POST['ProposalDetail']) && isset($_POST['t'])){
               if (TokenTool::isValid($_POST['t'])){
                  $idDayCalculation = $_POST['IdDayCalculation'];
                  $idProposalCreator = $_POST['IdProposalCreator'];
                  $totalInvestment = $_POST['TotalInvestment'];
                  $date = new DateTime("now");
                  $currentDate = $date->format('Y-m-d H:i:s');
                  $date->add(new DateInterval("P3M"));
                  $expirationDate = $date->format('Y-m-d H:i:s');
                  $proposalDetail = json_decode($_POST['ProposalDetail'], true);

                  $dbConnection->beginTransaction();//starts a transaction in the database

                  $initialPart = "INSERT INTO proposals (IdDayCalculation, IdProposalCreator, TotalInvestment, ProposalDate, ProposalExpirationDate";
                  $values ="VALUES ($idDayCalculation, $idProposalCreator, $totalInvestment, '$currentDate', '$expirationDate'";
                  
                  if (isset($_POST['CurrencyType'])) {
                     $tag = $_POST['CurrencyType'];
                     
                     $initialPart .= ", CurrencyType";
                     $values .= ", '$tag'";
                  }
                  if (isset($_POST['IssueInitialStage'])) {
                     $tag = $_POST['IssueInitialStage'];
                     
                     $initialPart .= ", IssueInitialStage";
                     $values .= ", '$tag'";
                  }
                  if (isset($_POST['IssueSurveillance1'])) {
                     $tag = $_POST['IssueSurveillance1'];
                     
                     $initialPart .= ", IssueSurveillance1";
                     $values .= ", '$tag'";
                  }
                  if (isset($_POST['IssueSurveillance2'])) {
                     $tag = $_POST['IssueSurveillance2'];
                     
                     $initialPart .= ", IssueSurveillance2";
                     $values .= ", '$tag'";
                  }
                  if (isset($_POST['IssueRR'])) {
                     $tag = $_POST['IssueRR'];
                     
                     $initialPart .= ", IssueRR";
                     $values .= ", '$tag'";
                  }

                  $query = $initialPart. ") ". $values. ")";

                  try {
                     $createProposal = $dbConnection->prepare($query);
                     $createProposal->execute();
                     $idProposal = $dbConnection->lastInsertId();
                  } catch (\Throwable $th) {
                     $dbConnection->rollBack();
                     header("HTTP/1.1 409 Conflict");
                     echo json_encode(array(
                           'Request_Status' => 'Error',
                           'Request_Message' => 'Header bad request:'
                     ));
                     exit();
                  }
                  
                  for ($i=0; $i < count($proposalDetail); $i++) {
                     $detail = $proposalDetail[$i];

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
            header("Allow: GET, POST, OPTIONS");
            break;
        
        default:
            header("HTTP/1.1 405 Allow; GET, POST, OPTIONS");
            exit();
            break;
    }
