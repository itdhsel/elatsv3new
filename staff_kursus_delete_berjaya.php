<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 0)
{

include('files/db.php');

$nokp = $_GET['nokp'];
$id = $_GET['id'];

?>

<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu2.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">           

    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
	
	<?php  if($_POST['deleteyes']==1) { ?>
		<td align="center" valign="top"><p><span class="title">Hapus Rekod Kursus Pegawai Berjaya </span></p> 
          <table cellpadding="2" cellspacing="2" class="tablestyleB">
            <tr>
              <td align="center">
                <br>
			  
			<?php

				if(isset($_POST['nama_kursus'],$_POST['nokp']))
				{ 
					include ('include/file_delete_kursus.php');
				}
				
				else
				echo "Tiada Sebarang Aktiviti Proses Sedang Berjalan";

			?>
    </td></tr></table>

        <?php  } else { ?>

      <td align="center" valign="top">
      <h3> Memadam rekod kursus kakitangan</h3>
	  <form action="staff_kursus_delete_berjaya.php?nokp=<?php echo $_GET['nokp'];?>" method="post">
      Adakah anda pasti untuk memadam rekod kursus berikut?<br>
      No KP Kakitangan: <?php echo $_GET['nokp'];?><br>
	  Nama Kursus: <?php echo urldecode($_GET['nama_kursus']);?><br>
      <br><br>
      <input type=submit value="YA"> 
      <input type=button onclick="history.back()" value="TIDAK">
      <input type=hidden name="nama_kursus" value="<?php echo urldecode($_GET['nama_kursus']);?>">
      <input type=hidden name="nokp" value="<?php echo $_GET['nokp'];?>">
      <input type=hidden name="id" value="<?php echo $_GET['id'];?>">
      <input type=hidden name="deleteyes" value="1">
      </form>
      </td>

		<?php  } ?>   
		   
      </tr>
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
