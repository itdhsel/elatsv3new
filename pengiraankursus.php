<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 0)
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
<br>
<div align="center"><b>KAEDAH PENGIRAAN BILANGAN HARI BERKURSUS </b></div>
Pengiraan bilangan hari berkursus setahun bagi tujuan perekodan adalah seperti berikut:<br>
<table width="695" height="128" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#E0E0E0">
      <tr>
        <td width="5" height="17">&nbsp;</td>
        <td width="28">&nbsp;</td>
        <td width="260">&nbsp;</td>
        <td width="377">&nbsp;</td>
        <td width="7">&nbsp;</td>
      </tr>
      <tr bgcolor="#c0c0c0">
        <td>&nbsp;</td>
        <td class="table-header2"><div align="center" class="style4"><b>Bil.</b></div></td>
        <td class="table-header2"><div align="center" class="style4"><b>Program Latihan</b></div></td>
        <td class="table-header2"><div align="center" class="style4"><b>Jenis Aktiviti</b></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td valign="top" class="menu-item" align="center">
          1.</td>
        <td valign="top" class="menu-item"><strong>
          Latihan</strong></td>
        <td valign="top" class="menu-item">
          <ol><li>Tempoh 6 jam bersamaan 1 hari berkursus</li>
          <li>Minimum 2 hari setahun (wajib dihadiri)</li>
          <li>Kursus pendek jangka panjang (melebihi 3 bulan tidak diambilkira)</li>
          </ol></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td valign="top" class="menu-item" align="center">
          2.</td>
        <td valign="top" class="menu-item"><strong>
          Sesi Pembelajaran (Bersemuka)
        </strong>
        
        <td valign="top" class="menu-item">
          <ol><li>Kehadiran 6 jam bersamaan 1 hari berkursus</li>
          <li>Maksimum adalah 5 hari setahun</li>
          <li>Pembentangan kertas kerja / Ceramah 1 kertas yang dibentang bersamaan 1 hari maksimum 3 hari sahaja</li>
          <li>Bagi penemuan <i>mentor-mentee</i> serta sesi perbincangan / perkongsian idea dengan pengurusan tertinggi (catatan perbincangan mestilah dibuat di dalam sebuah buku catatan)</li>
          </ol></td>
        <td>&nbsp;</td>
      </tr>
	<tr>
        <td>&nbsp;</td>
        <td valign="top" class="menu-item" align="center">
          3.</td>
        <td valign="top" class="style4 menu-item"><strong>
          Sesi Pembelajaran (Tidak Bersemuka)
        </strong>
        
        <td valign="top" class="menu-item">
          <ol><li>Kehadiran 6 jam bersamaan 1 hari berkursus</li>
          <li>Maksimum 5 hari setahun</li>
          </ol></td>
        <td>&nbsp;</td>
      </tr>
<tr>
        <td>&nbsp;</td>
        <td valign="top" class="menu-item" align="center">
          4.</td>
        <td valign="top" class="style4 menu-item"><strong>
          Pembelajaran Kendiri
        </strong>
        
        <td valign="top" class="menu-item">
          <ol><li>Satu sesi pembentangan perlu diadakan di peringkat Jabatan, Bahagian, Cawangan atau Seksyen. Seorang pegawai di peringkat Kumpulan Pengurusan & Profesional (Gred 41 dan ke atas) atau Pegawai Pengesah Latihan perlu hadir sebagai penyelia. Setiap satu pembentangan diiktiraf sebagai satu hari berkursus.</li>
          <li>Maksimum 3 hari setahun iaitu bersamaan dengan 3 kali pembentangan dalam setahun</li>
         </ol></td>
        <td>&nbsp;</td>
      </tr>
     
    </table>
<br>
<input name="Submit3" type="button" class="style10" onclick="history.back()" value="&lt;&lt; Kembali" />
<br>
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