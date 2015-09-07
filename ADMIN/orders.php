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
ob_end_flush();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>	</title>
		<link rel="stylesheet" type="text/css" href="../CSS/main.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700" rel="stylesheet" type="text/css">
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
				
				<?php
							echo '
									<form class="form-horizontal" id="filter_form" name="filter_form" role="form" style="margin-top: 2.592016589%; margin-left: 29.030585796%; margin-bottom: 10%;">
										<div class="col-xs-7">
											<select class="form-control" name="filter" id="filter" onchange="RenderOrders()">
												<option value="all" selected>All Orders</option>
												<option value="today">Today</option>
												<option value="week">This Week</option>
												<option value="pending">Pending</option>
												<option value="processing">Processing</option>
												<option value="shipped">Shipped</option>
											</select>
										</div>
									</form>							
							';
							
							echo '
									<div id="viewOrders">';
								$viewOrders = '<span style="color:crimson; font-size:1.5em;">No orders were found</span>';
								$sql = "SELECT Orders.*, Customer.customer_id, Customer.first_name, Customer.last_name
											FROM Orders, Customer
											WHERE Customer.customer_id = Orders.customer_id
											ORDER BY Orders.order_date DESC";
								$rs = $db->query($sql);
								
								if($rs->num_rows > 0) {
									
									$viewOrders = '<table border="0" class="table-condensed table table-hover"';
									$viewOrders .= '<tr>
													  	</th style="font-weight: bold;">
													  		<td><strong>Order ID</strong></td>
															<td><strong>Customer ID</strong></td>
															<td><strong>Customer Name</strong></td>
															<td><strong>Order Date</strong></td>
															<td><strong>Order Total</strong></td>
															<td><strong>Status</strong></td>
															<td></td>
													  	</th>
													  </tr>
															';
									while($row = $rs->fetch_assoc()) {
										$orderID = $row['order_id'];
										$custID = $row['customer_id'];
										$amount = $row['amount'];
										$date = $row['order_date'];
										$status = strtoupper($row['status']);
										$fname = ucfirst($row['first_name']);
										$sname = ucfirst($row['last_name']);
										$viewOrders .= '<tr>
																		<td>'.$orderID.'</td>
																		<td>'.$custID.'</td>
																		<td>'.$fname.' '.$sname.'</td>																
																		<td>'.$date.'</td>
																		<td>&euro;'.$amount.'</td>
																		<td>';
																	if($status == "PENDING") {$viewOrders .= '<p style="color:gray">'.$status.'</p>';}
																	if($status == "PROCESSING") {$viewOrders .= '<p style="color:orange">'.$status.'</p>';} 	
																	if($status == "SHIPPED") {$viewOrders .= '<p style="color:green">'.$status.'</p>';} 	
																	$viewOrders .= 		'</td>
																		<td>
																			<form action="process_order.php" method="post">
																				<input type="hidden" name="oid" value="'.$orderID.'">
																				<input type="hidden" name="cid" value="'.$custID.'">
																				<input type="hidden" name="fname" value="'.$fname.'">
																				<input type="hidden" name="sname" value="'.$sname.'">
																				<input type="hidden" name="date" value="'.$date.'">
																				<input type="hidden" name="amount" value="'.$amount.'">
																				<input type="hidden" name="status" value="'.$status.'">
																				<button type="submit" name="orderProcess" id="orderProcess" class="btn btn-primary">Process</button>																			
																			</form>														
																		</td>
																	</tr>';
									}
									$viewOrders .= '</table>';
								}								

								echo $viewOrders;
								
								
								echo '</div>';
							
				?>
				
				</div>	
								
				</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
		</div>
		
		
	</body>
	
</html>