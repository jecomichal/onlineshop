<?php
session_start();
require("CONFIG/connect_to_mysql.php");

$latestFromCat = "No Products Found";
?>

<?php
if(isset($_GET['cat']) && !empty($_GET['cat'])) {
	
	$cat = $_GET['cat'];
	$latestFromCat = "";
	$sql = "SELECT * FROM Product WHERE category_id = (SELECT category_id FROM Category WHERE name = '$cat') ORDER BY date_added DESC LIMIT 12";
	$rs = $db->query($sql);
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$id = $row['product_id'];
			$title = $row['title'];
			$price = $row['price'];
			
			$latestFromCat .= '<table border=0 class="latestContentTable" style="width:21%;">
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
		<title><?php echo ucfirst($_GET['cat']); ?></title>
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
						<p>Sub Categories</p>
						<?php if(isset($_GET['cat']) && $_GET['cat'] == "footwear") { ?>
						<ul>
							<li><a href="product_list.php?type=boots">Boots</a></li>
							<li><a href="product_list.php?type=canvas shoes">Canvas Shoes</a></li>
							<li><a href="product_list.php?type=hi tops">Hi Tops</a></li>
							<li><a href="product_list.php?type=reebok classic">Reebok Classic</a></li>
							<li><a href="product_list.php?type=runners">Runners</a></li>
							<li><a href="product_list.php?type=shoes">Shoes</a></li>
							<li><a href="product_list.php?type=skate shoes">Skate Shoes</a></li>
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
							<li><a href="product_list.php?type=caps hats">Caps & Hats</a></li>
							<li><a href="product_list.php?type=wallets purses">Wallets & Purses</a></li>
							<li><a href="product_list.php?type=watches">Watches</a></li>
						</ul>
						<?php } ?>
					</div>
					
					<!--<div id="sidebarBottom">
					
					</div>-->

				</div>
				
				<div id="latestFromCat">
				<?php if(isset($_GET['cat']) && !empty($_GET['cat'])) { ?>
					<div class="bannerTitle">
							<p>Newest from <?php echo ucfirst($cat);?></p>
						</div>
				<?php } ?>
				<br/>
					<?php echo $latestFromCat;?>
				</div>
				
			</div><!--END contentWrapper-->
			
		</div><!--END mainWrapper-->
		
		<?php include("TEMPLATES/footer.php"); ?>
		
	</body>
	
</html>