<?php
include("../CONFIG/connect_to_mysql.php");

$pid = $_REQUEST['pid'];

$outPut = '<span style="color:crimson; font-size:1.5em;">Product NOT found</span>';

$sql = "SELECT title,brand,price,date_added,available FROM Product WHERE product_id = '$pid'";
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
					  		<td><strong>Product ID</strong></td>
							<td><strong>Title</strong></td>
							<td><strong>Brand</strong></td>
							<td><strong>Price</strong></td>
							<td><strong>Date Added</strong></td>
							<td><strong>Available</strong></td>
							<td></td>
					  	</th>
					  </tr>
							';
	while($row = $rs->fetch_assoc()) {
		$title = ucwords($row['title']);
		$brand = ucfirst($row['brand']);
		$price = $row['price'];
		$date = $row['date_added'];
		$avail = $row['available'];
		$outPut  .= '<tr>
										<td><img src="../IMAGES/PRODUCTS/'.$pid.'.jpg" width="75" height="75"></td>
										<td>'.$pid.'</td>
										<td>'.$title.'</td>
										<td>'.$brand.'</td>
										<td>&euro;'.$price.'</td>
										<td>'.$date.'</td>
										
										<td>';
									if($avail == 1) {$outPut  .= 'Yes';}
									else {$outPut  .= 'No';} 	
		$outPut  .= 		'</td>
										<td>
											<a href = "edit_product.php?pid='.$pid.'&title='.$title.'"<button type="submit" name="editProduct" class="btn btn-primary">Edit</button></a>																	
										</td>
									</tr>';
	}
	$outPut  .= '</table>';
	
}

echo $outPut;
}
?>