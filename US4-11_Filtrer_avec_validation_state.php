<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filter depending on validation state  
Developped by Aurélie			      
This page contains code to display the filter labels for validation state.
It is used in **'US4-11_Filtre_avec_tag_all_tags.php'** along with other similar pages to display other kinds of tags.
 

Input variables : 		

Output variables :		id of selected formats 								
		
------------------------------------------------------------->	

<META charset="utf-8"> 

<!-- Import for collapse and event handling of checkbox buttons in main page US4-11_Filtre_avec_tag_all_tags.php -->

</head>
<body>
<?php
// Call to connexion file and connexion etablished in main page 'US4-11_Filtre_avec_tag_all_tags.php'
	
// Query to get projects 
$query_validation_state = "SELECT id_validation_state ,label_validation_state FROM validation_state";
$result_validation_state = pg_query($connex, $query_validation_state);

// Resultset as a table
$table_validation_state = new Tab_donnees($result_validation_state,"PG");
?>

<p>
  <button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapseValidationState" aria-expanded="true" aria-controls="collapseValidationState">
	Validation state
  </button>
</p>
<!-- Content of collapse -->
<div class="collapse" id="collapseValidationState">
  <div class="card card-body">
	<div class="form-check">
		<?php 
		// For each format 
		for ($i=0; $i< $table_validation_state->nb_enregistrements (); $i++){
			// Get id of the format n°$i  of recordset
			$id_validation_state = $table_validation_state-> t_enr[$i][0];
			// Get label of the format n°$i  of recordset
			$label_validation_state = $table_validation_state-> t_enr [$i][1];
		
			// Make checkbox button 
			echo '<span class="button-checkbox">';
			echo '<button type="button" class="btn btn-sm" data-color="primary" id = project_"'. $id_validation_state .'">'.$label_validation_state.'</button>';
			echo '<input type="checkbox" style="display: none;" name="Validation_state[]" value="'.$id_validation_state.'"/>';
			echo '</span>';
		}
		?>
	</div>
  </div>
</div>

</body>
</html>