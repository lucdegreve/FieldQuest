<html lang="en">
	<head>
        <!-- Développeur : Manu ; Modif : Diane-->
        <!-- Send mail to the uploader of a file to have more info -->
        <!-- Input : id_file -->
        
	</head>
	<body>
        <?php
				 include("en_tete.php");
				 echo "</br>";
        ?>
		
		<div class="container">
        <form action="US4-11_Main_page_filter.php">
				<button name="return" class="btn btn-outline-info" type="submit">Back</button>
				
        <div align="center">
        
            <!-- if the comment is already written --> 
            <?php
            require "tab_donnees/tab_donnees.class.php";
            require "tab_donnees/funct_connex.php";
            if (isset($_GET['Comment'])){
                    // send email 
                    $comment = $_GET['Comment'];
                    $user_mail = $_GET['user_mail'];
                    echo "Le mail a bien été envoyé";
                    
                    // Actually not sending the mail because of fakes emails adress.
                    //Now it's sending the mail ->
                    //Test : need to have valid mail adress in the database
                    mail($user_mail, // you will send the message to this e-mail adress 
                     "Fieldquest - Incomplete files", // mail subject
                     "Your files are incomplete. Here's the administrator comment : ".$comment); // message to send 
                     }
            else { // else find the users email
                    // put the real $id_file once linked
                    $id_file = $_GET["id_file"];
                    //$id_file = 2; // Test var
                $con = new Connex();
            $connex = $con->connection;
                    $query_pre = "SELECT id_user_account from files where id_file = ".$id_file." ";
                    $result_pre = pg_query($connex,$query_pre) or die (pg_last_error() );
                    $donnees_pre = pg_fetch_array($result_pre);
                    $id_user_account = $donnees_pre[0];
                    $query = "SELECT user_account.email from user_account where id_user_account = ".$id_user_account." ";
            $result = pg_query($connex,$query) or die (pg_last_error() );
                    $donnees = pg_fetch_array($result);
                    $user_mail = $donnees[0];
                    echo '</br><h2>Envoyer une alerte concernant ce fichier</h2></br>';
					echo "</div>";
                    // and fill the form
                    echo '<form id ="alertform" name="alertform" action="US3_22_alert_incomplete_file.php?user_mail='.$user_mail.'" method="GET">';
                    echo  '<input type="hidden" name="user_mail" value='.$user_mail.'>';
                    echo '	<B>Comment :</B> <br/> <textarea id="Comment" name="Comment" class="form-control" form="alertform"></textarea></br>';
					echo "<div align='center'>";
						echo '<button type="submit" class="btn btn-md btn-success" >Send e-mail</button>';
					echo "</div>";
            }
             ?>
		</form>
		</div>
	</body>
        <?php
		include("pied_de_page.php");
    ?>
</html>
	