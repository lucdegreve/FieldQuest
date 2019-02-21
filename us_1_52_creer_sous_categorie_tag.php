<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Creating a tag type -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		require "tab_donnees/tab_donnees.class.php";
		require "tab_donnees/funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		$name_tag_type=$_GET[""];//Demander à Camille
		$description_tag_type=[""]; //Demander à Camille
		$sql = "INSERT INTO tags (name_tag_type,description_tag_type) VALUES ('".$name_tag_type."','".$description_tag_type."')"; 
		$result=pg_query($connex,$sql);//exécution de la requête
		?>
		<script type="text/javascript">;
			alert(<?php echo"New tag $name_tag_type created";?>);
		</body>
		</body>
</html>