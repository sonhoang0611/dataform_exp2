<?php
//including the required files
require_once '../include/DbOperation.php';
require '../libs/Slim/Slim.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin");
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/departureFlights', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllFlights();
    $response = array();
    $response['departureFlights'] = array();

    while($row = $result->fetch_assoc()){
        $temp = array();
       $temp['airplanecode'] = $row['airplanecode'];
        $temp['airplanename'] = $row['airplanename'];
      
        array_push($response['departureFlights'],$temp);
    }

    echoResponse(200,$response);
});

$app->get('/destinationFlights/:departure', function($departure) use ($app){
    $db = new DbOperation();
    $result = $db->getAllDestinationFlights($departure);
    $response = array();
    $response['desFlights'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['destination']= $row['destination'];
        $temp['airplanename']= $row['airplanename'];
        array_push($response['desFlights'],$temp);
    }
    echoResponse(200,$response);
});

$app->get('/details/:bookingcode', function($bookingcode) use ($app){
    $db = new DbOperation();
    $result = $db->getFlightDetails($bookingcode);
    $response = array();
    $response['flightDetails'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['bookcode']= $row['bookcode'];
        $temp['planecode']= $row['planecode'];
        $temp['dayflight']= $row['dayflight'];
        $temp['flightclass']= $row['flightclass'];
        $temp['flightprice']= $row['flightprice'];
        array_push($response['flightDetails'],$temp);
    }
    echoResponse(200,$response);
});


$app->get('/flights/:departure/:destination/:departday/:quantity', function ($departure,$destination,$departday,$quantity) use ($app) {
    $db = new DbOperation();
    $response = array();
    if ($db->findFlightsOneWay($departure,$destination,$departday,$quantity)) {
         $response['availableFlights'] = array();
         $flight = $db->getFlightsOneWay($departure,$destination,$departday,$quantity);
        while($row = $flight->fetch_assoc()) {       
            $temp = array();
            $temp['departday'] = $row['departday'];
            $temp['flightcode'] = $row['flightcode'];
            $temp['departure'] = $row['departure'];
            $temp['destination'] = $row['destination'];
            $temp['class'] = $row['class'];
            $temp['timestart'] = $row['timestart'];
            $temp['pricetag'] = $row['pricetag'];
            $temp['priceticket'] = $row['priceticket'];
            array_push($response['availableFlights'],$temp);
        }
       
    } else {
        $response['message'] = "Can't find eauivalent flights";
    }
    echoResponse(200, $response);
});

$app->post('/booking', function () use ($app) {
    $response = array();
    $db = new DbOperation();
    $bookingcode = $app->request->post('bookcode');
    $flightcode = $app->request->post('planecode');
    $departday = $app->request->post('dayflight');
    $class = $app->request->post('flightclass');
    $pricetag = $app->request->post('flightprice');
   
    $code = $db->createBookingCode($bookingcode);
    $res = $db->createNewFlightDetails($bookingcode,$flightcode, $departday, $class, $pricetag);
    
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = "Successfully added flight details";
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Failed to add flight details";
        echoResponse(200, $response);
    }
});

$app->post('/customers', function () use ($app) {
    $response = array();
    $db = new DbOperation();
    $customercode = $app->request->post('customercode');
    $title = $app->request->post('title');
    $lastname = $app->request->post('lastname');
    $firstname = $app->request->post('firstname');
    $email = $app->request->post('email');
    $phone = $app->request->post('phone');
   
    $res = $db->createNewCustomers($customercode, $title, $lastname, $firstname, $email, $phone);
    
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = "Successfully added customers";
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Failed to add customers";
        echoResponse(200, $response);
    }
});




function echoResponse($status_code, $response)
{
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}

$app->run();