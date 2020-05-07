<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table) ----------------------------------------------------------------*/
        case 'GET':
            if(isset($_GET['email']) && isset($_GET['password'])){//If is a request to log-in
                $employeeEmail = $_GET['email'];
                $employeePassword = $_GET['password'];
                $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto FROM personal WHERE EmployeeEmail = '$employeeEmail' AND EmployeePassword = AES_ENCRYPT('$employeePassword','@Empleado')";
                $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                $consult->execute();
                if($consult->rowCount()){//if is there any result for the query then
                    $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                    $employeeData = $consult->fetchAll()[0];
                    
                    $dataForToken = array(
                        'IdEmployee' => $employeeData['IdEmployee'],
                        'EmployeeName' => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                        'EmployeeRFC' => $employeeData['EmployeeRFC'],
                        'EmployeeEmail' => $employeeData['EmployeeEmail']
                    );
                    $employeeData['Token'] = TokenTool::createToken($dataForToken);
                    header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                    header('Content-Type: application/json'); //now define the content type to get back
                    echo json_encode($employeeData); //to finalize the server return the data
                    exit();
                }else{//if there isn't any result for the query
                    header("HTTP/1.0 404 Not found");//the server advice to not found result
                    exit();
                }
            }elseif(isset($_GET['idEmployee']) && isset($_GET['t']) && TokenTool::isValid($_GET['t'])){
                $idEmployee = $_GET['idEmployee'];
                $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto FROM personal WHERE IdEmployee = $idEmployee";
                $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                $consult->execute(); //execute the query
                $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                header('Content-Type: application/json'); //now define the content type to get back
                $employeeData = $consult->fetchAll()[0];
                $dataForToken = array(
                    'IdEmployee' => $employeeData['IdEmployee'],
                    'EmployeeName' => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                    'EmployeeRFC' => $employeeData['EmployeeRFC'],
                    'EmployeeEmail' => $employeeData['EmployeeEmail']
                );
                $employeeData['Token'] = TokenTool::createToken($dataForToken);
                echo json_encode($companyData); //to finalize the server return the data
            }else{/**email doesn't exist, then it's a request for the whole information */
                if (isset($_GET['t']) && TokenTool::isValid($_GET['t'])){
                    $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, EmployeePhoto FROM personal;";
                    $consult = $dbConnection->prepare($query);//this line prepare the query for execute
                    $consult->execute();//execute the query
                    if ($consult->rowCount()) {
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                        header('Content-Type: application/json'); //now define the content type to get back
                        echo json_encode($consult->fetchAll()); //to finalize the server return the data
                    }else{
                        header("HTTP/1.0 500 Internal server error");//the server advice to not found result
                    }
                }
                else {
                    header("HTTP/1.0 401 Unauthorized");
                }
                exit();
            }
            break;


/**-----Post request (request for create a new employee (Admin)) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['contract']) && isset($_POST['charge']) && isset($_POST['email']) && isset($_POST['rfc']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    //get the sended data
                    $employeeName = $_POST['name'];
                    $employeeLastName = $_POST['lastname'];
                    $employeeContractYear = $_POST['contract'];
                    $employeeCharge = $_POST['charge'];
                    $employeeEmail = $_POST['email'];
                    $employeeRFC = $_POST['rfc'];
                    
                    $STR = 'QWERTYUIOPASDFGHJKLZXCVBNM0123456789/*-+.$?';
                    $employeePassword = '';

                    for ($i=0; $i < 8; $i++) {
                        $employeePassword .= substr($STR, rand(0,42),1);
                    }

                    $query = "INSERT INTO personal(EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, EmployeePassword) VALUES ('$employeeName', '$employeeLastName', '', '0000-00-00', $employeeContractYear, '$employeeCharge', '', '', '$employeeEmail', '', '$companyRFC', AES_ENCRYPT('$companyPassword','@Empleado'));";

                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $insert = $dbConnection->prepare($query);//prepare the statement
                    try{//try to complete the insertion
                        $insert->execute();//execute the statement
                        $dbConnection->commit();//it's everything ok
                        header("HTTP/1.0 200 Created"); //this indicates to the client that the new record
                    }catch (Exception $e){//the insertion fails then
                        $dbConnection->rollBack();//get back the database
                        header("HTTP/1.0 500 Internal Server Error");//info for the client
                    }
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
        if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['contract']) && isset($_POST['charge']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['rfc']) && isset($_POST['t'])) {
            if (TokenTool::isValid($_GET['t'])){
                echo "<h4>holamundo</h4>";
                //get the sended data
                $IdEmployee = $_GET['idCompany'];
                $EmployeeName = $_GET['name'];
                $EmployeeLastName = $_GET['lastname'];
                $employeeContractYear = $_GET['contract'];
                $EmployeeCharge =  $_GET['charge'];
                $EmployeePhone = $_GET['phone'];
                $EmployeeEmail = $_GET['email'];
                $employeeRFC = $_GET['rfc'];

                $dbConnection->beginTransaction(); //starts a transaction in the database

                if ($mainEmployee) {
                    $query = "UPDATE Employees SET MainEmployee = 0 WHERE IdCompany = $companyId;";
                    $update = $dbConnection->prepare($query);
                    try { //try to complete the insertion
                        $update->execute(); //execute the statement
                    } catch (Exception $e) { //the insertion fails then
                        $dbConnection->rollBack(); //get back the database
                        header("HTTP/1.0 500 Internal Server Error"); //info for the client
                        exit();
                    }
                }
                $query = "UPDATE `personal` SET `EmployeeName`=EmployeeName,`EmployeeLastName`=EmployeeLastName,`EmployeeDegree`=EmployeeDegree,`EmployeeBirth`=[value-5],`EmployeeContractYear`=[value-6],`EmployeeCharge`=[value-7],`EmployeeAddress`=[value-8],`EmployeePhone`=[value-9],`EmployeeEmail`=[value-10],`EmployeeInsurance`=[value-11],`EmployeeRFC`=[value-12],`EmployeePassword`=[value-13] WHERE `IdEmployee`=[value-1]"; //prepare the query including to make this Employee the main

                $update = $dbConnection->prepare($query); //prepare the statement
                try { //try to complete the modification
                    $update->execute(); //execute the statement
                    $dbConnection->commit(); //it's everything ok
                    header("HTTP/1.0 200 Modified"); //this indicates to the client that the reecord was modified
                } catch (Exception $e) { //the modification fails then
                    $dbConnection->rollBack(); //get back the database
                    header("HTTP/1.0 500 Internal Server Error"); //info for the client
                }
            }else {
                header("HTTP/1.0 401 Unauthorized");
            }
            exit();
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;


/**-----Patch request (request for change employee photo in the table) -----------------------------------------------------------------------------------------------------------*/
        case 'PATCH':
            if(isset($_GET['t'])){
                if (TokenTool::isValid($_GET['t'])){
                    //
                    //Code for change the company logo
                    $query = '';
                    //
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $update = $dbConnection->prepare($query);//prepare the statement
                    try {//try to complete the modification
                        $update->execute();//execute the statement
                        $dbConnection->commit();//it's everything ok
                        header("HTTP/1.0 200 Modified"); //this indicates to the client that the reecord was modified
                    }catch (Exception $e) {//the modification fails then
                        $dbConnection->rollBack();//get back the database
                        header("HTTP/1.0 500 Internal Server Error");//info for the client
                    }
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
        
        default:
            header("HTTP/1.0 405 Allow; GET, POST, PUT, PATCH");
            exit();
            break;
    }
