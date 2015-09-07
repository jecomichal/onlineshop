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
if (isset($_POST['changeStatusBlock'])) {
	$custID = $_POST['cid'];
	$sql = "UPDATE Customer SET active = 0 WHERE customer_id = '$custID'";
	$db->query($sql);
}
?>

<?php
if (isset($_POST['changeStatusUnblock'])) {
	$custID = $_POST['cid'];
	$sql = "UPDATE Customer SET active = 1 WHERE customer_id = '$custID'";
	$db->query($sql);
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
											<select class="form-control" name="filter" id="filter" onchange="RenderUsers()">
												<option value="all" selected>All Users</option>
												<option value="blocked">Blocked</option>
											</select>
										</div>
									</form>							
							';
							
							echo '
									<div id="viewOrders">';
								$viewOrders = '<span style="color:crimson; font-size:1.5em;">No users were found</span>';
								$sql = "SELECT *
											FROM Customer
											ORDER BY created DESC";
								$rs = $db->query($sql);
								
								if($rs->num_rows > 0) {
									
									$viewOrders = '<table border="0" class="table-condensed table table-hover"';
									$viewOrders .= '<tr>
													  	</th style="font-weight: bold;">
													  		<td><strong>Customer ID</strong></td>
															<td><strong>First Name</strong></td>
															<td><strong>Surname Name</strong></td>
															<td><strong>Email</strong></td>
															<td></td>
													  	</th>
													  </tr>
															';
									while($row = $rs->fetch_assoc()) {
										$custID = $row['customer_id'];
										$email = $row['email'];
										$status = $row['active'];
										$fname = ucfirst($row['first_name']);
										$sname = ucfirst($row['last_name']);
										$viewOrders .= '<tr>
																		<td>'.$custID.'</td>
																		<td>'.$fname.'</td>
																		<td>'.$sname.'</td>	
																		<td>'.$email.'</td>
																		<td>';
																	if($status == 1) {$viewOrders .= '<form action="users.php" method="post">
																				<input type="hidden" name="cid" value="'.$custID.'">
																				<button type="submit" name="changeStatusBlock" id="changeStatusBlock" class="btn btn-danger" style="width: 100px;">Block</button>
																				</form>';}
																	else{$viewOrders .= '<form action="users.php" method="post">
																				<input type="hidden" name="cid" value="'.$custID.'">
																				<button type="submit" name="changeStatusUnblock" id="changeStatusUnblock" class="btn btn-success" style="width: 100px;">Unblock</button>
																				</form>';} 	

																	$viewOrders .= 	'</td>
																		
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