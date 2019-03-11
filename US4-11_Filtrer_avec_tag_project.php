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

<!-- Import for collapse and event handling of checkbox buttons in main page US4-11_Filtre_avec_tag_all_tags.php -->

</head>
<body>
<?php
$id_user_account=$_SESSION['id_user_account'];
// Call to connexion file and connexion etablished in main page 'US4-11_Filtre_avec_tag_all_tags.php'
	
// Query to get projects 
if ($_SESSION['id_user_type']!=3){
	$query_project = "SELECT id_project ,name_project FROM projects";
}
else{
	$query_project = "SELECT id_project ,name_project FROM projects where id_project IN (select id_project from link_project_users where id_user_account=$id_user_account)";
}
$result_project = pg_query($connex, $query_project);

// Resultset as a table
$table_projects = new Tab_donnees($result_project,"PG");
?>

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
			//If a favorite search has been launched, we preselect the filters "project" of the projects which are required in the favorite search
			if (isset($liste_project_fs)){
				if (in_array($id_project,$liste_project_fs)){
								echo '<input type="checkbox" style="display: none;" name="projet[]" value="'.$id_project.'" checked/>';
							}
			}
			else {
					echo '<input type="checkbox" style="display: none;" name="projet[]" value="'.$id_project.'" />';
				}
			echo '</span>';
			
		}
		
		
		?>
	</div>
  </div>
</div>

</body>
</html>