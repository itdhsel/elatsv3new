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
    <td align="center" valign="top" bgcolor="#f1e6e5" width="1000">
    
    <table width="710" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
      <td align="left" valign="top"><p><span class="title">Tukar 'Password' Pengguna</span></p> 
      
      <table width="100%" border="1" bordercolor="#FFFFFF">
      <tr><td align="center" valign="middle"><span class="style10">.: Status Penukaran Password Pengguna :.</span></td></tr>
      </table>
          
      <table width="100%" border="1" bordercolor="#FFFFFF">
      <tr><td>
         
      <table width="100%" border="0" cellpadding="2" cellspacing="2" bordercolor="#000000" bgcolor="#FFFFFF">
      <tr><td colspan="6" class="style10">
			<?php

				if(isset($_POST['resetPassword']))
				{ 
					include ('include/file_admin_reset_password.php');
				}
				else
				echo "Tiada sebarang aktiviti sedang dijalankan";

			?>	
      </td></tr>
      </table>
       
		  </td></tr>
      </table>
      
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
alert('Hanya Administrator Dibenarkan Menggunakan Sistem Ini!!');
location='home.php';
</script>
<?php 
}
?>

