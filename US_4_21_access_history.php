<!doctype html>
<html lang="en">


<head>

<!-- Développeur : Eva & Liantsoa
	Access my deposit history
	-> writing the query to access the list of my submitted files (changes on query made by Ophélie - query with filters)
	-> table to display the results of the query
	This page is used in "US4_22_Main_page_history_with_filters.php"
	-->


 <title >Upload history</title>

</head>

<body>

<?php


// Call to files to connect to the db in main page "US4_22_Main_page_history_with_filters.php"
$query = "SELECT  f.id_file, f.file_name, fr.label_format, fr.label_format, vs.label_validation_state, f.id_version, f.upload_date, 
				  f.file_comment, f.data_init_date, f.data_end_date, f.validation_date, f.evaluation_comment, f.file_size, f.file_place
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
	
	$query .= " GROUP BY f.id_file, f.file_name, fr.label_format, vs.label_validation_state, f.id_version, f.upload_date, 
	f.file_comment, f.data_init_date, f.data_end_date, f.validation_date, f.evaluation_comment, f.file_size 
	ORDER BY MIN(f.upload_date) DESC";


$result = pg_query($connex,$query) or die (pg_last_error() );

?>



</br>


		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">

					<script type="text/javascript">
					$(document).ready(function() {
					    $('#example').DataTable();
					} );
					</script>
					<div class="table-responsive">
						<?php
						//creation du tableau

							echo '<table id="example"   cellpadding="0" bordercolor="E8E8E8" bgcolor="white">';
						// en tete du tableau
								echo '<thead class="thead-dark">';
									echo '<tr>';
										echo '<th>' ;
											echo  'ID';
										echo '</th>';
										echo '<th>';
											echo  'Name';
										echo '</th>';

										echo '<th>';
											echo  'View File';
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
											echo  'Size(Octet)';
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
											for($i=0; $i<  pg_num_fields($result)-1; $i++)
											{
												if($i ==2){
													$format=$row[$i+1];
													$link = $row[13]."".$row[$i-1];

													switch ($format){
														case 'jpg':
															echo '<td>';
																echo "  <button type='button' class='btn btn-sm btn-outline-primary btn-block'  onclick='return popup_visualize($row[0])'>View File</button>	  ";
															echo '</td>';
															break;

														case 'png':
															echo '<td>';
																echo "  <button type='button' id='btnVisualize' name='btnVisualize' class='btn btn-sm btn-outline-primary btn-block'  onclick='return popup_visualize($row[0])'>View File</button>	  ";
															echo '</td>';
															break;
															
														case 'JPG':
															echo '<td>';
																echo "  <button type='button' id='btnVisualize' name='btnVisualize' class='btn btn-sm btn-outline-primary btn-block'  onclick='return popup_visualize($row[0])'>View File</button>	  ";
															echo '</td>';
															break;

														case 'xlsx':
															echo '<td>';
																// we don't know how to visualize a xlsx file
																echo '<center><font color="79C8EA"><small><i>No visualization available</i></small></font></center>';															
															echo '</td>';
															break;

														case 'pdf':
															echo '<td>';
																echo '<a href='.$link.' target="_blank" >'."  <button type='button' id='btnVisualize' name='btnVisualize' class='btn btn-sm btn-outline-primary btn-block'>".'View File'."</button>".'</a>';
															echo '</td>';
															break;

														default:
															 echo '<td>';
																echo '<center><font color="79C8EA"><small><i>No visualization available</i></small></font></center>';
															echo '</td>';
															break;
													}




												}else{
													echo '<td>';
													if ($i== 1){
														echo substr($row[$i],10)."";
													} else {
													echo $row[$i]."";
													}
												echo '</td>';

												}

											}
												echo '<td>';
													if ($row[4]=='Not validated')
													{
													echo ("<a href ='US3_11_Visualiser_liste_fichiers.php' class='lien'>Delete</A>");
													}
													else
													{
													echo " ";
													}
												echo '</td>';
										echo '</tr>';
									}
								echo '</tbody>';
							echo '</table>'

						?>
					</div>
				</div>
			</div>
		</div>



</body>


<script type="text/javascript">
		//Ouvrir la popup pour afficher les différentes versions
		function popup(original_id) {
			window.open("US3_11_Visualiser_liste_fichiers_P2.php?original_id="+original_id,'newWin','width=1000,height=400');
		}

		//Ouvrir la popup pour visualiser le fichier
		function popup_visualize(original_id) {
			window.open("US5_2_Visualize?original_id="+original_id,'newWin','width=1000,height=400');
		}

        function popup_visualize_xls(original_id) {
				window.open("US5_2_Visualize_xls?original_id="+original_id,'newWin','width=1000,height=400');
			}

		//Ouvrir la page "edit file"
		function edit_file(id_file) {
			document.location.href="US3_13_Modifier_fichiers_deposes.php?id_file="+id_file;
		}

		//Ouvrir la page "US3_4_Supprimer_fichiers_deposes"
		function delete_file(id_file) {
			document.location.href="US3_4_Supprimer_fichiers_deposes.php?id_file="+id_file;
		}

	</script>

</html>
