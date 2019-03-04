<?php

require "./tab_donnees/tab_donnees.class.php";
require "./tab_donnees/funct_connex.php";

$con = new Connex();
$connex = $con->connection;
$result2= pg_query($connex, "SELECT * FROM tag_type");
$arr = pg_fetch_all($result2);
$nbenr= count($arr);
for ($i=0;$i<$nbenr;$i++){
	echo pg_fetch_result($result2, $i, 1);
}

 echo '</form>';
?>