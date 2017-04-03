<?php

	/*
	 * Helper function to rename array keys. 
	 * from http://stackoverflow.com/questions/240660/in-php-how-do-you-change-the-key-of-an-array-element
	 */
	function _rename_arr_key($oldkey, $newkey, array &$arr) {
	  if (array_key_exists($oldkey, $arr)) {
	    $arr[$newkey] = $arr[$oldkey];
	    unset($arr[$oldkey]);
	    return TRUE;
	  } else {
	    return FALSE;
	  }
	}

	/*
	 * Function that parses a time stamp into the format (January 1, 2000)
	 */
	function parseTimeStamp ($date){
		# array to store month names
		$months = array("null", "January", "February", "March", "April", "May", "June", "July", "August",  "September", "October", "November", "December");
		$monthsVals = array_values($months);

		# split date into separate parts
		$day = substr($date, 8, 9);
		$month = $monthsVals[intval(substr($date, 5, 6))]; 
		$year = substr($date, 0, 4);

		# return formatted dated string
		return ($month . "_" . $day . "_" . $year);
	}

	if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
		die('Get request fialed');
	}
	$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda"); 

	/* check connection */
	if (mysqli_connect_errno())
	{
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	# array to hold date values
	$dateValues = array();

	# read up to 500 date elements from the database
	for ($i=0; $i < 500; $i++) 
	{ 
		# check if there's a valid result
		if ($result = $mysqli->query("SELECT trip_number, DATE(time) as time FROM bikedata ORDER BY rowid DESC LIMIT 500 OFFSET $i"))
		{
			# fetch one row
			$row = $result->fetch_assoc();

			# separate trip number and datetime object
			$trip_number = intval($row['trip_number']);
			$latestdate = $row['time'];

			# parse the datetime object to our format
			$finaldate = parseTimeStamp($latestdate);

			# add date and trip to the dates array if it's not already there
			if (!in_array($finaldate, array_keys($dateValues)))
			{
				# initialie the json array for that date
				$trips = array('trip1' => $trip_number);

				# add the json array template to the dates array
				$dateValues[$finaldate] = $trips; 
			} 
			# do this if date was already initialized in the array. Add another trip
			else
			{
				
				# trip is not in trip array
				if (!in_array($trip_number, $dateValues[$finaldate]))
				{
					# push a new trip into the json array
					array_push($dateValues[$finaldate], $trip_number);
					
					
					$keysOfDates = array_keys($dateValues[$finaldate]);

					$lastArrElem = $keysOfDates[sizeof($keysOfDates)-1];

					$beforeChange = $keysOfDates[sizeof($keysOfDates)-2];

					# placeholder for the trip 
					$tripPlaceholder = (string) intval(substr($beforeChange, 4)) + 1;

					$consecutiveVal = "trip".$tripPlaceholder;

					_rename_arr_key($lastArrElem, $consecutiveVal, $dateValues[$finaldate]);
				} 
			}
			$result->close();
		}
		# connection error signal
		else 
		{
	    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	# encode the array into json
	echo json_encode($dateValues);

	# close mysql connection
	$mysqli->close();
?>
