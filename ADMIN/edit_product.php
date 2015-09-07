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
if(isset($_GET['pid'])) {
	
//Get product Details

	$pid = $_GET['pid'];
	
	$sql = "SELECT p.product_id,p.title,p.brand,p.description, p.gender, p.price, p.date_added, p.available, c.name as category, pt.name as ptype FROM Product p,Category c,ProductType pt 
				WHERE p.product_id = '$pid' AND c.category_id = p.category_id AND pt.product_type_id = p.product_type_id";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}	
	
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$pid = $row['product_id'];
			$title = ucwords($row['title']);
			$brand = ucfirst($row['brand']);
			$price = $row['price'];
			$date = $row['date_added'];
			$avail = $row['available'] == 1 ? 'YES':'NO';
			$desc = $row['description'];
			$gender = $row['gender'];
			$cat = $row['category'];
			$type = $row['ptype'];
		}		
	}

}
?>

<?php
if(isset($_POST['updateProduct'])) {
	$oriTitle = strtolower($_GET['title']);
	$pid = $_POST['pid'];
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
		
	//Title must be unique
	$sql = "SELECT * FROM Product WHERE title = '$title'";
	$rs = $db->query($sql);
	
	if($rs->num_rows > 0 && $title !== str_replace("%20"," ",$oriTitle)) {	
			echo '<meta http-equiv="refresh" content="0;url=edit_product.php?pid='.$pid.'&title='.$oriTitle.'&msg=duplicate">';
			exit();
	}
	
	//Insert Product to DB
	$sql = "UPDATE Product SET title = ?, description = ?, brand = ?, category_id = ?, product_type_id = ?, gender = ?, price = ? WHERE product_id = '$pid'";
		  	
  	$stmt =  $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);	
  	$stmt->bind_param('sssiisd',$title,$desc,$brand,$catID,$typeID,$gender,$price);
  	$stmt->execute();
  	$stmt->close();

	//Move image to folder
  	if (isset($_FILES["myFile"]["name"]) && !empty($_FILES["myFile"]["name"]))
  	 { 
		 $fileName = $pid.'.jpg';
	    $tmp_name = $_FILES['myFile']['tmp_name'];
		    
     $location = '../IMAGES/PRODUCTS/';
		
		if(file_exists($location.$fileName)) {
			 chmod($location.$fileName, 0777);
  	 				 unlink($location.$fileName);
  	 			}
     move_uploaded_file($tmp_name, $location.$fileName);
	    
	}
	
	echo '<meta http-equiv="refresh" content="0;url=edit_product.php?msg=success">';
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
							<li><a href="products.php?q=feat">Featured Products</a></li>
					</div>
				</div>
				
				<div id="admin_nav">
					<a class="tab_admin"  href="../logout.php">Sign Out</a>
					<a class="tab_admin"  href="index.php">Home</a>
				</div>
				<div id="admin_view_window">
				
				<?php echo'<div class="account_edit_box">
							 		<div class="account_edit_box_title">
											<h3 style="margin:0;">Edit Product Details</h3>							 		
							 		</div>';
							 	if(isset($_GET['msg']) && $_GET['msg'] == "success") {
							 		echo '<h2 style="color:green;">Product Successfully Updated</h2>';
									echo '<a href="index.php"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">Admin Panel</button></a>';
							 	}
							 	else{
									include("../FORMS/admin_edit_product_form.php");	
								}
								echo '</div>';	 ?>		
				
				</div>	
								
				</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
		</div>
		
		
	</body>
	
</html>