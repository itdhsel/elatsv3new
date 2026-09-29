<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 0)
{

include('files/db.php');
$nokp = $_GET['nokp'];
$nokp = $_POST['nokp'];
$id = $_GET['id'];

?>

<?php include('pagetitleheader.php'); ?> 

</head>
<?php include('header.php'); ?>
<?php include('rightmenu2.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">

<br><br><span class="title">Pendaftaran Kursus Baru</span></p> 
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
            <tr>
              <td>
			  
			<?php

				if(isset($_POST['addkursus']))
				{ 
					include ('include/file_register_kursus.php');
				}				
				else
				echo "Tiada Sebarang Aktiviti Proses Sedang Berjalan";

			?>

</td>
            </tr>
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
