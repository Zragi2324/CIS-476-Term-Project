<?php
//singleton class to manage session
class manageSession {
    private static $currentInstance; // current instance 

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
        if((isset($_SESSION['username'])) && ($_SESSION['username'] === $username)){
            $this->endSession();
        }
    }
    
    }
?>