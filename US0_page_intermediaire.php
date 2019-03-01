<! DOCTYPE html>
<html>
    <head>
        <title> Page de connexion </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" >
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/Header-Icons.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
	<body>
		<?php
			//Liantsoa
			//page intermediaire qui recupere le login et la passeword quand un utilisateur veut se connecter et dirigera ensuite vers la page accueil specififique a chaque utilisateur
			// connexion à la base de données Fieldquest
			session_start();
			include("en_tete.php");
			$id_user=$_GET['id_user'];
			$id_user_type=$_GET['id_user_type'];
			$link = pg_connect("dbname=fieldquest user=postgres password=postgres");
			//$link = pg_connect("dbname=fieldquest1 user=postgres password=Admin");
			$query = "select id_user_account,id_user_type,first_name,last_name,login ,password from user_account
			where id_user_account='".$id_user."'AND id_user_type='".$id_user_type."'";
			$result = pg_query($link, $query);
			$row=pg_fetch_array($result);
			$id_user=$row[0];
			$id_user_type=$row[1];
			$first_name=$row[2];
			$last_name=$row[3];
			$_SESSION['id_user_account']=$id_user;
			$id_user=$_SESSION['id_user_account'];
			$_SESSION['id_user_type']=$id_user_type;
			$id_user_type=$_SESSION['id_user_type'];
			
			echo '<div class="container">';
				echo '<div class="row">';
					echo '<div class="col-4">';
					echo '</div>';
					echo '<div class="col-8">';
						if ($id_user_type==1) 
						{
							echo '<h2>You are logged in as <b>'.$first_name.'</b></h2>';
							echo '<form method="GET"  action="US0_page_accueil_admin.php">';
							echo '<button type="submit" class="btn btn-success btn-lg">Go to the home page</button>';
							echo '</form>';
						} 
						if ($id_user_type==2) 
						{
							echo '<h2>You are logged in as <b>'.$first_name.'</b></h2>';
							echo '<form method="GET"  action="US0_page_accueil_internes.php">';
							echo '<button type="submit" class="btn btn-success btn-lg">Go to the home page</button>';
							echo '</form>';
						} 
						if ($id_user_type==3)
						{
							echo '<h2>You are logged in as <b>'.$first_name.'</b></h2>';
							echo '<form method="GET"  action="US0_page_accueil_externes.php">';
							echo '<button type="submit" class="btn btn-success btn-lg">Go to the home page</button>';
							echo '</form>';
						}
					echo '</div>';		
				echo '</div>';
			echo '</div>';
		include("pied_de_page.php");
		?>
  </body>
</html>		