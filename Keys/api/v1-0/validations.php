<?php
    header('Access-Control-Allow-Origin: *');
    include("../../../Config/Connection.php");
    //Function to erase a validation code
    function eraseCode(object $connection, int $id){
        $query = "DELETE FROM validation_keys WHERE IdKey = $id";
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
                    eraseCode($dbConnection, $validationKey['IdKey']);
                    echo json_encode(createAnswer(false));
                }elseif ($dif->h) {
                    eraseCode($dbConnection, $validationKey['IdKey']);
                    echo json_encode(createAnswer(false));
                }elseif ($dif->m > 5) {
                    eraseCode($dbConnection, $validationKey['IdKey']);
                    echo json_encode(createAnswer(false));
                }else {
                    eraseCode($dbConnection, $validationKey['IdKey']);
                    echo json_encode(createAnswer(true));
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                exit();
            }
        }
        else{
            header("HTTP/1.0 412 Precondition Failed");//the request don't complete the preconditions
            exit();
        }
    } else {
        header("HTTP/1.0 405 Allow; POST");
            exit();
    }
