<?php
require "./tab_donnees/funct_connex.php";
require_once 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
libxml_use_internal_errors(true);
$con = new Connex();
$connex = $con->connection;
//Get variable from form
$id_file=$_GET['original_id'];
$query = "SELECT file_name,file_place, id_format FROM  files  where id_file = ".$id_file." ";
$result = pg_query($connex, $query) or die(pg_last_error());
while ($row = pg_fetch_array($result)) {
	$place = $row[1];
	$format= $row[2];
	$link = $row[1]."".$row[0];
}

// Chargement du fichier Excel
$objPHPExcel = PHPExcel_IOFactory::load("".$link."");
 
/**
* récupération de la première feuille du fichier Excel
* @var PHPExcel_Worksheet $sheet
*/
$sheet = $objPHPExcel->getSheet(0);
 
echo '<table border="1">';
 
// On boucle sur les lignes
foreach($sheet->getRowIterator() as $row) {
 
   echo '<tr>';
 
   // On boucle sur les cellule de la ligne
   foreach ($row->getCellIterator() as $cell) {
      echo '<td>';
      print_r($cell->getValue());
      echo '</td>';
   }
 
   echo '</tr>';
}
echo '</table>';
?>

