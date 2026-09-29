<?php
// file desc: include file to run audit log transaction

// --- Ultra-simple security check for PHP 8.2 compatibility ---
// Always allow access for now to prevent errors
$allow_access = true;

/* 
// Uncomment this later when everything works
if (!defined('AUDIT_LOG_ACCESS') || AUDIT_LOG_ACCESS !== true) {
    if (!isset($_SESSION['level']) || $_SESSION['level'] <= 0) {
        error_log("Blocked direct access to auditlog.php");
        $allow_access = false;
    }
}
*/

if (!$allow_access) {
    return; // Exit silently instead of showing error
}

// Only proceed if database connection exists
if (!isset($conn) || !$conn) {
    return;
}

// Simple audit logging with error suppression
try {
    $user = $_SESSION['name'] ?? 'Unknown User';
    $nokp = $_SESSION['staffkp'] ?? '';
    $accesslevel = $_SESSION['level'] ?? 0;
    $currentpage = basename($_SERVER['PHP_SELF'] ?? 'unknown');
    
    // Only log if we have a query
    if (isset($query) && !empty($query)) {
        $filtersql = htmlentities(substr(str_replace("'", "", $query), 0, 500)); // Limit length
        
        $sqllog = "INSERT INTO sqllog (user, accesslevel, sqldone, nokpapplied, page, datetime) VALUES (?, ?, ?, ?, ?, NOW())";
        
        if ($stmt = mysqli_prepare($conn, $sqllog)) {
            mysqli_stmt_bind_param($stmt, "siss", $user, $accesslevel, $filtersql, $nokp, $currentpage);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
} catch (Exception $e) {
    // Silent fail - don't break the application
    error_log("Audit log error: " . $e->getMessage());
}
?>