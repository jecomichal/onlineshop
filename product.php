<?php
session_start();
require("CONFIG/connect_to_mysql.php");


$productExists = false;
?>

<?php
//Redirect back to home if ?id= is not set
if(!isset($_GET['id'])) {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
		exit();
}

?>

<?php
	if(isset($_GET['id'])) {
		$pid = $_GET['id'];
		
		//check if product exists in DB
		$sql = "SELECT * FROM Product WHERE product_id = '$pid'";
		$rs = $db->query($sql);
		if($rs->num_rows > 0) {
			$productExists = true;
		}		
		
		//Get Product Details
		if($productExists === true) {
			$sql = "SELECT title, brand, description, price FROM Product WHERE product_id = '$pid'";
			$rs = $db->query($sql);
			
			if($rs->num_rows > 0) {
				while($row = $rs->fetch_assoc()) {
					$productTitle = $row['title'];
					$productBrand = $row['brand'];
					$productDescription = $row['description'];
					$productPrice = $row['price'];
				}
			}
		}
	}
?>

<?php

	$id = $_GET['id'];
	$relatedContent = "";
	$sql = "SELECT * FROM Product WHERE available = 1 AND product_type_id = (SELECT product_type_id FROM Product WHERE product_id = '$id')
				AND product_id <> '$id' LIMIT 5";
	$rs = $db->query($sql);
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$id = $row['product_id'];
			$title = $row['title'];
			$price = $row['price'];
			
			$relatedContent .= '<table border=0 class="latestContentTable">
										<tr>
											<td><a href="product.php?id=' . $id . '"><img src="IMAGES/PRODUCTS/' . $id . '.jpg" width="170" height="170"></a></td>
										</tr>
											
										<tr>
											<td><p class="productTitle">' . ucwords($title) . '</p></td>
										</tr>
										
										<tr>
											<td><p class="productPrice">&euro;' . $price . '</p></td>
										</tr>
										
										</table>';
		}
	}
?>
<!DOCTYPE html>
<html>

	<head>
		<title><?php echo ucfirst($productBrand). ' - '. ucwords($productTitle);?></title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="JS/myScripts.js"></script>
	
	
	
	</head>
	
	<body>
		
		<div align="center" id="mainWrapper">
		
			<?php 
				include("TEMPLATES/header.php");
			?>
			
			<div id="contentWrapper">
			
				<?php
						if(isset($_GET['id'])) {
							if($productExists === true) {
							echo '<div id="productViewWrapper">
							
									
										<div id="productImageBox">
												<img src="IMAGES/PRODUCTS/'.$pid.'.jpg" class="product_img">
										</div>
										
										<div id="productOptionsBox">
											<div id="productTitleBox">
												<p>' . ucwords($productTitle) . '</p>
											</div>
											
											<div id="productPriceBox">
												<p class="productPrice" style="font-size:25px;">&euro;' . $productPrice . '</p>
											</div>
											
											<div id="stockCheckBox">
												
											</div>
											
											<div id="productOptions">';
												if(isset($_GET['nostock']) && $_GET['nostock'] == 1)
												{echo '<p style="color:crimson">Sorry we are out of stock on that item</p>';}
												elseif(isset($_GET['nostock']) && $_GET['nostock'] == 2)
												{echo '<p style="color:orange">Sorry we do not have that many in stock</p>';}
												echo '<form name="productOptionsForm" id="productOptionsForm" class="form-horizontal" role="form" method="POST" action="cart.php">
													<input type="hidden" name="productID" id="productID" value="'.$pid.'">
													<div class="form-group">
													<label for size class="control-lable col-xs-3" align="right" style="line-height: 30px;">Size<span style="color:red;"> *</span></label>
													<div class="col-xs-7" style="width: 62.952153845%;">
													<select name="size" id="size" class="form-control" onchange="GetMatchingColors()" style="width: 100%;">
													<option value="-" disabled selected>Please select one</option>	';										
													
														$sql = "SELECT Sizes.size_id, Sizes.measurement FROM Sizes,Stock
																	WHERE Stock.size_id = Sizes.size_id AND Stock.product_id = '$pid'
																	GROUP BY Stock.size_id";
														$rs = $db->query($sql);
														
														if($rs === false) {
															trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
														}
														
														else {
															if($rs->num_rows > 0) {
																
																while($row = $rs->fetch_assoc()) {
																	echo '<option value=' . $row['size_id'] . '>' .   ucwords($row['measurement']) . '</option>';
																}	
																
															}
														}
			
													echo '</select>
													</div>
													</div>
													
													<div class="form-group">
													<label for color class="control-lable col-xs-3" align="right" style="line-height: 30px;">Color<span style="color:red;"> *</span></label>
													<div class="col-xs-7" style="width: 62.952153845%;">
													<div id = "dynamicColors">
													<select name="color" id="color" class="form-control" style="width: 100%;">												
													<option value="-">First select size</option>';
														/* Code Generated by AJAX*/													
													echo '</select>
													</div>
													</div>
													</div>
													
													<div class="form-group">
													<label for qty class="control-label col-xs-3">Quantity<span style="color:red;"> *</span></label>
													<div class="col-xs-7" style="width: 62.952153845%;">
													<input type="number" name="qty" id="productQty" min="1" max="99" step="1" value="1" class="form-control" style="width: 100%;">
													</div>
													</div>
													<button type="submit" name="addToCart" id="addToCartBtn">Add to cart</button>
												</form>
											</div>
										</div>
										
										<div id="productInfoBox">
											<div class="quickbox_title_large" style="text-align: center; margin-bottom: 5%;">
												<h4 style="margin:0;">Product Description</h4>
											</div>
											<div id="descText" style="margin-left: 4%;">
											<p>' .  $productDescription . '</p>
											</div>
										</div>	
									</div>';
									
									echo '<div class="bannerTitle" style="height:50px;margin-top: 10%;">
												<p style="width:auto;">Products From Same Category</p>
											</div>									
									';
									
									echo '<div id="relatedBox">
												'.$relatedContent.'
											</div>									
									';
									
						}
						else {
							echo '<div id="productViewWrapper">
										<h1 style="font-size: 72px; margin-top: 50px; color:#d3d3d3;">Product not found</h1>
									</div>';
						}
					}
				
			
				
				?>

			</div><!--END mainWrapper-->
			
			<?php include("TEMPLATES/footer.php"); ?>
		</div>
		
	
	</body>
	
</html>

