<!-- Binome : Fagniné Jean -Baptiste-->
    <!-- Variables appellées : Id d'un utilisateur, son mot de passe, et information personnelles -->
    <!-- Variables renvoyées : Id d'un utilisateur, son mot de passe, et information personnelles-->
    <!-- Objectif de la page : * Faire le formulaire d'identification
                               * Vérifie la correspondance double
                               * Rédirection vers acceuil ou message d'erreur
                               * Création variable session " ID "-->


<?php
    $login = $ps = "";
    $loginError = $psError = "";
    if($_SERVER["REQUEST_METHOD"] == "POST" )
    {
        $login = InputCleaner($_POST['login']);
        $ps = InputCleaner($_POST['ps']);
        
        
        if(!empty($login))
        {
            // connexion à la base de données Fieldquest
            $link = pg_connect("dbname=Fieldquest user=postgres password=Admin");
            $query = "select login, password from user_account
                      where login = '".$login."'";
            $result = pg_query($link, $query);
            
            
           
            
            if(pg_num_rows($result) == 1){                
                while ($row = pg_fetch_row($result)) {
                    //echo "login:".$row[0]." password: ".$row[1];
                    //echo "<br />\n";

                        if($ps == $row[1])
                        {
                            //echo "bon ps";
                            header('Location: http://www.commentcamarche.net/forum/');
                            exit();
                        }else{
                            $psError = "Wrong password ";

                        }



                }

                
            }elseif(pg_num_rows($result) == 0){
                $loginError = "Your login does not existe";
            }else{
                
            }
            
           
            
            

        }else{
            $loginError = "Enter your login please";
        }

        if(empty($ps))
        {
            $psError = "Enter your password please";

        }
        
        
        
        
        
        
    }

   
    function InputCleaner($var)
    {
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }


?>



<! DOCTYPE html>
<html>
    <head>
        <title> Page de connexion </title>
        <meta name="viewport" content="width=device-width, initial-scale=1" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/custom.css">
    
    
    </head>

    <body>
        
         <div class="row no-gutters">
                
                <div class="col-md-2 col-sm-5 "   >
                    <a class="navbar-brand" href="#">
                        <img src="picto/logo.jpg"  class="img-fluid rounded" alt=""  style="width: 100%;">
                    </a>
                </div>
               
                <div class="col-md-1 col-sm-2">
                   
                </div> 
                <div class="col-md-9 col-sm-5 ">
                    <nav class="navbar navbar-expand-lg navbar-light"  style="height: 15%; float: right;  ">
                    <a class="navbar-brand" href="#">     </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-item nav-link" href="#"><h4>Link1</h4></a>
                            <a class="nav-item nav-link" href="#"><h4>Link1</h4></a>
                            <a class="nav-item nav-link" href="#"><h4>Help </h4></a>
                            
                        </div>
                    </div>
                    </nav>
                                  
                </div>
            
            
            </div>   

        
        
        
            <div class="card border-white" style="padding-top: 2%;">
                <div class="row">
                    <div class="col-md-1 col-sm-1">
                    </div>
                    <div class="col-md-3 col-sm-2"></div>
                    <!-- Centre de page-->
                                       
                    
                    <div class="col-md-4 col-sm-6 border-white bg-secondary" style="border-radius: 15%;padding: 2%">
                        

                            <form id="connecter" method ="post" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']); ?> "  role="form">
                                <div class="form-group">
                                    <label for="Email1">Email address</label>
                                    <input type="email" name="login" class="form-control" id="Email1" aria-describedby="emailHelp" placeholder="prenom@geosys.fr" value="<?php echo $login; ?>" >
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                    <p class="comments text-light" > <?php echo $loginError; ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="Password1">Password</label>
                                    <input type="password" name="ps" class="form-control" id="Password1" placeholder="Password">
                                     <p class="comments text-light" > <?php echo $psError; ?></p>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="Check1">
                                    <label class="form-check-label" for="Check1">Check me out</label>
                                </div>
                                <button type="submit" class="btn btn-success">Connect</button>
                            </form>
                        
                           
                    </div>
                        
                     

                    <!-- Centre de page-->
                    <div class="col-md-3 col-sm-2"> </div>
                    <div class="col-md-1 col-sm-1">
                        <b class="card text-center border-white"></b>           
                    </div>
                </div>
                <div class="row"></div>
                
            </div>
       
       
        
        
        
        
        
        
         
       
        
        
     
        
       
        
    
    </body>




</html>