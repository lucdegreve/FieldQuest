<html>
<head>
<!-----------------------------------------------------------
       US4-22 & US4-21 - Access history and search using tags 
	   
Developped by Ophélie			      
This page contains the display of history upload and filters. 

It uses pages : - US_4_21_access_history.php
				- US4_22_Filter_on_history_filters.php

Input variables : 		

Output variables :		
		
------------------------------------------------------------->	
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="styles.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- Js, Jquery & Bootstrap Ressources for collapse and checkbox button -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" integrity="sha384-u/bQvRA/1bobcXlcEYpsEdFVK/vJs3+T+nXLsBYJthmdBuavHvAW6UsmqO2Gd/F9"
	 crossorigin="anonymous"></script>

<!-- Ressources for access history -->

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
<link href="css/custom.css" rel="stylesheet" type="text/css">


<!-- downloading leaflet libraries for the map-->

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-draw@1.0.2/dist/leaflet.draw.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.2/dist/leaflet.draw.css" />


</head>
<body>
<?php 

// Header 
include("en_tete.php"); 

// Files to connect to the db & use recordset
require_once "./tab_donnees/tab_donnees.class.php";
require_once "./tab_donnees/funct_connex.php";
// Connexion to the database
$con = new Connex();
$connex = $con->connection;

// Get user Id from session
$id_user=$_SESSION['id_user_account'];
$id_user = 1;
?>

	<div class="row">
		<div class="col col-md-2">
			<?php include "US4_22_Filter_on_history_filters.php"; ?>
		</div>
		<div class ="col-md-10">
			<!-- Navigation tabs -->
			<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
							<a href="#list" data-toggle="tab" role="tab" class="nav-link active">Files list</a>
					</li>
					<li>
							<a href="#map" data-toggle="tab" role="tab" class="nav-link">Map</a>
					</li>
			</ul>
			
			<!-- Table panes -->
			<div class="tab-content">
					<div class="tab-pane active" id="list" role="tabpanel" aria-labelledby="list">
							<?php include ("US_4_21_access_history.php"); ?>
					</div>
					<div class="tab-pane fade" id="map" role="tabpanel" aria-labelledby="map">
						<div id="map-holder">
						  <div class="container fill">
							<div id="map"><?php include ("US4_22_Map.php"); ?></div>
						  </div>
						</div>
					</div>
			</div>  
		</div>
	</div>
	
<?php
	// Include footer
	include("pied_de_page.php");
?>
</body>


</html>
