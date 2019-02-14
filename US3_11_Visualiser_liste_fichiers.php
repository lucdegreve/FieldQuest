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
		include("tab_donnees.class.php");
		//DB connection
		include("funct_connex.php");
		$con=new Connex();
		$connex=$con->connection;
		//Query
		$result_files_names=pg_query($connex, "SELECT file_name, MAX(upload_date) FROM files GROUP BY file_name ORDER BY MAX(upload_date) DESC") or die('Échec de la requête : ' . pg_last_error());
		$nbrows=pg_num_rows($result_files_names);
		?>

		<!-- Header creation -->
		<div class="jumbotron jumbotron-fluid">
			<h1>Header</h1>
		</div>

		<div class="container">
			<div class="row">
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th scope="col" width="30%">File name</th>
							<th scope="col" width="25%">Upload date</th>
							<th scope="col" width="20%">Origin</th>
							<th scope="col" width="10%">Size</th>
							<th scope="col" width="2%">State</th>
							<th scope="col" width="13%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($row=pg_fetch_array($result_files_names)){
							$file_name=$row[0];
							$query="SELECT file_name, upload_date, f.id_user_account, file_size, label_validation_state, id_version, last_name, first_name
							FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account JOIN validation_state vs ON f.id_validation_state=vs.id_validation_state
							WHERE file_name='".$file_name."' AND id_version=(SELECT MAX(id_version) FROM files WHERE file_name='".$file_name."')";
							$result_files_list=pg_query($connex, $query) or die('Échec de la requête : ' . pg_last_error());
							while($col=pg_fetch_array($result_files_list)){
								$name=$col[0];
							$date=$col[1];
								$user=$col[2];
								$size=$col[3];
								$valid=$col[4];
								$version=$col[5];
								$lname=$col[6];
								$fname=$col[7];
							}
							if($valid=="being checked"){
								echo "<tr class='table-active'>";
									echo "<th scope='row'>".$name."</th>";
									echo "<th scope='row'>".$date."</th>";
									echo "<th scope='row'>".$fname." ".$lname."</th>";
									echo "<th scope='row'>".$size."</th>";
									echo "<th scope='row'></th>";
									echo "<td>";
										echo "<form method='GET' action='#'>";
											echo "<input type='submit' class='btn btn-sm btn-warning' value='Standardize'>";
										echo "</form>";
									echo "</td>";
								echo "</tr>";
							}
							if($valid=="not validated"){
								echo "<tr>";
									echo "<td>".$name."</td>";
									echo "<td>".$date."</td>";
									echo "<td ".$bold.">".$fname." ".$lname."</td>";
									echo "<td ".$bold.">".$size."</td>";
									echo "<td ".$bold."><img src='pict/refused.png' width='27' height='27'/></td>";
									echo "<td></td>";
								echo "</tr>";
							}
							if($valid=="validated"){
								echo "<tr>";
									echo "<td>".$name."</td>";
									echo "<td>".$date."</td>";
									echo "<td ".$bold.">".$fname." ".$lname."</td>";
									echo "<td ".$bold.">".$size."</td>";
									echo "<td ".$bold."><img src='pict/validated.png' width='30' height='30'/></td>";
									echo "<td>";
										echo "<form method='GET' action=''>";
											echo "<button type='submit' class='btn btn-sm btn-primary' name='versions' value='".$name."'>See versions</button>";
										echo "</form>";
									echo "</td>";
								echo "</tr>";
								if(isset($_GET['versions'])){
									$name=$_GET['versions'];
									//Query
									$query="SELECT upload_date, f.id_user_account, file_size, label_validation_state, id_version, last_name, first_name
									FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account JOIN validation_state vs ON f.id_validation_state=vs.id_validation_state
									WHERE file_name='".$name."' AND id_version NOT IN (SELECT MAX(id_version) FROM files WHERE file_name='".$name."')
									ORDER BY id_version DESC";
									$result_versions=pg_query($connex, $query) or die('Échec de la requête : ' . pg_last_error());
									$nbrows=pg_num_rows($result_versions);
									while($col=pg_fetch_array($result_versions)){
										$date=$col[0];
										$user=$col[1];
										$size=$col[2];
										$valid=$col[3];
										$version=$col[4];
										$lname=$col[5];
										$fname=$col[6];
										echo "<tr class='table-info'>";
											echo "<td>".$name."</td>";
											echo "<td>".$date."</td>";
											echo "<td>".$fname." ".$lname."</td>";
											echo "<td>".$size."</td>";
											echo "<td>".$valid."</td>";
											echo "<td>Version ".$version."</td>";
										echo "</tr>";
									}
								}
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>

	</body>

</html>
