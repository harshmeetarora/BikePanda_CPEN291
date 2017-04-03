<?php

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
        die('Get request failed');
}
$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$most_recent_point = 0;
$time = 0;
$latitude = 0;
$current_trip = 0.0;
$longitude = 0.0;

if ($result = $mysqli->query("SELECT MAX(rowid) as rowid FROM bikedata")) {
        while($row = $result->fetch_assoc()) {
                $most_recent_point = $row["rowid"];
        }
        $result->free();
} else {
    echo "Error1: " . $sql . "<br>" . $mysqli->error;
}


// userid should be changed to rowid when we migrate to the live database
if ($result = $mysqli->query("SELECT latitude, longitude FROM bikedata WHERE rowid = '".$most_recent_point."'")) {
        while($row = $result->fetch_assoc()) {
                $longitude = $row["longitude"];
                $latitude = $row["latitude"];
        }
        $result->free();
} else {
    echo "Error3: " . $sql . "<br>" . $mysqli->error;
}
if (abs($longitude) > 1 && abs($latitude) > 1) {
	$arr = array('longitude' => $longitude, 'latitude' => $latitude);
	echo json_encode($arr);
}
$mysqli->close();
?>
