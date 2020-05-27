<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table of Sectors) ----------------------------------------------------------------*/
        case 'GET':
            if (isset($_GET['idCompany']) && isset($_GET['t']) && TokenTool::isValid($_GET['t'])) {
                $idCompany = intval($_GET['idCompany']);
                $query = "SELECT IdCompany, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite, CompanyLogo FROM companies WHERE IdCompany = $idCompany";
                $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                $consult->execute(); //execute the query
                $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                header('Content-Type: application/json'); //now define the content type to get back
                $companyData = $consult->fetchAll()[0];
                echo json_encode($companyData); //to finalize the server return the data
            }else{/**RFC doesn't exist, then it's a request for the whole information */
                if (isset($_GET['t']) && TokenTool::isValid($_GET['t'])){
                    $query = "SELECT IdCompany, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite, CompanyLogo FROM companies; ";//it create the query for the server
                    $consult = $dbConnection->prepare($query);//this line prepare the query for execute
                    $consult->execute();//execute the query
                    if ($consult->rowCount()) {
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                        header('Content-Type: application/json'); //now define the content type to get back
                        echo json_encode($consult->fetchAll()); //to finalize the server return the data
                    }else{
                        header("HTTP/1.0 409 Conflict with the Server");//the server advice to not found result
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
            if(isset(isset($_POST['name']) && isset($_POST['rfc']) && isset($_POST['address'])){
                //get the sended data
                $companyName = $_POST['name'];
                $companyRFC = strtoupper($_POST['rfc']);
                $companyAddress = $_POST['address'];
                if(isset($_POST['website'])){
                    $companyWebsite = $_POST['website'];
                    $query = "INSERT INTO companies(CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite) VALUES ('$companyName', '$companyRFC', '$companyAddress', '$companyWebsite');";//prepare the query including the website
                }else{
                    $query = "INSERT INTO companies(CompanyName, CompanyRFC, CompanyAddress) VALUES ('$companyName', '$companyRFC', '$companyAddress');";//prepare the query without the website
                }
                $dbConnection->beginTransaction();//starts a transaction in the database
                $insert = $dbConnection->prepare($query);//prepare the statement
                try{//try to complete the insertion
                    $insert->execute();//execute the statement
                    $array = array('IdCompany' => $dbConnection->lastInsertId());
                    $dbConnection->commit();//it's everything ok
                    header("HTTP/1.0 200 Created"); //this indicates to the client that the new record
                    echo json_encode($array);
                }catch (Exception $e){//the insertion fails then
                    $dbConnection->rollBack();//get back the database
                    header("HTTP/1.0 409 Conflict with the Server");//info for the client
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
            if(isset($_GET['id']) && isset($_GET['name']) && isset($_GET['rfc']) && isset($_GET['address']) && isset($_GET['t'])){
                if (TokenTool::isValid($_GET['t'])){
                    //get the sended data
                    $id = $_GET['id'];
                    $companyName = $_GET['name'];
                    $companyRFC = strtoupper($_GET['rfc']);
                    $companyAddress = $_GET['address'];
                    if(isset($_GET['website']) && trim($_GET['website']) !== ''){
                        $companyWebsite = $_GET['website'];
                        $query = "UPDATE companies SET CompanyName = '$companyName', CompanyRFC = '$companyRFC', CompanyAddress = '$companyAddress', CompanyWebsite = '$companyWebsite' WHERE IdCompany = $id;";//prepare the query including the website
                    }else{
                        $query = "UPDATE companies SET CompanyName = '$companyName', CompanyRFC = '$companyRFC', CompanyAddress = '$companyAddress' WHERE IdCompany = $id;";//prepare the query without the website
                    }
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $update = $dbConnection->prepare($query);//prepare the statement
                    try {//try to complete the modification
                        $update->execute();//execute the statement
                        $dbConnection->commit();//it's everything ok
                        $query = "SELECT IdCompany, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite CompanyLogo FROM companies WHERE IdCompany = $id";
                        $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                        $consult->execute(); //execute the query
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                        header('Content-Type: application/json'); //now define the content type to get back
                        $companyData = $consult->fetchAll()[0];
                        echo json_encode($companyData);
                        header("HTTP/1.0 200 Modified"); //this indicates to the client that the reecord was modified
                    }catch (Exception $e) {//the modification fails then
                        $dbConnection->rollBack();//get back the database
                        header("HTTP/1.0 409 Conflict with the Server");//info for the client
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

        case 'OPTIONS':
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            break;
        
        default:
            header("HTTP/1.0 405 Allow; GET, POST, PUT, PATCH");
            exit();
            break;
    }
?>