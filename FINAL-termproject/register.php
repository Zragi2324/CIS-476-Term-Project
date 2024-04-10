<?php

require_once 'manageSession.php';
include 'getUserId.php';
if (isset($_SERVER['HTTP_ORIGIN'])) { 
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}

function isUserNameTaken($connect, $userName){
    $query = "SELECT * FROM users WHERE username=?";
    $prepareStatement = $connect->prepare($query);
    $prepareStatement->bind_param("s", $userName);
    $prepareStatement->execute();
    $result = $prepareStatement->get_result();
    
    if($result->num_rows > 0){
        $response = array("Unavailable" => true);
        echo json_encode($response);
        $prepareStatement->close();
        return true;
    } else {
        $response = array("Available" => false);
        $prepareStatement->close();
        return false;
    }
}

function register($connect, $userName, $password, $sq1,$sa1, $sq2, $sq3,$sa2, $sa3){
    $query = "INSERT INTO users (ID, username, password,balance) VALUES (NULL,?, ?,0.00)";
    $prepareStatement = $connect->prepare($query);
    $prepareStatement->bind_param("ss", $userName, $password);
    $prepareStatement->execute();

    $userID = getUserId( $userName);
    $query2 = "INSERT INTO securityquestions (id, sq1, sa1, sq2, sa2, sq3, sa3) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $prepareStatement2 = $connect->prepare($query2);
    $prepareStatement2->bind_param("issssss", $userID, $sq1, $sa1, $sq2, $sq3, $sa2, $sa3);
    $prepareStatement2->execute();
    if(($prepareStatement->affected_rows > 0) && ($prepareStatement2->affected_rows > 0)){
        $response = array("Success" => true);
        echo json_encode($response);
    } else {
        $response = array("Failed" => false);
        echo json_encode($response);
    }
    $prepareStatement->close();
    $prepareStatement2->close();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = json_decode(file_get_contents("php://input"));
    $userName = $user->username;
    $password = $user->password;
    $sq1 = $user->sq1;
    $sq2 = $user->sq2;
    $sq3 = $user->sq3; 
    $sa1 = $user->sa1;
    $sa2 = $user->sa2;
    $sa3 = $user->sa3;

    $connect = new mysqli("localhost", "root", "", "termproject");

    if($connect->connect_error) {
        die("Connection Failed: " . $connect->connect_error);
    }

    if(!isUserNameTaken($connect, $userName)) {
        register($connect, $userName, $password, $sq1,$sa1, $sq2,$sa2, $sq3, $sa3);
    }

    $connect->close();
}

?>
