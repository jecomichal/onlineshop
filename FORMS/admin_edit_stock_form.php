<form name="admin_search_stock" id="admin_add_stock" class="form-horizontal" role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" style="margin-top:25px;" enctype="multipart/form-data">

<div class="form-group">
<label for stock class="control-lable col-xs-4" align="right" style="line-height: 30px;">Stock ID: </label>
<div class="col-xs-5">
<input type="text" name="stockID" id="stockID" value="<?php echo $sid; ?>" readonly="true" class="form-control">
</div>
</div>
<div class="form-group">
<label for product class="control-lable col-xs-4" align="right" style="line-height: 30px;">Product ID: </label>
<div class="col-xs-5">
<input type="text" name="productID" id="productID" value="<?php echo $pid; ?>" readonly="true" class="form-control">
</div>
</div>

<div class="form-group">
<label for size class="control-lable col-xs-4" align="right" style="line-height: 30px;">Size<span style="color:red;"> *</span></label>
<div class="col-xs-3">
<select name="size" id="size" class="form-control">
<?php
	$sql = "SELECT Sizes.measurement, Sizes.size_id, Sizes.category_id, Product.category_id, Product.product_id
			FROM Product, Sizes
			WHERE Product.product_id = '$pid' AND Product.category_id = Sizes.category_id";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				
				if($size == $row['measurement']){echo '<option value=' . $row['size_id'] . ' selected>' .   ucwords($row['measurement']) . '</option>';}
				else {echo '<option value=' . $row['size_id'] . '>' .   ucwords($row['measurement']) . '</option>';}
			}	
			
		}
	}
?>

</select>
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
				
				if(strtolower($color) == $row['name']){echo '<option value=' . $row['color_id'] . ' selected>' .   ucwords($row['name']) . '</option>';}
				else {echo '<option value=' . $row['color_id'] . '>' .   ucwords($row['name']) . '</option>';}
			}	
			
		}
	}
?>

</select>
</div>
</div>

<div class="form-group">
<label for myFile class="control-label col-xs-4">Image:</label>
<div class="col-xs-5">
<input type="file" name="myFile" id="myFile" class="form-control">
</div>
</div>

<div class="form-group">
<label for qty class="control-label col-xs-4">Quantity<span style="color:red;"> *</span></label>
<div class="col-xs-3">
<input type="number" name="qty" id="qty" min="0" max="10000" step="1" value="<?php echo $qty ?>" class="form-control">
</div>
</div>

<button type="submit" name="editStock" id="EditStocktBtn" class="btn btn-success" style="width: 125px; float:left; margin-left: 245px;">Update</button>
<a href="stock.php"><button type="button" class="btn btn-danger" style="width: 125px; float:left; margin-left: 30px;">Cancel</button></a>
</form>