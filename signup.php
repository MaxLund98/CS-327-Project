<!DOCTYPE html>
<html>
<head>
    <title>Create New User</title>
    <style>
    
        table, th, td, tr {
            border: solid black;
            border-collapse: collapse
        }
        
    </style>
</head>
<body>
 
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    First Name:  <input type="text" name="firstname"/>
	<br><br>
    Last Name:  <input type="text" name="lastname"/>
	<br><br>
    User ID:  <input type="text" name="userid"/>
	<br><br>
    Password: <input type="password" name="password1"/>
    <br><br>
    Retype Password: <input type="password" name="password2"/>
    <br><br>
    <input type="submit" value="Create User"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Clear"/>
    <br><br>
    Already have an account? Sign in <a href="index.php">here</a>.
</form>

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "aaaaaaaaaaaaaaaaaaaaaaaa";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql="";
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }
    else
    {
        //echo "Connected successfully<br>";

        $fname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
        $lname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
        $userid = isset($_POST["userid"]) ? $_POST["userid"] : "";
        $password = isset($_POST["password1"]) ? $_POST["password1"] : "";
        
	}
	if($userid!=""){
        //Create the SQL query
        $sql = "select reader_pk from reader";
        $sql = $sql . " where reader_pk = '$userid'";
        
	//Run the query
	$result = $conn->query($sql);
    
    if ($result->num_rows == 0) 
	{
        $sql2 = "insert into reader(first_name,last_name,reader_pk,password) values(";
        $sql2 = $sql2 . "'$fname','$lname','$userid','$password')";
	    $result = $conn->query($sql2);
        echo $sql2;
        /*if ($result->num_rows > 0) 
            echo "Created User";
        else
            echo "Something went wrong!";*/
            
        echo "<br><a href='index.php'>Login</a>";

    } 
    else
	{
        echo "Sorry! That userid already exists!";
        echo "<br><a href='signup.php'>Try again</a>";
    }
    }
    $conn->close();
    
?>
</body>
</html>

