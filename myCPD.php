<?php
#
# MyCPD 2.0 PHP Integration Class
# RAJA MOHAMMAD HAFIZ
# V1.0
#
# 4 FUNCTIONS AVAILABLE ACCORDING TO WSDL
# 1. getUserInfo ($params)
# 2. getPointByCategory ($params)
# 3. getCumulativePoint ($params)
# 4. getHcpList()
#
# $params = [DateStart,DateEnd,Hcp,IdentityNo] - default to empty value
#

class MyCPD {
    private $wsdl = 'https://www.mycpd2.moh.gov.my/ws/Service1.svc?singleWsdl';
    private $client;

    public function __construct(){
        $this->client = new SoapClient($this->wsdl);
    }

    public function debug(){
        echo "<br>FUNCTIONS : <br>";
        var_dump($this->client->__getFunctions()); 
        echo "<br>TYPES : <br>";
        var_dump($this->client->__getTypes()); 
    }    

    public function getUserInfo($params){
        try{
            $userDetails = new UserDetails();
            $userDetails->setParam($params);
            $userInfo = new UserInfo($userDetails);
            $response = $this->client->__soapCall('UserInfo',[$userInfo]);

            return $response;
        }catch(Exception $e){

        }        
    }

    public function getPointByCategory($params){
        try{
            $userDetails = new UserDetails();
            $userDetails->setParam($params);
            $userInfo = new UserInfo($userDetails);
            $response = $this->client->__soapCall('PointByCategory',[$userInfo]);

            return $response;
        }catch(Exception $e){

        } 
    }

    public function getCumulativePoint($params){
        try{
            $userDetails = new UserDetails();
            $userDetails->setParam($params);
            $userInfo = new UserInfo($userDetails);
            $response = $this->client->__soapCall('CumulativePoint',[$userInfo]);
            //$response = $this->client->__getLastResponse() . "\n";            
            return $response;
            

        }catch(Exception $e){

        } 
    }

    public function getActualPoint($params){
        try{
            $userDetails = new UserDetails();
            $userDetails->setParam($params);
            $userInfo = new UserInfo($userDetails);
            $response = $this->client->__soapCall('ActualPoint',[$userInfo]);

            return $response;
        }catch(Exception $e){

        } 
    }

    public function getHcpList(){
        try{           
            $response = $this->client->__soapCall('HcpList',[]);
            
            return $response;
        }catch(Exception $e){

        } 
    }
}

class UserDetails{
    private $DateEnd = "";
    private $DateStart = "";
    private $Hcp = "";
    private $IdentityNo = "";

    public function setParam($params){
        $this->DateEnd = isset($params['DateEnd']) ? $params['DateEnd'] : "";
        $this->DateStart = isset($params['DateStart']) ? $params['DateStart'] : "";
        $this->Hcp = isset($params['Hcp']) ? $params['Hcp'] : "";
        $this->IdentityNo = isset($params['IdentityNo']) ? $params['IdentityNo'] : "";        
    }
}

class UserInfo{
    private $userdet;

    public function __construct(UserDetails $ud){
        $this->userdet = $ud;
    }
}

class PointByCategory {
    private $userdet;

    public function __construct(UserDetails $ud){
        $this->userdet = $ud;
    }
}

class CumulativePoint {
    private $userdet;

    public function __construct(UserDetails $ud){
        $this->userdet = $ud;
    }
}

class ActualPoint  {
    private $userdet;

    public function __construct(UserDetails $ud){
        $this->userdet = $ud;
    }
}

function checkmycpd($data1,$data2,$data3) {  

$hcpcheck=0;

switch($data2) {
case "JURURAWAT":           //JURURAWAT BERDAFTAR
    $hcp=8;$hcpcheck=1;
    break;    
case "JURURAWAT TERLATIH":  //JURURAWAT BERDAFTAR
    $hcp=8;$hcpcheck=1;
    break;
case "KETUA JURURAWAT":     //JURURAWAT BERDAFTAR
    $hcp=8;$hcpcheck=1;
    break;
case "PENYELIA JURURAWAT":  //JURURAWAT BERDAFTAR
    $hcp=8;$hcpcheck=1;
    break;
case "JURURAWAT MASYARAKAT":
    $hcp=70;$hcpcheck=1;
    break;
case "PEGAWAI OPT0METRI":   // PEGAWAI OPToMETRI - OPTOMETRIS
    $hcp=18;$hcpcheck=1;
    break;
case "PEGAWAI FARMASI":
    $hcp=2;$hcpcheck=1;
    break;
case "PENOLONG PEGAWAI FARMASI": // PENOLONG PEGAWAI FARMASI - PENOLONG FARMASI
    $hcp=34;$hcpcheck=1;
    break;
case "PEGAWAI KESIHATAN PERSEKITARAN":
    $hcp=62;$hcpcheck=1;
    break;
case "PEGAWAI PSIKOLOGI(KAUNSELING)":
    $hcp=11;$hcpcheck=1;
    break;
case "PENOLONG PEGAWAI TEKNOLOGI MAKLUMAT":
    $hcp=49;$hcpcheck=1;
    break;
case "PEGAWAI TEKNOLOGI MAKLUMAT":
    $hcp=32;$hcpcheck=1;
    break;
case "PEGAWAI DIETETIK":
    $hcp=19;$hcpcheck=1;
    break;
case "PEGAWAI PERGIGIAN":
    $hcp=3;$hcpcheck=1;
    break;
case "JURUTEKNOLOGI MAKMAL PERUBATAN":
    $hcp=10;$hcpcheck=1;
    break;
case "JURU X-RAY (DIAGNOSTIK)": //JURU X-RAY (DIAGNOSTIK) - JURURADIOGRAFI DIAGNOSTIK 
    $hcp=85;$hcpcheck=1;
    break;   
case "JURU X-RAY": //JURU X-RAY - JURURADIOGRAFI DIAGNOSTIK 
    $hcp=85;$hcpcheck=1;
    break;   
case "PEGAWAI PEMULIHAN PERUBATAN (PENDENGARAN)": //PEGAWAI PEMULIHAN PERUBATAN (PENDENGARAN) - AHLI AUDIOLOGI
    $hcp=15;$hcpcheck=1;
    break;   
case "JURUPULIH PERUBATAN (ANGGOTA)": //JURUPULIH PERUBATAN (ANGGOTA) - AHLI FISIOTERAPI
    $hcp=87;$hcpcheck=1;
    break;
case "JURUTEKNOLOGI PERGIGIAN": 
    $hcp=53;$hcpcheck=1;
    break; 
//case (preg_match("/PAKAR.*/", $data2) ? $data2 : !$data2):
case (preg_match('/PAKAR.*/', $data2) ? true : false):
    $hcp=1;$hcpcheck=1;
    break;
case "PENOLONG PEGAWAI TADBIR (REKOD PERUBATAN)":
    $hcp=90;$hcpcheck=1;
    break;
case "PEGAWAI TADBIR (REKOD PERUBATAN)":
    $hcp=67;$hcpcheck=1;
    break;
case "PENOLONG PEGAWAI PERUBATAN":
    $hcp=9;$hcpcheck=1;
    break;
case "PEGAWAI PERUBATAN":
    $hcp=1;$hcpcheck=1;
    break;
case "TIMBALAN PENGARAH(PERUBATAN)":
    $hcp=1;$hcpcheck=1;
    break;
case "PENGARAH HOSPITAL":
    $hcp=1;$hcpcheck=1;
    break;

    
}

//initialize the class
$mycpd = new MyCPD();
//set the params
$tahun=date("Y");

$params = [
    'DateStart' => $tahun.'-01-01',
    'DateEnd' => $tahun.'-12-31',
    'IdentityNo' => $data1,
    'Hcp' => $hcp
];

if($hcpcheck==1) {

if($data3==1){ //get Actual
$response2 = $mycpd->getActualPoint($params);
//echo var_dump($response2);
//echo "<br>Actual Point: ";
$actual=$response2->ActualPointResult;
//echo $actual."<br>";

return $actual;
}

if($data3==2) { //get Cumulative
$response3 = $mycpd->getCumulativePoint($params);
//echo var_dump($response3);
//echo "Cumulative: ";
$cumulative=$response3->CumulativePointResult;
//echo $cumulative."<br>";
return $cumulative;
}

} else {
return $hcpcheck;    
}

}

