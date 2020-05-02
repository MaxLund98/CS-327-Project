<!DOCTYPE html>
<html>
<head>
    <title>City Library Home</title>
    <style>
    
        table, th, td, tr {
            border: solid black;
            border-collapse: collapse
        }
        
    </style>
</head>
<body>
    
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

        $userid = isset($_POST["userid"]) ? $_POST["userid"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";

        //Create the SQL query
        $sql = "select first_name, last_name, reader_pk, usertype from reader";
        $sql = $sql . " where reader_pk = '$userid'";
        $sql = $sql . " and password = '$password'";
	}
	
	//Run the query
	$result = $conn->query($sql);

    if ($result->num_rows > 0) 
	{
        $row = $result->fetch_assoc();
        echo "<h2>Welcome " . $row["first_name"] . " " . $row["last_name"];
        
        //Set Session Variables
        session_start();
        $_SESSION["uname"] = $row["reader_pk"];
        $_SESSION["fullname"] = $row["first_name"] . " " . $row["last_name"];
        if($row["usertype"]=="reader")
        {
		    header("Location: readermenu.php");
		// write menu with links here
        }
        else
        {
            echo "<br>Librarian Menu</br>";
                // write menu with links here
        }

    } 
    else
	{
        echo "<h2>Sorry! Wrong username / password!</h2>";
        echo "<br><a href='index.php'>Try again</a>";
    }
        
    $conn->close();
?>
<br>
<a href="logout.php">Sign Out</a>
</body>
</html>