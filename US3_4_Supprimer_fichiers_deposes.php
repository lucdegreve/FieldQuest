<html>

	<head>
		<!-- Coders : Axelle & Elsa -->
		<!-- Files list, validated or not -->

		<META charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
	</head>

	<body>

		<?php
		//Header
		include("en_tete.php");
		echo "</br></br>";
		//DB connection
		include("tab_donnees/funct_connex.php");
		$con=new Connex();
		$connex=$con->connection;
		//Query to get all file id
		$result_nb_files=pg_query($connex, "SELECT id_file FROM files") or die('Échec de la requête : ' . pg_last_error());
		//Get variables from form
		while($row=pg_fetch_array($result_nb_files)){
			$id_file=$row[0];
			$variable="id_file_".$id_file;
			if(isset($_GET[$variable])){
				$id_file_to_delete=$_GET[$variable];
				echo $id_file_to_delete."</br>";
			}
			//Query FOR DELETE
			//$result_delete=pg_query($connex, "DELETE FROM files WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());
		}
		?>
		
		<div class="container">
			<h1>Files have been deleted successfully !</h1>
		</div>

	</body>
	
	<?php
	echo "</br></br>";
	include("pied_de_page.php");
	?>
	
</html>