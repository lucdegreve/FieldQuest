<!-----------------------------------------------------------
       US1-41 Create a project and US1-42 Gérer projets
Developped by Aurélie		      
This page is linked to ajax function removeuser1 in US1-41_create_project.php

Display : Button , should be the same as in userprop.php

Needed pages : tab_donnees.class.php, funct_connex.php

Input variables : 		$id_user_value, $_SESSION["id_user_list"]

Output variables :										

------------------------------------------------------------->	
<?php session_start();

    require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    // Variables needed for connexion
    $con = new Connex();
    $connex = $con->connection;
	
    $id_user_value = $_GET["id_user_value"];
	$user_list = $_SESSION["id_user_list"];
	$nb_id_user_b = count($user_list);
	
	for($i=0;$i<$nb_id_user_b;$i++){
		if($user_list[$i]==$id_user_value){
			unset($user_list[$i]);
			$user_list=array_values($user_list);
		}
	}
	$_SESSION["id_user_list"] = $user_list;
	//echo'user_list'.var_dump($user_list);
	$nb_id_user = count($user_list);
	//$nb_id=array_count_values ($user_list); // counts frequency of each element
	  // Query to get all information from user_type to make a list of user type.
	  // With this admin will choose between three possibilities what type of user the account is for
	  for ($i=0; $i < $nb_id_user; $i++) {

		  $query = "SELECT id_user_account,last_name, first_name FROM user_account WHERE id_user_account = '".$user_list[$i]."'";

		  $result= pg_query($connex, $query);
		  $tab = new Tab_donnees($result,"PG");
		  $table_users = $tab->t_enr;
		  echo "<BR/>";
		  //echo '<p class = "'.$table_users[0][0].'">';
		  echo '<button type="button" class="btn btn-info" name="button_user '.$table_users[0][0].'" >'.$table_users[0][1].' '.$table_users[0][2].'</button>';
		  echo '<button type="button" class="btn btn-danger" name="remove_project" onclick=removeuser1('.$table_users[0][0].')>Remove user</button>';
		  //echo'</p>';
	  }
?>