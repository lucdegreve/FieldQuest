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
			<title></title>
			<link rel="stylesheet" href="css/bootstrap.min.css">
			<link rel="stylesheet" href="css/custom.css">
			<!-- Import for collapse -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>  
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
		</head>
		<body>


			<!-- Navbar for Search -->
			<nav class="navbar navbar-light bg-light">
			  <form class="form-inline">
					<FONT size="6">Search :</FONT>
			  </form>
			</nav>
			<br/>
			<!-- button data type with collapse -->
			<div class="container">

				<button type="submit" name="button1" class="btn btn-success btn-block" data-toggle="collapse" data-target="#collapsefirst" aria-expanded="true" aria-controls="collapseExample"/>
				Data type
				</button>
				
			</div>
			</br>
			<!-- separateur -->
			<hr size="8" width="90%" color="success">
			</br>
			<!-- collapse div -->
			<div class="collapse" id="collapsefirst">
				<div class="card card-body">

			<?php
			
			// connection to data base
				require_once "funct_connex.php";
				$con = new Connex();
				$connex = $con->connection;
				$requete = "SELECT id_tag_type, name_tag_type FROM tag_type";
				$result=pg_query($connex,$requete);//exécution de la requête
				$pp=pg_num_rows($result);
				echo "<table>";
				echo "<tr>";
				
			// For loop for first button	
					for ($i=0 ;  $i<$pp ;$i++){
						
						$row=pg_fetch_row($result);
						$id=$row[0];
						$name=$row[1];
						
						echo "<td>";
						
						echo '<button type="submit" name='.$name.' value='.$id.' class="btn btn-primary" data-toggle="collapse" data-target="#collapse'.$id.'" aria-expanded="true" aria-controls="collapse2">';
						echo $name;
						echo '</button>';
						
						echo "&nbsp; ";
						
						echo '<div class="collapse" id="collapse'.$id.'">';
						echo '<div class="card card-body">';
						
						// second button
							$requete2 = "SELECT id_tag, tag_name FROM tags WHERE id_tag_type=$id";
							$result2=pg_query($connex,$requete2);//exécution de la requête
							$pp2=pg_num_rows($result2);
						
						
							echo "<table>";
							
				
				
							for ($j=0 ;  $j<$pp2 ;$j++){
						
								$row2=pg_fetch_row($result2);
								$id2=$row2[0];
								$name2=$row2[1];
								echo "<tr>";

								echo "<td>";
								
								echo '<span class="button-checkbox">';
								echo '<button type="button" class="btn" data-color="primary" id = "'. $id2 .'">'.$name2.'</button>';
								echo '<input type="checkbox" class="hidden" />';
								echo '</span>';
								
								echo "</td>";
								echo "</tr>";
								}
								
								echo "</table>";
								
								
						echo "</td>";
					}
			
				echo "</tr>";
				echo "</table>";
			


			?>
			
			</div>
			</div>
		</body>
</html>