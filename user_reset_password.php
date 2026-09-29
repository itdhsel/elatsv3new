<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 0)
{

include('files/db.php');

$nokp = $_GET['nokp'];

$queryname  = "SELECT * FROM peribadi WHERE nokp = '$nokp'";
$result = mysqli_query($query);
$capture = mysqli_fetch_array($result);


?>

<?php include('pagetitleheader.php'); ?> 

</head>
<script type="text/JavaScript">
<!--
function fill_register()
{
	if(document.update.p.value==''||document.update.rep.value=='')
	{
		alert('Please Fill In All Fields');
		return false;
	}

	else
	{
		return true;
	}
}
//-->
</script>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
<td valign=top bgcolor="#f1e6e5" width="1000">
	<form id="update" name="update" method="post" action="admin_reset_password_berjaya.php">

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
<tr><td height="30" colspan="2" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style21">FUNGSI MENUKAR KATA LALUAN PENGGUNA SISTEM </div></td></tr>
<tr><td>

            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
            <tr>
		<td align="left" valign="top"><p><span class="title">Tukar Kata Laluan Pengguna </span></p> </td>  </tr>

            <tr>
              <td class="style10"><table width="100%" border="0" cellpadding="2" cellspacing="2" bordercolor="#000000" bgcolor="#FFFFFF">

                <tr>
                  <td height="30" align="right" valign="middle"><span class="style20">IC </span></td>
                  <td><span class="style20">:</span></td>
                  <td colspan="3"><?php echo $capture["pwd"]; ?><span class="style02">
                    <input name="username2" type="hidden" id="username2" value="<?php echo $capture["pwd"]; ?>" />
                    <input name="user_id2" type="hidden" id="user_id2" value="<?php echo $capture["user_id"]; ?>" />
                  </span></td>
                </tr>
                
                <tr>
                  <td align="right" valign="middle"><span class="style20">Password Baru </span></td>
                  <td><span class="style20">:</span></td>
                  <td colspan="3"><input name="p" type="password" id="p" size="25" /></td>
                </tr>
                <tr>
                  <td align="right" valign="middle"><span class="style20">Re-Password Baru </span></td>
                  <td><span class="style20">:</span></td>
                  <td colspan="3"><input name="rep" type="password" id="rep" size="25" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="right" valign="middle"><span class="style05">
                    <input name="Submit22" type="button" id="Submit2" onclick="history.back()" value="&lt;&lt; Ke hadapan" />
                  </span></td>
                  <td>&nbsp;</td>
                  <td colspan="3"><div align="left"><span class="style1"></span>
                    <input name="resetPassword" type="submit" id="resetPassword" onclick="return fill_register()" value="Tukar Kata Laluan"/>
                    &nbsp;
                    <input name="Submit2" type="reset" value="Kosongkan" />
                  </div></td>
                </tr>
                <tr>
                  <td width="151">&nbsp;</td>
                  <td width="3">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
                <br>
				</span>
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
alert('Hanya Administrator Dibenarkan Menggunakan Sistem Ini!!');
location='home.php';
</script>
<?php 
}
?>

