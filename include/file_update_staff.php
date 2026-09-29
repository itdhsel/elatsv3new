<?php

include 'files/db.php';

// ----- maklumat peribadi -------------------------------------------------------------------------
$namapegawai = strtoupper(mysql_real_escape_string($_POST["namapegawai"]));  
//$namapegawai = strtoupper(mysql_real_escape_string($_POST["nama_kursus"]))
$nokp = $_POST["nokp"];   
$nokp2 = $_POST["nokp2"]; 

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

$status1 = strtoupper($_POST["status"]);
if($status1 == 'SILA BUAT PILIHAN'){
	$status = '';
}
else {
	$status = $status1;
}

// ----- maklumat perkhidmatan ---------------------------------------------------------------------


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


// ----- User yang key in data ---------------------------------------------------------------------
$user_id = $_SESSION['user_id'];
$level = $_SESSION['level'];


// ----- Coding untuk update data ke dalam database ------------------------------------------------

$query = "UPDATE peribadi set namapegawai = '$namapegawai', jantina ='$jantina', bangsa = '$bangsa', skim_khidmat = '$skim_khidmat', gredhakiki = '$gredhakiki', 
kumpulan = '$kumpulan', jabatan = '$jabatan', user_id = '$user_id',  nokp = '$nokp2', email = '$email',	status = '$status' WHERE nokp='$nokp' ";
      
//echo $query;
mysqli_query($query) or die('Error, update data failed');
//$query = "FLUSH PRIVILEGES";
// ---------- function: log sql executed -------
include 'auditlog.php';
// ---------- end log sql function -----------


if ($nokp!=$nokp2)
{
$query2 = "update kursus set nokp2='$nokp2' WHERE nokp2='$nokp'";
mysqli_query($query2) or die('Error, update data failed');

$query3 = "update infokursus set nokp='$nokp2' WHERE nokp='$nokp'";
mysqli_query($query3) or die('Error, update data failed');

$query="update kursus set nokp2='$nokp2' WHERE nokp2='$nokp', update infokursus set nokp='$nokp2' WHERE nokp='$nokp'";
//$query2 = "FLUSH PRIVILEGES";
// ---------- function: log sql executed -------
include 'auditlog.php';
// ---------- end log sql function -----------
}


echo "<center>Maklumat pegawai dengan nombor kad pengenalan '".$nokp2."' telah BERJAYA dikemaskini</center>";
echo "<br><center>[<a href='staff_update.php?nokp=".$nokp2."'>Kembali ke Paparan Kemaskini Rekod Peribadi</a>] </center>";




?>
