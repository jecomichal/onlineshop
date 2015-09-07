<?php
include("../CONFIG/connect_to_mysql.php");

$sizeID = $_REQUEST['size'];
$colorID = $_REQUEST['col'];
$pid = $_REQUEST['pid'];
$qty = $_REQUEST['qty'];

$outPut = "";

$sql = "SELECT quantity FROM Stock WHERE product_id = '$pid' AND size_id = '$sizeID' AND color_id = '$colorID' LIMIT 1";
$rs = $db->query($sql);

if($rs === false) {
trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
}

else {
if($rs->num_rows > 0) {
	
	while($row = $rs->fetch_assoc()) {
		$qtyInStock = $row['quantity'];
	}
	if($qty > $qtyInStock) {$outPut = '<p style="color:orange">We do not have that many items in stock</p>';}
	else if($qty == 0 ) {$outPut = '<p style="color:crimson">We are out of stock on this item</p>';}
}

echo $outPut;
}
?>