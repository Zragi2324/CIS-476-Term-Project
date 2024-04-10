<?php

//require_once 'manageSession.php';

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


if(isset($_POST)){

    $user  =  json_decode(file_get_contents("php://input")); 
    $userName=$user->username;
   $password=$user->password;
    

    $connect = new mysqli("localhost","root","", "termproject");


   
    if($connect->connect_error){
        die("Connection failed: " .$connect->connect_error);
    }
    
    executeQuery($connect,  $userName,$password );
}



class manageSession {
    private static $currentInstance; 

    private function __construct(){
        session_start();
    }

    public static function getInstance(){
        if(!isset(self::$currentInstance)){
            self::$currentInstance = new self();
        }
        return self::$currentInstance;
    }

    public function start($username){
        $this->endPreviousSession($username);
        $_SESSION['username'] = $username;
    }

    public function getUserName(){
        return isset($_SESSION['username']) ? $_SESSION['username'] : null;

    }

    public function endSession(){
        session_unset();
        session_destroy();
        $_SESSION = array();
    }

    private function endPreviousSession($username){
        if(isset($_SESSION['username']) && $_SESSION['username'] !== $username){
            $this->endSession();
        }
    }
    
    
    }






function executeQuery($connectToSql, $userName, $password){


    $query="SELECT *
    FROM users
    WHERE username=? AND password=?";


    
    $prepareStatement = $connectToSql->prepare($query);
    $prepareStatement->bind_param("ss", $userName, $password );
    $prepareStatement->execute();
    $result = $prepareStatement->get_result();

    
    if($result->num_rows > 0){

        $response = array("success" => true);
        
        //singleton pattern 
        $manageSession = manageSession::getInstance();

        $manageSession->start($userName);
        //header("Location: index.html");
    
    }else{
        $response = array("Faild" => false);

       //die("failed query, invalid username or password");
    }
   
    echo json_encode($response);
   $prepareStatement->close();
   $connectToSql->close();

}






?>