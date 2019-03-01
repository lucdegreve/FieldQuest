<!DOCTYPE html>
<html>
<head>
	
	
	
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
			width: 1000px;
			height: 800px;
		}
	</style>

	
</head>
<body>

<div id='map'></div>

<?php
require "./tab_donnees/tab_donnees.class.php";
require "./tab_donnees/funct_connex.php";

//connexion to database
$con = new Connex();
$connex = $con->connection;

// real query that'll be used when pages are linked
/*
$query_map = "SELECT f.id_file, f.latitude, f.longitude,f.file_place, f.file_name, f.file_comment
			FROM files f
                            LEFT JOIN version v on f.id_version = v.id_version
                            LEFT JOIN link_file_project lfp ON lfp.id_file=f.id_file
                            LEFT JOIN projects p ON lfp.id_file=p.id_project
                            LEFT JOIN format fr ON fr.id_format=f.id_format
                            LEFT JOIN user_account u ON u.id_user_account=f.id_user_account
                            LEFT JOIN link_tag_project ltp ON ltp.id_file=f.id_file
                            LEFT JOIN tags t ON t.id_tag=ltp.id_tag
                        WHERE f.id_validation_state = '2' AND ";
                
                if ($_GET['start']!=''){
                        $start_date = $_GET['start'];
                        $query .= " f.upload_date >'".$start_date."' AND ";
                }
                
                if ($_GET['end']!=''){
                        $end_date = $_GET['end'];
                        $query .= " f.upload_date <'".$end_date."' AND ";
                }
                
                if (isset($_GET['format'])){
                        //$array_format = print_r($_GET['format'],true);
                        //print_r($array_format);
                        $query .= " f.id_format IN (";
                        foreach ($_GET['format'] AS $i){
                                $query .= $i.", ";
                        }
                        $query = substr($query, 0, strlen($query) -2);
                        $query .= ")";
                        $query .= " AND ";
                }
                
                if (isset($_GET['projet'])){
                        //$array_projet = print_r($_GET['projet'], true);
                        //print_r($array_projet);
                        $query .= " lfp.id_project IN (";
                        foreach ($_GET['projet'] AS $i){
                                $query .= $i.", ";
                        }
                        $query = substr($query, 0, strlen($query) -2);
                        $query .= ")";
                        $query .= " AND ";
                }
                
                $TAG_SLD='(';
                if (isset($_GET['unit'])){
                        //$array_unit = print_r($_GET['unit'], true);
                        foreach ($_GET['unit'] AS $i){
                                $TAG_SLD .= $i.", ";
                        }
                        echo '</br>';
                        //print_r($array_unit);
                }
                
                if (isset($_GET['tag'])){
                        //$array_tag = print_r($_GET['tag'], true);
                        foreach ($_GET['tag'] AS $i){
                                $TAG_SLD .= $i.", ";
                        }
                        echo '</br>';
                        //print_r($array_tag);
                }
                if ($TAG_SLD!='('){
                        
                        $query .= " ltp.id_tag IN ".$TAG_SLD;
                        $query = substr($query, 0, strlen($query) -2);
                        $query .= ")";
                }
                
                
                if (substr($query, -6)=='WHERE '){
                    $query = substr($query, 0, strlen($query) -6);
                }
                
                if (substr($query, -4)=='AND '){
                    $query = substr($query, 0, strlen($query) -4);
                }
		$query .= " GROUP BY f.id_file";
	*/ 
$query = "SELECT id_file, latitude, longitude, file_name,file_place, file_comment FROM  files  ";
$result = pg_query($connex, $query) or die(pg_last_error());

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
if(confirm("Do you want to download these files ?")){
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
		
		<?php
		// adresse a modifier avec la vraie du serveur TELECHARGEMENT NE FONCTIONNANT PAS
	//file_put_contents("0Z_".$fichresult[$j][3]."", file_get_contents("http://localhost/depot/FieldQuest/US_2_21_dragdrop_upload/".$fichresult[$j][3].""));
	?>
	}
	<?php
	}
}
	?>
// save the polygon
  editableLayers.addLayer(layer);
}
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



</body>
</html>