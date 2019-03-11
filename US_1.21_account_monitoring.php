<?php
    if(!isset($_GET["modify_account"])){
        if(isset($_SESSION["id_project_list_am"])){
            unset($_SESSION["id_project_list_am"]);
       }
    }
?>

<!--
       US1-11 Modify user account
Developped by Adrien
This page contains the form to create a new account.
Needed/called pages : 	tab_donnees.class.php, funct_connex.php,
            delete_project_account_monitoring
            reinject_project_datalist_account_monitoring_from_delete.php

            majprojectproposition_account_monitoring.php
            majremoveproject_account_monitoring.php

            remove_project_from_datalist_account_monitoring.php
            reinject_project_datalist_from_remove_account_monitoring.php


Input variables : 		$id_user_account

Output variables :
		name of the form : account_monitoring
		variables submitted in the form : All the ones from user_account + the id of linked projects

Description :
In this script we modify the user account in order to update the table "user_account" in the database.
Verifying that needed fields (such as name or first_name) are checked with Javascript function
This part is not difficult BUT
We have a table of the projects already associated with the user that must be dynamic (2 Ajax functions)
AND
We need to associate project if the admin want to do so
So we have to create dynamic list of project to add or to remove, what we do with 4 Ajax functions

------------------------------------------------------------->

<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title> Account monitoring </title>
        <link rel = "stylesheet" href ="css/bootstrap.min.css">
        <link rel = "stylesheet" href ="css/custom.css">
    </head>
    <body>
        <script type="text/javascript">
            // Function valider(), verify for each field if it is filled. If not, warning message appears

            function valider(){
                  var c = 0 ;
                  var msg = "" ;
                if (document.account_monitoring.last_name.value == "") {
                      c = 1 ;
                      msg = msg + "Please enter the last name \n" ;
                }
                if (document.account_monitoring.first_name.value == "") {
                      c = 1 ;
                      msg = msg + "Please enter the first name \n" ;
                }
                if (c==0) {
                      return true;
                }
                else {
                      alert(msg);
                      return false;
                  }
            }
        </script>

    		<?php
    				 include("en_tete.php");
    		?>
<div align="center">
        <BR/>
        <h2> Please find here the user's information </h2>
        <BR/>
        Fields with (*) must be filled

        <?php

            $id_user_account = $_GET["id_user_account"];

            // A ENLEVER APRES VERIFICATION
            //$id_user_account = 2;

            require "tab_donnees/tab_donnees.class.php";
            require "tab_donnees/funct_connex.php";
            $con = new Connex();
            $connex = $con->connection;
        ?>

        <?php
        // We must put an isset now, Indeed the following form must be pre-filled AND when you click sur modify
        // You have to update the database and to re pre-fill the form to have a view

            if (isset($_GET["last_name"],$_GET["first_name"])){
                $last_name = $_GET["last_name"];
                $first_name = $_GET["first_name"];
                $company = $_GET["company"];
                $address = $_GET["address"];
                $postcode = $_GET["postcode"];
                $city = $_GET["city"];
                $country = $_GET["country"];
                $email = $_GET["email"];
                $phone = $_GET["phone"];
                $website = $_GET["website"];

                $id_user_account = $_GET["id_user_account"];
                echo '</br><p><b><font color="#33cc33"> Database have been correctly updated</b></font></p>';

                $query = "UPDATE user_account
                          SET last_name = '".$last_name."', first_name = '".$first_name."',  company = '".$company."',
                          address = '".$address."', postcode = '".$postcode."', city = '".$city."', country = '".$country."',
                          email = '".$email."', phone = '".$phone."', website = '".$website."'
                          WHERE id_user_account = '".$id_user_account."'";
                $query_result = pg_query($connex,$query) or die (pg_last_error() );

                // Adding project to the user created

                // First, deleting all the associated projects
                $query_delete = "DELETE FROM link_project_users WHERE id_user_account =".$id_user_account;
                $query_result_delete = pg_query($connex,$query_delete) or die (pg_last_error());

                // Then, Taking all the project
                $id_already_associated_p = $_SESSION["already_associated_projects"]; //tableau avec trois colonnes
                $id_projects_added = $_SESSION["id_project_list_am"]; //tableau d'identifiant
                if ($id_already_associated_p[0]!="") {
                    for ($i=0; $i < count($id_already_associated_p); $i++) {
                        $id_projects_added[]=$id_already_associated_p[$i][0];
                    }
                }

                // To finally add them
                if ($id_projects_added[0]!="") {
                    $new_nb_of_project = count($id_projects_added);
                    for ($i=0; $i < $new_nb_of_project ; $i++) {
                        $query_add = "INSERT INTO link_project_users
                        VALUES (".$id_projects_added[$i].", ".$id_user_account.")";
                        $query_result_add = pg_query($connex,$query_add) or die (pg_last_error() );
                    }
                }


            }
        ?>


        <form name="account_monitoring" action="US_1.21_account_monitoring.php" onsubmit="return valider()" method="GET">
            <BR/>

            <?php
                // Query to get all information needed from user_account
                $result= pg_query($connex, "SELECT last_name, first_name, company, address, postcode, city, country, email, phone, website FROM user_account WHERE id_user_account = $id_user_account");
                $row = pg_fetch_row($result);

                // Then present all the info properly in a table
                echo '<div class="container" align="center">

                <div class="input-group mb-3">

                    <div class="input-group-prepend">
                        <span class="input-group-text"> (*) Last name : </span>
                    </div>
                    </br>
                    <input type="text" size = "50" name="last_name" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[0].' ">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> (*) First name : </span>
                        </div>
                        </br>
                        <input type="text" size = "50" name="first_name" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[1].'">
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text"> Company : </span>
                      </div>
                    </br>
                    <input type="text" size = "50" name="company" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[2].'">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Address : </span>
                        </div>
                        </br>
                        <input type="text" size = "50" name="address" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[3].'">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text"> Postcode : </span>
                        </div>
                        </br>
                        <input type="text" size = "50" name="postcode" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[4].'">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> City : </span>
                        </div>
                        </br>
                        <input type="text" size = "50" name="city" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[5].'">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Country : </span>
                        </div>
                        </br>
                        <input type="text" size = "50" name="country" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[6].'">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Email address : </span>
                        </div>
                        </br>
                        <input type="text" size = "50" name="email" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[7].'">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Telephone number : </span>
                        </div>
                        </br>
                        <input type="text" size = "50" name="phone" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[8].'">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Company website : </span>
                        </div>
                        </br>
                        <input type="text" size = "50" name="website" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[9].'">
                    </div>
                    <input type="hidden" size = "50" name="id_user_account" value="'.$id_user_account.'">
                  </div>
                </div>';
            ?>
</div>
            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <script type="text/javascript">
            // Here are all the Ajax functions that will be used to associate/remove/delete projects of the user

                function addproject2(){
                // Add project into the span "associated project" in two steps

                     //First adding into the span
                     $.ajax({

                         type: 'get',
                         dataType: 'html',
                         url: 'majprojectproposition_account_monitoring.php',
                         timeout: 1000,
                         data: {
                            id_project_value_am: document.account_monitoring.project_list.value
                         },
                         //var id_project_value = document.account_creation.list_user_type.value
                         success: function (response) {
                           document.getElementById("associated_project").innerHTML=response;
                         },
                         error: function () {
                           alert('Query has failed');
                         }
                      });

                     // Secondly removing it from the datalist
                     $.ajax({

                         type: 'get',
                         dataType: 'html',
                         url: 'remove_project_from_datalist_account_monitoring.php',
                         timeout: 1000,
                         data: {
                           id_project_erase_am: document.account_monitoring.project_list.value
                           },
                         success: function (response) {
                           document.getElementById("list_projects_a").innerHTML=response;
                           },
                         error: function () {
                           alert('Query has failed');
                         }
                     });

                  }

                  function deleteproject1(str){
                  // Delete a project from the table of already associated files in two steps

                      // First, removing it from the table
                      $.ajax({
                    			type: 'get',
                    			dataType: 'html',
                    			url: 'delete_project_account_monitoring.php',
                    			timeout: 1000,
                    			data: {
                    				    id_project_to_delete:str
                    			},
                    			success : function(response){
                                    document.getElementById("associated_projects_before").innerHTML=response;
                    			},
                    			error: function () {
                    				alert('Query has failed');
                    			}
                  		});

                      //Then re-adding it to the datalist
                      $.ajax({
                          type: 'get',
                          dataType: 'html',
                          url: 'reinject_project_datalist_account_monitoring_from_delete.php',
                          timeout: 1000,
                          data: {
                            id_project_to_add_from_delete:str
                            },
                          success: function (response) {
                            document.getElementById("list_projects_a").innerHTML=response;
                            },
                          error: function () {
                            alert('Query has failed');
                          }
                      });

                   }

                  function removeproject2(str){
                  // When you add a project into the span you add a button "remove"
                  // This function removes a project from this span in two steps

                        //First it to remove it from the span
                        $.ajax({
                            type: 'get',
                            dataType: 'html',
                            url: 'majremoveproject_account_monitoring.php',
                            timeout: 1000,
                            data: {
                              id_project_value_rm:str
                            },
                            success: function (response) {
                                document.getElementById("associated_project").innerHTML=response;
                            },
                            error: function () {
                                alert('Query has failed');
                            }
                        });

                        // Then, re-add it into the datalist
                        $.ajax({
                            type: 'get',
                            dataType: 'html',
                            url: 'reinject_project_datalist_from_remove_account_monitoring.php',
                            timeout: 1000,
                            data: {
                                id_project_to_add_am:str
                            },
                            success: function (response) {
                                document.getElementById("list_projects_a").innerHTML=response;
                            },
                            error: function () {
                                alert('Query has failed');
                            }
                        });

                  }

              </script><div align="center">

              <?php
              // Now creation of the table of already associated projects
              $query_already_associated_project = "SELECT lpu.id_project, name_project
                                                      FROM link_project_users lpu
                                                        JOIN projects p on lpu.id_project = p.id_project
                                                          WHERE lpu.id_user_account = $id_user_account";
              $result_already_associated_project = pg_query($connex, $query_already_associated_project) or die ("Failed to fetch user accounts");
              $tab = new Tab_donnees($result_already_associated_project,"PG");
              $tab_associated_project = $tab->t_enr;
              $_SESSION["already_associated_projects"]=$tab_associated_project;

              $nb_rows = pg_num_rows($result_already_associated_project);


              echo '<fieldset style="width: 180px">
              <input class="form-control" type="text" placeholder="Associated project(s) :" readonly>
              </fieldset>
                <span id="associated_project"></span></p>
              <BR/>';
// Julien Lorriette : Problème d'Ajax avec la fonction addprojet2 qui appelle une donnée "associated_project" qui n'est présente nulle part !
// Elle était dans un <span> avant bootsraping, sans aucune valeur de donnée : à corriger (aucune idée de ce que cette donnée est censée être utile pour...)
              echo'<div id="associated_projects_before" class= "col-md-6">';
                  echo '<table>';
                      for ($i=0; $i < $nb_rows ; $i++) {
                        echo '<tr>';
                            echo '<td> Projet '.$tab_associated_project[$i][0].' : '.$tab_associated_project[$i][1].' </td> <td> <button type="button" name="delete_project" class= "btn btn-outline-danger" onclick=deleteproject1('.$tab_associated_project[$i][0].')>Delete </button></td>';
                        echo '</tr>';
                      }
                  echo '</table>';
              echo '</div>';

              ?>

              <?php
              // Then creation of the datalist

              $query_project = "SELECT id_project, name_project
                                  FROM projects
                                    WHERE id_project NOT IN (SELECT id_project FROM link_project_users WHERE id_user_account = $id_user_account )";
              $result_project = pg_query($connex, $query_project) or die ("Failed to fetch user accounts");
              $tab = new Tab_donnees($result_project,"PG");
              $table_project_2 = $tab->t_enr;
              $_SESSION["not_associated_projects_account_monitoring"] = $table_project_2;
              $nb_rows = pg_num_rows($result_project);

              echo "</BR>";

              echo '<fieldset style="width: 400px">
              <input class="form-control" type="text" placeholder="Add a new project to this user :" readonly>
              </fieldset>';

              echo'<div id="list_projects_a" class="col-md-6">';

                  echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
                      //div ou span ici à rafraichir en fonction des remove et add
                      echo '<datalist id="project_choice">';
                            for ($k = 0; $k<$nb_rows;$k++ ){
                                echo '<option value="'.$table_project_2[$k][0].'"> Project '.$table_project_2[$k][0].' : '.$table_project_2[$k][1].' </option>';
                            }
                      echo '</datalist>';
                  echo '<button type="button" value="Add a project" class="btn btn-md btn-outline-warning" name="addproject" onclick=addproject2()>Add a project</button>';
              echo '</div>';




              ?>






              <button type="submit" class="btn btn-outline-success" name="modify_account">Modify user account</button>

        </form></div>
      	<?php
      			 include("pied_de_page.php");
      	?>
    </body>
</html>
