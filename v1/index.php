<?php
//including the required files
require_once '../include/DbOperation.php';
require '../libs/Slim/Slim.php';
header("Access-Control-Allow-Origin: *");
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
        $res = $db->createBookingCode();
       
    } else {
        $response['message'] = "Can't find eauivalent flights";
    }
    echoResponse(200, $response);
});

/*$app->post('/flightdetails', function () use ($app) {
    $response = array();
    $flightcode = $app->request->post('flightcode');
    $departday = $app->request->post('departday');
    $class = $app->request->post('class');
    $pricetag = $app->request->post('pricetag');
    $db = new DbOperation();
    $bookingcode = $db->getBookingCode();
    $res = $db->createFlightdetails($bookingcode,$flightcode, $departday, $class, $pricetag);
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = "Successfully added flight details";
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Failed to add flight details";
        echoResponse(200, $response);
    }
});*/

function echoResponse($status_code, $response)
{
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}

$app->run();