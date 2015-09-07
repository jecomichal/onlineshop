
/*product.php -- Match colors to selected size */
function GetMatchingColors(){
	var el = document.getElementById("size");
	var val = el.options[el.selectedIndex].value;
	var pid = document.getElementById("productID").value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("dynamicColors").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "DATA/getColors.php?q=" + val + "&pid=" + pid + "&r=" + Math.random(), true);
	     xmlhttp.send();
}	

/*product.php -- Match image to selected color */
function GetMatchingImage(){
	var el = document.getElementById("color");
	var val = el.options[el.selectedIndex].value;
	var pid = document.getElementById("productID").value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("productImageBox").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "DATA/getImage.php?q=" + val + "&pid=" + pid + "&r=" + Math.random(), true);
	     xmlhttp.send();
	     
	     GetStock();
}

/*admin -- Match sizes to product */
function GetSizes(){
	var el = document.getElementById("product");
	var pid = el.options[el.selectedIndex].value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("dynamicSize").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/getSizes.php?pid=" + pid + "&r=" + Math.random(), true);
	     xmlhttp.send();
  
}	

/*product.php -- Get stock label */
function GetStock(){
	var selectSize = document.getElementById("size");
	var size = selectSize.options[selectSize.selectedIndex].value;
	var selectColor = document.getElementById("color");
	var color = selectColor.options[selectColor.selectedIndex].value;
	var pid = document.getElementById("productID").value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("stockCheckBox").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "DATA/getStock.php?col=" + color + "&size=" + size + "&pid=" + pid + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*admin -- Find product */
function FindProduct(){
	
	var pid = document.getElementById("searchID").value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("resultBox").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/findProduct.php?pid=" + pid + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*admin -- Find product -- featured */
function FindProductFeatured(){
	
	var pid = document.getElementById("featuredSearchID").value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("featuredResultBox").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/findProductFeatured.php?pid=" + pid + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*admin -- remove featured product*/
function RemoveFeatured(e){
	
        var e =  window.event || e;
        
	var fullID = e.target.id;
	var row = fullID.substring(14);
	
	var pid = row;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("ajaxFeatured").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/removeFeatured.php?pid=" + pid + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*admin -- add featured product*/
function AddFeatured(){
	
	var pid = document.getElementById("addPID").value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("feature-msg").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/addFeatured.php?pid=" + pid + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*admin -- Find stock */
function FindStock(){
	
	var sid = document.getElementById("searchID").value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("resultBox").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/findStock.php?sid=" + sid + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*Cart - Change Quantity */
function ChangeQty(){
	
	var fullID = event.target.id;
	var row = fullID.substring(6);	
	
	var qty = document.getElementById("newQty"+row).value;
	var sid = document.getElementById("itemToChange"+row).value;
	var siz = document.getElementById("newSize"+row).value;
	var col = document.getElementById("newColor"+row).value;	
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("cartOutputBox").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "DATA/changeQty.php?sid=" + sid + "&qty=" + qty + "&size=" + siz + "&color=" + col + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*View Orders*/
function RenderOrders(){
	var el = document.getElementById("filter");
	var fil = el.options[el.selectedIndex].value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("viewOrders").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/renderOrders.php?f=" + fil + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*Manage Users*/
function RenderUsers(){
	var el = document.getElementById("filter");
	var fil = el.options[el.selectedIndex].value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("viewOrders").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/renderUsers.php?f=" + fil + "&r=" + Math.random(), true);
	     xmlhttp.send();
}

/*View Orders*/
function UpdateStatus(){
	
	var oid = document.getElementById("tableOrderID").innerHTML;
	var el = document.getElementById("status");
	var st = el.options[el.selectedIndex].value;
	
	var xmlhttp = new XMLHttpRequest();
	     xmlhttp.onreadystatechange = function() {
	         if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	             document.getElementById("statusUpdated").innerHTML = xmlhttp.responseText;
	         }
	     }
	     xmlhttp.open("GET", "../DATA/updateStatus.php?s=" + st + "&oid=" + oid + "&r=" + Math.random(), true);
	     xmlhttp.send();
}	


/*Validate Email*/
function validateEmail(id)
{
	var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	var email = $("#"+id).val();	
	var valid = emailReg.test(email);
	
	if($("#"+id).val() == null || $("#"+id).val() == "" || valid == false)
	{
		var div = $("#"+id).closest("div");
		div.removeClass("has-success");
		$("#glyph"+id).remove();
		div.addClass("has-error has-feedback");
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
		return false;
	}
	else{
		var div = $("#"+id).closest("div");
		div.removeClass("has-error");
		div.addClass("has-success has-feedback");
		$("#glyph"+id).remove();
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
		return true;	
	}
}

/*Validate Text*/
function validateText(id)
{
	if($("#"+id).val() == null || $("#"+id).val() == "")
	{
		var div = $("#"+id).closest("div");
		div.removeClass("has-success");
		$("#glyph"+id).remove();
		div.addClass("has-error has-feedback");
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
		return false;
	}
	else{
		var div = $("#"+id).closest("div");
		div.removeClass("has-error");
		div.addClass("has-success has-feedback");
		$("#glyph"+id).remove();
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
		return true;	
	}
}

/*Validate number*/
function validateNumber(id)
{
	var value = $("#"+id).val();
	var numeric = $.isNumeric(value);
	if($("#"+id).val() == null || $("#"+id).val() == "" || numeric == false)
	{
		var div = $("#"+id).closest("div");
		div.removeClass("has-success");
		$("#glyph"+id).remove();
		div.addClass("has-error has-feedback");
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
		return false;
	}
	else{
		var div = $("#"+id).closest("div");
		div.removeClass("has-error");
		div.addClass("has-success has-feedback");
		$("#glyph"+id).remove();
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
		return true;	
	}	
}

/*Validate qty*/
function validateQty(id)
{
	var value = $("#"+id).val();
	var numeric = $.isNumeric(value);
	if($("#"+id).val() == null || $("#"+id).val() == "" || numeric == false || value < 1 || value > 99)
	{
		var div = $("#"+id).closest("div");
		div.removeClass("has-success");
		$("#glyph"+id).remove();
		div.addClass("has-error has-feedback");
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
		return false;
	}
	else{
		var div = $("#"+id).closest("div");
		div.removeClass("has-error");
		div.addClass("has-success has-feedback");
		$("#glyph"+id).remove();
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
		return true;	
	}	
}

/*Go Green*/
function Green(id)
{
	if($("#"+id).val() != null && $("#"+id).val() != "" && $("#"+id).val() != "-")
	{
		var div = $("#"+id).closest("div");
		div.removeClass("has-error");
		div.addClass("has-success has-feedback");
		$("#glyph"+id).remove();
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
	}
}


function validPass(id)
{
	var passReg = new RegExp(/^(?=.*[a-z])(?=.*\d).+$/);
	var pass = $("#"+id).val();	
	var valid = passReg.test(pass);
	
	if(valid === false)
	{	
		var div = $("#"+id).closest("div");
		var span = $("#invalidPass");
		div.removeClass("has-success");
		$("#glyph"+id).remove();
		span.removeClass("hidden");
		span.addClass("show");
		div.addClass("has-error has-feedback");
		
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
		return false;
	}
	else
	{
		var div = $("#"+id).closest("div");
		var span = $("#invalidPass");
		div.removeClass("has-error");
		div.addClass("has-success has-feedback");
		$("#glyph"+id).remove();
		span.addClass("hidden");
		span.removeClass("show");
		div.append('<span id="glyph'+id+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
		return true;	
	}	
}

/*Compare 2 passwords*/
function comparePass(pass1,pass2)
{
	var p1 = $("#"+pass1).val();
	var p2 = $("#"+pass2).val();
	var samePass = false;
	
	if(p1 == p2){samePass = true;}
	
	if(samePass === false)
	{	
		var div = $("#"+pass2).closest("div");
		var span = $("#noMatch");
		div.removeClass("has-success");
		$("#glyph"+pass2).remove();
		span.removeClass("hidden");
		span.addClass("show");
		div.addClass("has-error has-feedback");
		
		div.append('<span id="glyph'+pass2+'" class="glyphicon glyphicon-remove form-control-feedback"></span>');
		return false;
	}
	else
	{
		var div = $("#"+pass2).closest("div");
		var span = $("#noMatch");
		div.removeClass("has-error");
		div.addClass("has-success has-feedback");
		$("#glyph"+pass2).remove();
		span.addClass("hidden");
		span.removeClass("show");
		div.append('<span id="glyph'+pass2+'" class="glyphicon glyphicon-ok form-control-feedback"></span>');
		return true;	
	}	
}

/* Validate product.php form */	
$(document).ready(

function()
{
	$("#addToCartBtn").click(function()
	
	{
		if(!validateText("size"))
		{
			return false;	
		}
		
		if(!validateText("color"))
		{
			return false;	
		}
		
		if(!validateQty("productQty"))
		{
			return false;	
		}
		
		$("#productOptionsForm").submit();
		
	});	
}


);

/*Validate Admin login Form*/

$(document).ready(

function()
{
	$("#adminLoginBtn").click(function()
	
	{
		if(!validateEmail("admin_email"))
		{
			return false;	
		}
		
		if(!validateText("admin_password"))
		{
			return false;	
		}
		
		$("#admin_login_form").submit();
		
	});	
}


	);
	
/*Admin Add product*/
$(document).ready(

function()
{
	$("#addProductBtn").click(function()
	
	{
		if(!validateText("title"))
		{
			return false;	
		}
		
		if(!validateText("desc"))
		{
			return false;	
		}
		
		if(!validateText("brand"))
		{
			return false;	
		}

		Green("category");
		Green("type");
		Green("gender");
		
		if(!validateText("myFile"))
		{
			return false;	
		}
		
		if(!validateNumber("price"))
		{
			return false;	
		}
		
		$("#add_product_form").submit();
		
	});	
}


	);	

/*Admin Edit product*/
$(document).ready(

function()
{
	$("#updateProductBtn").click(function()
	
	{
		if(!validateText("title"))
		{
			return false;	
		}
		
		if(!validateText("desc"))
		{
			return false;	
		}
		
		if(!validateText("brand"))
		{
			return false;	
		}
		
		if(!validateNumber("price"))
		{
			return false;	
		}
		
		$("#edit_product_form").submit();
		
	});	
}


	);
	
/*Admin Add Stock*/
$(document).ready(

function()
{
	$("#AddStocktBtn").click(function()
	
	{
		if(!validateText("product"))
		{
			return false;	
		}
		
		if(!validateText("size"))
		{
			return false;	
		}

		Green("color");
		
		if(!validateText("myFile"))
		{
			return false;	
		}
		
		if(!validateNumber("qty"))
		{
			return false;	
		}
		
		$("#admin_add_stock").submit();
		
	});	
}


	);

/*Account.php Edit Details*/

$(document).ready(

function()
{
	$("#editDetailsBtn").click(function()
	
	{
		if(!validateEmail("email"))
		{
			return false;	
		}
		
		if(!validateText("first_name"))
		{
			return false;	
		}
		
		if(!validateText("last_name"))
		{
			return false;	
		}
		
		if(!validateNumber("phone"))
		{
			return false;	
		}
		
		$("#edit_details_form").submit();
		
	});	
}


);

/*Account.php Change password*/

$(document).ready(

function()
{
	$("#changePassBtn").click(function()
	
	{
		if(!validateText("current"))
		{
			return false;	
		}
		
		if(!validateText("newpass1"))
		{
			return false;	
		}
		
		if(!validPass("newpass1"))
		{
			return false;	
		}
		
		
		if(!validateText("newpass2"))
		{
			return false;	
		}
		
		if(!comparePass("newpass1","newpass2"))
		{
			return false;			
		}
		
		$("#change_pass_form").submit();
		
	});	
}


);

/*Account.php Change address*/

$(document).ready(

function()
{
	$("#changeAddressBtn").click(function()
	
	{
		if(!validateText("countries"))
		{
			return false;	
		}		
		
		if(!validateText("street"))
		{
			return false;	
		}
		
		if(!validateText("city"))
		{
			return false;	
		}
		
		if(!validateText("state"))
		{
			return false;	
		}
		
		
		if(!validateText("zip"))
		{
			return false;	
		}
		
		$("#manage_address_form").submit();
		
	});	
}


);

/*Account.php Change payment*/

$(document).ready(

function()
{
	$("#changePaymentBtn").click(function()
	
	{
		if(!validateText("card_type"))
		{
			return false;	
		}		
		
		if(!validateNumber("card_number1"))
		{
			return false;	
		}
		
		if(!validateNumber("card_number2"))
		{
			return false;	
		}
		
		if(!validateNumber("card_number3"))
		{
			return false;	
		}
		
		if(!validateNumber("card_number4"))
		{
			return false;	
		}
		
		if(!validateText("card_owner"))
		{
			return false;	
		}
		
		if(!validateNumber("card_expiry_month"))
		{
			return false;	
		}
		
		if(!validateNumber("card_expiry_year"))
		{
			return false;	
		}
		
		
		if(!validateNumber("card_cvn"))
		{
			return false;	
		}
		
		$("#payment_details_form").submit();
		
	});	
}


);
	

/*Registration Form*/
$(document).ready(

function()
{
	$("#registerButton").click(function()
	
	{
		if(!validateEmail("email"))
		{
			location.href='#logo';
			return false;	
		}		
		
		if(!validateText("first_name"))
		{
			location.href='#logo';
			return false;	
		}
		
		if(!validateText("last_name"))
		{
			location.href='#logo';
			return false;	
		}
		
		Green("dob_day");
		Green("dob_month");
		Green("dob_year");
		
		if(!validateNumber("phone"))
		{
			location.href='#logo';
			return false;	
		}
		
		Green("countries");
		
		if(!validateText("address_street"))
		{
			return false;	
		}
		
		if(!validateText("address_city"))
		{
			return false;	
		}
		
		if(!validateText("address_state"))
		{
			return false;	
		}
		
		Green("address_zip");
		
		if(!validPass("password1"))
		{
			return false;	
		}
		
		
		if(!validateText("password2"))
		{
			return false;	
		}
		
		if(!comparePass("password1","password2"))
		{
			return false;			
		}
		
		
		
		$("#user_reg_form").submit();
		
	});	
}


);





















