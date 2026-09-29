<?php 

session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION ['level'] > 0)
{

include('files/db.php');

$nokp2 = $_GET['nokp'];


?>
<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 

<td valign=top bgcolor="#f1e6e5">
<table width="100%"><tr><td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">PORTAL SEMAKAN LOG AKTIVITI BERKAITAN KEMASKINI DATA LATIHAN DAN PERIBADI</div></td></tr></table>

<center>

<?php 

$strSQL  = "SELECT * FROM `sqllog` where nokpapplied = '$nokp2' ";


$objQuery = mysqli_query($strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$Per_Page = 1000;   // Data Line Per Page

$Page = $_GET["Page"];
if(!$_GET["Page"])
{
$Page=1;
}

$Prev_Page = $Page-1;
$Next_Page = $Page+1;

$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($Num_Rows<=$Per_Page)
{
$Num_Pages =1;
}
else if(($Num_Rows % $Per_Page)==0)
{
$Num_Pages =($Num_Rows/$Per_Page) ;
}
else
{
$Num_Pages =($Num_Rows/$Per_Page)+1;
$Num_Pages = (int)$Num_Pages;
}

$strSQL .= " order by datentime desc LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($strSQL);
//echo $strSQL;
         
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="100%">
<tr><th>Date/Time</th><th>User</th><th>Access<br>Level</th><th>SQL</th><th>NoKP</th><th>Page</th><th>IP</th><th>User Agent</th></tr>
<?php 

 if ($Num_Rows==0) 
{
echo "<tr bgcolor='ffffff'><td colspan='4' align='center'>Tiada rekod ditemui.</td></tr>";
}
        
$i=1;
while($capture2 = mysqli_fetch_array($objQuery))
{
if ($Page!=1)
{
$ordernum=(($Page-1)*$Per_Page)+$i;
$i++;
}
else
{
$ordernum=$i++;
}

echo "<tr bgcolor='#ffffff'><td>".$capture2['datentime']."</td><td align='left'>". $capture2['user'] . "</td><td align='center'>". $capture2['accesslevel'] . " </td><td>". $capture2['sqldone'] . "</td><td><a href='staff_kursus.php?nokp=".$capture2['nokpapplied']."'>".$capture2['nokpapplied']. "</a></td><td>".$capture2['page']."</td><td>".$capture2['ip']."</td><td>".$capture2['agent']."</td></tr>";	
        
}
?>

</table>
<br>
 
<font face="Verdana, Arial, Helvetica, sans-serif" size="1">Sebanyak <span class="class19">        <?php echo  $Num_Rows;?></span> rekod ditemui dari pangkalan data </font> 
<font face="Verdana, Arial, Helvetica, sans-serif" size="1">        : <span class="class19">Sejumlah <?php echo $Num_Pages;?> Muka Surat</span></font> <br>
<?php 
if($Prev_Page)
{
echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page'><< Back</a> ";
}

for($i=1; $i<=$Num_Pages; $i++){
if($i != $Page)
{
echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ]";
}
else
{
echo "<b> $i </b>";
}
}
if($Page!=$Num_Pages)
{
echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'>Next>></a> ";
}
	
//include 'files/closedb.php';
         

?>

</center>

<br><br>
</td> </tr>
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
