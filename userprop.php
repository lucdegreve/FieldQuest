<!-----------------------------------------------------------
       US1-41 Create a project and US1-42 Gérer projets
Developped by Aurélie		      
This page is linked to ajax function add_user1 in US1-41_create_project.php

Display : Button , should be the same as in removeuser.php

Needed pages : tab_donnees.class.php, funct_connex.php

Input variables : 		$id_user_value

Output variables :		$_SESSION["id_user_list"]								

------------------------------------------------------------->	
<?php session_start();

    require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    // Variables needed for connexion
    $con = new Connex();
    $connex = $con->connection;
	
	//Variable from US1-41_create_project
    $id_user_value = $_GET["id_user_value"];
	if($id_user_value!=""){

	//To create variables without emptying them each time
    if(!isset($_SESSION["id_user_list"])){
      $_SESSION["id_user_list"]=array();
      $user_list=array();

    }else {

      $user_list = $_SESSION["id_user_list"];
    }
	$user_list[] = $id_user_value;
	$_SESSION["id_user_list"] = $user_list;
	$nb_id_user = count($user_list);
	
	  // Query to get all information from user_account to make a list of user.
	  for ($i=0; $i < $nb_id_user; $i++) {
		  $query = "SELECT id_user_account,last_name, first_name FROM user_account WHERE id_user_account = ".$user_list[$i];
		  $result= pg_query($connex, $query);
		  $tab = new Tab_donnees($result,"PG");
		  $table_users = $tab->t_enr;
		  echo "<BR/>";
		  echo '<input type="button" name="button_user '.$table_users[0][0].'" value="'.$table_users[0][1].' '.$table_users[0][2].'">';
		  echo '<input type="button" name="remove_user" value="Remove user" onclick=removeuser1('.$table_users[0][0].')>'; // removeuser1 is an ajax function called in US1-41_create_project
	  }
	}
	
?>
