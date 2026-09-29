<?php
// --- securing include file ---
if (!isset($ping) || $ping != "pong") {
     exit('<h2>You cannot access this file directly!</h2>');
}
// --- end securing include file --
?>
<?php
// Check if session variables exist
if (!isset($_SESSION['staffkp'])) {
    die("Session staffkp not set");
}

$nokp = $_SESSION['staffkp'];

// Use prepared statement to prevent SQL injection
$queryname = "SELECT namapegawai, nokp FROM peribadi WHERE nokp = ?";
$stmt = mysqli_prepare($conn, $queryname);
mysqli_stmt_bind_param($stmt, "s", $nokp);
mysqli_stmt_execute($stmt);
$resultname = mysqli_stmt_get_result($stmt);
$foundname = mysqli_num_rows($resultname);

if ($foundname > 0) {
    $capturename = mysqli_fetch_array($resultname);
    $namastaff = $capturename["namapegawai"];
} else {
    $namastaff = "User Not Found";
}
?>

<!-- start page display -->
<td align="left" valign="top" width="180" bgcolor="#CDB79E">
     <!-- start left column --> 

      <table border="0" align="center" cellpadding="4" cellspacing="4" width="90%" bordercolor="white">
      
      <!-- start left menu -->
      
        
        <tr><td bgcolor="#8B8378" align="center" background='images/titlebox.png'><b>:: Menu Utama :: </b></td></tr>
        <?php if($_SESSION['level'] > 3){ ?>        
        <tr><td background='images/textbox.png' align="left"><b><a href="../ekesl/index.php">Akses Sistem e-Kesl</a></b></td></tr>          
        <?php } ?>        
        <tr><td background='images/textbox.png' align="left"><b><a href="mydashboard.php">Rumusan Info Latihan</a></b></td></tr>                
        <?php if($_SESSION['level'] > 2){ ?>
        <tr><td background='images/textbox.png'><b><a href="adminportal.php">Semak Daftar Latihan <?php if (isset($_SESSION['belumsah']) && $_SESSION['belumsah'] == 1) { ?><img src="new.gif" height="10%" width="10%"><?php } ?></a></b></td></tr>
        <?php } ?>
        
        <?php if($_SESSION['level'] > 1){ ?>
        <tr><td background='images/textbox.png'><b><a href="home.php">Paparan Kakitangan</a></b></td></tr>
        <tr><td background='images/textbox.png'><b><a href="search.php">- Carian Pegawai</a></b></td></tr>
        <?php } ?>     
        
        <?php if($_SESSION['level'] > 3){ ?>        
        <tr><td background='images/textbox.png'><b><a href="register_staff.php" class="style25">- Daftar Pegawai Baru</a></b></td></tr>
        <?php } ?>    

        <?php if($_SESSION['level'] == 5){ ?>
        <tr><td background='images/textbox.png'><b><a href="admin.php">Selenggara Pentadbir</a></b></td></tr>
        <tr><td background='images/textbox.png'><b><a href="editor.php">Editor Data Utama</a></b></td></tr>      
        <tr><td background='images/textbox.png'><b><a href="checkauditlog.php">Semak Audit Log</a></b></td></tr>
        <tr><td background='images/textbox.png'><b><a href="adminenginemenu.php">Fungsi Backend</a></b></td></tr>        
        <?php } ?>        
               
        <?php if($_SESSION['level'] > 3){ ?>
        <tr><td background='images/textbox.png'><b><a href="report_new.php">Modul Laporan</a></b></td></tr>
        <?php } ?>
        
        <?php if($_SESSION['level'] == 1){ ?>        
        <tr><td background='images/textbox.png'><b><a href="chpswd.php?nokp=<?php echo htmlspecialchars($nokp); ?>">Tukar kata laluan</a></b></td></tr>
        <?php } else { ?>
        <tr><td background='images/textbox.png'><b><a href="admin_reset_password.php?user_id=<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>">Tukar kata laluan</a></b></td></tr>        
        <?php } ?>

        <tr><td background='images/textbox.png'><b><a href="logout.php">Log Keluar</a></b></td></tr>
        
      </table>
      
<!-- end left menu -->     
</td>