<?php
if (isset($_SESSION['level'])) {
$ping = "pong";  //pairing passkey for include file verification

if (isset($_GET['nokp'])) {
if ($_SESSION['level']=='1')
{
if ($_GET['nokp']!=$_SESSION['staffkp'])
{

	$message = "Operasi tidak dibenarkan!!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	$_GET['nokp']=$_SESSION['staffkp'];
    //echo "<script type="text/javascript">location.href = 'index.php';</script>";$_SESSION['jabatan']
}
}
if ($_SESSION['level']=='3')
{
include('files/db.php');
$kp=$_GET['nokp'];	
$query  = "SELECT nokp,jabatan FROM peribadi WHERE nokp = '$kp'";
$result = mysqli_query($conn, $query);
//echo $query;
//$capture=mysqli_fetch_object($query);
//$count = mysqli_num_rows($result);
$capture = mysqli_fetch_array ($result);	
if($_SESSION['jabatan']!=$capture["jabatan"]) 
{
	$message = "Operasi tidak dibenarkan!! Sila lakukan aktiviti untuk jabatan anda sahaja.";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script type='text/javascript'>location.href = 'home.php';</script>";
}
include('files/closedb.php');
}
}

if(isset($_SESSION['LAST_ACTIVITY'])){ $last=$_SESSION['LAST_ACTIVITY']; } else { $_SESSION['LAST_ACTIVITY']=""; }

$lapsed=floor((time()-$_SESSION['LAST_ACTIVITY']) % 3600 /60);

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago (30x60=1800)
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage


    //echo "Sorry.. Your session has expired!";
    //header("location:index.php");
    $message = "Sessi anda telah tamat. Sila log in semula.";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script type='text/javascript'>location.href = 'index.php';</script>";

}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

}
else { 
  $message = "Anda tiada akses capaian untuk melihat laman ini. Sila login untuk mendapatkan akses.";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo "<script type='text/javascript'>location.href = 'index.php';</script>";
}
?>