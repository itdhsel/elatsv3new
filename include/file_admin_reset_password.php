<title>Training Management System TMS 2010</title>
<?php

include 'files/db.php';

$user_id2 = $_POST["user_id2"];
$username2 = $_POST["username2"];

$p = $_POST["p"];
$rep = $_POST["rep"];

if($p != $rep)
{	
	echo "<center>Penukaran Password GAGAL!!</center>";
	echo "<br><center>'Password Baru' dan 'Re-Password Baru' tidak sama!!</center>";
	echo "<br><center>Sila cuba sekali lagi!</center>";
	echo "<br><center><a href='admin.php'>Kembali ke Modul Penyelenggaraan</a></center> ";	
}
else
{	
	$encrypted_mypassword = md5($p);
	// ----- Coding for update data to database ------------------------------------------------
	$query = "UPDATE members SET password='$encrypted_mypassword'
WHERE user_id='$user_id2' ";
			
	mysqli_query($query) or die('Error, reset password failed');
	$query = "FLUSH PRIVILEGES";
	
	echo "<center>Penukaran Password BERJAYA !!</center>";
	echo "<br><center>Penukaran Password bagi Username '".$username2."' telah berjaya!!</center>";
	echo "<br><center><a href='admin.php'>Kembali ka Modul Penyelenggaraan</a></center> ";	

}



?>