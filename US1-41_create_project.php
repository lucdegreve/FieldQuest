<html>
<head>
<!-----------------------------------------------------------
       US1-41 Create a project 
Developped by Diane and Ophélie			      
This page contains the form to create a new project.


Input variables : 		

Output variables :										
		name of the form : new_project
		variables submitted in the form : project_name, project_desc, begin_date, 
			end_date, status
------------------------------------------------------------->	

<META charset="utf-8"> 
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">

<script language= "javascript" src="validate.js" type="text/javascript"></script>

</head>

<?php
// Include the file with all the functions (function to display the dropdown list is used here)

include('functions.php');

// Connexion with the database not etablished yet, we use a fake list of status for the time being.

$list_status=['Started','Finished','Given up'];

?>


<h1> New project </h1>
Fields marked with (*) are mandatory
</br></br>
<form name='new_project' method='POST' onsubmit='return validate_project()' action='US1-41_create_project.php' >

<table>
    <tr><td>(*)</td><td>Project name </td>  	<td><input type="text" name="project_name"></td></tr>
    <tr><td>(*)</td><td>Date of beginning</td>  <td><input type="date" name="begin_date"></td></tr>
    <tr><td>   </td><td>Date of end</td>        <td><input type="date" name="end_date"></td></tr>
    <tr><td>   </td><td>Project description</td><td><textarea name="project_desc" rows="3"></textarea></td></tr>    
	<tr><td>   </td><td>Status</td>             <td><?php dropdown_list($list_status,'status'); ?></td></tr>
</table>

<input type='submit' name='validate' value='Validate'>

</form>

<?php
if(isset($_POST['validate'])){
	
}



?>


</html>