<?php
ob_start();
session_start();
?>

<?php
if(!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] == 0) {
		echo '<meta http-equiv="refresh" content="0;url=../login.php">';
		exit();
	}
?>

<?php
require("../CONFIG/connect_to_mysql.php");
?>

<?php
if(isset($_POST['orderProcess'])) {
	
	$oid = $_POST['oid'];

	//Get all Items From that order
	/*$sql = "SELECT OrderItem.order_id, OrderItem.stock_id, OrderItem.quantity, Stock.product_id, Stock.size_id, Stock.color_id, Product.product_id, Product.title, Product.price,
			 Colors.color_id, Colors.name as color, Sizes.size_id, Sizes.measurement
			FROM OrderItem
			INNER JOIN Orders on OrderItem.order_id = '$oid'
			INNER JOIN Stock on OrderItem.stock_id = Stock.stock_id
			INNER JOIN Product on Stock.product_id = Product.product_id
			INNER JOIN Colors on Stock.color_id = Colors.color_id
			INNER JOIN Sizes on Stock.size_id = Sizes.size_id
			GROUP BY Stock.stock_id";*/

	$sql = "CALL getOrderItems($oid)";

	$rs = $db->query($sql);
	
	if($rs->num_rows > 0) {
		$outPut = '<table border="0" class="table-condensed table table-hover" style="margin-top:5%"';
		$outPut .= '<tr>
						  	</th style="font-weight: bold;">
						  		<td></td>
						  		<td><strong>Title</strong></td>
								<td><strong>Size</strong></td>
								<td><strong>Color</strong></td>
								<td><strong>Quantity</strong></td>
								<td><strong>Unit Price</strong></td>
								<td><strong>Total Price</strong></td>
						  	</th>
						  </tr>';
						  
		while($row = $rs->fetch_assoc()) {
			$pid = $row['product_id'];
			$title = $row['title'];
			$size = $row['measurement'];
			$color = $row['color'];
			$colorID = $row['color_id'];
			$qty = $row['quantity'];
			$unit = $row['price'];
			$total = $qty*$unit;
			
			$outPut .= '<tr>
							  <td><img src="../IMAGES/PRODUCTS/'.$pid.'-'.$colorID.'.jpg" width="75" height="75"></td>
							  <td>'. ucwords($title) .'</td>
								<td>'.$size.'</td>
								<td>'. ucfirst($color).'</td>
								<td>'.$qty.'</td>
								<td>&euro;'.$unit.'</td>
								<td>&euro;'. number_format((float)$qty*$unit, 2, '.', '').'</td>
							  </tr>';
		}
		
		$outPut .= '</table>';
	}		
}
?>


<?php
ob_end_flush();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>	</title>
		<link rel="stylesheet" type="text/css" href="../CSS/main.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="../JS/myScripts.js"></script>
	</head>
	
	<body>
		
		<div align="center" id="mainWrapper">
		
			
			
			<div id="contentWrapper" style="min-height:600px; height:auto; overflow: hidden; margin-top: 100px; padding:0px;">
			
				
				
				<div id="admin_nav" style="width: 100%;">
					<a class="tab_admin"  href="../logout.php">Sign Out</a>
					<a class="tab_admin"  href="index.php">Home</a>
				</div>
				<div id="admin_view_window" style="width:100%;">
				
					
							<table border="0" class="table">
								<thead>
									<th>Order ID</th>
									<th>Customer ID</th>
									<th>Customer Name</th>
									<th>Order Date</th>
									<th>Order Total</th>
									<th>Status</th>																		
								</thead>
								<tbody>
										<tr>
											<td id="tableOrderID"><?php echo $_POST['oid'] ?></td>
											<td><?php echo $_POST['cid']; ?></td>
											<td><?php echo $_POST['fname'] .' '. $_POST['sname']; ?></td>
											<td><?php echo $_POST['date']; ?></td>
											<td>&euro;<?php echo $_POST['amount']; ?></td>
											<td>
											<?php
												echo '<form>
													<div class="col-xs-7">
													<select name="status" id="status" class="form-control" onchange="UpdateStatus()">';
														if($_POST['status'] == "PENDING") {
															echo '<option value="pending" selected>PENDING</option>
														<option value="processing">PROCESSING</option>
														<option value="shipped">SHIPPED</option>';
														}
														
														elseif($_POST['status'] == "PROCESSING") {
															echo '<option value="pending">PENDING</option>
														<option value="processing" selected>PROCESSING</option>
														<option value="shipped">SHIPPED</option>';
														}
														
														else {
															echo '<option value="pending">PENDING</option>
														<option value="processing">PROCESSING</option>
														<option value="shipped" selected>SHIPPED</option>';
														}
														
													echo '</select>												
												</form>';
											?>
											
											</td>			
										</tr>	
										<tr>
											<td colspan="6"></td>
										</tr>						
								</tbody>
							</table>
					
					<br>
					
					<div id="statusUpdated">
					
					</div>
					
						<?php echo $outPut; ?>
						
					<br><br><br>
					
					<a href="orders.php"><button type="button" class="btn btn-default">Go Back</button>
				
				</div>	
								
				</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
		</div>
		
		
	</body>
	
</html>