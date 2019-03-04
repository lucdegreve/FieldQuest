<?php

require "./tab_donnees/tab_donnees.class.php";
require "./tab_donnees/funct_connex.php";

$con = new Connex();
$connex = $con->connection;

$result2= pg_query($connex, "SELECT * FROM tag_type");
$tab2 = new Tab_donnees($result2,"PG");
$tab2->creer_tableau ( "class_tabl", "tablo", "id_tag_type","name_tag_type","description_tag_type");
echo '<input type="checkbox" name="vehicle1" value="Bike"><br>
<input type="checkbox" name="vehicle2" value="Car"> <br>
<input type="checkbox" name="vehicle3" value="Boat" checked><br>';

?>