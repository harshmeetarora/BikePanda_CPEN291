<?php 

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
        die('Get request failed');
}
$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$trip_start = 0;
$time = 0;
$current_trip = 0;
$speed = 0;

if ($result = $mysqli->query("SELECT MAX(trip_number) as trip_number FROM bikedata")) {
	while($row = $result->fetch_assoc()) {
		$current_trip= $row["trip_number"];
	}
	$result->free();
} else {
    echo "Error1: " . $sql . "<br>" . $mysqli->error;
}

if ($result = $mysqli->query("SELECT MIN(time) as time FROM bikedata WHERE trip_number = '".$current_trip."'")) {
        while($row = $result->fetch_assoc()) {
		$trip_start = $row["time"];
        }
        $result->free();
} else {
    echo "Error2: " . $sql . "<br>" . $mysqli->error;
}

if ($result = $mysqli->query("SELECT speed, time FROM bikedata WHERE trip_number = '".$current_trip."'")) {
	while($row = $result->fetch_assoc()) {
		$time = strtotime($row["time"]) - strtotime($trip_start);
		$speed = $row["speed"];
        }
        $result->free();
} else {
    echo "Error3: " . $sql . "<br>" . $mysqli->error;
}

$arr = array('speed' => intval($speed), 'time' => $time);
echo json_encode($arr);
$mysqli->close();
?>
