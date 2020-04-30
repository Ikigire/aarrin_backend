<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    include("../../../Config/Connection.php");
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            /**If exist and id in the request then search the contact id */
            if (isset($_GET['idContact'])) {

                $id = $_GET['idContact'];
                $query = "SELECT * FROM contacts WHERE IdContact = $id"; //it create the query for the server
                $consult = $dbConnection->prepare($query);
                $consult->execute(); //execute the query
                if($consult->rowCount()){//if is there any result for the query then
                    $consult->setFetchMode(PDO::FETCH_ASSOC);
                    header("HTTP/1.0 202 Accepted");
                    header('Content-Type: application/json');
                    echo json_encode($consult->fetchAll()[0]);//Return the data
                    exit();
                }else{//if there isn't any result for the query
                    header("HTTP/1.0 404 Not found");
                    exit();
                }
            }
            elseif(isset($_GET['idCompany'])){/**Id not exist, then it's a request for the whole information */
                $id = $_GET['idCompany'];
                $query = "SELECT * FROM contacts WHERE IdCompany = $id";
                $consult = $dbConnection->prepare($query);
                $consult->execute();//execute the query
                $consult->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.0 202 Accepted");
                header('Content-Type: application/json');
                echo json_encode($consult->fetchAll());//Return the data
                exit();
            }else {
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;

        case 'POST':
            if(isset($_POST['idCompany']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['charge'])){
                //get the sended data
                $companyId = $_POST['idCompany'];
                $contactName = $_POST['name'];
                $contactPhone = $_POST['phone'];
                $contactEmail = $_POST['email'];
                $contactCharge = $_POST['charge'];
                if(isset($_POST['main'])){
                    $mainContact = $_POST['main'];
                    $query = "INSERT INTO contacts(IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge) VALUES ($companyId, $mainContact, '$contactName', '$contactPhone', '$contactEmail', '$contactCharge');";//prepare the query including to make this contact the main
                }else{
                    $query = "INSERT INTO contacts(IdCompany, ContactName, ContactPhone, ContactEmail, ContactCharge) VALUES ($CompanyId, '$contactName', '$contactPhone', '$contactEmail', '$contactCharge');";//prepare the query without the website
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

        case 'PUT':
        if (isset($_GET['idContact']) && isset($_GET['idCompany']) && isset($_GET['name']) && isset($_GET['phone']) && isset($_GET['email']) && isset($_GET['charge']) && isset($_GET['t'])) {
                if (TokenTool::isValid($_GET['t'])){
                    //get the sended data
                    $IdContact = $_GET['idContact'];
                    $companyId = $_GET['idCompany'];
                    $contactName = $_GET['name'];
                    $contactPhone = $_GET['phone'];
                    $contactEmail = $_GET['email'];
                    $contactCharge = $_GET['charge'];
                    if(isset($_GET['main'])){
                        $mainContact = $_POST['main'];
                        $query = "UPDATE contacts SET IdCompany = $companyId, MainContact = $mainContact, ContactName = '$contactName', ContactPhone = '$contactPhone', ContactEmail = '$contactEmail', ContactCharge = '$contactCharge') WHERE IdContact = $IdContact;";//prepare the query including to make this contact the main
                    }else{
                        $query = "UPDATE contacts SET IdCompany = $companyId, ContactName = '$contactName', ContactPhone = '$contactPhone', ContactEmail = '$contactEmail', ContactCharge = '$contactCharge') WHERE IdContact = $IdContact;";//prepare the query without the website
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
        
        default:
            header("HTTP/1.0 405 Allow; GET, POST, PUT");
            exit();
            break;
    }
?>