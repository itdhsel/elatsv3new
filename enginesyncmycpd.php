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
<td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">SYNC DATA MYCPD KAKITANGAN TAHUN <?php echo $tahun1; ?></div></td>
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

$selectdata1 = "SELECT nokp,namapegawai,email FROM peribadi WHERE status = 'AKTIF' ORDER BY namapegawai";
$result1 = mysqli_query($selectdata1);
$total = mysqli_num_rows($result1); 

//echo "<html><head><title>WEB ENGINE - CHECK KURSUS REMINDER</title><style type='text/css'> td { font-size: xx-small; face: verdana; }</style></head><body>";
echo "<h4>WEB ENGINE SYNC MYCPD STARTED ON ". date('d-m-Y h:i:s A') ."</h4>";
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

//echo "<tr><td valign=top>Record ".$counter." : ".$capturedata1['namapegawai']." - ".$capturedata1['nokp']."</td> ";

$nokp=$capturedata1['nokp'];
// get data from mycpd function

$url = 'http://www.mycpd.moh.gov.my/apc/default.aspx';
$ic=$nokp;
$year= date("Y");

$data = array(
  //"__VIEWSTATE" => "/wEPDwUJMzk1NjkxNjIwD2QWAgIDD2QWEAIDDxAPFgYeDkRhdGFWYWx1ZUZpZWxkBQJpZB4NRGF0YVRleHRGaWVsZAUDZGF5HgtfIURhdGFCb3VuZGdkEBUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFR8BMQEyATMBNAE1ATYBNwE4ATkCMTACMTECMTICMTMCMTQCMTUCMTYCMTcCMTgCMTkCMjACMjECMjICMjMCMjQCMjUCMjYCMjcCMjgCMjkCMzACMzEUKwMfZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2RkAgUPEA8WBh8ABQJpZB8BBQVtb250aB8CZ2QQFQwHSmFudWFyeQhGZWJydWFyeQVNYXJjaAVBcHJpbANNYXkESnVuZQRKdWx5BkF1Z3VzdAlTZXB0ZW1iZXIHT2N0b2JlcghOb3ZlbWJlcghEZWNlbWJlchUMATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyFCsDDGdnZ2dnZ2dnZ2dnZ2RkAgcPEGQQFQMEMjAxMwQyMDE0BDIwMTUVAwQyMDEzBDIwMTQEMjAxNRQrAwNnZ2dkZAIJDxAPFgYfAAUCaWQfAQUDZGF5HwJnZBAVHwExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMgIxMwIxNAIxNQIxNgIxNwIxOAIxOQIyMAIyMQIyMgIyMwIyNAIyNQIyNgIyNwIyOAIyOQIzMAIzMRUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFCsDH2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dkZAILDxAPFgYfAAUCaWQfAQUFbW9udGgfAmdkEBUMB0phbnVhcnkIRmVicnVhcnkFTWFyY2gFQXByaWwDTWF5BEp1bmUESnVseQZBdWd1c3QJU2VwdGVtYmVyB09jdG9iZXIITm92ZW1iZXIIRGVjZW1iZXIVDAExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMhQrAwxnZ2dnZ2dnZ2dnZ2dkZAINDxBkEBUDBDIwMTMEMjAxNAQyMDE1FQMEMjAxMwQyMDE0BDIwMTUUKwMDZ2dnZGQCDw8PZBYCHgdvbmNsaWNrBSBqYXZhc2NyaXB0OnJldHVybiBjaGVja0lzRW1wdHkoKWQCGw88KwANAGQYAQUJR3JpZFZpZXcxD2dkqQxPF4Kekuv0APLqD+s0nvzweek=",
  "__VIEWSTATE" => "/wEPDwUJMzk1NjkxNjIwD2QWAgIDD2QWGgIDDxAPFgYeDkRhdGFWYWx1ZUZpZWxkBQJpZB4NRGF0YVRleHRGaWVsZAUDZGF5HgtfIURhdGFCb3VuZGdkEBUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFR8BMQEyATMBNAE1ATYBNwE4ATkCMTACMTECMTICMTMCMTQCMTUCMTYCMTcCMTgCMTkCMjACMjECMjICMjMCMjQCMjUCMjYCMjcCMjgCMjkCMzACMzEUKwMfZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2RkAgUPEA8WBh8ABQJpZB8BBQVtb250aB8CZ2QQFQwHSmFudWFyeQhGZWJydWFyeQVNYXJjaAVBcHJpbANNYXkESnVuZQRKdWx5BkF1Z3VzdAlTZXB0ZW1iZXIHT2N0b2JlcghOb3ZlbWJlcghEZWNlbWJlchUMATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyFCsDDGdnZ2dnZ2dnZ2dnZ2RkAgcPEGQQFQMEMjAxNAQyMDE1BDIwMTYVAwQyMDE0BDIwMTUEMjAxNhQrAwNnZ2dkZAIJDxAPFgYfAAUCaWQfAQUDZGF5HwJnZBAVHwExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMgIxMwIxNAIxNQIxNgIxNwIxOAIxOQIyMAIyMQIyMgIyMwIyNAIyNQIyNgIyNwIyOAIyOQIzMAIzMRUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFCsDH2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dkZAILDxAPFgYfAAUCaWQfAQUFbW9udGgfAmdkEBUMB0phbnVhcnkIRmVicnVhcnkFTWFyY2gFQXByaWwDTWF5BEp1bmUESnVseQZBdWd1c3QJU2VwdGVtYmVyB09jdG9iZXIITm92ZW1iZXIIRGVjZW1iZXIVDAExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMhQrAwxnZ2dnZ2dnZ2dnZ2dkZAINDxBkEBUDBDIwMTQEMjAxNQQyMDE2FQMEMjAxNAQyMDE1BDIwMTYUKwMDZ2dnZGQCDw8PZBYCHgdvbmNsaWNrBSBqYXZhc2NyaXB0OnJldHVybiBjaGVja0lzRW1wdHkoKWQCEQ8PFgIeBFRleHQFG05hbWUgOiBTQUxNSSBCSU5USSBBQkRVTExBSGRkAhMPDxYCHwQFF0hDUCA6IFBlZ2F3YWkgUGVydWJhdGFuZGQCFQ9kFgICAQ9kFgICAQ8PFgIfBAUOR3JhZGUgOiBLaGFzIENkZAIXDw8WAh8EBRpJQyBObyAoTmV3KSA6IDcxMDcxMDEwNTE1NGRkAhkPZBYCAgEPZBYCAgEPDxYCHwQFDFN1cGVydmlzb3IgLWRkAhsPPCsADQEADxYEHwJnHgtfIUl0ZW1Db3VudAIBZBYCZg9kFgQCAQ9kFgZmDw8WAh8EBQQyMDE2ZGQCAQ8PFgIfBAUCMzhkZAICDw8WAh8EBQIzOGRkAgIPDxYCHgdWaXNpYmxlaGRkGAEFCUdyaWRWaWV3MQ88KwAKAQgCAWRZw/Z80tM7vyhMC6Y6sp6coojS3g==",
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
    'content' => http_build_query($data),
    ),
  );
$context  = stream_context_create($options);
$response = @file_get_contents($url, false, $context);

//echo $response;
//if ($response===FALSE) { echo "<td colspan=2 align='center' bgcolor=red><b>- ERROR UPDATING -</b></td>"; }
if ($response===FALSE) { echo "<br>- ERROR UPDATING MYCPD DATA (KP ".$nokp.") -</b></td>"; }

else {

preg_match('#No user found#Uis', $response, $nouser);
preg_match('#<td align="center" width="100">([0-9\.]*)</td>#Uis', $response, $mycpd_year);
preg_match('#<td align="center" width="150">([0-9\.]*)</td>#Uis', $response, $mycpd_cumulative);
preg_match('#<td align="center" width="120">([0-9\.]*)</td>#Uis', $response, $mycpd_actual);

if($cpdyear=date("Y")) {
if($mycpd_year[1]=="") {$cpdyear=date("Y");} else {$cpdyear = $mycpd_year[1];}
if($mycpd_cumulative[1]=="") {$cpdcum="0";} else {$cpdcum = $mycpd_cumulative[1];}
if($mycpd_actual[1]=="") {$cpdact="0";} else {$cpdact = $mycpd_actual[1];}
//echo "Year: $cpdyear Cumulative: $cpdcum  Actual: $cpdact";
} 

$datetoday=date('Y-m-d');

$query = "UPDATE infokursus SET mycpdc='$cpdcum', mycpda='$cpdact', mycpddate = '$datetoday' WHERE nokp='$nokp' AND year='$year'";
mysqli_query($query) or die('Error, insert data failed');

//echo "<td bgcolor='#ffffff' align='center' width='15%'>". $cpdcum ."</td><td width='15%' bgcolor='#ffffff' align='center'>". $cpdact."</td>";

}
// end of mycpd grab function

//echo "<td align=left>";
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

    // fully display progress details
    //document.getElementById("information").innerHTML="'.$counter.'/'.$total.' row(s) processed. <br>Time taken has been '.$total_time.' seconds. <br>Speed is '.$counter/$total_time.' row per second.";
    
    // lite progress details
    //document.getElementById("information").innerHTML="'.$counter.'/'.$total.' row(s) processed.";

 
// This is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*64);

// Send output to browser immediately
    flush();
 
// Sleep one second so we can see the delay for server to process queue
    sleep(1);
    
//echo "</td>"; 

//echo "</tr>";
$counter=$counter+1;
}
//echo "</table>";  

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<p><h4>Page generated in '.$total_time.' seconds.</h4>';
echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';
echo "<H4>WEB ENGINE CHECK KURSUS REMINDER ENDED ON ".date('d-m-Y h:i:s A'); 
echo "</H4></font>";


$query = "UPDATE metaconf SET value = '$datetoday' WHERE var='mycpddate'";
mysqli_query($query) or die('Error, insert data failed');

?>

</td></tr>
</table>
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