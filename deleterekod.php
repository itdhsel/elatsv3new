<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 0)
{

include('files/db.php');

?>

<?php include('pagetitleheader.php'); ?> 

<script src="calendar/jquery.js"></script>
<script type="text/javascript" src="calendar/calendar/jquery.dynDateTime.js"></script>
<script type="text/javascript" src="calendar/calendar/lang/calendar-en.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar/css/calendar-system.css"  />


</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
<td valign=top bgcolor="#f1e6e5" width="1000">

<table width="100%">
<tr><td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">MEMADAM REKOD KAKITANGAN</div></td></tr>
<tr><td align="center">
<br><br>
Adakah anda pasti untuk memadam keseluruhan rekod pegawai ini? <p>

No KP : <?php echo $_POST["nokp"];?>

<?php 
		$selectdata = "SELECT * FROM peribadi WHERE nokp = '".$_POST['nokp']."' ";
        $result = mysqli_query($selectdata);
		$capture = mysqli_fetch_array ($result);
	
		echo $capture["namapegawai"];


if ($_POST["dodel"]==1) {

$nokp=$_POST['nokp'];

mysqli_query("delete FROM peribadi where nokp='$nokp'");
mysqli_query("delete FROM kursus where nokp2='$nokp'");
mysqli_query("delete FROM infokursus where nokp='$nokp'");

$query="delete FROM peribadi where nokp='$nokp',delete FROM kursus where nokp2='$nokp',delete FROM infokursus where nokp='$nokp'";
include 'auditlog.php';

echo "<p><font color=red><b>REKOD PERIBADI DAN KURSUS PEGAWAI DIATAS TELAH DIPADAMKAN DALAM SISTEM</b></font>";

}
else {
?>
<br><br>
                      <form action=deleterekod.php method=post>
                  
                      <input type=submit name=deletey class="style10" value="Ya">
					  <input type=button onclick="history.back()" class="style10" value="Batal" />
                      <input type=hidden name=dodel value=1>
                      <input type=hidden name=nokp value="<?php echo $_POST['nokp'];?>">
                      </form>  

<?php  } ?>
</td></tr>
</table>            

</td>
<!-- end page display -->
<?php include('footer.php'); ?> 

<?php 
}
else
{
?>
<script language="javascript" type="text/javascript">
alert('Hanya Pengguna Berdaftar Dibenarkan Menggunakan Sistem Ini');
location='index.php';
</script>
<?php 
}
?>
