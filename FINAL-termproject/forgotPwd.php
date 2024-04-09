<?php
//forgotPwd.php file
include 'getUserId.php'; // Include getUserId.php
require_once 'manageSession.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $user = json_decode(file_get_contents("php://input"));
    $username = $user->username;

    $connect = new mysqli("localhost", "root", "", "test");

    if ($connect->connect_error) {
        die("Connection Failed: " . $connect->connect_error);
    }

    // Get the user's ID
    $userID = getUserId($username);

    if ($userID === null) {
        $response = array("success" => false, "error" => "User not found");
        echo json_encode($response);
        exit;
    }

    // Retrieve security questions for the user
    $query = "SELECT sq1, sq2, sq3 FROM securityquestions WHERE id=?";
    $prepareStatement = $connect->prepare($query);
    $prepareStatement->bind_param("i", $userID);
    $prepareStatement->execute();
    $result = $prepareStatement->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array(
            "success" => true,
            "questions" => array(
                "sq1" => $row['sq1'],
                "sq2" => $row['sq2'],
                "sq3" => $row['sq3']
            )
        );
    } else {
        $response = array("success" => false, "error" => "Security questions not found");
    }

    echo json_encode($response);

    $connect->close();
} else {
    $response = array("success" => false, "error" => "Invalid request method");
    echo json_encode($response);
}
?>
