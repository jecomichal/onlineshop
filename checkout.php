<?php
ob_start();
?>

<?php
session_start();
require("CONFIG/connect_to_mysql.php");

$cartTotal = isset($_SESSION['user_cart_total']) ? $_SESSION['user_cart_total'] : null;
?>

<?php
	if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin'] == 0) {
		echo '<meta http-equiv="refresh" content="0;url=login.php">';
		exit();
	}
?>

<?php
   $noCard = false;
	$id = $_SESSION['user_id'];
	$sql = "SELECT card_type, card_number, card_owner, card_expiry, card_cvn FROM Customer WHERE customer_id = '$id'";
	
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		while($row = $rs->fetch_assoc()) {
			if(empty($row['card_type']) || empty($row['card_number']) || empty($row['card_owner']) || empty($row['card_expiry']) || empty($row['card_cvn'])) 
			{$noCard = true;	}
			$cardType = $row['card_type'];
			$cardNumber = '************';
			$cardNumber .= substr($row['card_number'],12,4); 
			$cardOwner = $row['card_owner']; 
			$cardExpiry = $row['card_expiry']; 
			$cardCvn = $row['card_cvn']; 
		}
	}
?>

<?php
ob_start();
if(isset($_POST['pay'])) {
	
	//Check user balance
	$balance = $_SESSION['user_balance'];
	if($cartTotal > $balance) {
		echo '<meta http-equiv="refresh" content="0;url=checkout.php?lowfunds=1">';
		exit();
	}
	if($noCard == true)
	{
		echo '<meta http-equiv="refresh" ob_start();content="0;url=checkout.php?nocard=1">';
		exit();
	}
	else{
		
		//Insert into Order Table
		$sql = "INSERT INTO Orders (customer_id, amount, order_date) VALUES(?,?,now())";
		$stmt = $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);
		$stmt->bind_param('id',$id,$cartTotal);
		$stmt->execute();
		$orderID = $stmt->insert_id;
		$stmt->close();
		
		//Insert into OrderItem Table
		foreach($_SESSION['cart'] as $orderItem)
		{
				$stockID = $orderItem['item_id'];
				$qty = $orderItem['item_qty'];
				
				$sql = "INSERT INTO OrderItem (order_id, stock_id, quantity) VALUES(?,?,?)";
				$stmt = $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);;
				$stmt->bind_param('iii',$orderID,$stockID,$qty);
				$stmt->execute();
				$stmt->close();
				
				//Reduce stock quantity
				$sql = "SELECT quantity FROM Stock WHERE stock_id = '$stockID'"; //Get current Quantity
				$rs = $db->query($sql);
				if($rs->num_rows > 0) {
					while($row = $rs->fetch_assoc()) {
						$currentQty = $row['quantity'];
					}
				}
				
				$newQty = $currentQty - $qty;
				
				//Update quantity
				$sql = "UPDATE Stock SET quantity = '$newQty' WHERE stock_id = '$stockID'";
				if(!$db->query($sql)) {
					trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
				}			
				
		}
		
		//Update user balance
		$newBalance = $balance - $cartTotal;
		$sql = "UPDATE Customer SET balance = ? WHERE customer_id = ?";
		$stmt = $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);;
		$stmt->bind_param('di',$newBalance,$id);
		$stmt->execute();
		$stmt->close();
		
		$_SESSION['user_balance'] = $newBalance;
		
		
		//Empty Cart
		unset($_SESSION['cart']);
		$_SESSION['user_cart_total'] = 0;
		$user_cart = "";
		$user_cart .= $_SESSION['user_id'];
		$user_cart .= '-cart';
		setcookie($user_cart, "blank", time()-10000);	
			
		echo '<meta http-equiv="refresh" content="0;url=checkout.php?success=1">';
		exit();
	}
	$db->close();
}

?>

<?php
ob_end_flush();
?>

<!DOCTYPE HTML>
<html>

	<head>
		<title>Checkout</title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<div align="center" id="mainWrapper">
		
		<?php include("TEMPLATES/header.php"); ?>
				
			<div id="contentWrapper" style="min-height:650px;height:auto; overflow: hidden">
				<div class="bannerTitle" style="height:50px">
					<p>Checkout</p>
				</div>
								
				<?php if(isset($_GET['success']) && $_GET['success'] == 1) {
							echo '
										<br/><br/><br/>
										<p style="color: green; font-size: 2em;">Payment Successfull. Thank you for your purchase</p>';
							echo '<meta http-equiv="refresh" content="3;url=index.php">';
					}
				?>
				
				<?php if(!isset($_GET['success'])) {	?>
				
				<div class="info_box" style="margin-left:7%;">
					<table class="table-condensed table table-hover">
										<thead>
											<tr>
												<th colspan="2"><h4>Delivery Address<h4></th>									
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>Street</th>
												<td><?php echo ucwords($_SESSION['user_address_street']); ?></td>
											</tr>
											<tr>
												<th>City</th>
												<td><?php echo ucwords($_SESSION['user_address_city']); ?></td>
											</tr>
											<tr>
												<th>State</th>
												<td><?php echo ucwords($_SESSION['user_address_state']); ?></td>
											</tr>
											<tr>
												<th>ZIP</th>
												<td><?php echo ucwords($_SESSION['user_address_zip']); ?></td>
											</tr>
											<tr>
												<th>Country</th>
												<td><?php echo ucwords($_SESSION['user_address_country']); ?></td>
											</tr>
										</tbody>
									</table>
				</div>
				
				<div class="info_box">
					<table class="table-condensed table table-hover">
										<thead>
											<tr>
												<th colspan="2"><h4>Credit Card Information<h4></th>									
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>Card Type</th>
												<td><?php echo $cardType; ?></td>
											</tr>
											<tr>
												<th>Card Number</th>
												<td><?php echo $cardNumber; ?></td>
											</tr>
											<tr>
												<th>Owner</th>
												<td><?php echo $cardOwner; ?></td>
											</tr>
											<tr>
												<th>Expiry</th>
												<td><?php echo $cardExpiry; ?></td>
											</tr>
											<tr>
												<th>CVN</th>
												<td><?php echo $cardCvn; ?></td>
											</tr>
										</tbody>
									</table>
				</div>
				
					<div class="info_box">
						<table class="table-condensed table table-hover">
						<thead>
							<tr>
								<th colspan="2"><h4>Checkout<h4></th>									
							</tr>
						</thead>
						<tbody>
							<tr>
								<th style="font-size: 1.5em;">Total:</th>
								<td style="font-size: 1.5em;">&euro;<?php echo  $cartTotal == null ? 0 : number_format((float)$cartTotal, 2, '.', ''); ?></td>
						</tbody>
						</table>
						<form name="payNow" method="post" action="" style="margin-top: 35%;">
							<?php if(isset($_GET['lowfunds']) && $_GET['lowfunds'] == 1){
								echo '<span id="lowFunds" class="help-block" style="color:crimson;">Insufficent balance please top up</span>';
							}?>
							<?php if(isset($_GET['nocard']) && $_GET['nocard'] == 1){
								echo '<span id="noCard" class="help-block" style="color:crimson;">You must set up your payment information (<a href="account.php?q=payment">here</a>)</span>';
							}?>
							
							<?php echo $cartTotal == null ? '<input type="submit" name="pay" value="Pay Now" class="btn btn-success disabled" style="width:75%; margin-left: 12%;">'
									: '<input type="submit" name="pay" value="Pay Now" class="btn btn-success" style="width:75%; margin-left: 12%;">' ?>
						</form>
					</div>
				<?php } ?>
				
			</div><!--END contentWrapper-->
			
		</div><!--END mainWrapper-->
		
		<?php include("TEMPLATES/footer.php"); ?>
		
	</body>
	
</html>