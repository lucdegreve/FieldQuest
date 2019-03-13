<!doctype html> 

<?php
//Header
include("en_tete.php");
echo "</br>";
?>

<html lang="en">

	<head>	
	<!-- Développeurs: JB, Fagniné & Elsa 
	Page to update data of the modified file in the database and to confirm it to the user -->
	
	<link href="css/custom.css" rel="stylesheet" type="text/css">
	<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
	<script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
	<script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>
	</head>
	
	<body>

		<?php
		$id_file=$_SESSION["id_file"];
		//DB connection
		require "./tab_donnees/funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		//Get id of the user
		$id_user=$_SESSION['id_user_account'];
		$user_type=$_SESSION['id_user_type'];
		
	//IF A NEW FILE HAS BEEN SELECTED
		if(isset($_GET['new_file'])){
		
			//Get id_original_file and id_user_account
			$result_original_id=pg_query($connex, "SELECT id_original_file, id_user_account FROM files WHERE id_file=".$id_file) or die('Échec de la requête : ' . pg_last_error());
			while($row=pg_fetch_array($result_original_id)){
				$original_id=$row[0];
				$id_user_account=$row[1];
			}
			
			//Get the last version of the file
			$result_max_version=pg_query($connex, "SELECT MAX(id_version) FROM files WHERE id_original_file=".$original_id) or die('Échec de la requête : ' . pg_last_error());
			$max_version=pg_fetch_array($result_max_version)[0];
			$max_version=$max_version + 1;
			
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
			
			//Get new comment
			$comment=$_GET['Comment'];
			
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
				
			//Get new latitude and longitude
			$longitude= $_SESSION['longitude'];
			$latitude = $_SESSION['latitude'];		
			
			//Get new tags
			$selected_tags=array(); //Empty list which will contain all selected tags id
			$result_id_tag=pg_query($connex, "SELECT id_tag, tag_name FROM  tags") or die(pg_last_error());
			//For every tag, check if tag is selected
			while($row=pg_fetch_array($result_id_tag)) { 
				$var=$_GET[$row["id_tag"]."_tag"];
				if ($var == "on") { //If checkbox is checked...
					array_push($selected_tags, $row["id_tag"]); //... add tag id to array
				}
			}
			
			
			//Insertion of the data for the modified file which has been uploaded previously
			$query_insert="INSERT INTO files (id_user_account, use_id_user_account, id_format, id_validation_state, id_version, upload_date, file_name, file_place, file_size, id_original_file, file_comment, data_init_date, data_end_date, latitude, longitude) VALUES (".$id_user_account.",".$id_user.",".$id_format.",2,".$max_version .",'".$_SESSION["upload_date"]."','".$_SESSION["upload_filename"]."','".$_SESSION["upload_location"]."',".$_SESSION["upload_file_size"].",".$original_id.",'".$comment."','".$start_date."','".$end_date."','".$latitude."','".$longitude."')"; 
			$result_insert=pg_query($connex,$query_insert) or die (pg_last_error() );
			
			//Get file's ID from DB to put projects and tags into DB		
			$result_new_id=pg_query($connex, "SELECT id_file FROM files WHERE file_name='".$_SESSION["upload_filename"]."'") or die(pg_last_error());
			while($row = pg_fetch_array($result_new_id)) { 
				$new_id=$row[0];
			}			
			
			//Get the new projects and insert them in the DB
			if(isset($_GET['projet']) && !empty($_GET['projet'])){ 
				$Col1_Array = $_GET['projet']; 
				foreach($Col1_Array as $selectValue){
					$result_projects=pg_query($connex, "INSERT INTO link_file_project (id_file, id_project) VALUES (".$new_id.",'".$selectValue."')") or die (pg_last_error() );
				} 
			}
			
			//Insert tags into DB
			$nb_tags=count($selected_tags);
			if($nb_tags!=0){
				for($i=0;$i<$nb_tags;$i++){
					$result_insert_tags=pg_query($connex, "INSERT INTO link_tag_project (id_file, id_tag) VALUES (".$new_id.",'".$selected_tags[$i]."')") or die (pg_last_error() );
				}
			}
			
		}
		
	//IF THERE IS NO NEW FILE
		else{
			
			//Get new comment
			$comment=$_GET['Comment'];
			
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
				
			//Get new latitude and longitude
			$longitude= $_SESSION['longitude'];
			$latitude = $_SESSION['latitude'];

			//Get new tags
			$selected_tags=array(); //Empty list which will contain all selected tags id
			$result_id_tag=pg_query($connex, "SELECT id_tag, tag_name FROM  tags") or die(pg_last_error());
			//For every tag, check if tag is selected
			while($row=pg_fetch_array($result_id_tag)) { 
				$var=$_GET[$row["id_tag"]."_tag"];
				if ($var == "on") { //If checkbox is checked...
					array_push($selected_tags, $row["id_tag"]); //... add tag id to array
				}
			}
			
			
			//Insertion of the data for the modified file which has been uploaded previously
			$query_update="UPDATE files SET id_validation_state=2, file_comment='".$comment."', data_init_date='".$start_date."', data_end_date='".$end_date."', latitude='".$latitude."', longitude='".$longitude."' WHERE id_file=".$id_file; 
			$result_update=pg_query($connex,$query_update) or die (pg_last_error() );
			
			//Delete former projects in the DB
			$result_delete_projects=pg_query($connex, "DELETE FROM link_file_project WHERE id_file=".$id_file) or die (pg_last_error() );
			
			//Get the new projects and insert them in the DB
			if(isset($_GET['projet']) && !empty($_GET['projet'])){ 
				$Col1_Array = $_GET['projet']; 
				foreach($Col1_Array as $selectValue){
					$result_projects=pg_query($connex, "INSERT INTO link_file_project (id_file, id_project) VALUES (".$id_file.",'".$selectValue."')") or die (pg_last_error() );
				} 
			}
			
			//Delete former tags in the DB
			$result_delete_tags=pg_query($connex, "DELETE FROM link_tag_project WHERE id_file=".$id_file) or die (pg_last_error() );
			
			//Insert new tags into DB
			$nb_tags=count($selected_tags);
			if($nb_tags!=0){
				for($i=0;$i<$nb_tags;$i++){
					$result_insert_tags=pg_query($connex, "INSERT INTO link_tag_project (id_file, id_tag) VALUES (".$id_file.",'".$selected_tags[$i]."')") or die (pg_last_error() );
				}
			}
			
		}		
		?>
	
		<div class="container">
			<h1  align="center">Your modification has been considered !</h1></br>
			<div align="center">
				<form action="US4-11_Main_page_filter.php" method="GET">
					<button type="submit" class="btn btn-md btn-primary">Back to the files list</button>
				</form>
			</div>
		</div></br>
		
		<?php
		//Reset of $_SESSION variables
		$_SESSION["upload_filename"]="";
		$_SESSION["upload_location"]="";
		$_SESSION["upload_date"]="";
		$_SESSION["upload_file_size"]="";
		$_SESSION['longitude']="";
		$_SESSION['latitude']="";
		?>

	</body>
 
	<?php
	echo "</br>";
	include("pied_de_page.php");
	?>

</html>
