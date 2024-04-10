<?php
require_once 'getUserId.php';
require_once 'manageSession.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);
    error_log(print_r($postData, true));
    
    if (!isset($postData['username'])) {
        echo json_encode(array("success" => false, "error" => "Username not provided"));
        exit;
    }

    $userName = $postData['username'];

   
    $userID = getUserId($userName);
    $username = $postData['username'];
    $sa1 = $postData['answers']['sq1'];
    $sa2 = $postData['answers']['sq2'];
    $sa3 = $postData['answers']['sq3'];

 
    if ($userID === null) {
        echo json_encode(array("success" => false, "error" => "User not found"));
        exit;
    }
    
   
   
    $mysqli = new mysqli("localhost", "root", "", "termproject");
    if ($mysqli->connect_error) {
        die("Connection Failed: " . $mysqli->connect_error);
    }

 
    $query = "SELECT *  FROM securityquestions WHERE id = ? AND sa1=? AND sa2=? AND sa3=?";

    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    
    $stmt->bind_param("isss", $userID,$sa1,$sa2, $sa3);
    $stmt->execute();
    $result = $stmt->get_result();

  
    if ($result === false) {
        echo json_encode(array("success" => false, "error" => "Query execution failed: " . $mysqli->error));
    } else {
        // Check if there is a matching row
        if ($result->num_rows > 0) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "error" => "Invalid answers"));
        }
    }

    $mysqli->close();
} else {
    
    echo json_encode(array("success" => false, "error" => "Invalid request method"));
}
?>
