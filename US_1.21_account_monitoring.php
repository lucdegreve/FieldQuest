<?php
     session_start();
?>

<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title> Account monitoring </title>
        <!-- Account monitoring by Adrien -->
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

        <BR/>
        <!-- Form to go to the account manage page -->
        <form name='backtomanageaccounts' method='GET' action='US1-10_Gerer_comptes.php'>
            <button type='submit' class='btn btn-info' name='back'>Back to accounts</button>
	</form>
        
        <strong> Here are your profile information </strong>
        <BR/>
        <BR/>
        Fields with (*) must be filled

        <?php
            // Session variable
            //$id_user_account = $_SESSION["id_user_account"]; //Variable session started while connecting the first time
            // For now I will use this one --> it has to be removed when Session start is working !
            //$id_user_account = 1;
            
            // id of the clicked user
            $id_user_account = $_GET['id_user_account'];

            // Connexion to class file and connexion file
            require "tab_donnees/tab_donnees.class.php";
            require "tab_donnees/funct_connex.php";
            // Variables needed for connexion
            $con = new Connex();
            $connex = $con->connection;
        ?>

        <?php
        if (isset($_GET["last_name"],$_GET["first_name"]))
        {
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

            // Query to update database
            $query = "UPDATE user_account
                      SET last_name = '".$last_name."', first_name = '".$first_name."',  company = '".$company."',
                      address = '".$address."', postcode = '".$postcode."', city = '".$city."', country = '".$country."',
                      email = '".$email."', phone = '".$phone."', website = '".$website."'
                      WHERE id_user_account = '".$id_user_account."'";
            $query_result = pg_query($connex,$query) or die (pg_last_error() );
            echo "</BR>";
            echo "</BR>";
            echo "Data have been correctly inserted into database";
        }
        ?>
        <form name="account_monitoring" action="US_1.21_account_monitoring.php" onsubmit="return valider()" method="GET">
            <BR/>

            <?php
                // Query to get all information needed from user_account
                $result= pg_query($connex, "SELECT last_name, first_name, company, address, postcode, city, country, email, phone, website FROM user_account WHERE id_user_account = $id_user_account");
                $row = pg_fetch_row($result);

                // Then present all the info properly in a table
                echo '<table>';
                    echo '<tr>';
                        echo '<td> (*) Last name  </td> <td> <input type="text" size = "50" name="last_name" value="'.$row[0].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> (*) First name </td><td> <input type="text" size = "50" name="first_name" value="'.$row[1].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> Company </td><td> <input type="text" size = "50" name="company" value="'.$row[2].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> Address </td><td> <input type="text" size = "50" name="address" value="'.$row[3].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> Postcode </td><td> <input type="text" size = "50" name="postcode" value="'.$row[4].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> City </td><td> <input type="text" size = "50" name="city" value="'.$row[5].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> Country </td><td> <input type="text" size = "50" name="country" value="'.$row[6].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> Email </td><td> <input type="text" size = "50" name="email" value="'.$row[7].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> Phone number </td><td> <input type="text" size = "50" name="phone" value="'.$row[8].'"> </td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td> Company website</td><td> <input type="text" size = "50" name="website" value="'.$row[9].'"> </td>';
                    echo '</tr>';
                echo '</table>';
                
                echo '<input type="hidden" name="id_user_account" value="'.$id_user_account.'"></input>';
            ?>

            <BR/>
            <input type="submit" name="modify_account" value="Modify user account">
        </form>
      	<?php
      			 include("pied_de_page.php");
      	?>
    </body>
</html>
