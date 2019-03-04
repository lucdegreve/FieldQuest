<?php session_start();

    require "tab_donnees/tab_donnees.class.php";
    require "tab_donnees/funct_connex.php";
    // Variables needed for connexion
    $con = new Connex();
    $connex = $con->connection;
    $id_user_value = $_GET["id_user_value"];

    if(!isset($_SESSION["id_user_list"])){
      $_SESSION["id_user_list"]=array();
      $user_list=array();

    }else {

      $user_list = $_SESSION["id_user_list"];
    }
        $user_list[] = $id_user_value;
        $_SESSION["id_user_list"] = $user_list;
        $nb_id_user = count($user_list);
		$nb_id=array_count_values ($user_list); // counts frequency of each element
		echo $nb_id[0][0];
          // Query to get all information from user_type to make a list of user type.
          // With this admin will choose between three possibilities what type of user the account is for
          for ($i=0; $i < $nb_id_user; $i++) {

              $query = "SELECT id_user_account,last_name, first_name FROM user_account WHERE id_user_account = ".$user_list[$i];

              $result= pg_query($connex, $query);
              $tab = new Tab_donnees($result,"PG");
              $table_users = $tab->t_enr;
              echo "<BR/>";
              //echo '<p class = "'.$table_users[0][0].'">';
              echo '<input type="button" name="button_user '.$table_users[0][0].'" value="'.$table_users[0][1].' '.$table_users[0][2].'">';
              //echo '<a href="'.$table_project[0][0].'" onclick=removeproject1(this.value)> Remove </a>';
              //echo '<input type="button" name="remove_project" value"Remove project" onclick=removeproject1()>';
              //echo'</p>';
          }
?>
