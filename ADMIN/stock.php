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
// Add Stock
if(isset($_POST['addStock'])) {
	$pid = isset($_POST['product']) ? $_POST['product'] : '-';
	$size = $_POST['size'];
	$color = $_POST['color'];
	$qty = $_POST['qty'];
	
	//Check for empty fields
	if($pid == '-' || $size == '-' || !isset($_FILES["myFile"]["name"]) ||  empty($_FILES["myFile"]["name"]) || $qty < 1) {
		die("All Fields are required!");
	}	
	
	//Prepare insert to stock table
	$sql = "INSERT INTO Stock (product_id,size_id,color_id,quantity) VALUES(?,?,?,?)";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('iiii',$pid,$size,$color,$qty);
	$stmt->execute();
	
	//Make product available
	$sql = "UPDATE Product SET available = 1 WHERE product_id = '$pid'";
	if(!$db->query($sql)) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
  	//Move image to folder
  	if (isset($_FILES["myFile"]["name"]))
  	 {
		 $fileName = $pid.'-'.$color.'.jpg';
	    $tmp_name = $_FILES['myFile']['tmp_name'];
	    $error = $_FILES['myFile']['error'];
	
	    if (!empty($fileName)) {
	        $location = '../IMAGES/PRODUCTS/';
	
	        move_uploaded_file($tmp_name, $location.$fileName);
	    }
	}
	
	echo '<meta http-equiv="refresh" content="0;url=stock.php?q=add&msg=success">';
	exit();
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700" rel="stylesheet" type="text/css">
		<script src="../JS/myScripts.js"></script>
	</head>
	
	<body>
		
		<div align="center" id="mainWrapper">
		
			
			
			<div id="contentWrapper" style="min-height:600px; height:auto; overflow: hidden; margin-top: 100px; padding:0px;">
			
				<div id="sidebarWrapper">
					
					<div id="admin_sidebar">
						<ul>
							<li><a href="stock.php?q=add">Add Stock</a></li>
							<li><a href="stock.php?q=edit">Edit Stock</a></li>
					</div>
					
				</div>
				
				<div id="admin_nav">
					<a class="tab_admin"  href="../logout.php">Sign Out</a>
					<a class="tab_admin"  href="index.php">Home</a>
				</div>
				<div id="admin_view_window">
				
				<?php	if(isset($_GET['q']) && !empty($_GET['q'])) {
						
						if($_GET['q'] == "add") {
							echo'<div class="account_edit_box">
							 		<div class="account_edit_box_title">
											<h3 style="margin:0;">Add New Stock Item</h3>							 		
							 		</div>';
							 	if(isset($_GET['msg']) && $_GET['msg'] == "success") {
							 		echo '<h2 style="color:green;">Stock Item Successfully Added</h2>';
									echo '<a href="index.php"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">Admin Panel</button></a>';
							 	}
							 	else{
									include("../FORMS/admin_add_stock_form.php");	
								}
								echo '</div>';			
						}
						
						elseif($_GET['q'] == "delete") {
								echo '<div class="bannerTitle"><p>Delete Stock Items</p></div><br/>';
							 	
								$viewProductOutput = '<p style="font-size: 1.5em;">There are no products in the system</p>';
								$sql = "SELECT product_id,title,brand,price,date_added,available FROM Product ORDER BY date_added DESC";
								$rs = $db->query($sql);
								
								if($rs->num_rows > 0) {
									
									$viewProductOutput = '<table border="0" class="table-condensed table table-hover"';
									$viewProductOutput .= '<tr>
													  	</th style="font-weight: bold;">
													  		<td></td>
													  		<td><strong>Product ID</strong></td>
															<td><strong>Title</strong></td>
															<td><strong>Brand</strong></td>
															<td><strong>Price</strong></td>
															<td><strong>Date Added</strong></td>
															<td><strong>Available</strong></td>
															<td></td>
													  	</th>
													  </tr>
															';
									while($row = $rs->fetch_assoc()) {
										$productID = $row['product_id'];
										$title = ucwords($row['title']);
										$brand = ucfirst($row['brand']);
										$price = $row['price'];
										$date = $row['date_added'];
										$avail = $row['available'];
										$viewProductOutput .= '<tr>
																		<td><img src="../IMAGES/PRODUCTS/'.$productID.'.jpg" width="75" height="75"></td>
																		<td>'.$productID.'</td>
																		<td>'.$title.'</td>
																		<td>'.$brand.'</td>
																		<td>&euro;'.$price.'</td>
																		<td>'.$date.'</td>
																		
																		<td>';
																	if($avail == 1) {$viewProductOutput .= 'Yes';}
																	else {$viewProductOutput .= 'No';} 	
										$viewProductOutput .= 		'</td>
																		<td>
																			<form method="post" action="view_product.php">
																				<input type="hidden" name="productID" value="'.$productID.'">
																				<input type="hidden" name="title" value="'.$title.'">
																				<input type="hidden" name="brand" value="'.$brand.'">
																				<input type="hidden" name="price" value="'.$price.'">
																				<input type="hidden" name="date" value="'.$date.'">
																				<input type="hidden" name="avail" value="'.$avail.'">
																				<button type="submit" name="viewSingleProduct" class="btn btn-primary">View</button>
																			</form>																		
																		</td>
																	</tr>';
									}
									$viewProductOutput .= '</table>';
								}								

								echo $viewProductOutput;
							 }
							 
							 elseif($_GET['q'] == "edit") {
							 		echo '<h3>Find the Stock item that you want to edit</h3><br><br><br>';
									echo '<form method="get" action="" style="width: 600px;">
				                <div class="input-group">
				                    <input type="text" id="searchID" class="form-control" placeholder="Enter Stock ID" name="search">
				                    <div class="input-group-btn">
				                        <button class="btn btn-default" type="button" onclick="FindStock()"><i class="glyphicon glyphicon-search"></i></button>
				                    </div>
				                </div>
				              </form>
								  <div id="resultBox" style="margin-top: 100px;">
									
									</div>				              
				              ';
							 }
						}

						else
						{
							echo '<h1>Manage Stock Menu</h1>';
							echo '<br><br>
								  <h3>Here you can add new stock items for a given product or edit an existing stock item</h3>
							';
						}
							
							
				
				?>
				
				</div>	
								
				</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
		</div>
		
		
	</body>
	
</html>