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
     session_start();
     if(isset($_SESSION["uname"]) && $_SESSION["uname"]!="")
        {
        echo $_SESSION["fullname"];
        echo "<br>";
        echo "<h2>Welcome " . $_SESSION["uname"];
        echo "<br><a href='search.php'>Search for Documents</a>";
        } 
    else
	{
        echo "<h2>Sorry! Wrong username / password!</h2>";
        echo "<br><a href='index.php'>Try again</a>";
    }
?>
<br>
<a href="logout.php">Sign Out</a>
</body>
</html>