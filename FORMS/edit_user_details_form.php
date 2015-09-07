<?php
$dob_split = explode('-', $_SESSION['user_dob']);
?>
<form method="post" name="edit_details_form" id="edit_details_form" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form" style="margin-top: 25px;">
<div class="form-group">
<label for email class="control-label col-xs-3">Email<span style="color:red;"> *</span></label>
<div class="col-xs-6">
<input type="email" name="email" id="email" class="form-control" value="<?php echo ucfirst($_SESSION['user_email']); ?>">
</div>
</div>

<div class="form-group">
<label for first_name class="control-label col-xs-3">First Name<span style="color:red;"> *</span></label>
<div class="col-xs-6">
<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo ucfirst($_SESSION['user_first_name']); ?>">
</div>
</div>

<div class="form-group">
<label for last_name class="control-label col-xs-3">Last Name<span style="color:red;"> *</span></label>
<div class="col-xs-6">
<input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo ucfirst($_SESSION['user_last_name']); ?>">
</div>
</div>

<div class="form-group">
<label for dob_day class="control-lable col-xs-3" align="right">Date of Birth</label>
<div class="col-xs-2" style="width: 105px;">
 <select name="dob_day" class="form-control">
<option value="-" <?php echo ($dob_split[2] == '-')?"selected":""; ?>>Day</option>
<option value="1"<?php if ($dob_split[2] == 1) echo "selected"; ?>>1</option>
<option value="2"<?php if ($dob_split[2] == 2) echo "selected"; ?>>2</option>
<option value="3"<?php if ($dob_split[2] == 3) echo "selected"; ?>>3</option>
<option value="4"<?php if ($dob_split[2] == 4) echo "selected"; ?>>4</option>
<option value="5"<?php if ($dob_split[2] == 5) echo "selected"; ?>>5</option>
<option value="6"<?php if ($dob_split[2] == 6) echo "selected"; ?>>6</option>
<option value="7"<?php if ($dob_split[2] == 7) echo "selected"; ?>>7</option>
<option value="8"<?php if ($dob_split[2] == 8) echo "selected"; ?>>8</option>
<option value="9"<?php if ($dob_split[2] == 9) echo "selected"; ?>>9</option>
<option value="10"<?php if ($dob_split[2] == 10) echo "selected"; ?>>10</option>
<option value="11"<?php if ($dob_split[2] == 11) echo "selected"; ?>>11</option>
<option value="12"<?php if ($dob_split[2] == 12) echo "selected"; ?>>12</option>
<option value="13"<?php if ($dob_split[2] == 13) echo "selected"; ?>>13</option>
<option value="14"<?php if ($dob_split[2] == 14) echo "selected"; ?>>14</option>
<option value="15"<?php if ($dob_split[2] == 15) echo "selected"; ?>>15</option>
<option value="16"<?php if ($dob_split[2] == 16) echo "selected"; ?>>16</option>
<option value="17"<?php if ($dob_split[2] == 17) echo "selected"; ?>>17</option>
<option value="18"<?php if ($dob_split[2] == 18) echo "selected"; ?>>18</option>
<option value="19"<?php if ($dob_split[2] == 19) echo "selected"; ?>>19</option>
<option value="20"<?php if ($dob_split[2] == 20) echo "selected"; ?>>20</option>
<option value="21"<?php if ($dob_split[2] == 21) echo "selected"; ?>>21</option>
<option value="22"<?php if ($dob_split[2] == 22) echo "selected"; ?>>22</option>
<option value="23"<?php if ($dob_split[2] == 23) echo "selected"; ?>>23</option>
<option value="24"<?php if ($dob_split[2] == 24) echo "selected"; ?>>24</option>
<option value="25"<?php if ($dob_split[2] == 25) echo "selected"; ?>>25</option>
<option value="26"<?php if ($dob_split[2] == 26) echo "selected"; ?>>26</option>
<option value="27"<?php if ($dob_split[2] == 27) echo "selected"; ?>>27</option>
<option value="28"<?php if ($dob_split[2] == 28) echo "selected"; ?>>28</option>
<option value="29"<?php if ($dob_split[2] == 29) echo "selected"; ?>>29</option>
<option value="30"<?php if ($dob_split[2] == 30) echo "selected"; ?>>30</option>
<option value="31"<?php if ($dob_split[2] == 31) echo "selected"; ?>>31</option>
</select>
</div>
<div class="col-xs-2" style="width: 150px;">
<select name="dob_month" class="form-control">
<option value="-"<?php if ($dob_split[1] == '-') echo "selected"; ?>>Month</option>
<option value="1"<?php if ($dob_split[1] == 1) echo "selected"; ?>>January</option>
<option value="2"<?php if ($dob_split[1] == 2) echo "selected"; ?>>Febuary</option>
<option value="3"<?php if ($dob_split[1] == 3) echo "selected"; ?>>March</option>
<option value="4"<?php if ($dob_split[1] == 4) echo "selected"; ?>>April</option>
<option value="5"<?php if ($dob_split[1] == 5) echo "selected"; ?>>May</option>
<option value="6"<?php if ($dob_split[1] == 6) echo "selected"; ?>>June</option>
<option value="7"<?php if ($dob_split[1] == 7) echo "selected"; ?>>July</option>
<option value="8"<?php if ($dob_split[1] == 8) echo "selected"; ?>>August</option>
<option value="9"<?php if ($dob_split[1] == 9) echo "selected"; ?>>September</option>
<option value="10"<?php if ($dob_split[1] == 10) echo "selected"; ?>>October</option>
<option value="11"<?php if ($dob_split[1] == 11) echo "selected"; ?>>November</option>
<option value="12"<?php if ($dob_split[1] == 12) echo "selected"; ?>>December</option>
</select>
</div>
<div class="col-xs-2" style="width: 110px;">
 <select name="dob_year" class="form-control">
<option value="-"<?php if ($dob_split[0] == '-') echo "selected"; ?>>Year</option>
<option value="2015"<?php if ($dob_split[0] == 2015) echo "selected"; ?>>2015</option>
<option value="2014"<?php if ($dob_split[0] == 2014) echo "selected"; ?>>2014</option>
<option value="2013"<?php if ($dob_split[0] == 2013) echo "selected"; ?>>2013</option>
<option value="2012"<?php if ($dob_split[0] == 2012) echo "selected"; ?>>2012</option>
<option value="2011"<?php if ($dob_split[0] == 2011) echo "selected"; ?>>2011</option>
<option value="2010"<?php if ($dob_split[0] == 2010) echo "selected"; ?>>2010</option>
<option value="2009"<?php if ($dob_split[0] == 2009) echo "selected"; ?>>2009</option>
<option value="2008"<?php if ($dob_split[0] == 2008) echo "selected"; ?>>2008</option>
<option value="2007"<?php if ($dob_split[0] == 2007) echo "selected"; ?>>2007</option>
<option value="2006"<?php if ($dob_split[0] == 2006) echo "selected"; ?>>2006</option>
<option value="2005"<?php if ($dob_split[0] == 2005) echo "selected"; ?>>2005</option>
<option value="2004"<?php if ($dob_split[0] == 2004) echo "selected"; ?>>2004</option>
<option value="2003"<?php if ($dob_split[0] == 2003) echo "selected"; ?>>2003</option>
<option value="2002"<?php if ($dob_split[0] == 2002) echo "selected"; ?>>2002</option>
<option value="2001"<?php if ($dob_split[0] == 2001) echo "selected"; ?>>2001</option>
<option value="2000"<?php if ($dob_split[0] == 2000) echo "selected"; ?>>2000</option>
<option value="1999"<?php if ($dob_split[0] == 1999) echo "selected"; ?>>1999</option>
<option value="1998"<?php if ($dob_split[0] == 1998) echo "selected"; ?>>1998</option>
<option value="1997"<?php if ($dob_split[0] == 1997) echo "selected"; ?>>1997</option>
<option value="1996"<?php if ($dob_split[0] == 1996) echo "selected"; ?>>1996</option>
<option value="1995"<?php if ($dob_split[0] == 1995) echo "selected"; ?>>1995</option>
<option value="1994"<?php if ($dob_split[0] == 1994) echo "selected"; ?>>1994</option>
<option value="1993"<?php if ($dob_split[0] == 1993) echo "selected"; ?>>1993</option>
<option value="1992"<?php if ($dob_split[0] == 1992) echo "selected"; ?>>1992</option>
<option value="1991"<?php if ($dob_split[0] == 1991) echo "selected"; ?>>1991</option>
<option value="1990"<?php if ($dob_split[0] == 1990) echo "selected"; ?>>1990</option>
<option value="1989"<?php if ($dob_split[0] == 1989) echo "selected"; ?>>1989</option>
<option value="1988"<?php if ($dob_split[0] == 1988) echo "selected"; ?>>1988</option>
<option value="1987"<?php if ($dob_split[0] == 1987) echo "selected"; ?>>1987</option>
<option value="1986"<?php if ($dob_split[0] == 1986) echo "selected"; ?>>1986</option>
<option value="1985"<?php if ($dob_split[0] == 1985) echo "selected"; ?>>1985</option>
<option value="1984"<?php if ($dob_split[0] == 1984) echo "selected"; ?>>1984</option>
<option value="1983"<?php if ($dob_split[0] == 1983) echo "selected"; ?>>1983</option>
<option value="1982"<?php if ($dob_split[0] == 1982) echo "selected"; ?>>1982</option>
<option value="1981"<?php if ($dob_split[0] == 1981) echo "selected"; ?>>1981</option>
<option value="1980"<?php if ($dob_split[0] == 1980) echo "selected"; ?>>1980</option>
<option value="1979"<?php if ($dob_split[0] == 1979) echo "selected"; ?>>1979</option>
<option value="1978"<?php if ($dob_split[0] == 1978) echo "selected"; ?>>1978</option>
<option value="1977"<?php if ($dob_split[0] == 1977) echo "selected"; ?>>1977</option>
<option value="1976"<?php if ($dob_split[0] == 1976) echo "selected"; ?>>1976</option>
<option value="1975"<?php if ($dob_split[0] == 1975) echo "selected"; ?>>1975</option>
<option value="1974"<?php if ($dob_split[0] == 1974) echo "selected"; ?>>1974</option>
<option value="1973"<?php if ($dob_split[0] == 1973) echo "selected"; ?>>1973</option>
<option value="1972"<?php if ($dob_split[0] == 1972) echo "selected"; ?>>1972</option>
<option value="1971"<?php if ($dob_split[0] == 1971) echo "selected"; ?>>1971</option>
<option value="1970"<?php if ($dob_split[0] == 1970) echo "selected"; ?>>1970</option>
<option value="1969"<?php if ($dob_split[0] == 1969) echo "selected"; ?>>1969</option>
<option value="1968"<?php if ($dob_split[0] == 1968) echo "selected"; ?>>1968</option>
<option value="1967"<?php if ($dob_split[0] == 1967) echo "selected"; ?>>1967</option>
<option value="1966"<?php if ($dob_split[0] == 1966) echo "selected"; ?>>1966</option>
<option value="1965"<?php if ($dob_split[0] == 1965) echo "selected"; ?>>1965</option>
<option value="1964"<?php if ($dob_split[0] == 1964) echo "selected"; ?>>1964</option>
<option value="1963"<?php if ($dob_split[0] == 1963) echo "selected"; ?>>1963</option>
<option value="1962"<?php if ($dob_split[0] == 1962) echo "selected"; ?>>1962</option>
<option value="1961"<?php if ($dob_split[0] == 1961) echo "selected"; ?>>1961</option>
<option value="1960"<?php if ($dob_split[0] == 1960) echo "selected"; ?>>1960</option>
<option value="1959"<?php if ($dob_split[0] == 1959) echo "selected"; ?>>1959</option>
</select>
</div>
</div>

<div class="form-group">
<label for phone class="control-label col-xs-3">Phone<span style="color:red;"> *</span></label>
<div class="col-xs-6">
<input type="tel" name="phone" id="phone" class="form-control" value="<?php echo $_SESSION['user_phone']; ?>">
</div>
</div>

<button type="submit" name="editdetails" id="editDetailsBtn" class="btn btn-success" style="width: 125px; float:left; margin-left: 182px;">Save Changes</button>
<a href="account.php"><button type="button" class="btn btn-danger" style="width: 125px; float:left; margin-left: 82px;">Cancel</button></a>
</form>