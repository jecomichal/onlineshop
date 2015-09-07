<?php
session_start();
require("CONFIG/connect_to_mysql.php");

$productList = "No Products Found";
?>

<?php
//Only type is Set
if(isset($_GET['type']) && !empty($_GET['type'])) {
		
		$productList = "";
		$type = $_GET['type'];	

		$sql = "SELECT * FROM Product WHERE product_type_id = (SELECT product_type_id FROM ProductType WHERE name = '$type') ORDER BY date_added DESC LIMIT 12";
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['product_id'];
				$title = $row['title'];
				$price = $row['price'];
				
				$productList .= '<table border=0 class="latestContentTable" style="width:21%;">
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
}
//Type + gender
if(isset($_GET['type']) && isset($_GET['gender'])) {
	$productList = "";
		$type = $_GET['type'];	
		$gender = $_GET['gender'];

		$sql = "SELECT * FROM Product WHERE product_type_id = (SELECT product_type_id FROM ProductType WHERE name = '$type') AND gender = '$gender' ORDER BY date_added DESC LIMIT 12";
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['product_id'];
				$title = $row['title'];
				$price = $row['price'];
				
				$productList .= '<table border=0 class="latestContentTable" style="width:21%;">
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
}
//Type + size
if(isset($_GET['type']) && isset($_GET['size'])) {
	$productList = "";
		$type = $_GET['type'];	
		$size = $_GET['size'];

		$sql = "SELECT Product.* , Stock.* 
				 FROM Product, Stock
				 WHERE Product.product_type_id = (SELECT product_type_id FROM ProductType WHERE name = '$type')
				 	AND Stock.product_id = Product.product_id AND Stock.size_id = (SELECT size_id FROM Sizes WHERE measurement = '$size') AND Stock.quantity > 0
				 GROUP BY Product.product_id
				 ORDER BY date_added DESC LIMIT 12";
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['product_id'];
				$title = $row['title'];
				$price = $row['price'];
				
				$productList .= '<table border=0 class="latestContentTable" style="width:21%;">
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
}
//Type + color
if(isset($_GET['type']) && isset($_GET['color'])) {
	$productList = "";
		$type = $_GET['type'];	
		$color = $_GET['color'];

		$sql = "SELECT Product.* , Stock.* 
				 FROM Product, Stock
				 WHERE Product.product_type_id = (SELECT product_type_id FROM ProductType WHERE name = '$type')
				 	AND Stock.product_id = Product.product_id AND Stock.color_id = (SELECT color_id FROM Colors WHERE name = '$color') AND Stock.quantity > 0
				 GROUP BY Product.product_id
				 ORDER BY date_added DESC LIMIT 12";
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['product_id'];
				$title = $row['title'];
				$price = $row['price'];
				
				$productList .= '<table border=0 class="latestContentTable" style="width:21%;">
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
}
//Type + gender + size
if(isset($_GET['type']) && isset($_GET['gender']) && isset($_GET['size'])) {
	$productList = "";
		$type = $_GET['type'];	
		$gender = $_GET['gender'];
		$size = $_GET['size'];

		$sql = "SELECT Product.* , Stock.* 
				 FROM Product, Stock
				 WHERE Product.product_type_id = (SELECT product_type_id FROM ProductType WHERE name = '$type') AND Product.gender = '$gender' 
				 	AND Stock.product_id = Product.product_id AND Stock.size_id = (SELECT size_id FROM Sizes WHERE measurement = '$size') AND Stock.quantity > 0
				 GROUP BY Product.product_id
				 ORDER BY date_added DESC LIMIT 12";
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['product_id'];
				$title = $row['title'];
				$price = $row['price'];
				
				$productList .= '<table border=0 class="latestContentTable" style="width:21%;">
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
}

//Type + gender + color
if(isset($_GET['type']) && isset($_GET['gender']) && isset($_GET['color'])) {
	$productList = "";
		$type = $_GET['type'];	
		$gender = $_GET['gender'];
		$color = $_GET['color'];

		$sql = "SELECT Product.* , Stock.* 
				 FROM Product, Stock
				 WHERE Product.product_type_id = (SELECT product_type_id FROM ProductType WHERE name = '$type') AND Product.gender = '$gender' 
				 	AND Stock.product_id = Product.product_id AND Stock.color_id = (SELECT color_id FROM Colors WHERE name = '$color') AND Stock.quantity > 0
				 GROUP BY Product.product_id
				 ORDER BY date_added DESC LIMIT 12";
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['product_id'];
				$title = $row['title'];
				$price = $row['price'];
				
				$productList .= '<table border=0 class="latestContentTable" style="width:21%;">
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
}

//Type + size + color
if(isset($_GET['type']) && isset($_GET['size']) && isset($_GET['color'])) {
	$productList = "";
		$type = $_GET['type'];	
		$size = $_GET['size'];
		$color = $_GET['color'];

		$sql = "SELECT Product.* , Stock.* 
				 FROM Product, Stock
				 WHERE Product.product_type_id = (SELECT product_type_id FROM ProductType WHERE name = '$type') AND Stock.size_id = (SELECT size_id FROM Sizes WHERE measurement = '$size')
				 	AND Stock.product_id = Product.product_id AND Stock.color_id = (SELECT color_id FROM Colors WHERE name = '$color') AND Stock.quantity > 0
				 GROUP BY Product.product_id
				 ORDER BY date_added DESC LIMIT 12";
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['product_id'];
				$title = $row['title'];
				$price = $row['price'];
				
				$productList .= '<table border=0 class="latestContentTable" style="width:21%;">
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
}

//Type +gender + size + color
if(isset($_GET['type']) && isset($_GET['gender']) && isset($_GET['color']) && isset($_GET['size'])) {
	$productList = "";
		$type = $_GET['type'];	
		$gender = $_GET['gender'];
		$size = $_GET['size'];
		$color = $_GET['color'];

		$sql = "SELECT Product.* , Stock.* 
				 FROM Product, Stock
				 WHERE Product.product_type_id = (SELECT product_type_id FROM ProductType WHERE name = '$type') AND Product.gender = '$gender' AND Stock.size_id = (SELECT size_id FROM Sizes WHERE measurement = '$size')
				 	AND Stock.product_id = Product.product_id AND Stock.color_id = (SELECT color_id FROM Colors WHERE name = '$color') AND Stock.quantity > 0
				 GROUP BY Product.product_id
				 ORDER BY date_added DESC LIMIT 12";
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$id = $row['product_id'];
				$title = $row['title'];
				$price = $row['price'];
				
				$productList .= '<table border=0 class="latestContentTable" style="width:21%;">
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
}
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title><?php echo ucwords($_GET['type']); ?></title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<div align="center" id="mainWrapper">
		
		<?php include("TEMPLATES/header.php"); ?>
				
			<div id="contentWrapper" style="min-height:650px;height:auto; overflow: hidden; padding:0; margin-top: 3px;">
				<div id="sidebarWrapper">
					
					<div id="subcategory_sidebar">
					
						<?php if(isset($_GET['cat']) && $_GET['cat'] == "footwear") { ?>
						<ul>
							<li><a href="product_list.php?type=boots">Boots</a></li>
							<li><a href="product_list.php?type=canvas">Canvas Shoes</a></li>
							<li><a href="product_list.php?type=hitops">Hi Tops</a></li>
							<li><a href="product_list.php?type=reebok classic">Reebok Classic</a></li>
							<li><a href="product_list.php?type=runners">Runners</a></li>
							<li><a href="product_list.php?type=shoes">Shoes</a></li>
							<li><a href="product_list.php?type=skate">Skate Shoes</a></li>
						</ul>
						<?php } ?>
						
						<?php if(isset($_GET['cat']) && $_GET['cat'] == "clothing") { ?>
						<ul>
							<li><a href="product_list.php?type=chinos">Chinos</a></li>
							<li><a href="product_list.php?type=hoodies">Hoodies</a></li>
							<li><a href="product_list.php?type=jackets">Jackets</a></li>
							<li><a href="product_list.php?type=jeans">Jeans</a></li>
							<li><a href="product_list.php?type=shirts">Shirts</a></li>
							<li><a href="product_list.php?type=sweatpants">Sweatpants</a></li>
							<li><a href="product_list.php?type=vests">Vests</a></li>
						</ul>
						<?php } ?>
						
						<?php if(isset($_GET['cat']) && $_GET['cat'] == "accessories") { ?>
						<ul>
							<li><a href="product_list.php?type=backpacks">Backpacks</a></li>
							<li><a href="product_list.php?type=belts">Belts</a></li>
							<li><a href="product_list.php?type=capshats">Caps & Hats</a></li>
							<li><a href="product_list.php?type=walletspurses">Wallets & Purses</a></li>
							<li><a href="product_list.php?type=watches">Watches</a></li>
						</ul>
						<?php } ?>
						
						<?php if(isset($_GET['type']) && !empty($_GET['type']) ) {
						echo '<ul>';
							
							
							if(!isset($_GET['gender'])) {							
							
							
					echo'	<li class="filter_title" style="margin-top: 0;">Gender</li>
							<li><a href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&gender=male">Mens</a></li>
							<li><a href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&gender=female">Ladies</a></li>
							<li><a href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&gender=unisex">Unisex</a></li>';
							
							}
							
								$type = $_GET['type'];
								$sql = "SELECT category_id FROM ProductType WHERE name = '$type'";
								$rs = $db->query($sql);
								if($rs === false) {
									
								}						
								else {
									if($rs->num_rows > 0) {
										while($row = $rs->fetch_assoc()) {
												$catID = $row['category_id'];
										}
									}	
								}	
							?>
							
							<?php if($catID == 1) { 
							
								if(!isset($_GET['size'])) {
								echo'	
								<li class="filter_title">Size</li>
								<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666; border-right: 1px solid #666;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=6">6</a></li>
								<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666; border-right: 1px solid #666;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=6.5">6.5</a></li>
								<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=7">7</a></li>
								<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=7.5">7.5</a></li>
								<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=8">8</a></li>
								<li style="width:33.333%;"><a class="size_filter" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=8.5">8.5</a></li>
								<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=9">9</a></li>
								<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=9.5">9.5</a></li>
								<li style="width:33.333%;"><a class="size_filter" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=10">10</a></li>';
								}
							
							 } ?>
							
							<?php if($catID == 2) { 
							
								if(!isset($_GET['size'])) {
									echo'
									<li class="filter_title">Size</li>
									<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666; border-right: 1px solid #666;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=XS">XS</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666; border-right: 1px solid #666;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=S">S</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=M">M</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=L">L</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=XL">XL</a></li>
									<li style="width:33.333%;"><a class="size_filter" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=30">30</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=30 S">30 S</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=30 R">30 R</a></li>
									<li style="width:33.333%;"><a class="size_filter" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=30 L">30 L</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=31">31</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=31 R">31 R</a></li>
									<li style="width:33.333%;"><a class="size_filter" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=31 L">31 L</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=32">32</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=32 S">32 S</a></li>
									<li style="width:33.333%;"><a class="size_filter" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=32 R">32 R</a></li>
									<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&size=32 L">32 L</a></li>
									
									';
								}
							} ?>
							
							<?php if(!isset($_GET['color'])) {
							
							echo'<li class="filter_title">Color</li>
							<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666; border-right: 1px solid #666; background-color: #000;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=black"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666; border-right: 1px solid #666; background-color: #0000FF;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=blue"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-top: 1px solid #666; background-color: #A52A2A;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=brown"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #36454f;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=charcoal"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #1560BD;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=denim"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="background-color: #808080;" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=gray"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #008000;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=green"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #000080;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=navy"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #800080;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=purple"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #FF3300;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=orange"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #FFFF00;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=yellow"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #FF0000;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=red"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background-color: #fff;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=white"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="border-right: 1px solid #666; background: #db2bbb;
background: -moz-linear-gradient(left,  #db2bbb 0%, #f1f424 100%);
background: -webkit-gradient(linear, left top, right top, color-stop(0%,#db2bbb), color-stop(100%,#f1f424));
background: -webkit-linear-gradient(left,  #db2bbb 0%,#f1f424 100%);
background: -o-linear-gradient(left,  #db2bbb 0%,#f1f424 100%);
background: -ms-linear-gradient(left,  #db2bbb 0%,#f1f424 100%);
background: linear-gradient(to right,  #db2bbb 0%,#f1f424 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#db2bbb", endColorstr="#f1f424",GradientType=1 );
" href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=multi"></a></li>
							<li style="width:33.333%;"><a class="size_filter" style="background-color: #FF69B4;"href="http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '&color=pink"></a></li>
';
							
							} ?>
						</ul>
						<?php } ?>
					</div>
					
					<!--<div id="sidebarBottom">
					
					</div>-->

				</div>
				
				<div id="latestFromCat">
				<?php if(isset($_GET['type']) && !empty($_GET['type'])) {
					
					$gender = isset($_GET['gender']) ? $_GET['gender'] : "All";
					$size = isset($_GET['size']) ? $_GET['size'] : "All";
					$color = isset($_GET['color']) ? $_GET['color'] : "All";
					
					echo '<div class="bannerTitle" style="width:auto;">';
							echo '<p style="width:auto;">' . ucwords($type) . ' ||	 Gender: ' . ucwords($gender) . ' - Size: ' . ucwords($size) . ' - Color: ' . ucwords($color) . '</p>';
						echo '</div>';
				 }
				echo '<br/>';
					 echo $productList;			
				echo '</div>';
				?>
				
				
			</div><!--END contentWrapper-->
			
			
			
		</div><!--END mainWrapper-->
		
	<?php include("TEMPLATES/footer.php"); ?>
		
	</body>
	
</html>