<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - Units part  
Developped by Ophélie			      
This page contains code to display the filter labels based on the Tag Units.
It is used in **'US4-11_Filtre_avec_tag_all_tags.php'** along with other similar pages to display other kinds of tags.


Input variables : 		

Output variables :		id of selected tags 								
		
------------------------------------------------------------->	

<META charset="utf-8"> 

<!-- Import for collapse and event handling of checkbox buttons in main page US4-11_Filtre_avec_tag_all_tags.php -->

</head>
<body>
	<?php
	// Call to connexion file and connexion etablished in main page 'US4-11_Filtre_avec_tag_all_tags.php'
	
	// Query to get the tags of the tag type units 
	$query_units = "SELECT t.id_tag, t.tag_name FROM tags t JOIN tag_type tt on t.id_tag_type = tt.id_tag_type 
			WHERE tt.name_tag_type = 'unit'"; 
	$result_units = pg_query($connex,$query_units) or die ("Failed to fetch units tag");
	// Get recordset as a table
	$table_units = new Tab_donnees($result_units,"PG");
	?>

		<p>
		  <button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapseUnit" aria-expanded="true" aria-controls="collapseUnit">
			Unit
		  </button>
		</p>
		<div class="collapse" id="collapseUnit">
		  <div class="card card-body">
			<div class="form-check">
				<?php 
				// For each tag 
				for ($i=0; $i< $table_units->nb_enregistrements (); $i++){
					// Get id of the tag n°$i  of recordset
					$id_tag = $table_units-> t_enr[$i][0];
					// Get name of the tag n°$i  of recordset
					$tag_name = $table_units-> t_enr [$i][1];
				
					// Make checkbox button 
					echo '<span class="button-checkbox">';
					echo '<button type="button" class="btn btn-sm" data-color="primary" id = "unit_'. $id_tag .'">'.$tag_name.'</button>';
					//If a search has been previously launched , we preselect the filters "units" of the units which are been previously selected
					if (isset($selected_unit)){	
						if (in_array($id_tag,$selected_unit)){
							
								echo '<input type="checkbox" style="display: none;" name="unit[]" value="'.$id_tag.'" checked/>';
							}
					}
					else {
							echo '<input type="checkbox" style="display: none;" name="unit[]" value="'.$id_tag.'" unchecked/>';
						}
					echo '</span>';
				}
				?>
			</div>
		  </div>
		</div>


</body>

</html>