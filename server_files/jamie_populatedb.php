<?php

$conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

srand(time());

// origin for random lat/long pairs
$origin_x = 5.420525;
$origin_y = 100.319500; 

$i = 0;
while ($i < 100) {
	$distance = rand(0, 10);
	$incline = rand(1, 100);
	$altitude = rand(0, 3000);
	$speed = rand(0, 150);
	$latitude = $origin_x + rand(-100, 100);
	$longitude = $origin_y + rand(-100, 100);
	$trip_number = 1;
	$calories = rand(0, 900);

	if($stmt = $conn->prepare("INSERT INTO bikedata (trip_number, longitude, latitude, speed, altitude, incline, distance, time, calories) VALUES (?, ?, ?, ?, ?, ?, ?, FROM_UNIXTIME(UNIX_TIMESTAMP('2010-01-01 14:53:27') + FLOOR(0 + ABS((RAND() * 33052000)))), ?)")) {
		$stmt->bind_param("ssssssss", $trip_number, $longitude, $latitude, $speed, $altitude, $incline, $distance, $calories);
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
