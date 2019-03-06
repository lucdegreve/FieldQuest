<html>

    <head>
<!--------------------------------------------------------------------------------
   US4-11 Filtrer avec des tags - Union page for filter search
Developped by Ophélie	& Diane	
          
This page is the join between US4-11_Filtre_avec_tag_all_tags, US4-11_Result_table_filter, US4_11_Carte

Input variables : 		

Output variables :								
            
---------------------------------------------------------------------------------->	
<!-- SOURCES FILTRES TAG -->

  
    <!-- SOURCES SOURCES -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>

<!-- SOURCES RESULT TABLE -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

                <!-- Bootstrap core JavaScript
================================================== -->


<!-- Placed at the end of the document so the pages load faster -->

<script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>  

<!-- Resources for popover -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
	 crossorigin="anonymous">
         
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
	 crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" integrity="sha384-u/bQvRA/1bobcXlcEYpsEdFVK/vJs3+T+nXLsBYJthmdBuavHvAW6UsmqO2Gd/F9"
	 crossorigin="anonymous">
</script>

	<link rel="stylesheet" href="styles.css">

<script src="bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<!-- END SCRIPT -->


    </head>

    <body>



        <?php
        //Header
        include("en_tete.php");
        echo "</br>";
        //DB connection
        require "./tab_donnees/funct_connex.php";
        require "./tab_donnees/tab_donnees.class.php";
        $con=new Connex();
        $connex=$con->connection;
        
        ?>
        <div class="row">
                <div class="col-md-3">
                    <?php include ("US4-11_Filtre_avec_tag_all_tags.php"); ?>
                </div>
                <div class="col-md-9">
                        <!-- Navigation tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                        <a href="#list" data-toggle="tab" role="tab" class="nav-link active">Files list</a>
                                </li>
                                <li>
                                        <a href="#map" data-toggle="tab" role="tab" class="nav-link">Map</a>
                                </li>
                        </ul>
                        
                        <!-- Table panes -->
                        <div class="tab-content">
                                <div class="tab-pane active" id="list" role="tabpanel" aria-labelledby="list">
                                        <?php include ("US4-11_Result_table_filter.php"); ?>
                                </div>
                                <div class="tab-pane fade" id="map" role="tabpanel" aria-labelledby="map">
                                        <?php include ("US4_11_Carte.php"); ?>
                                </div>
                        </div>                                                           
                </div>
        </div>

    </body>
        
    	<?php
	echo "</br></br></br>";
	include("pied_de_page.php");
	?>	
</html>