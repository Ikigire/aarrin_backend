<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    include("../../../Config/Connection.php");
    //Function to erase a validation code
    function eraseCode(object $connection, string $email){
        $query = "DELETE FROM validation_keys WHERE ValidationEmail = '$email'";
        $delete = $connection->prepare($query);
        $delete->execute();
    }

    //function to create an answer
    function createAnswer(bool $status){
        $answer = array();
        ($status)? $answer['keyStatus'] = "Active": $answer['keyStatus'] = "Inactive";
        return $answer;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email']) && isset($_POST['code'])) {
            $email = $_POST['email'];
            //get a new code
            $code = $_POST['code'];
            //Register the code for validation
            $query = "SELECT * FROM validation_keys WHERE ValidationCode = '$code' AND ValidationEmail = '$email'";
            $consult = $dbConnection->prepare($query);
            $consult->execute();
            if ($consult->rowCount()) {
                $consult->setFetchMode(PDO::FETCH_ASSOC);
                $validationKey = $consult->fetch();
                $dateKey = new DateTime($validationKey['ValidationDate']);
                $today = new DateTime("now");
                $dif = $today->diff($dateKey);
                if ($dif->days){
                    eraseCode($dbConnection, $email);
                    echo json_encode(createAnswer(false));
                }elseif ($dif->h) {
                    eraseCode($dbConnection, $email);
                    echo json_encode(createAnswer(false));
                }elseif ($dif->i > 10) {
                    eraseCode($dbConnection, $email);
                    echo json_encode(createAnswer(false));
                }else {
                    eraseCode($dbConnection, $email);
                    echo json_encode(createAnswer(true));
                }
            }
            else {
                header("HTTP/1.1 404 Not Found");
                exit();
            }
        }
        else{
            header("HTTP/1.1 412 Precondition Failed");//the request don't complete the preconditions
            exit();
        }
    } else {
        header("HTTP/1.1 405 Allow; POST");
            exit();
    }
