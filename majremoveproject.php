<?php session_start();

    require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    $con = new Connex();
    $connex = $con->connection;

    $id_project_value = $_GET["id_project_value"];
    $project_list = $_SESSION["id_project_list"];

    $nb_id_project_before = count($project_list);
    for ($i=0; $i < $nb_id_project_before ; $i++) {
        if ($project_list[$i] == $id_project_value) {
          unset($project_list[$i]);
          $project_list = array_values($project_list);
        }
    }

    $_SESSION["id_project_list"] = $project_list;
    $nb_id_project = count($project_list);

    for ($i=0; $i < $nb_id_project; $i++) {
        $query = "SELECT id_project, name_project
                    FROM projects
                      WHERE id_project = ".$project_list[$i];
        $result= pg_query($connex, $query);
        $tab = new Tab_donnees($result,"PG");
        $table_project = $tab->t_enr;
        echo "<BR/>";
        echo '<input type="button" name="button_project '.$table_project[0][0].'" value=" Project '.$table_project[0][0].' :'.$table_project[0][1].'">';
        echo '<input type="button" name="remove_project" value="Remove project" onclick=removeproject1('.$table_project[0][0].')>';
    }
?>
