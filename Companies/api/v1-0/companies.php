<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table of Sectors) ----------------------------------------------------------------*/
        case 'GET':
            if(isset($_GET['rfc']) && isset($_GET['password'])){//If is a request to log-in
                $companyRFC = $_GET['rfc'];
                $companyPassword = $_GET['password'];
                $query = "SELECT IdCompany, IdSector, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite, AES_DECRYPT(CompanyPassword,'@Company') AS 'CompanyPassword' FROM companies WHERE CompanyRFC='$companyRFC' AND `CompanyPassword`= AES_ENCRYPT('$companyPassword', '@Company')"; //it create the query for the server
                $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                $consult->execute(); //execute the query
                if($consult->rowCount()){//if is there any result for the query then
                    $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                    header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                    header('Content-Type: application/json'); //now define the content type to get back
                    $companyData = $consult->fetchAll()[0];
                    $dataForToken = array(
                        'IdCompany' => $companyData['IdCompany'],
                        'CompanyName' => $companyData['CompanyName'],
                        'CompanyRFC' => $companyData['CompanyRFC']
                    );
                    $companyData['Token'] = TokenTool::createToken($dataForToken);
                    echo json_encode($companyData); //to finalize the server return the data
                    exit();
                }else{//if there isn't any result for the query
                    header("HTTP/1.0 404 Not found");//the server advice to not found result
                    exit();
                }
            }else{/**RFC doesn't exist, then it's a request for the whole information */
                if (isset($_GET['t']) && TokenTool::isValid($_GET['t'])){
                    $query = "SELECT IdCompany, IdSector, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite FROM companies; ";//it create the query for the server
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


/**-----Post request (request for create a new companie) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['sector']) && isset($_POST['name']) && isset($_POST['rfc']) && isset($_POST['address']) && isset($_POST['password'])){
                //get the sended data
                $sector = $_POST['sector'];
                $companyName = $_POST['name'];
                $companyRFC = $_POST['rfc'];
                $companyAddress = $_POST['address'];
                $companyPassword = $_POST['password'];
                if(isset($_POST['website'])){
                    $companyWebsite = $_POST['website'];
                    $query = "INSERT INTO companies(IdSector, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite, CompanyPassword) VALUES ($sector, '$companyName', '$companyRFC', '$companyAddress', '$companyWebsite', AES_ENCRYPT('$companyPassword','@Company'));";//prepare the query including the website
                }else{
                    $query = "INSERT INTO companies(IdSector, CompanyName, CompanyRFC, CompanyAddress, CompanyPassword) VALUES ($sector, '$companyName', '$companyRFC', '$companyAddress', AES_ENCRYPT('$companyPassword','@Company'));";//prepare the query without the website
                }
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
                exit();
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;


/**-----Put request (request for change information in the table) -----------------------------------------------------------------------------------------------------------*/
        case 'PUT':
            if(isset($_GET['id']) && isset($_GET['sector']) && isset($_GET['name']) && isset($_GET['rfc']) && isset($_GET['address']) && isset($_GET['t'])){
                if (TokenTool::isValid($_GET['t'])){
                    //get the sended data
                    $id = $_GET['id'];
                    $sector = $_GET['sector'];
                    $companyName = $_GET['name'];
                    $companyRFC = $_GET['rfc'];
                    $companyAddress = $_GET['address'];
                    if(isset($_GET['website'])){
                        $companyWebsite = $_GET['website'];
                        $query = "UPDATE companies SET IdSector = $sector, CompanyName = '$companyName', CompanyRFC = '$companyRFC', CompanyAddress = '$companyAddress', CompanyWebsite = '$companyWebsite' WHERE IdCompany = $id;";//prepare the query including the website
                    }else{
                        $query = "UPDATE companies SET IdSector = $sector, CompanyName = '$companyName', CompanyRFC = '$companyRFC', CompanyAddress = '$companyAddress' WHERE IdCompany = $id;";//prepare the query without the website
                    }
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


/**-----Patch request (request for change company logo in the table) -----------------------------------------------------------------------------------------------------------*/
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
?>