<?php
	function getFromPOST($str){
		return isset($_POST[$str]) ? $_POST[$str] : "";
	}
	function getFromGET($str){
		return isset($_GET[$str]) ? $_GET[$str] : "";
	}
	function validateFromSession($str){
		return isset($_SESSION[$str]) && $_SESSION[$str]!="";
	}
	function validateReader(){
		if(validateFromSession("uname")){
			echo
				$_SESSION["fullname"],"<br>",
				"<a href='readermenu.php'>Return HomeðŸ </a><br>";
				return $_SESSION["uname"];
		}else{
			echo
				"You are not supposed to be here!<br>",
				"<a href='index.php'>Login</a> to continue.";
			exit();
		}
	}
	function validateLibrarian(){
		if(!validateFromSession("uname")){
			echo
				"You are not supposed to be here!<br>",
				"<a href='index.php'>Login</a> to continue.";
			exit();
		}
		if($_SESSION["usertype"]!="librarian"){
			echo
				"You do not have permission to use this function!<br>",
				"<a href='index.php'>Return to main menu</a>";
			exit();
		}
		return $_SESSION["uname"];
	}
	
	
	function getSQLConnection(){
		$conn = new mysqli("localhost", "root", "", "aaaaaaaaaaaaaaaaaaaaaaaa");
		if ($conn->connect_error){
			exit("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}
	function waitForSubmission($name, $transfer_mode){
		$out = False;
		if($transfer_mode=="get"){
			if(!isset($_GET[$name])){
				exit();
			}else{
				$out = $_GET[$name];
				unset($_GET[$name]);
				return $out;
			}
		}else if($transfer_mode=="post"){
			if(!isset($_POST[$name])){
				exit();
			}else{
				$out = $_POST[$name];
				unset($_POST[$name]);
				return $out;
			}
		}else{
			exit();
		}
	}

	
	function getBorrower($docid, $docnum){
		$sql = 
			"select borrower "
		.	"from loan "
		. "where doc_id = $docid "
		.	"and doc_num = $docnum "
		. "and return_date IS NULL";
		$conn = getSQLConnection();
		$result = $conn->query($sql);
		if($result == false){
			return null;
		}else{
			return ($result->fetch_assoc())["borrower"];
		}
	}
	
	
	function getCreditTable($doc_table){
		switch($doc_table){
			case 'book': return 'author';
			case 'journal': return 'editor';
			case 'dvd': return 'director';
			default: exit("Unknown document type $doc_table!");
		}
	}
	
	function getOrAddAccredited($credit, $credit_table, $conn){
		$credit_arr = explode(" ", $credit, 2);
		$first_name = $credit_arr[0];
		$last_name = $credit_arr[1];
		$accredited_pk_name = "$credit_table" . "_pk";
		$result = $conn->query(
			"select $accredited_pk_name "
		.	"from $credit_table "
		.	"where first_name = '$first_name' "
		.	"and last_name = '$last_name'"
		);
		if($result == False || $result == NULL || $result->num_rows == 0){
			$sql = 
				"insert into $credit_table (first_name, last_name) "
			.	"values ('$first_name', '$last_name')";
			$conn->query($sql);
			$sql = 
				"select $accredited_pk_name "
			.	"from $credit_table "
			.	"where first_name = '$first_name' "
			.	"and last_name = '$last_name'"
			;
			$result = $conn->query($sql);
		}
		if($result == False || $result == NULL || $result->num_rows == 0){
			return $result;
		}
		return $result->fetch_assoc()["$accredited_pk_name"];
	}
	
	function getOrAddPublisher($name, $conn){
		$result = $conn->query(
			"select publisher_pk "
		.	"from publisher "
		.	"where name = '$name' ");
		if($result == False || $result == NULL || $result->num_rows == 0){
			$result = $conn->query(
				"insert into publisher (name) "
			.	"values ('$name')");
			$result = $conn->query(
				"select publisher_pk "
			.	"from publisher "
			.	"where name = '$name' ");
		}
		return $result->fetch_assoc()["publisher_pk"];
	}
	
	function addCredit($docid, $doc_table, $credit, $credit_table, $conn){
		$accredited_pk = getOrAddAccredited($credit, $credit_table, $conn);
		$doc_credit_table = "$doc_table" . "_$credit_table" . "_credit";
		$result = $conn->query(
			"insert into $doc_credit_table ($doc_table"."_fk, $credit_table"."_fk) "
		.	"values('$docid', '$accredited_pk')");
	}
	
	
?>