<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Creating a tag -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php 
		require "tab_donnees/tab_donnees.class.php";
		require "tab_donnees/funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		
		$id_tag_type=$_GET[""];// Demander à Camille 
		$tag_name=$_GET[""];//Demander à Camille
		$tag_description=$_GET[""]; //Demander à Camille
		$sql = "INSERT INTO tags (id_tag_type,tag_name,tag_description) VALUES ('".$id_tag_type."' ,'".$tag_name."','".$tag_description."')"; 
		echo $sql;
		$result=pg_query($connex,$sql);//à modifier en fonction de la page connection
		?>
		<script type="text/javascript">;
			alert(<?php echo"New tag $name_tag created";?>);
		</body>
</html>