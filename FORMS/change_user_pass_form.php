<form method="post" name="change_pass_form" id="change_pass_form" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form" style="margin-top: 25px;">
<div class="form-group">
<label for current class="control-label col-xs-4">Current Password<span style="color:red;"> *</span></label>
<div class="col-xs-5">
<input type="password" name="current" id="current" class="form-control">
<?php if(isset($_GET['wrongc']) && $_GET['wrongc'] == 1){
	echo '<span id="wrongCurrent" class="help-block" style="color:crimson;">Incorrect current password</span>';
}?>
</div>
</div>

<div class="form-group">
<label for newpass1 class="control-label col-xs-4">New Password<span style="color:red;"> *</span></label>
<div class="col-xs-5">
<input type="password" name="newpass1" id="newpass1" class="form-control">
<span id="invalidPass" class="help-block hidden" style="color:crimson;">Password must be at least 6 characters long and contain at least 1 digit!</span>
</div>
</div>

<div class="form-group">
<label for newpass2 class="control-label col-xs-4">Re-enter Password<span style="color:red;"> *</span></label>
<div class="col-xs-5">
<input type="password" name="newpass2" id="newpass2" class="form-control">
<span id="noMatch" class="help-block hidden" style="color:crimson;">Passwords do not match</span>
</div>
</div>

<button type="submit" name="changepass" id="changePassBtn" class="btn btn-success" style="width: 125px; float:left; margin-left: 245px;">Save Changes</button>
<a href="account.php"><button type="button" class="btn btn-danger" style="width: 125px; float:left; margin-left: 20px;">Cancel</button></a>

</form>