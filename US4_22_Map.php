<!DOCTYPE html>
<html>
<head>
<!-----------------------------------------------------------
       US4-22 & US4-21 - Map to display localisation of files 

Developped by Ophélie using "US4_11_Carte.php" as an example.
This page will be used in "US4_22_Main_page_history_with_filters.php"			      
	
------------------------------------------------------------->		
	<title>Results from request</title>
	<!-- downloading leaflet libraries -->

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
	<script src="https://unpkg.com/leaflet-draw@1.0.2/dist/leaflet.draw.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.2/dist/leaflet.draw.css" />


	<!-- creating map style -->
	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		#map {
			width: 800px;
			height: 600px;
		}
	</style>	
</head>
<body>

<div id='map'></div>

<?php

//$id_user=$_SESSION['id_user_account']; // Get id of user 

require_once "Zip_classes/src/zip.php";

    $zip = new Zip();
    $zip->zip_start("zip_map_file.zip");

// real query that'll be used when pages are linked


$query_map = "SELECT f.id_file as id_file, f.latitude as latitude, f.longitude as longitude, f.file_name as file_name, f.file_place as file_place, f.file_comment as file_comment
                FROM files f
                    LEFT JOIN version v on f.id_version = v.id_version
                    LEFT JOIN link_file_project lfp ON lfp.id_file=f.id_file
                    LEFT JOIN projects p ON lfp.id_project=p.id_project
                    LEFT JOIN format fr ON fr.id_format=f.id_format
                    LEFT JOIN user_account u ON u.id_user_account=f.id_user_account
                    LEFT JOIN link_tag_project ltp ON ltp.id_file=f.id_file
                    LEFT JOIN tags t ON t.id_tag=ltp.id_tag
                WHERE f.id_user_account = '".$id_user."' AND ";
                
                if ($_POST['start']!=''){
                        $start_date = $_POST['start'];
                        $query_map .= " f.upload_date >'".$start_date."' AND ";
                }
                
                if ($_POST['end']!=''){
                        $end_date = $_POST['end'];
                        $query_map .= " f.upload_date <'".$end_date."' AND ";
                }
                
                if (isset($_POST['format'])){
                        $query_map .= " f.id_format IN (";
                        foreach ($_POST['format'] AS $i){
                                $query_map .= $i.", ";
                        }
                        $query_map = substr($query_map, 0, strlen($query_map) -2);
                        $query_map .= ")";
                        $query_map .= " AND ";
                }
                
                if (isset($_POST['projet'])){
                        $query_map .= " lfp.id_project IN (";
                        foreach ($_POST['projet'] AS $i){
                                $query_map .= $i.", ";
                        }
                        $query_map = substr($query_map, 0, strlen($query_map) -2);
                        $query_map .= ")";
                        $query_map .= " AND ";
                }
                
                $TAG_SLD='(';
                if (isset($_POST['unit'])){
                        foreach ($_POST['unit'] AS $i){
                                $TAG_SLD .= $i.", ";
                        }
                        echo '</br>';
                }
                
                if (isset($_POST['tag'])){
                        foreach ($_POST['tag'] AS $i){
                                $TAG_SLD .= $i.", ";
                        }
                        echo '</br>';
                }
                if ($TAG_SLD!='('){
                        
                        $query_map .= " ltp.id_tag IN ".$TAG_SLD;
                        $query_map = substr($query_map, 0, strlen($query_map) -2);
                        $query_map .= ")";
                }
                
                
                if (substr($query_map, -6)=='WHERE '){
                    $query_map = substr($query_map, 0, strlen($query_map) -6);
                }
                
                if (substr($query_map, -4)=='AND '){
                    $query_map = substr($query_map, 0, strlen($query_map) -4);
                }
		$query_map .= " GROUP BY f.id_file";
	
$query = "SELECT id_file, latitude, longitude, file_name,file_place, file_comment FROM  files  ";
$result = pg_query($connex, $query_map) or die(pg_last_error());

//creating a list of lists containing all the needed informations
$fichresult=array();
while ($row = pg_fetch_array($result)) { 
	$fich = array();
	for ($i=0;$i<=6;$i++){
		array_push($fich, $row[$i]);
	}
	array_push($fichresult,$fich);
}
	$link=$fichresult[$j][4]."".$fichresult[$j][3];
	echo $link;

?>

<script>

// creatinG the map
	var dll_link = '';
	var map = L.map('map').setView([2.7246093749999925,48.57478976304037], 2);
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);


	// variables of the icon
	var LeafIcon = L.Icon.extend({
		options: {
			shadowUrl: 'dot.png',
			iconSize:     [25,25],
			shadowSize:   [0, 0],
			iconAnchor:   [10, 10],
			shadowAnchor: [0, 0],
			popupAnchor:  [0, 0]
		}
	});
	
var editableLayers = new L.FeatureGroup();
map.addLayer(editableLayers);

// Initialise the FeatureGroup to store editable layers
var editableLayers = new L.FeatureGroup();
map.addLayer(editableLayers);

var drawPluginOptions = {
  position: 'topright',
  draw: {
    polygon: {
      allowIntersection: false, // Restricts shapes to simple polygons
      drawError: {
        color: '#e1e100', // Color the shape will turn when intersects
        message: '<strong>Oh snap!<strong> you can\'t draw that!' // Message that will show when intersect
      },
      shapeOptions: {
        color: '#4ACE32'
      }
    },
    // disable toolbar item by setting it to false
    polyline: false,
    circle: false, // Turns off this drawing tool
    //rectangle: false,
    marker: false,
	circlemarker: false,
    },
  edit: {
    featureGroup: editableLayers, //REQUIRED!!
    remove: false
  }
};

// Initialise the draw control and pass it the FeatureGroup of editable layers
var drawControl = new L.Control.Draw(drawPluginOptions);
map.addControl(drawControl);

var editableLayers = new L.FeatureGroup();
map.addLayer(editableLayers);

//what happens when a polygon is created
map.on('draw:created', function(e) {
	//if user confirms he wants to download
  var type = e.layerType,
    layer = e.layer;
	Polygon = e.layer;
	// for every query result
	<?php 
// looping on every result
for ($j=0;$j<count($fichresult);$j++){ 
// link for ddl
	$link=$fichresult[$j][4]."".$fichresult[$j][3];
	?>
	var greenIcon = new LeafIcon({iconUrl: 'dot.png'}),
		redIcon = new LeafIcon({iconUrl: 'dot.png'}),
		orangeIcon = new LeafIcon({iconUrl: 'dot.png'});
	<?php
	//ensure we have all geolocalisation datas
	if  ($fichresult[$j][1]!=null and $fichresult[$j][2]!=null ){
	?> 
	var mark = L.marker([<?php echo$fichresult[$j][2].",".$fichresult[$j][1];?>], {icon: greenIcon}).bindPopup(<?php echo "'".$fichresult[$j][5]." </br> <a href = ".$link." download>Telecharger</a></li> '"; ?> );
	mark.addTo(map);
	if(Polygon.getBounds().contains(mark.getLatLng())==true){
		dll_link=dll_link+ "<?php echo $fichresult[$j][5]."  <a href = ".$link." download>Telecharger</a></li> </br>"; ?> "
		var popup = L.popup()
		.setLatLng(Polygon.getBounds().getCenter())
		.setContent(dll_link)
		.openOn(map);
		<?php
	// Quick check to verify that the file exists
		// adresse a modifier avec la vraie du serveur TELECHARGEMENT NE FONCTIONNANT PAS
		
	?>
	}
	<?php
	}
}
	?>
// save the polygon
  editableLayers.addLayer(layer);
  dll_link="";
});



<?php 
// looping on every result
for ($j=0;$j<count($fichresult);$j++){ 
// link for ddl
	$link=$fichresult[$j][4]."".$fichresult[$j][3];
	?>
	var greenIcon = new LeafIcon({iconUrl: 'dot.png'}),
		redIcon = new LeafIcon({iconUrl: 'dot.png'}),
		orangeIcon = new LeafIcon({iconUrl: 'dot.png'});
	<?php
	//ensure we have all geolocalisation datas
	if  ($fichresult[$j][1]!=null and $fichresult[$j][2]!=null ){
		
	?> 
	// creating all the markers, with the onclickpopup, 
	L.marker([<?php echo$fichresult[$j][2].",".$fichresult[$j][1];?>], {icon: greenIcon}).bindPopup(<?php echo "'".$fichresult[$j][5]." </br> <a href = ".$link." download>Telecharger</a></li> '"; ?> ).addTo(map);
	<?php
	}
}
?>


</script>
<div id="dialog" title="Basic dialog">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>


</body>
</html>