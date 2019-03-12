<?php

	/* Developpeur : Gala
	
	Get JSON file from prevision-meteo.ch API.
	Insert in DB with all "meteo" tags (id_tag_type = 1)
	Automatic deposit with validated status
	No project selected
	*/

	require "./tab_donnees/tab_donnees.class.php";
	require "./tab_donnees/funct_connex.php";

	//ICI METTRE LES VAR DE SESSION AU LIEU DE METTRE EN DUR
	$id_user=5;
	$user_type=1;

	$origin=$id_user;
	//get JSON
	$json = file_get_contents('https://www.prevision-meteo.ch/services/json/lat=46.259lng=5.235');

	//decode JSON to array
	$data = json_decode($json, true);
	
	$date = new DateTime();
	$date_today = $date->format('m-d-Y');
	$file_place = "US_2_21_dragdrop_upload/";
	
	$file = $date->getTimestamp() . $date_today.'_weather_data_api.json';
	// Ouvre un fichier pour lire un contenu existant
	$current = $json;
	// Écrit le résultat dans le fichier
	file_put_contents($file_place.$file, $current);
	
	$file_name = $file;
	
	$file_size = filesize($file_place.$file_name);

	$comment="Data from www.prevision-meteo.ch API";
	$longitude= "46.259";
	$latitude = "5.235";
	$file_projet= "";
	// date from the daterange picker
	$date=$date_today;
	//get file format
	$file_extension = end(explode('.',$file_name));
	
	// start&end date from DRP us format
	$start_date = substr($date,0,10);
	$end_date = substr($date,-10,10);

	// cutting sto create Date in French Format
	$monthdeb = substr($start_date,0,2);
	$daydeb = substr($start_date,3,2);
	$yeardeb = substr($start_date,6,4);

	// real starting date
	$starting_date = $daydeb."/".$monthdeb."/".$yeardeb;

	// to create Date in French Format
	$monthend = substr($end_date,0,2);
	$dayend = substr($end_date,3,2);
	$yearend = substr($end_date,6,4);

	// real ending date
	$ending_date = $dayend."/".$monthend."/".$yearend;


	//get todays date and turn it into en date
	$today_en = date("m/d/y");
	$todD = substr($today_en,0,2);
	$todM = substr($today_en,3,2);
	$todY = substr($today_en,6,4);
	$today_fr= $todM."/".$todD."/".$todY;    //date at good format
	
	$all_tags = array();
	$con = new Connex();
	$connex = $con->connection;
	$query = "SELECT id_tag FROM  tags WHERE id_tag_type=1 ";
	$result = pg_query($connex, $query) or die(pg_last_error());
	//get all "meteo" tags
	while ($row = pg_fetch_array($result)) {
		echo $row["id_tag"];
		array_push($all_tags, $row["id_tag"]); //add tag id to array
	}
	
	// getting format id
	$query = "SELECT label_format, id_format FROM format";
	$result = pg_query($connex, $query) or die(pg_last_error());
	
	//finding if format already exists and adding id if so
	while ($row = pg_fetch_array($result)) {
		if ($row[0]==$file_extension){
			$file_format=$row[1];
			break;
		}
	}
	// or creating format and id
	if (isset($file_format)){
		$file_format=$file_format;
			}
	else{
		// creating format into db
			$query = "INSERT INTO format(label_format) VALUES('".$file_extension."') ";
			$result = pg_query($connex, $query) or die(pg_last_error());
			//finding new id  for this format in DB
			$query = "SELECT label_format, id_format FROM format";
			$result = pg_query($connex, $query) or die(pg_last_error());
			while ($row = pg_fetch_array($result)) {
				if ($row[0]==$file_extension){
					$file_format=$row[1];
					break;
				}
			}
	}
	
	$id_validation_state=2;
	
	$query = "INSERT INTO files(id_user_account,use_id_user_account,id_format,id_validation_state,id_version,upload_date, file_name, file_comment, data_init_date,data_end_date,latitude,longitude,file_place,file_size,id_original_file)
		VALUES ('".$origin."','".$origin."','".$file_format."','".$id_validation_state."',1,'".$today_fr."','".$file_name."','".$comment."','".$starting_date."','".$ending_date."','".$latitude."','".$longitude."','".$file_place."','".$file_size."',0)";

	/* $query = "INSERT INTO files(id_user_account,use_id_user_account,id_format,id_validation_state,id_version,upload_date, file_name, file_comment, data_init_date,data_end_date,latitude,longitude,file_place,id_original_file)
	VALUES ('".$origin."','".$origin."','".$file_format."','".$id_validation_state."',
	1,'".$today_fr."','".$file_name."','".$comment."','".$starting_date."','".$ending_date."','".$latitude."','".$longitude."','".$file_place."',0)"; */
	$query_result = pg_query($connex,$query) or die (pg_last_error() );

//getting file's id from DB to put tags into DB

	$query = "SELECT id_file FROM  files where file_name='".$file_name."'";
	$result = pg_query($connex, $query) or die(pg_last_error());
	while ($row = pg_fetch_array($result)) {
	$id_now=$row[0];
	}

	// add id_original_file
	$query = "UPDATE files SET id_original_file =" .$id_now. " WHERE id_file=" . $id_now;
	$query_result = pg_query($connex,$query) or die (pg_last_error() );


	// inserting tags into DB
	$nb_tags = count($all_tags);
	for ($i=0;$i<$nb_tags;$i++){
		$query = "insert into link_tag_project (id_file,id_tag)
					VALUES ('".$id_now."','".$all_tags[$i]."')";
		$query_result = pg_query($connex,$query) or die (pg_last_error() );
	}

	// insert file and projet link (multiple projects)
	if(isset($_GET['projet']) && !empty($_GET['projet'])){
		$Col1_Array = $_GET['projet'];
		foreach($Col1_Array as $selectValue){
			$query = "insert into link_file_project (id_file,id_project)
					VALUES ('".$id_now."','".$selectValue."')";
			$query_result = pg_query($connex,$query) or die (pg_last_error() );
		}
	}

?> 