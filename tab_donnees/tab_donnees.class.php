<?php
class Tab_donnees
{
     protected $t_entete; //tableau d'1 ligne qui contient les en-tête de colonne du recordset (les noms de champs)
     protected $t_type; //tableau d'1 ligne qui contient les types de données des champs du recordset
     public $t_enr;  // tableau 2D qui contient les enregistrements du recordset
     protected $nb_champs; // nombre de colonnes du recordset
     public $nb_enr; // nombre d'enregistrements du recordset

     public function __construct($recordset, $type_recordset)
     {
		 
		//teste si le recordset est de format ODBC ou MYSQL
		switch (strtoupper($type_recordset))
		{
			
			case "ODBC":
				odbc_fetch_row($recordset,0);
				//remplit le tableau des en-têtes et des types de données
		         $this->nb_champs = odbc_num_fields($recordset) ;

		         for ($i=1; $i<=$this->nb_champs; $i++)
		         {
		             $type = odbc_field_type ($recordset, $i);
		             $this->t_type[$i-1]=$type;
					 //echo $type;
					 $this->t_entete[$i-1]= odbc_field_name($recordset, $i);
		         }
				 
		         //remplit le tableau des enregistrements
		         $n=0;
		         while (odbc_fetch_row($recordset)==true)
		         {
		             for ($i=1; $i<=$this->nb_champs; $i++)
		             {
		                 $val = odbc_result($recordset,$i) ;
		                 $this->t_enr[$n][$i-1]=$val;
		             }
		             $n++;
		         }
		         $this->nb_enr= $n;
				 break;

			case "PG":
				//remplit le tableau des en-têtes et des types de données
		         $this->nb_champs = pg_num_fields($recordset) ;

		         for ($i=0; $i<$this->nb_champs; $i++)
		         {
		             $type = pg_field_type ($recordset, $i);
		             $this->t_type[$i-1]=$type;
					 //echo $type;
					 $this->t_entete[$i-1]= pg_field_name($recordset, $i);
		         }
				 
		         //remplit le tableau des enregistrements
		         $n=0;
		         while ($row = pg_fetch_row($recordset)) 
		         {
		             for ($i=1; $i<=$this->nb_champs; $i++)
		             {
						 
		                 $this->t_enr[$n][$i-1]=$row[$i];
		             }
		             $n++;
		         }
		         $this->nb_enr= $n;
				 break;

				 
			 case "MYSQL":
			 
				$mysql_data_type_hash = array(
					1=>'tinyint',
					2=>'smallint',
					3=>'int',
					4=>'float',
					5=>'double',
					7=>'timestamp',
					8=>'bigint',
					9=>'mediumint',
					10=>'date',
					11=>'time',
					12=>'datetime',
					13=>'year',
					16=>'bit',
					//252 is currently mapped to all text and blob types (MySQL 5.0.51a)
					253=>'varchar',
					254=>'char',
					246=>'decimal'
				);
				
				
				
				//mysql_data_seek ($recordset,0);
				$this->nb_champs = mysqli_num_fields($recordset);
				//remplit le tableau des en-têtes et des types de données
				for ($i=0; $i < mysqli_num_fields($recordset); $i++)
                {

				$type = $mysql_data_type_hash[mysqli_fetch_field_direct($recordset,$i)->type];
					
		            $this->t_type[$i]=$type;
		            $this->t_entete[$i]= mysqli_fetch_field_direct($recordset,$i)->name;
                }
				//remplit le tableau des enregistrements
				for ($k = 0; $k < mysqli_num_rows($recordset); $k++)
		        {
				
					$tbl_ligne = mysqli_fetch_array($recordset, MYSQLI_BOTH);
					
					for ($j=0; $j < mysqli_num_fields($recordset); $j++)
			        {
//////			            //$champ = mysql_field_name($recordset,$j);
						$champ = mysqli_fetch_field_direct($recordset,$j)->name;
			            $val = $tbl_ligne["$champ"];
						//echo "k= $k j=$j <br>";
						$this->t_enr[$k][$j]=$val;
					}	
				}
				$this->nb_enr=$k;
				break;
		}		
     }

     //méthode qui renvoie le nombre d'enregistrements du tableau de données
     public function nb_enregistrements ()
     {
          return $this->nb_enr;
     }

     //méthode qui renvoie le nombre de champs du tableau de données
     public function nb_champs ()
     {
          return $this->nb_champs;
     }

     //méthode qui renvoie le type de données d'une colonne par l'indice de colonne (de 0 à nb_champs - 1)
     //$indice_col = indice de la colonne
     public function type_col_indice ($indice_col)
     {
         $type = $this->t_type[$indice_col] ;
          return $type;
     }

     //méthode qui renvoie le type de données d'une colonne par le nom du champ
     //$nom_champ = nom du champ du recordset
     public function type_col_champ ($champ)
     {
         $i=0;
         while ($i< $this->nb_champs && strtoupper($this->t_entete[$i])!=strtoupper($champ))
         {
            $i++;
         }

         if ($i< $this->nb_champs)
         {
            $type = $this->t_type[$i] ;
         }
         else //le champ n'a pas été trouvé
         {
            $type = "non trouvé";
         }
         return $type;
     }

     //méthode qui renvoie l'indice de la colonne à partir du nom de champ
     //si le champ n'est pas trouvé, la fonction renvoie -1
     public function recup_indice_champ ($champ)
     {
         $i=0;
         while ($i< $this->nb_champs && strtoupper($this->t_entete[$i])!=strtoupper($champ))
         {
            $i++;
         }
         if ($i==$this->nb_champs)
         {
             $i=-1;
         }
         return $i;

     }

     //méthode qui affiche le tableau de données sous forme d'un tableau HTML
     public function affich_simple_tableau_HTML  ()
	 {
		 echo "<Table border=1>";

         //CREATION EN-TETE du TABLEAU
         echo "<thead><tr>";
         $j=0;
         while ($j< $this->nb_champs)
         {
             $libel_entete = $this->t_entete[$j];
             echo "<TD>$libel_entete</TD>";
             $j++;
         }
         echo "</TR></THEAD>";

         //CREATION DU CORPS DU TABLEAU
         echo "<tbody>";
         //balaye le tableau de données
         for ($i=0; $i<$this->nb_enr;$i++)
         {
             echo "<tr>";
             //balaye les champs
             $j=0;
             while ($j< $this->nb_champs)
             {
                //récupère la valeur à afficher
                $val = $this->t_enr[$i][$j];
                echo "<td>$val &nbsp</TD>";
                $j++;
             }
             echo "</tr>";
         }
         echo "</table>";
     }

	/*
	$champ_site = nom du champ qui contient l'adresse du site internet (mettre "" si on n'a pas de site internet dans un champ)
	$champ_mail = nom du champ sur lequel on doit faire un lien mailto 
	$champ_lien = nom du champ qui servira à créer les variables transmises pour les liens hypertexte (pour la première colonne, la colonne $champ_href et les colonnes modifier et supprimer). : valeur transmise = valeur du champ_lien 
	$champ_href = nom du champ sur lequel sera placé le lien hypertexte (si on veut l'utiliser, il est nécessaire de renseigner $champ_lien et $fichier_href)
	$fichier_href = nom du fichier vers lequel on va envoyer sur le clic du lien hypertexte sur le champ $champ_ref
	$modif = nom du fichier vers lequel on envoie si on veut modifier la fiche : si vide (""), pas de modification possible (si on veut modifier, il est nécessaire de renseigner $champ_lien)
	$supprim = idem mais pour un lien de suppression(si  on veut supprimer, il est nécessaire de renseigner $champ_lien)
	$tableau_entete = si renseigné, indique les en-têtes du tableau à afficher (si '', prend les en-têtes par défaut du recordset)
	$tablo_champs_a_afficher = si renseigné, indique les champs du recordset à afficher (si '', prend les champs par défaut du recordset)
	$fichier_lien_col1, $libelle_lien_col1 servent à créer une première colonne dans le tableau avec un lien hypertexte vers le fichier $fichier_lien_col1
	la variable transmise portera le nom du champ lien et renverra la valeur du champ_lien 
	nb : ne rien renseigner dans ces 2 variables si on ne veut ps créer de première colonne spécifique
	EXEMPLE :
	paramétrage du tableau d'entête particulier
	$tablo_entete[0]='Nom';
	$tablo_entete[1]='Prénom';
	$tablo_entete[2]='Adresse';
	$tablo_entete[3]='Code postal';
	$tablo_entete[4]='Ville';
	$tablo_entete[5]='Téléphone';
	$tablo_entete[6]='Site';
	$tablo_entete[7]='Mail';

	//paramétrage de la liste restreinte de champ à afficher (ici on affichera tous les champs sauf le code client)
	$tablo_affich[0]='Nom';
	$tablo_affich[1]='pre_cl';
	$tablo_affich[2]='ad_cl';
	$tablo_affich[3]='cp_cl';
	$tablo_affich[4]='ville_cl';
	$tablo_affich[5]='tel_cl';
	$tablo_affich[6]='site';
	$tablo_affich[7]='Mail'; 

	*/
     function creer_tableau ($class_tablo, $id_tablo, $champ_site, $champ_mail, $champ_lien, $champ_href, $fichier_href, $modif, $supprim, $tableau_entete, $tablo_champs_a_afficher, $fichier_lien_col1, $libelle_lien_col1)
     {
		echo '<script type="text/javascript">';
		echo "$(document).ready(function() {
			$('#".$id_tablo."').DataTable( {
				'scrollY': 200,
				'scrollX': true
			} );
		} );";
		echo "</script>";
		 
		 if ($class_tablo=="")
		 {
			$classe = "";
		 }
		 else
		 {
			$classe="class='".$class_tablo."'";
		 }
		 echo "<table id='".$id_tablo."'". $classe.">";

         //CREATION EN-TETE du TABLEAU
    	 echo "<thead><TR>";
         
	
		  //si on a choisi de créer une première colonne avec un lien hypertexte
		 if ($fichier_lien_col1 !='')
		 {
			echo "<th></Th>";
		 
		 }	 
		 //si on a spécifié un tableau d'entête particulier, on l'affiche
		 if ($tableau_entete!='')
		 {
			$j=0;
			while ($j< count($tableau_entete))
		     {
			 
						
		        $libel_entete = $tableau_entete[$j];
						

		        echo "<Th>$libel_entete</Th>";
		        $j++;
		     }
		 }
		 else
		{	 
			// on a spécifié un affichage restreint des champs du recordset => adpater l'entête en conséquence
			if ($tablo_champs_a_afficher!='')
			 {
				$j=0;
				while ($j< count($tablo_champs_a_afficher))
			     {
					$libel_entete = $tablo_champs_a_afficher[$j];
			        echo "<Th>$libel_entete</Th>";
			        $j++;
			     }
			 }
			 else
			 {
				//tableau d'en-tête par défaut
				 {
				 	 $j=0;
					 while ($j< $this->nb_champs)
				     {				
				        $libel_entete = $this->t_entete[$j];
				        echo "<Th>$libel_entete</Th>";
				        $j++;
				     }
				 }
			 }
		 }
		 
		 
         // rajoute les en têtes pour les colonnes "modifier" et "supprimer", si besoin
         if ($modif != "")
                 echo ("<TH>" . "Modifier" . "</TH>");
         if ($supprim != "")
                  echo ("<TH>" . "Supprimer" . "</TH>");
         echo "</TR></THEAD>";

         //CREATION DU CORPS DU TABLEAU
         echo "<tbody>";
         $c=0;
		 $bcolor="";
         //balaye le tableau de données
         for ($i=0; $i<$this->nb_enr;$i++)
         {
             echo ("<TR>");

			if ($champ_lien !='')
			{
				$indice_champ_lien = $this->recup_indice_champ ($champ_lien);
				$lien = $this->t_enr[$i][$indice_champ_lien]; 
			}
			
			//si on a choisi de créer une première colonne avec un lien hypertexte
			if ($fichier_lien_col1 !='')
			{
				echo "<td><a href ='$fichier_lien_col1?$champ_lien=$lien' class='lien'>$libelle_lien_col1</A>&nbsp</font></TD>";
			}

			 
			 //regarde si on a une liste de champs spécifiques fournie
			 if ($tablo_champs_a_afficher!='')
			 {
				$nb_champs = count($tablo_champs_a_afficher);
			 }
			 else
			 //prend la liste de tous les champs du recordset
			 {
				$nb_champs=$this->nb_champs;
			 }
            
			//balaye les champs
             $j=0;			 
             while ($j< $nb_champs)
             {
				//récupère la valeur à afficher
				//regarde si on a une liste de champs spécifiques fournie
                if ($tablo_champs_a_afficher!='')
				 {
					$champ =$tablo_champs_a_afficher[$j];
				 }
				 else
				 //prend la liste des les champs du recordset
				 {
					$champ = $this->t_entete[$j];
				 }
				 $indice_champ = $this->recup_indice_champ($champ);
				
				
				 $val = $this->t_enr[$i][$indice_champ];
				 
				//teste si on doit mettre un lien site
                If (strtoupper($champ) == strtoupper($champ_site))
                {
					//crée le lien hypertext
					$val = "<a href='http://$val' class='lien'>$val</a>";
                }
				//teste si on doit mettre un lien mailto
                If (strtoupper($champ) == strtoupper($champ_mail))
                {
					//crée le lien hypertext
					$val = "<a href='mailto:$val' class='lien'>$val</a>";
                }
				//teste si on doit mettre un lien hypertexte sur le champ
                If (strtoupper($champ) == strtoupper($champ_href))
                {
					//crée le lien hypertext
					$val = "<a href=$fichier_href?$champ_lien=$lien class='lien'>$val</a>";
                }
				
				//teste si la valeur est de type date

				$align=" align='left'";
				//teste pour les types de données
				$type_champ=$this->type_col_champ($this->t_entete[$j]);
				
						if ($type_champ=='char' || $type_champ=='varchar' || $type_champ=='text' || $type_champ=='string')
						{
							$align=" align='left'";
						}
						else
							if ($type_champ=='date' || $type_champ=='datetime')
							{
								$align=" align='center'";
							}
							else
							{
								$align=" align='right'";;
							}
				echo "<td$align>$val &nbsp</TD>";
                $j++;
				}
			
			// ajoute éventuellement la colonne modifier
			if ($modif != "")
            {
				echo ("<TD><a href = $modif?$champ_lien=$lien class='lien'>Modifier</A></TD>");
			}
			// ajoute éventuellement la colonne supprimer
			if ($supprim != "")
            {
				echo ("<TD><a href = $supprim?$champ_lien=$lien class='lien'>Supprimer</A></TD>");
			}
			echo "</tr>";
         }
		  echo "</tbody></table>";
     }

     // méthode qui crée une liste à partir du tableau de données
     //$champ_stock = nom du champ du recordset qui servira pour la valeur de la liste
     // $champ_affich = nom du champ du recordset à afficher dans la liste
     //$ligne_defaut = valeur de la ligne qui doit être affichée à l'ouverture de la liste.
     //mettre "" si on ne veut pas présélectionner une ligne en particulier
     //$optionplus = code et libelle d'une ligne supplémentaire à ajouter pour la liste
     //mettre "" si on ne veut pas jouter de ligne particulière
     // ex : creer_liste_option_plus('lst_prod','ref_produit', 'libelle', 'A03', 'aucun')
     //la liste stockera la référence du produit, affichera son libellé. Et par défaut,
     //la ligne présélectionée sera celle correspondant au produit dont la référence est A03
     //en plus de la liste des produits, il y aura une ligne avec 'AUCUN'.
     function creer_liste_option_plus ( $nom_liste, $champ_stock, $champ_affich, $ligne_defaut="", $optionplus="")
     {
     
     $indi_stock =  $this->recup_indice_champ($champ_stock);
     $indi_affich =$this->recup_indice_champ($champ_affich);
     $ligne_sel = "";
     echo "<SELECT NAME ='$nom_liste'>";
     //teste s'il faut afficher une ligne particulière en début de liste
         if ($optionplus != "")
         {
             if ($optionplus ==$ligne_sel)
             {
                $ligne_sel = "";
             }
             echo "<OPTION VALUE ='$optionplus' $ligne_sel>$optionplus</OPTION>";
         }
         //crée une ligne dans la liste pour chaque ligne du tableau de données
         for ($i=0; $i<$this->nb_enr;$i++)
         {
             //récupère la valeur à stocker et la valeur à afficher
             $stock = $this->t_enr[$i][$indi_stock];
             $affich = $this->t_enr[$i][$indi_affich];
             //teste si l'option en cours de sélection est la ligne à afficher
             if ($ligne_defaut == $stock)
             {
                 $ligne_sel = "selected" ;
             }
             else
             {
                 $ligne_sel = "";
             }

             //crée la ligne dans la liste
             echo "<OPTION VALUE ='$stock' $ligne_sel>$affich</OPTION>";
          }
          echo "</SELECT>";
     }

	//méthode qui renvoie la valeur d'un champ du tableau de données qui répond à un critère donné
	//Exemple : trouve_valeur("nom","code_client", "== '00005'"); renvoie le nom du client dont le code_client est égal à 00005
	function trouve_valeur ($nom_champ_affich, $nom_champ_critere, $condition)
	{
	   $nb=0;
       $indi_champ_condition= $this->recup_indice_champ ($nom_champ_critere);
	   $indi_champ_affich= $this->recup_indice_champ ($nom_champ_affich);
      $retour ="";
	  //balaye le tableau de données
	  $i =0;
      while (($i<$this->nb_enr)&& ($retour==""))
      {
         //récupère la valeur contenue dans la colonne qui contient la valeur à tester
         $val = $this->t_enr[$i][$indi_champ_condition];
         //test pour voir si la valeur répond à la condition : si oui, on incrémente la somme
          $chaine_condition = "$" . "ma_condition= ('" .$val . "'". $condition . ");";
		 
          eval($chaine_condition);
		//echo $chaine_condition;
         if ($ma_condition)
         {
             $retour =$this->t_enr[$i][$indi_champ_affich];
         }
		 $i++;
      }
       return $retour;
	}



	
}?>