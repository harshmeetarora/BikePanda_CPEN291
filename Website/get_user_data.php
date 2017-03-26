<?php
	$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");

	$distance = $incline = $altitude = $speed = $latitude = $longitude = $trip_number = "";
	
	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	/* return name of current default database */

	if ($result = $mysqli->query("SELECT * FROM bikedata")) {
		//printf("Select returned %d rows.\n", $result->num_rows);
		$row = $result->fetch_array(MYSQLI_NUM);
		$arr = array('user_id' => $row[0], 'time' => $row[1], 'trip_number' => $row[2], 'longitude' => $row[3], 'latitude' => $row[4], 'speed' => $row[5], 'altitude' => $row[6], 'incline' => $row[7], 'distance' => $row[6]);
		$json_array = json_encode($arr, JSON_NUMERIC_CHECK);		
		echo $json_array;
		$result->close();
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$mysqli->close();

?>
