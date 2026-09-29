 <?php 
 error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
 ?>
 
<head>
<title>Sistem Pengurusan Latihan Hospital Selayang - eLats V3</title>  
<link rel="stylesheet" href="css/styles.css" type="text/css">
<script type="text/javascript" src="poll/jquery.js"></script>
<script type="text/javascript" src="poll/ajax-poll.php"></script>
<!-- Place somewhere in the <head> of your document -->
<link rel="stylesheet" type="text/css" href="flexslider1.css" media="all" />
<script type="text/javascript" src="style/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="style/js/ddsmoothmenu.js"></script>
<script type="text/javascript" src="style/js/carousel.js"></script>
<script type="text/javascript" src="style/js/jquery.flexslider-min.js"></script>
<!-- flexslider end -->
</head>
<body bgcolor="#c4afab">
<table border="1" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="900" height="400" valign="top" align="center" colspan=2 bgcolor=#CDB79E>
<br><IMG SRC="images/sistem.gif"><br>
<?php if ($_GET['module']=='fail') {echo "<font color=red><b>ID pengguna/No KP atau kata laluan yang salah. Akses disekat</b></font>";} ?>
<table widht=100% border="0">
 
      <tr><td valign="top">
      <table border="0">
        
        <!-- system annoucement -->
        <!-- <tr><td align=center bgcolor=black bordercolor=black><b><font color=white size=1 face=verdana>Pengumuman Sistem:</font></td><td align=center bgcolor=red bordercolor=black height=30 valign=middle><b><font color=white size=1 face=verdana><marquee behavior="scroll" direction="left" scrolldelay="100">Sistem eLATS akan ditutup sementara tujuan penyelenggaraan server. Sekian untuk makluman. Terima kasih.</marquee></font></b></td></tr> -->
        <!-- <tr><td align=center bgcolor=black bordercolor=black><b><font color=white size=1 face=verdana>Pengumuman Sistem:</font></td><td align=center bgcolor=red bordercolor=black height=30 valign=middle><b><font color=white size=1 face=verdana>Sistem eLATS akan ditutup sementara mulai jam 9.00 pagi ke 1.00 petang tujuan penyelenggaraan server. Sekian untuk makluman. Terima kasih.</font></b></td></tr>
        <!-- end system annoucement -->
        
        <tr><td width="172" rowspan="2" align="left" valign="top">  
        
        
        <form action="login.php" method="post" name="form1" id="form1">
        <table cellpadding="2" cellspacing="2" border=0>
        <tr><th colspan=2 align=left width="270"><font size=2>ID Kakitangan <br>(Format: 880909011234) </font></th></tr>
        <tr><td width="100">No Kad Pengenalan: </td><td><input name="nokp" type="text" id="Username" value="" size="20"></td></tr>
        <tr><td>Kata Laluan: </td><td><input name="stafpwd" type="password" id="Password" value="" size="20"> </td></tr>
        <tr><td colspan=2><input name="selflogin" type="submit" value="LOG MASUK KAKITANGAN"></td></tr>
        </table>
        <input type=hidden name="user" value="staff">
        </form>
        

        <form action="login.php" method="post" name="form1" id="form1">
        <table cellpadding="2" cellspacing="2" border=0>
        <tr><th colspan=2 align=left width="270"><font size="2">ID Pentadbir Sistem</font></th></tr>
        <tr><td width="100">ID Pentadbir: </td><td><input name="Username" type="text" id="Username" value="" size="20"></td></tr>
        <tr><td>Kata Laluan: </td><td><input name="Password" type="password" id="Password" value="" size="20"></td></tr>
        <tr><td colspan=2><input name="adminlogin" type="submit" value="LOG MASUK PENTADBIR"></td></tr>
        </table>
        <input type=hidden name="user" value="admin">
        </form>
         
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        
        <br>
        <p><b>PAUTAN SESAWANG</b><br>
        </p>
        <table width="175" border="0">
          <tr>
            <td width="55"><a href="http://www.epsa.gov.my/" title="EPSA"><img src="images/logo_epsa_new.jpg" width="50" height="50" align="absmiddle"></a></td>
            <td width="55"><a href="http://www.online-itims.intan.my/itims/courses_schedule/crs_course_list.php" title="INTAN"><img src="images/logo_intan.png" width="50" height="50" align="absmiddle"></a></td>
            <td width="51"><a href="http://www.cgso.gov.my/portal/index.php/hubungi-kami/23-staff-cgso/47-staff-cgso-2#jadual" title="CGSO"><img src="images/cgso_logo.png" width="50" height="50" align="absmiddle"></a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><a href="http://www.mycpd.moh.gov.my/" title="myCPD"><img src="images/mycpd logo.jpg" width="50" height="50" align="absmiddle"></a></td>
            <td><a href="https://hrmisone.eghrmis.gov.my/"title="HRMIS"><img src="images/logo_HRMIS.png" width="50" height="50"></a></td>
            <td><a href="http://latihan.moh.gov.my/v3/index.php?lang=ms" title="KKM"><img src="images/LOGO_KKM_1.75MB_.png" width="50" height="50" align="absmiddle"></a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr><th colspan="3" align="left"><font size=1>Jumlah Pengunjung : &nbsp;<?php include('counter.php'); ?></font></th></tr>
      </table>
        <p>&nbsp;</p></td><td width=621 valign=top align=left bgcolor=white>
      <table width='100%'>
      
      <tr><td height='30' bgcolor='#8B8378' align='center'><span class='style21'>PENGUMUMAN DARI UNIT LATIHAN</span></td></tr>
      <tr><td>
      <ul>

      <li>Sila kemaskini maklumat kursus anda ke dalam sistem eLats.
      <br><br>
      </ul>
      </td></tr>
      
      <tr><td height='30' bgcolor='#8B8378' align='center'><span class='style21'>PROMOSI TERKINI DALAMAN</span></td></tr>
      <tr><td align="center" valign="top">
      
      <!-- Begin Slider  
      <div id="slider">
      <div class="flexslider">
      <ul class="slides">
        <li><img src="style/images/art/a.png" alt=""/></li>
        <li><img src="style/images/art/b.jpg" alt=""/></li>
        <li><img src="style/images/art/e.jpg" alt=""/></li>
        <li><img src="style/images/art/f.png" alt=""/></li> 
        <li><img src="style/images/art/g.png" alt=""/></li> 
          
      </ul>
      </div>
      </div>

      <div class="clear"></div>
      <script type="text/javascript" src="style/js/scripts.js"></script>
      End Slider -->     
        
      <iframe id="iframe1" src="http://10.30.0.63/slider.html" width="522" height="392" frameborder="0"></iframe>
      
      </td></tr>
      <!--
      <tr><td height='30' bgcolor='#8B8378' align='center'><span class='style21'>KAJIAN MAKLUMBALAS PENGGUNA ELATS</span></td></tr>
      <tr><td>Kumpulan VAKSIN10 dan Unit Latihan ingin mendapatkan maklumabalas daripada pengguna sistem eLats untuk tujuan penamnbahbaikan sistem di masa hadapan.<br><br><div class='ajax-poll' tclass='poll-simple'></div> </td></tr>
      -->
      </table>
      </td></tr>

      </table>
      
</td>        
</tr> 

<tr>
<td align="center" valign="middle" bgcolor=#CDB79E>
<span class="style20">Segala masalah berkaitan sistem, sila hubungi Unit Latihan , ext 3166/3163 atau email 
<br>SYARIFAH FADILAH BINTI SYED MOHAMMAD (sfadilah@selayanghospital.gov.my) atau <br>Aspanita binti Abdullah (aspanita @moh.gov.my)<br>
&copy Hakcipta Terpelihara 2015: KIK Vaksin10 Hospital Selayang</span>
</b></font></td>
</tr> 
</table>
</body>
</html>




