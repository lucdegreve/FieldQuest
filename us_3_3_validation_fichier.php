<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Changing a file status in the database -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		require "tab_donnees/tab_donnees.class.php";
		require "tab_donnees/funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;

		$id_validation_state=$_GET[""];// à modifier à voir avec Elsa
		$sql = 'UPDATE files set id_validation_state="'.$id_validation_state.'"';
		?>
		</body>
</html>