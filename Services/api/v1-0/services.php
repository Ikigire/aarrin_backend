<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    include("../../../Config/Connection.php");

    /**Check out the request method from the client */
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            /**If exist and id in the request then search the id on the table */
            if (isset($_GET['idService']) && isset($_GET['t'])) {
                if (TokenTool::isValid($_GET['t'])) {
                    $id = $_GET['idService'];
                    $query = "SELECT IdService, ServiceStandard, ServiceShortName, ServiceStatus, ServiceDescription FROM services WHERE IdService = $id";
                    $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                    $consult->execute();
                    if($consult->rowCount()){//if is there any result for the query then
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                        header('Content-Type: application/json'); //now define the content type to get back
                        $service = $consult->fetch();
                        echo json_encode($service); //to finalize the server return the data

                    }else{//it there isn't any result for the query
                        header("HTTP/1.0 404 Not found");//the server advice to not found result

                    }
                } else {
                    header("HTTP/1.0 401 Unhautorized");
                }
            }elseif (isset($_GET['t'])) { /** Admin information request */
                if (TokenTool::isValid($_GET['t'])){
                    $query = "SELECT IdService, ServiceStandard, ServiceShortName, ServiceStatus, ServiceDescription FROM services ORDER BY ServiceStandard"; //it create the query for the server
                    $consult = $dbConnection->prepare($query);
                    $consult->execute();
                    $consult->setFetchMode(PDO::FETCH_ASSOC); //this comand sets the fetch mode in association for the best way to put the data
                    header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                    header('Content-Type: application/json'); //now define the content type to get back
                    echo json_encode($consult->fetchAll());//to finalize the server return the data
                }else {
                    header("HTTP/1.0 401 Unauthorized");
                }
            }else{/**the request don't have an Id, then it's a request for the whole information */

                $query = "SELECT IdService, ServiceStandard, ServiceDescription FROM services WHERE ServiceStatus = 'Active' ORDER BY ServiceStandard";//it create the query for the server
                $consult = $dbConnection->prepare($query);
                $consult->execute();
                $consult->setFetchMode(PDO::FETCH_ASSOC); //this comand sets the fetch mode in association for the best way to put the data
                header("HTTP/1.0 202 Accepted");//this indicates to the client that the request was accepted
                header('Content-Type: application/json');//now define the content type to get back
                echo json_encode($consult->fetchAll());//to finalize the server return the data
            }
            exit();
            break;

/**-----Post request (request for create a new sector; it just needs the sector type) ---------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['standard']) && isset($_POST['shortname']) && isset($_POST['description'])  && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    $serviceStandard = $_POST['standard'];//get the sended data
                    $serviceDescription = $_POST['description'];//get the sended data
                    $serviceShortName = trim($_POST['shortname']);
                    $query = "INSERT INTO services(IdService, ServiceStandard, ServiceShortName, ServiceDescription) VALUES (null,'$serviceStandard', '$serviceShortName', $serviceDescription);";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $insert = $dbConnection->prepare($query);//prepare the statement
                    try{//try to complete the insertion
                        $insert->execute();
                        //echo $dbConnection->lastInsertId(); /** This return the Id of the last insertion */
                        $dbConnection->commit();//it's everything ok
                        header("HTTP/1.0 200 Created"); //this indicates to the client that the new record was created
                    }catch (Exception $e){//the insertion fails then
                        $dbConnection->rollBack();//make rollback the database
                        header("HTTP/1.0 409 Conflict with the Server");//info for the client
                    }
                }else{
                    header("HTTP/1.0 401 Unauthorized");
                }
                exit();
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
                exit();
            }
            break;

/**-----Put request (request for change information in the table; it needs the new sector type and the Id) ------------------------------------------------------------------*/
        case 'PUT':
            if (isset($_GET['idService']) && isset($_GET['standard']) && isset($_GET['shortname']) && isset($_GET['description']) && isset($_GET['t'])) {
                if (TokenTool::isValid($_GET['t'])){
                    $serviceId = $_GET['idService'];
                    $serviceStandard = $_GET['standard'];
                    $serviceShortName = trim($_GET['shortname']);
                    $description = $_GET['description'];
                    $query = "UPDATE services SET ServiceStandard = '$serviceStandard', ServiceShortName = '$serviceShortName', ServiceDescription = '$description'";
                    if(isset($_GET['status'])){
                        $serviceStatus = $_GET['status'];
                        $query .= ", ServiceStatus = '$serviceStatus'";
                    }
                    $query .= " WHERE IdService = $serviceId;";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $update = $dbConnection->prepare($query);
                    try {//try to complete the modification
                        $update->execute();
                        $dbConnection->commit();//it's everything ok
                        header("HTTP/1.0 200 Modified"); //this indicates to the client that the reecord was modified
                        $query = "SELECT IdService, ServiceStandard, ServiceShortName, ServiceStatus, ServiceDescription FROM services WHERE IdService = $serviceId";
                        $consult = $dbConnection->prepare($query); //this line prepare the query for execute
                        $consult->execute();
                        $consult->setFetchMode(PDO::FETCH_ASSOC); //sets the fetch mode in association for the best way to put the data
                        header('Content-Type: application/json'); //now define the content type to get back
                        $service = $consult->fetch();
                        echo json_encode($service);
                    }catch (Exception $e) {//the modification fails then
                        $dbConnection->rollBack();//get rollback the database
                        header("HTTP/1.0 409 Conflict with the Server");//info for the client
                    }
                }else{
                    header("HTTP/1.0 401 Unauthorized"); //the request don't complete the preconditions
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
        /**Any other request type will be refuse for the server */
        default:
            header("HTTP/1.0 405 Allow; GET, POST, PUT");
            exit();
            break;
    }
