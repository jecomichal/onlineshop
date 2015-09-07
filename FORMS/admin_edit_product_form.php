<?php
include("../CONFIG/connect_to_mysql.php");
?>

<form method="post" name="edit_product_form" id="edit_product_form" class="form-horizontal" action="" role="form" enctype="multipart/form-data" style="margin-top: 25px;">

<div class="form-group">
<label for pid class="control-label col-xs-3">Product ID:</label>
<div class="col-xs-6">
<input type="text" name="pid" id="pid" class="form-control" value="<?php echo $pid; ?>" readonly="true">
</div>
</div>
<div class="form-group">
<label for title class="control-label col-xs-3">Title<span style="color:red;"> *</span></label>
<div class="col-xs-6">
<input type="text" name="title" id="title" class="form-control" value="<?php echo $title; ?>">
<?php if(isset($_GET['msg']) && $_GET['msg'] == "duplicate" ) {
echo '<span class="help-block" style="color:crimson;">Product with that title is already in the system</span>'; }	
?>
</div>
</div>

<div class="form-group">
<label for desc class="control-label col-xs-3">Description<span style="color:red;"> *</span></label>
<div class="col-xs-6">
<textarea class="form-control" name="desc" id="desc" rows="5" style="resize:none;"><?php echo $desc; ?></textarea>
</div>
</div>

<div class="form-group">
<label for brand class="control-label col-xs-3">Brand<span style="color:red;" > *</span></label>
<div class="col-xs-6">
<input type="text" name="brand" id="brand" class="form-control" value="<?php echo $brand; ?>">
</div>
</div>

<div class="form-group">
<label for category class="control-lable col-xs-3" align="right">Category<span style="color:red;"> *</span></label>
<div class="col-xs-3">
<select name="category" id="category" class="form-control">
<?php
	$sql = "SELECT * FROM Category";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				if($cat === $row['name']) {
					echo '<option value=' . $row['category_id'] . ' selected >' .  ucfirst($row['name']) . '</option>';
				}
				else{
					echo '<option value=' . $row['category_id'] . '>' .  ucfirst($row['name']) . '</option>';
				}
			}	
			
		}
	}
?>
</select>
</div>
</div>

<div class="form-group">
<label for type class="control-lable col-xs-3" align="right">Product Type<span style="color:red;"> *</span></label>
<div class="col-xs-3">
<select name="type" id="type" class="form-control">
<optgroup label="Footwear">
<?php
	$sql = "SELECT * FROM ProductType WHERE category_id = (SELECT category_id FROM Category WHERE name = 'footwear')";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				if($type === $row['name']) {
					echo '<option value=' . $row['product_type_id'] . ' selected >' .  ucfirst($row['name']) . '</option>';
				}
				else {
					echo '<option value=' . $row['product_type_id'] . '>' .  ucfirst($row['name']) . '</option>';
				}
			}	
			
		}
	}
?>
</optgroup>
<optgroup label="Clothing">
<?php
	$sql = "SELECT * FROM ProductType WHERE category_id = (SELECT category_id FROM Category WHERE name = 'clothing')";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				if($type === $row['name']) {
					echo '<option value=' . $row['product_type_id'] . ' selected >' .  ucfirst($row['name']) . '</option>';
				}
				else {
					echo '<option value=' . $row['product_type_id'] . '>' .  ucfirst($row['name']) . '</option>';
				}
			}	
			
		}
	}
?>
</optgroup>
<optgroup label="Accessories">
<?php
	$sql = "SELECT * FROM ProductType WHERE category_id = (SELECT category_id FROM Category WHERE name = 'accessories')";
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		if($rs->num_rows > 0) {
			
			while($row = $rs->fetch_assoc()) {
				if($type === $row['name']) {
					echo '<option value=' . $row['product_type_id'] . ' selected >' .  ucfirst($row['name']) . '</option>';
				}
				else {
					echo '<option value=' . $row['product_type_id'] . '>' .  ucfirst($row['name']) . '</option>';
				}
			}	
			
		}
	}
?>
</optgroup>
</select>
</div>
</div>

<div class="form-group">
<label for gender class="control-lable col-xs-3" align="right">Gender<span style="color:red;"> *</span></label>
<div class="col-xs-3">
<select name="gender" id="gender" class="form-control">
<option value="male" <?php if($gender == "male"){echo 'selected';} ?> >Male</option>
<option value="female" <?php if($gender == "female"){echo 'selected';} ?> >Female</option>
<option value="unisex" <?php if($gender == "unisex"){echo 'selected';} ?> >Unisex</option>
</select>
</div>
</div>

<div class="form-group">
<label for myFile class="control-label col-xs-3">Default Image:</label>
<div class="col-xs-5">
<input type="file" name="myFile" id="myFile" class="form-control">
</div>
</div>

<div class="form-group">
<label for price class="control-label col-xs-3">Price<span style="color:red;"> *</span></label>
<div class="col-xs-2">
<input type="text" name="price" id="price" class="form-control" maxlength="7" value="<?php echo $price; ?>">
</div>
</div>

<div class="form-group">
<label for avail class="control-label col-xs-3">Available:</label>
<div class="col-xs-2">
<input type="text" name="avail" id="avail" class="form-control" value="<?php echo $avail; ?>" readonly="true">
</div>
</div>

<button type="submit" name="updateProduct" id="updateProductBtn" class="btn btn-success" style="width: 125px; float:left; margin-left: 185px; margin-bottom: 50px;">Update</button>
<a href="products.php"><button type="button" class="btn btn-danger" style="width: 125px; float:left; margin-left: 30px;">Cancel</button></a>
</form>