<?php 

//---------- Script copyright -----------------
/* 
this script is writtin by Razlan Abdul Aziz, for the use of elatihan system only. 
plz do not distribute or share the codes without consent from me.

your cooperations is highly appreciate. :) thank you.
*/


session_start();

include('files/db.php');

echo "<b>MYCPD SYNC STARTED ON ".date('d-m-Y H:i:s')."</b><br>";

echo "<div id='progress' style='width:500px;border:1px solid #FF0000;'></div>";
echo "<div id='information' style='width'></div>";

set_time_limit(0);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

$tahun1 = date("Y");

$selectdata1 = "SELECT nokp,namapegawai,email FROM peribadi WHERE status = 'AKTIF' ORDER BY namapegawai";
$result1 = mysqli_query($selectdata1);
$total = mysqli_num_rows($result1); 

$counter=1;
$errorupdate=0;
while($capturedata1 = mysqli_fetch_array ($result1))
{
$percent = intval($counter/$total * 100)."%";

//echo "Record ".$counter." : ".$capturedata1['namapegawai']." - ".$capturedata1['nokp']." : ";

$nokp=$capturedata1['nokp'];

$url = 'http://www.mycpd.moh.gov.my/apc/default.aspx';
$opts = array('http' =>
    array(
        'method'  => 'GET',
        'timeout' => 1, 
    )
);
$context1  = stream_context_create($opts);
$response1 = @file_get_contents($url, false, $context1);
preg_match('#<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.*)" />#Uis', $response1, $state);

$ic=$nokp;
$year= date("Y");

$data = array(
  "__VIEWSTATE" => $state[1],
  "txtIDNo" => $ic,
  "ddlDayFrom" => "1",
  "ddlMthFrom" => "1",
  "ddlYearFrom" => $year,
  "ddlDayTo" => "31",
  "ddlMthTo" => "12",
  "ddlYearTo" => $year,
  "Button1" => "Go",
  "hdnHCP" => ""
  );

$options = array(
  'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    'method'  => 'POST',
    'timeout' => 1,
    'content' => http_build_query($data),
    ),
  );
$context  = stream_context_create($options);
$response = @file_get_contents($url, false, $context);

if ($response===FALSE) { 
//echo "<br>- ERROR UPDATING MYCPD DATA (KP ".$nokp.") -</b><br>";
$errorupdate=$errorupdate+1; }

else {

preg_match('#No user found#Uis', $response, $nouser);
preg_match('#<td align="center" width="100">([0-9\.]*)</td>#Uis', $response, $mycpd_year);
preg_match('#<td align="center" width="150">([0-9\.]*)</td>#Uis', $response, $mycpd_cumulative);
preg_match('#<td align="center" width="120">([0-9\.]*)</td>#Uis', $response, $mycpd_actual);

if($mycpd_year[1]=date("Y")) {
if($mycpd_year[1]=="") {$cpdyear=date("Y");} else {$cpdyear = $mycpd_year[1];}
if($mycpd_cumulative[1]=="") {$cpdcum="0";} else {$cpdcum = $mycpd_cumulative[1];}
if($mycpd_actual[1]=="") {$cpdact="0";} else {$cpdact = $mycpd_actual[1];}
//echo "Year: $cpdyear Cumulative: $cpdcum  Actual: $cpdact";
} 

$datetoday=date('Y-m-d');
$query = "UPDATE infokursus SET mycpdc='$cpdcum', mycpda='$cpdact', mycpddate = '$datetoday' WHERE nokp='$nokp' AND year='$year'";
mysqli_query($query) or die('Error, insert data failed');
//echo " - ". $cpdcum ." - ". $cpdact."<br>";


}
// end of mycpd grab function
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);

// Javascript for updating the progress bar and information
echo '<script language="javascript">
document.getElementById("progress").innerHTML="<div align=left style=\"width:'.$percent.';background-color:#FF0000;\">&nbsp;'.$percent.'&nbsp;</div>";
document.getElementById("information").innerHTML="'.$counter.'/'.$total.' row(s) processed. <br>Total Errors: '.$errorupdate.' record(s).";
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

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<p>Overall procees took $total_time seconds. Total Errors: '.$errorupdate.' record(s).<p>';
echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed."</script>';
echo "<b>MYCPD SYNC ENDED ON ".date('d-m-Y H:i:s');

?>