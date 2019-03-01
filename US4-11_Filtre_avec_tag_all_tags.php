<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by Ophélie	& Diane		      
This page contains code to display the filter labels:
- US4-11_Filtrer_avec_tag_project.php
- US4-11_Filtrer_avec_tag_format.php
- US4-11_Filtrer_avec_tag_unit.php
- US_4_11_filtre_avec_tag_data_type.php

Input variables : 		

Output variables :		id of selected tags							
		
------------------------------------------------------------->	



<script type= 'text/javascript' src = 'manage_checkbox_button.js'></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


</head>

<body>

<!-- Form to get selected filters  -->
<form name='filters' method = 'POST' action = 'US4-11_Main_page_filter.php'>

	
	<?php 
	// Include page with collapse button & content for project names
	include "US4-11_Filtrer_avec_tag_project.php"; 
	?>
	<!-- Collapse button for date (start and end)-->
	<p>
		<button class="btn btn-lg btn-primary btn-block" type="button" data-toggle="collapse" data-target="#collapseDate" aria-expanded="true" aria-controls="collapseDate">
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
	// Include page with source bar search 
	include "US4_11_Requete_source_final.php";
	// Include page with collapse button & content for data type 
	include "US_4_11_filtre_avec_tag_data_type.php";
	
	?>
	<!-- Search button -->
	<button type='submit' class='btn btn_lg btn-success' name='search'>Search</button>

</form>


</body>

</html>