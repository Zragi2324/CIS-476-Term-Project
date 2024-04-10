<?php

function getUserId($username) {
  
    
    $connect = new mysqli("localhost", "root", "", "termproject");

    if ($connect->connect_error) {
        die("Connection Failed: " . $connect->connect_error);
    }

    $getID = "SELECT ID FROM users WHERE username=?";
    $prepareStatement1 = $connect->prepare($getID);
    $prepareStatement1->bind_param("s", $username);
    $prepareStatement1->execute(); 

    $result1 = $prepareStatement1->get_result();

    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();


        return $row['ID'];
    } else {
        return null; // User not found
    }
}
?>
