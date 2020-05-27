<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table of Sectors) ----------------------------------------------------------------*/
        case 'GET':
            
            break;


/**-----Post request (request for add a company logo) --------------------------------------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset(isset($_POST['company']) && $_POST['rfc'] && isset($_FILES['logo']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])) {
                    $companyId = $_POST['company'];
                    $companyRFC = $_POST['rfc'];
                    $f = $_FILES['logo'];
                    $name = "logo_$companyId.Image-$companyRF.Clajhasd9ul3iu0a.ñohsdf-jsdf.klsdj0ojmalsdasd.png";
                    $path = "https://aarrin.com/mobile/app_resources/companies/$name";
                    if (move_uploaded_file($f['tmp_name'], __DIR__. "/../../../../app_resources/companies/$name")){
                        $query = "UPDATE companies SET CompanyLogo = '$path' WHERE IdCompany = $companyId";
                        $dbConnection->beginTransaction();//starts a transaction in the database
                        $update = $dbConnection->prepare($query);//prepare the statement
                        try{//try to complete the insertion
                            $update->execute();//execute the statement
                            $dbConnection->commit();//it's everything ok
                            header("HTTP/1.0 200 Created"); //this indicates to the client that the new record
                            $query = "SELECT IdCompany, CompanyName, CompanyRFC, CompanyAddress, CompanyWebsite, CompanyLogo FROM companies WHERE IdCompany = $companyId";
                            $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                            $consult->execute(); //execute the query
                            $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                            header('Content-Type: application/json'); //now define the content type to get back
                            $companyData = $consult->fetchAll()[0];
                            echo json_encode($companyData);
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


/**-----Put request (request for change information in the table) -----------------------------------------------------------------------------------------------------------*/
        case 'PUT':
            if(isset($_GET['id']) && isset($_GET['name']) && isset($_GET['rfc']) && isset($_GET['address']) && isset($_GET['t'])){
                if (TokenTool::isValid($_GET['t'])){
                    
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