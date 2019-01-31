function validate_project (){
    
    var msg = "Please complete the following fields : ";
    
    if (document.new_project.project_name.value ==""){
        msg = msg + "Project name.";
    }
    
    if (document.new_project.begin_date.value ==""){
        msg = msg + " Date of beginning.";
    }

    if (msg=="Please complete the following fields : "){
		return true;
    }
    else {
        alert(msg);
        return false;
    }

}