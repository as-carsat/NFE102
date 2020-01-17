<?php 
if(!isset($_SESSION)) 
{ 
	session_start();
}	
	try{
		//$db = new PDO('mysql:host=127.0.0.1;dbname=e-commerce; charset=utf8', 'root','');
		$db = new PDO('mysql:host=localhost;dbname=test_nfe102; charset=utf8', 'root','');
		$db -> setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(Exception $e){
		die('une erreur est survenue');
	}
	
?>