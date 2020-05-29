<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    include("../../../Config/Connection.php");
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            
            break;

        case 'POST':
            if((isset($_POST['contact']) && $_POST['email'] && isset($_FILES['photo']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])) {
                    $contactId = $_POST['contact'];
                    $contactEmail = $_POST['email'];
                    $f = $_FILES['photo'];
                    $name = "profile_$contactId.Image-$contactEmail.Clajhasd9ul3iu0a.ohsdf-jsdf.klsdj0ojmalsdasd.png";
                    $path = "https://aarrin.com/mobile/app_resources/contacts/$name";
                    if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../../../app_resources/contacts/$name")){
                        $query = "UPDATE contacts SET ContactPhoto = '$path' WHERE IdContact = $contactId";
                        $dbConnection->beginTransaction();//starts a transaction in the database
                        $update = $dbConnection->prepare($query);//prepare the statement
                        try{//try to complete the insertion
                            $update->execute();//execute the statement
                            $dbConnection->commit();//it's everything ok
                            header("HTTP/1.0 200 Uploaded"); //this indicates to the client that the new record
                            $query = "SELECT IdContact, IdCompany, MainContact, ContactName, ContactPhone, ContactEmail, ContactCharge, AES_DECRYPT(ContactPassword, '@Company') AS 'ContactPassword', ContactPhoto FROM contacts WHERE IdContact = $contactId;";
                            $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                            $consult->execute(); //execute the query
                            $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                            header('Content-Type: application/json'); //now define the content type to get back
                            $contactData = $consult->fetchAll()[0];
                            echo json_encode($contactData);
                        }catch (Exception $e){//the insertion fails then
                            $dbConnection->rollBack();//get back the database
                            header("HTTP/1.0 409 Conflict with the Server");//info for the client
                        }
                    }
                    exit();
                } else {
                    header("HTTP/1.0 401 Unauthorized");
                }
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;

        case 'PUT':
        
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