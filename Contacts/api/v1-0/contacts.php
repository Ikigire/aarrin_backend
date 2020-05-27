<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    include("../../../Config/Connection.php");
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            /** If it's a login request */
            if (isset($_GET['email']) && isset($_GET['password'])) {
                $email = $_GET['email'];
                $password = $_GET['password'];
                $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, AES_DECRYPT(ContactPassword, '@Company') AS 'ContactPassword', ContactPhoto FROM contacts WHERE ContactEmail = '$email' AND AES_DECRYPT(ContactPassword, '@Company') = '$password';";
                $consult = $dbConnection->prepare($query);
                $consult->execute(); //execute the query
                if ($consult->rowCount()) { //if is there any result for the query then
                    $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                    $contactData = $consult->fetchAll()[0];

                    $dataForToken = array(
                        'IdContact' => $contactData['IdContact'],
                        'IdCompany' => $contactData['IdCompany'],
                        'ContactName' => $contactData['ContactName'],
                        'ContactEmail' => $contactData['ContactEmail']
                    );
                    $contactData['Token'] = TokenTool::createToken($dataForToken);
                    header("HTTP/1.0 202 Accepted");
                    header('Content-Type: application/json');
                    echo json_encode($contactData); //Return the data
                    exit();
                } else { //if there isn't any result for the query
                    header("HTTP/1.0 404 Not found");
                    exit();
                }
            }elseif (isset($_GET['idContact']) && isset($_GET['t']) && TokenTool::isValid($_GET['t'])) {
            /**If exist and id in the request then search the contact id */
                $id = $_GET['idContact'];
                $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, ContactPhoto FROM contacts WHERE IdContact = $id"; //it create the query for the server
                $consult = $dbConnection->prepare($query);
                $consult->execute(); //execute the query
                if($consult->rowCount()){//if is there any result for the query then
                    $consult->setFetchMode(PDO::FETCH_ASSOC);
                    header("HTTP/1.0 202 Accepted");
                    header('Content-Type: application/json');
                    $contactData = $consult->fetch();
                    echo json_encode($contactData);//Return the data
                    exit();
                }else{//if there isn't any result for the query
                    header("HTTP/1.0 404 Not found");
                    exit();
                }
            }elseif(isset($_GET['idCompany'])  && isset($_GET['t']) && TokenTool::isValid($_GET['t'])){/**Id not exist, then it's a request for the whole information */
                $id = $_GET['idCompany'];
                $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, ContactPhoto FROM contacts WHERE IdCompany = $id";
                $consult = $dbConnection->prepare($query);
                $consult->execute();//execute the query
                $consult->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.0 202 Accepted");
                header('Content-Type: application/json');
                $companyContacts = $consult->fetchAll();
                echo json_encode($companyContacts);//Return the data
                exit();
            }else {
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;

        case 'POST':
            if (isset($_POST['idCompany']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['charge']) && isset($_POST['main']) && isset($_POST['password'])) {
                //get the sended data
                
                $companyId = $_POST['idCompany'];
                $contactName = $_POST['name'];
                $contactPhone = $_POST['phone'];
                $contactEmail = $_POST['email'];
                $contactCharge = $_POST['charge'];
                $mainContact = $_POST['main'];
                $contactPassword = $_POST['password'];
                

                $dbConnection->beginTransaction(); //starts a transaction in the database

                if ($mainContact) {
                    //to ensure that the new contact will convert in the only main contact of the company
                    $query = "UPDATE contacts SET MainContact = 0 WHERE IdCompany = $companyId;";
                    $update = $dbConnection->prepare($query);
                    try { //try to complete the insertion
                        $update->execute(); //execute the statement
                    } catch (Exception $e) { //the insertion fails then
                        $dbConnection->rollBack(); //get back the database
                        header("HTTP/1.0 409 Conflict with the Server"); //info for the client
                        exit();
                    }
                }
                $query = "INSERT INTO contacts(IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, ContactPassword) VALUES ($companyId, $mainContact, '$contactName', '$contactPhone', '$contactEmail', '$contactCharge', AES_ENCRYPT('$contactPassword', '@Company'));"; //prepare the query including to make this contact the main
                $insert = $dbConnection->prepare($query); //prepare the statement
                echo "<h4>ok</h4>";
                try { //try to complete the insertion
                    $insert->execute(); //execute the statement
                    $dbConnection->commit(); //it's everything ok
                    header("HTTP/1.0 200 Created"); //this indicates to the client that the new record
                } catch (Exception $e) { //the insertion fails then
                    $dbConnection->rollBack(); //get back the database
                    header("HTTP/1.0 409 Conflict with the Server"); //info for the client
                }
                exit();
            } else {
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;

        case 'PUT':
        if (isset($_GET['idContact']) && isset($_GET['idCompany']) && isset($_GET['name']) && isset($_GET['phone']) && isset($_GET['email']) && isset($_GET['charge']) && isset($_GET['t'])) {
                if (TokenTool::isValid($_GET['t'])){
                    //get the sended data
                    $idContact = $_GET['idContact'];
                    $contactName = $_GET['name'];
                    $contactPhone = $_GET['phone'];
                    $contactEmail = $_GET['email'];
                    $contactCharge = $_GET['charge'];
                    $companyId = $_GET['idCompany'];
                    $updateQuery = "UPDATE contacts SET ContactName = '$contactName', ContactPhone = '$contactPhone', ContactEmail = '$contactEmail', ContactCharge = '$contactCharge'";

                    $mainContact = false;
                    if (isset($_GET['main'])) {
                        $mainContact = $_GET['main'];
                        $updateQuery = $updateQuery. ", MainContact = 1";
                    }
                    if (isset($_GET['password']) && trim($_GET['password']) !== '') {
                        $contactPassword = $_GET['password'];
                        $updateQuery = $updateQuery. ", ContactPassword = AES_ENCRYPT('$contactPassword', '@Company')";
                    }

                    $dbConnection->beginTransaction(); //starts a transaction in the database

                    if ($mainContact) {
                        $query = "UPDATE contacts SET MainContact = 0 WHERE IdCompany = $companyId;";
                        $update = $dbConnection->prepare($query);
                        try { //try to complete the insertion
                            $update->execute(); //execute the statement
                        } catch (Exception $e) { //the insertion fails then
                            $dbConnection->rollBack(); //get back the database
                            header("HTTP/1.0 409 Conflict"); //info for the client
                            exit();
                        }
                    }
                    $updateQuery = $updateQuery. " WHERE IdContact = $idContact;";

                    $update = $dbConnection->prepare($updateQuery); //prepare the statement
                    try { //try to complete the modification
                        $update->execute(); //execute the statement
                        $dbConnection->commit(); //it's everything ok
                        $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, AES_DECRYPT(ContactPassword, '@Company') AS 'ContactPassword', ContactPhoto FROM contacts WHERE IdContact = $idContact"; //it create the query for the server
                        $consult = $dbConnection->prepare($query);
                        $consult->execute(); //execute the query
                        if($consult->rowCount()){//if is there any result for the query then
                            $consult->setFetchMode(PDO::FETCH_ASSOC);
                            $contactData = $consult->fetchAll()[0];
                            $dataForToken = array(
                                'IdContact' => $contactData['IdContact'],
                                'IdCompany' => $contactData['IdCompany'],
                                'ContactName' => $contactData['ContactName'],
                                'ContactEmail' => $contactData['ContactEmail']
                            );
                            $contactData['Token'] = TokenTool::createToken($dataForToken);
                            header("HTTP/1.0 202 Modified");
                            header('Content-Type: application/json');
                            echo json_encode($contactData); //Return the data
                        }
                        header("HTTP/1.0 200 Modified"); //this indicates to the client that the reecord was modified
                    } catch (Exception $e) { //the modification fails then
                        $dbConnection->rollBack(); //get back the database
                        header("HTTP/1.0 409 Conflict"); //info for the client
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

        case 'OPTIONS':
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            break;

        default:
            header("HTTP/1.0 405 Allow; GET, POST, PUT");
            exit();
            break;
    }
?>