<?php 

session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION ['level'] > 3)
{

include('files/db.php');

$nokp = $_GET['nokp'];


?>

<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">           
<table width='100%'><tr><td height='30' bgcolor='#8B8378' align='center'><span class='style21'>FUNGSI BACKEND SISTEM ELATS</span></td></tr></table>
<br>
<font color=red><b>NOTA MAKLUMAN PENTING</b></font><br><br> Fungsi-fungsi berikut akan menggunakan load memori yang tinggi atau memakan masa yang lama. <br>Adalah dinasihatkan agar menjalankan fungsi-fungsi tersebut diluar waktu puncak.
<br><br>
<table bgcolor=#c0c0c0 cellpadding=10 cellspacing=10 border=1>
<tr><td align=center bgcolor=white> <a href="enginesyncdbinfo.php">- Kemaskini Data Infokursus Kakitangan -</a> </td></tr>
<tr><td align=center bgcolor=white> <a href="enginesyncmycpd.php">- Kemaskini Data CPD Point dari MyCPD -</a> </td></tr>
<tr><td align=center bgcolor=white> <a href="enginecheckkursus.php">- Hantar email peringatan kursus kepada yang belum cukup 7 hari -</a> </td></tr>
<tr><td align=center bgcolor=white> <a href="enginecheckborang.php">- Hantar email peringatan borang keberkesanan kursus kepada yang belum kembalikan -</a> </td></tr>
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