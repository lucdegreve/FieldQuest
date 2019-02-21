<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - Units part  
Developped by Ophélie			      
This page contains code to display the filter labels based on the Tag Units


Input variables : 		

Output variables :										
		
------------------------------------------------------------->	

<META charset="utf-8"> 
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">
</head>
<body>
	<?php
	// Header of the page 
	include("en_tete.php");
	
	// File to connect to the database & use recordset 
	require "tab_donnees/funct_connex.php";
	require "tab_donnees/tab_donnees.class.php";
	
	// Connexion with the database 
	$con = new Connex();
	$connex = $con->connection;
	
	// Query to get the tags of the tag type units 
	$query_units = "SELECT t.id_tag, t.tag_name FROM tags t JOIN tag_type tt on t.id_tag_type = tt.id_tag_type 
			WHERE tt.name_tag_type = 'unit'"; 
	$result_units = pg_query($connex,$query_units) or die ("Failed to fetch units tag");
	$table_units = new Tab_donnees($result_units,"PG");
	
	//$table_units -> creer_liste_option_plus ( "unit", "id_tag", "tag_name");
	
	// Footer of the page 
	include("pied_de_page.php");
	?>

</body>

</html>