<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Setting up the page attributes -->	  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>About Bike Panda</title>
	<link rel="icon" href="http://example.com/favicon.png">

	<!-- Tab icon (providing all sizes of the logo) -->
	<link rel="apple-touch-icon" sizes="57x57" href="./images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="./images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="./images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="./images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="./images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="./images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="./images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="./images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="./images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="./images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="./images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="./images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="./images/favicon-16x16.png">
	<link rel="manifest" href="./images/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="./images/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- CSS additional attributes -->
	<style>
		body {
			background-color: aliceblue;
		}
		.navbar {
			margin-bottom:0;
			border-radius:0;
		}
		.navlogo {
			width: auto;
			height: 100%;
		}
		.bgimage{
			background-image: url('./images/treetops.jpg');
			background-size: 100%;
			background-repeat: no-repeat;
			height: auto;
		}
		.jumbotron {
		  margin-bottom: 0px;
		  color: white;
		  text-shadow: black 0.3em 0.3em 0.3em;
		}
		.lettherebewhite {
			background-color: #F0F0F0;
		}
		.headshot {
			width: 8vw;
			height: auto;
		}
		img.displayed {
			display: block;
			margin-left: auto;
			margin-right: auto;
			max-height: 50vh;
		}
		hr {
			display: block;
			height: 1px;
			border: 0;
			border-top: 5px solid silver;
			margin: 1em 0;
			padding: 0; 
		}
		.hr-1 {
			padding: 0;
			border: none;
			border-top: 5px solid silver;
			color: #383a4f;
			text-align: center;    
			font-size:32px;
			font-weight: 300;
		}
		.hr-1:after {
			content: attr(data-content);
			display: inline-block;
			position: relative; 
			top: -0.8em; 
			padding: 0 1em;
			background: #F0F0F0;
		}
		.vcenter {
			display: inline-block;
			vertical-align: middle;
			float: none;
		}
		.hr-2 {
			padding: 0;
			border: none;
			border-top: 5px solid silver;
			color: #383a4f;
			text-align: center;    
			font-size:32px;
			font-weight: 300;
		}
		.productimage {
			height: 300px;
			width: auto;
		}
		.textContainer { 
			height: 300px; 
			line-height: 295px;
		}
		.textContainer h4 {
			vertical-align: middle;
			display: inline-block;
		}
		.textContainer2 { 
			height: 300px; 
		}
		.textContainer2 h4 {
			vertical-align: middle;
			display: inline-block;
		}
		.mylist ul li{
			list-style-type:none;
		}
		.mylist ul li:before{
			font-family: 'Glyphicons Halflings';
			content: "\e067"; 
			position: relative;
		}
		.img-thumbnail {
			background: aliceblue;
		}
	</style>
  </head>

  <!-- BODY -->
  <body>  
	<div class="navbar navbar-inverse">
		<div class="container">
		</div>
	</div>
	<!-- NAV BAR -- Setting up the page navbar -->
	<nav class='navbar navbar-inverse navbar-fixed-top sticky' role='navigation'>
	  <div class="container">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="./index.php"><img class="navlogo" src="./images/BikePandaLogo.png"></a>
		  <a class="navbar-brand" href="./index.php">Bike Panda</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav navbar-right">
			<li>
                        <?php if(isset($_SESSION["id"])): ?>
                        <a href="./logout.php">Log out<span class="sr-only">(current)</span></a>
                        <?php else: ?>
                        <a href="./login.html">Log in<span class="sr-only">(current)</span></a>
                        <?php endif;?>
                        </li>
		  </ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<!-- JUMBOTRON -->
	<div class="jumbotron text-center bgimage">
	  <div class="container">
		<h1>About Bike Panda</h1>
	  </div>
	</div>

	<!-- Info -->
	<!-- OUR MISSION -->
	<br>
	<div class="container lettherebewhite">
		<hr class="hr-1" data-content="Our Mission"/>
	</div>
	<div class="container lettherebewhite">
		<br>
		<div class="col-md-2"></div>
		<!-- Mission Statement -->
		<div class="col-md-8 text-center">
			<h4>Founded by seven Computer Engineering students from the University of British Columbia, Bike Panda was created to allow cyclists to get more out of their rides.</h4>
			<blockquote class="blockquote">
				<h3><i>"Most people know that riding a bike is good for your health but few are able to track their improvement."</i></h3>
				<h3 align="right">- Mitch Duffield</h3>
			</blockquote>
		</div>
		<div class="col-md-2"></div>
		<br>
	</div>
	<div class="container lettherebewhite">
		<hr/><br>
	</div>
	
	<!-- OUR PRODUCT -->
	<br>
	<div class="container lettherebewhite">
		<hr class="hr-1" data-content="Our Product"/>
	</div>
	<div class="container lettherebewhite">
		<!-- Using Bootstrap Grid -->
		<br>
		<div class="col-md-1"></div>
		<div class="col-md-5"><img class="img-thumbnail productimage" src="./images/bicycle2.jpg" alt="Bike Panda on a bike"></div>
		<div class="col-md-5 textContainer text-center"><h4><i>The Bike Panda device is secured to your bicycle and tracks your trip.<br><br>By recording and charting trip data, Bike Panda shows statistics from past and current ride sessions so users can see their progress over time.</i></h4></div>
		<div class="col-md-1"></div>
	</div>
	<div class="container lettherebewhite">
		<br>
		<div class="col-md-1"></div>
		<div class="mylist col-md-5">
			<br><br>
			<h4 class="text-center"><i>Available trip data includes:</i></h4>
			<ul>
				<li>  Speed versus time</li>
				<li>  Altitude versus distance</li>
				<li>  Distance travelled</li>
				<li>  Time spent on bike</li>
				<li>  Calories burned over time</li>
			</ul>
		</div>
		<div class="col-md-5"><img class="img-thumbnail productimage" src="./images/bikegraph.jpg" alt="Graphed Data"></div>
		<div class="col-md-1"></div>
	</div>
	<div class="container lettherebewhite">
		<br><hr/><br>
	</div>

	<!-- OUR TEAM -->
	<br>
	<div class="container lettherebewhite">
		<hr class="hr-1" data-content="Our Team"/>
		<br>
		<!-- Team Row 1 -->
		<div class="col-md-2"></div>
		<div class="col-md-2 text-center"><img class="headshot img-circle img-thumbnail" src="./images/omar.jpg" alt="Omar Agha"><h3><b>Omar Agha</b></h3><p>Software Engineer<br/>Front End</p></div>
		<div class="col-md-2 text-center"><img class="headshot img-circle img-thumbnail" src="./images/harshmeet.jpg" alt="Harshmeet Arora"><h3><b>Harshmeet Arora</b></h3><p>Software Engineer<br/>Back End</p></div>
		<div class="col-md-2 text-center"><img class="headshot img-circle img-thumbnail" src="./images/jamie.jpg" alt="Jamie Asefa"><h3><b>Jamie Asefa</b></h3><p>Server Database Admin</p></div>
		<div class="col-md-2 text-center"><img class="headshot img-circle img-thumbnail" src="./images/mitch.jpg" alt="Mitch Duffield"><h3><b>Mitch Duffield</b></h3><p>Software Engineer<br/>Front End</p></div>
		<div class="col-md-2"></div>
	</div>
	<div class="container lettherebewhite">
		<br><br>
		<!-- Team Row 2 -->
		<div class="col-md-3"></div>
		<div class="col-md-2 text-center"><img class="headshot img-circle img-thumbnail" src="./images/stefan.jpg" alt="Stefan Jauca"><h3><b>Stefan Jauca</b></h3><p>Embedded Systems Engineer</p></div>
		<div class="col-md-2 text-center"><img class="headshot img-circle img-thumbnail" src="./images/laurenz.jpg" alt="Laurenz Lebenstraum"><h3><b>Laurenz Lebenstraum</b></h3><p>Software Engineer<br/>Back End</p></div>
		<div class="col-md-2 text-center"><img class="headshot img-circle img-thumbnail" src="./images/sahil.jpg" alt="Franklin"><h3><b>Sahil Mazmudar</b></h3><p>Embedded Systems Engineer</p></div>
		<div class="col-md-3"></div>
	</div>
	<div class="container lettherebewhite">
		<br><hr/><br>
	</div>

	<br>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
