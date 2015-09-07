<?php
///////////////////////////////////////////////////////////////////////////////////////
//		Section 1 - Includes, Start Session
//////////////////////////////////////////////////////////////////////////////////////
session_start();
require("CONFIG/connect_to_mysql.php");

?>

<?php
///////////////////////////////////////////////////////////////////////////////////////
//		Section 2 - Display details of new customer
//////////////////////////////////////////////////////////////////////////////////////
	if(isset($_GET['id']) && isset($_GET['token'])) {
		$id = $_GET['id'];
		$token = $_GET['token'];
		
		//See if user with that id and token exists in DB
		$sql = "SELECT first_name, last_name, email, address_country, address_street, address_city, address_state,
		  				address_zip, DOB, mobile FROM Customer WHERE customer_id = ? AND token = ? LIMIT 1";
		
		$stmt = $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);
		$stmt->bind_param('is',$id,$token);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows != 1) {
			echo '<meta http-equiv="refresh" content="0;url=index.php">';
			exit();
		}
		
		$stmt->bind_result($first_name,$last_name,$email,$address_country,$address_street,$address_city,
			$address_state,$address_zip,$dob,$phone);
		
		$stmt->fetch();

		$stmt->close();
		$db->close();
	}
	
	else {
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();	
	}
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>	</title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		
		<div align="center" id="mainWrapper">
		
			<?php 
				include("TEMPLATES/header.php");
			?>
			
			<div id="contentWrapper" style="height: 650px;">
			
					<div id="registration_final_wrapper">
						<div id="registration_final">
								<h1>Registration Successfull</h1>
								
								<div class="info_box" style="margin-left: 265px;">
									<table class="table-condensed table table-hover">
										<thead>
											<tr>
												<th colspan="2"><h4>Personal Information<h4></th>									
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>First Name</th>
												<td><?php echo ucfirst($first_name) ?></td>
											</tr>
											<tr>
												<th>Last Name</th>
												<td><?php echo ucfirst($last_name) ?></td>
											</tr>
											<tr>
												<th>Email</th>
												<td><?php echo ucfirst($email) ?></td>
											</tr>
											<tr>
												<th>Date of Birth</th>
												<td><?php echo $dob ?></td>
											</tr>
											<tr>
												<th>Phone</th>
												<td><?php echo $phone ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								
								<div class="info_box">
									<table class="table-condensed table table-hover">
										<thead>
											<tr>
												<th colspan="2"><h4>Address<h4></th>									
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>Country</td>
												<td><?php echo $address_country ?></th>
											</tr>
											<tr>
												<th>Street</th>
												<td><?php echo ucwords($address_street) ?></td>
											</tr>
											<tr>
												<th>City</th>
												<td><?php echo ucfirst($address_city) ?></td>
											</tr>
											<tr>
												<th>State/County</th>
												<td><?php echo ucfirst($address_state) ?></td>
											</tr>
											<tr>
												<th>Zip</th>
												<td><?php echo ucfirst($address_zip) ?></td>
											</tr>
										</tbody>
									</table>
								
								</div>
								
								<div id="success_buttons_box">
									<table class="table">
										<tr>
											<td>
												<form action="index.php">
    												<input type="submit" class="btn btn-primary success_button" value="Home" style="width: 125px; height: 50px;">
												</form>
											</td>
											<td>
											<form action="login.php">
    												<input type="submit" class="btn btn-primary success_button" value="Sign In" style="width: 125px; height: 50px;">
												</form>											
											</td>										
										</tr>
									</table>
								</div>
						</div><!--END registration_final-->
					</div><!--END registration_final_wrapper-->
								
			</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			<?php include("TEMPLATES/footer.php"); ?>
		</div>
	</body>
	
</html>

