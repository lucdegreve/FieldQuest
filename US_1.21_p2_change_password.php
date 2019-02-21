<?php
     session_start();
?>
<html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title> Password change </title>
      <!-- Password change by Adrien -->
      <link rel = "stylesheet" href ="css/bootstrap.min.css">
      <link rel = "stylesheet" href ="css/custom.css">
    </head>
    <body>

		<?php
				 include("en_tete.php");
		?>

        <BR/>
        <strong> Change your password </strong>
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
        $result= pg_query($connex, "SELECT password FROM user_account WHERE id_user_account = $id_user_account");
        $row = pg_fetch_row($result);

        // Then present all the info properly in a table
        echo '<table>';
        echo '<tr>';
        echo '<td> Password  </td> <td> '.$row[0].' </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> New password </td><td><input type="text" size = "50"  name="adresse" value=""> </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> Verify password </td><td><input type="text" size = "50"  name="adresse" value=""> </td>';
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
