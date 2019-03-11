<?php session_start();
	require "tab_donnees/tab_donnees.class.php";
  require "tab_donnees/funct_connex.php";
  $con = new Connex();
  $connex = $con->connection;


	$id_project_to_add=$_GET["id_project_to_add"];
	$projects_for_list_2=$_SESSION["not_associated_projects"];

	$query_for_updated_project_list = "SELECT id_project, name_project
                                      FROM projects
                                        WHERE id_project = ".$id_project_to_add;
	$result= pg_query($connex, $query_for_updated_project_list);
	$tab = new Tab_donnees($result,"PG");
	$project_to_reinject = $tab->t_enr;

	$projects_for_list_2[]=$project_to_reinject[0];
  $nb_projects_a = count($projects_for_list_2);
	$_SESSION["not_associated_projects"] = $projects_for_list_2;

  echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
  echo '<datalist id="project_choice">';
        for ($k = 0; $k<$nb_projects_a;$k++ ){
              echo '<option value="'.$projects_for_list_2[$k][0].'"> Project '.$projects_for_list_2[$k][0].' : '.$projects_for_list_2[$k][1].' </option>';
        }
  echo'</datalist>';
  echo '<button type="button" class="btn btn-outline-warning" name="addproject" onclick=addproject1() >Add a project</button> ';
?>
