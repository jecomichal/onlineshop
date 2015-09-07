<?php
require("../CONFIG/connect_to_mysql.php");

$status = $_REQUEST['s'];
$oid = $_REQUEST['oid'];

$outPut = '<span style="color:crimson; font-size:1.5em;">Something went wrong !</span>';

$sql = "UPDATE Orders SET status = '$status' WHERE order_id = '$oid'";

if(!$db->query($sql)) {
	echo $outPut;
}

else {
	$outPut = '<span style="color:green; font-size:1.5em;">Order status changed to: '. strtoupper($status) .'</span>';
	echo $outPut;
}

?>