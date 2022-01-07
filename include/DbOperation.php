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

    public function getFlightDetails($bookingcode){
        $stmt = $this->con->prepare("SELECT * FROM flightdetails where bookcode=?");
        $stmt->bind_param("s",$bookingcode);
        $stmt->execute();
        $flightdetails = $stmt->get_result();
        $stmt->close();
        return $flightdetails;
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

    public function createBookingCode($code){
            $timebooking = null;
            $total = null;
            $statusbooking = 0;
            //Crating an statement
            $stmt = $this->con->prepare("INSERT INTO booking(bookingcode,timebooking,total,statusbooking) values(?,?,?,?)");
 
            //Binding the parameters
            $stmt->bind_param("sssi", $code,$timebooking,$total,$statusbooking);
 
            //Executing the statment
            $result = $stmt->execute();
 
            //Closing the statment
            $stmt->close();    
            if ($result) {
                return 0;
            } else {
                return 1;
            }

    }

     public function createNewFlightDetails($bookingcode, $flightcode, $departday, $class, $pricetag){
            $stmt = $this->con->prepare("INSERT INTO flightdetails(bookcode, planecode, dayflight, flightclass, flightprice) values(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss",$bookingcode, $flightcode, $departday, $class, $pricetag);
            $result = $stmt->execute();
            $stmt->close();

            //Closing the statment 
            if ($result) {
                return 0;
            } else {
                return 1;
            }
    }

    public function createNewCustomers($customercode, $title, $lastname, $firstname, $email, $phone){
            $stmt1 = "SELECT bookingcode FROM booking where statusbooking = 0 limit 1";
            if($query = $this->con->prepare($stmt1)){
                $query->execute();
                $book = $query->get_result()->fetch_assoc();
                $query->close();
            
            }

            $stmt = "INSERT INTO customer(bookedcode, customercode, title, lastname, firstname, email, phone) values(?, ?, ?, ?, ?, ?, ?)";
            if($query = $this->con->prepare($stmt)){
                $query->bind_param("sssssss", $book['bookingcode'], $customercode, $title, $lastname, $firstname, $email, $phone);
                $result = $query->execute();
                $query->close();
            
            }
            //Closing the statment 
            if ($result) {
                return 0;
            } else {
                return 1;
            }
    }

   

 
    /*private function generateApiKey(){
        return substr(str_shuffle(str_repeat("QWERTYUIOPLKJHGFDSAMNBVCXZ", 6)), 0, 6);
    }*/
}