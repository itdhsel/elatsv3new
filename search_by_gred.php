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
<tr><td height="30" colspan="2" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style21">CARIAN REKOD MENGIKUT GRED HAKIKI </div></td></tr>
<tr><td>
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
            <tr>
              <td class="style10">
              <form action="<?php echo $_SERVER['SCRIPT_NAME'];?>" method="get" name="frmSearch" id="frmSearch">
                <table width="100%" cellpadding="5" cellspacing="2" border=0>
                  <tr align="left">
                    <th width="13%" align="right" valign="middle" bgcolor="#CCCCCC">Gred Hakiki :</th>
				    <th width="87%" valign="middle" align="left"><input name="txtKeyword" type="text" id="txtKeyword" value="<?php echo $_GET["txtKeyword"];?>" size="30" /><span class="style22"> ( Cth : F29, U29 )</span></th>
                  </tr>
                  <tr align="left">
                    <th><span class="style05">
                      <input name="Submit3" type="button" class="style10" onclick="history.back()" value="&lt;&lt; Kembali" />
                    </span></th>
                    <th align="left">
					         <input class="style10" name="submit" type="submit" value="Carian" />
                    <input class="style10" name="Reset" type="reset" id="reset" value="Kosongkan" /></th>
                  </tr>
                </table>
              </form>
              </td>
            </tr>
          </table>
          
		  <table width="100%" border="0" cellpadding="2" cellspacing="2">
            <tr>
              <td class="style10" align="center">

<?php 

$user_id = $_SESSION['user_id'];
$level = $_SESSION['level'];

if($_GET["txtKeyword"] != "")
{

	if($level == 1)
	{
	$strSQL = "SELECT namapegawai,nokp,gredhakiki, skim_khidmat 
				FROM peribadi WHERE (gredhakiki = '".$_GET["txtKeyword"]."' )";

				

	$objQuery = mysqli_query($strSQL) or die ("Error Query [".$strSQL."]");
	$Num_Rows = mysqli_num_rows($objQuery);
	}
	else
	{
	$strSQL = "SELECT namapegawai,nokp,gredhakiki, skim_khidmat 
				FROM peribadi WHERE (gredhakiki = '".$_GET["txtKeyword"]."' )";
	$objQuery = mysqli_query($strSQL) or die ("Error Query [".$strSQL."]");
	$Num_Rows = mysqli_num_rows($objQuery);
	}

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


	$strSQL .=" order by skim_khidmat,namapegawai ASC LIMIT $Page_Start , $Per_Page";
	$objQuery  = mysqli_query($strSQL);
?>
<table width="100%" cellpadding="2" cellspacing="2" bgcolor="#f1988a">
  <tr>
    <th align="center" valign="middle" colspan="6">HASIL CARIAN</th>
  </tr>
<tr>
<td width="6%" bgcolor="#CCCCCC"><div align="center">NO.</div></td>
<td width="33%" bgcolor="#CCCCCC"><div align="center">NAMA PEGAWAI</div></td>
<td width="11%" bgcolor="#CCCCCC"><div align="center">GRED HAKIKI</div></td>
<td width="32%" bgcolor="#CCCCCC"><div align="center">JAWATAN</div></td>
<td width="9%" bgcolor="#CCCCCC"><div align="center">PERIBADI</div></td>
<td width="9%" bgcolor="#CCCCCC"><div align="center">KURSUS</div></td>
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
<td><div align="center">
  <?php echo $ordernum;?>
</div></td>
<td align="left"><a href="search_display.php?nokp=<?php echo $capture["nokp"];?>"><?php echo $capture["namapegawai"];?></a></td>
<td><div align="center">
  <?php echo $capture["gredhakiki"];?>
</div>  </td>
<td><div align="center">
  <?php echo $capture["skim_khidmat"];?>
</div></td>
<td><div align="center"><a href='search_display.php?nokp=<?php echo $capture["nokp"]?>'><img src='images/peribadi.png' title='Paparan Maklumat Peribadi' width='16' height='16' border='0' /></a></div></td>
<td><div align="center"><a href='staff_kursus.php?nokp=<?php echo $capture["nokp"]?>'><img src='images/kursus.png' alt="kursus" width='16' height='16' border='0' title='Paparan Maklumat Kursus yang Telah Dihadiri' /></a></div></td>        
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&txtKeyword=$_GET[txtKeyword]'><< Back</a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&txtKeyword=$_GET[txtKeyword]'>$i</a> ]";
		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&txtKeyword=$_GET[txtKeyword]'>Next>></a> ";
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
