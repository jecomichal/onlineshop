<?php
	$id = $_SESSION['user_id'];
	$sql = "SELECT card_type, card_number, card_owner, card_expiry, card_cvn FROM Customer WHERE customer_id = '$id'";
	
	$rs = $db->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $db->error, E_USER_ERROR);
	}
	
	else {
		while($row = $rs->fetch_assoc()) {
			$cardType = $row['card_type']; 
			$cardNumber = $row['card_number']; 
			$cardOwner = $row['card_owner']; 
			$cardExpiry = $row['card_expiry']; 
			$cardCvn = $row['card_cvn']; 
		}
	}
?>

<?php
	$expirySplit = explode('-', $cardExpiry);
?>
<form method="post" name="payment_details_form" id="payment_details_form" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form" style="margin-top: 25px;">

<div class="form-group">
<label for card_type class="control-lable col-xs-3" align="right">Card Type<span style="color:red;"> *</span></label>
<div class="col-xs-4">
 <select name="card_type" id="card_type" class="form-control">
<option value="-" <?php if ($cardType == "") echo "selected"; ?>>Select</option>
<option value="Mastercard" <?php if ($cardType == "Mastercard") echo "selected"; ?>>Mastercard</option>
<option value="VISA"<?php if ($cardType == "VISA") echo "selected"; ?>>VISA</option>
<option value="VISA Debit"<?php if ($cardType == "VISA Debit") echo "selected"; ?>>VISA Debit</option>
<option value="VISA Electron"<?php if ($cardType == "VISA Electron") echo "selected"; ?>>VISA Electron</option>
<option value="Maestro"<?php if ($cardType == "Maestro") echo "selected"; ?>>Maestro</option>
<option value="American Express"<?php if ($cardType == "American Express") echo "selected"; ?>>American Express</option>
</select>
</div>
</div>
	
<div class="form-group">
<label for card_number1 class="control-label col-xs-3">Card Number<span style="color:red;"> *</span></label>
<div class="col-xs-1" style="width: 120px;">
<input type="text" name="card_number1" id="card_number1" class="form-control" maxlength="4" value="<?php echo substr($cardNumber,0,4) ?>">
</div>
<div class="col-xs-1" style="width: 120px;">
<input type="text" name="card_number2" id="card_number2" class="form-control" maxlength="4" value="<?php echo substr($cardNumber,4,4) ?>">
</div>
<div class="col-xs-1" style="width: 120px;">
<input type="text" name="card_number3" id="card_number3" class="form-control"  maxlength="4" value="<?php echo substr($cardNumber,8,4) ?>">
</div>
<div class="col-xs-1" style="width: 120px;">
<input type="text" name="card_number4" id="card_number4" class="form-control"  maxlength="4" value="<?php echo substr($cardNumber,12,4) ?>">
</div>
</div>

<div class="form-group">
<label for card_owner class="control-label col-xs-3">Name on Card<span style="color:red;"> *</span></label>
<div class="col-xs-4">
<input type="text" name="card_owner" id="card_owner" class="form-control" value="<?php echo $cardOwner ?>">
</div>
</div>

<div class="form-group">
<label for card_expiry_month class="control-lable col-xs-3" align="right">Expiry<span style="color:red;"> *</span></label>
<div class="col-xs-1" style="width: 120px;">
 <select name="card_expiry_month" id="card_expiry_month" class="form-control" style="width:100px;">
<option value="---"<?php if ($expirySplit[1] == "00") echo "selected"; ?>>---</option>
<option value="1"<?php if ($expirySplit[1] == "1") echo "selected"; ?>>1</option>
<option value="2"<?php if ($expirySplit[1] == "2") echo "selected"; ?>>2</option>
<option value="3"<?php if ($expirySplit[1] == "3") echo "selected"; ?>>3</option>
<option value="4"<?php if ($expirySplit[1] == "4") echo "selected"; ?>>4</option>
<option value="5"<?php if ($expirySplit[1] == "5") echo "selected"; ?>>5</option>
<option value="6"<?php if ($expirySplit[1] == "6") echo "selected"; ?>>6</option>
<option value="7"<?php if ($expirySplit[1] == "7") echo "selected"; ?>>7</option>
<option value="8"<?php if ($expirySplit[1] == "8") echo "selected"; ?>>8</option>
<option value="9"<?php if ($expirySplit[1] == "9") echo "selected"; ?>>9</option>
<option value="10"<?php if ($expirySplit[1] == "10") echo "selected"; ?>>10</option>
<option value="11"<?php if ($expirySplit[1] == "11") echo "selected"; ?>>11</option>
<option value="12"<?php if ($expirySplit[1] == "12") echo "selected"; ?>>12</option>
</select>
</div>

<div class="col-xs-1"style="width: 120px;" >
<select name="card_expiry_year" id="card_expiry_year" class="form-control" style="width:100px;">
<option value="---"<?php if ($expirySplit[0] == "00") echo "selected"; ?>>---</option>
<option value="15"<?php if ($expirySplit[0] == "15") echo "selected"; ?>>15</option>
<option value="16"<?php if ($expirySplit[0] == "16") echo "selected"; ?>>16</option>
<option value="17"<?php if ($expirySplit[0] == "17") echo "selected"; ?>>17</option>
<option value="18"<?php if ($expirySplit[0] == "18") echo "selected"; ?>>18</option>
<option value="19"<?php if ($expirySplit[0] == "19") echo "selected"; ?>>19</option>
<option value="20"<?php if ($expirySplit[0] == "20") echo "selected"; ?>>20</option>
</select>
</div>
</div>

<div class="form-group">
<label for card_cvn class="control-label col-xs-3">CVN<span style="color:red;"> *</span></label>
<div class="col-xs-1">
<input type="text" name="card_cvn" id="card_cvn" class="form-control" style="width:70px;" maxlength="5" value="<?php echo $cardCvn ?>">
</div>
</div>

<button type="submit" name="payment" id="changePaymentBtn" class="btn btn-success"  style="width: 125px; float:left; margin-left: 183px;">Save Changes</button>
<a href="account.php"><button type="button" class="btn btn-danger" style="width: 125px; float:left; margin-left: 20px;">Cancel</button></a>

</form>