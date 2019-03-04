<html>
	<head>
<!--------------------------------------------------------------------------------
       US4-11 Filtrer avec des tags - Table of query result  
Developped by Ophélie	& Diane	
	      
This page displays the result of the search by tags as a table. 
Code based on "US3_11_Visualiser_liste_fichiers.php" developped by Elsa & Axelle


Input variables : 		

Output variables :								
		
---------------------------------------------------------------------------------->	

		<META charset="UTF-8">
	</head>

	<body>
		<?php

                //Query : filtered search
                // To Do : Add Sources to the query
                $query="SELECT f.id_original_file, MIN(f.upload_date)
                        FROM files f
                            LEFT JOIN version v on f.id_version = v.id_version
                            LEFT JOIN link_file_project lfp ON lfp.id_file=f.id_file
                            LEFT JOIN projects p ON lfp.id_file=p.id_project
                            LEFT JOIN format fr ON fr.id_format=f.id_format
                            LEFT JOIN user_account u ON u.id_user_account=f.id_user_account
                            LEFT JOIN link_tag_project ltp ON ltp.id_file=f.id_file
                            LEFT JOIN tags t ON t.id_tag=ltp.id_tag
                        WHERE f.id_validation_state = '2' AND ";
                if (isset($_POST['start'])){
                if ($_POST['start']!=''){
                        $start_date = $_POST['start'];
                        $query .= " f.upload_date >'".$start_date."' AND ";
                }}
                if (isset($_POST['end'])){
                if ($_POST['end']!=''){
                        $end_date = $_POST['end'];
                        $query .= " f.upload_date <'".$end_date."' AND ";
                }}
                
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
                }}
                
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
		?>

		<!-- Table creation -->
		<div class="container-fluid"> 
			<form name="box_download" method="GET" action="**URL_download**">
				<div class="row">
					<div class="col-md-10"><h1><B>Files list</B></h1></div>
					<div class="col-md-2" align="right">
						<button type="submit" class="btn btn-md btn-success">Download selection</button>
					</div>
				</div></br>
				<div class="row">				
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col" width="5%">State</th>
								<th scope="col" width="25%">File name</th>
								<th scope="col" width="10%">Upload date</th>
								<th scope="col" width="17%">Origin</th>
								<th scope="col" width="8%">Size</th>
								<th scope="col" width="10%"></th>
								<th scope="col" width="10%"></th>
								<th id="select" scope="col" width="10%" style="text-align:center;">Select</th> 
								<th class="droite" scope="col" width="5%" style="text-align:center;"><input id="id_selectAll" type="checkbox" onclick="selectAll();"></th> 
							
							</tr>
						</thead>
						<tbody>
							<?php
							while($row=pg_fetch_array($result_files_id)){
								$id=$row[0];
								//Query to get the last version for each file name
								$query="SELECT id_file, file_name, to_char(upload_date,'DD/MM/YYYY'), file_size, label_validation_state, id_version, last_name, first_name, id_original_file, file_comment
								FROM user_account ua JOIN files f ON ua.id_user_account=f.id_user_account JOIN validation_state vs ON f.id_validation_state=vs.id_validation_state
								WHERE id_original_file='".$id."' AND id_version=(SELECT MAX(id_version) FROM files WHERE id_original_file='".$id."')";
								$result_files_list=pg_query($connex, $query) or die('Échec de la requête : ' . pg_last_error());
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
								
								//State "validated"
								if($valid=="validated"){
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
										echo '<td>'.$name.' <a tabindex="0" class="badge badge-light" role="button" data-toggle="popover" data-trigger="focus" title="Metadata related to this file" data-content="'.$metadata.'">i</a></td>';
										echo "<td>".$date."</td>";
										echo "<td>".$first_name." ".$last_name."</td>";
										echo "<td>".$size."</td>";
										echo "<td>";
											echo '<button type="button" id="btnDownload" name="btnDownload" class="btn btn-sm btn-outline-success btn-block" onclick="return download_file('.$id_file.')">Download</button>';													
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
                





<script type="text/javascript">
        //Ouvrir la popup pour afficher les différentes versions
        function popup(original_id) {	
                window.open("US3_11_Visualiser_liste_fichiers_P2.php?original_id="+original_id,'newWin','width=1000,height=400');
        }	
        
        //Ouvrir la page "edit file"
        function edit_file(id_file) { 
                document.location.href="US3_13_Modifier_fichiers_deposes.php?id_file="+id_file;
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
