<!--Code développé par clément. Il permet de selectionner les sources ainsi que de les enlever
si une erreur a été effectuée. Il n'y a plus de barre de recherche car trop compliqué
Dans la requete : Peut etre changer le mot sources car différents noms en fonction des gens

ligne 90 url : mettre l'url souhaité-->

<!DOCTYPE html>
<html>
 <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

   $con = new Connex();
   $connex = $con->connection;

   $query = "SELECT sources FROM files";
   $result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());

   $n = pg_num_rows($result);
   ?>

  <br />
  <div class="container">
   <div class="row">
    <h2 align="center">Tentative PHP Ajax</h2>
     <br />
     <div class="col-md-6" style="margin:0 auto; float:none;">
      <span id="success_message"></span>
      <form method="post" id="programmer_form">
       <div class="form-group">
        <label>Sources</label>
        <input type="text" name="sources" id="sources" class="form-control" />
       </div>
       <div class="form-group">
        <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
       </div>
      </form>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>
<script>

<?php
$list = array();
while($row = pg_fetch_array($result)) {
  $list[] =  $row[0];
}
$list = join( $list, "','");
echo("aaaalist = ['".$list."']");
?>




$(document).ready(function(){

 $('#sources').tokenfield({
  autocomplete:{
   source: aaaalist,
   delay:100
  },
  showAutocompleteOnFocus: true
 });

 $('#programmer_form').on('submit', function(event){
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
    url:"insert.php",
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
