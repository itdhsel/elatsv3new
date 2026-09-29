<?php

/*
function checkmycpd($data1,$data2,$data3) {  

//require the file
require_once('myCPD.php');

//initialize the class
$mycpd = new MyCPD();
//set the params
$params = [
    'DateStart' => '2017-01-01',
    'DateEnd' => '2017-12-31',
    //'IdentityNo' => '620902085419',
    'IdentityNo' => $data1,
    //'Hcp' => 1
    'Hcp' => $data2
];


if($data3==1){
$response2 = $mycpd->getActualPoint($params);
//echo var_dump($response2);
//echo "<br>Actual Point: ";
$actual=$response2->ActualPointResult;
//echo $actual."<br>";

return $actual;
}

if($data3==2) {
$response3 = $mycpd->getCumulativePoint($params);
//echo var_dump($response3);
//echo "Cumulative: ";
$cumulative=$response3->CumulativePointResult;
//echo $cumulative."<br>";
return $cumulative;
}

}
*/

require_once('myCPD.php');

$mycpd = new MyCPD();
//set the params
$params = [
    'DateStart' => '',
    'DateEnd' => '',
    'IdentityNo' => '',
    'Hcp' => 1
];

$response = $mycpd->getHcpList();
var_dump($response);

//echo checkmycpd(850724146226,1,1)."<br>";
//echo checkmycpd(850724146226,1,2)."<br>";



//set_time_limit(0);

$jawatan="PAKAR PERUBATAN KANAK-KANAK";
$year= date("Y");
$nokp="650613075238";

$cpdact=checkmycpd($nokp,$jawatan,1);
$cpdcum=checkmycpd($nokp,$jawatan,2);

echo "<br>No KP: ".$nokp;
echo "<br>Jawatan: ".$jawatan;
echo "<br>Actual: ".$cpdact;
echo "<br>Cumulative: ".$cpdcum;