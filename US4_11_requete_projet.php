

<link rel="stylesheet" href="css/bootstrap.min.css">

<?php
include('menu_administrateurs.html');

require "tab_donnees.class.php";
require "funct_connex.php";

$con = new Connex();
$connex = $con->connection;

//parametrage de la requete
$query = "SELECT name_project FROM projects";


//execution de la requete et récuperation des resultats
$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());

echo "<div class='container'>";

echo "<table class='table'>";

$n = pg_num_rows($result);
$modulo = $n%4;

for ($i=0; $i<($n-$modulo)/4; $i++){
  echo "<tr>";
  for ($j=0; $j <4 ; $j++) {
    echo "<td>";
    $row=pg_fetch_array($result);

    echo "<button type='button' class='btn btn-light btn-lg btn-block'>";
    echo $row[0];
    echo "</button>";


    echo "</td>";
  }
  echo"</tr>";
}
echo "<tr>";
for ($k=0; $k <$modulo ; $k++) {
  echo "<td>";
  $row=pg_fetch_array($result);
  echo "<button type='button' class='btn btn-light btn-lg btn-block'>";
  echo $row[0];
  echo "</button>";

  echo "</td>";
}

echo "</tr>";

echo "</table>";

echo "</div>";

?>
