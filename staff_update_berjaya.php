<?php 

session_start();
include('privcheck.php');

if(($_SESSION['level'] ?? 0) > 0)
{

include('files/db.php');

// Safely get nokp with validation
$nokp = $_POST['nokp2'] ?? '';

// Use prepared statement for security
$query = "SELECT namapegawai, nokp, jantina, bangsa, skim_khidmat, gredhakiki, kumpulan, jabatan, status
            FROM peribadi 
            WHERE nokp = ?";

$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("s", $nokp);
    $stmt->execute();
    $result = $stmt->get_result();
    $found = $result->num_rows;
    $capture = $result->fetch_assoc();
    $stmt->close();
} else {
    // Handle error
    $found = 0;
    $capture = [];
    echo "Database error: " . htmlspecialchars($conn->error);
}

?>

<?php include('pagetitleheader.php'); ?> 

</head>

<?php include('header.php'); ?>

<?php include('rightmenu2.php'); ?> 

<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">

<p><span class="title">Kemaskini Maklumat Pegawai Berjaya </span></p> 
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB">
<tr>
<td>
<?php

if(isset($_POST['updatestaff']))
{ 
    include ('include/file_update_staff.php');
}
else
{
    echo "Tiada Sebarang Aktiviti Proses Sedang Berjalan";
}
?>

</td>
</tr>
</table>
          
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