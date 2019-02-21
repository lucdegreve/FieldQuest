<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - Units part  
Developped by Ophélie			      
This page contains code to display the filter labels based on the Tag Units


Input variables : 		

Output variables :		id of selected tags 								
		
------------------------------------------------------------->	

<META charset="utf-8"> 
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script> 

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>


 <script type= 'text/javascript' src = 'manage_checkbox_button.js'></script> 
</head>
<body>
	<?php
	
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
	<div class = "col-md-5">
		<p>
		  <button class="btn btn-lg btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
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
				
					// Make checkbox button 
					echo '<span class="button-checkbox">';
					echo '<button type="button" class="btn" data-color="primary" id = "'. $id_tag .'">'.$tag_name.'</button>';
					echo '<input type="checkbox" class="hidden" />';
					echo '</span>';
				}
				?>
			</div>
		  </div>
		</div>
	</div> <!-- End col-md-3 class -->
</div> <!-- End container -->


</body>

</html>