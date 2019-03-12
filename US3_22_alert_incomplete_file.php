<html lang="en">
	<head>
	</head>
	<body>
        <?php
				 include("en_tete.php");
				 echo "</br>";
						
		?>
		        
            <!-- if the comment is already written --> 
            <?php
            require "tab_donnees/tab_donnees.class.php";
            require "tab_donnees/funct_connex.php";
            if (isset($_GET['Comment'])){
            
            			$id_file = $_GET['id_file_after'];
				        echo    '<div class="container">';
						echo	'<form method="GET" action="US3_13_Modifier_fichiers_deposes.php">';
						echo	'<button type="submit" class="btn btn-outline-info btn-md">Back</button>';
						echo	'<input type="hidden" value="'.$id_file.'" name="id_file">'	;		
						echo	'</form>'	;	
				        echo    '<div align="center">';           
           			
                    // send email 
                    $comment = $_GET['Comment'];
                    $user_mail = $_GET['user_mail'];
                    echo "Email has been correctly sent";
                    // Actually not sending the mail because of fakes emails adress.
                    mail($user_mail, // you will send the message to this e-mail adress 
                     "Fieldquest - Incomplete files", // mail subject
                     "Your files are incomplete. Here's the administrator comment : ".$comment); // message to send 
                     }
            else { // else find the users email
            
            			$id_file = $_GET['id_file_hidden'];
				        echo    '<div class="container">';
						echo	'<form method="GET" action="US3_13_Modifier_fichiers_deposes.php">';
						echo	'<button type="submit" class="btn btn-outline-info btn-md">Back</button>';
						echo	'<input type="hidden" value="'.$id_file.'" name="id_file">'	;		
						echo	'</form>'	;	
				        echo    '<div align="center">'; 
            
            
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
                    echo '</br><h2>Send an alert concerning this file : </h2></br>';
					echo "</div>";
                    // and fill the form
                    echo '<form id ="alertform" name="alertform" action="US3_22_alert_incomplete_file.php?user_mail='.$user_mail.'" method="GET">';
                    echo  '<input type="hidden" name="user_mail" value='.$user_mail.'>';
                    echo '	<B>Comment :</B> <br/> <textarea id="Comment" name="Comment" class="form-control" form="alertform"></textarea></br>';
					echo "<div align='center'>";
						echo '<input type="hidden" value="'.$id_file.'" name="id_file_after">';
						echo '<button type="submit" class="btn btn-md btn-success" >Send e-mail</button>';
					echo "</div>";
					echo "</form>";
            }
             ?>
		</div>
		</div>
		

	</body>
	
		<?php
		include("pied_de_page.php");
		?>

       </html>
	