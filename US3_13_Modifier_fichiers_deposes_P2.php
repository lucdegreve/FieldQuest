<!doctype html> 

<html lang="en">

	<head>	
	<!-- Développeurs: JB, Fagniné & Elsa 
	Page to update data of the modified file in the database and to confirm it to the user -->
	
	<link href="css/custom.css" rel="stylesheet" type="text/css">
	<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
	<script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
	<script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>
	
	<title>Your modification has been considered</title>
	</head>
	
	<body>

		<?php
		session_start();
		$id_file=$_SESSION["id_file"];
		//Header
		include("en_tete.php");
		echo "</br>";
		//DB connection
		require "./tab_donnees/funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		
		//On met une valeur en dur pour l'id_user_account pour l'instant
		$id_user_account=1;
		
		//Get id_original_file
		$result_original_id=pg_query($connex, "SELECT id_original_file FROM files WHERE id_file=".$id_file) or die('Échec de la requête : ' . pg_last_error());
		while($row=pg_fetch_array($result_original_id)){
			$original_id=$row[0];
		}

		//Tous les echo ci dessous ne seront pas présents plus tard mais ils aident pour travailler sur la page !
		echo "File name : ".$_SESSION["upload_filename"]."<br/>";
		echo "File location : ".$_SESSION["upload_location"]."<br/>";
		echo "File modification date : ".$_SESSION["upload_date"]."<br/>";
		echo "File new size (octet) : ".$_SESSION["upload_file_size"]."<br/>";
		echo "ID of the modified file : ".$id_file."</br>";
		echo "ID of the original file : ".$original_id."</br>";
		echo "ID of the user account : ".$id_user_account."</br>";
		
		//Get the last version of the file
		$result_max_version=pg_query($connex, "SELECT MAX(id_version) FROM files WHERE id_original_file=".$original_id) or die('Échec de la requête : ' . pg_last_error());
		$max_version=pg_fetch_array($result_max_version)[0];
		$max_version=$max_version + 1;
		echo "Version à affecter à ce nouveau fichier : ".$max_version."</br>";
		
		//Get new file format
		$file_extension=end(explode('.',$_SESSION["upload_filename"]));
		//Get format ID's
		$result_formats=pg_query($connex, "SELECT label_format, id_format FROM format") or die('Échec de la requête : ' . pg_last_error());
		//Check if format already exists and store id/label if so
		while($row=pg_fetch_array($result_formats)) {
			if($row[0]==$file_extension){
				$id_format=$row[1];
				break;
			}
		}		
		//If not, creating a new format
		if(isset($id_format)){
			$id_format=$id_format;
		}
		else{
			//Create a new format into DB
			$result_new_format=pg_query($connex, "INSERT INTO format (label_format) VALUES('".$file_extension."')") or die('Échec de la requête : ' . pg_last_error());
			//Find id for this new format in DB
			$result_new_id_format=pg_query($connex, "SELECT label_format, id_format FROM format") or die('Échec de la requête : ' . pg_last_error());
			while($row=pg_fetch_array($result_new_id_format)) { 
				if($row[0]==$file_extension){
					$id_format=$row[1];
					break;
				}
			}
		}
		echo "Format du nouveau fichier : ".$id_format." ".$file_extension."</br>";
		
		//Get new comment
		$comment=$_GET['Comment'];
		echo "Commentaire : ".$comment."</br>";
		
		//Get start and end dates
			//Date from the daterange picker
			$date=$_GET['daterange'];
			//Start & end dates from DRP us format
			$start_date = substr($date,0,10);
			$end_date = substr($date,-10,10);
			//Cut to create dates in french format
			$monthdeb = substr($start_date,0,2);
			$daydeb = substr($start_date,3,2);
			$yeardeb = substr($start_date,6,4);
			$monthend = substr($end_date,0,2);
			$dayend = substr($end_date,3,2);
			$yearend = substr($end_date,6,4);
			//Real dates
			$start_date = $daydeb."/".$monthdeb."/".$yeardeb;
			$end_date = $dayend."/".$monthend."/".$yearend;
		echo "Start date : ".$start_date." & End date : ".$end_date."</br>";
		
		//Get the new projects
			//A CODER
			
		//Get new latitude and longitude
		
			

		//It will be an insert and not an update finally. We recuperate some metadata of the modified data and we create an insertion with the new file, indicating the id of the original file"
		//Insertion of the data for the modified file which has been upladed previously
		$query="INSERT INTO files (id_user_account, id_format, id_validation_state, id_version, upload_date, file_name, file_place, file_size, id_original_file, file_comment, data_init_date, data_end_date) VALUES (".$id_user_account.",".$id_format.",2,".$max_version .",'".$_SESSION["upload_date"]."','".$_SESSION["upload_filename"]."','".$_SESSION["upload_location"]."',".$_SESSION["upload_file_size"].",".$original_id.",'".$comment."','".$start_date."','".$end_date."')"; 
		$query_result = pg_query($connex,$query) or die (pg_last_error() );
		?>
	
		<div class="container">
			<h1  align="center">Your modification has been considered !</h1></br>
			<div align="center">
				<form action="US3_11_Visualiser_liste_fichiers.php" method="GET">
					<button type="submit" class="btn btn-md btn-primary">Previous page</button>
				</form>
			</div>
		</div></br>

	</body>
 
	<?php
	echo "</br>";
	include("pied_de_page.php");
	?>

</html>
