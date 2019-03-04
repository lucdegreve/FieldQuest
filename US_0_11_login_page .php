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
            
            
            //$link = pg_connect("dbname=fieldquest user=postgres password=postgres");
            $link = pg_connect("dbname=fieldquest user=postgres password=Admin");
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
                            header('Location: US3_11_Visualiser_liste_fichiers.php');
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
        
       <?php
				 include("en_tete.php");
		?>
        
        
        
            <div class="card border-white" style="padding-top: 2%;">
                <div class="row">
                    <div class="col-md-1 col-sm-1">
                    </div>
                    <div class="col-md-3 col-sm-2"></div>
                    <!-- Centre de page-->
                                       
                    
                    <div class="col-md-4 col-sm-6 border-white bg-secondary" style="border-radius: 15%;padding: 2%">
                        

                            <form id="connecter" method ="post" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']); ?> "  role="form">
                                <div class="form-group">
                                    <label for="Email1">Login</label>
                                    <input type="text" name="login" class="form-control" id="Email1" aria-describedby="emailHelp" placeholder="Login" value="<?php echo $login; ?>" >
                                    <p class="comments text-light" > <?php echo $loginError; ?></p>
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="Password1">Password</label>
                                    <input type="password" name="ps" class="form-control" id="Password1" placeholder="Password">
                                     <p class="comments text-light" > <?php echo $psError; ?></p>
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
       
       
        </br>
		</br>
		</br>
		</br>
		
        
        
        
        
        
         
       
        
        <?php
				 include("pied_de_page.php");
		?>
     
        
       
        
    
    </body>




</html>