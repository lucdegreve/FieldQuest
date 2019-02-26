<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by Ophélie			      
This page contains code to display the filter labels based on the format of files 


Input variables : 		

Output variables :		id of selected formats 								
		
------------------------------------------------------------->	

<META charset="utf-8"> 
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">

<!-- Import for collapse -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script> 
<!-- Import for checkbox button -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<!-- Javascript to handle checkbox button events -->
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
	
	// Query to get formats 
	$query_format = "SELECT id_format, label_format FROM format";
	$result_format = pg_query($connex, $query_format);
	
	// Get recordset as a table
	$table_format = new Tab_donnees($result_format,"PG");
?>
<!-- Collapse button -->
<div class="container">	
	<div class = "col-md-5">
		<p>
		  <button class="btn btn-lg btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
			File format
		  </button>
		</p>
		<!-- Content of collapse -->
		<div class="collapse" id="collapseExample">
		  <div class="card card-body">
			<div class="form-check">
				<?php 
				// For each format 
				for ($i=0; $i< $table_format->nb_enregistrements (); $i++){
					// Get id of the format n°$i  of recordset
					$id_format = $table_format-> t_enr[$i][0];
					// Get label of the format n°$i  of recordset
					$label_format = $table_format-> t_enr [$i][1];
				
					// Make checkbox button 
					echo '<span class="button-checkbox">';
					echo '<button type="button" class="btn" data-color="primary" id = "'. $id_format .'">'.$label_format.'</button>';
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