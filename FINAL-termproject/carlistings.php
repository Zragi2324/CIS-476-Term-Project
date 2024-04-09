<?php

require_once 'getUserId.php';
header('Content-Type: application/json');
error_reporting(E_ALL & ~E_NOTICE);

// Disable displaying notices
ini_set('display_errors', 0);
/*
if (isset($_SERVER['HTTP_ORIGIN'])) { 
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}


function doesCarExist($connect, $vin){
    $query = "SELECT * FROM carinventory WHERE carID =?" ;
    $prepareStatement = $connect->prepare($query);
    $prepareStatement->bind_param("s", $vin);
    $prepareStatement->execute();
    $result = $prepareStatement->get_result();
    
    if($result->num_rows > 0){
        $response = array("Unavailable" => true);
        echo json_encode($response);
        $prepareStatement->close();
        return true;
    } else {
        $response = array("Available" => false);
        $prepareStatement->close();
        return false;
    }
}


function registerCar($connect, $userName1, $vin, $carMake, $carModel, $carColor, $startDate, $endDate, $carYear, $pickupLoc, $carMileage, $rentPrice){
    $userID = getUserId($userName1);
    $query = "INSERT INTO carinventory (carID, make, model, year, color, ownerID, startavailability, endAvailability, carMileage, pickuplocation, rentprice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $prepareStatement = $connect->prepare($query);
    $prepareStatement->bind_param("sssissssssi", $vin, $carMake, $carModel, $carYear, $carColor, $userID, $startDate, $endDate, $carMileage, $pickupLoc, $rentPrice);
    $prepareStatement->execute();
    
    if ($prepareStatement->affected_rows > 0) {
        $response = array("success" => true);
        echo json_encode($response);
    } else {
        $response = array("failed" => false);
        echo json_encode($response);
    }
    $prepareStatement->close();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = json_decode(file_get_contents("php://input"));
    $userName1 = $user->userName1;
    //$submitNewListingBtn = $user->submitNewListingBtn;
    $vin = $user->vin;
    $carMake = $user->carMake;
    $carModel = $user->carModel;
    $carColor = $user->carColor;
    $startDate = $user->startDate;
     $endDate = $user->endDate;
      $carYear = $user->carYear;
     $pickupLoc = $user->pickupLoc;
     $carMileage = $user->carMileage;
     $rentPrice = $user->rentPrice;
    $connect = new mysqli("localhost", "root", "", "test");

    if($connect->connect_error) {
        die("Connection Failed: " . $connect->connect_error);
    }

    if(!doesCarExist($connect, $vin)) {
        registerCar($connect, $userName1, $vin, $carMake, $carModel,  $carColor, $startDate,  $endDate, $carYear, $pickupLoc,$carMileage, $rentPrice);
    }


    $connect->close();
}*/


class CarListing
{
    private $vin;
    private $carMake;
    private $carModel;
    private $carColor;
    private $startDate;
    private $endDate;
    private $carYear;
    private $pickupLoc;
    private $carMileage;
    private $rentPrice;

    public function __construct($builder)
    {
        $this->vin = $builder->vin;
        $this->carMake = $builder->carMake;
        $this->carModel = $builder->carModel;
        $this->carColor = $builder->carColor;
        $this->startDate = $builder->startDate;
        $this->endDate = $builder->endDate;
        $this->carYear = $builder->carYear;
        $this->pickupLoc = $builder->pickupLoc;
        $this->carMileage = $builder->carMileage;
        $this->rentPrice = $builder->rentPrice;
    }

    public function getVin()
    {
        return $this->vin;
    }

    public function getCarMake()
    {
        return $this->carMake;
    }

    public function getCarModel()
    {
        return $this->carModel;
    }

    public function getCarColor()
    {
        return $this->carColor;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getCarYear()
    {
        return $this->carYear;
    }

    public function getPickupLoc()
    {
        return $this->pickupLoc;
    }

    public function getCarMileage()
    {
        return $this->carMileage;
    }

    public function getRentPrice()
    {
        return $this->rentPrice;
    }

    // Setter methods
    public function setVin($vin)
    {
        $this->vin = $vin;
        return $this;
    }

    public function setCarMake($carMake)
    {
        $this->carMake = $carMake;
        return $this;
    }

    public function setCarModel($carModel)
    {
        $this->carModel = $carModel;
        return $this;
    }

    public function setCarColor($carColor)
    {
        $this->carColor = $carColor;
        return $this;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function setCarYear($carYear)
    {
        $this->carYear = $carYear;
        return $this;
    }

    public function setPickupLoc($pickupLoc)
    {
        $this->pickupLoc = $pickupLoc;
        return $this;
    }

    public function setCarMileage($carMileage)
    {
        $this->carMileage = $carMileage;
        return $this;
    }

    public function setRentPrice($rentPrice)
    {
        $this->rentPrice = $rentPrice;
        return $this;
    }
}
class CarListingBuilder
{
    public $vin;
    public $carMake;
    public $carModel;
    public $carColor;
    public $startDate;
    public $endDate;
    public $carYear;
    public $pickupLoc;
    public $carMileage;
    public $rentPrice;

    public function setVin($vin)
    {
        $this->vin = $vin;
        return $this;
    }

    public function setCarMake($carMake)
    {
        $this->carMake = $carMake;
        return $this;
    }

    public function setCarModel($carModel)
    {
        $this->carModel = $carModel;
        return $this;
    }

    public function setCarColor($carColor)
    {
        $this->carColor = $carColor;
        return $this;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function setCarYear($carYear)
    {
        $this->carYear = $carYear;
        return $this;
    }

    public function setPickupLoc($pickupLoc)
    {
        $this->pickupLoc = $pickupLoc;
        return $this;
    }

    public function setCarMileage($carMileage)
    {
        $this->carMileage = $carMileage;
        return $this;
    }

    public function setRentPrice($rentPrice)
    {
        $this->rentPrice = $rentPrice;
        return $this;
    }

    public function build()
    {
        return new CarListing($this);
    }
}
function doesCarExist($connect, $vin){
    $query = "SELECT * FROM carinventory WHERE carID = ?" ;
    $prepareStatement = $connect->prepare($query);
    $prepareStatement->bind_param("s", $vin);
    $prepareStatement->execute();
    $result = $prepareStatement->get_result();
    
    if($result->num_rows > 0){
        $response = array("Unavailable" => true);
        echo json_encode($response);
        $prepareStatement->close();
        return true;
    } else {
        $response = array("Available" => false);
        $prepareStatement->close();
        return false;
    }
}
function registerCar($connect, $userName1, $carListing){
    $userID = getUserId($userName1);
    $query = "INSERT INTO carinventory (carID, make, model, year, color, ownerID, startavailability, endAvailability, carMileage, pickuplocation, rentprice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $prepareStatement = $connect->prepare($query);
    $prepareStatement->bind_param("sssissssssi",
        $carListing->getVin(), 
        $carListing->getCarMake(), 
        $carListing->getCarModel(), 
        $carListing->getCarYear(), 
        $carListing->getCarColor(), 
        $userID, 
        $carListing->getStartDate(), 
        $carListing->getEndDate(), 
        $carListing->getCarMileage(), 
        $carListing->getPickupLoc(), 
        $carListing->getRentPrice()
    );
    $prepareStatement->execute();
     /*
        $response = array("success" => true);
        $to = $userName1;
        $subject = "Test Email";
        $message = "This is a test email.";
        $headers = "From: sender@example.com" . "\r\n" .
           "Reply-To: sender@example.com" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();
           // Send email
        if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
            } else {
    echo "Failed to send email.";
    }*/
    if ($prepareStatement->affected_rows > 0) {
        $response = array("success" => true);
        echo json_encode($response);
    } else {
        $response = array("failed" => false);
        echo json_encode($response);
    }
    $prepareStatement->close();
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = json_decode(file_get_contents("php://input"));
    $userName1 = $user->userName1;

    // Created a new CarListing object using CarListingBuilder
    $carListing = (new CarListingBuilder())
        ->setVin($user->vin)
        ->setCarMake($user->carMake)
        ->setCarModel($user->carModel)
        ->setCarColor($user->carColor)
        ->setStartDate($user->startDate)
        ->setEndDate($user->endDate)
        ->setCarYear($user->carYear)
        ->setPickupLoc($user->pickupLoc)
        ->setCarMileage($user->carMileage)
        ->setRentPrice($user->rentPrice)
        ->build();

    $connect = new mysqli("localhost", "root", "", "test");

    if ($connect->connect_error) {
        // Return error response
        http_response_code(500);
        echo json_encode(["error" => "Connection failed: " . $connect->connect_error]);
        exit;
    }

    if (!doesCarExist($connect, $carListing->getVin())) {
        $registered = registerCar($connect, $userName1, $carListing);
        if($registered == true){
            $BOOKED = new NotificationSubject();
            
            $vinC= $carListing->getVin();
          $userID = getUserId( $userName1); 
            $observedUpdate = new NotificationObserver("Car inserted",$userID, $connect);
            $BOOKED->attach( $observedUpdate);
            $BOOKED->setNotification("your car with vin number: {$vinC} has been added to listing");
    
    }

    $connect->close();
    }
}

?>


