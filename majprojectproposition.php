<?php session_start();

    require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    // Variables needed for connexion
    $con = new Connex();
    $connex = $con->connection;
    $id_project_value = $_GET["id_project_value"];

    if(!isset($_SESSION["id_project_list"])){
        //$_SESSION["id_project_list"]=array();
        $_SESSION["id_project_list"]=array();
    }
    else {
        $project_list = $_SESSION["id_project_list"];
    }

    $project_list[] = $id_project_value;

    // Re-injected new project list in SESSION variable
    $_SESSION["id_project_list"] = $project_list;
          //$_SESSION["id_project_list"] = 1;
    $nb_id_project = count($project_list);
          // Query to get all information from user_type to make a list of user type.
          // With this admin will choose between three possibilities what type of user the account is for
    for ($i=0; $i < $nb_id_project; $i++) {

        $query = "SELECT id_project, name_project FROM projects WHERE id_project = ".$project_list[$i];

        $result= pg_query($connex, $query);
        $tab = new Tab_donnees($result,"PG");
        $table_project = $tab->t_enr;

        echo "<BR/>";
        echo '<button type="button" class="btn btn-outline-info" name="button_project '.$table_project[0][0].'" >Project '.$table_project[0][0].' :'.$table_project[0][1].'</button>';    
        echo '<button type="button" class="btn btn-outline-warning" name="remove_project" onclick=removeproject1('.$table_project[0][0].')>Remove project</button> ';

    }
?>
