<?php
require_once('DBconnect.php');

$user_id = isset($_GET['u_id']) ? $_GET['u_id'] : '';

if ($user_id) {
    
    $sql = "DELETE FROM customers WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?msg=account_deleted");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>