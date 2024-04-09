<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "test");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM carinventory WHERE 1=1 ";

$searchData = json_decode(file_get_contents("php://input"), true);

// Build the search query dynamically based on the provided data recieved
foreach ($searchData as $key => $value) {
    if (!empty($value)) {
        //added conditions for each field
        $sql .= " AND $key = '$value' ";
    }
}


$result = $conn->query($sql);


$searchResults = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }
}

echo json_encode($searchResults);


$conn->close();
?>
