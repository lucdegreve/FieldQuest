<!DOCTYPE html>
<html>
<head>
<!-- Page made by Guillaume in order to show the result of a query with a public statue -->
<!-- Edit by Diane -->


<!--Basic styling for map div, if height is not defined the div will show up with 0 px height  -->
<meta charset="utf-8">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>

<body>



<?php
$query =  'SELECT f.id_favorite_search, f.search_label, f.comment, f.begin_date, f.end_date
						FROM favorite_search f
						WHERE status_public_private = true';
$result = pg_query($connex, $query) or die('Echec de la requête :'.pg_last_error($connex));
/*
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

pg_free_result($result);*/


                    echo '<hr>';
                    while ($row = pg_fetch_array($result))
                    {
                            echo '<ul>' ;
                                    echo "<H6> <a class='btn btn-outline-primary btn-sm btn-block' href=US4-11_Main_page_filter.php?id_favorite_search=".$row[0]." class='lien'> <i class='fas fa-search' style='float:left; position:relative; '></i> ".$row[1]."</a></H6>";
                                    echo $row[2];
                            echo '<hr></ul>';
                    }


?>

</body>
</html>
