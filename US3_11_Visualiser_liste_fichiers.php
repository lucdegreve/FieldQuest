<html>

	<head>
		<!-- Coders : Axelle & Elsa -->
		<!-- Files list, validated or not -->
		
		<META charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
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
				<?php
				/*$tab_files_names=new Tab_donnees($result_files_names,"PG");
				$tab_files_names->affich_simple_tableau_HTML();
				echo "</br></br>";*/
				echo "TEST :</br>";
				while($row=pg_fetch_array($result_files_names)){
					$file_name=$row[0];
					$query="SELECT file_name, id_version, upload_date, id_user_account, file_size, id_validation_state FROM files 
					WHERE file_name='".$file_name."' AND id_version=(SELECT MAX(id_version) FROM files WHERE file_name='".$file_name."')";
					$result_files_list=pg_query($connex, $query) or die('Échec de la requête : ' . pg_last_error());
					while($col=pg_fetch_array($result_files_list)){
						$name=$col[0];
						$version=$col[1];
						$date=$col[2];
						$user=$col[3];
						$size=$col[4];
						$valid=$col[5];
						echo $name.";".$version.";".$date.";".$user.";".$size.";".$valid."</br>";
					}
				}
				?>
			</div>
		</div>
		
	</body>

</html>