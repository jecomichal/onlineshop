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
if(isset($_POST['addProduct'])) {
	
	$title = strtolower(trim($_POST['title']));
	$desc = trim($_POST['desc']);
        $desc = preg_replace("<script>", "", $desc);
        $desc = preg_replace("</script>", "", $desc);
	$brand = strtolower(trim($_POST['brand']));
	$catID = $_POST['category'];
	$typeID = $_POST['type'];
	$gender = $_POST['gender'];
	$price = $_POST['price'];
	
	
	if(empty($title) || empty($desc) || empty($brand) || empty($price)) {
		die("All fields are required");
	}
	
	if(!preg_match("/^[0-9.]+$/",$price)) {
				die("Invalid Price!");
	}
	
	if(!isset($_FILES["myFile"]["name"]) || empty($_FILES["myFile"]["name"])) {
		die("Image is required");
	}
	
	//Title must be unique
	$sql = "SELECT * FROM Product WHERE title = '$title'";
	$rs = $db->query($sql);
	
	if($rs->num_rows > 0) {
		header('Location: products.php?q=add&msg=duplicate');
		exit();
	}
	
	//Insert Product to DB
	$sql = "INSERT INTO Product (title, description, brand, category_id, product_type_id, gender, price, date_added) VALUES(?,?,?,?,?,?,?,now())";
		  	
  	$stmt =  $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);	
  	$stmt->bind_param('sssiisd',$title,$desc,$brand,$catID,$typeID,$gender,$price);
  	$stmt->execute();
	$pid = $stmt->insert_id;
  	$stmt->close();

  	//Move image to folder
  	if (isset($_FILES["myFile"]["name"]))
  	 {
		 $fileName = $pid.'.jpg';
	    $tmp_name = $_FILES['myFile']['tmp_name'];
	    $error = $_FILES['myFile']['error'];
	
	    if (!empty($fileName)) {
	        $location = '../IMAGES/PRODUCTS/';
	
	        move_uploaded_file($tmp_name, $location.$fileName);
	    }
	}
	echo '<meta http-equiv="refresh" content="0;url=products.php?q=add&msg=success">';
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
		<meta http-equiv="Pragma" content="no-cache">
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
							<li><a href="products.php?q=feat">Featured Products</a></li>
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
											<h3 style="margin:0;">Add New Product</h3>							 		
							 		</div>';
							 	if(isset($_GET['msg']) && $_GET['msg'] == "success") {
							 		echo '<h2 style="color:green;">Product Successfully Added</h2>';
							 		echo '<h3 style="color:orange;">In order for customers to purchase this product please add stock items</h3>';
									echo '<a href="index.php"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">Admin Panel</button></a>';
							 	}
							 	else{
									include("../FORMS/admin_add_product_form.php");	
								}
								echo '</div>';			
						}
						
						elseif($_GET['q'] == "view") {
								echo '<div class="bannerTitle"><p>List of Products</p></div><br/>';
							 	
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
							 		echo '<h3>Find the product that you want to edit</h3><br><br><br>';
									echo '<form method="get" action="" style="width: 600px;">
				                <div class="input-group">
				                    <input type="text" id="searchID" class="form-control" placeholder="Enter Product ID" name="search">
				                    <div class="input-group-btn">
				                        <button class="btn btn-default" type="button" onclick="FindProduct()"><i class="glyphicon glyphicon-search"></i></button>
				                    </div>
				                </div>
				              </form>
								  <div id="resultBox" style="margin-top: 100px;">
									
									</div>				              
				              ';
							 }
							 
							 elseif($_GET['q'] == "feat") {
							 	echo '<h3>Find the product that you want to feature</h3><br>';
									echo '<form method="get" action="" style="width: 600px;">
				                <div class="input-group">
				                    <input type="text" id="featuredSearchID" class="form-control" placeholder="Enter Product ID">
				                    <div class="input-group-btn">
				                        <button class="btn btn-default" type="button" onclick="FindProductFeatured()"><i class="glyphicon glyphicon-search"></i></button>
				                    </div>
				                </div>
				              </form>
								  <div id="featuredResultBox" style="margin-top: 5%; margin-bottom: 5%;">
									
									</div>
									
									<div id="feature-msg" style="margin-bottom: 5%;">
									
									</div>			              
				              ';
				              
				             echo '<div class="bannerTitle"><p>Currently Featured</p></div><br/>';
				             
				            echo '<div id="ajaxFeatured">';			 
							 	
								$featuredProductOutput = '<p style="font-size: 1.5em;">There are no featured products</p>';
								$sql = "SELECT product_id,title,brand,price,date_added,available FROM Product WHERE featured = 1 ORDER BY date_added DESC";
								$rs = $db->query($sql);
								
								if($rs->num_rows > 0) {
									
									$featuredProductOutput = '<table border="0" class="table-condensed table table-hover"';
									$featuredProductOutput .= '<tr>
													  	</th style="font-weight: bold;">
													  		<td></td>
													  		<td><strong>Product ID</strong></td>
															<td><strong>Title</strong></td>
															<td><strong>Brand</strong></td>
															<td><strong>Price</strong></td>
															<td><strong>Date Added</strong></td>
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
										$featuredProductOutput .= '<tr>
																		<td><img src="../IMAGES/PRODUCTS/'.$productID.'.jpg" width="75" height="75"></td>
																		<td>'.$productID.'</td>
																		<td>'.$title.'</td>
																		<td>'.$brand.'</td>
																		<td>&euro;'.$price.'</td>
																		<td>'.$date.'</td>
																		<td>
																			<form class="form-horizontal" id="remove_featured_form" name="remove_featured_form" role="form">
																				<input type="hidden" id="featuredProductID'.$productID.'" value="'.$productID.'">
																				<button type="button" name="removeFeatured" id="removeFeatured'.$productID.'" class="btn btn-danger" onclick="RemoveFeatured(event)">X</button>
																			</form>																		
																		</td>
																	</tr>';
									}
									$featuredProductOutput .= '</table>';
								}
									

								echo $featuredProductOutput;
								
								echo '</div>';
								
							 }
						}

						else
						{
							echo '<h1>Manage Products Menu</h1>';
							echo '<br><br>
								  <h3>Here you can view existing products that are currently in the system, add new products for customers to buy, edit details
								  of existing products and set featured products</h3>
							';
						}
							
							
				
				?>
				
				</div>	
								
				</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
		</div>
		
		
	</body>
	
</html>