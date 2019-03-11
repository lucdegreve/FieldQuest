<?php session_start();
	require "tab_donnees/tab_donnees.class.php";
  require "tab_donnees/funct_connex.php";
  $con = new Connex();
  $connex = $con->connection;

	$id_project_to_add_am=$_GET["id_project_to_add_am"];
	$projects_list_to_update=$_SESSION["not_associated_projects_account_monitoring"];


	$query_for_updated_project_list = "SELECT id_project, name_project
                                      FROM projects
                                        WHERE id_project = ".$id_project_to_add_am;
	$result= pg_query($connex, $query_for_updated_project_list);
	$tab = new Tab_donnees($result,"PG");
	$project_to_reinject_am = $tab->t_enr;

	$projects_list_to_update[]=$project_to_reinject_am[0];
	$_SESSION["not_associated_projects_account_monitoring"] = $projects_list_to_update;

	$nb_projects_a = count($projects_list_to_update);

  echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
		  echo '<datalist id="project_choice">';
		        for ($k = 0; $k<$nb_projects_a;$k++ ){
		              echo '<option value="'.$projects_list_to_update[$k][0].'"> Project '.$projects_list_to_update[$k][0].' : '.$projects_list_to_update[$k][1].' </option>';
		        }
		  echo'</datalist>';
  echo '<button type="button" class="btn btn-outline-warning" name="addproject" onclick=addproject2() >Add a project</button> ';
?>
