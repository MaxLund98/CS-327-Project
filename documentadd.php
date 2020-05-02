<!DOCTYPE html>
<html>
<head>
    <title>Add Document</title>
    <style>
    
        table, th, td, tr {
            border: solid black;
            border-collapse: collapse
        }
        
    </style>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Document ID:  <input type="text" name="docid" autocomplete="off"/>
	<br><br>
    Title:  <input type="text" name="title" autocomplete="off"/>
	<br><br>
    Publisher:  <input type="text" name="publisher" autocomplete="off"/>
	<br><br>
	<input type="submit" value="Create Document"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Clear"/>
</form>

<?php
	// Create connection
	echo "<a href='librarianmenu.php'>Return Home🏠</a>";

    include 'utility.php';
	$conn = getSQLConnection();
    $sql="";

    $docid = isset($_POST["docid"]) ? $_POST["docid"] : "";
    $title = isset($_POST["title"]) ? $_POST["title"] : "";
    $publisher = isset($_POST["publisher"]) ? $_POST["publisher"] : "";
        
	if($docid != ""){
        //Create the SQL query
        $sql = "select document_pk from document";
        $sql = $sql . " where document_pk = '$docid'";
        
	//Run the query
	$result = $conn->query($sql);
    
    if ($result->num_rows == 0) 
	{
        $sql2 = "insert into document(document_pk,title,publisher) values(";
        $sql2 = $sql2 . "'$docid','$title','$publisher')";
	    $result = $conn->query($sql2);

    } 
    else
	{
        echo "Sorry! That Document ID already exists!";
    }
    }
    $conn->close();
    
?>
</body>
</html>

