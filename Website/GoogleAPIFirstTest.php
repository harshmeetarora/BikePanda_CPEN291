<!DOCTYPE html>
<html>
  <head>
    <title>Trip <?php echo $_GET['tripId'] ?></title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      #map {
        height: 100%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <body>
    <div id="map"></div>
    <script>
      var tripId = '<?php echo $_GET['tripId'] ?>';
      var map;
      var pathCoordninates = [];
      var centerLatitude = 49.2606;
      var centerLongitude = -123.2460;
      var centerLatLng = {lat: centerLatitude, lng: centerLongitude};

      var lastPlottedLatitude;
      var lastPlottedLongitude;

    function reconfigure(pathCoordninates){
           

        var flightPath = new google.maps.Polyline({
            path: pathCoordninates,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        flightPath.setMap(map);
    }

function initMap() {
map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: centerLatLng,
            mapTypeId: 'terrain'
        });
/*var flightPath = new google.maps.Polyline({
    path: pathCoordninates,
    geodesic: true,
    strokeColor: '#FF0000',
    strokeOpacity: 1.0,
    strokeWeight: 2
  });

  flightPath.setMap(map);*/
//}, 1000);
	
		$.ajax({
		      url:'./staticmapsdata.php',
		      dataType:'json',
		      async: 'false',
		      type: 'get',
		      data: { tripid: tripId},

		      success: function(data){
			  var i;
			  //minLong = maxLong = data[0].longitude;
			  //minLat = maxLat = data[0].latitude;
			  for ( i = 0; i < data.length; i++){
			      var latitude = data[i].latitude;
			      var longitude = data[i].longitude;

			     pathCoordninates.push( new google.maps.LatLng( latitude, longitude));
			    }
			reconfigure(pathCoordninates);
		      },
		      error: function(){}
		});
}
   </script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeasNGrKh3vL9EkHJlVEP3VhSQpk4frNU&callback=initMap"> </script>
  </body>
</html>
