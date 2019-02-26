<html>
<?php
session_start();
require "./tab_donnees/tab_donnees.class.php";
require "./tab_donnees/funct_connex.php";

if (isset($_GET['Comment'])) {
	$comment = $_GET['Comment'];
	echo $comment . '<br/>';
}

if (isset($_GET['Latitude'])) {
	$lat = $_GET['Latitude'];
	echo $lat . '<br/>';
}

if (isset($_GET['Longitude'])) {
	$long = $_GET['Longitude'];
	echo $long . '<br/>';
}

if (isset($_GET['daterange'])) {
	$date = $_GET['daterange'];
	echo $date . '<br/>';
}

if (isset($_GET['lst_proj'])) {
	$id_proj = $_GET['lst_proj'];
	echo $id_proj . '<br/>';
}

//Get selected tags
$all_tags = array(); //empty list will contain all selected tags id
$con = new Connex();
$connex = $con->connection;
$query = "SELECT id_tag FROM  tags  ";
$result = pg_query($connex, $query) or die(pg_last_error());
//for all tags check if tag selected
while ($row = pg_fetch_array($result)) { 
	$var=$_GET[$row["id_tag"]."_tag"];
	if ($var == "on") { //if checkbox checked
		array_push($all_tags, $row["id_tag"]); //add tag id to array
	}
}

//Get all infos on uploaded file
$filename = $_SESSION["upload_filename"];
$location = $_SESSION["upload_location"];
$upload_date = $_SESSION["upload_date"];
$filesize = $_SESSION["upload_file_size"];

$con = new Connex();
$connex = $con->connection;
$query = 'INSERT INTO fichiers(id_client,nom_client,prenom_client,adresse_client,cp_client,ville_client,tel_client,site_client,mail_client,photo_client) VALUES ("'.$code.'","'.$nom.'","'.$prenom.'","'.$adresse.'","'.$codepostal.'","'.$ville.'","'.$Tel.'","'.$site.'","'.$mail.'","'.$chill.'")';

?>