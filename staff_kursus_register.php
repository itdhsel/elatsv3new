<?php 

session_start();
include('privcheck.php');

if(($_SESSION['level'] ?? 0) > 0)
{

include('files/db.php');

// Safely get nokp with validation
$nokp = $_GET['nokp'] ?? '';

// Use prepared statement for security
$query2 = "SELECT * FROM peribadi WHERE nokp = ?";
$stmt = $conn->prepare($query2);
if ($stmt) {
    $stmt->bind_param("s", $nokp);
    $stmt->execute();
    $result2 = $stmt->get_result();
    $found2 = $result2->num_rows;
    $capture2 = $result2->fetch_assoc();
    $staffemail = $capture2["email"] ?? '';
    $stmt->close();
} else {
    // Handle error
    $found2 = 0;
    $capture2 = [];
    $staffemail = '';
}


?>

<?php include('pagetitleheader.php'); ?> 


<script type="text/javascript">
function checkdate(inputdate)
{

var EnteredDate = inputdate.value; //for javascript

var date = EnteredDate.substring(0, 2);
var month = EnteredDate.substring(3, 5);
var year = EnteredDate.substring(6, 10);

var myDate = new Date(year, month - 1, date);
var today = new Date();

if (myDate > today) {
alert("Tarikh yang dimasukkan melebihi tarikh hari ini. Hanya kursus yang telah dihadiri dibenarkan.");
return false;
 }

}

function updateCombo(optionValue)
{    
		document.getElementById('jenis_penganjur_luaran').disabled = (optionValue!='LUARAN');
		document.getElementById('jenis_penganjur_dalaman').disabled = (optionValue!='DALAMAN');

}
</script>

<script type="text/javascript">
function updateCombo2(optionValue)
{    
		
	document.getElementById('agensi_luar').disabled = (optionValue != 'AGENSI LUAR');


}
</script>


<script type="text/javascript">
function updateCombo3(optionValue)
{    
		document.getElementById('lain_lokasi').disabled = (optionValue!='LAIN-LAIN');
		

}
</script>



<script type="text/javascript">
function updateCombo4(optionValue)
{    
		//document.reason_other.disabled = (optionValue!='Others');
		document.getElementById('lain_lokasi').disabled = (optionValue!='LAIN-LAIN');
}

</script>
                                                                                                                    
<script type="text/javascript">
function bezahari()
{  
var one_day=1000*60*60*24; 

var date1 = document.register.tarikh_mula.value;  
var date11 = date1.split("-");
var date111 = new Date(date11[2], date11[1], date11[0]);

var date2 = document.register.tarikh_tamat.value;  
var date21 = date2.split("-");
var date211 = new Date(date21[2], date21[1], date21[0]);

var Diff=Math.ceil((date211.getTime()-date111.getTime())/(one_day)); 

var jumlahharikursus = Diff + 1;

if (jumlahharikursus == 1)
{
//alert ('Kursus adalah pada hari yang sama. Sila masukkan jumlah jam kursus tersebut tidak melebihi 6 jam jika bukan kursus EPSA.');
//document.register.total_jam.value=1;
//document.getElementById('total_jam').disabled = false;
//return false;
}
else
{
  if (jumlahharikursus < 1)
  {
  alert ('Pilihan Tarikh Tamat kursus adalah salah kerana memberikan nilai negatif. Sila masukkan semula Tarikh Tamat kursus');
  document.register.total_jam.value=0;
  return false;
  }
  else
  {
  //alert ('Kursus adalah selama '+ jumlahharikursus +' hari iaitu bersamaan '+ jumlahharikursus*6 +' jam');
  document.register.total_jam.value=jumlahharikursus*6;
  //document.getElementById('total_jam').disabled;
  //document.getElementById('total_jam').disabled = true;
  }
}

if (jumlahharikursus > 3)
{
document.register.keperluan_borang.value='PERLU';
document.register.status_borang.value='BELUM DIKEMBALIKAN';
}
else
{
document.register.keperluan_borang.value='TIDAK PERLU';
document.register.status_borang.value='TIDAK BERKENAAN';
}

}
</script>


<script type="text/JavaScript">
function fill_register()
{
	if(document.register.kategori.value=='Sila Buat Pilihan')
	{
		alert('Sila isi maklumat kategori');
    document.register.kategori.focus();
		return false;
	}
  
  else if(document.register.jenis_kursus.value=='Sila Buat Pilihan')
	{
		alert('Sila isi maklumat jenis kursus');
    document.register.jenis_kursus.focus();
		return false;
	}

	else if(document.register.nama_kursus.value=='')
	{
		alert('Sila isi nama kursus');
    document.register.nama_kursus.focus();
		return false;
	}
  
  else if(document.register.penganjur.value=='Sila Buat Pilihan')
	{
		alert('Sila isi penganjur kursus');
    document.register.penganjur.focus();
		return false;
	}

	else if(document.register.tarikh_mula.value=='')
	{
		alert('Sila isi tarikh mula');
    document.register.tarikh_mula.focus();
		return false;
	}
  
  else if(document.register.tarikh_tamat.value=='')
	{
		alert('Sila isi tarikh tamat');
    document.register.tarikh_tamat.focus();
		return false;
	}

  else if(document.register.total_jam.value=='')
	{
		alert('Sila isi jumlah jam');
    document.register.total_jam.focus();
		return false;
	}
  else if ( document.register.tarikh_mula.value==document.register.tarikh_tamat.value && document.register.total_jam.value>6 && document.register.jenis_kursus.value!='EPSA')
	{
    alert('Jumlah jam melebihi 6 jam dan kursus ini bukan kursus EPSA.');
    document.register.total_jam.focus();
    return false;
  }
  else if ( document.register.total_jam.value<=0)
  {
    alert('Jumlah jam yang dikira sistem adalah 0 jam atau kurang.');
    document.register.total_jam.focus();
    return false;
  }
	else if (document.register.tarikh_mula.value!=document.register.tarikh_tamat.value)
	{
    bezahari();
    return true;
  }
  else 
  {
    alert('Kursus yang anda telah masukkan adalah selama '+ document.register.total_jam.value +' jam.');
		return true;
	}
}
</script>


</head>
<?php include('header.php'); ?>
<?php include('rightmenu2.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000"> 

<form id="register" name="register" method="post" action="staff_kursus_register_berjaya.php">
<input name="nokp" type="hidden" id="nokp"  value="<?php echo htmlspecialchars($nokp); ?>"/>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">

<tr><td height="30" colspan="2" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style21">PENDAFTARAN  KURSUS BARU YANG TELAH DIHADIRI</div></td></tr>
  <tr><td height="30" colspan="2" align="center" valign="middle">&nbsp;</td></tr>
<tr><td><div align="right"><span class="style20">Kategori</span> : </div></td>
	<td align="left"><select name='kategori' id='kategori'>
		<option selected="">Sila Buat Pilihan</option>
		<option value="PESERTA">PESERTA</option>
		<option value="PENCERAMAH">PENCERAMAH</option>
		</select>
	    <span class="style26">*</span>
     </td>
</tr>

<tr><td align="right"><span class="style20">Jenis Kursus</span> :</td>
	<td align="left"><select name='jenis_kursus' id='jenis_kursus'>
		<option selected="selected">Sila Buat Pilihan</option>
		<option value="DALAMAN">DALAMAN</option>
		<option value="LUARAN">LUARAN</option>
		<option value="LUARAN">PASCA</option>
		<option value="INDUKSI UMUM">INDUKSI UMUM</option>
		<option value="INDUKSI KHUSUS">INDUKSI KHUSUS</option>
		<option value="PTM">PROGRAM TRANSFORMASI MINDA</option>
		<option value="POSBASIK">POS BASIK</option>
		<option value="EPSA">EPSA</option>
                <option value="CME/CNE/CAE">CME/CNE/CAE</option>
    </select>
		<span class="style26">*</span>
        </td>
</tr>

<tr><td><div align="right"><span class="style20">Nama  Kursus</span> : </div></td>
    <td align="left"><input name="nama_kursus" type="text" id="nama_kursus" style="text-transform: uppercase" size="50" /><span class="style26">*</span></td>
</tr>

<tr><td><div align="right"><span class="style20">Penganjur</span> : </div></td>
    <td align="left"><select name="penganjur" id="penganjur" onChange="updateCombo(this.value)">
        <option selected="">Sila Buat Pilihan</option>
        <option value="DALAMAN">DALAMAN</option>
        <option value="LUARAN">LUARAN</option>
		<option value="PASCA">PASCA</option>
        </select>
        <span class="style26">*</span></td>
</tr>
<tr><td><div align="right"><strong>Jenis Penganjur Luaran </strong>: </div></td>
    <td align="left"><select name="jenis_penganjur_luaran" id="jenis_penganjur_luaran" disabled="disabled" onChange="updateCombo2(this.value)">
        <option>Sila Buat Pilihan</option>
        <option value="AGENSI LUAR">AGENSI LUAR</option>
        <option value="JKNS">JKN SELANGOR</option>
        <option value="KKM">KKM</option>
        <option value="INTAN">INTAN</option>        
        </select>
        </td>
</tr>
<tr><td><div align="right"><strong>Jenis Penganjur Dalaman </strong>: </div></td>
    <td align="left"><select name="jenis_penganjur_dalaman" id="jenis_penganjur_dalaman" disabled="disabled" onChange="updateCombo2(this.value)">
        <option selected='selected'>Sila Buat Pilihan</option>
        <option value='KOMUNITI RESUSITASI HOSPITAL SELAYANG'>KOMUNITI RESUSITASI HOSPITAL SELAYANG</option>
        <?php 
        $strSQL2 = "SELECT namajabatan from jabatan order by namajabatan"; 
        $objQuery2 = mysqli_query($conn, $strSQL2) or die ("Error Query [".$strSQL2."]");   
        while($capture2 = mysqli_fetch_array($objQuery2))
        {   
		?><option value='<?php echo htmlspecialchars($capture2["namajabatan"] ?? '');?>'><?php echo htmlspecialchars($capture2["namajabatan"] ?? '');?></option><?php    
        }
        ?>     
        </select>
        </td>
</tr>
<tr><td><div align="right"><span class="style20">Agensi Luar </span> : </div></td>
    <td align="left"><input name="agensi_luar" disabled="disabled" style="text-transform: uppercase" type="text" id="agensi_luar" value="<?php echo htmlspecialchars($capture['agensi_luar'] ?? ''); ?>" size="45" /></td>
</tr>

<tr><td><div align="right"><strong>Lokasi </strong>: </div></td>
    <td align="left"><select name="lokasi" id="lokasi" onChange="updateCombo3(this.value)">
        <option selected="">Sila Buat Pilihan</option>
	    <option value="AUDITORIUM HSLYG">AUDITORIUM HSLYG</option>
		<option value="BILIK SEMINAR 1&2">BILIK SEMINAR 1&2</option>
		<option value="BILIK SEMINAR 3&4">BILIK SEMINAR 3&4</option>
		<option value="AUDITORIUM UITM">AUDITORIUM UITM</option>
		<option value="BILIK LATIHAN ITD">BILIK LATIHAN ITD</option>
		<option value="LAIN-LAIN">LAIN-LAIN</option>
		</select>
        </td>
</tr>

<tr><td><div align="right"><span class="style20">Lain-Lain Lokasi </span> : </div></td>
    <td align="left"><input name="lain_lokasi" type="text" id="lain_lokasi" style="text-transform: uppercase" size="40" / onChange="updateCombo3(this.value)"><span class="style26"> Jika Lokasi = LAIN-LAIN </span></td>
</tr>

<tr><td><div align="right"><strong>Tarikh Mula</strong> : </div></td>
    <script type="text/javascript">
	jQuery(document).ready(function() {
	jQuery("#tarikh_mula").dynDateTime(); //defaults
	});
    </script>
    <td align="left"><input name="tarikh_mula" type="text" id="tarikh_mula" size="16" onchange="checkdate(this)"><span class="style26">* Jika durasi kursus kurang 1 hari, pilih tarikh yang sama</span></td>
</tr>  
  
<tr><td><div align="right"><strong>Tarikh Tamat</strong>: </div></td>
    <script type="text/javascript">
	jQuery(document).ready(function() {
	jQuery("#tarikh_tamat").dynDateTime(); //defaults
	});
	</script> 
    <td align="left"><input name="tarikh_tamat" type="text" id="tarikh_tamat" size="16" onchange="checkdate(this)"><span class="style26">* </span></td>
</tr>

<tr><td><div align="right"><span class="style20">Jumlah Jam </span><span class="style01">:</span></div></td>
    <td align="left"><input name="total_jam" type="text" id="total_jam" size="8" maxlength="3" onFocus="bezahari()"><span class="style26"> * 6 jam = 1 hari kursus. </span></td>
</tr>

<!--
<tr><td><div align="right"><span class="style20">Mata CPD </span> : </div></td>
    <td align="left"><input name="cpdpoint" type="text" value="0" id="cpdpoint" size="30" /><span class="style26">* Jika berkaitan</span></td>
</tr>

<tr><td><div align="right"><span class="style20">Kategori CPD </span> : </div></td>
    <td align="left"><select name="cpdcategory" id="cpdcategory">
        <option selected="">Sila Buat Pilihan</option>
		<option value="A1">A1</option>
		<option value="A2">A2</option>
		<option value="A3">A3</option>
		<option value="A4">A4</option>
		<option value="A5">A5</option>
    	<option value="A6">A6</option>
		<option value="A7">A7</option>
        <option value="A8">A8</option>
		<option value="A9">A9</option>
		<option value="A10">A10</option>
		<option value="A11">A11</option>
		<option value="B1">B1</option>
    	<option value="B2">B2</option>
        </select>
        <span class="style26">* Jika Mata CPD diisi</span></td>
</tr>
<tr><td><div align="right"><span class="style20">Status </span> : </div></td>
    <td align="left"><select name='status_kursus' id='status_kursus'>
        <option selected="">Sila Buat Pilihan</option>
        <option value="LULUS">LULUS</option>
        <option value="GAGAL">GAGAL</option>
        </select>
	 	<span class="style26">* Untuk Kursus BTN, Induksi, Posbasik dan PTM</span>
        </td>
</tr>
-->

<?php if (($_SESSION['level'] ?? 0) < 3)
{
echo "<input type=hidden name='keperluan_borang' value='Sila Buat Pilihan'>";
echo "<input type=hidden name='status_borang' value='Sila Buat Pilihan'>";
}
else
{
?>

<tr><td><div align="right"><span class="style20">Borang Keberkesanan</span> : </div></td>
    <td align="left"><select name='keperluan_borang' id='keperluan_borang'>
        <option selected="">Sila Buat Pilihan</option>
        <option value="PERLU">PERLU</option>
        <option value="TIDAK PERLU" >TIDAK PERLU</option>
        </select>
	 	<span class="style26">* Untuk kursus yang 4 hari dan lebih</span>

        </td>
</tr>

<tr><td><div align="right"><span class="style20">Status Borang </span> : </div></td>
    <td align="left"><select name='status_borang' id='status_borang'>
        <option selected="">Sila Buat Pilihan</option>
        <option value="DIKEMBALIKAN" >DIKEMBALIKAN</option>
        <option value="BELUM DIKEMBALIKAN" >BELUM DIKEMBALIKAN</option>
        <option value="TIDAK BERKENAAN" >TIDAK BERKENAAN</option>
        </select>
	 	<span class="style26">* Jika perlu mengisi borang</span>

        </td>
</tr>  

<?php  } ?>
          
<tr><td colspan=2>&nbsp;</td></tr>

<tr><td colspan="2" align=center>
    <!-- <input name="Submit3" type="button" onClick="history.back()" value="&lt;&lt; Kembali" />  -->
    &nbsp;     <span class="style26">Ruang bertanda * adalah mandatori untuk diisi. <br>Klik pada ruangan Jumlah Jam untuk kemaskini masa kursus</span>
</td></tr>

<tr><td colspan="2">
    <input type="hidden" name="staffemail" value="<?php echo htmlspecialchars($staffemail); ?>">
    <div align="center" class="tablestyleB">
		<label><input type="submit" name="addkursus" id="addkursus" onClick="return fill_register()" value="Simpan" />&nbsp;</label>
    <label><input type="reset" name="reset" value="Kosongkan" /></label>
    </td>
</tr>

<tr><td colspan="2">
<table>
<tr><td align=left><img src="images/qmark.gif" width=50 height=30 alt="Panduan"></td>
<td> Panduan: [ <a href="pengelasanlatihan.php">Pengelasan Aktiviti Latihan</a> ]</td>
<td>[ <a href="pengiraankursus.php">Pengiraan Bilangan Hari Kursus</a> ]</td></tr>
</table>
</td></tr>
              
</table>  
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