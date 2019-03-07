<?php session_start();

    require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    $con = new Connex();
    $connex = $con->connection;

    $id_project_value_am = $_GET["id_project_value_rm"];
    $project_list_am = $_SESSION["id_project_list_am"];

    $nb_id_project_before_am = count($project_list_am);
    for ($i=0; $i < $nb_id_project_before_am ; $i++) {
        if ($project_list_am[$i] == $id_project_value_am) {
          unset($project_list_am[$i]);
          $project_list_am = array_values($project_list_am);
        }
    }

    $_SESSION["id_project_list_am"] = $project_list_am;

    $nb_id_project_am = count($project_list_am);
    for ($i=0; $i < $nb_id_project_am; $i++) {

        $query = "SELECT id_project, name_project FROM projects WHERE id_project = ".$project_list_am[$i];
        $result= pg_query($connex, $query);
        $tab = new Tab_donnees($result,"PG");
        $table_project_am = $tab->t_enr;

        echo "<BR/>";
        echo '<input type="button" name="button_project '.$table_project_am[0][0].'" value=" Project '.$table_project_am[0][0].' :'.$table_project_am[0][1].'">';
        echo '<input type="button" name="remove_project" value="Remove project" onclick=removeproject2('.$table_project_am[0][0].')>';
    }
?>
