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
while ($i < 100) {
	$total_distance = rand(0, 1000);
	$trip_distance = rand(0, 100);
	$altitude = rand(0, 3000);
	$speed = rand(0, 150);
	$latitude = $origin_x + $i/100000.0;
	$longitude = $origin_y + $i/100000.0;
	$trip_number = 1013;
	$calories = rand(0, 900);
	$userid = 1;

	if($stmt = $conn->prepare("INSERT INTO bikedata (userid, trip_distance, trip_number, longitude, latitude, speed, altitude, total_distance, time, calories) VALUES (?, ?, ?, ?, ?, ?, ?, ?, FROM_UNIXTIME(UNIX_TIMESTAMP('2010-01-01 14:53:27') + FLOOR(0 + ABS((RAND() * 33052000)))), ?)")) {
		$stmt->bind_param("iiddddddd", $userid, $trip_distance, $trip_number, $longitude, $latitude, $speed, $altitude, $total_distance, $calories);
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
