<?php
require_once('DBconnect.php');


$g_id = isset($_GET['id']) ? $_GET['id'] : null;
$u_id = isset($_GET['u_id']) ? $_GET['u_id'] : null;
$score = isset($_GET['rating']) ? $_GET['rating'] : null;


if ($g_id && $u_id && isset($score)) {
    
    
    $sql = "INSERT INTO ratings (user_id, game_id, rating_value) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE rating_value = VALUES(rating_value)";
            
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iii", $u_id, $g_id, $score);
        
        if (mysqli_stmt_execute($stmt)) {           
            header("Location: browse.php?u_id=$u_id&status=rated");
            exit();
        } else {
            echo "Execution Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "SQL Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request. Missing parameters.";
}
?>