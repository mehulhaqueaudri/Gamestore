<?php
require_once('DBconnect.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    
    $u_name   = $_POST['name'];
    $u_email  = $_POST['email'];
    $u_pass   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $u_bday   = $_POST['birth_date'];
    $u_user   = $_POST['username'];
    $u_bio    = $_POST['bio'];
    $u_avatar = $_POST['avatar_url'];
    $u_genre  = $_POST['fav_genre'];

    $sql = "INSERT INTO customers (username, password, name, email, birth_date, bio, avatar_url, fav_genre) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $u_user, $u_pass, $u_name, $u_email, $u_bday, $u_bio, $u_avatar, $u_genre);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?registered=1");
            exit();
        } else {
            $message = "Error: " . mysqli_stmt_error($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join GameStore | Sign Up</title>
    <style>
        :root {
            --bg: #0d0d0d;
            --card: #1a1a1a;
            --accent: #3d5afe;
            --text: #e0e0e0;
            --input-bg: #262626;
            --border: #333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .signup-container {
            background-color: var(--card);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.6);
            width: 100%;
            max-width: 600px;
            border: 1px solid var(--border);
        }

        h2 {
            margin: 0 0 10px 0;
            text-align: center;
            color: #fff;
            letter-spacing: 1px;
        }

        .subtitle {
            text-align: center;
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .error {
            background: rgba(255, 82, 82, 0.1);
            color: #ff5252;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #ff5252;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width { grid-column: span 2; }

        .input-group label {
            display: block;
            font-size: 0.8rem;
            color: #aaa;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            background-color: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: #fff;
            font-size: 1rem;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        textarea { height: 80px; resize: none; }

        input:focus, select:focus, textarea:focus {
            border-color: var(--accent);
        }

        button {
            grid-column: span 2;
            padding: 15px;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #2e4ad1;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: #888;
        }

        .login-link a {
            color: var(--accent);
            text-decoration: none;
        }

        /* Mobile Responsive */
        @media (max-width: 600px) {
            form { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            button { grid-column: span 1; }
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Create Account</h2>
    <p class="subtitle">Join the community and start your journey</p>

    <?php if($message != "") echo "<div class='error'>$message</div>"; ?>

    <form action="csignup.php" method="POST">
        <div class="input-group">
            <label>Full Name</label>
            <input type="text" name="name" required placeholder="John Doe">
        </div>

        <div class="input-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="john@example.com">
        </div>

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required placeholder="GamerTag">
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="••••••••">
        </div>

        <div class="input-group">
            <label>Birth Date</label>
            <input type="date" name="birth_date" required>
        </div>

        <div class="input-group">
            <label>Favorite Genre</label>
            <select name="fav_genre">
                <option value="">-- Choose --</option>
                <option value="Action">Action</option>
                <option value="RPG">RPG</option>
                <option value="Strategy">Strategy</option>
                <option value="Shooter">Shooter</option>
            </select>
        </div>

        <div class="input-group full-width">
            <label>Avatar Image URL</label>
            <input type="text" name="avatar_url" placeholder="https://image-link.com/photo.jpg">
        </div>

        <div class="input-group full-width">
            <label>Bio</label>
            <textarea name="bio" placeholder="Tell us about your gaming style..."></textarea>
        </div>

        <button type="submit" name="register">Create Account</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="index.php">Log In</a>
    </div>
</div>

</body>
</html>