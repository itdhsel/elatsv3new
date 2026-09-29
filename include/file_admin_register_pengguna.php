<?php
include('../files/db.php');
$n = ucwords(strtolower($_POST['namepengguna']));
$u = strtolower($_POST['username']);
$p = $_POST['password'];
$l = $_POST['level'];
$j = $_POST['jabatan'];
$k = $_POST['email'];

$query="SELECT * FROM members WHERE jabatan = '$u'";
$result=mysqli_query($query);
$num=mysqli_num_rows($result);

//$query1="SELECT * FROM members WHERE jabatan = '$j'";
//$result1=mysqli_query($query1);
//$num1=mysqli_num_rows($result1);

if($num > 0 )
{ echo '<center>Harap Maaf. Username anda telah digunakan . Sila guna username yang lain. <a href="../admin.php" onClick="history.go(-1)">Kembali ke Modul Penyelenggaraan</a>'; }


elseif ((!$n == NULL) && (!$u == NULL) && (!$p == NULL) && ($l > 0))
		{
		$encrypted_mypassword = md5($p);
		$query = "INSERT INTO members (name, username, password, level, jabatan, email) VALUES ('$n', '$u', '$encrypted_mypassword', '$l', '$j','$k')";
		mysqli_query($query) or die('Error, Register User Failed');
		$query = "FLUSH PRIVILEGES";
		echo "<center>Pengguna baru '".$n."' dengan Username '".$u."' Telah Berjaya Didaftarkan!' </center>";
		echo "<br><center><a href='../admin.php'>Kembali ke Modul Penyelenggaraan</a></center> ";	

		}
else	
	{
		echo "<center>";
		echo "Medan 'Nama Pengguna' atau 'Username' atau 'Password' atau 'Level' adalah kosong.<br>";
		echo "Sila pastikan anda masuk maklumat yang lengkap!<br>";
		echo "<br><a href='../admin.php'>Kembali ke Modul Penyelenggaraan</a>";	
		echo "</center>";
	}


?>