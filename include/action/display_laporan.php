 <?php

include 'include/db.php';

$tarikh1 = $_POST['tarikh1'];
$tarikh2 = $_POST['tarikh2'];

// how many rows to show per page
$rowsPerPage = 10;

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
    $pageNum = $_GET['page'];
}

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
//$query = " SELECT sid, nama, nric, tarikh_aduan, status FROM borang_aduan order by sid" .
$query = " SELECT * 
		   FROM dokumen
		   WHERE tterima between '$tarikh1' and '$tarikh2'
		   order by id" .
         " LIMIT $offset, $rowsPerPage";
$result = mysqli_query($query) or die('Error, query failed');


echo '<table width="100%" border="1" cellpadding="3" cellspacing="3" bordercolor="#000000" bgcolor="#FFCCCC">';
echo '<tr bgcolor="#D4D0C8">';
echo "<td><center>No Id</center></td>";
echo "<td><center>T/terima</center></td>";
echo "<td><center>Rujukan</center></td>";
echo "</tr>";

// print the vendor list
while($row = mysqli_fetch_array($result))
{
$sid = $row['sid'];
echo "<tr>";
echo "<td><center><a href='informasi.php?sid=$sid'>{$row['id']}</a></center></td>";
//echo "<td>{$row['nama']}</td>";
//echo "<td><center>{$row['lokasi_aduan2']}</center></td>";
//echo "<td><center>{$row['tarikh_aduan']}</center></td>";
//echo "<td><center><a href='informasi.php?sid=$sid'><img src='images/39.png' title='Kemaskini Borang 02' width='16' height='16' border='0' /></a></center></td>";

/*echo "<td><center><a href='jawapan_awal.php?sid=$sid'><img src='images/39.png' title='Kemaskini Borang Jawapan Awal' width='16' height='16' border='0' /></a></center></td>";
echo "<td><center><a href='tindakan_pembetulan.php?sid=$sid'><img src='images/39.png' title='Kemaskini Borang Tindakan Pembetulan' width='16' height='16' border='0' /></a></center></td>";
echo "<td><center><a href='peringatan_jabatan.php?sid=$sid'><img src='images/39.png' title='Kemaskini Borang Peringatan' width='16' height='16' border='0' /></a></center></td>";
echo "<td><center><a href='borang03.php?sid=$sid'><img src='images/24.png' title='Kemaskini Borang 03' width='16' height='16' border='0' /></a></center></td>";
echo "<td><center><a href='penghargaan_jabatan.php?sid=$sid'><img src='images/39.png' title='Kemaskini Borang Penghargaan' width='16' height='16' border='0' /></a></center></td>";
echo "<td><center><a href='kesimpulan_aduan.php?sid=$sid'><img src='images/39.png' title='Kemaskini Borang Kesimpulan' width='16' height='16' border='0' /></a></center></td>";*/


// column status
echo "<td><center>{$row['tterima']}</center></td>";

echo "<td><center>{$row['rujukan']}</center></td>";

/*echo "<td><center><a href='delete.php?sid=$sid'><img src='images/delete.png' title='Delete Aduan' width='16' height='16' border='0' /></a></center></td>";
*/
echo "</tr>";

}
echo "</table>";

$query   = "SELECT COUNT(id) AS numrows FROM dokumen
		   WHERE tterima between '$tarikh1' and '$tarikh2' ";
$result  = mysqli_query($query) or die('Error, query failed');
$row     = mysqli_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];

// how many pages we have when using paging?
$maxPage = ceil($numrows/$rowsPerPage);

// print the link to access each page
$self = $_SERVER['PHP_SELF'];
$nav  = '';

for($page = 1; $page <= $maxPage; $page++)
{
   if ($page == $pageNum)
   {
      $nav .= " $page "; // no need to create a link to current page
   }
   else
   {
      $nav .= " <a href=\"$self?page=$page\">$page</a> ";
   }
}

// creating previous and next link
// plus the link to go straight to
// the first and last page

if ($pageNum > 1)
{
   $page  = $pageNum - 1;
   $prev  = " <a href=\"$self?page=$page\"><img src='images/2.png' title='Halaman Sebelumnya' width='16' height='16' border='0' /></a> ";

 //  $first = " <a href=\"$self?page=1\">[First Page]</a> ";
}
else
{
   $prev  = '&nbsp;'; // we're on page one, don't print previous link
   $first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage)
{
   $page = $pageNum + 1;
   $next = " <a href=\"$self?page=$page\"><img src='images/1.png' title='Halaman Seterusnya' width='16' height='16' border='0' /></a> ";

  // $last = " <a href=\"$self?page=$maxPage\">[Last Page]</a> ";
}
else
{
   $next = '&nbsp;'; // we're on the last page, don't print next link
   $last = '&nbsp;'; // nor the last page link
}

// print the navigation link
echo "<center>".$first . $prev . $nav . $next . $last."</center>";

// and close the database connection
include 'include/closedb.php';

// ... and we're done!
?>