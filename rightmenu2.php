<?php
// --- securing include file ---
if (isset($ping) != "pong") {
     exit('<h2>You cannot access this file directly!</h2>');
}
// --- end securing include file --
?>
<?php 
          
$queryname = "SELECT namapegawai, nokp FROM peribadi WHERE nokp = '$nokp'";
$resultname = mysqli_query($conn, $queryname);
if ($resultname) {
    $foundname = mysqli_num_rows($resultname);
    if ($foundname > 0) {
        $capturename = mysqli_fetch_array($resultname);
        $namastaff = $capturename["namapegawai"] ?? '';
    } else {
        $namastaff = 'Staff Not Found';
    }
} else {
    $namastaff = 'Error Loading Staff Name';
    error_log("Database error: " . mysqli_error($conn));
}

$level = $_SESSION['level'] ?? 0;
$belumsah = $_SESSION['belumsah'] ?? 0;
$user_id = $_SESSION['user_id'] ?? '';
$nokp_sanitized = htmlspecialchars($nokp ?? '', ENT_QUOTES, 'UTF-8');
$user_id_sanitized = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');

// Define image paths properly
$staffpico_path = '../staffpico/';
$imgfile = $nokp_sanitized . ".jpg";
$default_image = 'noimage.jpg';

// Check if default image exists, if not use alternative path or base64 placeholder
$default_image_path = $staffpico_path . $default_image;
if (!file_exists($default_image_path)) {
    // Try current directory if not found in staffpico
    $default_image_path = 'images/' . $default_image;
    if (!file_exists($default_image_path)) {
        // Use a base64 placeholder image as fallback
        $use_placeholder = true;
    } else {
        $use_placeholder = false;
    }
} else {
    $use_placeholder = false;
}

?>

<td valign="top" width="180" align="center" bgcolor="#CDB79E">

        <table border="0" cellpadding="4" cellspacing="4" width="164">
        <tr><td align="center" background='images/titlebox.png'><b>:: Menu Utama :: </b></td></tr>
        <tr><td background='images/textbox.png' align="left"><b><a href="mydashboard.php">Rumusan Info Latihan</a></b></td></tr>        
        
        <?php if($level > 2){ ?>
        <tr><td background='images/textbox.png' align="left"><b><a href="adminportal.php">Semak Daftar Latihan <?php if ($belumsah == 1) { ?><img src="new.gif" height="10" width="10" alt="new"><?php } ?></a></b></td></tr>
        <?php } ?>        
        
        <?php if($level > 1){ ?>
        <tr><td background='images/textbox.png' align="left"><b><a href="home.php">Paparan Kakitangan</a></b></td></tr>
        <tr><td background='images/textbox.png' align="left"><b><a href="search.php">- Carian Pegawai</a></b></td></tr>
        <?php } ?>     
        
        <?php if($level > 2){ ?>        
        <tr><td background='images/textbox.png' align="left"><b><a href="register_staff.php" class="style25">- Daftar Pegawai Baru</a></b></td></tr>
        <?php } ?>   

        <?php if($level == 5){ ?>
        <tr><td background='images/textbox.png' align="left"><b><a href="admin.php">Selenggara Pentadbir</a></b></td></tr>
        <tr><td background='images/textbox.png' align="left"><b><a href="editor.php">Editor Data Utama</a></b></td></tr>   
        <tr><td background='images/textbox.png'><b><a href="checkauditlog.php">Semak Audit Log</a></b></td></tr>  
        <tr><td background='images/textbox.png'><b><a href="adminenginemenu.php">Fungsi Backend</a></b></td></tr>              
        <?php } ?>  

        
        <?php if($level > 3){ ?>
        <tr><td background='images/textbox.png' align="left"><b><a href="report_new.php">Modul Laporan</a></b></td></tr>
        <?php } ?>
        

        <?php if($level == 1){ ?>        
        <tr><td background='images/textbox.png' align="left"><b><a href="chpswd.php?nokp=<?php echo $nokp_sanitized; ?>">Tukar kata laluan</a></b></td></tr>
        <?php } else { ?>
        <tr><td background='images/textbox.png' align="left"><b><a href="admin_reset_password.php?user_id=<?php echo $user_id_sanitized; ?>">Tukar kata laluan</a></b></td></tr>        
        <?php } ?>

        <tr><td background='images/textbox.png' align="left"><b><a href="logout.php">Log Keluar</a></b></td></tr>
        <tr><td>&nbsp;</td></tr>

        <tr><td bgcolor="#8B8378" align="center" background='images/titlebox.png'><b>:: Fail Kakitangan ::</b> </td></tr>

        <tr><td bgcolor="#cccccc" align="center">
            <?php
            $staff_image_path = $staffpico_path . $imgfile;
            
            if (file_exists($staff_image_path)) {
                echo '<img src="' . $staff_image_path . '" width="150" height="200" alt="Gambar Kakitangan">';
            } else {
                if (isset($use_placeholder) && $use_placeholder) {
                    // Base64 placeholder image as fallback
                    echo '<img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDE1MCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMjAwIiBmaWxsPSIjZGRkZGRkIi8+Cjx0ZXh0IHg9Ijc1IiB5PSIxMDAiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzY2NjY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZG9taW5hbnQtYmFzZWxpbmU9Im1pZGRsZSI+Tm8gSW1hZ2U8L3RleHQ+Cjwvc3ZnPgo=" width="150" height="200" alt="Tiada Gambar">';
                } else {
                    echo '<img src="' . $default_image_path . '" width="150" height="200" alt="Gambar Default">';
                }
            }
            ?>
        </td></tr>  

        <tr><td bgcolor="#cccccc" align="center"><?php echo htmlspecialchars($namastaff); ?><br></td></tr>
        <tr><td align="left"><b>PERIBADI</b></td></tr>
        <tr><td background='images/textbox.png' align="left"><a href="search_display.php?nokp=<?php echo $nokp_sanitized; ?>"><b>Paparan Rekod Peribadi</a></b></td></tr>

        <?php if($level == 1 || $level > 2){ ?> 
        <tr><td background='images/textbox.png' align="left"><a href="staff_update.php?nokp=<?php echo $nokp_sanitized; ?>"><b>Kemaskini Rekod Peribadi</a></b></td></tr>
        <?php } ?>

        <tr><td align="left"><b>KURSUS</b></td></tr>
        <tr><td background='images/textbox.png' align="left"><a href="staff_kursus.php?nokp=<?php echo $nokp_sanitized; ?>"><b>Paparan Kursus Dihadiri</a></b></td></tr>
        
        <?php if($level == 1 || $level > 2){ ?>   
        <tr><td background='images/textbox.png' align="left"><a href="staff_kursus_register.php?nokp=<?php echo $nokp_sanitized; ?>"><b>Daftar Kursus Baru</a></b></td></tr>
        <?php } ?>

        <?php if($level > 2){ ?>        
        <tr><td align="left"><b>KATA LALUAN</b></td></tr>
        <tr><td background='images/textbox.png' align="left"><a href="chpswd_admin.php?nokp=<?php echo $nokp_sanitized; ?>"><b>Tukar kata laluan staff</b></a></td></tr>
        <?php } ?>
        
        </table>

</td>