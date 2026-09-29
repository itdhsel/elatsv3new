<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 0)
{


include('files/db.php');



?>

<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
<tr><td height="30" colspan="2" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style21">CARIAN REKOD KURSUS PEGAWAI MENGIKUT NAMA KURSUS </div></td></tr>
<tr><td>

          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
            <tr>
              <td class="style10"><form action="<?php echo $_SERVER['SCRIPT_NAME'];?>" method="get" name="frmSearch" id="frmSearch">
                <table width="100%" cellpadding="5" cellspacing="2">
                  <tr align="left">
                    <th width="13%" align="right" valign="middle" bgcolor="#cccccc">Nama kursus :</th>
				            <th align="left"><input name="txtKeyword" type="text" id="txtKeyword" value="<?php echo $_GET["txtKeyword"];?>" size="30" /> 
                        <?php if($_GET["txtKeyword"] != "") { ?>   
                        <script type="text/javascript">
	                      jQuery(document).ready(function() {
	                      jQuery("#tarikh").dynDateTime(); //defaults
	                      });
                        </script>
                        Tarikh Kursus: <input type="text" name="tarikh" id="tarikh" size="10" value="<?php echo $_GET["tarikh"];?>">
                        <?php } ?>
                        </th>
                  </tr>
                  <tr align="left">
                    <th><span class="style05">
                      <input name="Submit3" type="button" class="style10" onclick="history.back()" value="&lt;&lt; Kembali" />
                    </span></th>
                    <th align="left">
					         <input class="style10" name="submit" type="submit" value="Carian" />
                    <input class="style10" type="button" value="Reset Semula" onClick="location.href='<?php echo $_SERVER['SCRIPT_NAME'];?>'"></th>   
                  </tr>
                </table>
              </form></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellpadding="2" cellspacing="2">
            <tr>
              <td class="style10" align="center">

<?php 

$user_id = $_SESSION['user_id'];
$level = $_SESSION['level'];

$tarikh=$_GET["tarikh"];
if ($tarikh!="") {
$hari=substr("$tarikh",0,2);
$bulan=substr("$tarikh",3,2);
$tahun=substr("$tarikh",6,4);
$tarikh="$tahun"."-"."$bulan"."-"."$hari";
}

if($_GET["txtKeyword"] != "")
{
	if($level == 1)
	{
   if ($tarikh!="") {
     $strSQL = "SELECT * FROM kursus,peribadi WHERE kursus.nokp2=peribadi.nokp and (nama_kursus LIKE '%".$_GET["txtKeyword"]."%') and tarikh_mula = '$tarikh' ";
   } else {
	$strSQL = "SELECT *	FROM kursus,peribadi WHERE kursus.nokp2=peribadi.nokp and (nama_kursus LIKE '%".$_GET["txtKeyword"]."%' )";
	}		
  
	$objQuery = mysqli_query($strSQL) or die ("Error Query [".$strSQL."]");
	$Num_Rows = mysqli_num_rows($objQuery);
	}
	
	else
	{
   if ($tarikh!="") {
     $strSQL = "SELECT * FROM kursus,peribadi WHERE kursus.nokp2=peribadi.nokp and (nama_kursus LIKE '%".$_GET["txtKeyword"]."%') and tarikh_mula = '$tarikh' ";
   } else {
	$strSQL = "SELECT *	FROM kursus,peribadi WHERE kursus.nokp2=peribadi.nokp and (nama_kursus LIKE '%".$_GET["txtKeyword"]."%' )";
	}	
	$objQuery = mysqli_query($strSQL) or die ("Error Query [".$strSQL."]");
	$Num_Rows = mysqli_num_rows($objQuery);
	}

  echo $strsql;
  
	$Per_Page = 20;   // Per Page

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


	$strSQL .=" order by nama_kursus ASC LIMIT $Page_Start , $Per_Page";
	$objQuery  = mysqli_query($strSQL);
  //echo $strSQL;
?>
<table width="100%" cellpadding="2" cellspacing="2" bgcolor="#f1988a">
  <tr>
    <td colspan="6" align="center" valign="middle">HASIL CARIAN</td>
  </tr>

<tr bgcolor="#FFFF00">
<td width="34" height="16" bgcolor="#CCCCCC"><div align="center">NO.</div></td>  
<td bgcolor="#CCCCCC"><div align="center">TARIKH KURSUS </div></td>
<td bgcolor="#CCCCCC"><div align="center">NAMA KURSUS </div></td>
<td bgcolor="#CCCCCC"><div align="center">NAMA PEGAWAI</div></td>
<td bgcolor="#CCCCCC" width=100><div align="center">NO KP</div></td>
<td bgcolor="#CCCCCC"><div align="center">PERIBADI</div></td>
<td bgcolor="#CCCCCC"><div align="center">KURSUS</div></td>
</tr>

<?php 

        if ($Num_Rows==0) {
        echo "<tr bgcolor='ffffff'><td colspan='6' align='center'>Tiada rekod ditemui</td></tr>";
        }
$i=1;
while($capture = mysqli_fetch_array($objQuery))
{
        if ($Page!=1){
        $ordernum=(($Page-1)*$Per_Page)+$i;
        $i++;
        }
        else{
        $ordernum=$i++;
        }
?>
    
   
<tr bgcolor="#FFFFFF">
<td><div align="center"><?php echo $ordernum;?></div></td>
<td align=center>&nbsp;<?php echo $capture["tarikh_mula"];?></td>
<td align="left"><a href="search_display.php?nokp=<?php echo $capture["nokp"];?>"><a href='staff_kursus_detail.php?nokp=<?php echo $capture["nokp"]; ?>&id=<?php echo $capture['id'] ?>&nama_kursus=<?php echo $capture['nama_kursus'] ?>' ><?php echo $capture['nama_kursus'] ?></a></td>
<td align="left">&nbsp;<?php echo $capture["namapegawai"];?></td>
<td><div align="center"><?php echo $capture["nokp"];?></div></td>
<td><div align="center">
  <div align="center"><a href='search_display.php?nokp=<?php echo $capture["nokp"]?>'><img src='images/peribadi.png' title='Paparan Maklumat Peribadi' width='16' height='16' border='0' /></a></div>
</div>
  <div align="center"></div></td>
<td><div align="center">
  <div align="center"><a href='staff_kursus.php?nokp=<?php echo $capture["nokp"]?>'><img src='images/kursus.png' alt="kursus" width='16' height='16' border='0' title='Paparan Maklumat Kursus yang Telah Dihadiri' /></a></div>
</div></td>
</tr>

<?php 
}
?>
</table>

<br>
</span>

<!-- End of NEw Frame -->
        <font face="Verdana, Arial, Helvetica, sans-serif" size="1">Sebanyak <span class="class19">
        <?php echo  $Num_Rows;?></span> rekod ditemui dari pangkalan data </font> 
        
        <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
        : <span class="class19"><?php echo $Num_Pages;?> Muka Surat</span></font> 
         
<?php 
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&tarikh=$_GET[tarikh]&txtKeyword=$_GET[txtKeyword]'><< Back</a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&tarikh=$_GET[tarikh]&txtKeyword=$_GET[txtKeyword]'>$i</a> ]";
		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&tarikh=$_GET[tarikh]&txtKeyword=$_GET[txtKeyword]'>Next>></a> ";
	}
	

	}	
	?>

	</td>
  </tr>
  </table>
</td></tr>
</table>

</td>	   
   
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
