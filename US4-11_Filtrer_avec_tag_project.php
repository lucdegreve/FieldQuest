<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by Ophélie			      
This page contains code to display the filter labels for projects.
It is used in **'US4-11_Filtre_avec_tag_all_tags.php'** along with other similar pages to display other kinds of tags.
 


Input variables : 		

Output variables :		id of selected formats 								
		
------------------------------------------------------------->	

<META charset="utf-8"> 
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">

<!-- Import for collapse and event handling of checkbox buttons in main page US4-11_Filtre_avec_tag_all_tags.php -->

</head>
<body>
<?php
// Call to connexion file and connexion etablished in main page 'US4-11_Filtre_avec_tag_all_tags.php'
	
// Query to get projects 
$query_project = "SELECT id_project ,name_project FROM projects";
$result_project = pg_query($connex, $query_project);

// Resultset as a table
$table_projects = new Tab_donnees($result_project,"PG");
?>

<p>
  <button class="btn btn-lg btn-primary" type="button" data-toggle="collapse" data-target="#collapseProject" aria-expanded="true" aria-controls="collapseProject">
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
			echo '<button type="button" class="btn" data-color="primary" id = project_"'. $id_project .'">'.$name_project.'</button>';
			echo '<input type="checkbox" class="hidden" name="projet[]" value="'.$id_project.'"/>';
			echo '</span>';
		}
		?>
	</div>
  </div>
</div>

</body>
</html>