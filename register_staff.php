<?php 

session_start();
include('privcheck.php');  //check session n permission to access


if($_SESSION ['level'] > 0)
{
include('files/db.php');
?>

<?php include('pagetitleheader.php'); ?> 
</head>

<script type="text/JavaScript">

function ValidateEmail(inputText)
{
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(inputText.value.match(mailformat))
{
return true;
}
else
{
alert("You have entered an invalid email address!");
document.register.mail.focus();
return false;
}
}


<!--
function fill_register()
{
	if(document.register.nokp.value==''||document.register.jantina.value=='Sila Buat Pilihan'||document.register.bangsa.value=='Sila Buat Pilihan'||document.register.namapegawai.value==''||document.register.skim_khidmat.value==''||document.register.gredhakiki.value==''||document.register.kumpulan.value=='Sila Buat Pilihan'||document.register.jabatan.value=='')
	{
		alert('Sila mengisi semua kekosongan terlampir!!');
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
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000"> 

<form id="register" name="register" method="post" action="register_staff_berjaya.php">	

<table width=100% border=0>	
<tr bgcolor="#FFFF00">
<td height="30" colspan="2" bgcolor=#8B8378 align=center><span class="title"><span class="style21">DAFTAR PEGAWAI BARU</span></td>
</tr> 

<tr>
<td colspan="2" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style21">BUTIR - BUTIR PERIBADI</div></td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>

<tr>
<td align="right" width=300><span class="style20">Nama Pegawai</span> :</td>
<td align="left"><input style="text-transform: uppercase" name="namapegawai" type="text" id="namapegawai" size="50" /></td>
</tr>

<tr>
<td align="right"><span class="style20">No KP </span> :</td>
<td><div align="left"><input name="nokp" type="text" id="nokp" size="16" maxlength="14" /><span class="style22">( Cth : 780728035465 )</span></div></td>
</tr>

<tr>
<td align="right"><span class="style20">Jantina</span> :</td>
<td align="left">
<select name='jantina' id='jantina'>
<option selected='selected'>Sila Buat Pilihan</option>
<option value="LELAKI">LELAKI</option>
<option value="PEREMPUAN">PEREMPUAN</option>
</select></td>
</tr>
      
<tr>
<td align="right"><span class="style20">Bangsa</span> : </div></td>
<td align="left">
<select name='bangsa' id='bangsa'>
<option selected='selected'>Sila Buat Pilihan</option>
<option value="MELAYU">MELAYU</option>
<option value="CINA">CINA</option>
<option value="INDIA">INDIA</option>
<option value="BUMIPUTRA SARAWAK">BUMIPUTRA SARAWAK</option>
<option value="BUMIPUTRA SABAH">BUMIPUTRA SABAH</option>
<option value="LAIN-LAIN">LAIN-LAIN</option>
</select>
</td>
</tr>

<tr>
<td><div align="right"><span class="style20">Email </span> : </div></td>
<td align="left"><input name="email" type="text" id="email" size="50" onChange="ValidateEmail(document.register.email)"> <span class="style22">* Sila gunakan email rasmi jabatan.</span>
</td>
</tr> 
      
<tr>
<td align="right"><span class="style20">Status</span> : </td> 
<td align="left">
<select name='status' id='status'>
<option selected='selected'>Sila Buat Pilihan</option>
<option value="AKTIF">AKTIF</option>
<option value="TIDAK AKTIF">TIDAK AKTIF</option>
</select>
</td>
</tr>
      
<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2" bgcolor=#8B8378><div align="center" class="style21">BUTIR - BUTIR PERKHIDMATAN </div></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>

<tr>
<td align="right"><span class="style20">Jawatan </span>: </div></td>
<td align="left">
<select name='skim_khidmat' id='skim_khidmat'>
<option selected='selected'>Sila Buat Pilihan</option>
<?php 
$strSQLjawatan = "SELECT namajawatan from jawatan order by namajawatan"; 
$objQueryjawatan = mysqli_query($strSQLjawatan) or die ("Error Query [".$strSQLjawatan."]");   

while($capturejawatan = mysqli_fetch_array($objQueryjawatan))
{ ?><option value='<?php echo $capturejawatan["namajawatan"];?>'><?php echo $capturejawatan["namajawatan"]?></option><?php  }
?>     
</select>
</td>
</tr>

<tr>
<td align="right"><span class="style20">Gred</span> : </div></td>
<td align="left">
<select name='gredhakiki' id='gredhakiki'>
<option selected='selected'>Sila Buat Pilihan</option>
<?php 
$strSQLgred = "SELECT namagred from gred order by namagred"; 
$objQuerygred = mysqli_query($strSQLgred) or die ("Error Query [".$strSQLgred."]");   

while($capturegred = mysqli_fetch_array($objQuerygred))
{ ?><option value='<?php echo $capturegred["namagred"];?>'><?php echo $capturegred["namagred"]?></option><?php  }
?>     
</select>
</td>
</tr>

<tr>
<td align="right"><span class="style20">Kumpulan </span>: </div></td>
<td align="left">
<select name='kumpulan' id='kumpulan'>
<option selected='selected'>Sila Buat Pilihan</option>
<option value="PENGURUSAN TERTINGGI">PENGURUSAN TERTINGGI</option>
<option value="PENGURUSAN DAN PROFESIONAL">PENGURUSAN DAN PROFESIONAL</option>
<option value="SOKONGAN 1">SOKONGAN 1</option>
<option value="SOKONGAN 2">SOKONGAN 2</option>
</select>
</td>
</tr>

<tr><td align="right"><span class="style20">Jabatan </span>: </div></td>
<td align="left">
<select name='jabatan' id='jabatan' <?if ($_SESSION['level']== 3){echo "disabled";}?>>
<option selected='selected'>Sila Buat Pilihan</option>
<?php 
$strSQLjabatan = "SELECT namajabatan from jabatan order by namajabatan"; 
$objQueryjabatan = mysqli_query($strSQLjabatan) or die ("Error Query [".$strSQLjabatan."]");   

while($capturejabatan = mysqli_fetch_array($objQueryjabatan))
{ ?><option value='<?php echo $capturejabatan["namajabatan"];?>' <?php  if ($capturejabatan["namajabatan"]==$_SESSION['jabatan']) { echo "selected"; } ?>><?php echo $capturejabatan["namajabatan"]?></option><?php  } ?>     
</select>
</td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>

<tr>
<td colspan="2"><div align="center" class="tablestyleB">
<label><input type="submit" name="addstaff" id="addstaff" onClick="return fill_register()" value="Simpan" /></label>
<label><input type="reset" name="Submit2" value="Kosongkan" /></label>
</div>
</td>
</tr>

</table>
</form>

&nbsp;
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
<!-- end footer -->
