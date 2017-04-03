<?php 

// only serve get requests
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
        die('Get request failed');
}
$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$trip_start = 0;
$time = 0;
$trip_distance = 0;
$current_trip = 0;
$altitude = 0;
$speed = 0;
$calories = 0;
$most_recent_row = 0;

// get the most recent row
if ($result = $mysqli->query("SELECT MAX(rowid) as rowid FROM bikedata")) {
	while($row = $result->fetch_assoc()) {
		$most_recent_row = $row["rowid"];
	}
	$result->free();
} else {
    echo "Error1: " . $sql . "<br>" . $mysqli->error;
}

// get the trip ID for the most recent row
if ($result = $mysqli->query("SELECT trip_number FROM bikedata WHERE rowid = '".$most_recent_row."'")) {
        while($row = $result->fetch_assoc()) {
                $current_trip = $row["trip_number"];
        }
        $result->free();
} else {
    echo "Error1: " . $sql . "<br>" . $mysqli->error;
}

// get the starting timestamp for this trip ID
if ($result = $mysqli->query("SELECT MIN(time) as time FROM bikedata WHERE trip_number = '".$current_trip."'")) {
        while($row = $result->fetch_assoc()) {
		$trip_start = $row["time"];
        }
        $result->free();
} else {
    echo "Error2: " . $sql . "<br>" . $mysqli->error;
}

// get the relevant data for this trip
if ($result = $mysqli->query("SELECT altitude, speed, time, trip_distance FROM bikedata WHERE rowid = '".$most_recent_row."'")) {
	while($row = $result->fetch_assoc()) {
    		$time = strtotime($row["time"]) - strtotime($trip_start); // calculate time in seconds from the beginning of the trip
    		$speed = $row["speed"];
    		$trip_distance = $row["trip_distance"];	
    		$altitude = $row["altitude"];
        }
        $result->free();
} else {
    echo "Error4: " . $sql . "<br>" . $mysqli->error;
}

// encode and return
$arr = array('speed' => intval($speed), 'time' => $time, 'distance' => $trip_distance, 'calories' => $calories, 'altitude' => $altitude, 'tripId' => $current_trip);
echo json_encode($arr);
$mysqli->close();
?>
