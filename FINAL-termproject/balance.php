<?php
include 'getUserId.php';

$conn = new mysqli("localhost", "root", "", "termproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getBalance($conn, $userName){
    $userId = getUserId( $userName);

    $sqlQuery = "SELECT balance FROM users WHERE ID = ?";
    $stmt = $conn->prepare($sqlQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $balance = $row["balance"];
        return $balance;
    } else {
        return null;
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = json_decode(file_get_contents("php://input"));
    $userName = $user->username;

    $balance = getBalance($conn, $userName);

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
