<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Creating a tag type -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		require("connection.php"); //à modifier en fonction du nom de la page de connexion
		$id_tag_type=$_GET[""];// Demander à Camille 
		$name_tag_type=$_GET[""];//Demander à Camille
		$description_tag_type=[""]; //Demander à Camille
		$sql = 'INSERT INTO tag_type VALUES ("'.$id_tag_type.'", "'.$name_tag_type.'", "'.$description_tag_type.'")'; 
		//echo $sql;
		$result=pg_query($connection,$sql);//à modifier en fonction de la page connection
		echo '<script type="text/javascript">';
			echo'alert("New tag_type '.$name_tag_type.' created")';
		?>
		</body>
</html>