<html>
	<head>
		<!--developpers: Camille Bonas et Julien Louet-->
		<!--This page will make it possible to visualize the different categories as well as the tags and the possibility to create new ones-->
		<!--Avancement: on a créé le bouton plus qui permet de développer la catégorie pour afficher les tags correspondants-->
		<!--Avancement(2): il faut tester avec la base de données pour voir si ça marche-->
		<META charset="UTF-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/custom.css">
	</head>
	<body>
	
	<?php
		//connection to server + choice of database
		$link = pg_connect("host=localhost dbname= user= password= ") or die(pg_last_error());
		
		//request parameters
		$query = "SELECT * FROM tags t JOIN type_tag tt ON t.id_type_tag=tt.id_type_tag";
		//request execution
		$result = pg_query($query) or die(pg_last_error());
	
		// Results browsing line by line
		// For each line pg_fetch_array return a value table  
		while ($row = pg_fetch_array($result)) 
		{ 
			// The access to a table element can be do thanks to index or field name
			// Here we are using field name
			echo $row["nom_type_tag"];
			echo '<form method="GET" action="Tag.php">';
			echo '<input type="hidden" name="id_cat" value=' .$row["id_type_tag"]. '>';
			echo '<button type="button" class="button_plus" name="button_plus" value="+"></button>"';
			echo '</form>';
			if(isset($_GET[button_plus]))
			{
				$query2= "SELECT * FROM tags t JOIN type_tag tt ON t.id_type_tag=tt.id_type_tag 
						  WHERE id_type_tag=".$_GET[id_cat];
				$result2 = pg_query($query2) or die(pg_last_error());
				while ($row2 = mysqli_fetch_array($result2)) {  	 	
					echo $row["nom_tag"] .'<BR>'; 
			   } 
	
			}
			
		}
		
		
		
	
		//libère le résultat
		pg_free_result($result);
		//ferme la connexion
		pg_close($link);
	?>
	
	
	</body>
</html>