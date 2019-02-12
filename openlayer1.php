<!DOCTYPE html>
<html>
<head>
 <title>Working with Openlayers</title>
 <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
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
<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
 <!-- Openlayesr JS fIle -->
 <script type="text/javascript"  >
 var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([-74.006,40.712]), // Coordinates of New York
          zoom: 7 //Initial Zoom Level
        })
      });
	  
	  var marker = new ol.Feature({
  geometry: new ol.geom.Point(
    ol.proj.fromLonLat([-74.006,40.7127])
  ),  // Cordinates of New York's Town Hall
});

var vectorSource = new ol.source.Vector({
  features: [marker]
});

//Adding a marker on the map
var marker = new ol.Feature({
  geometry: new ol.geom.Point(
    ol.proj.fromLonLat([-74.006,40.7127])
  ),  // Cordinates of New York's City Hall
});
marker.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
            crossOrigin: 'anonymous',
            src: 'dot.png',
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

var featureListener = function ( event ) {
    console.log("featureListenerCalled");
    alert("Feature Listener Called");
};

map.on('click', function(event) {
alert('['+event.coordinate+']');
				var marker = new ol.Feature({
  geometry: new ol.geom.Point(
    ol.proj.fromLonLat('['+event.coordinate+']')
  ),  // Cordinates of New York's City Hall
});
marker.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
            crossOrigin: 'anonymous',
            src: 'dot.png',
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
            });
	  </script>
 <!-- Our map file -->
</html>