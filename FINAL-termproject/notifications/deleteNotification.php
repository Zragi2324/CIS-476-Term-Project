<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'));
    //error_log(print_r($postData, true));
    $userID = $postData->id;

    $connection = new mysqli("localhost", "root", "", "test");


    $query = "DELETE FROM notifications WHERE id = ?";

    $stmt = $connection->prepare($query);

    if($stmt === false){
        die("Failed to prepare".$connection->connect_error);
    }

    $stmt->bind_param("i",$userID);

    $stmt->execute();
    if($stmt->affected_rows > 0){
        echo json_encode(array("success" => true));


    }else{
        echo json_encode(array("success" => false, "error" => "Failed to delete notification"));
    }

    $stmt->close();
    $connection->close();



}




















?>
