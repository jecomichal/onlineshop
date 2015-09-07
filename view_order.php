<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 1 - Includes, Session start
//////////////////////////////////////////////////////////////////////////////////////
session_start();
require("CONFIG/connect_to_mysql.php");

?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 2 - Check if user is logged in
//////////////////////////////////////////////////////////////////////////////////////
	if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin'] == 0) {
		echo '<meta http-equiv="refresh" content="0;url=login.php">';
		exit();
	}
?>


<?php
if(isset($_POST['viewOrder'])) {
	$oid = $_POST['oid'];
	$orderDate = $_POST['date'];
	$amount = $_POST['amount'];
	$outPut = "";	
	
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
		$outPut = '<table border="0" class="table-condensed table table-hover" style="margin-top:100px"';
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
							  <td><img src="IMAGES/PRODUCTS/'.$pid.'-'.$colorID.'.jpg" width="75" height="75"></td>
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

<!DOCTYPE HTML>
<html>

	<head>
		<title>	</title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="JS/myScripts.js"></script>
	</head>
	
	<body>
		
		<div align="center" id="mainWrapper">
		
			<?php 
				include("TEMPLATES/header.php");
			?>
			
			<div id="contentWrapper" style="min-height:500px; height:auto; overflow:hidden; padding:0px; margin-top: 2px;">
			
				<div id="sidebarWrapper">
					
					<div id="account_sidebar">
						<ul>
							<li><a href="account.php?q=editdetails">Edit Personal Details</a></li>
							<li><a href="account.php?q=changepass">Change Password</a></li>
							<li><a href="account.php?q=address">Manage Address</a></li>
							<li><a href="account.php?q=history">View Order History</a></li>
							<li><a href="account.php?q=payment">Edit Payment Details</a></li>
							<li><a href="account.php?q=topups">Top Up Transactions</a></li>
						</ul>
					</div>
					
				</div>
			
				<div id="account_detail_view_window">
					<div id="orderDetails">
							<table border="0" class="table">
								<thead>
									<th>Order ID</th>
									<th>Date</th>
									<th>Total</th>								
								</thead>
								<tbody>
										<tr>
											<td><?php echo $oid; ?></td>
											<td><?php echo $orderDate; ?></td>
											<td>&euro;<?php echo $amount; ?></td>								
										</tr>	
										<tr>
											<td colspan="3"></td>
										</tr>						
								</tbody>
							</table>
					</div>
					<br><br><br>
					
						<?php echo $outPut; ?>
						
					<br><br><br>
					
					<a href="account.php?q=history"><button type="button" class="btn btn-default">Go Back</button>
						
				</div>	
								
				</div><!--END contentWrapper-->
							
				
				
			</div><!--END mainWrapper-->
			<?php include("TEMPLATES/footer.php"); ?>
	</body>
	
</html>

