<?php
require_once 'getUserId.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON data from the request body
    $data = json_decode(file_get_contents("php://input"));

    // Extract data from the JSON object
    $carID = $data->carID;

    // Connect to your database
    $connect = new mysqli("localhost", "root", "", "test");

    // Check for database connection errors
    if($connect->connect_error) {
        die("Connection Failed: " . $connect->connect_error);
    }

    // Initialize arrays to store the fields and values to update
    $fieldsToUpdate = array();
    $valuesToUpdate = array();

    // Check which fields have values in the JSON object and add them to the arrays
    if (!empty($data->carMake)) {
        $fieldsToUpdate[] = "make=?";
        $valuesToUpdate[] = $data->carMake;
    }
    if (!empty($data->carModel)) {
        $fieldsToUpdate[] = "model=?";
        $valuesToUpdate[] = $data->carModel;
    }
    if (!empty($data->carYear)) {
        $fieldsToUpdate[] = "year=?";
        $valuesToUpdate[] = $data->carYear;
    }
    if (!empty($data->carColor)) {
        $fieldsToUpdate[] = "color=?";
        $valuesToUpdate[] = $data->carColor;
    }
    if (!empty($data->carMileage)) {
        $fieldsToUpdate[] = "carMileage=?";
        $valuesToUpdate[] = $data->carMileage;
    }
    if (!empty($data->startDate)) {
        $fieldsToUpdate[] = "startavailability=?";
        $valuesToUpdate[] = $data->startDate;
    }
    if (!empty($data->endDate)) {
        $fieldsToUpdate[] = "endAvailability=?";
        $valuesToUpdate[] = $data->endDate;
    }
    if (!empty($data->pickupLocation)) {
        $fieldsToUpdate[] = "pickuplocation=?";
        $valuesToUpdate[] = $data->pickupLocation;
    }
    if (!empty($data->rentPrice)) {
        $fieldsToUpdate[] = "rentprice=?";
        $valuesToUpdate[] = $data->rentPrice;
    }
    

    //Built SQL query dynamically based on the fields user entered
    $query = "UPDATE carinventory SET ";
    $query .= implode(", ", $fieldsToUpdate);
    $query .= " WHERE carID=?";
    
   
    $prepareStatement = $connect->prepare($query);

    
    $types = str_repeat('s', count($valuesToUpdate)) . 's';
    
 
    $params = array_merge(array($types), $valuesToUpdate, array($carID));

    
    $prepareStatement->bind_param(...$params);
    
    
    $prepareStatement->execute();

    
    if ($prepareStatement->affected_rows > 0) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false);
    }

   
    $prepareStatement->close();
    $connect->close();

    
    echo json_encode($response);
}
?>
