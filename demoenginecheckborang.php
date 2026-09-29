<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 3)
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
<table width="100%">
<tr>
<?php 
$tahun1 = date("Y");
//$tahun1="2014"; 
?>
<td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">EMEL PERINGATAN PEMULANGAN BORANG KEBERKESANAN KURSUS TAHUN <?php echo $tahun1; ?></div></td>
</tr>
</table>

<?php  

set_time_limit(0);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

$selectdata1 = "SELECT nokp,namapegawai,email FROM peribadi ORDER BY namapegawai limit 10";
$result1 = mysqli_query($selectdata1);
$total = mysqli_num_rows($result1); 

//echo "<html><head><title>WEB ENGINE - BORG CHECK REMINDER</title><style type='text/css'> td { font-size: xx-small; face: verdana; }</style></head><body>";
echo "<center><h4>WEB ENGINE CHECK BORANG REMINDER STARTED ON ". date('d-m-Y h:i:s A') ."</b></h4>";
echo "<font face='verdana' size=1>";
?>

<table><tr><td>
<!-- Progress bar holder -->
<div id="progress" style="width:500px;border:1px solid #FF0000;"></div>
<!-- Progress information -->
<div id="information" style="width"></div>     
</td></tr></table>
<br>

<?php
echo "<table width=90%>";

$counter=1;
while($capturedata1 = mysqli_fetch_array ($result1))
{
$percent = intval($counter/$total * 100)."%";

echo "<tr><td valign=top>Record ".$counter." : ".$capturedata1['namapegawai']." - ".$capturedata1['nokp']."</td> ";
$queuekp=$capturedata1['nokp'];

$selectdata2 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
         AND k.valid = 1
         AND n.status = 'AKTIF'
         AND k.borang = 'PERLU'
         AND k.borang_dikembalikan = 'BELUM DIKEMBALIKAN'    
         ORDER BY k.tarikh_mula
			   ";
$result2 = mysqli_query($selectdata2) or die('Error, query data failed');
$founddata = mysqli_num_rows($result2);
//echo "run sql - ".$selectdata2."<br>";
echo "<td valign=top> ".$founddata." borang</td>";

//echo "<td valign=top>Checking kursus info for kursus yang borang belum dikembalikan..<br>";
$x=0;
while($capturedata2 = mysqli_fetch_array($result2))
{
$datadisplay[$x]="- ".$capturedata2['nama_kursus']." pada ".$capturedata2['tarikh_mula']." ke ".$capturedata2['tarikh_tamat']."<br>";
//echo $datadisplay[$x];
$x=$x+1;
}	
//echo "</td>";

if($founddata>0){ 
echo "<td valign=top>Email reminder sent to "; 
//echo "<td valign=top>Email reminder sent to ".$capturedata1['email']."<br>"; 

//email to user function for successful course registration

if ($capturedata1['email']!="") {

echo $capturedata1['email'];

//$to = $capturedata1['email']; 
$to = "razlan@moh.gov.my"; //for demo purposes

$subject = "Peringatan penghantaran borang keberkesanan kursus"; 
$body = "
<html>
<head>
<title>eLATS notification email</title>
</head>
<body>
<h3>PERINGATAN PENGEMBALIAN BORANG KEBERKESANAN KURSUS OLEH SISTEM ELATS HOSPITAL SELAYANG</h3>
<p>

".$capturedata1['namapegawai']."<br>
".$capturedata1['nokp']."<br>
<p>
Tuan/Puan,<p>
Sukacita dimaklumkan yang Sistem eLats telah menyemak maklumat kursus tuan dan didapati bahawa <p>
Tuan/Puan belum mengembalikan borang keberkesanan kursus bagi kursus-kursus berikut:<p>";

for ($i = 0; $i < $x; $i++) { $body .= $datadisplay[$i]; }

$body .= "Diharap pihak Tuan/Puan dapat mengambil tindakan yang sewajarnya.
<p>
Sekian, terima kasih.<p>

Unit Latihan <br>
Hospital Selayang<br>
<p>
<i>This email is auto-generated</i>
</body>
</html>
"; 

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

echo $body;

//--- send email function --
if (mail($to, $subject, $body, $headers)) {   
echo("OK!");  
} 
else 
{   
echo("<font color=red><b>KO!</b></font>"); 
} 

} 
 else 
{ 
  //echo "<br>Tiada makluman pendaftaran melalui email kerana sistem tiada maklumat email kakitangan berikut.<p>"; 
  echo "NONE";
}

// end of email to user function

unset ($datadisplay);
echo "</td>";
} 
else { echo "<td>NO email sent!</td>"; }

echo "<td align=left>";
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
//echo "<p><h5>Page generated in $total_time seconds.</h5><p>";

    // Javascript for updating the progress bar and information
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div align=left style=\"width:'.$percent.';background-color:#FF0000;\">&nbsp;'.$percent.'&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$counter.'/'.$total.' row(s) processed. <br>Time taken has been '.$total_time.' seconds. <br>Speed is '.$counter/$total_time.' row per second.";
    </script>';
 
// This is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*64);

// Send output to browser immediately
    flush();
 
// Sleep one second so we can see the delay
    sleep(5);
    
echo "</td>"; 

echo "</tr>";
$counter=$counter+1;
}
echo "</table>";  

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<p><h3>Page generated in '.$total_time.' seconds.</h3>';
echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';
echo "<H4>WEB ENGINE CHECK BORANG REMINDER ENDED ON ".date('d-m-Y h:i:s A'); 
echo "</H4></font>";

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