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
	function getSQLConnection(){
		$conn = new mysqli("localhost", "root", "", "aaaaaaaaaaaaaaaaaaaaaaaa");
		if ($conn->connect_error){
			exit("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}
?>