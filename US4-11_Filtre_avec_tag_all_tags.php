<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by Ophélie			      
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
<link rel="stylesheet" href="css/custom.css">

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

<div class='container'>
	
	<?php 
	// include page data type
	include "US4-11_Filtrer_avec_tag_project.php"; 
	// include page for source 
	?>
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
	include "US4-11_Filtrer_avec_tag_format.php";
	include "US4-11_Filtrer_avec_tag_unit.php";
	?>
</div>
</body>

</html>