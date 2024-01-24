<?php
$server="cray.cs.gettysburg.edu";
$dbase="f23_2";
$user="boyech01";
$pass="boyech01";

try{
$db=new PDO("mysql:host=$server;dbname=$dbase", $user, $pass);
//print("<H1> Successfully connected to databse</H1>\n");

}
catch(PDOException $e){
die("Error connecting to database: " . $e->getMessage());
}

?>