<!DOCTYPE html>
<html>
<head>
    <title>Create New Reader/Librarian</title>
    <style>
    
        table, th, td, tr {
            border: solid black;
            border-collapse: collapse
        }
        
    </style>
</head>
<body>
 
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    First Name:  <input type="text" name="firstname" autocomplete="off"/>
	<br><br>
    Last Name:  <input type="text" name="lastname" autocomplete="off"/>
	<br><br>
    User ID:  <input type="text" name="userid" autocomplete="off"/>
	<br><br>
    Password: <input type="password" name="password1" autocomplete="off"/>
    <br><br>
    Retype Password: <input type="password" name="password2" autocomplete="off"/>
    <br><br>
    <input type="checkbox" id="islibrarian" name="islibrarian" value="Librarian">
    <label for="islibrarian">Add as Librarian </label><br>
    <br><br>
    <input type="submit" value="Create User"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Clear"/>
    <br><br>
    Already have an account? Sign in <a href="index.php">here</a>.
</form>

<?php
    echo "<a href='librarianmenu.php'>Return Home🏠</a>";

    include 'utility.php';
	$conn = getSQLConnection();
        //echo "Connected successfully<br>";

    $fname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
    $lname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
    $userid = isset($_POST["userid"]) ? $_POST["userid"] : "";
    $password = isset($_POST["password1"]) ? $_POST["password1"] : "";
    $librarian = FALSE;
    if (isset($_POST['islibrarian'])) {
        $librarian = TRUE;
    }
	
	if($userid!=""){
        //Create the SQL query
        $sql = "select reader_pk from reader";
        $sql = $sql . " where reader_pk = '$userid'";
        if ($librarian) {
            $sql = "select librarian_pk from librarian";
            $sql = $sql . " where librarian_pk = '$userid'";
        }
        
	//Run the query
	$result = $conn->query($sql);
    
    if ($result->num_rows == 0) 
	{
        if ($librarian) {
            $sql2 = "insert into librarian(first_name,last_name,librarian_pk,password) values(";
            $sql2 = $sql2 . "'$fname','$lname','$userid','$password')";
            $result = $conn->query($sql2);
        }
        else {
            $sql2 = "insert into reader(first_name,last_name,reader_pk,password) values(";
            $sql2 = $sql2 . "'$fname','$lname','$userid','$password')";
            $result = $conn->query($sql2);
        }
    } 
    else
	{
        echo "Sorry! That userid already exists!";
    }
    }
    $conn->close();
    
?>
</body>
</html>

