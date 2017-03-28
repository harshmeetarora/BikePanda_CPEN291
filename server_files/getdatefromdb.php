<?php

	/*
	 * Function that parses a time stamp into the format (January 1, 2020)
	 */
	function parseTimeStamp ($date){
		# array to store month names
		$months = array("null", "January", "February", "March", "April", "May", "June", "July", "August",  "September", "October", "November", "December");
		$monthsVals = array_values($months);

		# split date into separate parts
		$day = substr($date, 8, 9);

		$month = $monthsVals[intval(substr($date, 5, 6))];

		$year = substr($date, 0, 4);

		return ($month . " " . $day . ", " . $year);
	}

	if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
		die('Get request fialed');
	}
	$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");

	/* check connection */
	if (mysqli_connect_errno())
	{
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
	}

	# array to hold 4 date values
	$fourDateValues = array();
	$dateVals = array_values($fourDateValues);

	for ($i=0; $i < 4; $i++) 
	{ 
		if ($result = $mysqli->query("SELECT DATE(time) as time FROM testDate ORDER BY userid DESC LIMIT 4 OFFSET $i")) // DESC LIMIT 1
		{
			
			$row = $result->fetch_assoc();

			$latestdate = $row['time'];

			$finaldate = parseTimeStamp($latestdate);

			$datearr = array('time'.$i => $finaldate);

			//$encodedarr = js($datearr);

			//echo $encodedarr;

			$dateVals[$i] = $datearr; 

			$result->close();

		}
		else 
		{
	    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}	

	//$finalDatesArr = array('arr' => $dateVals);
	echo json_encode($dateVals);

	
	
	$mysqli->close();
?>
