<?php 
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session for visitor counting
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
 
<!DOCTYPE html>
<html>
<head>
<title>Sistem Pengurusan Latihan Hospital Selayang - eLats V3</title>  
<link rel="stylesheet" href="css/styles.css" type="text/css">
<!-- Place somewhere in the <head> of your document -->
<link rel="stylesheet" type="text/css" href="flexslider1.css" media="all" />

<!-- Load modern jQuery for better compatibility -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- flexslider end -->
</head>
<body bgcolor="#c4afab">
<table border="1" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="900" height="400" valign="top" align="center" colspan=2 bgcolor=#CDB79E>
<br><img src="images/sistem.gif" alt="System Logo"><br>
<?php if (isset($_GET['module']) && $_GET['module']=='fail') {echo "<font color=red><b>ID pengguna/No KP atau kata laluan yang salah. Akses disekat</b></font>";} ?>
<table width=100% border="0">
 
      <tr><td valign="top">
      <table border="0">
        
        <tr><td width="172" rowspan="2" align="left" valign="top">  
        
        <form action="login.php" method="post" name="form1" id="form1">
        <table cellpadding="2" cellspacing="2" border=0>
        <tr><th colspan=2 align=left width="270"><font size=2>ID Kakitangan <br>(Format: 880909011234) </font></th></tr>
        <tr><td width="100">No Kad Pengenalan: </td><td><input name="nokp" type="text" id="Username" value="" size="20" required></td></tr>
        <tr><td>Kata Laluan: </td><td><input name="stafpwd" type="password" id="Password" value="" size="20" required> </td></tr>
        <tr><td colspan=2><input name="selflogin" type="submit" value="LOG MASUK KAKITANGAN"></td></tr>
        </table>
        <input type=hidden name="user" value="staff">
        </form>
        

        <form action="login.php" method="post" name="form2" id="form2">
        <table cellpadding="2" cellspacing="2" border=0>
        <tr><th colspan=2 align=left width="270"><font size="2">ID Pentadbir Sistem</font></th></tr>
        <tr><td width="100">ID Pentadbir: </td><td><input name="Username" type="text" id="Username" value="" size="20" required></td></tr>
        <tr><td>Kata Laluan: </td><td><input name="Password" type="password" id="Password" value="" size="20" required></td></tr>
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
            <td width="55"><a href="http://www.epsa.gov.my/" title="EPSA"><img src="images/logo_epsa_new.jpg" width="50" height="50" align="absmiddle" alt="EPSA"></a></td>
            <td width="55"><a href="http://www.online-itims.intan.my/itims/courses_schedule/crs_course_list.php" title="INTAN"><img src="images/logo_intan.png" width="50" height="50" align="absmiddle" alt="INTAN"></a></td>
            <td width="51"><a href="http://www.cgso.gov.my/portal/index.php/hubungi-kami/23-staff-cgso/47-staff-cgso-2#jadual" title="CGSO"><img src="images/cgso_logo.png" width="50" height="50" align="absmiddle" alt="CGSO"></a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><a href="http://www.mycpd.moh.gov.my/" title="myCPD"><img src="images/mycpd logo.jpg" width="50" height="50" align="absmiddle" alt="myCPD"></a></td>
            <td><a href="https://hrmisone.eghrmis.gov.my/" title="HRMIS"><img src="images/logo_HRMIS.png" width="50" height="50" alt="HRMIS"></a></td>
            <td><a href="http://latihan.moh.gov.my/v3/index.php?lang=ms" title="KKM"><img src="images/LOGO_KKM_1.75MB_.png" width="50" height="50" align="absmiddle" alt="KKM"></a></td>
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
        
      <iframe id="iframe1" src="http://10.30.0.63/slider.html" width="522" height="392" frameborder="0" title="Promosi Terkini"></iframe>
      
      </td></tr>
      </table>
      </td></tr>

      </table>
      
</td>        
</tr> 

<tr>
<td align="center" valign="middle" bgcolor=#CDB79E>
<span class="style20">Segala masalah berkaitan sistem, sila hubungi Unit Latihan , ext 3166/3163  
<br><br>
&copy; Hakcipta Terpelihara 2015: KIK Vaksin10 Hospital Selayang</span>
<br><br>
<?php
// Improved visitor counter without file operations
function getMonthlyVisitorCount() {
    $currentMonth = date('Y-m');
    
    // Initialize session-based counter
    if (!isset($_SESSION['visitor_counter'])) {
        $_SESSION['visitor_counter'] = [
            'month' => $currentMonth,
            'count' => 1
        ];
        return 1;
    }
    
    // Check if month has changed
    if ($_SESSION['visitor_counter']['month'] !== $currentMonth) {
        // New month, reset counter
        $_SESSION['visitor_counter'] = [
            'month' => $currentMonth,
            'count' => 1
        ];
        return 1;
    }
    
    // Increment counter for same month
    $_SESSION['visitor_counter']['count']++;
    return $_SESSION['visitor_counter']['count'];
}

// Get visitor count
$visitorCount = getMonthlyVisitorCount();
echo "Jumlah Pelawat pada Bulan Ini : $visitorCount";
?></td>
</tr> 
</table>

<script type="text/javascript">
// Simple DOM ready function without plugin dependencies
jQuery(document).ready(function($) {
    console.log('jQuery loaded successfully');
    
    // Enhanced form validation
    $('#form1, #form2').on('submit', function(e) {
        var form = $(this);
        var inputs = form.find('input[required]');
        var valid = true;
        var errorMessages = [];
        
        inputs.each(function() {
            var input = $(this);
            var value = input.val().trim();
            
            if (value === '') {
                valid = false;
                input.addClass('error');
                errorMessages.push('Sila isi semua medan yang diperlukan.');
            } else {
                input.removeClass('error');
                
                // Additional validation for staff ID format (12 digits)
                if (input.attr('name') === 'nokp' && !/^\d{12}$/.test(value)) {
                    valid = false;
                    input.addClass('error');
                    errorMessages.push('No Kad Pengenalan mesti mengandungi 12 digit nombor sahaja.');
                }
            }
        });
        
        if (!valid) {
            e.preventDefault();
            // Show first error message only to avoid multiple alerts
            if (errorMessages.length > 0) {
                alert(errorMessages[0]);
            }
        }
    });
    
    // Auto-format staff ID (remove non-numeric characters)
    $('input[name="nokp"]').on('input', function() {
        var value = $(this).val().replace(/\D/g, '');
        // Limit to 12 characters
        if (value.length > 12) {
            value = value.substring(0, 12);
        }
        $(this).val(value);
    });
    
    // Add focus effects for better UX
    $('input[type="text"], input[type="password"]').on('focus', function() {
        $(this).addClass('focus');
    }).on('blur', function() {
        $(this).removeClass('focus');
    });
});

// Simple iframe fallback
window.addEventListener('load', function() {
    var iframe = document.getElementById('iframe1');
    if (iframe) {
        // Set timeout to handle iframe loading issues
        setTimeout(function() {
            try {
                // Try to access iframe content (will fail for cross-origin)
                var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                // If we can access this, iframe loaded successfully
                console.log('Iframe loaded successfully');
            } catch (e) {
                // Cross-origin iframe, we can't check content but assume it loaded
                console.log('Cross-origin iframe loaded');
            }
        }, 2000);
    }
});
</script>

<style>
.error {
    border: 2px solid #ff0000 !important;
    background-color: #ffe6e6;
}

.focus {
    border: 2px solid #4a90e2 !important;
    background-color: #f0f8ff;
}

.style20 {
    font-size: 12px;
    color: #333;
    font-family: Arial, sans-serif;
}

.style21 {
    font-weight: bold;
    color: white;
    font-size: 14px;
    font-family: Arial, sans-serif;
}

/* Improve form styling */
form table {
    margin-bottom: 15px;
}

form th {
    background-color: #f0f0f0;
    padding: 5px;
    border: 1px solid #ccc;
}

form td {
    padding: 3px;
}

input[type="text"], input[type="password"] {
    padding: 4px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 13px;
}

input[type="submit"] {
    background-color: #8B8378;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-weight: bold;
}

input[type="submit"]:hover {
    background-color: #7a7268;
}

/* Improve iframe appearance */
#iframe1 {
    border: 1px solid #ccc;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>

</body>
</html>