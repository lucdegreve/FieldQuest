<?php session_start();

	$id_project_erase_list=$_GET["id_project_erase"];
	$projects_for_list=$_SESSION["not_associated_projects"];
	$nb_projects = count($projects_for_list);

	//To find which user to erase from the datalist
	for($i=0; $i<$nb_projects; $i++){
			if($projects_for_list[$i][0]==$id_project_erase_list){
					unset($projects_for_list[$i]); // erase from the table of users used to make datalist
					$projects_for_list=array_values($projects_for_list); // update numbers in array
			}
	}
	$_SESSION["not_associated_projects"] = $projects_for_list;
	$nb_projects_a = count($projects_for_list);

	echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
			echo '<datalist id="project_choice">';
						for ($k = 0; $k<$nb_projects_a;$k++ ){
									echo '<option value="'.$projects_for_list[$k][0].'"> Project '.$projects_for_list[$k][0].' : '.$projects_for_list[$k][1].' </option>';
							}
			echo'</datalist>';
	echo '<button type="button" class="btn btn-md btn-outline-warning" name="addproject" onclick=addproject1()>Add a project</button>';
?>
