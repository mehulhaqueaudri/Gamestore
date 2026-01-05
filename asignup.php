<?php
require_once('DBconnect.php');
$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_reg'])) {
    
   
    $check_sql = "SELECT COUNT(*) as total FROM admin";
    $check_result = mysqli_query($conn, $check_sql);
    $check_data = mysqli_fetch_assoc($check_result);

    if ($check_data['total'] > 0) {
        $message = "Access Denied: An administrator is already registered.";
        $message_type = "error";
    } else {
        
        
        $a_name  = $_POST['admin_name'];
        $a_email = $_POST['admin_email'];
        $a_pass  = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);
        $a_bday  = $_POST['admin_birth_date'];

        $sql = "INSERT INTO admin (name, email, password, birth_date) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $a_name, $a_email, $a_pass, $a_bday);
            
            if (mysqli_stmt_execute($stmt)) {
                $new_id = mysqli_insert_id($conn);
                $message = "Success! Admin ID assigned: A" . $new_id;
                $message_type = "success";
            } else {
                $message = "Registration failed: " . mysqli_stmt_error($stmt);
                $message_type = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration | GameStore</title>
    <style>
        :root {
            --bg: #0d0d0d;
            --card: #181818;
            --admin-gold: #ffc107;
            --admin-gold-hover: #ffca2c;
            --text: #ffffff;
            --input-bg: #222222;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .admin-container {
            background-color: var(--card);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.8);
            width: 100%;
            max-width: 400px;
            border: 1px solid #333;
            border-top: 4px solid var(--admin-gold);
        }

        h2 {
            margin: 0 0 10px 0;
            text-align: center;
            font-size: 1.8rem;
            color: var(--admin-gold);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        p.subtitle {
            text-align: center;
            color: #777;
            font-size: 0.85rem;
            margin-bottom: 25px;
        }

        .msg {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: bold;
        }

        .success { background: rgba(255, 193, 7, 0.1); color: var(--admin-gold); border: 1px solid var(--admin-gold); }
        .error { background: rgba(255, 82, 82, 0.1); color: #ff5252; border: 1px solid #ff5252; }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 0.75rem;
            color: #aaa;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            padding: 12px;
            background-color: var(--input-bg);
            border: 1px solid #333;
            border-radius: 6px;
            color: #fff;
            font-size: 1rem;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: var(--admin-gold);
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: var(--admin-gold);
            color: #000;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: var(--admin-gold-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }

        .footer-links {
            text-align: center;
            margin-top: 25px;
            font-size: 0.85rem;
        }

        .footer-links a {
            color: #888;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--admin-gold);
        }
    </style>
</head>
<body>

<div class="admin-container">
    <h2>Admin Portal</h2>
    <p class="subtitle">Establish higher-level security credentials</p>
    
    <?php if($message != ""): ?>
        <div class="msg <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form action="asignup.php" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="admin_name" required placeholder="Enter full name">
        </div>

        <div class="form-group">
            <label>Work Email</label>
            <input type="email" name="admin_email" required placeholder="admin@gamestore.com">
        </div>

        <div class="form-group">
            <label>Secure Password</label>
            <input type="password" name="admin_password" required placeholder="••••••••">
        </div>

        <div class="form-group">
            <label>Birth Date</label>
            <input type="date" name="admin_birth_date" required>
        </div>

        <button type="submit" name="admin_reg">Authorize Admin Account</button>
    </form>

    <div class="footer-links">
        <a href="home.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>