<form name="admin_search_stock" id="admin_add_stock" class="form-horizontal" role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" style="margin-top:25px;" enctype="multipart/form-data">

<div class="form-group">
<label for product class="control-lable col-xs-4" align="right" style="line-height: 30px;">Select Product<span style="color:red;"> *</span></label>
<div class="col-xs-5">
<select name="product" id="product" class="form-control" onchange="GetSizes()">
<option value="-" disabled selected>Select One</option>
<optgroup label="Footwear">
<?php
	$sql = "SELECT product_id,title FROM Product WHERE category_id = (SELECT category_id FROM Category WHERE name = 'footwear')";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				echo '<option value=' . $row['product_id'] . '>' .   ucwords($row['title']) . '</option>';
			}	
			
		}
	}
?>
</optgroup>
<optgroup label="Clothing">
<?php
	$sql = "SELECT product_id,title FROM Product WHERE category_id = (SELECT category_id FROM Category WHERE name = 'clothing')";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				echo '<option value=' . $row['product_id'] . '>' .  ucwords($row['title']) . '</option>';
			}	
			
		}
	}
?>
</optgroup>
<optgroup label="Accessories">
<?php
	$sql = "SELECT product_id,title FROM Product WHERE category_id = (SELECT category_id FROM Category WHERE name = 'accessories')";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				echo '<option value=' . $row['product_id'] . '>' .   ucwords($row['title']) . '</option>';
			}	
			
		}
	}
?>
</optgroup>
</select>
</div>
</div>

<div class="form-group">
<label for size class="control-lable col-xs-4" align="right" style="line-height: 30px;">Size<span style="color:red;"> *</span></label>
<div class="col-xs-3">
<div id="dynamicSize">
<select name="size" id="size" class="form-control">
<option value="-">First select product</option>
</select>
</div>
</div>
</div>

<div class="form-group">
<label for color class="control-lable col-xs-4" align="right" style="line-height: 30px;">Color<span style="color:red;"> *</span></label>
<div class="col-xs-3">
<select name="color" id="color" class="form-control">

<?php
	$sql = "SELECT * FROM Colors";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				echo '<option value=' . $row['color_id'] . '>' .   ucwords($row['name']) . '</option>';
			}	
			
		}
	}
?>

</select>
</div>
</div>

<div class="form-group">
<label for myFile class="control-label col-xs-4">Image:<span style="color:red;"> *</span></label>
<div class="col-xs-5">
<input type="file" name="myFile" id="myFile" class="form-control">
</div>
</div>

<div class="form-group">
<label for qty class="control-label col-xs-4">Quantity<span style="color:red;"> *</span></label>
<div class="col-xs-3">
<input type="number" name="qty" id="qty" min="1" max="10000" step="1" value="1" class="form-control">
</div>
</div>

<!--<input type="hidden" name="productID" value="<?php echo $pid ?>">-->

<button type="submit" name="addStock" id="AddStocktBtn" class="btn btn-success" style="width: 125px; float:left; margin-left: 245px;">Add</button>
<a href="stock.php"><button type="button" class="btn btn-danger" style="width: 125px; float:left; margin-left: 30px;">Cancel</button></a>
</form>