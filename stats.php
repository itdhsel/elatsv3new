<?php 

session_start();
include('privcheck.php');  //check session n permission to access


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
<table border=0 width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td height="30" align="center" bgcolor=#8B8378><div class="style21">STATISTIK LATIHAN</div></td></tr>
</table>
<?php 

set_time_limit(0);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// --- engine code starts here ---

$year_today = date("Y");
//$year_today = "2017";  
$targetkp=$nokp;
$jabatan=$_SESSION['jabatan'];

if ($_GET["stats"]==1) {

echo "<h3>Paparan statistik maklumat kursus untuk untuk setiap jabatan di Hospital Selayang <br>sehingga ".date('d-m-Y h:i:s A')."</b></h3><p>";

$selectdata3 = "SELECT p.nokp,i.nokp, i.year, p.jabatan, sum(i.bil) as bilj, sum(i.bilsah) as bils, sum(i.day) as tday, sum(i.hour) as thour,sum(i.borgperlu) as bope, sum(i.borgkembali) as boke FROM peribadi p,infokursus i 
WHERE p.nokp = i.nokp AND i.year='$year_today' AND p.status = 'AKTIF' AND p.jabatan is not null group by p.jabatan ";
$result3 = mysqli_query($selectdata3);
$foundrow3 = mysqli_num_rows($result3);
//$capturedata3 = mysqli_fetch_array ($result3);

echo "<table width=90% border=1>";
echo "<tr bgcolor=cfcfcf><th>Nama Jabatan</th><th>Jumlah Kakitangan</th><th>Jumlah Kursus<br>Belum Disahkan</th><th>Jumlah borang<br>perlu kembalikan</th><th>Jumlah borang<br>belum kembali</th><th>Kursus < 7 hari</th><th>Kursus >= 7 hari</th><th>% Kehadiran Kursus <br> >= 7 hari</th></tr>";

while($capturedata3 = mysqli_fetch_array ($result3))
{

$jabatan1=$capturedata3['jabatan'];

$selectdata3a = "SELECT p.nokp,i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan1' AND p.status = 'AKTIF' AND i.year='$year_today' AND i.day < 7";
$result3a = mysqli_query($selectdata3a);
$foundrow3a = mysqli_num_rows($result3a);
$capturedata3a = mysqli_fetch_array ($result3a);
//echo $selectdata2a."<p>";

$selectdata3b = "SELECT p.nokp,i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan1' AND p.status = 'AKTIF' AND i.year='$year_today' AND i.day >= 7";
$result3b = mysqli_query($selectdata3b);
$foundrow3b = mysqli_num_rows($result3b);
$capturedata3b = mysqli_fetch_array ($result3b);

$selectdata3c = "SELECT * FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan1' AND p.status = 'AKTIF' AND i.year='$year_today'";
$result3c = mysqli_query($selectdata3c);
$foundrow3c = mysqli_num_rows($result3c);
$capturedata3c = mysqli_fetch_array ($result3c);

$jumlahkursusbelumdisahkan=$capturedata3['bilj']-$capturedata3['bils'];

$strSQL  = "SELECT * FROM peribadi,kursus WHERE peribadi.nokp = kursus.nokp2 AND kursus.valid=0 AND peribadi.status='AKTIF' AND peribadi.jabatan='".$jabatan1."'";
$objQuery = mysqli_query($strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);       //kira jumlah kursus belum sah

$persento=($foundrow3b/$foundrow3c)*100;
$persen=number_format((float)$persento, 2, '.', '');

if ($persen=='100.00') { $bgkaler="bgcolor='#99FF99'";}  else {$bgkaler="";}

echo "<tr bgcolor=#ffffff ><td>";
if ($capturedata3['jabatan']=="") { echo "TIADA INFO JABATAN";} else { echo $capturedata3['jabatan']; }
echo "</td><td align=center><a href='statsdetail.php?data=3&jabatan=".urlencode($jabatan1)."'><font color=blue><u>".$foundrow3c."</u></font></a></td><td align=center><a href='statsdetail.php?data=7&jabatan=".urlencode($jabatan1)."'><font color=blue><u>$Num_Rows</u></font></a></td><td align=center>".$capturedata3['bope']."</td><td align=center>".$capturedata3['boke']."</td><td align=center><a href='statsdetail.php?data=2&jabatan=".urlencode($jabatan1)."'><font color=blue><u>".$foundrow3a."</u></font></a></td><td align=center><a href='statsdetail.php?data=1&jabatan=".urlencode($jabatan1)."'><font color=blue><u>".$foundrow3b."</u></font></a></td><td align=center $bgkaler>$persen</td></tr>";

}

echo "</table><br><b>Arahan:</b> Sila klik pada link biru untuk maklumat terperinci.<br><br>";
}

if ($_GET["stats"]==2) {

//$year_today = date("Y");
echo "<h3>Paparan statistik maklumat kursus bagi jabatan di Hospital Selayang secara terkumpul<br>sehingga ".date('d-m-Y h:i:s A')."</b></h3><p>";

$selectdata = "SELECT * FROM jabatan where id2=0 order by namajabatan";
$result = mysqli_query($selectdata);
$foundrow = mysqli_num_rows($result);

echo "<table border=1 width=90% bgcolor=white>";
echo "<tr bgcolor=#99FF99><td colspan=2>&nbsp;</td><td>JABATAN</td><td align=center>Jumlah Staff</td><td align=center> >= 7 Hari Kursus </td><td align=center> < 7 Hari Kursus </td><td align=center> 100% </td><td align=center> >=7 % </td><td align=center> <7 % </td></tr> ";

while($capturedata = mysqli_fetch_array ($result))
{
if ($capturedata["id2"]=='0') {
$jabatan1=$capturedata["namajabatan"];
$counter=0;
$counter1=0;
$counter2=0;


$selectdata1 = "SELECT * FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan1' AND p.status = 'AKTIF' AND i.year='$year_today'";
$result1 = mysqli_query($selectdata1);
$foundrow1 = mysqli_num_rows($result1);

$selectdata1a = "SELECT * FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan1' AND p.status = 'AKTIF' AND i.year='$year_today' AND i.day > 6";
$result1a = mysqli_query($selectdata1a);
$foundrow1a = mysqli_num_rows($result1a);

$selectdata1b = "SELECT * FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan1' AND p.status = 'AKTIF' AND i.year='$year_today' AND i.day < 7";
$result1b = mysqli_query($selectdata1b);
$foundrow1b = mysqli_num_rows($result1b);

echo "<tr><td colspan=2 bgcolor=#c0c0c0>&nbsp;</td><td> ".$capturedata["namajabatan"]." </td><td bgcolor=cyan align=center>". $foundrow1." </td><td bgcolor=cyan align=center>". $foundrow1a." </td><td bgcolor=cyan align=center>". $foundrow1b." </td>"; 
$counter=$counter+$foundrow1;
$counter1=$counter1+$foundrow1a;
$counter2=$counter2+$foundrow1b;

$id2=$capturedata["id"];
 
$selectdata2 = "SELECT * FROM jabatan where id!='0' and id2='$id2' order by namajabatan";
$result2 = mysqli_query($selectdata2);
$foundrow2 = mysqli_num_rows($result2);
  

$finalcol=$foundrow2+1;

//start calculate total for department

//echo "<td rowspan=$finalcol bgcolor=yellow>&nbsp;</td>";

//end calculate total for department

while($capturedata2 = mysqli_fetch_array ($result2))
{
if($capturedata["id"]==$capturedata2["id2"]){

$jabatan2=$capturedata2["namajabatan"];
 
$selectdata3 = "SELECT * FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan2' AND p.status = 'AKTIF' AND i.year='$year_today'";
$result3 = mysqli_query($selectdata3);
$foundrow3 = mysqli_num_rows($result3);

$selectdata3a = "SELECT * FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan2' AND p.status = 'AKTIF' AND i.year='$year_today' AND i.day > 6";
$result3a = mysqli_query($selectdata3a);
$foundrow3a = mysqli_num_rows($result3a);

$selectdata3b = "SELECT * FROM peribadi p,infokursus i WHERE p.nokp = i.nokp and p.jabatan='$jabatan2' AND p.status = 'AKTIF' AND i.year='$year_today' AND i.day < 7";
$result3b = mysqli_query($selectdata3b);
$foundrow3b = mysqli_num_rows($result3b);

echo "<tr><td align=center width=7% colspan=2>----------</td><td>&nbsp;&nbsp; ".$capturedata2["namajabatan"]." </td><td bgcolor=cyan align=center> ". $foundrow3." </td><td bgcolor=cyan align=center> ". $foundrow3a." </td><td bgcolor=cyan align=center> ". $foundrow3b." </td>"; 
$counter=$counter+$foundrow3;
$counter1=$counter1+$foundrow3a;
$counter2=$counter2+$foundrow3b;
}
}

echo "<td bgcolor=FFFF9C align=center>$counter</td><td bgcolor=FFFF9C align=center>$counter1</td><td bgcolor=FFFF9C align=center>$counter2</td></tr>";
}

if ($counter>1){
$more7=($counter1/$counter)*100;
$more7percentage=number_format((float)$more7, 2, '.', '');

$less7=($counter2/$counter)*100;
$less7percentage=number_format((float)$less7, 2, '.', '');
}

echo "<tr><td colspan=6 bgcolor=white>&nbsp;</td><td bgcolor=yellow align=center>100%</td><td bgcolor=yellow align=center>". $more7percentage ."%</td><td bgcolor=yellow align=center>". $less7percentage ."%</td></tr>";
}

echo "</table><br><br>";


}

if ($_GET["stats"]==3) {
include('testreport2.php');
}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<br><h5>[ Statistik dijana dalam '.$total_time.' saat. ] [ <a href="mydashboard.php">Kembali ke Rumusan Latihan</a> ]</h5>';


?>

    
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