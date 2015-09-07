<?php
//////////////////////////////////////////////////////////////////////////////////////
//		Section 1 - Includes, Session start
//////////////////////////////////////////////////////////////////////////////////////
session_start();
?>

<?php
if(!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] == 0) {
		echo '<meta http-equiv="refresh" content="0;url=../login.php">';
		exit();
	}
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
	</head>
	
	<body>
		
		<div align="center" id="mainWrapper">
		
			
			
			<div id="contentWrapper" style="height:565px; margin-top: 100px; padding:0px;">
			
				<div id="sidebarWrapper">
					
					<div id="admin_sidebar">
						<ul>
							<li><a href="products.php">Manage Products</a></li>
							<li><a href="stock.php">Manage Stock</a></li>
							<li><a href="orders.php">Manage Orders</a></li>
							<li><a href="users.php">Manage Users</a></li>
						</ul>
					</div>
					
				</div>
				
				<div id="admin_nav">
					<a class="tab_admin"  href="../logout.php">Sign Out</a>
					<a class="tab_admin"  href="index.php">Home</a>
				</div>
				<div id="admin_view_window">
				
					<?php
				
						echo '<div id="account_welcome">
										<h3 style="margin:0;">Welcome '. ucfirst($_SESSION['admin_first_name']).'</h3>
										<br/>
										<p>This is your admin panel.<br/> Here you can add/edit/delete products, stock, manage orders and users</p>
									</div>';	
														
					
							echo '<div class="account_quickbox_large">
											<div class="quickbox_title_large">
												<h4 style="margin:0;">Orders</h4>
											</div>
											<h5 style="float:left; margin-left:7px;font-weight:bold;">View latest orders</h5>
											<br/><br/>
											<p style="font-size: 0.9em; text-align:left; margin-left:7px;">View latest orders made by customers</p>
											<a href="orders.php"><button type="button" class="btn btn-primary" style="width:40%; float:left; margin-left:7px;">View Now</button></a>
											<br/>
									</div>';
							echo '<div class="account_quickbox_small">
										<div class="quickbox_title_small">
												<h4 style="margin:0;">Add New Product</h4>
										</div>
										<p style="font-size: 0.9em; text-align:left; margin-left:7px;">Add new product to the database<br/><br/></p>
										<a href="products.php?q=add"><button type="button" class="btn btn-primary" style="width:60%; float:left; margin-left:7px;">Add Product</button></a>
									</div>';
									
							echo '<div class="account_quickbox_small">
										<div class="quickbox_title_small">
												<h4 style="margin:0;">View Products</h4>
										</div>
										<p style="font-size: 0.9em; text-align:left; margin-left:7px;">See all products that are currently in the system</p>
										<a href="products.php?q=view"><button type="button" class="btn btn-primary" style="width:40%; float:left; margin-left:7px;">View</button></a>
									</div>';		
									
						echo '<div class="account_quickbox_small" style="margin-top:2.5%;">
										<div class="quickbox_title_small">
												<h4 style="margin:0;">Add Stock Item</h4>
										</div>
										<p style="font-size: 0.9em; text-align:left; margin-left:7px;">Add new stock item for a specific product</p>
										<a href="stock.php?q=add"><button type="button" class="btn btn-primary" style="width:50%; float:left; margin-left:7px;">Add Stock</button></a>
									</div>';	
									
							echo '<div class="account_quickbox_small" style="margin-top:2.5%;">
										<div class="quickbox_title_small">
												<h4 style="margin:0;">View Stock Items</h4>
										</div>
										<p style="font-size: 0.9em; text-align:left; margin-left:7px;">View all stock items for a specific product</p>
										<a href="stock.php?q=view"><button type="button" class="btn btn-primary" style="width:40%; float:left; margin-left:7px;">View</button></a>
									</div>';		
								
					?>
				
				</div>	
								
				</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
		</div>
		
		
	</body>
	
</html>