<!--Code développé par clément. Modifié par Ophélie et Diane. 
Il permet de selectionner les sources ainsi que de les enlever
si une erreur a été effectuée. Il n'y a plus de barre de recherche car trop compliqué
Dans la requete : Peut etre changer le mot sources car différents noms en fonction des gens

ligne 90 url : mettre l'url souhaité-->

<!DOCTYPE html>
<html>
 <head>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
 </head>
 <body>
   <?php
   //index.php

   require_once "tab_donnees/tab_donnees.class.php";
   require_once "tab_donnees/funct_connex.php";

  

   $query = "SELECT id_user_account, first_name, last_name FROM user_account";
   $result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());

   $n = pg_num_rows($result);
   ?>

      <span id="success_message"></span>
       <div class="form-group">
        <p>
			<button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapseSource" aria-expanded="true" aria-controls="collapseSource">
				Sources
			</button>
		</p>
		<div class="collapse" id="collapseSource">
			<div class="card card-body">
				<input type="text" name="sources" id="sources" class="form-control" />
			</div>
		</div>
       </div>

 </body>
</html>
<script>

<?php
$list = array();
while($row = pg_fetch_array($result)) {
  $list[] = '{value:'.$row[0].',label:"'.$row[1].' '.$row[2].'"}';
}
$list = join( $list, ",");
echo("aaaalist = [".$list."]");
?>




$(document).ready(function(){

 $('#sources').tokenfield({
  autocomplete:{
   source: aaaalist,
   delay:100
  },
  showAutocompleteOnFocus: true
 });

 $('#filters').on('submit', function(event){
  event.preventDefault();
  if($.trim($('#sources').val()).length == 0)
  {
   alert("Please Enter atleast on source");
   return false;
  }
  else
  {
   var form_data = $(this).serialize();
   $('#submit').attr("disabled","disabled");
   $.ajax({
    url:"US4-11_Result_table_filter.php",
    method:"POST",
    data:form_data,
    beforeSend:function(){
     $('#submit').val('Submitting...');
    },
    success:function(data){
     if(data != '')
     {
      $('#sources').tokenfield('setTokens',[]);
      $('#success_message').html(data);
      $('#submit').attr("disabled", false);
      $('#submit').val('Submit');
     }
    }
   });
   setInterval(function(){
    $('#success_message').html('');
   }, 5000);
  }
 });

});
</script>
