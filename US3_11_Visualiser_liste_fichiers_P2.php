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
		//DB connection
		include("tab_donnees/funct_connex.php");
		$con=new Connex();
		$connex=$con->connection;
		//Get variable
		$name=$_GET['name'];
		//Query
		$query="SELECT id_file, to_char(upload_date,'DD/MM/YYYY'), file_size, id_version, last_name, first_name
		FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account JOIN validation_state vs ON f.id_validation_state=vs.id_validation_state
		WHERE file_name='".$name."'
		ORDER BY id_version DESC";
		$result_versions=pg_query($connex, $query) or die('Échec de la requête : ' . pg_last_error());
		$nbrows=pg_num_rows($result_versions);
		?>
		
		<div class="container-fluid">
			<table class='table'>
				<thead class="thead-dark">
					<tr>
						<th scope="col" width="35%">File name</th>
						<th scope="col" width="20%">Upload/update date</th>
						<th scope="col" width="25%">Origin/editor</th>
						<th scope="col" width="10%">Size</th>
						<th scope="col" width="10%">Version</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($col=pg_fetch_array($result_versions)){
						$id_file=$col[0];
						$date=$col[1];
						$size=$col[2];
						$version=$col[3];
						$last_name=$col[4];
						$first_name=$col[5];
						echo "<tr class='table-info'>";
							echo "<td>".$name."</td>";
							echo "<td>".$date."</td>";
							echo "<td>".$first_name." ".$last_name."</td>";
							echo "<td>".$size."</td>";
							echo "<td>".$version."</td>";
						echo "</tr>";
					}?>
				</tbody>
			</table>
		</div>

	</body>
	
</html>