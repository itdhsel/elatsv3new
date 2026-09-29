<?php 

session_start();
include('privcheck.php');

if(($_SESSION['level'] ?? 0) > 0)
{

include('files/db.php');

// Safely get nokp with validation
$nokp = $_GET['nokp'] ?? '';

?>
<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 

<td valign=top bgcolor="#f1e6e5" width="1000">

<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">

<tr><td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">FUNGSI MENUKAR KATA LALUAN KAKITANGAN</div></td></tr>

<tr><td>

<h5>Menukar kata laluan Kakitangan (KP: <?php echo htmlspecialchars($nokp);?>)</h5>

<?php   
// Use prepared statement for security
$queryname = "SELECT * FROM peribadi WHERE nokp = ?";
$stmt = $conn->prepare($queryname);
if ($stmt) {
    $stmt->bind_param("s", $nokp);
    $stmt->execute();
    $resultname = $stmt->get_result();
    $capturename = $resultname->fetch_assoc();
    $staffpwd = $capturename["pwd"] ?? '';
    $stmt->close();
} else {
    $staffpwd = '';
    echo "<font color='red'><b>Error: Cannot retrieve staff data</b></font>";
}
                     
if (($_POST['change'] ?? '') == "1") {
    //echo "Entering change password function <br>";
    $oldpwd = $_POST['oldpwd'] ?? '';
    $newpwd = $_POST['newpwd'] ?? '';
    $newpwd2 = $_POST['newpwd2'] ?? '';
    
    if ($oldpwd == $staffpwd) {
        echo "Old password verified <br> ";
        
        if ($newpwd == $newpwd2) {
            echo " New password combination matched <br> " ;
            
            // Use prepared statement for update
            $updateQuery = "UPDATE peribadi SET pwd = ? WHERE nokp = ?";
            $stmt = $conn->prepare($updateQuery);
            if ($stmt) {
                $stmt->bind_param("ss", $newpwd, $nokp);
                if ($stmt->execute()) {
                    echo "<font color=red><b>Kata laluan baru telah diaktifkan!!</b></font>";
                } else {
                    echo "<font color='red'><b>Error: Cannot update password</b></font>";
                }
                $stmt->close();
            } else {
                echo "<font color='red'><b>Error: Database update failed</b></font>";
            }
        } else { 
            echo "<font color='red'><b>Kata laluan baru tidak sepadan. Sila masuk semula</b></font>"; 
        }

    } else { 
        echo "<font color='red'><b>Kata laluan lama tidak tepat, sila masuk semula.</b></font>"; 
    }
}
?>

<form action="chpswd.php?nokp=<?php echo htmlspecialchars($nokp); ?>" method="post">
<table>
<tr><td>Kata laluan lama:</td><td><input type="password" name="oldpwd" size="30" <?php  if (($_SESSION['level'] ?? 0) > 1) { echo "disabled"; } ?> ></td></tr>
<tr><td>Kata laluan baru:</td><td><input type="password" name="newpwd" size="30"></td></tr>
<tr><td>Kata laluan baru (diulang pengesahan):</td><td><input type="password" size="30" name="newpwd2"></td></tr>
<tr><td colspan="2"><br><input type="reset" value="Kosongkan"> <input type="submit" value="Tukar kata laluan"></td></tr>
</table>
<input type="hidden" name="change" value="1">
</form>

</td></tr>
</table>

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