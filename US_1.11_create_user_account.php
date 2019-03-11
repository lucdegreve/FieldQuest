<?php
    if(!isset($_GET["createaccount"])){
        if(isset($_SESSION["id_project_list"])){
            unset($_SESSION["id_project_list"]);
       }
    }

?>

<!--
       US1-11 Create user account
Developped by Adrien
This page contains the form to create a new account.
Needed/called pages : 	tab_donnees.class.php, funct_connex.php,
            majprojectproposition.php
            majremoveproject.php
            reinject_project_datalist_create_account.php
            remove_project_from_datalist_create_account.php

Input variables : 		$id_user_account,

Output variables :
		name of the form : account_creation
		variables submitted in the form : All the ones from user_account + the id of linked projects

Description :
In this script we create an account to fill the table "user_account" in the database.
Verifying that needed fields (such as name or first_name) are checked with Javascript function
This part is not difficult BUT
We need to associate project if the admin want to do so
So we have to create dynamic list of project to add or to remove, what we do with 4 Ajax functions

------------------------------------------------------------->

<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title> User account creation </title>
        <!-- Create a user account, by Guillaume and Adrien -->
        <link rel = "stylesheet" href ="css/bootstrap.min.css">
        <link rel = "stylesheet" href ="css/custom.css">
    </head>

    <body>
    		<?php
    				 include("en_tete.php");
    		?>
	</br>
	<?php if (isset($_GET["createaccount"])){
		if (isset($_GET["last_name"],$_GET["first_name"])){
			echo "<div class='alert alert-success'>The user account has been correctly created. A confirmation e-mail has been sent.</div>";
		}
	}?>
	<div class="container">
		<form method="GET"  action="US1-10_Gerer_comptes.php">
			<button type="submit" class="btn btn-outline-info btn-md">Back</button>
		</form>


		<div align="center">
			<h2>Please fill all the information</h2>
		</div>
        <BR/>
        <strong>NB : All the fields with (*) must be filled</strong>

        <!-- Function valider(), verify for each need field if it is filled. If not, warning message appears -->
        <script type="text/javascript">


                function valider(){
                  var c = 0 ;
                  var msg = "" ;

                if (document.account_creation.list_user_type.value == "") {
                      c = 1 ;
                      msg = msg + "Please enter the user type \n" ;
                }
                if (document.account_creation.last_name.value == "") {
                      c = 1 ;
                      msg = msg + "Please enter the last name \n" ;
                }
                if (document.account_creation.first_name.value == "") {
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

        <!-- Now we create the form to be filles -->
        <div align="center">
        <form name="account_creation" action="US_1.11_create_user_account.php" onsubmit="return valider()" method="GET">
                <Br/>

                <!-- Important php, all the info that are needed further -->
                <?php

                    // Connexion to class file and connexion file
                    require "tab_donnees/tab_donnees.class.php";
                    require "tab_donnees/funct_connex.php";
                    // Variables needed for connexion
                    $con = new Connex();
                    $connex = $con->connection;

                ?>

                <!-- Table creation -->


                    <!-- Here is a table of all the fields admin have to fill -->
                    <!-- Attention à l'identifiant utilisateur ?? -->


                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text"> User type : </span>
                      </div>
                          <?php
                                // When you create an account you need to choose if it is an admin, an intern user or an extern user
                                // Query to get all information from user_type to make a list of user_type.
                                // With this admin will choose between three possibilities what type of user the account is for
                                $result= pg_query($connex, "SELECT * FROM user_type");
                                $tab = new Tab_donnees($result,"PG");
                                // Here is the list of user types
                                $tab->creer_liste_option_plus ("list_user_type", "id_user_type", "name_user_type");
                          ?>
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> (*) Last name : </span>
                          </div>
                          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="last_name" value=""> </td>
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> (*) First name : </span>
                          </div>
                          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default"  name="first_name" value="">
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> Company : </span>
                          </div>
                          </br><input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="company" value="">
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> Address : </span>
                          </div>
                          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="address" value="">
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> Postcode : </span>
                          </div>
                          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="postcode" value=""> </td>
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> City : </span>
                          </div>
                          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="city" value=""> </td>
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> Country : </span>
                          </div>
                          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default"  name="country" value=""> </td>
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> Email address : </span>
                          </div>
                          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default"  name="email" value=""> </td>
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> Telephone number : </span>
                          </div>
                          <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="phone" value=""> </td>
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> Company website : </span>
                          </div>
                      <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="website" value=""> </td>
                      </div>


                      <BR/>

                <!-- Following php is to implement for the first time the datalist that will be used to associate
                projects to the user -->

                <?php
                    // Session variable

                    $id_user_account = $_SESSION["id_user_account"];

                    $query_project = "SELECT id_project, name_project
                  	                   FROM projects";
                  	$result_project = pg_query($connex, $query_project) or die ("Failed to fetch user accounts");
                  	$tab = new Tab_donnees($result_project,"PG");
                    $table_project = $tab->t_enr;

                    $_SESSION["not_associated_projects"]=$table_project; // We put the result in $_SESSION
                    //because we need it in Ajax functions


                    $nb_rows = pg_num_rows($result_project);
                    
                    echo '<fieldset style="width: 400px">
                    <input class="form-control" type="text" placeholder="Please choose the project(s) this user will work on :" readonly>
                    </fieldset>';

                    echo'<div id="list_projects_a" class="col-md-6">';

                        echo '<input list="project_choice" type="text" id="project_list" autocomplete = "off">';
                            //div ou span ici à rafraichir en fonction des remove et add
                            echo '<datalist id="project_choice">';
                                  for ($k = 0; $k<$nb_rows;$k++ ){
                                      echo '<option value="'.$table_project[$k][0].'"> Project '.$table_project[$k][0].' : '.$table_project[$k][1].' </option>';
                                  }
                            echo '</datalist>';
                        echo '<button type="button" class="btn btn-md btn-outline-warning" name="addproject" onclick=addproject1()>Add a project</button>';
                    echo '</div>';
                ?>

                <!--  Beginning of Ajax functions -->

                <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                <script type="text/javascript">

                function addproject1(){
                    // This function associates a project to an user with two steps

                       // First part of this function add a project in the span "associated project"
                    		$.ajax({

                                  type: 'get',
                            			dataType: 'html',
                            			url: 'majprojectproposition.php',
                            			timeout: 1000,
                                  data: {
                                        id_project_value: document.account_creation.project_list.value
                            			},

                                  success: function (response) {
                            			     document.getElementById("associated_project").innerHTML=response;
                            			},
                            			error: function () {
                            			     alert('Query has failed');
                            			}
                    		      });

                        // Second part of this function remove the project added from the datalist
                        $.ajax({
                            			type: 'get',
                            			dataType: 'html',
                            			url: 'remove_project_from_datalist_create_account.php',
                            			timeout: 1000,
                            			data: {
                            			     id_project_erase: document.account_creation.project_list.value
                            			},
                            			success: function (response) {
                            			     document.getElementById("list_projects_a").innerHTML=response;
                            			},
                            			error: function () {
                            				    alert('Query has failed');
                            			}
                            	});

                        }

                function removeproject1(str){
                // When you add a project, a remove button is also added allowing you to remove the project just added
                // This function allows us to remove it in two steps

                        //First step remove the button
                        $.ajax({

                                  type: 'get',
                                  dataType: 'html',
                                  url: 'majremoveproject.php',
                                  timeout: 1000,
                                  data: {
                                      id_project_value:str
                                  },

                                  success: function (response) {
                                        document.getElementById("associated_project").innerHTML=response;
                                  },
                                  error: function () {
                                        alert('Query has failed');
                                  }
                              });

                        // Second step reinject the project in the datalist
                        $.ajax({
                                  type: 'get',
                                  dataType: 'html',
                                  url: 'reinject_project_datalist_create_account.php',
                                  timeout: 1000,
                                  data: {
                                      id_project_to_add:str
                                  },
                                  success: function (response) {
                                    document.getElementById("list_projects_a").innerHTML=response;
                                  },
                                  error: function () {
                                    alert('Query has failed');
                                  }
                              });

                      }

                </script>

              </BR></br>
                <fieldset style="width: 180px">
                <input class="form-control" type="text" placeholder="Associated project(s) :" readonly>
                </fieldset>
                  <span id="associated_project"></span></p>
                <BR/>
				<div align="center">
					<button type="submit" name="createaccount" class="btn btn-lg btn-outline-success">Create account</button>
				</div>
                <BR/>
        </form>
	</div>

        <!-- After submitting this form, issset verifies if first name and last name are filled, if so, data are loaded in the database -->
        <?php
            //if (isset($_GET["last_name"],$_GET["first_name"]))
				if (isset($_GET["createaccount"]))
            {
                $user_type = $_GET["list_user_type"];
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

                // From the first name we want to have the first letter to create a login that is first letter of first name + last name (ccochais for Chloé Cochais for exemple)
                $length_fn = strlen($first_name);
                $substr_fn = substr($first_name, -$length_fn, 1);

                // Function generating a random password
                function password($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789')
                {
                    $nb_lettres = strlen($chaine) - 1;
                    $generation = '';
                    for($i=0; $i < $nb_car; $i++)
                    {
                        $pos = mt_rand(0, $nb_lettres);
                        $car = $chaine[$pos];
                        $generation .= $car;
                    }
                    return $generation;
                }
                // Generating a password of 12 caracters
                $password = password(12, $chaine = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPMLKJHGFDSQWXCVBN123456789');


                // Query to update database
                $query = "INSERT INTO user_account(id_user_type, last_name, first_name, address, postcode, city, country, email, phone, company, website, login, password)
                              VALUES ('".$user_type."','".$last_name."','".$first_name."','".$address."',
                                            '".$postcode."','".$city."','".$country."','".$email."','".$phone."','".$company."',
                                                  '".$website."','".$substr_fn.$last_name."','".$password."')";
                $query_result = pg_query($connex,$query) or die (pg_last_error() );

                // Adding project to the user created

                // Getting the id created
                $query_id_user_account = "SELECT MAX(id_user_account)
                                            FROM user_account";
                $result_id_user_account = pg_query($connex, $query_id_user_account) or die ("Failed to fetch user accounts");
                $tab_iu = new Tab_donnees($result_id_user_account,"PG");
                $table_id_user = $tab_iu->t_enr;
                $new_id_user = $table_id_user[0][0];

                // Adding the projects
                $tab_id_project_assiocated = $_SESSION["id_project_list"];
				if ($tab_id_project_assiocated[0]!= ""){
					$nb_projects = count($tab_id_project_assiocated);
					for ($i=0; $i < $nb_projects ; $i++) {
						$query_add = "INSERT INTO link_project_users
						VALUES (".$tab_id_project_assiocated[$i].", ".$new_id_user.")";
						$query_result_add = pg_query($connex,$query_add) or die (pg_last_error() );
					}
				}

                if(isset($_SESSION["id_project_list"])){
                // Once user created we need to destroy session list to create another account
                    unset($_SESSION["id_project_list"]);
                }
            }
        ?>
      </div>
    		<?php
    				 include("pied_de_page.php");

    		?>

    </body>
</html>
