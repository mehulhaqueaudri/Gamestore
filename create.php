<?php
require_once('DBconnect.php');


$user_id = $_GET['u_id'] ?? $_POST['user_id_hidden'] ?? null;


if (!$user_id) {
    die("<div style='color:white; background:#721c24; padding:20px; font-family:sans-serif;'>
            <h3>Login Required</h3>
            <p>User identity was lost. Please return to <a href='home.php' style='color:yellow;'>Home</a>.</p>
         </div>");
}


$sql_games = "SELECT title FROM games";
$result_games = mysqli_query($conn, $sql_games);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_ticket'])) {
    $selected_title = $_POST['game_title'];
    $description = $_POST['description'];

    $insert_sql = "INSERT INTO support_ticket (user_id, title, description) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $selected_title, $description);
        if (mysqli_stmt_execute($stmt)) {
            
            header("Location: home.php?u_id=$user_id&status=ticket_success");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Ticket</title>
    <style>
        body { font-family: sans-serif; background: #121212; color: white; padding: 20px; }
        .box { max-width: 400px; margin: auto; background: #1e1e1e; padding: 25px; border-radius: 8px; border: 1px solid #333; }
        input, select, textarea { width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #444; background: #262626; color: white; box-sizing: border-box; }
        button { background: #3d5afe; color: white; border: none; padding: 12px; width: 100%; border-radius: 4px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>

<div class="box">
    <h2>Submit Ticket</h2>
    <p>User ID: <span style="color:#3d5afe;"><?php echo htmlspecialchars($user_id); ?></span></p>

    <form method="POST" action="create.php?u_id=<?php echo $user_id; ?>">
        
        <input type="hidden" name="user_id_hidden" value="<?php echo $user_id; ?>">

        <label>Game Title</label>
        <select name="game_title" required>
            <option value="">-- Select Game --</option>
            <?php while($game = mysqli_fetch_assoc($result_games)): ?>
                <option value="<?php echo htmlspecialchars($game['title']); ?>">
                    <?php echo htmlspecialchars($game['title']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Description</label>
        <textarea name="description" rows="5" required></textarea>

        <button type="submit" name="submit_ticket">Send Ticket</button>
    </form>
    
    <p style="text-align:center;"><a href="home.php?u_id=<?php echo $user_id; ?>" style="color:#888; text-decoration:none;">Cancel</a></p>
</div>

</body>
</html>