
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Progress</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      
    <!-- JS BOOTSTRAP -->  
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
   <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeasNGrKh3vL9EkHJlVEP3VhSQpk4frNU"> </script>  
    <style>
        body {
            background-color: Ivory;
        }
        .navbar {
            margin-bottom:0;
            border-radius:0;
        }   
        .panel {
            border-radius:0;
        }
        .panel-heading {
            border-radius:0;
        }
        .panel-body {
            border-radius:0;
        }
        .list-group {
            border-radius:0;
        }
    </style>

    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="./js/chart.js/dist/Chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  </head>
    
  <body>
    <!-- NAV BAR -->
    <nav class="navbar navbar-inverse">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./index.php">Bike Panda</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="./index.php">Home<span class="sr-only">(current)</span></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">  
                    <li><a href="./logout.php">Log out<span class="sr-only">(current)</span></a></li>
          </ul> 
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./about.php">About Us</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
     </div><!-- /.container-fluid -->
    </nav>

    <!-- GRID CONTAINING THE GRAPH AND RELEVANT INFORMATION -->
    <div class="container-fluid text-center" >
        <div class="row" >
            <div class="col-md-2 col-sm-2">
            <br>
                <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2>Live Feed</h2>
                </div>
                <div class="panel-body">
                    <a href="#" class="btn btn-primary" role="button" id="realOG" onclick="realTime()">Real-time Graph</a>
                    <hr>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-info"><b>Past Trips</b></li>

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                              <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="date1">
                                  <!-- Collapsible Group Item #1 -->
                                </a>
                              </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                              <div class="panel-body">
                                <div class="btn-group" role="group" aria-label="..." id="DATE0">
                                  <!-- <button type="button" class="btn btn-default">t</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                              <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="date2">
                                 
                                </a>
                              </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                              <div class="panel-body">
                                <div class="btn-group" role="group" aria-label="..." id="DATE1">
                                  <!-- <button type="button" class="btn btn-default">t</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                              <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="date3">
                                
                                </a>
                              </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                              <div class="panel-body">
                                <div class="btn-group" role="group" aria-label="..." id="DATE2">
                                  <!-- <button type="button" class="btn btn-default">t</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                              <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour" id="date4">
                                
                                </a>
                              </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                              <div class="panel-body">
                                <div class="btn-group" role="group" aria-label="..." id="DATE3">
                                  <!-- <button type="button" class="btn btn-default">t</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <script type="text/javascript">
                        var tripID;
			var real_time = 0;	
                            function reply_click(clicked_id)
                            {
				real_time = 0;
                                tripID = clicked_id;
				var outgoinglink = './GoogleAPIFirstTest.php?tripId='+tripID;
				$('#mapbutton').attr('href',outgoinglink);
				$('#calorieheader').text('Calories (cal)');
                            }
			    function reply_click_realtime(clicked_id)
                            {
				if (real_time) {
					var outgoinglink = './GoogleAPID2.html';
					$('#mapbutton').attr('href',outgoinglink);
					$('#calorieheader').text('Calories (W)');
				}
                            }
                        </script>

                        <script type="text/javascript">
                            var omarTime = "";
                            var currentID = 0;
                            //var arrrr = [];
                            //var poll = function(){
                            $.ajax(
                            {
                                url:'./getdatefromdb.php',//php,
                                dataType:'json',
                                type: 'GET',
                                //async
                                success: function(data){
                                    var dateStrings = [];
                                    dateStrings = Object.keys(data);

                                    $('#date1').text(dateStrings[0]);
                                    $('#date2').text(dateStrings[1]);
                                    $('#date3').text(dateStrings[2]);
                                    $('#date4').text(dateStrings[3]);

                                    

                                    for (var i = 0; i < dateStrings.length; i++) {


                                        for (var j = 0; j < (Object.keys(data[dateStrings[i]])).length; j++) {
                                            // read trip id and append a button, with the trip id
                                            // in text 
                                            //"trip"+(j+1);
                                            var trip = "trip" + (j+1).toString();

                                            currentID = (data[dateStrings[i]])[trip].toString();
                                            var button_text = '<button type="button" class="btn btn-lg btn-default" id='+currentID+' onClick="reply_click('+currentID+')">'+currentID+'</button>';

                                            var bt = $(button_text);
                                            $("#DATE"+i).append(bt);
                                            //$("#DATE"+i).text(currentID);
                                        }
                                    }

                                    /*
                                    $('button').on('click',function(){
                                        var r= $('<input type="button" value="new button"/>');
                                        $("body").append(r);
                                    });
                                    */
                                },
                                error: function(){}
                                });
                            //};
                        </script>
                    </ul>
                </div>
                </div>
            </div>
            
            <!-- PLACE GRAPH HERE -->
            <div class="col-md-8 col-sm-8" style="margin-top:20px" > 
                
            <!-- DISMISSABLE ALERTS -->
            <div class="alert alert-warning alert-dismissable" role="alert">
                <h3>Please choose a trip ID, then choose a graph type.
                <button type="button" class="close" data-dismiss="alert">
                    <span>Close &times;</span></button></h3>
            </div>    

            <canvas id="SpeedTimeChart" width="400" height="200"></canvas>
            <script>
                var myChart;
                var ctx = document.getElementById("window");
                var SpeedTime = 0;
                var AltitudeDistance = 0;
                var MapAPI = 0;

            function initChart(){
                if (SpeedTime){
                    var responseData =[];
                    $.ajax(
                                {
                                    url:'./staticdata.php',
                                    dataType:'json',
                                    async: 'false',
                                    type: 'get',
                                    data: {tripid: tripID},
                                    success: function(data){
					$('.speed').text(data[0].average_speed.toFixed(2));
                                        $('.calories').text(data[0].calories);
                                        $('.distance').text(data[0].sum_trip_distance);
                                        var i;
                                        for ( i = 0; i < data.length - 1; i++){
                                                responseData.push( {x: data[i].time, y: data[i].speed} )
                                        }
                                        
                                    },
                                    error: function(){}
                                });


                    var configurationSpeedTime = {
                        type: 'line',
                        data: {
                            datasets: [{
                                borderColor: "rgb(10, 35, 117)",
                                pointBackgroundColor: "rgb(10, 35, 117)",
                                fill: true,
                                backgroundColor: "rgba(10, 35, 117, 0.2)",
                                data: responseData
                            }]
                        },
                        options: {
                            title: {
                                display: false,
                                //text: startTime,
                                fontColor: "rgb(0, 0, 0)"
                            },
                            legend:{
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    type: "linear",
                                    position: "bottom",
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Time in seconds",
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                    ticks: {
                                        min: 0,
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                
                                    gridLines: {
                                        zeroLineColor: "rgb(0, 0, 0)"
                                    }
                                }],
                                yAxes: [{
                                    type: "linear",
                                    position: "left",
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Speed in km/h",
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                    ticks: {
                                        min: 0,
                                        max: 35,
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                
                                    gridLines: {
                                        zeroLineColor: "rgb(0, 0, 0)"
                                    }
                                }]
                                
                            },
                            animation: {
                                    duration: 900,
                                    }
                        }
                    };
                    setTimeout(function() {
                        myChart = new Chart(ctx, configurationSpeedTime);
                    }, 1000);

                }  else if (AltitudeDistance){
                    var freshData = [];
                    $.ajax(
                                {
                                    url:'./staticdata.php',
                                    dataType:'json',
                                    async: 'false',
                                    type: 'get',
                                    data: { tripid: tripID},
                                    success: function(data){
					$('.speed').text(data[0].average_speed.toFixed(2));
					$('.calories').text(data[0].calories);
					$('.distance').text(data[0].sum_trip_distance);
                                        var i;
                                        for ( i = 0; i < data.length; i++){
                                            freshData.push( {x: data[i].distance, y: 100*data[i].altitude} )
                                        }
                                    },
                                    error: function(){}
                                });
                    var configurationAltitudeDistance = {
                        type: 'line',
                        data: {
                            datasets: [{
                                borderColor: "rgb(8, 96, 8)",
                                pointBackgroundColor: "rgb(8, 96, 8)",
                                fill: true,
                                backgroundColor: "rgba(8, 96, 8, 0.2)",
                                data: freshData
                            }]
                        },
                        options: {
                            title: {
                                display: false,
                                text: "Name, Date, Start time",
                                fontColor: "rgb(0, 0, 0)"
                            },
                            legend:{
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    type: "linear",
                                    position: "bottom",
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Distance in m",
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                    ticks: {
                                        min: 0,
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                
                                    gridLines: {
                                        zeroLineColor: "rgb(0, 0, 0)"
                                    }
                                }],
                                yAxes: [{
                                    type: "linear",
                                    position: "left",
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Altitude in m",
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                    ticks: {
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                
                                    gridLines: {
                                        zeroLineColor: "rgb(0, 0, 0)"
                                    }
                                }]
                                
                            },
                            animation: {
                                    duration: 900,
                                    }
                        }
                    };
                    setTimeout(function() {
                        myChart = new Chart(ctx, configurationAltitudeDistance);
                    }, 1000);

                } else if (MapAPI){
                    var pathCoordninates = [];
                    var minLong;
                    var maxLong;
                    var minLat;
                    var maxLat;
                    var latitude = 0;
                    var longitude = 0;
                    var latLng = 0;
                    $.ajax(
                        {
                            url:'./staticmapsdata.php',
                            dataType:'json',
                            async: 'false',
                            type: 'get',
                            data: { tripid: tripID},

                            success: function(data){
                                var i;

                                minLong = maxLong = data[0].longitude;
                                minLat = maxLat = data[0].latitude;
                                pathCoordninates.push( new google.maps.LatLng( minLong, minLat));
                                for ( i = 1; i < data.length; i++){
                                    latitude = data[i].latitude;
                                    longitude = data[i].longitude;

                                    if(latitude < minLat){
                                    minLat = latitude;
                                    }
                                    if (latitude > maxLat){
                                    maxLat = latitude;
                                    }
                                    if (longitude < minLong){
                                    minLong = longitude;
                                    }
                                    if (longitude > maxLong){
                                    maxLong = longitude;
                                    }
                                    pathCoordninates.push( new google.maps.LatLng( latitude, longitude));
                                }
                            },
                            error: function(){}
                        });

                    latitude = (maxLat - minLat) / 2;
                    longitude = (maxLong - minLong) / 2;

                    setTimeout(function() {
                        latLng = new google.maps.LatLng( latitude, longitude);
                        myChart = new google.maps.Map(ctx, {
                            zoom: 3,
                            center: latLng,
                            mapTypeId: 'terrain'
                        });

                        var Path = new google.maps.Polyline({
                            path: pathCoordninates,
                            geodesic: true,
                            strokeColor: '#FF0000',
                            strokeOpacity: 1.0,
                            strokeWeight: 2
                        });

                        Path.setMap(myChart);
                    }, 1000);
                }   
            };

            function getSpeedGraphUp(){
                SpeedTime = 1;
                AltitudeDistance = 0;
                MapAPI = 0;
                initChart();

            };
            function getAltitudeGraphUp(){
                SpeedTime = 0;
                AltitudeDistance = 1;
                MapAPI = 0;
                initChart();

            };
            function getMapAPIgoing(){
                SpeedTime = 0;
                AltitudeDistance = 0;
                MapAPI = 1;
                initChart();

            };
            // document.getElementById("speedtimebutton").onClick = function() {getSpeedGraphUp()};
            // document.getElementById("altdistancebutton").onclick = function() {getAltitudeGraphUp()};
            // document.getElementById("mapbutton").onclick = function() {getMapAPIgoing()};




            </script>

            <script>
            //var myChart;
            var Data = [];
            var configuration;
            var time;
            var lastPlottedTime;
            var speed;
            var distance;
            var minTime;
            var minTime;
            var ctx = document.getElementById("SpeedTimeChart");



            function reconfigure(newData, maxTime, minTime){
                configuration = {
                        type: 'line',
                        data: {
                            datasets: [{
                                borderColor: "rgb(8, 96, 8)",
                                pointBackgroundColor: "rgb(8, 96, 8)",
                                fill: true,
                                backgroundColor: "rgba(8, 96, 8, 0.2)",
                                data: newData
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: "Real-time Speed vs Time",
                                fontColor: "rgb(0, 0, 0)"
                            },
                            legend:{
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    type: "linear",
                                    position: "bottom",
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Time in seconds",
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                    ticks: {
                                        min: minTime,
                                        max: maxTime,
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                
                                    gridLines: {
                                        zeroLineColor: "rgb(0, 0, 0)"
                                    }
                                }],
                                yAxes: [{
                                    type: "linear",
                                    position: "left",
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Speed in km/h",
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                    ticks: {
                                        min: 0,
                                        max: 35,
                                        fontColor: "rgb(0, 0, 0)"
                                    },
                                
                                    gridLines: {
                                        zeroLineColor: "rgb(0, 0, 0)"
                                    }
                                }]
                                
                            },
                            animation: {
                                    duration: 0,
                                    }
                        }
                    };
            }
            function realTime(){
		real_time = 1;
            setInterval(function(){

                $.ajax(
                            {
                    url:'./livegraph.php',
                    dataType:'json',
                    async: 'false',
                    type: 'get',
                    // data: 
                    success: function(data){
			if (real_time) {
				$('.speed').text(data.speed.toFixed(2));
				$('.calories').text((data.speed*(3.5+(0.2581*data.speed*data.speed))/4186).toFixed(2));
				$('.distance').text(data.distance);
				reply_click_realtime(data.tripId);
				time = data.time;
                        }
                    },
                    error: function(){}
                });

                if ( time != lastPlottedTime){
                	
                    Data.push({
                        x: time,
                        y: speed
                    });

                    maxTime = time + 10;//10 + 5 * (time/10);
                    minTime = time - 90;// 5 * (time/10);
		    if (SpeedTime) {
			    reconfigure(Data, maxTime, minTime);            
			    myChart = new Chart(ctx, configuration);
                    }
                    lastPlottedTime = time;
                }
            },1000);
            }
            </script>



            <hr>   
                <div class="btn-group" role="group" aria-label="...">
                  <button type="button" id="speedtimebutton" class="btn btn-lg btn-primary" onclick="getSpeedGraphUp()"> Speed Vs. Time</button>
                  <button type="button" id="altdistancebutton" class="btn btn-lg btn-primary" onclick="getAltitudeGraphUp()">Altitude Vs. Distance</button> 
                  <a href="" role="button" target="_blank" id="mapbutton" class="btn btn-lg btn-primary">Bike Path</a>
                </div>     
            </div>
            <!-- LIVE DATA UPDATE -->
            <div class="col-md-2 col-sm-2">
            <h2>Data Gauges</h2>
            <hr>
               
                    <!-- PANELS -->  
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title"><h3>Speed (km/h)</h3></h2>
                        </div>
                        <div class="panel-body">
                            <span class="speed" style="font-size: 20pt"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="panel-title"><h3>Distance (m)</h3></h2>
                        </div>
                        <div class="panel-body">
                            <span class="distance" style="font-size: 20pt"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
			    
                            <h2 class="panel-title"><h3 id="calorieheader">Calories (W)</h3></h2>
                        </div>
                        <div class="panel-body">
                            
                               <span class="calories" style="font-size: 20pt"></span>
                        
                            
                        </div>
                    </div>
                </div>
        </div>
    </div>

    
    
</body>    
    
</html>    
