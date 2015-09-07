<?php
require("../CONFIG/connect_to_mysql.php");
$f = $_REQUEST['f'];

if($f == "all") {
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
}

elseif($f == "today") {
	list ( $y, $m, $d ) = explode('.', date('Y.m.d')); 
	$today_start = mktime(0, 0, 0, $m, $d, $y);
	$today_end   = mktime(23, 59, 59, $m, $d, $y);	
	$viewOrders = '<span style="color:crimson; font-size:1.5em;">No orders from today were found</span>';
	$sql = "SELECT Orders.*, Customer.customer_id, Customer.first_name, Customer.last_name
				FROM Orders, Customer
				WHERE Customer.customer_id = Orders.customer_id AND Orders.order_date >= DATE(NOW())
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
}

elseif($f == "week") {
	$viewOrders = '<span style="color:crimson; font-size:1.5em;">No orders from this week were found</span>';
	$sql = "SELECT Orders.*, Customer.customer_id, Customer.first_name, Customer.last_name
				FROM Orders, Customer
				WHERE Customer.customer_id = Orders.customer_id AND Orders.order_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)
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
}

elseif($f == "pending") {
	$viewOrders = '<span style="color:crimson; font-size:1.5em;">No orders were found</span>';
	$sql = "SELECT Orders.*, Customer.customer_id, Customer.first_name, Customer.last_name
				FROM Orders, Customer
				WHERE Customer.customer_id = Orders.customer_id AND Orders.status = 'pending'
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
}

elseif($f == "processing") {
	$viewOrders = '<span style="color:crimson; font-size:1.5em;">No orders were found</span>';
	$sql = "SELECT Orders.*, Customer.customer_id, Customer.first_name, Customer.last_name
				FROM Orders, Customer
				WHERE Customer.customer_id = Orders.customer_id AND Orders.status = 'processing'
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
}

else {
	$viewOrders = '<span style="color:crimson; font-size:1.5em;">No orders were found</span>';
	$sql = "SELECT Orders.*, Customer.customer_id, Customer.first_name, Customer.last_name
				FROM Orders, Customer
				WHERE Customer.customer_id = Orders.customer_id AND Orders.status = 'shipped'
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
}

?>