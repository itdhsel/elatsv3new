<?php 

session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION ['level'] > 0)
{

include('files/db.php');

$updatedone=0;

if ($_POST['action']=="update")
{

$userid=$_POST['user_id'];
$level=$_POST['level'];
$jabatan=$_POST['jabatan'];
$email=$_POST['email'];

$queryupdate  = "UPDATE members SET level=$level,jabatan='$jabatan',email='$email' WHERE user_id= '$userid'";
$resultupdate = mysqli_query($conn, $queryupdate);

$updatedone=1;

}
else
{ 
  $userid = $_GET['userid'];
}




$user_id = $_SESSION['user_id'];

$query  = "SELECT *	FROM members WHERE user_id= '$userid'";
$result = mysqli_query($conn, $query);
$found = mysqli_num_rows($result);
$capture = mysqli_fetch_array ($result);


?>

<?php include('pagetitleheader.php'); ?> 

<script src="calendar/jquery.js"></script>
<script type="text/javascript" src="calendar/calendar/jquery.dynDateTime.js"></script>
<script type="text/javascript" src="calendar/calendar/lang/calendar-en.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar/css/calendar-system.css"  />

<style type="text/css">
<!--
.style25 {color: #FFFFFF}
-->
</style>
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
		
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">  
  <table width=100%><tr><td height="30" bgcolor=#8B8378 align=center><span class="style21">PAPARAN MAKLUMAT PENGGUNA SISTEM</span></td></tr></table>
      

      <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF" class="tablestyleB">
            <tr>
              <td colspan="3" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style1">
                  <div align="center" class="style21">BUTIR - BUTIR PENGGUNA </div>
              </div></td>
              </tr>
            <tr>
              
			  
			  
			  <td width="19%">&nbsp;</td>
              <td width="74%">&nbsp;</td>
              <td width="7%">&nbsp;</td>
            </tr>
            
     <form id="register" name="register" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?userid='<?php  echo $capture["user_id"];?>'">
			 <tr> 
			 <td><div align="right">
                <div align="right"><span class="style20">Nama </span> : </div>
              </div></td>
              <td><span class="style20"><?php  echo $capture["name"];?></span></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="right">
                <div align="right"><span class="style20">Username</span> : </div>
              </div></td>
              <td><span class="style20"><?php  echo $capture["username"];?></span></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right"> <span class="style20">Level</span> :  </td>
              <td>
			  
			  <span class="style20">
			  
        <?php  

        //if($capture["level"] == "2") { echo 'Kakitangan Sendiri';}
        //if($capture["level"] == "3") { echo 'Wakil Jabatan';}
        //if($capture["level"] == "4") { echo 'Pentadbir Sumber Manusia';}
        //if($capture["level"] == "5") { echo 'Pentadbir Penuh Sistem';}

        ?>
        <select name="level" id="level">
          <option value="0" <?php  if ($capture["level"]=="0") { echo "selected"; } ?>>Sila Buat Pilihan</option>
          <option value="3" <?php  if ($capture["level"]=="3") { echo "selected"; } ?>>Wakil Jabatan</option>
          <option value="4" <?php  if ($capture["level"]=="4") { echo "selected"; } ?>>Pentadbir Sumber Manusia</option>
          <option value="5" <?php  if ($capture["level"]=="5") { echo "selected"; } ?>>Pentadbir Penuh Sistem</option>
        </select>

			  <input type="hidden" name="user_id" value="<?php  echo $capture["user_id"];?>">
        <input type="hidden" name="action" value="update">
        </span></td>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td align="right"><span class="style20">Jabatan</span> : </td>
              <td>
              <select name='jabatan' id='jabatan'>
              <option selected='selected'></option>              
              <?php 
              $strSQL2 = "SELECT * from jabatan order by namajabatan"; 
              $objQuery2 = mysqli_query($conn, $strSQL2) or die ("Error Query [".$strSQL2."]");   
              while($capture2 = mysqli_fetch_array($objQuery2))
              {   
              ?><option value='<?php echo $capture2["namajabatan"];?>' <?php  if ($capture["jabatan"]==$capture2["namajabatan"]) { echo "selected"; } ?>><?php if ($capture2["jabatan_type"]==0){echo $capture2["namajabatan"];} else {echo "- ".$capture2["namajabatan"];}?></option><?php     
              }
              ?>     
              </select>  
              </td>

              <td>&nbsp;</td>
            </tr>

            <tr>
              <td align="right"><span class="style20">Emel</span> : </td>
              <td><input type="text" size="50" name="email" value="<?php echo $capture["email"]; ?>"></td>

              <td>&nbsp;</td>
            </tr>
            <?php if ($updatedone==1) { echo "<tr><td colspan=3><font color='red'><b>- Data pengguna telah dikemaskini..</b></font></td></tr>"; } ?>
            <tr>
              <td colspan="3"><div align="center" class="tablestyleB"><span></span>

                    <div align="right"><span class="style05">
                      <input type=submit name="Kemaskini" value="Kemaskini"> <input name="Submit22" type="button" id="Submit2" onclick="location.href='admin.php'" value="&lt;&lt; Kembali" />
                    </span></div>
              </div></td>
			  </tr>
              </form>
          </table>
           <br /></td>
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
