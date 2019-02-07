<!doctype html>
<html>
    <head>
		<!-- Développeurs : Manu et Gala
			Drag and drop which download file automatically when drop. 
			Issues : can't create a button "upload" (always automatic)
					 if 2 files are dropped with the same name, the first doc is replaced by the 2nd !!
		-->
		
        <link href="css/custom.css" rel="stylesheet" type="text/css">
		<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
        <script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
        <script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>
    </head>
    <body >

        <div class="container" >
            <input type="file" name="file" id="file">

            <!-- Drag and Drop container-->
            <div class="upload-area"  id="uploadfile">
                <h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
            </div>
        </div>

    </body>
</html>