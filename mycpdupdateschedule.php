<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include('files/db.php');
?>
<table width="100%">
<tr>
<?php 
$tahun1 = date("Y");
//$tahun1="2014"; 
?>
<td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">PENGEMASKINIAN DATA MAKLUMAT KURSUS KAKITANGAN TAHUN <?php echo $tahun1; ?></div></td>
</tr>
</table>
<br> 

<table><tr><td>
<!-- Progress bar holder -->
<div id="progress" style="width:500px;border:1px solid #FF0000;"></div>
<!-- Progress information -->
<div id="information" style="width"></div>     
</td></tr></table>
<br>

<font face='verdana' size=1>
<b>WEB ENGINE DBSYNC STARTED ON <?php echo date('d-m-Y H:i:s'); ?></b><p>
<?php

set_time_limit(0);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

$staffdata = "SELECT nokp,namapegawai,email FROM peribadi WHERE status = 'AKTIF' ORDER BY namapegawai limit 10";
$resultstaff = mysqli_query($staffdata);  
//$founddata0 = mysqli_fetch_array ($staffdata);    
$total = mysqli_num_rows($resultstaff);        

//echo $total;

$inserto=0;
$updato=0;
  

//echo "<table width=90%>";

$counter=1;
while($capturestaff = mysqli_fetch_array ($resultstaff))
{

$percent = intval($counter/$total * 100)."%";
//echo "<tr>";
//echo "<tr><td>Record $counter : ".$capturestaff['namapegawai']." - ".$capturestaff['nokp']." </td>";

$queuekp=$capturestaff['nokp'];

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

$selectdata1 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
         ".$tahun_range."
         ORDER BY k.tarikh_mula
			   ";
         
$result1 = mysqli_query($selectdata1) or die('Error, query data failed');
$founddata1 = mysqli_num_rows($result1);
//echo "<td>".$founddata1."</td>";;

$selectdata2 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
             
         AND k.valid = 1
         ".$tahun_range."
         ORDER BY k.tarikh_mula
			   ";
         
$result2 = mysqli_query($selectdata2) or die('Error, query data failed');
$founddata2 = mysqli_num_rows($result2);
//echo "<td>".$founddata2."</td>";

$selectdata3 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
         AND k.valid = 1
         AND k.borang = 'PERLU'
         ".$tahun_range."
         ORDER BY k.tarikh_mula
			   ";
$result3 = mysqli_query($selectdata3) or die('Error, query data failed');
$founddata3 = mysqli_num_rows($result3);
//echo "<td>".$founddata3."</td>";

$selectdata4 = "SELECT k.valid, n.namapegawai, n.nokp, n.status, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.borang, k.borang_dikembalikan							
			   FROM peribadi n, kursus k
			   WHERE k.nokp2 = n.nokp
         AND n.nokp = '$queuekp'
         AND k.valid = 1
         AND k.borang = 'PERLU'
         AND k.borang_dikembalikan = 'BELUM DIKEMBALIKAN' 
         ".$tahun_range."
         ORDER BY k.tarikh_mula
			   ";
         
$result4 = mysqli_query($selectdata4) or die('Error, query data failed');
$founddata4 = mysqli_num_rows($result4);
//echo "<td>".$selectdata4."</td>";
//echo "<td>".$founddata4."</td>";

$check="select nokp,year from infokursus where nokp='$queuekp' and year='$tahun1'";
$checkdata = mysqli_query($check) or die('Error, query data failed');
$foundcheck = mysqli_num_rows($checkdata);
//echo "<td>$foundcheck</td>";


if ($foundcheck==0) {
$query = "INSERT INTO infokursus (nokp, year, bil, bilsah, day, hour, borgperlu, borgkembali) VALUES ('$queuekp', '$tahun1', '$founddata1', '$founddata2', '$total_hari', '$total_jam', '$founddata3', '$founddata4') ";
mysqli_query($query) or die('Error, insert data failed');
//echo "<td>$query</td>";
$inserto=$inserto+1;
//echo "<td bgcolor=white align=center><font color=red><b> - INSERT - </b></font></td>";
} else {
$query = "UPDATE infokursus SET bil='$founddata1', bilsah='$founddata2', day='$total_hari', hour='$total_jam', borgperlu='$founddata3', borgkembali='$founddata4' WHERE nokp='$queuekp' AND year='$tahun1'";
mysqli_query($query) or die('Error, insert data failed');
//echo "<td>$query</td>;
$updato=$updato+1;
//echo "<td bgcolor=#e3e3e3 align=center><font color=green><b> - UPDATE - </b></font></td>";
}

//echo "<td align=left>";
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
$insett = $inserto;
$updett = $updato;
//echo "<p><h5>Page generated in $total_time seconds.</h5><p>";

    // Javascript for updating the progress bar and information
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div align=left style=\"width:'.$percent.';background-color:#FF0000;\">&nbsp;'.$percent.'&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$counter.'/'.$total.' row(s) processed. <br>Time taken has been '.$total_time.' seconds. <br>Inserted: '.$insett.' record(s) - Updated: '.$updett.' record(s)<br>Speed is '.$counter/$total_time.' row per second.";
    </script>';
 
// This is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*64);

// Send output to browser immediately
    flush();
 
// Sleep one second so we can see the delay
    //sleep(1);
    
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
echo "<p>Page generated in $total_time seconds.<p>";
echo "Total Record Inserted: ".$inserto." <br>Total Record Updated: ".$updato."<br><br>";
echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';
echo "<b>WEB ENGINE DBSYNC ENDED ON ".date('d-m-Y H:i:s');

?>

