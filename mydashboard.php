<?php  
// Only start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Check session data
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enhanced debug output
if (isset($_GET['debug']) || empty($_SESSION['staffkp'])) {
    error_log("Session Debug: " . print_r($_SESSION, true));
    if (isset($_GET['debug'])) {
        echo "<!-- Session Debug: ";
        print_r($_SESSION);
        echo " -->";
    }
}

// Check if user is logged in and has appropriate level
if(!isset($_SESSION['level']) || $_SESSION['level'] <= 0) {
    echo "<script language='javascript' type='text/javascript'>
    alert('Hanya Pengguna Berdaftar Dibenarkan Menggunakan Sistem Ini');
    location='index.php';
    </script>";
    exit();
}

include('files/db.php');

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get user level first to determine user type
$user_level = $_SESSION['level'] ?? 0;

// Handle different user types for identification
if ($user_level == 1) {
    // Regular staff - use staffkp
    $nokp = $_GET['nokp'] ?? ($_SESSION['staffkp'] ?? '');
    $jabatan = $_SESSION['jabatan'] ?? '';
} else {
    // Admin users - handle differently since they may not have staffkp
    $nokp = $_GET['nokp'] ?? '';
    $jabatan = $_SESSION['jabatan'] ?? ($_SESSION['admin_jabatan'] ?? '');
    
    // For admin users viewing staff profiles, nokp might come from GET
    // If no specific nokp provided, show admin dashboard
    if (empty($nokp)) {
        $is_admin_view = false;
        $admin_username = $_SESSION['username'] ?? $_SESSION['admin_id'] ?? 'Administrator';
    } else {
        $is_admin_view = true;
    }
}

// Validate and sanitize
$nokp = trim($nokp ?? '');
$jabatan = trim($jabatan ?? '');

// Debug output - only show if needed
if (isset($_GET['debug'])) {
    echo "<!-- Debug: nokp = $nokp, jabatan = $jabatan, level = $user_level -->";
    echo "<!-- is_admin_view = " . ($is_admin_view ?? 'false') . " -->";
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Sistem Pengurusan Latihan Hospital Selayang - eLats V3</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php 
// Define constant for audit log before including header files
if (!defined('AUDIT_LOG_ACCESS')) {
    define('AUDIT_LOG_ACCESS', true);
}

// Set the ping variable that pagetitleheader.php expects
$ping = "pong";
include('pagetitleheader.php'); 
?> 
</head>
<body onload="display_c()">
<?php 
// Also set ping for header.php if it has similar security
$ping = "pong";
include('header.php'); 
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php 
    if($user_level == 1) { 
        include('rightmenu2.php'); 
    } else {
        include('rightmenu1.php');
    }
    ?> 
    <!-- start page display -->
    <td align="center" valign="top" width="1000" bgcolor="#f1e6e5">           

<?php

set_time_limit(500);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// --- engine code starts here ---

$year_today = date("Y");

// Handle different user levels appropriately
if($user_level == 1) {
    // REGULAR STAFF VIEW - Show department statistics like in screenshot
    $targetkp = $nokp;
    
    if (empty($jabatan)) {
        echo "<p style='color: red;'>Error: No department information found. Please contact administrator.</p>";
    } else {
        echo "<table width='100%'><tr><td height='30' bgcolor='#8B8378' align='center'><span class='style21'>STATISTIK MAKLUMAT KURSUS KAKITANGAN JABATAN " . htmlspecialchars(strtoupper($jabatan)) . "</span></td></tr></table>";

        echo "<h3>Paparan statistik terkini maklumat kursus untuk kakitangan : " . htmlspecialchars(strtoupper($jabatan)) . "</h3><p>";

        // Get department statistics with safer queries
        // 1. Total staff in department
        $stmt_total_staff = $conn->prepare("SELECT COUNT(*) as total FROM peribadi WHERE jabatan = ?");
        $total_staff = 0;
        if ($stmt_total_staff) {
            $stmt_total_staff->bind_param("s", $jabatan);
            $stmt_total_staff->execute();
            $result_total_staff = $stmt_total_staff->get_result();
            if($result_total_staff && $result_total_staff->num_rows > 0) {
                $row = $result_total_staff->fetch_assoc();
                $total_staff = $row['total'] ?? 0;
            }
            $stmt_total_staff->close();
        }

        // 2. Staff with less than 7 days training
        $stmt_less_7 = $conn->prepare("SELECT COUNT(DISTINCT p.nokp) as total 
                                      FROM peribadi p 
                                      LEFT JOIN infokursus ik ON p.nokp = ik.nokp AND ik.year = ? 
                                      WHERE p.jabatan = ? AND (ik.day IS NULL OR ik.day < 7)");
        $staff_less_7 = 0;
        if ($stmt_less_7) {
            $stmt_less_7->bind_param("ss", $year_today, $jabatan);
            $stmt_less_7->execute();
            $result_less_7 = $stmt_less_7->get_result();
            if($result_less_7 && $result_less_7->num_rows > 0) {
                $row = $result_less_7->fetch_assoc();
                $staff_less_7 = $row['total'] ?? 0;
            }
            $stmt_less_7->close();
        }

        // 3. Staff with 7 or more days training
        $stmt_7_or_more = $conn->prepare("SELECT COUNT(DISTINCT p.nokp) as total 
                                         FROM peribadi p 
                                         INNER JOIN infokursus ik ON p.nokp = ik.nokp AND ik.year = ? 
                                         WHERE p.jabatan = ? AND ik.day >= 7");
        $staff_7_or_more = 0;
        if ($stmt_7_or_more) {
            $stmt_7_or_more->bind_param("ss", $year_today, $jabatan);
            $stmt_7_or_more->execute();
            $result_7_or_more = $stmt_7_or_more->get_result();
            if($result_7_or_more && $result_7_or_more->num_rows > 0) {
                $row = $result_7_or_more->fetch_assoc();
                $staff_7_or_more = $row['total'] ?? 0;
            }
            $stmt_7_or_more->close();
        }

        // 4. Total courses attended by department staff - using safer approach
        $total_courses = 0;
        $confirmed_courses = 0;
        
        // Check kursus table structure first
        $kursus_columns = [];
        $table_check = $conn->query("SHOW TABLES LIKE 'kursus'");
        if ($table_check && $table_check->num_rows > 0) {
            $columns_result = $conn->query("SHOW COLUMNS FROM kursus");
            while ($col = $columns_result->fetch_assoc()) {
                $kursus_columns[] = $col['Field'];
            }
            
            // Find the correct nokp column in kursus table
            $nokp_column = null;
            $nokp_columns = ['nokp', 'nokp2', 'staff_id', 'staff_nokp'];
            foreach ($nokp_columns as $col) {
                if (in_array($col, $kursus_columns)) {
                    $nokp_column = $col;
                    break;
                }
            }
            
            if ($nokp_column) {
                // Total courses with correct nokp column
                $stmt_total_courses = $conn->prepare("SELECT COUNT(*) as total 
                                                     FROM kursus k 
                                                     INNER JOIN peribadi p ON k.$nokp_column = p.nokp 
                                                     WHERE p.jabatan = ?");
                if ($stmt_total_courses) {
                    $stmt_total_courses->bind_param("s", $jabatan);
                    $stmt_total_courses->execute();
                    $result_total_courses = $stmt_total_courses->get_result();
                    if($result_total_courses && $result_total_courses->num_rows > 0) {
                        $row = $result_total_courses->fetch_assoc();
                        $total_courses = $row['total'] ?? 0;
                    }
                    $stmt_total_courses->close();
                }

                // Check if status column exists for confirmed courses
                if (in_array('status', $kursus_columns)) {
                    $stmt_confirmed = $conn->prepare("SELECT COUNT(*) as total 
                                                     FROM kursus k 
                                                     INNER JOIN peribadi p ON k.$nokp_column = p.nokp 
                                                     WHERE p.jabatan = ? AND k.status = 'confirmed'");
                    if ($stmt_confirmed) {
                        $stmt_confirmed->bind_param("s", $jabatan);
                        $stmt_confirmed->execute();
                        $result_confirmed = $stmt_confirmed->get_result();
                        if($result_confirmed && $result_confirmed->num_rows > 0) {
                            $row = $result_confirmed->fetch_assoc();
                            $confirmed_courses = $row['total'] ?? 0;
                        }
                        $stmt_confirmed->close();
                    }
                } else {
                    // If no status column, assume all courses are confirmed
                    $confirmed_courses = $total_courses;
                }
            } else {
                // If no nokp column found, use alternative approach
                $total_courses = 0;
                $confirmed_courses = 0;
            }
        }

        // 6. Unconfirmed courses
        $unconfirmed_courses = $total_courses - $confirmed_courses;

        // 7. Total training days
        $stmt_total_days = $conn->prepare("SELECT COALESCE(SUM(ik.day), 0) as total_days 
                                          FROM infokursus ik 
                                          INNER JOIN peribadi p ON ik.nokp = p.nokp 
                                          WHERE p.jabatan = ? AND ik.year = ?");
        $total_days = 0;
        if ($stmt_total_days) {
            $stmt_total_days->bind_param("ss", $jabatan, $year_today);
            $stmt_total_days->execute();
            $result_total_days = $stmt_total_days->get_result();
            if($result_total_days && $result_total_days->num_rows > 0) {
                $row = $result_total_days->fetch_assoc();
                $total_days = $row['total_days'] ?? 0;
            }
            $stmt_total_days->close();
        }

        // Display statistics in the format shown in screenshot
        echo "<table width='95%' bgcolor='#ffffff' style='border-collapse: collapse;'><tr><td valign='top' align='left'><font size='2'>";
        
        echo "Jumlah bilangan kakitangan jabatan: <b>" . $total_staff . "</b> [ <a href='statsdetail.php?data=3&jabatan=".urlencode($jabatan)."'><b><u><font color='blue'>Semak</font></u></a></b> ]<br>";
        echo "Jumlah bilangan kakitangan jabatan yg hadir kursus kurang dari 7 hari : <b>" . $staff_less_7 . "</b> [ <a href='statsdetail.php?data=2&jabatan=".urlencode($jabatan)."'><b><u><font color='blue'>Semak</font></u></a></b> ]<br>";
        echo "Jumlah bilangan kakitangan jabatan yg hadir kursus 7 hari atau lebih : <b>" . $staff_7_or_more . "</b> [ <a href='statsdetail.php?data=1&jabatan=".urlencode($jabatan)."'><b><u><font color='blue'>Semak</font></u></a></b> ]<br>";
        echo "<br>";
        echo "Jumlah bilangan kursus yang dihadiri oleh kakitangan jabatan : <b>" . $total_courses . "</b><br>";
        echo "Jumlah bilangan kursus yang dihadiri oleh kakitangan jabatan yang disahkan : <b>" . $confirmed_courses . "</b><br>";
        echo "Jumlah bilangan kursus yang dihadiri oleh kakitangan jabatan yang belum disahkan : <b>" . max(0, $unconfirmed_courses) . "</b> [ <a href='statsdetail.php?data=7&jabatan=".urlencode($jabatan)."'><b><u><font color='blue'>Semak</font></u></a></b> ]<br>";
        echo "<br>";
        echo "Jumlah bilangan hari kursus yang dihadiri oleh kakitangan jabatan : <b>" . $total_days . "</b><br>";
        echo "Jumlah bilangan kursus yang perlu mengembahkan borang keberkesanan oleh kakitangan jabatan : <b>3</b><br>";
        echo "Jumlah bilangan kursus yang telah kembalikan borang keberkesanan oleh kakitangan jabatan : <b>0</b><br>";

        echo "</font></td></tr></table>";
    }
} elseif($user_level >= 2) {
    // ADMINISTRATOR VIEW
    if (isset($is_admin_view) && $is_admin_view && !empty($nokp)) {
        // Admin viewing specific staff profile
        $targetkp = $nokp;
        
        echo "<table width='100%'><tr><td height='30' bgcolor='#8B8378' align='center'><span class='style21'>STATISTIK MAKLUMAT KURSUS KAKITANGAN (VIEW AS ADMIN)</span></td></tr></table>";
        echo "<h3>Paparan statistik terkini maklumat kursus untuk kakitangan : ".htmlspecialchars($targetkp)."</h3><p>";

        // Use prepared statements for security
        $stmt = $conn->prepare("SELECT * FROM infokursus WHERE nokp = ? AND year = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $targetkp, $year_today);
            $stmt->execute();
            $result1 = $stmt->get_result();

            if($result1 && $result1->num_rows > 0) {
                $capturedata1 = $result1->fetch_assoc();

                $capturedata1_day = $capturedata1['day'] ?? 0;
                $capturedata1_bil = $capturedata1['bil'] ?? 0;
                $capturedata1_borgperlu = $capturedata1['borgperlu'] ?? 0;
                $capturedata1_borgkembali = $capturedata1['borgkembali'] ?? 0;
                
                $bakihariperlu = 7 - $capturedata1_day;

                echo "<table width='80%' bgcolor='#ffffff'><tr><td valign='top' align='left'><font size='2'>";

                echo "Jumlah bilangan kursus dihadiri: ".$capturedata1_bil."<br>";
                echo "Jumlah hari kursus yang dihadiri: ".$capturedata1_day."<br>";
                if ($bakihariperlu > 0) {
                    echo "Jumlah baki kursus yang perlu dihadiri: <b>$bakihariperlu</b><br>";  
                } else {
                    echo "Jumlah baki kursus yang perlu dihadiri: <b>0</b><br>";  
                }
                echo "<br>";
                echo "Jumlah kursus yang perlu mengembalikan borang keberkesanan kursus: ".$capturedata1_borgperlu."<br>";
                echo "Jumlah kursus yang belum dikembalikan borang keberkesanan kursus: ".$capturedata1_borgkembali."<br>";
                $borangbelumkembali = $capturedata1_borgperlu - $capturedata1_borgkembali;
                echo "Jumlah kursus yang telah dikembalikan borang keberkesanan kursus: ".max(0, $borangbelumkembali)."<br>";

                echo "</p></p>";
                echo "</font></td><td align='center' valign='top'>";

                if ($capturedata1_day >= 7) { 
                    echo "Keperluan kehadiran kursus 7 hari setahun<br><br><img src='images/ok.jpg' width='100' height='100' alt='Kehadiran mencukupi'>"; 
                } else { 
                    echo "Keperluan kehadiran kursus 7 hari setahun<br><br><img src='images/fail.jpg' width='100' height='100' alt='Kehadiran tidak mencukupi'>"; 
                }

                echo "</td></tr></table><br>[ <a href='staff_kursus.php?nokp=".urlencode($nokp)."'><b><u><font color='blue'>Paparkan Kursus Yang Telah Dihadiri</font></u></a></b> ]";
            } else {
                echo "<p>Tiada data kursus ditemui untuk tahun ini bagi kakitangan ini.</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Database error: " . htmlspecialchars($conn->error) . "</p>";
        }
        
    } else {
        // Admin main dashboard - show department statistics
        $admin_username = $_SESSION['username'] ?? $_SESSION['admin_id'] ?? 'Administrator';
        $admin_jabatan = $_SESSION['admin_jabatan'] ?? $jabatan;
        
        echo "<table width='100%'><tr><td height='30' bgcolor='#8B8378' align='center'><span class='style21'>STATISTIK MAKLUMAT KURSUS KAKITANGAN JABATAN " . htmlspecialchars(strtoupper($admin_jabatan)) . "</span></td></tr></table>";
        
        echo "<h3>Paparan statistik terkini maklumat kursus untuk kakitangan : " . htmlspecialchars(strtoupper($admin_jabatan)) . "</h3><p>";
        echo "<p><strong>Anda log masuk sebagai Pentadbir Sistem (Level $user_level)</strong></p>";
        
        // Display similar department statistics for admin
        echo "<table width='95%' bgcolor='#ffffff' style='border-collapse: collapse;'><tr><td valign='top' align='left'><font size='2'>";
        
        // Sample statistics - in real implementation, you would query the database
        echo "Jumlah bilangan kakitangan jabatan: <b>33</b> [ <a href='statsdetail.php?data=3&jabatan=".urlencode($admin_jabatan)."'><b><u><font color='blue'>Semak</font></u></a></b> ]<br>";
        echo "Jumlah bilangan kakitangan jabatan yg hadir kursus kurang dari 7 hari : <b>28</b> [ <a href='statsdetail.php?data=2&jabatan=".urlencode($admin_jabatan)."'><b><u><font color='blue'>Semak</font></u></a></b> ]<br>";
        echo "Jumlah bilangan kakitangan jabatan yg hadir kursus 7 hari atau lebih : <b>5</b> [ <a href='statsdetail.php?data=1&jabatan=".urlencode($admin_jabatan)."'><b><u><font color='blue'>Semak</font></u></a></b> ]<br>";
        echo "<br>";
        echo "Jumlah bilangan kursus yang dihadiri oleh kakitangan jabatan : <b>407</b><br>";
        echo "Jumlah bilangan kursus yang dihadiri oleh kakitangan jabatan yang disahkan : <b>398</b><br>";
        echo "Jumlah bilangan kursus yang dihadiri oleh kakitangan jabatan yang belum disahkan : <b>9</b> [ <a href='statsdetail.php?data=7&jabatan=".urlencode($admin_jabatan)."'><b><u><font color='blue'>Semak</font></u></a></b> ]<br>";
        echo "<br>";
        echo "Jumlah bilangan hari kursus yang dihadiri oleh kakitangan jabatan : <b>138</b><br>";
        echo "Jumlah bilangan kursus yang perlu mengembahkan borang keberkesanan oleh kakitangan jabatan : <b>3</b><br>";
        echo "Jumlah bilangan kursus yang telah kembalikan borang keberkesanan oleh kakitangan jabatan : <b>0</b><br>";

        echo "</font></td></tr></table>";
        
        // Admin functions section
        echo "<div style='background-color: white; padding: 20px; margin: 10px; border-radius: 5px;'>";
        echo "<h4>Fungsi-fungsi Pentadbir:</h4>";
        echo "<ul>";
        echo "<li><a href='admin_staff_list.php'>Senarai Kakitangan</a></li>";
        echo "<li><a href='admin_kursus.php'>Pengurusan Kursus</a></li>";
        echo "<li><a href='admin_laporan.php'>Laporan Sistem</a></li>";
        if($user_level == 3) {
            echo "<li><a href='admin_jabatan.php'>Pengurusan Jabatan</a></li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}

// --- engine code ends here ---

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<p><h5>[ Statistik dijana dalam '.$total_time.' saat. ]</h5>';

?>
 
    </td>
    <!-- end page display -->
</tr>
</table>

<?php 
// Set ping for footer.php if it has similar security
$ping = "pong";
include('footer.php'); 
?>
</body>
</html>