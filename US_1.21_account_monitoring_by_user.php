
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
			  echo "</br>";
        ?>
        <div class='container'>
		<?php
		if($_SESSION['id_user_type']==3){
			echo'<form action="US0_page_accueil_externes.php">';
				echo'<button name="return" class="btn btn-outline-info" type="submit">Back</button>';
			echo'</form>';
		}
		else{
			if($_SESSION['id_user_type']==1){
				echo'<form action="US0_page_accueil_admin.php">';
					echo'<button name="return" class="btn btn-outline-info" type="submit">Back</button>';
				echo'</form>';
			}
			else {
				echo'<form action="US0_page_accueil_internes.php">';
					echo'<button name="return" class="btn btn-outline-info" type="submit">Back</button>';
				echo'</form>';
			}
		}
		?>
		<div align="center">
			<h2> Here are your profile information </h2>
    </div>
		</br>

        <?php
              $id_user = $_SESSION["id_user_account"]; //Variable session started while connecting the first time
              // For now I will use this one --> it has to be removed when Session start is working !
              //$id_user_account = 1;
              require "tab_donnees/tab_donnees.class.php";
              require "tab_donnees/funct_connex.php";
              // Variables needed for connexion
              $con = new Connex();
              $connex = $con->connection;

              if(isset($_GET['change_info']))
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

              }
          ?>
          <form name="account_monitoring_user" action="US_1.21_account_monitoring_by_user.php" method="GET">
          <?php

                // Query to get all information needed from user_account
                $result= pg_query($connex, "SELECT last_name, first_name, company, address, postcode, city, country, email, phone, website FROM user_account WHERE id_user_account = $id_user");
                $row = pg_fetch_row($result);

                // Then present all the info properly in a table
                echo '

                <div class="input-group mb-3">

                    <div class="input-group-prepend">
                        <span class="input-group-text"> (*) Last name : </span>
                    </div>
                    </br>
                    <input type="text"  name="last_name" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="'.$row[0].' ">
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


                </div>';
          ?>
          </div>
          </div>
        </br>
      <div class="container">
		  <div class="row" align="center">
			<div class="col-md-4">
				<button type="submit" class="btn btn-outline-success btn-block" name="change_info"><font size=2>Change your information</font></button>
			</div>
          </form>

          <?php
              if(isset($_GET['change_info'])){
                  echo "Database have been correctly updated";
              }
          ?>
		<div class="col-md-4">
          <form name="account_monitoring_user" action="US_1.21_p2_change_password.php" method="GET">
              <button type="submit" name="change_password" class="btn btn-outline-warning btn-block"><font size=2>Change your password</font></button>
          </form>
		</div>

		<div class="col-md-4">
			<form name="delete_account_user" method="POST" action="US_1.22_p2_delete_account.php">
				<button type="submit" class="btn btn-md btn-danger btn-block" ><font size=2>Delete my account</font></button>
			</form>
		</div>

		</div>

    </div>
    </body>
    <?php
        			 include("pied_de_page.php");
        	?>
</html>
