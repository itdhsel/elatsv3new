<?php  
// Only start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('privcheck.php');  //check session n permission to access

if($_SESSION['level'] > 0) {
    include('files/db.php');

    $nokp = $_GET['nokp'] ?? '';

?>
<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 

<td valign=top bgcolor="#f1e6e5">
<table width="100%">
<tr>
<td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">MAKLUMAT TERPERINCI STATISTIK DAFTAR LATIHAN</div></td>
</tr>
</table>

<center><BR>
<?php 

$datasection = $_GET['data'] ?? '';
$year_today = date("Y");

if ($datasection == 1) {
    $jabatan1 = urldecode($_GET['jabatan'] ?? '');
    
    echo "Senarai kakitangan dari <b>". htmlspecialchars($jabatan1) ."</b> yang menghadiri kursus lebih 7 hari sehingga ".date('d-m-Y h:i:s A')."<p>";

    $strSQL = "SELECT *, p.nokp, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
               FROM peribadi p, infokursus i 
               WHERE p.nokp = i.nokp AND p.jabatan = ? AND p.status = 'AKTIF' AND i.year = ? AND i.day >= 7";
    
    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        $stmt->bind_param("ss", $jabatan1, $year_today);
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="950">
<tr><th>Bil</th><th>Nama pegawai</th><th>No KP</th><th>Jawatan</th><th>Gred</th><th>Bil hari kursus dihadiri</th></tr>
<?php 
    if ($Num_Rows == 0) {
        echo "<tr bgcolor='ffffff'><td colspan='6' align='center'>Tiada rekod ditemui.</td></tr>";
    }
        
    $i = 1;
    while($capture2 = $objQuery->fetch_assoc()) {
        $ordernum = $i++;
        echo "<tr bgcolor='#ffffff'><td>".$ordernum."</td><td align='left'><a href='search_display.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['namapegawai']) . "</a></td><td align='center'>".htmlspecialchars($capture2['nokp'])."</td><td align='center'>".htmlspecialchars($capture2['skim_khidmat'] ?? '')."</td><td align='center'>".htmlspecialchars($capture2['gredhakiki'] ?? '')."</td><td align='center'><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['day']) . "</a></td></tr>";	
    }
    $stmt->close();
?>
</table>
<?php
    }
}

if ($datasection == 2) {
    $jabatan1 = urldecode($_GET['jabatan'] ?? '');
    
    echo "Senarai kakitangan dari <b>". htmlspecialchars($jabatan1) ."</b> yang menghadiri kursus kurang dari 7 hari sehingga ".date('d-m-Y h:i:s A')."<p>";

    $strSQL = "SELECT *, p.nokp, i.nokp, i.year, i.bil, i.bilsah, i.day, i.hour, i.borgperlu, i.borgkembali 
               FROM peribadi p, infokursus i 
               WHERE p.nokp = i.nokp AND p.jabatan = ? AND p.status = 'AKTIF' AND i.year = ? AND i.day < 7";
    
    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        $stmt->bind_param("ss", $jabatan1, $year_today);
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="950">
<tr><th>Bil</th><th>Nama pegawai</th><th>No KP</th><th>Jawatan</th><th>Gred</th><th>Bil hari kursus dihadiri</th></tr>
<?php 
    if ($Num_Rows == 0) {
        echo "<tr bgcolor='ffffff'><td colspan='6' align='center'>Tiada rekod ditemui.</td></tr>";
    }
        
    $i = 1;
    while($capture2 = $objQuery->fetch_assoc()) {
        $ordernum = $i++;
        echo "<tr bgcolor='#ffffff'><td>".$ordernum."</td><td align='left'><a href='search_display.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['namapegawai']) . "</a></td><td align='center'>".htmlspecialchars($capture2['nokp'])."</td><td align='center'>".htmlspecialchars($capture2['skim_khidmat'] ?? '')."</td><td align='center'>".htmlspecialchars($capture2['gredhakiki'] ?? '')."</td><td align='center'><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['day']) . "</a></td></tr>";	
    }
    $stmt->close();
?>
</table>
<?php
    }
}

if ($datasection == 3) {
    $jabatan1 = urldecode($_GET['jabatan'] ?? '');
    
    echo "Senarai kakitangan dari <b>". htmlspecialchars($jabatan1) ."</b> dengan maklumat bilangan kursus yang dihadiri sehingga ".date('d-m-Y h:i:s A')."<p>";

    $strSQL = "SELECT * FROM peribadi p, infokursus i 
               WHERE p.nokp = i.nokp AND p.jabatan = ? AND p.status = 'AKTIF' AND i.year = ?";
    
    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        $stmt->bind_param("ss", $jabatan1, $year_today);
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="950">
<tr><th>Bil</th><th>Nama pegawai</th><th>No KP</th><th>Jawatan</th><th>Gred</th><th>Bil hari kursus dihadiri</th></tr>
<?php 
    if ($Num_Rows == 0) {
        echo "<tr bgcolor='ffffff'><td colspan='6' align='center'>Tiada rekod ditemui.</td></tr>";
    }
        
    $i = 1;
    while($capture2 = $objQuery->fetch_assoc()) {
        $bgkaler = ($capture2['day'] >= 7) ? "bgcolor='#99FF99'" : "";
        $ordernum = $i++;
        echo "<tr bgcolor='#ffffff'><td>".$ordernum."</td><td align='left'><a href='search_display.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['namapegawai']) . "</a></td><td align='center'>".htmlspecialchars($capture2['nokp'])."</td><td align='center'>".htmlspecialchars($capture2['skim_khidmat'] ?? '')."</td><td align='center'>".htmlspecialchars($capture2['gredhakiki'] ?? '')."</td><td align='center' $bgkaler><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['day']) . "</a></td></tr>";	
    }
    $stmt->close();
?>
</table>
<?php
    }
}

if ($datasection == 4) {
    $kumpulan = $_GET['k'] ?? '';
    $days = $_GET['d'] ?? '';
    
    if ($days == '8') {
        $strSQL = "SELECT * FROM peribadi p, infokursus i 
                   WHERE p.nokp = i.nokp AND i.year = ? AND i.day > 7 AND p.kumpulan = ? AND p.status = 'AKTIF'";
    } else {
        $strSQL = "SELECT * FROM peribadi p, infokursus i 
                   WHERE p.nokp = i.nokp AND i.year = ? AND i.day = ? AND p.kumpulan = ? AND p.status = 'AKTIF'";
    }

    echo "Senarai kakitangan kumpulan ".htmlspecialchars($kumpulan)." dengan maklumat bilangan kursus yang dihadiri sehingga ".date('d-m-Y h:i:s A')."<p>";

    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        if ($days == '8') {
            $stmt->bind_param("ss", $year_today, $kumpulan);
        } else {
            $stmt->bind_param("sss", $year_today, $days, $kumpulan);
        }
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="950">
<tr><th>Bil</th><th>Nama pegawai</th><th>No KP</th><th>Jawatan</th><th>Gred</th><th>Bil hari kursus dihadiri</th><th>MYCPD Actual</th></tr>
<?php 
    if ($Num_Rows == 0) {
        echo "<tr bgcolor='ffffff'><td colspan='7' align='center'>Tiada rekod ditemui.</td></tr>";
    }
        
    $i = 1;
    while($capture2 = $objQuery->fetch_assoc()) {
        $bgkaler = ($capture2['day'] >= 7) ? "bgcolor='#99FF99'" : "";
        $ordernum = $i++;
        echo "<tr bgcolor='#ffffff'><td>".$ordernum."</td><td align='left'><a href='search_display.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['namapegawai']) . "</a></td><td align='center'>".htmlspecialchars($capture2['nokp'])."</td><td align='center'>".htmlspecialchars($capture2['skim_khidmat'] ?? '')."</td><td align='center'>".htmlspecialchars($capture2['gredhakiki'] ?? '')."</td><td align='center' $bgkaler><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['day']) . "</a></td><td align=center>".htmlspecialchars($capture2['mycpda'] ?? '')."</td></tr>";	
    }
    $stmt->close();
?>
</table>
<?php
    }
}

if ($datasection == 5) {
    $strSQL = "SELECT * FROM peribadi p, infokursus i 
               WHERE p.nokp = i.nokp AND i.year = ? AND i.mycpda > 39 AND i.day < 7 AND p.status = 'AKTIF' 
               ORDER BY p.namapegawai ASC";

    echo "Senarai kakitangan yang maklumat hari kursus kurang dari 7 hari dan mata MyCPD bersamaan 40 atau lebih sehingga 03-10-2015<p>MYCPDC = Cumulative Points, MYCPDA = Actual Points";

    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        $stmt->bind_param("s", $year_today);
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="950">
<tr><th>Bil</th><th>Nama pegawai</th><th>No KP</th><th>Jawatan</th><th>Gred</th><th>Hari Kursus eLATS</th><th>MCPDC</th><th>MYCPDA</th></tr>
<?php 
    if ($Num_Rows == 0) {
        echo "<tr bgcolor='ffffff'><td colspan='8' align='center'>Tiada rekod ditemui.</td></tr>";
    }
        
    $i = 1;
    while($capture2 = $objQuery->fetch_assoc()) {
        $bgkaler = ($capture2['mycpda'] >= 40) ? "bgcolor='#99FF99'" : "";
        $bgkaler1 = ($capture2['day'] >= 7) ? "bgcolor='#99FF99'" : "";
        $ordernum = $i++;
        echo "<tr bgcolor='#ffffff'><td>".$ordernum."</td><td align='left'><a href='search_display.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['namapegawai']) . "</a></td><td align='center'>".htmlspecialchars($capture2['nokp'])."</td><td align='center'>".htmlspecialchars($capture2['skim_khidmat'] ?? '')."</td><td align='center'>".htmlspecialchars($capture2['gredhakiki'] ?? '')."</td><td align='center' $bgkaler1><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['day']) . "</a></td><td align='center' $bgkaler><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['mycpdc'] ?? '') . "</a></td><td align='center' $bgkaler><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['mycpda'] ?? '') . "</a></td></tr>";	
    }
    $stmt->close();
?>
</table>
<?php
    }
}

if ($datasection == 6) {
    $strSQL = "SELECT * FROM peribadi p, infokursus i 
               WHERE p.nokp = i.nokp AND i.year = ? AND i.mycpda >= 40 AND p.status = 'AKTIF' 
               ORDER BY p.namapegawai ASC";

    echo "Senarai kakitangan yang maklumat mata MyCPD bersamaan 40 atau lebih sehingga 03-10-2015<p>MYCPDC = Cumulative Points, MYCPDA = Actual Points";

    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        $stmt->bind_param("s", $year_today);
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="950">
<tr><th>Bil</th><th>Nama pegawai</th><th>No KP</th><th>Jawatan</th><th>Gred</th><th>Hari Kursus eLATS</th><th>MCPDC</th><th>MYCPDA</th></tr>
<?php 
    if ($Num_Rows == 0) {
        echo "<tr bgcolor='ffffff'><td colspan='8' align='center'>Tiada rekod ditemui.</td></tr>";
    }
        
    $i = 1;
    while($capture2 = $objQuery->fetch_assoc()) {
        $bgkaler = ($capture2['mycpda'] >= 40) ? "bgcolor='#99FF99'" : "";
        $bgkaler1 = ($capture2['day'] >= 7) ? "bgcolor='#99FF99'" : "";
        $ordernum = $i++;
        echo "<tr bgcolor='#ffffff'><td>".$ordernum."</td><td align='left'><a href='search_display.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['namapegawai']) . "</a></td><td align='center'>".htmlspecialchars($capture2['nokp'])."</td><td align='center'>".htmlspecialchars($capture2['skim_khidmat'] ?? '')."</td><td align='center'>".htmlspecialchars($capture2['gredhakiki'] ?? '')."</td><td align='center' $bgkaler1><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['day']) . "</a></td><td align='center' $bgkaler><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['mycpdc'] ?? '') . "</a></td><td align='center' $bgkaler><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['mycpda'] ?? '') . "</a></td></tr>";	
    }
    $stmt->close();
?>
</table>
<?php
    }
}

if ($datasection == 7) {
    $jabataninfo = $_GET['jabatan'] ?? '';

    $strSQL = "SELECT * FROM members WHERE level = 3 AND jabatan = ?";
    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        $stmt->bind_param("s", $jabataninfo);
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;

        if ($Num_Rows == 0) {
            echo "<br>Tiada wakil jabatan yang telah dilantik untuk ".htmlspecialchars($jabataninfo).".<br>";
        } else {
            echo "<br>Wakil jabatan yang dilantik untuk ".htmlspecialchars($jabataninfo)." ialah: <br>";
        }

        while($capture2 = $objQuery->fetch_assoc()) {
            echo "<br><b>".htmlspecialchars($capture2["name"] ?? '') ." - ". htmlspecialchars($capture2["email"] ?? '') ."</b><br>";
        }
        $stmt->close();
    }
?>
<br>
Senarai kursus baru yang didaftarkan oleh kakitangan jabatan/unit yang masih belum disahkan:<br><br>
<center>
<?php 
    $strSQL = "SELECT * FROM peribadi, kursus 
               WHERE peribadi.nokp = kursus.nokp2 AND kursus.valid = 0 AND peribadi.status = 'AKTIF' AND peribadi.jabatan = ?";
    
    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        $stmt->bind_param("s", $jabataninfo);
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;

        $Per_Page = 35;   // Per Page
        $Page = $_GET["Page"] ?? 1;
        $Prev_Page = $Page - 1;
        $Next_Page = $Page + 1;
        $Page_Start = (($Per_Page * $Page) - $Per_Page);
        
        if($Num_Rows <= $Per_Page) {
            $Num_Pages = 1;
        } else if(($Num_Rows % $Per_Page) == 0) {
            $Num_Pages = ($Num_Rows / $Per_Page);
        } else {
            $Num_Pages = ($Num_Rows / $Per_Page) + 1;
            $Num_Pages = (int)$Num_Pages;
        }

        // Get paginated results
        $strSQL_paged = "SELECT * FROM peribadi, kursus 
                        WHERE peribadi.nokp = kursus.nokp2 AND kursus.valid = 0 AND peribadi.status = 'AKTIF' AND peribadi.jabatan = ? 
                        ORDER BY kursus.id DESC LIMIT ?, ?";
        
        $stmt_paged = $conn->prepare($strSQL_paged);
        if ($stmt_paged) {
            $stmt_paged->bind_param("sii", $jabataninfo, $Page_Start, $Per_Page);
            $stmt_paged->execute();
            $objQuery_paged = $stmt_paged->get_result();
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="950">
<tr><th>Bil</th><th>Nama pegawai</th><th>Nama kursus</th><th>Ambil tindakan</th></tr>
<?php 
    if ($Num_Rows == 0) {
        echo "<tr bgcolor='ffffff'><td colspan='4' align='center'>Tiada rekod ditemui.</td></tr>";
    }
        
    $i = 1;
    while($capture2 = $objQuery_paged->fetch_assoc()) {
        if ($Page != 1) {
            $ordernum = (($Page - 1) * $Per_Page) + $i;
            $i++;
        } else {
            $ordernum = $i++;
        }

        echo "<tr bgcolor='#ffffff'><td>".$ordernum."</td><td align='left'>". htmlspecialchars($capture2['namapegawai']) . "</td><td align='left'>". htmlspecialchars($capture2['nama_kursus']) . " </td><td align=center>[<a href='staff_kursus_detail.php?nokp=". htmlspecialchars($capture2['nokp']) . "&id=". htmlspecialchars($capture2['id']) . "&nama_kursus=".htmlspecialchars($capture2['nama_kursus'])."&highlight=1'>Kemaskini</a>]</td></tr>";	
    }
    $stmt_paged->close();
?>
</table>
<br>
 
<font face="Verdana, Arial, Helvetica, sans-serif" size="1">Sebanyak <span class="class19"><?php echo $Num_Rows;?></span> rekod ditemui dari pangkalan data </font> 
<font face="Verdana, Arial, Helvetica, sans-serif" size="1">: <span class="class19">Sejumlah <?php echo $Num_Pages;?> Muka Surat</span></font> <br>
<?php 
    if($Prev_Page) {
        echo " <a href='".htmlspecialchars($_SERVER['SCRIPT_NAME'])."?Page=$Prev_Page&data=7&jabatan=".urlencode($jabataninfo)."'><< Back</a> ";
    }

    for($i = 1; $i <= $Num_Pages; $i++) {
        if($i != $Page) {
            echo "[ <a href='".htmlspecialchars($_SERVER['SCRIPT_NAME'])."?Page=$i&data=7&jabatan=".urlencode($jabataninfo)."'>$i</a> ]";
        } else {
            echo "<b> $i </b>";
        }
    }
    
    if($Page != $Num_Pages) {
        echo " <a href='".htmlspecialchars($_SERVER['SCRIPT_NAME'])."?Page=$Next_Page&data=7&jabatan=".urlencode($jabataninfo)."'>Next>></a> ";
    }
        }
        $stmt->close();
    }
?>
</center>
<?php
}

if ($datasection == 8) {
    $status = $_GET['status'] ?? '';

    $strSQL = "SELECT * FROM peribadi p, infokursus i 
               WHERE p.nokp = i.nokp AND i.year = ? AND p.status = ?";

    echo "Senarai kakitangan berstatus <b>".htmlspecialchars($status)."</b> dengan maklumat bilangan kursus yang dihadiri sehingga ".date('d-m-Y h:i:s A')."<p>";

    $stmt = $conn->prepare($strSQL);
    if ($stmt) {
        $stmt->bind_param("ss", $year_today, $status);
        $stmt->execute();
        $objQuery = $stmt->get_result();
        $Num_Rows = $objQuery->num_rows;
?>
         
<table border=0 cellspacing="2" cellpadding="2" bgcolor="#f1988a" width="950">
<tr><th>Bil</th><th>Nama pegawai</th><th>No KP</th><th>Jawatan</th><th>Gred</th><th>Bil hari kursus dihadiri</th></tr>
<?php 
    if ($Num_Rows == 0) {
        echo "<tr bgcolor='ffffff'><td colspan='6' align='center'>Tiada rekod ditemui.</td></tr>";
    }
        
    $i = 1;
    while($capture2 = $objQuery->fetch_assoc()) {
        $bgkaler = ($capture2['day'] >= 7) ? "bgcolor='#99FF99'" : "";
        $ordernum = $i++;
        echo "<tr bgcolor='#ffffff'><td>".$ordernum."</td><td align='left'><a href='search_display.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['namapegawai']) . "</a></td><td align='center'>".htmlspecialchars($capture2['nokp'])."</td><td align='center'>".htmlspecialchars($capture2['skim_khidmat'] ?? '')."</td><td align='center'>".htmlspecialchars($capture2['gredhakiki'] ?? '')."</td><td align='center' $bgkaler><a href='staff_kursus.php?nokp=".htmlspecialchars($capture2['nokp'])."'>". htmlspecialchars($capture2['day']) . "</a></td></tr>";	
    }
    $stmt->close();
?>
</table>
<?php
    }
}
?>

<?php if ($datasection != 7) { ?>
<br>
<b>Arahan:</b> Sila klik pada nama pegawai untuk maklumat peribadi kakitangan atau klik pada bil hari kursus untuk maklumat terperinci kursus yang dihadiri.
<?php } ?>

</center>

<br><br>
</td> </tr>
<!-- end page display -->
<?php include('footer.php'); ?> 

<?php 
} else {
?>
<script language="javascript" type="text/javascript">
alert('Hanya Pengguna Berdaftar Dibenarkan Mengguna