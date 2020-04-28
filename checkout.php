<!DOCTYPE html>
<html>

<head>
    <title>Welcome to the City Library System</title>
    <style>
        table,
        th,
        td,
        tr {
            border: solid black;
            border-collapse: collapse
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $docid = $_GET["document_pk"];
    $title = $_GET["title"];

    echo "Checking out " . $title . "...";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "aaaaaaaaaaaaaaaaaaaaaaaa";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "";
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //Create the SQL query
        $uname = $_SESSION["uname"];
        $sql = "update document set borrower=" . "'$uname'";
        $sql = $sql . " where document_pk = '$docid'";
        echo $sql;
    }

    //Run the query
    if ($conn->query($sql)) {
        header("Location: search.php?docid=" . $docid);
    } else {
        echo "Failed to checkout.";
    }

    ?>

</body>

</html>
