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
if(isset($_POST['viewSingleProduct'])) {
	
	$pid = $_POST['productID'];
	$title = $_POST['title'];
	$brand = $_POST['brand'];
	$price = $_POST['price'];
	$date = $_POST['date'];
	$avail = $_POST['avail'];
	$viewDetails = "";
	//Get product Details
	$sql = "SELECT p.description, p.gender, c.name as category, pt.name as type FROM Product p,Category c,ProductType pt 
				WHERE p.product_id = '$pid' AND c.category_id = p.category_id AND pt.product_type_id = p.product_type_id";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}	
	
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$desc = $row['description'];
			$gender = $row['gender'];
			$cat = $row['category'];
			$type = $row['type'];
		}
		$viewDetails = '<table border="0" class="table-condensed table table-hover"';
		$viewDetails .= '<tr>
									<th>Image</th>
									<td><img src="../IMAGES/PRODUCTS/'.$pid.'.jpg" width="75" height="75"></td>
								</tr>
								<tr>
									<th>Product ID</th>
									<td>'.$pid.'</td>
								</tr>
								<tr>
									<th>Title</th>
									<td>'.$title.'</td>
								</tr>
								<tr>
									<th>Description</th>
									<td>'.$desc.'</td>
								</tr>
								<tr>
									<th>Brand</th>
									<td>'.$brand.'</td>
								</tr>
								<tr>
									<th>Category</th>
									<td>'.ucfirst($cat).'</td>
								</tr>
								<tr>
									<th>Product Type</th>
									<td>'.ucfirst($type).'</td>
								</tr>
								<tr>
									<th>Gender</th>
									<td>'.ucfirst($gender).'</td>
								</tr>
								<tr>
									<th>Price</th>
									<td>&euro;'.$price.'</td>
								</tr>
								<tr>
									<th>Date Added</th>
									<td>'.$date.'</td>
								</tr>
								<tr>
									<th>Available</th>';
									
									if($avail == 1) { $viewDetails .= '<td>Yes</td>';}
									else{$viewDetails .= '<td>No</td>';}
								$viewDetails .= '</tr>

								</table>								
								<br><br>
								<a href="products.php?q=view"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">Back To Product List</button></a>
								';
		
	}
	
	else{
		$viewDetails = "No Details were found. Sorry";
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
		<title>	</title>
		<link rel="stylesheet" type="text/css" href="../CSS/main.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="../JS/myScripts.js"></script>
	</head>
	
	<body>
		
		<div align="center" id="mainWrapper">
		
			
			
			<div id="contentWrapper" style="min-height:600px; height:auto; overflow: hidden; margin-top: 100px; padding:0px;">
			
				<div id="sidebarWrapper">
					
					<div id="admin_sidebar">
						<ul>
							<li><a href="products.php?q=view">View All Products</a></li>
							<li><a href="products.php?q=add">Add New Product</a></li>
							<li><a href="products.php?q=edit">Edit Existing Product</a></li>
					</div>
					
				</div>
				
				<div id="admin_nav">
				
				</div>
				<div id="admin_view_window">
				
				<?php echo $viewDetails; ?>
				
				</div>	
								
				</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
		</div>
		
		
	</body>
	
</html>