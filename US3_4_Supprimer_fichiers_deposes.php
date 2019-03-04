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
		echo "
		</br>";
		//DB connection
		include("tab_donnees/funct_connex.php");
		$con=new Connex();
		$connex=$con->connection;
		
	//IF CHECKBOX
		//Query to get all file id
		$result_nb_files=pg_query($connex, "SELECT id_file FROM files") or die('Échec de la requête : ' . pg_last_error());
		//Get variables from form
		while($row=pg_fetch_array($result_nb_files)){
			$id_file=$row[0];
			$variable="id_file_".$id_file;
			if(isset($_GET[$variable])){
				$id_file_to_delete=$_GET[$variable];
				//echo $id_file_to_delete."</br>";
				//Queries FOR DELETE

				$result_info=pg_query($connex, "SELECT file_name, label_format FROM files JOIN format ON files.id_format=format.id_format WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());
				while($col=pg_fetch_array($result_info)){
					$name=$col[0];
					$extension=$col[1];
				}
				//Delete the linked projects
				$result_delete_projects=pg_query($connex, "DELETE FROM link_file_project WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());
				//Delete the inked tags
				$result_delete_tags=pg_query($connex, "DELETE FROM link_tag_project WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());
				//Delete the file in the "files" table
				$result_delete=pg_query($connex, "DELETE FROM files WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());	
				//Delete the real file on the server
				$path='US_2_21_dragdrop_upload/';
				unlink($path.$name.".".$extension);
			}	
		}
		
	//IF "DELETE" BUTTON
		if(isset($_GET['id_file'])){
			$id_file_to_delete=$_GET['id_file'];
			//echo $id_file_to_delete."</br>";
			//Queries FOR DELETE

			$result_info=pg_query($connex, "SELECT file_name, label_format FROM files JOIN format ON files.id_format=format.id_format WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());
			while($col=pg_fetch_array($result_info)){
				$name=$col[0];
				$extension=$col[1];
			}
			//Delete the linked projects
			$result_delete_projects=pg_query($connex, "DELETE FROM link_file_project WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());
			//Delete the inked tags
			$result_delete_tags=pg_query($connex, "DELETE FROM link_tag_project WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());
			//Delete the file in the "files" table
			$result_delete=pg_query($connex, "DELETE FROM files WHERE id_file=".$id_file_to_delete) or die('Échec de la requête : ' . pg_last_error());
			//Delete the real file on the server
			$path='US_2_21_dragdrop_upload/';
			unlink($path.$name.".".$extension);
		}
		?>
		
		<div class="container">

			<h1>Files have been deleted successfully !</h1></br>

			<div align="center">
				<form action="US3_11_Visualiser_liste_fichiers.php" method="GET">
					<button type="submit" class="btn btn-md btn-primary">Previous page</button>
				</form>
			</div>
		</div>

	</body>
	
	<?php
	echo "</br>";
	include("pied_de_page.php");
	?>
	
</html>