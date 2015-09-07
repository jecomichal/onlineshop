<?php
$colorID = $_REQUEST['q'];
$pid = $_REQUEST['pid'];

if(file_exists('../IMAGES/PRODUCTS/'.$pid.'-'.$colorID.'.jpg'))
{$outPut = '<img src="../IMAGES/PRODUCTS/'.$pid.'-'.$colorID.'.jpg" class="product_img">';}

else{$outPut = '<img src="../IMAGES/PRODUCTS/default.jpg" class="product_img">';}

echo $outPut;
?>