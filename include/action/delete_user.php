<?
session_start();
if(!session_is_registered(myusername)){
header("location:login.php");
}

include('include/db.php');



$query1 = "select * FROM members WHERE username='".$user."'";
$numresults1=mysqli_query($query1);

$numrows1=mysqli_num_rows($numresults1);

//$query1 = "DELETE FROM members WHERE username='".$user."'";
//$result1 = mysqli_query($query1) or die('Error, query failed');

//$numresults1=mysqli_query($query1);

//$numrows1=mysqli_num_rows($numresults1);

if ($numrows1 > 0 )
{ 
mysqli_query("DELETE FROM members WHERE username='".$user."'");
echo '<center>Penghapusan Rekod Pengguna "'.$user.'" Berjaya. <a href="#" onClick="history.go(-1)">Kembali ke Modul Admin</a></center>'; }

else
{ echo '<center>Penghapusan Pengguna Gagal. Tiada Pengguna Dapat Dipadamkan. <a href="#" onClick="history.go(-1)"><br><br>Kembali ke Modul Admin</a></center>';}
//mysqli_query("DELETE FROM members WHERE username='".$user."'");
//echo $user;
include 'include/closedb.php';

?>