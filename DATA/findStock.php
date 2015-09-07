<?php
include("../CONFIG/connect_to_mysql.php");

$sid = $_REQUEST['sid'];

$outPut = '<span style="color:crimson; font-size:1.5em;">Stock item NOT found</span>';

$sql = $sql = "SELECT * FROM Stock WHERE stock_id = '$sid'";

$rs = $db->query($sql);

if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
}

else {
	
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$pid = $row['product_id'];
			$sizeID = $row['size_id'];
			$colorID = $row['color_id'];
			$qty = $row['quantity'];
		}
		$sql = "SELECT p.title, s.measurement, c.name FROM Product p, Sizes s, Colors c
			WHERE p.product_id = '$pid' AND s.size_id = '$sizeID' AND c.color_id = '$colorID'";
			
$rs = $db->query($sql);

if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
}


else {
if($rs->num_rows > 0) {

	$outPut  = '<table border="0" class="table-condensed table table-hover"';
	$outPut  .= '<tr>
					  	</th style="font-weight: bold;">
					  		<td></td>
					  		<td><strong>Stock ID</strong></td>
							<td><strong>Product ID</strong></td>
							<td><strong>Title</strong></td>
							<td><strong>Size</strong></td>
							<td><strong>Color</strong></td>
							<td><strong>Quantity</strong></td>
							<td></td>
					  	</th>
					  </tr>
							';
	while($row = $rs->fetch_assoc()) {
		$title = ucwords($row['title']);
		$size = strtoupper($row['measurement']);
		$color = ucfirst($row['name']);
		$outPut  .= '<tr>
										<td>';
											if(file_exists('../IMAGES/PRODUCTS/'.$pid.'-'.$colorID.'.jpg')){$outPut  .= '<img src="../IMAGES/PRODUCTS/'.$pid.'-'.$colorID.'.jpg" width="75" height="75">';}
											else{$outPut  .= '<img src="../IMAGES/PRODUCTS/default.jpg" width="75" height="75">';}
										$outPut  .= '</td>
										<td>'.$sid.'</td>
										<td>'.$pid.'</td>
										<td>'.$title.'</td>
										<td>'.$size.'</td>
										<td>'.$color.'</td>
										<td>'.$qty.'</td>
										<td>
											<form action="edit_stock.php" method="post">
												<input type="hidden" name="stockID" value="'.$sid.'">
												<input type="hidden" name="productID" value="'.$pid.'">
												<input type="hidden" name="size" value="'.$size.'">
												<input type="hidden" name="color" value="'.$color.'">
												<input type="hidden" name="qty" value="'.$qty.'">
												<button type="submit" name="editStockView" class="btn btn-primary">Edit</button>
											</form>															
										</td>
						</tr>';
	}
	$outPut  .= '</table>';
	
}


}
	}

}
echo $outPut;
?>