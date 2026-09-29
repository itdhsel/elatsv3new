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
<td valign="top" align=center bgcolor="#f1e6e5" width="1000"> 
<table width="100%">
<tr>
<?php 
$tahun1 = date("Y");
//$tahun1="2014"; 
?>
<td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">EMEL PERINGATAN KEHADIRAN KURSUS KAKITANGAN TAHUN <?php echo $tahun1; ?></div></td>
</tr>
</table>

<?php

set_time_limit(0);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

//$tahun1 = date("Y");
//$tahun1="2014"; 

$selectdata1 = "SELECT nokp,namapegawai,email,status,jabatan FROM peribadi where status='AKTIF' ORDER BY namapegawai limit 10";
$result1 = mysqli_query($selectdata1);
$total = mysqli_num_rows($result1); 

//echo "<html><head><title>WEB ENGINE - CHECK KURSUS REMINDER</title><style type='text/css'> td { font-size: xx-small; face: verdana; }</style></head><body>";
echo "<h4>WEB ENGINE CHECK KURSUS REMINDER STARTED ON ". date('d-m-Y h:i:s A') ."</h4>";
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
echo "<table width=95%>";

$counter=1;
while($capturedata1 = mysqli_fetch_array ($result1))
{
$percent = intval($counter/$total * 100)."%";

echo "<tr><td valign=top bgcolor=#d3d3d3>Record ".$counter." :<br>".$capturedata1['namapegawai']."<br>".$capturedata1['nokp']."</td> ";

$queuekp=$capturedata1['nokp'];
//$staffemail=$capturedata1['email'];
/*
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

*/
  
$selectdata0 = "SELECT * from infokursus WHERE year = '$tahun1' AND nokp = '$queuekp'";
$result0 = mysqli_query($selectdata0)or die('Error, query data failed');
$founddata0 = mysqli_fetch_array ($result0);
$foundrow0 = mysqli_num_rows($result0);

$total_hari=$founddata0['day'];
$total_cpd=$founddata0['mycpda'];
$cpd_date=date('d M Y', strtotime($founddata0['mycpddate']));
        
$hariperlu=$total_hari-7;
$hariok=abs($total_hari-7);

echo "<td width=100 valign=top bgcolor=#e3e3e3>eLATS: $total_hari hari<br> Actual CPD pts: $total_cpd  </td>";

if ($total_hari<7 && $total_cpd<40) { 

echo "<td bgcolor=#66ff99>Email: "; 

//echo "<td valign=top>Perlu hadir lagi $hariok hari kursus.";
//echo "Email reminder dihantar ke ".$capturedata1['email']."<br>"; 


//email to user function for successful course registration

if ($capturedata1['email']!="") {

echo $capturedata1['email']; 

//$to = $capturedata1['email']; 
$to = "razlan@moh.gov.my"; //for demo purposes

$subject = "Peringatan keperluan kehadiran kursus tahunan"; 
$body = "
<html>
<head>
<title>eLATS notification email</title>
</head>
<body>
<h3>PERINGATAN KEPERLUAN KEHADIRAN KURSUS 7 HARI OLEH SISTEM ELATS HOSPITAL SELAYANG</h3>
<p>

".$capturedata1['namapegawai']."<br>
".$capturedata1['nokp']."<br>
<p>
Tuan/Puan,<p>
Sukacita dimaklumkan yang Sistem eLats telah menyemak maklumat kursus Tuan/Puan dan didapati bahawa: <p><p>

Mengikut rekod sistem eLATS, Tuan/Puan telah hadir ". $total_hari ." hari kursus. <br><br>
Mengikut rekod sistem MYCPD KKM, actual CPD Tuan/Puan adalah ".$total_cpd." sehingga $cpd_date .<br><br>  

Keperluan kehadiran 7 hari berkursus adalah selaras dengan Pekeliling Perkhidmatan Bil 6/2005.<br>
Mata kredit CPD adalah penting bagi kakitangan yang akan melakukan pembaharuan Sijil Amalan Tahunan (APC).<p>
Jika Tuan/Puan telah menghadiri kursus, mohon agar dapat mengemaskini maklumat kursus yang telah dihadiri.<p>
Diharap pihak Tuan/Puan dapat mengambil tindakan yang sewajarnya<p>
Sekian, terima kasih.<p>

Unit Latihan <br>
Sistem Pengurusan Latihan - eLATS<br>
Hospital Selayang<br>
<p>
<i>This email is auto-generated...</i>
</body>
</html>
"; 

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

echo $body; echo "<p>";

// --- function send email --
if (mail($to, $subject, $body, $headers)) {   
echo(" - <font color=green><b>Sent!</b></font>");  
} 
else 
{   
echo(" - <font color=red><b>Fail!</b></font>");  
}

 
} 
 else 
{ 
 echo "NONE EMAIL DEFINED!";
}

// end of email to user function

echo "</td>";
} 
else { echo "<td bgcolor=white>No Reminder needed.</td>"; }

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
 
// Sleep one second so we can see the delay for server to process queue
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
echo '<p><h4>Page generated in '.$total_time.' seconds.</h4>';
echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';
echo "<H4>WEB ENGINE CHECK KURSUS REMINDER ENDED ON ".date('d-m-Y h:i:s A'); 
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