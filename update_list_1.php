<!-----------------------------------------------------------
       US1-41 Create a project and US1-42 Gérer projets
Developped by Aurélie		      
This page is linked to ajax function add_user1 in US1-41_create_project.php

Display : Datalist , should be the same as in US1-41_create_project.php, update_list_2.php, update_list_3.php

Needed pages : tab_donnees.class.php, funct_connex.php

Input variables : 		$id_user_erase, $_SESSION["users_not_asso_before"]

Output variables :										

------------------------------------------------------------->	

<?php session_start();

	$id_user_erase_list=$_GET["id_user_erase"];
	$users_for_list= array();
	$users_for_list=$_SESSION["users_not_asso_before"];
	$nb_users = count($users_for_list);
	
	//To find which user to erase from the datalist
	for($i=0;$i<$nb_users;$i++){
		if($users_for_list[$i][0]==$id_user_erase_list){
			unset($users_for_list[$i]); // erase from the table of users used to make datalist
			$users_for_list=array_values($users_for_list); // update numbers in array
		}
	}
	$_SESSION["users_not_asso_before"] = $users_for_list;

	//rebuilding of datalist updated
	echo'<input list="users" type="text" id="users_na" autocomplete="off">';
		echo'<datalist id="users">';
				for($i=0; $i<count($users_for_list); $i++){	
					echo'<option value="'.$users_for_list[$i][0].'" label="'.$users_for_list[$i][1].' '.$users_for_list[$i][2].'">'.$users_for_list[$i][1].' '.$users_for_list[$i][2].'</option>';
				}
		echo'</datalist>';
	// button to add the selected user to the project	
	echo'<button type="button" class="btn btn-success" name="addu" onclick="add_user1()">Add a user</button>';
					
?>