<!doctype html>
<html lang="en">


<head>

<?php
	include("en_tete.php");
	//$id_user = $_SESSION[$id_user_account] ; variables sessions à lier
	$id_user = 1;
?>


<!-- Développeur : Eva
	Access my deposit history
	-> writing the query to access the list of my submitted files	
	-> table to display the results of the query
	-->
	
	    <link href="custom.css" rel="stylesheet" type="text/css">
		<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
        <script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
        <script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>
        
 <title >Upload history</title>
 
 <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
 
 <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
		
 <!-- Openlayers CSS file-->
 
 <style type="text/css">
  #map{
   width:40%;
   height:300px;
  }
 </style>
 <!--Basic styling for map div, 
 if height is not defined the div will show up with 0 px height  -->
 
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>

</head>	

<body>

<?php

require "./tab_donnees/tab_donnees.class.php";
require "./tab_donnees/funct_connex.php";

$con = new Connex();
$connex = $con->connection;

$query = "SELECT id_file, file_name, id_format, id_validation_state, id_version, upload_date, file_comment, data_init_date, data_end_date, evaluation_date, evaluation_comment, file_size FROM files WHERE id_user_account=$id_user";
$result = pg_query($connex,$query) or die (pg_last_error() );

echo "</BR>";

?>

<form name="return" action="US_2_21_dragdrop_index.php" method="GET"> <!-- URL à changer (Liantsoa) -->
<button type='submit' class='btn btn-success btn-block'>Back to the home page</button>
</form>

</br>


		<div class="container-fluid">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
				
					<script type="text/javascript">
					$(document).ready(function() {
					    $('#example').DataTable();
					} );
					</script>

					<?php
					//creation du tableau
						echo '<table id="example" class="display" border="1" cellpadding="4" bordercolor="E8E8E8" bgcolor="white">';
					// en tete du tableau
							echo '<thead>';
								echo '<tr>';
									echo '<th>' ;
										echo  'ID';
									echo '</th>';
									echo '<th>';
										echo  'Name';
									echo '</th>';
									echo '<th>';
										echo  'Format';
									echo '</th>';
									echo '<th>' ;
										echo  'Status';
									echo '</th>';
									echo '<th>' ;
										echo  'Version';
									echo '</th>';
									echo '<th>';
										echo  'Upload date';
									echo '</th>';
									echo '<th>';
										echo  'Comment';
									echo '</th>';
									echo '<th>';
										echo  'Init date';
									echo '</th>';
									echo '<th>';
										echo  'End date';
									echo '</th>';
									echo '<th>';
										echo  'Evaluation date';
									echo '</th>';
									echo '<th>';
										echo  'Evaluation comment';
									echo '</th>';
									echo '<th>';
										echo  'Size';
									echo '</th>';
								echo '</tr>';
							echo '</thead>';

					//corps du tableau
							echo '<tbody>';
							while ($row = pg_fetch_array($result))
								{
									echo '<tr>' ;
										for($i=0; $i<  pg_num_fields($result); $i++)
										{
											echo '<td>';
												echo $row[$i]."  ";
											echo '</td>';
										}		
									echo '</tr>';
								}
							echo '</tbody>';
						echo '</table>'

					?>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>


</body>

</html>
