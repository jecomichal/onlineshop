<form method="post" name="admin_login_form" id="admin_login_form" class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF'];?>">
<div class="form-group">
<label for admin_email class="control-label col-xs-2">Email: </label>
<div class="col-xs-6">
<input type="email" name="admin_email" id="admin_email" class="form-control" placeholder="someone@example.com">
</div>
</div>

<div class="form-group">
<label for admin_password class="control-label col-xs-2">Password: </label>
<div class="col-xs-6">
<input type="password" name="admin_password" id="admin_password" class="form-control">
</div>
</div>

<button type="submit" class="btn btn-primary" name="admin_login" id="adminLoginBtn" style="height: 40px; width: 100px; float:left; margin-left:83px;">Sign In</button>
</form>