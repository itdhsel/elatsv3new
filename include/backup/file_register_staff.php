<?php

include 'files/db.php';

// ----- select no IC dari database ---------------------------------------------------
$selectdata = "SELECT * FROM peribadi WHERE nokp = '".$_POST['nokp']."' ";
$result = mysqli_query($selectdata);
$found = mysqli_num_rows($result);

// ----- maklumat peribadi -------------------------------------------------------------------------

$namapegawai = strtoupper($_POST["namapegawai"]);
$nokp = $_POST['nokp'];

$gentle = strtoupper($_POST["jantina"]);
if($gentle =='SILA BUAT PILIHAN'){
	$jantina = '';
}
else {
	$jantina = $gentle;
}

$race = strtoupper($_POST["bangsa"]);
if($race == 'SILA BUAT PILIHAN'){
	$bangsa = '';
}
else {
	$bangsa = $race;
}

$email= $_POST["email"];

$flag_status = strtoupper($_POST["status"]);
if($flag_status == 'SILA BUAT PILIHAN'){
	$status = '';
}
else {
	$status = $flag_status;
}

// ----- maklumat perkhidmatan ---------------------------------------------------------------------


$skim = strtoupper($_POST["skim_khidmat"]);
if ($skim == 'SILA BUAT PILIHAN'){
$skim_khidmat = '';
} 
else{
$skim_khidmat = $skim;
}



$gred = strtoupper($_POST["gredhakiki"]);
if ($gred == 'SILA BUAT PILIHAN'){
$gredhakiki = '';
} 
else{
$gredhakiki = $gred;
}


$group = strtoupper($_POST["kumpulan"]);
if ($group == 'SILA BUAT PILIHAN'){
$kumpulan = '';
} 
else{
$kumpulan = $group;
}

$department = strtoupper($_POST["jabatan"]);
if ($department == 'SILA BUAT PILIHAN'){
$jabatan = '';
} 
else{
$jabatan = $department;
}


// ----- User yang key in data ---------------------------------------------------------------------
$user_id = $_SESSION['user_id'];


if($found >0)
{	
	echo "<center>Nama Kad Pengenalan '".$nokp."' telah WUJUD dalam pangkalan data !!</center>";
	echo "<br><center>Pendaftaran TIDAK BERJAYA !!</center>";
	echo "<br><center><a href='register_staff.php'>Pendaftaran Pegawai Baru</a></center> ";	
}
else
{

// ----- Coding untuk insert data ke dalam database ------------------------------------------------
$query = "INSERT INTO peribadi (namapegawai, nokp, pwd, jantina, bangsa, email, skim_khidmat , gredhakiki, kumpulan, jabatan, status, user_id) 		
		VALUES ( '$namapegawai', '$nokp', '$nokp', '$jantina', '$bangsa', '$email', '$skim_khidmat' , '$gredhakiki', '$kumpulan', '$jabatan', '$status','$user_id') ";
		
mysqli_query($query) or die('Error, insert data failed');


$tahun1 = date("Y");

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
} else {
$query = "UPDATE infokursus SET bil='$founddata1', bilsah='$founddata2', day='$total_hari', hour='$total_jam', borgperlu='$founddata3', borgkembali='$founddata4' WHERE nokp='$queuekp' AND year='$tahun1'";
mysqli_query($query) or die('Error, insert data failed');
//echo $query;   //for debug
}


// --- end synd db infokursus

//$query = "FLUSH PRIVILEGES";


echo "<center>Maklumat pegawai dengan nombor kad pengenalan '".$nokp."' telah BERJAYA didaftarkan</center>";
echo "<br><center><a href='register_staff.php'>Daftar Pegawai Baru</a></center> ";

}



?>
