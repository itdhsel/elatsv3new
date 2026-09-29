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
    <div align="center" class="style4"><strong>PENGELASAN AKTIVITI LATIHAN</strong></div>
    Setiap pegawai perlu peka dan bertanggungjawab secara peribadi untuk mencatatkan kehadiran program latihan yang diikuti<br>
    Untuk tujuan rekod, pengelasan program latihan dipecahkan kepada empat (4) kumpulan seperti berikut :

<table width="695" height="128" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#E0E0E0">
      <tr>
        <td width="5" height="17">&nbsp;</td>
        <td width="28">&nbsp;</td>
        <td width="429">&nbsp;</td>
        <td width="208">&nbsp;</td>
        <td width="7">&nbsp;</td>
      </tr>
      <tr bgcolor="#c0c0c0">
        <td colspan="2"><div align="center" class="style4"><strong>Bil.</strong></div></td>
        <td class="table-header2"><div align="center" class="style4"><b>Program Latihan</b></div></td>
        <td class="table-header2"><div align="center" class="style4"><b>Jenis Aktiviti</b></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#E0E0E0">
          <div align="center"><strong>1.
              </p>
          </strong></div></td>
        <td valign="top" class="menu-item">
          <strong>Latihan          </strong>
          <p align="left">Definisi : &nbsp;Aktiviti Latihan yang dijalankan selama 6 jam&nbsp;secara bersemuka dan berterusan anjuran&nbsp;Jabatan, bahagian atau Agensi Luar di dalam&nbsp;dan di luar negara </p>          </td>
        <td valign="top"><br>
          <ol class="menu-item"><li class="menu-item">Kursus;</li>
          <li class="menu-item">Seminar;</li>
          <li class="menu-item">Konvensyen;</li>
          <li class="menu-item">Bengkel;</li>
          <li class="menu-item">Forum;</li>
          <li class="menu-item">Simposium / Persidangan</li>
          </ol></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#E0E0E0">
          <div align="center"><strong>2.</strong></div></td>
        <td valign="top" class="menu-item">
          <strong>Sesi Pembelajaran (Bersemuka)</strong>
          <p>Definisi : Sebarang aktiviti latihan atau pembelajaran secara bersemuka yang tempohnya kurang daripada 6 jam anjuran Jabatan, Bahagian atau Agensi luar di dalam negara  </p></td><td valign="top" class="menu-item"><br>
          <ol><li>Sesi Pembelajaran;</li>
          <li>Perhimpunan Bulanan;</li>
          <li>Program Penerapan Nilai-nilai Murni dan Ceramah-Ceramah Khas;</li>
          <li>Program Sambutan / Program Khas - Sambutan Bulan-Bulan Islam / Perayaan yang mengandungi ucapan / ceramah / forum;</li>
          <li>Pembentangan kertas di Seminar, Konvensyen, Simposium dan Persidangan;</li>
          <li>Menyampaikan ceramah di dalam Kursus / Bengkel (Modul yang pertama kali dibentangkan atas tajuk yang sama sahaja diambilkira)</li>
          </ol></td>
        <td>&nbsp;</td>
      </tr>
	<tr>
        <td colspan="2" valign="top" bgcolor="#E0E0E0">
          <div align="center"><strong>3.</strong></div></td>
        <td valign="top" class="menu-item">
          <strong>Sesi Pembelajaran (Tidak Bersemuka)</strong>
          <p>Definisi : Sebarang aktiviti latihan atau pembelajaran secara tidak bersemuka dan tidak berterusan yang tempohnya kurang daripada 6 jam anjuran Jabatan, Bahagian atau Agensi luar di dalam negara  </p></td><td valign="top" class="menu-item"><br>
          <ol><li>Lawatan Kerja;</li>
          <li><i>On-the-job-training</i>;</li>
          <li>Latihan Seangkutan;</li>
          <li>Simulasi;</li>
          <li>Lain-lain (seperti kajian kes, tayangan filem, <i>under study</i>)</li>
          </ol></td>
        <td>&nbsp;</td>
      </tr>
<tr>
        <td colspan="2" valign="top" bgcolor="#E0E0E0">
          <div align="center"><strong>4.</strong></div></td>
        <td valign="top" class="menu-item">
          <strong>Pembelajaran Kendiri</strong>
          <p>Definisi : Kaedah pembelajaran yang berkonsepkan belajar atas daya usaha sendiri. Pembelajaran melibatkan secara tidak bersemuka (online)  </p></td><td valign="top" class="menu-item"><br>
          <ol><li>Penggunaan portal; e-Pembelajaran Sektor Awam (EPSA);</li>
          <li>Penggunaan Portal e-Pembelajaran yang diiktiraf oleh Jabatan / Kementerian; </li>
          <li>Penggunaan Pangkalan Repositori Ilmu Sumber Manusia;</li>
          <li>Pembacaan buku-buku ilmiah dalam Bahasa Inggeris (termasuk e-book);</li>
          <li>Pembacaan Jurnal Ilmiah / Laporan Kajian dan lain-lain bahan ilmiah secara fizikal atau maya (virtual)</li>
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