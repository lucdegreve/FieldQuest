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

	unset($_SESSION["id_user_list"]);
	echo "";
	
?>