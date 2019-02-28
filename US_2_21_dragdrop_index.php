<!doctype html>

<html lang="en">

	<head>
		<!-- Développeurs : Manu et Gala -->
		<!-- Drag and drop which download file automatically when drop -->
		<!-- Issues : can't create a button "upload" (always automatic) -->
		
		<link href="css/custom.css" rel="stylesheet" type="text/css">
		<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
		<script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
		<script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>
		<script type= 'text/javascript' src = 'manage_checkbox_button.js'></script>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">	

		<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
		<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
				
		<!-- Openlayers CSS file-->		 
		<style type="text/css">
		  #map{
		   width:90%;
		   height:290px;
		  }
		</style>

		<!--Basic styling for map div, if height is not defined the div will show up with 0 px height  -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	</head>

	<body>
		
		<?php
		//Header
		include("en_tete.php");
		echo "</br>";
		//DB connection
		require "./tab_donnees/tab_donnees.class.php";
		require "./tab_donnees/funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		?>		
		
		<form id ="formdepot" action="US_2_21_insert_bdd.php" method="GET">
			<div class="container-fluid" >
				<div class="row">
				
					<div class="col-md-6"><div class="jumbotron">
						<!-- Drag and drop container -->						
						<h4><B>Your file</B></h4>
						<input type="file" name="file" id="file">							
						<div class="upload-area"  id="uploadfile" align="left">
							</br><B>Drag and drop a file here</B><br/></br>or<br/></br><B>Click to select a file</B>
						</div>
						</br>
					</div></div>
					
					<div class="col-md-6"><div class="jumbotron">
						<h4><B>Select the data localisation</B></h4></br>
						<div style="margin:0 auto" id="map" >
							<!-- Your map will be shown inside this div-->
						</div>						
						Latitude : <span id="Latitude" ></span> </br>
						Longitude : <span id="Longitude" ></span>
					</div></div>
					
				</div>
				
				<div class="row">
					
					<div class="col-md-6"><div class="jumbotron">
						<h4><B>Other information</B></h4></br>
						
						<!-- Period -->
						Select a period : <input type="text" name="daterange" value=""/></br></br>
						<script>
						$(function() {
						  $('input[name="daterange"]').daterangepicker({
							opens: 'left'
						  }, function(start, end, label) {
							console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
						  });
						});
						</script>
						
						<!-- Projects -->
						<?php
						//Query projects
						//$id_user = $_SESSION[$id_user]; A DECOMMENTER QUANS LA VARIABLE DE SESSION SERA VALABLE
						$result_projects_list = pg_query($connex, " SELECT * from projects p JOIN link_project_users lpu ON p.id_project=lpu.id_project where lpu.id_user_account=1 ORDER BY name_project asc");	//CHANGER L'ID					
						$tab_projects_list = new Tab_donnees($result_projects_list,"PG");
						//$tab_projects_list -> creer_liste_option_multiple("lst_proj", "id_project", "name_project","",multiple);
						?>
						Select one or several project(s) :
						<div class="container">
							<div class="card card-body">
								<div class="form-check">
									<?php 
										// For each format 
										for ($i=0; $i< $tab_projects_list->nb_enregistrements (); $i++){
											// Get id of the format n°$i  of recordset
											$id_project = $tab_projects_list-> t_enr[$i][0];
											// Get label of the format n°$i  of recordset
											$name_project = $tab_projects_list-> t_enr [$i][2];
										
											// Make checkbox button 
											echo '<span class="button-checkbox">';
											echo '<button type="button" class="btn" data-color="primary" id = project_"'. $id_project .'">'.$name_project.'</button>';
											echo '<input type="checkbox" class="hidden" name="projet[]" value="'.$id_project.'"/>';
											echo '</span>';
										}
									?>
								</div>
							</div>
						</div>
						
						<!-- Comments -->
						Comment : <br/> <textarea id="Comment" name="Comment" class="form-control" form="formdepot"></textarea>
					</div></div>
					
					<div class="col-md-6"><div class="jumbotron">					
						<h4><B>Select tags</B></h4></br>

						<script type="text/javascript"> // allows to make a tree structure dynamic
							$(document).ready( function () {
								// We hide the sub-menus except the one with the class "open_at_load" :
								$(".navigation ul.subMenu:not('.open_at_load')").hide();
								// We select all list items with the class "toggleSubMenu" and replace the span element they contain with a link :
								$(".navigation li.toggleSubMenu span").each( function () {
									// We stock the span content :
									var TexteSpan = $(this).text();
									$(this).replaceWith('<a href="" title="Afficher le sous-menu">' + TexteSpan + '<\/a>') ;
								} ) ;
								// We modify the "click" event on the links in the list items that have the class "toggleSubMenu" :
								$(".navigation li.toggleSubMenu > a").click( function () {
									// If the sub-menu was open, we close it :
									if ($(this).next("ul.subMenu:visible").length != 0) {
										$(this).next("ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") } );
									}
									// If the sub-menu is hidden, we close the others and display it :
									else {
										$(".navigation ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") });
										$(this).next("ul.subMenu").slideDown("normal", function () { $(this).parent().addClass("open") } );
									}
									return false; // Prevent the browser to follow the link
								});
							});
						</script>

						<?php
							//request parameters
							$query = "SELECT tt.id_tag_type, name_tag_type FROM  tag_type tt  ";
							//request execution
							$result = pg_query($connex, $query) or die(pg_last_error());
							// Results browsing line by line
							// For each line pg_fetch_array return a value table  
							while ($row = pg_fetch_array($result)) { 
								// The access to a table element can be do thanks to index or field name
								// Here we are using field name
								$id_cat= $row["id_tag_type"];
								
								echo '<ul class="navigation">';
								echo '<li class="toggleSubMenu"><span>'.$row["name_tag_type"].' </span>';
								echo '<ul class="subMenu">';
								
								$query2 = "SELECT id_tag, tag_name FROM tags where id_tag_type=".$id_cat; //it gives the name of the tag within the category
								$result2 = pg_query($connex, $query2)  or die('Échec de la requête : ' . pg_error($connex)); 
								while ($row2 = pg_fetch_array($result2)) {
									echo '<li><div><input type="checkbox" id="' . $row2["id_tag"] . '_tag" name="' . $row2["id_tag"] . '_tag">';
									echo '<label for="' . $row2["id_tag"] . '_tag"> ' . $row2["tag_name"] . '</label></div></li>';
								}
								echo '</ul>';
								echo '</li>';
								echo '</ul>';
							}
						?>
						</br>
					</div></div>
					
				</div>
			</div>
			
			<div align="center">
				<button type="submit" class="btn btn-lg btn-success">Send the form</button>
			</div>
		</form></br>
		
	</body>
	
	<?php
	include("pied_de_page.php");
	?>







<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
 <!-- Openlayesr JS fIle -->

 <script type="text/javascript"  >
 

 
 // creating map : center on paris
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
	  
	// create pinpoint onclick
	map.on('click', function(event) {
		map.setLayerGroup(new ol.layer.Group());  // on rajoute la couche OSM car supprimee en cas de pin point
		couche = new ol.layer.Tile({
				source: new ol.source.OSM()
			  });
			  map.addLayer(couche); 
			  
			  //getting coordonates
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
	// passing variables through ajax to put them into session's variables
						$.ajax({
		type: "GET",
		url: "US_2_21_ajax1.php",
		data:{coords:coords}, //name is a $_GET variable name here,
							   // and 'youwant' is its value to be passed 
		success: function(response) {
							document.getElementById("Latitude").innerHTML=response;
						},
						error: function() {
							alert('Erreur');
						}
	})
	//same

						$.ajax({
		type: "GET",
		url: "US_2_21_ajax2.php",
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
