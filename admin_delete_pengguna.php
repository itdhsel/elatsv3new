<?php 

session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION['level'] > 1)
{

include('files/db.php');

$user_id = $_GET['user_id'];

$query  = "SELECT * FROM members WHERE user_id = '$user_id' ";
$result = mysqli_query($conn, $query);
$capture = mysqli_fetch_array($result);

?>

<?php include('pagetitleheader.php'); ?> 

</head>

<script language="javascript" type="text/javascript" >
function fill()
{
	if(confirm("Adakah anda pasti untuk MENGHAPUSKAN akaun pengguna ini dari pangkalan data?"))
	{
		return true; // submit form is user says yes.
	} 
	else 
	{
		return false; // don't submit form if user says no
	}
}
</script>

<?php include('header.php'); ?>

<?php include('rightmenu1.php'); ?> 

<td width="730" align="center" valign="top" bgcolor="#f1e6e5">

<form id="update" name="update" method="post" action="admin_delete_pengguna_berjaya.php">
<p><span class="title">Hapus Akaun Pengguna </span></p> 
    
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
<tr><td class="style10">
              
<table width="100%" border="0" cellpadding="2" cellspacing="2" bordercolor="#000000" bgcolor="#FFFFFF">
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td width="190">&nbsp;</td>
<td width="175">&nbsp;</td>
<td width="155">&nbsp;</td>
</tr>
                
<tr>
<td align="right" valign="middle"><span class="style20">Name Pengguna </span></td>
<td><span class="style20">:</span></td>
<td colspan="3"><span class="style02">
<?php echo $capture["name"]; ?>
<input name="name2" type="hidden" id="name2" value="<?php echo $capture["name"]; ?>" />
<input name="user_id2" type="hidden" id="user_id2" value="<?php echo $capture["user_id"]; ?>" />
<input name="username2" type="hidden" id="username2" value="<?php echo $capture["username"]; ?>" />
</span></td>
</tr>

<tr>
<td align="right" valign="middle"><span class="style20">Username</span></td>
<td>:</td>
<td colspan="3"><?php echo $capture["username"]; ?></td>
</tr>
                
<tr>
<td align="right" valign="middle"><span class="style20"> Level  </span></td>
<td><span class="style20">:</span></td>
<td colspan="3"><?php echo $capture["level"]; ?></td>
</tr>
                
<tr>
<td align="right" valign="middle">&nbsp;</td>
<td>&nbsp;</td>
<td colspan="3">&nbsp;</td>
</tr>
                
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
                
<tr>
<td align="right" valign="middle"><span class="style05"><input name="Submit2" type="button" id="Submit2" onclick="history.back()" value="&lt;&lt; Ke hadapan" /></span></td>
<td>&nbsp;</td>
<td colspan="3"><div align="left"><span class="style1"></span>
<input name="deleteAccount" type="submit" id="deleteAccount" onclick="return fill()" value="Hapuskan Akaun"/>&nbsp;</div></td>
</tr>
                
<tr>
<td width="151">&nbsp;</td>
<td width="3">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
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
alert('Hanya Administrator Dibenarkan Menggunakan Sistem IniOnly admin have permission to enter this page');
location='home.php';
</script>
<?php 
}
?>

