<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, PATCH, DELETE");
    header('Content-Type: application/json');
    include("../../../Config/Connection.php");

    switch ($_SERVER['REQUEST_METHOD']) {
      /** Get request (get all otifications for user) */
      case 'GET':
         if(isset($_GET['t']) && isset($_GET['IdEmployee'])){
            if (TokenTool::isValid($_GET['t'])){
               $idEmployee = $_GET['IdEmployee'];

               $query = "SELECT IdNotification, IdEmployee, IdCompany, Role_Type, Message, URL, Viewed, NotificationDate FROM notifications WHERE IdEmployee = $idEmployee";

               if (isset($_GET['Role'])) {
                  $role = $_GET['Role'];
                  $query .= " OR Role_Type = '$role'";
               }
               
               $query .= " ORDER BY NotificationDate DESC";
               
               $consult = $dbConnection->prepare($query);
               $consult->execute();
               $consult->setFetchMode(PDO::FETCH_ASSOC);
               $notifications = $consult->fetchAll();
               echo json_encode($notifications);

            }
            else{
               header("HTTP/1.1 401 Unauthorized");
            }
            exit();
         } elseif(isset($_GET['t']) && isset($_GET['IdCompany'])){
            if (TokenTool::isValid($_GET['t'])){
               $idCompany = $_GET['IdCompany'];

               $query = "SELECT IdNotification, IdEmployee, IdCompany, Role_Type, Message, URL, Viewed, NotificationDate FROM notifications WHERE IdCompany = $idCompany ORDER BY NotificationDate DESC";

               $consult = $dbConnection->prepare($query);
               $consult->execute();
               $consult->setFetchMode(PDO::FETCH_ASSOC);
               $notifications = $consult->fetchAll();
               echo json_encode($notifications);
            }
            else{
               header("HTTP/1.1 401 Unauthorized");
            }
            exit();
         } else{
            header("HTTP/1.1 412 Precondition Failed"); //the request don't complete the preconditions
            exit();
         }
         break;

      /**---Post request (request for create a new notification) --------------------------------------------------------------------------------------------------------------------*/
      case 'POST':
         if(isset($_POST['Message']) && isset($_POST['URL']) && isset($_POST['Role_Type']) && isset($_POST['t'])){
            if (TokenTool::isValid($_POST['t'])){
               $message = $_POST['Message'];
               $URL = $_POST['URL'];
               $role_type = $_POST['Role_Type'];
               $date = new DateTime("now");
               $currentDate = $date->format('Y-m-d H:i:s');
               $initialPart = "INSERT INTO notifications (Role_Type, Message, URL, NotificationDate";
               $values = "VALUES('$role_type', '$message', '$URL', '$currentDate'";
               
               if (isset($_POST['IdEmployee'])) {
                  $idEmployee = $_POST['IdEmployee'];
                  $initialPart .= ", IdEmployee";
                  $values .= ", $idEmployee";
               }

               if (isset($_POST['IdCompany'])) {
                  $idCompany = $_POST['IdCompany'];
                  $initialPart .= ", IdCompany";
                  $values .= ", $idCompany";
               }

               $query = $initialPart. ") ". $values. ");";

               $dbConnection->beginTransaction();
               try {
                  $insert = $dbConnection->prepare($query);
                  $insert->execute();
                  $dbConnection->commit();
               } catch (\Throwable $th) {
                  $dbConnection->rollBack();
                  echo json_encode(array(
                     'status' => 'Conflict with the server',
                     'message' => 'query = '. $query
                  ));
                  header('HTTP/1.1 409 Conflict');
                  exit();
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

      /** Put request (To mark a notfication like viewed) */
      case 'PUT':
         if(isset($_GET['IdNotification']) &&  isset($_GET['t'])){
            if (TokenTool::isValid($_GET['t'])){
               $idNotification = $_GET['IdNotification'];

               $query = "UPDATE notifications SET Viewed = 1 WHERE IdNotification = $idNotification";

               $dbConnection->beginTransaction();

               try {
                  $update = $dbConnection->prepare($query);
                  $update->execute();
                  $dbConnection->commit();
               } catch (\Throwable $th) {
                  $dbConnection->rollBack();
                  header('HTTP/1.1 409 Conflict');
                  exit();
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

      case 'OPTIONS':
         header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
         header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE");
         header("Allow: GET, POST, PUT, OPTIONS");
         break;
      
      default:
         header("HTTP/1.1 405 Allow; POST, OPTIONS");
         exit();
         break;
    }
