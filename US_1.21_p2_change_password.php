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

        <script type="text/javascript">
        // Function change_password, verify if the old password is correct and the new is correctly created (identical in two different fields)

        function changepassword(){
          var c = 0 ;
          var msg = "" ;
        if (document.password_change.old_password.value != document.password_change.true_password.value) {
             c = 1 ;
             msg = msg + "You did not put the good old password, please do it again \n" ;
        }
        if (document.password_change.new_password.value != document.password_change.password_verif.value) {
              c = 1 ;
              msg = msg + "New password can not be created \n Please verify that 'New password' and 'Verify password' are identical" ;
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
        <strong> Change your password </strong>
        <BR/>
        <BR/>
        <form name="password_change" action="US_1.21_p2_change_password.php"  onsubmit="return changepassword()" method="GET">
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

        ?>

        <?php
        if (isset($_GET["new_password"]))
        {
        $new_password = $_GET["new_password"];

        // Query to update database
        $query = "UPDATE user_account
                  SET password = '".$new_password."'
                  WHERE id_user_account = '".$id_user_account."'";
        $query_result = pg_query($connex,$query) or die (pg_last_error() );

        echo "Your password has correctly been changed";
        }
        ?>

        <?php

        // Query to get all information needed from user_account
        $result= pg_query($connex, "SELECT password FROM user_account WHERE id_user_account = $id_user_account");
        $row = pg_fetch_row($result);

        // Then it presents all the info properly in a table
        echo '<table>';
        echo '<tr>';
        echo '<td> Old password  </td><td><input type="text" size = "50"  name="old_password" value=""> </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> New password </td><td><input type="text" size = "50"  name="new_password" value=""> </td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> Verify password </td><td><input type="text" size = "50"  name="password_verif" value=""> </td>';
        echo '</tr>';
        echo '</table>';

        echo '<input type="hidden" size = "50"  name="true_password" value='.$row[0].'>';

        echo '<BR/>';
        echo '<input type="submit" name="change_password" value="Change your password">';
        echo '</form>';
        ?>

        <form action = "US_1.21_account_monitoring_by_user.php" method = "POST" name = "Return">
        <input type = "submit" value = "Return">
        </form>

    		<?php
    				 include("pied_de_page.php");
    		?>
  </body>
</html>
