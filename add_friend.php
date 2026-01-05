<?php
require_once('DBconnect.php');


$user_id = isset($_GET['u_id']) ? $_GET['u_id'] : '';

if (!$user_id) {
    header("Location: index.php");
    exit();
}

$message = "";



if (isset($_POST['accept_id'])) {
    $sender_id = $_POST['accept_id'];
    $sql = "UPDATE friendships SET status = 'accepted' WHERE user_id = ? AND friend_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $sender_id, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $message = "Request accepted!";
    }
}


if (isset($_POST['add_target_id'])) {
    $target = $_POST['add_target_id'];
    $sql = "INSERT INTO friendships (user_id, friend_id, status) VALUES (?, ?, 'pending')";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $target);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Friend request sent!";
        } else {
            $message = "A request already exists between you.";
        }
    }
}


if (isset($_POST['delete_id'])) {
    $target_id = $_POST['delete_id'];
    
    $sql = "DELETE FROM friendships WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $user_id, $target_id, $target_id, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $message = "Friend removed.";
    }
}


$req_sql = "SELECT c.user_id, c.username FROM friendships f 
            JOIN customers c ON f.user_id = c.user_id 
            WHERE f.friend_id = ? AND f.status = 'pending'";
$stmt_req = mysqli_prepare($conn, $req_sql);
mysqli_stmt_bind_param($stmt_req, "i", $user_id);
mysqli_stmt_execute($stmt_req);
$pending_requests = mysqli_stmt_get_result($stmt_req);


$friends_sql = "SELECT DISTINCT c.user_id, c.username FROM friendships f 
                JOIN customers c ON (f.friend_id = c.user_id OR f.user_id = c.user_id)
                WHERE ((f.user_id = ?) OR (f.friend_id = ?)) 
                AND f.status = 'accepted' AND c.user_id != ?";
$stmt_f = mysqli_prepare($conn, $friends_sql);
mysqli_stmt_bind_param($stmt_f, "iii", $user_id, $user_id, $user_id);
mysqli_stmt_execute($stmt_f);
$friends_list = mysqli_stmt_get_result($stmt_f);




$cust_sql = "SELECT user_id, username FROM customers 
             WHERE user_id != ? 
             AND user_id NOT IN (SELECT friend_id FROM friendships WHERE user_id = ?)
             AND user_id NOT IN (SELECT user_id FROM friendships WHERE friend_id = ?)";
$stmt_c = mysqli_prepare($conn, $cust_sql);
mysqli_stmt_bind_param($stmt_c, "iii", $user_id, $user_id, $user_id);
mysqli_stmt_execute($stmt_c);
$all_customers = mysqli_stmt_get_result($stmt_c);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Social Hub | GameStore</title>
    <style>
        :root { 
            --bg: #121212; 
            --card: #1e1e1e; 
            --accent: #00e676; 
            --danger: #ff5252;
            --text: #e0e0e0; 
            --secondary-bg: #262626;
        }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); display: flex; justify-content: center; padding: 40px; margin: 0; }
        .container { width: 100%; max-width: 600px; }
        .section { background: var(--card); padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #333; }
        h3 { margin-top: 0; color: var(--accent); border-bottom: 1px solid #333; padding-bottom: 10px; font-size: 1.1rem; text-transform: uppercase; }
        .row { display: flex; justify-content: space-between; align-items: center; padding: 12px; background: var(--secondary-bg); margin-bottom: 8px; border-radius: 8px; border-left: 3px solid transparent; transition: 0.2s; }
        .row:hover { border-left-color: var(--accent); transform: scale(1.01); }
        .btn { border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.2s; }
        .btn-accept { background: var(--accent); color: #000; }
        .btn-delete { background: transparent; color: var(--danger); border: 1px solid var(--danger); }
        .btn-delete:hover { background: var(--danger); color: white; }
        .msg { background: rgba(0, 230, 118, 0.1); color: var(--accent); padding: 12px; border-radius: 8px; text-align: center; margin-bottom: 20px; border: 1px solid var(--accent); }
        .back-btn { text-decoration: none; color: #888; font-size: 0.9rem; margin-bottom: 10px; display: inline-block; }
        .back-btn:hover { color: white; }
    </style>
</head>
<body>

<div class="container">
    <a href="home.php?u_id=<?php echo $user_id; ?>" class="back-btn">← Back to Dashboard</a>
    <h1 style="margin-top:0;">Social Hub</h1>
    
    <?php if($message): ?><div class="msg"><?php echo $message; ?></div><?php endif; ?>

    <div class="section">
        <h3>Friend Requests</h3>
        <?php if(mysqli_num_rows($pending_requests) > 0): ?>
            <?php while($req = mysqli_fetch_assoc($pending_requests)): ?>
                <div class="row">
                    <span><strong>@<?php echo htmlspecialchars($req['username']); ?></strong> sent you a request</span>
                    <form method="POST">
                        <input type="hidden" name="accept_id" value="<?php echo $req['user_id']; ?>">
                        <button type="submit" class="btn btn-accept">Accept</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:#666; font-size: 0.9rem;">No new friend requests.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h3>My Friends</h3>
        <?php if(mysqli_num_rows($friends_list) > 0): ?>
            <?php while($friend = mysqli_fetch_assoc($friends_list)): ?>
                <div class="row">
                    <span>✅ <strong>@<?php echo htmlspecialchars($friend['username']); ?></strong></span>
                    <form method="POST" onsubmit="return confirm('Remove this friend?');">
                        <input type="hidden" name="delete_id" value="<?php echo $friend['user_id']; ?>">
                        <button type="submit" class="btn btn-delete">Remove</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:#666; font-size: 0.9rem;">You haven't added any friends yet.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h3>Available Gamers</h3>
        <?php if(mysqli_num_rows($all_customers) > 0): ?>
            <?php while($cust = mysqli_fetch_assoc($all_customers)): ?>
                <div class="row">
                    <span><strong>@<?php echo htmlspecialchars($cust['username']); ?></strong></span>
                    <form method="POST">
                        <input type="hidden" name="add_target_id" value="<?php echo $cust['user_id']; ?>">
                        <button type="submit" class="btn btn-accept">+ Add Friend</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color:#666; font-size: 0.9rem;">No other customers found to add.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>