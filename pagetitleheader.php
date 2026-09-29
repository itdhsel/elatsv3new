<?php
// --- securing include file ---
if (isset($ping) != "pong") {
     exit('<h2>You cannot access this file directly!</h2>');
}
// --- end securing include file --
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eLats V3</title>  

<link rel="stylesheet" href="css/styles.css" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar/css/calendar-system.css"  />

<script src="calendar/jquery.js"></script>
<script type="text/javascript" src="calendar/calendar/jquery.dynDateTime.js"></script>
<script type="text/javascript" src="calendar/calendar/lang/calendar-en.js"></script>

<script type="text/javascript"> 
function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
var strcount
var x = new Date()
document.getElementById('ct').innerHTML = x;
tt=display_c();
 }
</script>
