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

			//recuparate id_user and id user type
			$id_user=$_GET['id_user'];
			$id_user_type=$_GET['id_user_type'];

			// Include the file with all the functions
            require "tab_donnees/funct_connex.php";

            // connexion à la base de données Fieldquest
            $con = new Connex();
            $connex = $con->connection;

			$link = $connex;

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

						if ($id_user_type==1)
						{
							header('Location: US0_page_accueil_admin.php');
						}
						if ($id_user_type==2)
						{
							header('Location: US0_page_accueil_internes.php');
						}
						if ($id_user_type==3)
						{
              header('Location: US0_page_accueil_externes.php');
						}

		?>
  </body>
</html>
