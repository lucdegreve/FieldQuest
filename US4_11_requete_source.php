code effectue par Florian et clement en lien avec la source : barre de recherche avec checkbox
<html>
<head>
	<META charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js">
</script>

<!-- Section Javascript: définition de la fonction gérant la récupération des données -->
<script type="text/javascript">

	function search_sources(str){
		$.ajax({
			type: 'get',
			dataType: 'html',
			url: 'affichage_recherche.php', // Si on fait une erreur dans le nom du fichier php, la requête échoue.
			timeout: 1000, //délai (en ms) pour que la requête soit exécutée. Si ce délai est dépassé, on exécute la fonction spécifiée dans le paramètre "error".
			data: {
				debut:str
				},
			success: function (response) {
				document.getElementById("txtFiles").innerHTML=response;
			},
			error: function () {
				alert('La requête a échouée');
			}

		});

	}

</script>

</head>
<?php include('menu_administrateurs.html'); ?>
<body>
	<div class = "container">
		<!-- Ci-dessous la section réservée à l'affichage de la liste déroulante  -->
		<h3> Select the sources </h3>


		<nav class="navbar navbar-light bg-light">
	  	<form class="form-inline">
	    	<div class="input-group">
					<p><b>Please enter your research :<br/></p>
	      		<input type="text" onkeyup="search_sources(this.value)" size="20" />
	    	</div>
	  	</form>
		</nav>

				<h3>Suggestions:</h3>
				<br/>
				<span id="txtFiles"></span>

	</div>


</body>
</html>
