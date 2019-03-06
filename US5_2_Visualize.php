<?php
require "./tab_donnees/funct_connex.php";
$con = new Connex();
$connex = $con->connection;
//Get variable from form
$id_file=$_GET['original_id'];
$query = "SELECT file_name,file_place FROM  files  where id_file = ".$id_file." ";
$result = pg_query($connex, $query) or die(pg_last_error());
while ($row = pg_fetch_array($result)) {
	$place = $row[1];
	echo $row[0];
	$link = $row[1]."".$row[0];
}
?>

<img src=<?php echo "".$link.""; ?> width="1000" height="400" alt="L'image">