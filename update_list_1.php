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
	require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    // Variables needed for connexion
    $con = new Connex();
    $connex = $con->connection;
	
	$id_user_erase_list=$_GET["id_user_erase"];
	$users_for_list=$_SESSION["users_not_asso_before"];
	//echo "tableau avec tout".var_dump($users_for_list);
	$query2 = "SELECT id_user_account,last_name, first_name FROM user_account WHERE last_name ='".$id_user_erase_list."'";
	$result2= pg_query($connex, $query2);
	$tab2 = new Tab_donnees($result2,"PG");
	$table_users2= $tab2->t_enr;
	
	//echo "tableau utilisateur à enlever de liste".var_dump($table_users2);
	$nb_users = count($users_for_list);
	
	//To find which user to erase from the datalist
	for($i=0;$i<$nb_users;$i++){
		if($users_for_list[$i][0]==$table_users2[0][0]){
			unset($users_for_list[$i]); // erase from the table of users used to make datalist
			$users_for_list=array_values($users_for_list); // update numbers in array
		}
	}
	$_SESSION["users_not_asso_before"] = $users_for_list;

	//rebuilding of datalist updated
	echo'<input list="users" type="text" id="users_na" autocomplete="off">';
		echo'<datalist id="users">';
				for($i=0; $i<count($users_for_list); $i++){	
					echo'<option value="'.$users_for_list[$i][1].'">'.$users_for_list[$i][1].' '.$users_for_list[$i][2].'</option>';
				}
		echo'</datalist>';
	// button to add the selected user to the project	
	echo'<button type="button" class="btn btn-outline-warning" name="addu" onclick="add_user1()">Add a user</button>';
					
?>