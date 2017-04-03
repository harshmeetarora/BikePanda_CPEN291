<?php

// only serve POST requests
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    die('Request method must be POST!');
}

$conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// decode the input to this file (it is JSON if it is coming from the PI)
$content = file_get_contents("php://input");
$json_string = json_decode($content, true);

// validate
if(!is_array($json_string)){
	die('Received content contained invalid JSON!');
}

// read out the JSON fields
// for the demo we have only 1 user. 
// in future, we could update this user dynamically from the PI
// or a mobile app
$user_id = 1;
$Bike_Speed = $json_string["Bike_Speed"];
$trip_distance = $json_string["Trip_Distance"];
$total_distance = $json_string["Total_Distance"];
$trip_id = $json_string["Trip_ID"];
$longitude = $json_string["Longitude"];
$latitude = $json_string["Latitude"];

// standardize the timestamps to be PST
date_default_timezone_set('America/Vancouver'); 
$time = date("Y-m-d H:i:s");
$altitude = $json_string["Altitude"];

// calorie formula based on http://www.cptips.com/formula.htm
$calories = ($Bike_Speed*(3.5+(0.2581*$Bike_Speed*$Bike_Speed))/4186;

// prepare statement, to ward off potential SQL injections
if($stmt = $conn->prepare("INSERT INTO bikedata (userid, trip_number, speed, altitude, calories, trip_distance, total_distance, latitude, longitude, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
	$stmt->bind_param("iiddddddds", $user_id, $trip_id, $Bike_Speed, $altitude, $calories, $trip_distance, $total_distance, $latitude, $longitude, $time);
} else {
	die("Prepared statement failed failed: " . $conn->error_list);
}

if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

// if all goes well we can respond (useful for testing)
echo "New record created successfully";
$stmt->close();
$conn->close();

?>
