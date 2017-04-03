<?php

// this only serves GET requests
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
        die('Get requests only');
}
$conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if(!isset($_GET['tripid'])) {
	die('Get request failed on parameter');
}

// initialize lat and long to UBC
$longitude = 49.2607;
$latitude = -123.2461;
$arr = array();
$trip_number = $_GET['tripid'];

// now get the GPS data for the trip!
if($stmt = $conn->prepare("SELECT longitude, latitude FROM bikedata WHERE trip_number = ?")) {
        $stmt->bind_param("i",$trip_number);
} else {
        die("Prepared statement failed failed: " . $conn->error_list);
}

// error checking
if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

$stmt->bind_result($longitude, $latitude);

// fetch the row values of latitude and longitude
while($stmt->fetch()) {
	array_push($arr, ['longitude' => $longitude, 'latitude' => $latitude]);
}

// send results and close the db connection
echo json_encode($arr);
$stmt->close();
$conn->close();
?>

