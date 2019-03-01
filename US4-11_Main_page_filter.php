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
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>

<!-- SOURCES RESULT TABLE -->
                
                <!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>  

<!-- Resources for popover -->
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>



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
            <div class="col-md-3">
                <?php include ("US4-11_Filtre_avec_tag_all_tags.php"); ?>
            </div>
            <div class="col-md-9">
                <div>
                    <?php include ("US4-11_Result_table_filter.php"); ?>
                    <?php include ("US4_11_Carte.php"); ?>
                </div>
            </div>
    </body>
        
    	<?php
	echo "</br>";
	//include("pied_de_page.php");
	?>	
</html>