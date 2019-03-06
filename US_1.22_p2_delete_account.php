<?php
    
?>
<html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title> Delete account </title>
      <!-- Delete account by Guillaume & Eva -->
      <!-- bouton d'accès à la page de suppression sur US_1.21_account_monitoring_by_user -->
      <!-- 
      REMARQUE IMPORTANTE :
      Pour que la page php marche, aller dans le fichier php.ini de WAMP
      Faire un CTRL+F [mail function]
      modifier la ligne ";SMTP = localhost" par "SMTP = sauternes.agro-bordeaux.fr"
      modifier la ligne ";sendmail_from ="admin@wampserver.invalid"" par "sendmail_from ="une adresse agro-bordeaux.fr existante"" 
      -->
      <link rel = "stylesheet" href ="bootstrap.min.css">
      <link rel = "stylesheet" href ="custom.css">
    </head>
    
<body>

    		<?php
    				 include("en_tete.php");
    				 
    		?>

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
		$query = "SELECT last_name, first_name FROM user_account WHERE id_user_account = ".$id_user_account." ";
        $result = pg_query($connex,$query) or die (pg_last_error() );
        $donnees = pg_fetch_array($result);
        ?>


<!-- Message to check if the user really want to delete his account -->
<div class="container-fluid">

	<br/><br/><br/>
	<div class="row">
		<div class="col-3">
		</div>
		<div class="col-6">
			<div class="card text-center">
			  <div class="card-body">
			    <h5 class="card-title">Do you really want to delete your account ?</h5>
			    <p class="card-text"> 
			    	<div class="row">
			    		<div class="col-4">
						</div>
				    	<div class="col-2">
						    <form name="suppr" action="US_1.22_p2_delete_account.php" method="GET">
			              		<input type="submit" name="delete" value="Yes">
			         		</form>
			         	</div>
			         	<div class="col-2">
			         		<form name="return" action="US_1.21_account_monitoring_by_user.php" method="GET">
			              		<input type="submit" name="return" value="No / Return">
			         		</form>
	         			</div>
	         			<div class="col-4">
						</div>
	         		</div>
			    </p>
			  </div>
			</div>
		</div>
		<div class="col-3">
	</div>
</div>

<!-- If the user click on YES -->

<?php if (isset($_GET['delete'])){

// we send an email to an admin
mail("guillaume.lequeux@supagro.fr", // you will send the message to this e-mail adress 
     "Delete account", // mail subject
     "The user ".$donnees[1]." ".$donnees[0]." (id=".$id_user_account.") want to delete his account."); // message to send

// we show a message to confirm the request
echo	"<br/><br/><br/>";
echo	'<div class="row">';
echo		'<div class="col-3">';
echo		"</div>";
echo		'<div class="col-6">';
echo			'<div class="card text-center">';
echo			  '<div class="card-body">';
echo			    '<h5 class="card-title">Account deletion</h5>';
echo			    '<p class="card-text"> ';
echo			    "Your request to delete your account has been taken into consideration. <br/>";
echo			    "Our admistrators will process your request as soon as possible. <br/>" ;
echo				"You will receive a confirmation of deletion once the operation has been completed. <br/>";
echo			    "</p>";
echo			  "</div>";
echo			"</div>";
echo		"</div>";
echo		'<div class="col-3">';
echo		"</div>";
echo	"</div>";
echo "</div>";
}
?>
<br/><br/>




</body>
<?php
include("pied_de_page.php");
?>

</html>
