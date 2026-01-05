<?php
require_once('DBconnect.php');

$u_id = $_GET['u_id'];
$g_id = $_GET['g_id'];

if ($u_id && $g_id) {
    $sql = "INSERT IGNORE INTO wishlist (user_id, game_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $u_id, $g_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $msg = (mysqli_stmt_affected_rows($stmt) > 0) ? "Added to wishlist!" : "Already in wishlist!";
        header("Location: browse.php?u_id=$u_id&msg=$msg");
    }
}
?>