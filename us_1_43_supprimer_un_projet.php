<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Verifying that there is no files in a project before to delete it -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		$id_project=$_GET["id_project"]
		$link = mysqli_connect('postgre','mdpsql','');
			mysqli_set_charset($link,'utf8mb4');
			mysqli_select_db($link,'Geosys_ok')
							or die ('Impossible to make a connection with Geosys_ok'.
							mysqli_error($link));
		$query="SELECT count(id_file) FROM link_file_project where id_project=$id_project";	// counts the number of files in a project
		$result=mysqli_query($link,$query) or die ('the query has failed : '.mysqli_error($link));
		$nb_files = mysqli_fetch_all($result);
		if($nb_files[0][0]==0){
			$sql = 'Delete from projects where id_project="'.$id_project.'"';  // if the project is empty we can delete it
		}
		else {
			echo'<script type="text/javascript">';
			echo "alert('The project isn't empty and cannot be deleted')";
			echo'</script>';
		}
		?>
		</body>
</html>

