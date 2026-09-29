<?php

session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION ['level'] > 0)
{
include('files/db.php');
?>

<html>
<head>
<title>Notifikasi Sistem eLATS</title>
<link rel="stylesheet" href="css/styles.css" type="text/css">
</head>
<body bgcolor="#c4afab">
<center>
<table border=10 bordercolor=red bgcolor="#f1e6e5">
<tr><td align=center>	
<h3>Notifikasi Sistem eLATS</h3>
Anda ada <b>
<?php
            if($_SESSION ['level'] == 3){
            $jabataninfo = $_SESSION['jabatan'];
            $strSQL  = "SELECT * FROM peribadi,kursus WHERE peribadi.nokp = kursus.nokp2 AND peribadi.status='AKTIF' AND kursus.valid=0 AND peribadi.jabatan='".$jabataninfo."'";
            } else {
            $strSQL  = "SELECT * FROM peribadi,kursus WHERE peribadi.nokp = kursus.nokp2 AND peribadi.status='AKTIF' AND valid=0";
            }

            $objQuery = mysqli_query($strSQL) or die ("Error Query [".$strSQL."]");
            $Num_Rows = mysqli_num_rows($objQuery);
            echo  $Num_Rows;

?> </b> 
maklumat latihan yang telah dihantar dan belum disahkan. <br>Mohon pihak tuan/puan mengambil tindakan sewajarnya.<br> Terima kasih.<br>
<br>
<input type=button value=Tutup onclick="self.close()"> 
</center>
</body>
</html>
<?php } ?>