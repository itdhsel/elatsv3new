<?php 

session_start();
include('privcheck.php');  //check session n permission to access
set_time_limit(0);

if($_SESSION ['level'] > 0)
{
include('files/db.php');
$user_id = $_SESSION['user_id'];
$level = $_SESSION['level'];

include('pagetitleheader.php'); 
?> 
</head>
<?php 
include('header.php'); 
include('rightmenu1.php'); 
?>
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">
<!-- start content -->

<table width="100%">
<tr><td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">MODUL PENJANAAN LAPORAN</div></td></tr>
<tr><td align="center">      
<br>
<b>ARAHAN PENGGUNAAN:</b><br><br>Sila pilih laporan yang ingin dijana, dan klik SET pada kriteria yang diperlukan. Klik JANA LAPORAN setelah memasukkan tarikh laporan yang diperlukan. <br>Klik Cetak Laporan sekiranya memerlukan lampiran cetakan. Pilih SET SEMULA untuk menjana laporan berlainan.
<br><br>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Laporan: <select name="aktiviti1">
      <option value=none >Sila pilih laporan yang diperlukan</option>
      <option value="report_1" <?php  if($_POST["aktiviti1"]=="report_1") echo selected?>>PEGAWAI YANG HADIR KURSUS KURANG 7 HARI SETAHUN</option>
      <option value="report_2" <?php  if($_POST["aktiviti1"]=="report_2") echo selected?>>PEGAWAI YANG HADIR KURSUS LEBIH 7 HARI SETAHUN</option>
      <option value="report_3" <?php  if($_POST["aktiviti1"]=="report_3") echo selected?>>PEGAWAI YANG TIDAK PERNAH HADIR KURSUS</option>     
      <option value="report_4" <?php  if($_POST["aktiviti1"]=="report_4") echo selected?>>PEGAWAI YANG BELUM KEMBALIKAN BORANG KEBERKESANAN KURSUS</option>   
      <option value="report_6" <?php  if($_POST["aktiviti1"]=="report_6") echo selected?>>PEGAWAI YANG KEMBALIKAN BORANG KEBERKESANAN KURSUS</option>   
      <option value="report_5" <?php  if($_POST["aktiviti1"]=="report_5") echo selected?>>LAPORAN KEHADIRAN KURSUS</option>   
      </select>

      <input type="submit" value="SET">
      <input type="button" value="SET SEMULA" onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>'">
      <input type="hidden" name="actionform1" value="step1">
      </form>

</td></tr>
<?php  if($_POST["actionform1"]=="step1") { ?>
<tr><td align="center">

      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Mengikut: <select name="aktiviti2">
      <option>Sila Pilih</option>
      <option value="report_a" <?php  if($_POST["aktiviti2"]=="report_a") echo selected?>>JABATAN</option>
      <option value="report_b" <?php  if($_POST["aktiviti2"]=="report_b") echo selected?>>KUMPULAN</option>
      <option value="report_c" <?php  if($_POST["aktiviti2"]=="report_c") echo selected?>>SKIM PERKHIDMATAN</option>     
      <?php  if($_POST["aktiviti1"]=="report_5") { ?><option value="report_d" <?php  if($_POST["aktiviti2"]=="report_d") echo selected ?>>INDIVIDU</option> <?php } ?>    
      </select>



      <input type="submit" value="SET">
      <input type="hidden" name="actionform1" value="step1">
      <input type="hidden" name="actionform2" value="step2">
      <input type="hidden" name="aktiviti1" value="<?php echo $_POST['aktiviti1'];?>">

      </form>

</td></tr>
<?php  } ?>

<?php  if($_POST["actionform2"]=="step2") { ?>
<tr><td align="center">


      <?php  if ($_POST['aktiviti2']=="report_a") { ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Jabatan: 
      <select name='jabatan'>
      <option selected='selected'>Sila Buat Pilihan</option>
      <?php 
      $strSQLjabatan = "SELECT namajabatan from jabatan order by namajabatan"; 
      $objQueryjabatan = mysqli_query($strSQLjabatan) or die ("Error Query [".$strSQLjabatan."]");   
      while($capturejabatan = mysqli_fetch_array($objQueryjabatan))
      {   
	  ?><option value='<?php echo $capturejabatan["namajabatan"];?>' <?php  if ($_POST['jabatan']==$capturejabatan["namajabatan"]) { echo "selected='selected'";} ?>>
	 <?php echo $capturejabatan["namajabatan"]?></option><?php      
      }
      ?>     
      </select>
      
      <input type="submit" value="SET">
      <input type="hidden" name="actionform1" value="step1">
      <input type="hidden" name="actionform2" value="step2">
      <input type="hidden" name="actionform3" value="step3">
      <input type="hidden" name="aktiviti1" value="<?php echo $_POST['aktiviti1'];?>">
      <input type="hidden" name="aktiviti2" value="<?php echo $_POST['aktiviti2'];?>">
      
      </form>
      <?php  } ?>
      
      <?php  if ($_POST['aktiviti2']=="report_b") { ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Kumpulan: 
	    <select name="kumpulan" id="kumpulan">
		  <option selected="">Sila Buat Pilihan</option>
      <option value="PENGURUSAN DAN PROFESIONAL" <?php  if ($_POST['kumpulan']=="PENGURUSAN DAN PROFESIONAL") { echo "selected='selected'";} ?> >PENGURUSAN DAN PROFESIONAL</option>
      <option value="PENGURUSAN TERTINGGI" <?php  if ($_POST['kumpulan']=="PENGURUSAN TERTINGGI") { echo "selected='selected'";} ?> >PENGURUSAN TERTINGGI</option>
      <option value="SOKONGAN 1" <?php  if ($_POST['kumpulan']=="SOKONGAN 1") { echo "selected='selected'";} ?> >SOKONGAN 1</option>
      <option value="SOKONGAN 2" <?php  if ($_POST['kumpulan']=="SOKONGAN 2") { echo "selected='selected'";} ?> >SOKONGAN 2</option>         
      </select>
      
      <input type="submit" value="SET">
      <input type="hidden" name="actionform1" value="step1">
      <input type="hidden" name="actionform2" value="step2">
      <input type="hidden" name="actionform3" value="step3">
      <input type="hidden" name="aktiviti1" value="<?php echo $_POST['aktiviti1'];?>">
      <input type="hidden" name="aktiviti2" value="<?php echo $_POST['aktiviti2'];?>">
      
      </form>
      <?php  } ?>
      
      <?php  if ($_POST['aktiviti2']=="report_c") { ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Skim Perkhidmatan: 
      <select name='skim_khidmat' id='skim_khidmat'>
      <option selected='selected'>Sila Buat Pilihan</option>
      <?php 
        	$strSQLjawatan = "SELECT namajawatan from jawatan order by namajawatan"; 
          $objQueryjawatan = mysqli_query($strSQLjawatan) or die ("Error Query [".$strSQLjawatan."]");   
          while($capturejawatan = mysqli_fetch_array($objQueryjawatan))
          {   
				        ?><option value='<?php echo $capturejawatan["namajawatan"];?>' <?php  if ($_POST['skim_khidmat']==$capturejawatan["namajawatan"]) { echo "selected='selected'";} ?> ><?php echo $capturejawatan["namajawatan"]?></option><?php 
                
          }
      ?>     
      </select>
      
      <input type="submit" value="SET">
      <input type="hidden" name="actionform1" value="step1">
      <input type="hidden" name="actionform2" value="step2">
      <input type="hidden" name="actionform3" value="step3">
      <input type="hidden" name="aktiviti1" value="<?php echo $_POST['aktiviti1'];?>">
      <input type="hidden" name="aktiviti2" value="<?php echo $_POST['aktiviti2'];?>">
      
      </form>
      <?php  } ?>
      
      <?php  if ($_POST['aktiviti2']=="report_d") { ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      No KP: <input type="text" name="nokp"id="nokp" size="14" value='<?php echo $_POST['nokp'];?>'> <span class="style22">* Ikut format xxxxxxxxxxxx</span>

      <input type="submit" value="SET">
      <input type="hidden" name="actionform1" value="step1">
      <input type="hidden" name="actionform2" value="step2">
      <input type="hidden" name="actionform3" value="step3">
      <input type="hidden" name="aktiviti1" value="<?php echo $_POST['aktiviti1'];?>">
      <input type="hidden" name="aktiviti2" value="<?php echo $_POST['aktiviti2'];?>">
      
      </form>
      <?php  } ?>
      
</td></tr>
<?php  } ?>

<?php  if($_POST["actionform3"]=="step3") { ?>
<tr><td align="center">

      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Jangkamasa: 
      <script type="text/javascript">jQuery(document).ready(function() { jQuery("#tarikh_mula").dynDateTime(); });</script>
      <input name="tarikh_mula" type="text" id="tarikh_mula" size="16" value="<?php echo $_POST['tarikh_mula'];?>">

      <script type="text/javascript">jQuery(document).ready(function() { jQuery("#tarikh_tamat").dynDateTime(); });</script>
      <input name="tarikh_tamat" type="text" id="tarikh_tamat" size="16" value="<?php echo $_POST['tarikh_tamat'];?>">

      <input type="submit" value="JANA LAPORAN">
      <input type="hidden" name="actionform1" value="step1">
      <input type="hidden" name="actionform2" value="step2">
      <input type="hidden" name="actionform3" value="step3">
      <input type="hidden" name="actionform4" value="step4">
      <input type="hidden" name="aktiviti1" value="<?php echo $_POST['aktiviti1'];?>">
      <input type="hidden" name="aktiviti2" value="<?php echo $_POST['aktiviti2'];?>">
      <input type="hidden" name="jabatan" value="<?php echo $_POST['jabatan'];?>">
      <input type="hidden" name="kumpulan" value="<?php echo $_POST['kumpulan'];?>">
      <input type="hidden" name="skim_khidmat" value="<?php echo $_POST['skim_khidmat'];?>">
      <input type="hidden" name="nokp" value="<?php echo $_POST['nokp'];?>">      
      </form>

</td></tr>
<?php  } ?>

<?php  if($_POST["actionform4"]=="step4") { ?>
<tr><td align="center">
<hr width=78%>      
    
<?php 

$jabatan = $_POST['jabatan'];
$kumpulan = $_POST['kumpulan'];
$skim_khidmat = $_POST['skim_khidmat'];
$nokp = $_POST['nokp'];

$tarikh_1 = $_POST['tarikh_mula'];
$hari=substr("$tarikh_1",0,2);
$bulan=substr("$tarikh_1",3,2);
$tahun=substr("$tarikh_1",6,4);
$tarikh_mula="$tahun"."-"."$bulan"."-"."$hari";

$tarikh_2 = $_POST['tarikh_tamat'];
$hari=substr("$tarikh_2",0,2);
$bulan=substr("$tarikh_2",3,2);
$tahun=substr("$tarikh_2",6,4);
$tarikh_tamat="$tahun"."-"."$bulan"."-"."$hari";

$today = date("Y-m-d");

if ($_POST['aktiviti1']=='report_1'||$_POST['aktiviti1']=='report_2'||$_POST['aktiviti1']=='report_5')
{
$strSQL = "SELECT n.namapegawai, n.nokp, n.skim_khidmat, n.gredhakiki, n.kumpulan, n.jabatan, n.status, sum(k.total_jam) DIV 6 as hari, MOD(sum(k.total_jam),6) as jam, k.valid, i.mycpda as mycpd  FROM peribadi n, kursus k, infokursus i WHERE k.nokp2 = n.nokp AND n.nokp = i.nokp ";
}


if ($_POST['aktiviti1']=='report_3')
{
$strSQL = "SELECT n.namapegawai, n.nokp, n.skim_khidmat, n.gredhakiki, n.kumpulan, n.jabatan, n.status, k.day, k.hour, k.year  FROM peribadi n, infokursus k WHERE k.nokp = n.nokp AND k.day = 0 AND k.hour = 0 AND k.year = $tahun  AND n.status = 'AKTIF' ";
}

if ($_POST['aktiviti1']=='report_4'||$_POST['aktiviti1']=='report_6')
{
$strSQL = "SELECT n.namapegawai, n.nokp, n.skim_khidmat,n.jabatan,n.gredhakiki,n.kumpulan, k.nama_kursus, k.borang, k.borang_dikembalikan, k.tarikh_mula, k.tarikh_tamat FROM peribadi n, kursus k WHERE k.nokp2 = n.nokp ";
}	

if ($_POST['aktiviti1']=='report_4')
{
$strSQL .= "AND k.borang = 'PERLU' AND k.borang_dikembalikan = 'BELUM DIKEMBALIKAN' ";
$group="k.nama_kursus";
$sort="k.nama_kursus";
}

if ($_POST['aktiviti1']=='report_6')
{
$strSQL .= "AND k.borang = 'PERLU' AND k.borang_dikembalikan = 'DIKEMBALIKAN' ";
$group="k.nama_kursus";
$sort="k.nama_kursus";
}

if ($_POST['aktiviti2']== 'report_a'){ $strSQL .= "AND n.jabatan = '$jabatan' "; }
if ($_POST['aktiviti2']== 'report_b'){ $strSQL .= "AND n.kumpulan = '$kumpulan' "; }
if ($_POST['aktiviti2']== 'report_c'){ $strSQL .= "AND n.skim_khidmat = '$skim_khidmat' "; }
if ($_POST['aktiviti2']== 'report_d'){ $strSQL .= "AND n.nokp = '$nokp' "; }

if ($_POST['aktiviti1']!='report_3')
{
$strSQL .= "AND k.valid = 1 
            AND n.status = 'AKTIF'
		AND k.tarikh_mula BETWEEN '$tarikh_mula' AND '$tarikh_tamat'
		AND k.tarikh_tamat BETWEEN '$tarikh_mula' AND '$tarikh_tamat' ";

            
if ($group!="") {            
$strSQL .= "GROUP BY ".$group." ";            
} else {
$strSQL .= "GROUP BY n.nokp ";            
}
            
if ($_POST['aktiviti1']=='report_1')
{
$strSQL .= "HAVING hari < 7 ";
}

if ($_POST['aktiviti1']=='report_2')
{
$strSQL .= "HAVING hari > 6 ";
}

if ($_POST['aktiviti1']=='report_3')
{
$strSQL .= "HAVING hari = 0 AND jam_tinggal = 0 ";
}

}                    

if ($sort!=""){
$strSQL .= "ORDER BY ".$sort."";
} else {
$strSQL .= "ORDER BY n.namapegawai";
}            
       
if($tarikh_mula > $tarikh_tamat)
{ echo "Tarikh di medan DARI tidak boleh lebih dari tarikh di medan HINGGA"; }

if($tarikh_tamat > $today)
{ echo "Tiada Rekod Dijumpai. Pastikan tarikh di medan DARI tidak melebihi tarikh hari ini"; }


$result = mysqli_query($strSQL) or die ("<font color=red><b>Maaf, terdapat masalah dalam menjana laporan yang diperlukan. Sila semak dan jana semula.</b><font><hr width=78%>");
$found = mysqli_num_rows($result);

//echo $strSQL."<br><br>";

if ($_POST['aktiviti1']=='report_1' AND $_POST['aktiviti2']=='report_a') {
echo "<form action='report_kursus_belum_cukup_jabatan.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG HADIR KURSUS KURANG 7 HARI SETAHUN MENGIKUT JABATAN UNTUK $jabatan";
}
if ($_POST['aktiviti1']=='report_1' AND $_POST['aktiviti2']=='report_b') {
echo "<form action='report_kursus_belum_cukup.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG HADIR KURSUS KURANG 7 HARI SETAHUN MENGIKUT KUMPULAN UNTUK $kumpulan";
}
if ($_POST['aktiviti1']=='report_1' AND $_POST['aktiviti2']=='report_c') {
echo "<form action='report_kursus_belum_cukup_skim.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG HADIR KURSUS KURANG 7 HARI SETAHUN MENGIKUT SKIM KHIDMAT UNTUK $skim_khidmat";
}

if ($_POST['aktiviti1']=='report_2' AND $_POST['aktiviti2']=='report_a') {
echo "<form action='report_kursus_telah_cukup_jabatan.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG HADIR KURSUS LEBIH 7 HARI SETAHUN MENGIKUT JABATAN UNTUK $jabatan";
}
if ($_POST['aktiviti1']=='report_2' AND $_POST['aktiviti2']=='report_b') {
echo "<form action='report_kursus_telah_cukup.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG HADIR KURSUS LEBIH 7 HARI SETAHUN MENGIKUT KUMPULAN UNTUK $kumpulan";
}
if ($_POST['aktiviti1']=='report_2' AND $_POST['aktiviti2']=='report_c') {
echo "<form action='report_kursus_telah_cukup_skim.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG HADIR KURSUS LEBIH 7 HARI SETAHUN MENGIKUT SKIM KHIDMAT UNTUK $skim_khidmat";
}

if ($_POST['aktiviti1']=='report_3' AND $_POST['aktiviti2']=='report_a') {
echo "<form action='report_kursus_tpernah_jabatan.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG TIDAK PERNAH HADIR KURSUS MENGIKUT JABATAN UNTUK $jabatan";
}
if ($_POST['aktiviti1']=='report_3' AND $_POST['aktiviti2']=='report_b') {
echo "<form action='report_kursus_tpernah.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG TIDAK PERNAH HADIR KURSUS MENGIKUT KUMPULAN UNTUK $kumpulan";
}
if ($_POST['aktiviti1']=='report_3' AND $_POST['aktiviti2']=='report_c') {
echo "<form action='report_kursus_tpernah_skim.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG TIDAK PERNAH HADIR KURSUS MENGIKUT SKIM KHIDMAT UNTUK $skim_khidmat";
}

if ($_POST['aktiviti1']=='report_4' AND $_POST['aktiviti2']=='report_a') {
echo "<form action='report_kursus_borang_jabatan.php' method='post' target='_blank'>"; 
$report_name="LAPORAN PEGAWAI YANG BELUM KEMBALIKAN BORANG KEBERKESANAN KURSUS MENGIKUT JABATAN UNTUK $jabatan";
}
if ($_POST['aktiviti1']=='report_4' AND $_POST['aktiviti2']=='report_b') {
echo "<form action='report_kursus_borang.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG BELUM KEMBALIKAN BORANG KEBERKESANAN KURSUS MENGIKUT KUMPULAN UNTUK $kumpulan";
}
if ($_POST['aktiviti1']=='report_4' AND $_POST['aktiviti2']=='report_c') {
echo "<form action='report_kursus_borang_skim.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG BELUM KEMBALIKAN BORANG KEBERKESANAN KURSUS MENGIKUT SKIM KHIDMAT UNTUK $skim_khidmat";
}


if ($_POST['aktiviti1']=='report_5' AND $_POST['aktiviti2']=='report_a') {
echo "<form action='report_kursus_jabatan.php' method='post' target='_blank'>";
$report_name="LAPORAN KEHADIRAN KURSUS MENGIKUT JABATAN UNTUK $jabatan";
}
if ($_POST['aktiviti1']=='report_5' AND $_POST['aktiviti2']=='report_b') {
echo "<form action='report_kursus_kumpulan_table.php' method='post' target='_blank'>";
$report_name="LAPORAN KEHADIRAN KURSUS MENGIKUT KUMPULAN UNTUK $kumpulan";
}
if ($_POST['aktiviti1']=='report_5' AND $_POST['aktiviti2']=='report_c') {
echo "<form action='report_kursus_jawatan.php' method='post' target='_blank'>";
$report_name="LAPORAN KEHADIRAN KURSUS MENGIKUT SKIM KHIDMAT UNTUK $skim_khidmat";
}
if ($_POST['aktiviti1']=='report_5' AND $_POST['aktiviti2']=='report_d') {
echo "<form action='report_kursus_individu.php' method='post' target='_blank'>";
$report_name="LAPORAN KEHADIRAN KURSUS INDIVIDU UNTUK $nokp";
}

if ($_POST['aktiviti1']=='report_6' AND $_POST['aktiviti2']=='report_a') {
echo "<form action='report_kursus_borang_jabatan_kembali.php' method='post' target='_blank'>"; 
$report_name="LAPORAN PEGAWAI YANG TELAH KEMBALIKAN BORANG KEBERKESANAN KURSUS MENGIKUT JABATAN UNTUK $jabatan";
}
if ($_POST['aktiviti1']=='report_6' AND $_POST['aktiviti2']=='report_b') {
echo "<form action='report_kursus_borang_kembali.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG TELAH KEMBALIKAN BORANG KEBERKESANAN KURSUS MENGIKUT KUMPULAN UNTUK $kumpulan";
}
if ($_POST['aktiviti1']=='report_6' AND $_POST['aktiviti2']=='report_c') {
echo "<form action='report_kursus_borang_skim_kembali.php' method='post' target='_blank'>";
$report_name="LAPORAN PEGAWAI YANG TELAH KEMBALIKAN BORANG KEBERKESANAN KURSUS MENGIKUT SKIM KHIDMAT UNTUK $skim_khidmat";
}

echo "<input type=hidden name='jabatan' value='$jabatan'>";
echo "<input type=hidden name='kumpulan' value='$kumpulan'>";
echo "<input type=hidden name='skim_khidmat' value='$skim_khidmat'>";
echo "<input type=hidden name='nokp' value='$nokp'>";
echo "<input type=hidden name='tarikh_mula' value='$tarikh_1'>";
echo "<input type=hidden name='tarikh_tamat' value='$tarikh_2'>";
echo "<input type=submit value='Cetak Laporan Yang Dijana'></form>";
echo "<hr width=78%>";
echo "<h4>$report_name</h4>";
echo "<h4>DARI $tarikh_1 KE $tarikh_2</h4>";
		
$sql_result = mysqli_query($strSQL);                                   
$rownum=1;
if (($sql_result)||(mysql_errno == 0)) 
    {        
        echo "<TABLE bgcolor='#f1988a' cellSpacing=2 cellPadding=2 border=0>";
        echo "<TBODY>";
        if (mysqli_num_rows($sql_result)>0) 
        { 
            //loop thru the field names to print the correct headers 
            $i = 0; 
            echo "<TR vAlign=top bgcolor='#cccccc'><th>No</th>";
            while ($i < mysql_num_fields($sql_result)) 
            { 
                echo "<TH>". mysql_field_name($sql_result, $i) . "</TH>"; 
                $i++; 
            } 
            echo "</TR>"; 

            //display The data 
            while ($rows = mysqli_fetch_array($sql_result,MYSQL_ASSOC)) 
            { 
                echo "<TR bgcolor='#FFFFFF'><td>".$rownum."</td>"; 
                foreach ($rows as $data) 
                { 
                    echo "<TD align='left'>". $data . "</TD>"; 
                } 
                echo "</TR>";
               $rownum=$rownum+1;   
            } 
        } else { 
            echo "<TR bgcolor='#FFFFFF'><TD colspan='" . ($i+1) . "'>No Results found!</TD></TR>"; 
        } 
        
        echo "</TBODY></TABLE>";
    } else { 
        echo "Error in running query: %s", mysql_error(); 
    }
    mysql_free_result($sql_result);


?>

</td></tr>
<?php  } ?>

</table>
<br><br>
<!-- end content -->
</td>            
<?php 
include('footer.php'); 
}
else
{
echo "<script language='javascript' type='text/javascript'>alert('Hanya Pengguna Berdaftar Dibenarkan Menggunakan Sistem Ini');location='index.php';</script>";
}
?>
