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
if (isset($_POST['editStockView'])) {
	$color = $_POST['color'];
	$size = $_POST['size'];
	$sid = $_POST['stockID'];
	$pid = $_POST['productID'];
	$qty = $_POST['qty'];
}
?>

<?php
if(isset($_POST['editStock'])) {
	$pid = $_POST['productID'];
	$sid = $_POST['stockID'];
	$size = $_POST['size'];
	$color = $_POST['color'];
	$qty = $_POST['qty'];

	if (empty($qty) || $qty < 0) {
		die("Quantity is required!");
		exit();
	}

	$sql = "UPDATE Stock SET size_id = ?, color_id = ?, quantity = ? WHERE stock_id = ?";

	$stmt =  $db->prepare($sql) or die("Prepared Statement Error: " . $db->error);	
  	$stmt->bind_param('iiii',$size,$color,$qty,$sid);
  	$stmt->execute();
  	$stmt->close();

	//Move image to folder
  	if (isset($_FILES["myFile"]["name"]) && !empty($_FILES["myFile"]["name"]))
  	{ 
		$fileName = $pid.'-'.$color.'.jpg';
	    $tmp_name = $_FILES['myFile']['tmp_name'];
		    
     $location = '../IMAGES/PRODUCTS/';
		
		if(file_exists($location.$fileName)) {
			 chmod($location.$fileName, 0777);
  	 				 unlink($location.$fileName);
  	 	}
    	move_uploaded_file($tmp_name, $location.$fileName);
	    
	}

	echo '<meta http-equiv="refresh" content="0;url=edit_stock.php?msg=success">';

	
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
							<li><a href="stock.php?q=add">Add Stock</a></li>
							<li><a href="stock.php?q=edit">Edit Stock</a></li>
					</div>
					
				</div>
				
				<div id="admin_nav">
					<a class="tab_admin"  href="../logout.php">Sign Out</a>
					<a class="tab_admin"  href="index.php">Home</a>
				</div>
				<div id="admin_view_window">
				
				<?php echo'<div class="account_edit_box">
							 		<div class="account_edit_box_title">
											<h3 style="margin:0;">Edit Stock Item Details</h3>							 		
							 		</div>';
							 	if(isset($_GET['msg']) && $_GET['msg'] == "success") {
							 		echo '<h2 style="color:green;">Stock Item Successfully Updated</h2>';
									echo '<a href="index.php"><button type="button" class="btn btn-default" style="width: 200px; height: 50px; font-size: 1.2em; margin-top:25px;">Admin Panel</button></a>';
							 	}
							 	else{
									include("../FORMS/admin_edit_stock_form.php");	
								}
								echo '</div>';	 ?>		
				
				</div>	
								
				</div><!--END contentWrapper-->			
				
			</div><!--END mainWrapper-->
			
		</div>
		
		
	</body>
	
</html>