<?php
ob_start();
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 1 - Includes, Session start
//////////////////////////////////////////////////////////////////////////////////////
session_start();
require("CONFIG/connect_to_mysql.php");
require("CONFIG/config.php");
$userExists = false;
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 2 - Set session variables
//////////////////////////////////////////////////////////////////////////////////////
	
	if(!isset($_SESSION['loginAttempts'])){
		$_SESSION['loginAttempts']=0;
	}
	
	if(!isset($_SESSION['loginAttemptsAdmin'])){
		$_SESSION['loginAttemptsAdmin']=0;
	}

	if (!isset($_SESSION['userloggedin'])){
		$_SESSION['userloggedin']=0;
	}
	
	if (!isset($_SESSION['adminloggedin'])){
		$_SESSION['adminloggedin']=0;
	}
	
	$max_login_attempts = __MAX_LOGIN_ATTEMPTS;
	$login_fail = false;
	$login_fail_admin = false;
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 3 - Redirect user if they are logged in
//////////////////////////////////////////////////////////////////////////////////////
if (isset($_SESSION['userloggedin']) && $_SESSION['userloggedin']==1){
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
	exit();
}

if (isset($_SESSION['adminloggedin']) && $_SESSION['adminloggedin']==1){
	echo '<meta http-equiv="refresh" content="0;url=ADMIN/index.php">';
	exit();
}
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 4 - User login
//////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['user_login'])) {

	$email = trim($_POST['user_email']);
	$pass = trim($_POST['user_password']);
	$hashpass = hash("sha256",$pass);
	
	//Check if account is locked
	$rs = $db->query("SELECT * FROM Customer WHERE email = '$email' LIMIT 1");
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	if($rs->num_rows > 0) {
		$userExists = true;
		while($row = $rs->fetch_assoc()) {
				$active = $row['active'];
		}
		if($active != 1) {
			echo '<meta http-equiv="refresh" content="0;url=login.php?msg=blocked">';
			exit();

		}
	}
	
	
	//Check DB for that email & password to see if user exists
	$rs = $db->query("CALL userLogin('$email','$hashpass')");
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	if($rs->num_rows == 1) { //Login successful
		
		while($row = $rs->fetch_assoc()) {
			$_SESSION['userloggedin'] = 1;
			$_SESSION['user_id'] = $row['customer_id'];
			$_SESSION['user_email'] =  ucfirst($row['email']);
			$_SESSION['user_first_name'] =  ucfirst($row['first_name']);
			$_SESSION['user_last_name'] =  ucfirst($row['last_name']);
			$_SESSION['user_address_country'] = $row['address_country'];
			$_SESSION['user_address_street'] =  ucfirst($row['address_street']);
			$_SESSION['user_address_city'] =  ucfirst($row['address_city']);
			$_SESSION['user_address_state'] =  ucfirst($row['address_state']);
			$_SESSION['user_address_zip'] = $row['address_zip'];
			$_SESSION['user_dob'] = $row['dob'];
			$_SESSION['user_phone'] = $row['mobile'];
			$_SESSION['user_balance'] = $row['balance'];
				
				$user_cart = "";
				$user_cart .= $_SESSION['user_id'];
				$user_cart .= '-cart';
			if(isset($_COOKIE[$user_cart])) {
				$cart_array = json_decode($_COOKIE[$user_cart], true);
				$_SESSION['cart'] = $cart_array;
			}	
		}
			echo '<meta http-equiv="refresh" content="0;url=index.php">';
			exit();
		
	}
	
	else {
		//Unsuccessful login
		$login_fail = true;
		$_SESSION['loginAttempts']++;
		$logins_left = $max_login_attempts - $_SESSION['loginAttempts'];
		
		if($_SESSION['loginAttempts'] >= $max_login_attempts) { //Lock user account after 3 login fails
			
			if($userExists === true) {
				while($db->more_results()){
				    $db->next_result();
				    $db->use_result();
				}
				$sql = "UPDATE Customer SET active = 0 WHERE email = ?";
				$stmt =  $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);	
					$stmt->bind_param('s',$email);
					$stmt->execute();
					$stmt->close();
				$_SESSION['loginAttempts'] = 0;
				echo '<meta http-equiv="refresh" content="0;url=login.php?msg=lock">';
				exit();
			}
			
			else {
				$_SESSION['loginAttempts'] = 0;
				echo '<meta http-equiv="refresh" content="0;url=login.php">';
				exit();
			}
			
		}
	}
		
	
	
}
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 5 - Admin login
//////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['admin_login'])) {

	$email = trim($_POST['admin_email']);
	$pass = trim($_POST['admin_password']);
	$hashpass = hash("sha256",$pass);
	
	//Check if account is locked
	$sql = "SELECT * FROM Admin WHERE email = '$email' LIMIT 1";
	
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			while($row = $rs->fetch_assoc()) {
					$active = $row['active'];
			}
			if($active != 1) {
				echo '<meta http-equiv="refresh" content="0;url=login.php?msg=blocked">';
				exit();
			}
		}
	}
	
	//Check DB for that email & password to see if admin exists
	$sql = "SELECT * FROM Admin WHERE email = '$email' AND password = '$hashpass' LIMIT 1";
	
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows == 1) { //Login successful
			
			while($row = $rs->fetch_assoc()) {
				$_SESSION['adminloggedin'] = 1;
				$_SESSION['admin_id'] = $row['admin_id'];
				$_SESSION['admin_email'] =  ucfirst($row['email']);
				$_SESSION['admin_first_name'] =  ucfirst($row['first_name']);
				$_SESSION['admin_last_name'] =  ucfirst($row['last_name']);
				$_SESSION['admin_type'] = $row['type'];
				
				//update last_login
				$sql = "UPDATE Admin SET last_login = now() WHERE email = '$email'";
				if($db->query($sql) === false){
					trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
				}
			}	
			echo '<meta http-equiv="refresh" content="0;url=ADMIN/index.php">';
			exit();
		}
		
		else {
			//Unsuccessful login
			$login_fail_admin = true;
			$_SESSION['loginAttemptsAdmin']++;
			$logins_left = $max_login_attempts - $_SESSION['loginAttemptsAdmin'];
			
			if($_SESSION['loginAttemptsAdmin'] >= $max_login_attempts) { //Lock admin account after 3 login fails
				
				//Check if that email is in DB. if so lock that account
				$sql = "SELECT * FROM Admin WHERE email = '$email'";
				$rs = $db->query($sql);
				if($rs === false) {
					trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
				}
				
				if($rs->num_rows > 0) {
					$sql = "UPDATE Admin SET active = 0 WHERE email = '$email'";
					if($db->query($sql) === false){
						trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
					}
					$_SESSION['loginAttemptsAdmin'] = 0;
					echo '<meta http-equiv="refresh" content="0;url=login.php?msg=lock">';
					exit();
				}
				
				else {
					$_SESSION['loginAttemptsAdmin'] = 0;
					header('Location: login.php');
					exit();
				}
				
			}
		}
		
	}
	
}
?>

<?php
ob_end_flush();
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>Sign In</title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="JS/myScripts.js"></script>
	</head>
	
	<body>
		<div align="center" id="mainWrapper">
		
		<?php include("TEMPLATES/header.php"); ?>
				
			<div id="contentWrapper" style="height: 650px;">
				<div id="registration_final_wrapper">
					<div id="registration_final">
						<div class="login_box">
						<h4 align="left">User Login</h4>
							<br/>
							<?php
							 if($login_fail == true) {
								echo'<div id="login_warning_box">
								<p>login failed ' .$logins_left. ' attempts left!</p>
							</div>';
							}?>
							<?php include("FORMS/user_login_form.php");	 ?>
							<?php if(isset($_GET['msg']) && $_GET['msg'] == 'blocked')
								{
									echo '<br><br><br><br><p style="color:crimson; font-size: 1.3em;">This accout has been blocked. Please contact the administrator.</p>';
								} 

								elseif (isset($_GET['msg']) && $_GET['msg'] == 'lock') {
									echo '<br><br><br><br><p style="color:crimson; font-size: 1.3em;">Your account is now block due to too many incorrect login attempts.</p>';

								}?>
						</div>							
						<div class="login_box" style="float:right">
						<h4 align="left">Admin Login</h4>
							<br/>
							<?php
							 if($login_fail_admin == true) {
								echo'<div id="login_warning_box">
								<p>Login failed ' .$logins_left. ' attempts left!</p>
							</div>';
							}?>
							<?php include("FORMS/admin_login_form.php");?>
						</div>
					</div><!--END registration_final-->
				</div><!--END registration_final_wrapper-->
								
			</div><!--END contentWrapper-->
			
		</div><!--END mainWrapper-->
		
		<?php include("TEMPLATES/footer.php");?>
		
	</body>
	
</html>