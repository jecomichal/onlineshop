<?php
//Define Connection Parameters
//
$host = "fdb6.atspace.me";
$database = "1645599_vertigo";
$user = "1645599_vertigo";
$password = "michal95";

//Create mysqli connection object
$db = new mysqli($host, $user, $password, $database);

//Check connection
if($db->connect_errno) {
	die("Connection failed: " . $db->connect_error);
}

?>