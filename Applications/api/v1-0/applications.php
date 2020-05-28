<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table) ----------------------------------------------------------------*/
        case 'GET':
            $appDetail = json_encode($_GET['AppDetail']); echo json_last_error_msg();
            var_dump($appDetail);
            break;


/**-----Post request (request for create a new employee (Admin)) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['IdCompany']) && isset($_POST['IdContact']) && isset($_POST['IdService']) && isset($_POST['IdSector']) && isset($_POST['AppLenguage']) && isset($_POST['NumberEmployees']) && isset($_POST['AppDetail']) && isset($_POST['AppComplement']) && isset($_POST['t'])){
                if (($_POST['t'])){
                    $idCompany = $_POST['IdCompany'];
                    $idContact = $_POST['IdContact'];
                    $idService = $_POST['IdService'];
                    $idSector = $_POST['IdSector'];
                    $appLenguage = $_POST['AppLenguage'];
                    $numberEmployees = $_POST['NumberEmployees'];
                    $appDetail = json_encode($_POST['AppDetail'], true);
                    $appDetail = json_decode($_POST['AppDetail'], true);
                    //$array = json_decode($_POST['AppDetail'], true);
                    $appComplement = json_decode($_POST['AppComplement'], true);
                    $initialPart = "INSERT INTO applications (IdCompany, IdContact, IdService, IdSector, AppLenguage, NumberEmployees";
                    $values = "VALUES ($idCompany, $idContact, $idService, $idSector, '$appLenguage', $numberEmployees";
                    echo `weas "raras"`;
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
                    echo "<h3>Inicia Transaccion</h3><br>";
                    echo $query."<br>Guardando Detalle<br>";
                    $idApp = 0;
                    
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

                        echo $query."<br>";
                    }
                    
                    var_dump($appDetail);
                    echo "<br><br>";
                    var_dump($appComplement);

                }
                else{
                    header("HTTP/1.0 401 Unauthorized");
                }
                exit();
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
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
            header("HTTP/1.0 405 Allow; GET, POST, PUT, PATCH");
            exit();
            break;
    }
