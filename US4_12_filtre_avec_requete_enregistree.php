<!DOCTYPE html>
<html>
<head>
<!-- Page made by Guillaume in order to show the result of a query with a public statue -->

<link href="css/custom.css" rel="stylesheet" type="text/css">
<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
<script type= 'text/javascript' src = 'manage_checkbox_button.js'></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>

<!-- Openlayers CSS file-->
<style type="text/css">
	#map{
	 width:90%;
	 height:290px;
	}
</style>

<!--Basic styling for map div, if height is not defined the div will show up with 0 px height  -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>

	<?php
	//Header
	include("en_tete.php");
	//DB connection
	require "./tab_donnees/tab_donnees.class.php";
	require "./tab_donnees/funct_connex.php";
	$con = new Connex();
	$connex = $con->connection;
	?>

<?php
$query =  'SELECT f.search_label, f.comment, f.begin_date, f.end_date
						FROM favorite_search f
						WHERE status_public_private = true';
$result = pg_query($connex, $query) or die('Echec de la requête :'.pg_last_error($connex));

echo'<table class="table">';
  echo'<thead class="thead-dark">';
    echo'<tr>';
      echo'<th scope="col">';
      echo'<th scope="col">Search label</th>';
      echo'<th scope="col">Comment</th>';
      echo'<th scope="col">Begin date</th>';
			echo'<th scope="col">End date</th>';
    echo'</tr>';
  echo'</thead>';
  echo'<tbody>';
		while($row = pg_fetch_array($result)) {
    echo'<tr>';
      echo'<th scope="row">1</th>';
      echo'<td>'.$row["search_label"].'</td>';
      echo'<td>'.$row["comment"].'</td>';
      echo'<td>'.$row["begin_date"].'</td>';
			echo'<td>'.$row["end_date"].'</td>';
    echo'</tr>';
	}
  echo'</tbody>';
echo'</table>';

pg_free_result($result);
?>

</body>
</html>
