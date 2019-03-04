<html>
<head>
<!-----------------------------------------------------------
       US1-12 Suppress an account
Developped by Ophélie
This page contains the query to suppress the login and password of an user account


Input variables : 	id_user_account

Output variables :			NONE

------------------------------------------------------------->
<META charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">
</head>
<body>
<?php
	// Include header
	include("en_tete.php");
	// Include files containing connexion to database
	require "tab_donnees/funct_connex.php";

	// Connexion to the database
	$con = new Connex();
	$connex = $con->connection;

	// Get the id of the account we want to delete
	$id_user_account = $_GET['id_user_account'];

	$query_delete_account = "UPDATE user_account SET
						login = NULL ,
						password = NULL
						WHERE id_user_account='".$id_user_account."'";
	$result_delete_account = pg_query($connex,$query_delete_account)
		or die ("<div class = 'alert alert-danger'>Failed to delete account</div>");
	echo '<div class="alert alert-success">Login and password successfully deleted. </div>';
	echo'<form action = "US1-10_Gerer_comptes.php" method = "POST" name = "Return">';
	echo'<input type = "submit" value = "Return">';
	echo'</form>';
	// Include footer
	include("pied_de_page.php");
?>
</body>

</html>
