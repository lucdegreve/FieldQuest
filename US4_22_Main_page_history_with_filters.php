<html>
<?php session_start(); ?>
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


</head>
<body>
<?php 
// Files to connect to the db & use recordset
require_once "./tab_donnees/tab_donnees.class.php";
require_once "./tab_donnees/funct_connex.php";
// Connexion to the database
$con = new Connex();
$connex = $con->connection;
// Header 
include("en_tete.php"); 
// Get user Id from session
$id_user=$_SESSION['id_user_account'];
$id_user = 1;
?>
<div class="row">
	<div class="col col-md-3">
		<?php include "US4_22_Filter_on_history_filters.php"; ?>
	</div>
	<div class ="col-md-9">
		<?php include "US_4_21_access_history.php"; ?>
	</div>
</div>
<?php
	// Include footer
	include("pied_de_page.php");
?>
</body>
</html>
