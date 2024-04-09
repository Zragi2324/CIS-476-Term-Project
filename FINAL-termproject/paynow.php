<?php

include 'getUserId.php';

$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function payBalance($conn, $username){
    $userId = getUserId( $username);
    $sqlQuery = "UPDATE users  set balance =0.00 WHERE ID =?";
    $stmt = $conn->prepare($sqlQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
   // $result = $stmt->get_result();
   $Payment = new NotificationSubject();
   $observedUpdate = new NotificationObserver("Made Payment",$userID, $connect);
   $Payment->attach( $observedUpdate);
   $Payment->setNotification("You have paid your balance!");
    if($stmt->execute()){
        return 0.00;
}else{
    return null;
}
$stmt->close();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = json_decode(file_get_contents("php://input"));
    $userName = $user->username;
    
    
    $balance = payBalance($conn, $userName);

    if ($balance !== null) {
        $response = array("success" => true, "totalBalance" => $balance);
        echo json_encode($response);
    } else {
        $response = array("success" => false);
        echo json_encode($response);
    }

    
}

$conn->close();
?>