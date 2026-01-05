<?php
require_once('DBconnect.php');

$u_id = $_GET['u_id'];
$g_id = $_GET['g_id'];

if ($u_id && $g_id) {
 
    $check_sql = "SELECT * FROM purchases WHERE user_id = ? AND game_id = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "ii", $u_id, $g_id);
    mysqli_stmt_execute($stmt);
    $owned = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($owned) > 0) {
        header("Location: browse.php?u_id=$u_id&msg=You already own this game!");
        exit();
    }

    
    mysqli_begin_transaction($conn);
    try {
        
        $buy_sql = "INSERT INTO purchases (user_id, game_id) VALUES (?, ?)";
        $stmt_buy = mysqli_prepare($conn, $buy_sql);
        mysqli_stmt_bind_param($stmt_buy, "ii", $u_id, $g_id);
        mysqli_stmt_execute($stmt_buy);

       
        $stock_sql = "UPDATE games SET quantity = quantity - 1 WHERE game_id = ? AND quantity > 0";
        $stmt_stock = mysqli_prepare($conn, $stock_sql);
        mysqli_stmt_bind_param($stmt_stock, "i", $g_id);
        mysqli_stmt_execute($stmt_stock);

        mysqli_commit($conn);
        header("Location: browse.php?u_id=$u_id&msg=Purchase successful!");
    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: browse.php?u_id=$u_id&msg=Transaction failed.");
    }
}
?>