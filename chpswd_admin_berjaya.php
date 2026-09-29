<?php 

session_start();
include('privcheck.php');

if($_SESSION['level'] > 1)
{

include('files/db.php');


?>

<?php include('pagetitleheader.php'); ?> 
</head>
<script type="text/JavaScript">
<!--
function fill_register()
{
	if(document.update.p.value==''||document.update.rep.value=='')
	{
		alert('Please Fill In All Fields');
		return false;
	}

	else
	{
		return true;
	}
}
//-->
</script>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
    <td align="center" valign="top" bgcolor="#f1e6e5" width="1000"><p>&nbsp;</p>
    <p>Kata Laluan pengguna telah BERJAYA di reset.</p></td> 
<?php include('footer.php'); ?> 
<?php 
}
else
{
?>
<script language="javascript" type="text/javascript">
alert('Hanya Administrator Dibenarkan Menggunakan Sistem Ini!!');
location='home.php';
</script>
<?php 
}
?>

