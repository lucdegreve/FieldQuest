<?php session_start();
	require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    $con = new Connex();
    $connex = $con->connection;


	$id_project_erase_list_am=$_GET["id_project_erase_am"];
	$projects_for_list_am=$_SESSION["not_associated_projects_account_monitoring"];
	$query2 = "SELECT id_project,name_project FROM projects WHERE name_project='".$id_project_erase_list_am."'";
	$result2= pg_query($connex, $query2);
	$tab2 = new Tab_donnees($result2,"PG");
	$table_project2_am= $tab2->t_enr;
	$nb_projects_am = count($projects_for_list_am);

	//To find which user to erase from the datalist
	for($i=0; $i<$nb_projects_am; $i++){
			if($projects_for_list_am[$i][0]==$table_project2_am[0][0]){
					unset($projects_for_list_am[$i]); // erase from the table of users used to make datalist
					$projects_for_list_am=array_values($projects_for_list_am); // update numbers in array
			}
	}
	$_SESSION["not_associated_projects_account_monitoring"] = $projects_for_list_am;
	$nb_projects_am_a = count($projects_for_list_am);

	echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
			echo '<datalist id="project_choice">';
						for ($k = 0; $k<$nb_projects_am_a;$k++ ){
									echo '<option value="'.$projects_for_list_am[$k][1].'"> Project '.$projects_for_list_am[$k][0].' : '.$projects_for_list_am[$k][1].' </option>';
						}
			echo'</datalist>';
	echo '<button type="button" class="btn btn-outline-warning" name="addproject" onclick=addproject2() >Add a project</button> ';

?>
