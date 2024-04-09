
<?php
// Subject Interface
interface Subject {
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();
}

// Observer Interface
interface Observer {
    //public function update($notification); dont need this for now will just update to database
    public function updateDatabase($notification);
}

// Concrete Subject
class NotificationSubject implements Subject {
    private $observers = [];
    private $notification;

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function setNotification($notification) {
        $this->notification = $notification;
        $this->notify();
    }

    public function notify() {
        foreach ($this->observers as $observer) {
          
            $observer->updateDatabase($this->notification); // Invoke database update
        }
    }
}

// Concrete Observer
class NotificationObserver implements Observer {
    private $name;
    private $userID;
    private $connection;

    public function __construct($name, $userID, $connection) {
        $this->name = $name;
        $this->userID = $userID;
        $this->connection = $connection;

    }

    public function updateDatabase($notification) {
        // Ensure connection is not null
        if (!$this->connection) {
            echo "Database connection is not established.";
            return;
        }
    
        $sql = "INSERT INTO notifications (id, description, userID) VALUES (NULL, ?, ?)";
        $prepareStatement = $this->connection->prepare($sql);
    
        if (!$prepareStatement) {
            echo "Prepare statement error: " . $this->connection->error;
            return;
        }
    
        $prepareStatement->bind_param("si", $notification, $this->userID);
        $prepareStatement->execute();
    
        if ($prepareStatement->affected_rows > 0) {
            //echo "Notification inserted successfully.";
        } else {
            //echo "Failed to insert Notification";
        }
    
        $prepareStatement->close();
    }
    
}
?>