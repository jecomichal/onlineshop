<?php 
ob_start();
?>

<?php
session_start();
include("../CONFIG/connect_to_mysql.php");

$itemToChange = $_REQUEST['sid'];
$newSize = $_REQUEST['size'];
$newColor = $_REQUEST['color'];
$newQty = $_REQUEST['qty'];

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

$cartOutput = "";
$cartTotal = 0;


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
									<form class="form-horizontal" name="quantityToggle" onkeypress="return event.keyCode != 13;" id="quantityToggle" role="form" action="cart.php" method="POST">
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
		
	if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { 
	
			$cartOutput .=	'<table class="cart-table" cellpadding="10" cellspacing="10">
				<tr>
				<td><a href="cart.php?q=empty"><button class="btn btn-default">Empty Cart</button></a></td>
					<td>
						<div id="cartTotal">
						<p>Sub total</p>
							&euro;'. number_format((float)$_SESSION['user_cart_total'], 2, '.', '') .'
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
				</table>';
	}	
	
	echo $cartOutput;
?>

<?php 
ob_end_flush();
?>