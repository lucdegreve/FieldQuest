<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Verifying that there is no files in a project before to delete it -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		$id_project=$_GET["id_project"];
		$connection =pg_connect("host=localhost port=5432 dbname=Geosys_eng user=postgres password=mdpsql")or die ("Connection impossible");
		$query="SELECT count(id_file) FROM link_file_project where id_project=$id_project";	// counts the number of files in a project
		$result=pg_query($connection,$query);
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


