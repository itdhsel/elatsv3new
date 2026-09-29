<?php

include 'files/db.php';

// ----- maklumat peribadi -------------------------------------------------------------------------
$nokp = $_POST['nokp'];

// ----- maklumat kursus ---------------------------------------------------------------------------
$nama_kursus = $_POST['nama_kursus'];

// ----- User yang key in data ---------------------------------------------------------------------
$id = $_POST['id'];

// ----- Delete coding data dari dalam database ------------------------------------------------
$query = "DELETE FROM kursus WHERE nama_kursus = '$nama_kursus' AND id = '$id'";

mysqli_query($query) or die('Error, delete data failed');

$query = "FLUSH PRIVILEGES";

// --- sync db infokursus

$queuekp=$nokp;
$tahun1=date("Y");

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

echo "<center>Rekod kursus bernama '".$nama_kursus."' bagi pegawai dengan nombor kad pengenalan '".$nokp."' telah BERJAYA DIHAPUSKAN!!</center>";
echo "<br><br>[ <a href='staff_kursus.php?nokp=".$nokp."'>Kembali ke Paparan Kursus Dihadiri</a> ]";



?>
