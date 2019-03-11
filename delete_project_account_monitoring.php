<?php
	session_start();
	require "tab_donnees/tab_donnees.class.php";
  require "tab_donnees/funct_connex.php";
  $con = new Connex();
  $connex = $con->connection;


	$id_project_to_delete=$_GET["id_project_to_delete"];
	$project_list_already_associated=$_SESSION["already_associated_projects"];

	$nb_project_b = count($project_list_already_associated);
	for($i=0;$i<$nb_project_b;$i++){
  		if($project_list_already_associated[$i][0]==$id_project_to_delete){
    			unset($project_list_already_associated[$i]);
    			$project_list_already_associated=array_values($project_list_already_associated);
  		}
	}
	$_SESSION["already_associated_projects"] = $project_list_already_associated;

  $nb_project_a = count($project_list_already_associated);

	echo'<table>';
	for ($i=0;$i<$nb_project_a;$i++){
    echo '<tr>';
        echo '<td> Projet '.$project_list_already_associated[$i][0].' : '.$project_list_already_associated[$i][1].' </td>
        <td> <button type="button" class="btn btn-outline-danger" name="delete_project" onclick=deleteproject1('.$tab_associated_project[$i][0].')>Delete</button> </td>';
    echo '</tr>';
	}
	echo '</table>';

?>
