<?php
require_once('DBconnect.php');
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT user_id, password FROM customers WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $uid = $row['user_id'];
            header("Location: home.php?u_id=$uid");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT user_id, password FROM admin WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $uid = $row['user_id'];
            header("Location: handle.php?u_id=$uid");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameStore | Login</title>
    <style>
        :root {
            --bg-color: #0f0f0f;
            --card-bg: #1a1a1a;
            --accent: #3d5afe;
            --accent-hover: #2e4ad1;
            --text: #ffffff;
            --error-red: #ff5252;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-card {
            background-color: var(--card-bg);
            width: 100%;
            max-width: 380px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.7);
            border: 1px solid #333;
            text-align: center;
        }

        .login-card h2 {
            margin-bottom: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--accent);
        }

        .login-card p {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .input-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 0.8rem;
            margin-bottom: 8px;
            color: #bbb;
            text-transform: uppercase;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            background: #262626;
            border: 1px solid #444;
            border-radius: 6px;
            color: #fff;
            font-size: 1rem;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: var(--accent);
        }

        .error-msg {
            background: rgba(255, 82, 82, 0.1);
            color: var(--error-red);
            padding: 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid var(--error-red);
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: var(--accent-hover);
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        .footer-text {
            margin-top: 25px;
            font-size: 0.85rem;
            color: #666;
        }

        .footer-text a {
            color: var(--accent);
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>GameStore</h2>
    <p>Sign in to your account</p>

    <?php if($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="name@example.com">
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="••••••••">
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="footer-text">
        Don't have an account? Register here <a href="csignup.php">Customer</a> | <a href="asignup.php">Admin</a>  
    </div>
</div>

</body>
</html>