<!-----------------------------------------------------------
       US1-41 Create a project and US1-42 Gérer projets
Developped by Aurélie		      
This page is linked to ajax function deleteuser1 in US1-41_create_project.php

Display : Table , should be the same as in US1-41_create_project.php

Needed pages : tab_donnees.class.php, funct_connex.php

Input variables : 		$id_user_to_delete, $_SESSION["users_asso_before"]

Output variables :									

------------------------------------------------------------->	
<?php 
	
	session_start();
	require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    // Variables needed for connexion
    $con = new Connex();
    $connex = $con->connection;
	$id_user_to_delete=$_GET["id_user_to_delete"];

	$user_list_b = array();
	$user_list_b=$_SESSION["users_asso_before"];
	$nb_user_b = count($user_list_b);
	for($i=0;$i<$nb_user_b;$i++){
		if($user_list_b[$i][0]==$id_user_to_delete){
			unset($user_list_b[$i]);
			$user_list_b=array_values($user_list_b);
		}
	}
	$_SESSION["users_asso_before"] = $user_list_b;

	// to update the table of users associated after having deleted one
	echo'<table>';
	for ($i=0;$i<count($user_list_b);$i++){
		echo'<tr id='.$i.'>';
			echo'<td>'.$user_list_b[$i][1].' '.$user_list_b[$i][2].'</td>';
			echo'<td><input type="button" name="delete_user" value="Delete" onclick=deleteuser1('.$user_list_b[$i][0].')>'; 
		echo'</tr>';
	}
	echo '</table>';
	

?>
