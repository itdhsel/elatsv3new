<?php 
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Include privcheck.php properly with defined constant
define('INCLUDED', true);
if (file_exists('privcheck.php')) {
    include('privcheck.php');
} else {
    // Fallback access control
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['level']) || (($_SESSION['level'] ?? 0) <= 0)) {
        echo '<script>alert("Hanya Pengguna Berdaftar Dibenarkan Menggunakan Sistem Ini"); window.location.href="index.php";</script>';
        exit();
    }
}

// Include database connection directly
if (!file_exists('files/db.php')) {
    die('Error: Database configuration file not found.');
}

include('files/db.php');

// Check if database connection is successful
if (!$conn) {
    die('Database connection failed: ' . (function_exists('mysqli_connect_error') ? mysqli_connect_error() : 'Unknown error'));
}

$nokp = $_GET['nokp'] ?? '';
$id = $_GET['id'] ?? '';

// Validate inputs
if (empty($nokp) || empty($id)) {
    echo '<script>alert("Parameter tidak sah"); window.location.href="index.php";</script>';
    exit();
}

// Validate nokp format (should be 12 digits)
if (!preg_match('/^\d{12}$/', $nokp)) {
    echo '<script>alert("Format No KP tidak sah. Mesti 12 digit nombor."); window.location.href="index.php";</script>';
    exit();
}

// Use prepared statements for security
$query1 = "SELECT namapegawai, nokp, jantina, bangsa, skim_khidmat, gredhakiki, kumpulan, jabatan, status
            FROM peribadi 
            WHERE nokp = ?";
$stmt1 = mysqli_prepare($conn, $query1);

if ($stmt1) {
    mysqli_stmt_bind_param($stmt1, "s", $nokp);
    $execute_result1 = mysqli_stmt_execute($stmt1);
    
    if (!$execute_result1) {
        mysqli_stmt_close($stmt1);
        echo '<script>alert("Database error occurred."); window.location.href="index.php";</script>';
        exit();
    }
    
    $result2 = mysqli_stmt_get_result($stmt1);
    
    if (!$result2) {
        mysqli_stmt_close($stmt1);
        echo '<script>alert("Database result error."); window.location.href="index.php";</script>';
        exit();
    }

    $found2 = mysqli_num_rows($result2);
    if ($found2 > 0) {
        $capture2 = mysqli_fetch_assoc($result2);
    } else {
        mysqli_stmt_close($stmt1);
        echo '<script>alert("Rekod peribadi tidak dijumpai"); window.location.href="index.php";</script>';
        exit();
    }
    mysqli_stmt_close($stmt1);
} else {
    echo '<script>alert("Database preparation error."); window.location.href="index.php";</script>';
    exit();
}

$query2 = "SELECT id, nokp2, kategori, jenis_kursus, jenis_program, nama_kursus, penganjur, 
            jenis_penganjur_luaran, jenis_penganjur_dalaman, agensi_luar, lokasi, 
            DATE_FORMAT(`tarikh_mula`,'%d-%m-%Y') as tarikh_mula, 
            DATE_FORMAT(`tarikh_tamat`,'%d-%m-%Y') as tarikh_tamat,
            lain_lokasi, total_jam, rm, nolpo, cpdpoint, cpdcategory, status_kursus, 
            borang, borang_dikembalikan, user_id, valid
            FROM kursus
            WHERE nokp2 = ? AND id = ?";
$stmt2 = mysqli_prepare($conn, $query2);

if ($stmt2) {
    mysqli_stmt_bind_param($stmt2, "si", $nokp, $id);
    $execute_result2 = mysqli_stmt_execute($stmt2);
    
    if (!$execute_result2) {
        mysqli_stmt_close($stmt2);
        echo '<script>alert("Database error occurred."); window.location.href="index.php";</script>';
        exit();
    }
    
    $result = mysqli_stmt_get_result($stmt2);
    
    if (!$result) {
        mysqli_stmt_close($stmt2);
        echo '<script>alert("Database result error."); window.location.href="index.php";</script>';
        exit();
    }

    $found = mysqli_num_rows($result);
    if ($found > 0) {
        $capture = mysqli_fetch_assoc($result);
    } else {
        mysqli_stmt_close($stmt2);
        echo '<script>alert("Rekod kursus tidak dijumpai"); window.location.href="index.php";</script>';
        exit();
    }
    mysqli_stmt_close($stmt2);
} else {
    echo '<script>alert("Database preparation error."); window.location.href="index.php";</script>';
    exit();
}

// Get jabatan list for dropdown - DON'T close connection yet
$jabatan_list = [];
$strSQL2 = "SELECT namajabatan FROM jabatan"; 
$objQuery2 = mysqli_query($conn, $strSQL2);
if ($objQuery2) {
    while($capture_jabatan = mysqli_fetch_assoc($objQuery2)) {
        $jabatan_list[] = $capture_jabatan;
    }
}

// DO NOT close database connection here - header.php needs it
// mysqli_close($conn); // REMOVED THIS LINE
?>
<!DOCTYPE html>
<html lang="ms">
<head>
<title>Sistem Pengurusan Latihan Hospital Selayang - eLats V3</title>
<meta charset="UTF-8">
<?php 
// Include pagetitleheader safely
if (file_exists('pagetitleheader.php')) {
    include('pagetitleheader.php');
} else {
    echo '<link rel="stylesheet" href="css/styles.css" type="text/css">';
}
?> 

<script type="text/javascript">
function updateCombo(optionValue) {
    const dalamanSelect = document.getElementById('jenis_penganjur_dalaman');
    const luaranSelect = document.getElementById('jenis_penganjur_luaran');
    const agensiInput = document.getElementById('agensi_luar');
    
    if (dalamanSelect) dalamanSelect.disabled = (optionValue !== 'DALAMAN');
    if (luaranSelect) luaranSelect.disabled = (optionValue !== 'LUARAN');
    
    // Also update agensi_luar based on current state
    if (agensiInput && luaranSelect) {
        agensiInput.disabled = (luaranSelect.value !== 'AGENSI LUAR' || optionValue !== 'LUARAN');
    }
}

function updateCombo2(optionValue) {    
    const agensiInput = document.getElementById('agensi_luar');
    if (agensiInput) {
        agensiInput.disabled = (optionValue !== 'AGENSI LUAR');
    }
}

function checkdate(inputdate) {
    if (!inputdate || !inputdate.value) return true;
    
    const EnteredDate = inputdate.value;
    if (EnteredDate.length < 10) return true;
    
    const date = EnteredDate.substring(0, 2);
    const month = EnteredDate.substring(3, 5);
    const year = EnteredDate.substring(6, 10);

    const myDate = new Date(year, month - 1, date);
    const today = new Date();

    if (myDate > today) {
        alert("Tarikh yang dimasukkan melebihi tarikh hari ini. Hanya kursus yang telah dihadiri dibenarkan.");
        inputdate.focus();
        return false;
    }
    return true;
}

function bezahari() {  
    const one_day = 1000 * 60 * 60 * 24; 
    const tarikhMula = document.update.tarikh_mula?.value;
    const tarikhTamat = document.update.tarikh_tamat?.value;

    if (!tarikhMula || !tarikhTamat) return;

    const date11 = tarikhMula.split("-");
    const date21 = tarikhTamat.split("-");
    
    if (date11.length < 3 || date21.length < 3) return;

    const date111 = new Date(date11[2], date11[1] - 1, date11[0]);
    const date211 = new Date(date21[2], date21[1] - 1, date21[0]);

    const Diff = Math.ceil((date211.getTime() - date111.getTime()) / (one_day)); 
    const jumlahharikursus = Diff + 1;
    
    if (jumlahharikursus > 1) {
        document.update.total_jam.value = jumlahharikursus * 6;
    }

    if (jumlahharikursus > 1) {
        if (document.update.keperluan_borang) document.update.keperluan_borang.value = 'PERLU';
        if (document.update.status_borang) document.update.status_borang.value = 'BELUM DIKEMBALIKAN';
    } else {
        if (document.update.keperluan_borang) document.update.keperluan_borang.value = 'TIDAK PERLU';
        if (document.update.status_borang) document.update.status_borang.value = 'TIDAK BERKENAAN';
    }
}

function fill_register() {
    const form = document.update;
    if (!form) return false;

    if(!form.kategori || form.kategori.value === '' || form.kategori.value === 'Sila Buat Pilihan') {
        alert('Sila isi maklumat kategori');
        if(form.kategori) form.kategori.focus();
        return false;
    }
    else if(!form.jenis_kursus || form.jenis_kursus.value === '' || form.jenis_kursus.value === 'Sila Buat Pilihan') {
        alert('Sila isi maklumat jenis kursus');
        if(form.jenis_kursus) form.jenis_kursus.focus();
        return false;
    }
    else if(!form.nama_kursus || form.nama_kursus.value === '') {
        alert('Sila isi nama kursus');
        if(form.nama_kursus) form.nama_kursus.focus();
        return false;
    }
    else if(!form.penganjur || form.penganjur.value === '' || form.penganjur.value === 'Sila Buat Pilihan') {
        alert('Sila isi penganjur kursus');
        if(form.penganjur) form.penganjur.focus();
        return false;
    }
    else if(!form.tarikh_mula || form.tarikh_mula.value === '') {
        alert('Sila isi tarikh mula');
        if(form.tarikh_mula) form.tarikh_mula.focus();
        return false;
    }
    else if(!form.tarikh_tamat || form.tarikh_tamat.value === '') {
        alert('Sila isi tarikh tamat');
        if(form.tarikh_tamat) form.tarikh_tamat.focus();
        return false;
    }
    else if(!form.total_jam || form.total_jam.value === '') {
        alert('Sila isi jumlah jam');
        if(form.total_jam) form.total_jam.focus();
        return false;
    }
    else if(form.tarikh_mula.value === form.tarikh_tamat.value && form.total_jam.value > 6 && form.jenis_kursus.value !== 'EPSA') {
        alert('Jumlah jam melebihi 6 jam dan kursus ini bukan kursus EPSA.');
        if(form.total_jam) form.total_jam.focus();
        return false;
    }
    else if(form.total_jam.value <= 0) {
        alert('Jumlah jam yang dikira sistem adalah 0 jam atau kurang.');
        if(form.total_jam) form.total_jam.focus();
        return false;
    }
    else if(form.tarikh_mula.value !== form.tarikh_tamat.value) {
        bezahari();
        return true;
    }
    else {
        return true;
    }
}

// Initialize form fields on page load
document.addEventListener('DOMContentLoaded', function() {
    const penganjurSelect = document.getElementById('penganjur');
    const jenisLuaranSelect = document.getElementById('jenis_penganjur_luaran');
    
    if (penganjurSelect) {
        updateCombo(penganjurSelect.value);
    }
    if (jenisLuaranSelect) {
        updateCombo2(jenisLuaranSelect.value);
    }
});
</script>

<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar/css/calendar-system.css" />
</head>

<body>
<?php 
// Include header safely
if (file_exists('header.php')) {
    include('header.php');
} else {
    echo '<div style="padding:10px; background:#8B8378; color:white; text-align:center;">Sistem Pengurusan Latihan Hospital Selayang</div>';
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<?php 
// Include rightmenu2 safely
if (file_exists('rightmenu2.php')) {
    include('rightmenu2.php');
} else {
    echo '<td width="150" valign="top" bgcolor="#d9cfcc">Menu tidak tersedia</td>';
}
?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">  	
<table width=100%><tr><td height="30" bgcolor=#8B8378 align=center><span class="style21">KEMASKINI MAKLUMAT KURSUS</span></td></tr></table>
          <table border=0 width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
            <tr>
              <td colspan="2" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style1">
                  <div align="center" class="style21">BUTIR - BUTIR PERIBADI </div>
              </div></td>
              </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td width="300"><div align="right">
                  <span class="style20">Nama Pegawai</span> : 
              </div></td>
              <td align="left"><span class="style19"><?php echo htmlspecialchars($capture2["namapegawai"] ?? ''); ?></span></td>
              </tr>
            <tr>
              <td align="right"><span class="style20">No IC</span> : </td>
              <td align="left"><span class="style19"><?php echo htmlspecialchars($capture2["nokp"] ?? ''); ?></td>
            </tr>
            <tr>
              <td align="right"> <strong>Jawatan</strong> :</td>
              <td align="left"><span class="style19"><?php echo htmlspecialchars($capture2["skim_khidmat"] ?? ''); ?></span></td>
            </tr>
            <tr>
              <td align="right"><span class="style20">Gred</span> : </td>
              <td align="left"><span class="style19"><?php echo htmlspecialchars($capture2["gredhakiki"] ?? ''); ?></span></td>
            </tr>
            <tr>
              <td align="right"><span class="style20">Kumpulan</span> : </td>
              <td align="left"><span class="style19"><?php echo htmlspecialchars($capture2["kumpulan"] ?? ''); ?></span></td>
            </tr>
            <tr>
              <td align="right"><strong>Jabatan</strong>: </td>
              <td align="left"><span class="style19"><?php echo htmlspecialchars($capture2["jabatan"] ?? ''); ?></span></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              </tr>
          </table>
		  <br />
		  <table border=0 width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
            <tr>
              <td colspan="2" align="center" valign="middle" bgcolor=#8B8378><div align="center" class="style1">
                  <div align="center" class="style21">KEMASKINI KURSUS YANG TELAH DIHADIRI </div>
              </div></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <form id="update" name="update" method="post" action="staff_kursus_detail_berjaya.php">

		<tr>
                <td width="300" align="right"><span class="style20">Kategori</span> : </td>
                <td align="left"><select name='kategori' id='kategori'>
                  <option value='' <?php if(($capture["kategori"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                  <option value="PENCERAMAH" <?php if(($capture["kategori"] ?? '') == "PENCERAMAH") echo 'selected'; ?>>PENCERAMAH</option>
                  <option value="PESERTA" <?php if(($capture["kategori"] ?? '') == "PESERTA") echo 'selected'; ?>>PESERTA</option>
                </select>
                  <span class="style26">*</span></td>
              </tr>

              <tr>
                <td align="right"><span class="style20">Jenis Kursus</span> : </td>
                <td align="left"><select name='jenis_kursus' id='jenis_kursus'>
                  <option value='' <?php if(($capture["jenis_kursus"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                  <option value="DALAMAN" <?php if(($capture["jenis_kursus"] ?? '') == "DALAMAN") echo 'selected'; ?>>DALAMAN</option>
                  <option value="LUARAN" <?php if(($capture["jenis_kursus"] ?? '') == "LUARAN") echo 'selected'; ?>>LUARAN</option>
                  <option value="INDUKSI UMUM" <?php if(($capture["jenis_kursus"] ?? '') == "INDUKSI UMUM") echo 'selected'; ?>>INDUKSI UMUM</option>
                  <option value="INDUKSI KHUSUS" <?php if(($capture["jenis_kursus"] ?? '') == "INDUKSI KHUSUS") echo 'selected'; ?>>INDUKSI KHUSUS</option>
                  <option value="PTM" <?php if(($capture["jenis_kursus"] ?? '') == "PROGRAM TRANSFORMASI MINDA") echo 'selected'; ?>>PROGRAM TRANSFORMASI MINDA</option>
                  <option value="POSBASIK" <?php if(($capture["jenis_kursus"] ?? '') == "POS BASIK") echo 'selected'; ?>>POS BASIK</option>
                  <option value="EPSA" <?php if(($capture["jenis_kursus"] ?? '') == "EPSA") echo 'selected'; ?>>EPSA</option>
                  <option value="CME/CNE/CAE" <?php if(($capture["jenis_kursus"] ?? '') == "CME/CNE/CAE") echo 'selected'; ?>>CME/CNE/CAE</option>
                  <?php if(($_SESSION['level'] ?? 0) > 3) { ?>
                  <option value="KAVEAT" <?php if(($capture["jenis_kursus"] ?? '') == "KAVEAT") echo 'selected'; ?>>KAVEAT</option>
                  <?php } ?>
                </select>
                  <span class="style26">*</span></td>
              </tr>
             
              <tr>
                <td align="right"><span class="style20">Nama Kursus</span> : </td>
                <td align="left"><input name="nama_kursus" type="text" id="nama_kursus" style="text-transform: uppercase" value="<?php echo htmlspecialchars($capture['nama_kursus'] ?? ''); ?>" size="30" />
                  <span class="style26">*</span></td>
              </tr>
              
              <tr>
                <td align="right"><span class="style20">Penganjur</span> : </td>
                <td align="left"><select name='penganjur' id='penganjur' onChange="updateCombo(this.value)">
                  <option value='' <?php if(($capture["penganjur"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                  <option value="DALAMAN" <?php if(($capture["penganjur"] ?? '') == "DALAMAN") echo 'selected'; ?>>DALAMAN</option>
                  <option value="LUARAN" <?php if(($capture["penganjur"] ?? '') == "LUARAN") echo 'selected'; ?>>LUARAN</option>
                </select>
                  <span class="style26">*</span></td>
              </tr>
              
              <tr>
                <td align="right"><span class="style20"><strong>Jenis Penganjur Luaran</strong></span> : </td>
                <td align="left"><select name='jenis_penganjur_luaran' id='jenis_penganjur_luaran' onChange="updateCombo2(this.value)">
                  <option value='' <?php if(($capture["jenis_penganjur_luaran"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                  <option value="AGENSI LUAR" <?php if(($capture["jenis_penganjur_luaran"] ?? '') == "AGENSI LUAR") echo 'selected'; ?>>AGENSI LUAR</option>
                  <option value="JKNS" <?php if(($capture["jenis_penganjur_luaran"] ?? '') == "JKNS") echo 'selected'; ?>>JKNS</option>
                  <option value="KKM" <?php if(($capture["jenis_penganjur_luaran"] ?? '') == "KKM") echo 'selected'; ?>>KKM</option>
                </select></td>
              </tr>

              <tr>
                <td align="right"><span class="style20"><strong>Jenis Penganjur Dalaman</strong></span> : </td>
                <td align="left">
                <select name='jenis_penganjur_dalaman' id='jenis_penganjur_dalaman' onChange="updateCombo2(this.value)">
                  <option value='' <?php if(($capture["jenis_penganjur_dalaman"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                  <?php 
                    if (!empty($jabatan_list)) {
                        foreach($jabatan_list as $capture_jabatan) {
                            $selected = (($capture["jenis_penganjur_dalaman"] ?? '') == $capture_jabatan["namajabatan"]) ? 'selected' : '';
                            echo '<option value="'.htmlspecialchars($capture_jabatan["namajabatan"]).'" '.$selected.'>'.htmlspecialchars($capture_jabatan["namajabatan"]).'</option>';
                        }
                    }
                  ?>     
                </select>
                </td>
              </tr>

              <tr>
                <td align="right"><span class="style20">Agensi Luar</span> : </td>
                <td align="left"><input name="agensi_luar" disabled="disabled" type="text" style="text-transform: uppercase" id="agensi_luar" value="<?php echo htmlspecialchars($capture['agensi_luar'] ?? ''); ?>" size="45" /></td>
              </tr>

              <tr>
                <td align="right"><span class="style20">Lokasi</span> : </td>
                <td align="left"><select name='lokasi' id='lokasi'>
                  <option value='' <?php if(($capture["lokasi"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                  <option value="AUDITORIUM HSLYG" <?php if(($capture["lokasi"] ?? '') == "AUDITORIUM HSLYG") echo 'selected'; ?>>AUDITORIUM HSLYG</option>
                  <option value="BILIK SEMINAR 1&2" <?php if(($capture["lokasi"] ?? '') == "BILIK SEMINAR 1&2") echo 'selected'; ?>>BILIK SEMINAR 1&2</option>
                  <option value="BILIK SEMINAR 3&4" <?php if(($capture["lokasi"] ?? '') == "BILIK SEMINAR 3&4") echo 'selected'; ?>>BILIK SEMINAR 3&4</option>
                  <option value="AUDITORIUM UITM" <?php if(($capture["lokasi"] ?? '') == "AUDITORIUM UITM") echo 'selected'; ?>>AUDITORIUM UITM</option>
                  <option value="BILIK LATIHAN ITD" <?php if(($capture["lokasi"] ?? '') == "BILIK LATIHAN ITD") echo 'selected'; ?>>BILIK LATIHAN ITD</option>
                  <option value="LAIN-LAIN" <?php if(($capture["lokasi"] ?? '') == "LAIN-LAIN") echo 'selected'; ?>>LAIN-LAIN</option>
                </select></td>
              </tr>
       
              <tr>
                <td align="right"><span class="style20">Lain-Lain Lokasi</span> : </td>
                <td align="left"><input name="lain_lokasi" type="text" id="lain_lokasi" style="text-transform: uppercase" value="<?php echo htmlspecialchars($capture['lain_lokasi'] ?? ''); ?>" size="30" /></td>
              </tr>
 
              <tr>
                <td align="right"><strong>Tarikh Mula</strong> : </td>
                <td align="left">
                <input name="tarikh_mula" type="text" id="tarikh_mula" value="<?php echo htmlspecialchars($capture['tarikh_mula'] ?? ''); ?>" size="16" onchange="checkdate(this)">
                <span class="style26">*</span></td>
              </tr>
              
              <tr>
                <td align="right"><strong>Tarikh Tamat</strong> : </td>
                <td align="left">
                <input name="tarikh_tamat" type="text" id="tarikh_tamat" value="<?php echo htmlspecialchars($capture['tarikh_tamat'] ?? ''); ?>" size="16" onchange="checkdate(this)">
                <span class="style26">* Untuk kursus sehari atau kurang, sila masukkan tarikh yang sama</span></td>
              </tr>
              
              <tr>
                <td align="right"><strong>Jumlah Jam</strong> : </td>
                <td align="left"><input name="total_jam" type="text" id="total_jam" value="<?php echo htmlspecialchars($capture['total_jam'] ?? ''); ?>" size="8" maxlength="3" onFocus="bezahari()" />
                  <span class="style26"> * 6 jam = 1 hari kursus. Sila kemaskini jam jika kursus hari yang sama. </span></td>
              </tr>

              <tr>
                <td align="right"><span class="style20">Borang Keberkesanan</span> : </td>
                <td align="left">
                <select name='keperluan_borang' id='keperluan_borang' <?php if(($_SESSION['level'] ?? 0) < 3) { ?> disabled <?php } ?>>
                <option value='' <?php if(($capture["borang"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                <option value="PERLU" <?php if(($capture["borang"] ?? '') == "PERLU") echo 'selected'; ?>>PERLU</option>
                <option value="TIDAK PERLU" <?php if(($capture["borang"] ?? '') == "TIDAK PERLU") echo 'selected'; ?>>TIDAK PERLU</option>
                </select>
                <span class="style26">* Untuk kursus yang melebihi 2 hari</span>
                <?php if (($_SESSION['level'] ?? 0) < 3) { 
                    echo "<input type='hidden' name='keperluan_borang' value='".htmlspecialchars($capture["borang"] ?? '')."'>";
                } ?>
                </td>
              </tr>
              
              <tr>
                <td align="right"><span class="style20">Status Borang</span> : </td>
                <td align="left">
                <select name='status_borang' id='status_borang' <?php if(($_SESSION['level'] ?? 0) < 3) { ?> disabled <?php } ?>>
                <option value='' <?php if(($capture["borang_dikembalikan"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                <option value="DIKEMBALIKAN" <?php if(($capture["borang_dikembalikan"] ?? '') == "DIKEMBALIKAN") echo 'selected'; ?>>DIKEMBALIKAN</option>
                <option value="BELUM DIKEMBALIKAN" <?php if(($capture["borang_dikembalikan"] ?? '') == "BELUM DIKEMBALIKAN") echo 'selected'; ?>>BELUM DIKEMBALIKAN</option>
                <option value="TIDAK BERKENAAN" <?php if(($capture["borang_dikembalikan"] ?? '') == "TIDAK BERKENAAN") echo 'selected'; ?>>TIDAK BERKENAAN</option>
                </select>
                <span class="style26">* Jika perlu mengisi borang</span>
                <?php if (($_SESSION['level'] ?? 0) < 3) { 
                    echo "<input type='hidden' name='status_borang' value='".htmlspecialchars($capture["borang_dikembalikan"] ?? '')."'>";
                } ?>
                </td>
              </tr>  

              <tr <?php if(($_GET["highlight"] ?? '') == 1) { echo "bgcolor=#cccccc"; } ?>>
                <td align="right"><span class="style20">Status Pendaftaran Kursus</span> : </td>
                <td align="left">
                <select name='status_kursus' id='status_kursus' <?php if(($_SESSION['level'] ?? 0) < 3) { ?> disabled <?php } ?>>
                <option value='' <?php if(($capture["valid"] ?? '') == "") echo 'selected'; ?>>Sila Buat Pilihan</option>
                <option value="0" <?php if(($capture["valid"] ?? '') == "0") echo 'selected'; ?>>BELUM DISAHKAN</option>
                <option value="1" <?php if(($capture["valid"] ?? '') == "1") echo 'selected'; ?>>TELAH DISAHKAN</option>
                </select>
                <span class="style26">*</span>
                <?php if (($_SESSION['level'] ?? 0) < 3) { 
                    echo "<input type='hidden' name='valid' value='".htmlspecialchars($capture["valid"] ?? '')."'>";
                } ?>
                </td>
              </tr> 
                                      
              <tr>
                <td colspan="2"><span class="style10">
                  <input name="nokp" type="hidden" id="nokp" value="<?php echo htmlspecialchars($nokp); ?>"/>
                  <input name="id" type="hidden" id="id" value="<?php echo htmlspecialchars($id); ?>"/>
                </span></td>
              </tr>
              
              <tr>
                <td colspan="2" align=center>
                &nbsp; <span class="style26">Ruang bertanda * adalah mandatori untuk diisi. <br>Sila klik ruangan Jumlah Jam untuk kemaskini data jika ada perubahan dilakukan.</span><br><br>
                <input name="updatekursus" type="submit" id="updatekursus" onClick="return fill_register();" value="Kemaskini" />
              </td>
              </tr>
            </form>
		    </table>
		  <br />
</td>	         
</tr>
</table>
<?php 
// Include footer safely
if (file_exists('footer.php')) {
    include('footer.php');
} else {
    echo '</body></html>';
}

// Close database connection AFTER all includes that need it
if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>