<?php
class ConnexEntete
{

	public $connection ;

     public function __construct(){
		 $this->connection = pg_connect("host=localhost port=5432 dbname=fieldquest user=postgres password=postgres")or die ("Connexion impossible");
     }
	 
}?>
