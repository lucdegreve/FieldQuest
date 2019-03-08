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
        //Header
        include("en_tete.php");
        echo "</br>";
        //DB connection
        require "./tab_donnees/funct_connex.php";
        require "./tab_donnees/tab_donnees.class.php";
        $con=new Connex();
        $connex=$con->connection;
        
?>

<div class="container-fluid">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="card text-white bg-info mb-3" style="border-radius: 10px 10px; color: gray">
					Do you want to save these filters in your favorite request(s) ?
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
	
							

	
<!-- data recovery from the selection page -->

		<?php
				
                if (isset($_POST['start'])){
                	if ($_POST['start']!=''){
                        $start_date = $_POST['start']; //only one value, string format 
                        echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        			echo 'Start date : '.'<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$start_date.'">'.$start_date.'</button>';
                        			echo '</div></div>'; 
                        		echo '</div>';
                        		echo '<div class="col-md-3"></div>';
                        	echo '</div>';
                        echo '</div>';
                	}
                }

                if (isset($_POST['end'])){
                	if ($_POST['end']!=''){
                        $end_date = $_POST['end']; //only one value, string format 
                        echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        			echo 'End date : '.'<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$end_date.'">'.$end_date.'</button>';
                        			echo '</div></div>'; 
                        		echo '</div>';
                        		echo '<div class="col-md-3"></div>';
                        	echo '</div>';
                        echo '</div>';
                	}
                }
                
                if (isset($_POST['format'])){
                	$format = Array();
                    foreach ($_POST['format'] AS $i){
                    	$format[] = $i;
                    }
                    echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        				echo 'Format(s) :';
                        			foreach($format as $i){
                        			
                        					$query="SELECT label_format FROM format WHERE id_format = $i";
											$result=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());	
											$row=pg_fetch_array($result);
											//echo implode("",$row);

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$i.'">'.$row['label_format'].'</button>';
                        			}
                        			echo '</div></div>';  
                        		echo '</div>';
                        	echo '<div class="col-md-3"></div>';
                        echo '</div>';
                    echo '</div>';
                }
                
                if (isset($_POST['projet'])){
                	$projet = Array();
                    foreach ($_POST['projet'] AS $i){
                    	$projet[] = $i; //array format
                    }
                	echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        				echo 'Project(s) :';
                        			foreach($projet as $i){
                        			
                        					$query="SELECT name_project FROM projects WHERE id_project = $i";
											$result=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());	
											$row=pg_fetch_array($result);
											//echo print_r($row);
											//echo implode("",$row);

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$i.'">'.$row['name_project'].'</button>';
                        			}
                        			echo '</div></div>';  
                        		echo '</div>';
                        	echo '<div class="col-md-3"></div>';
                        echo '</div>';
                    echo '</div>';
                }
                
                if (isset($_POST['sources'])){
               		if ($_POST['sources']!='' AND $_POST['sources'] != NULL){
                        $sources = $_POST['sources']; //string format
                	}
                	
					echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        				echo 'Source(s) :';
                        			while (strlen($sources)>=3){
				                		$a = strripos($sources, ",");
				                		$i= substr($sources, $a+1, strlen($sources)); 
				                		$sources = substr($sources, 0, $a);
				                		
				                			$query="SELECT first_name, last_name FROM user_account WHERE id_user_account = $i";
											$result=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());	
											$row=pg_fetch_array($result);
											//echo print_r($row);
											//echo implode("",$row);

				                		echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$i.'">'.$row['first_name'].' '.$row['last_name'].'</button>';
				                	}
				                	if (strlen($sources)==1){
				                		$i = substr($sources, -1, 1);
				                		
				                			$query="SELECT first_name, last_name FROM user_account WHERE id_user_account = $i";
											$result=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());	
											$row=pg_fetch_array($result);
											//echo print_r($row);
											//echo implode("",$row);

				                		echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$i.'">'.$row['first_name'].' '.$row['last_name'].'</button>';
				                	}
                        			echo '</div></div>';  
                        		echo '</div>';
                        	echo '<div class="col-md-3"></div>';
                        echo '</div>';
                    echo '</div>';
                }
                
                if (isset($_POST['unit'])){
                	$unit = Array();
                    foreach ($_POST['unit'] AS $i){
                    	$unit[] = $i; //array format
                    }
                	echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        				echo 'Unit(s) :';
                        			foreach($unit as $i){
                        			
                        					$query="SELECT tag_name FROM tags WHERE id_tag = $i";
											$result=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());	
											$row=pg_fetch_array($result);
											//echo print_r($row);
											//echo implode("",$row);

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$i.'">'.$row['tag_name'].'</button>';
                        			}
                        			echo '</div></div>';  
                        		echo '</div>';
                        	echo '<div class="col-md-3"></div>';
                        echo '</div>';
                    echo '</div>';
                }
                
                if (isset($_POST['tag'])){
                	$tag = Array();
                    foreach ($_POST['tag'] AS $i){
                    	$tag[] = $i; //array format
                    }
                	echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        				echo 'Tag(s) :';
                        			foreach($tag as $i){
                        			
                        					$query="SELECT tag_name FROM tags WHERE id_tag = $i";
											$result=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());	
											$row=pg_fetch_array($result);
											//echo implode("",$row);

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$i.'">'.$row['tag_name'].'</button>';
                        			}
                        			echo '</div></div>'; 
                        		echo '</div>';
                        	echo '<div class="col-md-3"></div>';
                        echo '</div>';
                    echo '</div>';
                }  
          
          ?>

          
<!-- end of the recovery, beginning of the form -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
					<!-- Search button -->
					<button type='submit' class='btn btn_lg btn-success' name='Save in favorite' value="Button1">Save filters</button>
					<!-- Save button -->
					<button type='submit' class='btn btn_lg btn-success' name='Return' value="Button2">Return</button>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>

	</body>
	
	</html>
