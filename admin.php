<?php 

session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION ['level'] > 0)
{

include('files/db.php');

$nokp = $_GET['nokp'];


?>

<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">  

<table width="100%"><tr><td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">PENDAFTARAN PENTADBIR SISTEM</div></td></tr></table>	

                  <form id="form1" name="form1" method="post" action="include/file_admin_register_pengguna.php">
                  <table width="90%" border="0" align="center">
                      <tr>
                        <td><div align="right" class="style10">Nama Pengguna</div></td>
                        <td>:</td>
                        <td align="left"><input name="namepengguna" type="text" id="name" size="35" /></td>
                        </tr>
                      <tr>
                        <td width="25%"><div align="right" class="style10">Username </div></td>
                        <td width="2%">:</td>
                        <td align="left" width="73%"><input name="username" type="text" id="username" size="35" /></td>
                        </tr>
                      <tr>
                        <td><div align="right" class="style10">Kata Laluan</div></td>
                        <td>:</td>
                        <td align="left"><input name="password" type="password" id="password" size="35" /></td>
                        </tr>
                      <tr>
                        <td><div align="right" class="style10">Tahap Akses</div></td>
                        <td>:</td>
                        <td align="left">
                        <select name="level" id="level">
                          <option value="0"></option>                        	
                          <option value="3">Wakil Jabatan</option>
                          <option value="4">Pentadbir Sumber Manusia</option>
                          <option value="5">Pentadbir Penuh Sistem</option>
                        </select></td>
                        </tr>
                      <tr>
                      <td align="right" class="style10">Jabatan</td>
                      <td>:</td>

                      <td align="left">
                      
                        <select name='jabatan' id='jabatan'>
                        <option selected='selected' value=""></option>
                        <?php 
        	                 $strSQLjabatan = "SELECT namajabatan from jabatan order by namajabatan"; 
                          $objQueryjabatan = mysqli_query($conn, $strSQLjabatan) or die ("Error Query [".$strSQLjabatan."]");   
                          while($capturejabatan = mysqli_fetch_array($objQueryjabatan))
                          {   
				                    ?><option value='<?php echo $capturejabatan["namajabatan"];?>'><?php echo $capturejabatan["namajabatan"]?></option><?php 
                
                          }
                        ?>     
                        </select>
                      
                      </td>
                      </tr>
                      <tr>
                        <td><div align="right" class="style10">Email </div></td>
                        <td>:</td>
                        <td align="left"><input name="email" type="text" size="35" /></td>
                      </tr>                      
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="left"><label>
                          <input type="reset" name="Reset" value="Kosongkan" />
                          </label>
                          <label>
                            <input type="submit" name="reguser" id="reguser" value="Daftar Baru" />
                            </label></td>
                        </tr>
                      </table>
                    </form>
                 

<table width="100%"><tr><td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">PENYELENGGARAAN PENTADBIR SISTEM</div></td></tr></table>
	  	<b>Nota: Sila klik pada nama pentadbir untuk edit akses.</b><br>
           <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
             <tr>
              <td width="92%"><div align="left" class="style26"></div>
                <h2 class="title">

<?php 


$select_members = "ALL";

if($select_members = "ALL")
{

	$strSQL = "SELECT * FROM members";
	$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
	$Num_Rows = mysqli_num_rows($objQuery);

	$Per_Page = 50;   // Per Page

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


	$strSQL .=" order by level desc LIMIT $Page_Start , $Per_Page";
	$objQuery  = mysqli_query($conn, $strSQL);
?>
                </h2>
                <table width="100%" border="1" bordercolor="#FFFFFF" bgcolor="#0F363F">
                  <tr bgcolor="#FFFF00">
                    <td bgcolor="#464646" class="style21"><div align="center">BIL.</div></td>
                    <td bgcolor="#464646" class="style21"><div align="center">NAMA PENGGUNA</div></td>
                    <td bgcolor="#464646" class="style21"><div align="center">LEVEL</div></td>
                    <td bgcolor="#464646" class="style21"><div align="center">USERNAME</div></td>
                    <td bgcolor="#464646" class="style21"><div align="center">JABATAN</div></td>
                    <td bgcolor="#464646" class="style21"><div align="center">EMAIL</div></td>
                    <td width="5%" bgcolor="#464646" class="style21"><div align="center">TUKAR PASSWORD</div></td>
                    <td bgcolor="#464646" class="style21"><div align="center">HAPUS</div></td>
                  </tr>
                  <?php 
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
                    <td height="22" class="style10">
                      <div align="center">
                        <?php echo $ordernum;?>
                      </div></td>
                    <td class="style10">
					
					<a href="admin_pengguna_display.php?userid=<?php echo $capture["user_id"];?>	">
					<?php echo $capture["name"]?>
					</a>
					
					</td>
                    <td class="style10"><div align="center">
                        <?php echo $capture["level"];?>
                    </div></td>
                    <td class="style10"><?php echo $capture["username"];?></td>
                    <td class="style10"><?php echo $capture["jabatan"];?></td>
                    <td class="style10"><?php echo $capture["email"];?></td>                                        
                    <td><center>
                      <p><a href="admin_reset_password.php?user_id=<?php echo $capture["user_id"];?>"><img src='images/detail.png' width='16' height='16' border='0' class="style10" title='Reset Password' /></a></p>
                    </center></td>
                    <td><center>
                      <p><a href="admin_delete_pengguna.php?user_id=<?php echo $capture["user_id"];?>"><img src='images/cross.png' width='18' height='18' border='0' class="style10" title='Delete User' /></a></p>
                    </center></td>
                  </tr>
                  <?php 
}
?>
                </table>
                <br />
                <!-- End of NEw Frame -->
                <font face="Verdana, Arial, Helvetica, sans-serif" size="1">Sebanyak <span class="class19">
                <?php echo  $Num_Rows;?>
                </span> rekod ditemui dari pangkalan data </font> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> : <span class="class19">
                <?php echo $Num_Pages;?> Muka Surat</span></font>
                <?php 
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&select_members=$select_members'><< Back</a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&select_members=$select_members'>$i</a> ]";
		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&select_members=$select_members'>Next>></a> ";
	}
	
	//include 'files/closedb.php';

	}	
	?></td>
            </tr>
          </table>
 <br>
</td>
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