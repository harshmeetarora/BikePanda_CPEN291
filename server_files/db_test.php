<!DOCTYPE html>
<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
	Welcome Team 2<br>
	<?php
		$distance = $incline = $altitude = $speed = $latitude = $longitude = $trip_number = "";
		$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");

		/* check connection */
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

		$distance = test_input($_POST["distance"]);
		$incline = test_input($_POST["incline"]);
		$altitude = test_input($_POST["altitude"]);
		$speed = test_input($_POST["speed"]);
		$latitude = test_input($_POST["latitude"]);
		$longitude = test_input($_POST["longitude"]);
		$trip_number = test_input($_POST["trip_number"]);

		$query = "INSERT INTO bikedata (trip_number, longitude, latitude, speed, altitude, incline, distance)
				VALUES ('$trip_number', '$longitude', '$latitude', '$speed', '$altitude', '$incline', '$distance')";
		/* return name of current default database */
		if ($mysqli->query($query) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
			
		$mysqli->close();
		
		function test_input($data) {
		  $data = trim($data);
		  return $data;
		}	
	?>
 </body>
</html>
