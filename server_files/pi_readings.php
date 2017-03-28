<?php

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    die('Request method must be POST!');
}

$conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");
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

$Bike_Speed = $json_string["Bike_Speed"];
$distance = $json_string["Trip_Distance"];
$altitude = $json_string["Total_Distance"];
$trip_id = $json_string["Trip_ID"];
date_default_timezone_set('America/Vancouver');
$time = date("Y-m-d H:i:s");
//echo "bike speed = ".$Bike_Speed . " trip distance = ". $distance . " total distance = ".$altitude . " time = ".$time . " trip id = ".$trip_id;

if($stmt = $conn->prepare("INSERT INTO bikedata (trip_number, speed, altitude, distance, time) VALUES (?, ?, ?, ?, ?)")) {
	$stmt->bind_param("iddds", $trip_id, $Bike_Speed, $altitude, $distance, $time);
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
