<html>
		<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by Antoine Autran			      
This page contains code to display the filter labels based on the format of files 


Input variables : 		

Output variables :		id of selected formats 								
		
------------------------------------------------------------->
			<meta charset="utf-8">
			<!-- Import for collapse and event handling of checkbox buttons in main page US4-11_Filtre_avec_tag_all_tags.php -->
		</head>
		<body>


			<!-- button data type with collapse -->
                        <p>
				<button type="button" name="button1" class="btn btn-sm btn-primary btn-block" data-toggle="collapse" data-target="#collapseFirst" aria-expanded="true" aria-controls="collapseFirst"/>
				Data type
				</button>
                        </p>
			</br>
			
			</br>
			<!-- collapse div -->
			<div class="collapse" id="collapseFirst">
				<div class="card card-body">
                                <div class="form-check">

			<?php
			
			// connection to data base in main page 'US4-11_Filtre_avec_tag_all_tags.php'
				$requete = "SELECT id_tag_type, name_tag_type FROM tag_type";
				$result=pg_query($connex,$requete);//exécution de la requête
				$pp=pg_num_rows($result);
                                
				echo "<table>";
				
				
			// For loop for first button	
					
					for ($i=0 ;  $i<$pp ;$i++){
						echo "<tr>";
						$row=pg_fetch_row($result);
						$id=$row[0];
						$name=$row[1];
						
						echo "<td>";
						echo '<button type="button" name='.$name.' value='.$id.' class="btn btn-sm btn-primary btn-block" data-toggle="collapse" data-target="#collapse'.$id.'" aria-expanded="true" aria-controls="collapse2">';
						echo $name;
						echo '</button>';
						
						
						echo '<div class="collapse" id="collapse'.$id.'">';
						echo '<div class="card card-body">';
						
						// second button
							$requete2 = "SELECT id_tag, tag_name FROM tags WHERE id_tag_type=$id";
							$result2=pg_query($connex,$requete2);//exécution de la requête
							$pp2=pg_num_rows($result2);
					
				
				
							for ($j=0 ;  $j<$pp2 ;$j++){
						
								$row2=pg_fetch_row($result2);
								$id_tag=$row2[0];
								$name_tag=$row2[1];
								
								
								echo '<span class="button-checkbox">';
								echo '<button type="button" class="btn btn-sm" data-color="primary" id = "'. $id_tag .'">'.$name_tag.'</button>';
                                echo '<input type="checkbox" style="display: none;" name="tag[]" value="'.$id_tag.'"/>';
								echo '</span>';
								
								}
								
							
								
								
                            echo '</td>';
                            echo "</tr>";
					}
				
				echo "</table>";

			?>
			</div>
			</div>
			</div>
		</body>
</html>