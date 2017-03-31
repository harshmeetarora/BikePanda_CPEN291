<?php

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    die('Request method must be POST!');
}

$conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//echo file_get_contents("php://input");
$content = file_get_contents("php://input");
$json_string = json_decode($content, true);

if(!is_array($json_string)){
	die('Received content contained invalid JSON!');
}

$user_id = 1;
$Bike_Speed = $json_string["Bike_Speed"];
$trip_distance = $json_string["Trip_Distance"];
$total_distance = $json_string["Total_Distance"];
$trip_id = $json_string["Trip_ID"];
$longitude = $json_string["Longitude"];
$latitude = $json_string["Latitude"];
date_default_timezone_set('America/Vancouver');
$time = date("Y-m-d H:i:s");
$altitude = $json_string["Altitude"];
$calories = intval($Bike_speed * (3.6/1.609) * ((3.509/1.609) + 0.2581*($Bike_speed * (3.6/1.609))*($Bike_speed * (3.6/1.609))));
//echo "bike speed = ".$Bike_Speed . " trip distance = ". $distance . " total distance = ".$altitude . " time = ".$time . " trip id = ".$trip_id;

if($stmt = $conn->prepare("INSERT INTO bikedata (userid, trip_number, speed, altitude, calories, trip_distance, total_distance, latitude, longitude, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
	$stmt->bind_param("iiddddddds", $user_id, $trip_id, $Bike_Speed, $altitude, $calories, $trip_distance, $total_distance, $latitude, $longitude, $time);
} else {
	die("Prepared statement failed failed: " . $conn->error_list);
}

if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}
echo "New record created successfully";
$stmt->close();
$conn->close();

?>
