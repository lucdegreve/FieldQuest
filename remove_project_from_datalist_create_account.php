<?php session_start();
	require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    // Variables needed for connexion
    $con = new Connex();
    $connex = $con->connection;

	$id_project_erase_list=$_GET["id_project_erase"];
	$projects_for_list=$_SESSION["not_associated_projects"];
	$query2 = "SELECT id_project,name_project FROM projects WHERE name_project='".$id_project_erase_list."'";
	$result2= pg_query($connex, $query2);
	$tab2 = new Tab_donnees($result2,"PG");
	$table_project2= $tab2->t_enr;
	$nb_projects = count($projects_for_list);
	$nb_projects = count($projects_for_list);

	//To find which user to erase from the datalist
	for($i=0; $i<$nb_projects; $i++){
			if($projects_for_list[$i][0]==$table_project2[0][0]){
					unset($projects_for_list[$i]); // erase from the table of users used to make datalist
					$projects_for_list=array_values($projects_for_list); // update numbers in array
			}
	}
	$_SESSION["not_associated_projects"] = $projects_for_list;
	$nb_projects_a = count($projects_for_list);

	echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
			echo '<datalist id="project_choice">';
						for ($k = 0; $k<$nb_projects_a;$k++ ){
									echo '<option value="'.$projects_for_list[$k][1].'"> Project '.$projects_for_list[$k][0].' : '.$projects_for_list[$k][1].' </option>';
							}
			echo'</datalist>';
	echo '<button type="button" class="btn btn-md btn-outline-warning" name="addproject" onclick=addproject1()>Add a project</button>';
?>
