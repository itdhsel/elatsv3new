<?php 

session_start();
include('privcheck.php');  //check session n permission to access


if($_SESSION ['level'] > 0)
{
include('files/db.php');

?>

<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
<td align="left" valign="top" bgcolor="#f1e6e5" width="1000">

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
<tr>
<td height="30" colspan="2" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style21">CARIAN REKOD PEGAWAI </div></td>
</tr>

<tr>
<td><font face=verdana size=2></p>
<span class="style22">PENDAFTARAN PEGAWAI</span> <br /><br />
1 . <a href="register_staff.php">Pendaftaran pegawai baru</a> </p><br />

<span class="style22">SENARAI CARIAN PEGAWAI</span> <br /><br />
1 . <a href="search_by_gred.php">Carian mengikut gred hakiki pegawai</a><br>	
2 . <a href="search_by_name.php">Carian mengikut nama pegawai </a> <br>
3 . <a href="search_by_nokp.php">Carian mengikut no. kad pengenalan pegawai</a> <br />
<?php  if($_SESSION ['level'] != 3) { ?>
4 . <a href="search_kursus_by_name.php">Carian mengikut pegawai mengikut kursus</a><br />
<?php  } ?> 
<br />
</p>
</font>
</td></tr>
</table>

</td>  
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
