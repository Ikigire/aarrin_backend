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
            if (isset($_GET['employee']) && isset($_GET['t'])) {
                if (TokenTool::isValid($_GET['t'])){
                    $id = $_GET['employee'];
                    $query = "SELECT Role_Type FROM roles WHERE IdEmployee = $id";
                    $roleSearch = $dbConnection->prepare($query);
                    $roleSearch->execute();
                    if($roleSearch->rowCount()){ //if is there any result for the query then
                        $roleSearch->setFetchMode(PDO::FETCH_ASSOC);
                        header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                        header('Content-Type: application/json'); //now define the content type to get back
                        echo json_encode($roleSearch->fetchAll()); //to finalize the server return the data
                    }else{//it there isn't any result for the query
                        header("HTTP/1.0 404 Not found");//the server advice to not found result
                    }
                }
                else {
                    header("HTTP/1.0 401 Unauthorized");
                }
            }
            else{
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
            }
            exit();
            break;

/**-----Post request (request for create a new sector; it just needs the sector type) ---------------------------------------------------------------------------------------*/
        case 'POST':
            if(isset($_POST['employee']) && isset($_POST['role']) && isset($_POST['t'])){
                if (TokenTool::isValid($_POST['t'])){
                    $employee = $_POST['employee']; //get the sended data
                    $role = $_POST['role'];
                    $query = "INSERT INTO roles(IdEmployee, Role_Type) VALUES ($employee, '$role');";
                    $dbConnection->beginTransaction();//starts a transaction in the database
                    $insert = $dbConnection->prepare($query);//prepare the statement
                    try{//try to complete the insertion
                        $insert->execute();
                        $dbConnection->commit();//it's everything ok
                        header("HTTP/1.0 200 Created"); //this indicates to the client that the new record was created
                    }catch (Exception $e){//the insertion fails then
                        $dbConnection->rollBack();//make rollback the database
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

/** Request to remove a role to an employee */
        case "DELETE":
            if (isset($_GET['employee']) && isset($_GET['role']) && isset($_GET['t'])) {
                if (TokenTool::isValid($_GET['t'])) {
                    //get the sended data
                    $idEmployee = $_GET['employee'];
                    $role = $_GET['role'];
                    $query = "DELETE FROM roles WHERE IdEmployee = $idEmployee And Role_Type = '$role'";
                    $dbConnection->beginTransaction();
                    $roleDelete = $dbConnection->prepare($query);
                    try {
                        $roleDelete->execute();
                        if ($roleDelete->rowCount()){
                            header("HTTP/1.0 202 Accepted"); //this indicates to the client that the request was accepted
                        } else {
                            header("HTTP/1.0 400 Bad request");
                        }
                        $dbConnection->commit();
                    } catch (\Throwable $th) {
                        $dbConnection->rollBack();
                        header("HTTP/1.0 409 Conflict with the Server");//info for the client
                    }
                } else {
                    header("HTTP/1.0 401 Unauthorized");
                }
            } else {
                header("HTTP/1.0 412 Precondition Failed"); //the request don't complete the preconditions
            }
            exit();
            break;
        case 'OPTIONS':
            header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
            break;
        /**Any other request type will be refuse for the server */
        default:
            header("HTTP/1.0 405 Allow; GET, POST, DELETE");
            exit();
            break;
    }
