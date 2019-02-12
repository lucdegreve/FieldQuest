<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Verifying that there is no files in a project before to delete it -->
	<!-- recuperation de la variable id_project -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		$id_project=$_GET["id_project"];
		require "tab_donnees.class.php";
		require "funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		$result= pg_query($connex, "SELECT count(id_file) FROM link_file_project where id_project=$id_project"); // counts the number of files in a project
		
		$nb_files = pg_fetch_all($result);
		if($nb_files[0][0]==0){
			$sql = 'Delete from projects where id_project="'.$id_project.'"';  // if the project is empty we can delete it
			echo'The project has been deleted';
		}
		else {
			echo'<script type="text/javascript">';
			echo "alert('The project isn't empty and cannot be deleted')";
			echo'</script>';
		}
		?>
		</body>
</html>


