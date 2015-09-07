<?php
include("../CONFIG/connect_to_mysql.php");

$pid = $_REQUEST['pid'];
$output = "";

$sql = "SELECT * FROM Product WHERE featured = 1";

$rs = $db->query($sql);

if($rs->num_rows == 5) {
	echo '<span style="color:orange; font-size:1.5em;">Only 5 products can be featured at once<span>';
}

else {

	$sql = "SELECT available, featured FROM Product WHERE product_id = '$pid'";
	
	$rs = $db->query($sql);
	
	if($rs === false) {
		echo '<span style="color:crimson; font-size:1.5em;">ERROR HAS OCCURED</span>';
	}
	
	else {
		if($rs->num_rows > 0) {
			while($row = $rs->fetch_assoc()) {
				$isFeatured = $row['featured'];
				$isAvail = $row['available'];
			}
			
			if($isFeatured == 1) {
				echo '<span style="color:orange; font-size:1.5em;">This product is already featured</span>';
			}
			
			elseif($isAvail == 0) {
				echo '<span style="color:orange; font-size:1.5em;">You must first make this product available before you can add it to featured list</span>';
			}
			
			else {
				$sql = "UPDATE Product SET featured = 1 WHERE product_id = '$pid'";
				if(!$db->query($sql)) {
					echo '<span style="color:crimson; font-size:1.5em;">ERROR HAS OCCURED</span>';
				}
				
				else {
					echo '<span style="color:green; font-size:1.5em;">Product added to featured list</span>
							<meta http-equiv="refresh" content="1;url=products.php?q=feat">';	
					
				}
			}	
		}
	}
}
?>