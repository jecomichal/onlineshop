<?php
//configuration settings for this web application
//these are defined as global constants which will be available in ALL SCRIPTS, CLASSES and FUNCTIONS

define ('__DEBUG',1);  //constants are defined using the define keyword 1=true, 0=false

define ('__USER_ERROR_PAGE', 'error.php');  //script to redirect to in case of error

define ('__CSS','CSS/mystyle.css');  //reference to CSS 

define ('__MAX_LOGIN_ATTEMPTS', 3) //maximum logins allowed before blocking account

?>
