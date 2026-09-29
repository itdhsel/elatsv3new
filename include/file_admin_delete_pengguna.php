<title>Training Management System TMS 2010</title>

<?php
include 'files/db.php';
//$n = ucwords(strtolower($_POST['name']));
$user_id = $_POST["user_id2"];
$name = $_POST["name2"];
$username = $_POST["username2"];


// ----- Coding for delete data in database ------------------------------------------------
//$query1 = "SELECT * FROM members WHERE username = '$username'";
//$result = mysqli_query($query1);
//$found = mysqli_num_rows($result);

//if ($found > 0){
//$query = "DELETE FROM members WHERE name = '$name'";
//echo "<center>Penghapusan Akaun Pengguna BERJAYA bagi pegawai bernama'".$name."'. <a href='admin.php'>Kembali ke Modul Penyelenggaraan</a></center>"; }
//else {
//echo "<center>Penghapusan Akaun Pengguna GAGAL. Tiada Pengguna Dapat Dipadamkan.<br><br> <a href='admin.php'>Kembali ke Modul Penyelenggaraan</a></center>";}


$query = "DELETE FROM members WHERE name = '$name'
		AND user_id = '$user_id'";
//$result = mysqli_query($query);
//$found = mysqli_num_rows($result);
		
//if ($found > 0){
//echo "<center>Penghapusan Akaun Pengguna BERJAYA bagi pegawai bernama'".$name."'. <a href='admin.php'>Kembali ke Modul Penyelenggaraan</a></center>"; }
//else {
//echo "<center>Penghapusan Akaun Pengguna GAGAL. Tiada Pengguna Dapat Dipadamkan.<br><br> <a href='admin.php'>Kembali ke Modul Penyelenggaraan</a></center>";}
		

mysqli_query($query) or die('Penghapusan Akaun Pengguna GAGAL. Tiada Pengguna Dapat Dipadamkan.');
$query = "FLUSH PRIVILEGES";
echo "<center>Penghapusan Akaun Pengguna BERJAYA!!</center>";
echo "<center>Akaun pengguna bagi pegawai bernama '".$name."'dengan username '".$username."' telah dihapuskan!<br><br><a href='admin.php'>Kembali ke Modul Penyelenggaraan</a></center>";


?>