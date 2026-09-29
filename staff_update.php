<?php 

session_start();
include('privcheck.php');

if(($_SESSION['level'] ?? 0) > 0)
{

include('files/db.php');

$nokp = $_GET['nokp'] ?? '';

// Validate and sanitize input
if (empty($nokp)) {
    die('<script>alert("No KP tidak sah"); location="index.php";</script>');
}

$nokp_sanitized = mysqli_real_escape_string($conn, $nokp);

$query = "SELECT * FROM peribadi WHERE nokp = '$nokp_sanitized'";
$result = mysqli_query($conn, $query); // Added connection parameter
if (!$result) {
    die('Database query error: ' . mysqli_error($conn));
}

$found = mysqli_num_rows($result);
if ($found > 0) {
    $capture = mysqli_fetch_array($result);
} else {
    die('<script>alert("Rekod tidak dijumpai"); location="index.php";</script>');
}

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
document.updatestaff.email.focus();
return false;
}
}

<!--
function fill_register()
{
	if(document.updatestaff.nokp.value=='')
	{
		alert('Sila mengisi maklumat nokp');
		return false;
	}
	else if(document.updatestaff.jantina.value=='0')
	{
		alert('Sila mengisi maklumat jantina');
		return false;
	}
	else if(document.updatestaff.bangsa.value=='0')
	{
		alert('Sila mengisi maklumat bangsa');
		return false;
	}
	else if(document.updatestaff.namapegawai.value=='')
	{
		alert('Sila mengisi maklumat nama pegawai');
		return false;
	}
	else if(document.updatestaff.skim_khidmat.value=='')
	{
		alert('Sila mengisi maklumat skim khidmat');
		return false;
	}
	else if(document.updatestaff.gredhakiki.value=='')
	{
		alert('Sila mengisi maklumat gred hakiki');
		return false;
	}
	else if(document.updatestaff.kumpulan.value=='0')
	{
		alert('Sila mengisi maklumat kumpulan');
		return false;
	}	
	else if(document.updatestaff.jabatan.value=='')
	{
		alert('Sila mengisi maklumat jabatan');
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
<?php include('rightmenu2.php'); ?> 

<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">

<form id="updatestaff" name="updatestaff" method="post" action="staff_update_berjaya.php">		

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB" bgcolor="#f1e6e5">

<tr>
<td height="30" colspan="2" align="center" bgcolor="#8B8378"><span class="style21">KEMASKINI MAKLUMAT PEGAWAI</span></td>
</tr>

<tr>
<td colspan="2" align="center" bgcolor="#8B8378"><span class="style21">BUTIR - BUTIR PERIBADI</span></td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>

<tr>
<td><div align="right"><span class="style20">Nama Pegawai </span> : </div></td>
<td align="left"><input name="namapegawai" type="text" id="namapegawai" style="text-transform: uppercase" value="<?php echo htmlspecialchars($capture['namapegawai'] ?? ''); ?>" size="50" /></td>
</tr>

<tr>
<td><div align="right"><span class="style20">Jantina</span> : </div></td>
<td align="left">
<select name='jantina' id='jantina'>
<option value='0' <?php if(($capture["jantina"] ?? "") == " ") echo "selected"; ?>>Sila Buat Pilihan</option>
<option value='LELAKI' <?php if(($capture["jantina"] ?? "") == "LELAKI") echo "selected"; ?>>LELAKI</option>
<option value='PEREMPUAN' <?php if(($capture["jantina"] ?? "") == "PEREMPUAN") echo "selected"; ?>>PEREMPUAN</option>
</select>
</td>
</tr>

<tr>
<td><div align="right"><span class="style20">No KP </span> : </div></td>
<?php if(($_SESSION['level'] ?? 0) > 3) { ?>   
<td align="left"><span class="style1"></span><input name="nokp2" type="text" id="nokp2" value="<?php echo htmlspecialchars($capture['nokp'] ?? ''); ?>" size="16" maxlength="14" />&nbsp;<span class="style22">( Can be edited )</span></td>
<?php } else { ?>
<td align="left"><span class="style1"></span><input readonly="readonly" name="nokp2dummy" type="text" id="nokp2dummy" value="<?php echo htmlspecialchars($capture['nokp'] ?? ''); ?>" size="16" maxlength="14" />&nbsp;<span class="style22">( Tidak Boleh Diubah )</span></td>
<input type="hidden" name="nokp2" value="<?php echo htmlspecialchars($capture['nokp'] ?? ''); ?>">
<?php } ?>
</tr>

<tr>
<td><div align="right"><span class="style20">Bangsa </span> : </div></td>
<td align="left">
<select name='bangsa' id='bangsa'>
<option value='0' <?php if(($capture["bangsa"] ?? "") == "") echo "selected"; ?>>Sila Buat Pilihan</option>
<option value="MELAYU" <?php if(($capture["bangsa"] ?? "") == "MELAYU") echo "selected"; ?>>MELAYU</option>
<option value="CINA" <?php if(($capture["bangsa"] ?? "") == "CINA") echo "selected"; ?>>CINA</option>
<option value="INDIA" <?php if(($capture["bangsa"] ?? "") == "INDIA") echo "selected"; ?>>INDIA</option>
<option value="BUMIPUTRA SARAWAK" <?php if(($capture["bangsa"] ?? "") == "BUMIPUTRA SARAWAK") echo "selected"; ?>>BUMIPUTRA SARAWAK</option>
<option value="BUMIPUTRA SABAH" <?php if(($capture["bangsa"] ?? "") == "BUMIPUTRA SABAH") echo "selected"; ?>>BUMIPUTRA SABAH</option>
<option value="LAIN-LAIN" <?php if(($capture["bangsa"] ?? "") == "LAIN-LAIN") echo "selected"; ?>>LAIN-LAIN</option>
</select>
</td>
</tr>

<tr>
<td><div align="right"><span class="style20">Email </span> : </div></td>
<td align="left"><input name="email" type="text" id="email" value="<?php echo htmlspecialchars($capture['email'] ?? ''); ?>" size="50" onChange="ValidateEmail(document.updatestaff.email)"> <span class="style22">*Sila gunakan email rasmi </span>
</td>
</tr>      
  
<?php if (($_SESSION['level'] ?? 0) > 3) { ?>
<tr><td><div align="right"><span class="style20">Status </span>: </div></td>
<td align="left">
<select name='status' id='status'>
<option value="0" <?php if(($capture["status"] ?? "") == "") echo "selected"; ?>>Sila Buat Pilihan</option>
<option value="AKTIF" <?php if(($capture["status"] ?? "") == "AKTIF") echo "selected"; ?>>AKTIF</option>
<option value="TIDAK AKTIF" <?php if(($capture["status"] ?? "") == "TIDAK AKTIF") echo "selected"; ?>>TIDAK AKTIF</option>
<option value="KAVEAT" <?php if(($capture["status"] ?? "") == "KAVEAT") echo "selected"; ?>>KAVEAT</option>
</select>
</td>
</tr>
<?php } else { echo "<tr><td colspan='2'><input type='hidden' name='status' value='".htmlspecialchars($capture["status"] ?? "")."'></td></tr>";}?>

<tr>
<td colspan="4">&nbsp;</td></tr>
<td colspan="4">&nbsp;</td></tr>

<tr>
<td colspan="4" bgcolor="#8B8378" align="center"><span class="style21">BUTIR - BUTIR PERKHIDMATAN</span></td>
</tr>

<tr><td colspan="4">&nbsp;</td></tr>

<tr>
<td><div align="right"><span class="style20"> Jawatan </span> : </div></td>
<?php if(($_SESSION['level'] ?? 0) > 2 ){ ?> 
<td align="left"><select name='skim_khidmat' id='skim_khidmat'>
<option value=''>Sila Buat Pilihan</option>
<?php 
$strSQLjawatan = "SELECT namajawatan from jawatan order by namajawatan"; 
$objQueryjawatan = mysqli_query($conn, $strSQLjawatan); // Added connection
if ($objQueryjawatan) {
    while($capturejawatan = mysqli_fetch_array($objQueryjawatan))
    {   
?><option value='<?php echo htmlspecialchars($capturejawatan["namajawatan"] ?? ''); ?>' <?php if (($capture["skim_khidmat"] ?? "") == ($capturejawatan["namajawatan"] ?? "")) { echo "selected"; } ?>><?php echo htmlspecialchars($capturejawatan["namajawatan"] ?? ''); ?></option><?php 
    }
} else {
    echo "<option value=''>Error loading jawatan</option>";
}
?>     
</select></td>
<?php } else { echo "<td align='left'>".htmlspecialchars($capture['skim_khidmat'] ?? '')."<input type='hidden' name='skim_khidmat' value='".htmlspecialchars($capture['skim_khidmat'] ?? '')."'></td>"; } ?>   
</tr>

<tr>
<td><div align="right"><span class="style20"> Gred</span> : </div></td>
<?php if(($_SESSION['level'] ?? 0) > 2 ){ ?>
<td align="left"><select name='gredhakiki' id='gredhakiki'>
<option value=''>Sila Buat Pilihan</option>
<?php 
$strSQLgred = "SELECT namagred from gred order by namagred"; 
$objQuerygred = mysqli_query($conn, $strSQLgred); // Added connection
if ($objQuerygred) {
    while($capturegred = mysqli_fetch_array($objQuerygred))
    {   
?><option value='<?php echo htmlspecialchars($capturegred["namagred"] ?? ''); ?>'<?php if (($capture["gredhakiki"] ?? "") == ($capturegred["namagred"] ?? "")) { echo "selected"; } ?>><?php echo htmlspecialchars($capturegred["namagred"] ?? ''); ?></option><?php 
    }
} else {
    echo "<option value=''>Error loading gred</option>";
}
?>     
</select></td>
<?php } else { echo "<td align='left'>".htmlspecialchars($capture['gredhakiki'] ?? '')."<input type='hidden' name='gredhakiki' value='".htmlspecialchars($capture['gredhakiki'] ?? '')."'></td>"; } ?>        
</tr>

<tr>
<td><div align="right"><span class="style20">Kumpulan </span>: </div></td>
<?php if(($_SESSION['level'] ?? 0) > 2 ){ ?>
<td align="left">
<select name='kumpulan' id ='kumpulan'>
<option value="0" <?php if(($capture["kumpulan"] ?? "") == "0") echo "selected"; ?>>Sila Buat Pilihan</option>
<option value="PENGURUSAN TERTINGGI" <?php if(($capture["kumpulan"] ?? "") == "PENGURUSAN TERTINGGI") echo "selected"; ?>>PENGURUSAN TERTINGGI</option>
<option value="PENGURUSAN DAN PROFESIONAL" <?php if(($capture["kumpulan"] ?? "") == "PENGURUSAN DAN PROFESIONAL") echo "selected"; ?>>PENGURUSAN DAN PROFESIONAL</option>
<option value="SOKONGAN 1" <?php if(($capture["kumpulan"] ?? "") == "SOKONGAN 1") echo "selected"; ?>>SOKONGAN 1</option>
<option value="SOKONGAN 2" <?php if(($capture["kumpulan"] ?? "") == "SOKONGAN 2") echo "selected"; ?>>SOKONGAN 2</option>
</select></td>
<?php } else { echo "<td align='left'>".htmlspecialchars($capture['kumpulan'] ?? '')."<input type='hidden' name='kumpulan' value='".htmlspecialchars($capture['kumpulan'] ?? '')."'></td>"; } ?>                    
</tr>

<tr>
<td><div align="right"><span class="style20"> Jabatan</span> : </div></td>
<?php if(($_SESSION['level'] ?? 0) > 3 ){ ?>
<td align="left">
<select name='jabatan' id='jabatan'>
<option value=''>Sila Buat Pilihan Jabatan/Unit</option>
<?php 
$strSQL2 = "SELECT namajabatan from jabatan order by namajabatan"; 
$objQuery2 = mysqli_query($conn, $strSQL2); // Added connection
if ($objQuery2) {
    while($capture2 = mysqli_fetch_array($objQuery2))
    {   
?><option value='<?php echo htmlspecialchars($capture2["namajabatan"] ?? ''); ?>' <?php if (($capture["jabatan"] ?? "") == ($capture2["namajabatan"] ?? "")) { echo "selected"; } ?>><?php echo htmlspecialchars($capture2["namajabatan"] ?? ''); ?></option><?php 
    }
} else {
    echo "<option value=''>Error loading jabatan</option>";
}
?>     
</select></td>
<?php } else { 
    echo "<td align='left'>".htmlspecialchars($capture['jabatan'] ?? '')."<input type='hidden' name='jabatan' value='".htmlspecialchars($capture['jabatan'] ?? '')."'></td>";
} ?>          
</tr>

<tr><td colspan="4">&nbsp;</td></tr>
<tr><td colspan="4">&nbsp;</td></tr>

<tr>
<td colspan="4"><div align="center" class="tablestyleB">
<input name="nokp" type="hidden" id="nokp" value="<?php echo htmlspecialchars($nokp); ?>"/>
<!-- <input name="Submit3" type="button" class="style10" onclick="history.back()" value="&lt;&lt; Kembali" />&nbsp; -->
<input class="style10" type="submit" name="updatestaff" id="updatestaff" onclick="return fill_register()" value="Kemaskini" />
</td>
</tr>

</table>
<br />
</form>	 

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