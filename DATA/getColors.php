<?php
include("../CONFIG/connect_to_mysql.php");

$sizeID = $_REQUEST['q'];
$pid = $_REQUEST['pid'];
$outPut = "";

$sql = "SELECT Colors.color_id, Colors.name FROM Colors,Stock
		WHERE Stock.color_id = Colors.color_id AND Stock.product_id = '$pid' AND Stock.size_id = '$sizeID'
		GROUP BY Stock.color_id";
$rs = $db->query($sql);

if($rs === false) {
trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
}

else {
if($rs->num_rows > 0) {
	
	$outPut .= '<select name="color" id="color" class="form-control" onChange="GetMatchingImage()" style="width: 100%;">';
	$outPut .= '<option value="-" disabled selected>Select one</option>';
	while($row = $rs->fetch_assoc()) {
		$outPut .= '<option value=' . $row['color_id'] . '>' .   ucwords($row['name']) . '</option>';
	}
	$outPut .= '</select>';
	
}
echo $outPut;
}
?>