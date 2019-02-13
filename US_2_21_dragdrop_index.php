<!doctype html>
<html lang="en">


<head>


<!-- Développeurs : Manu et Gala
			Drag and drop which download file automatically when drop. 
			Issues : can't create a button "upload" (always automatic)
					 if 2 files are dropped with the same name, the first doc is replaced by the 2nd !!
		-->
		
		

        <link href="css/custom.css" rel="stylesheet" type="text/css">
		<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
        <script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
        <script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>
 <title >Deposer un fichier,</title>
 <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
 		<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
 <!-- Openlayers CSS file-->
 
 <style type="text/css">
  #map{
   width:40%;
   height:300px;
  }
  

 </style>
 <!--Basic styling for map div, 
 if height is not defined the div will show up with 0 px height  -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
  
</head>


<body>

<form action="insert_bdd.php" method="get">
	<h1  align="center">Déposer un fichier </h1> </br>
	<h2  align="center">Déplacer vos fichiers dans la zone, ou cliquer pour parcourir votre ordinateur </h2>
	<div class="container" >
		<input type="file" name="file" id="file">
		<!-- Drag and Drop container-->
		<div class="upload-area"  id="uploadfile">
			<h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
		</div>
		</div> </br> </br> </br> 
	<h2 align = "center"> Indiquez la localisation des données </h2>
	    <div style="margin:0 auto" id="map" >
	    <!-- Your map will be shown inside this div-->
	    </div>
		



 
</body>
Latitude :  <span id="Latitude"></span></br> </br>
Longitude : <span id="Longitude"></span> </br> </br>

Commentaire : <br/>  <textarea id="txtAreaa" rows="10" cols="70"></textarea></br>
Date :<span> <input type="text" id="datepicker" ></span></br></br></br>

<input type="submit" value="Envoyer le formulaire">

 </form>
 
 
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
          zoom: 3 //Initial Zoom Level
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
    url: "ajax1.php",
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
	  
