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

        <strong> Please fill all the information </strong>
        <BR/>
        <BR/>

        NB : All the fields with (*) must be filled

        <!-- Function valider(), verify for each field if it is filled. If not, warning message appears -->
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

        <form name="account_creation" action="US_1.11_create_user_account.php" onsubmit="return valider()" method="GET">
                <br/>

                <!-- Important php, all the info that are needed further -->
                <?php

                    // Connexion to class file and connexion file
                    require "tab_donnees/tab_donnees.class.php";
                    require "tab_donnees/funct_connex.php";
                    // Variables needed for connexion
                    $con = new Connex();
                    $connex = $con->connection;

                    // Query to get all information from user_type to make a list of user type.
                    // With this admin will choose between three possibilities what type of user the account is for
                    $result= pg_query($connex, "SELECT * FROM user_type");
                    $tab = new Tab_donnees($result,"PG");

                ?>

                <!-- Table creation -->
                <table>
                    <!-- Here is a table of all the fields admin have to fill -->
                    <!-- Attention à l'identifiant utilisateur ?? -->
                    <tr>
                        <td> (*) User type </td><td>
                          <?php
                                // Here is the list of user types
                                $tab->creer_liste_option_plus ("list_user_type", "id_user_type", "name_user_type");
                          ?>
                    </td>
                    </tr>
                    <tr>
                        <td> (*) Last name </td><td> <input type="text" size = "50" name="last_name" value=""> </td>
                    </tr>
                    <tr>
                        <td> (*) First name </td><td> <input type="text" size = "50"  name="first_name" value=""> </td>
                    </tr>
                    <tr>
                        <td> Company </td><td> <input type="text" size = "50"  name="company" value=""> </td>
                    </tr>
                    <tr>
                        <td> Address </td><td> <input type="text" size = "50"  name="address" value=""> </td>
                    </tr>
                    <tr>
                        <td> Postcode </td><td> <input type="text" size = "50"  name="postcode" value=""> </td>
                    </tr>
                    <tr>
                        <td> City </td><td> <input type="text" size = "50"  name="city" value=""> </td>
                    </tr>
                    <tr>
                        <td> Country </td><td> <input type="text" size = "50"  name="country" value=""> </td>
                    </tr>
                    <tr>
                        <td> Email </td><td> <input type="text" size = "50"  name="email" value=""> </td>
                    </tr>
                    <tr>
                        <td> Phone number </td><td> <input type="text" size = "50"  name="phone" value=""> </td>
                    </tr>
                    <tr>
                        <td> Company website </td><td> <input type="text" size = "50" name="website" value=""> </td>
                    </tr>
                </table>
                <BR/>
                <input type="submit" name="createaccount" value="Create account">
        </form>

        <!-- After submitting this form, issset verifies if first name and last name are filled, if so, data are loaded in the database -->
        <?php
            if (isset($_GET["last_name"],$_GET["first_name"]))
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

                // Function generating a password
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
                '".$postcode."','".$city."','".$country."','".$email."','".$phone."','".$company."','".$website."','".$substr_fn.$last_name."','".$password."')";
                $query_result = pg_query($connex,$query) or die (pg_last_error() );

                echo "User account have been correctly created and inserted into the database";
            }
        ?>
        
    		<?php
    				 include("pied_de_page.php");
    		?>
  </body>
</html>
