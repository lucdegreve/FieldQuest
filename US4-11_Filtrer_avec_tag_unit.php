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
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script> 



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
	// Get recordset as a table
	$table_units = new Tab_donnees($result_units,"PG");
	?>
<div class="container">	
	<div class = "col-md-3">
		<p>
		  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
			Units
		  </button>
		</p>
		<div class="collapse" id="collapseExample">
		  <div class="card card-body">
			<div class="form-check">
				<?php 
				// For each tag 
				for ($i=0; $i< $table_units->nb_enregistrements (); $i++){
					// Get id of the tag n°$i  of recordset
					$id_tag = $table_units-> t_enr[$i][0];
					// Get name of the tag n°$i  of recordset
					$tag_name = $table_units-> t_enr [$i][1];
					// Make a checkbox 
					echo '<div class = row>';
					echo '<input type="checkbox" class="form-check-input" id="'. $id_tag .'">';
					echo '<label class="form-check-label" for="'.$id_tag.'"> '.$tag_name.' </label>';
					echo '</div>';
				}
				?>
			</div>
		  </div>
		</div>
	</div> <!-- End col-md-3 class -->
</div> <!-- End container -->
<?php
// Footer of the page 
include("pied_de_page.php");
?>

</body>

</html>