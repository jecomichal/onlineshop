<form method="post" name="user_login_form" id="user_login_form" class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF'];?>">
<div class="form-group">
<label for user_email class="control-label col-xs-2">Email: </label>
<div class="col-xs-6">
<input type="email" name="user_email" class="form-control" placeholder="someone@example.com">
</div>
</div>

<div class="form-group">
<label for user_password class="control-label col-xs-2">Password: </label>
<div class="col-xs-6">
<input type="password" name="user_password" class="form-control">
</div>
</div>
<button type="submit" class="btn btn-primary" name="user_login" style="height: 40px; width: 100px; float:left; margin-left:83px;">Sign In</button>
</form>