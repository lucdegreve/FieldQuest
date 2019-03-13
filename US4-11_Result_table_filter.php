<html>

	<head>

<!--------------------------------------------------------------------------------

       US4-11 Filtrer avec des tags - Table of query result  

Developped by Ophélie	& Diane	

This page displays the result of the search by tags as a table. 

///// This page is included in US4-11_Main_page_filter.php /////

Code based on "US3_11_Visualiser_liste_fichiers.php" developped by Elsa & Axelle

Input variables : 		

Output variables :	
							
---------------------------------------------------------------------------------->	

		<META charset="UTF-8">
                <link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">

	</head>



	<body>

		<?php

                //Query : filtered search
                $query="SELECT f.id_original_file, MIN(f.upload_date)
                        FROM files f
                            LEFT JOIN version v on f.id_version = v.id_version
                            LEFT JOIN link_file_project lfp ON lfp.id_file=f.id_file
                            LEFT JOIN projects p ON lfp.id_file=p.id_project
                            LEFT JOIN format fr ON fr.id_format=f.id_format
                            LEFT JOIN user_account u ON u.id_user_account=f.id_user_account
                            LEFT JOIN link_tag_project ltp ON ltp.id_file=f.id_file
                            LEFT JOIN tags t ON t.id_tag=ltp.id_tag
                        Where f.id_file NOT IN (0) AND ";
						
				//If a favorite search has been launched, we complete the query with the filters of this search:
				if (isset($_POST['Validation_state'])){ 
                                        $query .= " f.id_validation_state IN ("; 
                                        foreach ($_POST['Validation_state'] AS $i){ 
                                            $query .= $i.", "; 
                                        } 
                                        $query = substr($query, 0, strlen($query) -2); 
                                        $query .= ")"; 
                                        $query .= " AND "; 
                                } 
                                
				if (isset($begin_date_fs)){
							if ($begin_date_fs!=''){
                                $start_date = $begin_date_fs;

                                $query .= " f.upload_date >'".$start_date."' AND ";
							}
						}

				if (isset($end_date_fs)){
					if ($end_date_fs!=''){
						$query .= " f.upload_date <'".$end_date_fs."' AND ";
					}
				}

                
				if (isset($liste_format_fs)){
					if ($liste_format_fs !=[]){
						$query .= " f.id_format IN (";
						foreach ($liste_format_fs AS $i){
								$query .= $i.", ";
						}
						$query = substr($query, 0, strlen($query) -2);
						$query .= ")";
						$query .= " AND ";
					}
				}
				
				if (isset($liste_project_fs)){
					if ($liste_project_fs !=[]){
						$query .= " lfp.id_project IN (";
						foreach ($liste_project_fs AS $i){
								$query .= $i.", ";
						}
						$query = substr($query, 0, strlen($query) -2);
						$query .= ")";
						$query .= " AND ";
					}
					
				}

				//TAG_FS = list of tag selected in the favorite_search(units included)
				$TAG_FS='(';

				

				if (isset($liste_tag_fs)){
						foreach ($liste_tag_fs AS $i){
								$TAG_FS .= $i.", ";
						}
						echo '</br>';
				}

				if ($TAG_FS!='('){
						$query .= " ltp.id_tag IN ".$TAG_FS;
						$query = substr($query, 0, strlen($query) -2);
						$query .= ")";
				}

				//End of the filters applied for the favorite search
				// If we have previously launched a search and go back to this page
				if (isset($selected_validation_state)){ 
                                        $query .= " f.id_validation_state IN ("; 
                                        foreach ($selected_validation_state AS $i){ 
                                            $query .= $i.", "; 
                                        } 
                                        $query = substr($query, 0, strlen($query) -2); 
                                        $query .= ")"; 
                                        $query .= " AND "; 
                }

                if (isset($_POST['sources'])){
                        if ($_POST['sources']!=''){
                                $query .= "f.id_user_account IN (".$_POST['sources'].") AND ";
                        }
                }


                //TAG_SLD = list of tag selected (units included)
                $TAG_SLD='(';

                if (isset($_SESSION['selected_unit'])){
                        foreach ($_SESSION['selected_unit'] AS $i){
                                $TAG_SLD .= $i.", ";
                        }
                        echo '</br>';
                }

                if (isset($_SESSION['selected_tag'])){
                        foreach ($_SESSION['selected_tag'] AS $i){
                                $TAG_SLD .= $i.", ";
                        }
                        echo '</br>';
                }

                if ($TAG_SLD!='('){
                        $query .= " ltp.id_tag IN ".$TAG_SLD;
                        $query = substr($query, 0, strlen($query) -2);
                        $query .= ")";
                }
				// end of previously selected search
				
				//If some filters are set in the main page, and search button is launched, some other filters are going to be set to the query:
                if (isset($_POST['start'])){
                        if ($_POST['start']!=''){
                                $start_date = $_POST['start'];

                                $query .= " f.upload_date >'".$start_date."' AND ";
                        }
                }

                if (isset($_POST['end'])){
                        if ($_POST['end']!=''){
                                $end_date = $_POST['end'];
                                $query .= " f.upload_date <'".$end_date."' AND ";
                        }
                }

                
                if (isset($_POST['format'])){
                        $query .= " f.id_format IN (";
                        foreach ($_POST['format'] AS $i){
                                $query .= $i.", ";
                        }
                        $query = substr($query, 0, strlen($query) -2);
                        $query .= ")";
                        $query .= " AND ";
                }

                
                if (isset($_POST['projet'])){
                    
                        $query .= " lfp.id_project IN (";
                        foreach ($_POST['projet'] AS $i){
                                $query .= $i.", ";
                        }
                        $query = substr($query, 0, strlen($query) -2);
                        $query .= ")";
                        $query .= " AND ";
                        
                }

                if (isset($_POST['sources'])){
                        if ($_POST['sources']!=''){
                                $query .= "f.id_user_account IN (".$_POST['sources'].") AND ";
                        }
                }


                //TAG_SLD = list of tag selected (units included)
                $TAG_SLD='(';

                if (isset($_POST['unit'])){
                        foreach ($_POST['unit'] AS $i){
                                $TAG_SLD .= $i.", ";
                        }
                        echo '</br>';
                }

                if (isset($_POST['tag'])){
                        foreach ($_POST['tag'] AS $i){
                                $TAG_SLD .= $i.", ";
                        }
                        echo '</br>';
                }

                if ($TAG_SLD!='('){
                        $query .= " ltp.id_tag IN ".$TAG_SLD;
                        $query = substr($query, 0, strlen($query) -2);
                        $query .= ")";
                }
				
                
                //Cut end of query
                if (substr($query, -6)=='WHERE '){
                    $query = substr($query, 0, strlen($query) -6);
                }

                if (substr($query, -4)=='AND '){
                    $query = substr($query, 0, strlen($query) -4);
                }

                
                $query .= " GROUP BY f.id_original_file ORDER BY MIN(f.upload_date) DESC";


		//Query : list of distinct file names

		$result_files_id=pg_query($connex, $query) or die('Échec de la requête : ' . pg_last_error());
		$nbrows=pg_num_rows($result_files_id);
               
		//Path to download file							
        $path='US_2_21_dragdrop_upload/'; 
		?>


		<!-- Table creation -->

		<div class="container-fluid"> 

			<form name="box_download" method="GET" action="**URL_download**">

				<div class="row">

					<div class="col-md-9"><h1>Files list</h1></div>

					<div class="col-md-1" align="right">

						<button type="submit" class="btn btn-md btn-success">Download selection</button>

					</div>

				</div></br>

				<div class="row">				

					<table class="table">

						<thead class="thead-dark">

							<tr>

								<th scope="col" width="5%">State</th>

								<th scope="col" width="21%">File name</th>

								<th scope="col" width="17%">Upload date</th>

								<th scope="col" width="17%">Origin</th>

								<th scope="col" width="20%">Size(Octet)</th>

								<th scope="col" width="10%"></th>

								<th scope="col" width="10%"></th>

								<th id="select" scope="col" width="10%" style="text-align:center;">Select</th> 

								<th class="droite" scope="col" width="5%" style="text-align:center;"><input id="id_selectAll" type="checkbox" onclick="selectAll();"></th> 

							

							</tr>

						</thead>

						<tbody>

							<?php
                                                        
                                                        //Compteur pour faire transiter la donnée vers le téléchargement
							$pos=0;

							while($row=pg_fetch_array($result_files_id)){

								$id=$row[0];

								//Query to get the last version for each file name

								$query="SELECT id_file, file_name, to_char(upload_date,'DD/MM/YYYY'), file_size, label_validation_state, id_version, last_name, first_name, id_original_file, file_comment

								FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account JOIN validation_state vs ON f.id_validation_state=vs.id_validation_state

								WHERE id_original_file='".$id."' AND id_version=(SELECT MAX(id_version) FROM files WHERE id_original_file='".$id."')";

								$result_files_list=pg_query($connex, $query) or die('Échec de la requête : ' . pg_last_error());
                                                                
                                                                //Type of metadata of the file
                                                                
								while($col=pg_fetch_array($result_files_list)){

									$id_file=$col[0];
									$name=$col[1];
									$date=$col[2];
									$size=$col[3];
									$valid=$col[4];
									$version=$col[5];
									$last_name=$col[6];
									$first_name=$col[7];
									$original_id=$col[8];
                                                                        
									if ($col[9]!= ''){
										$metadata="Comment :".$col[9]."\r\n Tags: ";
									} else {
										$metadata="Tags: ";
									}
                                                                        
								}

								// Query to get metadata of the file 

								$query_metadata = "SELECT t.tag_name
											FROM link_tag_project ltp JOIN tags t on t.id_tag = ltp.id_tag 
											WHERE ltp.id_file = '".$id_file."'";

								$result_metadata = pg_query($connex, $query_metadata) or die (' Failed to get tags');

								$table_metadata = new Tab_donnees($result_metadata,'PG');

								if ( $table_metadata->nb_enregistrements() == 0){

									$metadata .= "None. ";

								}

								for ($i=0; $i< $table_metadata->nb_enregistrements();$i++){

									$metadata .= $table_metadata->t_enr[$i][0].", ";
                                                                        
								}

								// Delete last ', ' in $metadata

								$metadata = substr($metadata, 0, strlen($metadata)-2);
								//State "being checked"                               								
                                if($valid=="Being checked"){
									echo "<tr class='table-active'>";
										echo "<th scope='row'></th>";
										echo '<th scope="row">'.substr($name,10).'<a tabindex="0" class="badge badge-light" role="button" data-toggle="popover" data-trigger="focus" title="Metadata related to this file" data-content="'.$metadata.'">i</a></th>';
										echo "<th scope='row'>".$date."</th>";
										echo "<th scope='row'>".$first_name." ".$last_name."</th>";
										echo "<th scope='row'>".$size."</th>";
										echo "<td>";
                                            echo "<a href='".$path.$name."' download> ";                                                
												echo '<button type="button" id="btnDownload" name="btnDownload" class="btn btn-sm btn-outline-success btn-block" onclick="return download_file('.$id_file.')">Download file</button>';                                            
                                            echo "</a>";
										echo "</td>";
										echo "<td>";
											echo '<button type="button" id="btnEdit" name="btnEdit" class="btn btn-sm btn-outline-warning btn-block" onclick="return edit_file('.$id_file.')">Edit</button>';													
										echo "</td>";
										echo "<td>";
											echo "<button type='button' id='btnDelete' name='btnDelete' class='btn btn-sm btn-outline-danger btn-block' onclick='return delete_file(".$id_file.")'>Delete</button>";
										echo "</td>";
										echo "<td>";
											echo '</br><div align="center"><input type="checkbox" name="id_file_'.$id_file.'" value="'.$id_file.'"></div>';
										echo "</td>";
									echo "</tr>";
								}
								
								//State "not validated"
								if($valid=="Not validated"){
									echo "<tr>";
										echo "<td><img src='picto/refused.png' width='27' height='27'/></td>";
										echo '<td>'.substr($name,10).'<a tabindex="0" class="badge badge-light" role="button" data-toggle="popover" data-trigger="focus" title="Metadata related to this file" data-content="'.$metadata.'">i</a></th>';
										echo "<td>".$date."</td>";
										echo "<td>".$first_name." ".$last_name."</td>";
										echo "<td>".$size."</td>";
										echo "<td>";                                    
                                            echo "<a href='".$path.$name."' download> ";                                    
												echo '<button type="button" id="btnDownload" name="btnDownload" class="btn btn-sm btn-outline-success btn-block" onclick="return download_file('.$id_file.')">Download file</button>';
                                            echo "</a>";                                    
										echo "</td>";
										echo "<td></td>";
										echo "<td>";
											echo "<button type='button' id='btnDelete' name='btnDelete' class='btn btn-sm btn-outline-danger btn-block' onclick='return delete_file(".$id_file.")'>Delete</button>";
										echo "</td>";
										echo "<td>";
											echo '</br><div align="center"><input type="checkbox" name="id_file_'.$id_file.'" value="'.$id_file.'"></div>';									
										echo "</td>";
									echo "</tr>";
								}
								//State "validated"

								if($valid=="Validated"){

									if($id_file!=$original_id){

										//Query to get right "upload date" and "origin"

										$query_origin="SELECT to_char(upload_date,'DD/MM/YYYY'), last_name, first_name FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account WHERE id_file=".$original_id;

										$result_origin=pg_query($connex, $query_origin) or die('Échec de la requête : ' . pg_last_error());

										while($col=pg_fetch_array($result_origin)){

											$date=$col[0];
											$last_name=$col[1];
											$first_name=$col[2];

										}

									}						

									echo "<tr>";

										echo "<td><img src='picto/validated.png' width='30' height='30'/></td>";

										// Popover to display metadata for each file

										echo '<td>'.substr($name,10).' <a tabindex="0" class="badge badge-light" role="button" data-toggle="popover" data-trigger="focus" title="Metadata related to this file" data-content="'.$metadata.'">i</a></td>';

										echo "<td>".$date."</td>";

										echo "<td>".$first_name." ".$last_name."</td>";

										echo "<td>".$size."</td>";

										echo "<td>";

                                                                                            //Affichage du lien de telechargement qui prend en compte le nom du fichier ainsi que le chemin

                                                                                            //Affichage de la requete par fichier

                                                                                            $querydl = "SELECT fi.file_place, fi.file_name, fo.label_format
                                                                                                      FROM files fi JOIN format fo
                                                                                                      ON fi.id_format = fo.id_format
                                                                                                      WHERE fi.id_file = $original_id";

                                                                                            $resultdl = pg_query($querydl) or die('Échec de la requête : ' . pg_last_error());


                                                                                            //creation d'une liste contenant le non, l'extension et la pos du fichier

                                                                                            $rowdl = pg_fetch_array($resultdl);

                                                                                            $listdl = array();

                                                                                            $listdl[] =  $rowdl[1];

                                                                                            $listdl[] = $rowdl[2];

                                                                                            $listdl = join( $listdl, ".");

                                                                                            $_SESSION["path[".$pos."]"] = $rowdl[0];

                                                                                            //Récuperation des valeurs pour la fonction download

																							echo "<a href='".$path.$name."' download> ";                                            
																								echo '<button type="button" id="btnDownload" name="btnDownload" class="btn btn-sm btn-outline-success btn-block" onclick="return download_file('.$id_file.')">Download file</button>';                                    
																							echo "</a>";                                                                                            
																							$pos=$pos+1;

										echo "</td>";

										echo "<td>";

											echo '<button type="button" id="btnEdit" name="btnEdit" class="btn btn-sm btn-outline-warning btn-block" onclick="return edit_file('.$id_file.')">Edit</button>';

										echo "</td>";

										echo "<td>";

											?>

											<button type='button' id='btnVersions' name='btnVersions' class='btn btn-sm btn-outline-primary btn-block' onclick='return popup("<?php echo $original_id; ?>")'>See versions</button>								

											<?php

										echo "</td>";										

										echo "<td>";

											echo '</br><div align="center"><input  id='.$id_file.' type="checkbox" name="id_file_'.$id_file.'" value="'.$id_file.'" onclick= "compteur('.$id_file.');" ></div>'; 

										echo "</td>";

									echo "</tr>";

								}

							}

							?>

						</tbody>

					</table>

				</div></br>

			</form>

		</div>
	
	Filters selected : 
                
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

                        				echo '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="'.$i.'">'.$row['label_validation_state'].'</button>';
                        			}
                        			echo '</div></div>';  
                        		echo '</div>';
                        	echo '<div class="col-md-3"></div>';
                        echo '</div>';
                    echo '</div>';
					// Save selected filters in a session var 
					 $_SESSION['selected_validation_state']= $valid;

				}

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
						// Save selected filters in a session var 
						$_SESSION['selected_start_date']= $start_date;
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
						// Save selected filters in a session var 
						$_SESSION['selected_end_date']= $end_date;
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
					// Save selected filters in a session var 
					$_SESSION['selected_format']= $format;
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
					// Save selected filters in a session var 
					$_SESSION['selected_project']= $projet;
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
					// Save selected filters in a session var 
					$_SESSION['selected_sources']= $sources;
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
					// Save selected filters in a session var 
					$_SESSION['selected_unit']= $unit;
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
					// Save selected filters in a session var 
					$_SESSION['selected_tag']= $tag;
                }  		  
          ?>





<script type="text/javascript">

        //Ouvrir la popup pour afficher les différentes versions

        function popup(original_id) {	

                window.open("US3_11_Visualiser_liste_fichiers_P2.php?original_id="+original_id,'newWin','width=1000,height=400');

        }	

        

        //Ouvrir la page "edit file"

        function edit_file(id_file) { 

                document.location.href="US3_13_Modifier_fichiers_deposes.php?id_file="+id_file;

        }
		
		function delete_file(id_file) { 

                document.location.href="US3_4_Supprimer_fichiers_deposes.php?id_file="+id_file;

        }

        

        $('[data-toggle="popover"]').popover();



        $('body').on('click', function (e) {

        //only buttons

                if ($(e.target).data('toggle') !== 'popover' && $(e.target).parents('.popover.in').length === 0) { 

                        $('[data-toggle="popover"]').popover('hide');

                }

        });

        

        

        // Function Compteur 

         

        var count=0; 

         

        function compteur(id_file) { 

            if(document.getElementById(id_file).checked){ 

                count++; 

            }

            else{ 

                count--; 

            } 

            document.getElementById("select").innerHTML= 'selected <br> ('+ count +')' ; 

        }

         

        

        function cocherTout(etat){ 

            var cases = document.getElementsByTagName('input');   // on recupere tous les INPUT 

            for(var i=0; i<cases.length; i++)     // on les parcourt 

                if(cases[i].type == 'checkbox')     // si on a une checkbox... 

                cases[i].checked = etat;     // ... on la coche ou non 

        }

         



        function selectAll() { 

            var all = <?php echo $nbrows; ?>; 

            

            if(document.getElementById("id_selectAll").checked){ 

                cocherTout(true); 

				count=all; 

                document.getElementById("select").innerHTML= 'selected <br> ('+ count +')' ; 

            }

            else{ 

                cocherTout(false); 

				count=0; 

                document.getElementById("select").innerHTML= 'selected <br> ('+ count +')' ;

            }

        }



</script>



</body>

	

</html>

