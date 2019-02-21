function validate_project (){
    
    var msg = "Please complete the following fields : ";
    
    if (document.new_project.project_name.value ==""){
        msg = msg + "Project name.";
    }
    
    if (document.new_project.begin_date.value ==""){
        msg = msg + " Date of beginning.";
    }
	if (document.new_project.end_date.value !="" ){
		var date1 = new Date(document.new_project.end_date.value);
		var date2 = new Date(document.new_project.begin_date.value);
		if (date1<date2){
			msg = msg + " Date of end must be after date of beginning.";
		}
    }

    if (msg=="Please complete the following fields : "){
		return true;
    }
    else {
        alert(msg);
        return false;
    }

}