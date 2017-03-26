<?php

if(isset($_POST["trip_number"], $_POST["longitude"], $_POST["latitude"], $_POST["speed"], $_POST["altitude"], $_POST["incline"], $_POST["distance"])) {

	$distance = $incline = $altitude = $speed = $latitude = $longitude = $trip_number = "";
	$conn = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");

	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$distance = trim($_POST["distance"]);
	$incline = trim($_POST["incline"]);
	$altitude = trim($_POST["altitude"]);
	$speed = trim($_POST["speed"]);
	$latitude = trim($_POST["latitude"]);
	$longitude = trim($_POST["longitude"]);
	$trip_number = trim($_POST["trip_number"]);


	if($stmt = $conn->prepare("INSERT INTO bikedata (trip_number, longitude, latitude, speed, altitude, incline, distance) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
		$stmt->bind_param("sssssss", $trip_number, $longitude, $latitude, $speed, $altitude, $incline, $distance);
	} else {
		die("Prepared statement failed failed: " . $conn->error_list);
	}

	if (!$stmt->execute()) {
	    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}

	echo "New record created successfully";
	$stmt->close();	
	$mysqli->close();
} else {
	echo "post parameters not set";
}

?>
