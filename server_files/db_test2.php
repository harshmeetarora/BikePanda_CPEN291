<!DOCTYPE html>
<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
        <p>Welcome Team 2</p><br>
        <?php
                $mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");

		$distance = $incline = $altitude = $speed = $latitude = $longitude = $trip_number = "";
		$json_array = array('trip_number', 'longitude', 'latitude', 'speed', 'altitude', 'incline', 'distance');
		
                /* check connection */
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }

                /* return name of current default database */

                if ($result = $mysqli->query("SELECT * FROM bikedata")) {
			//printf("Select returned %d rows.\n", $result->num_rows);
			$row = $result->fetch_array(MYSQLI_NUM);
			$json_array = array('user_id' => $row[0], 'time' => $row[1], 'trip_number' => $row[2], 'longitude' => $row[3], 'latitude' => $row[4], 'speed' => $row[5], 'altitude' => $row[6], 'incline' => $row[7], 'distance' => $row[6]);
			
			echo json_encode($json_array, JSON_NUMERIC_CHECK);
			$result->close();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $mysqli->close();

        ?>
 </body>
</html>
