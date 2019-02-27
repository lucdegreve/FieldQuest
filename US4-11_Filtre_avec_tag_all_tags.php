<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by OphÃ©lie			      
This page contains code to display the filter labels:
- US4-11_Filtrer_avec_tag_project.php
- US4-11_Filtrer_avec_tag_format.php
- US4-11_Filtrer_avec_tag_unit.php


Input variables : 		

Output variables :		id of selected tags							
		
------------------------------------------------------------->	

<META charset="utf-8"> 
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script> 

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type= 'text/javascript' src = 'manage_checkbox_button.js'></script>
</head>

<body>
<?php
// Files to connect to the database and use recordset
require "tab_donnees/funct_connex.php";
require "tab_donnees/tab_donnees.class.php";

// Connexion to the database 
$con = new Connex();
$connex = $con->connection;
?>
<!-- Form to get selected filters  -->
<form name='filters' method = 'GET' action = 'US4-11_Filtre_avec_tag_all_tags.php'>
<div class='container'>
	
	<?php 
	// TO DO : include page data type
	
	// Include page with collapse button & content for project names
	include "US4-11_Filtrer_avec_tag_project.php"; 
	// TO DO : include page for source 
	?>
	<!-- Collapse button for date (start and end)-->
	<p>
		<button class="btn btn-lg btn-primary" type="button" data-toggle="collapse" data-target="#collapseDate" aria-expanded="true" aria-controls="collapseDate">
			Date
		</button>
	</p>
	<div class="collapse" id="collapseDate">
		<div class="card card-body">
			<label for ='start_date'>from</label>
			<input type = 'date' name ='start' id='start_date' >
			<label for ='end_date'>to</label>
			<input type='date' name ='end' id='end_date'>
		</div>
	</div>
	<?php
	// Include page with collapse button & content for file format 
	include "US4-11_Filtrer_avec_tag_format.php"; 
	// Include page with collapse button & content for unit 
	include "US4-11_Filtrer_avec_tag_unit.php";
	include "US_4_11_filtre_avec_tag_data_type.php";
	?>
	<!-- Search button -->
	<button type='submit' class='btn btn_lg btn-success' name='search'>Search</button>
</div>
</form>

<?php

if (isset($_GET['search'])){

	$start_date = $_GET['start'];
	$end_date = $_GET['end'];
	echo 'date : '.$start_date.' - '.$end_date.'</br></br>';
	
	if (isset($_GET['format'])){
		$array_format = print_r($_GET['format'],true);
		echo '</br>';
		print_r($array_format);
	}
	
	if (isset($_GET['projet'])){
		$array_projet = print_r($_GET['projet'], true);
		echo '</br>';
		print_r($array_projet);
	}
	
	if (isset($_GET['unit'])){
		$array_unit = print_r($_GET['unit'], true);
		echo '</br>';
		print_r($array_unit);
	}
	
	if (isset($_GET['tag'])){
		$array_tag = print_r($_GET['tag'], true);
		echo '</br>';
		print_r($array_tag);
	}
	
}
?>

</body>

</html>