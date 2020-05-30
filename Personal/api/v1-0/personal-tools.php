<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table) ----------------------------------------------------------------*/
        case 'GET':

            break;


/**-----Post request (request for create a new employee (Admin)) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['employee']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    header('Content-Type: application/json');
                    $idEmployee = $_POST['employee'];
                    $file = '';
                    $receivedData = null;
                    if (isset($_FILES['image'])){
                        $f = $_FILES['image'];
                        $name = "profile_$idEmployee.Image-pqwe82354daloihd.png";
                        $path = "https://aarrin.com/mobile/app_resources/personal/$name";
                        
                        if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../../../app_resources/personal/$name")){
                            $query = "UPDATE personal SET EmployeePhoto = '$path' WHERE IdEmployee = $idEmployee";
                            $dbConnection->beginTransaction();//starts a transaction in the database
                            $update = $dbConnection->prepare($query);//prepare the statement
                            try {//try to complete the modification
                                $update->execute();//execute the statement
                                $dbConnection->commit();//it's everything ok
                                header("HTTP/1.1 200 Modified"); //this indicates to the client that the reecord was modified
                                $query = "SELECT IdEmployee, EmployeeName, EmployeeLastName, EmployeeDegree, EmployeeBirth, EmployeeContractYear, EmployeeCharge, EmployeeAddress, EmployeePhone, EmployeeEmail, EmployeeInsurance, EmployeeRFC, AES_DECRYPT(EmployeePassword, '@Empleado') AS 'EmployeePassword', EmployeePhoto FROM personal WHERE IdEmployee = $idEmployee";
                                $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                                $consult->execute();
                                $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                                $employeeData = $consult->fetchAll()[0];

                                $dataForToken = array(
                                    'IdEmployee' => $employeeData['IdEmployee'],
                                    'EmployeeName' => $employeeData['EmployeeName'].' '.$employeeData['EmployeeLastName'],
                                    'EmployeeRFC' => $employeeData['EmployeeRFC'],
                                    'EmployeeEmail' => $employeeData['EmployeeEmail']
                                );
                                $employeeData['Token'] = TokenTool::createToken($dataForToken);
                                echo json_encode($employeeData); //to finalize the server return the data
                            }catch (Exception $e) {//the modification fails then
                                $dbConnection->rollBack();//get back the database
                                echo json_encode(array('error' => 'Can\'t change the data', 'place' => 'At moment to register the new path'));
                                header("HTTP/1.1 409 Conflict with the Server");//info for the client
                            }
                        } else {
                            echo json_encode(array('error' => 'Can\'t move the file', 'place' => 'At moment to move the file'));
                            header("HTTP/1.1 409 Conflict with the Server");//info for the client
                        }
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
