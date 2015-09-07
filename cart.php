<?php
ob_start();
session_start();
require("CONFIG/connect_to_mysql.php");

?>

<?php
if(isset($_GET['q']) && $_GET['q'] == 'empty') {
	unset($_SESSION['cart']);
	$user_cart = "";
	$user_cart .= $_SESSION['user_id'];
	$user_cart .= '-cart';
	setcookie($user_cart, "blank", time()-10000);				
}
?>

<!--<?php
if(isset($_POST['changeQty'])) {
	
	$itemToChange = $_POST['itemToChange'];
	$newSize = $_POST['newSize'];
	$newColor = $_POST['newColor'];
	$newQty = $_POST['changeQty'];
	$i = 0;

	$newQty = preg_replace('#[^0-9]#i', '', $newQty);
	if ($newQty >= 100) { $newQty = 99; }
	if ($newQty < 1) {$newQty = 1; }
	if ($newQty == "") { $newQty = 1; }
	
	foreach($_SESSION['cart'] as $each_product){
		$i++;
		while(list($key,$val) = each($each_product)) {
			if($key == "item_id" && $val == $itemToChange) {
				array_splice($_SESSION['cart'], $i-1, 1, array(array("item_id" => $itemToChange, "item_size" => $newSize, "item_color" => $newColor, "item_qty" => $newQty)));
				//update cookie file
				$user_cart = "";
				$user_cart .= $_SESSION['user_id'];
				$user_cart .= '-cart';
				
				$saveCart = $_SESSION['cart'];
				$saveCart = json_encode($saveCart);
				setcookie($user_cart, $saveCart, time()+86400);			
			}
			
		}
	}
	echo '<meta http-equiv="refresh" content="0;url=cart.php">';
	exit();
}
?>-->

<?php
if(isset($_POST['removeItem'])) {
	
	$removeKey = $_POST['itemToRemove'];
	
	if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
		if(count($_SESSION['cart']) <= 1) {
		unset($_SESSION['cart']);
		}
		
		else {
			unset($_SESSION["cart"]["$removeKey"]);
			sort($_SESSION['cart']);
			
			//update cookie file
			$user_cart = "";
			$user_cart .= $_SESSION['user_id'];
			$user_cart .= '-cart';
			
			$saveCart = $_SESSION['cart'];
			$saveCart = json_encode($saveCart);
			setcookie($user_cart, $saveCart, time()+86400);				
		}
	}
}
?>

<?php
if(isset($_POST['addToCart'])) {
	//Collect form data
	$pid = $_POST['productID'];
	$stockID;
	$sizeID = $_POST['size'];
	$colorID = $_POST['color'];
	$qty = $_POST['qty'];
	$size = "";
	$color = "";
   $qtyInStock = 0;
	
	$sameID = false;
	$sameSize = false;
	$sameColor = false;
	$itemFound = false;
	$i = 0;	
	
	$sql = "SELECT quantity FROM Stock WHERE product_id = '$pid' AND size_id = '$sizeID' AND color_id = '$colorID' LIMIT 1";
	$rs = $db->query($sql);
	
	if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				$qtyInStock = $row['quantity'];
			}
			if($qtyInStock == 0 ) {
				echo '<meta http-equiv="refresh" content="0;url=product.php?id='.$pid.'&nostock=1">';
				exit();
			}
			elseif($qty > $qtyInStock) {
				echo '<meta http-equiv="refresh" content="0;url=product.php?id='.$pid.'&nostock=2">';
				exit();
			}
		}
	}
	
	//Get Stock Item
	$sql = "SELECT stock_id FROM Stock WHERE product_id = '$pid' AND size_id = '$sizeID' AND color_id = '$colorID'";
	$rs = $db->query($sql);
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$stockID = $row['stock_id'];
		}
	}	
	
	//Get size and color strings from DB
	$sql = "SELECT measurement FROM Sizes
				WHERE size_id = '$sizeID'";
	$rs = $db->query($sql);
	
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$size = $row['measurement'];
		}
	}
	
	$sql = "SELECT name FROM Colors
				WHERE color_id = '$colorID'";
	$rs = $db->query($sql);
	
	if($rs->num_rows > 0) {
		while($row = $rs->fetch_assoc()) {
			$color = $row['name'];
		}
	}
	
	//If cart empty or session not set
	
	if(!isset($_SESSION['cart']) || count($_SESSION['cart']) < 1) {
		$_SESSION['cart'] = array(0 => array("item_id" => $stockID, "item_size" => $size, "item_color" => $color, "item_qty" => $qty));
		//update cookie file
		$user_cart = "";
		$user_cart .= $_SESSION['user_id'];
		$user_cart .= '-cart';
		
		$saveCart = $_SESSION['cart'];
		$saveCart = json_encode($saveCart);
		setcookie($user_cart, $saveCart, time()+86400);				
	}
	
	else {
		foreach($_SESSION['cart'] as $each_product){
			$i++;
			while(list($key, $val) = each($each_product)) {
				if($key == "item_id" && $val == $stockID) {$sameID = true;}
				if($key == "item_size" && $val === $size) {$sameSize = true;}
				if($key == "item_color" && $val === $color) {$sameColor = true;}	
			}
			
			if($sameID === true && $sameSize === true && $sameColor === true) {
				array_splice($_SESSION['cart'], $i-1, 1, array(array("item_id" => $stockID, "item_size" => $size, "item_color" => $color, "item_qty" => $each_product['item_qty']+$qty)));
				$itemFound = true;
				
				//update cookie file
				$user_cart = "";
				$user_cart .= $_SESSION['user_id'];
				$user_cart .= '-cart';
				
				$saveCart = $_SESSION['cart'];
				$saveCart = json_encode($saveCart);
				setcookie($user_cart, $saveCart, time()+86400);					
				
			}
			
		
			$sameID = false;
			$sameSize = false;
			$sameColor = false;
			
			
		}
			
		
		if($itemFound === false) {
			array_push($_SESSION['cart'],  array("item_id" => $stockID, "item_size" => $size, "item_color" => $color, "item_qty" => $qty));
			//update cookie file
			$user_cart = "";
			$user_cart .= $_SESSION['user_id'];
			$user_cart .= '-cart';
			
			$saveCart = $_SESSION['cart'];
			$saveCart = json_encode($saveCart);
			setcookie($user_cart, $saveCart, time()+86400);					
		}
	}
	echo '<meta http-equiv="refresh" content="0;url=cart.php">';
	exit();
}
?>

<?php
$cartOutput = "";
$cartTotal = 0;
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) < 1) {
	$cartOutput = '<h2 align="center">Shopping Cart is Empty</h2>';
}

else {
	$i = 0;
	$cartOutput = '<table border="0" class="table-condensed table table-hover"';
	$cartOutput .= '<tr>
						  	</th style="font-weight: bold;">
						  		<td></td>
						  		<td><strong>Title</strong></td>
								<td><strong>Size</strong></td>
								<td><strong>Color</strong></td>
								<td><strong>Quantity</strong></td>
								<td><strong>Unit Price</strong></td>
								<td><strong>Total</strong></td>
								<td></td>
						  	</th>
						  </tr>
								';
	$_SESSION['user_cart_total'] = 0;
	foreach($_SESSION['cart'] as $each_product){
		$stockID = $each_product['item_id'];
		$sql = "SELECT product_id, title, price FROM Product WHERE product_id = (SELECT product_id FROM Stock WHERE stock_id = '$stockID')";
		$rs = $db->query($sql);
		if($rs->num_rows > 0) {
			while($row = $rs->fetch_assoc()) {
				$productTitle = $row['title'];
				$price = $row['price'];
				$pid = $row['product_id'];
			}
		}
		
		$colorID;
	 	$searchColor = $each_product['item_color'];
		$sql = "SELECT color_id FROM Colors WHERE name = '$searchColor'";
		$rs = $db->query($sql);
		if($rs->num_rows > 0) {
			while($row = $rs->fetch_assoc()) {
				$colorID = $row['color_id'];
			}
		}		
		
				
		$cartTotal += ($price*$each_product['item_qty']);
		
		$cartOutput .= '<tr>
							  <td><img src="IMAGES/PRODUCTS/'.$pid.'-'.$colorID.'.jpg" width="75" height="75"></td>
							  <td>'. ucwords($productTitle) .'</td>
								<td>'.$each_product['item_size'].'</td>
								<td>'. ucfirst($each_product['item_color']).'</td>
								<td>
									<form class="form-horizontal" name="quantityToggle" id="quantityToggle" onkeypress="return event.keyCode != 13;" role="form" action="cart.php" method="POST">
										<input type="hidden" name="itemToChange" id="itemToChange'.$i.'" value="'.$stockID.'">
										<input type="hidden" name="newSize" id="newSize'.$i.'" value="'.$each_product['item_size'].'">
										<input type="hidden" name="newColor" id="newColor'.$i.'" value="'.$each_product['item_color'].'">
										<div class="col-xs-7">
										<input type="number" name="changeQty" id="newQty'.$i.'" class="form-control" min="1" max="99" step="1" value="'.$each_product['item_qty'].'" onchange="ChangeQty()">
										</div>
									</form>								
								</td>
								<td>&euro;'.$price.'</td>
								<td>&euro;'. number_format((float)$price*$each_product['item_qty'], 2, '.', '').'</td>
								<td>
									<form action="cart.php" method="POST">
										<input type="hidden" name="itemToRemove" value="'.$i.'">
										<input type="submit" name="removeItem" class="btn btn-danger" value="Remove" style="width:75px;">
									</form>
								</td>
							  </tr>	
		';
		$i++;	
	}
	$cartOutput .= '</table>';
	$_SESSION['user_cart_total'] = $cartTotal;
}
ob_end_flush();
?>

<!DOCTYPE HTML>
<html>

	<head>
		<title>Shopping Cart</title>
	<link rel="stylesheet" type="text/css" href="CSS/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="JS/myScripts.js"></script>
	</head>
	
	<body>
		<div align="center" id="mainWrapper">
		
		<?php include("TEMPLATES/header.php"); ?>
				
			<div id="contentWrapper" style="min-height:650px;height:auto; overflow: hidden">
				<div class="bannerTitle" style="height:50px">
					<p>Your Shopping Cart</p>
				</div>
				<br/><br/><br/>
				<div id="cartOutputBox">
					<?php echo $cartOutput; ?>
				
				
				<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
				<table class="cart-table" cellpadding="10" cellspacing="10">
				<tr>
				<td><a href="cart.php?q=empty"><button class="btn btn-default">Empty Cart</button></a></td>
					<td>
						<div id="cartTotal">
						<p>Sub total</p>
						<?php echo '&euro;'. number_format((float)$_SESSION['user_cart_total'], 2, '.', '') .'';?>
						</div>
					</td>
				</tr>
				<tr>
					
					<td colspan="2">			
						<form method="post" name="goToCheckout" action="checkout.php">
							<input type="submit" name="goToCheckoutBtn" class="btn btn-success" id="goToCheckoutBtn" value="Checkout">						
						</form>		
											
					</td>
				</tr>
				</table>
				<?php } ?>
				
			</div>
				
			</div><!--END contentWrapper-->
			
		</div><!--END mainWrapper-->
		
		<?php include("TEMPLATES/footer.php"); ?>
		
	</body>
	
</html>