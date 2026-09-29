<?php
include('files/db.php');
$n = ucwords(strtolower($_POST['name']));
$u = strtolower($_POST['username']);
$p = $_POST['password'];
$l = $_POST['level'];

$query="SELECT * FROM members WHERE username = '$u'";
$result=mysqli_query($query);
$num=mysqli_num_rows($result);

if($num > 0)
{ echo '<center>Maaf. Username yang serupa telah didaftarkan. Sila guna Username lain. <a href="admin.php" onClick="history.go(-1)">Kembali ke Pengurusan Administrator</a>'; }


elseif ((!$n == NULL) && (!$u == NULL) && (!$p == NULL) && ($l > 0))
		{
		$encrypted_mypassword = md5($p);
		$query = "INSERT INTO members (name, username, password, level) VALUES ('$n', '$u', '$encrypted_mypassword', '$l')";
		mysqli_query($query) or die('Error, Register User Failed');
		$query = "FLUSH PRIVILEGES";
		echo "<center>Pengguna baru '".$n."' dengan Username '".$u."' Telah Berjaya Didaftarkan!' </center>";
		echo '<br><center><a href="admin.php" onClick="history.go(-1)">Kembali ke Modul Pengurusan</a></center> ';
		include 'files/closedb.php';
		}

else	{
		echo "<center>";
		echo "Medan Username atau Password atau Level kosong. Sila pastikan maklumat yang anda masukkan lengkap!<br>";
		echo '<a href="admin.php" onClick="history.go(-1)">Back</a>';
		echo "</center>";
		}


?>