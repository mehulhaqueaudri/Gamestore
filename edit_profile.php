<?php
require_once('DBconnect.php');

$user_id = isset($_GET['u_id']) ? $_GET['u_id'] : '';

if (!$user_id) {
    header("Location: index.php");
    exit();
}

$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_name = $_POST['name'];
    $new_username = $_POST['username'];
    $new_dob = $_POST['birth_date'];
    $new_bio = $_POST['bio'];

    $update_sql = "UPDATE customers SET name = ?, username = ?, birth_date = ?, bio = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $update_sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssi", $new_name, $new_username, $new_dob, $new_bio, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Profile updated successfully!";
        } else {
            $message = "Error updating profile: " . mysqli_error($conn);
        }
    }
}


$sql = "SELECT name, username, email, birth_date, bio FROM customers WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_info = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile | GameStore</title>
    <style>
        :root { --bg: #121212; --card: #1e1e1e; --accent: #3d5afe; --text: #e0e0e0; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .edit-container { background: var(--card); padding: 30px; border-radius: 16px; width: 100%; max-width: 400px; border: 1px solid #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 0.8rem; color: #888; margin-bottom: 5px; text-transform: uppercase; }
        input, textarea { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #333; background: #121212; color: white; box-sizing: border-box; }
        input[readonly] { background: #1a1a1a; color: #555; cursor: not-allowed; }
        .btn-save { background: var(--accent); color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 0.9rem; }
        .msg { background: rgba(61, 90, 254, 0.1); color: var(--accent); padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 15px; border: 1px solid var(--accent); }
    </style>
</head>
<body>

<div class="edit-container">
    <h2>Edit Profile</h2>
    <?php if($message): ?><div class="msg"><?php echo $message; ?></div><?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Email (Locked)</label>
            <input type="text" value="<?php echo htmlspecialchars($user_info['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user_info['name']); ?>" required>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user_info['username']); ?>" required>
        </div>
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="birth_date" value="<?php echo htmlspecialchars($user_info['birth_date']); ?>" required>
        </div>
        <div class="form-group">
            <label>Bio</label>
            <textarea name="bio" rows="3"><?php echo htmlspecialchars($user_info['bio']); ?></textarea>
        </div>

        <button type="submit" name="update_profile" class="btn-save">Save Changes</button>
        <a href="home.php?u_id=<?php echo $user_id; ?>" class="back-link">Return Home</a>
    </form>
</div>

</body>
</html>