<?php

include 'getUserId.php';
require_once 'C:/xampp/htdocs/projects/CIS-476-Term-Project/FINAL-termproject/notifications/pushNotifications.php';
header('Content-Type: application/json');

// Connected to  db
$conn = new mysqli("localhost", "root", "", "termproject");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Query to check if the car is available in carinventory and in booking table
function isCarAvailable($carId, $rentStart, $rentEnd, $conn)
{
    
    $query = "SELECT * FROM carinventory WHERE carID = ? AND startavailability <= ? AND endAvailability >= ?";
    
    
    $prepareStatement = $conn->prepare($query);
    
    
    $prepareStatement->bind_param("iss", $carId, $rentStart, $rentEnd);
    $prepareStatement->execute();
    
    
    $result = $prepareStatement->get_result();
    
    
    if ($result->num_rows == 0) {
        
        return false;
    }

    
    $query = "SELECT * FROM booking WHERE carID = ? AND ((bookingStart <= ? AND bookingEnd >= ?) OR (bookingStart <= ? AND bookingEnd >= ?))";
    
    
    $prepareStatement = $conn->prepare($query);
    
    
    $prepareStatement->bind_param("isiss", $carId, $rentStart, $rentStart, $rentEnd, $rentEnd);
    $prepareStatement->execute();
    
    
    $result = $prepareStatement->get_result();
    
    
    if ($result->num_rows > 0) {
        
        return false;
    }

    
    return true;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user = json_decode(file_get_contents("php://input"));
    
    
    $carId = $user->carID;
    $rentStart = $user->bookingStart;
    $rentEnd = $user->bookingEnd;
    $username = $user->username;

    
    if (empty($carId) || empty($rentStart) || empty($rentEnd)) {
        
        $response = array("success" => false, "message" => "Please fill in all fields.");
        echo json_encode($response);
        exit; 
    }
    
   
        if (isCarAvailable($carId, $rentStart, $rentEnd, $conn, $username)) {
            // Get the user ID
            $userId = getUserId($username);
        
            // Fetch the price of the car from carInventory
            $priceQuery = "SELECT rentprice FROM carinventory WHERE carID = ?";
            $priceStatement = $conn->prepare($priceQuery);
            $priceStatement->bind_param("i", $carId);
            $priceStatement->execute();
            $priceResult = $priceStatement->get_result();
            
            // Check if the car exists in carInventory
            if ($priceResult->num_rows > 0) {
                // Fetch the price
                $priceRow = $priceResult->fetch_assoc();
                $carPrice = $priceRow['rentprice'];
        
                // Calculate the total cost of the booking
                $bookingDuration = strtotime($rentEnd) - strtotime($rentStart);
                $bookingDays = ceil($bookingDuration / (60 * 60 * 24)); // Converted duration to days
                $totalCost = $carPrice * $bookingDays;
        
                // Updated the user's balance
                $updateQuery = "UPDATE users SET balance = balance - ? WHERE ID = ?";
                $updateStatement = $conn->prepare($updateQuery);
                $updateStatement->bind_param("di", $totalCost, $userId);
                $updateStatement->execute();
        
                // Insert the booking into the booking table
                $bookingQuery = "INSERT INTO booking (carID, userID, bookingStart, bookingEnd) VALUES ( ?, ?, ?, ?)";
                $bookingStatement = $conn->prepare($bookingQuery);
                $bookingStatement->bind_param("iiss", $carId, $userId, $rentStart, $rentEnd);
                $bookingStatement->execute();
                $bookingStatement->close();
        
                // Close statements
                $updateStatement->close();
                $priceStatement->close();


        
                // Output success message
                $response = array("success" => true, "message" => "Car booked successfully!");

                

                // Initialize NotificationSubject and NotificationObserver objects
               // $BOOKED = new NotificationSubject(); 
                //$observedUpdate = new NotificationObserver("Car booked", $userID, $conn);
                //$BOOKED->attach($observedUpdate);
                //$BOOKED->setNotification("Your booked car with VIN number: {$carId}");
                
                // Output JSON response
                echo json_encode($response);
            } else {
               
                $response = array("success" => false, "message" => "Car not found in inventory.");
                echo json_encode($response);
            }
        } else {
            
            $response = array("success" => false, "message" => "The selected car is not available for the specified period.");
            echo json_encode($response);
        }
    }

?>
