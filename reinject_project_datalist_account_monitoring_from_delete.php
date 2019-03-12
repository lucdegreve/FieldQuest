<?php session_start();
	require "tab_donnees/tab_donnees.class.php";
  require "tab_donnees/funct_connex.php";
  $con = new Connex();
  $connex = $con->connection;

	$id_project_to_add_from_delete=$_GET["id_project_to_add_from_delete"];
	$not_associated_project_account_monitoring=$_SESSION["not_associated_projects_account_monitoring"];


	$query_add_new_project = "SELECT id_project, name_project FROM projects WHERE id_project = ".$id_project_to_add_from_delete;
	$result_add= pg_query($connex, $query_add_new_project);
	$tab2 = new Tab_donnees($result_add,"PG");
	$not_associated_project_account_monitoring_a = $tab2->t_enr;

	$not_associated_project_account_monitoring[]=$not_associated_project_account_monitoring_a[0];
	$_SESSION["not_associated_projects_account_monitoring"] = $not_associated_project_account_monitoring;

  $nb_projects_ad = count($not_associated_project_account_monitoring);
  echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
		  echo '<datalist id="project_choice">';
		        for ($k = 0; $k<$nb_projects_ad; $k++ ){
		            echo '<option value="'.$not_associated_project_account_monitoring[$k][1].'"> Project '.$not_associated_project_account_monitoring[$k][0].' : '.$not_associated_project_account_monitoring[$k][1].' </option>';
		        }
		  echo '</datalist>';
  echo '<button type="button" class="btn btn-outline-warning" name="addproject" onclick=addproject2() >Add a project</button>';

?>
