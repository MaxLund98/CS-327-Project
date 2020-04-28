<!DOCTYPE html>

<html>
<head>
    <title>Search for Documents</title>
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
        echo "<a href='readermenu.php'>Return Home</a>";
?>
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Document ID:  <input type="text" name="docid" autocomplete="off"/>
	<br><br>
    Title: <input type="text" name="title" autocomplete="off"/>
    <br><br>
    Publisher: <input type="text" name="publisher" autocomplete="off"/>
    <br><br>
    <input type="submit" value="Search"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Clear"/>
    <br><br>
</form>
 
<?php   
        } else {
            echo "You are not supposed to be here!<br>";
            echo "<a href='index.php'>Login</a> to continue.";
        }
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
            echo "Connection error";
            die("Connection failed: " . $conn->connect_error);
        }
        else
        {
            //echo "Connected successfully<br>";
    
            $docid = isset($_GET["docid"]) ? $_GET["docid"] : "";
            $title = isset($_GET["title"]) ? $_GET["title"]: "";
            $publisher = isset($_GET["publisher"]) ? $_GET["publisher"]: "";
            //Create the SQL query
            $sql = "select document_pk, publisher, borrower, title from document";
            $sql = $sql . " where document_pk = '$docid'";
            $sql = $sql . " or title = '$title'";
            $sql = $sql . " or publisher = '$publisher'";
        }
        //Run the query
        
        $result = $conn->query($sql);

        if ($result != NULL) {
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<b>" . $row["title"] . "</b><br>";
                echo "Document ID: " . $row["document_pk"] . "<br>";
                echo "Publisher: " . $row["publisher"] . "<br>";
                if ($row["borrower"] == NULL) {
                    echo "This document is available.<br><br>";
                } else {
                    echo "This document is not available.<br><br>";
                }
            }
                
            
        }
        else
            {
                echo "<br>No results</br>";
            }
        }
        else
            {
                echo "<br>No results</br>";
            }
        
        
 ?>           
</body>
</html>