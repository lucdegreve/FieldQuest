
<link rel="stylesheet" href="css/bootstrap.min.css">

<?php
// Définition des sources

require_once "tab_donnees/tab_donnees.class.php";
require_once "tab_donnees/funct_connex.php";

$con = new Connex();
$connex = $con->connection;


// Récupération du début du prénom tapé
$debut=$_GET["debut"];
//parametrage de la requete
$query = "SELECT name_project FROM projects WHERE LOWER (name_project) LIKE LOWER ('%".$debut."%')";

//execution de la requete et récuperation des resultats
$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());


	echo "<div class='container'>";

	echo "<table class='table'>";

	$n = pg_num_rows($result);
	$modulo = $n%4;

	if ($debut != ""){

		if ($n != 0) {
			for ($i=0; $i<($n-$modulo)/4; $i++){
			  echo "<tr>";
			  for ($j=0; $j <4 ; $j++) {
			    echo "<td>";
			    $row=pg_fetch_array($result);

					echo '<div class="form-check">';
	            echo '<label>';
	                echo '<input type="checkbox" name="check" > <span class="label-text">';
											echo $row[0];
	                echo '</span>';
	            echo '</label>';
	        echo '</div>';





			    echo "</td>";
			  }
			  echo"</tr>";
			}
			echo "<tr>";
			for ($k=0; $k <$modulo ; $k++) {
			  echo "<td>";
			  $row=pg_fetch_array($result);



				echo '<div class="form-check">';
						echo '<label>';
								echo '<input type="checkbox" name="check" > <span class="label-text">';
										echo $row[0];
								echo '</span>';
						echo '</label>';
				echo '</div>';




			  echo "</td>";
			}

			echo "</tr>";

			echo "</table>";

			echo "</div>";
		}
		else {
			echo "No suggestion";
		}
	}
	else {
		echo "Please insert a topic ";
	}

?>
