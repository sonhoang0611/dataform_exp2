<?php

class DbOperation
{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    public function getAllFlights(){
        $stmt = $this->con->prepare("SELECT * FROM airplane");
        $stmt->execute();
        $depflights = $stmt->get_result();
        $stmt->close();
        return $depflights;
    }

     public function getAllDestinationFlights($departure){
        $stmt = "SELECT fl.destination, ap.airplanename FROM flight fl, airplane ap WHERE fl.departure=? and fl.destination = ap.airplanecode group by destination";
        
        if($query = $this->con->prepare($stmt)){
            $query->bind_param("s", $departure);
            $query->execute();
            $desflights = $query->get_result();
            $query->close();
            return $desflights;
        //rest of code here
        }   
        else {
            return null;
        }
        
    }

    //Method to get student details
    public function getFlightsOneWay($departure,$destination,$departday,$quantity){
        $stmt = $this->con->prepare("SELECT * FROM flight WHERE departure=? and destination=? and departday=? and chairquantity>?");
        $stmt->bind_param("sssi",$departure,$destination,$departday,$quantity);
        $stmt->execute();
        $flight = $stmt->get_result();
        $stmt->close();
        return $flight;
    }


    public function findFlightsOneWay($departure,$destination,$departday,$quantity){
        $stmt = "SELECT * FROM flight WHERE departure=? and destination=? and departday=? and chairquantity>?";
        if($query = $this->con->prepare($stmt)){
            $query->bind_param("sssi",$departure,$destination,$departday,$quantity);
            $query->execute();
            $query->store_result();
            $num_rows = $query->num_rows;
            $query->close();
            return $num_rows>0;
        }
        else {
            return 0;
        }

    }

    public function createBookingCode(){
 
            $bookingCode = $this->generateApiKey();
            $timebooking = null;
            $total = null;
            $statusbooking = 0;
            //Crating an statement
            $stmt = $this->con->prepare("INSERT INTO booking(bookingCode,timebooking,total,statusbooking) values(?,?,?,?)");
 
            //Binding the parameters
            $stmt->bind_param("sssi", $bookingCode,$timebooking,$total,$statusbooking);
 
            //Executing the statment
            $result = $stmt->execute();
 
            //Closing the statment
            $stmt->close();
 
            //If statment executed successfully
            if ($result) {
                //Returning 0 means student created successfully
                return 0;
            } else {
                //Returning 1 means failed to create student
                return 1;
            }
        
    }

     public function createNewFlightDetails($bookingcode, $flightcode, $departday, $class, $pricetag){
            $stmt = $this->con->prepare("INSERT INTO flightdetails(bookingcode, name, username, password, api_key) values(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss",$bookingcode, $flightcode, $departday, $class, $pricetag);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 0;
            } else {
                return 1;
            }
    }

    public function getBookingCode(){
        $stmt = $this->con->prepare("SELECT * FROM booking where statusbooking=0 limit 1");
        $stmt->execute();
        $depflights = $stmt->get_result();
        $stmt->close();
        return $depflights;
    }

 
    private function generateApiKey(){
        return substr(str_shuffle(str_repeat("QWERTYUIOPLKJHGFDSAMNBVCXZ", 6)), 0, 6);
    }
}