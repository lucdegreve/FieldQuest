<?php
class Connex
{
	
	public $connection ;

     public function __construct(){

		 $this->connection = pg_connect("host=194.199.251.150 port=5432 dbname=fieldquest user=postgres password=postgres")or die ("Connexion impossible");

		    //$this->connection = pg_connect("host=194.199.251.150 port=5432 dbname=fieldquest user=postgres password=postgres")or die ("Connexion impossible");
         

     }
	 
}?>