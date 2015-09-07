<form name="admin_search_stock" id="admin_search_stock" class="form-horizontal" role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

<div class="form-group">
<label for product class="control-lable col-xs-2" align="right" style="line-height: 30px;">Select Product<span style="color:red;"> *</span></label>
<div class="col-xs-5">
<select name="product" id="product" class="form-control">
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

<input type="submit" name="findProduct" id="findProductBtn" class="btn btn-primary" value="Select" style="width: 125px; float:left; margin-left: 167px; margin-top: 10px;">

</form>