<?php

function mysql_connect(){
$servername = "localhost";
$username = "root"; //add a username to the database and stop using root in here
$password = "sql112S@112";
$dbname = "projects";

//Create connection
	$cn = new mysqli($servername, $username, $password, $dbname);

	if($cn->connect_error){
		die("Connection failed: " . $cn->connect_error);
	}

return $cn;
}

?>
