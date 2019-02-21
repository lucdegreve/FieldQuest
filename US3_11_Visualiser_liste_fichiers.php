<html>

	<head>
		<!-- Coders : Axelle & Elsa -->
		<!-- Files list, validated or not -->

		<META charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
	</head>

	<body>

		<?php
		//Header
		include("en_tete.php");
		echo "</br></br>";
		//DB connection
		include("tab_donnees/funct_connex.php");
		$con=new Connex();
		$connex=$con->connection;
		//Query : list of distinct file names
		$result_files_names=pg_query($connex, "SELECT file_name, MIN(upload_date) FROM files GROUP BY file_name ORDER BY MIN(upload_date) DESC") or die('Échec de la requête : ' . pg_last_error());
		$nbrows=pg_num_rows($result_files_names);
		?>

		<!-- Table creation -->
		<div class="container">
			<form name="box_delete" method="GET" action="US3_4_Supprimer_fichiers_deposes.php">
				<div class="row">
					<div class="col-md-10"></div><div class="col-md-2">
						<button type="submit" class="btn btn-md btn-danger btn-block">Delete selection</button>
					</div>
				</div></br>
				<div class="row">				
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col" width="5%">State</th>
								<th scope="col" width="25%">File name</th>
								<th scope="col" width="15%">Upload date</th>
								<th scope="col" width="20%">Origin</th>
								<th scope="col" width="15%">Size</th>
								<th scope="col" width="15%"></th>
								<th scope="col" width="5%">Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while($row=pg_fetch_array($result_files_names)){
								$file_name=$row[0];
								//Query to get the last version for each file name
								$query="SELECT id_file, file_name, to_char(upload_date,'DD/MM/YYYY'), file_size, label_validation_state, id_version, last_name, first_name, id_original_file
								FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account JOIN validation_state vs ON f.id_validation_state=vs.id_validation_state
								WHERE file_name='".$file_name."' AND id_version=(SELECT MAX(id_version) FROM files WHERE file_name='".$file_name."')";
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
								}
								//State "being checked
								if($valid=="being checked"){
									echo "<tr class='table-active'>";
										echo "<th scope='row'></th>";
										echo "<th scope='row'>".$name."</th>";
										echo "<th scope='row'>".$date."</th>";
										echo "<th scope='row'>".$first_name." ".$last_name."</th>";
										echo "<th scope='row'>".$size."</th>";									
										echo "<td>";
											echo '<div class="btn-group-vertical btn-block" role="group" aria-label="Basic example">';
												echo '<button id="btnEditFile" type="button" class="btn btn-sm btn-outline-warning" value='.$id_file.' onclick="return edit_file()">Edit file</button>';
												echo '<button id="btnEditMetadata" type="button" class="btn btn-sm btn-outline-warning" value='.$id_file.' onclick="return edit_metadata()">Edit metadata</button>';
											echo '</div>';
										echo "</td>";
										echo "<td>";
											echo '<div align="center"><input type="checkbox" name="id_file_'.$id_file.'" value="'.$id_file.'"></div>';
										echo "</td>";
									echo "</tr>";
								}
								//State "not validated"
								if($valid=="not validated"){
									echo "<tr>";
										echo "<td ".$bold."><img src='picto/refused.png' width='27' height='27'/></td>";
										echo "<td>".$name."</td>";
										echo "<td>".$date."</td>";
										echo "<td ".$bold.">".$first_name." ".$last_name."</td>";
										echo "<td ".$bold.">".$size."</td>";
										echo "<td></td>";
										echo "<td>";
											echo '<div align="center"><input type="checkbox" name="id_file_'.$id_file.'" value="'.$id_file.'"></div>';									
										echo "</td>";
									echo "</tr>";
								}
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
										echo "<td>".$name."</td>";
										echo "<td>".$date."</td>";
										echo "<td ".$bold.">".$first_name." ".$last_name."</td>";
										echo "<td ".$bold.">".$size."</td>";
										echo "<td>";										
											echo "<button type='button' id='btnVersions' name='btnVersions' class='btn btn-sm btn-outline-primary btn-block' value='".$name."' onclick='return popup()'>See versions</button>";								
										echo "</td>";
										echo "<td></td>";
									echo "</tr>";
								}
							}
							?>
						</tbody>
					</table>
				</div></br>
				<!-- <div class="row">
					<div class="col-md-10"></div><div class="col-md-2">
						<button type="submit" class="btn btn-md btn-danger btn-block">Delete selection</button>
					</div>
				</div>--> 
			</form>
		</div>

	</body>
	
	<?php
	echo "</br></br>";
	include("pied_de_page.php");
	?>
	
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script>
	
	<script type="text/javascript">
		//Ouvrir la popup pour afficher les différentes versions
		function popup() {
			var versions;
			versions = document.getElementById("btnVersions").value; 							
			window.open('US3_11_Visualiser_liste_fichiers_P2.php?name='+versions,'newWin','width=1000,height=400');
		}	
		
		//Ouvrir la page "edit file"
		function edit_file() {
			var id_file;
			id_file = document.getElementById("btnEditFile").value; 
			document.location.href="/Edit_file.php?id_file="+id_file;
		}
		
		//Ouvrir la page "edit metadata"
		function edit_metadata() {
			var id_file;
			id_file = document.getElementById("btnEditMetadata").value; 
			document.location.href="/Edit_metadata.php?id_file="+id_file;
		}
	
	</script>
	
</html>
