<?php 

session_start();
include('privcheck.php');  //check session n permission to access


if($_SESSION ['level'] > 0)
{

include('files/db.php');

$nokp = $_GET['nokp'];


?>

<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu2.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">           

 test
 
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