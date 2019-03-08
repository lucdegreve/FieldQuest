<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by Ophélie			      
This page contains code to display the filter labels based on the format of files. 
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
	
	// Query to get formats 
	$query_format = "SELECT id_format, label_format FROM format";
	$result_format = pg_query($connex, $query_format);
	
	// Get recordset as a table
	$table_format = new Tab_donnees($result_format,"PG");
?>
<!-- Collapse button -->
		<p>
		  <button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapseFormat" aria-expanded="true" aria-controls="collapseFormat">
			File format
		  </button>
		</p>
		<!-- Content of collapse -->
		<div class="collapse" id="collapseFormat">
		  <div class="card card-body">
			<div class="form-check">
				<?php 
				// For each format 
				for ($i=0; $i< $table_format->nb_enregistrements (); $i++){
					// Get id of the format n°$i  of recordset
					$id_format = $table_format-> t_enr[$i][0];
					// Get label of the format n°$i  of recordset
					$label_format = $table_format-> t_enr [$i][1];
				
					// Make checkbox button 
					echo '<span class="button-checkbox">';
					echo '<button type="button" class="btn btn-sm" data-color="primary" id = "format_'. $id_format .'">'.$label_format.'</button>';
					//If a favorite search has been launched, we preselect the filters "formats" of the formats which are required in the favorite search
					if (isset($liste_format_fs)){	
						if (in_array($id_format,$liste_format_fs)){
								echo '<input type="checkbox" style="display: none;" name="format[]" value="'.$id_format.'" checked/>';
							}
					}
					else {
						echo '<input type="checkbox" style="display: none;" name="format[]" value="'.$id_format.'" unchecked/>';
					}
					
					echo '</span>';
				}
				?>
			</div>
		  </div>
		</div>

</body>
</html>