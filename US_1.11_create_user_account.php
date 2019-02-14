<html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title> User account creation </title>
      <!-- Create a user account, by Guillaume and Adrien -->
    </head>
    <body>
        <strong> Please fill all the information </strong>
        <BR/>
        <BR/>

        NB : All the fields with (*) must be filled

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

        <form name="account_creation" action="US_1.11_p1.php" onsubmit="return valider()" method="GET">
        <br/>
        <?php
        //$connection = pg_connect("host=localhost port=5432 dbname=base_exo2 user=postgres password=postgres")or die ("Connexion impossible");
        require "tab_donnees/tab_donnees.class.php";
        require "tab_donnees/funct_connex.php";

        $con = new Connex();
        $connex = $con->connection;

        $result= pg_query($connex, "SELECT * FROM user_type");
        $tab = new Tab_donnees($result,"PG");

        ?>

        <table>
        <!-- Attention à l'identifiant utilisateur ?? -->
        <tr>
        <td> (*) User type </td><td>
          <?php
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

        $length_fn = strlen($first_name);
        $substr_fn = substr($first_name, -$length_fn, 1);

        // Génération d'une chaine aléatoire
        function chaine_aleatoire($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789')
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
        $password = chaine_aleatoire(12, $chaine = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPMLKJHGFDSQWXCVBN123456789');

        //$dbconn = pg_connect("host=localhost dbname=bdd_geosys user=postgres password=mdpPG2019") or die ("Connexion impossible");
        // Detail de la requete
        $query = "INSERT INTO user_account(id_user_type, last_name, first_name, address, postcode, city, country, email, phone, company, website, login, password)
        VALUES ('".$user_type."','".$last_name."','".$first_name."','".$address."',
        '".$postcode."','".$city."','".$country."','".$email."','".$phone."','".$company."','".$website."','".$substr_fn.$last_name."','".$password."')";

        //execute la requete dans le moteur de base de donnees
        $query_result = pg_query($dbconn,$query) or die (pg_last_error() );

        echo "Data have been correctly inserted into database";
      }
        ?>


      </body>
    </html>

  </body>
</html>
