<?
session_start();
if(!session_is_registered(myusername)){

}

include('files/db.php');

$query1 = " SELECT name, username, level FROM members where username = '".$user."'";
$result1 = mysqli_query($query1) or die('Error, query failed'); 

while($row = mysqli_fetch_array($result1))
{
$name = $row['name'];
$user = $row['username'];
$password = $row['password'];
$level = $row['level'];
}
?>
<form id="form1" name="form1" method="post" action="process.php">
			  <table width="90%" border="0" align="center">
    <tr>
      <td><div align="right">Nama Pengguna </div></td>
      <td>:</td>
      <td><?php echo $name; ?></td>
    </tr>
    <tr>
      <td width="25%"><div align="right">Username </div></td>
      <td width="2%">:</td>
      <td width="73%"><?php echo $user; ?></td>
    </tr>
    <tr>
      <td><div align="right">Password Baru </div></td>
      <td>:</td>
      <td><input name="password" type="password" id="password" value="<?php echo $password; ?>" size="35" /><input name="user" type="hidden" id="user" value="<?php echo $user; ?>" size="35" /></td>
    </tr>
    <tr>
      <td><div align="right">Level</div></td>
      <td>:</td>
      <td><?php echo $level; ?></td>
    </tr>
    <tr>
      <td><div align="right">Update Level</div></td>
      <td>:</td>
      <td><select name="level" id="level">
        <option value="0" selected="selected">Select User Level</option>
        <option value="1">Normal User</option>
        <option value="2">Supervisor</option>
            </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="reset" name="Reset" value="Reset" />
      </label>
        <label>
        <input type="submit" name="upduser" id="upduser" value="Submit Data" />
        </label></td>
    </tr>
  </table>
</form>