<html>
<?php session_start(); ?>
<head>
<!-----------------------------------------------------------
       US4-22 - Filter for user history of upload- Filters
	   
Developped by Ophélie			      
This page contains the filters to search for files (validated or not) in the user's history. 

It uses filter pages : - US4-11_Filtrer_avec_tag_format.php
					   - US4-11_Filtrer_avec_tag_unit.php
					   - US_4_11_filtre_avec_tag_data_type.php

Input variables : 		

Output variables :		
		
------------------------------------------------------------->	
 
<!-- Js, Jquery & Bootstrap Ressources for collapse and checkbox button -->
   <link href="//netdna.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="styles.css">

<meta name="viewport" content="width=device-width, initial-scale=1">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" integrity="sha384-u/bQvRA/1bobcXlcEYpsEdFVK/vJs3+T+nXLsBYJthmdBuavHvAW6UsmqO2Gd/F9"
	 crossorigin="anonymous">
</script>



<!-- Script for handling of checkbox button (bootstrap 4 version) -->
<script type= 'text/javascript' src = 'manage_checkbox_button_bt4.js'></script>
</head>
<body>

<?php
// Include code to connect to the database 
require_once "./tab_donnees/funct_connex.php";
require_once "./tab_donnees/tab_donnees.class.php";

// Get id of current user 
$id_user = $_SESSION['id_user'];
$id_user = 2;
// Connexion to the database 
$con=new Connex();
$connex=$con->connection;

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
	<div class = 'container'>
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
	</div> <!-- End container div -->
</form>
</body>
</html>