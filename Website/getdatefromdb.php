<?php

	/**
	 * Helper function to rename array keys. 
	 * http://stackoverflow.com/questions/240660/in-php-how-do-you-change-the-key-of-an-array-element
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

	# array to hold 4 date values
	$fiveDateValues = array();
	//$dateVals = array_values($fiveDateValues);

	for ($i=0; $i < 500; $i++) 
	{ 
		if ($result = $mysqli->query("SELECT trip_number, DATE(time) as time FROM bikedata ORDER BY rowid DESC LIMIT 500 OFFSET $i"))
		{
			$row = $result->fetch_assoc();

			$trip_number = intval($row['trip_number']);
			$latestdate = $row['time'];

			$finaldate = parseTimeStamp($latestdate);

			if (!in_array($finaldate, array_keys($fiveDateValues)))
			{
				$trips = array('trip1' => $trip_number);

				$fiveDateValues[$finaldate] = $trips; 
			} 
			else
			{
				if (!in_array($trip_number, $fiveDateValues[$finaldate]))//trip is not in trip array
				{
					array_push($fiveDateValues[$finaldate], $trip_number);

					$keysOfDates = array_keys($fiveDateValues[$finaldate]);

					$lastArrElem = $keysOfDates[sizeof($keysOfDates)-1];

					$beforeChange = $keysOfDates[sizeof($keysOfDates)-2];

					$tripPlaceholder = (string) intval(substr($beforeChange, 4)) + 1;

					$consecutiveVal = "trip".$tripPlaceholder;

					_rename_arr_key($lastArrElem, $consecutiveVal, $fiveDateValues[$finaldate]);
				} 
				else
				{

				}			

				

			}
			$result->close();
		}
		else 
		{
	    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	//echo $dateVals;	

	//$finalDatesArr = array('arr' => $dateVals);
	echo json_encode($fiveDateValues);

	$mysqli->close();
?>
