<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Creating a tag -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		require "tab_donnees.class.php";
		require "funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		$id_tag=$_GET[""];// Demander à Camille 
		$id_tag_type=$_GET[""];// Demander à Camille 
		$name_tag=$_GET[""];//Demander à Camille
		$tag_description=[""]; //Demander à Camille
		$sql = 'INSERT INTO tag_type VALUES ("'.$id_tag.'","'.$id_tag_type.'" ,"'.$name_tag.'", "'.$tag_description.'")'; 
		$result=pg_query($connex,$sql);
		echo '<script type="text/javascript">';
			echo'alert("New tag '.$name_tag.' created")';
		?>
		</body>
</html>