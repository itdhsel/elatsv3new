<?php 

session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION ['level'] > 1)
{

include('files/db.php');

?>

<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
    <td align="center" valign="top" bgcolor="#f1e6e5" width="1000">
	
		<p><span class="title">Hapus Akaun Pengguna</span></p> 
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
            <tr>
              <td class="style10">
              
              <table width="100%" cellpadding="2" cellspacing="2">
                <tr bordercolor="#FFFFFF">
                  <td align="center" valign="middle"><span class="style24">.: Status Penghapusan Akaun Pengguna :. </span></td>
                </tr>
                <tr>
				<td colspan="6" class="style10">
			 <?php

				if(isset($_POST['deleteAccount']))
				{ 
					include ('include/file_admin_delete_pengguna.php');
				}
				else
				echo "Tiada sebarang aktiviti sedang dijalankan";

			?>	</td> </tr>
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
alert('Hanya Administrator Dibenarkan Menggunakan Sistem Ini');
location='home.php';
</script>
<?php 
}
?>