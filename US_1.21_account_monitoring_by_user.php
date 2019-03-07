
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title> Account monitoring </title>
        <!-- Account monitoring by Adrien -->
        <link rel = "stylesheet" href ="css/bootstrap.min.css">
        <link rel = "stylesheet" href ="css/custom.css">
    </head>

    <body>
    
        <?php
              include("en_tete.php");
        ?>
        <div class='container'>
       <form action="US0_page_accueil_externes.php">
            <button name="return" class="btn btn-outline-info" type="submit">back</button>
        <BR/>
        <h1> Here are your profile information </h1>
        <BR/>
        <?php
              $id_user = $_SESSION["id_user_account"]; //Variable session started while connecting the first time
              // For now I will use this one --> it has to be removed when Session start is working !
              //$id_user_account = 1;
              require "tab_donnees/tab_donnees.class.php";
              require "tab_donnees/funct_connex.php";
              // Variables needed for connexion
              $con = new Connex();
              $connex = $con->connection;

              if(isset($_GET['change_info']) AND $_GET['change_info']=='Change your information')
              {
                      // Session variable

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
                              SET   company = '".$company."', address = '".$address."', postcode = '".$postcode."', city = '".$city."', country = '".$country."',
                              email = '".$email."', phone = '".$phone."', website = '".$website."'
                              WHERE id_user_account = '".$id_user."'";
                    $query_result = pg_query($connex,$query) or die (pg_last_error() );
                    echo "</br>";
                    echo "Data have been correctly inserted into database";
              }
          ?>
          <form name="account_monitoring_user" action="US_1.21_account_monitoring_by_user.php" method="GET">
          <?php

                // Query to get all information needed from user_account
                $result= pg_query($connex, "SELECT last_name, first_name, company, address, postcode, city, country, email, phone, website FROM user_account WHERE id_user_account = $id_user");
                $row = pg_fetch_row($result);

                // Then present all the info properly in a table
                echo '<table>';
                echo '<tr>';
                echo '<td> Last name  </td> <td> '.$row[0].' </td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td> First name </td><td> '.$row[1].' </td>';
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
          ?>
              <button type="submit" class="btn btn-outline-success" name="change_info">Change your information</button>
          </form>

          <form name="account_monitoring_user" action="US_1.21_p2_change_password.php" method="GET">
              <input type="submit" name="change_password" value="Change your password">
          </form>

        	<?php
        			 include("pied_de_page.php");
        	?>
    </div>
    </body>
</html>
