<!DOCTYPE html>
<html>
<head>
	
	
	
	<title>Wathing as a map</title>
	<!-- downloading leaflet libraries -->

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.2.3/leaflet.draw.js"> </script>
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>



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
        color: '#97009c'
      }
    },
    // disable toolbar item by setting it to false
    polyline: false,
    circle: false, // Turns off this drawing tool
    rectangle: false,
    marker: false,
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

map.on('draw:created', function(e) {
  var type = e.layerType,
    layer = e.layer;

  if (type === 'marker') {
    layer.bindPopup('A popup!');
  }

  editableLayers.addLayer(layer);
});

	
<?php 
// looping on every result
for ($j=0;$j<count($fichresult);$j++){ 
// lien pour le telechargement, a modifier une fois que le serveur sera disponible
	$link=$fichresult[$j][4]."".$fichresult[$j][3];
	?>
	var greenIcon = new LeafIcon({iconUrl: 'dot.png'}),
		redIcon = new LeafIcon({iconUrl: 'dot.png'}),
		orangeIcon = new LeafIcon({iconUrl: 'dot.png'});
	<?php
	//ensure we have all geolocalisation datas
	if  ($fichresult[$j][1]!=null and $fichresult[$j][2]!=null ){
		
	?> 
	L.marker([<?php echo$fichresult[$j][2].",".$fichresult[$j][1];?>], {icon: greenIcon}).bindPopup(<?php echo "'".$fichresult[$j][5]." </br> Telecharger: <a href = ".$link." download>Website</a></li> '"; ?> ).addTo(map);
	<?php
	}
}
	?>
</script>



</body>
</html>