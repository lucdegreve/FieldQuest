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

<form action = "US4-11_Main_page_filter.php" method = "POST" name = "save_filter">

<div class="container-fluid">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div align="center" class="card text-white bg-info mb-3" style="border-radius: 10px 10px; color: gray; height:30px">
					Do you want to save these filters in a new favorite request ?
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>




<!-- data recovery from the selection page -->

		<?php
				if (isset($_POST['Validation_state'])){
                    $valid = Array();
                    foreach ($_POST['Validation_state'] AS $i){
                    	$valid[] = $i; //array format
                    }
                	echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        				echo 'Validation state :';
                        			foreach($valid as $i){

                        					$query="SELECT label_validation_state FROM validation_state WHERE id_validation_state = $i";
											$result=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());
											$row=pg_fetch_array($result);
											//echo print_r($row);
											//echo implode("",$row);

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$i.'" name="valid[]">'.$row['label_validation_state'].'</button>';
                        				echo '<input type="hidden" style="display: none;" value="'.$i.'" name="valid[]">';
                        			}
                        			echo '</div></div>';
                        		echo '</div>';
                        	echo '<div class="col-md-3"></div>';
                        echo '</div>';
                    echo '</div>';                }

                if (isset($_POST['start'])){
                	if ($_POST['start']!=''){
                        $start_date = $_POST['start']; //only one value, string format
                        echo '<div class="container-fluid">';
                        	echo '<div class="row">';
           						echo '<div class="col-md-3"></div>';
           						echo '<div class="col-md-6">';
                        			echo '<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">';
                        			echo 'Start date : '.'<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$start_date.'" name="start_date">'.$start_date.'</button>';
                        			echo '<input type="hidden" style="display: none;" value="'.$start_date.'" name="start">';
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
                        			echo 'End date : '.'<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$end_date.'" name="end_date">'.$end_date.'</button>';
                        			echo '<input type="hidden" style="display: none;" value="'.$end_date.'" name="end">';
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

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$i.'" name="format[]">'.$row['label_format'].'</button>';
                        				echo '<input type="hidden" style="display: none;" value="'.$i.'" name="format[]">';

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

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$i.'" name="project[]">'.$row['name_project'].'</button>';
                        				echo '<input type="hidden" style="display: none;" value="'.$i.'" name="project[]">';

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

				                		echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$i.'" name="sources[]">'.$row['first_name'].' '.$row['last_name'].'</button>';
				                		echo '<input type="hidden" style="display: none;" value="'.$i.'" name="sources[]">';

				                	}
				                	if (strlen($sources)==1){
				                		$i = substr($sources, -1, 1);

				                			$query="SELECT first_name, last_name FROM user_account WHERE id_user_account = $i";
											$result=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());
											$row=pg_fetch_array($result);
											//echo print_r($row);
											//echo implode("",$row);

				                		echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$i.'" name="sources[]">'.$row['first_name'].' '.$row['last_name'].'</button>';
				                		echo '<input type="hidden" style="display: none;" value="'.$i.'" name="sources[]">';

				                	}
                        			echo '</div></div>';
                        		echo '</div>';
                        	echo '<div class="col-md-3"></div>';
                        echo '</div>';
                    echo '</div>';
                    }
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

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$i.'" name="unit[]">'.$row['tag_name'].'</button>';
                        				echo '<input type="hidden" style="display: none;" value="'.$i.'" name="unit[]">';

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

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" value="'.$i.'" name="tag[]">'.$row['tag_name'].'</button>';
                        				echo '<input type="hidden" style="display: none;" value="'.$i.'" name="tag[]">';

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
				<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">
					Query name : <input style="border-radius: 5px 5px" type="text" id="name" name="name" required minlength="2" maxlength="10">
				</div></div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="card text-white bg-primary mb-3" style="border-radius: 20px 50px"><div class="card-body">
					<textarea id="comment" name="comment" style="border-radius: 10px 25px; height:100px; width:600px" placeholder=" Insert your comment here "></textarea>
				</div></div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
					<!-- Search button -->
					<button type='submit' class='btn btn_lg btn-success' name='Save_in_favorite' value="Button1">Save filters</button>
					<!-- Save button -->
					<button type='submit' class='btn btn_lg btn-success' name='Return' value="Button2">Return</button>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>

</form>

	</body>

	</html>
