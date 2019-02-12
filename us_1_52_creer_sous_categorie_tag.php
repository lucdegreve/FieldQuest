<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Creating a tag type -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		require "tab_donnees.class.php";
		require "funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		$id_tag_type=$_GET[""];// Demander à Camille 
		$name_tag_type=$_GET[""];//Demander à Camille
		$description_tag_type=[""]; //Demander à Camille
		$sql = 'INSERT INTO tag_type VALUES ("'.$id_tag_type.'", "'.$name_tag_type.'", "'.$description_tag_type.'")'; 
		$result=pg_query($connex,$sql);
		echo '<script type="text/javascript">';
			echo'alert("New tag_type '.$name_tag_type.' created")';
		?>
		</body>
</html>