<?php
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
	die('Get request failed');
}
$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "bikepanda");

$trip_distance = $incline = $altitude = $speed = $latitude = $longitude = $trip_number = "";

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if ($result = $mysqli->query("SELECT calories, trip_distance, time FROM bikedata")) {
	//printf("Select returned %d rows.\n", $result->num_rows);
	$janarr = $febarr = $mararr = $aprarr = $mayarr = $junearr = $julyarr = $augarr = $septarr = $octarr = $novarr = $decarr = "";

	$jancals = $febcals = $marcals = $aprcals = $maycals = $junecals = $julycals = $augcals = $septcals = $octcals = $novcals = $deccals = 0;

	$jandist = $febdist = $mardist = $aprdist = $maydist = $junedist = $julydist = $augdist = $septdist = $octdist = $novdist = $decdist = 0;

	$jantime = $febtime = $martime = $aprtime = $maytime = $junetime = $julytime = $augtime = $septtime = $octtime = $novtime = $dectime = 0;
	while($row = $result->fetch_assoc()) {
		if(strpos($row["time"], '2010-01') !== false) {
			$jandist += $row["trip_distance"];
			$jancals += $row["calories"];
		} else if(strpos($row["time"], '2010-02') !== false) {
			$febdist += $row["trip_distance"];
                        $febcals += $row["calories"];
		} else if(strpos($row["time"], '2010-03') !== false) {
			$mardist += $row["trip_distance"];
                        $marcals += $row["calories"];
		} else if(strpos($row["time"], '2010-04') !== false) {
			$aprdist += $row["trip_distance"];
                        $aprcals += $row["calories"];
		} else if(strpos($row["time"], '2010-05') !== false) {
			$maydist += $row["trip_distance"];
                        $maycals += $row["calories"];
		} else if(strpos($row["time"], '2010-06') !== false) {
			$junedist += $row["trip_distance"];
                        $junecals += $row["calories"];
		} else if(strpos($row["time"], '2010-07') !== false) {
			$julydist += $row["trip_distance"];
                        $julycals += $row["calories"];
		} else if(strpos($row["time"], '2010-08') !== false) {
			$augdist += $row["trip_distance"];
                        $augcals += $row["calories"];
		} else if(strpos($row["time"], '2010-09') !== false) {
			$septdist += $row["trip_distance"];
                        $septcals += $row["calories"];
		} else if(strpos($row["time"], '2010-10') !== false) {
			$octdist += $row["trip_distance"];
                        $octcals += $row["calories"];
		} else if(strpos($row["time"], '2010-11') !== false) {
			$novdist += $row["trip_distance"];
                        $novcals += $row["calories"];
		} else if(strpos($row["time"], '2010-12') !== false) {
			$decdist += $row["trip_distance"];
                        $deccals += $row["calories"];
		} 
	}
	$janarr = array('calories' => $jancals, 'trip_distance' => $jandist);
	$febarr = array('calories' => $febcals, 'trip_distance' => $febdist);
	$mararr = array('calories' => $marcals, 'trip_distance' => $mardist);
	$aprarr = array('calories' => $aprcals, 'trip_distance' => $aprdist);
	$mayarr = array('calories' => $maycals, 'trip_distance' => $maydist);
	$junearr = array('calories' => $junecals, 'trip_distance' => $junedist);
	$julyarr = array('calories' => $julycals, 'trip_distance' => $julydist);
	$augarr = array('calories' => $augcals, 'trip_distance' => $augdist);
	$septarr = array('calories' => $septcals, 'trip_distance' => $septdist);
	$octarr = array('calories' => $octcals, 'trip_distance' => $octdist);
	$novarr = array('calories' => $novcals, 'trip_distance' => $novdist);
	$decarr = array('calories' => $deccals, 'trip_distance' => $decdist);
	$json_array = array('jan' => $janarr, 'feb' => $febarr, 'mar' => $mararr, 'apr' => $aprarr, 'may' => $mayarr, 'jun' => $junearr, 'jul' => $julyarr, 'aug' => $augarr, 'sep' => $septarr, 'oct' =>$octarr, 'nov' => $novarr, 'dec' => $decarr);
	$json_array = json_encode($json_array);
	echo $json_array;
	$result->free();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$mysqli->close();

?>
