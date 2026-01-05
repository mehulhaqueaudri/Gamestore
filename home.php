<?php
require_once('DBconnect.php'); 

$user_id = isset($_GET['u_id']) ? $_GET['u_id'] : '';

if (!$user_id) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT name, username, email, birth_date, bio FROM customers WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_info = mysqli_fetch_assoc($result);

if (!$user_info) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamer Dashboard | Home</title>
    <style>
        :root {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --primary-accent: #3d5afe;
            --friend-accent: #00e676;
            --danger-accent: #ff5252;
            --text-main: #e0e0e0;
            --text-dim: #888;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .dashboard-container {
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 450px;
            border: 1px solid #333;
        }

        .profile-header {
            text-align: center;
            border-bottom: 1px solid #333;
            margin-bottom: 25px;
            padding-bottom: 20px;
        }

        .user-details {
            text-align: left;
            background: #121212;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 0.9rem;
        }

        .user-details div { margin-bottom: 8px; }
        .label { color: var(--text-dim); font-size: 0.75rem; text-transform: uppercase; display: block; }

        h2 { margin: 0; font-size: 1.8rem; color: #fff; }

        nav {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-main);
            background: #262626;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover {
            background: #333;
            border-color: var(--primary-accent);
            transform: translateX(5px);
            color: #fff;
        }

        .nav-link.delete-btn {
            border: 1px solid var(--danger-accent);
            color: var(--danger-accent);
            background: transparent;
            justify-content: center;
        }

        .nav-link.delete-btn:hover {
            background: var(--danger-accent);
            color: white;
            transform: none;
        }

        .nav-link.logout {
            margin-top: 10px;
            background: transparent;
            color: var(--text-dim);
            border: 1px solid #444;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="profile-header">
        <h2>Gamer Profile</h2>
        <p style="color: var(--primary-accent); font-weight: bold; margin-top: 5px;">#<?php echo htmlspecialchars($user_id); ?></p>
    </div>

    <div class="user-details">
        <div>
            <span class="label">Full Name</span>
            <strong><?php echo htmlspecialchars($user_info['name']); ?></strong>
        </div>
        <div>
            <span class="label">Username</span>
            <strong><?php echo htmlspecialchars($user_info['username']); ?></strong>
        </div>        
        <div>
            <span class="label">Email Address</span>
            <strong><?php echo htmlspecialchars($user_info['email']); ?></strong>
        </div>
        <div>
            <span class="label">Date of Birth</span>
            <strong><?php echo htmlspecialchars($user_info['birth_date']); ?></strong>
        </div>
        <div>
            <span class="label">Bio</span>
            <strong><?php echo htmlspecialchars($user_info['bio']); ?></strong>
        </div>        
    </div>

    <div style="margin-bottom: 25px;">
        <a href="edit_profile.php?u_id=<?php echo $user_id; ?>" class="nav-link" style="background: var(--primary-accent); justify-content: center; color: white;">
            ✏️ Edit Profile Details
        </a>
    </div>
    
    <nav>
        <a href="browse.php?u_id=<?php echo $user_id; ?>" class="nav-link">🎮 Browse Games</a>
        <a href="add_friend.php?u_id=<?php echo $user_id; ?>" class="nav-link friends">🤝 Find Friends</a>
        <a href="create.php?u_id=<?php echo $user_id; ?>" class="nav-link">🛠️ Create Support Ticket</a>
        <a href="paymentmethod.php?u_id=<?php echo $user_id; ?>" class="nav-link">💳 Set Payment Method</a>

        <a href="delete_profile.php?u_id=<?php echo $user_id; ?>" 
           class="nav-link delete-btn" 
           onclick="return confirm('WARNING: Are you sure you want to permanently delete your profile? This cannot be undone.');">
           🗑️ Delete Profile
        </a>

        <a href="index.php" class="nav-link logout">Logout</a>
    </nav>
</div>

</body>
</html>