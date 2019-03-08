<!doctype html>
<html lang="en">


<head>

<?php
	//include("en_tete.php");
	$id_user=$_SESSION['id_user_account'];

    // pour verifier cette page il faut donner une valeur à $id_user. si on ne souhaite pas partir de la page de connexion car $_SESSION['id_user_account'] ne sera pas defini dans ce cas
    //$id_user=1;
?>


<!-- Développeur : Eva & Liantsoa
	Access my deposit history
	-> writing the query to access the list of my submitted files
	-> table to display the results of the query
	-->

	    <link href="custom.css" rel="stylesheet" type="text/css">
		<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
        <script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
        <script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>

 <title >Upload history</title>

 <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">

 <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>

 <!-- Openlayers CSS file-->

 <style type="text/css">
  #map{
   width:40%;
   height:300px;
  }
 </style>
 <!--Basic styling for map div,
 if height is not defined the div will show up with 0 px height  -->

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>

</head>

<body>

<?php

//require "./tab_donnees/tab_donnees.class.php";
//require "./tab_donnees/funct_connex.php";

$con = new Connex();
$connex = $con->connection;

$query = "SELECT f.id_file, f.file_name, f.id_format, fo.label_format, v.label_validation_state, f.id_version, f.upload_date, f.file_comment, f.data_init_date, f.data_end_date, f.upload_date, f.evaluation_comment, f.file_size, f.file_place
FROM files as f JOIN validation_state v ON f.id_validation_state = v.id_validation_state
JOIN format fo ON fo.id_format=f.id_format
WHERE f.id_user_account=$id_user;";


$result = pg_query($connex,$query) or die (pg_last_error() );





echo "</BR>";

?>



</br>


		<div class="container-fluid">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">

					<script type="text/javascript">
					$(document).ready(function() {
					    $('#example').DataTable();
					} );
					</script>

					<?php
					//creation du tableau

						echo '<table id="example"   cellpadding="4" bordercolor="E8E8E8" bgcolor="white">';
					// en tete du tableau
							echo '<thead class="thead-dark">';
								echo '<tr>';
									echo '<th>' ;
										echo  'ID';
									echo '</th>';
									echo '<th>';
										echo  'Name';
									echo '</th>';

                                    echo '<th>';
										echo  'Visualize';
									echo '</th>';


									echo '<th>';
										echo  'Format';
									echo '</th>';
									echo '<th>' ;
										echo  'Status';
									echo '</th>';
									echo '<th>' ;
										echo  'Version';
									echo '</th>';
									echo '<th>';
										echo  'Upload date';
									echo '</th>';
									echo '<th>';
										echo  'Comment';
									echo '</th>';
									echo '<th>';
										echo  'Init date';
									echo '</th>';
									echo '<th>';
										echo  'End date';
									echo '</th>';
									echo '<th>';
										echo  'Evaluation date';
									echo '</th>';
									echo '<th>';
										echo  'Evaluation comment';
									echo '</th>';
									echo '<th>';
										echo  'Size';
									echo '</th>';
									echo '<th>';
										echo  'Delete';
									echo '</th>';
								echo '</tr>';
							echo '</thead>';

					//corps du tableau
							echo '<tbody>';
							while ($row = pg_fetch_array($result))


								{
									echo '<tr>' ;
										for($i=0; $i<  pg_num_fields($result)-1; $i++)
										{
											if($i ==2){
                                                $format=$row[$i+1];
                                                $link = $row[13]."".$row[$i-1];

                                                switch ($format){
                                                    case 'jpg':
                                                        echo '<td>';
                                                            echo "  <button type='button' class='btn btn-outline-primary'  onclick='return popup_visualize($row[0])'>Visualize</button>	  ";
                                                        echo '</td>';
                                                        break;

                                                    case 'png':
                                                        echo '<td>';
                                                            echo "  <button type='button' id='btnVisualize' name='btnVisualize' class='btn btn-sm btn-outline-primary btn-block'  onclick='return popup_visualize($row[0])'>Visualize</button>	  ";
                                                        echo '</td>';
                                                        break;

                                                    case 'xlsx':
                                                        echo '<td>';

                                                            echo '	<a href='.$link.' target="_blank" class="btn btn-sm btn-outline-primary btn-block" style="" > Download';


                                                            echo '</a>';

                                                        echo '</td>';
                                                        break;

                                                    case 'pdf':
                                                        echo '<td>';
                                                       echo '	<a href='.$link.' target="_blank" class="btn btn-sm btn-outline-primary btn-block" >Visualize</a>';
                                                        echo '</td>';



                                                        break;

                                                    default:
                                                         echo '<td>';


                                                            echo '	<a href='.$link.' target="" class="btn btn-sm btn-outline-primary btn-block" style="" > Download';

                                                            echo '</a>';

                                                        echo '</td>';
                                                        break;
                                                }




                                            }else{
                                                echo '<td>';
												echo $row[$i]."";

											echo '</td>';

                                            }

										}
											echo '<td>';
												if ($row[3]=='not validated')
												{
												echo ("<a href ='US3_11_Visualiser_liste_fichiers.php' class='lien'>Delete</A>");
												}
												else
												{
												echo " ";
												}
											echo '</td>';
									echo '</tr>';
								}
							echo '</tbody>';
						echo '</table>'

					?>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
		</BR>
<?php
	// Include footer
	include("pied_de_page.php");
?>

</body>


<script type="text/javascript">
		//Ouvrir la popup pour afficher les différentes versions
		function popup(original_id) {
			window.open("US3_11_Visualiser_liste_fichiers_P2.php?original_id="+original_id,'newWin','width=1000,height=400');
		}

		//Ouvrir la popup pour visualiser le fichier
		function popup_visualize(original_id) {
			window.open("US5_2_Visualize?original_id="+original_id,'newWin','width=1000,height=400');
		}

        function popup_visualize_xls(original_id) {
				window.open("US5_2_Visualize_xls?original_id="+original_id,'newWin','width=1000,height=400');
			}

		//Ouvrir la page "edit file"
		function edit_file(id_file) {
			document.location.href="US3_13_Modifier_fichiers_deposes.php?id_file="+id_file;
		}

		//Ouvrir la page "US3_4_Supprimer_fichiers_deposes"
		function delete_file(id_file) {
			document.location.href="US3_4_Supprimer_fichiers_deposes.php?id_file="+id_file;
		}

	</script>

</html>
