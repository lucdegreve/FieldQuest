<!-----------------------------------------------------------
       US1-41 Create a project and US1-42 Gérer projets
Developped by Aurélie		      
This page is linked to ajax function removeuser1 in US1-41_create_project.php

Display : Datalist , should be the same as in US1-41_create_project.php, update_list_1.php, update_list_3.php

Needed pages : tab_donnees.class.php, funct_connex.php

Input variables : 		$id_user_add, $_SESSION["users_not_asso_before"]

Output variables :										

------------------------------------------------------------->	


<?php session_start();
	require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    // Variables needed for connexion
    $con = new Connex();
    $connex = $con->connection;

	$id_user_add_list=$_GET["id_user_add"];
	//echo 'id recup '.$id_user_add_list;
	$users_for_list2= array();
	$users_for_list2=$_SESSION["users_not_asso_before"];
	$query_for_list = "SELECT id_user_account,last_name, first_name FROM user_account WHERE id_user_account = ".$id_user_add_list;
	$result= pg_query($connex, $query_for_list);
	$tab = new Tab_donnees($result,"PG");
	$table_users_list = $tab->t_enr;
	$users_for_list2[]=$table_users_list[0];
	
	$_SESSION["users_not_asso_before"] = $users_for_list2;
	//echo 'id recup2 '.var_dump($users_for_list2);
	
	echo'<input list="users" type="text" id="users_na" autocomplete="off">';
		echo'<datalist id="users">';
				for($i=0; $i<count($users_for_list2); $i++){	
					echo'<option value="'.$users_for_list2[$i][0].'" label="'.$users_for_list2[$i][1].' '.$users_for_list2[$i][2].'">'.$users_for_list2[$i][1].' '.$users_for_list2[$i][2].'</option>';
				}
		echo'</datalist>';
	// button to add the selected user to the project	
	echo'<input type="button" name="addu" value="Add a user" onclick="add_user1()">';
					
?>