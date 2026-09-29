<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */


$url = 'http://www.mycpd.moh.gov.my/apc/default.aspx';
$opts = array('http' =>
    array(
        'method'  => 'GET',
        'timeout' => 120 
    )
);
$context1  = stream_context_create($opts);
$response1 = @file_get_contents($url, false, $context1);
preg_match('#<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.*)" />#Uis', $response1, $state);
//echo $state[1];


$nokp="590125015015";
// get data from mycpd function


$ic=$nokp;
$year= date("Y");

$data = array(
  //"__VIEWSTATE" => "/wEPDwUJMzk1NjkxNjIwD2QWAgIDD2QWEAIDDxAPFgYeDkRhdGFWYWx1ZUZpZWxkBQJpZB4NRGF0YVRleHRGaWVsZAUDZGF5HgtfIURhdGFCb3VuZGdkEBUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFR8BMQEyATMBNAE1ATYBNwE4ATkCMTACMTECMTICMTMCMTQCMTUCMTYCMTcCMTgCMTkCMjACMjECMjICMjMCMjQCMjUCMjYCMjcCMjgCMjkCMzACMzEUKwMfZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2RkAgUPEA8WBh8ABQJpZB8BBQVtb250aB8CZ2QQFQwHSmFudWFyeQhGZWJydWFyeQVNYXJjaAVBcHJpbANNYXkESnVuZQRKdWx5BkF1Z3VzdAlTZXB0ZW1iZXIHT2N0b2JlcghOb3ZlbWJlcghEZWNlbWJlchUMATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyFCsDDGdnZ2dnZ2dnZ2dnZ2RkAgcPEGQQFQMEMjAxMwQyMDE0BDIwMTUVAwQyMDEzBDIwMTQEMjAxNRQrAwNnZ2dkZAIJDxAPFgYfAAUCaWQfAQUDZGF5HwJnZBAVHwExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMgIxMwIxNAIxNQIxNgIxNwIxOAIxOQIyMAIyMQIyMgIyMwIyNAIyNQIyNgIyNwIyOAIyOQIzMAIzMRUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFCsDH2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dkZAILDxAPFgYfAAUCaWQfAQUFbW9udGgfAmdkEBUMB0phbnVhcnkIRmVicnVhcnkFTWFyY2gFQXByaWwDTWF5BEp1bmUESnVseQZBdWd1c3QJU2VwdGVtYmVyB09jdG9iZXIITm92ZW1iZXIIRGVjZW1iZXIVDAExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMhQrAwxnZ2dnZ2dnZ2dnZ2dkZAINDxBkEBUDBDIwMTMEMjAxNAQyMDE1FQMEMjAxMwQyMDE0BDIwMTUUKwMDZ2dnZGQCDw8PZBYCHgdvbmNsaWNrBSBqYXZhc2NyaXB0OnJldHVybiBjaGVja0lzRW1wdHkoKWQCGw88KwANAGQYAQUJR3JpZFZpZXcxD2dkqQxPF4Kekuv0APLqD+s0nvzweek=",
  //"__VIEWSTATE" => "/wEPDwUJMzk1NjkxNjIwD2QWAgIDD2QWGgIDDxAPFgYeDkRhdGFWYWx1ZUZpZWxkBQJpZB4NRGF0YVRleHRGaWVsZAUDZGF5HgtfIURhdGFCb3VuZGdkEBUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFR8BMQEyATMBNAE1ATYBNwE4ATkCMTACMTECMTICMTMCMTQCMTUCMTYCMTcCMTgCMTkCMjACMjECMjICMjMCMjQCMjUCMjYCMjcCMjgCMjkCMzACMzEUKwMfZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2RkAgUPEA8WBh8ABQJpZB8BBQVtb250aB8CZ2QQFQwHSmFudWFyeQhGZWJydWFyeQVNYXJjaAVBcHJpbANNYXkESnVuZQRKdWx5BkF1Z3VzdAlTZXB0ZW1iZXIHT2N0b2JlcghOb3ZlbWJlcghEZWNlbWJlchUMATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyFCsDDGdnZ2dnZ2dnZ2dnZ2RkAgcPEGQQFQMEMjAxNAQyMDE1BDIwMTYVAwQyMDE0BDIwMTUEMjAxNhQrAwNnZ2dkZAIJDxAPFgYfAAUCaWQfAQUDZGF5HwJnZBAVHwExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMgIxMwIxNAIxNQIxNgIxNwIxOAIxOQIyMAIyMQIyMgIyMwIyNAIyNQIyNgIyNwIyOAIyOQIzMAIzMRUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFCsDH2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dkZAILDxAPFgYfAAUCaWQfAQUFbW9udGgfAmdkEBUMB0phbnVhcnkIRmVicnVhcnkFTWFyY2gFQXByaWwDTWF5BEp1bmUESnVseQZBdWd1c3QJU2VwdGVtYmVyB09jdG9iZXIITm92ZW1iZXIIRGVjZW1iZXIVDAExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMhQrAwxnZ2dnZ2dnZ2dnZ2dkZAINDxBkEBUDBDIwMTQEMjAxNQQyMDE2FQMEMjAxNAQyMDE1BDIwMTYUKwMDZ2dnZGQCDw8PZBYCHgdvbmNsaWNrBSBqYXZhc2NyaXB0OnJldHVybiBjaGVja0lzRW1wdHkoKWQCEQ8PFgIeBFRleHQFG05hbWUgOiBTQUxNSSBCSU5USSBBQkRVTExBSGRkAhMPDxYCHwQFF0hDUCA6IFBlZ2F3YWkgUGVydWJhdGFuZGQCFQ9kFgICAQ9kFgICAQ8PFgIfBAUOR3JhZGUgOiBLaGFzIENkZAIXDw8WAh8EBRpJQyBObyAoTmV3KSA6IDcxMDcxMDEwNTE1NGRkAhkPZBYCAgEPZBYCAgEPDxYCHwQFDFN1cGVydmlzb3IgLWRkAhsPPCsADQEADxYEHwJnHgtfIUl0ZW1Db3VudAIBZBYCZg9kFgQCAQ9kFgZmDw8WAh8EBQQyMDE2ZGQCAQ8PFgIfBAUCMzhkZAICDw8WAh8EBQIzOGRkAgIPDxYCHgdWaXNpYmxlaGRkGAEFCUdyaWRWaWV3MQ88KwAKAQgCAWRZw/Z80tM7vyhMC6Y6sp6coojS3g==",
  //"__VIEWSTATE" => "/wEPDwUJMzk1NjkxNjIwD2QWAgIDD2QWGgIDDxAPFgYeDkRhdGFWYWx1ZUZpZWxkBQJpZB4NRGF0YVRleHRGaWVsZAUDZGF5HgtfIURhdGFCb3VuZGdkEBUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFR8BMQEyATMBNAE1ATYBNwE4ATkCMTACMTECMTICMTMCMTQCMTUCMTYCMTcCMTgCMTkCMjACMjECMjICMjMCMjQCMjUCMjYCMjcCMjgCMjkCMzACMzEUKwMfZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2RkAgUPEA8WBh8ABQJpZB8BBQVtb250aB8CZ2QQFQwHSmFudWFyeQhGZWJydWFyeQVNYXJjaAVBcHJpbANNYXkESnVuZQRKdWx5BkF1Z3VzdAlTZXB0ZW1iZXIHT2N0b2JlcghOb3ZlbWJlcghEZWNlbWJlchUMATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyFCsDDGdnZ2dnZ2dnZ2dnZ2RkAgcPEGQQFQMEMjAxNAQyMDE1BDIwMTYVAwQyMDE0BDIwMTUEMjAxNhQrAwNnZ2dkZAIJDxAPFgYfAAUCaWQfAQUDZGF5HwJnZBAVHwExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMgIxMwIxNAIxNQIxNgIxNwIxOAIxOQIyMAIyMQIyMgIyMwIyNAIyNQIyNgIyNwIyOAIyOQIzMAIzMRUfATEBMgEzATQBNQE2ATcBOAE5AjEwAjExAjEyAjEzAjE0AjE1AjE2AjE3AjE4AjE5AjIwAjIxAjIyAjIzAjI0AjI1AjI2AjI3AjI4AjI5AjMwAjMxFCsDH2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dkZAILDxAPFgYfAAUCaWQfAQUFbW9udGgfAmdkEBUMB0phbnVhcnkIRmVicnVhcnkFTWFyY2gFQXByaWwDTWF5BEp1bmUESnVseQZBdWd1c3QJU2VwdGVtYmVyB09jdG9iZXIITm92ZW1iZXIIRGVjZW1iZXIVDAExATIBMwE0ATUBNgE3ATgBOQIxMAIxMQIxMhQrAwxnZ2dnZ2dnZ2dnZ2dkZAINDxBkEBUDBDIwMTQEMjAxNQQyMDE2FQMEMjAxNAQyMDE1BDIwMTYUKwMDZ2dnZGQCDw8PZBYCHgdvbmNsaWNrBSBqYXZhc2NyaXB0OnJldHVybiBjaGVja0lzRW1wdHkoKWQCEQ8PFgIeBFRleHQFDU5vIHVzZXIgZm91bmRkZAITDw8WAh8EZWRkAhUPZBYCAgEPZBYCAgEPDxYCHwRlZGQCFw8PFgIfBGVkZAIZD2QWAgIBD2QWAgIBDw8WAh8EZWRkAhsPPCsADQBkGAEFCUdyaWRWaWV3MQ9nZEOisMuvThJ2DkSCmrE2J7R17FbJ",
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

echo "Output: ".$nouser[1]." ".$mycpd_year[1]." ".$mycpd_cumulative[1]." ".$mycpd_actual[1]."<br>";

$datetoday=date('Y-m-d');

$query = "UPDATE infokursus SET mycpdc='$cpdcum', mycpda='$cpdact', mycpddate = '$datetoday' WHERE nokp='$nokp' AND year='$year'";
//mysqli_query($query) or die('Error, insert data failed');
echo $query;

//echo "<td bgcolor='#ffffff' align='center' width='15%'>". $cpdcum ."</td><td width='15%' bgcolor='#ffffff' align='center'>". $cpdact."</td>";

}
// end of mycpd grab function


?>
