<?php session_start();

	$id_project_erase_list_am=$_GET["id_project_erase_am"];
	$projects_for_list_am=$_SESSION["not_associated_projects_account_monitoring"];

	$nb_projects_am = count($projects_for_list_am);

	//To find which user to erase from the datalist
	for($i=0; $i<$nb_projects_am; $i++){
			if($projects_for_list_am[$i][0]==$id_project_erase_list_am){
					unset($projects_for_list_am[$i]); // erase from the table of users used to make datalist
					$projects_for_list_am=array_values($projects_for_list_am); // update numbers in array
			}
	}
	$_SESSION["not_associated_projects_account_monitoring"] = $projects_for_list_am;
	$nb_projects_am_a = count($projects_for_list_am);

	echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
			echo '<datalist id="project_choice">';
						for ($k = 0; $k<$nb_projects_am_a;$k++ ){
									echo '<option value="'.$projects_for_list_am[$k][0].'"> Project '.$projects_for_list_am[$k][0].' : '.$projects_for_list_am[$k][1].' </option>';
						}
			echo'</datalist>';
	echo '<input type="button" value="Add a project" name="addproject" onclick=addproject2() >';

?>
