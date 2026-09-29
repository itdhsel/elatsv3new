<?php

include('files/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if database connection is successful
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user']) && $_POST['user'] == "admin"){
    
    // Validate and sanitize inputs
    $Username = isset($_POST['Username']) ? $conn->real_escape_string(trim($_POST['Username'])) : '';
    $Password = isset($_POST['Password']) ? $conn->real_escape_string(trim($_POST['Password'])) : '';

    if (empty($Username) || empty($Password)) {
        header("location:index.php?module=fail");
        exit();
    }

    $encrypted_Password = md5($Password);

    $sql = "SELECT * FROM members WHERE username='$Username' and password='$encrypted_Password'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result && $result->num_rows > 0) {
        $get_user = $result->fetch_array(MYSQLI_ASSOC);

        setcookie("login_user", $Username, time() + (60 * 60), "/");
        
        $_SESSION['username'] = $get_user['username'] ?? '';
        $_SESSION['user_id'] = $get_user['user_id'] ?? '';
        $_SESSION['level'] = $get_user['level'] ?? '';
        $_SESSION['name'] = $get_user['name'] ?? '';
        $_SESSION['picture'] = $get_user['picture'] ?? '';
        $_SESSION['jabatan'] = $get_user['jabatan'] ?? '';
        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['firstlogon'] = 1;
      
        if(($_SESSION['level'] ?? 0) == 2) {
            header("location:mydashboard.php");
            exit();
        } else if(($_SESSION['level'] ?? 0) == 3) {
            header("location:mydashboard.php");
            exit();
        } else if(($_SESSION['level'] ?? 0) == 4) {
            header("location:mydashboard.php");
            exit();
        } else if(($_SESSION['level'] ?? 0) == 5) {
            header("location:mydashboard.php");
            exit();
        } else {
            header("location:index.php?module=fail");
            exit();
        }
    } else {
        header("location:index.php?module=fail");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user']) && $_POST['user'] == "staff"){
    
    // Validate and sanitize inputs
    $staffkp = isset($_POST['nokp']) ? $conn->real_escape_string(trim($_POST['nokp'])) : '';
    $stafpwd = isset($_POST['stafpwd']) ? $conn->real_escape_string(trim($_POST['stafpwd'])) : '';

    if (empty($staffkp) || empty($stafpwd)) {
        header("location:index.php?module=fail");
        exit();
    }

    // Note: This is storing password in plain text - consider using password_hash()
    $sql = "SELECT * FROM peribadi WHERE nokp='$staffkp' and pwd='$stafpwd'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if($result && $result->num_rows > 0) {
        $get_user = $result->fetch_assoc();
        setcookie("login_user", $get_user['namapegawai'] ?? '', time() + (60 * 60), "/");
      
        $_SESSION['staffkp'] = $staffkp;
        $_SESSION['level'] = '1';
        $_SESSION['user_id'] = $staffkp;
        $_SESSION['name'] = $get_user['namapegawai'] ?? '';
        $_SESSION['LAST_ACTIVITY'] = time();

        header("location:mydashboard.php");
        exit();
    } else {
        header("location:index.php?module=fail");
        exit();
    }
}

// Redirect if accessed directly without POST data
header("location:index.php");
exit();
?>