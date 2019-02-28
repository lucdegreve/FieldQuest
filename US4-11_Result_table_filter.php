<html>

	<head>
<!--------------------------------------------------------------------------------
       US4-11 Filtrer avec des tags - Table of query result  
Developped by Ophélie	& Diane	
	      
This page displays the result of the search by tags as a table. 
Code based on "US3_11_Visualisere_liste_fichiers.php" developped by Elsa & Axelle


Input variables : 		

Output variables :								
		
---------------------------------------------------------------------------------->	

		<META charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
	</head>

	<body>

		<?php
		//Header
		include("en_tete.php");
		echo "</br>";
		//DB connection
		require "./tab_donnees/funct_connex.php";
		require "tab_donnees/tab_donnees.class.php";
		$con=new Connex();
		$connex=$con->connection;
		//Query : list of distinct file names
		$result_files_id=pg_query($connex, "SELECT id_original_file, MIN(upload_date) FROM files GROUP BY id_original_file ORDER BY MIN(upload_date) DESC") or die('Échec de la requête : ' . pg_last_error());
		$nbrows=pg_num_rows($result_files_id);
		?>

		<!-- Table creation -->
		<div class="container-fluid"> 
			<form name="box_download" method="GET" action="**URL_download**">
				<div class="row">
					<div class="col-md-10"><h1><B>Files list</B></h1></div>
					<div class="col-md-2" align="right">
						<button type="submit" class="btn btn-md btn-success">Download selection</button>
					</div>
				</div></br>
				<div class="row">				
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col" width="5%">State</th>
								<th scope="col" width="25%">File name</th>
								<th scope="col" width="10%">Upload date</th>
								<th scope="col" width="17%">Origin</th>
								<th scope="col" width="8%">Size</th>
								<th scope="col" width="10%"></th>
								<th scope="col" width="10%"></th>
								<th scope="col" width="10%"></th>
								<th scope="col" width="5%">Select</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while($row=pg_fetch_array($result_files_id)){
								$id=$row[0];
								//Query to get the last version for each file name
								$query="SELECT id_file, file_name, to_char(upload_date,'DD/MM/YYYY'), file_size, label_validation_state, id_version, last_name, first_name, id_original_file, file_comment
								FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account JOIN validation_state vs ON f.id_validation_state=vs.id_validation_state
								WHERE id_original_file='".$id."' AND id_version=(SELECT MAX(id_version) FROM files WHERE id_original_file='".$id."')";
								$result_files_list=pg_query($connex, $query) or die('Échec de la requête : ' . pg_last_error());
								while($col=pg_fetch_array($result_files_list)){
									$id_file=$col[0];
									$name=$col[1];
									$date=$col[2];
									$size=$col[3];
									$valid=$col[4];
									$version=$col[5];
									$last_name=$col[6];
									$first_name=$col[7];
									$original_id=$col[8];
									if ($col[9]!= ''){
										$metadata="Comment :".$col[9]."\r\n Tags: ";
									} else {
										$metadata="Tags: ";
									}
								}
								// Query to get metadata of the file 
								$query_metadata = "SELECT t.tag_name
											FROM link_tag_project ltp JOIN tags t on t.id_tag = ltp.id_tag 
											WHERE ltp.id_file = '".$id_file."'";
								$result_metadata = pg_query($connex, $query_metadata) or die (' Failed to get tags');
								$table_metadata = new Tab_donnees($result_metadata,'PG');
								if ( $table_metadata->nb_enregistrements() == 0){
									$metadata .= "None. ";
								}
								for ($i=0; $i< $table_metadata->nb_enregistrements();$i++){
									$metadata .= $table_metadata->t_enr[$i][0].", ";
									
								}
								// Delete last ', ' in $metadata
								$metadata = substr($metadata, 0, strlen($metadata)-2);
								
								//State "validated"
								if($valid=="validated"){
									if($id_file!=$original_id){
										//Query to get right "upload date" and "origin"
										$query_origin="SELECT to_char(upload_date,'DD/MM/YYYY'), last_name, first_name FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account WHERE id_file=".$original_id;
										$result_origin=pg_query($connex, $query_origin) or die('Échec de la requête : ' . pg_last_error());
										while($col=pg_fetch_array($result_origin)){
											$date=$col[0];
											$last_name=$col[1];
											$first_name=$col[2];
											
											
										}
									}						
									echo "<tr>";
										echo "<td ".$bold."><img src='picto/validated.png' width='30' height='30'/></td>";
										// Popover to display metadata for each file
										echo '<td>'.$name.' <a tabindex="0" class="badge badge-light" role="button" data-toggle="popover" data-trigger="focus" title="Metadata related to this file" data-content="'.$metadata.'">i</a></td>';
										echo "<td>".$date."</td>";
										echo "<td ".$bold.">".$first_name." ".$last_name."</td>";
										echo "<td ".$bold.">".$size."</td>";
										echo "<td>";
											echo '<button type="button" id="btnDownload" name="btnDownload" class="btn btn-sm btn-outline-success btn-block" onclick="return download_file('.$id_file.')">Download</button>';													
										echo "</td>";
										echo "<td>";
											echo '<button type="button" id="btnEdit" name="btnEdit" class="btn btn-sm btn-outline-warning btn-block" onclick="return edit_file('.$id_file.')">Edit</button>';
										echo "</td>";
										echo "<td>";
											?>
											<button type='button' id='btnVersions' name='btnVersions' class='btn btn-sm btn-outline-primary btn-block' onclick='return popup("<?php echo $original_id; ?>")'>See versions</button>								
											<?php
										echo "</td>";										
										echo "<td>";
											echo '</br><div align="center"><input type="checkbox" name="id_file_'.$id_file.'" value="'.$id_file.'"></div>';
										echo "</td>";
									echo "</tr>";
								}
							}
							?>
						</tbody>
					</table>
				</div></br>
			</form>
		</div>

	</body>
	
	<?php
	echo "</br>";
	include("pied_de_page.php");
	?>
	
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Resources for popover -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script>
	
	<script type="text/javascript">
		//Ouvrir la popup pour afficher les différentes versions
		function popup(original_id) {	
			window.open("US3_11_Visualiser_liste_fichiers_P2.php?original_id="+original_id,'newWin','width=1000,height=400');
		}	
		
		//Ouvrir la page "edit file"
		function edit_file(id_file) { 
			document.location.href="US3_13_Modifier_fichiers_deposes.php?id_file="+id_file;
		}
		
		$('[data-toggle="popover"]').popover();

		$('body').on('click', function (e) {
		//only buttons
			if ($(e.target).data('toggle') !== 'popover' && $(e.target).parents('.popover.in').length === 0) { 
				$('[data-toggle="popover"]').popover('hide');
			}
		});
	
	</script>
	
</html>
