<?php session_start();

    require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    $con = new Connex();
    $connex = $con->connection;

    $id_project_value_am = $_GET["id_project_value_am"];
	$query1 = "SELECT id_project,name_project FROM projects WHERE name_project ='".$id_project_value_am."'";
	$result1= pg_query($connex, $query1);
	$tab1 = new Tab_donnees($result1,"PG");
	$table_project1_am = $tab1->t_enr;

    if(!isset($_SESSION["id_project_list_am"])){
        $_SESSION["id_project_list_am"]=array();
    }
    else {
        $project_list_am = $_SESSION["id_project_list_am"];
    }
	
    $project_list_am[] = $table_project1_am[0][0];

    $_SESSION["id_project_list_am"] = $project_list_am;
    $nb_id_project_am = count($project_list_am);
	
    for ($i=0; $i < $nb_id_project_am; $i++) {
        $query = "SELECT id_project, name_project FROM projects WHERE id_project = ".$project_list_am[$i];
        $result= pg_query($connex, $query);
        $tab = new Tab_donnees($result,"PG");
        $table_project_am = $tab->t_enr;

        echo "<BR/>";
        echo '<button type="button" class="btn btn-outline-info" name="button_project '.$table_project_am[0][0].'"> Project '.$table_project_am[0][0].' :'.$table_project_am[0][1].'</button>';
        echo '<button type="button" class="btn btn-outline-danger" name="remove_project" onclick=removeproject2('.$table_project_am[0][0].')>Remove project</button>';
    }
?>
