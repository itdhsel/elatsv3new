<?php
// --- securing include file ---
// Check if user is logged in via session
if (!isset($_SESSION['level']) || $_SESSION['level'] <= 0) {
     exit('<h2>You cannot access this file directly!</h2>');
}
// --- end securing include file --
?>
<!-- start header -->
  
<body bgcolor="#c4afab" onload=display_ct();>

<?php
// Fix MySQLi queries - add connection parameter and error handling
if($_SESSION['level'] > 2){
    if($_SESSION['level'] == 3){
        $jabataninfo = $_SESSION['jabatan'] ?? '';
        $strSQL = "SELECT * FROM peribadi,kursus WHERE peribadi.nokp = kursus.nokp2 AND peribadi.status='AKTIF' AND kursus.valid=0 AND peribadi.jabatan='".mysqli_real_escape_string($conn, $jabataninfo)."'";
    } else {
        $strSQL = "SELECT * FROM peribadi,kursus WHERE peribadi.nokp = kursus.nokp2 AND peribadi.status='AKTIF' AND valid=0";
    }

    // Fixed mysqli_query - added connection parameter
    $objQuery = mysqli_query($conn, $strSQL);
    $Num_Rows = mysqli_num_rows($objQuery);
    
    if ($Num_Rows>0) {
        $_SESSION['belumsah']=1;
    } else {
        $_SESSION['belumsah']=0;
    }  

    if (($_SESSION['firstlogon'] ?? 0)==1 && $Num_Rows>0){
        echo "<script language='Javascript'>blah=window.open('popup.php','win2','status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=no,width=500,height=150,directories=no,location=no');</script>";
        $_SESSION['firstlogon']=0;
    }
}
?>

<table border="0" align="center" cellpadding="2" cellspacing="4" width="1200" bordercolor=white bgcolor=white  style="border: 0px;">
<tr>
<td colspan=4 align=center bgcolor=#CDB79E><IMG SRC="images/sistem.gif"><div align=right><span id='ct' ></span></div></td>
</tr>
  <!-- system annoucement -->
  <!-- <tr><td colspan=1 align=center bgcolor=black bordercolor=black><b><font color=white size=1 face=verdana>Pengumuman Sistem:</font></td><td colspan=3 align=center bgcolor=red bordercolor=black height=30 valign=middle><b><font color=white size=1 face=verdana><marquee behavior="scroll" direction="left" scrolldelay="200">Sistem eLATS akan ditutup sementara waktu bermula jam 9.00 pagi ke 1.00 petang untuk tujuan penyelenggaraan. Sekian untuk makluman. Terima kasih.</marquee></font></b></td></tr> 
  <!-- end system annoucement -->
<?php
if($_SESSION['level'] > 0)
{
?>
      <tr>
      <td colspan=4 align=center valign=top>
      
      <table border="0" bordercolor="black" width="100%" cellpadding="5" cellspacing="2">
      <tr>
      <td align="center" valign="middle" width=50% bgcolor=#CDB79E bordercolor=#000000>&nbsp;
      <b>Pengguna Berdaftar : </b> 
      <?php  
      
      if($_SESSION['level'] > 1) { 
          echo htmlspecialchars($_SESSION['name'] ?? 'Unknown User'); 
      } else { 
          $nokp = $_SESSION['staffkp'] ?? '';          
          $queryname = "SELECT namapegawai,nokp FROM peribadi WHERE nokp = '".mysqli_real_escape_string($conn, $nokp)."'";
          $resultname = mysqli_query($conn, $queryname); // Added connection parameter
          if($resultname && mysqli_num_rows($resultname) > 0) {
              $capturename = mysqli_fetch_array($resultname);
              $namastaff = $capturename["namapegawai"] ?? 'Unknown Staff';   
              $emailstaff = $capturename["email"] ?? '';       
              echo htmlspecialchars($namastaff);         
          } else {
              echo 'Staff Not Found';
          }
      }
      
      echo "</td><td align=center valign=middle width=50% bgcolor=#CDB79E bordercolor=#000000>";
      
      echo "&nbsp; <b>Tahap Akses :</b> ";

      if($_SESSION['level'] == 1) {
          echo "Kakitangan Sendiri";
      } else if($_SESSION['level'] == 2) {
          echo "Paparan Sahaja";
      } else if($_SESSION['level'] == 3) {
          echo "Wakil Jabatan";
      } else if($_SESSION['level'] == 4) {
          echo "Pentadbir Sumber Manusia";
      } else if($_SESSION['level'] == 5) {
          echo "Pentadbir Penuh Sistem";
      } else {
          echo "Unknown Level";
      }
      ?> 
      
      </td>
      </tr>
      </table>

      </td>
      </tr> 
<?php } ?>      
<tr>