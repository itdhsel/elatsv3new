<?php

include 'files/db.php';

$selectdata = "SELECT * FROM peribadi WHERE nokp = '".$_POST['nokp']."' ";
$result = mysqli_query($selectdata);
$capturedata = mysqli_fetch_array ($result);

$jabatanfound=$capturedata["jabatan"];
$namapegawaifound=$capturedata["namapegawai"];
$emailpegawaifound=$capturedata["email"];

// ----- maklumat peribadi -------------------------------------------------------------------------
$nokp = $_POST['nokp'];
$id = $_POST['id'];

// semak maklumat kursus samada telah disahkan
//$selectdata2 = "SELECT id,nokp2,valid,tarikh_mula,tarikh_tamat,total_hari,total_jam,borang FROM kursus WHERE id = '".$id."' ";
//$result2 = mysqli_query($selectdata2);
//$capturedata2 = mysqli_fetch_array ($result2);
//$kursusvalidated=$capturedata2["valid"];
//$kursusmula=$capturedata2["tarikh_mula"];
//$kursustamat=$capturedata2["tarikh_tamat"];
//$kursushari=$capturedata2["total_hari"];
//$kursusjam=$capturedata2["total_jam"];
//$borangperluold=$capturedata2["borang"];
// end 

$skim_khidmat = strtoupper($_POST["skim_khidmat"]);
//$gredhakiki = strtoupper($_POST["gredhakiki"]);


$group = strtoupper($_POST["kumpulan"]);
if ($group == 'SILA BUAT PILIHAN')
{
$kumpulan = '';
} 
else
{
$kumpulan = $group;
}

$grade = strtoupper($_POST["gredhakiki"]);
if ($grade == 'SILA BUAT PILIHAN')
{
$gredhakiki = '';
} 
else
{
$gredhakiki = $grade;
}



$lain_lokasi = strtoupper($_POST["lain_lokasi"]);

$department = strtoupper($_POST["jabatan"]);
if ($department == 'SILA BUAT PILIHAN')
{
$jabatan = '';
} 
else
{
$jabatan = $department;
}


//$jabatan = strtoupper($_POST["jabatan"]);


// ----- maklumat perkhidmatan ---------------------------------------------------------------------

$category = strtoupper($_POST["kategori"]);
if ($category == 'SILA BUAT PILIHAN')
{
$kategori = '';
} 
else
{
$kategori = $category;
}


$kursus = strtoupper($_POST["jenis_kursus"]);
if ($kursus == 'SILA BUAT PILIHAN')
{
$jenis_kursus = '';
} 
else
{
$jenis_kursus = $kursus;
}

$nama_kursus = strtoupper(mysql_real_escape_string($_POST["nama_kursus"]));

$program = strtoupper($_POST["jenis_program"]);
if ($program == 'SILA BUAT PILIHAN')
{
$jenis_program = '';
} 
else
{
$jenis_program = $program;
}

$location = strtoupper($_POST["lokasi"]);
if ($location == 'SILA BUAT PILIHAN')
{
$lokasi = '';
} 
else
{
$lokasi = $location;
}

$lain_lokasi = strtoupper($_POST["lain_lokasi"]);

$nama_kursus = mysql_real_escape_string(strtoupper($_POST["nama_kursus"]));

$p_anjur = strtoupper($_POST['penganjur']);
if ($p_anjur == 'SILA BUAT PILIHAN')
{
$penganjur = '';
} 
else
{
$penganjur = $p_anjur;
}

$j_penganjur_luaran = strtoupper($_POST['jenis_penganjur_luaran']);
if ($j_penganjur_luaran == 'SILA BUAT PILIHAN')
{
$jenis_penganjur_luaran = '';
}
else
{
$jenis_penganjur_luaran = $j_penganjur_luaran;
}


$j_penganjur_dalaman = strtoupper($_POST['jenis_penganjur_dalaman']);
if ($j_penganjur_dalaman == 'SILA BUAT PILIHAN')
{
$jenis_penganjur_dalaman = '';
}
else
{
$jenis_penganjur_dalaman = $j_penganjur_dalaman;
}

$agensi_luar = strtoupper($_POST["agensi_luar"]);

if($penganjur != 'DALAMAN' && $jenis_penganjur_luaran != 'AGENSI LUAR')
{	
	$agensi_luar = '';
}

if($penganjur == 'DALAMAN')
{	
	$jenis_penganjur_luaran = '';
	$agensi_luar = '';
}


$t_m = $_POST['tarikh_mula'];
$hari=substr("$t_m",0,2); $bulan=substr("$t_m",3,2); $tahun1=substr("$t_m",6,4);
$tarikh_mula ="$tahun1"."-"."$bulan"."-"."$hari";

$t_t = $_POST['tarikh_tamat'];
$hari=substr("$t_t",0,2); $bulan=substr("$t_t",3,2); $tahun=substr("$t_t",6,4);
$tarikh_tamat="$tahun"."-"."$bulan"."-"."$hari";

$dateend = strtotime($tarikh_tamat);
$datestart = strtotime($tarikh_mula);
$datediff = $dateend - $datestart;
$datetotal = floor($datediff/(60*60*24));

$total_jam = $_POST['total_jam'];

if ($datediff==0 && $total_jam>6){
  if ($kursus!="EPSA") {$total_jam=6;}       //kiraan kursus epsa boleh dikira lebih 6 jam walaupun sehari
}

$t_jam = $total_jam; 
$jam_tinggal = $t_jam % 6;

if ($t_jam < 6)
{
	$total_hari = 0;
}
elseif ($t_jam >= 6 && $jam_tinggal >= 3)
{
	$total_hari = $t_jam / 6 - 1;
} 
else
{
$total_hari = $t_jam/6;
}

$rm = $_POST['rm'];
$nolpo = $_POST['nolpo'];
$cpdpoint = $_POST['cpdpoint'];
$cpdcategory = strtoupper($_POST['cpdcategory']);
if($cpdcategory == 'SILA BUAT PILIHAN')
{	
	$cpdcategory = '';
}

$status = strtoupper($_POST['status_kursus']);
if($status == 'SILA BUAT PILIHAN')
{	
	$status_kursus = '';
}
else
{
$status_kursus = $status;
}

$borang = $_POST['keperluan_borang'];
$borang_dikembalikan = $_POST['status_borang'];
$status_kursus = $_POST['status_kursus'];

// ----- User yang key in data ---------------------------------------------------------------------
$user_id = $_SESSION['user_id'];
$level = $_SESSION['level'];


// ----- Coding untuk update data ke dalam database ------------------------------------------------
$query = "UPDATE kursus set nokp2='$nokp', kategori = '$kategori',jenis_kursus ='$jenis_kursus', jenis_program='$jenis_program', nama_kursus='$nama_kursus',
penganjur ='$penganjur',jenis_penganjur_luaran = '$jenis_penganjur_luaran', jenis_penganjur_dalaman = '$jenis_penganjur_dalaman', agensi_luar = '$agensi_luar', 
lokasi='$lokasi', lain_lokasi='$lain_lokasi', tarikh_mula ='$tarikh_mula', tarikh_tamat='$tarikh_tamat', total_jam='$total_jam', total_hari ='$total_hari', 
jam_tinggal ='$jam_tinggal', status_kursus='$status_kursus', borang='$borang', borang_dikembalikan='$borang_dikembalikan', user_id='$user_id', valid='$status_kursus' 
WHERE id = '$id'"; 
                              
//echo "<br>".$query."<p>";     //debug
mysqli_query($query) or die('Error, update data failed');
//$query = "FLUSH PRIVILEGES";
// ---------- function: log sql executed -------
include 'auditlog.php';
// ---------- end log sql function -----------


echo "<center>Maklumat kursus bagi pegawai dengan nombor kad pengenalan '".$nokp."' telah BERJAYA dikemaskini</center>";

// --- sync db infokursus

$queuekp=$nokp;

$tahun_range=" AND k.tarikh_mula BETWEEN '$tahun1-01-01' AND '$tahun1-12-31' AND k.tarikh_tamat BETWEEN '$tahun1-01-01' AND '$tahun1-12-31' ";

$selectdata0 = "SELECT k.valid, n.namapegawai, n.nokp, n.status,k.tarikh_mula,k.tarikh_tamat, sum(k.total_jam) DIV 6 as hari, MOD(sum(k.total_jam),6) as jam							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'        
         AND k.valid = 1
         ".$tahun_range."
			   GROUP BY n.nokp
			   ORDER BY n.namapegawai
			   ";
$result0 = mysqli_query($selectdata0)or die('Error, query data failed');
$founddata0 = mysqli_fetch_array ($result0);
$foundrow0 = mysqli_num_rows($result0);
//echo "<td>".$foundrow0."</td>";

if ($foundrow0==0) {
$total_hari=0;
$total_jam=0;
} else {
$total_hari=$founddata0['hari'];
$total_jam=$founddata0['jam'];
}

$selectdata1 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
         AND n.status = 'AKTIF'
         ".$tahun_range."
         ORDER BY k.tarikh_mula
			   ";
         
$result1 = mysqli_query($selectdata1) or die('Error, query data failed');
$founddata1 = mysqli_num_rows($result1);
//echo "<td>".$founddata1."</td>";;

$selectdata2 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
         AND k.valid = 1
         AND n.status = 'AKTIF'
         ".$tahun_range."
         ORDER BY k.tarikh_mula
			   ";
         
$result2 = mysqli_query($selectdata2) or die('Error, query data failed');
$founddata2 = mysqli_num_rows($result2);
//echo "<td>".$founddata2."</td>";

$selectdata3 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
         AND k.valid = 1
         AND n.status = 'AKTIF'
         AND k.borang = 'PERLU'
         ".$tahun_range."
         ORDER BY k.tarikh_mula
			   ";
$result3 = mysqli_query($selectdata3) or die('Error, query data failed');
$founddata3 = mysqli_num_rows($result3);
//echo "<td>".$founddata3."</td>";

$selectdata4 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
         AND k.valid = 1
         AND n.status = 'AKTIF'
         AND k.borang = 'PERLU'
         AND k.borang_dikembalikan = 'BELUM DIKEMBALIKAN' 
         ".$tahun_range."
         ORDER BY k.tarikh_mula
			   ";
         
$result4 = mysqli_query($selectdata4) or die('Error, query data failed');
$founddata4 = mysqli_num_rows($result4);
//echo "<td>".$selectdata4."</td>";
//echo "<td>".$founddata4."</td>";

$check="select nokp,year from infokursus where nokp='$queuekp' and year='$tahun1'";
$checkdata = mysqli_query($check) or die('Error, query data failed');
$foundcheck = mysqli_num_rows($checkdata);

if ($foundcheck==0) {
$query = "INSERT INTO infokursus (nokp, year, bil, bilsah, day, hour, borgperlu, borgkembali) VALUES ('$queuekp', '$tahun1', '$founddata1', '$founddata2', '$total_hari', '$total_jam', '$founddata3', '$founddata4') ";
mysqli_query($query) or die('Error, insert data failed');
//echo $query;   //for debug
// ---------- function: log sql executed -------
include 'auditlog.php';
// ---------- end log sql function -----------

} else {
$query = "UPDATE infokursus SET bil='$founddata1', bilsah='$founddata2', day='$total_hari', hour='$total_jam', borgperlu='$founddata3', borgkembali='$founddata4' WHERE nokp='$queuekp' AND year='$tahun1'";
mysqli_query($query) or die('Error, insert data failed');
//echo $query;   //for debug
// ---------- function: log sql executed -------
include 'auditlog.php';
// ---------- end log sql function -----------

}

// --- end synd db infokursus


echo "<p><center>[<a href='staff_kursus.php?nokp=".$nokp."'>Kembali ke Paparan Kursus Dihadiri</a>] </center>";

	

?>