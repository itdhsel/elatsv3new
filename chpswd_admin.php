<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 1)
{

include('files/db.php');

$nokp = $_GET['nokp'];

?>
<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu2.php'); ?> 

<td valign=top bgcolor="#f1e6e5" width="1000">

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">

<tr><td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">FUNGSI MENUKAR KATA LALUAN KAKITANGAN</div></td></tr>

<tr><td>

<h5>Menukar kata laluan Kakitangan (KP: <?php echo $nokp;?>)</h5>

<?php   
$queryname  = "SELECT * FROM peribadi WHERE nokp = '$nokp'";
$resultname = mysqli_query($queryname);
$capturename = mysqli_fetch_array ($resultname);
$staffpwd = $capturename["pwd"];
		                     

$queryname  = "UPDATE peribadi SET pwd = nokp WHERE nokp = '$nokp'";
$resultname = mysqli_query($queryname);

} else { echo "<font color='red'><b>Kata laluan baru tidak sepadan. Sila masuk semula</b></font>"; }


?>
<form action="chpswd_admin_berjaya.php?nokp=<?php echo $nokp; ?>" method="post">
<table>

<tr><td colspan="2"><br> <input type="submit" value="Reset Kata Laluan"></tr>
</table>
<input type="hidden" name="change" value="1">
</form>

</td></tr>
</table>

</td>
<!-- end page display -->
<?php include('footer.php'); ?> 

<?php 



?>
