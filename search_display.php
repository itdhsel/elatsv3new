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
<?php include('header.php'); ?>
<?php include('rightmenu2.php'); ?> 

<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">

<input name="nokp" type="hidden" id="nokp" value="<?php echo htmlspecialchars($nokp ?? ''); ?>"/>
     
<table border="0" cellpadding="2" cellspacing="2" class="tablestyleB" width="100%" bordercolor="#f1988a">
<tr><td height="30" colspan="5" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">PAPARAN REKOD PERIBADI KAKITANGAN</div></td></tr>
<tr>
<td colspan="5" align="center" valign="middle" bgcolor="#8B8378"><div align="center" class="style21">BUTIR - BUTIR PERIBADI</div></td>
</tr>

<tr>
<td rowspan="7" width="250" align="right">&nbsp;</td>
<td width="100"><span class="style20">Nama Pegawai</span> </td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["namapegawai"] ?? ''); ?></span></td>
<td rowspan="8" width="100">&nbsp;</td>
</tr>

<tr>
<td><span class="style20">No IC </span> </td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["nokp"] ?? ''); ?></span></td>
</tr>

<tr>
<td><strong>Jantina </strong> </td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["jantina"] ?? ''); ?></span></td>
</tr>

<tr>
<td><span class="style20">Bangsa </span> </td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["bangsa"] ?? ''); ?></span></td>
</tr>

<tr>
<td><strong>Email </strong></td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["email"] ?? ''); ?></span></td>
</tr>

<tr>
<td><strong>Status </strong></td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["status"] ?? ''); ?></span></td>
</tr>

<tr>
<td colspan="5">&nbsp;</td>
</tr>
            
<tr>
<td colspan="5" bgcolor="#8B8378"><div align="center" class="style21">BUTIR - BUTIR PERKHIDMATAN </div></td>
</tr>

<tr>
<td rowspan="4" width="250" align="right">&nbsp;</td>
<td><strong>Jawatan </strong></td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["skim_khidmat"] ?? ''); ?></span></td>
<td rowspan="4" width="100" align="right">&nbsp;</td>
</tr>

<tr>
<td><strong>Kumpulan </strong></td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["kumpulan"] ?? ''); ?></span></td>
</tr>
            
<tr>
<td><strong>Gred </strong></td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["gredhakiki"] ?? ''); ?></span></td>
</tr>

<tr>
<td><strong>Jabatan </strong></td><td>: </td>
<td align="left"><span class="style19"><?php echo htmlspecialchars($capture["jabatan"] ?? ''); ?></span></td>             
</tr>

<?php if(($_SESSION['level'] ?? 0) > 3) { ?>
<tr>
<td colspan="5" align="center">
<br>
<form action="deleterekod.php" method="post">                  
<input type="submit" name="delete" class="style10" value="Hapuskan Rekod Pegawai <?php echo htmlspecialchars($nokp); ?>">
<input type="hidden" name="nokp" value="<?php echo htmlspecialchars($nokp); ?>">
</form>
</td>                
</tr>
<?php } ?>

</table>

<br>     
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