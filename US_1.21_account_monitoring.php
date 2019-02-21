<?php
     session_start();
?>
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

        <BR/>
        <strong> Here are your profile information </strong>
        <BR/>
        <BR/>
        <form name="account_creation" action="US_1.21_p2_change_password.php" method="GET">
        <BR/>

        <?php

        // Session variable
        $id_user_account = $_SESSION["id_user_account"]; //Variable session started while connecting the first time
        // For now I will use this one --> it has to be removed when Session start is working !
        $id_user_account = 1;


        // Connexion to class file and connexion file
        require "tab_donnees/tab_donnees.class.php";
        require "tab_donnees/funct_connex.php";
        // Variables needed for connexion
        $con = new Connex();
        $connex = $con->connection;

        // Query to get all information needed from user_account
        $result= pg_query($connex, "SELECT last_name, first_name, company, address, postcode, city, country, email, phone, website FROM user_account WHERE id_user_account = $id_user_account");
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
        echo '<td> Company </td><td> '.$row[2].' </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> Address </td><td> '.$row[3].' </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> Postcode </td><td> '.$row[4].' </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> City </td><td> '.$row[5].' </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> Country </td><td> '.$row[6].' </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> Email </td><td> '.$row[7].' </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> Phone number </td><td> '.$row[8].' </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> Company website</td><td> '.$row[9].' </td>';
        echo '</tr>';
        echo '</table>';


        echo '<BR/>';
        echo '<input type="submit" name="change_password" value="Change your password">';
        echo '</form>';
        ?>

		<?php
				 include("pied_de_page.php");
		?>
  </body>
</html>
