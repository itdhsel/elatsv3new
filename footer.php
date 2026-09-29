<?php
// --- securing include file ---
if (isset($ping) != "pong") {
     exit('<h2>You cannot access this file directly!</h2>');
}
// --- end securing include file --
?>
<!-- start footer -->
<tr>
<td colspan="4" align="center" valign="middle" bgcolor="#CDB79E">
<span class="style20">Segala masalah berkaitan sistem, sila hubungi Unit Latihan , ext 3166/3163 atau email 
<br><br>
&copy; Hakcipta Terpelihara <?php echo date('Y'); ?>: KIK Vaksin10 Hospital Selayang</span>
</td>
</tr>
     
</table>
<?php  
// Use mysqli_close() instead of mysql_close() which was removed in PHP 7.0
if (isset($conn) && $conn instanceof mysqli) {
    mysqli_close($conn);
}
?>
</body>
</html>

<!-- end footer -->