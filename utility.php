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
	function validateUser(){
		if(validateFromSession("uname")){
			echo
				$_SESSION["fullname"],"<br>",
				"<a href='readermenu.php'>Return HomeðŸ </a>";
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
		$conn = new mysqli("localhost", "root", "", "library");
		if ($conn->connect_error){
			exit("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}
	function waitForSubmission($name, $transfer_mode){
		$out = False;
		if($transfer_mode="get"){
			if(!isset($_GET[$name])){
				exit();
			}else{
				$out = $_GET[$name];
				unset($_GET[$name]);
				return $out;
			}
		}else if($method="post"){
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
	
	
	function getAccreditedTable($doctype){
		switch($doctype){
			case 'book': return 'author';
			case 'journal': return 'editor';
			case 'dvd': return 'director';
			default: exit("Unknown document type $doctype!");
		}
	}
	
	
?>