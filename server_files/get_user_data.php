<?php
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
	die('Get request failed');
}
$mysqli = new mysqli("localhost", "jamie", "3parj9Ld5Rs18", "test_db");

$distance = $incline = $altitude = $speed = $latitude = $longitude = $trip_number = "";

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if ($result = $mysqli->query("SELECT calories, distance, time FROM bikedata")) {
	//printf("Select returned %d rows.\n", $result->num_rows);
	$janarr = $febarr = $mararr = $aprarr = $mayarr = $junearr = $julyarr = $augarr = $septarr = $octarr = $novarr = $decarr = "";

	$jancals = $febcals = $marcals = $aprcals = $maycals = $junecals = $julycals = $augcals = $septcals = $octcals = $novcals = $deccals = 0;

	$jandist = $febdist = $mardist = $aprdist = $maydist = $junedist = $julydist = $augdist = $septdist = $octdist = $novdist = $decdist = 0;

	$jantime = $febtime = $martime = $aprtime = $maytime = $junetime = $julytime = $augtime = $septtime = $octtime = $novtime = $dectime = 0;
	while($row = $result->fetch_assoc()) {
		if(strpos($row["time"], '2010-01') !== false) {
			$jandist += $row["distance"];
			$jancals += $row["calories"];
		} else if(strpos($row["time"], '2010-02') !== false) {
			$febdist += $row["distance"];
                        $febcals += $row["calories"];
		} else if(strpos($row["time"], '2010-03') !== false) {
			$mardist += $row["distance"];
                        $marcals += $row["calories"];
		} else if(strpos($row["time"], '2010-04') !== false) {
			$aprdist += $row["distance"];
                        $aprcals += $row["calories"];
		} else if(strpos($row["time"], '2010-05') !== false) {
			$maydist += $row["distance"];
                        $maycals += $row["calories"];
		} else if(strpos($row["time"], '2010-06') !== false) {
			$junedist += $row["distance"];
                        $junecals += $row["calories"];
		} else if(strpos($row["time"], '2010-07') !== false) {
			$julydist += $row["distance"];
                        $julycals += $row["calories"];
		} else if(strpos($row["time"], '2010-08') !== false) {
			$augdist += $row["distance"];
                        $augcals += $row["calories"];
		} else if(strpos($row["time"], '2010-09') !== false) {
			$septdist += $row["distance"];
                        $septcals += $row["calories"];
		} else if(strpos($row["time"], '2010-10') !== false) {
			$octdist += $row["distance"];
                        $octcals += $row["calories"];
		} else if(strpos($row["time"], '2010-11') !== false) {
			$novdist += $row["distance"];
                        $novcals += $row["calories"];
		} else if(strpos($row["time"], '2010-12') !== false) {
			$decdist += $row["distance"];
                        $deccals += $row["calories"];
		} 
	}
	$janarr = array('calories' => $jancals, 'distance' => $jandist);
	$febarr = array('calories' => $febcals, 'distance' => $febdist);
	$mararr = array('calories' => $marcals, 'distance' => $mardist);
	$aprarr = array('calories' => $aprcals, 'distance' => $aprdist);
	$mayarr = array('calories' => $maycals, 'distance' => $maydist);
	$junearr = array('calories' => $junecals, 'distance' => $junedist);
	$julyarr = array('calories' => $julycals, 'distance' => $julydist);
	$augarr = array('calories' => $augcals, 'distance' => $augdist);
	$septarr = array('calories' => $septcals, 'distance' => $septdist);
	$octarr = array('calories' => $octcals, 'distance' => $octdist);
	$novarr = array('calories' => $novcals, 'distance' => $novdist);
	$decarr = array('calories' => $deccals, 'distance' => $decdist);
	$json_array = array('jan' => $janarr, 'feb' => $febarr, 'mar' => $mararr, 'apr' => $aprarr, 'may' => $mayarr, 'jun' => $junearr, 'jul' => $julyarr, 'aug' => $augarr, 'sep' => $septarr, 'oct' =>$octarr, 'nov' => $novarr, 'dec' => $decarr);
	$json_array = json_encode($json_array);
	echo $json_array;
	$result->free();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$mysqli->close();

?>
