<?php
include("../CONFIG/connect_to_mysql.php");

$pid = $_REQUEST['pid'];
$outPut = "";

$sql = "SELECT Sizes.measurement, Sizes.size_id, Sizes.category_id, Product.category_id, Product.product_id
			FROM Product, Sizes
			WHERE Product.product_id = '$pid' AND Product.category_id = Sizes.category_id";
$rs = $db->query($sql);

if($rs === false) {
trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
}

else {
if($rs->num_rows > 0) {
	
	$outPut .= '<select name="size" id="size" class="form-control">';
	while($row = $rs->fetch_assoc()) {
		$outPut .= '<option value=' . $row['size_id'] . '>' .   ucwords($row['measurement']) . '</option>';
	}
	$outPut .= '</select>';
	
}
echo $outPut;
}
?>