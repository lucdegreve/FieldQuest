<!DOCTYPE html>
<html>
<head>
 <title>Working with Openlayers</title>
 <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
 		<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
 <!-- Openlayers CSS file-->
 
 <style type="text/css">
  #map{
   width:100%;
   height:600px;
  }
 </style>
 <!--Basic styling for map div, 
 if height is not defined the div will show up with 0 px height  -->
</head>
<body>
 <div id="map">
  <!-- Your map will be shown inside this div-->
 </div>
</body>
	  		Latitude : <span id="Latitude"></span> </br> </br>
			Longitude : <span id="Longitude"></span> </br> </br>
<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
 <!-- Openlayesr JS fIle -->
 <script type="text/javascript"  >
 
 // creation carte : centree sur paris 
 var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([2.7246093749999925,48.57478976304037]), // Coordinates of Paris
          zoom: 7 //Initial Zoom Level
        })
      });
	  
	  
// que faire en cas de clic 
map.on('click', function(event) {
	map.setLayerGroup(new ol.layer.Group());  // on rajoute la couche OSM car supprimee en cas de pin point
	couche = new ol.layer.Tile({
            source: new ol.source.OSM()
          });
		  map.addLayer(couche); 
		  
		  // on recupere les coordonnées du click
var coords = ol.proj.toLonLat(event.coordinate);
var marker = new ol.Feature({
  geometry: new ol.geom.Point(
    ol.proj.fromLonLat(coords)
  ), 
});
marker.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
            crossOrigin: 'anonymous',
            src: 'pinpoint2.png',
			 scale: 0.1
        }))
    }));
var vectorSource = new ol.source.Vector({
  features: [marker]
});
var markerVectorLayer = new ol.layer.Vector({
  source: vectorSource,
});
map.addLayer(markerVectorLayer);

					$.ajax({
    type: "GET",
    url: "geojsonParcelles.php",
    data:{coords:coords}, //name is a $_GET variable name here,
                           // and 'youwant' is its value to be passed 
    success: function(response) {
						document.getElementById("Latitude").innerHTML=response;
					},
					error: function() {
						alert('Erreur');
					}
})

					$.ajax({
    type: "GET",
    url: "ajax2.php",
    data:{coords:coords}, //name is a $_GET variable name here,
                           // and 'youwant' is its value to be passed 
    success: function(response) {
						document.getElementById("Longitude").innerHTML=response;
					},
					error: function() {
						alert('Erreur');
					}
})
            });
		

	  </script>
	  

	  
</html>