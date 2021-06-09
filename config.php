<?php  
ob_start(); //output buffering

try{
	$con = new PDO("mysql:dbname=moodle;host=localhost", "root", "");
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
	echo "Connection Failed: " . $e->getMessage();
}
	

?>