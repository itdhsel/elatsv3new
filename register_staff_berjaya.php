<?php 

session_start();
include('privcheck.php');

if($_SESSION ['level'] > 0)
{


include('files/db.php');



?>

<?php include('pagetitleheader.php'); ?> 
</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 
<!-- start page display -->
<td align="center" valign="top" bgcolor="#f1e6e5" width="1000"><br />

  <table height="100%" border="0" align="center" class="tablestyleB"> 
		<tr><td align="center" valign="top"><p><span class="title">Daftar Pegawai Baru  </span></td></tr>
		<tr><td>	  
			<?php 

				if(isset($_POST['addstaff']))
				{ 

          include 'files/db.php';

          // ----- select no IC dari database ---------------------------------------------------
          $selectdata = "SELECT * FROM peribadi WHERE nokp = '".$_POST['nokp']."' ";
          $result = mysqli_query($selectdata);
          $found = mysqli_num_rows($result);

          // ----- maklumat peribadi -------------------------------------------------------------------------
          $namapegawai = mysql_real_escape_string(strtoupper($_POST["namapegawai"]));
          $nokp = $_POST['nokp'];

          $gentle = strtoupper($_POST["jantina"]);
          if($gentle =='SILA BUAT PILIHAN'){
	           $jantina = '';
            }
          else {
	           $jantina = $gentle;
            }

          $race = strtoupper($_POST["bangsa"]);
          if($race == 'SILA BUAT PILIHAN'){
	           $bangsa = '';
            }
          else {
	           $bangsa = $race;
            }

          $flag_status = strtoupper($_POST["status"]);
          if($flag_status == 'SILA BUAT PILIHAN'){
	           $status = '';
            }
          else {
	        $status = $flag_status;
       }

       // ----- maklumat perkhidmatan ---------------------------------------------------------------------


          $skim = strtoupper($_POST["skim_khidmat"]);
          if ($skim == 'SILA BUAT PILIHAN'){
              $skim_khidmat = '';
             } 
          else{
              $skim_khidmat = $skim;
            }

          $gred = strtoupper($_POST["gredhakiki"]);
          if ($gred == 'SILA BUAT PILIHAN'){
              $gredhakiki = '';
             } 
          else{
              $gredhakiki = $gred;
              }


          $group = strtoupper($_POST["kumpulan"]);
          if ($group == 'SILA BUAT PILIHAN'){
          $kumpulan = '';
          } 
          else{
          $kumpulan = $group;
          }

          $department = strtoupper($_POST["jabatan"]);
          if ($department == 'SILA BUAT PILIHAN'){
          $jabatan = '';
          } 
          else{
          $jabatan = $department;
          }


          // ----- User yang key in data ---------------------------------------------------------------------
          $user_id = $_SESSION['user_id'];
		  $email = $_POST['email'];


          if($found >0)
          {	
	         echo "<center>Nama Kad Pengenalan '".$nokp."' telah WUJUD dalam pangkalan data !!</center>";
	         echo "<br><center>Pendaftaran TIDAK BERJAYA !!</center>";
	         echo "<br><center><a href='register_staff.php'>Pendaftaran Pegawai Baru</a></center> ";	
          }
          else
          {

          // ----- Coding untuk insert data ke dalam database ------------------------------------------------
          $query = "INSERT INTO peribadi (namapegawai, nokp, pwd, jantina, bangsa, email, skim_khidmat , gredhakiki, kumpulan, jabatan, status, user_id) 		
		      VALUES ( '$namapegawai', '$nokp', '$nokp','$jantina', '$bangsa', '$email', '$skim_khidmat' , '$gredhakiki', '$kumpulan', '$jabatan', '$status','$user_id') ";
		
          mysqli_query($query) or die('Error, insert data failed');

          $year_today = date("Y");

          $query1 = "INSERT INTO infokursus (nokp, year, bil, bilsah, day, hour, borgperlu, borgkembali) VALUES ('$nokp', '$year_today', '0', '0', '0', '0', '0', '0') ";
          mysqli_query($query1) or die('Error, insert data failed');
          
          //$query = "FLUSH PRIVILEGES";
          
          //filling up $query variable for auditlog
          $query = "INSERT INTO peribadi (namapegawai, nokp, pwd, jantina, bangsa, email, skim_khidmat , gredhakiki, kumpulan, jabatan, status, user_id)    
          VALUES ( '$namapegawai', '$nokp', '$nokp','$jantina', '$bangsa', '$email', '$skim_khidmat' , '$gredhakiki', '$kumpulan', '$jabatan', '$status','$user_id') 
          & INSERT INTO infokursus (nokp, year, bil, bilsah, day, hour, borgperlu, borgkembali) VALUES ('$nokp', '$year_today', '0', '0', '0', '0', '0', '0') ";

          // ---------- function: log sql executed -------
          include 'auditlog.php';
          // ---------- end log sql function -----------          


          echo "<center>Maklumat pegawai dengan nombor kad pengenalan '".$nokp."' telah BERJAYA didaftarkan</center>";
          echo "<br><center><a href='register_staff.php'>Daftar Pegawai Baru</a></center> ";

          }

                  
				}
				
				else
				echo "Tiada Sebarang Aktiviti Proses Sedang Berjalan";

			?>
   </td></tr>
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
