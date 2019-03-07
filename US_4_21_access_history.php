<!doctype html>
<html lang="en">


<head>

<?php
	include("en_tete.php");
	$id_user=$_SESSION['id_user_account'];
	
?>


<!-- Développeur : Eva & Liantsoa
	Access my deposit history
	-> writing the query to access the list of my submitted files	(changes on query made by Ophélie - query with filters)
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

require_once "./tab_donnees/tab_donnees.class.php";
require_once "./tab_donnees/funct_connex.php";

$con = new Connex();
$connex = $con->connection;

$query = "SELECT  f.id_file, f.file_name, f.id_format, vs.label_validation_state, f.id_version, f.upload_date, 
				  f.file_comment, f.data_init_date, f.data_end_date, f.evaluation_date, f.evaluation_comment, f.file_size 
					FROM files f
					LEFT JOIN validation_state vs ON f.id_validation_state = vs.id_validation_state 
					LEFT JOIN link_file_project lfp ON lfp.id_file=f.id_file
					LEFT JOIN projects p ON lfp.id_project=p.id_project
					LEFT JOIN format fr ON fr.id_format=f.id_format
					LEFT JOIN user_account u ON u.id_user_account=f.id_user_account
					LEFT JOIN link_tag_project ltp ON ltp.id_file=f.id_file
					LEFT JOIN tags t ON t.id_tag=ltp.id_tag
				WHERE f.id_user_account = '".$id_user."' AND ";
// Selected start date 
	if (isset($_POST['start'])){
			if ($_POST['start']!=''){
					$start_date = $_POST['start'];

					$query .= " f.upload_date >'".$start_date."' AND ";
			}
	}
	// Selected end date
	if (isset($_POST['end'])){
			if ($_POST['end']!=''){
					$end_date = $_POST['end'];
					$query .= " f.upload_date <'".$end_date."' AND ";
			}
	}

	// List of selected format
	if (isset($_POST['format'])){
			$query .= " f.id_format IN (";
			foreach ($_POST['format'] AS $i){
					$query .= $i.", ";
			}
			$query = substr($query, 0, strlen($query) -2);
			$query .= ")";
			$query .= " AND ";
	}

	// list of selected projects
	if (isset($_POST['projet'])){
		
			$query .= " lfp.id_project IN (";
			foreach ($_POST['projet'] AS $i){
					$query .= $i.", ";
			}
			$query = substr($query, 0, strlen($query) -2);
			$query .= ")";
			$query .= " AND ";
			
	}
	//TAG_SLD = list of tag selected (units included)
	$TAG_SLD='(';

	if (isset($_POST['unit'])){
			foreach ($_POST['unit'] AS $i){
					$TAG_SLD .= $i.", ";
			}
			echo '</br>';
	}

	if (isset($_POST['tag'])){
			foreach ($_POST['tag'] AS $i){
					$TAG_SLD .= $i.", ";
			}
			echo '</br>';
	}
	// add condition on tag in query if list of tags not empty
	if ($TAG_SLD!='('){
			$query .= " ltp.id_tag IN ".$TAG_SLD;
			$query = substr($query, 0, strlen($query) -2);
			$query .= ")";
	}

	//Cut end of query (unecessary WHERE or AND)
	if (substr($query, -6)=='WHERE '){
		$query = substr($query, 0, strlen($query) -6);
	}

	if (substr($query, -4)=='AND '){
		$query = substr($query, 0, strlen($query) -4);
	}
	
	$query .= " GROUP BY f.id_file, f.file_name, vs.label_validation_state, f.id_version, f.upload_date, 
	f.file_comment, f.data_init_date, f.data_end_date, f.evaluation_date, f.evaluation_comment, f.file_size 
	ORDER BY MIN(f.upload_date) DESC";


$result = pg_query($connex,$query) or die (pg_last_error() );



echo "</BR>";

?>



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
									echo '<th>';
										echo  'Delete';
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
											echo '<td>';
												if ($row[3]=='not validated')
												{
												echo ("<a href =# class='lien'>Delete</A>");
												}
												else
												{
												echo "";
												}
											echo '</td>';			
									echo '</tr>';
								}
							echo '</tbody>';
						echo '</table>'

					?>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
		</BR>
<?php
	// Include footer
	include("pied_de_page.php");
?>

</body>

</html>
