 <?php

include('files/db.php');

// how many rows to show per page
$rowsPerPage = 5;

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
    $pageNum = $_GET['page'];
}

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;

$query = " SELECT name, username, level FROM members order by user_id" .
         " LIMIT $offset, $rowsPerPage";
$result = mysqli_query($query) or die('Error, query failed');


echo '<table width="100%" border="1" cellpadding="3" cellspacing="3" bordercolor="#000000" bgcolor="#FFFFCC">';
echo '<tr bgcolor="#FFCC66">';
echo "<td><center>Nama Pengguna</center></td>";
echo "<td><center>Username</center></td>";
echo "<td><center>Level</center></td>";
echo "<td><center>Tukar Password</center></td>";    
echo "<td><center>Padam</center></td>";
//echo "<td><center>Email</center></td>";
echo "</tr>";

// print the vendor list
while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td><center>{$row['name']}</center></td>";
echo "<td>{$row['username']}</td>";
//
if($row['level'] == 1)
	{	echo "<td><center>Biasa</center></td>";	}
else
		
		{echo "<td><center>Administratror</a></center></td>";}
		
//echo "<td><center>{$row['compregno']}</center></td>";
//echo "<td><center>{$row['contactname']}</center></td>";
echo "<td><center><a href='process.php?pass=".$row['username']."'><img src='images/72.png' title='Reset Password Pengguna' width='16' height='16' border='0' /></a></center></td>";

echo "<td><center><a href='process.php?user=".$row['username']."'><img src='images/24.png' title='Padam Rekod Pengguna' width='16' height='16' border='0' /></a></center></td>";
//echo "<td><center><a href='details2.php?labno=$labno'><img src='images/48.png' title='Email Kepada Pembekal' width='16' height='16' border='0' /></a></center></td>";
echo "</tr>";
  // echo $row['compname'] . $row['compregno'] . $row['contactname'] .'<br>';
}
echo "</table>";

$query   = "SELECT COUNT(username) AS numrows FROM members";
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
include 'files/closedb.php';

// ... and we're done!
?>