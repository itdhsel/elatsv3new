<?php 

//---------- Script copyright -----------------
/* 
this script is writtin by Razlan Abdul Aziz, for the use of elatihan system only. 
plz do not distribute or share the codes without consent from me.

your cooperations is highly appreciate. :) thank you.
*/


session_start();

include('files/db.php');
require_once('myCPD.php');

echo "<b>MYCPD SYNC STARTED ON ".date('d-m-Y H:i:s')."</b><br>";

echo "<div id='progress' style='width:500px;border:1px solid #FF0000;'></div>";
echo "<div id='information' style='width'></div>";

set_time_limit(0);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

$tahun1 = date("Y");

$selectdata1 = "SELECT nokp,namapegawai,skim_khidmat FROM peribadi WHERE status = 'AKTIF' ORDER BY namapegawai";
$result1 = mysqli_query($selectdata1);
$total = mysqli_num_rows($result1); 

$counter=1;
$errorupdate=0;
while($capturedata1 = mysqli_fetch_array ($result1))
{
$percent = intval($counter/$total * 100)."%";


$nokp=$capturedata1['nokp'];
$jawatan=$capturedata1['skim_khidmat'];
$datetoday=date('Y-m-d');
$year= date("Y");

$cpdact=checkmycpd($nokp,$jawatan,1);
$cpdcum=checkmycpd($nokp,$jawatan,2);

//echo "NoKP $nokp cpdact $cpdact cpdcum $cpdcum <br>";

if($cpdact!=0 && $cpdcum!=0) {
$query = "UPDATE infokursus SET mycpdc='$cpdcum', mycpda='$cpdact', mycpddate = '$datetoday' WHERE nokp='$nokp' AND year='$year'";
mysqli_query($query) or die('Error, insert data failed');
echo "NoKP $nokp cpdact $cpdact cpdcum $cpdcum <br>";
$errorupdate=$errorupdate+1;
}



/*
//$cpdact==0 && $cpdcum==0) 
if($hcpcheck==0){
    
$errorupdate=$errorupdate+1;
echo "Record ".$counter." : ".$capturedata1['namapegawai']." - ".$capturedata1['nokp']."- HCP:".$jawatan." : ";
echo " - ". $cpdcum ." - ". $cpdact."<br>";
goto a;
a:
    
}
*/

// end of mycpd grab function
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);

// Javascript for updating the progress bar and information
echo '<script language="javascript">
document.getElementById("progress").innerHTML="<div align=left style=\"width:'.$percent.';background-color:#FF0000;\">&nbsp;'.$percent.'&nbsp;</div>";
document.getElementById("information").innerHTML="'.$counter.'/'.$total.' row(s) processed. <br>Total Updated: '.$errorupdate.' record(s).";
</script>';
 
// This is for the buffer achieve the minimum size in order to flush data
echo str_repeat(' ',1024*64);

// Send output to browser immediately
flush();
 
// Sleep one second so we can see the delay
//sleep(1);

$counter=$counter+1;
}

$query = "UPDATE metaconf SET value = '$datetoday' WHERE var='mycpddate'";
mysqli_query($query) or die('Error, insert data failed');
echo "<br>Metaconf updated: ".$datetoday;

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<p>Overall procees took '.$total_time.' seconds. Total Errors: '.$errorupdate.' record(s).<p>';
echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed."</script>';
echo "<b>MYCPD SYNC ENDED ON ".date('d-m-Y H:i:s');

?>