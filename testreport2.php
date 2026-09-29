<?php
// --- securing include file ---
if (isset($ping) != "pong") {
     exit('<h2>You cannot access this file directly!</h2>');
}
// --- end securing include file --
?>
<?php

include 'files/db.php';

//$kumpulan = $_POST['kumpulan'];
//$kumpulan = "SOKONGAN 1";

/*
$array = array("PENGURUSAN TERTINGGI", "PENGURUSAN DAN PROFESIONAL", "SOKONGAN 1", "SOKONGAN 2");

//$tarikh_belum1 = $_POST['tarikh_belum1'];
$tarikh_belum1 = "01-01-2014";
$hari=substr("$tarikh_belum1",0,2);
$bulan=substr("$tarikh_belum1",3,2);
$tahun=substr("$tarikh_belum1",6,4);
$tarikh_mula="$tahun"."-"."$bulan"."-"."$hari";

//$tarikh_belum2 = $_POST['tarikh_belum2'];
$tarikh_belum2 ="31-07-2014";
$hari=substr("$tarikh_belum2",0,2);
$bulan=substr("$tarikh_belum2",3,2);
$tahun=substr("$tarikh_belum2",6,4);
$tarikh_tamat="$tahun"."-"."$bulan"."-"."$hari";

$today = date("Y-m-d");
$jusa1=0;
$pnp1=0;
$sokongan11=0;
$sokongan21=0;

$count = count($array);

for ($i = 0; $i < $count; $i++) {
    
    $kumpulan=$array[$i];
    //echo "<p>". $kumpulan ."<p>";

      $strSQL = "SELECT k.valid, n.namapegawai, n.nokp, n.skim_khidmat,n.gredhakiki, n.kumpulan,n.jabatan,n.status, sum(k.total_jam) DIV 6 as hari, MOD(sum(k.total_jam),6) as jam_tinggal                     
               FROM peribadi n, kursus k
               WHERE k.nokp2 = n.nokp
               AND n.kumpulan = '$kumpulan' AND k.valid = 1 
               AND n.status = 'AKTIF'
               AND k.tarikh_mula BETWEEN '$tarikh_mula' AND '$tarikh_tamat'
               AND k.tarikh_tamat BETWEEN '$tarikh_mula' AND '$tarikh_tamat'
               GROUP BY n.nokp
               ORDER BY k.total_jam";

		$result = mysqli_query($strSQL);
		$found = mysqli_num_rows($result);
		
	  echo $strSQL."<p>";
		

	while($capture = mysqli_fetch_array($result))
	{
    if( $capture['hari'] > 6)
		{
      if ($kumpulan=="PENGURUSAN TERTINGGI")
      {
      $jusa1=$jusa1+1;
      }	
      if ($kumpulan=="PENGURUSAN DAN PROFESIONAL")
      {
      $pnp1=$pnp1+1;
      }	
      if ($kumpulan=="SOKONGAN 1")
      {
      $sokongan11=$sokongan11+1;
      }	
      if ($kumpulan=="SOKONGAN 2")
      {
      $sokongan21=$sokongan21+1;
      }	                  							
		}
    if( $capture['hari'] < 7)
		{
      if ($kumpulan=="PENGURUSAN TERTINGGI")
      {
      $jusa2=$jusa2+1;
      }	
      if ($kumpulan=="PENGURUSAN DAN PROFESIONAL")
      {
      $pnp2=$pnp2+1;
      }	
      if ($kumpulan=="SOKONGAN 1")
      {
      $sokongan12=$sokongan12+1;
      }	
      if ($kumpulan=="SOKONGAN 2")
      {
      $sokongan22=$sokongan22+1;
      }	                  							
		}
    if( $capture['hari'] == 0)
		{
      if ($kumpulan=="PENGURUSAN TERTINGGI")
      {
      $jusa3=$jusa3+1;
      }	
      if ($kumpulan=="PENGURUSAN DAN PROFESIONAL")
      {
      $pnp3=$pnp3+1;
      }	
      if ($kumpulan=="SOKONGAN 1")
      {
      $sokongan13=$sokongan13+1;
      }	
      if ($kumpulan=="SOKONGAN 2")
      {
      $sokongan23=$sokongan23+1;
      }	                  							
		}

	}




}
     

$jumlah1=$jusa1+$pnp1+$sokongan11+$sokongan21;
$jumlah2=$jusa2+$pnp2+$sokongan12+$sokongan22;
$jumlah3=$jusa3+$pnp3+$sokongan13+$sokongan23;

echo "<table border=1 width=100%>";
echo "<tr><td rowspan=2>Bil</td><td rowspan=2>Gred/Kumpulan</td><td colspan=3 align=center>Kursus Pendek</td></tr>";
echo "<tr><td align=center>Bilangan Anggota Yang Hadir > 7 hari setahun</td><td align=center>Bilangan Anggota Yang Hadir < 7 hari setahun</td><td align=center>Bilangan Anggota yang tdak berkursus</td>";
echo "<tr><td align=center>1</td><td align=center>PENGURUSAN TERTINGGI</td><td align=center>".$jusa1."</td><td align=center>".$jusa2."</td><td align=center>".$jusa3."</td></tr>";                                               
echo "<tr><td align=center>2</td><td align=center>PENGURUSAN DAN PROFESIONAL</td><td align=center>".$pnp1."</td><td align=center>".$pnp2."</td><td align=center>".$pnp3."</td></tr>";
echo "<tr><td align=center>3</td><td align=center>SOKONGAN 1</td><td align=center>".$sokongan11."</td><td align=center>".$sokongan12."</td><td align=center>".$sokongan13."</td></tr>";
echo "<tr><td align=center>4</td><td align=center>SOKONGAN 2</td><td align=center>".$sokongan21."</td><td align=center>".$sokongan22."</td><td align=center>".$sokongan23."</td></tr>";
echo "<tr><td colspan=2>JUMLAH</td><td align=center>".$jumlah1."</td><td align=center>".$jumlah2."</td><td align=center>".$jumlah3."</td></tr>";
echo "</table>";






$selectdata2a = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= 'PENGURUSAN DAN PROFESIONAL'
                 AND i.year='$year_today' 
                 AND i.day < 7";


      $result8 = mysqli_query($selectdata2a);
      $found8 = mysqli_num_rows($result8);

*/
echo "<center>";
echo "<br><br><b>LAPORAN KESELURUHAN PRESTASI LATIHAN DALAM PERKHIDMATAN KEMENTERIAN KESIHATAN MALAYSIA HOSPITAL $year_today</b><br>";
echo "(Sila klik pada data untuk maklumat terperinci)<br><br>";

/*
set_time_limit(500);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

*/

//$year_today = date("Y");

$selectdata1 = "SELECT distinct(kumpulan) FROM `peribadi` WHERE kumpulan is NOT NULL";
//$selectdata1 = "SELECT distinct(kumpulan) FROM `peribadi`";
$result1 = mysqli_query($selectdata1);
$total = mysqli_num_rows($result1); 

echo "<table border=0 width=80% cellspacing=2 cellpadding=2><tr bgcolor=#c0c0c0><td rowspan=2>KUMPULAN</td><td colspan=9 align=center>HARI</td><td rowspan=2>JUMLAH</td></tr><tr bgcolor=#c0c0c0><td align=center> >7 </td><td align=center> 7 </td><td align=center> 6 </td><td align=center> 5 </td><td align=center> 4 </td><td align=center> 3 </td><td align=center> 2 </td><td align=center> 1 </td><td align=center> 0 </td></tr>";

$datamore7=0;
$data7=0;
$data6=0;
$data5=0;
$data4=0;
$data3=0;
$data2=0;
$data1=0;
$data0=0;

while($capturedata1 = mysqli_fetch_array ($result1))
{
$counter=0;

echo "<tr bgcolor=white ><td>".$capturedata1["kumpulan"]."</td>";

$kumpulan=$capturedata1["kumpulan"];


$total = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.status = 'AKTIF'                 
                 AND i.year='$year_today' "; 

$resulttotal = mysqli_query($total);
$totalstotal = mysqli_num_rows($resulttotal);   


$totalo = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND p.status = 'AKTIF'                 
                 AND i.year='$year_today' "; 

$resulttotalo = mysqli_query($totalo);
$totalstotalo = mysqli_num_rows($resulttotalo);   


$more7 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'                 
                 AND i.day > 7";

$resultmore7 = mysqli_query($more7);
$totalmore7 = mysqli_num_rows($resultmore7);   

$totalmore7p=$totalmore7/$totalstotal*100;
$totalmore7p=number_format((float)$totalmore7p, 2, '.', '');


echo "<td align=center><a href='statsdetail.php?data=4&d=8&k=$kumpulan'>$totalmore7</a><br> ($totalmore7p%)</td>";  
$counter=$counter+$totalmore7;   
$datamore7=$datamore7+$totalmore7;

$sharp7 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'
                 AND i.day = 7 ";

$resultsharp7 = mysqli_query($sharp7);
$totalsharp7 = mysqli_num_rows($resultsharp7);   

$totalsharp7p=$totalsharp7/$totalstotal*100;
$totalsharp7p=number_format((float)$totalsharp7p, 2, '.', '');

echo "<td align=center><a href='statsdetail.php?data=4&d=7&k=$kumpulan'>$totalsharp7</a><br> ($totalsharp7p%)</td>";  
$counter=$counter+$totalsharp7;   
$data7=$data7+$totalsharp7;         

$sharp6 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'                 
                 AND i.day = 6 ";

$resultsharp6 = mysqli_query($sharp6);
$totalsharp6 = mysqli_num_rows($resultsharp6);   

$totalsharp6p=$totalsharp6/$totalstotal*100;
$totalsharp6p=number_format((float)$totalsharp6p, 2, '.', '');


echo "<td align=center><a href='statsdetail.php?data=4&d=6&k=$kumpulan'>$totalsharp6</a><br> ($totalsharp6p%)</td>"; 
$counter=$counter+$totalsharp6;    
$data6=$data6+$totalsharp6;  

$sharp5 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'                 
                 AND i.day = 5 ";

$resultsharp5 = mysqli_query($sharp5);
$totalsharp5 = mysqli_num_rows($resultsharp5);   

$totalsharp5p=$totalsharp5/$totalstotal*100;
$totalsharp5p=number_format((float)$totalsharp5p, 2, '.', '');


echo "<td align=center><a href='statsdetail.php?data=4&d=5&k=$kumpulan'>$totalsharp5</a><br> ($totalsharp5p%)</td>"; 
$counter=$counter+$totalsharp5;  
$data5=$data5+$totalsharp5;     

$sharp4 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'                 
                 AND i.day = 4 ";

$resultsharp4 = mysqli_query($sharp4);
$totalsharp4 = mysqli_num_rows($resultsharp4);   

$totalsharp4p=$totalsharp4/$totalstotal*100;
$totalsharp4p=number_format((float)$totalsharp4p, 2, '.', '');


echo "<td align=center><a href='statsdetail.php?data=4&d=4&k=$kumpulan'>$totalsharp4</a><br> ($totalsharp4p%)</td>";  
$counter=$counter+$totalsharp4;   
$data4=$data4+$totalsharp4;   

$sharp3 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'                 
                 AND i.day = 3 ";

$resultsharp3 = mysqli_query($sharp3);
$totalsharp3 = mysqli_num_rows($resultsharp3);   

$totalsharp3p=$totalsharp3/$totalstotal*100;
$totalsharp3p=number_format((float)$totalsharp3p, 2, '.', '');


echo "<td align=center><a href='statsdetail.php?data=4&d=3&k=$kumpulan'>$totalsharp3</a><br> ($totalsharp3p%)</td>";  
$counter=$counter+$totalsharp3;  
$data3=$data3+$totalsharp3;    

$sharp2 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'                 
                 AND i.day = 2 ";

$resultsharp2 = mysqli_query($sharp2);
$totalsharp2 = mysqli_num_rows($resultsharp2);   

$totalsharp2p=$totalsharp2/$totalstotal*100;
$totalsharp2p=number_format((float)$totalsharp2p, 2, '.', '');


echo "<td align=center><a href='statsdetail.php?data=4&d=2&k=$kumpulan'>$totalsharp2</a><br> ($totalsharp2p%)</td>";
$counter=$counter+$totalsharp2;      
$data2=$data2+$totalsharp2;  

$sharp1 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'                 
                 AND i.day = 1 ";

$resultsharp1 = mysqli_query($sharp1);
$totalsharp1 = mysqli_num_rows($resultsharp1);   

$totalsharp1p=$totalsharp1/$totalstotal*100;
$totalsharp1p=number_format((float)$totalsharp1p, 2, '.', '');

echo "<td align=center><a href='statsdetail.php?data=4&d=1&k=$kumpulan'>$totalsharp1</a><br> ($totalsharp1p%)</td>"; 
$counter=$counter+$totalsharp1;     
$data1=$data1+$totalsharp1;  

$sharp0 = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.kumpulan= '$kumpulan'
                 AND i.year='$year_today' 
                 AND p.status = 'AKTIF'                 
                 AND i.day = 0 ";

$resultsharp0 = mysqli_query($sharp0);
$totalsharp0 = mysqli_num_rows($resultsharp0);   

$totalsharp0p=$totalsharp0/$totalstotal*100;
$totalsharp0p=number_format((float)$totalsharp0p, 2, '.', '');

echo "<td align=center><a href='statsdetail.php?data=4&d=0&k=$kumpulan'>$totalsharp0</a><br> ($totalsharp0p%)</td>"; 
$counter=$counter+$totalsharp0;     
$data0=$data0+$totalsharp0;  


echo "<td align=center>$totalstotalo</td>";  
//echo "<td align=center>$counter</td>";


echo "</tr>";

}

$total = "SELECT p.nokp, p.kumpulan, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
                 FROM peribadi p,infokursus i 
                 WHERE p.nokp = i.nokp 
                 AND p.status = 'AKTIF'                 
                 AND i.year='$year_today' "; 

$resulttotal = mysqli_query($total);
$totalstotal = mysqli_num_rows($resulttotal);   

echo "<tr bgcolor=white ><td align=center>&nbsp;</td><td align=center>$datamore7</td><td align=center>$data7</td><td align=center>$data6</td><td align=center>$data5</td><td align=center>$data4</td><td align=center>$data3</td><td align=center>$data2</td><td align=center>$data1</td><td align=center>$data0</td><td align=center>$totalstotal</td></tr>";

echo "</table>";

// --- engine code ends here ---
/*
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<p><h5>[ Statistik dijana dalam '.$total_time.' saat. ]</h5>';
*/

echo "</center>";


?>