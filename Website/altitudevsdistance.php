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

$altitude = 0;
$trip_distance = 0;
$arr = array();
$trip_number = $_GET['tripid'];
$trip_start = 0;


// get the time stamp for the beginning of the trip
if($stmt1 = $conn->prepare("SELECT MIN(time) as time FROM bikedata WHERE trip_number = ?")) {
        $stmt1->bind_param("i",$trip_number);
} else {
        die("Prepared statement failed failed: " . $conn->error_list);
}

if (!$stmt1->execute()) {
    die("Execute failed: (" . $stmt1->errno . ") " . $stmt1->error);
}

$stmt1->bind_result($trip_start);
$stmt1->fetch();
$stmt1->close();


// now get the rest of the data for the trip
if($stmt2 = $conn->prepare("SELECT altitude, trip_distance FROM bikedata WHERE trip_number = ?")) {
        $stmt2->bind_param("i",$trip_number);
} else {
        die("Prepared statement failed failed: " . $conn->error_list);
}

if (!$stmt2->execute()) {
    die("Execute failed: (" . $stmt2->errno . ") " . $stmt2->error);
}

$stmt2->bind_result($altitude, $trip_distance);

// fetch the row values of speed and time
while($stmt2->fetch()) {
	if ($altitude > 1) {
		array_push($arr, ['altitude' => $altitude, 'distance' => $trip_distance]);
	}
}

// add the date of the trip and send results
//array_push($arr, ["start_time" => $trip_start]);
echo json_encode($arr);
$stmt2->close();
$conn->close();
?>
