<?php

session_start();
setcookie("login_user","",time()-(60*60));
session_destroy();
header("location:index.php");
?>