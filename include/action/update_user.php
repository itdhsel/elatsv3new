<?php
include('files/db.php');
//$n = ucwords(strtolower($_POST['nama']));
//$u = strtolower($_POST['username']);
$p = $_POST['password'];
$l = $_POST['level'];

$user = $_POST['user'];

$query="SELECT * FROM members WHERE username = '$u'";
$result=mysqli_query($query);
$num=mysqli_num_rows($result);


if ((!$p == NULL) && ($l > 0))
		{
		$encrypted_mypassword = md5($p);
		$query = "UPDATE members SET password ='$encrypted_mypassword', level='$l' WHERE username = '$user'";
		mysqli_query($query) or die('Error, Update User Failed');
		$query = "FLUSH PRIVILEGES";
		echo "<center>Pengguna dengan Username '".$user."' Telah Berjaya Dikemaskini!' </center>";
		echo '<br><center><a href="admin.php" >Kembali ke Modul Pengurusan</a></center> ';
		include 'files/closedb.php';
		}

else	{
		echo "<center>";
		echo "Medan Username atau Password atau Level kosong. Sila pastikan maklumat yang anda masukkan lengkap!<br>";
		echo '<a href="#" onClick="history.go(-1)">Back</a>';
		echo "</center>";
		}


?>