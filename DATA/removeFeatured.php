<?php
include("../CONFIG/connect_to_mysql.php");

$pid = $_REQUEST['pid'];

$sql = "UPDATE Product SET featured = 0 WHERE product_id = '$pid'";

if(!$db->query($sql)) {
	echo "ERROR HAS OCCURED!";
}

else {
	$featuredProductOutput = '<p style="font-size: 1.5em;">There are no featured products</p>';
	$sql = "SELECT product_id,title,brand,price,date_added,available FROM Product WHERE featured = 1 ORDER BY date_added DESC";
	$rs = $db->query($sql);
	
	if($rs->num_rows > 0) {
		
		$featuredProductOutput = '<table border="0" class="table-condensed table table-hover"';
		$featuredProductOutput .= '<tr>
						  	</th style="font-weight: bold;">
						  		<td></td>
						  		<td><strong>Product ID</strong></td>
								<td><strong>Title</strong></td>
								<td><strong>Brand</strong></td>
								<td><strong>Price</strong></td>
								<td><strong>Date Added</strong></td>
								<td></td>
						  	</th>
						  </tr>
								';
		while($row = $rs->fetch_assoc()) {
			$productID = $row['product_id'];
			$title = ucwords($row['title']);
			$brand = ucfirst($row['brand']);
			$price = $row['price'];
			$date = $row['date_added'];
			$avail = $row['available'];
			$featuredProductOutput .= '<tr>
											<td><img src="../IMAGES/PRODUCTS/'.$productID.'.jpg" width="75" height="75"></td>
											<td>'.$productID.'</td>
											<td>'.$title.'</td>
											<td>'.$brand.'</td>
											<td>&euro;'.$price.'</td>
											<td>'.$date.'</td>
											<td>
												<form class="form-horizontal" id="remove_featured_form" name="remove_featured_form" role="form">
													<input type="hidden" id="featuredProductID'.$productID.'" value="'.$productID.'">
													<button type="button" name="removeFeatured" id="removeFeatured'.$productID.'" class="btn btn-danger" onclick="RemoveFeatured(event)">X</button>
												</form>																
											</td>
										</tr>';
		}
		$featuredProductOutput .= '</table>';
		
		
	}
	echo $featuredProductOutput;

}
?>