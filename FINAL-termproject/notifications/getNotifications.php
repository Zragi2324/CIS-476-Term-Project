<?php
include "C:/xampp/htdocs/projects/CIS-476-Term-Project/FINAL-termproject/getUserId.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the incoming JSON data
    $postData = json_decode(file_get_contents('php://input'));
    // Retrieve the username from the JSON data
    $username = $postData->username;
    
    // Get the user ID using the username
    $userID = getUserId($username);

    // Establish a connection to the database
    $connection = new mysqli("localhost", "root", "", "test");

    // Check for connection errors
    if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
    }

    // Prepare the SQL query to retrieve notifications for the user
    $query = "SELECT * FROM notifications WHERE userID = ?";
    $stmt = $connection->prepare($query);
    
    // Bind the user ID parameter to the query
    $stmt->bind_param("i", $userID);
    
    // Execute the query
    $stmt->execute();

    // Get the result 
    $result = $stmt->get_result();

    // Initialize an array to store the notifications
    $notifications = array();

    // Check if there are any notifications
    if ($result->num_rows > 0) {
        // Fetch each row and add it to the notifications array
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $connection->close();

    // Encode the notifications array as JSON and send it as the response
    echo json_encode($notifications);
} else {

    echo json_encode(array("success" => false, "error" => "Invalid request method"));
}
?>
