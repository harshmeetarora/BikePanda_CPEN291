<?php

$conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

srand(time());

// origin for random lat/long pairs
$origin_x = 49.2607;
$origin_y = -123.2461;

$i = 0;
while ($i < 50) {
	$total_distance = $i*2;
	$trip_distance = $i;
	$altitude =  100 + rand(-3,2);
	$speed = 17 + rand(-2,2);
	$latitude = $origin_x + pow($i/1000,2);
	$longitude = $origin_y - pow($i/900,2);
	$trip_number = 4;
	$calories = rand(1, 3);
	$userid = 1;
	$string_of_i = (string) $i;
	$time = '2017-03-25 07:53:'.$string_of_i;

	if($stmt = $conn->prepare("INSERT INTO bikedata (userid, trip_distance, trip_number, longitude, latitude, speed, altitude, total_distance, time, calories) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
		$stmt->bind_param("iiddddddsd", $userid, $trip_distance, $trip_number, $longitude, $latitude, $speed, $altitude, $total_distance, $time, $calories);
	} else {
		die("Prepared statement failed failed: " . $conn->error_list);
	}

	if (!$stmt->execute()) {
	    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	$i++;
}
echo "New record created successfully";
$stmt->close();
$mysqli->close();

?>
