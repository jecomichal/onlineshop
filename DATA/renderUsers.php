<?php
require("../CONFIG/connect_to_mysql.php");
$f = $_REQUEST['f'];

if($f == "all") {
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
}								
	

elseif($f == "blocked") {
$viewOrders = '<span style="color:crimson; font-size:1.5em;">No users were found</span>';
	$sql = "SELECT *
				FROM Customer
				WHERE active = 0
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
}								
?>