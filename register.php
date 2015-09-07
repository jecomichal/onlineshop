<?php
///////////////////////////////////////////////////////////////////////////////////////
//		Section 1 - Includes, Start Session
//////////////////////////////////////////////////////////////////////////////////////
session_start();
require("CONFIG/connect_to_mysql.php");
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 2 - Registration
//////////////////////////////////////////////////////////////////////////////////////
	if(isset($_POST['registerButton'])) { 
	
		  	//Process the data from the form
		  	$email = strtolower($_POST['email']);
		  	$first_name = strtolower($_POST['first_name']);
		  	$last_name = strtolower($_POST['last_name']);
		  	$dob_day = $_POST['dob_day'];
		  	$dob_month = $_POST['dob_month'];
		  	$dob_year = $_POST['dob_year'];
		  	$dob = $dob_year . '-' . $dob_month . '-' . $dob_day;
		  	$phone = $_POST['phone'];
		  	$address_country = $_POST['address_country'];
		  	$address_street = strtolower($_POST['address_street']);
		  	$address_city = strtolower($_POST['address_city']);
		  	$address_state = strtolower($_POST['address_state']);
		  	$address_zip = strtolower($_POST['address_zip']);
		  	$password1 = $_POST['password1'];
		  	$password2 = $_POST['password2'];
		  	$hashpass = hash("sha256", $password1);
		  	$token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);
			
		   //Check for empty fields that are required
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
			
			if(empty($address_street)) {
				die("Street is required!");
			}
			
			if(empty($address_city)) {
				die("City is required!");
			}
			
			if(empty($address_state)) {
				die("State is required!");
			}
			
			if($dob_day == '-' || $dob_month == '-' || $dob_year == '-') {
				$dob = "0000-00-00";
			}
			
			if(empty($password1) || empty($password2)) {
				die("Password is required!");
			}
			
			//Check phone number
			if(!preg_match("/^[0-9]+$/",$phone)) {
				die("Invalid phone number!");
			}
			
			//Check if email is valid and not already in the system
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				die("Invalid email address format!");
			}
			
			$sql = "SELECT customer_id FROM Customer WHERE email = '$email' LIMIT 1";
			
			$rs = $db->query($sql);
			
			if($rs === false) {
				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
			}
			
			if($rs->num_rows > 0) {
				echo '<meta http-equiv="refresh" content="0;url=register.php?msg=wrongmail">';
                                exit();
			}
	
			if(strlen($password1) < 6 || !preg_match('/\d/', $password1)) {
					die("Password must be at least 6 characters long and contain at least 1 digit!");
			}
			
			if($password1 !== $password2) {
				die("Passwords do not match!");
			}
			
			//Prepare INSERT to DB - Insert new customer
		  	$sql = "INSERT INTO Customer (first_name, last_name, email, password, address_country, address_street, address_city, address_state,
		  				address_zip, dob, mobile, token, created)
		  				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,now())";
		  	
		  	$stmt =  $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);	
	  		$stmt->bind_param('ssssssssssss',$first_name,$last_name,$email,$hashpass,$address_country,$address_street,
	  			$address_city,$address_state,$address_zip,$dob,$phone,$token);
	  		$stmt->execute();
	  		$stmt->close();
			
			//SELECT from DB
			$sql = "SELECT customer_id, token FROM Customer WHERE email= '$email' LIMIT 1";
			$rs = $db->query($sql);
			
			if($rs === false) {
				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
			}
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['customer_id'];
				$token = $row['token'];
			}
	  		
	  		//Redirect to success.php page
	  		echo '<meta http-equiv="refresh" content="0;url=success.php?id='.$id.'&token='.$token.'">';
			exit();
	  		$db->close();	
		}
?>
<!DOCTYPE html>
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
			
			<div id="contentWrapper" style="min-height: 1000px; height: auto; overflow:hidden;">
			
				<div id="regformWrapper">
					<h2 align="left">Registration</h2>
					<div align="left" id="regformContainer">
						<section>
							<p>All fields marked with <span style="color:red;">*</span> are required.</p>
							<p><strong>NOTE: </strong> Server may take several seconds to process your registration request please let the page fully load.</p>
							<hr/>
						</section>
						<br/>
						<br/>
						<?php include("FORMS/registration_form.php"); ?>
					</div>
					
					<div id="regbenefits">
					
					</div>
				</div>
									
			</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
			<?php include("TEMPLATES/footer.php"); ?>
		</div>
	</body>
	
</html>
