<?php
session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION['level'] > 0) {
    include('files/db.php');
    
    // Initialize variables safely
    $action = $_GET['action'] ?? '';
    $jabatan_post = $_POST['jabatan'] ?? '';
    
    if ($action == 'reset') {
        $_SESSION['jabatan'] = "Sila Buat Pilihan Jabatan/Unit";
    }

    if (empty($jabatan_post)) {
        $jabataninfo = $_SESSION['jabatan'] ?? "Sila Buat Pilihan Jabatan/Unit";
    } else {
        $jabataninfo = $jabatan_post;
        $_SESSION['jabatan'] = $jabataninfo;
    }
?>
<!DOCTYPE html>
<html>
<head>
<?php include('pagetitleheader.php'); ?> 
</head>
<body>
<?php include('header.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">   
<table width="100%"><tr><td height="30" colspan="2" align="center" valign="middle" bgcolor="#8B8378"><div class="style21">PAPARAN KAKITANGAN HOSPITAL MENGIKUT JABATAN</div></td></tr></table>
<br>  
      <form action="home.php" method="post">
      <span class="title">Jabatan : </span>
      
      <select name='jabatan' id='jabatan' <?php if ($_SESSION['level'] == 3){echo "disabled";}?> >
      <option value='Sila Buat Pilihan Jabatan/Unit' <?php if ($jabataninfo == 'Sila Buat Pilihan Jabatan/Unit') { echo "selected"; } ?>>Sila Buat Pilihan Jabatan/Unit</option>
      <option value='all' <?php if ($jabataninfo == 'all') { echo "selected"; } ?>>--- SELURUH KAKITANGAN HOSPITAL ---</option>      
      <?php 
        $strSQL2 = "SELECT * FROM jabatan ORDER BY namajabatan"; 
        $objQuery2 = mysqli_query($conn, $strSQL2) or die ("Error Query [".$strSQL2."]");   
        while($capture2 = mysqli_fetch_array($objQuery2)) {   
            $selected = ($jabataninfo == $capture2["namajabatan"]) ? "selected" : "";
            $displayName = ($capture2["jabatan_type"] == 0) ? $capture2["namajabatan"] : "- ".$capture2["namajabatan"];
            echo "<option value='".htmlspecialchars($capture2["namajabatan"])."' $selected>".htmlspecialchars($displayName)."</option>";
        }
      ?>     
      </select>   
      <input type="submit" value="PILIH" <?php if ($_SESSION['level'] == 3){echo "disabled";}?>> 
      <input type="button" value="SET SEMULA" onClick="location.href='home.php?action=reset'" <?php if ($_SESSION['level'] == 3){echo "disabled";}?>><br>
      </form> <br>         

      <?php 
      $user_id = $_SESSION['user_id'] ?? '';
      $level = $_SESSION['level'] ?? 0;

      // Build SQL query safely
      if ($jabataninfo == "all") {
        $strSQL = "SELECT nokp, namapegawai, skim_khidmat, jabatan, status, gredhakiki FROM peribadi WHERE 1=1";
      } else {
        $strSQL = "SELECT nokp, namapegawai, skim_khidmat, jabatan, status, gredhakiki FROM peribadi WHERE jabatan='".mysqli_real_escape_string($conn, $jabataninfo)."'";
      }

      $j = $_GET["j"] ?? '';
      $s = $_GET["s"] ?? '';

      if (!empty($j) && $jabataninfo == "all") {
        $strSQL .= " AND skim_khidmat='".mysqli_real_escape_string($conn, $j)."'";
      }
      if (!empty($j) && $jabataninfo != "all") {
        $strSQL .= " AND skim_khidmat='".mysqli_real_escape_string($conn, $j)."'";
      }

      // Add ordering
      switch($s) {
        case 'ju':
            $strSQL .= " ORDER BY skim_khidmat ASC";
            break;
        case 'jd':
            $strSQL .= " ORDER BY skim_khidmat DESC";
            break;
        case 'gu':
            $strSQL .= " ORDER BY gredhakiki ASC";
            break;
        case 'gd':
            $strSQL .= " ORDER BY gredhakiki DESC";
            break;
        case 'nu':
            $strSQL .= " ORDER BY namapegawai ASC";
            break;
        case 'nd':
            $strSQL .= " ORDER BY namapegawai DESC";
            break;
        default:
            $strSQL .= " ORDER BY namapegawai ASC";
            break;
      }

      // Get total count for pagination
      $countQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
      $Num_Rows = mysqli_num_rows($countQuery);

      $Per_Page = 35;   // Per Page
      $Page = $_GET["Page"] ?? 1;
      $Page = (int)$Page;

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

      // Add limit for pagination
      $strSQL .= " LIMIT $Page_Start, $Per_Page";
      
      $objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");

      ?>
      <table width="95%" cellpadding="2" cellspacing="2" border="1" bgcolor="#f1988a">
      <tr><th align="center" valign="middle" colspan="6">SENARAI PEGAWAI</th></tr>
  
      <tr bgcolor="#FFFF00">
      <th width="6%" bgcolor="#CCCCCC"><div align="center">NO.</div></th>
      <th width="39%" align="center" bgcolor="#CCCCCC">
          <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?s=n">NAMA PEGAWAI</a><br>
          <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?s=nu&j=<?php echo urlencode($j ?? ''); ?>"><img src="images/arrowup.gif" border="0" height="10" width="30" alt="Sort Asc"></a>
          <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?s=nd&j=<?php echo urlencode($j ?? ''); ?>"><img src="images/arrowdown.gif" border="0" height="10" width="30" alt="Sort Desc"></a>
      </th>
      <th width="11%" align="center" valign="middle" bgcolor="#CCCCCC">GRED HAKIKI<br> 
          <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?s=gu&j=<?php echo urlencode($j ?? ''); ?>"><img src="images/arrowup.gif" border="0" height="10" width="30" alt="Sort Asc"></a>
          <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?s=gd&j=<?php echo urlencode($j ?? ''); ?>"><img src="images/arrowdown.gif" border="0" height="10" width="30" alt="Sort Desc"></a>
      </th>
      <th width="28%" align="center" valign="middle" bgcolor="#CCCCCC">
          <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?s=j">JAWATAN</a><br>
          <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?s=ju&j=<?php echo urlencode($j ?? ''); ?>"><img src="images/arrowup.gif" border="0" height="10" width="30" alt="Sort Asc"></a>
          <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?s=jd&j=<?php echo urlencode($j ?? ''); ?>"><img src="images/arrowdown.gif" border="0" height="10" width="30" alt="Sort Desc"></a>        
      </th>
      <th width="9%" bgcolor="#CCCCCC"><div align="center">PERIBADI</div></th>
      <th width="9%" bgcolor="#CCCCCC"><div align="center">KURSUS</div></th>
      </tr>

      <?php 
      if ($jabataninfo == "" || $jabataninfo == "Sila Buat Pilihan Jabatan/Unit" || $Num_Rows == 0) {
          echo "<tr bgcolor='#ffffff'><td colspan='6' align='center'>Tiada rekod ditemui atau tiada pilihan jabatan atau unit.</td></tr>";
      } else {
          $i = 1;
          while ($capture = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
              if ($Page != 1) {
                  $ordernum = (($Page - 1) * $Per_Page) + $i;
                  $i++;
              } else {
                  $ordernum = $i++;
              }

              $rowColor = ($capture["status"] == "AKTIF") ? "#FFFFFF" : "#FFFF66";
              ?>
              <tr bgcolor="<?php echo $rowColor; ?>">
              <td><?php echo $ordernum; ?></td>
              <td align="left"><?php echo htmlspecialchars($capture["namapegawai"]); ?></td>
              <td><center><?php echo htmlspecialchars($capture["gredhakiki"]); ?></center></td>
              <td><center><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?j=<?php echo urlencode($capture["skim_khidmat"]); ?>"><?php echo htmlspecialchars($capture["skim_khidmat"]); ?></a></center></td>
              <td><center><a href='search_display.php?nokp=<?php echo urlencode($capture["nokp"]); ?>'><img src='images/peribadi.png' title='Paparan Maklumat Peribadi' width='16' height='16' border='0' alt='Peribadi' /></a></center></td>
              <td><center><a href='staff_kursus.php?nokp=<?php echo urlencode($capture["nokp"]); ?>'><img src='images/kursus.png' title='Paparan Maklumat Kursus yang Telah Dihadiri' width='16' height='16' border='0' alt='Kursus' /></a></center></td>
              </tr>
              <?php 
          }
      }
      ?>
      <tr><td colspan="6" align="left"><font size=1><b>Nota:</b> Paparan berwarna kuning pada baris bermaksud kakitangan tersebut TIDAK AKTIF</font></td></tr>
      </table>
      <br>
      </span> 
      <font face="Verdana, Arial, Helvetica, sans-serif" size="1">Sebanyak <span class="class19"><?php echo $Num_Rows; ?></span> rekod ditemui dari pangkalan data </font> 
      <font face="Verdana, Arial, Helvetica, sans-serif" size="1">: <span class="class19">Sejumlah <?php echo $Num_Pages; ?> Muka Surat</span></font> <br>
      <?php 
      if($Prev_Page > 0) {
          echo " <a href='".htmlspecialchars($_SERVER['SCRIPT_NAME'])."?Page=$Prev_Page&jabatan=".urlencode($jabataninfo)."&s=".urlencode($s)."&j=".urlencode($j)."'>&lt;&lt; Back</a> ";
      }

      for($i=1; $i<=$Num_Pages; $i++) {
          if($i != $Page) {
              echo "[ <a href='".htmlspecialchars($_SERVER['SCRIPT_NAME'])."?Page=$i&jabatan=".urlencode($jabataninfo)."&s=".urlencode($s)."&j=".urlencode($j)."'>$i</a> ]";
          } else {
              echo "<b> $i </b>";
          }
      }
      
      if($Page != $Num_Pages && $Num_Pages > 1) {
          echo " <a href='".htmlspecialchars($_SERVER['SCRIPT_NAME'])."?Page=$Next_Page&jabatan=".urlencode($jabataninfo)."&s=".urlencode($s)."&j=".urlencode($j)."'>Next&gt;&gt;</a> ";
      }
      ?>
      </span>	
      <br><br>
        
<!-- end page display -->        
</td>
</tr>
</table>
<?php include('footer.php'); ?>
</body>
</html>
<?php
} else {
?>
<script language="javascript" type="text/javascript">
alert('Hanya Pengguna Berdaftar Dibenarkan Menggunakan Sistem Ini');
location='index.php';
</script>
<?php 
}
?>