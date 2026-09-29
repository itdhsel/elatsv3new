<?php 

session_start();
include('privcheck.php');  //check session n permission to access

if($_SESSION ['level'] > 4)
{
include('files/db.php');
?>

<?php include('pagetitleheader.php'); ?> 

<script type="text/javascript">
function updateCombo(optionValue)
{    
		document.getElementById('jabatan').disabled = (optionValue=='add');
		//document.getElementById('jabatan').disabled = (optionValue!='edit');  
		//document.getElementById('jabatan').disabled = (optionValue!='delete');      
}
</script>

<script type="text/javascript">
function updateCombo2(optionValue)
{    
	document.getElementById('jabatan').disabled = (optionValue == 'Sila Buat Pilihan');
}
</script>

</head>
<?php include('header.php'); ?>
<?php include('rightmenu1.php'); ?> 

<td align="center" valign="top" bgcolor="#f1e6e5" width="1000">


<table border=0 width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
	    
	  <td height="30" align="center" bgcolor=#8B8378><div class="style21">EDITOR TEMPLATE DATA UTAMA</div></td></tr>
    <tr><td align="center">
      <br><br><strong>Peringatan:</strong> <font color="red">Gunakan fungsi ini dengan berhati-hati kerana sebarang kesilapan akan melibatkan perubahan pada semua data sedia ada.</font></div></td></tr>
      <td align="center">
      <br><br>
      <table width="80%" border="0" cellpadding="2" cellspacing="2" class="tablestyleB" bgcolor=#ffffff>
      <tr>
      <td class="style10">
      <!-- start page display -->
      
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Sila pilih maklumat untuk transaksi: 
      <select name="aktiviti">
      <option value="ajabatan" <?php  if($_POST["aktiviti"]=="ajabatan") echo selected?>>Jabatan</option>
      <option value="ajawatan" <?php  if($_POST["aktiviti"]=="ajawatan") echo selected?>>Jawatan</option>
      <option value="agred" <?php  if($_POST["aktiviti"]=="agred") echo selected?>>Gred Hakiki</option>     
      </select>

      <input type="submit" value="PILIH">
      <input type="button" value="SET SEMULA" onClick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>'">
      <input type="hidden" name="actionform" value="display">
      </form>
      
      <!-- end page display -->
      <?php 
      
      if ($_POST['actionform']=="display")
      {
        if ($_POST['aktiviti']=="ajabatan")
        { $strSQLjabatan = "SELECT namajabatan,id,id2 from jabatan ORDER BY namajabatan"; } 
        if ($_POST['aktiviti']=="ajawatan")
        { $strSQLjabatan = "SELECT namajawatan from jawatan ORDER BY namajawatan"; } 
        if ($_POST['aktiviti']=="agred")
        { $strSQLjabatan = "SELECT namagred from gred ORDER BY namagred"; } 
        
        
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <select name="actionform" onChange="updateCombo(this.value)">
        <option value="nil">Sila Pilih Tindakan</option>        
        <option value="add">Add</option>
        <option value="edit">Edit</option>
        <option value="delete">Delete</option>
        </select>
        
        <select name='jabatan' id='jabatan' onChange="updateCombo2(this.value)">
        <option selected='selected'>Sila Buat Pilihan</option>
        <?php 
        	//$strSQLjabatan = "SELECT namajabatan from jabatan"; 
          $objQueryjabatan = mysqli_query($strSQLjabatan) or die ("Error Query [".$strSQLjabatan."]");   
          while($capturejabatan = mysqli_fetch_array($objQueryjabatan))
          {                  
                if ($_POST['aktiviti']=="ajabatan")
                { ?><option value='<?php echo $capturejabatan["namajabatan"];?>'><?php echo $capturejabatan["id"];?> | <?php echo $capturejabatan["id2"];?> | <?php echo $capturejabatan["namajabatan"];?></option><?php  } 
                if ($_POST['aktiviti']=="ajawatan")
                { ?><option value='<?php echo $capturejabatan["namajawatan"];?>'><?php echo $capturejabatan["namajawatan"];?></option><?php } 
                if ($_POST['aktiviti']=="agred")
                { ?><option value='<?php echo $capturejabatan["namagred"];?>'><?php echo $capturejabatan["namagred"];?></option><?php  } 
                
          }
        ?>     
        </select>
             
        <input type="hidden" name="aktiviti" value='<?php echo $_POST["aktiviti"];?>'>
        <input type="submit" value="PILIH">
        </form>
        <?php 
            
      }

      if ($_POST['actionform']=="add")
      {
        ?>   
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php 
        
        if ($_POST['aktiviti']=="ajabatan")
        { echo "<input type='hidden' name='aktiviti' value='ajabatan'>"; } 
        if ($_POST['aktiviti']=="ajawatan")
        { echo "<input type='hidden' name='aktiviti' value='ajawatan'>"; } 
        if ($_POST['aktiviti']=="agred")
        { echo "<input type='hidden' name='aktiviti' value='agred'>";  }
        
        ?>   
        Masukkan Data Baru: <input type="text" name="jabatan" size="50"> <input type="submit" value="MASUKKAN">
        <input type="hidden" name="actionform" value="insert">
        </form>
        <?php 
              
      }         
      
      if ($_POST['actionform']=="insert")
      {
        if ($_POST['aktiviti']=="ajabatan")
        { $strSQLjabatan = "INSERT INTO jabatan (namajabatan) VALUES ('".$_POST['jabatan']."')"; }
        if ($_POST['aktiviti']=="ajawatan")
        { $strSQLjabatan = "INSERT INTO jawatan (namajawatan) VALUES ('".$_POST['jabatan']."')"; } 
        if ($_POST['aktiviti']=="agred")
        { $strSQLjabatan = "INSERT INTO gred (namagred) VALUES ('".$_POST['jabatan']."')"; }
        
        ?>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php 
        	//$strSQLjabatan = "INSERT INTO jabatan (namajabatan) VALUES ('".$_POST['jabatan']."')"; 
          //echo $strSQLjabatan;
          mysqli_query($strSQLjabatan) or die('Error, insert data failed');     

        ?>
        Data Jabatan baru telah dimasukkan dengan berjaya. 
        <input type="submit" name="edit" value="SELESAI">
        </form>
        <?php 
           
      }   
      
      if ($_POST['actionform']=="edit")
      {
        if ($_POST['aktiviti']=="ajabatan")
        { $strSQLjabatan = "SELECT namajabatan,id,id2 from jabatan where namajabatan = '".$_POST['jabatan']."'"; } 
        if ($_POST['aktiviti']=="ajawatan")
        { $strSQLjabatan = "SELECT namajawatan from jawatan where namajawatan = '".$_POST['jabatan']."'"; } 
        if ($_POST['aktiviti']=="agred")
        { $strSQLjabatan = "SELECT namagred from gred where namagred = '".$_POST['jabatan']."'"; }
        
        ?>     
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php 
        	//$strSQLjabatan = "SELECT namajabatan from jabatan where namajabatan = '".$_POST['jabatan']."'"; 
          //echo $strSQLjabatan;
          $objQueryjabatan = mysqli_query($strSQLjabatan) or die ("Error Query [".$strSQLjabatan."]");   
          while($capturejabatan = mysqli_fetch_array($objQueryjabatan))
          {   

                
              if ($_POST['aktiviti']=="ajabatan")
              { 
				        ?>
                <input type="text" name="id" value='<?php echo $capturejabatan["id"];?>' size="3" disabled>
                <input type="text" name="id2" value='<?php echo $capturejabatan["id2"];?>' size="3">
                <input type="text" name="jabatan" value='<?php echo $capturejabatan["namajabatan"];?>' size="50">
                <input type="hidden" name="orivalue" value='<?php echo $capturejabatan["namajabatan"];?>'>
                <?php                 
              } 
              if ($_POST['aktiviti']=="ajawatan")
              { 
				        ?>
                <input type="text" name="jabatan" value='<?php echo $capturejabatan["namajawatan"];?>' size="50">
                <input type="hidden" name="orivalue" value='<?php echo $capturejabatan["namajawatan"];?>'>
                <?php                 
              } 
              if ($_POST['aktiviti']=="agred")
              { 
				        ?>
                <input type="text" name="jabatan" value='<?php echo $capturejabatan["namagred"];?>' size="50">
                <input type="hidden" name="orivalue" value='<?php echo $capturejabatan["namagred"];?>'>
                <?php               
              }                
                        
          }
        ?>  

        <input type="hidden" name="aktiviti" value='<?php echo $_POST["aktiviti"];?>'>          
        <input type="hidden" name="actionform" value="update">
        <input type="submit" name="edit" value="KEMASKINI">
        </form>
        <?php 
              
      }   
      
      if ($_POST['actionform']=="update")

      {
        if ($_POST['aktiviti']=="ajabatan")
        { 
        $strSQLjabatan = "UPDATE jabatan set namajabatan = '".$_POST['jabatan']."',id2 = '".$_POST['id2']."' where namajabatan = '".$_POST['orivalue']."'"; 
        $strSQLjabatan2 = "UPDATE peribadi set jabatan = '".$_POST['jabatan']."' where jabatan = '".$_POST['orivalue']."'";
        $strSQLjabatan3 = "UPDATE kursus set jenis_penganjur_dalaman = '".$_POST['jabatan']."' where jenis_penganjur_dalaman = '".$_POST['orivalue']."'";      
        }
        if ($_POST['aktiviti']=="ajawatan")
        { 
        $strSQLjabatan = "UPDATE jawatan set namajawatan = '".$_POST['jabatan']."' where namajawatan = '".$_POST['orivalue']."'";
        $strSQLjabatan2 = "UPDATE peribadi set skim_khidmat = '".$_POST['jabatan']."' where skim_khidmat = '".$_POST['orivalue']."'";
        } 
        if ($_POST['aktiviti']=="agred")
        { 
        $strSQLjabatan = "UPDATE gred set namagred = '".$_POST['jabatan']."' where namagred = '".$_POST['orivalue']."'"; 
        $strSQLjabatan2 = "UPDATE peribadi set gredhakiki = '".$_POST['jabatan']."' where gredhakiki = '".$_POST['orivalue']."'";
        }        
        
        ?>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php 
        	//$strSQLjabatan = "UPDATE jabatan set namajabatan = '".$_POST['jabatan']."' where namajabatan = '".$_POST['orivalue']."'"; 
          mysqli_query($strSQLjabatan) or die ('Error, update data failed');     
          mysqli_query($strSQLjabatan2) or die ('Error, update data failed');  
        if ($_POST['aktiviti']=="ajabatan")
        {           
          mysqli_query($strSQLjabatan3) or die ('Error, update data failed');    
        }  
          //echo $strSQLjabatan;
        ?>
        Data Dikemaskini dan Diselaraskan. 
        <input type="submit" name="edit" value="SELESAI">
        </form>
        <?php 
             
      }     
 
       if ($_POST['actionform']=="delete")
      {
        if ($_POST['aktiviti']=="ajabatan")
        { $strSQLjabatan = "DELETE FROM jabatan where namajabatan = '".$_POST['jabatan']."'"; }
        if ($_POST['aktiviti']=="ajawatan")
        { $strSQLjabatan = "DELETE FROM jawatan where namajawatan = '".$_POST['jabatan']."'";} 
        if ($_POST['aktiviti']=="agred")
        { $strSQLjabatan = "DELETE FROM gred where namagred = '".$_POST['jabatan']."'"; }        
        
        ?>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php 
        	//$strSQLjabatan = "UPDATE jabatan set namajabatan = '".$_POST['jabatan']."' where namajabatan = '".$_POST['orivalue']."'"; 
          mysqli_query($strSQLjabatan) or die ('Error, Delete data failed');          
          //echo $strSQLjabatan;
        ?>
        Data telah dihapuskan. 
        <input type="submit" name="edit" value="SELESAI">
        </form>
        <?php 
             
      }
      
      ?>
			</td>
      </tr></table>   </td></tr></table>

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
