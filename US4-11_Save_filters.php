<html>
	<head>
<!--------------------------------------------------------------------------------
       US4-11 Enregistrer les tags - Table of query result  
       
Developped by Eva
	      
This page displays the result of the search by tags as a table. 

Input variables : 		

Output variables :								
		
---------------------------------------------------------------------------------->	

		<META charset="UTF-8">
	</head>

	<body>
		<?php

                if (isset($_POST['start'])){
                	if ($_POST['start']!=''){
                        $start_date = $_POST['start'];
                        echo "Start date : ".$start_date; //only one value, string format                       
                	}
                }

                if (isset($_POST['end'])){
                	if ($_POST['end']!=''){
                        $end_date = $_POST['end'];
                        echo " </br> End date : ".$end_date; //only one value, string format
                	}
                }
                
                if (isset($_POST['format'])){
                	$format = Array();
                    foreach ($_POST['format'] AS $i){
                    	$format[] = $i;
                    }
                    echo " </br> Format : ".implode(", ", $format); //array format
                }
                
                if (isset($_POST['projet'])){
                	$projet = Array();
                    foreach ($_POST['projet'] AS $i){
                    	$projet[] = $i;
                    }
                	echo " </br> Projet : ".implode(", ", $projet); //array format
                }
				
				if (isset($_POST['Validation_state'])){
                	$validation_state = Array();
                    foreach ($_POST['Validation_state'] AS $i){
                    	$validation_state[] = $i;
                    }
                	echo " </br> Validation state : ".implode(", ", $validation_state); //array format
                }
                
                if (isset($_POST['sources'])){
               		if ($_POST['sources']!=''){
                        $sources = $_POST['sources'];
                	}
                	echo " </br> Sources : ".$sources; //string format
                }
                
                if (isset($_POST['unit'])){
                	$unit = Array();
                    foreach ($_POST['unit'] AS $i){
                    	$unit[] = $i;
                    }
                    echo " </br> Unit : ".implode(", ", $unit); //array format
                }
                
                if (isset($_POST['tag'])){
                	$tag = Array();
                    foreach ($_POST['tag'] AS $i){
                    	$tag[] = $i;
                    }
                    echo " </br> Tags : ".implode(", ", $tag); //array format
                }  
          
          ?>

	</body>
	
	</html>
