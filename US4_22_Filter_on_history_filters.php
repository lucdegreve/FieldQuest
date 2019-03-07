<html>
<head>
<!-----------------------------------------------------------
       US4-22 - Filter for user history of upload- Filters
	   
Developped by Ophélie			      
This page contains the filters to search for files (validated or not) in the user's history of upload. 

It uses filter pages : - US4-11_Filtrer_avec_tag_format.php
					   - US4-11_Filtrer_avec_tag_unit.php
					   - US_4_11_filtre_avec_tag_data_type.php
This page is used in "US4_22_Main_page_history_with_filters.php"

Input variables : 		

Output variables :	Selected 	Start date (start), End date (end), list of unit tags (unit)
					list of project tags (project), list of format (format), list of data type (tag)
					
					Use method POST 
		
------------------------------------------------------------->	

<!-- Script for handling of checkbox button (bootstrap 4 version) -->
<script type= 'text/javascript' src = 'manage_checkbox_button_bt4.js'></script>
</head>
<body>

<?php

// Query to get projects 
$query_project = "SELECT p.id_project ,p.name_project 
					FROM projects p 
					JOIN link_project_users lpu ON p.id_project = lpu.id_project
					WHERE lpu.id_user_account = '".$id_user."'";
$result_project = pg_query($connex, $query_project);

// Resultset as a table
$table_projects = new Tab_donnees($result_project,"PG");
?>

<!--------------------- Form to select filters --------------------->
	<form name= "form_filters" method="POST">
	
		<?php
		// Filter on file format 
		include "US4-11_Filtrer_avec_tag_format.php";
		?>
		<!------ Collapse button for date (start and end)------>
		<p>
			<button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapseDate" aria-expanded="true" aria-controls="collapseDate">
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
		
		<!------ Collaps button for filter on projects ------->
		<p>
		  <button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapseProject" aria-expanded="true" aria-controls="collapseProject">
			Project
		  </button>
		</p>
		<!-- Content of collapse -->
		<div class="collapse" id="collapseProject">
		  <div class="card card-body">
			<div class="form-check">
				<?php 
				// For each format 
				for ($i=0; $i< $table_projects->nb_enregistrements (); $i++){
					// Get id of the format n°$i  of recordset
					$id_project = $table_projects-> t_enr[$i][0];
					// Get label of the format n°$i  of recordset
					$name_project = $table_projects-> t_enr [$i][1];
				
					// Make checkbox button 
					echo '<span class="button-checkbox">';
					echo '<button type="button" class="btn btn-sm" data-color="primary" id = project_"'. $id_project .'">'.$name_project.'</button>';
					echo '<input type="checkbox" style="display: none;" name="projet[]" value="'.$id_project.'"/>';
					echo '</span>';
				}
				?>
			</div>
		  </div>
		</div>
		<?php
		// Filter on tag unit
		include "US4-11_Filtrer_avec_tag_unit.php";
		// Filter on data type tag 
		include "US_4_11_filtre_avec_tag_data_type.php";
		?>
	
	</form>
</body>
</html>