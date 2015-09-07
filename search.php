<?php
session_start();
require("CONFIG/connect_to_mysql.php");
if(isset($_GET['search'])) {
	
	if(!empty($_GET['search'])) {		
		$q = strtolower(str_replace("+"," ",$_GET['search']));
		$searchContent = "";
		$sql = "SELECT * FROM Product WHERE title LIKE '%$q%' OR brand LIKE '%$q%' OR description LIKE '%$q%'";
		
		$rs = $db->query($sql);
		
		if($rs->num_rows > 0) {
			
			
			while($row = $rs->fetch_assoc()) {
			$id = $row['product_id'];
			$title = $row['title'];
			$price = $row['price'];
			
			$searchContent .= '<table border=0 class="latestContentTable">
										<tr>
											<td><a href="product.php?id=' . $id . '"><img src="IMAGES/PRODUCTS/' . $id . '.jpg" width="170" height="170"></a></td>
										</tr>
											
										<tr>
											<td><p class="productTitle">' . ucwords($title) . '</p></td>
										</tr>
										
										<tr>
											<td><p class="productPrice">€' . $price . '</p></td>
										</tr>
										
										</table>';
			}
		}
		
		else {
			$searchContent = '<p>No products found</p>';
		}
	}
	
	else {
		$searchContent = '<p>No products found</p>';
	}
}
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>Search</title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<div align="center" id="mainWrapper">
		
		<?php include("TEMPLATES/header.php"); ?>
				
			<div id="contentWrapper" style="min-height:650px;height:auto; overflow: hidden">
				<div id="searchResultBox">
				
					<div class="bannerTitle">
						<p>Search Results</p>
					</div>
					
					<?php echo $searchContent; ?>
				</div>
				
			</div><!--END contentWrapper-->
			
		</div><!--END mainWrapper-->
		
		<?php include("TEMPLATES/footer.php"); ?>
		
	</body>
	
</html>


