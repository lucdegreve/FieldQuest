<html>
<?php
include("en_tete.php");
echo "</br>";
require "./tab_donnees/tab_donnees.class.php";
require "./tab_donnees/funct_connex.php";

$id_user=$_SESSION['id_user_account'];
$user_type=$_SESSION['id_user_type'];

//Determine the origin of the file
if(!isset($_SESSION["id_user_list"]) or $_SESSION["id_user_list"]==""){
	$origin=$id_user;
}
else{
	$origin=$_SESSION["id_user_list"];
}


//Get all infos on uploaded file
$file_name = $_SESSION["upload_filename"];
$file_place = $_SESSION["upload_location"];
$file_size = $_SESSION["upload_file_size"];
$comment=$_GET['Comment'];
$longitude= $_SESSION['longitude'];
$latitude = $_SESSION['latitude'];
$file_projet= $_GET['lst_proj'];
// date from the daterange picker
$date=$_GET['daterange'];
//get file format
$file_extension = end(explode('.',$file_name));


// start&end date from DRP us format
$start_date = substr($date,0,10);
$end_date = substr($date,-10,10);

// cutting sto create Date in French Format
$monthdeb = substr($start_date,0,2);
$daydeb = substr($start_date,3,2);
$yeardeb = substr($start_date,6,4);

// real starting date
$starting_date = $daydeb."/".$monthdeb."/".$yeardeb;

// to create Date in French Format
$monthend = substr($end_date,0,2);
$dayend = substr($end_date,3,2);
$yearend = substr($end_date,6,4);

// real ending date
$ending_date = $dayend."/".$monthend."/".$yearend;


//get todays date and turn it into en date
$today_en = date("m/d/y");
$todD = substr($today_en,0,2);
$todM = substr($today_en,3,2);
$todY = substr($today_en,6,4);
$today_fr= $todM."/".$todD."/".$todY;                  //date at good format



$all_tags = array(); //empty list which will contain all selected tags id
$con = new Connex();
$connex = $con->connection;
$query = "SELECT id_tag FROM  tags  ";
$result = pg_query($connex, $query) or die(pg_last_error());
//for all tags check if tag selected
while ($row = pg_fetch_array($result)) {
	$var=$_GET[$row["id_tag"]."_tag"];
	if ($var == "on") { //if checkbox checked
		array_push($all_tags, $row["id_tag"]); //add tag id to array
	}
}

// getting format id
$query = "SELECT label_format, id_format FROM format";
$result = pg_query($connex, $query) or die(pg_last_error());

//finding if format already exists and adding id if so
while ($row = pg_fetch_array($result)) {
	if ($row[0]==$file_extension){
		$file_format=$row[1];
		break;
	}
}
// or creating format and id
if (isset($file_format)){
	$file_format=$file_format;
		}
else{
	// creating format into db
		$query = "insert into format (label_format) VALUES('".$file_extension."') ";
		$result = pg_query($connex, $query) or die(pg_last_error());
		//finding new id  for this format in DB
		$query = "SELECT label_format, id_format FROM format";
		$result = pg_query($connex, $query) or die(pg_last_error());
		while ($row = pg_fetch_array($result)) {
			if ($row[0]==$file_extension){
				$file_format=$row[1];
				break;
			}
		}
}

//Get the state
if(isset($_GET['validated'])){
	$id_validation_state=2;
}
else{
	$id_validation_state=1;
}


// importing in the DB



		$query = "INSERT INTO files(id_user_account,use_id_user_account,id_format,id_validation_state,id_version,upload_date, file_name, file_comment, data_init_date,data_end_date,latitude,longitude,file_place,file_size)
        VALUES ('".$origin."','".$origin."','".$file_format."','".$id_validation_state."',
        1,'".$today_fr."','".$file_name."','".$comment."','".$starting_date."','".$ending_date."','".$latitude."','".$longitude."','".$file_place."','".$file_size."')";
        $query_result = pg_query($connex,$query) or die (pg_last_error() );



		//getting file's id from DB to put tags into DB

$query = "SELECT id_file FROM  files where file_name='".$file_name."'";
$result = pg_query($connex, $query) or die(pg_last_error());
while ($row = pg_fetch_array($result)) {
$id_now=$row[0];
}

// add id_original_file
$query = "UPDATE files SET id_original_file =" .$id_now. " WHERE id_file=" . $id_now;
$query_result = pg_query($connex,$query) or die (pg_last_error() );


// inserting tags into DB
$nb_tags = count($all_tags);
for ($i=0;$i<$nb_tags;$i++){
	$query = "insert into link_tag_project (id_file,id_tag)
				VALUES ('".$id_now."','".$all_tags[$i]."')";
	$query_result = pg_query($connex,$query) or die (pg_last_error() );
}

// insert file and projet link (multiple projects)
if(isset($_GET['projet']) && !empty($_GET['projet'])){
    $Col1_Array = $_GET['projet'];
    foreach($Col1_Array as $selectValue){
		$query = "insert into link_file_project (id_file,id_project)
				VALUES ('".$id_now."','".$selectValue."')";
		$query_result = pg_query($connex,$query) or die (pg_last_error() );
    }
}
echo "<br/>";
?>

<div class="container">
	<h1 align="center">Your file has been imported successfully, thank you !</h1></br>
	<div align="center">
		<?php if($user_type==1){ ?>
		<form action="US0_page_accueil_admin.php" method="GET">
		<?php }
		if($user_type==2){ ?>
		<form action="US0_page_accueil_internes.php" method="GET">
		<?php }
		if($user_type==3){ ?>
		<form action="US0_page_accueil_externes.php" method="GET">
		<?php } ?>
			<button type="submit" class="btn btn-md btn-primary">Back to the home page</button>
		</form>
	</div>
</div>


<?php
//Reset of $_SESSION variables
$_SESSION["upload_filename"]=NULL;
$_SESSION["upload_location"]=NULL;
$_SESSION["upload_date"]=NULL;
$_SESSION["upload_file_size"]=NULL;
$_SESSION['longitude']=NULL;
$_SESSION['latitude']=NULL;

include("pied_de_page.php"); 
?>

</html>
