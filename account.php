<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 1 - Includes, Session start
//////////////////////////////////////////////////////////////////////////////////////
session_start();
require("CONFIG/connect_to_mysql.php");

$success = false;
$wrongCurrent = false;
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
	
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 3 - Edit user details
//////////////////////////////////////////////////////////////////////////////////////
	if(isset($_POST['editdetails'])) {
		$email = trim($_POST['email']);
	  	$first_name = trim($_POST['first_name']);
	  	$last_name =trim($_POST['last_name']);
	  	$dob_day = $_POST['dob_day'];
	  	$dob_month = $_POST['dob_month'];
	  	$dob_year = $_POST['dob_year'];
	  	$dob = $dob_year . '-' . $dob_month . '-' . $dob_day;
	  	$phone = trim($_POST['phone']);
	  	
	  	//Check for empty fields
	  	if(empty($email)) {
			die("Email address is required!");
		}
		
		if(empty($first_name)) {
			die("First Name is required!");
		}
		
		if(empty($last_name)) {
			die("Last Name is required!");
		}
		
		if(empty($phone)) {
			die("Phone number is required!");
		}
			
	  	if($dob_day == '-' || $dob_month == '-' || $dob_year == '-') {
				$dob = NULL;
		}
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				die("Invalid email address format!");
		}
			
		$sql = "SELECT * FROM Customer WHERE email = '$email' LIMIT 1";
		$rs = $db->query($sql);
			
		if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
		}
		
		if($rs->num_rows > 0 && strtolower($email) !== strtolower($_SESSION['user_email'])){
			die("Email address: $email is already in the system!");
		}
		
		//Update user details in DB
		$id = $_SESSION['user_id'];
  		$sql = "UPDATE Customer SET email = ?, first_name = ?, last_name = ?, dob = ?, mobile = ?
  				WHERE customer_id = ?";
		
		$stmt = $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);	
	  	$stmt->bind_param('sssssi',strtolower($email),strtolower($first_name),strtolower($last_name),$dob,$phone,$id);
	  	$stmt->execute();
	  	$stmt->close();
	  	$db->close();
	  	
	  	//Update current session variables
	  	$_SESSION['user_email'] = strtolower($email);
		$_SESSION['user_first_name'] = strtolower($first_name);
		$_SESSION['user_last_name'] = strtolower($last_name);
		$_SESSION['user_dob'] = $dob;
		$_SESSION['user_phone'] = $phone;
		
		echo '<meta http-equiv="refresh" content="0;url=account.php?q=editdetails&msg=success">';
		exit();
	  	
	}
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 4 - Change user password
//////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST['changepass'])) {
	
	$current = trim(hash("sha256", $_POST['current']));
	$newPass1 = trim($_POST['newpass1']);
	$newPass2 = trim($_POST['newpass2']);
	$hashpass = hash("sha256", $newPass1);
	$id = $_SESSION['user_id'];
	
	if(empty($current) || empty($newPass1) || empty($newPass2)) {
		die("Some required fields were left empty!");
	}
	
	if(strlen($newPass1) < 6 || !preg_match('/\d/', $newPass1)) {
		die("Password must be at least 6 characters long and contain at least 1 digit!");
	}
	
	$sql = "SELECT password FROM Customer WHERE customer_id = '$id'";
	
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error(trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR));
	}
	
	while($row = $rs->fetch_assoc()) {
		$actualPass = $row['password'];
	}
	
	//Check if current password from form matches users actuall current password from DB
	if($current === $actualPass) {
		
		if($newPass1 === $newPass2) {
			//Update user password
			$sql = "UPDATE Customer SET password = ? WHERE customer_id = ?";
			$stmt = $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);;
			$stmt->bind_param('si',$hashpass,$id);
			$stmt->execute();
			$stmt->close();
			$db->close();
			
			echo '<meta http-equiv="refresh" content="0;url=account.php?q=changepass&msg=success">';
			exit();
		}
		
		else {
			die("Passwords do NOT match!");	
		}
	}
	
	else {
		$wrongCurrent = true;
		
		echo '<meta http-equiv="refresh" content="0;url=account.php?q=changepass&wrongc=1">';
		exit();
	}	
	
}
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 5 - Manage address
//////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['changeaddress'])) {
	$newCountry = trim($_POST['address_country']);
	$newStreet = trim($_POST['street']);
	$newCity = trim($_POST['city']);
	$newState = trim($_POST['state']);
	$newZip = trim($_POST['zip']);
	
	if(empty($newStreet) || empty($newCity)  || empty($newState)) {
		die("Some required fields were left empty!");
	}
	
	//Update user details in DB
	$id = $_SESSION['user_id'];
  	$sql = "UPDATE Customer SET address_country = ?, address_street = ?, address_city = ?, address_state = ?, address_zip = ?
  			WHERE customer_id = ?";
	
	$stmt = $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);	
  	$stmt->bind_param('sssssi',$newCountry,$newStreet,$newCity,$newState,$newZip,$id);
  	$stmt->execute();
  	$stmt->close();
  	$db->close();
  	
  	//Update current session variables
  	$_SESSION['user_address_country'] = $newCountry;
	$_SESSION['user_address_street'] = $newStreet;
	$_SESSION['user_address_city'] = $newCity;
	$_SESSION['user_address_state'] = $newState;
	$_SESSION['user_address_zip'] = $newZip;
	
	echo '<meta http-equiv="refresh" content="0;url=account.php?q=address&msg=success">';
		exit();
}
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 6 - Edit payment details
//////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['payment'])) {
	$type = trim($_POST['card_type']); 
	$name =$_POST['card_owner']; 
	$num1 = $_POST['card_number1'];
	$num2 = $_POST['card_number2'];
	$num3 = $_POST['card_number3'];
	$num4 = $_POST['card_number4'];
	$cardNumber = $num1.$num2.$num3.$num4;
	$month = trim($_POST['card_expiry_month']); 
	$year = trim($_POST['card_expiry_year']); 
	$expiry = $year . '-' . $month;
	$cvn = trim($_POST['card_cvn']);
	
	
	
	//Check for empty fields
	if(empty($type) || $type == "-" || empty($name) || empty($cardNumber) || empty($month) || $month == '---' || empty($year) || $year == '---' || empty($cvn)) {
		die("Some required fields were left blank!");
	}
	
	//Check card number
	if(!is_numeric($cardNumber)) {
		die("Invalid Card Number!");
	}
	
	//Prepare INSERT into DB
	$id = $_SESSION['user_id'];
	$sql = "UPDATE Customer SET card_type = ?, card_number = ?, card_owner = ?, card_expiry = ?, card_cvn = ?
		WHERE customer_id = ?";	
	
	$stmt = $db->prepare($sql) or  die("Prepared Statement Error: " . $db->error);
	$stmt->bind_param('ssssii',$type,$cardNumber,$name,$expiry,$cvn,$id);
	$stmt->execute();
	$stmt->close();
	
	echo '<meta http-equiv="refresh" content="0;url=account.php?q=payment&msg=success">';
		exit();
}
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 7 - Balance Top Up
//////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['topUp']) && !empty($_POST['topUp'])) {
	
	//Check if user has card info set up
	$id = $_SESSION['user_id'];
	$sql = "SELECT card_type, card_number, card_owner, card_expiry, card_cvn FROM Customer WHERE customer_id = '$id'";
	
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		while($row = $rs->fetch_assoc()) {
			if(empty($row['card_type']) || empty($row['card_number']) || empty($row['card_owner']) || empty($row['card_expiry']) || empty($row['card_cvn'])) 
			{echo '<meta http-equiv="refresh" content="0;url=account.php?nocard=1">';;exit();}
		}
	}
	
	$amount = $_POST['amount'];
	//Get current balance
	$current = $_SESSION['user_balance'];
	
	//Get new balance
	$current += $amount;
	
	//Update balance
	$sql = "UPDATE Customer SET balance = ? WHERE customer_id = ?";
	$stmt = $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);
	$stmt->bind_param('ii',$current,$id);
	$stmt->execute();
	$stmt->close();
	
	//Insert into Top up table
	$sql = "INSERT INTO TopUp (customer_id, amount, topup_date) VALUES ('$id','$amount',now())";
	if(!$db->query($sql)) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	//Update Session Variable
	$_SESSION['user_balance'] += $amount;

	echo '<meta http-equiv="refresh" content="0;url=account.php?topped=1">';
	exit();
	
	$db->close();
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
				
				<?php if(isset($_GET['q'])) { 
				
							 if($_GET['q'] == "editdetails") { 
							 	echo'<div class="account_edit_box">
							 		<div class="account_edit_box_title">
											<h3 style="margin:0;">Edit Your Details</h3>							 		
							 		</div>';
							 	if(isset($_GET['msg']) && $_GET['msg'] == "success") {
							 		echo '<h2 style="color:green;">Details Successfully Updated</h2>'	;
									echo '<a href="account.php"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">My Account</button></a>';
							 	}
							 	else{
									include("FORMS/edit_user_details_form.php");
								}
								echo '</div>';
							 }
							 
							 if($_GET['q'] == "changepass") {
							 	echo'<div class="account_edit_box">
							 		<div class="account_edit_box_title">
											<h3 style="margin:0;">Change Password</h3>							 		
							 		</div>';
							 	if(isset($_GET['msg']) && $_GET['msg'] == "success") {
							 		echo '<h2 style="color:green;">Password Successfully Changed</h2>'	;
									echo '<a href="account.php"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">My Account</button></a>';
							 	}
							 	else{
									include("FORMS/change_user_pass_form.php");
								}
								echo '</div>';
							 	
							 }
							 
							 if($_GET['q'] == "address") {
							 	echo'<div class="account_edit_box">
							 		<div class="account_edit_box_title">
											<h3 style="margin:0;">Manage Address</h3>							 		
							 		</div>';
							 	if(isset($_GET['msg']) && $_GET['msg'] == "success") {
							 		echo '<h2 style="color:green;">Address Successfully Updated</h2>'	;
									echo '<a href="account.php"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">My Account</button></a>';
							 	}
							 	else{
									include("FORMS/manage_user_address_form.php");
								}
								echo '</div>';	
							 }
							 
							 if($_GET['q'] == "payment") {
							 	echo'<div class="account_edit_box">
							 		<div class="account_edit_box_title">
											<h3 style="margin:0;">Edit Payment Options</h3>							 		
							 		</div>';
							 	if(isset($_GET['msg']) && $_GET['msg'] == "success") {
							 		echo '<h2 style="color:green;">Payment Details Successfully Updated</h2>'	;
									echo '<a href="account.php"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">My Account</button></a>';
							 	}
							 	else{
								 	include("FORMS/edit_payment_details_form.php");
								}
								echo '</div>';	
							 }
							 
							 if($_GET['q'] == "history") {
							 	
							 	echo '<div class="bannerTitle"><p>Your order history</p></div><br/>';
							 	
							 	$id = $_SESSION['user_id'];
								$historyOutput = '<p style="font-size: 1.5em;">You have no orders</p>';
								$sql = "SELECT * FROM Orders WHERE customer_id = '$id' ORDER BY order_date DESC";
								$rs = $db->query($sql);
								
								if($rs->num_rows > 0) {
									
									$historyOutput = '<table border="0" class="table-condensed table table-hover"';
									$historyOutput .= '<tr>
													  	</th style="font-weight: bold;">
													  		<td><strong>Order ID</strong></td>
															<td><strong>Order Date</strong></td>
															<td><strong>Total</strong></td>
															<td><strong>Status</strong></td>
															<td></td>
													  	</th>
													  </tr>
															';
									while($row = $rs->fetch_assoc()) {
										$orderID = $row['order_id'];
										$amount = $row['amount'];
										$orderDate = $row['order_date'];
										$status = strtoupper($row['status']);
										$historyOutput .= '<tr>
																		<td>'.$orderID.'</td>
																		<td>'.$orderDate.'</td>
																		<td>&euro;'.$amount.'</td>
																		<td>';
																	if($status == "PENDING") {$historyOutput .= '<p style="color:gray">'.$status.'</p>';}
																	if($status == "PROCESSING") {$historyOutput .= '<p style="color:orange">'.$status.'</p>';} 	
																	if($status == "SHIPPED") {$historyOutput .= '<p style="color:green">'.$status.'</p>';} 	
										$historyOutput .= 		'</td>
																	<td>
																		<form action="view_order.php" method="post">
																			<input type="hidden" name="oid" value="'.$orderID.'">
																			<input type="hidden" name="date" value="'.$orderDate.'">
																			<input type="hidden" name="amount" value="'.$amount.'">
																			<button type="submit" name="viewOrder" id="viewOrderBtn" class="btn btn-primary">View</button>
																		</form>																
																	</td>
																	</tr>';
									}
									$historyOutput .= '</table>';
								}								

								echo $historyOutput;
							 }
							 
							 if($_GET['q'] == "topups") {
							 	
							 	echo '<div class="bannerTitle"><p>Your top up history</p></div><br/>';
							 	
							 	$id = $_SESSION['user_id'];
								$topUpOutput = '<p style="font-size: 1.5em;">You did not top up yet</p>';
								$sql = "SELECT * FROM TopUp WHERE customer_id = '$id' ORDER BY topup_date DESC";
								$rs = $db->query($sql);
								
								if($rs->num_rows > 0) {
									
									$topUpOutput = '<table border="0" class="table-condensed table table-hover"';
									$topUpOutput .= '<tr>
													  	</th style="font-weight: bold;">
													  		<td><strong>Top Up ID</strong></td>
															<td><strong>Date</strong></td>
															<td><strong>Amount</strong></td>
													  	</th>
													  </tr>
															';
									while($row = $rs->fetch_assoc()) {
										$topUpID = $row['top_up_id'];
										$amount = $row['amount'];
										$date = $row['topup_date'];
										$topUpOutput .= '<tr>
																		<td>'.$topUpID.'</td>
																		<td>'.$date.'</td>
																		<td>&euro;'.$amount.'</td>
																</tr>';
									}
									$topUpOutput .= '</table>';
								}								

								echo $topUpOutput;
							 }
							 
						}
						
						else {
							
							echo '<div id="account_welcome">
										<h3 style="margin:0;">Welcome '. ucfirst($_SESSION['user_first_name']).'</h3>
										<br/>
										<p>This is your account dashboard. Here you can edit your personal details<br/>as well as view recent orders and top up your balance</p>
									</div>';	
														
					
							echo '<div class="account_quickbox_large">
											<div class="quickbox_title_large">
												<h4 style="margin:0;">Edit Your Details</h4>
											</div>
											<h5 style="float:left; margin-left:7px;font-weight:bold;">Account details</h5>
											<br/><br/>
											<p style="font-size: 0.9em; text-align:left; margin-left:7px;">Edit personal details such as email, first name, surname, & phone number</p>
											<a href="account.php?q=editdetails"><button type="button" class="btn btn-primary" style="width:90px; float:left; margin-left:7px;">Edit Now</button></a>
											<br/><hr/>
											
											<h5 style="float:left; margin-left:7px;font-weight:bold;">Manage address</h5>
											<br/><br/>
											<p style="font-size: 0.9em; text-align:left; margin-left:7px;">Change you delivery address</p>
											<a href="account.php?q=address"><button type="button" class="btn btn-primary" style="width:140px; float:left; margin-left:7px;">Manage Address</button></a>
									</div>';
							echo '<div class="account_quickbox_small">
										<div class="quickbox_title_small">
												<h4 style="margin:0;">Add Credit Card</h4>
										</div>
										<p style="font-size: 0.9em; text-align:left; margin-left:7px;">Add Credit Card or edit the existing one</p>
										<a href="account.php?q=payment"><button type="button" class="btn btn-primary" style="width:140px; float:left; margin-left:7px;">Payment Options</button></a>
									</div>';
									
						 echo '<div class="account_quickbox_medium">
										<div class="quickbox_title_large">
												<h4 style="margin:0;">Top Up Balance</h4>
										</div>
										<p style="font-size: 0.9em; text-align:left; margin-left:7px;">Easily top up your balance here with a push of a button<br/>In order to top up ';
										if(isset($_GET['nocard']) && $_GET['nocard'] == 1) { echo '<span style="color:crimson; font-size: 1.15em; font-weight: bold;">first set up your credit card information </span>'; }
										else{ echo 'first set up your credit card information ';}
										echo 'then enter the amount and press Top Up</p>';
										if(isset($_GET['topped']) && $_GET['topped'] == 1){
										echo '<span class="help-block" style="color:green;">Balance Updated</span>';}
										echo '<hr/>
												<form method="post" action="account.php" class="form-horizontal">
													<div class="form-group">
													<label for amount class="control-label col-xs-4" style="margin-left:7px;"><strong>Amount</strong></label>
													<div class="col-xs-6">
													<input type="number" name="amount" class="form-control" min="5" max="1000" step="5" value="5">
													</div>
													</div>
													<input type="submit" name="topUp" id="topUpBtn" class="btn btn-primary" value="Top Up" style="width: 90px; margin-top: 10px;">
												</form>										
										';
									echo '</div>';			
									
						echo '<div class="account_quickbox_small" style="margin-top: 25px;">
										<div class="quickbox_title_small">
												<h4 style="margin:0;">View Recent Orders</h4>
										</div>
										<p style="font-size: 0.9em; text-align:left; margin-left:7px;">View the details of your orders and see their status</p>
										<a href="account.php?q=history"><button type="button" class="btn btn-primary" style="width:140px; float:left; margin-left:7px;">View my Orders</button></a>
									</div>';		
						}
				?>
				
				<?php
					if($success === true) {
						echo '<div id="success_msg_box">';
						echo '<h3 style="color: green">Details Successfully Updated</h3>';
						echo '<a href="account.php">Go to My Account</a>';
						echo '</div>';
					}			
				?>
				
				<?php
					if(isset($_GET['msg'])) {
						
						if($_GET['msg'] == "passchanged") {
							echo '<h3>Your password has been successfully changed</h3>';
						}
						
						if($_GET['msg'] == "detailsupdated") {
							echo '<h3>Your personal details have been successfully updated</h3>';
						}
					}
				?>		
				
				</div>	
								
				</div><!--END contentWrapper-->
							
				
				
			</div><!--END mainWrapper-->
			<?php include("TEMPLATES/footer.php"); ?>
	</body>
	
</html>


