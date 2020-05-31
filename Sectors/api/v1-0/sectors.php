<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    include("../../../Config/Connection.php");

    /**Check out the request method from the client */
    switch ($_SERVER['REQUEST_METHOD']) {
/**-----Get request (request of the whole information or just one of them; all data in the table of Sectors) ----------------------------------------------------------------*/
        case 'GET':
            /**If exist and id in the request then search the sector id */
            if (isset($_GET['id']) && isset($_GET['t'])) {
                if(TokenTool::isValid($_GET['t'])){
                    $id = $_GET['id'];
                    $query = "SELECT IdSector, SectorName FROM sectors WHERE IdSector = $id"; //it create the query for the server
                    $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                    $consult->execute();
                    if($consult->rowCount()){//if is there any result for the query then
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header("HTTP/1.1 202 Accepted"); //this indicates to the client that the request was accepted
                        header('Content-Type: application/json'); //now define the content type to get back
                        echo json_encode($consult->fetchAll()); //to finalize the server return the data

                    }else{//it there isn't any result for the query
                        header("HTTP/1.1 404 Not found");//the server advice to not found result

                    }
                }
            }elseif (isset($_GET['t']) && isset($_GET['iso'])) {/**Get sector for an application*/
                if (TokenTool::isValid($_GET['t'])){
                    $sectorISO = $_GET['iso'];
                    $query = "SELECT IdSector, IAF_MD5, SectorCluster, SectorCategory, SectorSubcategory, SectorRiskLevel FROM sectors WHERE SectorStatus = 'Active' AND SectorISO = '$sectorISO' ORDER BY IAF_MD5, SectorRiskLevel, SectorCategory, SectorSubcategory, SectorCluster";
                    $consult = $dbConnection->prepare($query);
                    $consult->execute();
                    $consult->setFetchMode(PDO::FETCH_ASSOC); //this comand sets the fetch mode in association for the best way to put the data
                    header("HTTP/1.1 202 Accepted");//this indicates to the client that the request was accepted
                    header('Content-Type: application/json');//now define the content type to get back
                    echo json_encode($consult->fetchAll());//to finalize the server return the data
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                }
            }elseif (isset($_GET['t'])) {/**Get sector for an application*/
                if (TokenTool::isValid($_GET['t'])){
                    $query = "SELECT IdSector, SectorISO, IAF_MD5, SectorCluster, SectorCategory, SectorSubcategory, SectorRiskLevel, SectorStatus FROM sectors ORDER BY SectorISO, IAF_MD5, SectorRiskLevel, SectorCategory, SectorSubcategory, SectorCluster";
                    $consult = $dbConnection->prepare($query);
                    $consult->execute();
                    $consult->setFetchMode(PDO::FETCH_ASSOC); //this comand sets the fetch mode in association for the best way to put the data
                    header("HTTP/1.1 202 Accepted");//this indicates to the client that the request was accepted
                    header('Content-Type: application/json');//now define the content type to get back
                    echo json_encode($consult->fetchAll());//to finalize the server return the data
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                }
            } else {
                header("HTTP/1.1 412 Precondition Failed"); //the request don't complete the preconditions
            }
            exit();
            break;

/**-----Post request (request for create a new sector; it just needs the sector type) ---------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['category']) && isset($_POST['iso']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    //get the sended data
                    $category = $_POST['category'];
                    $sectorISO = $_POST['iso'];

                    $init = "INSERT INTO sectors (SectorISO, SectorCategory";
                    $values = "VALUES ('$sectorISO', '$category'";

                    if (isset($_POST['iaf'])) {
                        $iaf = $_POST['iaf'];
                        $init .= ", IAF_MD5";
                        $values .=", $iaf";
                    }
                    if (isset($_POST['cluster'])) {
                        $cluster = $_POST['cluster'];
                        $init .= ", SectorCluster";
                        $values .=", '$cluster'";
                    }
                    if (isset($_POST['subcategory'])) {
                        $subcategory = $_POST['subcategory'];
                        $init .= ", SectorSubcategory";
                        $values .=", '$subcategory'";
                    }
                    if (isset($_POST['risklevel'])) {
                        $riskLevel = $_POST['risklevel'];
                        $init .= ", SectorRiskLevel";
                        $values .=", '$riskLevel'";
                    }

                    $query = $init. ") ". $values. ");";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $insert = $dbConnection->prepare($query);//prepare the statement
                    try{//try to complete the insertion
                        $insert->execute();
                        $dbConnection->commit();//it's everything ok
                        header("HTTP/1.1 200 Created"); //this indicates to the client that the new record was created
                    }catch (Exception $e){//the insertion fails then
                        $dbConnection->rollBack();//make rollback the database
                        header("HTTP/1.1 409 Conflict with the Server");//info for the client
                    }
                }else{
                    header("HTTP/1.1 401 Unauthorized");
                }
                exit();
            }
            else{
                header("HTTP/1.1 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;

/**-----Put request (request for change information in the table; it needs the new sector type and the Id) ------------------------------------------------------------------*/
        case 'PUT':
            if(isset($_GET['idSector']) && isset($_GET['category']) && isset($_GET['iso']) && isset($_GET['t'])){
                if (TokenTool::isValid($_GET['t'])){
                    //get the sended data
                    $idSector = $_GET['idSector'];
                    $category = $_GET['category'];
                    $sectorISO = $_GET['iso'];

                    $query = "UPDATE sectors SET SectorISO = '$sectorISO', SectorCategory = '$category'";

                    if (isset($_GET['iaf'])) {
                        $iaf = $_GET['iaf'];
                        $$query .= ", IAF_MD5 = $iaf";
                    }
                    if (isset($_GET['cluster'])) {
                        $cluster = $_GET['cluster'];
                        $query .= ", SectorCluster = '$cluster'";
                    }
                    if (isset($_GET['subcategory'])) {
                        $subcategory = $_GET['subcategory'];
                        $query .= ", SectorSubcategory = '$subcategory'";
                    }
                    if (isset($_GET['risklevel'])) {
                        $riskLevel = $_GET['risklevel'];
                        $query .= ", SectorRiskLevel = '$riskLevel'";
                    }
                    if (isset($_GET['status'])) {
                        $status = $_GET['status'];
                        $query .= ", SectorStatus = '$status'";
                    }

                    $query .= " WHERE IdSector = $idSector;";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $insert = $dbConnection->prepare($query);//prepare the statement
                    try{//try to complete the insertion
                        $insert->execute();
                        $dbConnection->commit();//it's everything ok
                        header("HTTP/1.1 200 Modified"); //this indicates to the client that the new record was created
                    }catch (Exception $e){//the insertion fails then
                        $dbConnection->rollBack();//make rollback the database
                        header("HTTP/1.1 409 Conflict with the Server");//info for the client
                    }
                }else{
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
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            break;
        /**Any other request type will be refuse for the server */
        default:
            header("HTTP/1.1 405 Allow; GET, POST, PUT");
            exit();
            break;
    }
?>