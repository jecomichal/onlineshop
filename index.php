<?php 
	session_start();
?>

<?php
	require("CONFIG/connect_to_mysql.php");
?>

<?php
	$latestContent = "";
	$sql = "SELECT * FROM Product WHERE available = 1 ORDER BY date_added DESC LIMIT 10";
	$rs = $db->query($sql);
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$id = $row['product_id'];
			$title = $row['title'];
			$price = $row['price'];
			
			$latestContent .= '<table border=0 class="latestContentTable">
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

<?php
	$featuredContent = "";
	$sql = "SELECT * FROM Product WHERE available = 1 AND featured = 1 ORDER BY date_added DESC LIMIT 5";
	$rs = $db->query($sql);
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$id = $row['product_id'];
			$title = $row['title'];
			$price = $row['price'];
			
			$featuredContent .= '<table border=0 class="latestContentTable">
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
		<title>	</title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	</head>
	<body>
		
		<div align="center" id="mainWrapper">
		
				<?php
					include("TEMPLATES/header.php");
				?>
			
			<div id="contentWrapperTop">
			
						<div class="bannerTitle">
							<p>Latest Products</p>
						</div>
					
						<div id="latestProductsList">
		
							<?php echo $latestContent;?>
						 
						</div>	
					</div><!--END contentWrapperTop-->		
						
					<div id="contentWrapperBot">
					
						<div class="bannerTitle" style="line-height: 30px;">
								<p>Featured Products</p>
						</div>
						
						<div id="featuredList">
							<?php echo $featuredContent; ?>
						</div>	
					
					</div>

			
			</div><!--END mainWrapper-->
			
		<?php include("TEMPLATES/footer.php"); ?>
	</body>
	
</html>