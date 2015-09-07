<?php
include("../CONFIG/connect_to_mysql.php");

$sizeID = $_REQUEST['size'];
$colorID = $_REQUEST['col'];
$pid = $_REQUEST['pid'];

$outPut = "";

$sql = "SELECT quantity FROM Stock WHERE product_id = '$pid' AND size_id = '$sizeID' AND color_id = '$colorID' LIMIT 1";
$rs = $db->query($sql);

if($rs === false) {
trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
}

else {
if($rs->num_rows > 0) {
	
	while($row = $rs->fetch_assoc()) {
		$qty = $row['quantity'];
	}
	if($qty == 0) {$outPut = '<p id="stockValue" style="background-color:crimson">Out of Stock</p>';}
	else if($qty <= 10 ) {$outPut = '<p id="stockValue" style="background-color:orange">Low Stock</p>';}
	else{$outPut = '<p id="stockValue" style="background-color:green">In Stock</p>';}
}

echo $outPut;
}
?>